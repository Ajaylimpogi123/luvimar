<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';
require_once '../global-library/product-functions.php';
require_once '../global-library/cart-functions.php';

checkUser();

$userId = $_SESSION['user_id'];
$val = $_GET['v'] ?? null;
$pid = $_GET['pid'] ?? null;

// Validate inputs
if (!$pid || !$val || !is_numeric($pid) || !is_numeric($val)) {
	header('Location: cart.php');
	exit;
}

// Fetch product info securely
$sql = $conn->prepare("SELECT * FROM tbl_product WHERE pd_id = ? AND is_deleted != '1'");
$sql->execute([$pid]);

if ($sql->rowCount() !== 1) {
	header('Location: cart.php');
	exit;
}

$product = $sql->fetch();
$prodId = $product['pd_id'];

switch ((int)$val) {
	case 1:
		$pdprice = $product['pc_price'];
		$currentStock = (int)$product['pc_qty'];
		$isfp = 1;
		break;
	case 2:
		$pdprice = $product['ib_price'];
		$currentStock = (int)$product['ib_qty'];
		$isfp = 2;
		break;
	default:
		$pdprice = $product['bx_price'];
		$currentStock = (int)$product['bx_qty'];
		$isfp = 3;
		break;
}

$pdcost = $product['pd_cost'];
$catid = $product['cat_id'];

if ($currentStock <= 0) {
	echo "<center><h3 style='color:red;'>The product you requested is no longer in stock</h3><img src='../images/loader/loader_3.gif'></center>";
	$url = "index.php?view=list&id=$catid";
	echo "<meta http-equiv=\"refresh\" content=\"2;URL=$url\">";
	exit;
}

// Proceed to cart logic
$sid = session_id();
date_default_timezone_set("Asia/Manila");
$today_date1 = date("Y-m-d H:i:s");

// Check if product already exists in cart
$checkCart = $conn->prepare("SELECT ct_qty FROM tbl_cart WHERE pd_id = ? AND user_id = ? AND is_type = ?");
$checkCart->execute([$prodId, $userId, $isfp]);

if ($checkCart->rowCount() === 0) {
	// Add to cart with quantity = 1
	$insert = $conn->prepare("INSERT INTO tbl_cart (pd_id, ct_qty, ct_price, ct_cost, ct_session_id, ct_date, user_id, is_type)
        VALUES (?, 1, ?, ?, ?, ?, ?, ?)");
	$insert->execute([$prodId, $pdprice, $pdcost, $sid, $today_date1, $userId, $isfp]);
} else {
	// Check if adding more exceeds current stock
	$cart = $checkCart->fetch();
	$currentQtyInCart = (int)$cart['ct_qty'];

	if ($currentQtyInCart >= $currentStock) {
		echo "<center><h3 style='color:red;'>You’ve reached the maximum stock limit for this product.</h3><img src='../images/loader/loader_3.gif'></center>";
		$url = "index.php?view=list&id=$catid";
		echo "<meta http-equiv=\"refresh\" content=\"2;URL=$url\">";
		exit;
	}

	// Update cart quantity if stock allows
	$update = $conn->prepare("UPDATE tbl_cart 
        SET ct_qty = ct_qty + 1
        WHERE pd_id = ? AND user_id = ? AND is_type = ?");
	$update->execute([$prodId, $userId, $isfp]);
}

// Clean up abandoned carts
deleteAbandonedCart();

// Optional: redirect or success message
// header('Location: ' . $_SESSION['shop_return_url']);
