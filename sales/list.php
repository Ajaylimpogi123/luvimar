<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$userId = $_SESSION['user_id'];

$cid = isset($_GET['id']) ? $_GET['id'] : '0';

// $cid = 1;
$ct = $conn->prepare("SELECT * FROM tbl_category WHERE cat_id = '$cid' AND is_deleted != '1'");
$ct->execute();
$ct_data = $ct->fetch();
$catname = isset($ct_data['cat_name']) ? $ct_data['cat_name'] : '';


$sql = $conn->prepare("SELECT * FROM tbl_category WHERE cat_parent_id = '$cid' AND is_deleted != '1'");
$sql->execute();

if (isset($_GET['pid'])) {
	$pid = $_GET['pid'];
	include "insert_order.php";
} else {
}

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>

<head>
	<link rel="stylesheet" type="text/css" href="<?php echo WEB_ROOT; ?>global-library/css/button/style4.css" />
</head>
<div>
	<ul class="breadcrumb">
		<li>
			<b><?php echo $catname; ?></b>
		</li>
		<li style="float:right;"><?php echo date('F d, Y | l'); ?></li>
	</ul>
	<table border="0">
		<tr>
			<td>
				<?php
				$crt = $conn->prepare("SELECT * FROM tbl_cart WHERE user_id = '$userId'");
				$crt->execute();
				if ($crt->rowCount() > 0) {
					$prc2 = $conn->prepare("SELECT SUM(ct_qty) as total_items FROM tbl_cart WHERE user_id = '$userId'");
					$prc2->execute();
					$prc2_data = $prc2->fetch();
					$totalqty = $prc2_data['total_items'];

					$prc = $conn->prepare("SELECT SUM(ct_price * ct_qty) as total_amt FROM tbl_cart WHERE user_id = '$userId'");
					$prc->execute();
					$prc_data = $prc->fetch();
					$totalprice = $prc_data['total_amt'];
					if ($crt->rowCount() > 1) {
						$pl = "s";
					} else {
						$pl = "";
					}
				?>
					<!--Cart Content: <a href="index.php?view=cart"><?php echo $num_crt; ?> item<?php echo $pl; ?></a> Total: Php <?php echo number_format($totalprice, 2); ?>
						<a href="index.php?view=cart"><span class="icon32 icon-red icon-cart"></a> Total: Php <?php echo number_format($totalprice, 2); ?>
						<!--<table border="0" height="100" width="125" background="<?php echo WEB_ROOT; ?>images/cart.png">
						<tr><td style="font-size:40px; border:solid 1px;"><b style="margin-left:75px; padding-botttom:200px; color:#ffffff;"><?php echo $num_crt; ?></b><br /></td></tr>
						</table>!-->
					<a href="index.php?view=cart" class="a-btn">
						<span class="a-btn-text">Go to Cart Content<br /><small style="font-size:13px;"><?php echo $totalqty; ?> item<?php echo $pl; ?></small></span>
						<span class="a-btn-slide-text">P <?php echo number_format($totalprice, 2); ?></span>
						<span class="a-btn-icon-right"><img src="<?php echo WEB_ROOT; ?>global-library/css/button/cart.png" alt="Add to Cart" width="40" height="40" /></span>
					</a>
				<?php
				} else {
				}
				?>
				<!--<form method="post" action="index.php?view=search">
					Search &nbsp;
					<input name="key" type="text" id="key" maxlength="50" style="font-size:16px; font-weight:bold;" placeholder="Search" required autocomplete=off />
					<input type="submit" value="Go" class="btn btn-success" />
				</form>!-->
				<!--<a href="</?php echo WEB_ROOT; ?>release/index.php?view=cart&action=view" class="btn btn-large btn-primary" style="float:right"><i class="icon icon-white icon-cart"></i>  Go to Cart</a>!-->
			</td>
		</tr>
	</table>
