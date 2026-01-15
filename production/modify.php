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

/* Select book from database */
$sql = $conn->prepare("SELECT * FROM tbl_product WHERE pd_id = '$id' AND is_deleted != '1'");
$sql->execute();
$sql_data = $sql->fetch();

$cat = $conn->prepare("SELECT * FROM tbl_category WHERE cat_id = '$sql_data[cat_id]'");
$cat->execute();
$cat_data = $cat->fetch();
if ($cat->rowCount() > 0) {
	$catId = $cat_data['cat_id'];
	$catName = $cat_data['cat_name'];
} else {
	$catId = 0;
	$catName = 'None';
}

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'

?>
<div class="row-fluid sortable">
	<div class="box span8">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-edit"></i> Modify Product</h2>
		</div>

		<form class="form-horizontal" method="post" enctype="multipart/form-data" action="processModify.php">
			<div class="box-content">
				<?php
				if ($errorMessage == 'Modified successfully') {
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
				} else if ($errorMessage == 'Image deleted successfully') {
				?>
					<div class="valid_box">
						<b><?php echo $errorMessage; ?></b>
					</div>
				<?php
				} else {
				}
				?>
				<fieldset>
					<div class="control-group">
						<label class="control-label" for="focusedInput">Brand</label>
						<div class="controls">
							<select name="category" id="category">
								<option value="<?php echo $catId; ?>"><?php echo $catName; ?></option>
								<?php
								$cat = $conn->prepare("SELECT * FROM tbl_category WHERE cat_parent_id = '0' AND is_deleted != '1' ORDER BY cat_name");
								$cat->execute();
								while ($cat_data = $cat->fetch()) {
									$categoryname = $cat_data['cat_name'];
									$categoryid = $cat_data['cat_id'];
								?>
									<optgroup label="<?php echo $categoryname; ?>">
										<?php
										$slp = $conn->prepare("SELECT * FROM tbl_category WHERE cat_id != '$catId' AND cat_parent_id = '$categoryid' AND is_deleted != '1' ORDER BY cat_name");
										$slp->execute();
										while ($slp_data = $slp->fetch()) {
										?>
											<option value="<?php echo $slp_data['cat_id']; ?>"><?php echo $slp_data['cat_name']; ?></option>
										<?php
										} // End While
										?>
									</optgroup>
								<?php
								} // End While
								?>
							</select>
							<div id="status"></div>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="focusedInput">Seriral Number</label>
						<div class="controls">
							<input class="input-xlarge focused" id="barcode" name="barcode" type="text" value="<?php echo $sql_data['pd_barcode']; ?>" />
							<div id="status"></div>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="focusedInput">Product Detail</label>
						<div class="controls">
							<input class="input-xlarge focused" id="pdname" name="pdname" type="text" value="<?php echo $sql_data['pd_name']; ?>" autocomplete=off required />
							<div id="status"></div>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="focusedInput">Description</label>
						<div class="controls">
							<textarea id="description" name="description"><?php echo $sql_data['pd_description']; ?></textarea>
							<div id="status"></div>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="focusedInput">Cost</label>
						<div class="controls">
							<input class="input-xlarge focused" id="cost" name="cost" type="text" value="<?php echo $sql_data['pd_cost']; ?>" autocomplete=off />
							<div id="status"></div>
						</div>
					</div>

					<div class="control-group">
						<div class="controls">
							<!-- <input class="input-xlarge focused" id="" name="" type="text" autocomplete=off disabled style="width:77px; border:0px; text-align:center; background-color:#ffffff;" placeholder="Formula" />
							&nbsp; -->
							<input class="input-xlarge focused" id="" name="" type="text" autocomplete=off disabled style="width:77px; border:0px; text-align:center; background-color:#ffffff;" placeholder="Price" />
							&nbsp;
							<input class="input-xlarge focused" id="" name="" type="text" autocomplete=off disabled style="width:77px; border:0px; text-align:center; background-color:#ffffff;" placeholder="Qty" />
							<div id="status"></div>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="focusedInput">Piece</label>
						<div class="controls">
							<!-- <input class="input-xlarge focused" id="pc_frm" name="pc_frm" type="text" autocomplete=off style="width:77px;" placeholder="Formula" value="<?php echo $sql_data['pc_formula']; ?>" />
							&nbsp; -->
							<input class="input-xlarge focused" id="pc_prc" name="pc_prc" type="text" autocomplete=off style="width:77px;" placeholder="Price" value="<?php echo $sql_data['pc_price']; ?>" />
							&nbsp;
							<input class="input-xlarge focused" id="pc_qty" name="pc_qty" type="text" autocomplete=off style="width:77px;" placeholder="Qty" value="<?php echo $sql_data['pc_qty']; ?>" />
							<div id="status"></div>
						</div>
					</div>


					<div class="control-group">
						<label class="control-label" for="date01">Expiration Date</label>
						<div class="controls">
							<input type="text" class="input-xlarge" id="txtFromDate" name="expdate" onkeypress="return isNumberKey(event)" value="<?php echo $sql_data['pd_expiration']; ?>" autocomplete=off />
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
				<input type="hidden" name="id" value="<?php echo $sql_data['pd_id']; ?>" />
				<button type="submit" class="btn btn-success">Save Changes</button>
			</div>
		</form>
	</div>

	<div class="box span4">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-picture"></i> Picture</h2>
		</div>

		<div class="box-content">
			<?php
			// Display image of employee
			if ($sql_data['pd_image']) {
				$image = WEB_ROOT . 'images/product/' . $sql_data['pd_image'];
			?>
				<img src="<?php echo $image; ?>" />
				<br /><br />
				<a class="btn btn-danger" href="javascript:delimg(<?php echo $sql_data['pd_id']; ?>);"><i class="icon-trash icon-white"></i> Delete Image</a>
			<?php
			} else {
				$image = WEB_ROOT . 'images/product/noimagelarge.png';
			?>
				<img src="<?php echo $image; ?>" />
			<?php
			}
			?>

		</div>
	</div>

</div><!--/span-->