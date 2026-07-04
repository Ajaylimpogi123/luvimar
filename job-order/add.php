<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$num_str = sprintf("%06d", mt_rand(1, 999999));

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';
?>

<?php if ($errorMessage == 'Added successfully'): ?>
	<div class="valid_box">
		<b><?php echo $errorMessage; ?></b>
	</div>
<?php elseif ($errorMessage == 'Product already exist! Data entry failed.'): ?>
	<div class="error_box">
		<b><?php echo $errorMessage; ?></b>
	</div>
<?php endif; ?>

<div class="row-fluid sortable">
	<div class="box span5">

		<div class="box-header well" data-original-title>
			<h2><i class="icon-plus-sign"></i> Add Job</h2>
		</div>

		<!-- ── Tab Navigation ── -->
		<ul class="nav nav-tabs" id="addJobTabs">
			<li class="active">
				<a href="#tab-add-job" data-toggle="tab">
					<i class="icon-briefcase"></i> Add Product 
				</a>
			</li>
			<li>
				<a href="#tab-raw-material" data-toggle="tab">
					<i class="icon-cog"></i> Add Raw Material
				</a>
			</li>
		</ul>

		<div class="tab-content" style="padding-top: 15px;">

			<!-- ══════════════════════════════════════════
			     TAB 1 — ADD JOB
			     ══════════════════════════════════════════ -->
			<div class="tab-pane active" id="tab-add-job">
				<form class="form-horizontal" method="post" action="processAdd.php"
				      enctype="multipart/form-data" name="form_job" id="form_job">

					<div class="box-content">
						<fieldset>

							<!-- Branch -->
							<div class="control-group">
								<label class="control-label">Branch</label>
								<div class="controls">
									<select name="branch" id="job_branch" data-rel="chosen" required>
										<?php
										$brn = $conn->prepare("SELECT * FROM bs_branch WHERE is_deleted != '1' ORDER BY date_added DESC");
										$brn->execute();
										while ($brn_data = $brn->fetch()):
										?>
											<option value="<?php echo $brn_data['branch_id']; ?>">
												<?php echo $brn_data['branch_name']; ?>
											</option>
										<?php endwhile; ?>
									</select>
								</div>
							</div>

							<!-- Customer -->
							<div class="control-group">
								<label class="control-label">Customer</label>
								<div class="controls">
									<select name="custname" id="job_custname" data-rel="chosen" required>
										<?php
										$cus = $conn->prepare("SELECT * FROM bs_customer WHERE is_deleted != '1' ORDER BY client_name");
										$cus->execute();
										while ($cus_data = $cus->fetch()):
										?>
											<option value="<?php echo $cus_data['cust_id']; ?>">
												<?php echo $cus_data['client_name']; ?>
											</option>
										<?php endwhile; ?>
									</select>
								</div>
							</div>

							<!-- Product Name -->
							<div class="control-group">
								<label class="control-label">Product Name</label>
								<div class="controls">
									<select name="pdId" id="job_pdId" data-rel="chosen" required>
										<option value="">— SELECT —</option>
										<?php
										$prd = $conn->prepare("SELECT * FROM tbl_product
											WHERE cat_id != '6' AND cat_id != '3'
											  AND pd_id NOT IN (
											      SELECT pd_id FROM tbl_jo_items
											      WHERE is_deleted != '1' AND is_submitted != 1
											  )
											GROUP BY pd_name ORDER BY pd_name ASC");
										$prd->execute();
										while ($prd_data = $prd->fetch()):
										?>
											<option value="<?php echo $prd_data['pd_id']; ?>">
												<?php echo $prd_data['pd_name']; ?> — <?php echo $prd_data['pd_keyword']; ?>
											</option>
										<?php endwhile; ?>
									</select>
								</div>
							</div>

							<!-- Qty -->
							<div class="control-group">
								<label class="control-label">Qty</label>
								<div class="controls">
									<input class="input-xlarge focused" value="1" name="qty" type="text" />
								</div>
							</div>

							<!-- Description -->
							<div class="control-group">
								<label class="control-label">Description</label>
								<div class="controls">
									<textarea name="description"></textarea>
								</div>
							</div>

							<!-- Job Description -->
							<div class="control-group">
								<label class="control-label">Job Description</label>
								<div class="controls">
									<div style="padding-top: 10px;">
										<label>
											<input type="radio" name="job_description" value="brandnew" required> Brandnew
										</label>
										&nbsp;
										<label>
											<input type="radio" name="job_description" value="refill" required> Refill
										</label>
									</div>
								</div>
							</div>

							<!-- Date Needed -->
							<div class="control-group">
								<label class="control-label">Date Needed</label>
								<div class="controls">
									<input class="input-xlarge focused" name="date_needed" type="date" required />
								</div>
							</div>

							<!-- Remarks -->
							<div class="control-group">
								<label class="control-label">Remarks</label>
								<div class="controls">
									<textarea name="remarks"></textarea>
								</div>
							</div>

						</fieldset>
					</div>

					<div class="form-actions">
						<button type="submit" onclick="return confirmAdd()" class="btn btn-success">
							Add to Job Order Content
						</button>
						<input type="button" value="Cancel"
						       onclick="window.location.href='index.php'" class="btn btn-danger">
					</div>

				</form>
			</div><!-- /tab-add-job -->


			<!-- ══════════════════════════════════════════
			     TAB 2 — ADD RAW MATERIAL
			     ══════════════════════════════════════════ -->
			<div class="tab-pane" id="tab-raw-material">
				<form class="form-horizontal" method="post" action="processAdd.php"
				      enctype="multipart/form-data" name="form_rawmat" id="form_rawmat">

					<!-- Hidden fields required by processAdd.php -->
					<input type="hidden" name="form_type" value="raw_material">

					<div class="box-content">
						<fieldset>

							<!-- Branch -->
							<div class="control-group" style="display: none;">
								<label class="control-label">Branch</label>
								<div class="controls">
									<select name="branch" id="rm_branch" data-rel="chosen" >
										<?php
										$brn2 = $conn->prepare("SELECT * FROM bs_branch WHERE is_deleted != '1' ORDER BY date_added DESC");
										$brn2->execute();
										while ($brn2_data = $brn2->fetch()):
										?>
											<option value="<?php echo $brn2_data['branch_id']; ?>">
												<?php echo $brn2_data['branch_name']; ?>
											</option>
										<?php endwhile; ?>
									</select>
								</div>
							</div>

								<!-- Customer -->
							<div class="control-group">
								<label class="control-label">Customer</label>
								<div class="controls">
									<select name="custname" id="job_custnamer" data-rel="chosen" required>
										<?php
										$cus = $conn->prepare("SELECT * FROM bs_customer WHERE is_deleted != '1' ORDER BY client_name");
										$cus->execute();
										while ($cus_data = $cus->fetch()):
										?>
											<option value="<?php echo $cus_data['cust_id']; ?>">
												<?php echo $cus_data['client_name']; ?>
											</option>
										<?php endwhile; ?>
									</select>
								</div>
							</div>

							<!-- Raw Material -->
							<div class="control-group">
								<label class="control-label">Raw Material</label>
								<div class="controls">
									<select name="pdId" id="rm_pdId" data-rel="chosen" required>
										<option value="">— SELECT —</option>
										<?php
										/*
										 * Queries cat_id = '3' for raw materials.
										 * Adjust the cat_id value if your raw materials
										 * use a different category in tbl_product.
										 */
										$prd_rm = $conn->prepare("SELECT * FROM tbl_product
											WHERE cat_id = '3'
											  AND pd_id NOT IN (
											      SELECT pd_id FROM tbl_jo_items
											      WHERE is_deleted != '1' AND is_submitted != 1
											  )
											GROUP BY pd_name ORDER BY pd_name ASC");
										$prd_rm->execute();
										while ($prd_rm_data = $prd_rm->fetch()):
										?>
											<option value="<?php echo $prd_rm_data['pd_id']; ?>">
												<?php echo $prd_rm_data['pd_name']; ?> — <?php echo $prd_rm_data['pd_keyword']; ?>
											</option>
										<?php endwhile; ?>
									</select>
								</div>
							</div>

							<!-- Qty -->
							<div class="control-group">
								<label class="control-label">Qty</label>
								<div class="controls">
									<input class="input-xlarge focused" value="1" name="qty" type="text" />
								</div>
							</div>

							<!-- Date Needed -->
							<div class="control-group">
								<label class="control-label">Date Needed</label>
								<div class="controls">
									<input class="input-xlarge focused" name="date_needed" type="date" required />
								</div>
							</div>

							<!-- Remarks -->
							<div class="control-group">
								<label class="control-label">Remarks</label>
								<div class="controls">
									<textarea name="remarks"></textarea>
								</div>
							</div>

						</fieldset>
					</div>

					<div class="form-actions">
						<button type="submit" onclick="return confirmAdd()" class="btn btn-success">
							Add to Job Order Content
						</button>
						<input type="button" value="Cancel"
						       onclick="window.location.href='index.php'" class="btn btn-danger">
					</div>

				</form>
			</div><!-- /tab-raw-material -->

		</div><!-- /tab-content -->
	</div><!-- /box -->

	<script>
		function confirmAdd() {
			return confirm("Are you sure you want to add this Job Order Content?");
		}
	</script>

	<?php include 'jobContent.php'; ?>
</div><!--/span-->