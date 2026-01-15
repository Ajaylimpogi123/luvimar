<?php
if (!defined('WEB_ROOT')) {
	exit;
}

if (!isset($_GET['id']) || (int)$_GET['id'] <= 0) {
	header('Location: index.php');
}

$pId = (int)$_GET['id'];
	
?>		
		<form action="process.php?action=saveorder" method="post" name="frmCart" id="frmCart">
			<div class="box span6">
				<div class="box-header well" data-original-title>
					<h2><i class="icon-file"></i> Payment Details</h2>
				</div>
									
				<div class="box-content">				
					<?php
						$sql = "SELECT * FROM tbl_order o, tbl_order_item i, tbl_product p
									WHERE o.od_id = i.od_id AND i.pd_id = p.pd_id AND o.od_id = '$orderId'";
						$rs = dbQuery($sql);
						$numItem = dbNumRows($rs);
						if ($numItem > 0) 
						{
					?>
							<div class="cart_details"> <?php echo $numItem; ?> item(s)</div>
							<br />						
							<table border="0" width="100%">
							<tr>								
								<td width="100px;"><b>OR #</b></td>
								<td width="10px;">&nbsp;</td>
								<td width="100px;"><b>PO #</b></td>
								<td width="10px;">&nbsp;</td>
								<td width="100px;"><b>Invoice #</b></td>
								<td width="10px;">&nbsp;</td>
								<td width="100px;"><b>Paid By</b></td>
								<td width="10px;">&nbsp;</td>
								<td width="100px;"><b>Sub-Total</b></td>
							</tr>
									<?php
											$subTotal = 0; $total = 0;
											while($rw = dbFetchAssoc($rs))
											{
												extract($rw);												
												
												if ($pd_thumbnail) {
													$image = WEB_ROOT . 'images/product/' . $pd_thumbnail;
												} else {
													$image = WEB_ROOT . 'images/product/noimagelarge.png';
												}
												
												$subTotal = $pd_price * $od_qty;
												$total += $pd_price * $od_qty;
												
												$dcamt = ($od_discount / 100) * $od_amount_due;												
												
												$orderdate = date("M d, Y | h:i a",strtotime($rw['od_date']));
									?>				
											  <tr>												
												<td><span class="border_cart"></span><?php echo word_split($pd_name,2); ?></td>
												<td width="10px;">&nbsp;</td>
												<td><span class="border_cart"></span>Php <?php echo number_format($pd_price, 2); ?></td>
												<td width="10px;">&nbsp;</td>
												<td align="center"><?php echo $od_qty; ?></td>
												<td width="10px;">&nbsp;</td>
												<td><span class="border_cart"></span>Php <?php echo number_format($subTotal, 2); ?></td>												
											  </tr>
									<?php
											} // End For
											
									?>
							<tr>
								<td colspan="7">
									<hr style="border: 0; height: 1px; background-image: -webkit-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); background-image: -moz-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); background-image: -ms-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0));  background-image: -o-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); " />
								</td>
							</tr>
							<tr>
								<td></td>
								<td></td>
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
							<td><input name="fname" type="text" id="fname" size="30" maxlength="50" value="<?php echo $customer_name; ?>" readonly /></td>
						</tr>
						<tr> 
							<td width="150"><span class="black" style="font-size:11px; font-weight:bold;">Order Date</span></td>
							<td><span class="black" style="font-size:11px; font-weight:bold;"><?php echo $orderdate; ?></span></td>
						</tr>
						<tr> 
							<td width="150"><span class="blue" style="font-size:14px; font-weight:bold;">Amount Due</span></td>
							<td><span class="blue" style="font-size:14px; font-weight:bold;">Php <?php echo number_format($od_amount_due, 2); ?></span></td>
						</tr>
						<tr> 
							<td width="150"><span class="blue" style="font-size:14px; font-weight:bold;">Discount</span></td>
							<td><span class="blue" style="font-size:14px; font-weight:bold;">Php <?php echo number_format($od_discount, 2); ?></span></td>
						</tr>
						<tr> 
							<td width="150"><span class="blue" style="font-size:14px; font-weight:bold;">Total Amount Due</span></td>
							<td><span class="blue" style="font-size:14px; font-weight:bold;">Php <?php echo number_format($od_total_amt_due, 2); ?></span></td>
						</tr>
						<tr> 
							<td width="150"><span class="green" style="font-size:14px; font-weight:bold;">Payment</span></td>
							<td><span class="green" style="font-size:14px; font-weight:bold;">Php <?php echo number_format($od_payment, 2); ?></span></td>
						</tr>
						<tr> 
							<td width="150"><span class="red" style="font-size:14px; font-weight:bold;">Change</span></td>
							<td><span class="red" style="font-size:14px; font-weight:bold;">Php <?php echo number_format($od_change, 2); ?></span></td>
						</tr>
						<tr>							
							<td colspan="2"><input name="btnBack" type="button" id="btnBack" value="Go Back" onClick="window.location.href='index.php?view=list'" class="btn btn-small"></td>							
						</tr>
					</table>
				</div>
			</div>
		</form>
			