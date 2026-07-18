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
} else if($stype == 'collection') {
	$typ_state = "AND payment_mode = 'collection'";
} else {
	$typ_state = "AND payment_mode = '$stype'";
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
<!DOCTYPE html>
<html>
<head>
	<title>Sales Report</title>
	<link rel="shortcut icon" href="<?php echo WEB_ROOT; ?>images/favicon.png">
	<style>
		* {
			box-sizing: border-box;
			
		}

		body {
			font-family: Arial, Helvetica, sans-serif;
			color: #1a1a1a;
			margin: 0 20% 0 20%;
		
		}

		      .report-header {
            text-align: center;
            margin-bottom: 18px;
            border-bottom: 3px solid #000;
            padding-bottom: 14px;
        }


		.report-header img {
			height: 70px;
			width: 140px;
			object-fit: contain;
		}

		.report-header h3 {
			margin: 0 0 4px 0;
			font-size: 20px;
			letter-spacing: 0.5px;
		}

		.report-header h4 {
			margin: 2px 0;
			font-size: 13px;
			font-weight: normal;
			color: #444;
		}

		.order-block {
			margin-bottom: 14px;
			border: 1px solid #ddd;
			border-radius: 4px;
			overflow: hidden;
			page-break-inside: avoid;
		}

		.order-meta {
			display: flex;
			flex-wrap: wrap;
			gap: 4px 28px;
			align-items: baseline;
			padding: 10px 14px;
			background: #333333;
			color: #fff;
		}

		.order-meta .meta-item {
			font-size: 12.5px;
		}

		.order-meta .meta-item .lbl {
			color: #bbb;
			font-size: 11px;
			text-transform: uppercase;
			letter-spacing: 0.5px;
			display: block;
			margin-bottom: 1px;
		}

		.order-meta .meta-ref {
			font-size: 15px;
			font-weight: bold;
		}

		.item-table {
			width: 100%;
			border-collapse: collapse;
			font-size: 12.5px;
			table-layout: fixed;
		}

		.item-table th {
			background: #f0f1f3;
			text-align: left;
			font-size: 11px;
			text-transform: uppercase;
			letter-spacing: 0.5px;
			color: #555;
			padding: 6px 10px;
			border-bottom: 1px solid #ddd;
		}

		.item-table th.num,
		.item-table td.num {
			text-align: right;
		}

		.item-table th.center,
		.item-table td.center {
			text-align: center;
		}

		.item-table td {
			padding: 7px 10px;
			border-bottom: 1px solid #f0f0f0;
			vertical-align: top;
		}

		.col-product  { width: 32%; }
		.col-serial   { width: 20%; }
		.col-qty      { width: 14%; }
		.col-price    { width: 17%; }
		.col-total    { width: 17%; }

		.no-items td {
			text-align: center;
			color: #999;
			font-style: italic;
			padding: 14px;
		}

		.order-summary {
			display: flex;
			justify-content: space-between;
			align-items: flex-end;
			gap: 16px;
			padding: 10px 14px;
			background: #fafafa;
			border-top: 1px solid #ddd;
		}

		.order-summary .left-notes {
			font-size: 11.5px;
			color: #555;
			line-height: 1.5;
		}

		.order-summary .left-notes .remarks {
			color: #2e7d32;
			font-style: italic;
			display: block;
		}

		.order-summary .order-total {
			font-size: 14px;
			font-weight: bold;
			white-space: nowrap;
		}

		.grand-total-bar {
			display: flex;
			justify-content: flex-end;
			padding: 16px 14px 6px 14px;
			border-top: 3px double #000;
			margin-top: 10px;
			font-size: 17px;
			font-weight: bold;
		}

		.nothing-follows {
			text-align: center;
			font-style: italic;
			color: #777;
			padding-top: 14px;
			letter-spacing: 1px;
		}
	</style>
</head>
<body>

	<div class="report-header">
		<img src="<?php echo WEB_ROOT; ?>images/branch_logo/<?php echo $img; ?>" alt="logo">
		<div>
			<h3>Sales Report</h3>
			<h4><?php echo $wfrom; ?><?php echo $t_from; ?> &nbsp;to&nbsp; <?php echo $wto; ?><?php echo $t_to; ?></h4>
			<h4>Terra Plaza, Cor. Rizal - Gatuslao Sts., Bacolod City</h4>
		</div>
	</div>

	<?php
	$emp = $conn->prepare("SELECT * FROM $branch.tbl_order
							WHERE ($oddate BETWEEN '$from' and '$to') $typ_state $rmk_state AND is_deleted != '1' AND is_paid != 0
							ORDER BY $oddate");
	$emp->execute();

	if ($emp->rowCount() > 0) {
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

			$lst = $conn->prepare("SELECT * FROM $branch.tbl_order_item i, $branch.tbl_product p
									WHERE i.od_id = '$emp_data[od_id]' AND i.pd_id = p.pd_id");
			$lst->execute();
			$items = $lst->fetchAll();
			$remarksText = '';
	?>
			<div class="order-block">

				<div class="order-meta">
					<div class="meta-item meta-ref"><?php echo $emp_data['invoice_num']; ?></div>
					<div class="meta-item">
						<span class="lbl">Date Released</span><?php echo $datereleased; ?>
					</div>
					<div class="meta-item">
						<span class="lbl">Customer</span><?php echo $fullname; ?>
					</div>
					<div class="meta-item">
						<span class="lbl">Payment Mode</span><?php echo $emp_data['payment_mode']; ?>
					</div>
					<div class="meta-item">
						<span class="lbl">Discount</span>&#x20B1;<?php echo number_format($emp_data['od_discount'], 2); ?> | <?php echo number_format($emp_data['percent_discount'], 0); ?>%
					</div>
				</div>

				<table class="item-table">
					<colgroup>
						<col class="col-product">
						<col class="col-serial">
						<col class="col-qty">
						<col class="col-price">
						<col class="col-total">
					</colgroup>
					<thead>
						<tr>
							<th>Product</th>
							<th>Serial #</th>
							<th class="center">Qty</th>
							<th class="num">Price</th>
							<th class="num">Total</th>
						</tr>
					</thead>
					<tbody>
						<?php if (count($items) > 0) { ?>
							<?php foreach ($items as $lst_data) {
								$total_amt_due = $lst_data['od_qty'] * $lst_data['od_price'];
								if (!empty($lst_data['remarks'])) {
									$remarksText = $lst_data['remarks'];
								}
							?>
								<tr>
									<td><?php echo $lst_data['pd_name']; ?></td>
									<td><?php echo $lst_data['pd_barcode']; ?></td>
									<td class="center"><?php echo $lst_data['od_qty']; ?> <?php echo $lst_data['pd_type']; ?></td>
									<td class="num"><?php echo number_format($lst_data['od_price'], 2); ?></td>
									<td class="num"><?php echo number_format($total_amt_due, 2); ?></td>
								</tr>
							<?php } ?>
						<?php } else { ?>
							<tr class="no-items">
								<td colspan="5">No items recorded for this order</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>

				<div class="order-summary">
					<div class="left-notes">
						Released by: <?php echo $released_by; ?>
						<?php if ($rmk != 0 && $remarksText !== '') { ?>
							<span class="remarks">*<?php echo $remarksText; ?>*</span>
						<?php } ?>
					</div>
					<div class="order-total">
						Order Total: &#x20B1; <?php echo number_format($emp_data['od_total_amt_due'], 2); ?>
					</div>
				</div>

			</div>
	<?php
		} // End while ($emp_data)
	?>
			<div class="grand-total-bar">
				Grand Total: &#x20B1; <?php echo number_format($grand_total, 2); ?>
			</div>
			<div class="nothing-follows">*** Nothing Follows ***</div>
	<?php
	} else {
	?>
			<div class="nothing-follows">*** No Records Found ***</div>
	<?php
	}
	?>

</body>
</html>