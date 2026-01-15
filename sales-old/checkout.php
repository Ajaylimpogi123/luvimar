<?php
if (!defined('WEB_ROOT')) {
	exit;
}
	$discId = $_POST['discId']; // Discount Id
	
	$firstname = $_POST['fname'];	
	$amtdue = $_POST['amtdue'];
	$discount = $_POST['discount'];
	$dcamt = $_POST['dcamt'];
	$tamtd = $_POST['tamtd'];
	$payment = $_POST['payment'];
	$change = $_POST['change'];		
		
?>		
		<form action="process.php?action=saveorder" method="post" name="frmCart" id="frmCart">
			<div class="box span6">
				<div class="box-header well" data-original-title>
					<h2><i class="icon-shopping-cart"></i> Cart Content</h2>
				</div>
									
				<div class="box-content">				
					<?php
						$cartContent = getCartContent();
						$numItem  = count($cartContent);
						if ($numItem > 0) 
						{
					?>
							<div class="cart_details"> <?php echo $numItem; ?> item(s)</div>
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
											$subTotal = 0; $total = 0;
											for ($i = 0; $i < $numItem; $i++) 
											{
												extract($cartContent[$i]);
												//$pd_name = "$ct_qty x $pd_name";
												$productUrl = "index.php?c=$cat_id&p=$pd_id";
												
												$subTotal = $pd_price * $ct_qty;
												$total += $pd_price * $ct_qty;
									?>				
											  <tr>
												<!--<td width="80" align="center"><img src="<?php echo $pd_thumbnail; ?>" border="0"></td>
												<td width="10px;">&nbsp;</td>!-->
												<td><span class="border_cart"></span><?php echo word_split($pd_name,2); ?></td>
												<td width="10px;">&nbsp;</td>
												<td><span class="border_cart"></span>Php <?php echo number_format($pd_price, 2); ?></td>
												<td width="10px;">&nbsp;</td>
												<td align="center"><?php echo $ct_qty; ?></td>
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
						}else{ echo "Shopping Cart Is Empty"; } 
					?>
				</div>
			</div>
			
			<div class="box span6">
				<div class="box-header well" data-original-title>
					<h2><i class="icon-user"></i> Customer Information</h2>
				</div>
									
				<div class="box-content">
					<table class="table table-striped table-bordered">
						<tr> 
							<td width="150">Customer Name</td>
							<td><input name="fname" type="text" id="fname" size="30" maxlength="50" value="<?php echo $firstname; ?>" readonly /></td>
						</tr>						
						<tr> 
							<td width="150"><span class="blue" style="font-size:14px; font-weight:bold;">Amount Due</span></td>
							<td>
								<span class="blue" style="font-size:14px; font-weight:bold;">Php <?php echo number_format($amtdue, 2); ?></span>
								<input type="hidden" name="amtdue" id="amtdue" value="<?php echo $amtdue; ?>" />
							</td>
						</tr>
						<tr> 
							<td width="150"><span class="blue" style="font-size:14px; font-weight:bold;">Discount</span></td>
							<td>
								<span class="blue" style="font-size:14px; font-weight:bold;"><?php echo $discount; ?>% &nbsp; &nbsp; Php <?php echo number_format($dcamt, 2); ?></span>
								<input type="hidden" name="discount" id="discount" value="<?php echo $discount; ?>" />
							</td>
						</tr>
						<tr> 
							<td width="150"><span class="blue" style="font-size:14px; font-weight:bold;">Total Amount Due</span></td>
							<td>
								<span class="blue" style="font-size:14px; font-weight:bold;">Php <?php echo number_format($tamtd, 2); ?></span>
								<input type="hidden" name="tamtd" id="tamtd" value="<?php echo $tamtd; ?>" />
							</td>
						</tr>
						<tr> 
							<td width="150"><span class="green" style="font-size:14px; font-weight:bold;">Payment</span></td>
							<td>
								<span class="green" style="font-size:14px; font-weight:bold;">Php <?php echo number_format($payment, 2); ?></span>
								<input type="hidden" name="payment" id="payment" value="<?php echo $payment; ?>" />
							</td>
						</tr>
						<tr> 
							<td width="150"><span class="red" style="font-size:14px; font-weight:bold;">Change</span></td>
							<td>
								<span class="red" style="font-size:14px; font-weight:bold;">Php <?php echo number_format($change, 2); ?></span>
								<input type="hidden" name="change" id="change" value="<?php echo $change; ?>" />
							</td>
						</tr>
						<tr> 			
							<input type="hidden" name="discId" id="discId" value="<?php echo $discId; ?>" />							
							<td><input name="btnBack" type="button" id="btnBack" value="Go Back" onClick="window.location.href='index.php?view=customer'" class="btn btn-small"></td>
							<td><input name="btnSubmit" type="submit" id="btnSubmit" value="Submit Order" class="btn btn-small" onClick="return confirmSubmit()" /></td>
						</tr>
					</table>
				</div>
			</div>
		</form>
			