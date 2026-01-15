<?php
if (!defined('WEB_ROOT')) {
	exit;
}


$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>		
		<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-road"></i> List of Deliveries</h2>						
						<div class="box-icon">																					
							<a href="../" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>							
						</div>
					</div>
					<div class="box-content">
						<ul class="nav nav-tabs" id="myTab">
							<li class="active"><a href="#pending">Pending</a></li>
							<li><a href="#delivered">Delivered</a></li>							
						</ul>
						<?php
								if($errorMessage == 'Delivered successfully')
								{
							?>
									<div class="valid_box">
										<b><?php echo $errorMessage; ?></b>
									</div>
							<?php
								}else{}
						?>
						<div id="myTabContent" class="tab-content">
							<div class="tab-pane active" id="pending">
								<?php include 'pending.php'; ?>
							</div>
							<div class="tab-pane" id="delivered">
								<?php include 'delivered.php'; ?>
							</div>
						</div>
					</div>
				</div><!--/span-->
			
			</div><!--/row-->
						