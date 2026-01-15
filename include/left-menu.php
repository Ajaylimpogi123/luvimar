<?php
	$userId = $_SESSION['user_id'];
	
	// Get user from database
	$sql = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$userId' AND is_deleted != '1'");
	$sql->execute();
	$sql_data = $sql->fetch();
	
?>
			<div class="span2 main-menu-span">
				<div class="well nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li class="nav-header hidden-tablet">Category</li>
						<?php
							$cat = $conn->prepare("SELECT * FROM tbl_category WHERE cat_parent_id = '0' AND is_deleted != '1' ORDER BY cat_name");
							$cat->execute();
							if($cat->rowCount() > 0)
							{
								while($cat_data = $cat->fetch())
								{
						?>					
									<li><a class="ajax-link" href="<?php echo WEB_ROOT; ?>sales/index.php?id=<?php echo $cat_data['cat_id']; ?>"><i class="icon-th"></i><span class="hidden-tablet"> <?php echo $cat_data['cat_name']; ?></span></a></li>
						<?php
								} // End While
							}else{}
						?>
					</ul>					
				</div><!--/.well -->
			</div><!--/span-->