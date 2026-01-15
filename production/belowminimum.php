<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

$userId = $_SESSION['user_id'];

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>

<head>
	<title>Product Report</title>
	<link rel="shortcut icon" href="<?php echo WEB_ROOT; ?>images/favicon.ico">
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
		<td><img src="<?php echo WEB_ROOT; ?>images/logo.png" /></td>
		<td>&nbsp; &nbsp;</td>
		<td>
			<h3>Product Below Minimum Qty</h3>
		</td>
	</tr>
	<table>
		<br />
		<table style="margin:auto;">
			<tr>
				<td>
					<table style="padding:7px;" border="0">
						<tr>
							<td class="tdlabel">#</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Product Name</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Brand</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Qty Left</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Minimum Qty</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Price</td>
						</tr>
						<tr>
							<td colspan="15">
								<hr color='black' />
							</td>
						</tr>
						<tbody>
							<?php
							$emp = $conn->prepare("SELECT * FROM tbl_product p, tbl_category c
													WHERE p.cat_id = c.cat_id ANd p.pc_qty < p.pd_mqty AND p.is_deleted != '1'
																	ORDER BY p.pd_name");
							$emp->execute();
							if ($emp->rowCount() > 0) {
								$ctr1 = 1;
								while ($emp_data = $emp->fetch()) {
							?>
									<tr>
										<td class="tddata" valign="top"><?php echo $ctr1++; ?>. </td>
										<td width="20px;">&nbsp;</td>
										<td class="tddata" valign="top"><?php echo $emp_data['pd_name']; ?></td>
										<td width="20px;">&nbsp;</td>
										<td class="tddata" valign="top"><?php echo $emp_data['cat_name']; ?></td>
										<td width="20px;">&nbsp;</td>
										<td class="tddata" valign="top" align="center"><?php echo $emp_data['pc_qty']; ?></td>
										<td width="20px;">&nbsp;</td>
										<td class="tddata" valign="top" align="center"><?php echo $emp_data['pd_mqty']; ?></td>
										<td width="20px;">&nbsp;</td>
										<td class="tddata" valign="top">Php <?php echo number_format($emp_data['pc_price'], 2); ?></td>
									</tr>
								<?php
								} // End While
								?>
								<tr>
									<td colspan="11">
										<hr color='black' />
									</td>
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
					</div>
					</div><!--/span-->
					</div><!--/row-->