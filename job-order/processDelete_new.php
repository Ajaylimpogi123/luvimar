<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

include '../global-library/database.php';
$userId = $_SESSION['user_id'];


if (isset($_POST['uid'])) {
	$uid = $_POST['uid'];
} else {
	$uid = $_GET['uid'];
}


// $ch = $conn->prepare("SELECT * FROM tbl_jo_items WHERE pd_id = '$id' AND is_deleted != '1'");
// $ch->execute();
// $ch_data = $ch->fetch();
// $name = $ch_data['pd_name'];

/* Update product Status */
$sql = $conn->prepare("DELETE FROM tbl_jo_items_new 
					WHERE uid = '$uid'");
$sql->execute();
/* End Product */

/* Insert Log */
$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
					VALUES ('Job order Item deleted', 'Job order item', 'product', '$userId', NOW())");
$log->execute();
/* End Log */

header('Location: index.php?view=add_new&error=' . urlencode('Deleted successfully'));
