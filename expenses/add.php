<?php
if (!defined('WEB_ROOT')) {
	exit;
}
$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';

?> 

		<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-plus-sign"></i> Add Expense</h2>											
					</div>
					
					<form class="form-horizontal" method="post" action="process.php?action=add" enctype="multipart/form-data" name="form" id="form">
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
									<label class="control-label" for="focusedInput">Expense Name</label>
										<div class="controls">
							<select id="selectError4" name="exp_cat" id="pid" data-rel="chosen" required>
								<option value="">-SELECT-</b></option>
								<?php
								$prd = $conn->prepare("SELECT * FROM tr_expense_category WHERE is_deleted != '1'");
								$prd->execute();
								if ($prd->rowCount() > 0) {
									while ($prd_data = $prd->fetch()) {
								?>
										<option value="<?php echo $prd_data['ec_id']; ?>"><?php echo $prd_data['expense_category_name']; ?></option>
								<?php
									} // End While
								} else {
								}
								?>
							</select>
						</div>
						</div>
							  
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Amount</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="amount" name="amount" type="text" required autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>							  							 
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Details</label>
								<div class="controls">
								  <textarea name="details" rows="20" cols="20"></textarea>
								  <div id="status"></div>
								</div>
							  </div>
							</fieldset>
					</div>
							<div class="form-actions">								
								<button type="submit" class="btn btn-success">Save</button>
								<input type="button" value="Cancel" onclick="window.location.href='index.php';" class="btn btn-danger">
							</div>							
					</form>
					
					</div>
		</div><!--/span-->					