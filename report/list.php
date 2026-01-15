<?php
if (!defined('WEB_ROOT')) {
	exit;
}

/* Select reports from database */
$sql = $conn->prepare("SELECT * FROM bs_report WHERE is_deleted != '1' ORDER BY name");
$sql->execute();

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>
<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-file"></i> List of Reports</h2>
			<!--&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:add();" class="btn btn-success">Add New</a>!-->
			<div class="box-icon">
				<a href="../" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>Name</th>
						<th>Description</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if ($sql->rowCount() > 0) {
						while ($sql_data = $sql->fetch()) {
					?>
							<tr>
								<td><a href="javascript:view(<?php echo $sql_data['report_id']; ?>);" style="text-transform:uppercase;"><?php echo $sql_data['name']; ?></a></td>
								<td><?php echo $sql_data['description']; ?></td>
								<td>



								</td>
							</tr>
					<?php
						}
					} else {
						echo '<tr><td colspan="3" class="text-center">No reports found</td></tr>';
					}
					?>


				</tbody>
			</table>

			<form action="daily.php" method="post" target="_new">
				<div class="report-header">
					<div class="header-content">
						<div class="header-title">
							<h2><i class="fas fa-chart-line"></i> Daily Sales Report</h2>
							<p class="subtitle">View and analyze daily sales performance</p>
						</div>

						<div class="report-controls">
							<div class="date-control">
								<label for="txtFromDate"><i class="fas fa-calendar-alt"></i> Select Date:</label>
								<div class="input-group">
									<input type="text" class="form-control input-date" id="txtFromDate" name="date1"
										placeholder="MM/DD/YYYY" onkeypress="return isNumberKey(event)"
										autocomplete="off" required />
									<span class="input-group-btn">
										<button class="btn btn-submit" type="submit">
											<i class="fas fa-search"></i> Generate Report
										</button>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>

				<style>
					/* Main Header Styles */
					.report-header {
						background: linear-gradient(135deg, #2c3e50, #3498db);
						color: white;
						padding: 20px;
						border-radius: 8px;
						margin-bottom: 25px;
						box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
					}

					.header-content {
						display: flex;
						flex-wrap: wrap;
						justify-content: space-between;
						align-items: center;
					}

					.header-title h2 {
						margin: 0;
						font-size: 24px;
						font-weight: 600;
						display: flex;
						align-items: center;
					}

					.header-title h2 i {
						margin-right: 12px;
						font-size: 28px;
					}

					.subtitle {
						margin: 5px 0 0 0;
						font-size: 14px;
						opacity: 0.9;
					}

					/* Form Controls */
					.report-controls {
						margin-top: 15px;
						width: 100%;
					}

					.date-control {
						display: flex;
						flex-direction: column;
					}

					.date-control label {
						margin-bottom: 8px;
						font-weight: 500;
						display: flex;
						align-items: center;
					}

					.date-control label i {
						margin-right: 8px;
					}

					.input-group {
						display: flex;
						width: 100%;
					}

					.input-date {
						height: 42px;
						border: 1px solid #ddd;
						border-radius: 4px 0 0 4px;
						padding: 10px 15px;
						font-size: 15px;
						flex: 1;
						transition: border-color 0.3s;
					}

					.input-date:focus {
						border-color: #3498db;
						outline: none;
						box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
					}

					.btn-submit {
						height: 42px;
						background: #e74c3c;
						color: white;
						border: none;
						border-radius: 0 4px 4px 0;
						padding: 0 20px;
						font-weight: 500;
						cursor: pointer;
						transition: background 0.3s;
						display: flex;
						align-items: center;
					}

					.btn-submit:hover {
						background: #c0392b;
					}

					.btn-submit i {
						margin-right: 8px;
					}

					/* Responsive adjustments */
					@media (min-width: 768px) {
						.header-content {
							flex-wrap: nowrap;
						}

						.header-title {
							margin-right: 30px;
						}

						.report-controls {
							margin-top: 0;
							width: auto;
							flex: 1;
							max-width: 500px;
						}

						.date-control {
							flex-direction: row;
							align-items: center;
						}

						.date-control label {
							margin-bottom: 0;
							margin-right: 15px;
							white-space: nowrap;
						}
					}
				</style>

				<!-- Include Font Awesome for icons -->
				<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
			</form>

		</div>
	</div><!--/span-->

</div><!--/row-->