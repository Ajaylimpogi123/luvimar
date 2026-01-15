<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';
require_once '../global-library/cart-functions.php';

checkUser();

$userId = $_SESSION['user_id'];


	$cartContent = getCartContent();
	$numItem     = count($cartContent);
		
		// save order & get order id
		$sql = "INSERT INTO tbl_order(cust_id, invoice_num, po_num, person_received, terms_in_days, customer_name, od_amount_due, od_discount, percent_discount, od_total_amt_due, od_cost, od_payment, od_change, dc_id, od_date, od_date_1, od_paid_date, date_due, delivery_date, delivery_address, driver, is_delivery, is_paid, is_charge, is_foodpanda, released_by)
				VALUES ('$custid', '$ordernum', '$ponum', '$recby', '$tidays', '$custname', '$amtdue', '$disc', '$perdisc', '$total_due', '$cost', '$payment', '$total_change', '$discId', '$today_date1', '$today_date2', '$paiddate', '$newDate', '$deliverydate', '$deladd', '$driver', '$isdelivery', '$paid', '$charge', '$isfp', '$userId')";
		$result = dbQuery($sql);
		
		// get the order id
		$orderId = dbInsertId();
		
		if ($orderId) {
			// update product stock
			for ($i = 0; $i < $numItem; $i++) {
				$sql = "UPDATE tbl_product 
						SET pd_qty = pd_qty - {$cartContent[$i]['ct_qty']}
						WHERE pd_id = {$cartContent[$i]['pd_id']}";
				$result = dbQuery($sql);
			}
			
			// save order items
			for ($i = 0; $i < $numItem; $i++) {
				$prd = "SELECT * FROM tbl_product WHERE pd_id = {$cartContent[$i]['pd_id']}";
				$rs_prd = dbQuery($prd);
				$rw_prd = dbFetchAssoc($rs_prd);
				$pdname = mysql_real_escape_string($rw_prd['pd_name']);
				$bal_qty = $rw_prd['pd_qty'];
				$orgprice = $rw_prd['pd_price'];
			
				$sql = "INSERT INTO tbl_order_item(od_id, pd_id, od_qty, od_price, od_cost, pd_qty_left, org_price, is_foodpanda)
						VALUES ($orderId, {$cartContent[$i]['pd_id']}, {$cartContent[$i]['ct_qty']}, {$cartContent[$i]['ct_price']}, {$cartContent[$i]['ct_cost']}, '$bal_qty', '$orgprice', '$isfp')";
				$result = dbQuery($sql);	
				
				// Graph Statistics
				$chk = "SELECT * FROM tr_graph_product_current WHERE pd_id = {$cartContent[$i]['pd_id']}";
				$rs_chk = dbQuery($chk);
				$num_chk = dbNumRows($rs_chk);
				if($num_chk > 0)
				{
					$up = "UPDATE tr_graph_product_current SET total_qty = total_qty + {$cartContent[$i]['ct_qty']}, od_date = '$today_date2'
								WHERE pd_id = {$cartContent[$i]['pd_id']}";
					dbQuery($up);
				}else{
					$in = "INSERT INTO tr_graph_product_current (pd_id, pd_name, total_qty, od_date) 
								VALUES ({$cartContent[$i]['pd_id']}, '$pdname', {$cartContent[$i]['ct_qty']}, '$today_date2')";
					dbQuery($in);
				}
			}								
						
			// then remove the ordered items from cart
			for ($i = 0; $i < $numItem; $i++) {
				$sql = "DELETE FROM tbl_cart
						WHERE ct_id = {$cartContent[$i]['ct_id']}";
				$result = dbQuery($sql);					
			}							
		}
	
	//return $orderId;
	
		/*echo "<center><h3>Processing...</h3><img src='../images/loader/loader_3.gif'><center>";
		$url = "../index.php";
		echo "<meta http-equiv=\"refresh\" content=\"1;URL=$url\">";*/
	
	
?>