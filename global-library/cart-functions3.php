<?php
require_once 'config.php';
require_once 'functions.php';

checkUser();

/*********************************************************
*                 SHOPPING CART FUNCTIONS 
*********************************************************/



/* -- RETURN CART STARTS HERE -- */

/*
	Get all item in current session
	from shopping cart table
*/
function getReturningCart()
{
	include 'database.php';
	$userId = $_SESSION['user_id'];
	
	$cartContent = array();

	$sid = session_id();
	$sql = $conn->prepare("SELECT ct_id, ct.pd_id, ct_qty, pd_name, pd_thumbnail, pd.cat_id, ct_cost, ct_price, is_type
			FROM tbl_cart_return ct, tbl_product pd, tbl_category cat
			WHERE ct.pd_id = pd.pd_id AND cat.cat_id = pd.cat_id AND ct.user_id = '$userId'");
	
	$sql->execute();
	
	while ($sql_data = $sql->fetch()) {
		if ($sql_data['pd_thumbnail']) {
			$sql_data['pd_thumbnail'] = WEB_ROOT . 'images/product/' . $sql_data['pd_thumbnail'];
		} else {
			$sql_data['pd_thumbnail'] = WEB_ROOT . 'images/product/noimagesmall.png';
		}
		$cartContent[] = $sql_data;
	}
	
	return $cartContent;
}

/*
	Remove an item from the cart
*/
function deleteFromReturningCart($cartId = 0)
{
	include 'database.php';
	$userId = $_SESSION['user_id'];
	
	if (!$cartId && isset($_GET['cid']) && (int)$_GET['cid'] > 0) {
		$cartId = (int)$_GET['cid'];
	}

	if ($cartId) {	
		$sql  = $conn->prepare("DELETE FROM tbl_cart_return
				 WHERE ct_id = $cartId");

		$sql->execute();
	}
	
	//header('Location: index.php?view=cart');	
}

/*
	Update item quantity in shopping cart
*/
function updateReturningCart()
{
	include 'database.php';
	$userId = $_SESSION['user_id'];
	
	$cartId     = $_POST['hidCartId'];
	$productId  = $_POST['hidProductId'];
	$itemQty    = $_POST['txtQty'];
	$numItem    = count($itemQty);
	$numDeleted = 0;
	$notice     = '';
	
	for ($i = 0; $i < $numItem; $i++) {
		$newQty = (int)$itemQty[$i];
		if ($newQty < 1) {
			// remove this item from shopping cart
			deleteFromCart($cartId[$i]);	
			$numDeleted += 1;
		} else {				
			// update product quantity
			$sql = $conn->prepare("UPDATE tbl_cart_return
					SET ct_qty = $newQty
					WHERE ct_id = {$cartId[$i]} AND user_id = '$userId'");
				
			$sql->execute();
		}
	}
	
	if ($numDeleted == $numItem) {
		// if all item deleted return to the last page that
		// the customer visited before going to shopping cart
		header("Location: $returnUrl" . $_SESSION['shop_return_url']);
	} else {
		//header("Location: index.php?view=cart");
		echo "<center><h3>Processing...</h3><img src='../images/loader/loader_3.gif'><center>";
		$url = "index.php?view=cart";
		echo "<meta http-equiv=\"refresh\" content=\"1;URL=$url\">";
	}
	
	exit;
}

function isReturningCartEmpty()
{
	include 'database.php';
	$userId = $_SESSION['user_id'];
	
	$isEmpty = false;
	
	$sid = session_id();
	$sql = $conn->prepare("SELECT ct_id
			FROM tbl_cart_return ct
			WHERE ct_session_id = '$sid' AND user_id = '$userId'");
	
	$sql->execute();
	
	if ($sql->rowCount() == 0) {
		$isEmpty = true;
	}	
	
	return $isEmpty;
}

/*
	Delete all cart entries older than one day
*/
function deleteAbandonedReturningCart()
{
	include 'database.php';
	$yesterday = date('Y-m-d H:i:s', mktime(0,0,0, date('m'), date('d') - 1, date('Y')));
	$sql = $conn->prepare("DELETE FROM tbl_cart_return
	        WHERE ct_date < '$yesterday'");
	$sql->execute();		
}

/* -- RETURNING CART STARTS HERE -- */

?>