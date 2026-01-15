<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

	$userId = $_SESSION['user_id'];	
			
	$dfrom = $_POST['from'];
	$dto = $_POST['to'];
	$top = $_POST['top'];
	
	# Format Date to match date in db
	$newfrom = date("Y-m-d", strtotime($dfrom));
	$newto = date("Y-m-d", strtotime($dto));	
	# Format Date to words
	$wfrom = date("M d, Y", strtotime($dfrom));	
	$wto = date("M d, Y", strtotime($dto));		

	$dateMonthYearArr = array();
	$fromDateTS = strtotime($newfrom);
	$toDateTS = strtotime($newto);
	
	$del = $conn->prepare("DELETE FROM tr_sales_graph");
	$del->execute();
?>		
<!--<table>!-->
<?php
	for ($currentDateTS = $fromDateTS; $currentDateTS <= $toDateTS; $currentDateTS += (60 * 60 * 24)) 
	{
		// use date() and $currentDateTS to format the dates in between
		$currentDateStr = date("Y-m-d",$currentDateTS);
		$dateMonthYearArr[] = $currentDateStr;
		//print $currentDateStr."<br />";
		$dd = $currentDateStr;
			//echo $dd . "<br />";
			
		$ord = $conn->prepare("SELECT SUM(od_total_amt_due) as total_sales FROM tbl_order WHERE od_date_1 = '$dd' AND is_deleted != '1'");
		$ord->execute();
		$ord_data = $ord->fetch();
		$total_sales = $ord_data['total_sales'];
		
		$dtname = date("M d, Y", strtotime($dd));
		
		$in = $conn->prepare("INSERT INTO tr_sales_graph (branch_id, date_name, total_sales, od_date) VALUES ('0', '$dtname', '$total_sales', '$dd')");
		$in->execute();
?>
	<!--<tr>
		<td></?php echo $dd; ?> - </?php echo $total_sales; ?></td>
	</tr>!-->
<?php 
	}
		echo "<center><h3>Processing...</h3><img src='../images/loader/loader_3.gif'><center>";
		$url = "graph.php?b=$top";
		echo "<meta http-equiv=\"refresh\" content=\"1;URL=$url\">";
 ?>
<!--</table>!-->