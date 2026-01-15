<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];
	
	$id = $_POST['id'];		
	$category = mysqli_real_escape_string($link, $_POST['category']);
	$barcode = mysqli_real_escape_string($link, $_POST['barcode']);
	$pdname = mysqli_real_escape_string($link, $_POST['pdname']);
	$description = mysqli_real_escape_string($link, $_POST['description']);
	$cost = mysqli_real_escape_string($link, $_POST['cost']);
	
	$pc_frm = mysqli_real_escape_string($link, $_POST['pc_frm']);
	$pc_prc = mysqli_real_escape_string($link, $_POST['pc_prc']);
	$pc_qty = mysqli_real_escape_string($link, $_POST['pc_qty']);
	
	$ib_frm = mysqli_real_escape_string($link, $_POST['ib_frm']);
	$ib_prc = mysqli_real_escape_string($link, $_POST['ib_prc']);
	$ib_qty = mysqli_real_escape_string($link, $_POST['ib_qty']);
	
	$bx_frm = mysqli_real_escape_string($link, $_POST['bx_frm']);
	$bx_prc = mysqli_real_escape_string($link, $_POST['bx_prc']);
	$bx_qty = mysqli_real_escape_string($link, $_POST['bx_qty']);
	
	$exp_dt = mysqli_real_escape_string($link, $_POST['expdate']);
	$expiration = date("Y-m-d", strtotime($exp_dt));
	$srch = date("M d, Y", strtotime($exp_dt));
	
	//$name = $pdname . ' - ' . $expiration;

	$name = $pdname;
	
	$images = uploadimage('fileImage', SRV_ROOT . 'images/product/');

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
		$mainImage = 'pd_image';
		$thumbnail = 'pd_thumbnail';
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
		/* Check if the product already exist. 
		$check = $conn->prepare("SELECT * FROM tbl_product
					WHERE pd_barcode = '$barcode' AND pd_id != '$id' AND is_deleted != '1'");
		$check->execute();
				
		if($check->rowCount() > 0)
		{			
			header("Location: index.php?view=modify&id=$id&error=Product already exist! Data entry failed.");
		}
		else
		{	*/
				$catkey = $conn->prepare("SELECT * FROM tbl_category WHERE cat_id = '$category'");
				$catkey->execute();
				$catkey_data = $catkey->fetch();
				$brandname = $catkey_data['cat_name'];
				$catpid = $catkey_data['cat_parent_id'];
				
				$ctn = $conn->prepare("SELECT * FROM tbl_category WHERE cat_id = '$catpid'");
				$ctn->execute();
				$ctn_data = $ctn->fetch();
				$ctname = $ctn_data['cat_name'];
								
				$keyword = $ctname . ' ' . $brandname . ' ' . $pdname . ' ' . $description . ' ' . $srch;
					
				/* Update Product */
				$sql = $conn->prepare("UPDATE tbl_product SET cat_id = '$category', cat_parent_id = '$catpid', pd_barcode = '$barcode', pd_name = '$name', pd_description = '$description', pd_keyword = '$keyword', pd_cost = '$cost', 
								pc_formula = '$pc_frm', ib_formula = '$ib_frm', bx_formula = '$bx_frm', pc_price = '$pc_prc', ib_price = '$ib_prc', bx_price = '$bx_prc', pc_qty = '$pc_qty', ib_qty = '$ib_qty', bx_qty = '$bx_qty',
									pd_expiration = '$expiration', pd_image = $mainImage, pd_thumbnail = $thumbnail, date_modified = NOW() 
										WHERE pd_id = '$id'");
				$sql->execute();
				/* End Product */
		
				/* Insert Log */
				$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
							VALUES ('Product modified', '$name', 'product', '$userId', NOW())");
				$log->execute();
				/* End Log */
				
				header("Location: index.php?view=modify&id=$id&error=Modified successfully");
				

function _deleteImage($id)
{
	include '../global-library/database.php';
	// we will return the status
	// whether the image deleted successfully
	$deleted = false;

	$sql = $conn->prepare("SELECT pd_image, pd_thumbnail
	        FROM tbl_product
			WHERE pd_id = $id");
	$sql->execute();

	if ($sql->rowCount() > 0) {
		$sql_data = $sql->fetch();

		if ($sql_data['pd_image'] && $sql_data['pd_thumbnail']) {
			// remove the image file
			$deleted = @unlink(SRV_ROOT . "images/product/$sql_data[pd_image]");
			$deleted = @unlink(SRV_ROOT . "images/product/$sql_data[pd_thumbnail]");
		}
	}

	return $deleted;
}
		
?>