<?php
if (!defined('WEB_ROOT')) {
	exit;
}


$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : 'view';

switch ($action) {
	case 'add':
		addToCart();
		break;
	case 'update1':
		updateReceivingCart();
		break;
	case 'delete':
		deleteFromReceivingCart();
		break;
	case 'view':
}

$cartContent = getReceivingCart();
$numItem = count($cartContent);


// show the error message ( if we have any )
displayError();

?>
<div class="box span12">
	<div class="box-header well" data-original-title>
		<h2><i class="icon-shopping-cart"></i> Receiving Cart</h2>
	</div>

	<div class="box-content">
		<?php
		if ($numItem > 0) {
		?>
			<div class="cart_details"> <?php echo $numItem; ?> item(s)</div>
			<br />
			<form action="process.php?action=saveorder" method="post" name="frmCart" id="frmCart">
				<table border="0" width="95%">
					<tr>
						<td valign="top">
							<table border="0" width="100%">
								<tr>
									<td colspan="9"><br /></td>
								</tr>
								<tr>
									<td width="300px;"><b>Product</b></td>
									<td width="10px;">&nbsp;</td>
									<td width="20px;" align="center"><b>Qty</b></td>
									<td width="10px;">&nbsp;</td>
									<td width="20px;" align="center"><b>Cost</b></td>
									<td width="10px;">&nbsp;</td>
									<td width="20px;" align="center"><b>Price</b></td>
								</tr>
								<?php
								for ($i = 0; $i < $numItem; $i++) {
									extract($cartContent[$i]);
									if ($is_type == 1) {
										$tp = 'PC';
									} else if ($is_type == 2) {
										$tp = 'BX';
									} else {
										$tp = 'CS';
									}

								?>
									<tr>
										<td><span class="border_cart"></span> <?php echo $pd_name; ?></td>
										<td width="10px;">&nbsp;</td>
										<td align="center">
											<input name="qty_<?php echo $ct_id; ?>[]" type="text" id="txtQty[]" size="5" value="<?php echo $ct_qty; ?>" class="box" onKeyUp="checkNumber(this);" style="width:37px;" autocomplete=off>
											<input name="hidCartId[]" type="hidden" value="<?php echo $ct_id; ?>">
											<input name="hidProductId[]" type="hidden" value="<?php echo $pd_id; ?>">
										</td>
										<td width="10px;">&nbsp;</td>
										<td align="center" style="display:none;">
											<input name="cost_<?php echo $ct_id; ?>[]" type="text" id="cost[]" size="5" value="<?php echo $ct_cost; ?>" class="box" onKeyUp="checkNumber(this);" style="width:47px;" autocomplete=off>
										</td>
										<td align="center">
											<?php echo $tp; ?>
										</td>
										<td width="10px;">&nbsp;</td>
										<td align="center">
											<input name="price_<?php echo $ct_id; ?>[]" type="text" id="price[]" size="5" value="<?php echo $ct_price; ?>" class="box" onKeyUp="checkNumber(this);" style="width:47px;" autocomplete=off>
										</td>
										<td width="10px;">&nbsp;</td>
										<td>
											<a class="btn btn-danger" href="index.php?view=cart&action=delete&cid=<?php echo $ct_id; ?>;"><i class="icon-trash icon-white"></i></a>
										</td>
									</tr>
								<?php
								} // End For

								?>
								<tr>
									<td colspan="9">
										<hr style="border: 0; height: 1px; background-image: -webkit-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); background-image: -moz-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); background-image: -ms-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0));  background-image: -o-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); " />
									</td>
								</tr>
							</table>
						</td>
						<td width="10"></td>
						<td valign="top">
							<table border="0" width="100%">
								<tr>
									<td>Supplier</td>
									<td>&nbsp; : &nbsp;</td>
									<td colspan="3">
										<select id="selectError" data-rel="chosen" name="supplier">
											<option value="0">-- Search Supplier --</option>
											<?php
											$sup = $conn->prepare("SELECT * FROM bs_supplier WHERE is_deleted != '1' ORDER BY company_name");
											$sup->execute();

											if ($sup->rowCount() > 0) {
												while ($sup_data = $sup->fetch()) {
											?>
													<option value="<?php echo $sup_data['sup_id']; ?>"><?php echo $sup_data['company_name']; ?></option>
											<?php
												} // End While
											} else {
											}
											?>
										</select>
									</td>
								</tr>
								<tr>
									<td>Payment Method</td>
									<td>&nbsp; : &nbsp;</td>
									<td colspan="3">
										<label class="radio">
											<input type="radio" class="payment_method" name="top" id="optionsRadios1" value="Cash" checked="" />Cash
										</label>
										<br />
										<label class="radio">
											<input type="radio" class="payment_method" name="top" id="optionsRadios2" value="Charge" />Charge
										</label>
									</td>
								</tr>
								<tr id="cust_name1">
									<td>OR Number</td>
									<td>&nbsp; : &nbsp;</td>
									<td colspan="3">
										<input class="input-xlarge focused" id="ornum" name="ornum" type="text" autocomplete=off style="width:100px;" />
									</td>
								</tr>
								<tr id="cust_name2" style="display:none">
									<td>DR/Invoice Number</td>
									<td>&nbsp; : &nbsp;</td>
									<td colspan="3">
										<input class="input-xlarge focused" id="drnum" name="drnum" type="text" autocomplete=off style="width:100px;" />
									</td>
								</tr>
								<tr id="cust_name3" style="display:none">
									<td>Terms in Days</td>
									<td>&nbsp; : &nbsp;</td>
									<td colspan="3">
										<input class="input-xlarge focused" id="terms" name="terms" type="text" autocomplete=off onKeyUp="checkNumber(this);" style="width:100px;" />
									</td>
								</tr>
								<tr align="right">
									<td colspan="3"></td>
									<?php
									if ($numItem > 0) {
									?>
										<td><a href="process.php?action=saveorder" onClick="return confirmSubmit()" title="Process Add"><button class="btn btn-small btn-warning">Proceed <i class="icon icon-white icon-carat-1-e"></i></button></a></td>
									<?php
									}
									?>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</form>
			<br />
			<a href="index.php" title="Go Back"><button class="btn btn-small btn-warning"><i class="icon icon-white icon-carat-1-w"></i> Go Back</button></a>
		<?php
		} else {
			echo "Receiving Cart Is Empty";
		}
		?>
	</div>
</div>

<script type="text/javascript">
	$(".payment_method").click(function() {


		var value_checked = $(this).val();

		// OR
		if (value_checked == "Cash") {
			$("#cust_name1").show();
		} else {
			$("#cust_name1").hide();
		}
		// DR
		if (value_checked == "Charge") {
			$("#cust_name2").show();
		} else {
			$("#cust_name2").hide();
		}
		// Terms
		if (value_checked == "Charge") {
			$("#cust_name3").show();
		} else {
			$("#cust_name3").hide();
		}
	});
</script>