</div>
<br />
<div class="box-content">
	<ul class="nav nav-tabs" id="myTab">
		<li><a href="#all">All</a></li>
		<?php
		$cat = $conn->prepare("SELECT * FROM tbl_category WHERE cat_parent_id = '$cid' AND is_deleted != '1'");
		$cat->execute();
		if ($cat->rowCount() > 0) {
			while ($cat_data = $cat->fetch()) {
		?>
				<li><a href="#<?php echo $cat_data['cat_id']; ?>"><?php echo $cat_data['cat_name']; ?></a></li>
		<?php
			} // End While
		} else {
		}
		?>
	</ul>

	<div id="myTabContent" class="tab-content">
		<?php include 'all.php'; ?>
		<?php
		$productsPerRow = 4;
		$columnWidth = (int)(100 / $productsPerRow);
		$cat1 = $conn->prepare("SELECT * FROM tbl_category WHERE cat_parent_id = '$cid' AND is_deleted != '1' AND cat_parent_id != '0'");
		$cat1->execute();
		if ($cat1->rowCount() > 0) {
			while ($cat1_data = $cat1->fetch()) {
				$prod = $conn->prepare("SELECT * FROM tbl_product WHERE cat_id = '$cat1_data[cat_id]' AND is_deleted != '1' ORDER BY pd_name ASC");
				$prod->execute();
		?>
				<div class="tab-pane" id="<?php echo $cat1_data['cat_id']; ?>">
					<h4><?php echo $cat1_data['cat_name']; ?></h4>
					<br />
					<table width="100%" border="0" cellspacing="7" cellspacing="7">
						<?php
						if ($prod->rowCount() > 0) {
							$i = 0;
							while ($prod_data = $prod->fetch()) {
								if ($prod_data['pd_thumbnail']) {
									$thumbnail = WEB_ROOT . 'images/product/' . $prod_data['pd_thumbnail'];
								} else {
									$thumbnail = WEB_ROOT . 'images/product/noimagesmall.png';
								}

								$cat2 = $conn->prepare("SELECT * FROM tbl_category WHERE cat_id = '$prod_data[cat_id]'");
								$cat2->execute();
								$cat2_data = $cat2->fetch();
								$catname = $cat2_data['cat_name'];

								if ($i % $productsPerRow == 0) {
									echo '<tr>';
								}

						?>
								<td valign="top">
									<table border="0" style="width:200px;" cellspacing="7" cellspacing="7">
										<tr>
											<td align="center">
												<a href="detail.php?id=<?php echo $prod_data['pd_id']; ?>" class="nyroModal"><img src="<?php echo $thumbnail; ?>" /></a><br />
												<?php echo $catname; ?><br />
												<a href="detail.php?id=<?php echo $prod_data['pd_id']; ?>" class="nyroModal"><?php echo $prod_data['pd_name7']; ?></a><br />
												<br />
												<a href="index.php?pid=<?php echo $prod_data['pd_id']; ?>&id=<?php echo $cid; ?>&v=1" class="btn btn-mini btn-primary" title="Piece" style="font-size:13px; font-weight:normal; color:#000000; width:100px;">
													PC | &#x20B1;<?php echo number_format($prod_data['pc_price'], 2); ?> <br /> <?php echo number_format($prod_data['pc_qty'], 0); ?> left
												</a>
												<!-- <br /><br />
													<a href="index.php?pid=<?php echo $prod_data['pd_id']; ?>&id=<?php echo $cid; ?>&v=2" class="btn btn-mini btn-warning" title="Individual Box" style="font-size:13px; font-weight:normal; color:#000000; width:100px;">
														BX | &#x20B1;<?php echo number_format($prod_data['ib_price'], 2); ?> <br /> <?php echo number_format($prod_data['ib_qty'], 0); ?> left
													</a>
													<br /><br />
													<a href="index.php?pid=<?php echo $prod_data['pd_id']; ?>&id=<?php echo $cid; ?>&v=3" class="btn btn-mini btn-success" title="Box" style="font-size:13px; font-weight:normal; color:#000000; width:100px;">
														CS | &#x20B1;<?php echo number_format($prod_data['bx_price'], 2); ?> <br /> <?php echo number_format($prod_data['bx_qty'], 0); ?> left
													</a> -->
											</td>
										</tr><br />
									</table>
								</td>
						<?php
								if ($i % $productsPerRow == $productsPerRow - 1) {
									echo '</tr>';
								}
								$i += 1;
								if ($i % $productsPerRow > 0) {
									echo '<td colspan="' . ($productsPerRow - ($i % $productsPerRow)) . '">&nbsp;</td>';
								}
							} // End While
						} else {
						}
						?>
					</table>
				</div>
		<?php
			} // End While
		} else {
		}
		?>

	</div>
</div>