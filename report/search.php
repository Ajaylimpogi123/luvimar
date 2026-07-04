<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$userId = $_SESSION['user_id'];

$reportId = $_GET['id']; // Get report id
# Get report details from db
$sql = $conn->prepare("SELECT * FROM bs_report WHERE report_id = '$reportId'");
$sql->execute();
$sql_data = $sql->fetch();

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>
<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-calendar"></i> Search Date</h2>
		</div>

		<div class="box-content">
			<form class="form-horizontal" method="post" action="<?php echo $sql_data['page']; ?>.php" target=_new name="frm" id="frm">
				<fieldset>
					<i class="icon icon-green icon-bullet-on"></i> <b>Report - <?php echo $sql_data['name']; ?></b><br /><br />
					<?php if ($reportId == 1015 || $reportId == 1001) {
						if ($reportId == 1015) { ?>

							<div class="control-group">
								<label class="control-label" for="focusedInput">Branch</label>
								<div class="controls">
									<select name="branch" id="selectError777" data-rel="chosen">
										<?php
										$cat = $conn->prepare("SELECT * FROM bs_branch WHERE is_deleted != '1' ORDER BY branch_name");
										$cat->execute();
										while ($cat_data = $cat->fetch()) {
											$brnname = $cat_data['branch_name'];
											$brndb = $cat_data['branch_db'];
										?>
											<option value="<?php echo $brndb; ?>"><?php echo $brnname; ?></option>
										<?php
										} // End While
										?>
									</select>
									<div id="status"></div>
								</div>
							</div>


						<div class="control-group">
							<label class="control-label" for="selectError">Category</label>
							<div class="controls">
								<select id="selectError2" name="cat" data-rel="chosen">
									<option value="0">All</option>
									<?php
									$cat = $conn->prepare("SELECT * FROM tbl_category WHERE is_deleted != '1' AND cat_parent_id = '0' GROUP BY cat_name");
									$cat->execute();
									while ($cat_data = $cat->fetch()) {
									?>
										<option value="<?php echo $cat_data['cat_id']; ?>"><?php echo $cat_data['cat_name']; ?></option>
									<?php
									} // End While
									?>
								</select>
							</div>
						</div>

						<?php 	} else {
						} ?>

						<div class="control-group">
							<label class="control-label" for="selectError">Product</label>
							<div class="controls">
								<select id="selectError1" name="product" data-rel="chosen">
									<option value="0">All</option>
									<?php
									$agt = $conn->prepare("SELECT * FROM tbl_product WHERE is_deleted != '1' GROUP BY pd_name");
									$agt->execute();
									while ($agt_data = $agt->fetch()) {
									?>
										<option value="<?php echo $agt_data['pd_id']; ?>"><?php echo $agt_data['pd_name']; ?></option>
									<?php
									} // End While
									?>
								</select>
							</div>
						</div>
					<?php } else {
					} ?>

					<?php if ($reportId == 1019) { ?>

						<div class="control-group">
							<label class="control-label" for="focusedInput">Branch</label>
							<div class="controls">
								<select name="branch" id="selectError1" data-rel="chosen">
									<?php
									$cat = $conn->prepare("SELECT * FROM bs_customer WHERE is_deleted != '1' AND is_branch = '1' ORDER BY customer_name");
									$cat->execute();
									while ($cat_data = $cat->fetch()) {
										$brnname = $cat_data['customer_name'];
										$brndb = $cat_data['cust_id'];
									?>
										<option value="<?php echo $brndb; ?>"><?php echo $brnname; ?></option>
									<?php
									} // End While
									?>
								</select>
								<div id="status"></div>
							</div>
						</div>
					<?php } else {
					} ?>


					<?php if ($reportId == 1017) { ?>
						<div class="control-group">
							<label class="control-label" for="selectError">Customer</label>
							<div class="controls">
								<select id="selectError1" name="customer" data-rel="chosen">
									<option value="0">All</option>
									<?php
									$agt = $conn->prepare("SELECT * FROM bs_customer WHERE is_deleted != '1'");
									$agt->execute();
									while ($agt_data = $agt->fetch()) {
									?>
										<option value="<?php echo $agt_data['cust_id']; ?>"><?php echo $agt_data['client_name']; ?></option>
									<?php
									} // End While
									?>
								</select>
							</div>
						</div>
					<?php } else {
					} ?>

					<?php if ($reportId == 1014) { ?>
						<div class="control-group">
							<label class="control-label" for="selectError">Supplier</label>
							<div class="controls">
								<select id="selectError1" name="supplier" data-rel="chosen">
									<option value="0">All</option>
									<?php
									$agt = $conn->prepare("SELECT * FROM bs_supplier WHERE is_deleted != '1'");
									$agt->execute();
									while ($agt_data = $agt->fetch()) {
									?>
										<option value="<?php echo $agt_data['sup_id']; ?>"><?php echo $agt_data['company_name']; ?></option>
									<?php
									} // End While
									?>
								</select>
							</div>
						</div>
					<?php } else {
					} ?>
					<?php if ($reportId == 1018) { ?>

						<!--<div class="control-group">
									<label class="control-label" for="selectError">Returned</label>
									<div class="controls">
										
										  <label class="radio">
											<input type="radio" class="return_type" name="top" id="optionsRadios1" value="a" checked="" />From Customer
										  </label>	
										  
										  <label class="radio">
											<input type="radio" class="return_type" name="top" id="optionsRadios2" value="o" />To Supplier
										  </label>
											
									</div>
								</div>
								
								<div class="control-group" id="sup" style="display:none">
									<label class="control-label" for="selectError">Supplier</label>
									<div class="controls">
									  <select id="selectError1" name="supplier" data-rel="chosen">
										<option value="0">All</option>
											<?php
											$agt = "SELECT * FROM bs_supplier WHERE is_deleted != '1'";
											$rs_agt = dbQuery($agt);
											while ($rw_agt = dbFetchAssoc($rs_agt)) {
												extract($rw_agt);
											?>
													<option value="<?php echo $sup_id; ?>"><?php echo $rw_agt['company_name']; ?></option>
											<?php
											} // End While
											?>
									  </select>
									</div>
								</div>
								
								<div class="control-group" id="cust">
									<label class="control-label" for="selectError">Customer</label>
									<div class="controls">
									  <select id="selectError2" name="customer" data-rel="chosen">
										<option value="0">All</option>
											<?php
											$agt = "SELECT * FROM bs_customer WHERE is_deleted != '1'";
											$rs_agt = dbQuery($agt);
											while ($rw_agt = dbFetchAssoc($rs_agt)) {
												extract($rw_agt);
											?>
													<option value="<?php echo $cust_id; ?>"><?php echo $rw_agt['client_name']; ?></option>
											<?php
											} // End While
											?>
									  </select>
									</div>
								</div>!-->
					<?php } else {
					} ?>

					<?php if ($reportId == 1) { ?>
						<div class="control-group">
							<label class="control-label" for="focusedInput">Expense Name</label>
							<div class="controls">
								<select name="ec_id" id="selectError771" data-rel="chosen">
								<option value="0">Select</option>
									<?php
												
									$cat2 = $conn->prepare("SELECT * FROM tr_expense_category WHERE is_deleted != '1' ORDER BY ec_id");
									$cat2->execute();
									while ($cat2_data = $cat2->fetch()) {
										$category_name = $cat2_data['expense_category_name'];
										$ec_id = $cat2_data['ec_id'];
									?>
										<option value="<?php echo $ec_id; ?>"><?php echo $category_name; ?></option>
									<?php
									} // End While
									?>
								</select>
								
								<div id="status"></div>
							</div>
						</div>
					<?php } else {
					} ?>

					<?php if ($reportId == 1013) { ?>
						<div class="control-group">
							<label class="control-label" for="focusedInput">Branch</label>
							<div class="controls">
								<select name="branch" id="selectError77" data-rel="chosen">
									<?php
									$cat = $conn->prepare("SELECT * FROM bs_branch WHERE is_deleted != '1' ORDER BY branch_name");
									$cat->execute();
									while ($cat_data = $cat->fetch()) {
										$brnname = $cat_data['branch_name'];
										$brndb = $cat_data['branch_db'];
									?>
										<option value="<?php echo $brndb; ?>"><?php echo $brnname; ?></option>
									<?php
									} // End While
									?>
								</select>
								<div id="status"></div>
							</div>
						</div>





						<div class="control-group">
							<label class="control-label" for="selectError">Payment Type</label>
							<div class="controls">
								<select id="selectError1" name="stype" data-rel="chosen">
									<option value="0">All</option>
									<option value="Cash">Cash</option>
								
									<option value="collection">Collection</option>
								</select>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="selectError">Remarks</label>
							<div class="controls">
								<select id="selectError7" name="rmk" data-rel="chosen">
									<option value="0">All</option>
									<option value="1">With Remarks Only</option>
								</select>
							</div>
						</div>
					<?php } else {
					} ?>

					<?php if ($reportId == 1015) {
					} else { ?>
						<div class="control-group">
							<label class="control-label" for="date01">From</label>
							<div class="controls">
								<input type="text" class="input-xlarge" id="txtFromDate" name="from" onkeypress="return isNumberKey(event)" autocomplete=off required />
								<?php if ($reportId == 1013) { ?>
									<select name="din1" style="width:50px;">
										<?php
										for ($x1 = 0; $x1 <= 24; $x1++) {
											$cts1 = strlen($x1);
											if ($cts1 != 2) {
												$y1 = 0 . $x1;
											} else {
												$y1 = $x1;
											}
										?>
											<option value="<?php echo $y1; ?>"><?php echo $y1; ?></option>
										<?php } ?>
									</select>
									&nbsp;:&nbsp;
									<select name="din2" style="width:50px;">
										<?php
										for ($x2 = 0; $x2 <= 59; $x2++) {
											$cts2 = strlen($x2);
											if ($cts2 != 2) {
												$y2 = 0 . $x2;
											} else {
												$y2 = $x2;
											}
										?>
											<option value="<?php echo $y2; ?>"><?php echo $y2; ?></option>
										<?php } ?>
									</select>
								<?php } else {
								} ?>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="date01">To</label>
							<div class="controls">
								<input type="text" class="input-xlarge" id="txtToDate" name="to" onkeypress="return isNumberKey(event)" autocomplete=off required />
								<?php if ($reportId == 1013) { ?>
									<select name="dout1" style="width:50px;">
										<?php
										for ($x3 = 0; $x3 <= 24; $x3++) {
											$cts3 = strlen($x3);
											if ($cts3 != 2) {
												$y3 = 0 . $x3;
											} else {
												$y3 = $x3;
											}
										?>
											<option value="<?php echo $y3; ?>"><?php echo $y3; ?></option>
										<?php } ?>
									</select>
									&nbsp;:&nbsp;
									<select name="dout2" style="width:50px;">
										<?php
										for ($x4 = 0; $x4 <= 59; $x4++) {
											$cts4 = strlen($x4);
											if ($cts4 != 2) {
												$y4 = 0 . $x4;
											} else {
												$y4 = $x4;
											}
										?>
											<option value="<?php echo $y4; ?>"><?php echo $y4; ?></option>
										<?php } ?>
									</select>
								<?php } else {
								} ?>
							</div>
						</div>

						<?php if ($reportId == '1016') { ?>
							<div class="control-group">
								<label class="control-label" for="date01">Graph Type</label>
								<div class="controls">
									<label class="radio">
										<input type="radio" class="graph_type" name="top" id="optionsRadios1" value="1" checked="" />
										Bar
									</label>
								</div>
							</div>
						<?php } else {
						} ?>
					<?php } ?>
				</fieldset>
				<div class="form-actions">
					<input type="hidden" name="reportId" value="<?php echo $reportId; ?>" />
					<button type="submit" class="btn btn-success">Submit</button>
				</div>
			</form>
		</div>

	</div>
</div><!--/span-->

<script type="text/javascript">
	$(".return_type").click(function() {


		var value_checked = $(this).val();

		// Supplier
		if (value_checked == "o") {
			$("#sup").show();
		} else {
			$("#sup").hide();
		}
		// Customer
		if (value_checked == "o") {
			$("#cust").hide();
		} else {
			$("#cust").show();
		}

	});
</script>