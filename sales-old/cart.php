<?php
if (!defined('WEB_ROOT')) {
	exit;
}
	

$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : 'view';

switch ($action) {
	case 'add' :
		addToCart();
		break;
	case 'update' :
		updateCart();
		break;	
	case 'delete' :
		deleteFromCart();
		break;
	case 'view' :
}

//$cartContent = getCartContent();
//$numItem = count($cartContent);

$sql = $conn->prepare("SELECT * FROM tbl_category c, tbl_product p, tbl_cart ct WHERE c.cat_id = p.cat_id AND p.pd_id = ct.pd_id AND ct.is_type != '0' AND ct.user_id = '$userId'");
$sql->execute();

// show the error message ( if we have any )
displayError();
		
?>							
			<div class="box span12">
				<div class="box-header well" data-original-title>
					<h2><i class="icon-shopping-cart"></i> Cart Content</h2>
				</div>
									
				<div class="box-content">				
					<?php
						if ($sql->rowCount() > 0) 
						{
					?>
							<div class="cart_details"> <?php echo $sql->rowCount(); ?> item(s)</div>
							<br />
							<form action="index.php?view=customer" method="post" name="frmCart" id="frmCart">
							<table border="0" width="100%">
							<tr>
								<!--<td width="100px;"><b>Image</b></td>
								<td width="10px;">&nbsp;</td>!-->
								<td width="100px;"><b>Category</b></td>
								<td width="10px;">&nbsp;</td>
								<td width="150px;"><b>Brand</b></td>
								<td width="10px;">&nbsp;</td>
								<td width="250px;"><b>Product</b></td>
								<td width="10px;">&nbsp;</td>
								<td width="100px;"><b>Price</b></td>
								<td width="10px;">&nbsp;</td>
								<td width="70px;" align="center"><b>Qty</b></td>
								<td width="10px;">&nbsp;</td>
								<td width="100px;"><b>Sub-Total</b></td>
							</tr>
									<?php
											$subTotal = 0; $total = 0;
											for ($i = 0; $i < $sql->rowCount(); $i++)
											{
												$sql_data = $sql->fetch();
												//$catId = $sql_data['cat_id'];
												//$pdId = $sql_data['pd_id'];
												//$pd_name = "$ct_qty x $pd_name";
												//$productUrl = "index.php?c=$catId&p=$pdId";
												
												$subTotal = $sql_data['ct_price'] * $sql_data['ct_qty'];
												$total += $sql_data['ct_price'] * $sql_data['ct_qty'];
												
												$ctn = $conn->prepare("SELECT * FROM tbl_category WHERE cat_id = '$sql_data[cat_parent_id]'");
												$ctn->execute();
												$ctn_data = $ctn->fetch();
												$ctname = $ctn_data['cat_name'];
												
												if($sql_data['is_type'] == 1){ $tp = "pc"; }
												else if($sql_data['is_type'] == 2){ $tp = "bx"; }
												else{ $tp = "cs"; }
									?>				
											  <tr>
												<!--<td width="80" align="center"><a href="<?php echo $productUrl; ?>"><img src="<?php echo $pd_thumbnail; ?>" border="0"></a></td>
												<td width="10px;">&nbsp;</td>!-->
												<td><span class="border_cart"></span><?php echo $ctname; ?></td>
												<td width="10px;">&nbsp;</td>
												<td><span class="border_cart"></span><?php echo $sql_data['cat_name']; ?></td>
												<td width="10px;">&nbsp;</td>
												<td><span class="border_cart"></span><?php echo $sql_data['pd_name7']; ?></td>
												<td width="10px;">&nbsp;</td>
												<td><span class="border_cart"></span>Php <?php echo number_format($sql_data['ct_price'], 2); ?></td>
												<td width="10px;">&nbsp;</td>
												<td align="center">													
													<input name="qty_<?php echo $sql_data['ct_id']; ?>[]" type="text" id="txtQty[]" size="5" value="<?php echo $sql_data['ct_qty']; ?>" class="box" onKeyUp="checkNumber(this);" style="width:40px;" autocomplete=off>
													<?php echo $tp; ?>
													<input name="hidCartId[]" type="hidden" value="<?php echo $sql_data['ct_id']; ?>">
													<input name="hidProductId[]" type="hidden" value="<?php echo $sql_data['pd_id']; ?>">
												</td>
												<td width="10px;">&nbsp;</td>
												<td><span class="border_cart"></span>Php <?php echo number_format($subTotal, 2); ?></td>
												<td width="10px;">&nbsp;</td>
												<td><input name="btnDelete" type="button" id="btnDelete" value="Delete" onClick="window.location.href='index.php?view=cart&action=delete&cid=<?php echo $sql_data['ct_id']; ?>';" class="btn btn-danger"></td>
											  </tr>
									<?php
											} // End For
											
									?>
							<tr>
								<td colspan="11">
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
								<td></td>
								<td colspan="2"><span class="blue" style="font-size:18px; font-weight:bold;">Total:</span></td>													
								<td colspan="3"><span class="blue" style="font-size:18px; font-weight:bold;">Php <?php echo number_format($total, 2); ?></span></td>
							</tr>
							<tr>	
								<td><br /></td>
							</tr>
							<?php if ($sql->rowCount() > 0){ ?>
								<tr>					
									<td colspan="11" align="center">
										<input type="hidden" name="isfp" id="isfp" value="<?php echo $is_foodpanda; ?>" />
										<input name="submit" type="submit" id="submit" value="Next" class="btn btn-large btn-success">
									</td>
								</tr>
							<?php } ?>
							</table>
							</form>
							<br />
							<?php
								$shoppingReturnUrl = isset($_SESSION['shop_return_url']) ? $_SESSION['shop_return_url'] : 'index.php';
							?>
							
					<?php
						}else{ echo "Shopping Cart Is Empty"; } 
					?>
				</div>
			</div>							
			