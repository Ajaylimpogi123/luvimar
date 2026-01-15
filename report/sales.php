<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

$userId = $_SESSION['user_id'];

$dfrom = $_POST['from'];
$dto = $_POST['to'];
$stype = $_POST['stype'];
$rmk = $_POST['rmk'];
$branch = $_POST['branch'];
$din1 = $_POST['din1'];
$din2 = $_POST['din2'];
$dout1 = $_POST['dout1'];
$dout2 = $_POST['dout2'];

if ($branch == "db_luvimar") {
	$branchname = "Terra Plaza, Cor. Rizal - Gatualas Sts., Bacolod City
";
	$img = "main.png";
} else {
	$branchname = "Bacolod Branch";
	$img = "main.png";
}

if ($stype == 0) {
	$typ_state = "";
} else if ($stype == 'Cash') {
	$typ_state = "AND payment_mode = 'Cash'";
} else {
	$typ_state = "AND payment_mode = 'Gcash'";
}

if ($rmk == 0) {
	$rmk_state = "";
} else {
	$rmk_state = "AND remarks != ''";
}

# Format Date to match date in db
$newfrom = date("Y-m-d", strtotime($dfrom));
$newto = date("Y-m-d", strtotime($dto));
# Format Date to words
$wfrom = date("M d, Y", strtotime($dfrom));
$wto = date("M d, Y", strtotime($dto));

$from_in = $din1 . ':' . $din2 . ':00';
$to_out = $dout1 . ':' . $dout2 . ':00';

$nfrom = $newfrom . ' ' . $from_in;
$nto = $newto . ' ' . $to_out;

$new_from = date("Y-m-d h:i:00", strtotime($nfrom));
$new_to = date("Y-m-d h:i:00", strtotime($nto));

$tfrom = ' - ' . date("h:i a", strtotime($from_in));
$tto = ' - ' . date("h:i a", strtotime($to_out));

if ($din1 != 00 || $dout1 != 00) {
	$t_from = $tfrom;
	$t_to = $tto;
	$oddate = "od_date";
	$from = $new_from;
	$to = $new_to;
} else {
	$t_from = "";
	$t_to = "";
	$oddate = "od_date_1";
	$from = $newfrom;
	$to = $newto;
}

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>

