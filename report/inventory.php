<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

$userId = $_SESSION['user_id'];

$branch = $_POST['branch'];
$product = $_POST['product'];

if ($branch == "db_luvimar") {
	$branchname = "Bacolod Branch";
	$img = "main.png";
} else {
	$branchname = "Bacolod Branch";
	$img = "main.png";
}

if ($product != 0) {
	$cus1 = $conn->prepare("SELECT * FROM $branch.tbl_product WHERE pd_parent_id  = '$product'");
	$cus1->execute();
	$cust1_data = $cus1->fetch();
	$cust_state = "AND pd_parent_id  = '$product'";
	$cust_label = $cust1_data['pd_name'];
} else {
	$cust_state = "";
	$cust_label = "All";
}

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>

<head>
	<title>Inventory Product Report</title>
	<link rel="shortcut icon" href="<?php echo WEB_ROOT; ?>images/favicon.png">
	<style rel="stylesheet">
		.tdlabel {
			color: #000 !important;
			font-family: Arial !important;
			font-weight: bold;
			font-size: 14px;
			text-align: center;
		}

		.tddata {
			color: #000 !important;
			font-family: Arial !important;
			font-size: 13px;
			border: solid 1px #000000;
			width: 37px;
			height: 37px;
			padding: 7px;
		}

		.tddata7 {
			color: #000 !important;
			font-family: Arial !important;
			font-size: 13px;
			border: solid 0px #000000;
		}
	</style>
</head>
<table style="margin:auto;">
	<tr>
		<td><img src="<?php echo WEB_ROOT; ?>images/branch_logo/<?php echo $img; ?>" style="height: 80px; width:160px;" /></td>
		<td>&nbsp; &nbsp;</td>
		<td>
			<h3>Inventory Product Report - <?php echo $cust_label; ?></h3>
			<h4><?php echo $branchname; ?></h4>
		</td>
	</tr>
	<table>
		<br />
		<table style="margin:auto;">
			<tr>
				<td>
					<table style="padding:17px;">
						<tr>
							<td style="background:#000000; color:#ffffff; text-align:center;">Product</td>
							<td width="20px;">&nbsp;</td>
							<td colspan="2" style="background:#000000; color:#ffffff; text-align:center;">Qty Left</td>
							<td width="20px;">&nbsp;</td>
							<td colspan="2" style="background:#000000; color:#ffffff; text-align:center;">Actual</td>
						</tr>
						<tr>
							<td colspan="13"><br /></td>
						</tr>
						<tr>
							<td class="tdlabel">Name</td>
							<td width="20px;">&nbsp;</td>

							<td class="tdlabel">PC</td>
							<td width="20px;">&nbsp;</td>
							<td width="20px;">&nbsp;</td>

							<td class="tdlabel">PC</td>
						</tr>
						<tr>
							<td colspan="13">
								<hr color='black' />
							</td>
						</tr>
						<tbody>
							<?php
							$emp = $conn->prepare("SELECT * FROM $branch.tbl_product
													WHERE is_deleted != '1' $cust_state
														ORDER BY pd_name");
							$emp->execute();
							if ($emp->rowCount() > 0) {
								$ctr1 = 1;
								$total_prc_pc = 0;
								$total_prc_ib = 0;
								$total_prc_bx = 0;
								while ($emp_data = $emp->fetch()) {
									$tpc = $emp_data['pc_qty'] * $emp_data['pc_price'];
									$total_prc_pc += $tpc;

									$tib = $emp_data['ib_qty'] * $emp_data['ib_price'];
									$total_prc_ib += $tib;

									$tbx = $emp_data['bx_qty'] * $emp_data['bx_price'];
									$total_prc_bx += $tbx;
							?>
									<tr>
										<td class="tddata7" valign="top"><?php echo $ctr1++; ?>. <?php echo $emp_data['pd_name']; ?></td>
										<td width="20px;">&nbsp;</td>

										<td class="tddata" valign="top"><?php echo number_format($emp_data['pc_qty'], 0); ?></td>
										<td width="20px;">&nbsp;</td>
										<td width="20px;">&nbsp;</td>
										<td class="tddata" valign="top"></td>
										<td width="20px;">&nbsp;</td>

									</tr>
							<?php
								} // End While
							} else {
							}
							?>
							<tr>
								<td colspan="17">
									<hr color='black' />
								</td>
							</tr>

							<tr style="border-top: 1px;">
								<td colspan="13" align="center">*** Nothing Follows ***</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</table>