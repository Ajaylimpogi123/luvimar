<?php
$userId = $_SESSION['user_id'];

/* Select user from database */
$sql = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$userId' AND is_deleted != '1'");
$sql->execute();
$sql_data = $sql->fetch();

# Get setting details
$sett = $conn->prepare("SELECT * FROM bs_setting");
$sett->execute();
$sett_data = $sett->fetch();


?>
<div class="navbar-inner" style="background: #0f2838;">
	<div class="container-fluid">
		<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</a>
		<!--
				<a class="brand" href="javascript:home();"><img src="<?php echo WEB_ROOT; ?>images/logo.gif" width="70" height="52" /> &nbsp; <span style="font-family:Verdana;"><?php echo $sett_data['system_title']; ?></span></a>
				-->
		<a class="brand" href="<?php echo WEB_ROOT; ?>index.php"><img src="<?php echo WEB_ROOT; ?>images/branch_logo/main.png" style="height: 60px; width:100px;" /></a>


		<!-- user dropdown starts -->
		<div class="btn-group pull-right">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="javascript:mod(<?php echo $userId; ?>);">
				<i class="icon-user"></i><span class="hidden-phone"> <?php echo $sql_data['firstname']; ?></span>
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<?php if ($sql_data['is_admin'] == 1) { ?>
					<li><a href="<?php echo WEB_ROOT; ?>index.php?id=1"><i class="icon-leaf"></i> Light Theme</a></li>
					<li><a href="<?php echo WEB_ROOT; ?>index.php?id=2"><i class="icon-fire"></i> Dark Theme</a></li>
				<?php } else {
				} ?>
				<li class="divider"></li>
				<li><a href="<?php echo $self; ?>?logout"><i class="icon icon-black icon-arrowreturn-se"></i> Logout</a></li>
			</ul>
		</div>
		<!-- user dropdown ends -->
		<?php if ($sql_data['is_admin'] != 1) { ?>
			<div class="top-nav nav-collapse">
				<ul class="nav">
					<li>
						<form method="post" action="<?php echo WEB_ROOT; ?>sales/index.php?view=search" class="navbar-search pull-left">
							<div class="input-append">
								<input name="key" type="text" id="appendedInputButtons" maxlength="50" placeholder="Search" style="width:400px; background:#ffffff;" required autocomplete=off class="search-query span2" />
								<input type="submit" value="Search" class="btn btn-success" />
							</div>
						</form>
					</li>
				</ul>
			</div><!--/.nav-collapse -->
		<?php } else {
		} ?>
	</div>
</div>