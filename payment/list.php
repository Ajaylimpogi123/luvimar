<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$sql = "SELECT *
			FROM tr_payment p, bs_customer c
				WHERE p.cust_id = c.cust_id AND p.is_deleted != '1'
					GROUP BY p.cust_id
						ORDER BY c.client_name DESC";
$result = dbQuery($sql);

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>		
		<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-certificate"></i> List of Payments</h2>						
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
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>Company</th>
								  <th>Contact Person</th>								  
								  <th>Contact No.</th>								 
								  <th>Address</th>								  
							  </tr>
						  </thead>
						  <tbody>
							<?php
								if($numrows > 0)
								{
									$ctr = 1;
									while($row = dbFetchAssoc($result))
									{
										extract($row);
										
										$cname = ucwords(strtolower($customer_name));
																			
							?>
										<!-- Start display list of orders !-->
										<tr>											
											<td><a href="javascript:detail(<?php echo $cust_id; ?>);"><?php echo $client_name; ?></a></td>
											<td><?php echo $contact_person; ?></td>											
											<td><?php echo $contactno; ?></td>
											<td><?php echo $address; ?></td>
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
						