<?php	
	require_once 'global-library/config.php';
	require_once 'global-library/functions.php';
	
	if(isset($_SESSION['user_id']))
	{ $userId = $_SESSION['user_id']; }else{ header('Location: login.php'); exit; }
	
	# Get setting details
	$sett = $conn->prepare("SELECT * FROM bs_setting");
	$sett->execute();
	$sett_data = $sett->fetch();
	
	$sql = $conn->prepare("SELECT * FROM bs_user
				WHERE user_id = '$userId'");
	$sql->execute();
	$sql_data = $sql->fetch();		
	
	checkUser();
	$content = 'home.php';
	$pageTitle = $sett_data['system_title'];
	$script = array('main.js');

	if($sql_data['is_admin'] == 1)
	{ require_once 'include/dash.php'; }else{ require_once 'include/template.php'; }
	
?>
<html>
<head>
</head>
<body bgcolor = "#FDE2B8">
</body>
</html>