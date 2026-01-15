<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {
	
    case 'add' :
        addCategory();
        break;
      
    case 'modify' :
        modifyCategory();
        break;
        
    case 'delete' :
        deleteCategory();
        break;
    
    case 'deleteImage' :
        deleteImage();
        break;
    
	   
    default :
        // if action is not defined or unknown
        // move to main category page
        header('Location: index.php');
}


/*
    Add a category
*/
function addCategory()
{
    include '../global-library/database.php';
    $name        = $_POST['txtName'];
    $description = $_POST['mtxDescription'];
    $image       = $_FILES['fileImage'];
    $parentId    = $_POST['hidParentId'];
    
    $catImage = uploadImage('fileImage', SRV_ROOT . 'images/category/');
    
    $sql = $conn->prepare("INSERT INTO tbl_category (cat_parent_id, cat_name, cat_description, cat_image, is_deleted) 
					VALUES ($parentId, '$name', '$description', '$catImage', '0')");
    $sql->execute();
    
    header('Location: index.php?catId=' . $parentId . '&error=Added successfully');              
}

/*
    Upload an image and return the uploaded image name 
*/
function uploadImage($inputName, $uploadDir)
{
    include '../global-library/database.php';
    $image     = $_FILES[$inputName];
    $imagePath = '';
    
    // if a file is given
    if (trim($image['tmp_name']) != '') {
        // get the image extension
        $ext = substr(strrchr($image['name'], "."), 1); 

        // generate a random new file name to avoid name conflict
        $imagePath = md5(rand() * time()) . ".$ext";
        
		// check the image width. if it exceed the maximum
		// width we must resize it
		$size = getimagesize($image['tmp_name']);
		
		if ($size[0] > MAX_CATEGORY_IMAGE_WIDTH) {
			$imagePath = createThumbnail($image['tmp_name'], $uploadDir . $imagePath, MAX_CATEGORY_IMAGE_WIDTH);
		} else {
			// move the image to category image directory
			// if fail set $imagePath to empty string
			if (!move_uploaded_file($image['tmp_name'], $uploadDir . $imagePath)) {
				$imagePath = '';
			}
		}	
    }

    
    return $imagePath;
}

/*
    Modify a category
*/
function modifyCategory()
{
    include '../global-library/database.php';
    $catId       = (int)$_GET['catId'];
    $name        = $_POST['txtName'];
    $description = $_POST['mtxDescription'];
    $image       = $_FILES['fileImage'];
    
    $catImage = uploadImage('fileImage', SRV_ROOT . 'images/category/');
    
    // if uploading a new image
    // remove old image
    if ($catImage != '') {
        _deleteImage($catId);
		$catImage = "'$catImage'";
    } else {
		// leave the category image as it was
		$catImage = 'cat_image';
	}
     
    $sql    = $conn->prepare("UPDATE tbl_category 
               SET cat_name = '$name', cat_description = '$description', cat_image = $catImage
               WHERE cat_id = $catId");
           
    $sql->execute();
    header("Location: index.php?view=modify&catId=$catId&error=Modified successfully");
}

/*
    Remove a category
*/
function deleteCategory()
{
    include '../global-library/database.php';
    if (isset($_GET['catId']) && (int)$_GET['catId'] > 0) {
        $catId = (int)$_GET['catId'];
    } else {
        header('Location: index.php');
    }
    
	// find all the children categories
	$children = getChildren($catId);
	
	// make an array containing this category and all it's children
	$categories  = array_merge($children, array($catId));
	$numCategory = count($categories);

	// remove all product image & thumbnail 
	// if the product's category is in  $categories
	$sql = $conn->prepare("SELECT pd_id, pd_image, pd_thumbnail
	        FROM tbl_product
			WHERE cat_id IN (" . implode(',', $categories) . ")");
	$sql->execute();
	
	while ($sql_data = $sql->fetch()) {
		$pd_image = $sql_data['pd_image'];
		$pd_thumbnail = $sql_data['pd_thumbnail'];
		
		@unlink(SRV_ROOT . "images/product/$pd_image");
		@unlink(SRV_ROOT . "images/product/$pd_thumbnail");
	}
	
	// delete the products. set is_deleted to 1 as deleted
	$sql = $conn->prepare("UPDATE tbl_product SET is_deleted = '1'
			WHERE cat_id IN (" . implode(',', $categories) . ")");
	$sql->execute();
	
	// then remove the categories image
	_deleteImage($categories);

    // delete the category. set is_deleted to 1 as deleted;
    $sql = $conn->prepare("UPDATE tbl_category SET is_deleted = '1'
            WHERE cat_id IN (" . implode(',', $categories) . ")");
    $sql->execute();
        
	header("Location: index.php?error=Deleted successfully");
}


/*
	Recursively find all children of $catId
*/
function getChildren($catId)
{
    include '../global-library/database.php';
    $sql = $conn->prepare("SELECT cat_id ".
           "FROM tbl_category ".
           "WHERE cat_parent_id = $catId ");
    $sql->execute();
    
	$cat = array();
	if ($sql->rowCount() > 0) {
		while ($sql_data = $sql->fetch()) {
			$cat[] = $sql_data[0];
			
			// call this function again to find the children
			$cat  = array_merge($cat, getChildren($sql_data[0]));
		}
    }

    return $cat;
}


/*
    Remove a category image
*/
function deleteImage()
{
    include '../global-library/database.php';
    if (isset($_GET['catId']) && (int)$_GET['catId'] > 0) {
        $catId = (int)$_GET['catId'];
    } else {
        header('Location: index.php');
    }
    
	_deleteImage($catId);
	
	// update the image name in the database
	$sql = $conn->prepare("UPDATE tbl_category
			SET cat_image = ''
			WHERE cat_id = $catId");
	$sql->execute();    

    header("Location: index.php?view=modify&catId=$catId&error=Image deleted successfully");
}

/*
	Delete a category image where category = $catId
*/
function _deleteImage($catId)
{
    include '../global-library/database.php';
    // we will return the status
    // whether the image deleted successfully
    $deleted = false;

	// get the image(s)
    $sql = $conn->prepare("SELECT cat_image 
            FROM tbl_category
            WHERE cat_id ");
    
    if ($sql->rowCount() > 0) {
        while ($sql_data = $sql->fetch()) {
		$cat_image = $sql_data['cat_image'];
	        // delete the image file
    	    $deleted = @unlink(SRV_ROOT . "images/category/$cat_image");
		}	
    }
    
    return $deleted;
}


?>