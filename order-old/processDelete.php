<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];

	if (isset($_GET['oid']) && (int)$_GET['oid'] > 0) {
		$id = (int)$_GET['oid'];
	} else {
		header('Location: index.php');
	}

	$ch = $conn->prepare("SELECT * FROM tbl_order WHERE od_id = '$id' AND is_deleted != '1'");
	$ch->execute();
	$ch_data = $ch->fetch();
	$name = $ch_data['od_id'];			
	
		/* Update Order Status */
		$sql = $conn->prepare("UPDATE tbl_order SET is_deleted = '1', deleted_by = '$userId', date_deleted = NOW()
					WHERE od_id = $id");
		$sql->execute();
		/* End Order */
		
		// Update Qty
		$q = $conn->prepare("SELECT * FROM tbl_order_item WHERE od_id = '$id'");
		$q->execute();
		if($q->rowCount() > 0)
		{
			
			while($q_data = $q->fetch())
			{
				$up = $conn->prepare("UPDATE tbl_product SET pd_qty = (pd_qty + '$q_data[od_qty]') WHERE pd_id = '$q_data[pd_id]'");
				$up->execute();
				
				$qw = $conn->prepare("SELECT * FROM tbl_product WHERE pd_id = '$q_data[pd_id]'");
				$qw->execute();
				$qw_data = $qw->fetch();
				
				$crt_qty = $q_data['od_qty'];
				$crt_pid = $q_data['pd_id'];
				
				if($q_data['pd_type'] == 'bx')
				{ 
					$tp = "bx";
					$bx = $qw_data['bx_formula'];
					$ib = $qw_data['ib_formula'];
					$pc = $qw_data['pc_formula'];
					$prc = $qw_data['bx_price'];
					$cost = $qw_data['pd_cost'];
					
					if($crt_qty != 0)
					{
						// BX
						$up_bx = $conn->prepare("UPDATE tbl_product SET bx_qty = bx_qty + '$crt_qty' WHERE pd_id = '$crt_pid'");
						$up_bx->execute();
						
						$ib_qty = $crt_qty * $ib;
						
						// IB
						$up_ib = $conn->prepare("UPDATE tbl_product SET ib_qty = ib_qty + '$ib_qty' WHERE pd_id = '$crt_pid'");
						$up_ib->execute();
						
						$pc_qty = $ib_qty * $pc;
						
						// PC
						$up_pc = $conn->prepare("UPDATE tbl_product SET pc_qty = pc_qty + '$pc_qty' WHERE pd_id = '$crt_pid'");
						$up_pc->execute();
												
					}else{}										
					
				}
				else if($q_data['pd_type'] == 'ib')
				{ 
					$tp = "ib"; 
					$bx = $qw_data['bx_formula'];
					$ib = $qw_data['ib_formula'];
					$pc = $qw_data['pc_formula'];
					$prc = $qw_data['ib_price'];
					$cost = $qw_data['pd_cost'];
					
					if($crt_qty != 0)
					{
						// IB
						$up_ib = $conn->prepare("UPDATE tbl_product SET ib_qty = ib_qty + '$crt_qty' WHERE pd_id = '$crt_pid'");
						$up_ib->execute();

						$pc_qty = $crt_qty * $pc;
						
						// PC
						$up_pc = $conn->prepare("UPDATE tbl_product SET pc_qty = pc_qty + '$pc_qty' WHERE pd_id = '$crt_pid'");
						$up_pc->execute();
						
						if($bx != 0)
						{
							$bx_qty = $crt_qty / $ib;
												
							$whole = floor($bx_qty);
							$fraction = $bx_qty - $whole;					
							
							// BX
							$up_bx = $conn->prepare("UPDATE tbl_product SET bx_qty = bx_qty + '$whole' WHERE pd_id = '$crt_pid'");
							$up_bx->execute();
						}else{}
																																
					}else{}
				}
				else
				{ 
					$tp = "pc"; 
					$bx = $qw_data['bx_formula'];
					$ib = $qw_data['ib_formula'];
					$pc = $qw_data['pc_formula'];
					$prc = $qw_data['pc_price'];
					$cost = $qw_data['pd_cost'];
					
					if($crt_qty != 0)
					{
						// PC
						$up_pc = $conn->prepare("UPDATE tbl_product SET pc_qty = pc_qty + '$crt_qty' WHERE pd_id = '$crt_pid'");
						$up_pc->execute();
						
						if($ib != 0)
						{
							$ib_qty = $crt_qty / $pc;
							$whole_ib = floor($ib_qty);
							$fraction_ib = $ib_qty - $whole_ib;
							
							// IB
							$up_ib = $conn->prepare("UPDATE tbl_product SET ib_qty = ib_qty + '$whole_ib' WHERE pd_id = '$crt_pid'");
							$up_ib->execute();
						}else{}
						
						if($bx != 0)
						{							
							if($ib != 0)
							{
								$bx_qty = $ib_qty / $ib;
							}else{
								$bx_qty = $crt_qty / $pc;
							}
							$whole_bx = floor($bx_qty);
							$fraction_bx = $bx_qty - $whole_bx;					
							
							// BX
							$up_bx = $conn->prepare("UPDATE tbl_product SET bx_qty = bx_qty + '$whole_bx' WHERE pd_id = '$crt_pid'");
							$up_bx->execute();
						}else{}
						
					}else{}
					
				}
			}
			
		}else{}
	
		/* Insert Log */
		$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
					VALUES ('Order deleted', '$name', 'order', '$userId', NOW())");
		$log->execute();
		/* End Log */

		header('Location: index.php?error=' . urlencode('Deleted successfully'));

?>