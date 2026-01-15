<?php
if (!defined('WEB_ROOT')) {
	exit;
}

date_default_timezone_set("Asia/Manila");
$today_date1 = date("Y-m-d H:i:s");
$today_date2 = date("Y-m-d");

$sql1 = $conn->prepare("SELECT *
			FROM tbl_order o, tbl_order_item oi
				WHERE o.od_date_1 = '$today_date2' AND oi.is_deleted != '1' AND oi.is_accepted != '1' AND o.od_id = oi.od_id
						ORDER BY o.od_id DESC");
$sql1->execute();

$sql2 = $conn->prepare("SELECT SUM(od_total_amt_due) AS payment
			FROM tbl_order
				WHERE od_date_1 = '$today_date2' AND is_paid = '1' AND is_deleted != '1'
						ORDER BY od_id DESC");
$sql2->execute();
$sql2_data = $sql2->fetch();
$total_cash = $sql2_data['payment'];

$sql3 = $conn->prepare("SELECT SUM(od_total_amt_due) AS credit
			FROM tbl_order
				WHERE od_date_1 = '$today_date2' AND is_charge = '1' AND is_deleted != '1'				
						ORDER BY od_id DESC");
$sql3->execute();
$sql3_data = $sql3->fetch();
$total_credit = $sql3_data['credit'];

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>


<div class="box-header well" data-original-title>
	<h2 <?php echo $csscolor; ?>><i class="icon-file"></i> Sales Today</h2>
	<div class="box-icon">
		<a href="../" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
	</div>
</div>
<br />
<div style="margin-left:20px;">
	<table cellpadding="4" cellspacing="4">
		<tr>
			<td>Cash Sales</td>
			<td> : </td>
			<td>Php <?php echo number_format($total_cash); ?></td>
		</tr>
		<tr>
			<td>Credit Sales</td>
			<td> : </td>
			<td>Php <?php echo number_format($total_credit); ?></td>
		</tr>
		<tr>
			<td><b>Total Sales</b></td>
			<td> <b>:</b> </td>
			<td>Php <b style="text-decoration-line: underline; text-decoration-style: double;"><?php echo number_format($total_cash + $total_credit); ?></b></td>
		</tr>
	</table>
</div>
<br />
<div class="box-content">
	<table class="table table-striped table-bordered bootstrap-datatable datatable">
		<thead>
			<tr>
				<th>Order #</th>
				<th>Customer</th>
				<th>Amount</th>
				<th>Order Date</th>
				<!-- <th>Action</th> -->
			</tr>
		</thead>
		<tbody>
			<?php
			if ($sql1->rowCount() > 0) {
				$ctr = 1;
				$total_all = 0;
				while ($sql1_data = $sql1->fetch()) {
					if ($sql1_data['is_charge'] == 1) {
						$clr = "style='background:#ff6666; color:#ffffff;'";
						$test = 1;
					} else {
						$clr = "";
						$test = 2;
					}

					$cname = ucwords(strtolower($sql1_data['customer_name']));
					$orderdate = date("M d, Y | h:i a", strtotime($sql1_data['od_date']));

			?>
					<!-- Start display list of orders !-->
					<tr>
						<td <?php echo $clr; ?>><?php echo $sql1_data['od_id']; ?></td>
						<td <?php echo $clr; ?>><?php echo $cname; ?></td>
						<td <?php echo $clr; ?>>Php <?php echo number_format($sql1_data['od_total_amt_due'], 2); ?></td>
						<td <?php echo $clr; ?>><?php echo $orderdate; ?></td>
						<!-- <td <?php echo $clr; ?>>
									<a href="order/process.php?action=delete&id=<?php echo $sql1_data['od_id']; ?>" class="btn btn-danger" onClick="return confirmDelete()"><i class="icon-trash icon-white"></i><span>Delete</span></a>									
								</td>									 -->
					</tr>
					<!-- End display list of orders !-->
			<?php
				}
			} else {
			}

			?>

		</tbody>
	</table>
</div>