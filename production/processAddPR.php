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

// $pr_serial = $_POST['pr_serial'];
// $pr_qty = $_POST['pr_qty'];
// $pr_price = $_POST['pr_price'];
$pr_num = $_POST['prNum'];


if (isset($_POST['prdId'])) {
    $prdId = $_POST['prdId'];


    # Job Description
    foreach ($prdId as $pdid) {

        if (isset($_POST['pr_serial_' . $pdid])) {
            $serials = $_POST['pr_serial_' . $pdid];

            // 1. Get the latest barcode ONCE
            $inc = $conn->prepare("SELECT MAX(CAST(pd_barcode AS UNSIGNED)) AS last_barcode
    FROM tbl_product
    WHERE is_deleted != '1'
");
            $inc->execute();
            $inc_data = $inc->fetch(PDO::FETCH_ASSOC);

            $lastBarcode = (int) ($inc_data['last_barcode'] ?? 0);

            // 2. Loop through serials
            foreach ($serials as $serial) {

                // Increment
                $lastBarcode++;

                // Format barcode to 7 digits (e.g. 2026001)
                $serial_inc = str_pad($lastBarcode, 7, STR_PAD_LEFT);

                // Update product
                $upProduct = $conn->prepare("UPDATE tbl_product SET pd_barcode = :barcode WHERE pd_id = :pd_id");
                $upProduct->execute([
                    ':barcode' => $serial_inc,
                    ':pd_id'   => $pdid
                ]);
            }


        }
        if (isset($_POST['pr_qty_' . $pdid])) {
            $qtys = $_POST['pr_qty_' . $pdid];

            foreach ($qtys as $serial) {

                $up = $conn->prepare("UPDATE tbl_product SET pc_qty = pc_qty + '$serial' WHERE pd_id = '$pdid'");
                $up->execute();


                $up = $conn->prepare("UPDATE tbl_pr_items SET pr_qty = '$serial' WHERE pd_id = '$pdid'");
                $up->execute();
            }
        }
        if (isset($_POST['pr_price_' . $pdid])) {
            $prices = $_POST['pr_price_' . $pdid];

            foreach ($prices as $serial) {

                $up = $conn->prepare("UPDATE tbl_product SET pc_price = '$serial' WHERE pd_id = '$pdid'");
                $up->execute();
            }
        }
    }
} else {
}

// generate r_id for request
$req = $conn->prepare("INSERT INTO tbl_production_report (jo_id, pr_num,  status,  added_by, date_added) VALUES ('$jo_num', '$pr_num', 'completed', '$userId', '$today_date2')");
$req->execute();
// get the  id
$prId = $conn->lastInsertId();

if ($prId) {




    // if v_id exist loop through the voucher and insert to tbl_voucher_list
    $item = $conn->prepare("SELECT * FROM tbl_pr_items WHERE is_submitted = 0 AND is_deleted != '1' AND added_by = '$userId'");
    $item->execute();
    while ($item_data = $item->fetch()) {


        $priId = $item_data['pri_id'];

        $item_pid = $item_data['pd_id'];
        $branchId = $item_data['branch_id'];

        $var_in = $conn->prepare("INSERT INTO tbl_pr_list (pri_id, pr_id, pd_id, branch_id, user_id, added_by, pr_date_added) VALUES ('$priId', '$prId', '$item_pid', '$branchId', '$userId', '$userId', '$today_date2')");
        $var_in->execute();
    }

    // if v_id exist loop through the voucher and insert to tbl_voucher_list
    // $item = $conn->prepare("SELECT * FROM tbl_pr_items WHERE is_submitted = 0 AND is_deleted != '1' AND added_by = '$userId'");
    // $item->execute();
    // for ($i = 0; $i < $item->rowCount(); $i++) {


    //     $item_data = $item->fetch();

    //     $priId = $item_data['pri_id'];

    //     $item_pid = $item_data['pd_id'];
    //     $branchId = $item_data['branch_id'];

    //     $var_in = $conn->prepare("INSERT INTO tbl_pr_list (pri_id, pr_id, pd_id, branch_id, user_id, added_by, date_added) VALUES ('$priId', '$prId', '$item_pid', '$branchId', '$userId', '$userId', '$today_date')");
    //     $var_in->execute();

    //     $up = $conn->prepare("UPDATE tbl_product SET pd_barcode = '$pr_serial', pc_price = '$pr_price', pc_qty = pc_qty + '$pr_qty' WHERE pd_id = '$item_pid'");
    //     $up->execute();

    //     $up = $conn->prepare("UPDATE tbl_pr_items SET pr_qty = '$pr_qty', pr_serial = '$pr_serial' WHERE pd_id = '$item_pid'");
    //     $up->execute();
    // }
    // then submit the voucher	
    $up = $conn->prepare("UPDATE tbl_pr_items SET is_submitted = 1
       WHERE added_by = '$userId' AND branch_id = '$branchId'");
    $up->execute();


    $up1 = $conn->prepare("UPDATE tbl_job_order SET status = 'completed'
       WHERE jo_id = '$jo_num'");
    $up1->execute();

    $uid = MD5($prId);
    $upt = $conn->prepare("UPDATE tbl_production_report SET uid = '$uid' WHERE pr_id = '$prId'");
    $upt->execute();
}
header('Location: index.php?view=list&error=Added successfully.');
