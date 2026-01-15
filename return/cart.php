<?php
if (!defined('WEB_ROOT')) {
	exit;
}
	

$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : 'view';

switch ($action) {
	case 'add' :
		addToCart();
		break;
	case 'update1' :
		updateReturningCart();
		break;	
	case 'delete' :
		deleteFromReturningCart();
		break;
	case 'view' :
}

$cartContent = getReturningCart();
$numItem = count($cartContent);


// show the error message ( if we have any )
displayError();
	
?>							
			<div class="box span12">
				<div class="box-header well" data-original-title>
					<h2><i class="icon-shopping-cart"></i> Returning Cart</h2>
				</div>
									
				<div class="box-content">				
					<?php
						if ($numItem > 0) 
						{
					?>
							<div class="cart_details"> <?php echo $numItem; ?> item(s)</div>
							<br />
							<form action="process.php?action=saveorder" method="post" name="frmCart" id="frmCart">
							<table border="0" width="95%">
							<tr>
								<td valign="top">
									<table border="0" width="600px">
									<tr><td colspan="9"><br /></td></tr>
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
													for ($i = 0; $i < $numItem; $i++) 
													{
														extract($cartContent[$i]);
														
														if($is_type == 1)
														{ $tp = 'PC'; }
														else if($is_type == 2)
														{ $tp = 'BX'; }
														else{ $tp = 'CS'; }
														
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
														<td align="center">													
															<input name="cost_<?php echo $ct_id; ?>[]" type="text" id="cost[]" size="5" value="<?php echo $ct_cost; ?>" class="box" onKeyUp="checkNumber(this);" style="width:47px;" readonly autocomplete=off>
														</td>
														<td width="10px;">&nbsp;</td>
														<td align="center">													
															<?php echo $tp; ?>
														</td>
														<td width="10px;">&nbsp;</td>
														<td align="center">													
															<input name="price_<?php echo $ct_id; ?>[]" type="text" id="price[]" size="5" value="<?php echo $ct_price; ?>" class="box" onKeyUp="checkNumber(this);" style="width:47px;" readonly autocomplete=off>
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
									<table border="0" width="400px">
									<!--<tr>
										<td>Return Type</td>
										<td>&nbsp; : &nbsp;</td>
										<td>
											<label class="radio">
												<input type="radio" class="return_type" name="top" id="optionsRadios1" value="o">
												To Supplier
											</label>
										  
											<label class="radio">
												<input type="radio" class="return_type" name="top" id="optionsRadios2" value="a" checked="">
												From Customer
											</label>	
										</td>
									</tr>
									<tr id="cust">
										<td>Customer</td>
										<td>&nbsp; : &nbsp;</td>
										<td>
											<select id="selectError7" data-rel="chosen" name="customer">
												<option value="0">-- Search Customer --</option>
												<?php
													$cust = $conn->prepare("SELECT * FROM bs_customer WHERE is_deleted != '1' ORDER BY client_name");
													$cust->execute();
													if($cust->rowCount() > 0)
													{
														while($cust_data = $cust->fetch())
														{
												?>
															<option value="<?php echo $cust_data['cust_id']; ?>"><?php echo $cust_data['client_name']; ?></option>
												<?php
														} // End While
													}else{}
												?>
											</select>
										</td>
									</tr>
									<tr id="sup" style="display:none">
										<td>Supplier</td>
										<td>&nbsp; : &nbsp;</td>
										<td>
											<select id="selectError" data-rel="chosen" name="supplier">
												<option value="0">-- Search Supplier --</option>
												<?php
													$sup = $conn->prepare("SELECT * FROM bs_supplier WHERE is_deleted != '1' ORDER BY company_name");
													$sup->execute();
													if($sup->rowCount() > 0)
													{
														while($sup_data = $sup->fetch())
														{
												?>
															<option value="<?php echo $sup_data['sup_id']; ?>"><?php echo $sup_data['company_name']; ?></option>
												<?php
														} // End While
													}else{}
												?>
											</select>
										</td>
									</tr>
									<tr>
										<td>Reason</td>
										<td>&nbsp; : &nbsp;</td>
										<td>
											<input class="input-xlarge focused" id="reason" name="reason" type="text" required autocomplete=off />
										</td>
									</tr>
									<tr id="inv">
										<td colspan="3">
											<b>Add to inventory?</b> If <b>YES</b>, the quantity returned of product will be added to it's current quantity on stock
											<label class="radio">
												<input type="radio" class="inv_type" name="inv" id="optionsRadios3" value="1">
												Yes
											</label>
										  
											<label class="radio">
												<input type="radio" class="inv_type" name="inv" id="optionsRadios4" value="2" checked="">
												No
											</label>
										</td>
									</tr>
									<tr><td colspan="3"><br /></td></tr>!-->
									<tr align="right">									  
										<?php 
											if ($numItem > 0)
											{
										?>  	
												<input type="hidden" name="top" value="o">
												<input type="hidden" name="customer" value="0">
												<input type="hidden" name="supplier" value="0">
												<input type="hidden" name="reason" value="">
												<input type="hidden" name="inv" value="">
												<td colspan="3"><input type = "submit" name="Submit" value="Proceed" onClick="return confirmSubmit()" class="btn btn-small btn-warning" /></td>
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
						}else{ echo "Returning Cart Is Empty"; } 
					?>
				</div>
			</div>

<script type="text/javascript">

	$(".return_type").click(function(){


		var value_checked = $(this).val();
		
		// Supplier
		if(value_checked == "o"){
			$("#sup").show();
		}
		else{
			$("#sup").hide();
		}
		// Customer
		if(value_checked == "o"){
			$("#cust").hide();
		}
		else{
			$("#cust").show();
		}
		// Inventory
		if(value_checked == "o"){
			$("#inv").hide();
		}
		else{
			$("#inv").show();
		}
	
});

</script>