<head>
	<title>Sales Report</title>
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
		<td><img src="<?php echo WEB_ROOT; ?>images/branch_logo/<?php echo $img; ?>" style="height: 80px; width:160px;" /></td>
		<td>&nbsp; &nbsp;</td>
		<td>
			<h3>Sales Report</h3>
			<h4><?php echo $wfrom; ?><?php echo $t_from; ?> to <?php echo $wto; ?><?php echo $t_to; ?></h4>

			<h4>Terra Plaza, Cor. Rizal - Gatualas Sts., Bacolod City
			</h4>
		</td>
	</tr>
	<table>
		<br />
		<table style="margin:auto;">
			<tr>
				<td>
					<table style="padding:7px;" border="0">
						<!--<tr colspan="21">
				<td>
					<form method="post" action="sales_print.php">
						<input type="hidden" name="from" value="<?php echo $dfrom; ?>" />
						<input type="hidden" name="to" value="<?php echo $dto; ?>" />
						<input type="submit" name="submit" value="Print" style="background:#66ff33; border:solid 1px #000000;" />
					</form>
				</td>
			</tr>!-->
						<tr>
							<td class="tdlabel">#</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Date Released</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Customer</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Payment Mode</td>
							<td width="20px;">&nbsp;</td>

							<td class="tdlabel">Discount</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel" valign="top">
								<table border="0">
									<tr>
										<td class="tdlabel" width="170">Product</td>
										<td width="20px;">&nbsp;</td>
										<td class="tdlabel" width="40">Qty</td>
										<td width="20px;">&nbsp;</td>
										<td class="tdlabel" width="70">Price</td>
										<td width="20px;">&nbsp;</td>
										<td class="tdlabel" width="70" style="text-align:right;">Total</td>
									</tr>
								</table>
							</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Released By</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">OR #</td>
						</tr>
						<tr>
							<td colspan="15">
								<hr color='black' />
							</td>
						</tr>
						<tbody>
							<?php
							$emp = $conn->prepare("SELECT * FROM $branch.tbl_order
													WHERE ($oddate BETWEEN '$from' and '$to') $typ_state $rmk_state AND is_deleted != '1'																
														ORDER BY $oddate");
							$emp->execute();
							if ($emp->rowCount() > 0) {
								$ctr1 = 1;
								$total = 0;
								$total_discount = 0;
								$grand_total = 0;
								while ($emp_data = $emp->fetch()) {
									$fullname = utf8_encode(ucwords(strtolower($emp_data['customer_name'])));
									$datereleased = date("M d, Y | h:i a", strtotime($emp_data['od_date']));

									$rby = $conn->prepare("SELECT * FROM $branch.bs_user WHERE user_id = '$emp_data[released_by]'");
									$rby->execute();

									if ($rby->rowCount() > 0) {
										$rby_data = $rby->fetch();
										$released_by = utf8_encode(ucwords(strtolower($rby_data['lastname']))) . ',&nbsp;' . ucwords(strtolower($rby_data['firstname']));
									} else {
										$released_by = '- -';
									}
									$grand_total += $emp_data['od_total_amt_due'];
							?>
									<tr>
										<td class="tddata" valign="top"><?php echo $ctr1++; ?>. </td>
										<td width="20px;">&nbsp;</td>
										<td class="tddata" valign="top"><?php echo $datereleased; ?></td>
										<td width="20px;">&nbsp;</td>
										<td class="tddata" valign="top"><?php echo $fullname; ?></td>
										<td width="20px;">&nbsp;</td>
										<td class="tddata" valign="top"><?php echo $emp_data['payment_mode']; ?></td>
										<td width="20px;">&nbsp;</td>

										<td class="tddata" valign="top">&#x20B1;<?php echo number_format($emp_data['od_discount'], 2); ?> | <?php echo number_format($emp_data['percent_discount'], 0); ?>%</td>
										<td width="20px;">&nbsp;</td>
										<td class="tddata" valign="top">
											<table border="0">
												<?php
												$lst = $conn->prepare("SELECT * FROM $branch.tbl_order_item i, $branch.tbl_product p
																				WHERE i.od_id = '$emp_data[od_id]' AND i.pd_id = p.pd_id");
												$lst->execute();
												if ($lst->rowCount() > 0) {
													$total_amount = 0;
													while ($lst_data = $lst->fetch()) {
														$total_amt_due = $lst_data['od_qty'] * $lst_data['od_price'];
														$total_amount += $total_amt_due;
												?>
														<tr>
															<td class="tddata" valign="top" width="170"><?php echo $lst_data['pd_name']; ?></td>
															<td width="20px;">&nbsp;</td>
															<td class="tddata" valign="top" width="40"><?php echo $lst_data['od_qty']; ?> <?php echo $lst_data['pd_type']; ?></td>
															<td width="20px;">&nbsp;</td>
															<td class="tddata" valign="top" width="70"><?php echo number_format($lst_data['od_price'], 2); ?></td>
															<td width="20px;">&nbsp;</td>
															<td class="tddata" valign="top" width="70" style="text-align:right;"><?php echo number_format($total_amt_due, 2); ?></td>
														</tr>
													<?php
													} // End While
													?>
													<tr>
														<?php if ($rmk == 0) {
														} else { ?>
															<td colspan="4" style="padding-left:17px; font-size:12px; color:#339900;">*<?php echo $lst_data['remarks']; ?>*</td>
														<?php } ?>
														<td colspan="7" class="tddata" style="text-align:right;"><b>&#x20B1; <?php echo number_format($emp_data['od_total_amt_due'], 2); ?></b><br /><br /></td>
													</tr>
												<?php
												} else {
												}
												?>
											</table>
										</td>
										<td width="20px;">&nbsp;</td>
										<td class="tddata" valign="top"><?php echo $released_by; ?></td>
										<td width="20px;">&nbsp;</td>
										<td class="tddata" valign="top"><?php echo $emp_data['invoice_num']; ?></td>
									</tr>
								<?php
								} // End While
								?>
								<tr>
									<td colspan="15">
										<hr color='black' />
									</td>
								</tr>
								<tr>
									<td colspan="13" class="tddata" style="text-align:right;"><b>&#x20B1; <?php echo number_format($grand_total, 2); ?></b><br /></td>
								</tr>
								<tr style="border-top: 1px;">
									<td colspan="15" align="center">*** Nothing Follows ***</td>
								</tr>
							<?php
							} else {
							}
							?>
						</tbody>
					</table>
				</td>
			</tr>
		</table>