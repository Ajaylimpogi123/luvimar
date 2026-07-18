<?php
if (!defined('WEB_ROOT')) {
	exit;
}
$keyword = $_POST['key'];
?>
<ul class="breadcrumb">
	<li>
		<b>Search Product Results</b>
	</li>
	<li style="float:right;"><?php echo date('F d, Y | l'); ?></li>
</ul>
<!--<form method="post" action="index.php?view=search">
		Search &nbsp;
		<input name="key" type="text" id="key" maxlength="50" style="font-size:16px; font-weight:bold;" value="<?php echo $keyword; ?>" required autocomplete=off />
		<input type="submit" value="Go" class="btn btn-success" />
	</form>!-->
<div id="myTabContent" class="tab-content">
	<?php
	$productsPerRow = 4;
	$columnWidth = (int)(100 / $productsPerRow);
	$prod = $conn->prepare("SELECT * FROM tbl_product WHERE  pd_barcode LIKE '%$keyword%' AND is_deleted != '1' AND pc_qty != 0 ORDER BY pd_name ASC");
	$prod->execute();
	?>
	<h4>
		<font color="#000000" size="2">Search result(s) for:</font> &nbsp; <b><?php echo $keyword; ?></b>
	</h4>
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

				if ($i % $productsPerRow == 0) {
					echo '<tr>';
				}

				$catkey = $conn->prepare("SELECT * FROM tbl_category WHERE cat_id = '$prod_data[cat_id]'");
				$catkey->execute();
				$catkey_data = $catkey->fetch();
				$brandname = $catkey_data['cat_name'];
				$catpid = $catkey_data['cat_parent_id'];

				$cat = $conn->prepare("SELECT * FROM tbl_category WHERE cat_id = '$prod_data[cat_id]'");
				$cat->execute();
				$cat_data = $cat->fetch();
				$catname = $cat_data['cat_name'];
		?>
				<td valign="top">
					<table border="0" style="width:200px;" cellspacing="7" cellspacing="7">
						<tr>
							<td align="center">
								<a href="detail.php?id=<?php echo $prod_data['pd_id']; ?>" class="nyroModal"><img src="<?php echo $thumbnail; ?>" /></a><br />
								<?php echo $catname; ?><br />
								<a href="detail.php?id=<?php echo $prod_data['pd_id']; ?>" class="nyroModal"><?php echo $prod_data['pd_name']; ?></a><strong style="color:#000000"> - <?php echo $prod_data['pd_barcode']; ?></strong><br />
								<br />
								<a href="index.php?pid=<?php echo $prod_data['pd_id']; ?>&id=<?php echo $catpid; ?>&v=1" class="btn btn-mini btn-primary" title="Piece" style="font-size:13px; font-weight:normal; color:#000000; width:100px;">
									PC | &#x20B1;<?php echo number_format($prod_data['pc_price'], 2); ?> <br /> <?php echo number_format($prod_data['pc_qty'], 0); ?> left
								</a>
								<!-- <br /><br />
										<a href="index.php?pid=<?php echo $prod_data['pd_id']; ?>&id=<?php echo $catpid; ?>&v=2" class="btn btn-mini btn-warning" title="Individual Box" style="font-size:13px; font-weight:normal; color:#000000; width:100px;">
											BX | &#x20B1;<?php echo number_format($prod_data['ib_price'], 2); ?> <br /> <?php echo number_format($prod_data['ib_qty'], 0); ?> left
										</a>
										<br /><br />
										<a href="index.php?pid=<?php echo $pd_id; ?>&id=<?php echo $catpid; ?>&v=3" class="btn btn-mini btn-success" title="Box" style="font-size:13px; font-weight:normal; color:#000000; width:100px;">
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