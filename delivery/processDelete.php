<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];

	if (isset($_GET['oid']) && (int)$_GET['oid'] > 0) {
		$id = (int)$_GET['oid'];
	} else {
		header('Location: index.php');
	}

	$ch = $conn->prepare("SELECT * FROM tbl_order WHERE od_id = '$id' AND is_delivered != '1'");
	$ch->execute();
	$ch_data = $ch->fetch();
	$name = $ch_data['od_id'];			
	
		/* Update Order Status */
		$sql = $conn->prepare("UPDATE tbl_order SET is_delivered = '1'
					WHERE od_id = $id");
		$sql->execute();
		/* End Order */
	
		/* Insert Log */
		$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
					VALUES ('Order delivered', '$name', 'order', '$userId', NOW())");
		$log->execute();
		/* End Log */

		header('Location: index.php?error=' . urlencode('Delivered successfully'));

?>