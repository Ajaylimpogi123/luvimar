<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

if (!isset($_GET['oid']) || (int)$_GET['oid'] <= 0) {
	header('Location: index.php');
}

	$orderId = (int)$_GET['oid'];
	
	$odde = $conn->prepare("SELECT * FROM tbl_order WHERE od_id = '$orderId'");
	$odde->execute();
	$odde_data = $odde->fetch();
	
	$orderdate = date("M d, Y | h:i a",strtotime($odde_data['od_date']));
	$deldate = date("M d, Y",strtotime($odde_data['delivery_date']));
	
	$sql = $conn->prepare("SELECT * FROM tbl_order o, tbl_order_item i, tbl_product p
				WHERE o.od_id = i.od_id AND i.pd_id = p.pd_id AND o.od_id = '$orderId'");
	$sql->execute();
	
?>		
<head>		
<title>Print Delivery</title>
<link rel="shortcut icon" href="<?php echo WEB_ROOT; ?>images/favicon.ico">
<script type="text/javascript">     
    function PrintDiv() {    
       var divToPrint = document.getElementById('divToPrint');
       var popupWin = window.open('', '_blank', 'width=auto,height=auto');
       popupWin.document.open();
       popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
        popupWin.document.close();
            }
 </script>
<style rel="stylesheet">
.tdlabel
{   
   color: #000 !important;
   font-family: Arial !important;
   font-weight: bold;
   font-size:14px;
}
.tddata
{   
   color: #000 !important;
   font-family: Arial !important;  
   font-size:13px;
}
</style>
</head>
<body onload="PrintDiv()">
	<table id="divToPrint" style="display:none;">
	<tr>
		<td>
		<table style="margin:auto;">
		<tr>
			<td><img src="<?php echo WEB_ROOT; ?>images/logo.png" /></td>
			<td>&nbsp; &nbsp;</td>
			<td>
				<h3>Delivery Details</h3>
				<h4><?php echo $sql->rowCount(); ?> item(s)</h4>
			</td>
		</tr>
		</table>
		<br />
		<table style="margin:auto; width:700px;">
		<tr><td>
			<table style="padding:7px; width:700px;" border="0">
			<tr>								
				<td class="tddata"><b>Customer Name :</b> <?php echo $customer_name; ?></td>
				<td width="10px;">&nbsp;</td>
				<td class="tddata"><b>Order Date :</b> <?php echo $orderdate; ?></td>
			</tr>
			<tr>
				<td class="tddata"><b>Delivery Date :</b> <?php echo $deldate; ?></td>
				<td width="10px;">&nbsp;</td>
				<td class="tddata"><b>Driver :</b> <?php echo $driver; ?></td>
			</tr>
			<tr>				
				<td class="tddata"><b>Delivery Address :</b> <?php echo $delivery_address; ?></td>
				<td width="10px;">&nbsp;</td>
				<td class="tddata"><b>Discount :</b> &#x20B1;<?php echo number_format($od_discount, 2); ?> | <?php echo number_format($percent_discount, 0); ?>%</td>
			</tr>
			</table>
		</td></tr>
		<tr><td colspan="7"><hr color='black' /></td></tr>
		<tr><td>		
			<table style="padding:7px; width:700px;">
			<tr>								
				<td class="tdlabel"><b>Product</b></td>
				<td width="10px;">&nbsp;</td>
				<td class="tdlabel"><b>Price</b></td>
				<td width="10px;">&nbsp;</td>
				<td class="tdlabel" align="center"><b>Qty</b></td>
				<td width="10px;">&nbsp;</td>
				<td class="tdlabel"><b>Sub-Total</b></td>
			</tr>
					<?php					
					if ($sql->rowCount() > 0) 
					{
							$subTotal = 0; $total = 0;
							while($sql_data = $sql->fetch())
							{
								if ($sql_data['pd_thumbnail']) {
									$image = WEB_ROOT . 'images/product/' . $sql_data['pd_thumbnail'];
								} else {
									$image = WEB_ROOT . 'images/product/noimagelarge.png';
								}
								
								$subTotal = $sql_data['od_price'] * $sql_data['od_qty'];
								$total += $sql_data['od_price'] * $sql_data['od_qty'];
								
								$dcamt = ($sql_data['od_discount'] / 100) * $sql_data['od_amount_due'];
					?>				
							  <tr>												
								<td class="tddata" valign="top"><span class="border_cart"></span><?php echo $sql_data['pd_name']; ?></td>
								<td width="10px;">&nbsp;</td>
								<td class="tddata" valign="top"><span class="border_cart"></span>&#x20B1; <?php echo number_format($sql_data['od_price'], 2); ?></td>
								<td width="10px;">&nbsp;</td>
								<td class="tddata" valign="top" align="center"><?php echo $od_qty; ?></td>
								<td width="10px;">&nbsp;</td>
								<td class="tddata" valign="top"><span class="border_cart"></span>&#x20B1; <?php echo number_format($subTotal, 2); ?></td>												
							  </tr>
					<?php
							} // End For
							
					?>
			<tr>
				<td colspan="7"><hr color='black' /></td>
			</tr>
			<tr>								
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td><span class="border_cart"></span>Total:</td>
				<td></td>								
				<td class="tdlabel"><span class="border_cart"></span>&#x20B1; <?php echo number_format($sql_data['od_total_amt_due'], 2); ?></td>
			</tr>							
			</table>
	       
		</td></tr>
		<tr style="border-top: 1px;">
			<td colspan="7" align="center">*** Nothing Follows ***</td>
		</tr>
		</table>
		<br />
		<center>
			<table style="padding:7px; font-size:14px;" width="700">
			<tr>
				<td>Prepared by:<br /><br />__________________<br />Signature over Printed Name</td>
				<td>Checked by:<br /><br />__________________<br />Signature over Printed Name</td>
				<td>Received by:<br /><br />__________________<br />Signature over Printed Name</td>
			</tr>
			</table>
		</center>
			<?php }else{ echo "Shopping Cart Is Empty"; } ?>
		</td>
	</tr>
	</table>
</body>			