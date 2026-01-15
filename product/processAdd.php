<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

include '../global-library/database.php';
$userId = $_SESSION['user_id'];

$category = mysqli_real_escape_string($link, $_POST['category']);
$barcode = mysqli_real_escape_string($link, $_POST['barcode'] ?? '');
$pdname = mysqli_real_escape_string($link, $_POST['pdname']);
$description = mysqli_real_escape_string($link, $_POST['description']);
$cost = mysqli_real_escape_string($link, $_POST['cost']);

$pc_frm = mysqli_real_escape_string($link, $_POST['pc_frm']);
$pc_prc = mysqli_real_escape_string($link, $_POST['pc_prc']);
$pc_qty = mysqli_real_escape_string($link, $_POST['pc_qty']);

$mqty = mysqli_real_escape_string($link, $_POST['pd_mqty']);

// $ib_frm = mysqli_real_escape_string($link, $_POST['ib_frm']);
// $ib_prc = mysqli_real_escape_string($link, $_POST['ib_prc']);
// $ib_qty = mysqli_real_escape_string($link, $_POST['ib_qty']);

// $bx_frm = mysqli_real_escape_string($link, $_POST['bx_frm']);
// $bx_prc = mysqli_real_escape_string($link, $_POST['bx_prc']);
// $bx_qty = mysqli_real_escape_string($link, $_POST['bx_qty']);

$exp_dt = mysqli_real_escape_string($link, $_POST['expdate'] ?? '');

if (!empty($exp_dt) && strtotime($exp_dt) !== false) {
	$expiration = date("Y-m-d H:i:s", strtotime($exp_dt)); // includes minutes
} else {
	$expiration = ''; // stays blank if no valid date
}


$srch = date("M d, Y", strtotime($exp_dt));

$name = $pdname;
$barcode = mysqli_real_escape_string($link, $_POST['barcode'] ?? '');
$images = uploadimage('fileImage', SRV_ROOT . 'images/product/');

$mainImage = $images['image'];
$thumbnail = $images['thumbnail'];

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

/* Check if the product already exist. */
$check = $conn->prepare("SELECT * FROM tbl_product
							WHERE  is_deleted != '1'");
$check->execute();


$catkey = $conn->prepare("SELECT * FROM tbl_category WHERE cat_id = '$category'");
$catkey->execute();
$catkey_data = $catkey->fetch();
$brandname = $catkey_data['cat_name'];
$catpid = $catkey_data['cat_parent_id'];

$ctn = $conn->prepare("SELECT * FROM tbl_category WHERE cat_id = '$catpid'");
$ctn->execute();
$ctn_data = $ctn->fetch();
$ctname = $ctn_data['cat_name'];

$keyword = $ctname;


// Only check for duplicates if barcode is not blank
if (!empty($barcode)) {
	$chk = $conn->prepare("SELECT * FROM tbl_product WHERE pd_barcode = '$barcode'");
	$chk->execute();

	if ($chk->rowCount() > 0) {
		header('Location: index.php?view=add&error=' . urlencode('Serial # Already Taken! Data entry failed.'));
		exit;
	}
}


/* Insert Product */
$sql = $conn->prepare("INSERT INTO tbl_product (cat_id, cat_parent_id, pd_barcode, pd_name, pd_name7, pd_description, pd_keyword, pd_cost, pc_formula, ib_formula, bx_formula, pc_price, ib_price, bx_price, pc_qty, ib_qty, bx_qty, pd_mqty, pd_expiration, pd_image, pd_thumbnail, date_added, is_deleted)
VALUES ('$category', '$catpid', '$barcode', '$name', '$pdname', '$description', '$keyword', '$cost', '$pc_frm', '$ib_frm', '$bx_frm', '$pc_prc', '$ib_prc', '$bx_prc', '$pc_qty', '$ib_qty', '$bx_qty', '$mqty', '$expiration', '$mainImage', '$thumbnail', '$today_date1', '0')");
$sql->execute();
/* End Product */


/* Insert Log */
$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
VALUES ('Product added', '$name', 'product', '$userId', NOW())");
$log->execute();
/* End Log */

header('Location: index.php?view=add&error=' . urlencode('Added successfully'));
