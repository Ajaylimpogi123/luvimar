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
} else if ($errorMessage == 'You already Add This product To Production Content!') {
?>
	<div class="error_box">
		<b><?php echo $errorMessage; ?></b>
	</div>
<?php
} else if ($errorMessage == 'Modified successfully') {
?>
	<div class="valid_box">
		<b><?php echo $errorMessage; ?></b>
	</div>
<?php

} else {
}
?>

<div class="row-fluid sortable">

	<!-- Hide Add Production Report -->
	<div class="box span4 offset" style="display: none;">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-plus-sign"></i> Add Production Report</h2>
		</div>

		<form class="form-horizontal" method="post" action="processAdd.php" enctype="multipart/form-data" name="form" id="form">
			<div class="box-content">

				<fieldset>
					<!-- <div class="control-group">
						<label class="control-label" for="focusedInput">Job Order Number</label>
						<div class="controls">
							<select name="custname" id="selectError" data-rel="chosen" required>
								<?php
								$job = $conn->prepare("SELECT * FROM tbl_job_order WHERE is_deleted != '1' AND status = 'pending' ORDER BY date_added DESC");
								$job->execute();
								if ($job->rowCount() > 0) {
									while ($job_data = $job->fetch()) {
								?>
										<option value="<?php echo $job_data['jo_id']; ?>"><?php echo $job_data['job_order_number']; ?></option>
								<?php
									} // End While
								} else {
								}
								?>
							</select>
							<div id="status"></div>
						</div>
					</div> -->

					<div class="control-group">
						<label class="control-label" for="focusedInput">Customer</label>
						<div class="controls">
							<select name="branch" id="selectError" data-rel="chosen" required>
								<?php
								$cus = $conn->prepare("SELECT * FROM bs_branch WHERE is_deleted != '1' ORDER BY branch_name; ");
								$cus->execute();
								if ($cus->rowCount() > 0) {
									while ($cus_data = $cus->fetch()) {
								?>
										<option value="<?php echo $cus_data['branch_id']; ?>"><?php echo $cus_data['branch_name']; ?></option>
								<?php
									} // End While
								} else {
								}
								?>
							</select>
							<div id="status"></div>
						</div>
					</div>

					<!-- <div class="control-group">
						<label class="control-label" for="focusedInput">Job Description</label>
						<div class="controls">
							<div style=" padding-top: 10px">
								<span class="border_cart"></span>
								<label>
									<input type="radio" class="payment_method" name="job_description" id="optionsRadios1" checked required
										value="brandnew"> Brandnew
								</label>
								<label>
									<input type="radio" class="payment_method" name="job_description" id="optionsRadios2" required
										value="refill"> Refill
								</label>
							</div>
						</div>
					</div> -->

					<!-- <div id="brandnew" class="control-group">
						<label class="control-label" for="focusedInput">Product Name</label>
						<div class="controls">
							<input class="input-xlarge focused" id="pdname" name="pdname" type="text" autocomplete=off required />
							<div id="status"></div>
						</div>
					</div> -->




					<div id="refill" class="control-group">
						<label class="control-label" for="focusedInput">Product Name</label>
						<div class="controls">
							<select id="selectError4" name="pdId" id="pid" data-rel="chosen" required>
								<option value="">-SELECT-</b></option>
								<?php
								$prd = $conn->prepare("SELECT * FROM tbl_product p, tbl_category c WHERE p.is_deleted != '1' AND p.cat_id = c.cat_id");
								$prd->execute();
								if ($prd->rowCount() > 0) {
									while ($prd_data = $prd->fetch()) {
								?>
										<option value="<?php echo $prd_data['pd_id']; ?>"><?php echo $prd_data['pd_name']; ?>- <?php echo $prd_data['pd_barcode']; ?> - <b><?php echo $prd_data['pd_keyword']; ?></b></option>
								<?php
									} // End While
								} else {
								}
								?>
							</select>
						</div>
					</div>

					<!-- <div id="serial" class="control-group">
						<label class="control-label" for="focusedInput">Serial Number</label>
						<div class="controls">
							<input class="input-xlarge focused" id="pdname" name="barcode" type="text" autocomplete=off required />
							<div id="status"></div>
						</div>
					</div> -->


					<div class="control-group">
						<label class="control-label" for="focusedInput">Qty</label>
						<div class="controls">
							<input class="input-xlarge focused" id="barcode" name="qty" style="width: 100px" type="text" />
							<div id="status"></div>
						</div>
					</div>



					<div class="control-group">
						<label class="control-label" for="focusedInput">Description</label>
						<div class="controls">
							<textarea id="description" name="description"></textarea>
							<div id="status"></div>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="focusedInput">Parts Replacement</label>
						<div class="controls">
							<textarea id="description" name="part_replacement"></textarea>
							<div id="status"></div>
						</div>
					</div>


					<div class="control-group">
						<label class="control-label" for="focusedInput">Remarks</label>
						<div class="controls">
							<textarea id="description" name="pr_remarks"></textarea>
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
			return confirm("Are you sure do you want to add to Production Report Content?");
		}
	</script>
	<!-- <script type="text/javascript">
		$(".payment_method").click(function() {

			var value_checked = $(this).val();

			// brandnew
			if (value_checked == "brandnew") {
				$("#brandnew").show();
			} else {
				$("#brandnew").hide();
			}
			// brandnew
			if (value_checked == "brandnew") {
				$("#serial").show();
			} else {
				$("#serial").hide();
			}

			// refill
			if (value_checked == "refill") {
				$("#refill").show();
			} else {
				$("#refill").hide();
			}
		});
	</script> -->

	<?php
	include 'reportContent.php';
	?>
</div><!--/span-->