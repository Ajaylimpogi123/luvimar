<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

$userId = $_SESSION['user_id'];

$dfrom = $_POST['from'];
$dto = $_POST['to'];

# Format Date to match date in db
$newfrom = date("Y-m-d", strtotime($dfrom));
$newto = date("Y-m-d", strtotime($dto));
# Format Date to words
$wfrom = date("M d, Y", strtotime($dfrom));
$wto = date("M d, Y", strtotime($dto));

$product = $_POST['product'];
if ($product != 0) {
	$cus1 = $conn->prepare("SELECT * FROM tbl_product WHERE pd_id = '$product'");
	$cus1->execute();
	$cus1_data = $cus1->fetch();
	$cust_state = "AND oi.pd_id = '$product'";
	$cust_label = $cus1_data['pd_name'];
} else {
	$cust_state = "";
	$cust_label = "All";
}


$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>

<head>
	<title>Released Product Report</title>
	<link rel="shortcut icon" href="<?php echo WEB_ROOT; ?>images/favicon.png">
	<style rel="stylesheet">
		.tdlabel {
			color: #000 !important;
			font-family: Arial !important;
			font-weight: bold;
			font-size: 14px;
		}

		.tddata {
			color: #000 !important;
			font-family: Arial !important;
			font-size: 13px;
		}
	</style>
</head>
<table style="margin:auto;">
	<tr>
		<td><img src="<?php echo WEB_ROOT; ?>images/branch_logo/main.png" style="height: 80px; width:160px;" /></td>
		<td>&nbsp; &nbsp;</td>
		<td>
			<h3>Released Product Report</h3>
			<h4><?php echo $wfrom; ?> to <?php echo $wto; ?></h4>
		</td>
	</tr>
	<table>
		<br />
		<table style="margin:auto;">
			<tr>
				<td>
					<table style="padding:7px;">
						<tr>
							<td class="tdlabel">#</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Date Released</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Customer</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Product</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Qty</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Balance</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Released By</td>
						</tr>
						<tr>
							<td colspan="13">
								<hr color='black' />
							</td>
						</tr>
						<tbody>
							<?php
							$emp = $conn->prepare("SELECT * FROM tbl_order o, tbl_order_item oi, tbl_product p
													WHERE o.od_id = oi.od_id AND oi.pd_id = p.pd_id
															AND (o.od_date_1 BETWEEN '$newfrom' and '$newto') $cust_state AND o.is_deleted != '1'
																	ORDER BY o.od_date_1");
							$emp->execute();
							if ($emp->rowCount() > 0) {
								$ctr1 = 1;
								$total_qty = 0;
								$total_bal = 0;
								while ($emp_data = $emp->fetch()) {
									$fullname = utf8_encode(ucwords(strtolower($emp_data['customer_name'])));
									$datereleased = date("M d, Y | h:i a", strtotime($emp_data['od_date']));

									$rby = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$emp_data[released_by]'");
									$rby->execute();

									if ($rby->rowCount() > 0) {
										$rby_data = $rby->fetch();
										$released_by = utf8_encode(ucwords(strtolower($rby_data['lastname']))) . ',&nbsp;' . ucwords(strtolower($rby_data['firstname']));
									} else {
										$released_by = '- -';
									}

									$balance = $emp_data['pd_qty'] - $emp_data['od_qty'];
									$total_qty += $emp_data['od_qty'];
									$total_bal += $emp_data['pd_qty_left'];
							?>
									<tr>
										<td class="tddata" valign="top"><?php echo $ctr1++; ?>. </td>
										<td width="20px;">&nbsp;</td>
										<td class="tddata" valign="top"><?php echo $datereleased; ?></td>
										<td width="20px;">&nbsp;</td>
										<td class="tddata" valign="top"><?php echo $fullname; ?></td>
										<td width="20px;">&nbsp;</td>
										<td class="tddata" valign="top"><?php echo $emp_data['pd_name']; ?></td>
										<td width="20px;">&nbsp;</td>
										<td class="tddata" valign="top"><?php echo number_format($emp_data['od_qty'], 0); ?></td>
										<td width="20px;">&nbsp;</td>
										<td class="tddata" valign="top"><?php echo number_format($emp_data['pd_qty_left'], 0); ?></td>
										<td width="20px;">&nbsp;</td>
										<td class="tddata" valign="top"><?php echo $released_by; ?></td>
									</tr>
							<?php
								} // End While
							} else {
								$total_qty = 0;
								$total_bal = 0;
							}
							?>
							<tr>
								<td colspan="13">
									<hr color='black' />
								</td>
							</tr>
							<tr>
								<td colspan="6"></td>
								<td><b>Total:</b></td>
								<td></td>
								<td class="tddata"><b><?php echo number_format($total_qty, 0); ?></b></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td><br /></td>
							</tr>
							<tr style="border-top: 1px;">
								<td colspan="13" align="center">*** Nothing Follows ***</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</table>