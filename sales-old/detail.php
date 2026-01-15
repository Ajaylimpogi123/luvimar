<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';
require_once '../global-library/product-functions.php';
require_once '../global-library/cart-functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

if (!isset($_GET['id']) || (int)$_GET['id'] <= 0) {
	header('Location: index.php');
}

$pId = (int)$_GET['id'];

	
?>		
		<form action="process.php?action=saveorder" method="post" name="frmCart" id="frmCart">
			<div class="box span6">
				<div class="box-header well" data-original-title>
					<h2><i class="icon-th"></i> Product Details</h2>
				</div>
									
				<div class="box-content">				
					<?php
						$sql = $conn->prepare("SELECT * FROM tbl_product
									WHERE pd_id = '$pId'");
						$sql->execute();
						if ($sql->rowCount() > 0) 
						{
							$sql_data = $sql->fetch();
							if ($sql_data['pd_image']) 
							{
								$image = WEB_ROOT . 'images/product/' . $sql_data['pd_image'];
							} else {
								$image = WEB_ROOT . 'images/product/noimagelarge.png';
							}
					?>							
							<br />						
							<table border="0" style="margin:auto; font-size:17px;">
							<tr style="margin:auto;">							
								<td valign="top">
									<table>
										<tr><td><img src="<?php echo $image; ?>" /></td></tr>
									</table>
								</td>
								<td width="20"></td>
								<td valign="top">
									<table class="table table-striped table-bordered">
										<tr><td><?php echo $sql_data['pd_name']; ?></td></tr>
										<tr><td><?php echo $sql_data['pd_description']; ?></td></tr>
										<tr><td>PC - &#x20B1; <?php echo number_format($sql_data['pc_price'], 2); ?></td></tr>
										<tr><td>BX - &#x20B1; <?php echo number_format($sql_data['ib_price'], 2); ?></td></tr>
										<tr><td>CS - &#x20B1; <?php echo number_format($sql_data['bx_price'], 2); ?></td></tr>
									</table>
							</tr>
							</table>							
							
					<?php
						}else{ echo "No product found"; } 
					?>
				</div>
			</div>
		</form>
			