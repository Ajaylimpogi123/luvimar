<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';
require_once '../global-library/product-functions.php';
require_once '../global-library/cart-functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';

	# Get setting details
	$sett = "SELECT * FROM bs_setting";
	$rs_sett = dbQuery($sett);
	$rw_sett = dbFetchAssoc($rs_sett);
	extract($rw_sett);

switch ($view) {
	case 'list' :
		$content 	= 'list.php';
		$pageTitle 	= $system_title;
		break;

	case 'search' :
		$content 	= 'search.php';
		$pageTitle 	= $system_title;
		break;
		
	case 'cart' :
		$content 	= 'cart.php';
		$pageTitle 	= $system_title;
		break;
		
	case 'customer' :
		$content 	= 'customer.php';
		$pageTitle 	= $system_title;
		break;
		
	case 'checkout' :
		$content 	= 'checkout.php';
		$pageTitle 	= $system_title;
		break;
		
	default :
		$content 	= 'list.php';
		$pageTitle 	= $system_title;
}

$script    = array('payment.js');

require_once '../include/template.php';
	
?>