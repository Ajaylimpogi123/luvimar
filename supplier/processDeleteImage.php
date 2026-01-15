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
		
		$ch = $conn->prepare("SELECT * FROM bs_supplier WHERE sup_id = '$id' AND is_deleted != '1'");
		$ch->execute();
		$ch_data = $ch->fetch();
		$name = $ch_data['company_name'];

		$deleted = _deleteImage($id);

		// update the image and thumbnail name in the database
		$sql = $conn->prepare("UPDATE bs_supplier
				SET image = '', thumbnail = ''
				WHERE sup_id = $id");
		$sql->execute();
		
		/* Insert Log */
		$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
					VALUES ('Image deleted', '$name', 'supplier', '$userId', NOW())");
		$log->execute();
		/* End Log */

	header("Location: index.php?view=modify&id=$id&error=Image deleted successfully");

function _deleteImage($id)
{
	include '../global-library/database.php';
	// we will return the status
	// whether the image deleted successfully
	$deleted = false;

	$sql = $conn->prepare("SELECT image, thumbnail
	        FROM bs_supplier
			WHERE sup_id = $id");
	$sql->execute();

	if ($sql->rowCount()) {
		$sql_data = $sql->fetch();

		if ($sql_data['image'] && $sql_data['thumbnail']) {
			// remove the image file
			$deleted = @unlink(SRV_ROOT . "images/supplier/$sql_data[image]");
			$deleted = @unlink(SRV_ROOT . "images/supplier/$sql_data[thumbnail]");
		}
	}

	return $deleted;
}

?>
