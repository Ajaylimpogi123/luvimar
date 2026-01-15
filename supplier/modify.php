<?php
if (!defined('WEB_ROOT')) {
	exit;
}

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

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'

?>		
		<div class="row-fluid sortable">
				<div class="box span8">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Modify Supplier</h2>						
					</div>
					
					<form class="form-horizontal" method="post" enctype="multipart/form-data" action="processModify.php">
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
								<label class="control-label" for="focusedInput">Company Name</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="sn" name="sn" type="text" value="<?php echo $sql_data['company_name']; ?>" required autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">First Name</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="firstname" name="firstname" type="text" value="<?php echo $sql_data['firstname']; ?>" autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>							  							 
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Last Name</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="lastname" name="lastname" type="text" value="<?php echo $sql_data['lastname']; ?>" autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Contact No</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="cn" name="cn" type="text" value="<?php echo $sql_data['contactno']; ?>" autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Address</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="address" name="address" type="text" value="<?php echo $sql_data['address']; ?>" autocomplete=off />
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
								<input type="hidden" name="id" value="<?php echo $sql_data['sup_id']; ?>" />
								<button type="submit" class="btn btn-success">Save Changes</button>								
								<input type="button" value="Cancel" onclick="window.location.href='index.php'" class="btn btn-danger" />								
							</div>							
					</form>					
				</div>
				
				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-picture"></i> Picture</h2>
					</div>
										
					<div class="box-content">
						<?php
							// Display image of supplier
							if ($sql_data['image']) 
							{
								$image = WEB_ROOT . 'images/supplier/' . $sql_data['image'];
						?>
								<img src="<?php echo $image; ?>" />
								<br /><br />
									<a class="btn btn-danger" href="javascript:delimg(<?php echo $sql_data['sup_id']; ?>);"><i class="icon-trash icon-white"></i> Delete Image</a>
						<?php
							} else {
								$image = WEB_ROOT . 'images/supplier/noimagelarge.png';
						?>
								<img src="<?php echo $image; ?>" />
						<?php
							}	
						?>
						
					</div>
				</div>	
				
		</div><!--/span-->								
			