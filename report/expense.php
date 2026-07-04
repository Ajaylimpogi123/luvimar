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

$ecId = $_POST['ec_id'];
if($ecId != 0){
    $exp = $conn->prepare("SELECT * FROM tr_expense_category WHERE is_deleted != '1'");
    $exp->execute();
    $exp_data = $exp->fetch();
    $exp_state = "AND exp.ec_id = '$ecId'";
    $exp_label = $exp_data['expense_category_name'];
}else{
    $exp_state = "";
    $exp_label = "All";
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
			<h3>Expense Report - <strong><?php echo $exp_label?></strong></h3>
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
							<td class="tdlabel">Expense Name</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Amount</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Details</td>
							<td width="20px;">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="8">
								<hr color='black' />
							</td>
						</tr>
						<tbody>
							<?php
							$emp = $conn->prepare("SELECT * FROM tr_expense exp, tr_expense_category exp_cat
													WHERE exp.ec_id = exp_cat.ec_id
															AND (exp.exp_date_added BETWEEN '$newfrom' and '$newto') $exp_state AND exp.is_deleted != '1'
																	ORDER BY exp.exp_date_added");
							$emp->execute();
							if ($emp->rowCount() > 0) {
								$ctr1 = 1;
								$total_amount = 0;
								
								while ($emp_data = $emp->fetch()) {
						
						
									$total_amount += $emp_data['amount'];
								
							?>
									<tr>
										<td class="tddata" valign="top"><?php echo $ctr1++; ?>. </td>
										<td width="20px;">&nbsp;</td>
										<td class="tddata" valign="top"><?php echo $emp_data['expense_category_name']; ?></td>
										<td width="20px;">&nbsp;</td>
										<td class="tddata" valign="top"><?php echo $emp_data['amount']; ?></td>
										<td width="20px;">&nbsp;</td>
										<td class="tddata" valign="top"><?php echo $emp_data['details']; ?></td>
										<td width="20px;">&nbsp;</td>

									</tr>
							<?php
								} // End While
							} else {
								$total_amount = 0;
							
							}
							?>
							<tr>
								<td colspan="8">
									<hr color='black' />
								</td>
							</tr>
							<tr>
								<td colspan="2"></td>
								<td><b>Total:</b></td>
								<td></td>
								<td class="tddata"><b><?php echo number_format($total_amount, 0); ?></b></td>
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