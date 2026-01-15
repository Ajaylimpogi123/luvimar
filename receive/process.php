<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';
require_once '../global-library/cart-functions2.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {
	
    case 'saveorder' :
        saveOrder();
        break;        
	   
    default :
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
	
	$pid = $_POST['hidCartId'];
	$sup = $_POST['supplier'];
	$pm = $_POST['top'];
	$ornum = $_POST['ornum'];
	$drnum = $_POST['drnum'];
	$terms = $_POST['terms'];
	
	if($pm == 'Cash'){ $ispaid = 1; $paiddate = $today_date2; $charge = 0; }else{ $ispaid = 0; $paiddate = ""; $charge = 1; }
	
	if($sup == 0)
	{
		include 'update_cart.php';
		
		echo "<center><h3>Please choose supplier</h3><img src='../images/loader/loader_3.gif'><center>";
		$url = "index.php?view=cart";
		echo "<meta http-equiv=\"refresh\" content=\"1;URL=$url\">";
	}else{
	
		include 'update_cart.php';
	
	
	$orderId = 0;
		
		$cartContent = getReceivingCart();
		$numItem     = count($cartContent);
		
		$totalcost = 0;
		for ($i = 0; $i < $numItem; $i++) {
			extract($cartContent[$i]);
			$totalcost += $ct_cost * $ct_qty;
		}
		
		if($pm == 'Cash')
		{
			$newDate = "0000-00-00";
		}else{
			$date=strtotime(date('Y-m-d'));  // if today :2013-05-23
			$newDate = date('Y-m-d',strtotime('+' . $terms . ' days',$date));
			//echo $newDate; //after15 days  :2013-06-07
		}
		
		// save order & get order id
		$sql = $conn->prepare("INSERT INTO tbl_received (sup_id, payment_method, or_num, dr_num, terms, total_cost, is_paid, is_charge, added_by, date_added, date_added_ymd, date_due, paid_date, is_deleted)
					VALUES ('$sup', '$pm', '$ornum', '$drnum', '0', '$totalcost', '$ispaid', '$charge', '$userId', '$today_date1', '$today_date2', '$newDate', '$paiddate', '0')");
		$sql->execute();
		
		// get the order id
		$orderId = $conn->lastInsertId();
		
			// save received
			for ($i = 0; $i < $numItem; $i++) {
				
				$istype = $cartContent[$i]['is_type'];
				$ctqty = $cartContent[$i]['ct_qty'];
				
				$pd = $conn->prepare("SELECT * FROM tbl_product WHERE pd_id = {$cartContent[$i]['pd_id']}");
				$pd->execute();
				$pd_data = $pd->fetch();
				$pc_qty = $pd_data['pc_qty'];
				$ib_qty = $pd_data['ib_qty'];
				$bx_qty = $pd_data['bx_qty'];
				$pd_qty_min = $pd_data['pd_mqty'];
				$pd_name = mysqli_real_escape_string($link, $pd_data['pd_name']);
				$pd_cost = $pd_data['pd_cost'];
				$pc_price = $pd_data['pc_price'];
				$ib_price = $pd_data['ib_price'];
				$bx_price = $pd_data['bx_price'];
				
				if(($istype == 3) && ($ctqty != 0))
				{
				
					$bx = $conn->prepare("INSERT INTO tbl_received_item(rec_id, pd_id, pd_qty_left, pd_mqty, od_qty_added, pd_cost, added_by, date_added, date_added_ymd, pd_type)
							VALUES ('$orderId', {$cartContent[$i]['pd_id']}, '$bx_qty', '$pd_qty_min', {$cartContent[$i]['ct_qty']}, '{$cartContent[$i]['ct_cost']}', '$userId', '$today_date1', '$today_date2', 'bx')");
					$bx->execute();									
				}
				else if(($istype == 2) && ($ctqty != 0))
				{
					$ib = $conn->prepare("INSERT INTO tbl_received_item(rec_id, pd_id, pd_qty_left, pd_mqty, od_qty_added, pd_cost, added_by, date_added, date_added_ymd, pd_type)
							VALUES ('$orderId', {$cartContent[$i]['pd_id']}, '$ib_qty', '$pd_qty_min', {$cartContent[$i]['ct_qty']}, '{$cartContent[$i]['ct_cost']}', '$userId', '$today_date1', '$today_date2', 'ib')");
					$ib->execute();
				}
				else if(($istype == 1) && ($ctqty != 0))
				{
					$pc = $conn->prepare("INSERT INTO tbl_received_item(rec_id, pd_id, pd_qty_left, pd_mqty, od_qty_added, pd_cost, added_by, date_added, date_added_ymd, pd_type)
																VALUES ('$orderId', {$cartContent[$i]['pd_id']}, '$pc_qty', '$pd_qty_min', {$cartContent[$i]['ct_qty']}, '{$cartContent[$i]['ct_cost']}', '$userId', '$today_date1', '$today_date2', 'pc')");
					$pc->execute();			
				}else{}
								
				// Product Log
				$sql = $conn->prepare("INSERT INTO tbl_product_log(pd_id, pd_name, pd_cost, date_added)
						VALUES ({$cartContent[$i]['pd_id']}, '$pd_name', '$pd_cost', '$today_date1')");
				$sql->execute();
			}
		
			
			// update product stock
			for ($i = 0; $i < $numItem; $i++) 
			{
				extract($cartContent[$i]);
				
				$qw = $conn->prepare("SELECT * FROM tbl_product WHERE pd_id = '$pd_id'");
				$qw->execute();
				$qw_data = $qw->fetch();
				
				$crt_qty = $cartContent[$i]['ct_qty'];
				$crt_pid = $cartContent[$i]['pd_id'];
				$crt_cid = $cartContent[$i]['ct_id'];
				
				if($is_type == 3)
				{ 
					$tp = "bx";
					$bx = $qw_data['bx_formula'];
					$ib = $qw_data['ib_formula'];
					$pc = $qw_data['pc_formula'];
					$prc = $qw_data['bx_price'];
					$cost = $qw_data['pd_cost'];
					
					if($crt_qty != 0)
					{
						
						// BX
						$sql3 = $conn->prepare("UPDATE tbl_product SET bx_qty = bx_qty + '$crt_qty', bx_price = {$cartContent[$i]['ct_price']} WHERE pd_id = '$crt_pid'");
						$sql3->execute();
						
						$ib_qty = $crt_qty * $ib;
						
						// IB
						$sql2 = $conn->prepare("UPDATE tbl_product SET ib_qty = ib_qty + '$ib_qty', ib_price = {$cartContent[$i]['ct_price']} WHERE pd_id = '$crt_pid'");
						$sql2->execute();
						
						if($ib != 0)
						{
							$pc_qty = $ib_qty * $pc;
						}else{
							$pc_qty = $crt_qty * $pc;
						}
						
						// PC
						$sql1 = $conn->prepare("UPDATE tbl_product  SET pc_qty = pc_qty + '$pc_qty', pc_price = {$cartContent[$i]['ct_price']} WHERE pd_id = '$crt_pid'");
						$sql1->execute();
												
					}else{}
				}
				else if($is_type == 2)
				{ 
					$tp = "ib"; 
					$bx = $qw_data['bx_formula'];
					$ib = $qw_data['ib_formula'];
					$pc = $qw_data['pc_formula'];
					$prc = $qw_data['ib_price'];
					$cost = $qw_data['pd_cost'];
					
					if($crt_qty != 0)
					{						
						
						// IB
						$up_ib = $conn->prepare("UPDATE tbl_product SET ib_qty = ib_qty + '$crt_qty', ib_price = {$cartContent[$i]['ct_price']} WHERE pd_id = '$crt_pid'");
						$up_ib->execute();
						$pc_qty = $crt_qty * $pc;
						
						// PC
						$up_pc = $conn->prepare("UPDATE tbl_product SET pc_qty = pc_qty + '$pc_qty', pc_price = {$cartContent[$i]['ct_price']} WHERE pd_id = '$crt_pid'");
						$up_pc->execute();
						
						if($bx != 0)
						{
							$bx_qty = $crt_qty / $ib;
												
							$whole = floor($bx_qty);
							$fraction = $bx_qty - $whole;					
							
							// BX
							$up_bx = $conn->prepare("UPDATE tbl_product SET bx_qty = bx_qty + '$whole', bx_price = {$cartContent[$i]['ct_price']} WHERE pd_id = '$crt_pid'");
							$up_bx->execute();
						}else{}
													
					}else{}
				}
				else
				{ 
					$tp = "pc"; 
					$bx = $qw_data['bx_formula'];
					$ib = $qw_data['ib_formula'];
					$pc = $qw_data['pc_formula'];
					$prc = $qw_data['pc_price'];
					$cost = $qw_data['pd_cost'];
					
					if($crt_qty != 0)
					{						
				
						// PC
						$up_pc = $conn->prepare("UPDATE tbl_product SET pc_qty = pc_qty + '$crt_qty', pc_price = {$cartContent[$i]['ct_price']} WHERE pd_id = '$crt_pid'");
						$up_pc->execute();
						
						if($ib != 0)
						{
							$ib_qty = $crt_qty / $pc;
							$whole_ib = floor($ib_qty);
							$fraction_ib = $ib_qty - $whole_ib;
							
							// IB
							$up_ib = $conn->prepare("UPDATE tbl_product SET ib_qty = ib_qty + '$whole_ib', ib_price = {$cartContent[$i]['ct_price']} WHERE pd_id = '$crt_pid'");
							$up_ib->execute();												
						}else{}
						if($bx != 0)
						{
							if($ib != 0)
							{
								$bx_qty = $ib_qty / $ib;
							}else{
								$bx_qty = $crt_qty / $pc;
							}
							$whole_bx = floor($bx_qty);
							$fraction_bx = $bx_qty - $whole_bx;						
						
							// BX
							$up_bx = $conn->prepare("UPDATE tbl_product SET bx_qty = bx_qty + '$whole_bx', bx_price = {$cartContent[$i]['ct_price']} WHERE pd_id = '$crt_pid'");
							$up_bx->execute();
						}else{}
					}
				}
			}
			
			
			// then remove the ordered items from cart
			for ($i = 0; $i < $numItem; $i++) {
				$sql = $conn->prepare("DELETE FROM tbl_cart_receive
				        WHERE ct_id = {$cartContent[$i]['ct_id']}");
				$sql->execute();				
			}							
		
	
	//return $orderId;
	
		echo "<center><h3>Processing...</h3><img src='../images/loader/loader_3.gif'><center>";
		$url = "index.php";
		echo "<meta http-equiv=\"refresh\" content=\"1;URL=$url\">";
	}
}


/*
Email : testme@phpwebcommerce.com 
Password : phpwebco
348640028
348640691
*/

?>