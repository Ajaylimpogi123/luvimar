<?php
require_once '../global-library/config.php';
//require_once '../global-library/functions.php';	
//checkUser();

if (!isset($_GET['oid']) || (int)$_GET['oid'] <= 0) {
	header('Location: index.php');
}

$page = $_GET['pg'];


$orderId = (int)$_GET['oid'];
$userId = $_SESSION['user_id'];

//$orderId = 1042;
$dsgn1 = "style='font-size:12px; font-family: Calibri;'";

?>

<head>
	<title>Receipt</title>

	<style rel="stylesheet" type="text/css">
		body {
			font-weight: bold;
		}

		.ctd {
			font-family: 'Calibri', sans-serif;
			font-weight: bold;
		}

		.reciept-container {
			width: 100px;
			font-family: 'Courier New', Courier, monospace;
			text-align: center;
			justify-content: center;
		}
	</style>
	<script type="text/javascript">
		function PrintDiv() {
			var divToPrint = document.getElementById('divToPrint');
			var popupWin = window.open('', '_blank', 'width=auto,height=auto');
			popupWin.document.open();
			popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
			popupWin.document.close();
		}
	</script>

</head>

<body onload="PrintDiv()">
	<table id="divToPrint" style="display:none;">

		<tr>
			<td>

				<div class="reciept-container" style="text-align: center;">
					<h5 class="reciept">===========================</h5>
					<h5 class="reciept">Store: 3KC</h5>
					<h5 class="reciept">Address: Door 4 Carmela Arcade</h5>
					<h5 class="reciept">Lasalle Ave, Barangay 5, Bacolod</h5>
					<h5 class="reciept">Contact No.: +63-9078055023</h5>
					<h5 class="reciept">===========================</h5>
				</div>


				<?php
				$sql = $conn->prepare("SELECT * FROM tbl_order o, tbl_product p, tbl_order_item i
									WHERE o.od_id = i.od_id AND i.pd_id = p.pd_id AND o.od_id = '$orderId'");
				$sql->execute();
				$numItem = $sql->rowCount();
				if ($numItem > 0) {
				?>
					<b>item(s)</b>
					<br />
					<table border="0" width="200">
						<?php
						$subTotal = 0;
						$total = 0;
						$ctr = 1;
						while ($rw_data = $sql->fetch()) {

							$new_price = $rw_data['od_price'];


							$subTotal = $new_price * $rw_data['od_qty'];
							$total += $new_price * $rw_data['od_qty'];


						?>
							<tr>
								<td <?php echo $dsgn1; ?>>
									<?php echo $rw_data['pd_name']; ?>
									<br /><?php echo number_format($new_price, 2); ?> X <?php echo $rw_data['od_qty']; ?>
								</td>
								<td <?php echo $dsgn1; ?> align="right">
									<span> = P<?php echo number_format($subTotal, 2); ?></span>
								</td>
							</tr>
							<tr>
								<td></td>
							</tr>
						<?php

						} // End For

						?>
					</table>

				<?php
				} else {
					echo "Shopping Cart Is Empty";
				}
				?>

				<br />
				----------------------------------

				<?php
				$sql7 = $conn->prepare("SELECT *, SUM(p.pc_price * i.od_qty) AS od_amount FROM tbl_order o, tbl_product p, tbl_order_item i
									WHERE o.od_id = i.od_id AND i.pd_id = p.pd_id AND o.od_id = '$orderId'");
				$sql7->execute();
				$sql_data7 = $sql7->fetch();

				$dcamt = ($sql_data7['od_discount'] / 100) * $sql_data7['od_amount_due'];

				$orderdate = date("M d, Y | h:i a", strtotime($sql_data7['od_date']));

				?>

				<table class="table" width="200">
					<tr>
						<td><span <?php echo $dsgn1; ?>>Control No.</span></td>
						<td align="right"><span <?php echo $dsgn1; ?>><?php echo $sql_data7['od_id']; ?></span></td>
					</tr>
					<tr>
						<td><span <?php echo $dsgn1; ?>>Date</span></td>
						<td align="right"><span <?php echo $dsgn1; ?>><?php echo $orderdate; ?></span></td>
					</tr>
					<tr>
						<td><span <?php echo $dsgn1; ?>>Total</span></td>
						<td align="right"><span <?php echo $dsgn1; ?>>Php <?php echo number_format($sql_data7['od_amount'], 2); ?></span></td>
					</tr>
					<tr>
						<td><span <?php echo $dsgn1; ?>>Discount</span></td>
						<td align="right"><span <?php echo $dsgn1; ?>>Php <?php echo number_format($sql_data7['od_discount'], 2); ?></span></td>
					</tr>
					<tr>
						<td><span <?php echo $dsgn1; ?>>Amount Due</span></td>
						<td align="right"><span <?php echo $dsgn1; ?>>Php <?php echo number_format($sql_data7['od_total_amt_due'], 2); ?></span></td>
					</tr>
					<tr>
						<td><span <?php echo $dsgn1; ?>>Payment Mode</span></td>
						<td align="right"><span <?php echo $dsgn1; ?>><?php echo $sql_data7['payment_mode'] ?></span></td>
					</tr>

					<?php
					if ($sql_data7['payment_mode'] == 'Gcash') {
					?>
						<tr>
							<td><span <?php echo $dsgn1; ?>>additional charge: </span></td>
							<td align="right"><span <?php echo $dsgn1; ?>>2%</span></td>
						</tr>
					<?php
					}
					?>
					<tr>
						<td><span <?php echo $dsgn1; ?>>Total Amount Due</span></td>
						<td align="right"><span <?php echo $dsgn1; ?>>Php <?php echo number_format($sql_data7['od_total_amt_due'], 2); ?></span></td>
					</tr>

					<tr>
						<td colspan="2"><br /><br /></td>
					</tr>
					<tr>
						<td><span <?php echo $dsgn1; ?>>Payment</span></td>
						<td align="right"><span <?php echo $dsgn1; ?>>Php <?php echo number_format($sql_data7['od_payment'], 2); ?></span></td>
					</tr>
					<tr>
						<td><span <?php echo $dsgn1; ?>>Change</span></td>
						<td align="right"><span <?php echo $dsgn1; ?>>Php <?php echo number_format($sql_data7['od_change'], 2); ?></span></td>
					</tr>
					<tr>
						<td colspan="2"><br /><br /></td>
					</tr>


				</table>
				<div class="reciept-container" style="text-align: center;">
					<h5 class="reciept">===========================</h5>
					<h5 class="reciept">This is not a Official Receipt</h5>
					<h5 class="reciept">Thank You Come Again!!</h5>
					<h5 class="reciept">===========================</h5>
				</div>
			</td>

		</tr>


	</table>


	<?php
	// if($page == 1)
	// {
	// 	echo "<center><h3>Processing...</h3><img src='../images/loader/loader_3.gif'><center>";
	$url = "index.php";
	echo "<meta http-equiv=\"refresh\" content=\"1;URL=$url\">";
	// }else{}

	?>
</body>