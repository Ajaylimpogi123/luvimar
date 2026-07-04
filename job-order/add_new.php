<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$num_str = sprintf("%06d", mt_rand(1, 999999));

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';
?>

<?php
if ($errorMessage == 'Added successfully') {
?>
	<div class="valid_box">
		<b><?php echo $errorMessage; ?></b>
	</div>
<?php
} else if ($errorMessage == 'Product already exist! Data entry failed.') {
?>
	<div class="error_box">
		<b><?php echo $errorMessage; ?></b>
	</div>
<?php
} else {
}
?>
<div class="row-fluid sortable">
	<div class="box span5">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-plus-sign"></i> Add Job - Brandnew</h2>
		</div>

		<form class="form-horizontal" method="post" action="processAdd_new.php" enctype="multipart/form-data" name="form" id="form">
			<div class="box-content">

				<fieldset>
					<div class="control-group">
						<label class="control-label" for="focusedInput">Branch</label>
						<div class="controls">
							<select name="branch" id="selectError1" data-rel="chosen" required>
								<?php
								$brn = $conn->prepare("SELECT * FROM bs_branch WHERE is_deleted != '1' ORDER BY date_added DESC");
								$brn->execute();
								if ($brn->rowCount() > 0) {
									while ($brn_data = $brn->fetch()) {
								?>
										<option value="<?php echo $brn_data['branch_id']; ?>"><?php echo $brn_data['branch_name']; ?></option>
								<?php
									} // End While
								} else {
								}
								?>
							</select>
							<div id="status"></div>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="focusedInput">Customer</label>
						<div class="controls">
							<select name="custname" id="selectError" data-rel="chosen" required>
								<?php
								$cus = $conn->prepare("SELECT * FROM bs_customer WHERE is_deleted != '1' ORDER BY client_name; ");
								$cus->execute();
								if ($cus->rowCount() > 0) {
									while ($cus_data = $cus->fetch()) {
								?>
										<option value="<?php echo $cus_data['cust_id']; ?>"><?php echo $cus_data['client_name']; ?></option>
								<?php
									} // End While
								} else {
								}
								?>
							</select>
							<div id="status"></div>
						</div>
					</div>

					<div id="refill" class="control-group">
						<label class="control-label" for="focusedInput">Product Name</label>
						<div class="controls">
							<select id="selectError4" name="pdId" id="pid" data-rel="chosen" required>
								<option value="">-SELECT-</b></option>
								<?php
								$prd = $conn->prepare("SELECT * FROM tbl_product WHERE is_deleted != '1' AND cat_id != '6' AND pd_id NOT IN (SELECT pd_id FROM tbl_jo_items_new WHERE is_deleted != '1' AND is_submitted != 1)");
								$prd->execute();
								if ($prd->rowCount() > 0) {
									while ($prd_data = $prd->fetch()) {
								?>
										<option value="<?php echo $prd_data['pd_id']; ?>"><?php echo $prd_data['pd_name']; ?>- <strong><?php echo $prd_data['pd_barcode']; ?></strong> - <b><?php echo $prd_data['pd_keyword']; ?></b></option>
								<?php
									} // End While
								} else {
								}
								?>
							</select>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="focusedInput">Qty</label>
						<div class="controls">
							<input class="input-xlarge focused" id="barcode" name="qty" value="1" type="text" />
							<div id="status"></div>
						</div>
					</div>

					<!-- <div class="control-group">
						<label class="control-label" for="focusedInput">Product Name</label>
						<div class="controls">
							<input class="input-xlarge focused" id="pdname" name="pdname" type="text" autocomplete=off required />
							<div id="status"></div>
						</div>
					</div> -->

					<div class="control-group">
						<label class="control-label" for="focusedInput">Description</label>
						<div class="controls">
							<textarea id="description" name="description"></textarea>
							<div id="status"></div>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="focusedInput">Job Description</label>
						<div class="controls">
							<div style=" padding-top: 10px">
								<span class="border_cart"></span>
								<label>
									<input type="radio" name="job_description" required
										value="brandnew" checked> Brandnew
								</label>
								<!-- <label>
									<input type="radio" name="job_description" required
										value="refill"> Refill
								</label> -->
							</div>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="focusedInput">Date Needed</label>
						<div class="controls">
							<input class="input-xlarge focused" id="date" name="date_needed" type="date" required />
							<div id="status"></div>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="focusedInput">Remarks</label>
						<div class="controls">
							<textarea id="description" name="remarks"></textarea>
							<div id="status"></div>
						</div>
					</div>


				</fieldset>
			</div>
			<div class="form-actions">
				<button type="submit" onclick="return confirmDelete2()" class="btn btn-success">Add to Job Order Content</button>
				<input type="button" value="Cancel" onclick="window.location.href='index.php'" class="btn btn-danger">
			</div>
		</form>
	</div>
	<script>
		function confirmDelete2() {
			return confirm("Are you sure do you want to add Job Order Content?");
		}
	</script>
	<?php
	include 'jobContent_new.php';
	?>
</div><!--/span-->