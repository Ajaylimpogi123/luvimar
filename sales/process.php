<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';
require_once '../global-library/cart-functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {

	case 'saveorder':
		saveOrder();
		break;

	default:
		// if action is not defined or unknown
		// move to main category page
		header('Location: index.php');
}

/*********************************************************
 *                 CHECKOUT FUNCTIONS 
 *********************************************************/
function saveOrder()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];

	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("Y-m-d");

	$discId = 0; // Discount Id

	$top = $_POST['top'];


	$amtdue = $_POST['amtdue'];
	$dcamt = $_POST['discount'];
	$tamtd = $_POST['tamtd'];
	$payment = $_POST['payment'];
	$change = $_POST['change'];
	$cost = $_POST['cost'];
	$tidays = $_POST['tidays'];
	$perdisc = $_POST['perdisc'];
	$remarks = $_POST['remarks'];
	


	$deldate = $_POST['deldate'];
	$deliverydate = date("Y-m-d", strtotime($deldate));
	$deladd = mysqli_real_escape_string($link, $_POST['deladd']);
	$driver = mysqli_real_escape_string($link, $_POST['driver']);
	$isdelivery = 1;


	$orderId       = 0;

	$firstname = mysqli_real_escape_string($link, $_POST['fname'] ?? '');

	$cus = $conn->prepare("SELECT * FROM bs_customer WHERE cust_id = '$firstname'");
	$cus->execute();
	$cus_data = $cus->fetch();
	$custname = mysqli_real_escape_string($link, $cus_data['client_name'] ?? '');
	$custid = $cus_data['cust_id'] ?? '';


	if ($top == 'Cash') {

		$ordernum = mysqli_real_escape_string($link, $_POST['ornum'] ?? '');
		$jonum = mysqli_real_escape_string($link, $_POST['jonum']);
		$transac = '';
		$paid = 1;
		$charge = 0;
		$paiddate = mysqli_real_escape_string($link, $_POST['date_purchase']);
		$cinum = mysqli_real_escape_string($link, $_POST['cinum']);
		// $ponum = mysqli_real_escape_string($link, $_POST['ponum']);
		// $recby = mysqli_real_escape_string($link, $_POST['recby']);

		$pmode = 'Cash';

		$newDate = "0000-00-00";

		// if ($firstname == "") {
		// 	$custname = "Walk-In";
		// } else {
		// 	$custname = $firstname;


		// }




		if ($dcamt == 0) {
			$disc = 0;
		} else {
			$disc = $dcamt;
		}
		if ($tamtd == 0 || $tamtd == "") {
			$total_due = $amtdue;
		} else {
			$total_due = $tamtd;
		}
		$total_change = $payment - $total_due;
		if (($payment < $tamtd) && $payment != 0) {
			echo "<center><h3>Payment not enough</h3><img src='../images/loader/loader_3.gif'><center>";
			$url = "index.php?view=customer";
			echo "<meta http-equiv=\"refresh\" content=\"1;URL=$url\">";
		} else {
			include 'save_order.php';

			echo "<center><h3>Processing...</h3><img src='../images/loader/loader_3.gif'><center>";
			$url = "../index.php";
			// $url = "print.php?oid=$orderId&pg=1";
			echo "<meta http-equiv=\"refresh\" content=\"1;URL=$url\">";
		}
	} elseif ($top == 'collection') {
		$deldate = $_POST['deldate'];
		$deliverydate = date("Y-m-d", strtotime($deldate));
		$deladd = mysqli_real_escape_string($link, $_POST['deladd']);
		$driver = mysqli_real_escape_string($link, $_POST['driver']);
		$isdelivery = 1;
		
		$duedate = $_POST['duedate'] ?? NULL;
		$pmode  = 'collection';
		$transac = '';

		$ordernum = mysqli_real_escape_string($link, $_POST['cinum']);
		$paid = 0;
		$charge = 1;
		$paiddate = "";
		$ponum = mysqli_real_escape_string($link, $_POST['ponum']);
		$recby = mysqli_real_escape_string($link, $_POST['recby']);

		$date = strtotime(date('Y-m-d'));  // if today :2013-05-23
		$newDate = date('Y-m-d', strtotime('+' . $tidays . ' days', $date));
		//echo $newDate; //after15 days  :2013-06-07



		if ($dcamt == 0) {
			$disc = 0;
		} else {
			$disc = $dcamt;
		}
		if ($tamtd == 0 || $tamtd == "") {
			$total_due = $amtdue;
		} else {
			$total_due = $tamtd;
		}
		$total_change = 0;

		include 'save_order.php';
		echo "<center><h3>Processing...</h3><img src='../images/loader/loader_3.gif'><center>";
		$url = "../index.php";
		echo "<meta http-equiv=\"refresh\" content=\"1;URL=$url\">";
	} else {
		$firstname = mysqli_real_escape_string($link, $_POST['fname']);

		$ordernum = mysqli_real_escape_string($link, $_POST['ornum'] ?? '');
		$paid = 1;
		$charge = 0;
		$paiddate = $today_date2;
		// $ponum = mysqli_real_escape_string($link, $_POST['ponum']);
		// $recby = mysqli_real_escape_string($link, $_POST['recby']);
		$pmode  = 'Gcash';
		$transac = mysqli_real_escape_string($link, $_POST['transaction_code'] ?? '');
		$newDate = "0000-00-00";

		if ($firstname == "") {
			$custname = "Walk-In";
		} else {
			$custname = $firstname;
		}

		$custid = 0;
		if ($dcamt == 0) {
			$disc = 0;
		} else {
			$disc = $dcamt;
		}

		if ($tamtd == 0 || $tamtd == "") {
			$total_due = $amtdue;
		} else {
			$total_due = $tamtd;
		}
		$total_change = $payment - $total_due;
		if (($payment < $tamtd) && $payment != 0) {
			echo "<center><h3>Payment not enough</h3><img src='../images/loader/loader_3.gif'><center>";
			$url = "index.php?view=customer";
			echo "<meta http-equiv=\"refresh\" content=\"1;URL=$url\">";
		} else {
			include 'save_order.php';

			echo "<center><h3>Processing...</h3><img src='../images/loader/loader_3.gif'><center>";
			// $url = "../index.php";
			$url = "print.php?oid=$orderId&pg=1";
			echo "<meta http-equiv=\"refresh\" content=\"1;URL=$url\">";
		}
	}
}

/*
	Get order total amount ( total purchase + shipping cost )
*/
function getOrderAmount($orderId)
{
	include '../global-library/database.php';
	$orderAmount = 0;

	$sql = $conn->prepare("SELECT SUM(pd_price * od_qty)
	        FROM tbl_order_item oi, tbl_product p 
		    WHERE oi.pd_id = p.pd_id and oi.od_id = $orderId
			
			UNION
			
			SELECT od_shipping_cost 
			FROM tbl_order
			WHERE od_id = $orderId");
	$sql->execute();

	if ($sql->rowCount() == 2) {
		$sql_data = $sql->fetch();
		$totalPurchase = $sql_data[0];

		$sql_data = $sql->fetch();
		$shippingCost = $sql_data[0];

		$orderAmount = $totalPurchase + $shippingCost;
	}

	return $orderAmount;
}

/*
Email : testme@phpwebcommerce.com 
Password : phpwebco
348640028
348640691
*/
