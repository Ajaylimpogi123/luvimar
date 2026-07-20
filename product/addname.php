<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$num_str = sprintf("%06d", mt_rand(1, 999999));

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';
?>


<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-plus-sign"></i> Add Product</h2>
		</div>

		<form class="form-horizontal" method="post" action="process.php?action=addname" enctype="multipart/form-data" name="form" id="form">
			<div class="box-content">
				<?php
				if ($errorMessage == 'Added successfully') {
				?>
					<div class="valid_box">
						<b><?php echo $errorMessage; ?></b>
					</div>
				<?php
				} else if ($errorMessage == 'Serial # Already Taken! Data entry failed.') {
				?>
					<div class="error_box">
						<b><?php echo $errorMessage; ?></b>
					</div>
				<?php
				} elseif ($errorMessage == 'Deleted successfully') {
				?>
					<div class="valid_box">
						<b><?php echo $errorMessage; ?></b>
					</div>
				<?php
				} else {
				} ?>
				<fieldset>
		
					<div class="control-group">
						<label class="control-label" for="focusedInput">Product Name</label>
						<div class="controls">
							<input class="input-xlarge focused" id="prodname" name="prodname" type="text" autocomplete=off required />
							<div id="status"></div>
						</div>
					</div>

				
				
				</fieldset>
			</div>
			<div class="form-actions">
				<button type="submit" class="btn btn-success">Save</button>
				<input type="button" value="Cancel" onclick="window.location.href='index.php'" class="btn btn-danger">
			</div>
		</form>

	</div>
</div><!--/span-->