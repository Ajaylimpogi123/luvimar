<?php
	$productsPerRow7 = 4; $columnWidth7 = (int)(100 / $productsPerRow7);
	$cat7 = $conn->prepare("SELECT * FROM tbl_category WHERE cat_parent_id = '$cid' AND is_deleted != '1'");
	$cat7->execute();
	if($cat7->rowCount() > 0)
	{
		while($cat7_data = $cat7->fetch())
		{
			$prod7 = $conn->prepare("SELECT * FROM tbl_product WHERE cat_parent_id = '$cat7_data[cat_parent_id]' AND is_deleted != '1' ORDER BY pd_name ASC");
			$prod7->execute();
?>				
			<div class="tab-pane" id="all">
				<h4>All</h4>
				<br />
				<table width="100%" border="0" cellspacing="7" cellspacing="7">
				<?php
					if($prod7->rowCount() > 0)
					{
						$i = 0;
						while($prod7_data = $prod7->fetch())
						{
							if ($prod7_data['pd_thumbnail']) {
								$thumbnail7 = WEB_ROOT . 'images/product/' . $prod7_data['pd_thumbnail'];
							} else {
								$thumbnail7 = WEB_ROOT . 'images/product/noimagesmall.png';
							}
							
							$cat7 = $conn->prepare("SELECT * FROM tbl_category WHERE cat_id = '$prod7_data[cat_id]'");
							$cat7->execute();
							$cat7_data = $cat7->fetch();
							$catname7 = isset($cat7_data['cat_name']) ? $cat7_data['cat_name'] : '';
							
							if ($i % $productsPerRow7 == 0) { echo '<tr>'; }
				?>
							<td valign="top">	
								<table border="0" style="width:200px;" cellspacing="7" cellspacing="7">
								<tr><td align="center">
									<a href="detail.php?id=<?php echo $prod7_data['pd_id']; ?>" class="nyroModal"><img src="<?php echo $thumbnail7; ?>" /></a><br />
									<?php echo $catname7; ?><br />
									<a href="detail.php?id=<?php echo $prod7_data['pd_id']; ?>" class="nyroModal"><?php echo $prod7_data['pd_name7']; ?></a><br />									
									<br />
										<a href="index.php?pid=<?php echo $prod7_data['pd_id']; ?>&id=<?php echo $cid; ?>&v=1" class="btn btn-mini btn-primary" title="Piece" style="font-size:13px; font-weight:normal; color:#000000; width:100px;">
											PC | &#x20B1;<?php echo number_format($prod7_data['pc_price'], 2); ?> <br /> <?php echo number_format($prod7_data['pc_qty'], 0); ?> left
										</a>
										<!-- <br /><br />
										<a href="index.php?pid=<?php echo $prod7_data['pd_id']; ?>&id=<?php echo $cid; ?>&v=2" class="btn btn-mini btn-warning" title="Individual Box" style="font-size:13px; font-weight:normal; color:#000000; width:100px;">
											BX | &#x20B1;<?php echo number_format($prod7_data['ib_price'], 2); ?> <br /> <?php echo number_format($prod7_data['ib_qty'], 0); ?> left
										</a>
										<br /><br />
										<a href="index.php?pid=<?php echo $prod7_data['pd_id']; ?>&id=<?php echo $cid; ?>&v=3" class="btn btn-mini btn-success" title="Box" style="font-size:13px; font-weight:normal; color:#000000; width:100px;">
											CS | &#x20B1;<?php echo number_format($prod7_data['bx_price'], 2); ?> <br /> <?php echo number_format($prod7_data['bx_qty'], 0); ?> left
										</a> -->
									
								</td></tr><br />
								</table>
							</td>
				<?php
							if ($i % $productsPerRow7 == $productsPerRow7 - 1) { echo '</tr>'; }
							$i += 1;
							if ($i % $productsPerRow7 > 0) { echo '<td colspan="' . ($productsPerRow7 - ($i % $productsPerRow7)) . '">&nbsp;</td>'; }
						} // End While
					}else{}
				?>
				</table>
			</div>
<?php
		} // End While
	}else{}
?>