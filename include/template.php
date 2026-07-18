<?php

if (!defined('WEB_ROOT')) {
	exit;
}

$self = WEB_ROOT . 'encrypt.php';

function word_split($str, $words = 15)
{
	$arr = preg_split("/[\s]+/", $str, $words + 1);
	$arr = array_slice($arr, 0, $words);
	return join(' ', $arr);
}
$userId = $_SESSION['user_id'];
$sql = $conn->prepare("SELECT * FROM bs_user
						WHERE user_id = '$userId'");
$sql->execute();
$sql_data = $sql->fetch();

# Get setting details
$sett = $conn->prepare("SELECT * FROM bs_setting");
$sett->execute();
$sett_data = $sett->fetch();

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title><?php echo $sett_data['system_title']; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php echo $sett_data['system_title']; ?>">
	<meta name="author" content="<?php echo $sett_data['developer']; ?>">

	<!-- The styles -->
	<?php require_once SRV_ROOT . '/global-library/global-css.php'; ?>
	<!-- The HTML5 shim, for IE6-8 support of HTML5 elemepowertruck -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?php require_once SRV_ROOT . '/global-library/misc-js.php'; ?>
</head>

<body onLoad="document.getElementById('siteLoader').style.display = 'none'; document.frm.pid.focus();">
	<!-- loading BEGIN PAGE LOADER -->
	<div id="siteLoader">
		<div id="loadImg" style="margin:auto;">
			<img src="<?php echo WEB_ROOT; ?>images/loader/loader_2.gif" border="0" align="left" style="position:absolute; left:50%; top:50%; margin-left:-100px; /*image width/2 */ margin-top:-100px; /">
		</div>
	</div>
	<!-- END PAGE LOADER -->

	<!-- topbar starts -->
	<div class="navbar">
	
		<?php require_once SRV_ROOT . 'include/header.php';?>
	</div>
	<!--<div style="height:85px; width:100%;"></div>!-->
	<!-- topbar ends -->
	<div class="container-fluid">
		<div class="row-fluid">

			<!-- left menu starts -->

			<?php require_once SRV_ROOT . '/include/left-menu.php'; ?>

			<!-- left menu ends -->

			<div id="content" class="span10">
				<!-- Check access level. Users can only access their own profile !-->
				<!-- start notifications for product below minimum qty -->
				<?php
				$expire = date("Y-m-d", strtotime($today_date2 . '+3 months'));

				$pdQty = $conn->prepare("SELECT * FROM tbl_product WHERE (pd_expiration BETWEEN '$today_date2' and '$expire') AND is_deleted != '1'");
				$pdQty->execute();
				if ($pdQty->rowCount() > 0) {

					if ($pdQty != "") {
						$pdQty_data = $pdQty->fetch();
						if ($pdQty_data['pc_qty'] != 0) {
				?>
							<span style='font-size:13px; background:#dd5600; border-radius: 10px; border: solid 1px #999999; padding:7px;'><a href="<?php echo WEB_ROOT; ?>product/expiration.php" target=_blank style="color:#ffffff;">You have a product that will expire after 3 months!</a></span><br /><br />
				<?php
						} else {
						}
					} else {
					}
				} else {
				}


				/*
						date_default_timezone_set("Asia/Manila");
						$datetoday = date('Y-m-d', strtotime('+3 days'));
						$chk = $conn->prepare("SELECT * FROM tbl_order WHERE delivery_date = '$datetoday' AND is_delivered != '1'");
						$chk->execute();
						
						if($chk->rowCount() > 0)
						{ echo "&nbsp; <span style='font-size:13px; background:#7db73e; border-radius: 10px; border: solid 1px #999999; padding:7px;'><a href='" . WEB_ROOT . "/delivery/' style='color:#ffffff;'>You have upcoming delivery 3 days from now</a></span>"; }else{}
					
						date_default_timezone_set("Asia/Manila");
						$today_date1 = date("Y-m-d H:i:s");
						$today_date2 = date("Y-m-d");
						
						$chk7 = $conn->prepare("SELECT * FROM tbl_order WHERE delivery_date = '$today_date2' AND is_delivered != '1'");
						$chk7->execute();
						
						if($chk7->rowCount() > 0)
						{ echo "&nbsp; <span style='font-size:13px; background:#3a9dd8; border-radius: 10px; border: solid 1px #999999; padding:7px;'><a href='" . WEB_ROOT . "/delivery/' style='color:#ffffff;'>You have " . $chk7->rowCount() . " delivery today</a></span>"; }else{}
				*/
				?>
				<!-- start notifications for product below minimum qty -->
				<?php
				$mqty = $conn->prepare("SELECT * FROM tbl_product WHERE pc_qty < pd_mqty AND is_deleted != '1'");
				$mqty->execute();

				if ($mqty->rowCount() > 0) {
					if ($mqty->rowCount() == 1) {
						$ps = '';
					} else {
						$ps = 's';
					}
				?>
					<div class="top-nav nav-collapse" style="margin-top: 15px;">
						<ul class="nav" href="<?php echo WEB_ROOT; ?>product/belowminimum.php" target=_blank style="font-size:13px; background:rgb(226, 68, 44);; border-radius: 10px; border: solid 1px #999999; padding:7px;">
							<li><a href="<?php echo WEB_ROOT; ?>product/belowminimum.php" target=_blank style="color: #ebebeb;">You have <?php echo $mqty->rowCount(); ?> product<?php echo $ps; ?> below minimum quantity!</a></li>
						</ul>
					</div>
				<?php
				} else {
				}
				?>
				<!-- end notifications for product below minimum qty -->
				<!-- end notifications for product below minimum qty -->

				<?php if ($sql_data['is_category_access'] == 1): ?><a href="<?php echo WEB_ROOT; ?>category"><i class="icon-th-large"></i><span class="hidden-tablet"> CATEGORY</span></a>&nbsp;|&nbsp;<?php endif; ?>

					<?php if ($sql_data['is_product_access'] == 1): ?><a href="<?php echo WEB_ROOT; ?>product"><i class="icon-th"></i><span class="hidden-tablet"> INVENTORY</span></a>&nbsp;|&nbsp;<?php endif; ?>
					<?php if ($sql_data['is_product_access'] == 1): ?><a href="<?php echo WEB_ROOT; ?>raw-product"><i class="icon-th"></i><span class="hidden-tablet"> RAW MATERIALS</span></a>&nbsp;|&nbsp;<?php endif; ?>

						<?php if ($sql_data['is_customer_access'] == 1): ?><a href="<?php echo WEB_ROOT; ?>customer"><i class="icon-user"></i><span class="hidden-tablet">
									<font size="2">CUSTOMER</font>
								</span></a>&nbsp;|&nbsp;<?php endif; ?>
							<?php if ($sql_data['is_job_order_access'] == 1): ?><a href="<?php echo WEB_ROOT; ?>job-order"><i class="icon-file"></i><span class="hidden-tablet"> JOB ORDER</span></a>&nbsp;|&nbsp;<?php endif; ?>
								<?php if ($sql_data['is_production_report_access'] == 1): ?><a href="<?php echo WEB_ROOT; ?>production"><i class="icon-file"></i><span class="hidden-tablet"> PRODUCTION REPORT</span></a>&nbsp;|&nbsp;<?php endif; ?>
									<!-- <?php if ($sql_data['is_supplier_access'] == 1): ?><a href="<?php echo WEB_ROOT; ?>/supplier"><i class="icon icon-black icon-users"></i><span class="hidden-tablet"> SUPPLIER</span></a>&nbsp;|&nbsp;<?php endif; ?> -->

									<!-- <?php if ($sql_data['is_receive_access'] == 1): ?><a href="<?php echo WEB_ROOT; ?>/receive"><i class="icon-list"></i><span class="hidden-tablet">
												<font size="2">RECEIVE</font>
											</span></a>&nbsp;|&nbsp;<?php endif; ?> -->
									<!-- 
									<?php if ($sql_data['is_return_access'] == 1): ?><a href="<?php echo WEB_ROOT; ?>/return"><i class=" icon-align-center"></i><span class="hidden-tablet">
												<font size="2">RETURN</font>
											</span></a>&nbsp;|&nbsp;<?php endif; ?> -->

									<?php if ($sql_data['is_sales_access'] == 1): ?><a href="<?php echo WEB_ROOT; ?>order"><i class="icon-file"></i><span class="hidden-tablet"> SALES HISTORY</span></a>&nbsp;|&nbsp;<?php endif; ?>


										<!-- <?php if ($sql_data['is_sales_access'] == 1): ?><a href="<?php echo WEB_ROOT; ?>/branch"><i class="icon-file"></i><span class="hidden-tablet"> BRANCH</span></a>&nbsp;|&nbsp;<?php endif; ?> -->

										<!-- <?php if ($sql_data['is_delivery_access'] == 1): ?><a href="javascript:delivery();"><i class="icon-road"></i><span class="hidden-tablet"> DELIVERY</span></a>&nbsp;|&nbsp;<?php endif; ?> -->

										<?php if ($sql_data['is_expense_access'] == 1): ?><a href="<?php echo WEB_ROOT; ?>expenses"><i class="icon-book"></i><span class="hidden-tablet"> EXPENSE</span></a>&nbsp;|&nbsp;<?php endif; ?>
										
											<?php if ($sql_data['is_receivable_access'] == 1): ?><a href="<?php echo WEB_ROOT; ?>receivable"><i class="icon-book"></i><span class="hidden-tablet"> COLLECTION</span></a>&nbsp;|&nbsp;<?php endif; ?>

											<?php if ($sql_data['is_report_access'] == 1): ?><a href="<?php echo WEB_ROOT; ?>report"><i class="icon-list-alt"></i><span class="hidden-tablet"> REPORTS</span></a>&nbsp;|&nbsp;<?php endif; ?>

												<?php if ($sql_data['is_user_access'] == 1): ?><a href="<?php echo WEB_ROOT; ?>user"><i class="icon icon-black icon-users"></i><span class="hidden-tablet"> USERS</span></a><?php endif; ?>

												<br /><br />
												<!-- content starts -->
												<?php require_once $content; ?>
												<!-- content ends -->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->

		<hr />

		<footer>
			<?php require_once SRV_ROOT . '/include/footer.php'; ?>
		</footer>

	</div><!--/.fluid-container-->


	<!-- external javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<?php require_once SRV_ROOT . '/global-library/global-js.php'; ?>


</body>

</html>