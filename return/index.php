<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';
require_once '../global-library/category-functions.php';
require_once '../global-library/product-functions.php';
require_once '../global-library/cart-functions3.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
$_SESSION['shop_return_url'] = $_SERVER['REQUEST_URI'];

$catId  = (isset($_GET['c']) && $_GET['c'] != '1') ? $_GET['c'] : 0;
$pdId   = (isset($_GET['p']) && $_GET['p'] != '') ? $_GET['p'] : 0;
checkUser();

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';

	# Get setting details
	$sett = $conn->prepare("SELECT * FROM bs_setting");
	$sett->execute();
	$sett_data = $sett->fetch();

switch ($view) {
	case 'list' :
		$content 	= 'list.php';
		$pageTitle 	= $sett_data['system_title'];
		break;
		
	case 'add' :
		$content 	= 'add.php';
		$pageTitle 	= $sett_data['system_title'];
		break;
		
	case 'modify' :
		$content 	= 'modify.php';
		$pageTitle 	= $sett_data['system_title'];
		break;
		
	case 'assign' :
		$content 	= 'assign.php';
		$pageTitle 	= $sett_data['system_title'];
		break;
		
	case 'cart' :
		$content 	= 'cart.php';
		$pageTitle 	= $sett_data['system_title'];
		break;
		
	case 'customer' :
		$content 	= 'customer.php';
		$pageTitle 	= $sett_data['system_title'];
		break;
		
	case 'checkout' :
		$content 	= 'checkout.php';
		$pageTitle 	= $sett_data['system_title'];
		break;
		
	default :
		$content 	= 'list.php';
		$pageTitle 	= $sett_data['system_title'];
}

$script    = array('return.js');

require_once '../include/template.php';
	
?>