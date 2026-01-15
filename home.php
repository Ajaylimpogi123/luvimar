<?php
$userId = $_SESSION['user_id'];

$sql = $conn->prepare("SELECT * FROM bs_user
				WHERE user_id = '$userId'");
$sql->execute();
$sql_data = $sql->fetch();

date_default_timezone_set("Asia/Manila");

/* Format the fields to be displayed for user */
$fullname = ucwords(strtolower($sql_data['firstname'])) . '&nbsp;' . ucwords(strtolower($sql_data['lastname']));
/* End Format */

/* Check if user has picture then display */
if ($sql_data['image']) {
	$user_image = WEB_ROOT . 'images/user/' . $sql_data['image'];
} else {
	$user_image = WEB_ROOT . 'images/user/noimagelarge.jpg';
}
/* End Picture */

$dt_login = date("M d, Y", strtotime($sql_data['last_login']));

if ($sql_data['is_admin'] == 1) {
	$span = "5";
} else {
	$span = "6";
}

if ($sql_data['is_admin'] == 1) {
	if ($sql_data['theme'] == 'slate') {
		$csstheme = "style='background:transparent; border: 1px solid #ffffff; color:#ffffff;'";
		$csscolor = "style='color:#ffffff;'";
	} else {
		$csstheme = "style='background:transparent; border: 2px solid #339900; color:#000000;'";
		$csscolor = "style='color:#000000;'";
	}
} else {
	$csscolor = "style='color:#000000;'";
}
?>
<div>
	<ul class="breadcrumb">
		<li>
			<b <?php echo $csscolor; ?>>Dashboard Sample</b>
		</li>
		<li style="float:right;"><?php echo date('F d, Y | l'); ?></li>
	</ul>
</div>
<div class="row-fluid sortable">
	<div class="box span<?php echo $span; ?>">
		<div class="box-header well" data-original-title>
			<h2 <?php echo $csscolor; ?>><i class="icon-list"></i> Gross Sales</h2>
			<div class="box-icon">
				<a href="../" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<?php include 'graph/gross_sales_process.php'; ?>
		</div>
	</div>
	<div class="box span<?php echo $span; ?>">
		<div class="box-header well" data-original-title>
			<h2 <?php echo $csscolor; ?>><i class="icon-list"></i> Gross Sales VS Net Sales</h2>
			<div class="box-icon">
				<a href="../" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<?php include 'graph/net_sales_process.php'; ?>
		</div>
	</div>
	<?php if ($sql_data['is_admin'] == 1) { ?>
		<div class="box span2">
			<div class="box-content alerts">
				<div class="alert alert-error">
					<strong style="font-size:17px; font-family:Verdana;">Net Sales:</strong>
					<?php
					$ns1 = $conn->prepare("SELECT * FROM tr_graph_net_current WHERE od_date = '$today_date2'");
					$ns1->execute();
					$ns1_data = $ns1->fetch();
					echo "<strong style='font-size:15px; font-family:Calibri; color:#003366;'>" . $ns1_data['date_name'] . "</strong>";
					echo "&nbsp; <strong style='font-size:20px; font-family:Arial; color:#003366;'> Php " . number_format($ns1_data['total_sales']) . "</strong>";
					?>
				</div>
				<div class="alert alert-success">
					<strong style="font-size:15px; font-family:Verdana;">Gross Sales:</strong>
					<?php
					$ns2 = $conn->prepare("SELECT * FROM tr_graph_gross_current WHERE od_date = '$today_date2'");
					$ns2->execute();
					$ns2_data = $ns2->fetch();
					echo "<strong style='font-size:15px; font-family:Calibri; color:#003366;'>" . $ns2_data['date_name'] . "</strong>";
					echo "&nbsp; <strong style='font-size:20px; font-family:Arial; color:#003366;'> Php " . number_format($ns2_data['total_sales']) . "</strong>";
					?>
				</div>
				<div class="alert alert-info">
					<strong style="font-size:15px; font-family:Verdana;">Net Income:</strong>
					<?php
					$income = $ns2_data['total_sales'] - $ns1_data['total_sales'];
					echo "<strong style='font-size:15px; font-family:Calibri; color:#003366;'>" . $ns2_data['date_name'] . "</strong>";
					echo "&nbsp; <strong style='font-size:20px; font-family:Arial; color:#003366;'> Php " . number_format($income) . "</strong>";
					?>
				</div>
			</div>
		</div>
	<?php } else {
	} ?>
</div>
<?php if ($sql_data['is_admin'] == 1) { ?>
	<div class="row-fluid sortable">
		<div class="box span6">
			<div class="box-header well" data-original-title>
				<h2 <?php echo $csscolor; ?>><i class="icon-calendar"></i> Payables Schedule</h2>
				<div class="box-icon">
					<a href="../" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
				</div>
			</div>
			<div class="box-content">
				<?php include 'calendar/payables.php'; ?>
			</div>
		</div>
		<div class="box span6">
			<div class="box-header well" data-original-title>
				<h2 <?php echo $csscolor; ?>><i class="icon-calendar"></i> Receivables Schedule</h2>
				<div class="box-icon">
					<a href="../" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
				</div>
			</div>
			<div class="box-content">
				<?php include 'calendar/receivables.php'; ?>
			</div>
		</div>
	</div>

	<div class="sortable row-fluid">
		<a data-rel="tooltip" title="as of today" class="well span3 top-block" <?php echo $csstheme; ?>>
			<?php
			$ord = $conn->prepare("SELECT * FROM tbl_order WHERE is_deleted != '1'");
			$ord->execute();

			$ord1 = $conn->prepare("SELECT SUM(od_total_amt_due) as total_orsales FROM tbl_order WHERE is_deleted != '1'");
			$ord1->execute();
			$ord1_data = $ord1->fetch();
			?>
			<span class="icon32 icon-red icon-tag"></span>
			<div>Total Orders</div>
			<div><?php echo $ord->rowCount(); ?></div>
			<span class="notification red">Php <?php echo number_format($ord1_data['total_orsales'], 2); ?></span>
		</a>

		<a data-rel="tooltip" title="as of today" class="well span3 top-block" <?php echo $csstheme; ?>>
			<?php
			$ord2 = $conn->prepare("SELECT * FROM tbl_order WHERE is_deleted != '1' AND is_charge != '1'");
			$ord2->execute();

			$ord3 = $conn->prepare("SELECT SUM(od_total_amt_due) as total_orsales3 FROM tbl_order WHERE is_deleted != '1' AND is_charge != '1'");
			$ord3->execute();
			$ord3_data = $ord3->fetch();
			?>
			<span class="icon32 icon-color icon-star-on"></span>
			<div>Total Cash Orders</div>
			<div><?php echo $ord2->rowCount(); ?></div>
			<span class="notification green">Php <?php echo number_format($ord3_data['total_orsales3'], 2); ?></span>
		</a>

		<a data-rel="tooltip" title="as of today" class="well span3 top-block" <?php echo $csstheme; ?>>
			<?php
			$ord4 = $conn->prepare("SELECT * FROM tbl_order WHERE is_deleted != '1' AND is_charge = '1'");
			$ord4->execute();

			$ord5 = $conn->prepare("SELECT SUM(od_total_amt_due) as total_orsales5 FROM tbl_order WHERE is_deleted != '1' AND is_charge = '1'");
			$ord5->execute();
			$ord5_data = $ord5->fetch();
			?>
			<span class="icon32 icon-color icon-cart"></span>
			<div>Total Charge Orders</div>
			<div><?php echo $ord4->rowCount(); ?></div>
			<span class="notification yellow">Php <?php echo number_format($ord5_data['total_orsales5'], 2); ?></span>
		</a>

		<a data-rel="tooltip" title="as of today" class="well span3 top-block" <?php echo $csstheme; ?>>
			<?php
			$ord6 = $conn->prepare("SELECT * FROM tbl_order WHERE is_deleted != '1'");
			$ord6->execute();

			$ord7 = "SELECT SUM(od_cost) as total_cost7 FROM tbl_order WHERE is_deleted != '1'";
			$ord7->execute();
			$ord7_data = $ord7->fetch();

			$net7 = $ord1_data['total_orsales'] - $ord7_data['total_cost7'];
			?>
			<span class="icon32 icon-color icon-copy"></span>
			<div>Total Net Income</div>
			<div><?php echo $ord6->rowCount(); ?></div>
			<span class="notification red">Php <?php echo number_format($net7, 2); ?></span>
		</a>
	</div>

<?php } else {
} ?>
<div class="row-fluid sortable">
	<div class="box span<?php echo $span; ?>">
		<?php include 'order/dashboard.php'; ?>
	</div><!--/span-->
	<div class="box span<?php echo $span; ?>">
		<div class="box-header well" data-original-title>
			<h2 <?php echo $csscolor; ?>><i class="icon-list"></i> Top Purchased Product</h2>
			<div class="box-icon">
				<a href="../" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<?php include 'graph/graph_product.php'; ?>
		</div>
	</div>
	<?php if ($sql_data['is_admin'] == 1) { ?>
		<div class="box span2">
			<div class="box-content alerts">
				<div class="alert alert-primary">
					<strong style="font-size:12px; font-family:Verdana;">Total Payables:</strong>
					<?php
					$ns3 = $conn->prepare("SELECT *, SUM(total_cost) as total_ct FROM tbl_received WHERE is_paid != '1' AND is_deleted != '1'");
					$ns3->execute();
					$ns3_data = $ns3->fetch();

					$bal3 = $conn->prepare("SELECT *, SUM(amount_paid) as total_pay3 FROM tr_payment_supplier WHERE is_deleted != '1'");
					$bal3->execute();
					$bal3_data = $bal3->fetch();
					$total_pay3 = $bal3_data['total_pay3'];
					$total_balance3 = $bal3_data['total_ct'] - $total_pay3;

					echo "<strong style='font-size:15px; font-family:Calibri; color:#003366;'>as of today</strong>";
					echo "&nbsp; <strong style='font-size:20px; font-family:Arial; color:#003366;'> Php " . number_format($total_balance3) . "</strong>";
					?>
				</div>
				<div class="alert alert-info">
					<strong style="font-size:10px; font-family:Verdana;">Total Receivables:</strong>
					<?php
					$ns4 = $conn->prepare("SELECT *, SUM(od_total_amt_due) as total_due FROM tbl_order WHERE is_paid != '1' AND is_deleted != '1'");
					$ns4->execute();
					$ns4_data = $ns4->fetch();

					$bal4 = $conn->prepare("SELECT *, SUM(amount_paid) as total_pay4 FROM tr_payment WHERE is_deleted != '1'");
					$bal4->execute();
					$bal4_data = $bal4->fetch();
					$total_pay4 = $bal4_data['total_pay4'];
					$total_balance4 = $bal4_data['total_due'] - $total_pay4;

					echo "<strong style='font-size:15px; font-family:Calibri; color:#003366;'>as of today</strong>";
					echo "&nbsp; <strong style='font-size:20px; font-family:Arial; color:#003366;'> Php " . number_format($total_balance4) . "</strong>";
					?>
				</div>
				<div class="alert alert-success">
					<strong style="font-size:27px; font-family:Verdana;">Profit:</strong>
					<?php

					if ($total_balance4 > $total_balance3) {
						$income2 = $total_balance4 - $total_balance3;
					} else {
						$income2 = 0;
					}
					echo "<strong style='font-size:15px; font-family:Calibri; color:#003366;'>as of today</strong>";
					echo "&nbsp; <strong style='font-size:20px; font-family:Arial; color:#003366;'> Php " . number_format($income2) . "</strong>";
					?>
				</div>
				<div class="alert alert-error">
					<strong style="font-size:25px; font-family:Verdana;">Deficit:</strong>
					<?php
					if ($total_balance3 > $total_balance4) {
						$income7 = $total_balance3 - $total_balance4;
					} else {
						$income7 = 0;
					}
					echo "<strong style='font-size:15px; font-family:Calibri; color:#003366;'>as of today</strong>";
					echo "&nbsp; <strong style='font-size:20px; font-family:Arial; color:#003366;'> Php " . number_format($income7) . "</strong>";
					?>
				</div>
				<div class="alert alert-primary">
					<strong style="font-size:11px; font-family:Verdana;">Total Expenses:</strong>
					<?php
					$ns5 = $conn->prepare("SELECT *, SUM(amount) as total_exp FROM tr_expense WHERE is_deleted != '1'");
					$ns5->execute();
					$ns5_data = $ns5->fetch();
					$total_exp = $ns5_data['total_exp'];

					echo "<strong style='font-size:15px; font-family:Calibri; color:#003366;'>as of today</strong>";
					echo "&nbsp; <strong style='font-size:20px; font-family:Arial; color:#003366;'> Php " . number_format($total_exp) . "</strong>";
					?>
				</div>
			</div>
		</div>
	<?php } else {
	} ?>
</div><!--/row-->

<?php if ($sql_data['is_admin'] == 1) { ?>
	<div class="row-fluid sortable">
		<div class="box span6">
			<div class="box-header well" data-original-title>
				<h2 <?php echo $csscolor; ?>><i class="icon-user"></i> Customers</h2>
				<div class="box-icon">
					<a href="../" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
				</div>
			</div>
			<div class="box-content">
				<?php include 'customer/dashboard.php'; ?>
			</div>
		</div>
		<div class="box span6">
			<div class="box-header well" data-original-title>
				<h2 <?php echo $csscolor; ?>><i class="icon-user"></i> Suppliers</h2>
				<div class="box-icon">
					<a href="../" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
				</div>
			</div>
			<div class="box-content">
				<?php include 'supplier/dashboard.php'; ?>
			</div>
		</div>
	</div>
<?php } else {
} ?>