<?php
if (!defined('WEB_ROOT')) {
	exit;
}


$parentId = (isset($_GET['parentId']) && $_GET['parentId'] > 0) ? $_GET['parentId'] : 0;
$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';
if($parentId != 0)
{
	$ctl = $conn->prepare("SELECT * FROM tbl_category WHERE cat_id = $parentId");
	$ctl->execute();
	$ctl_data = $ctl->fetch();
	$catsul = ' under ' . $ctl_data['cat_name'];	
	$catlegend = 'Brand';	
}else{
	$catsul = '';
	$catlegend = 'Category';
	
}
?> 

		<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-plus-sign"></i> Add <?php echo $catlegend; ?> <?php echo $catsul; ?></h2>											
					</div>
					
					<form class="form-horizontal" method="post" action="processCategory.php?action=add" enctype="multipart/form-data" name="form" id="form">
					<div class="box-content">
							<?php
								if($errorMessage == 'Added successfully')
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
								}else{}
							?>
							<fieldset>							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput"><?php echo $catlegend; ?> Name</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="txtName" name="txtName" type="text" autocomplete=off required />
								  <div id="status"></div>
								</div>
							  </div>							  							 
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Description</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="mtxDescription" name="mtxDescription" autocomplete=off type="text" />
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
								<input name="hidParentId" type="hidden" id="hidParentId" value="<?php echo $parentId; ?>"></td>
								<button type="submit" class="btn btn-success">Save</button>
								<input type="button" value="Cancel" onclick="window.location.href='index.php?catId=<?php echo $parentId; ?>';" class="btn btn-danger">
							</div>							
					</form>
					
					</div>
		</div><!--/span-->					