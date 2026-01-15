<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

	$userId = $_SESSION['user_id'];	
		
	$dfrom = $_POST['from'];
	$dto = $_POST['to'];	
	
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
	<table id="divToPrint" style="display:none; margin:auto;">
	<tr><td>
		<table style="margin:auto;">
		<tr>
			<td><img src="<?php echo WEB_ROOT; ?>images/logo.svg" /></td>
			<td>&nbsp; &nbsp;</td>
			<td>
				<h3>Sales Report</h3>
				<h4><?php echo $wfrom; ?> to <?php echo $wto; ?></h4>
			</td>
		</tr>
		<table>
		<br />
		<table style="margin:auto;">
		<tr><td>
			<table style="padding:7px;" border="0">
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
										$emp = "SELECT * FROM tbl_order o, tbl_order_item oi, tbl_product p
													WHERE o.od_id = oi.od_id AND oi.pd_id = p.pd_id
															AND (o.od_date_1 BETWEEN '$newfrom' and '$newto')
																	ORDER BY o.od_date_1";
										$rs_emp = dbQuery($emp);
										$num_emp = dbNumRows($rs_emp);
										if($num_emp > 0)
										{
											$ctr1 = 1; $total = 0; $total_discount = 0; $grand_total = 0;
											while($rw_emp = dbFetchAssoc($rs_emp))
											{
												extract($rw_emp);
												$fullname = utf8_encode(ucwords(strtolower($rw_emp['customer_name'])));
												$datereleased = date("M d, Y | h:i a", strtotime($od_date));
												
												$rby = "SELECT * FROM bs_user WHERE user_id = '$released_by'";
												$rs_rby = dbQuery($rby);
												$num_rby = dbNumRows($rs_rby);
												if($num_rby > 0)
												{ 
													$rw_rby = dbFetchAssoc($rs_rby);
													$released_by = utf8_encode(ucwords(strtolower($rw_rby['lastname']))) . ',&nbsp;' . ucwords(strtolower($rw_rby['firstname'])); 
												}else{ $released_by = '- -'; }
												
												$sub_total = $od_qty * $od_price;
												$alltotal = $sub_total - $od_discount;
												$total += $sub_total;
												$total_discount += $od_discount;
												$grand_total += $alltotal;
									?>
												<tr>
													<td class="tddata" valign="top"><?php echo $ctr1++; ?>. </td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $datereleased; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $fullname; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $pd_name; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $od_qty; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo number_format($od_price, 2); ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo number_format($sub_total, 2); ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo number_format($od_discount, 2); ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo number_format($alltotal, 2); ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $released_by; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $invoice_num; ?></td>
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
										<td class="tdlabel" style="text-decoration-line: underline; text-decoration-style: double;"><?php echo number_format($grand_total, 2); ?></td>
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
	</td></tr>
	</table>