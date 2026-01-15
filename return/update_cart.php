<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';
require_once '../global-library/cart-functions3.php';

checkUser();

	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];
	
	# Qty
		foreach ($pid as $prid)
		{
					
			if (isset($_POST['qty_' . $prid]) && $_POST['qty_' . $prid] > 0) 
			{
				$con = $_POST['qty_' . $prid];
			
				foreach($con as $op)
				{
					
					# UPDATE tbl_cart_return
					$up = $conn->prepare("UPDATE tbl_cart_return SET ct_qty = '$op'
								WHERE ct_id = '$prid' AND user_id = '$userId'");
					$up->execute();
				}
			}else{}		
		}
		
	# Cost
		foreach ($pid as $prid)
		{
					
			if (isset($_POST['cost_' . $prid]) && $_POST['cost_' . $prid] > 0) 
			{
				$con = $_POST['cost_' . $prid];
			
				foreach($con as $op)
				{
					
					# UPDATE tbl_cart_return
					$up = $conn->prepare("UPDATE tbl_cart_return SET ct_cost = '$op'
								WHERE ct_id = '$prid' AND user_id = '$userId'");
					$up->execute();
				}
			}else{}		
		}
		
	# Price
		foreach ($pid as $prid)
		{
					
			if (isset($_POST['price_' . $prid]) && $_POST['price_' . $prid] > 0) 
			{
				$con = $_POST['price_' . $prid];
			
				foreach($con as $op)
				{
					
					# UPDATE tbl_cart_return
					$up = $conn->prepare("UPDATE tbl_cart_return SET ct_price = '$op'
								WHERE ct_id = '$prid' AND user_id = '$userId'");
					$up->execute();
				}
			}else{}		
		}
?>