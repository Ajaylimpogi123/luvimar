<?php
if (!defined('WEB_ROOT')) {
	exit;
}

	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("Y-m-d");

	if(isset($_POST['submit']))
	{
		$dfrom = $_POST['from']; 
		$dto = $_POST['to']; 
		$newfrom = date("Y-m-d", strtotime($dfrom));
		$newto = date("Y-m-d", strtotime($dto));
		if(($dfrom != '') && ($dto != '')){ $datefilter = "od_date_1 BETWEEN '$newfrom' and '$newto'"; }
	}else{ $dfrom = ""; $dto = ""; $datefilter = "od_date_1 = '$today_date2'"; }

$userId = $_SESSION['user_id'];
	
$user = $conn->prepare("SELECT * FROM bs_user
			WHERE user_id = '$userId'");
$user->execute();
$user_data = $user->fetch();	

$sql = $conn->prepare("SELECT * FROM tbl_order WHERE $datefilter AND is_deleted != '1' ORDER BY od_date DESC");
$sql->execute();

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>		
		<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-file"></i> List of Orders</h2>						
						<div class="box-icon">																					
							<a href="../" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>							
						</div>
					</div>
					<div class="box-content">
						<?php
								if($errorMessage == 'Deleted successfully')
								{
							?>
									<div class="valid_box">
										<b><?php echo $errorMessage; ?></b>
									</div>
							<?php
								}else{}
						?>
							<form method="post" action="index.php?view=list">
								<input type="text" class="input-xlarge" id="txtFromDate" name="from" onkeypress="return isNumberKey(event)" autocomplete=off placeholder="Date From" style="width:117px;" value="<?php echo $dfrom; ?>" />
								<input type="text" class="input-xlarge" id="txtToDate" name="to" onkeypress="return isNumberKey(event)" autocomplete=off placeholder="Date To" style="width:117px;" value="<?php echo $dto; ?>" />
								<input type="submit" name="submit" class="btn btn-success btn-round" value="Search" />
							</form>
						<table class="table table-striped table-bordered bootstrap-datatable">
						  <thead>
							  <tr>
								  <th>Order #</th>
								  <th>Customer</th>								  
								  <th>Payment Mode</th>								  
								  <th>Ref No.</th>								  
								  <th>Amount</th>								 
								  <th>Order Date</th>
								  <th>Action</th>
							  </tr>
						  </thead>   
						  <tbody>
							<?php
								if($sql->rowCount() > 0)
								{
									while($sql_data = $sql->fetch())
									{
										$cname = ucwords(strtolower($sql_data['customer_name']));
										$orderdate = date("M d, Y | h:i a",strtotime($sql_data['od_date']));
																				
							?>
										<!-- Start display list of orders !-->
										<tr>											
											<td><?php echo $sql_data['od_id']; ?></td>
											<td><?php echo $cname; ?></td>
											<td><?php echo $sql_data['payment_mode']; ?></td>
											<td><?php echo $sql_data['ref_num']; ?></td>
											<td>&#x20B1; <?php echo number_format($sql_data['od_total_amt_due'], 2); ?></td>
											<td><?php echo $orderdate; ?></td>
											<td class="center">
												<?php if($user_data['is_sale_v_access'] == 1){ ?>
													<a class="btn btn-primary" href="javascript:detail(<?php echo $sql_data['od_id']; ?>);">
														<i class="icon-edit icon-white icon-eye-open"></i>  
														view                                            
													</a>	
												<?php }else{ echo "-- --"; }?>
												<?php if($user_data['is_sale_d_access'] == 1){ ?>
													<a class="btn btn-danger" href="javascript:del(<?php echo $sql_data['od_id']; ?>);">
														<i class="icon-trash icon-white"></i> 
														Delete
													</a>
												<?php }else{ echo "-- --"; }?>
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
				</div><!--/span-->
			
			</div><!--/row-->
						