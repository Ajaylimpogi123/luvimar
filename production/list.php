<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$userId = $_SESSION['user_id'];

$user = $conn->prepare("SELECT * FROM bs_user
			WHERE user_id = '$userId'");
$user->execute();
$user_data = $user->fetch();

/* Select books from database */
$sql = $conn->prepare("SELECT * FROM tbl_production_report WHERE status != 'pending' AND is_deleted != '1' ORDER BY pr_id DESC");
$sql->execute();

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>
<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-th"></i> List of Production Report</h2>
			<?php if ($user_data['is_prod_a_access'] == 1) { ?>


				<?php

				$sel = $conn->prepare("SELECT * FROM tbl_pr_items WHERE is_submitted != '1' AND is_deleted != '1'");
				$sel->execute();

				if ($sel->rowCount() > 0) {
				?>
					&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:add();" class="btn btn-success">Add New Cart</a>
				<?php
				} else {
				?> &nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?view=add_jo" class="btn btn-success">Add New</a>
				<?php
				}
				?>

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
						<th>Ref. Job Order #</th>
						<th>Production Report #</th>
						<th>Branch Name</th>
						<th>Customer</th>
						<th>Status</th>
						<th>Date added</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if ($sql->rowCount() > 0) {
						while ($sql_data = $sql->fetch()) {

							$prId = $sql_data['pr_id'];
							$joId = $sql_data['jo_id'];


							$sel = $conn->prepare("SELECT * FROM tbl_pr_list WHERE pr_id = '$prId' AND is_deleted != '1'");
							$sel->execute();
							$sel_data = $sel->fetch();

							$branchId = $sel_data['branch_id'];

							$cust = $conn->prepare("SELECT * FROM bs_branch WHERE branch_id = '$branchId'");
							$cust->execute();
							$cust_data = $cust->fetch();
							$custName = $cust_data['branch_name'];

							$status = $sql_data['status'];

							if ($status == 'pending') {
								$status = '<button class="btn btn-warning" disabled><i data-feather="circle" style="height: 16px; width: 16px;" class="me-1"></i>Pending </button> ';
							} elseif ($status == 'completed') {
								$status = '<button class="btn btn-info"><i data-feather="check" style="height: 16px; width: 16px;" class="me-1"></i>Completed</button> ';
							} elseif ($status == 'declined') {
								$status = '<button class="btn btn-danger"><i data-feather="x" style="height: 16px; width: 16px;" class="me-1"></i>Declined</button> ';
							} elseif ($status == 'released') {
								$status = '<button class="btn btn-primary" disabled><i data-feather="check" style="height: 16px; width: 16px;" class="me-1"></i>Released</button> ';
							} else {
							};


							$jo = $conn->prepare("SELECT * FROM tbl_job_order WHERE jo_id = '$joId' AND is_deleted != '1'");
							$jo->execute();
							$jo_data = $jo->fetch();

					?>
							<!-- Start display list of products !-->
							<tr>
								<td><?php echo $jo_data['job_order_number']; ?></td>
								<td><?php echo $sql_data['pr_num']; ?></td>
								<td><?php echo $custName; ?></td>
								<td><?php echo $custName; ?></td>
								<td><?php echo $status ?></td>
								<td><?php echo date("F j, Y", strtotime($sql_data['date_added'])); ?></td>
								<td class="center">
									<?php if ($user_data['is_prod_e_access'] == 1) { ?>

										<a class="btn btn-primary" href="print.php?prId=<?php echo $prId; ?>" class="btn btn-small" target=_new><i class="icon-edit icon-white"></i>Print</a>
									<?php } else {
										echo "-- --";
									} ?>
									<?php if ($user_data['is_prod_d_access'] == 1) { ?>
										<a class="btn btn-danger" href="javascript:del(<?php echo $sql_data['pr_id']; ?>);">
											<i class="icon-trash icon-white"></i>
											Delete
										</a>
									<?php } else {
										echo "-- --";
									} ?>
								</td>
							</tr>
							<!-- End display list of products !-->
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