<?php
if (!defined('WEB_ROOT')) {
	exit;
}
$userId = $_SESSION['user_id'];

$product = getProductDetail($pdId, $catId);

// we have $pd_name, $pd_price, $pd_description, $pd_image, $cart_url
extract($product);

$sql = $conn->prepare("SELECT *
			FROM tbl_product
			WHERE pd_id = '$pdId' AND is_deleted != '1'");

$sql->execute();
if ($sql->rowCount() > 0) {
	$sid = session_id();

	if ($sql->rowCount() != 1) {
		// the product doesn't exist
		header('Location: cart.php');
	} else {
		// how many of this product we
		// have in stock
		$sql_data =  $sql->fetch();
		$currentStock = $sql_data['pd_qty'];
		$prodId = $sql_data['pd_id'];
		$pcost = $sql_data['pd_cost'];
		$pc_price = $sql_data['pc_price'];
		$ib_price = $sql_data['ib_price'];
		$bx_price = $sql_data['bx_price'];
	}

	// check if the product is already
	// in cart table for this session
	$sql = $conn->prepare("SELECT pd_id
				FROM tbl_cart_receive
				WHERE pd_id = '$prodId' AND ct_session_id = '$sid'");
	$sql->execute();

	if ($sql->rowCount() == 0) {
		// put the product in cart table
		$pc = $conn->prepare("INSERT INTO tbl_cart_receive (pd_id, ct_qty, ct_cost, ct_price, ct_session_id, ct_date, user_id, is_type)
					VALUES ($prodId, 0, '$pcost', '$pc_price', '$sid', '$today_date1', '$userId', '1')");
		$pc->execute();

		// $ib = $conn->prepare("INSERT INTO tbl_cart_receive (pd_id, ct_qty, ct_cost, ct_price, ct_session_id, ct_date, user_id, is_type)
		// 			VALUES ($prodId, 0, '$pcost', '$ib_price', '$sid', '$today_date1', '$userId', '2')");
		// $ib->execute();

		// $bx = $conn->prepare("INSERT INTO tbl_cart_receive (pd_id, ct_qty, ct_cost, ct_price, ct_session_id, ct_date, user_id, is_type)
		// 			VALUES ($prodId, 0, '$pcost', '$bx_price', '$sid', '$today_date1', '$userId', '3')");
		// $bx->execute();
	} else {
	}

	// an extra job for us here is to remove abandoned carts.
	// right now the best option is to call this function here
	deleteAbandonedReceivingCart();

	//header('Location: ' . $_SESSION['shop_return_url']);	

?>
	<!--<div class="box span3">
				<div class="box-header well" data-original-title>
					<h2><i class="icon-th"></i> Product Detail</h2>
				</div>
									
				<div class="box-content">
					<img src="<?php echo $pd_image; ?>" />
					<br />
					<table>
					 <tr>						  
					  <td valign="middle">
						<strong><?php echo $pd_name; ?></strong><br /><br />
						Price : <?php echo displayAmount($pd_price); ?><br />
					  </td>
					 </tr>
					</table>
				</div>
			</div>!-->

<?php
} else {

?>
	<!--<div class="box span3">
				<div class="box-header well" data-original-title>
					<h2><i class="icon-th"></i> Product Detail</h2>
				</div>
									
				<div class="box-content">					
					<table>
					 <tr>						  
					  <td valign="middle">
						<strong>No Item Found</strong>
					  </td>
					 </tr>
					</table>
				</div>
			</div>!-->
<?php
}

$cartContent = getReceivingCart();

$numItem = count($cartContent);
?>
<div class="box span8">
	<div class="box-header well" data-original-title>
		<h2><i class="icon-shopping-cart"></i> Receiving Cart</h2>
	</div>

	<div class="box-content">
		<?php
		if ($numItem > 0) {
		?>
			<div class="cart_details"> <?php echo $numItem; ?> item(s)</div>
			<br />
			<table border="0" style="width:100%;">
				<tr>
					<td style="text-align:center;" width="10px;"><b>#</b></td>
					<td width="10px;">&nbsp;</td>
					<td width="100px;"><b>Product</b></td>
					<td width="10px;">&nbsp;</td>
					<td width="40px;"><b>Brand</b></td>
					<td width="10px;">&nbsp;</td>
					<td width="40px;"><b>Type</b></td>
					<td width="10px;">&nbsp;</td>
					<td width="40px;"><b>Price</b></td>
				</tr>
				<?php
				$ctr = 1;
				for ($i = 0; $i < $numItem; $i++) {
					extract($cartContent[$i]);

					$catb = $conn->prepare("SELECT * FROM tbl_category WHERE cat_id = '$cat_id'");
					$catb->execute();
					$catb_data = $catb->execute();
					if ($is_type == 1) {
						$tp = 'PC';
					} else if ($is_type == 2) {
						$tp = 'BX';
					} else {
						$tp = 'CS';
					}
				?>
					<tr>
						<td style="text-align:center;"><span></span><?php echo $ctr++; ?>. </td>
						<td width="10px;">&nbsp;</td>
						<td><span></span> <?php echo $pd_name; ?></td>
						<td width="10px;">&nbsp;</td>
						<td><span></span> <?php echo $cat_name; ?></td>
						<td width="10px;">&nbsp;</td>
						<td><?php echo $tp; ?></td>
						<td width="10px;">&nbsp;</td>
						<td><?php echo number_format($ct_price, 2); ?></td>
					</tr>
				<?php
				} // End For

				?>
				<tr>
					<td colspan="9">
						<hr style="border: 0; height: 1px; background-image: -webkit-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); background-image: -moz-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); background-image: -ms-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0));  background-image: -o-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); " />
					</td>
				</tr>
				<tr>
					<td colspan="9"><br /></td>
				</tr>
				<tr>
					<td colspan="9" align="right">
						<a href="index.php?view=cart&action=view" title="Go to receiving cart"><button class="btn btn-small btn-danger"><i class="icon icon-white icon-cart"></i> Proceed</button></a>
					</td>
				</tr>
			</table>
		<?php
		} else {
			echo "Receiving Cart Is Empty";
		}
		?>
	</div>
</div>