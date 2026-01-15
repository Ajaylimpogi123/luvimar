<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();
	
	// make sure a id exists
	if (isset($_GET['id']) && $_GET['id'] > 0) {
		$id = $_GET['id'];
	} else {
	// redirect to index.php if id is not present
		header('Location: index.php');
	}
	
	$sql = "SELECT * FROM tbl_order WHERE od_id = '$id' AND is_deleted != '1' AND is_paid != '1'";
	$result = dbQuery($sql);
	$row = dbFetchAssoc($result);
	$due = $row['date_due'];		
	
$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';

	
?>

		<table style="width:400px; border:solid 0px #000000;">
		<tr>
			<td><center><img src="<?php echo WEB_ROOT; ?>images/logo.png" /></center><br /></td>
		</tr>
		<tr>
			<td style="text-align:center;"><strong style='font-size:22px; font-family:Calibri; color:#003366;'>Receivables</strong><br /></td>
		</tr>
		<tr><td><hr style="border:solid 1px #000000;"/></td></tr>
		<?php
			$sq = "SELECT * FROM tbl_order WHERE date_due = '$due' AND is_deleted != '1' AND is_paid != '1'";
			$rs = dbQuery($sq);
			while($rw = dbFetchAssoc($rs))
			{
				extract($rw);
				$scheddate = date('F d, Y' ,strtotime($date_due));
		?>
				<tr>
					<td>
						<h3 style="float:left; margin-left:10px;"><?php echo $customer_name; ?></h3><br /><br />
						<h4 style="float:left; margin-left:10px;"><font color="#669900">Php <?php echo number_format($od_total_amt_due, 2); ?></font> &nbsp; | &nbsp; <small><?php echo $scheddate; ?></small></h4>
					</td>
				</tr>				
				<tr><td><hr style="border: 0; height: 1px; background-image: -webkit-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); background-image: -moz-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); background-image: -ms-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0));  background-image: -o-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); " /></td></tr>
		<?php
			} // End While
		?>
		</table>