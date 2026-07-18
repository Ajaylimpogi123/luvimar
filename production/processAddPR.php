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
$pr_num = $_POST['prNum'] ?? null;

if (isset($_POST['prNum']) && trim($_POST['prNum']) !== '') {

    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();

        // ===============================
        // GET THE ACTUAL PENDING LINE ITEMS DIRECTLY FROM THE DB.
        // This is the exact same set of rows shown on the submission
        // page. Pulling straight from the DB (instead of rebuilding
        // everything from a pile of parallel hidden POST arrays) means
        // there is nothing that can fall out of sync or go missing.
        // ===============================
        $pending = $conn->prepare("
            SELECT * FROM tbl_pr_items
            WHERE is_deleted != '1' AND is_submitted != '1'
            ORDER BY pri_id ASC
        ");
        $pending->execute();
        $pendingItems = $pending->fetchAll(PDO::FETCH_ASSOC);

        if (count($pendingItems) === 0) {
            throw new Exception("No pending items to submit.");
        }

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
        // STORE GENERATED BARCODES PER LINE ITEM
        // KEY: pri_id => [barcode1, barcode2, ...]
        // Keyed by pri_id (the specific row), never by pd_id, so two
        // rows ordering the same product can never overwrite each
        // other's barcodes.
        // ===============================
        $generatedBarcodes = [];

        foreach ($pendingItems as $row) {

            $priId = $row['pri_id'];
            $pdId  = $row['pd_id'];
            $qty   = (int)$row['pr_qty'];

            // Pull the product's info straight from tbl_product - the
            // single source of truth, instead of a matching hidden field.
            $prd = $conn->prepare("
                SELECT * FROM tbl_product WHERE pd_id = :pd_id AND is_deleted != '1'
            ");
            $prd->execute([':pd_id' => $pdId]);
            $prd_data = $prd->fetch(PDO::FETCH_ASSOC);

            if (!$prd_data) {
                throw new Exception("Product not found for pd_id: " . $pdId);
            }

            $price          = $prd_data['pc_price'];
            $pd_name        = $prd_data['pd_name'];
            $pd_name7       = $prd_data['pd_name7'];
            $pd_description = $prd_data['pd_description'];
            $pd_keyword     = $prd_data['pd_keyword'];
            $pd_cost        = $prd_data['pd_cost'];
            $cat_id         = $prd_data['cat_id'];
            $cat_parent_id  = $prd_data['cat_parent_id'];
            $date_added     = $prd_data['date_added'];

            // Initialize once per line item - never overwritten by
            // another row that happens to share the same pd_id.
            $generatedBarcodes[$priId] = [];

            for ($i = 1; $i <= $qty; $i++) {
                $lastBarcode++;
                $newBarcode = str_pad($lastBarcode, 7, "0", STR_PAD_LEFT);

                $generatedBarcodes[$priId][] = $newBarcode;

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
                    ':cat_id'         => $cat_id,
                    ':cat_parent_id'  => $cat_parent_id,
                    ':barcode'        => $newBarcode,
                    ':pd_name'        => $pd_name,
                    ':pd_name7'       => $pd_name7,
                    ':pd_description'=> $pd_description,
                    ':pd_keyword'     => $pd_keyword,
                    ':pd_cost'        => $pd_cost,
                    ':price'          => $price,
                    ':date_added'     => $date_added
                ]);

                if (!$result) {
                    $error = $insertProduct->errorInfo();
                    throw new Exception("Insert Failed: " . $pd_name . " - " . $error[2]);
                }
            }
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

        // ===============================
        // INSERT tbl_pr_list ROWS + MARK EACH LINE ITEM SUBMITTED
        // ===============================
        foreach ($pendingItems as $row) {
            $priId    = $row['pri_id'];
            $item_pid = $row['pd_id'];
            $branchId = $row['branch_id'];

            // ✅ looked up per LINE ITEM (pri_id) - guaranteed to match
            // exactly the barcodes generated for this row's own quantity
            $serialNumbers = isset($generatedBarcodes[$priId])
                ? implode(', ', $generatedBarcodes[$priId])
                : '';

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
                ':serial'   => $serialNumbers
            ]);

            // ✅ FIXED: mark only THIS specific line item as submitted.
            // The old query matched on (added_by, branch_id), which would
            // also flip is_submitted = 1 for any OTHER product going to
            // the same branch - marking unrelated items as submitted
            // before they'd actually been processed.
            $up = $conn->prepare("UPDATE tbl_pr_items SET is_submitted = 1 WHERE pri_id = :pri_id");
            $up->execute([':pri_id' => $priId]);
        }

        $up1 = $conn->prepare("UPDATE tbl_job_order SET status = 'completed' WHERE jo_id = :jo_num");
        $up1->execute([':jo_num' => $jo_num]);

        $uid = MD5($prId);
        $upt = $conn->prepare("UPDATE tbl_production_report SET uid = :uid WHERE pr_id = :prId");
        $upt->execute([':uid' => $uid, ':prId' => $prId]);

        $conn->commit();

        header('Location: index.php?view=list&error=Added successfully.');
        exit;

    } catch (Exception $e) {
        if ($conn->inTransaction()) {
            $conn->rollBack();
        }
        echo "<pre>TRANSACTION FAILED\n\n" . $e->getMessage() . "</pre>";
        exit;
    }
}