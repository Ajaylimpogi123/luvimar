<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();


$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';

?> 

		<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-plus-sign"></i> Beginning Balance</h2>											
					</div>
					
					<form class="form-horizontal nyroModal" method="post" action="process.php?action=beginning" enctype="multipart/form-data" name="form" id="form">
					<div class="box-content">
							<?php
								if($errorMessage == 'Added successfully')
								{
							?>
									<div class="valid_box">
										<b><?php echo $errorMessage; ?></b>
									</div>
							<?php
								}
								else if($errorMessage == 'Expense already exist! Data entry failed.')
								{
							?>
									<div class="error_box">
										<b><?php echo $errorMessage; ?></b>
									</div>
							<?php								
								}else{}
							?>
							<fieldset>							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Amount</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="amount" name="amount" type="text" required autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  <table width="100%">
							  <tr>
								<td>Amount</td>
								<td>Date Added</td>
								<td>Action</td>
							  </tr>
								<?php
									$bg = $conn->prepare("SELECT * FROM bs_beginning_balance WHERE is_deleted != '1' ORDER BY beg_id");
									$bg->execute();
									if($bg->rowCount() > 0)
									{
										$totalb = 0;
										while($bg_data = $bg->fetch())
										{
											$addeddate = date("M d, Y | h:i a",strtotime($bg_data['date_added']));
											$totalb += $bg_data['amount'];
								?>
											<tr>
												<td><?php echo number_format($bg_data['amount'], 2); ?></td>
												<td><?php echo $addeddate; ?></td>
												<td>
													<a class="nyroModal" href="process.php?action=delbeg&id=<?php echo $bg_data['beg_id']; ?>;">
														<i class="icon-remove"></i>														
													</a>
												</td>
											</tr>
								<?php
										} // End While
									}else{ $totalb = "0.00"; }
								?>								
								<tr>
									<td colspan="3"><hr /><b>Total: <?php echo number_format($totalb, 2); ?></b></td>
								</tr>
							  </table>
							</fieldset>
					</div>
							<div class="form-actions">								
								<button type="submit" class="btn btn-success">Save</button>
								<input type="button" value="Cancel" onclick="window.location.href='index.php';" class="btn btn-danger">
							</div>							
					</form>
					
					</div>
		</div><!--/span-->					