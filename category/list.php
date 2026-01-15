<?php
if (!defined('WEB_ROOT')) {
	exit;
}

if (isset($_GET['catId']) && (int)$_GET['catId'] >= 0) {
	$catId = (int)$_GET['catId'];
	$queryString = "&catId=$catId";
} else {
	$catId = 0;
	$queryString = '';
}
	
// for paging
// how many rows to show per page
$rowsPerPage = 5;

$userId = $_SESSION['user_id'];
	
$user = $conn->prepare("SELECT * FROM bs_user
			WHERE user_id = '$userId'");
$user->execute();
$user_data = $user->fetch();	

$sql = $conn->prepare("SELECT cat_id, cat_parent_id, cat_name, cat_description, cat_image
        FROM tbl_category
		WHERE cat_parent_id = $catId AND is_deleted != '1'
		ORDER BY cat_name");
$sql->execute();
$pagingLink = getPagingLink($sql, $rowsPerPage);
$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';
if($catId != 0)
{ $catlegend = 'Brand'; }else{ $catlegend = 'Category'; }


?>
		<div class="row-fluid sortable">		
			<form action="processCategory.php?action=addCategory" method="post"  name="frmListCategory" id="frmListCategory">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-th-large"></i> List of Categories</h2>
						<?php if($user_data['is_cat_a_access'] == 1){ ?>
							&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:addCategory(<?php echo $catId; ?>);" class="btn btn-success">Add New</a>
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
								  <th><?php echo $catlegend; ?></th>
								  <th>Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
							<?php
								if($sql->rowCount() > 0)
								{
									while($sql_data = $sql->fetch())
									{																
										if ($sql_data['cat_parent_id'] == 0) {
											$sql_data['cat_name'] = "Add brand under <a href=\"index.php?catId=$sql_data[cat_id]\">$sql_data[cat_name]</a>";
										}
										
										if ($sql_data['cat_image']) {
											$cat_image = WEB_ROOT . 'images/category/' . $sql_data['cat_image'];
										} else {
											$cat_image = WEB_ROOT . 'images/no-image-small.png';
										}		
																				
							?>
										<!-- Start display list of categories !-->
										<tr>											
											<td><?php echo $sql_data['cat_name']; ?></td>
											<td class="center">
											<?php if($user_data['is_cat_e_access'] == 1){ ?>
												<a class="btn btn-primary" href="javascript:modifyCategory(<?php echo $sql_data['cat_id']; ?>);" title="Edit">
													<i class="icon-edit icon-white"></i>  
													Edit
												</a>
											<?php }else{ echo "-- --"; }?>
											<?php if($user_data['is_cat_d_access'] == 1){ ?>
												<a class="btn btn-danger" href="javascript:deleteCategory(<?php echo $sql_data['cat_id']; ?>);" title="Delete">
													<i class="icon-trash icon-white"></i> 
													Delete
												</a>
											<?php }else{ echo "-- --"; }?>
											</td>
										</tr>
										<!-- End display list of categories !-->
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
			</form>
		</div><!--/row-->