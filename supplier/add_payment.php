<?php
if (!defined('WEB_ROOT')) {
	exit;
}
	
	$id = $_GET['id'];
	$oi = $_GET['oi'];
	
	$sql = $conn->prepare("SELECT * FROM bs_supplier WHERE sup_id = '$id' AND is_deleted != '1'");
	$sql->execute();
	$sql_data = $sql->fetch();
	
	$sql2 = $conn->prepare("SELECT *
				FROM tbl_received
					WHERE rec_id = '$oi' AND is_deleted != '1' AND is_charge = '1'");
	$sql2->execute();
	$sql2_data = $sql2->fetch();
	
	$bal = $conn->prepare("SELECT SUM(amount_paid) as total_pay FROM tr_payment_supplier WHERE sup_id = '$id' AND rec_id = '$oi'");
	$bal->execute();
	$bal_data = $bal->fetch();
	$total_pay = $bal_data['total_pay'];
	$total_balance = $sql2_data['total_cost'] - $total_pay;
	
	if($total_balance == 0)
	{ $dsg = "readonly"; }else{ $dsg = ""; }
	
$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>


		<div class="row-fluid sortable">
				<div class="box span12">
				<form class="form-horizontal" method="post" action="processPayment.php" enctype="multipart/form-data" name="form" id="form">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Update Payment - <small style="font-size:14px;">Supplier</small></h2>
						<?php if($total_balance == 0){}else{ ?>
							&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-success" onClick="return confirmSubmit()">Save</button>
						<?php } ?>
						<input type="hidden" name="cid" value="<?php echo $id; ?>" />
						<input type="hidden" name="oid" value="<?php echo $oi; ?>" />
						<div class="box-icon">																					
							<a href="../" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>							
						</div>
					</div>
					<div class="box-content">
							<?php
								if($errorMessage == 'Saved successfully')
								{
							?>
									<div class="valid_box">
										<b><?php echo $errorMessage; ?></b>
									</div>
							<?php
								}else{}
							?>
						<table class="table table-striped table-bordered">
						  <tbody>
							  <tr>
								  <td><b>Company Name</b></td>
								  <td> : </td>
								  <td><?php echo utf8_encode($sql_data['company_name']); ?></td>
								  <td></td>
								  <td><b>DR/Invoice #</b></td>
								  <td> : </td>
								  <td><?php echo utf8_encode($sql2_data['dr_num']); ?></td>
								  <td></td>
								  <td><b>Term in Days</b></td>
								  <td> : </td>
								  <td><?php echo utf8_encode($sql2_data['terms']); ?></td>
							  </tr>
							  <tr>
								  <td><b>Amount Payable</b></td>
								  <td> : </td>
								  <td>Php <?php echo number_format($sql2_data['total_cost'], 2); ?></td>
										<input type="hidden" name="arec" value="<?php echo $total_balance; ?>" />
								  <td></td>
								  <td><b>Paid Amount</b></td>
								  <td> : </td>
								  <td><input class="input-xlarge focused" id="camt" name="camt" type="text" onKeyUp="checkNumber(this);" required autocomplete=off style="width:100px;" <?php echo $dsg; ?> /></td>
								  <td></td>
								  <td><b>Balance</b></td>
								  <td> : </td>
								  <td style="color:<?php echo $bcolor; ?>;">Php <?php echo number_format($total_balance, 2); ?></td>
							  </tr>
							  <tr>
								  <td><b>Date Paid</b></td>
								  <td></td>
								  <td><input type="text" class="input-xlarge" id="txtFromDate" name="from" onkeypress="return isNumberKey(event)" required autocomplete=off style="width:100px;" <?php echo $dsg; ?> /></td>
								  <td></td>
								  <td><b>OR Number</b></td>
								  <td></td>
								  <td><input class="input-xlarge focused" id="or" name="or" type="text" required autocomplete=off style="width:100px;" <?php echo $dsg; ?> /></td>
								  <td></td>
								  <td><b>Payment Method</b></td>
								  <td> : </td>
								  <td>
										<label class="radio">
											<input type="radio" class="payment_method" name="top" id="optionsRadios1" value="Cash" checked="" />Cash
										</label>	
										<br />
										<label class="radio">
											<input type="radio" class="payment_method" name="top" id="optionsRadios2" value="Check" />Check
										</label>
								  </td>
							  </tr>
							  <tr id="cust_name1" style="display:none">
								  <td><b>Check No.</b></td>
								  <td> : </td>
								  <td><input class="input-xlarge focused" id="checknum" name="checknum" type="text" autocomplete=off style="width:100px;" <?php echo $dsg; ?> /></td>
								  <td></td>
								  <td><b>Check Date</b></td>
								  <td> : </td>
								  <td><input class="input-xlarge focused" id="txtToDate" name="checkdate" type="text" autocomplete=off style="width:100px;" <?php echo $dsg; ?> /></td>
								  <td></td>
								  <td><b>Bank</b></td>
								  <td> : </td>
								  <td><input class="input-xlarge focused" id="bank" name="bank" type="text" autocomplete=off style="width:100px;" <?php echo $dsg; ?> /></td>
							  </tr>							  
						  </tbody>
						</table>
						<a class="btn btn-primary" href="index.php?view=due&id=<?php echo $id; ?>">Back</a>
					</div>
				</form>
				</div>
		</div>
		
		<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-certificate"></i> Payment History - <small style="font-size:14px;">Supplier</small></h2>
						<div class="box-icon">
						
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered">
						  <thead>
							  <tr>
								  <th>Mode</th>
								  <th>Date Paid</th>
								  <th>OR Number</th>
								  <th>Amount Due</th>
								  <th>Amount Paid</th>
								  <th>Balance</th>								  
							  </tr>
						  </thead>   
						  <tbody>
							<?php
								$sql3 = $conn->prepare("SELECT * FROM tr_payment_supplier p, bs_supplier c
											WHERE p.is_deleted != '1' AND c.sup_id = p.sup_id AND p.rec_id = '$oi'
													ORDER BY p.date_paid, p.pays_id DESC");
								$sql3->execute();

								if($sql3->rowCount() > 0)
								{
									$ctr = 1;
									while($sql3_data = $sql->fetch())
									{
										$dr = date("M d, Y", strtotime($sql3_data['date_paid']));
										if($balance == 0)
										{ $bcolor = "#66cc00"; }else{ $bcolor = "#ff0000"; }
										
										if($sql3_data['payment_method'] == "Check")
										{
											$chkdate = date("M d, Y", strtotime($sql3_data['check_date']));
											$oh_con = '<span class=green>Check No.:</span> ' . $sql3_data['check_no'] . '<br /><span class=green>Check Date:</span> ' . $chkdate . '<br /><span class=green>Bank:</span> ' . $sql3_data['bank'];
											$chklink = "<a href='#' data-rel='popover' data-content='" . $oh_con . "' title='Check Details'>Check</a>";
										}else{ $oh_con = ""; $chklink = "Cash";}
																				
							?>
										<!-- Start display list of purchase orders !-->
										<tr>
											<td><?php echo $chklink; ?></td>
											<td><?php echo $dr; ?></td>
											<td><?php echo $sql3_data['or_number']; ?></td>
											<td>Php <?php echo number_format($sql3_data['amount_due'], 2); ?></td>
											<td>Php <?php echo number_format($sql3_data['amount_paid'], 2); ?></td>
											<td style="color:<?php echo $bcolor; ?>;">Php <?php echo number_format($balance, 2); ?></td>
										</tr>
										<!-- End display list of purchase orders !-->
							<?php
									}
								}
								else
								{}
							?>
							
						  </tbody>
						</table>
					</div>
				</div><!--/span-->
			
			</div><!--/row-->
		
<script type="text/javascript">

	$(".payment_method").click(function(){


		var value_checked = $(this).val();
		
		// Check Number
		if(value_checked == "Check"){
			$("#cust_name1").show();
		}
		else{
			$("#cust_name1").hide();
		}
		// Check Date
		if(value_checked == "Check"){
			$("#cust_name2").show();
		}
		else{
			$("#cust_name2").hide();
		}
		// Check Bank
		if(value_checked == "Check"){
			$("#cust_name3").show();
		}
		else{
			$("#cust_name3").hide();
		}
		
});

</script>