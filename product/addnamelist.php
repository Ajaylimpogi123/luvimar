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
$sql = $conn->prepare("SELECT * FROM tr_name WHERE is_deleted != '1'  ORDER BY prod_name");
$sql->execute();

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>
<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-th"></i> List of Products</h2>
			<?php if ($user_data['is_prod_a_access'] == 1) { ?>
			
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?view=addname" class="btn btn-success">Add Name</a>
			<?php } else {
			} ?>
			<div class="box-icon">
				<a href="../" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<?php
			if ($errorMessage == 'Added successfully') {
			?>
				<div class="valid_box">
					<b><?php echo $errorMessage; ?></b>
				</div>
			<?php
			} else if ($errorMessage == 'Serial # Already Taken! Data entry failed.') {
			?>
				<div class="error_box">
					<b><?php echo $errorMessage; ?></b>
				</div>
			<?php
			} elseif ($errorMessage == 'Deleted successfully') {
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
						<th>Name</th>
					
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if ($sql->rowCount() > 0) {
						while ($sql_data = $sql->fetch()) {

							$prod_name = $sql_data['prod_name'];

					?>
							<!-- Start display list of products !-->
							<tr>
								<td><?php echo $prod_name; ?></td>
							
								
								<td class="center">
									<?php if ($user_data['is_prod_e_access'] == 1) { ?>
										<a class="btn btn-primary" href="index.php?view=editname&id=<?php echo $sql_data['n_id']; ?>">
											<i class="icon-edit icon-white"></i>
											Edit
										</a>
									<?php } else {
										echo "-- --";
									} ?>
									<?php if ($user_data['is_prod_d_access'] == 1) { ?>
										<a class="btn btn-danger" href="process.php?action=delete&id=<?php echo $sql_data['n_id']; ?>">
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