<?php
if (!defined('WEB_ROOT')) {
	exit;
}

	/* Select books from database */
	$sql = $conn->prepare("SELECT * FROM tbl_product
				WHERE is_deleted != '1'");
	$sql->execute();

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>
		<div class="row-fluid sortable">		
				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-inbox"></i> Receive Product</h2>						
						<div class="box-icon">																					
							<a href="../" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>							
						</div>
					</div>
					<div class="box-content">
						<form method="post" action="index.php" name="frm" id="frm">
						<table class="table table-striped table-bordered">
						  <thead>
							  <tr>								 
								  <th>Search/Scan Product</th>
							  </tr>
						  </thead>   
						  <tbody>							
							<!-- Start display list of products !-->
							<tr>											
								<td><input type="text" name="pid" id="pid" autocomplete=off /></td>
							</tr>
							<!-- End display list of products !-->					
						  </tbody>
						</table>       
						</form>
						
						<form method="post" action="index.php" name="frm" id="frm">
						<table class="table table-striped table-bordered">
						  <thead>
							  <tr>								 
								  <th>Search Product</th>
							  </tr>
						  </thead>   
						  <tbody>							
							<!-- Start display list of products !-->
							<tr>											
								<td>
									<select id="selectError" name="pid" id="pid" data-rel="chosen">
										<?php
											$prd = $conn->prepare("SELECT * FROM tbl_product p, tbl_category c WHERE p.is_deleted != '1' AND p.cat_id = c.cat_id");
											$prd->execute();
											if($prd->rowCount() > 0)
											{
												while($prd_data = $prd->fetch())
												{
										?>
													<option value="<?php echo $prd_data['pd_id']; ?>"><?php echo $prd_data['pd_name']; ?> - <b><?php echo $prd_data['cat_name']; ?></b></option>
										<?php
												} // End While
											}else{}
										?>
								  </select>
								  <input type="submit" name="submit" class="btn btn-success" value="Go" />
								</td>
							</tr>
							<!-- End display list of products !-->					
						  </tbody>
						</table>       
						</form>
					</div>
				</div><!--/span-->
				
			<?php
				if(isset($_POST['pid']))
				{
					$pdId = $_POST['pid'];
					if ($pdId) 
					{
						require_once 'detail.php';
					}else{ require_once 'detail.php'; }			
				}else{ require_once 'detail.php'; }
			?>
			
		</div><!--/row-->