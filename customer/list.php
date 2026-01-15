<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$userId = $_SESSION['user_id'];

$user = $conn->prepare("SELECT * FROM bs_user
			WHERE user_id = '$userId'");
$user->execute();
$user_data = $user->fetch();

/* Select data from database */
$sql = $conn->prepare("SELECT * FROM bs_customer WHERE is_deleted != '1'");
$sql->execute();

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>
<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header well" data-original-title>
			<h2><i class="icon icon-black icon-users"></i> List of Customers</h2>
			<?php if ($user_data['is_cust_a_access'] == 1) { ?>
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:add();" class="btn btn-success">Add New</a>
			<?php } else {
			} ?>
			<div class="box-icon">
				<a href="../" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<?php
			if ($errorMessage == 'Deleted successfully') {
			?>
				<div class="valid_box">
					<b><?php echo $errorMessage; ?></b>
				</div>
			<?php
			} else {
			}
			?>
			<table class="table table-striped table-bordered bootstrap-datatable datatable">
				<thead>
					<tr>
						<th>Company Name</th>
						<th>Customer Name</th>
						<th>Address</th>
						<!-- <th>Contact Person</th> -->
						<th>Contact No.</th>
						<th>Actions</th>
						<!--<th>Payment</th>!-->
					</tr>
				</thead>
				<tbody>
					<?php
					if ($sql->rowCount() > 0) {
						while ($sql_data = $sql->fetch()) {
							$name = $user_data['firstname'] . '&nbsp;' . $user_data['lastname'];
							if ($sql_data['image']) {
								$image = WEB_ROOT . 'images/customer/' . $sql_data['image'];
							} else {
								$image = WEB_ROOT . 'images/customer/noimagelarge.jpg';
							}

					?>
							<!-- Start display list of customer !-->
							<tr>

								<td><a href="javascript:det(<?php echo $sql_data['cust_id']; ?>);"><?php echo $sql_data['client_name']; ?></a></td>
								<td><?php echo $sql_data['customer_name']; ?></td>
								<td><?php echo $sql_data['address']; ?></td>
								<!-- <td><?php echo $sql_data['contact_person']; ?></td> -->
								<td><?php echo $sql_data['contactno']; ?></td>
								<td class="center">
									<?php if ($user_data['is_cust_e_access'] == 1) { ?>
										<a class="btn btn-primary" href="javascript:mod(<?php echo $sql_data['cust_id']; ?>);">
											<i class="icon-edit icon-white"></i>
											Edit
										</a>
									<?php } else {
										echo "-- --";
									} ?>
									<?php if ($user_data['is_cust_d_access'] == 1) { ?>
										<a class="btn btn-danger" href="javascript:del(<?php echo $sql_data['cust_id']; ?>);">
											<i class="icon-trash icon-white"></i>
											Delete
										</a>
									<?php } else {
										echo "-- --";
									} ?>
								</td>
								<!--<td>
												<a class="btn btn-success" href="index.php?view=add_payment&id=<?php echo $cust_id; ?>">
													<i class="icon-gift"></i> 
													Add
												</a>
											</td>1-->
							</tr>
							<!-- End display list of customer !-->
					<?php
						}
					} else {
					}
					?>

				</tbody>
			</table>
		</div>
	</div><!--/span-->

</div><!--/row-->