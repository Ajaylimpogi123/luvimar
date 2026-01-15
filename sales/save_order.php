<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';
require_once '../global-library/cart-functions.php';
require_once '../global-library/api.php'; // Import sendSMS function

checkUser();

$userId = $_SESSION['user_id'];

$drnum = date("mdy-hi", strtotime($today_date1));

include '../global-library/database.php';
//$cartContent = getCartContent();
//$numItem     = count($cartContent);

$sql1 = $conn->prepare("SELECT * FROM tbl_category c, tbl_product p, tbl_cart ct WHERE c.cat_id = p.cat_id AND p.pd_id = ct.pd_id AND ct.is_type != '0'");
$sql1->execute();

// save order & get order id
// $sql = $conn->prepare("INSERT INTO tbl_order(cust_id, invoice_num, dr_num, po_num, person_received, terms_in_days, customer_name, od_amount_due, od_discount, percent_discount, od_total_amt_due, od_cost, od_payment, od_change, dc_id, od_date, od_date_1, od_paid_date, date_due, delivery_date, delivery_address, driver, is_delivery, is_paid, is_charge, released_by, remarks)
// 									VALUES ('$custid', '$ordernum', '$drnum', '$ponum', '$recby', '$tidays', '$custname', '$amtdue', '$disc', '$perdisc', '$total_due', '$cost', '$payment', '$total_change', '$discId', '$today_date1', '$today_date2', '$paiddate', '$newDate', '$deliverydate', '$deladd', '$driver', '$isdelivery', '$paid', '$charge', '$userId', '$remarks')");
// $sql->execute();

