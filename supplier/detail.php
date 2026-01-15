<?php
if (!defined('WEB_ROOT')) {
	exit;
}

date_default_timezone_set("Asia/Manila");
$today_date1 = date("Y-m-d H:i:s");
$today_date2 = date("Y-m-d");

	// make sure a id exists
	if (isset($_GET['id']) && $_GET['id'] > 0) {
		$id = $_GET['id'];
	} else {
	// redirect to index.php if id is not present
		header('Location: index.php');
	}
	
	$sql = $conn->prepare("SELECT * FROM bs_supplier WHERE sup_id = '$id' AND is_deleted != '1'");
	$sql->execute();
	$sql_data = $sql->fetch();
	$supname = $sql_data['company_name'];

	$sql1 = $conn->prepare("SELECT *
				FROM tbl_product p, bs_supplier s, tbl_received r, tbl_received_item i
					WHERE s.sup_id = '$id' AND s.sup_id = r.sup_id AND r.rec_id = i.rec_id AND p.pd_id = i.pd_id
							ORDER BY r.rec_id DESC");
	$sql1->execute();

	$sql2 = $conn->prepare("SELECT SUM(total_cost) AS payment
				FROM tbl_received
					WHERE payment_method = 'Cash' AND sup_id = '$id'
							ORDER BY rec_id DESC");
	$sql2->execute();
	$sql2_data = $sql2->fetch();
	$total_cash = $sql2_data['payment'];

	$sql3 = $conn->prepare("SELECT SUM(total_cost) AS credit
				FROM tbl_received
					WHERE payment_method = 'Charge' AND sup_id = '$id'
							ORDER BY rec_id DESC");
	$sql3->execute();
	$sql3_data = $sql3->fetch();
	$total_credit = $sql3_data['credit'];

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>		
		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> Supplier Transactions</h2>
						&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:due(<?php echo $id; ?>);" class="btn btn-success">Due Dates</a>
						<div class="box-icon">																					
							<!--<a href="../" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>!-->
						</div>
					</div>
					<br />
					<div style="margin-left:20px;">
						<table cellpadding="4" cellspacing="4">
						<tr>
							<td><b>Supplier</b></td>
							<td> <b>:</b> </td>
							<td><b><?php echo $supname; ?></b></td>
						</tr>
						<tr>
							<td>Cash</td>
							<td> : </td>
							<td>Php <?php echo number_format($total_cash, 2); ?></td>
						</tr>
						<tr>
							<td>Charge</td>
							<td> : </td>
							<td>Php <?php echo number_format($total_credit, 2); ?></td>
						</tr>
						<tr>
							<td><b>Total Purchases</b></td>
							<td> <b>:</b> </td>
							<td>Php <b style="text-decoration-line: underline; text-decoration-style: double;"><?php echo number_format($total_cash + $total_credit, 2); ?></b></td>
						</tr>
						</table>
					</div>
					<br />
					<div class="box-content">						
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>DR/Invoice</th>
								  <th>Product</th>								  
								  <th>Qty</th>								 
								  <th>Cost</th>
								  <th>Date</th>
								  <th>Payment</th>
								  <th>OR</th>
								  
							  </tr>
						  </thead>   
						  <tbody>
							<?php
								if($sql1->rowCount() > 0)
								{
									$ctr = 1; $total_all = 0;
									while($sql1_data = $sql1->fetch())
									{
										if($sql1_data['payment_method'] == 'Charge')
										{
											$clr = "style='background:#ff6666; color:#ffffff;'";
											$test = 1;
										}else{
											$clr = "";
											$test = 2;
										}										
																				
										$orderdate = date("M d, Y | h:i a",strtotime($sql1_data['date_added']));
																				
							?>
										<!-- Start display list of orders !-->
										<tr>
											<td <?php echo $clr; ?>><?php echo $sql1_data['dr_num']; ?></td>
											<td <?php echo $clr; ?>><?php echo $sql1_data['pd_name']; ?></td>
											<td <?php echo $clr; ?>><?php echo $sql1_data['od_qty_added']; ?></td>
											<td <?php echo $clr; ?>>Php <?php echo number_format($sql1_data['pd_cost'], 2); ?></td>
											<td <?php echo $clr; ?>><?php echo $orderdate; ?></td>
											<td <?php echo $clr; ?>><?php echo $sql1_data['payment_method']; ?></td>
											<td <?php echo $clr; ?>><?php echo $sql1_data['or_num']; ?></td>
											
										</tr>
										<!-- End display list of orders !-->
							<?php
									}
								}
								else
								{}
																
							?>
							
						  </tbody>
						</table>            
					</div>
				</div><!--/span-->					
						