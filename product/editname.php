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
$sql = $conn->prepare("SELECT * FROM tr_name WHERE n_id = '$id' AND is_deleted != '1'");
$sql->execute();
$sql_data = $sql->fetch();


$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'

?>
<div class="row-fluid sortable">
	<div class="box span8">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-edit"></i> Modify Product</h2>
		</div>

		<form class="form-horizontal" method="post" enctype="multipart/form-data" action="process.php?action=edit">
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
						<label class="control-label" for="focusedInput">Product Name</label>
						<div class="controls">
							<input class="input-xlarge focused" id="pdname" name="prodname" type="text" value="<?php echo $sql_data['prod_name']; ?>" autocomplete=off required />
							<div id="status"></div>
						</div>
					</div>

				</fieldset>
			</div>
			<div class="form-actions">
				<input type="hidden" name="id" value="<?php echo $sql_data['n_id']; ?>" />
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