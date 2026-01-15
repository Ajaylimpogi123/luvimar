<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

include '../global-library/database.php';
$userId = $_SESSION['user_id'];

$branch = mysqli_real_escape_string($link, $_POST['branch']);
$pdId = mysqli_real_escape_string($link, $_POST['pdId']);
$qty = mysqli_real_escape_string($link, $_POST['qty']);
$description = mysqli_real_escape_string($link, strip_tags($_POST['description']));

// $pdname = mysqli_real_escape_string($link, $_POST['pdname']);
// $jo_description = mysqli_real_escape_string($link, $_POST['job_description']);
$part_replacement = mysqli_real_escape_string($link, strip_tags($_POST['part_replacement']));
$remarks = mysqli_real_escape_string($link, strip_tags($_POST['pr_remarks']));


$prd = $conn->prepare("SELECT * FROM tbl_product WHERE pd_id = '$pdId'");
$prd->execute();
$prd_data = $prd->fetch();

$pd_name = $prd_data['pd_name'];

$names = $pd_name . ' ' . $description;

$chk = $conn->prepare("SELECT * FROM tbl_pr_items WHERE pd_id = '$pdId' AND is_submitted != '1'");
$chk->execute();
if ($chk->rowCount() > 0) {
    header('Location: index.php?view=add&error=' . urlencode('You already Add This product To Production Content!'));
} else {
    /* Insert Product */
    $sql = $conn->prepare("INSERT INTO tbl_pr_items 
    (branch_id, pd_id, pr_qty, pr_description,  part_replacement, pr_remarks, pr_date_added, added_by, is_deleted)
    VALUES ('$branch', '$pdId', '$qty', '$names', '$part_replacement', '$remarks', '$today_date2', '$userId', '0')");
    $sql->execute();
    /* End Product */
    /* End Product */

    $id = $conn->lastInsertId();
    $uid = md5($id);

    $up = $conn->prepare("UPDATE tbl_pr_items SET uid = '$uid' WHERE pri_id = '$id'");
    $up->execute();

    /* Insert Log */
    $log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
								VALUES ('Production Report added', '$description', 'production', '$userId', NOW())");
    $log->execute();
    /* End Log */

    header('Location: index.php?view=add&error=' . urlencode('Added successfully'));
}
