<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

include '../global-library/database.php';
$userId = $_SESSION['user_id'];


$pdId = mysqli_real_escape_string($link, $_POST['pdId']);
$uid = $_POST['uid'];
$qty = mysqli_real_escape_string($link, $_POST['qty']);
$barcode = mysqli_real_escape_string($link, $_POST['barcode']);
$pr_price = mysqli_real_escape_string($link, $_POST['pr_price']);
$pr_description = mysqli_real_escape_string($link, $_POST['pr_description']);

$part_replacement = mysqli_real_escape_string($link, $_POST['part_replacement']);
$pr_remark = mysqli_real_escape_string($link, $_POST['pr_remark']);

include '../global-library/database.php';

/* Update Product */
$sql = $conn->prepare("UPDATE tbl_pr_items SET pr_qty = :qty, pr_serial = :barcode, pr_price = :pr_price, 
pr_description = :pr_description, part_replacement = :part_replacement, pr_remarks = :pr_remark WHERE uid = :uid
");

$sql->execute([
    ':qty'             => $qty,
    ':barcode'         => $barcode,
    ':pr_price'        => $pr_price,
    ':pr_description'  => $pr_description,
    ':part_replacement' => $part_replacement,
    ':pr_remark'       => $pr_remark,
    ':uid'             => $uid
]);
/* Insert Log */
$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
							VALUES ('Production modified', '$name', 'product', '$userId', NOW())");
$log->execute();
/* End Log */

header("Location: index.php?view=add&error=Modified successfully");
