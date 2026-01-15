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


$supplier = $_POST['supplier'];
if ($supplier != 0) {
	$cus1 = $conn->prepare("SELECT * FROM bs_supplier WHERE sup_id = '$supplier'");
	$cus1->execute();
	$cus1_data = $cus1->fetch();
	$cust_state = "AND sup_id = '$supplier'";
	$cust_label = $cus1_data['company_name'];
} else {
	$cust_state = "";
	$cust_label = "All";
}


$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>

<head>
	<title>Received Product Report</title>
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
			<h3>Received Product Report</h3>
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
							<td class="tdlabel">Date Received</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel" valign="top">
								<table border="0">
									<tr>
										<td class="tdlabel" width="170">Product</td>
										<td width="20px;">&nbsp;</td>
										<td class="tdlabel" width="40">Qty Received</td>
									</tr>
								</table>
							</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Received By</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Supplier</td>
						</tr>
						<tr>
							<td colspan="9">
								<hr color='black' />
							</td>
						</tr>
						<tbody>
							<?php
							$emp = $conn->prepare("SELECT * FROM tbl_received
													WHERE (date_added_ymd BETWEEN '$newfrom' and '$newto') AND is_deleted != '1' $cust_state
																	ORDER BY date_added_ymd");
							$emp->execute();
							if ($emp->rowCount() > 0) {
								$ctr1 = 1;
								while ($emp_data = $emp->fetch()) {
									$datereceived = date("M d, Y | h:i A", strtotime($emp_data['date_added']));

									$rby = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$emp_data[added_by]'");
									$rby->execute();
									if ($rby->rowCount() > 0) {
										$rby_data = $rby->fetch();
										$received_by = utf8_encode(ucwords(strtolower($rby_data['lastname']))) . ',&nbsp;' . ucwords(strtolower($rby_data['firstname']));
									} else {
										$received_by = '- -';
									}

									$s7 = $conn->prepare("SELECT * FROM bs_supplier WHERE sup_id = '$emp_data[sup_id]'");
									$s7->execute();
									if ($s7->rowCount() > 0) {
										$s7_data = $s7->fetch();
										$company_name = utf8_encode(ucwords(strtolower($s7_data['company_name'])));
									} else {
										$company_name = '- -';
									}
							?>
									<tr>
										<td class="tddata" valign="top"><?php echo $ctr1++; ?>. </td>
										<td width="20px;">&nbsp;</td>
										<td class="tddata" valign="top"><?php echo $datereceived; ?></td>
										<td width="20px;">&nbsp;</td>
										<td class="tddata" valign="top">
											<table border="0">
												<?php
												$lst = $conn->prepare("SELECT * FROM tbl_received_item i, tbl_product p
																				WHERE i.rec_id = '$emp_data[rec_id]' AND i.pd_id = p.pd_id AND i.is_deleted != '1'");
												$lst->execute();
												if ($lst->rowCount() > 0) {
													$total_amount = 0;
													while ($lst_data = $lst->fetch()) {
														if ($lst_data['pd_type'] == 'pc') {
															$tp = 'PC';
														} else if ($lst_data['pd_type'] == 'ib') {
															$tp = 'BX';
														} else {
															$tp = 'CS';
														}
												?>
														<tr>
															<td class="tddata" valign="top" width="170"><?php echo $lst_data['pd_name']; ?></td>
															<td width="20px;">&nbsp;</td>
															<td class="tddata" valign="top" width="40"><?php echo $lst_data['od_qty_added']; ?> <?php echo $tp; ?></td>
														</tr>
												<?php
													} // End While

												} else {
												}
												?>
											</table>
										</td>
										<td width="20px;">&nbsp;</td>
										<td class="tddata" valign="top"><?php echo $received_by; ?></td>
										<td width="20px;">&nbsp;</td>
										<td class="tddata" valign="top"><?php echo $company_name; ?></td>
									</tr>
							<?php
								} // End While
							} else {
							}
							?>
							<tr>
								<td colspan="9">
									<hr color='black' />
								</td>
							</tr>
							<tr style="border-top: 1px;">
								<td colspan="9" align="center">*** Nothing Follows ***</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</table>