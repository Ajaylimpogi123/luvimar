<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];

	if (isset($_GET['id']) && (int)$_GET['id'] > 0) {
		$id = (int)$_GET['id'];
	} else {
		header('Location: index.php');
	}

	$ch = $conn->prepare("SELECT * FROM tbl_product WHERE pd_id = '$id' AND is_deleted != '1'");
	$ch->execute();
	$ch_data = $ch->fetch();
	$name = $ch_data['pd_name'];			
	
		/* Update product Status */
		$sql = $conn->prepare("UPDATE tbl_product SET is_deleted = '1', date_deleted = NOW()
					WHERE pd_id = $id");
		$sql->execute();
		/* End Product */
	
		/* Insert Log */
		$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
					VALUES ('Product deleted', '$name', 'product', '$userId', NOW())");
		$log->execute();
		/* End Log */

		header('Location: index.php?error=' . urlencode('Deleted successfully'));

?>