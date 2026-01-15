<?php
if (!defined('WEB_ROOT')) {
	exit;
}
$userId = $_SESSION['user_id'];

if (isset($_POST['hidCartId'])) {
	$pid = $_POST['hidCartId'];

	# Qty
	foreach ($pid as $prid) {

		if (isset($_POST['qty_' . $prid]) && $_POST['qty_' . $prid] > 0) {
			$con = $_POST['qty_' . $prid];

			foreach ($con as $op) {
				// check current stock
				$sql = $conn->prepare("SELECT *
							FROM tbl_product p, tbl_cart c
							WHERE c.ct_id = '$prid' AND c.pd_id = p.pd_id");
				$sql->execute();
				$sql_data = $sql->fetch();
				$tp7 = $sql_data['is_type'];
				if ($tp7 == 1) {
					$tp = $sql_data['pc_qty'];
				} else if ($tp7 == 2) {
					$tp = $sql_data['ib_qty'];
				} else {
					$tp = $sql_data['bx_qty'];
				}

				if ($op > $tp) {
					// we only have this much in stock
					$newQty = $tp;
				} else {
					$newQty = $op;
				}

				# UPDATE tbl_cart
				$up = $conn->prepare("UPDATE tbl_cart SET ct_qty = '$newQty'
								WHERE ct_id = '$prid' AND user_id = '$userId' AND is_type = '$tp7'");
				$up->execute();
			}
		} else {
		}
	}
} else {
}

//$cartContent = getCartContent();
//$numItem = count($cartContent);

$sql1 = $conn->prepare("SELECT * FROM tbl_category c, tbl_product p, tbl_cart ct WHERE c.cat_id = p.cat_id AND p.pd_id = ct.pd_id AND ct.is_type != '0'");
$sql1->execute();


// show the error message ( if we have any )
displayError();

$subTotal = 0;
$total = 0;
$cost = 0;
for ($i = 0; $i < $sql1->rowCount(); $i++) {
	$sql1_data = $sql1->fetch();
	//$pd_name = "$ct_qty x $pd_name";
	//$productUrl = "index.php?c=$cat_id&p=$pd_id";

	$subTotal = $sql1_data['ct_price'] * $sql1_data['ct_qty'];
	$total += $sql1_data['ct_price'] * $sql1_data['ct_qty'];
	$cost += $sql1_data['pd_cost'] * $sql1_data['ct_qty'];
} // End For

// make sure a discount card barcode exists
if (isset($_POST['disc']) && $_POST['disc'] > 0) {
	$disc = $_POST['disc'];
	$dc = $conn->prepare("SELECT * FROM bs_discount_card WHERE barcode = '$disc'");
	$dc->execute();
	$dc_data = $dc->fetch();
	$discount = $dc_data['discount'];
	$dcId = $dc_data['dc_id'];
} else {
	$discount = 0;
	$dcId = 0;
}
?>

<head>
	<script type="text/javascript">
		// Auto calculate 1. Loan Application
		function startCalc1() {
			interval = setInterval("calc1()", 1);
		}

		function calc1() {
			amtdue = document.frmCheckout.amtdue.value; // Amount Due
			payment = document.frmCheckout.payment.value; // Payment
			discount = document.frmCheckout.discount.value; // Discount Peso
			perdisc = document.frmCheckout.perdisc.value; // Discount Percent

			var per1 = (perdisc * 1) / 100; // Get percent discount
			var per2 = (per1 * 1) * (amtdue * 1); // Multiply amount due to discount to get discounted amount
			var per3 = (amtdue * 1) - (discount * 1); // Get total amount due less discount
			var per4 = (per3 * 1) - (per2 * 1); // Get total amount due less discount

			//document.frmCheckout.dcamt.value = (per2 * 1); // Discount Amount
			document.frmCheckout.tamtd.value = (per4 * 1); // Total Amount Due less discount
			document.frmCheckout.change.value = ((payment * 1) - (per4 * 1)); // Get Change

		}

		function stopCalc1() {
			clearInterval(interval);
		}
	</script>
</head>
<div class="row-fluid sortable">
	<div class="box span6">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-user"></i> Customer Information</h2>
		</div>

		<div class="box-content">
			<form action="process.php?action=saveorder" method="post" name="frmCheckout" id="frmCheckout">
				<table class="table table-striped table-bordered">
					<tr>
						<td width="250"><span class="blue" style="font-size:14px; font-weight:bold;">Payment Method</span></td>
						<td>
							<div class="controls">
								<label class="radio">
									<input type="radio" class="payment_method" name="top" id="optionsRadios1" value="Cash" checked="" />Cash
								</label>
								<br />
								<!-- <label class="radio">
									<input type="radio" class="payment_method" name="top" id="optionsRadios2" value="Charge" />Charge
								  </label> -->
							</div>
						</td>
					</tr>
					<tr id="cust_name">
						<td width="150">Customer Name</td>
						<td><input name="fname" type="text" id="fname" size="30" maxlength="50" autocomplete=off /></td>
					</tr>
					<tr id="cust_name2" style="display:none">
						<td width="150"><span class="blue" style="font-size:28px; font-weight:bold;">Charge To:</span></td>
						<td>
							<input type="hidden" name="customer" value="<?php echo $cust_id; ?>" />
							<select name="cname" id="selectError" data-rel="chosen">
								<?php
								$cus = $conn->prepare("SELECT * FROM bs_customer WHERE is_deleted != '1' ORDER BY client_name; ");
								$cus->execute();
								if ($cus->rowCount() > 0) {
									while ($cus_data = $cus->fetch()) {
								?>
										<option value="<?php echo $cus_data['cust_id']; ?>"><?php echo $cus_data['client_name']; ?></option>
								<?php
									} // End While
								} else {
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td width="150"><span class="blue" style="font-size:18px; font-weight:bold;">Amount Due</span></td>
						<td>
							<span class="blue" style="font-size:18px; font-weight:bold;">Php <?php echo number_format($total, 2); ?></span>
							<input type="hidden" name="amtdue" id="amtdue" value="<?php echo $total; ?>" onFocus="startCalc1();" onBlur="stopCalc1();" />
						</td>
					</tr>
					<tr>
						<td width="150"><span class="blue" style="font-size:14px; font-weight:bold;">&#x20B1; Discount</span></td>
						<td>
							<input name="discount" type="text" id="discount" value="0" size="30" maxlength="50" style="font-size:16px; font-weight:bold;" onKeyUp="checkNumber(this);" onFocus="startCalc1();" onBlur="stopCalc1();" autocomplete=off />
						</td>
					</tr>
					<tr>
						<td width="150"><span class="blue" style="font-size:14px; font-weight:bold;">% Discount</span></td>
						<td>
							<input name="perdisc" type="text" id="perdisc" value="0" size="30" maxlength="50" style="font-size:16px; font-weight:bold;" onKeyUp="checkNumber(this);" onFocus="startCalc1();" onBlur="stopCalc1();" autocomplete=off />
						</td>
					</tr>
					<tr>
						<td width="150"><span class="blue" style="font-size:14px; font-weight:bold;">Total Amount Due</span></td>
						<td>
							<input name="tamtd" type="text" id="tamtd" size="30" maxlength="50" style="font-size:16px; font-weight:bold;" readonly />
						</td>
					</tr>
					<tr id="cust_name3">
						<td width="150"><span class="blue" style="font-size:14px; font-weight:bold;">Payment</span></td>
						<td>
							<input name="payment" type="text" id="payment" placeholder="0" size="30" maxlength="50" style="font-size:16px; font-weight:bold; background:#66ff33;" onKeyUp="checkNumber(this);" onFocus="startCalc1();" onBlur="stopCalc1();" autocomplete=off />
						</td>
					</tr>
					<tr id="cust_name4">
						<td width="150"><span class="blue" style="font-size:14px; font-weight:bold;">Change</span></td>
						<td>
							<input name="change" type="text" id="change" size="30" maxlength="50" style="font-size:16px; font-weight:bold;" readonly />
						</td>
					</tr>
					<tr id="cust_name7">
						<td width="150"><span class="blue" style="font-size:14px; font-weight:bold;">OR #</span></td>
						<td>
							<input name="ornum" type="text" id="ornum" size="30" maxlength="50" style="font-size:16px; font-weight:bold;" autocomplete=off />
						</td>
					</tr>
					<tr id="cust_name5" style="display:none">
						<td width="150"><span class="blue" style="font-size:14px; font-weight:bold;">Invoice #</span></td>
						<td>
							<input name="cinum" type="text" id="cinum" size="30" maxlength="50" style="font-size:16px; font-weight:bold;" autocomplete=off />
						</td>
					</tr>
					<tr id="cust_name8" style="display:none">
						<td width="150"><span class="blue" style="font-size:14px; font-weight:bold;">PO #</span></td>
						<td>
							<input name="ponum" type="text" id="ponum" size="30" maxlength="50" style="font-size:16px; font-weight:bold;" autocomplete=off />
						</td>
					</tr>
					<tr id="cust_name9" style="display:none">
						<td width="150"><span class="blue" style="font-size:14px; font-weight:bold;">Received By</span></td>
						<td>
							<input name="recby" type="text" id="recby" size="30" maxlength="50" style="font-size:16px; font-weight:bold;" autocomplete=off />
						</td>
					</tr>
					<tr id="cust_name6" style="display:none">
						<td width="150"><span class="blue" style="font-size:14px; font-weight:bold;">Terms in Days</span></td>
						<td>
							<input name="tidays" type="text" id="tidays" size="30" maxlength="50" style="font-size:16px; font-weight:bold;" onKeyUp="checkNumber(this);" autocomplete=off />
						</td>
					</tr>

					<!-- <tr>
						<td width="250"><span class="blue" style="font-size:14px; font-weight:bold;">Releasing Method</span></td>
						<td>
							<div class="controls">
								<label class="radio">
									<input type="radio" class="releasing_method" name="rmet" id="optionsRadios1" value="fp" checked="" />For Pickup
								</label>
								<br />
								<label class="radio">
									<input type="radio" class="releasing_method" name="rmet" id="optionsRadios2" value="fd" />For Delivery
								</label>
							</div>
						</td>
					</tr> -->

					<tr id="rmethod1" style="display:none">
						<td width="150"><span class="blue" style="font-size:14px; font-weight:bold;">Delivery Date</span></td>
						<td>
							<input name="deldate" type="text" id="txtFromDate" size="30" maxlength="50" style="font-size:16px; font-weight:bold;" onKeyUp="checkNumber(this);" autocomplete=off />
						</td>
					</tr>

					<tr id="rmethod2" style="display:none">
						<td width="150"><span class="blue" style="font-size:14px; font-weight:bold;">Delivery Address</span></td>
						<td>
							<input name="deladd" type="text" id="deladd" size="30" style="font-size:16px; font-weight:bold;" autocomplete=off />
						</td>
					</tr>

					<tr id="rmethod3" style="display:none">
						<td width="150"><span class="blue" style="font-size:14px; font-weight:bold;">Driver</span></td>
						<td>
							<input name="driver" type="text" id="driver" size="30" maxlength="50" style="font-size:16px; font-weight:bold;" autocomplete=off />
						</td>
					</tr>
					<tr>
						<td width="150"><span class="blue" style="font-size:14px; font-weight:bold;">Remarks</span></td>
						<td>
							<input name="remarks" type="text" id="remarks" style="font-size:13px; font-weight:normal;" autocomplete=off />
						</td>
					</tr>
					<tr>
						<input type="hidden" name="discId" id="discId" value="<?php echo $dcId; ?>" />
						<input type="hidden" name="cost" id="cost" value="<?php echo $cost; ?>" />
						<td><input name="btnBack" type="button" id="btnBack" value="Go Back" onClick="window.location.href='index.php?view=cart&action=view'" class="btn btn-primary"></td>
						<td><input name="btnSubmit" type="submit" id="btnSubmit" value="Submit" class="btn btn-success" onClick="return confirmSubmit()" disabled/></td>
					</tr>
				</table>
			</form>
		</div>
	</div>

	<div class="box span6">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-shopping-cart"></i> Cart Content</h2>
		</div>

		<div class="box-content">
			<?php
			$sql1 = $conn->prepare("SELECT * FROM tbl_category c, tbl_product p, tbl_cart ct WHERE c.cat_id = p.cat_id AND p.pd_id = ct.pd_id AND ct.is_type != '0'");
			$sql1->execute();

			if ($sql1->rowCount() > 0) {
			?>
				<div class="cart_details"> <?php echo $sql1->rowCount(); ?> item(s)</div>
				<br />
				<table border="0" width="100%">
					<tr>
						<!--<td width="100px;"><b>Image</b></td>
								<td width="10px;">&nbsp;</td>!-->
						<td width="100px;"><b>Product</b></td>
						<td width="10px;">&nbsp;</td>
						<td width="100px;"><b>Price</b></td>
						<td width="10px;">&nbsp;</td>
						<td width="20px;" align="center"><b>Qty</b></td>
						<td width="10px;">&nbsp;</td>
						<td width="100px;"><b>Sub-Total</b></td>
					</tr>
					<?php
					$subTotal = 0;
					$total = 0;
					for ($i = 0; $i < $sql1->rowCount(); $i++) {
						$sql1_data = $sql1->fetch();
						//$pd_name = "$ct_qty x $pd_name";
						//$productUrl = "index.php?c=$cat_id&p=$pd_id";

						$subTotal = $sql1_data['ct_price'] * $sql1_data['ct_qty'];
						$total += $sql1_data['ct_price'] * $sql1_data['ct_qty'];

						if ($sql1_data['is_type'] == 1) {
							$tp = "pc";
						} else if ($sql1_data['is_type'] == 2) {
							$tp = "bx";
						} else {
							$tp = "cs";
						}
					?>
						<tr>
							<!--<td width="80" align="center"><img src="<?php echo $pd_thumbnail; ?>" border="0"></td>
												<td width="10px;">&nbsp;</td>!-->
							<td><span class="border_cart"></span><?php echo word_split($sql1_data['pd_name'], 2); ?></td>
							<td width="10px;">&nbsp;</td>
							<td><span class="border_cart"></span>Php <?php echo number_format($sql1_data['ct_price'], 2); ?></td>
							<td width="10px;">&nbsp;</td>
							<td align="center"><?php echo $sql1_data['ct_qty']; ?>&nbsp;<?php echo $tp; ?></td>
							<td width="10px;">&nbsp;</td>
							<td><span class="border_cart"></span>Php <?php echo number_format($subTotal, 2); ?></td>
						</tr>
					<?php
					} // End For

					?>
					<tr>
						<td colspan="9">
							<hr style="border: 0; height: 1px; background-image: -webkit-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); background-image: -moz-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); background-image: -ms-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0));  background-image: -o-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); " />
						</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td><span class="border_cart"></span>Total:</td>
						<td></td>
						<td><span class="border_cart"></span>Php <?php echo number_format($total, 2); ?></td>
					</tr>
				</table>

			<?php
			} else {
				echo "Shopping Cart Is Empty";
			}
			?>
		</div>
	</div>
</div>
<script type="text/javascript">

			const paymentInput = document.getElementById('payment');
			const submitBtn = document.getElementById('btnSubmit');

			paymentInput.addEventListener('input', function (){
				submitBtn.disabled = paymentInput.value.trim() === '';
			})

	$(".payment_method").click(function() {


		var value_checked = $(this).val();

		// Cash
		if (value_checked == "Cash") {
			$("#cust_name").show();
		} else {
			$("#cust_name").hide();
		}
		// Charge
		if (value_checked == "Charge") {
			$("#cust_name2").show();
		} else {
			$("#cust_name2").hide();
		}
		// Payment
		if (value_checked == "Cash") {
			$("#cust_name3").show();
		} else {
			$("#cust_name3").hide();
		}
		// Change
		if (value_checked == "Cash") {
			$("#cust_name4").show();
		} else {
			$("#cust_name4").hide();
		}
		// Invoice Number
		if (value_checked == "Charge") {
			$("#cust_name5").show();
		} else {
			$("#cust_name5").hide();
		}
		// Terms in Days
		if (value_checked == "Charge") {
			$("#cust_name6").show();
		} else {
			$("#cust_name6").hide();
		}
		// OR Number
		if (value_checked == "Cash") {
			$("#cust_name7").show();
		} else {
			$("#cust_name7").hide();
		}
		// PO Number
		if (value_checked == "Charge") {
			$("#cust_name8").show();
		} else {
			$("#cust_name8").hide();
		}
		// Received By
		if (value_checked == "Charge") {
			$("#cust_name9").show();
		} else {
			$("#cust_name9").hide();
		}
	});

	$(".releasing_method").click(function() {


		var value_checked = $(this).val();

		// Delivery Date
		if (value_checked == "fd") {
			$("#rmethod1").show();
		} else {
			$("#rmethod1").hide();
		}
		// Delivery Address
		if (value_checked == "fd") {
			$("#rmethod2").show();
		} else {
			$("#rmethod2").hide();
		}
		// Driver
		if (value_checked == "fd") {
			$("#rmethod3").show();
		} else {
			$("#rmethod3").hide();
		}

	});
</script>