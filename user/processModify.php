<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

include '../global-library/database.php';
$userId = $_SESSION['user_id'];

$id = $_POST['id'];
$firstname = ucwords($_POST['firstname']);
$lastname = ucwords($_POST['lastname']);
$username = $_POST['username'];
$password = $_POST['password'];
$branch = $_POST['branch'];

// Access Level
$cat = $_POST['cat'];
$cat_a = $_POST['cat_a'];
$cat_e = $_POST['cat_e'];
$cat_d = $_POST['cat_d'];
$cust = $_POST['cust'];
$cust_a = $_POST['cust_a'];
$cust_e = $_POST['cust_e'];
$cust_d = $_POST['cust_d'];
$sup = $_POST['sup'];
$sup_a = $_POST['sup_a'];
$sup_e = $_POST['sup_e'];
$sup_d = $_POST['sup_d'];
$prod = $_POST['prod'];
$prod_a = $_POST['prod_a'];
$prod_e = $_POST['prod_e'];
$prod_d = $_POST['prod_d'];
$rec = $_POST['rec'];
$ret = $_POST['ret'];
$sale = $_POST['sale'];
$sale_v = $_POST['sale_v'];
$sale_d = $_POST['sale_d'];
$jo = $_POST['job_order'];
$pr = $_POST['production_report'];
$delivery = $_POST['delivery'];
$del_v = $_POST['del_v'];
$del_d = $_POST['del_d'];
$exp = $_POST['exp'];
$exp_a = $_POST['exp_a'];
$exp_e = $_POST['exp_e'];
$exp_d = $_POST['exp_d'];
$rep = $_POST['rep'];
$user = $_POST['user'];
$user_a = $_POST['user_a'];
$user_e = $_POST['user_e'];
$user_d = $_POST['user_d'];

$name = $firstname . '&nbsp;' . $lastname;

$top = $_POST['top'];
if ($top == 'o') {
	$isadmin = 0;
} else {
	$isadmin = 1;
}

$images = uploadimage('fileImage', SRV_ROOT . 'images/user/');

$mainImage = $images['image'];
$thumbnail = $images['thumbnail'];

// if uploading a new image
// remove old image
if ($mainImage != '') {
	_deleteImage($id);

	$mainImage = "'$mainImage'";
	$thumbnail = "'$thumbnail'";
} else {
	// if we're not updating the image
	// make sure the old path remain the same
	// in the database
	$mainImage = 'image';
	$thumbnail = 'thumbnail';
}

