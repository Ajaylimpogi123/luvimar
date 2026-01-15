<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];
	
	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("Y-m-d");

	$cid = $_POST['cid'];
	$oid = $_POST['oid'];
	
	$or = mysqli_real_escape_string($link, $_POST['or']);
	
	$arec = mysqli_real_escape_string($link, $_POST['arec']);
	$camt = mysqli_real_escape_string($link, $_POST['camt']);
	
	$from = mysqli_real_escape_string($link, $_POST['from']);
	$datepaid = date("Y-m-d", strtotime($from));
	
	$top = mysqli_real_escape_string($link, $_POST['top']);
	
	$checknum = mysqli_real_escape_string($link, $_POST['checknum']);
	$checkdate = mysqli_real_escape_string($link, $_POST['checkdate']);
	$bank = mysqli_real_escape_string($link, $_POST['bank']);
	
	$chkdate = date("Y-m-d", strtotime($checkdate));
	
	$amtbal = $arec - $camt;
			
			$subjSql = $conn->prepare("INSERT INTO tr_payment_supplier (sup_id, rec_id, or_number, amount_due, amount_paid, balance, payment_method, check_no, check_date, bank, date_paid, date_time_added) 
							VALUES ('$cid', '$oid', '$or', '$arec', '$camt', '$amtbal', '$top', '$checknum', '$chkdate', '$bank', '$datepaid', '$today_date1')");
			$subjSql->execute();
			
			if($amtbal == 0)
			{
				$up = $conn->prepare("UPDATE tbl_received SET is_paid = '1', paid_date = '$today_date1' WHERE rec_id = '$oid'");
				$up->execute();
			}else{}
	
			/* Insert Log */
			$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
						VALUES ('Supplier payment added', '$cid', 'supplier payment', '$userId', NOW())");
			$log->execute();
			/* End Log */
			
			header("Location: index.php?view=add_payment&id=$cid&oi=$oid&error=Saved successfully");
				
						
?>