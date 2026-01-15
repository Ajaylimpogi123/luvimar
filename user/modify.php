<?php
if (!defined('WEB_ROOT')) {
	exit;
}
// Start check user access level
$userId = $_SESSION['user_id'];
$ac = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$userId'");
$ac->execute();
$ac_data = $ac->fetch();
$access = $ac_data['access_level'];

if ($access != '1') {
	$op = 'readonly';
} else {
	$op = 'required';
}
// End check user access level

// make sure a id exists
if (isset($_GET['id']) && $_GET['id'] > 0) {
	$id = $_GET['id'];
} else {
	// redirect to index.php if id is not present
	header('Location: index.php');
}

/* Select book from database */
$sql = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$id' AND is_deleted != '1'");
$sql->execute();
$sql_data = $sql->fetch();
if ($sql_data['branch_num'] == 1) {
	$branch = 'Branch 1';
} else {
	$branch = 'Main Branch';
}

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'

?>
<div class="row-fluid sortable">
	<div class="box span8">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-edit"></i> Modify User</h2>
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
				} else if ($errorMessage == 'Added successfully') {
				?>
					<div class="valid_box">
						<b><?php echo $errorMessage; ?></b>
					</div>
				<?php
				} else if ($errorMessage == 'Username already exist') {
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
						<label class="control-label" for="focusedInput">First Name</label>
						<div class="controls">
							<input class="input-xlarge focused" id="firstname" name="firstname" type="text" value="<?php echo $sql_data['firstname']; ?>" <?php echo $op; ?> autocomplete=off />
							<div id="status"></div>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="focusedInput">Last Name</label>
						<div class="controls">
							<input class="input-xlarge focused" id="lastname" name="lastname" type="text" value="<?php echo $sql_data['lastname']; ?>" <?php echo $op; ?> autocomplete=off />
							<div id="status"></div>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="focusedInput">User Name</label>
						<div class="controls">
							<input class="input-xlarge focused" id="username" name="username" type="text" value="<?php echo $sql_data['username']; ?>" <?php echo $op; ?> autocomplete=off />
							<div id="status"></div>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="focusedInput">Password</label>
						<div class="controls">
							<input class="input-xlarge focused" id="password" name="password" type="password" value="<?php echo $sql_data['pass_text']; ?>" required autocomplete=off />
							<div id="status"></div>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="fileInput">Picture</label>
						<div class="controls">
							<input class="input-file uniform_on" name="fileImage" id="fileInput" type="file" />
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="focusedInput">Branch</label>
						<div class="controls">
							<select name="branch" id="branch" required>
								<option value="0">Main Branch</option>
								<option value="1">Branch 1</option>
								<option value="2">Branch 2</option>
								<option value="3">Branch 3</option>
								<option value="4">Branch 4</option>
								<option value="5">Branch 5</option>
								<option value="6">Branch 6</option>
								<option value="7">Branch 7</option>
								<option value="8">Branch 8</option>
							</select>
							<div id="status"></div>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="fileInput">User Type</label>
						<div class="controls">
							<label class="radio">
								<input type="radio" class="user_type" name="top" id="optionsRadios1" value="o">
								Office
							</label>

							<label class="radio">
								<input type="radio" class="user_type" name="top" id="optionsRadios2" value="a" checked="">
								Owner
							</label>
						</div>
					</div>

					<hr /><b>Access Level</b><br />

					<div class="control-group" id="cat" style="display:none">
						<label class="control-label" for="selectError3">Category</label>
						<div class="controls">
							<select name="cat" id="selectError3">
								<?php if ($ac_data['is_category_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_category_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select>
						</div>
						<br />
						<div class="controls">
							<select name="cat_a" id="selectError3" style="width:55px;">
								<?php if ($ac_data['is_cat_a_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_cat_a_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select> Add
							&nbsp;&nbsp;
							<select name="cat_e" id="selectError3" style="width:55px;">
								<?php if ($ac_data['is_cat_e_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_cat_e_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select> Edit
							&nbsp;&nbsp;
							<select name="cat_d" id="selectError3" style="width:55px;">
								<?php if ($ac_data['is_cat_d_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_cat_d_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select> Delete
						</div>
					</div>

					<div class="control-group" id="cust" style="display:none">
						<label class="control-label" for="selectError3">Customer</label>
						<div class="controls">
							<select name="cust" id="selectError3">
								<?php if ($ac_data['is_customer_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_customer_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select>
						</div>
						<br />
						<div class="controls">
							<select name="cust_a" id="selectError3" style="width:55px;">
								<?php if ($ac_data['is_cust_a_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_cust_a_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select> Add
							&nbsp;&nbsp;
							<select name="cust_e" id="selectError3" style="width:55px;">
								<?php if ($ac_data['is_cust_e_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_cust_e_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select> Edit
							&nbsp;&nbsp;
							<select name="cust_d" id="selectError3" style="width:55px;">
								<?php if ($ac_data['is_cust_d_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_cust_d_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select> Delete
						</div>
					</div>

					<div class="control-group" id="sup" style="display:none">
						<label class="control-label" for="selectError3">Supplier</label>
						<div class="controls">
							<select name="sup" id="selectError3">
								<?php if ($ac_data['is_supplier_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_supplier_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select>
						</div>
						<br />
						<div class="controls">
							<select name="sup_a" id="selectError3" style="width:55px;">
								<?php if ($ac_data['is_sup_a_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_sup_a_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select> Add
							&nbsp;&nbsp;
							<select name="sup_e" id="selectError3" style="width:55px;">
								<?php if ($ac_data['is_sup_e_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_sup_e_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select> Edit
							&nbsp;&nbsp;
							<select name="sup_d" id="selectError3" style="width:55px;">
								<?php if ($ac_data['is_sup_d_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_sup_d_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select> Delete
						</div>
					</div>

					<div class="control-group" id="prod" style="display:none">
						<label class="control-label" for="selectError3">Product</label>
						<div class="controls">
							<select name="prod" id="selectError3">
								<?php if ($ac_data['is_product_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_product_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select>
						</div>
						<br />
						<div class="controls">
							<select name="prod_a" id="selectError3" style="width:55px;">
								<?php if ($ac_data['is_prod_a_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_prod_a_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select> Add
							&nbsp;&nbsp;
							<select name="prod_e" id="selectError3" style="width:55px;">
								<?php if ($ac_data['is_prod_e_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_prod_e_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select> Edit
							&nbsp;&nbsp;
							<select name="prod_d" id="selectError3" style="width:55px;">
								<?php if ($ac_data['is_prod_d_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_prod_d_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select> Delete
						</div>
					</div>

					<div class="control-group" id="rec" style="display:none">
						<label class="control-label" for="selectError3">Receive</label>
						<div class="controls">
							<select name="rec" id="selectError3">
								<?php if ($ac_data['is_receive_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_receive_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select>
						</div>
					</div>

					<div class="control-group" id="ret" style="display:none">
						<label class="control-label" for="selectError3">Return</label>
						<div class="controls">
							<select name="ret" id="selectError3">
								<?php if ($ac_data['is_return_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_return_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select>
						</div>
					</div>

					<div class="control-group" id="shy" style="display:none">
						<label class="control-label" for="selectError3">Sales History</label>
						<div class="controls">
							<select name="sale" id="selectError3">
								<?php if ($ac_data['is_sales_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_sales_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select>
						</div>
						<br />
						<div class="controls">
							<select name="sale_v" id="selectError3" style="width:55px;">
								<?php if ($ac_data['is_sale_v_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_sale_v_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select> View
							&nbsp;&nbsp;
							<select name="sale_d" id="selectError3" style="width:55px;">
								<?php if ($ac_data['is_sale_d_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_sale_d_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select> Delete
						</div>
					</div>

					<div class="control-group" id="jo" style="display:none">
						<label class="control-label" for="selectError3">Job Order</label>
						<div class="controls">
							<select name="job_order" id="selectError3">
								<?php if ($ac_data['is_sales_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_sales_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select>
						</div>

					</div>
					<div class="control-group" id="pr" style="display:none">
						<label class="control-label" for="selectError3">Production Report</label>
						<div class="controls">
							<select name="production_report" id="selectError3">
								<?php if ($ac_data['is_sales_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_sales_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select>
						</div>

					</div>

					<div class="control-group" id="delv" style="display:none">
						<label class="control-label" for="selectError3">Delivery</label>
						<div class="controls">
							<select name="delivery" id="selectError3">
								<?php if ($ac_data['is_delivery_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_delivery_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select>
						</div>
						<br />
						<div class="controls">
							<select name="del_v" id="selectError3" style="width:55px;">
								<?php if ($ac_data['is_del_v_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_del_v_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select> View
							&nbsp;&nbsp;
							<select name="del_d" id="selectError3" style="width:55px;">
								<?php if ($ac_data['is_del_d_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_del_d_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select> Delete
						</div>
					</div>

					<div class="control-group" id="exp" style="display:none">
						<label class="control-label" for="selectError3">Expense</label>
						<div class="controls">
							<select name="exp" id="selectError3">
								<?php if ($ac_data['is_expense_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_expense_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select>
						</div>
						<br />
						<div class="controls">
							<select name="exp_a" id="selectError3" style="width:55px;">
								<?php if ($ac_data['is_exp_a_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_exp_a_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select> Add
							&nbsp;&nbsp;
							<select name="exp_e" id="selectError3" style="width:55px;">
								<?php if ($ac_data['is_exp_e_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_exp_e_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select> Edit
							&nbsp;&nbsp;
							<select name="exp_d" id="selectError3" style="width:55px;">
								<?php if ($ac_data['is_exp_d_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_exp_d_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select> Delete
						</div>
					</div>

					<div class="control-group" id="rep" style="display:none">
						<label class="control-label" for="selectError3">Reports</label>
						<div class="controls">
							<select name="rep" id="selectError3">
								<?php if ($ac_data['is_report_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_report_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select>
						</div>
					</div>

					<div class="control-group" id="user" style="display:none">
						<label class="control-label" for="selectError3">User</label>
						<div class="controls">
							<select name="user" id="selectError3">
								<?php if ($ac_data['is_user_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_user_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select>
						</div>
						<br />
						<div class="controls">
							<select name="user_a" id="selectError3" style="width:55px;">
								<?php if ($ac_data['is_user_a_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_user_a_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select> Add
							&nbsp;&nbsp;
							<select name="user_e" id="selectError3" style="width:55px;">
								<?php if ($ac_data['is_user_e_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_user_e_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select> Edit
							&nbsp;&nbsp;
							<select name="user_d" id="selectError3" style="width:55px;">
								<?php if ($ac_data['is_user_d_access'] == '1') { ?>
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								<?php } else if ($ac_data['is_user_d_access'] == '0') { ?>
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								<?php } else { ?>
									<option value="1">Yes</option>
									<option value="0">No</option>
								<?php } ?>
							</select> Delete
						</div>
					</div>

				</fieldset>
			</div>
			<div class="form-actions">
				<input type="hidden" name="id" value="<?php echo $sql_data['user_id']; ?>" />
				<button type="submit" class="btn btn-success">Save Changes</button>
				<!-- Cancel link for user should be on the homepage !-->
				<?php if ($access != "1") { ?>
					<input type="button" value="Cancel" onclick="window.location.href='../index.php'" class="btn btn-danger" />
				<?php } else { ?>
					<input type="button" value="Cancel" onclick="window.location.href='index.php'" class="btn btn-danger" />
				<?php } ?>
			</div>
		</form>
	</div>

	<div class="box span4">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-picture"></i> Picture</h2>
		</div>

		<div class="box-content">
			<?php
			// Display image of user
			if ($sql_data['image']) {
				$image = WEB_ROOT . 'images/user/' . $sql_data['image'];
			?>
				<img src="<?php echo $image; ?>" />
				<br /><br />
				<a class="btn btn-danger" href="javascript:delimg(<?php echo $sql_data['user_id']; ?>);"><i class="icon-trash icon-white"></i> Delete Image</a>
			<?php
			} else {
				$image = WEB_ROOT . 'images/user/noimagelarge.jpg';
			?>
				<img src="<?php echo $image; ?>" />
			<?php
			}
			?>

		</div>
	</div>

</div><!--/span-->

<script type="text/javascript">
	$(".user_type").click(function() {


		var value_checked = $(this).val();

		// Category
		if (value_checked == "a") {
			$("#cat").hide();
		} else {
			$("#cat").show();
		}
		// Customer
		if (value_checked == "a") {
			$("#cust").hide();
		} else {
			$("#cust").show();
		}
		// Supplier
		if (value_checked == "a") {
			$("#sup").hide();
		} else {
			$("#sup").show();
		}
		// Product
		if (value_checked == "a") {
			$("#prod").hide();
		} else {
			$("#prod").show();
		}

		// Receive
		if (value_checked == "a") {
			$("#rec").hide();
		} else {
			$("#rec").show();
		}

		// Return
		if (value_checked == "a") {
			$("#ret").hide();
		} else {
			$("#ret").show();
		}

		// Sales History
		if (value_checked == "a") {
			$("#shy").hide();
		} else {
			$("#shy").show();
		}
		// Job order
		if (value_checked == "a") {
			$("#jo").hide();
		} else {
			$("#jo").show();
		}
		// Production Report
		if (value_checked == "a") {
			$("#pr").hide();
		} else {
			$("#pr").show();
		}

		// Delivery
		if (value_checked == "a") {
			$("#delv").hide();
		} else {
			$("#delv").show();
		}

		// Expenses
		if (value_checked == "a") {
			$("#exp").hide();
		} else {
			$("#exp").show();
		}

		// Report
		if (value_checked == "a") {
			$("#rep").hide();
		} else {
			$("#rep").show();
		}

		// User
		if (value_checked == "a") {
			$("#user").hide();
		} else {
			$("#user").show();
		}
	});
</script>