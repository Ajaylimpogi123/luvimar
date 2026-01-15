<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

	$userId = $_SESSION['user_id'];	
		
	// make sure a id exists
	if (isset($_GET['id']) && $_GET['id'] > 0) {
		$id = $_GET['id'];
	} else {
	// redirect to index.php if id is not present
		header('Location: index.php');
	}
	
	/* Select data from database */
	$sql = $conn->prepare("SELECT * FROM bs_supplier WHERE sup_id = '$id' AND is_deleted != '1'");
	$sql->execute();
	$sql_data = $sql->fetch();
?>		
		<div class="row-fluid sortable">
			<div class="box span6">
				<div class="box-header well" data-original-title>
					<h2><i class="icon-user"></i> Supplier Details</h2>
				</div>
									
				<div class="box-content">		
					<table class="table table-striped table-bordered">
					<tr>
						<td>					
								<?php
									// Display image of supplier
									if ($sql_data['image']) 
									{
										$image = WEB_ROOT . 'images/supplier/' . $sql_data['image'];
								?>
										<img src="<?php echo $image; ?>" />								
								<?php
									} else {
										$image = WEB_ROOT . 'images/supplier/noimagelarge.png';
								?>
										<img src="<?php echo $image; ?>" />
								<?php
									}	
								?>
						</td>
						<td>&nbsp; &nbsp;</td>
						<td>
							<table>
							<tr>
								<td>Company Name</td>
								<td>&nbsp; : &nbsp;</td>
								<td><?php echo utf8_encode($sql_data['company_name']); ?></td>
							</tr>
							<tr>
								<td>Contact Person</td>
								<td>&nbsp; : &nbsp;</td>
								<td><?php echo $sql_data['lastname']; ?>, <?php echo $sql_data['firstname']; ?></td>
							</tr>
							<tr>
								<td>Address</td>
								<td>&nbsp; : &nbsp;</td>
								<td><?php echo $sql_data['address']; ?></td>
							</tr>							
							<tr>
								<td>Contact No.</td>
								<td>&nbsp; : &nbsp;</td>
								<td><?php echo $sql_data['contactno']; ?></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td><a class="btn btn-primary" href="index.php?view=detail&id=<?php echo $id; ?>">Back</a></td>
							</tr>
							</table>
						</td>
					</tr>
					</table>
				</div>
			</div>
			
			<div class="box span6">
				<div class="box-header well" data-original-title>
					<h2><i class="icon-calendar"></i> Due Dates</h2>
				</div>
									
				<div class="box-content">		
					<table class="table table-striped table-bordered bootstrap-datatable datatable">
					  <thead>
						  <tr>
							  <th>Due Date</th>
							  <th>DR/Invoice #</th>								  
							  <th>Amount Due</th>
							  <th>Balance</th>
							  <th>Payment</th>
						  </tr>
					  </thead>   
					  <tbody>
						<?php
							$sql = $conn->prepare("SELECT *
										FROM tbl_received
											WHERE sup_id = '$id' AND is_deleted != '1' AND is_charge = '1'												
													ORDER BY date_due DESC");
							$sql->execute();
							if($sql->rowCount() > 0)
							{
								$ctr = 1;
								while($sql_data = $sql->fetch())
								{
									$datedue = date("M d, Y",strtotime($sql_data['date_due']));
									
									$bal = $conn->prepare("SELECT SUM(amount_paid) as total_pay FROM tr_payment_supplier WHERE sup_id = '$id' AND rec_id = '$sql_data[rec_id]'");
									$bal->execute();
									$bal_data = $bal->fetch();
									$total_pay = $bal_data['total_pay'];
									$total_balance = $sql_data['total_cost'] - $total_pay;
									
									if($total_balance == 0)
									{ $dsg = "primary"; $lbl = "View"; $ok = "<i class='icon-ok'></i>"; $bcolor = "#66cc00"; }else{ $dsg = "success"; $lbl = "<i class='icon-plus-sign'></i> Add"; $ok = ""; $bcolor = "#ff0000"; }
						?>
									<!-- Start display list of orders !-->
									<tr>											
										<td><?php echo $datedue; ?></td>
										<td><?php echo $sql_data['dr_num']; ?></td>										
										<td>Php <?php echo number_format($sql_data['total_cost'], 2); ?></td>
										<td style="color:<?php echo $bcolor; ?>;">Php <?php echo number_format($total_balance, 2); ?></td>
										<td>
											<a class="btn btn-<?php echo $dsg; ?>" href="index.php?view=add_payment&id=<?php echo $sql_data['sup_id']; ?>&oi=<?php echo $sql_data['rec_id']; ?>">
												<?php echo $lbl; ?>												
											</a>
											&nbsp;
											<?php echo $ok; ?>
										</td>
									</tr>
									<!-- End display list of orders !-->
						<?php
								}
							}
							else
							{}
						?>
						
					  </tbody>
					</table>
				</div>
			</div>
		</div>
	