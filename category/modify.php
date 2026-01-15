<?php
if (!defined('WEB_ROOT')) {
	exit;
}


// make sure a category id exists
if (isset($_GET['catId']) && (int)$_GET['catId'] > 0) {
	$catId = (int)$_GET['catId'];
} else {
	header('Location:index.php');
}	
	
$sql = $conn->prepare("SELECT cat_id, cat_parent_id, cat_name, cat_description, cat_image
		FROM tbl_category
		WHERE cat_id = $catId");
$sql->execute();
$sql_data = $sql->fetch();

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';

if($sql_data['cat_parent_id'] != 0)
{	
	$catlegend = 'Brand';	
}else{	
	$catlegend = 'Category';
	
}
?> 

		<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Modify <?php echo $catlegend; ?></h2>											
					</div>
					
					<form class="form-horizontal" method="post" action="processCategory.php?action=modify&catId=<?php echo $catId; ?>" enctype="multipart/form-data" name="form" id="form">
					<div class="box-content">
							<?php
								if($errorMessage == 'Modified successfully')
								{
							?>
									<div class="valid_box">
										<b><?php echo $errorMessage; ?></b>
									</div>
							<?php
								}
								else if($errorMessage == 'Category already exist! Data entry failed.')
								{
							?>
									<div class="error_box">
										<b><?php echo $errorMessage; ?></b>
									</div>
							<?php
								}
								else if($errorMessage == 'Image deleted successfully')
								{
							?>
									<div class="valid_box">
										<b><?php echo $errorMessage; ?></b>
									</div>
							<?php								
								}else{}
							?>
							<fieldset>							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput"><?php echo $catlegend; ?> Name</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="txtName" name="txtName" type="text" value="<?php echo $sql_data['cat_name']; ?>" autocomplete=off required />
								  <div id="status"></div>
								</div>
							  </div>							  							 
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Description</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="mtxDescription" name="mtxDescription" type="text" value="<?php echo $sql_data['cat_description']; ?>" autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  							  
							  <div class="control-group">
								<label class="control-label" for="fileInput">Picture</label>
								<div class="controls">
									<input class="input-file uniform_on" name="fileImage" id="fileInput" type="file" />
								</div>
							  </div>							  
							</fieldset>
					</div>
							<div class="form-actions">
								<input name="hidParentId" type="hidden" id="hidParentId" value="<?php echo $parentId; ?>">
								<button type="submit" class="btn btn-success">Save</button>
								<input type="button" value="Cancel" onclick="window.location.href='index.php'" class="btn btn-danger">
							</div>							
					</form>
					
				</div>
					
					<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-picture"></i> Picture</h2>
					</div>
										
					<div class="box-content">
						<?php
							// Display image of category
							if ($sql_data['cat_image']) 
							{
								$image = WEB_ROOT . 'images/category/' . $sql_data['cat_image'];
						?>
								<img src="<?php echo $image; ?>" />
								<br /><br />
									<a class="btn btn-danger" href="javascript:deleteImage(<?php echo $sql_data['cat_id']; ?>);"><i class="icon-trash icon-white"></i> Delete Image</a>
						<?php
							} else {
								$image = WEB_ROOT . 'images/category/noimagelarge.png';
						?>
								<img src="<?php echo $image; ?>" />
						<?php
							}	
						?>
						
					</div>
				</div>	
		</div><!--/span-->					