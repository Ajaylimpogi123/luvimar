<?php
require_once 'global-library/config.php';
require_once 'global-library/functions.php';

	if(isset($_SESSION['user_id']))
	{ $userId = $_SESSION['user_id']; }else{ header('Location: login.php'); exit; }

	$sql = $conn->prepare("SELECT * FROM bs_user
				WHERE user_id = '$userId'");
	$sql->execute();
	$sql_data = $sql->fetch();	

	# Get setting details
	$sett = $conn->prepare("SELECT * FROM bs_setting");
	$sett->execute();
	$sett_data = $sett->fetch();
	
	if(isset($_GET['id']))
	{
		$tid = $_GET['id'];
		if($tid == 1){ $theme = "cerulean"; }else{ $theme = "slate"; }
		$upt = $conn->prepare("UPDATE bs_user SET theme = '$theme' WHERE user_id = '$userId'");
		$upt->execute();
		header("Location: index.php");
	}else{}
	
	if($sql_data['is_admin'] == 1)
	{
		checkUser();
		$content = 'home.php';
		$pageTitle = $sett_data['system_title'];
		$script = array('main.js');
		
		require_once 'include/dash.php';
	}else{
?>
	<head>
		<title><?php echo $sett_data['system_title']; ?></title>
		<link rel="shortcut icon" href="images/favicon.png">
	</head>
	<frameset rows="100%">
	  <frameset cols="100%">
		<frame src="encrypt.php" frameborder="0" scrolling="yes">
	  </frameset>
	</frameset>
<?php } ?>