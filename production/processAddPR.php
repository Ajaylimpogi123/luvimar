<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

include '../global-library/database.php';
$userId = $_SESSION['user_id'];

$jo = $conn->prepare("SELECT * FROM tbl_pr_items WHERE is_deleted != '1' AND is_submitted != '1'");
$jo->execute();
$jo_data = $jo->fetch();

$jo_num = $jo_data['jo_id'];
$pr_num = $_POST['prNum'];

if (isset($_POST['prdId']) && is_array($_POST['prdId'])) {

    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();

        $prdId = $_POST['prdId'];

        // ===============================
        // GET LAST BARCODE
        // ===============================
        $inc = $conn->prepare("
            SELECT MAX(CAST(pd_barcode AS UNSIGNED)) AS last_barcode
            FROM tbl_product
            WHERE is_deleted != '1'
        ");
        $inc->execute();
        $inc_data = $inc->fetch(PDO::FETCH_ASSOC);
        $lastBarcode = (int)($inc_data['last_barcode'] ?? 0);

        // ===============================
        // STORE GENERATED BARCODES PER pdid
        // KEY: pdid => [barcode1, barcode2, ...]
        // ===============================
        $generatedBarcodes = []; // <-- collect barcodes here

        foreach ($prdId as $pdid) {

            if (
                isset($_POST['pr_qty_' . $pdid]) &&
                isset($_POST['pr_price_' . $pdid]) &&
                isset($_POST['pd_name_' . $pdid]) &&
                isset($_POST['pd_name7_' . $pdid]) &&
                isset($_POST['pd_description_' . $pdid]) &&
                isset($_POST['pd_keyword_' . $pdid]) &&
                isset($_POST['pd_cost_' . $pdid]) &&
                isset($_POST['cat_id_' . $pdid]) &&
                isset($_POST['cat_parent_id_' . $pdid]) &&
                isset($_POST['date_added_' . $pdid])
            ) {
                $qtys           = $_POST['pr_qty_' . $pdid];
                $prices         = $_POST['pr_price_' . $pdid];
                $pd_names       = $_POST['pd_name_' . $pdid];
                $pd_names7      = $_POST['pd_name7_' . $pdid];
                $pd_descriptions = $_POST['pd_description_' . $pdid];
                $pd_keywords    = $_POST['pd_keyword_' . $pdid];
                $pd_costs       = $_POST['pd_cost_' . $pdid];
                $cat_ids        = $_POST['cat_id_' . $pdid];
                $cat_parent_ids = $_POST['cat_parent_id_' . $pdid];
                $date_addeds    = $_POST['date_added_' . $pdid];

                foreach ($qtys as $index => $qty) {

                    $qty            = (int)$qty;
                    $price          = (float)($prices[$index] ?? 0);
                    $pd_name        = $pd_names[$index] ?? '';
                    $pd_name7       = $pd_names7[$index] ?? '';
                    $pd_description = $pd_descriptions[$index] ?? '';
                    $pd_keyword     = $pd_keywords[$index] ?? '';
                    $pd_cost        = $pd_costs[$index] ?? '';
                    $cat_id         = (int)($cat_ids[$index] ?? 0);
                    $cat_parent_id  = (int)($cat_parent_ids[$index] ?? 0);
                    $date_added     = (int)($date_addeds[$index] ?? 0);

                    // Update PR item qty
                    $updatePr = $conn->prepare("
                        UPDATE tbl_pr_items SET pr_qty = :qty WHERE pd_id = :pd_id
                    ");
                    $updatePr->execute([':qty' => $qty, ':pd_id' => $pdid]);

                    // ===============================
                    // INSERT PRODUCTS & COLLECT BARCODES
                    // ===============================
                    $generatedBarcodes[$pdid] = []; // initialize array for this product

                    for ($i = 1; $i <= $qty; $i++) {
                        $lastBarcode++;
                        $newBarcode = str_pad($lastBarcode, 7, "0", STR_PAD_LEFT);

                        // ✅ Collect each generated barcode
                        $generatedBarcodes[$pdid][] = $newBarcode;

                        $insertProduct = $conn->prepare("
                            INSERT INTO tbl_product (
                                cat_id, cat_parent_id, pd_barcode,
                                pd_name, pd_name7, pd_description,
                                pd_keyword, pd_cost, pc_price,
                                pc_qty, is_deleted, is_sold, date_added
                            ) VALUES (
                                :cat_id, :cat_parent_id, :barcode,
                                :pd_name, :pd_name7, :pd_description,
                                :pd_keyword, :pd_cost, :price,
                                1, 0, 0, :date_added
                            )
                        ");

                        $result = $insertProduct->execute([
                            ':cat_id'        => $cat_id,
                            ':cat_parent_id' => $cat_parent_id,
                            ':barcode'       => $newBarcode,
                            ':pd_name'       => $pd_name,
                            ':pd_name7'      => $pd_name7,
                            ':pd_description'=> $pd_description,
                            ':pd_keyword'    => $pd_keyword,
                            ':pd_cost'       => $pd_cost,
                            ':price'         => $price,
                            ':date_added'    => $date_added
                        ]);

                        if (!$result) {
                            $error = $insertProduct->errorInfo();
                            throw new Exception("Insert Failed: " . $pd_name . " - " . $error[2]);
                        }
                    }
                }
            }
        }

        $conn->commit();

    } catch (Exception $e) {
        if ($conn->inTransaction()) {
            $conn->rollBack();
        }
        echo "<pre>TRANSACTION FAILED\n\n" . $e->getMessage() . "</pre>";
        exit;
    }

    // ===============================
    // INSERT PRODUCTION REPORT
    // ===============================
    $req = $conn->prepare("
        INSERT INTO tbl_production_report (jo_id, pr_num, status, added_by, date_added)
        VALUES (:jo_num, :pr_num, 'completed', :userId, :today)
    ");
    $req->execute([
        ':jo_num'  => $jo_num,
        ':pr_num'  => $pr_num,
        ':userId'  => $userId,
        ':today'   => $today_date2
    ]);
    $prId = $conn->lastInsertId();

    if ($prId) {

        $item = $conn->prepare("
            SELECT * FROM tbl_pr_items
            WHERE is_submitted = 0 AND is_deleted != '1' AND added_by = :userId
        ");
        $item->execute([':userId' => $userId]);

        while ($item_data = $item->fetch()) {

            $priId    = $item_data['pri_id'];
            $item_pid = $item_data['pd_id'];
            $branchId = $item_data['branch_id'];

            // ✅ Get the collected barcodes for this pd_id
            // implode them as comma-separated string to save in pr_serial
            $serialNumbers = isset($generatedBarcodes[$item_pid])
                ? implode(', ', $generatedBarcodes[$item_pid])
                : '';

            // ✅ Save serial numbers into tbl_pr_list.pr_serial
            $var_in = $conn->prepare("
                INSERT INTO tbl_pr_list 
                    (pri_id, pr_id, pd_id, branch_id, user_id, added_by, pr_date_added, pr_serial)
                VALUES 
                    (:priId, :prId, :item_pid, :branchId, :userId, :userId2, :today, :serial)
            ");
            $var_in->execute([
                ':priId'    => $priId,
                ':prId'     => $prId,
                ':item_pid' => $item_pid,
                ':branchId' => $branchId,
                ':userId'   => $userId,
                ':userId2'  => $userId,
                ':today'    => $today_date2,
                ':serial'   => $serialNumbers  // ✅ comma-separated barcodes
            ]);

            $up = $conn->prepare("
                UPDATE tbl_pr_items SET is_submitted = 1
                WHERE added_by = :userId AND branch_id = :branchId
            ");
            $up->execute([':userId' => $userId, ':branchId' => $branchId]);
        }

        $up1 = $conn->prepare("UPDATE tbl_job_order SET status = 'completed' WHERE jo_id = :jo_num");
        $up1->execute([':jo_num' => $jo_num]);

        $uid = MD5($prId);
        $upt = $conn->prepare("UPDATE tbl_production_report SET uid = :uid WHERE pr_id = :prId");
        $upt->execute([':uid' => $uid, ':prId' => $prId]);
    }

    header('Location: index.php?view=list&error=Added successfully.');
}