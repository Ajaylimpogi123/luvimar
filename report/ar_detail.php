<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

	$userId = $_SESSION['user_id'];	
	
	$customer = $_POST['customer'];
	$dfrom = $_POST['from'];
	$dto = $_POST['to'];

	# Get user
	$usr = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$userId'");
	$usr->execute();
	$usr_data = $usr->fetch();
	$isadmin = $usr_data['access_level'];
	if($isadmin == 1)
	{
		$statement = '';
	}else{
		$statement = "AND t.released_by = '$userId'";
	}
	
	if($customer != 0)
	{
		$cus1 = $conn->prepare("SELECT * FROM bs_customer WHERE cust_id = '$customer'");
		$cus1->execute();
		$cust1_data = $cus1->fetch();
		$cust_state = "AND t.cust_id = '$customer'";
		$cust_label = $cust1_data['client_name'];
	}else{
		$cust_state = "";
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
<title>Accounts Receivable</title>
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
		<div class="row-fluid sortable">		
				<div class="box span6">
					<div class="box-header well" data-original-title>
						<center><table>
						<tr>
							<td><img src="<?php echo WEB_ROOT; ?>images/logo.svg" style="height: 80px; width:300px;" /></td>
							<td><h3>Accounts Receivable - <?php echo $cust_label; ?></h3><h4><?php echo $wfrom; ?> to <?php echo $wto; ?></h4></td>
						</tr>
						</table></center>
					</div>
					<br />
					<div class="box-content">
						<center><table style="padding:7px; font-size:14px;" width="1300" border="0">
						<tr>
							<td class="tdlabel">#</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Customer</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel" valign="top">
								<table border="0">
								<tr>
									<td class="tdlabel" width="170">Order Date</td>
									<td width="20px;">&nbsp;</td>
									<td class="tdlabel" width="100">Invoice #</td>
									<td width="20px;">&nbsp;</td>
									<td class="tdlabel" width="130">PO #</td>
									<td width="20px;">&nbsp;</td>
									<td class="tdlabel" width="100">Terms</td>									
									<td width="20px;">&nbsp;</td>
									<td class="tdlabel" width="100">Due Date</td>									
									<td width="20px;">&nbsp;</td>
									<td class="tdlabel" width="100" style="text-align:right;">Amount</td>
									<td width="70px;">&nbsp;</td>
									<td class="tdlabel" width="100">Received By</td>
								</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="13">
								<hr color='black' />
							</td>
						</tr>
								  <tbody>
									<?php
										$emp = $conn->prepare("SELECT *, SUM(od_total_amt_due) as total_amt FROM tbl_order t, bs_customer c
													WHERE t.cust_id = c.cust_id AND t.is_deleted != '1' AND t.is_paid != '1'
															AND (t.od_date_1 BETWEEN '$newfrom' and '$newto') $statement $cust_state
																GROUP BY t.cust_id, t.od_id
																	ORDER BY c.client_name, t.od_date");
										$emp->execute();
										if($emp->rowCount() > 0)
										{
											$ctr1 = 1; $total = 0;
											while($emp_data = $emp->fetch())
											{
												$datereleased = date("M d, Y", strtotime($emp_data['od_date']));
												
												$rby = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$emp_data[released_by]'");
												$rby->execute();

												if($rby->rowCount() > 0)
												{ 
													$rby_data = $rby->fetch();
													$released_by = utf8_encode(ucwords(strtolower($rby_data['lastname']))) . ',&nbsp;' . ucwords(strtolower($rby_data['firstname'])); 
												}else{ $released_by = '- -'; }
																							
																																				
												$total += $emp_data['total_amt'];
												// Check if items are for drop off
												$lst = $conn->prepare("SELECT * FROM tbl_order t
																	WHERE t.cust_id = '$emp_data[cust_id]' AND t.is_deleted != '1' AND t.is_paid != '1'
																		AND (t.od_date_1 BETWEEN '$newfrom' and '$newto') $statement $cust_state");
												$lst->execute();
												
									?>
												<tr>
													<td class="tddata" valign="top"><?php echo $ctr1++; ?>. </td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $emp_data['client_name']; ?></td>													
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top">
														<table border="0">
														<?php 
															
															if($lst->rowCount() > 0)
															{
																$total_amount = 0;
																while($lst_data = $lst->fetch())
																{
																	$odate = date("M d, Y | h:i a", strtotime($lst_data['od_date']));
																	$duedate = date("M d, Y", strtotime($lst_data['date_due']));																	
																	
																	$bal = $conn->prepare("SELECT SUM(amount_paid) as total_pay FROM tr_payment WHERE cust_id = '$emp_data[cust_id]' AND od_id = '$emp_data[od_id]'");
																	$bal->execute();
																	$bal_data = $bal->fetch();
																	$total_pay = $bal_data['total_pay'];
																	$total_balance = $lst_data['od_total_amt_due'] - $total_pay;
																	
																	$total_amount += $total_balance;
														?>
																	<tr>
																		<td class="tddata" valign="top" width="170"><?php echo $odate; ?></td>
																		<td width="20px;">&nbsp;</td>
																		<td class="tddata" valign="top" width="100"><?php echo $lst_data['invoice_num']; ?></td>
																		<td width="20px;">&nbsp;</td>
																		<td class="tddata" valign="top" width="130"><?php echo $lst_data['po_num']; ?></td>
																		<td width="20px;">&nbsp;</td>
																		<td class="tddata" valign="top" width="100"><?php echo number_format($lst_data['terms_in_days'], 0); ?>days</td>
																		<td width="20px;">&nbsp;</td>
																		<td class="tddata" valign="top" width="100"><?php echo $duedate; ?></td>
																		<td width="20px;">&nbsp;</td>
																		<td class="tddata" valign="top" width="100" style="text-align:right;"><?php echo number_format($total_balance, 2); ?></td>
																		<td width="70px;">&nbsp;</td>
																		<td class="tddata" valign="top" width="100"><?php echo $lst_data['person_received']; ?></td>
																	</tr>
														<?php
																} // End While
														?>
																	<tr><td colspan="11" class="tddata" style="text-align:right;"><b><?php echo number_format($total_amount, 2); ?></b><br /><br /></td></tr>
														<?php
															}else{}
														?>
														</table>
													</td>
												</tr>
									<?php
											} // End While
									?>
												<tr>
													<td colspan="13"><hr color='black' /></td>
												</tr>												
												<!--<tr>
													<td colspan="2" align="center"></td>
													<td class="tdlabel">Total</td>
													<td width="20px;"> : </td>
													<td class="tdlabel"><?php echo number_format($total, 2); ?></td>													
												</tr>!-->
												<tr>
													<td colspan="13" align="center">*** Nothing Follows ***</td>
												</tr>
									<?php
										}else{}
									?>
								  </tbody>
						</table>
						<br />
						<table style="padding:7px; font-size:14px;" width="1000">
						<tr>
							<td>Prepared by:<br /><br />__________________<br />Signature over Printed Name</td>
							<td>Checked by:<br /><br />__________________<br />Signature over Printed Name</td>
							<td>Received by:<br /><br />__________________<br />Signature over Printed Name</td>
						</tr>
						</table>
						</center>           
					</div>
				</div><!--/span-->
		</div><!--/row-->