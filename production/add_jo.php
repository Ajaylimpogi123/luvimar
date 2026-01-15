<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$num_str = sprintf("%06d", mt_rand(1, 999999));

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';
?>


<div class="row-fluid sortable">

	<div class="box span5"> <?php
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
							} else {
							}
		?>
		<div class="box-header well" data-original-title>
			<h2><i class="icon-plus-sign"></i> Add Production Report</h2>
		</div>

		<form class="form-horizontal" method="post" action="processAdd_jo.php" enctype="multipart/form-data" name="form" id="form">
			<div class="box-content">

				<fieldset>
					<div class="control-group">
						<label class="control-label" for="focusedInput">Job Order Number</label>
						<div class="controls">
							<select name="joId" id="selectError" data-rel="chosen" required>
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


</div><!--/span-->