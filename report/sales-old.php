<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

	$userId = $_SESSION['user_id'];	
		
	$dfrom = $_POST['from'];
	$dto = $_POST['to'];
	$stype = $_POST['stype'];
	
	if($stype == 2)
	{ $typ_state = ""; }else if($stype == 1){ $typ_state = "AND o.is_charge = '1'"; }else{ $typ_state = "AND o.is_charge = '0'"; }
	
	$opt = $_POST['opt'];
	if($opt != '7')
	{
		if($opt == 1)
		{		
			$cust_label = 'Food Panda';		
		}else if($opt == 0){		
			$cust_label = 'Panevino';
		}else{ $cust_label = 'Grab Food'; }
		
		$ty = "AND oi.is_foodpanda = '$opt'";
	}else{
		$ty = "";
		$cust_label = "All";
	}
	
	# Format Date to match date in db
	$newfrom = date("Y-m-d", strtotime($dfrom));
	$newto = date("Y-m-d", strtotime($dto));	
	# Format Date to words
	$wfrom = date("M d, Y", strtotime($dfrom));	
	$wto = date("M d, Y", strtotime($dto));		
	

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>		
<head>		
<title>Sales Report</title>
<link rel="shortcut icon" href="<?php echo WEB_ROOT; ?>images/favicon.ico">
<style rel="stylesheet">
.tdlabel
{   
   color: #000 !important;
   font-family: Arial !important;
   font-weight: bold;
   font-size:14px;
}
.tddata
{   
   color: #000 !important;
   font-family: Arial !important;  
   font-size:13px;
}
</style>
</head>
		<table style="margin:auto;">
		<tr>
			<td><img src="<?php echo WEB_ROOT; ?>images/logo.png" /></td>
			<td>&nbsp; &nbsp;</td>
			<td>
				<h3>Sales Report - <?php echo $cust_label; ?></h3>
				<h4><?php echo $wfrom; ?> to <?php echo $wto; ?></h4>
			</td>
		</tr>
		<table>
		<br />
		<table style="margin:auto;">
		<tr><td>
			<table style="padding:7px;" border="0">
			<!--<tr colspan="21">
				<td>
					<form method="post" action="sales_print.php">
						<input type="hidden" name="from" value="<?php echo $dfrom; ?>" />
						<input type="hidden" name="to" value="<?php echo $dto; ?>" />
						<input type="submit" name="submit" value="Print" style="background:#66ff33; border:solid 1px #000000;" />
					</form>
				</td>
			</tr>!-->
			<tr>
							<td class="tdlabel">#</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Date Released</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Customer</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Product</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Qty</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Price</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Sub Total</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Discount</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Total</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Released By</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">OR #</td>							
						</tr>
			<tr>
				<td colspan="21"><hr color='black' /></td>
			</tr>
								  <tbody>
									<?php
										$emp = $conn->prepare("SELECT * FROM tbl_order o, tbl_order_item oi, tbl_product p
													WHERE o.od_id = oi.od_id AND oi.pd_id = p.pd_id $ty
															AND (o.od_date_1 BETWEEN '$newfrom' and '$newto') $typ_state AND o.is_deleted != '1'
																	ORDER BY o.od_date_1");
										$emp->execute();
										if($emp->rowCount() > 0)
										{
											$ctr1 = 1; $total = 0; $total_discount = 0; $grand_total = 0;
											while($emp_data = $emp->fetch())
											{
												$fullname = utf8_encode(ucwords(strtolower($emp_data['customer_name'])));
												$datereleased = date("M d, Y | h:i a", strtotime($emp_data['od_date']));
												
												$rby = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$emp_data[released_by]'");
												$rby->execute();
												if($rby->rowCount() > 0)
												{ 
													$rby_data = $rby->fetch();
													$released_by = utf8_encode(ucwords(strtolower($rby_data['lastname']))) . ',&nbsp;' . ucwords(strtolower($rby_data['firstname'])); 
												}else{ $released_by = '- -'; }
												
												$sub_total = $emp_data['od_qty'] * $emp_data['od_price'];
												$alltotal = $sub_total - $emp_data['od_discount'];
												$total += $sub_total;
												$total_discount += $emp_data['od_discount'];
												$grand_total += $alltotal;
									?>
												<tr>
													<td class="tddata" valign="top"><?php echo $ctr1++; ?>. </td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $datereleased; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $fullname; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $emp_data['pd_name']; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $emp_data['od_qty']; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo number_format($emp_data['od_price'], 2); ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo number_format($sub_total, 2); ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo number_format($emp_data['od_discount'], 2); ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo number_format($alltotal, 2); ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $released_by; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $emp_data['invoice_num']; ?></td>
												</tr>
									<?php
											} // End While
									?>
												<tr>
										<td colspan="21"><hr color='black' /></td>
									</tr>												
									<tr>
										<td colspan="10"></td>
										<td class="tdlabel">Total</td>
										<td width="20px;"> : </td>
										<td class="tdlabel" style="text-decoration-line: underline; text-decoration-style: double;"><?php echo number_format($total, 2); ?></td>
										<td width="20px;"></td>
										<td class="tdlabel" style="text-decoration-line: underline; text-decoration-style: double;"><?php echo number_format($total_discount, 2); ?></td>
										<td width="20px;"></td>
										<td class="tdlabel" style="text-decoration-line: underline; text-decoration-style: double;">
											<?php echo number_format($grand_total, 2); ?>											
										</td>
										<td width="20px;"></td>
										<td>
											<!--<form method="post" action="sales_print.php">
												<input type="hidden" name="from" value="<?php echo $dfrom; ?>" />
												<input type="hidden" name="to" value="<?php echo $dto; ?>" />
												<input type="submit" name="submit" value="Print" style="background:#66ff33; border:solid 1px #000000;" />
											</form>!-->
										</td>
									</tr>
									<tr style="border-top: 1px;">
										<td colspan="21" align="center">*** Nothing Follows ***</td>
									</tr>
						<?php
							}else{}
						?>
					  </tbody>
			</table>            
		</td></tr>
		</table>