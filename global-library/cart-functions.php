<?php
require_once 'config.php';
require_once 'functions.php';

checkUser();

/*********************************************************
 *                 SHOPPING CART FUNCTIONS 
 *********************************************************/

function addToCart()
{
	include 'database.php';
	$userId = $_SESSION['user_id'];

	// make sure the product id exist
	if (isset($_GET['p']) && (int)$_GET['p'] > 0) {
		$productId = (int)$_GET['p'];
	} else {
		header('Location: index.php');
	}

	// does the product exist ?
	$sql = $conn->prepare("SELECT pd_id, pd_qty
	        FROM tbl_product
			WHERE pd_id = $productId");
	$sql->execute();

	if ($sql->rowCount() != 1) {
		// the product doesn't exist
		header('Location: cart.php');
	} else {
		// how many of this product we
		// have in stock
		$sql_data = $sql->fetch();
		$currentStock = $sql_data['pd_qty'];

		if ($currentStock == 0) {
			// we no longer have this product in stock
			// show the error message
			setError('The product you requested is no longer in stock');
			header('Location: cart.php');
			exit;
		}
	}

	// current session id
	$sid = session_id();

	// check if the product is already
	// in cart table for this session
	$sql = $conn->prepare("SELECT pd_id
	        FROM tbl_cart
			WHERE pd_id = $productId AND ct_session_id = '$sid'");
	$sql->execute();

	if ($sql->rowCount() == 0) {
		// put the product in cart table
		$sql = $conn->prepare("INSERT INTO tbl_cart (pd_id, ct_qty, ct_session_id, ct_date)
				VALUES ($productId, 1, '$sid', NOW())");
		$sql->execute();
	} else {
		// update product quantity in cart table
		$sql = $conn->prepare("UPDATE tbl_cart 
		        SET ct_qty = ct_qty + 1
				WHERE ct_session_id = '$sid' AND pd_id = $productId");

		$sql->execute();
	}

	// an extra job for us here is to remove abandoned carts.
	// right now the best option is to call this function here
	deleteAbandonedCart();

	header('Location: ' . $_SESSION['shop_return_url']);
}

/*
	Get all item in current session
	from shopping cart table
*/
function getCartContent()
{
	include 'database.php';
	$userId = $_SESSION['user_id'];

	$cartContent = array();

	$sid = session_id();
	$sql = $conn->prepare("SELECT *
			FROM tbl_cart ct, tbl_product pd, tbl_category cat
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
function deleteFromCart($cartId = 0)
{
	include 'database.php';
	$userId = $_SESSION['user_id'];

	if (!$cartId && isset($_GET['cid']) && (int)$_GET['cid'] > 0) {
		$cartId = (int)$_GET['cid'];
	}

	if ($cartId) {
		$sql  = $conn->prepare("DELETE FROM tbl_cart
				 WHERE ct_id = $cartId");

		$sql->execute();
	}

	//header('Location: index.php?view=cart');	
}

/*
	Update item quantity in shopping cart
*/
function updateCart()
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
			// check current stock
			$sql = $conn->prepare("SELECT pd_name, pd_qty
			        FROM tbl_product 
					WHERE pd_id = {$productId[$i]}");
			$sql->execute();
			$sql_data = $sql->fetch();

			if ($newQty > $sql_data['pd_qty']) {
				// we only have this much in stock
				$newQty = $sql_data['pd_qty'];

				// if the customer put more than
				// we have in stock, give a notice
				if ($sql_data['pd_qty'] > 0) {
					setError('The quantity you have requested is more than we currently have in stock. The number available is indicated in the &quot;Quantity&quot; box. ');
				} else {
					// the product is no longer in stock
					setError('Sorry, but the product you want (' . $sql_data['pd_name'] . ') is no longer in stock');

					// remove this item from shopping cart
					deleteFromCart($cartId[$i]);
					$numDeleted += 1;
				}
			}

			// update product quantity
			$sql = $conn->prepare("UPDATE tbl_cart
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

function isCartEmpty()
{
	include 'database.php';
	$userId = $_SESSION['user_id'];

	$isEmpty = false;

	$sid = session_id();
	$sql = $conn->prepare("SELECT ct_id
			FROM tbl_cart ct
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
function deleteAbandonedCart()
{
	include 'database.php';
	$yesterday = date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')));
	$sql = $conn->prepare("DELETE FROM tbl_cart
	        WHERE ct_date < '$yesterday'");
	$sql->execute();
}

/* -- RECEIVING CART STARTS HERE -- */

/*
	Get all item in current session
	from shopping cart table
*/
function getReceivingCart()
{
	include 'database.php';
	$userId = $_SESSION['user_id'];

	$cartContent = array();

	$sid = session_id();
	$sql = $conn->prepare("SELECT ct_id, ct.pd_id, ct_qty, pd_name, pd_price, pd_thumbnail, pd.cat_id, cat.cat_name, ct_cost, sup_id
			FROM tbl_cart_receive ct, tbl_product pd, tbl_category cat
			WHERE ct.ct_session_id = '$sid' AND ct.pd_id = pd.pd_id AND cat.cat_id = pd.cat_id AND ct.user_id = '$userId'");

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
function deleteFromReceivingCart($cartId = 0)
{
	include 'database.php';
	$userId = $_SESSION['user_id'];

	if (!$cartId && isset($_GET['cid']) && (int)$_GET['cid'] > 0) {
		$cartId = (int)$_GET['cid'];
	}

	if ($cartId) {
		$sql  = $conn->prepare("DELETE FROM tbl_cart_receive
				 WHERE ct_id = $cartId");

		$sql->execute();
	}

	//header('Location: index.php?view=cart');	
}

/*
	Update item quantity in shopping cart
*/
function updateReceivingCart()
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
			$sql = $conn->prepare("UPDATE tbl_cart_receive
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

function isReceivingCartEmpty()
{
	include 'database.php';
	$userId = $_SESSION['user_id'];

	$isEmpty = false;

	$sid = session_id();
	$sql = $conn->prepare("SELECT ct_id
			FROM tbl_cart_receive ct
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
function deleteAbandonedReceivingCart()
{
	include 'database.php';
	$yesterday = date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')));
	$sql = $conn->prepare("DELETE FROM tbl_cart_receive
	        WHERE ct_date < '$yesterday'");
	$sql->execute();
}

/* -- RECEIVING CART STARTS HERE -- */

/* -- RETURNING CART STARTS HERE -- */

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
	$sql = $conn->prepare("SELECT ct_id, ct.pd_id, ct_qty, pd_name, pd_price, pd_thumbnail, pd.cat_id, cat.cat_name, pd.branch_id, ct.release_to, ct.pd_barcode
			FROM tbl_cart_return ct, tbl_product pd, tbl_category cat
			WHERE ct.ct_session_id = '$sid' AND ct.pd_id = pd.pd_id AND cat.cat_id = pd.cat_id AND ct.user_id = '$userId'");

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
	$yesterday = date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')));
	$sql = $conn->prepare("DELETE FROM tbl_cart_return
	        WHERE ct_date < '$yesterday'");
	$sql->execute();
}

/* -- RETURNING CART STARTS HERE -- */
