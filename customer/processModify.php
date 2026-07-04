<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];

	$id = $_POST['id'];	
	$cname = mysqli_real_escape_string($link, $_POST['cname']);
	$custname = mysqli_real_escape_string($link, $_POST['custname']);
	$address = mysqli_real_escape_string($link, $_POST['address']);
	$cp = mysqli_real_escape_string($link, $_POST['cp']);
	$cn = mysqli_real_escape_string($link, $_POST['cn']);
	$scn = mysqli_real_escape_string($link, $_POST['scn']);
	$messenger = mysqli_real_escape_string($link, $_POST['messenger']);
	$email = mysqli_real_escape_string($link, $_POST['email']);
	
	$images = uploadimage('fileImage', SRV_ROOT . 'images/customer/');

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
		/* Check if the client_name already exist. */
		$check = $conn->prepare("SELECT * FROM bs_customer
					WHERE client_name = '$cname' AND cust_id != '$id' AND is_deleted != '1'");
		$check->execute();
				
		if($check->rowCount() > 0)
		{			
			header("Location: index.php?view=modify&id=$id&error=Customer already exist");
		}
		else
		{
				/* Update Customer */
				$sql = $conn->prepare("UPDATE bs_customer SET client_name = '$cname', address = '$address', customer_name = '$custname', contact_person = '$cp', contactno = '$cn', s_contactno = '$scn', messenger = '$messenger', email = '$email', image = $mainImage, thumbnail = $thumbnail, date_modified = NOW() 
							WHERE cust_id = '$id'");
				$sql->execute();
				/* End Customer */
		
				/* Insert Log */
				$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
							VALUES ('Customer modified', '$cname', 'customer', '$userId', NOW())");
				$log->execute();
				/* End Log */
				
				header("Location: index.php?view=modify&id=$id&error=Modified successfully");
		}		

function _deleteImage($id)
{
	include '../global-library/database.php';
	// we will return the status
	// whether the image deleted successfully
	$deleted = false;

	$sql = $conn->prepare("SELECT image, thumbnail
	        FROM bs_customer
			WHERE cust_id = $id");
	$sql->execute();

	if ($sql->rowCount()) {
		$sql_data = $sql->fetch();

		if ($sql_data['image'] && $sql_data['thumbnail']) {
			// remove the image file
			$deleted = @unlink(SRV_ROOT . "images/customer/$sql_data[image]");
			$deleted = @unlink(SRV_ROOT . "images/customer/$sql_data[thumbnail]");
		}
	}

	return $deleted;
}
		
?>