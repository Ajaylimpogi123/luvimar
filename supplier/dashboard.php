<?php
if (!defined('WEB_ROOT')) {
	exit;
}

	/* Select data from database */
	$sql = "SELECT * FROM bs_supplier WHERE is_deleted != '1'";
	$result = dbQuery($sql);
	$numrows = dbNumRows($result);
	
	

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>		
		
		<table class="table table-striped table-bordered bootstrap-datatable datatable">
		  <thead>
			  <tr>
				  <th>Image</th>
				  <th>Supplier</th>
				  <th>Payables</th>
			  </tr>
		  </thead>   
		  <tbody>
			<?php
				if($numrows > 0)
				{
					while($row = dbFetchAssoc($result))
					{
						extract($row);
																
						$name = $lastname . ', ' . $firstname;
						if ($image) {
							$image = WEB_ROOT . 'images/supplier/' . $image;
						} else {
							$image = WEB_ROOT . 'images/supplier/noimagesmall.png';
						}
						
						$rec2 = "SELECT *, SUM(total_cost) as total_rec2 FROM tbl_received WHERE sup_id = '$sup_id' AND is_deleted != '1' AND is_paid != '1'";
						$rs_rec2 = dbQuery($rec2);
						$rw_rec2 = dbFetchAssoc($rs_rec2);
						$total_payables = $rw_rec2['total_rec2'];
						
						$bal2 = "SELECT *, SUM(amount_paid) as total_pay2 FROM tr_payment_supplier WHERE sup_id = '$sup_id' AND is_deleted != '1'";
						$rs2 = dbQuery($bal2);
						$rw2 = dbFetchAssoc($rs2);
						$total_pay2 = $rw2['total_pay2'];
						$total_balance2 = $total_payables - $total_pay2;
																
			?>
						<!-- Start display list of users !-->
						<tr>
							<td><img class="dashboard-avatar" alt="<?php echo $name; ?>" src="<?php echo $image; ?>" /></td>											
							<td><?php echo $company_name; ?></td>
							<td>Php <?php echo number_format($total_balance2, 2); ?></td>
							
						</tr>
						<!-- End display list of users !-->
			<?php
					}
				}
				else
				{}
			?>
			
		  </tbody>
		</table>          
					