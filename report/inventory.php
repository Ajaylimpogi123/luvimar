<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

$userId = $_SESSION['user_id'];

$branch  = $_POST['branch'];
$product = $_POST['product'];
$cat_id  = $_POST['cat'];

if ($branch == "db_luvimar") {
	$branchname = "Bacolod Branch";
	$img = "main.png";
} else {
	$branchname = "other branch";
	$img = "main.png";
}

if ($product != 0) {
	$cus1 = $conn->prepare("SELECT * FROM $branch.tbl_product WHERE cat_parent_id = '$product' AND is_deleted != '1'");
	$cus1->execute();
	$cust1_data = $cus1->fetch();
	$cust_state = "AND p.cat_parent_id = '$product'";
	$cust_label = $cust1_data['pd_name'] ?? 'All';
} else {
	$cust_state = "";
	$cust_label = "All";
}

if ($cat_id != 0) {
	$cat = $conn->prepare("SELECT * FROM $branch.tbl_category WHERE cat_id = '$cat_id' AND is_deleted != '1'");
	$cat->execute();
	$cat_data = $cat->fetch();
	$cat_label = $cat_data['cat_name'] ?? 'All';

	// Products are tagged with the CHILD category id, not the parent.
	// So when a parent category is selected, pull in its child cat_ids too.
	$catChildren = $conn->prepare("SELECT cat_id FROM $branch.tbl_category 
									WHERE (cat_id = '$cat_id' OR cat_parent_id = '$cat_id') 
									AND is_deleted != '1'");
	$catChildren->execute();
	$catIds = $catChildren->fetchAll(PDO::FETCH_COLUMN);

	if (count($catIds) > 0) {
		$catIdsEscaped = implode(',', array_map('intval', $catIds)); // safe since these are ints
		$cat_state = "AND p.cat_id IN ($catIdsEscaped)";
	} else {
		$cat_state = "AND p.cat_id = '$cat_id'";
	}
} else {
	$cat_state = "";
	$cat_label = "All";
}

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';
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
		<td><?php echo $cat_label; ?></td>
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
							<td  style="background:#000000; color:#ffffff; text-align:center;">Serial #</td>
							<td width="20px;">&nbsp;</td>
							<td  style="background:#000000; color:#ffffff; text-align:center;">Category</td>
							<td width="20px;">&nbsp;</td>
							<td  style="background:#000000; color:#ffffff; text-align:center;">Qty Left</td>


						</tr>
						<tr>
							<td colspan="13"><br /></td>
						</tr>
						<tr>
							<td class="tdlabel">Name</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Serial #</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Category</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Qty</td>
							<td width="20px;">&nbsp;</td>


						</tr>
						<tr>
							<td colspan="13">
								<hr color='black' />
							</td>
						</tr>
						<tbody>
							<?php

							// if you want to group use this
							// GROUP BY pd_name

							$sql = "SELECT p.*, c.cat_name AS prod_cat_name
									FROM $branch.tbl_product p
									LEFT JOIN $branch.tbl_category c ON p.cat_id = c.cat_id
									WHERE p.is_deleted != '1' $cust_state $cat_state
									ORDER BY p.pd_name";

							$emp = $conn->prepare($sql);
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
										<td class="tddata7" valign="top"> <?php echo $emp_data['pd_barcode']; ?></td>
										<td width="20px;">&nbsp;</td>
										<td class="tddata7" valign="top"><?php echo $emp_data['prod_cat_name'] ?? ''; ?></td>
										<td width="20px;">&nbsp;</td>
										<td class="tddata" valign="top"><?php echo number_format($emp_data['pc_qty'], 0); ?></td>
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