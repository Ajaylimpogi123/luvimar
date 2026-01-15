<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();
?>
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
	  <tr>
		  <th>Order #</th>
		  <th>Customer</th>								  
		  <th>Amount</th>								 
		  <th>Status</th>
		  <th>Delivery Date</th>
		  <th>Action</th>
	  </tr>
  </thead>   
  <tbody>
	<?php
	$userId = $_SESSION['user_id'];
	
	$user = $conn->prepare("SELECT * FROM bs_user
				WHERE user_id = '$userId'");
	$user->execute();
	$user_data = $user->fetch();	

		$sql = $conn->prepare("SELECT oi.od_id, customer_name, delivery_date, od_total_amt_due, is_delivered
					FROM tbl_order o, tbl_order_item oi, tbl_product p 
						WHERE oi.pd_id = p.pd_id and o.od_id = oi.od_id AND o.is_deleted != '1' AND o.is_delivery = '1' AND o.is_delivered = '1'
							GROUP BY oi.od_id
								ORDER BY oi.od_id DESC");
		$sql->execute();
		if($sql->rowCount() > 0)
		{
			$ctr = 1;
			while($sql_data = $sql->fetch())
			{
				$cname = ucwords(strtolower($sql_data['customer_name']));
				$deldate = date("M d, Y",strtotime($sql_data['delivery_date']));
														
	?>
				<!-- Start display list of orders !-->
				<tr>											
					<td><?php echo $sql_data['od_id']; ?></td>
					<td><?php echo $cname; ?></td>
					<td>&#x20B1; <?php echo number_format($sql_data['od_total_amt_due'], 2); ?></td>
					<td><span class="label label-success">Delivered</span></td>
					<td><?php echo $deldate; ?></td>
					<td class="center">
						<?php if($user_data['is_del_v_access'] == 1){ ?>
							<a class="btn btn-primary" href="javascript:detail(<?php echo $sql_data['od_id']; ?>);">
								<i class="icon-edit icon-white icon-eye-open"></i>  
								view                                            
							</a>	
						<?php }else{ echo "-- --"; }?>
						<?php if($user_data['is_del_d_access'] == 1){ ?>
							<?php if($sql_data['is_delivered'] == 0){ ?>
								<a class="btn btn-success" href="javascript:del(<?php echo $sql_data['od_id']; ?>);">
									<i class="icon-ok icon-white"></i> 
									Set to Delivered
								</a>
							<?php }else{} ?>
						<?php }else{ echo "-- --"; }?>
					</td>
				</tr>
				<!-- End display list of orders !-->
	<?php
			}
		}
		else
		{}
	?>
	
  </tbody>
</table>