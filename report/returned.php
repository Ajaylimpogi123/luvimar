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

	
	/*$supplier = $_POST['supplier'];
	if($supplier != 0)
	{
		$cus1 = "SELECT * FROM bs_supplier WHERE sup_id = '$supplier'";
		$rs_cus1 = dbQuery($cus1);
		$rw_cust1 = dbFetchAssoc($rs_cus1);
		$cust_state = "AND sup_id = '$supplier'";
		$cust_label = $rw_cust1['company_name'];
	}else{
		$cust_state = "";
		$cust_label = "All";
	}*/
	

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>		
<head>		
<title>Returned Product Report</title>
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
			<td><img src="<?php echo WEB_ROOT; ?>images/logo.svg" style="height: 80px; width:300px;" /></td>
			<td>&nbsp; &nbsp;</td>
			<td>
				<h3>Returned Product Report</h3>
				<h4><?php echo $wfrom; ?> to <?php echo $wto; ?></h4>
			</td>
		</tr>
		<table>
		<br />
		<table style="margin:auto;">
		<tr><td>		
			<table style="padding:7px;">
			<tr>
				<td class="tdlabel">#</td>
				<td width="20px;">&nbsp;</td>
				<td class="tdlabel">Date Returned</td>				
				<td width="20px;">&nbsp;</td>
				<td class="tdlabel" valign="top">
					<table border="0">
					<tr>
						<td class="tdlabel" width="170">Product</td>
						<td width="20px;">&nbsp;</td>
						<td class="tdlabel" width="40">Qty Returned</td>						
					</tr>
					</table>
				</td>
				<td width="20px;">&nbsp;</td>
				<td class="tdlabel">Returned By</td>				
			</tr>
			<tr>
				<td colspan="7"><hr color='black' /></td>
			</tr>
								  <tbody>
									<?php
										$emp = "SELECT * FROM tbl_returned
													WHERE (date_added_ymd BETWEEN '$newfrom' and '$newto')
																	ORDER BY date_added_ymd";
										$rs_emp = dbQuery($emp);
										$num_emp = dbNumRows($rs_emp);
										if($num_emp > 0)
										{
											$ctr1 = 1;
											while($rw_emp = dbFetchAssoc($rs_emp))
											{
												extract($rw_emp);
												
												$datereceived = date("M d, Y | h:i A", strtotime($date_added));
												
												$rby = "SELECT * FROM bs_user WHERE user_id = '$added_by'";
												$rs_rby = dbQuery($rby);
												$num_rby = dbNumRows($rs_rby);
												if($num_rby > 0)
												{ 
													$rw_rby = dbFetchAssoc($rs_rby);
													$received_by = utf8_encode(ucwords(strtolower($rw_rby['lastname']))) . ',&nbsp;' . ucwords(strtolower($rw_rby['firstname'])); 
												}else{ $received_by = '- -'; }
												
												/*$s7 = "SELECT * FROM bs_supplier WHERE sup_id = '$sup_id'";
												$rs_s7 = dbQuery($s7);
												$num_s7 = dbNumRows($rs_s7);
												if($num_s7 > 0)
												{ 
													$rw_s7 = dbFetchAssoc($rs_s7);
													$company_name = utf8_encode(ucwords(strtolower($rw_s7['company_name']))); 
												}else{ $company_name = '- -'; }*/
									?>
												<tr>
													<td class="tddata" valign="top"><?php echo $ctr1++; ?>. </td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $datereceived; ?></td>													
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top">
														<table border="0">
														<?php 
															$lst = "SELECT * FROM tbl_returned_item i, tbl_product p
																				WHERE i.ret_id = '$ret_id' AND i.pd_id = p.pd_id";
															$rs_lst = dbQuery($lst);
															$num_lst = dbNumRows($rs_lst);
															if($num_lst > 0)
															{
																$total_amount = 0;
																while($rw_lst = dbFetchAssoc($rs_lst))
																{
																	extract($rw_lst);			

																	if($pd_type == 'pc')
																	{ $tp = 'PC'; }
																	else if($pd_type == 'ib')
																	{ $tp = 'BX'; }
																	else{ $tp = 'CS'; }
														?>
																	<tr>
																		<td class="tddata" valign="top" width="170"><?php echo $pd_name; ?></td>
																		<td width="20px;">&nbsp;</td>
																		<td class="tddata" valign="top" width="70"><?php echo $od_qty_added; ?> <?php echo $tp; ?></td>																		
																	</tr>
														<?php
																} // End While
													
															}else{}
														?>
														</table>
													</td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $received_by; ?></td>													
												</tr>
									<?php
											} // End While
										}else{}
									?>
									<tr>
										<td colspan="7"><hr color='black' /></td>
									</tr>
									<tr style="border-top: 1px;">
										<td colspan="7" align="center">*** Nothing Follows ***</td>
									</tr>
					  </tbody>
			</table>            
		</td></tr>
		</table>			