<?php
if (!defined('WEB_ROOT')) {
	exit;
}

	/* Select data from database */
	$sql = $conn->prepare("SELECT * FROM bs_customer WHERE is_deleted != '1'");
	$sql->execute();
	$sql_data = $sql->fetch();

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>		

		<table class="table table-striped table-bordered bootstrap-datatable datatable">
		  <thead>
			  <tr>
				  <th>Image</th>
				  <th>Customer</th>
				  <th>Receivable</th>
			  </tr>
		  </thead>   
		  <tbody>
			<?php
				if($sql->rowCount() > 0)
				{
					while($sql_data =$sql->fetch())
					{
						if ($sql_data['image']) {
							$image = WEB_ROOT . 'images/customer/' . $sql_data['image'];
						} else {
							$image = WEB_ROOT . 'images/customer/noimagesmall.png';
						}
						
						$rec = $conn->prepare("SELECT *, SUM(od_total_amt_due) as total_rec FROM tbl_order WHERE cust_id = '$cust_id' AND is_deleted != '1' AND is_paid != '1'");
						$rec->execute();
						$rec_data = $rec->fetch();
						$total_receivables = $rec_data['total_rec'];
						
						$bal = $conn->prepare("SELECT *, SUM(amount_paid) as total_pay FROM tr_payment WHERE cust_id = '$cust_id' AND is_deleted != '1'");
						$bal->execute();
						$bal_data = $bal->fetch();
						$total_pay = $bal_data['total_pay'];
						$total_balance = $total_receivables - $total_pay;
																
			?>
						<!-- Start display list of customer !-->
						<tr>
							<td><img class="dashboard-avatar" alt="<?php echo $sql_data['client_name']; ?>" src="<?php echo $image; ?>" /></td>
							<td><?php echo $sql_data['client_name']; ?></td>
							<td>Php <?php echo number_format($total_balance, 2); ?></td>
						</tr>
						<!-- End display list of customer !-->
			<?php
					}
				}
				else
				{}
			?>
			
		  </tbody>
		</table>            
					