<?php
if (!defined('WEB_ROOT')) {
	exit;
}


// make sure id exists
if (isset($_GET['id']) && (int)$_GET['id'] > 0) {
	$exid = (int)$_GET['id'];
} else {
	header('Location:index.php');
}	
	
$sql = $conn->prepare("SELECT *
		FROM tr_expense
		WHERE exp_id = $exid");
$sql->execute();
$sql_data = $sql->fetch();

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';

?> 

		<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Modify Expense</h2>											
					</div>
					
					<form class="form-horizontal" method="post" action="process.php?action=modify" enctype="multipart/form-data" name="form" id="form">
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
								else if($errorMessage == 'Expense already exist! Data entry failed.')
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
								<label class="control-label" for="focusedInput">Amount</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="amount" name="amount" type="text" value="<?php echo $sql_data['amount']; ?>" required autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>							  							 
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Details</label>
								<div class="controls">
								  <textarea name="details" rows="20" cols="20"><?php echo $sql_data['details']; ?></textarea>
								  <div id="status"></div>
								</div>
							  </div>
							</fieldset>
					</div>
							<div class="form-actions">
								<input name="id" type="hidden" id="id" value="<?php echo $exid; ?>"></td>
								<button type="submit" class="btn btn-success">Save</button>
								<input type="button" value="Cancel" onclick="window.location.href='index.php'" class="btn btn-danger">
							</div>							
					</form>
					
				</div>
		</div><!--/span-->					