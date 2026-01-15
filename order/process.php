<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {
        
    case 'delete' :
        delete_data();
        break;
	   
    default :
        // if action is not defined or unknown
        // move to main category page
        header('Location: index.php');
}
/*
    Remove Data
*/
function delete_data()
{
	include '../global-library/database.php';	
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        header('Location: index.php');
    }    	
	
	$sql = $conn->prepare("UPDATE tbl_order_item SET is_deleted = '1' WHERE od_id = '$id'");
	$sql->execute();
	
	$sql1 = $conn->prepare("UPDATE tbl_order SET is_deleted = '1' WHERE od_id = '$id'");
	$sql1->execute();
       
	header('Location: index.php?error=' . urlencode('Deleted successfully'));
}

?>