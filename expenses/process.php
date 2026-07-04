<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {

	case 'add':
		add();
		break;
	case 'add_category':
		add_category();
		break;

	case 'modify':
		modify();
		break;
	case 'cat_modify':
		cat_modify();
		break;

	case 'delete':
		delete();
		break;
	case 'cat_delete':
		cat_delete();
		break;

	case 'beginning':
		beginning();
		break;

	case 'delbeg':
		delbeg();
		break;

	default:
		// if action is not defined or unknown
		// move to main category page
		header('Location: index.php');
}


/*
    Add
*/
function add_category()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];

	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("Y-m-d");

	$name = $_POST['exp_name'];
	$details = $_POST['details'];

	$sql   = $conn->prepare("INSERT INTO tr_expense_category (expense_category_name, cat_details, date_added, is_deleted) 
				  VALUES ('$name', '$details', '$today_date2', '0')");
	$sql->execute();

	/* Insert Log */
	$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
					VALUES ('Expense added', '$amount', 'expense', '$userId', '$today_date2')");
	$log->execute();

	header('Location: index.php?view=cat&error=' . urlencode('Added successfully'));
}
/*
    Add
*/
function add()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];

	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("Y-m-d");

	$exp_cat = $_POST['exp_cat'];
	$amount = $_POST['amount'];
	$vat = $_POST['vat'];
	$tin = $_POST['tin'];
	$orno = $_POST['orno'];
	$exp_date = $_POST['exp_date'];
	$details = $_POST['details'];

	$sql   = $conn->prepare("INSERT INTO tr_expense (ec_id, amount, details, vat, tin_no, or_no, exp_date_added, is_deleted) 
				  VALUES ('$exp_cat', '$amount', '$details', '$vat', '$tin', '$orno', '$exp_date', '0')");
	$sql->execute();

	/* Insert Log */
	$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
					VALUES ('Expense added', '$amount', 'expense', '$userId', '$exp_date')");
	$log->execute();

	header('Location: index.php?view=add&error=' . urlencode('Added successfully'));
}

/*
    Modify
*/
function cat_modify()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];

	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("Y-m-d");

	$exid = $_GET['id'];
	$category_name = $_POST['cat_name'];
	$details = $_POST['details'];

	$sql    = $conn->prepare("UPDATE tr_expense_category
						SET expense_category_name = '$category_name', cat_details = '$details', date_modified = '$today_date1'
							WHERE ec_id = $exid");

	$sql->execute();


	/* Insert Log */
	$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
					VALUES ('Expense NAme', '$exid', 'expense', '$userId', '$today_date1')");
	$log->execute();

	header("Location: index.php?view=cat&id=$exid&error=Modified successfully");
}
/*
    Modify
*/
function modify()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];

	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("Y-m-d");

	$exid = $_POST['id'];
	$amount = $_POST['amount'];
	$details = $_POST['details'];
	$vat = $_POST['vat'];
	$tin = $_POST['tin'];
	$orno = $_POST['orno'];

	$sql    = $conn->prepare("UPDATE tr_expense
						SET amount = '$amount', details = '$details', vat = '$vat', tin_no = '$tin', or_no = '$orno', date_modified = '$today_date1'
							WHERE exp_id = $exid");

	$sql->execute();


	/* Insert Log */
	$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
					VALUES ('Expense modified', '$exid', 'expense', '$userId', '$today_date1')");
	$log->execute();

	header("Location: index.php?view=modify&id=$exid&error=Modified successfully");
}

/*
    Remove
*/
function cat_delete()
{
	include '../global-library/database.php';
	if (isset($_GET['id']) && (int)$_GET['id'] > 0) {
		$exid = (int)$_GET['id'];
	} else {
		header('Location: index.php');
	}

	$userId = $_SESSION['user_id'];

	$sql = $conn->prepare("UPDATE tr_expense_category SET is_deleted = '1', date_deleted = NOW()
				WHERE ec_id = '$exid'");
	$sql->execute();

	/* Insert Log */
	$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
					VALUES ('Expense Category deleted', '$exid', 'expense', '$userId', '$today_date1')");
	$log->execute();
	/* End Log */

	header("Location: index.php?view=cat&error=Deleted successfully");
}
/*
    Remove
*/
function delete()
{
	include '../global-library/database.php';
	if (isset($_GET['id']) && (int)$_GET['id'] > 0) {
		$exid = (int)$_GET['id'];
	} else {
		header('Location: index.php');
	}

	$userId = $_SESSION['user_id'];

	$sql = $conn->prepare("UPDATE tr_expense SET is_deleted = '1', date_deleted = NOW()
				WHERE exp_id = '$exid'");
	$sql->execute();

	/* Insert Log */
	$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
					VALUES ('Expense deleted', '$exid', 'expense', '$userId', '$today_date1')");
	$log->execute();
	/* End Log */

	header("Location: index.php?error=Deleted successfully");
}

/*
    Beginning Balance
*/
function beginning()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];

	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("Y-m-d");

	$amount = $_POST['amount'];

	$sql   = $conn->prepare("INSERT INTO bs_beginning_balance (amount, date_added, is_deleted) 
				  VALUES ('$amount', '$today_date1', '0')");
	$sql->execute();

	$details = $today_date1 . " - " . $amount;

	/* Insert Log */
	$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
					VALUES ('Beginning balance added', '$details', 'beginning balance', '$userId', '$today_date1')");
	$log->execute();

	header("Location: beginning.php?error=Beginning balance updated successfully");
}

/*
    Remove amount
*/
function delbeg()
{
	include '../global-library/database.php';
	if (isset($_GET['id']) && (int)$_GET['id'] > 0) {
		$exid = (int)$_GET['id'];
	} else {
		header('Location: index.php');
	}

	$userId = $_SESSION['user_id'];

	$sql = $conn->prepare("UPDATE bs_beginning_balance SET is_deleted = '1', date_deleted = '$today_date1'
				WHERE beg_id = '$exid'");
	$sql->execute();

	/* Insert Log */
	$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
					VALUES ('Amount deleted', '$exid', 'beginning amount', '$userId', '$today_date1')");
	$log->execute();
	/* End Log */

	header("Location: beginning.php");
}
