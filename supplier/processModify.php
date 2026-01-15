<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];

	$id = $_POST['id'];
	$sn = mysqli_real_escape_string($link, $_POST['sn']);
	$firstname = mysqli_real_escape_string($link, $_POST['firstname']);
	$lastname = mysqli_real_escape_string($link, $_POST['lastname']);
	$cn = $_POST['cn'];	
	$address = $_POST['address'];
	
	$name = $firstname . '&nbsp;' . $lastname;
	
	$images = uploadimage('fileImage', SRV_ROOT . 'images/supplier/');

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
		/* Check if the supplier already exist. */
		$check = $conn->prepare("SELECT * FROM bs_supplier
					WHERE company_name = '$sn' AND sup_id != '$id' AND is_deleted != '1'");
		$check->execute();
				
		if($check->rowCount() > 0)
		{			
			header("Location: index.php?view=modify&id=$id&error=Supplier already exist");
		}
		else
		{
				/* Update Supplier */
				$sql = $conn->prepare("UPDATE bs_supplier SET company_name = '$sn', firstname = '$firstname', lastname = '$lastname', contactno = '$cn', address = '$address', image = $mainImage, thumbnail = $thumbnail, date_modified = '$today_date1' 
								WHERE sup_id = '$id'");
				$sql->execute();
				/* End Supplier */
		
				/* Insert Log */
				$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
							VALUES ('Supplier modified', '$name', 'supplier', '$userId', '$today_date1')");
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
	        FROM bs_supplier
			WHERE sup_id = $id");
	$sql->execute();

	if ($sql->rowCount()) {
		$sql_data = $sql->fetch();

		if ($sql_data['image'] && $sql_data['thumbnail']) {
			// remove the image file
			$deleted = @unlink(SRV_ROOT . "images/supplier/$sql_data[image]");
			$deleted = @unlink(SRV_ROOT . "images/supplier/$sql_data[thumbnail]");
		}
	}

	return $deleted;
}
		
?>