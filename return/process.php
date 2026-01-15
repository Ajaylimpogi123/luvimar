<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';
require_once '../global-library/cart-functions3.php';

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
	$cust = $_POST['customer'];
	$reason = $_POST['reason'];
	
	$top = $_POST['top'];
	
	if($top == 'a'){ $val = $cust; $vla = "customer"; }else{ $val = $sup; $vla = "supplier"; }
	
	
	
		include 'update_cart.php';
	
	
	$orderId       = 0;
		
		$cartContent = getReturningCart();
		$numItem     = count($cartContent);
		
		$totalcost = 0;
		for ($i = 0; $i < $numItem; $i++) {
			extract($cartContent[$i]);
			$totalcost += $ct_cost * $ct_qty;
		}				
		
		// save order & get order id
		$sql = $conn->prepare("INSERT INTO tbl_returned (sup_id, cust_id, total_cost, added_by, date_added, date_added_ymd, is_deleted)
				VALUES ('$sup', '$cust', '$totalcost', '$userId', '$today_date1', '$today_date2', '0')");
		$sql->execute();
		
		// get the order id
		$orderId = $conn->lastInsertId();
		
			// save returned
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
			
				/*$sql = "INSERT INTO tbl_returned_item(ret_id, pd_id, pd_qty_left, pd_mqty, od_qty_added, pd_cost, added_by, date_added, date_added_ymd)
						VALUES ('$orderId', {$cartContent[$i]['pd_id']}, '$pd_qty_left', '$pd_qty_min', {$cartContent[$i]['ct_qty']}, '{$cartContent[$i]['ct_cost']}', '$userId', '$today_date1', '$today_date2')";
				$result = dbQuery($sql);*/
				
				if(($istype == 3) && ($ctqty != 0))
				{
				
					$bx = $conn->prepare("INSERT INTO tbl_returned_item(ret_id, pd_id, pd_qty_left, pd_mqty, od_qty_added, pd_cost, added_by, date_added, date_added_ymd, pd_type)
							VALUES ('$orderId', {$cartContent[$i]['pd_id']}, '$bx_qty', '$pd_qty_min', {$cartContent[$i]['ct_qty']}, '{$cartContent[$i]['ct_cost']}', '$userId', '$today_date1', '$today_date2', 'bx')");
					$bx->execute();								
				}
				else if(($istype == 2) && ($ctqty != 0))
				{
					$ib = $conn->prepare("INSERT INTO tbl_returned_item(ret_id, pd_id, pd_qty_left, pd_mqty, od_qty_added, pd_cost, added_by, date_added, date_added_ymd, pd_type)
							VALUES ('$orderId', {$cartContent[$i]['pd_id']}, '$ib_qty', '$pd_qty_min', {$cartContent[$i]['ct_qty']}, '{$cartContent[$i]['ct_cost']}', '$userId', '$today_date1', '$today_date2', 'ib')");
					$ib->execute();
				}
				else if(($istype == 1) && ($ctqty != 0))
				{
					$pc = $conn->prepare("INSERT INTO tbl_returned_item(ret_id, pd_id, pd_qty_left, pd_mqty, od_qty_added, pd_cost, added_by, date_added, date_added_ymd, pd_type)
							VALUES ('$orderId', {$cartContent[$i]['pd_id']}, '$pc_qty', '$pd_qty_min', {$cartContent[$i]['ct_qty']}, '{$cartContent[$i]['ct_cost']}', '$userId', '$today_date1', '$today_date2', 'pc')");
					$pc->execute();				
				}else{}
								
			}
		
			/*if($top == 'a')
			{
				$inv = $_POST['inv'];
				if($inv == 1)
				{
					// update product stock
					for ($i = 0; $i < $numItem; $i++) {
						
						/*$sql = "UPDATE tbl_product 
								SET pd_qty = pd_qty + {$cartContent[$i]['ct_qty']}
								WHERE pd_id = {$cartContent[$i]['pd_id']}";
						$result = dbQuery($sql);
						
						
						extract($cartContent[$i]);
				
							$qw = "SELECT * FROM tbl_product WHERE pd_id = '$pd_id'";
							$rs_qw = dbQuery($qw);
							$rw_qw = dbFetchAssoc($rs_qw);
							
							$crt_qty = $cartContent[$i]['ct_qty'];
							$crt_pid = $cartContent[$i]['pd_id'];
							$crt_cid = $cartContent[$i]['ct_id'];
							
							if($is_type == 3)
							{ 
								$tp = "bx";
								$bx = $rw_qw['bx_formula'];
								$ib = $rw_qw['ib_formula'];
								$pc = $rw_qw['pc_formula'];
								$prc = $rw_qw['bx_price'];
								$cost = $rw_qw['pd_cost'];
								
								if($crt_qty != 0)
								{
									
									// BX
									$sql3 = "UPDATE tbl_product SET bx_qty = bx_qty + '$crt_qty', bx_price = {$cartContent[$i]['ct_price']} WHERE pd_id = '$crt_pid'";
									dbQuery($sql3);
									
									$ib_qty = $crt_qty * $ib;
									
									// IB
									$sql2 = "UPDATE tbl_product SET ib_qty = ib_qty + '$ib_qty', ib_price = {$cartContent[$i]['ct_price']} WHERE pd_id = '$crt_pid'";
									dbQuery($sql2);
									
									if($ib != 0)
									{
										$pc_qty = $ib_qty * $pc;
									}else{
										$pc_qty = $crt_qty * $pc;
									}
									
									// PC
									$sql1 = "UPDATE tbl_product SET pc_qty = pc_qty + '$pc_qty', pc_price = {$cartContent[$i]['ct_price']} WHERE pd_id = '$crt_pid'";
									dbQuery($sql1);
															
								}else{}
							}
							else if($is_type == 2)
							{ 
								$tp = "ib"; 
								$bx = $rw_qw['bx_formula'];
								$ib = $rw_qw['ib_formula'];
								$pc = $rw_qw['pc_formula'];
								$prc = $rw_qw['ib_price'];
								$cost = $rw_qw['pd_cost'];
								
								if($crt_qty != 0)
								{						
									
									// IB
									$up_ib = "UPDATE tbl_product SET ib_qty = ib_qty + '$crt_qty', ib_price = {$cartContent[$i]['ct_price']} WHERE pd_id = '$crt_pid'";
									dbQuery($up_ib);

									$pc_qty = $crt_qty * $pc;
									
									// PC
									$up_pc = "UPDATE tbl_product SET pc_qty = pc_qty + '$pc_qty', pc_price = {$cartContent[$i]['ct_price']} WHERE pd_id = '$crt_pid'";
									dbQuery($up_pc);
									
									if($bx != 0)
									{
										$bx_qty = $crt_qty / $ib;
															
										$whole = floor($bx_qty);
										$fraction = $bx_qty - $whole;					
										
										// BX
										$up_bx = "UPDATE tbl_product SET bx_qty = bx_qty + '$whole', bx_price = {$cartContent[$i]['ct_price']} WHERE pd_id = '$crt_pid'";
										dbQuery($up_bx);
									}else{}
																
								}else{}
							}
							else
							{ 
								$tp = "pc"; 
								$bx = $rw_qw['bx_formula'];
								$ib = $rw_qw['ib_formula'];
								$pc = $rw_qw['pc_formula'];
								$prc = $rw_qw['pc_price'];
								$cost = $rw_qw['pd_cost'];
								
								if($crt_qty != 0)
								{						
							
									// PC
									$up_pc = "UPDATE tbl_product SET pc_qty = pc_qty + '$crt_qty', pc_price = {$cartContent[$i]['ct_price']} WHERE pd_id = '$crt_pid'";
									dbQuery($up_pc);
									
									if($ib != 0)
									{
										$ib_qty = $crt_qty / $pc;
										$whole_ib = floor($ib_qty);
										$fraction_ib = $ib_qty - $whole_ib;
										
										// IB
										$up_ib = "UPDATE tbl_product SET ib_qty = ib_qty + '$whole_ib', ib_price = {$cartContent[$i]['ct_price']} WHERE pd_id = '$crt_pid'";
										dbQuery($up_ib);													
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
										$up_bx = "UPDATE tbl_product SET bx_qty = bx_qty + '$whole_bx', bx_price = {$cartContent[$i]['ct_price']} WHERE pd_id = '$crt_pid'";
										dbQuery($up_bx);
									}else{}
								}
							}
					}
				}else{}
			}else{
					// update product stock
					for ($i = 0; $i < $numItem; $i++) {
						/*$sql = "UPDATE tbl_product 
								SET pd_qty = pd_qty - {$cartContent[$i]['ct_qty']}
								WHERE pd_id = {$cartContent[$i]['pd_id']}";
						$result = dbQuery($sql);
						
							extract($cartContent[$i]);
				
							$qw = "SELECT * FROM tbl_product WHERE pd_id = '$pd_id'";
							$rs_qw = dbQuery($qw);
							$rw_qw = dbFetchAssoc($rs_qw);
							
							$crt_qty = $cartContent[$i]['ct_qty'];
							$crt_pid = $cartContent[$i]['pd_id'];
							$crt_cid = $cartContent[$i]['ct_id'];
							
							if($is_type == 3)
							{ 
								$tp = "bx";
								$bx = $rw_qw['bx_formula'];
								$ib = $rw_qw['ib_formula'];
								$pc = $rw_qw['pc_formula'];
								$prc = $rw_qw['bx_price'];
								$cost = $rw_qw['pd_cost'];
								
								if($crt_qty != 0)
								{
									
									// BX
									$sql3 = "UPDATE tbl_product SET bx_qty = bx_qty - '$crt_qty', bx_price = {$cartContent[$i]['ct_price']} WHERE pd_id = '$crt_pid'";
									dbQuery($sql3);
									
									$ib_qty = $crt_qty * $ib;
									
									// IB
									$sql2 = "UPDATE tbl_product SET ib_qty = ib_qty - '$ib_qty', ib_price = {$cartContent[$i]['ct_price']} WHERE pd_id = '$crt_pid'";
									dbQuery($sql2);
									
									if($ib != 0)
									{
										$pc_qty = $ib_qty * $pc;
									}else{
										$pc_qty = $crt_qty * $pc;
									}
									
									// PC
									$sql1 = "UPDATE tbl_product SET pc_qty = pc_qty - '$pc_qty', pc_price = {$cartContent[$i]['ct_price']} WHERE pd_id = '$crt_pid'";
									dbQuery($sql1);
															
								}else{}
							}
							else if($is_type == 2)
							{ 
								$tp = "ib"; 
								$bx = $rw_qw['bx_formula'];
								$ib = $rw_qw['ib_formula'];
								$pc = $rw_qw['pc_formula'];
								$prc = $rw_qw['ib_price'];
								$cost = $rw_qw['pd_cost'];
								
								if($crt_qty != 0)
								{						
									
									// IB
									$up_ib = "UPDATE tbl_product SET ib_qty = ib_qty - '$crt_qty', ib_price = {$cartContent[$i]['ct_price']} WHERE pd_id = '$crt_pid'";
									dbQuery($up_ib);

									$pc_qty = $crt_qty * $pc;
									
									// PC
									$up_pc = "UPDATE tbl_product SET pc_qty = pc_qty - '$pc_qty', pc_price = {$cartContent[$i]['ct_price']} WHERE pd_id = '$crt_pid'";
									dbQuery($up_pc);
									
									if($bx != 0)
									{
										$bx_qty = $crt_qty / $ib;
															
										$whole = floor($bx_qty);
										$fraction = $bx_qty - $whole;					
										
										// BX
										$up_bx = "UPDATE tbl_product SET bx_qty = bx_qty - '$whole', bx_price = {$cartContent[$i]['ct_price']} WHERE pd_id = '$crt_pid'";
										dbQuery($up_bx);
									}else{}
																
								}else{}
							}
							else
							{ 
								$tp = "pc"; 
								$bx = $rw_qw['bx_formula'];
								$ib = $rw_qw['ib_formula'];
								$pc = $rw_qw['pc_formula'];
								$prc = $rw_qw['pc_price'];
								$cost = $rw_qw['pd_cost'];
								
								if($crt_qty != 0)
								{						
							
									// PC
									$up_pc = "UPDATE tbl_product SET pc_qty = pc_qty - '$crt_qty', pc_price = {$cartContent[$i]['ct_price']} WHERE pd_id = '$crt_pid'";
									dbQuery($up_pc);
									
									if($ib != 0)
									{
										$ib_qty = $crt_qty / $pc;
										$whole_ib = floor($ib_qty);
										$fraction_ib = $ib_qty - $whole_ib;
										
										// IB
										$up_ib = "UPDATE tbl_product SET ib_qty = ib_qty - '$whole_ib', ib_price = {$cartContent[$i]['ct_price']} WHERE pd_id = '$crt_pid'";
										dbQuery($up_ib);													
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
										$up_bx = "UPDATE tbl_product SET bx_qty = bx_qty - '$whole_bx', bx_price = {$cartContent[$i]['ct_price']} WHERE pd_id = '$crt_pid'";
										dbQuery($up_bx);
									}else{}
								}
							}
					}
			}*/
			
			
			// then remove the ordered items from cart
			for ($i = 0; $i < $numItem; $i++) {
				$sql = $conn->prepare("DELETE FROM tbl_cart_return
				        WHERE ct_id = {$cartContent[$i]['ct_id']}");
				$sql->execute();				
			}							
		
	
	//return $orderId;
	
		echo "<center><h3>Processing...</h3><img src='../images/loader/loader_3.gif'><center>";
		$url = "index.php";
		echo "<meta http-equiv=\"refresh\" content=\"1;URL=$url\">";
	
}


/*
Email : testme@phpwebcommerce.com 
Password : phpwebco
348640028
348640691
*/

?>