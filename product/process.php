<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {
        
    case 'addname' :
        add_name();
        break;
    case 'delete' :
        delete_data();
        break;
    case 'edit' :
        edit_data();
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
	
	$sql = $conn->prepare("UPDATE tr_name SET is_deleted = '1' WHERE n_id = '$id'");
	$sql->execute();

	header('Location: index.php?view=addnamelist&error=' . urlencode('Deleted successfully'));
}
function add_name()
{
	include '../global-library/database.php';	
    if (isset($_POST['prodname'])) {
        $prodname = $_POST['prodname'];
    } else {
        header('Location: index.php');
    }    	
	
	$sql = $conn->prepare("INSERT INTO tr_name (prod_name) VALUES ('$prodname')");
	$sql->execute();
       
	header('Location: index.php?view=addnamelist&error=' . urlencode('Added successfully'));
}
function edit_data()
{
	include '../global-library/database.php';	
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        header('Location: index.php');
    }    	
	
	$sql = $conn->prepare("UPDATE tr_name SET prod_name = ? WHERE n_id = ?");
	$sql->execute([$_POST['prodname'], $id]);
       
	header('Location: index.php?view=addnamelist&error=' . urlencode('Updated successfully'));
}


  
?>