<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

include '../global-library/database.php';
$userId = $_SESSION['user_id'];


$jo_num = $_POST['job_number'];

// generate r_id for request
$req = $conn->prepare("INSERT INTO tbl_job_order (job_order_number,  status,  added_by, date_added) VALUES ('$jo_num', 'pending', '$userId', '$today_date2')");
$req->execute();
// get the  id
$joId = $conn->lastInsertId();
if ($joId) {


    // if v_id exist loop through the voucher and insert to tbl_voucher_list
    $sel = $conn->prepare("SELECT * FROM tbl_jo_items_new WHERE is_submitted = 0 AND is_deleted != '1' AND added_by = '$userId'");
    $sel->execute();
    while ($sel_data = $sel->fetch()) {

        $custId = $sel_data['cust_id'];
        $item_pid = $sel_data['pd_id'];
        $branch_id = $sel_data['branch_id'];

        $var_in = $conn->prepare("INSERT INTO tbl_jo_list_new (join_id, jo_id, pd_id, cust_id, branch_id, user_id, added_by) VALUES ('$sel_data[join_id]', '$joId', '$item_pid', '$custId', '$branch_id', '$userId', '$userId')");
        $var_in->execute();
    }

    // then submit the voucher	
    $up = $conn->prepare("UPDATE tbl_jo_items_new SET is_submitted = 1
								WHERE added_by = '$userId' AND cust_id = '$custId'");
    $up->execute();
}
header('Location: index.php?view=list&error=Added successfully.');
