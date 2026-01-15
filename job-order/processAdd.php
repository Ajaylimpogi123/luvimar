<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

include '../global-library/database.php';
$userId = $_SESSION['user_id'];


$brnId = mysqli_real_escape_string($link, $_POST['branch']);
$cust = mysqli_real_escape_string($link, $_POST['custname']);

$pdId = mysqli_real_escape_string($link, $_POST['pdId']);
$qty = mysqli_real_escape_string($link, $_POST['qty']);
$description = mysqli_real_escape_string($link, strip_tags($_POST['description']));
$jo_description = mysqli_real_escape_string($link, $_POST['job_description']);
$date_needed = mysqli_real_escape_string($link, $_POST['date_needed']);
$remarks = mysqli_real_escape_string($link, strip_tags($_POST['remarks']));

$cus = $conn->prepare("SELECT * FROM bs_customer WHERE cust_id = '$cust'");
$cus->execute();
$cus_data = $cus->fetch();
$custname = mysqli_real_escape_string($link, $cus_data['client_name']);
$custid = $cus_data['cust_id'];

$prd = $conn->prepare("SELECT * FROM tbl_product WHERE pd_id = '$pdId'");
$prd->execute();
$prd_data = $prd->fetch();
$pd_price = $prd_data['pc_price'];
$pd_barcode = $prd_data['pd_barcode'];
$pd_name = $prd_data['pd_name'];

$names = $pd_name . ' ' . $description;

/* Insert Product */
$sql = $conn->prepare("INSERT INTO tbl_jo_items 
    (branch_id, cust_id, pd_id, customer_name, pd_name, qty, pd_price, pd_serial, description, job_description, date_needed, remarks, joi_date_added, added_by, is_deleted)
    VALUES ('$brnId', '$custid', '$pdId', '$custname', '$pd_name', '$qty', '$pd_price', '$pd_barcode', '$names', '$jo_description', '$date_needed', '$remarks', '$today_date2', '$userId', '0')");
$sql->execute();
/* End Product */

$id = $conn->lastInsertId();
$uid = md5($id);

$up = $conn->prepare("UPDATE tbl_jo_items SET uid = '$uid' WHERE joi_id = '$id'");
$up->execute();

/* Insert Log */
$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
								VALUES ('job order added', '$name', 'product', '$userId', NOW())");
$log->execute();
/* End Log */

header('Location: index.php?view=add&error=' . urlencode('Added successfully'));