/*
	Upload an image and return the uploaded image name
*/
function uploadimage($inputName, $uploadDir)
{
	include '../global-library/database.php';
	$image     = $_FILES[$inputName];
	$imagePath = '';
	$thumbnailPath = '';

	// if a file is given
	if (trim($image['tmp_name']) != '') {
		$ext = substr(strrchr($image['name'], "."), 1); //$extensions[$image['type']];

		// generate a random new file name to avoid name conflict
		$imagePath = md5(rand() * time()) . ".$ext";

		list($width, $height, $type, $attr) = getimagesize($image['tmp_name']);

		// make sure the image width does not exceed the
		// maximum allowed width
		if (LIMIT_IMAGE_WIDTH && $width > MAX_IMAGE_WIDTH) {
			$result    = createThumbnail($image['tmp_name'], $uploadDir . $imagePath, MAX_IMAGE_WIDTH);
			$imagePath = $result;
		} else {
			$result = move_uploaded_file($image['tmp_name'], $uploadDir . $imagePath);
		}

		if ($result) {
			// create thumbnail
			$thumbnailPath =  md5(rand() * time()) . ".$ext";
			$result = createThumbnail($uploadDir . $imagePath, $uploadDir . $thumbnailPath, THUMBNAIL_WIDTH);

			// create thumbnail failed, delete the image
			if (!$result) {
				unlink($uploadDir . $imagePath);
				$imagePath = $thumbnailPath = '';
			} else {
				$thumbnailPath = $result;
			}
		} else {
			// the image cannot be upload / resized
			$imagePath = $thumbnailPath = '';
		}
	}


	return array('image' => $imagePath, 'thumbnail' => $thumbnailPath);
}
include '../global-library/database.php';
/* Check if the username already exist. */
$check = $conn->prepare("SELECT * FROM bs_user
					WHERE username = '$username' AND user_id != '$id' AND is_deleted != '1'");
$check->execute();

$ch = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$id' AND is_deleted != '1'");
$ch->execute();
$ch_data = $ch->fetch();

$branch7 = $ch_data['branch_num'];

if ($check->rowCount() > 0) {
	header("Location: index.php?view=modify&id=$id&error=Username already exist");
} else {
	/* Update User */
	$sql = $conn->prepare("UPDATE bs_user SET firstname = '$firstname', lastname = '$lastname', username = '$username', password = md5('$password'), pass_text = '$password', image = $mainImage, thumbnail = $thumbnail,
								branch_num = '$branch',
								is_admin = '0',
								is_category_access = '$cat', is_cat_a_access = '$cat_a', is_cat_e_access = '$cat_e', is_cat_d_access = '$cat_d',
								is_customer_access = '$cust', is_cust_a_access = '$cust_a', is_cust_e_access = '$cust_e', is_cust_d_access = '$cust_d',
								is_supplier_access = '$sup', is_sup_a_access = '$sup_a', is_sup_e_access = '$sup_e', is_sup_d_access = '$sup_d',
								is_product_access = '$prod', is_prod_a_access = '$prod_a', is_prod_e_access = '$prod_e', is_prod_d_access = '$prod_d',
								is_receive_access = '$rec', is_return_access = '$ret',
								is_sales_access = '$sale', is_sale_v_access = '$sale_v', is_sale_d_access = '$sale_d', is_job_order_access = '$jo',
								is_production_report_access = '$pr',
								is_delivery_access = '$delivery', is_del_v_access = '$del_v', is_del_d_access = '$del_d',
								is_expense_access = '$exp', is_exp_a_access = '$exp_a', is_exp_e_access = '$exp_e', is_exp_d_access = '$exp_d',
								is_report_access = '$rep', 
								is_user_access = '$user', is_user_a_access = '$user_a', is_user_e_access = '$user_e', is_user_d_access = '$user_d',
								date_modified = '$today_date1' 
									WHERE user_id = '$id'");
	$sql->execute();
	/* End User */

	/* Insert Log */
	$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
							VALUES ('User modified', '$name', 'user', '$userId', '$today_date1')");
	$log->execute();
	/* End Log */

	if ($branch7 == 1) {
		$id = $_POST['id'];
		$firstname = ucwords($_POST['firstname']);
		$lastname = ucwords($_POST['lastname']);
		$username = $_POST['username'];
		$password = $_POST['password'];
		$branch = $_POST['branch'];

		$check = $conn->prepare("SELECT * FROM dbaq1zijdyzqgj.bs_user
								WHERE username = '$username' AND user_id != '$id' AND is_deleted != '1'");
		$check->execute();
		if ($check->rowCount() > 0) {
			$sql = $conn->prepare("UPDATE dbaq1zijdyzqgj.bs_user SET firstname = '$firstname', lastname = '$lastname', username = '$username', password = md5('$password'), pass_text = '$password', image = $mainImage, thumbnail = $thumbnail,
										branch_num = '$branch',
										is_admin = '0',
										is_category_access = '$cat', is_cat_a_access = '$cat_a', is_cat_e_access = '$cat_e', is_cat_d_access = '$cat_d',
										is_customer_access = '$cust', is_cust_a_access = '$cust_a', is_cust_e_access = '$cust_e', is_cust_d_access = '$cust_d',
										is_supplier_access = '$sup', is_sup_a_access = '$sup_a', is_sup_e_access = '$sup_e', is_sup_d_access = '$sup_d',
										is_product_access = '$prod', is_prod_a_access = '$prod_a', is_prod_e_access = '$prod_e', is_prod_d_access = '$prod_d',
										is_receive_access = '$rec', is_return_access = '$ret',
										is_sales_access = '$sale', is_sale_v_access = '$sale_v', is_sale_d_access = '$sale_d',
										is_delivery_access = '$delivery', is_del_v_access = '$del_v', is_del_d_access = '$del_d',
										is_expense_access = '$exp', is_exp_a_access = '$exp_a', is_exp_e_access = '$exp_e', is_exp_d_access = '$exp_d',
										is_report_access = '$rep', 
										is_user_access = '$user', is_user_a_access = '$user_a', is_user_e_access = '$user_e', is_user_d_access = '$user_d',
										date_modified = '$today_date1' 
											WHERE username = '$username'");
			$sql->execute();
		} else {
			$sql = $conn->prepare("INSERT INTO dbaq1zijdyzqgj.bs_user (is_admin, firstname, lastname, username, password, pass_text, image, thumbnail, access_level, date_added, theme, branch_num, is_deleted) 
															VALUES ('0', '$firstname', '$lastname', '$username', md5('$password'), '$password', '$mainImage', '$thumbnail', '2', '$today_date1', 'cerulean', '1', '0')");
			$sql->execute();
		}

		$sql7 = $conn->prepare("DELETE FROM dbaq1zijdyzqgj.bs_user WHERE branch_num != '1'");
		$sql7->execute();
	} else if ($branch7 == 2) {

		$id = $_POST['id'];
		$firstname = ucwords($_POST['firstname']);
		$lastname = ucwords($_POST['lastname']);
		$username = $_POST['username'];
		$password = $_POST['password'];
		$branch = $_POST['branch'];

		$check = $conn->prepare("SELECT * FROM db9zmfww0e39gt.bs_user
								WHERE username = '$username' AND user_id != '$id' AND is_deleted != '1'");
		$check->execute();
		if ($check->rowCount() > 0) {
			$sql = $conn->prepare("UPDATE db9zmfww0e39gt.bs_user SET firstname = '$firstname', lastname = '$lastname', username = '$username', password = md5('$password'), pass_text = '$password', image = $mainImage, thumbnail = $thumbnail,
												branch_num = '2',
												is_admin = '0',
												is_category_access = '$cat', is_cat_a_access = '$cat_a', is_cat_e_access = '$cat_e', is_cat_d_access = '$cat_d',
												is_customer_access = '$cust', is_cust_a_access = '$cust_a', is_cust_e_access = '$cust_e', is_cust_d_access = '$cust_d',
												is_supplier_access = '$sup', is_sup_a_access = '$sup_a', is_sup_e_access = '$sup_e', is_sup_d_access = '$sup_d',
												is_product_access = '$prod', is_prod_a_access = '$prod_a', is_prod_e_access = '$prod_e', is_prod_d_access = '$prod_d',
												is_receive_access = '$rec', is_return_access = '$ret',
												is_sales_access = '$sale', is_sale_v_access = '$sale_v', is_sale_d_access = '$sale_d',
												is_delivery_access = '$delivery', is_del_v_access = '$del_v', is_del_d_access = '$del_d',
												is_expense_access = '$exp', is_exp_a_access = '$exp_a', is_exp_e_access = '$exp_e', is_exp_d_access = '$exp_d',
												is_report_access = '$rep', 
												is_user_access = '$user', is_user_a_access = '$user_a', is_user_e_access = '$user_e', is_user_d_access = '$user_d',
												date_modified = '$today_date1' 
													WHERE username = '$username'");
			$sql->execute();
		} else {
			$sql = $conn->prepare("INSERT INTO db9zmfww0e39gt.bs_user (is_admin, firstname, lastname, username, password, pass_text, image, thumbnail, access_level, date_added, theme, branch_num, is_deleted) 
																VALUES ('0', '$firstname', '$lastname', '$username', md5('$password'), '$password', '$mainImage', '$thumbnail', '2', '$today_date1', 'cerulean', '2', '0')");
			$sql->execute();
		}

		$sql7 = $conn->prepare("DELETE FROM db9zmfww0e39gt.bs_user WHERE branch_num != '2'");
		$sql7->execute();
	} else if ($branch7 == 3) {

		$id = $_POST['id'];
		$firstname = ucwords($_POST['firstname']);
		$lastname = ucwords($_POST['lastname']);
		$username = $_POST['username'];
		$password = $_POST['password'];
		$branch = $_POST['branch'];

		$check = $conn->prepare("SELECT * FROM dbbagnnas1vbly.bs_user
								WHERE username = '$username' AND user_id != '$id' AND is_deleted != '1'");
		$check->execute();
		if ($check->rowCount() > 0) {
			$sql = $conn->prepare("UPDATE dbbagnnas1vbly.bs_user SET firstname = '$firstname', lastname = '$lastname', username = '$username', password = md5('$password'), pass_text = '$password', image = $mainImage, thumbnail = $thumbnail,
												branch_num = '3',
												is_admin = '0',
												is_category_access = '$cat', is_cat_a_access = '$cat_a', is_cat_e_access = '$cat_e', is_cat_d_access = '$cat_d',
												is_customer_access = '$cust', is_cust_a_access = '$cust_a', is_cust_e_access = '$cust_e', is_cust_d_access = '$cust_d',
												is_supplier_access = '$sup', is_sup_a_access = '$sup_a', is_sup_e_access = '$sup_e', is_sup_d_access = '$sup_d',
												is_product_access = '$prod', is_prod_a_access = '$prod_a', is_prod_e_access = '$prod_e', is_prod_d_access = '$prod_d',
												is_receive_access = '$rec', is_return_access = '$ret',
												is_sales_access = '$sale', is_sale_v_access = '$sale_v', is_sale_d_access = '$sale_d',
												is_delivery_access = '$delivery', is_del_v_access = '$del_v', is_del_d_access = '$del_d',
												is_expense_access = '$exp', is_exp_a_access = '$exp_a', is_exp_e_access = '$exp_e', is_exp_d_access = '$exp_d',
												is_report_access = '$rep', 
												is_user_access = '$user', is_user_a_access = '$user_a', is_user_e_access = '$user_e', is_user_d_access = '$user_d',
												date_modified = '$today_date1' 
													WHERE username = '$username'");
			$sql->execute();
		} else {
			$sql = $conn->prepare("INSERT INTO dbbagnnas1vbly.bs_user (is_admin, firstname, lastname, username, password, pass_text, image, thumbnail, access_level, date_added, theme, branch_num, is_deleted) 
																VALUES ('0', '$firstname', '$lastname', '$username', md5('$password'), '$password', '$mainImage', '$thumbnail', '2', '$today_date1', 'cerulean', '3', '0')");
			$sql->execute();
		}

		$sql7 = $conn->prepare("DELETE FROM dbbagnnas1vbly.bs_user WHERE branch_num != '3'");
		$sql7->execute();
	} else if ($branch7 == 4) {

		$id = $_POST['id'];
		$firstname = ucwords($_POST['firstname']);
		$lastname = ucwords($_POST['lastname']);
		$username = $_POST['username'];
		$password = $_POST['password'];
		$branch = $_POST['branch'];

		$check = $conn->prepare("SELECT * FROM dbeqlwgwj8husy.bs_user
								WHERE username = '$username' AND user_id != '$id' AND is_deleted != '1'");
		$check->execute();
		if ($check->rowCount() > 0) {
			$sql = $conn->prepare("UPDATE dbeqlwgwj8husy.bs_user SET firstname = '$firstname', lastname = '$lastname', username = '$username', password = md5('$password'), pass_text = '$password', image = $mainImage, thumbnail = $thumbnail,
												branch_num = '4',
												is_admin = '0',
												is_category_access = '$cat', is_cat_a_access = '$cat_a', is_cat_e_access = '$cat_e', is_cat_d_access = '$cat_d',
												is_customer_access = '$cust', is_cust_a_access = '$cust_a', is_cust_e_access = '$cust_e', is_cust_d_access = '$cust_d',
												is_supplier_access = '$sup', is_sup_a_access = '$sup_a', is_sup_e_access = '$sup_e', is_sup_d_access = '$sup_d',
												is_product_access = '$prod', is_prod_a_access = '$prod_a', is_prod_e_access = '$prod_e', is_prod_d_access = '$prod_d',
												is_receive_access = '$rec', is_return_access = '$ret',
												is_sales_access = '$sale', is_sale_v_access = '$sale_v', is_sale_d_access = '$sale_d',
												is_delivery_access = '$delivery', is_del_v_access = '$del_v', is_del_d_access = '$del_d',
												is_expense_access = '$exp', is_exp_a_access = '$exp_a', is_exp_e_access = '$exp_e', is_exp_d_access = '$exp_d',
												is_report_access = '$rep', 
												is_user_access = '$user', is_user_a_access = '$user_a', is_user_e_access = '$user_e', is_user_d_access = '$user_d',
												date_modified = '$today_date1' 
													WHERE username = '$username'");
			$sql->execute();
		} else {
			$sql = $conn->prepare("INSERT INTO dbeqlwgwj8husy.bs_user (is_admin, firstname, lastname, username, password, pass_text, image, thumbnail, access_level, date_added, theme, branch_num, is_deleted) 
																VALUES ('0', '$firstname', '$lastname', '$username', md5('$password'), '$password', '$mainImage', '$thumbnail', '2', '$today_date1', 'cerulean', '4', '0')");
			$sql->execute();
		}

		$sql7 = $conn->prepare("DELETE FROM dbeqlwgwj8husy.bs_user WHERE branch_num != '4'");
		$sql7->execute();
	} else if ($branch7 == 5) {

		$id = $_POST['id'];
		$firstname = ucwords($_POST['firstname']);
		$lastname = ucwords($_POST['lastname']);
		$username = $_POST['username'];
		$password = $_POST['password'];
		$branch = $_POST['branch'];

		$check = $conn->prepare("SELECT * FROM dblk0nwutv30gf.bs_user
								WHERE username = '$username' AND user_id != '$id' AND is_deleted != '1'");
		$check->execute();
		if ($check->rowCount() > 0) {
			$sql = $conn->prepare("UPDATE dblk0nwutv30gf.bs_user SET firstname = '$firstname', lastname = '$lastname', username = '$username', password = md5('$password'), pass_text = '$password', image = $mainImage, thumbnail = $thumbnail,
												branch_num = '5',
												is_admin = '0',
												is_category_access = '$cat', is_cat_a_access = '$cat_a', is_cat_e_access = '$cat_e', is_cat_d_access = '$cat_d',
												is_customer_access = '$cust', is_cust_a_access = '$cust_a', is_cust_e_access = '$cust_e', is_cust_d_access = '$cust_d',
												is_supplier_access = '$sup', is_sup_a_access = '$sup_a', is_sup_e_access = '$sup_e', is_sup_d_access = '$sup_d',
												is_product_access = '$prod', is_prod_a_access = '$prod_a', is_prod_e_access = '$prod_e', is_prod_d_access = '$prod_d',
												is_receive_access = '$rec', is_return_access = '$ret',
												is_sales_access = '$sale', is_sale_v_access = '$sale_v', is_sale_d_access = '$sale_d',
												is_delivery_access = '$delivery', is_del_v_access = '$del_v', is_del_d_access = '$del_d',
												is_expense_access = '$exp', is_exp_a_access = '$exp_a', is_exp_e_access = '$exp_e', is_exp_d_access = '$exp_d',
												is_report_access = '$rep', 
												is_user_access = '$user', is_user_a_access = '$user_a', is_user_e_access = '$user_e', is_user_d_access = '$user_d',
												date_modified = '$today_date1' 
													WHERE username = '$username'");
			$sql->execute();
		} else {
			$sql = $conn->prepare("INSERT INTO dblk0nwutv30gf.bs_user (is_admin, firstname, lastname, username, password, pass_text, image, thumbnail, access_level, date_added, theme, branch_num, is_deleted) 
																VALUES ('0', '$firstname', '$lastname', '$username', md5('$password'), '$password', '$mainImage', '$thumbnail', '2', '$today_date1', 'cerulean', '5', '0')");
			$sql->execute();
		}

		$sql7 = $conn->prepare("DELETE FROM dblk0nwutv30gf.bs_user WHERE branch_num != '5'");
		$sql7->execute();
	} else if ($branch7 == 6) {

		$id = $_POST['id'];
		$firstname = ucwords($_POST['firstname']);
		$lastname = ucwords($_POST['lastname']);
		$username = $_POST['username'];
		$password = $_POST['password'];
		$branch = $_POST['branch'];

		$check = $conn->prepare("SELECT * FROM dbsfm9aqzvepou.bs_user
								WHERE username = '$username' AND user_id != '$id' AND is_deleted != '1'");
		$check->execute();
		if ($check->rowCount() > 0) {
			$sql = $conn->prepare("UPDATE dbsfm9aqzvepou.bs_user SET firstname = '$firstname', lastname = '$lastname', username = '$username', password = md5('$password'), pass_text = '$password', image = $mainImage, thumbnail = $thumbnail,
												branch_num = '6',
												is_admin = '0',
												is_category_access = '$cat', is_cat_a_access = '$cat_a', is_cat_e_access = '$cat_e', is_cat_d_access = '$cat_d',
												is_customer_access = '$cust', is_cust_a_access = '$cust_a', is_cust_e_access = '$cust_e', is_cust_d_access = '$cust_d',
												is_supplier_access = '$sup', is_sup_a_access = '$sup_a', is_sup_e_access = '$sup_e', is_sup_d_access = '$sup_d',
												is_product_access = '$prod', is_prod_a_access = '$prod_a', is_prod_e_access = '$prod_e', is_prod_d_access = '$prod_d',
												is_receive_access = '$rec', is_return_access = '$ret',
												is_sales_access = '$sale', is_sale_v_access = '$sale_v', is_sale_d_access = '$sale_d',
												is_delivery_access = '$delivery', is_del_v_access = '$del_v', is_del_d_access = '$del_d',
												is_expense_access = '$exp', is_exp_a_access = '$exp_a', is_exp_e_access = '$exp_e', is_exp_d_access = '$exp_d',
												is_report_access = '$rep', 
												is_user_access = '$user', is_user_a_access = '$user_a', is_user_e_access = '$user_e', is_user_d_access = '$user_d',
												date_modified = '$today_date1' 
													WHERE username = '$username'");
			$sql->execute();
		} else {
			$sql = $conn->prepare("INSERT INTO dbsfm9aqzvepou.bs_user (is_admin, firstname, lastname, username, password, pass_text, image, thumbnail, access_level, date_added, theme, branch_num, is_deleted) 
																VALUES ('0', '$firstname', '$lastname', '$username', md5('$password'), '$password', '$mainImage', '$thumbnail', '2', '$today_date1', 'cerulean', '6', '0')");
			$sql->execute();
		}

		$sql7 = $conn->prepare("DELETE FROM dbsfm9aqzvepou.bs_user WHERE branch_num != '6'");
		$sql7->execute();
	} else if ($branch7 == 7) {

		$id = $_POST['id'];
		$firstname = ucwords($_POST['firstname']);
		$lastname = ucwords($_POST['lastname']);
		$username = $_POST['username'];
		$password = $_POST['password'];
		$branch = $_POST['branch'];

		$check = $conn->prepare("SELECT * FROM dbjdbn1excuqsu.bs_user
								WHERE username = '$username' AND user_id != '$id' AND is_deleted != '1'");
		$check->execute();
		if ($check->rowCount() > 0) {
			$sql = $conn->prepare("UPDATE dbjdbn1excuqsu.bs_user SET firstname = '$firstname', lastname = '$lastname', username = '$username', password = md5('$password'), pass_text = '$password', image = $mainImage, thumbnail = $thumbnail,
												branch_num = '7',
												is_admin = '0',
												is_category_access = '$cat', is_cat_a_access = '$cat_a', is_cat_e_access = '$cat_e', is_cat_d_access = '$cat_d',
												is_customer_access = '$cust', is_cust_a_access = '$cust_a', is_cust_e_access = '$cust_e', is_cust_d_access = '$cust_d',
												is_supplier_access = '$sup', is_sup_a_access = '$sup_a', is_sup_e_access = '$sup_e', is_sup_d_access = '$sup_d',
												is_product_access = '$prod', is_prod_a_access = '$prod_a', is_prod_e_access = '$prod_e', is_prod_d_access = '$prod_d',
												is_receive_access = '$rec', is_return_access = '$ret',
												is_sales_access = '$sale', is_sale_v_access = '$sale_v', is_sale_d_access = '$sale_d',
												is_delivery_access = '$delivery', is_del_v_access = '$del_v', is_del_d_access = '$del_d',
												is_expense_access = '$exp', is_exp_a_access = '$exp_a', is_exp_e_access = '$exp_e', is_exp_d_access = '$exp_d',
												is_report_access = '$rep', 
												is_user_access = '$user', is_user_a_access = '$user_a', is_user_e_access = '$user_e', is_user_d_access = '$user_d',
												date_modified = '$today_date1' 
													WHERE username = '$username'");
			$sql->execute();
		} else {
			$sql = $conn->prepare("INSERT INTO dbjdbn1excuqsu.bs_user (is_admin, firstname, lastname, username, password, pass_text, image, thumbnail, access_level, date_added, theme, branch_num, is_deleted) 
																VALUES ('0', '$firstname', '$lastname', '$username', md5('$password'), '$password', '$mainImage', '$thumbnail', '2', '$today_date1', 'cerulean', '7', '0')");
			$sql->execute();
		}

		$sql7 = $conn->prepare("DELETE FROM dbjdbn1excuqsu.bs_user WHERE branch_num != '7'");
		$sql7->execute();
	} else if ($branch7 == 8) {

		$id = $_POST['id'];
		$firstname = ucwords($_POST['firstname']);
		$lastname = ucwords($_POST['lastname']);
		$username = $_POST['username'];
		$password = $_POST['password'];
		$branch = $_POST['branch'];

		$check = $conn->prepare("SELECT * FROM dbeub5xgrqq3gh.bs_user
								WHERE username = '$username' AND user_id != '$id' AND is_deleted != '1'");
		$check->execute();
		if ($check->rowCount() > 0) {
			$sql = $conn->prepare("UPDATE dbeub5xgrqq3gh.bs_user SET firstname = '$firstname', lastname = '$lastname', username = '$username', password = md5('$password'), pass_text = '$password', image = $mainImage, thumbnail = $thumbnail,
												branch_num = '8',
												is_admin = '0',
												is_category_access = '$cat', is_cat_a_access = '$cat_a', is_cat_e_access = '$cat_e', is_cat_d_access = '$cat_d',
												is_customer_access = '$cust', is_cust_a_access = '$cust_a', is_cust_e_access = '$cust_e', is_cust_d_access = '$cust_d',
												is_supplier_access = '$sup', is_sup_a_access = '$sup_a', is_sup_e_access = '$sup_e', is_sup_d_access = '$sup_d',
												is_product_access = '$prod', is_prod_a_access = '$prod_a', is_prod_e_access = '$prod_e', is_prod_d_access = '$prod_d',
												is_receive_access = '$rec', is_return_access = '$ret',
												is_sales_access = '$sale', is_sale_v_access = '$sale_v', is_sale_d_access = '$sale_d',
												is_delivery_access = '$delivery', is_del_v_access = '$del_v', is_del_d_access = '$del_d',
												is_expense_access = '$exp', is_exp_a_access = '$exp_a', is_exp_e_access = '$exp_e', is_exp_d_access = '$exp_d',
												is_report_access = '$rep', 
												is_user_access = '$user', is_user_a_access = '$user_a', is_user_e_access = '$user_e', is_user_d_access = '$user_d',
												date_modified = '$today_date1' 
													WHERE username = '$username'");
			$sql->execute();
		} else {
			$sql = $conn->prepare("INSERT INTO dbeub5xgrqq3gh.bs_user (is_admin, firstname, lastname, username, password, pass_text, image, thumbnail, access_level, date_added, theme, branch_num, is_deleted) 
																VALUES ('0', '$firstname', '$lastname', '$username', md5('$password'), '$password', '$mainImage', '$thumbnail', '2', '$today_date1', 'cerulean', '8', '0')");
			$sql->execute();
		}

		$sql7 = $conn->prepare("DELETE FROM dbeub5xgrqq3gh.bs_user WHERE branch_num != '8'");
		$sql7->execute();
	}

	header("Location: index.php?view=modify&id=$id&error=Modified successfully");
}

function _deleteImage($id)
{
	include '../global-library/database.php';
	// we will return the status
	// whether the image deleted successfully
	$deleted = false;

	$sql = $conn->prepare("SELECT image, thumbnail
	        FROM bs_user
			WHERE user_id = $id");
	$sql->execute();

	if ($sql->rowCount() > 0) {
		$sql_data = $sql->fetch();

		if ($sql_data['image'] && $sql_data['thumbnail']) {
			// remove the image file
			$deleted = @unlink(SRV_ROOT . "images/user/$sql_data[image]");
			$deleted = @unlink(SRV_ROOT . "images/user/$sql_data[thumbnail]");
		}
	}

	return $deleted;
}
