<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$userId = $_SESSION['user_id'];
	
$user = $conn->prepare("SELECT * FROM bs_user
			WHERE user_id = '$userId'");
$user->execute();
$user_data = $user->fetch();	

	/* Select data from database */
	$sql = $conn->prepare("SELECT * FROM bs_supplier WHERE is_deleted != '1'");
	$sql->execute();

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>		
		<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon icon-black icon-users"></i> List of Suppliers</h2>
						<?php if($user_data['is_sup_a_access'] == 1){ ?>
							&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:add();" class="btn btn-success">Add New</a>
							<?php }else{} ?>
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
								  <th>Name</th>								  
								  <th>Contact No</th>
								  <th>Picture</th>								 
								  <th>Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
							<?php
								if($sql->rowCount() > 0)
								{
									while($sql_data = $sql->fetch())
									{						
										$name = $sql_data['lastname'] . ', ' . $sql_data['firstname'];
										if ($sql_data['image']) {
											$image = WEB_ROOT . 'images/supplier/' . $sql_data['image'];
										} else {
											$image = WEB_ROOT . 'images/supplier/noimagesmall.png';
										}
																				
							?>
										<!-- Start display list of users !-->
										<tr>											
											<td>
												<a href="javascript:view(<?php echo $sql_data['sup_id']; ?>);">
													<?php echo $sql_data['company_name']; ?>
												</a>
											</td>											
											<td><?php echo $sql_data['contactno']; ?></td>
											<td><img class="dashboard-avatar" alt="<?php echo $name; ?>" src="<?php echo $image; ?>" /></td>
											<td class="center">	
											<?php if($user_data['is_sup_e_access'] == 1){ ?>
													<a class="btn btn-primary" href="javascript:mod(<?php echo $sql_data['sup_id']; ?>);">
														<i class="icon-edit icon-white"></i>  
														Edit                                            
													</a>		
											<?php }else{ echo "-- --"; }?>
												<?php if($user_data['is_sup_d_access'] == 1){ ?>
													<a class="btn btn-danger" href="javascript:del(<?php echo $sql_data['sup_id']; ?>);">
														<i class="icon-trash icon-white"></i> 
														Delete
													</a>	
											<?php }else{ echo "-- --"; }?>
											</td>
										</tr>
										<!-- End display list of users !-->
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
						