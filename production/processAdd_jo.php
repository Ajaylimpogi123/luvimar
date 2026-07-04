<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

include '../global-library/database.php';
$userId = $_SESSION['user_id'];


$joId = $_POST['joId'];




$sel = $conn->prepare("SELECT * FROM tbl_jo_list WHERE jo_id = '$joId' AND is_deleted != '1'");
$sel->execute();
$sel_data = $sel->fetch();
$joi_id = $sel_data['joi_id'];


$sel3 = $conn->prepare("SELECT * FROM tbl_jo_items WHERE joi_id = '$joi_id' AND is_deleted != '1'");
$sel3->execute();
$sel3_data = $sel3->fetch();



$Job_Description = $sel3_data['job_description'];


    $jol = $conn->prepare("SELECT * FROM tbl_jo_list WHERE jo_id = '$joId'");
    $jol->execute();
    while ($jol_data = $jol->fetch()) {
        // $jol_joId = $jol_data['jo_id'];
        // $jol_pdId = $jol_data['pd_id'];
        $jo_joId = $jol_data['joi_id'];
        // $jo_custId = $jol_data['cust_id'];
        // $jo_branchId = $jol_data['branch_id'];


        $jo_items = $conn->prepare("SELECT * FROM tbl_jo_items WHERE joi_id = '$jo_joId' AND is_submitted = 1 AND is_deleted != '1' AND added_by = '$userId'");
        $jo_items->execute();
        $jo_items_data = $jo_items->fetch();

            $joi_custId = $jo_items_data['cust_id'];
            $joi_branchId = $jo_items_data['branch_id'];
            $joi_pdId = $jo_items_data['pd_id'];
            $joi_qty = $jo_items_data['qty'];
            $joi_price = $jo_items_data['pd_price'];
            $joi_barcode = $jo_items_data['pd_serial'];
            $pd_name = $jo_items_data['pd_name'];

            $pd = $conn->prepare("SELECT * FROM tbl_product WHERE pd_id = '$joi_pdId' AND is_deleted != '1' AND pd_keyword != 'Raw Material'");
            $pd->execute();
            $pd_data = $pd->fetch();

            if($pd_data){
            $pd_id = $pd_data['pd_id'];


            $sql = $conn->prepare("INSERT INTO tbl_pr_items 
            (jo_id, cust_id, branch_id, pd_id, pr_qty, pr_serial, pr_price, pr_description,  pr_date_added, added_by, is_deleted, is_submitted)
            VALUES ('$joId', '$joi_custId', '$joi_branchId', '$pd_id', '$joi_qty', '$joi_barcode', '$joi_price', '$pd_name', '$today_date2', '$userId', '0', '0')");
            $sql->execute();

            $id = $conn->lastInsertId();
            $uid = md5($id);

            $up = $conn->prepare("UPDATE tbl_pr_items SET uid = '$uid' WHERE pri_id = '$id'");
            $up->execute();

            }
        
    };

    header('Location: index.php?view=add&error=' . urlencode('Added successfully'));
