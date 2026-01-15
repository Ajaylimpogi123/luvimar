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

	$ch = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$id' AND is_deleted != '1'");
	$ch->execute();
	$ch_data = $ch->fetch();
	
	$branch = $ch_data['branch_num'];
	$username1 = $ch_data['username'];
	$name = $ch_data['firstname'] . '&nbsp;' . $ch_data['lastname'];			
	
		/* Update user Status */
		$sql = $conn->prepare("UPDATE bs_user SET is_deleted = '1'
					WHERE user_id = $id");
		$sql->execute();
		/* End User */
	
		/* Insert Log */
		$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
					VALUES ('User deleted', '$name', 'user', '$userId', '$today_date1')");
		$log->execute();
		/* End Log */
		
		if($branch == 1){
			//echo $username1;
			$sql7 = $conn->prepare("UPDATE dbaq1zijdyzqgj.bs_user SET is_deleted = '1' 
						WHERE username = '$username1'");
			$sql7->execute();
			
		}else if($branch == 2){			
			//echo $username1;
			$sql7 = $conn->prepare("UPDATE db9zmfww0e39gt.bs_user SET is_deleted = '1' 
						WHERE username = '$username1'");
			$sql7->execute();
			
		}else if($branch == 3){			
			//echo $username1;
			$sql7 = $conn->prepare("UPDATE dbbagnnas1vbly.bs_user SET is_deleted = '1' 
						WHERE username = '$username1'");
			$sql7->execute();
			
		}else if($branch == 4){			
			//echo $username1;
			$sql7 = $conn->prepare("UPDATE dbeqlwgwj8husy.bs_user SET is_deleted = '1' 
						WHERE username = '$username1'");
			$sql7->execute();
			
		}else if($branch == 5){			
			//echo $username1;
			$sql7 = $conn->prepare("UPDATE dblk0nwutv30gf.bs_user SET is_deleted = '1' 
						WHERE username = '$username1'");
			$sql7->execute();
			
		}else if($branch == 6){			
			//echo $username1;
			$sql7 = $conn->prepare("UPDATE dbsfm9aqzvepou.bs_user SET is_deleted = '1' 
						WHERE username = '$username1'");
			$sql7->execute();
			
		}else if($branch == 7){			
			//echo $username1;
			$sql7 = $conn->prepare("UPDATE dbjdbn1excuqsu.bs_user SET is_deleted = '1' 
						WHERE username = '$username1'");
			$sql7->execute();
			
		}
			

		header('Location: index.php?error=' . urlencode('Deleted successfully'));

?>