$sql = $conn->prepare("INSERT INTO tbl_order(cust_id, branch_id, invoice_num,  dr_num,  customer_name, payment_mode, transaction_code, od_amount_due, od_discount, percent_discount, od_total_amt_due, od_cost, od_payment, od_change, dc_id, od_date, od_date_1, od_paid_date, date_due,  is_paid, is_charge, released_by, remarks)
											VALUES ('$custid', '$brnId', '$ordernum', '$drnum', '$custname', '$pmode', '$transac','$amtdue', '$disc', '$perdisc', '$total_due', '$cost', '$payment', '$total_change', '$discId', '$today_date1', '$today_date2', '$paiddate', '$newDate',  '$paid', '$charge', '$userId', '$remarks')");
$sql->execute();

// get the order id
$orderId = $conn->lastInsertId();

if ($orderId) {
	for ($i = 0; $i < $sql1->rowCount(); $i++) {
		$sql1_data = $sql1->fetch();

		$qw = $conn->prepare("SELECT * FROM tbl_product WHERE pd_id = '$sql1_data[pd_id]'");
		$qw->execute();
		$qw_data = $qw->fetch();

		$crt_qty = $sql1_data['ct_qty'];
		$crt_pid = $sql1_data['pd_id'];
		$crt_cid = $sql1_data['ct_id'];
		$desc = $sql1_data['description'];
		$jdesc = $sql1_data['job_description'];

		if ($sql1_data['is_type'] == 3) {
			$tp = "bx";
			$bx = $qw_data['bx_formula'];
			$ib = $qw_data['ib_formula'];
			$pc = $qw_data['pc_formula'];
			$prc = $qw_data['bx_price'];
			$cost = $qw_data['pd_cost'];

			if ($crt_qty != 0) {
				// BX
				$up_bx = $conn->prepare("UPDATE tbl_product SET bx_qty = bx_qty - '$crt_qty' WHERE pd_id = '$crt_pid'");
				$up_bx->execute();

				$ib_qty = $crt_qty * $ib;

				// IB
				$up_ib = $conn->prepare("UPDATE tbl_product SET ib_qty = ib_qty - '$ib_qty' WHERE pd_id = '$crt_pid'");
				$up_ib->execute();

				$pc_qty = $ib_qty * $pc;

				// PC
				$up_pc = $conn->prepare("UPDATE tbl_product SET pc_qty = pc_qty - '$pc_qty' WHERE pd_id = '$crt_pid'");
				$up_pc->execute();

				$prd = $conn->prepare("SELECT * FROM tbl_product WHERE pd_id = '$crt_pid'");
				$prd->execute();
				$prd_data = $prd->fetch();
				$pdname = mysqli_real_escape_string($link, $prd_data['pd_name']);
				$bal_qty = $prd_data['bx_qty'];

				$sql = $conn->prepare("INSERT INTO tbl_order_item(od_id, pd_id, od_qty, od_price, od_cost, pd_qty_left, pd_type, branch_id)
									VALUES ($orderId, '$crt_pid', '$crt_qty', '$prc', '$cost', '$bal_qty', 'bx','$custid')");
				$sql->execute();

				// Graph Statistics
				$chk = $conn->prepare("SELECT * FROM tr_graph_product_current WHERE pd_id = '$crt_pid' AND pd_type = 'bx'");
				$chk->execute();
				if ($chk->rowCount() > 0) {
					$up = $conn->prepare("UPDATE tr_graph_product_current SET total_qty = total_qty + '$crt_qty', od_date = '$today_date2'
											WHERE pd_id = '$crt_pid' AND pd_type = 'bx'");
					$up->execute();
				} else {
					$in = $conn->prepare("INSERT INTO tr_graph_product_current (pd_id, pd_name, total_qty, od_date, pd_type) 
											VALUES ('$crt_pid', '$pdname', '$crt_qty', '$today_date2', 'bx')");
					$in->execute();
				}

				$sql7 = $conn->prepare("DELETE FROM tbl_cart WHERE ct_id = '$crt_cid'");
				$sql7->execute();
			} else {
			}
		} else if ($sql1_data['is_type'] == 2) {
			$tp = "ib";
			$bx = $qw_data['bx_formula'];
			$ib = $qw_data['ib_formula'];
			$pc = $qw_data['pc_formula'];
			$prc = $qw_data['ib_price'];
			$cost = $qw_data['pd_cost'];

			if ($crt_qty != 0) {
				// IB
				$up_ib = $conn->prepare("UPDATE tbl_product SET ib_qty = ib_qty - '$crt_qty' WHERE pd_id = '$crt_pid'");
				$up_ib->execute();

				$pc_qty = $crt_qty * $pc;

				// PC
				$up_pc = $conn->prepare("UPDATE tbl_product SET pc_qty = pc_qty - '$pc_qty' WHERE pd_id = '$crt_pid'");
				$up_pc->execute();

				if ($bx != 0) {
					$bx_qty = $crt_qty / $ib;

					$whole = floor($bx_qty);
					$fraction = $bx_qty - $whole;

					// BX
					$up_bx = $conn->prepare("UPDATE tbl_product SET bx_qty = bx_qty - '$whole' WHERE pd_id = '$crt_pid'");
					$up_bx->execute();
				} else {
				}

				$prd = $conn->prepare("SELECT * FROM tbl_product WHERE pd_id = '$crt_pid'");
				$prd->execute();
				$prd_data = $prd->fetch();
				$pdname = mysqli_real_escape_string($link, $prd_data['pd_name']);
				$bal_qty = $prd_data['ib_qty'];

				$sql = $conn->prepare("INSERT INTO tbl_order_item(od_id, pd_id, od_qty, od_price, od_cost, pd_qty_left, pd_type,branch_id)
										VALUES ($orderId, '$crt_pid', '$crt_qty', '$prc', '$cost', '$bal_qty', 'ib','$custid')");
				$sql->execute();

				// Graph Statistics
				$chk = $conn->prepare("SELECT * FROM tr_graph_product_current WHERE pd_id = '$crt_pid' AND pd_type = 'ib'");
				$chk->execute();
				if ($chk->rowCount() > 0) {
					$up = $conn->prepare("UPDATE tr_graph_product_current SET total_qty = total_qty + '$crt_qty', od_date = '$today_date2'
												WHERE pd_id = '$crt_pid' AND pd_type = 'ib'");
					$up->execute();
				} else {
					$in = $conn->prepare("INSERT INTO tr_graph_product_current (pd_id, pd_name, total_qty, od_date, pd_type) 
												VALUES ('$crt_pid', '$pdname', '$crt_qty', '$today_date2', 'ib')");
					$in->execute();
				}

				$sql7 = $conn->prepare("DELETE FROM tbl_cart WHERE ct_id = '$crt_cid'");
				$sql7->execute();
			} else {
			}
		} else {
			$tp = "pc";
			$bx = $qw_data['bx_formula'];
			$ib = $qw_data['ib_formula'];
			$pc = $qw_data['pc_formula'];
			$prc = $qw_data['pc_price'];
			$cost = $qw_data['pd_cost'];



			if ($crt_qty != 0) {
				// PC
				if (!empty($custid)) {

					$expiration = date("F j, Y", strtotime($today_date2 . ' +10 minutes'));

					$up_pc = $conn->prepare("UPDATE tbl_product SET pc_qty = pc_qty - '$crt_qty' , pd_expiration = '$expiration' WHERE pd_id = '$crt_pid'");
					$up_pc->execute();


					$sms = $conn->prepare("INSERT INTO tbl_sms(pd_id, cust_id, status, exp_date) VALUES ('$crt_pid', '$custid', 'pending', '$expiration')");
					$sms->execute();

					// No customer → update qty only
					// $up_pc = $conn->prepare("UPDATE tbl_product SET pc_qty = pc_qty - '$crt_qty' WHERE pd_id = '$crt_pid'");
					// $up_pc->execute();

					$prd = $conn->prepare("SELECT * FROM tbl_product WHERE pd_id = '$crt_pid'");
					$prd->execute();
					$prd_data = $prd->fetch();
					$pdname = mysqli_real_escape_string($link, $prd_data['pd_name']);
					$bal_qty = $prd_data['pc_qty'];

					$sql = $conn->prepare("INSERT INTO tbl_order_item(od_id, pd_id, cust_id, branch_id, od_qty, od_price, od_cost, pd_qty_left, pd_type, odi_description, odi_job_description)
											VALUES ($orderId, '$crt_pid', '$custid', '$brnId', '$crt_qty', '$prc', '$cost', '$bal_qty', 'pc', '$desc', '$jdesc')");
					$sql->execute();

					$chk = $conn->prepare("SELECT * FROM tr_graph_product_current WHERE pd_id = '$crt_pid' AND pd_type = 'pc'");
					$chk->execute();

					if ($chk->rowCount() > 0) {
						$up = $conn->prepare("UPDATE tr_graph_product_current SET total_qty = total_qty + '$crt_qty', od_date = '$today_date2'
												WHERE pd_id = '$crt_pid' AND pd_type = 'pc'");
						$up->execute();
					} else {
						$in = $conn->prepare("INSERT INTO tr_graph_product_current (pd_id, pd_name, total_qty, od_date, pd_type) 
												VALUES ('$crt_pid', '$pdname', '$crt_qty', '$today_date2', 'pc')");
						$in->execute();
					}

					$sql7 = $conn->prepare("DELETE FROM tbl_cart WHERE ct_id = '$crt_cid'");
					$sql7->execute();
				} else {
					// No customer → update qty only
					$up_pc = $conn->prepare("UPDATE tbl_product SET pc_qty = pc_qty - '$crt_qty' WHERE pd_id = '$crt_pid'");
					$up_pc->execute();

					$prd = $conn->prepare("SELECT * FROM tbl_product WHERE pd_id = '$crt_pid'");
					$prd->execute();
					$prd_data = $prd->fetch();
					$pdname = mysqli_real_escape_string($link, $prd_data['pd_name']);
					$bal_qty = $prd_data['pc_qty'];

					$sql = $conn->prepare("INSERT INTO tbl_order_item(od_id, pd_id, cust_id, branch_id, od_qty, od_price, od_cost, pd_qty_left, pd_type, odi_description, odi_job_description)
											VALUES ($orderId, '$crt_pid', '$custid', '$brnId', '$crt_qty', '$prc', '$cost', '$bal_qty', 'pc', '$desc', '$jdesc')");
					$sql->execute();

					$chk = $conn->prepare("SELECT * FROM tr_graph_product_current WHERE pd_id = '$crt_pid' AND pd_type = 'pc'");
					$chk->execute();

					if ($chk->rowCount() > 0) {
						$up = $conn->prepare("UPDATE tr_graph_product_current SET total_qty = total_qty + '$crt_qty', od_date = '$today_date2'
												WHERE pd_id = '$crt_pid' AND pd_type = 'pc'");
						$up->execute();
					} else {
						$in = $conn->prepare("INSERT INTO tr_graph_product_current (pd_id, pd_name, total_qty, od_date, pd_type) 
												VALUES ('$crt_pid', '$pdname', '$crt_qty', '$today_date2', 'pc')");
						$in->execute();
					}

					$sql7 = $conn->prepare("DELETE FROM tbl_cart WHERE ct_id = '$crt_cid'");
					$sql7->execute();
				}
			}
		}

		//echo $cartContent[$i]['ct_qty'] . '-' . $tp . '-' . $fr . '<br />';

	}
} else {
}
