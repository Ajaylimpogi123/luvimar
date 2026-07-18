<?php
if (!defined('WEB_ROOT')) {
	exit;
}

	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("Y-m-d");

// Filtering now happens live via AJAX (ajax_collection_filter.php),
// so the very first page load just shows everything, unfiltered.
$dfrom = "";
$dto   = "";

$userId = $_SESSION['user_id'];

$user = $conn->prepare("SELECT * FROM bs_user WHERE user_id = :uid");
$user->execute([':uid' => $userId]);
$user_data = $user->fetch();

$sql = $conn->prepare("SELECT * FROM tbl_order WHERE is_deleted != '1' AND payment_mode = 'collection' ORDER BY od_date DESC");
$sql->execute();

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>		
		<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-file"></i> List of Collection</h2>						
						<div class="box-icon">																					
							<a href="../" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>							
						</div>
					</div>
					<div class="box-content">
						<?php
								if($errorMessage == 'Deleted successfully')
								{
							?>
									<div class="valid_box">
										<b><?php echo $errorMessage; ?></b>
									</div>
							<?php
								}elseif($errorMessage == 'Paid successfully'){
									?>
									<div class="valid_box">
										<b><?php echo $errorMessage; ?></b>
									</div>
									<?php
								}else{}
						?>
					<div style="
    padding:15px;
    background:#fff;
    border:1px solid #eee;
    border-radius:8px;
    margin-bottom:15px;
">

<!-- No <form>/submit anymore — every filter fires an AJAX refresh on change -->
<div id="collectionFilterBar">

    <div style="
        display:flex;
        align-items:end;
        gap:10px;
        flex-wrap:wrap;
    ">

        <!-- Customer -->
        <div style="min-width:300px; 	margin-bottom:5px; padding-bottom:5px; border-bottom:1px solid #eee;">
            <label style="display:block; height:25px;  font-size:13px;">
                Customer
            </label>

            <select
                name="cust"
               
                id="selectError"
                data-rel="chosen"
                style="
                    width:100%;
				
                    height:58px;
                    border:1px solid #ccc;
                    border-radius:6px;
                "
            >
                <option value="">All Customer</option>

                <?php
                $cus = $conn->prepare("
                    SELECT *
                    FROM bs_customer
                    WHERE is_deleted != '1'
                    ORDER BY client_name
                ");
                $cus->execute();

                while ($cus_data = $cus->fetch()) {
                ?>
                    <option value="<?= $cus_data['cust_id']; ?>">
                        <?= $cus_data['client_name']; ?>
                        - <?= $cus_data['customer_name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <!-- Date From -->
        <!-- <div>
            <label style="display:block; font-size:13px;">
                From
            </label>

            <input
                type="text"
                id="txtFromDate"
                name="from"
                value="<?= $dfrom ?>"
                autocomplete="off"
                placeholder="Date From"
                style="
                    width:130px;
                    height:38px;
                    padding:0 10px;
                    border:1px solid #ccc;
                    border-radius:6px;
                "
            >
        </div> -->

        <!-- Date To -->
        <!-- <div>
            <label style="display:block;  font-size:13px;">
                To
            </label>

            <input
                type="text"
                id="txtToDate"
                name="to"
                value="<?= $dto ?>"
                autocomplete="off"
                placeholder="Date To"
                style="
                    width:130px;
                    height:38px;
				
                    padding:0 10px;
                    border:1px solid #ccc;
                    border-radius:6px;
                "
            >
        </div> -->

        <!-- Status (NEW) -->
        <div>
            <label style="display:block; font-size:13px;">
                Status
            </label>

            <select
                name="status"
                id="selectStatus"
                style="
                    width:140px;
                    height:38px;
                    padding:0 10px;
                    border:1px solid #ccc;
                    border-radius:6px;
                "
            >
                <option value="">All</option>
                <option value="paid">Paid</option>
                <option value="unpaid">Unpaid</option>
            </select>
        </div>

        <!-- Clear filters (still no page reload) -->
        <!-- <div>
            <button
                type="button"
                id="btnClearFilters"
                style="
                    height:38px;
                    padding:0 18px;
                    border:1px solid #ccc;
                    border-radius:6px;
                    background:#fff;
                    color:#333;
                    font-weight:600;
                    cursor:pointer;
                "
            >
                Clear
            </button>
        </div> -->

    </div>

</div>

</div>
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								<th>Invoice No.</th>
								  <th>Customer</th>								  
								  <th>Payment Mode</th>								  
																  
								  <th>Amount</th>								 
								  <th>Status</th>								 
								  <th>Order Date</th>
								  <th>Due Date</th>
								  <th>Action</th>
							  </tr>
						  </thead>   
						  <tbody id="collectionTableBody">
							<?php
								if($sql->rowCount() > 0)
								{
									while($sql_data = $sql->fetch())
									{
										$cname = ucwords(strtolower($sql_data['customer_name']));
										$orderdate = date("M d, Y | h:i a",strtotime($sql_data['od_date']));
										$datedue = date("M d, Y",strtotime($sql_data['date_due']));
																				
							?>
										<!-- Start display list of orders !-->
										<tr>											
											<td><?php echo $sql_data['invoice_num']; ?></td>
											<td><?php echo $cname; ?></td>
											<td><?php echo $sql_data['payment_mode']; ?></td>
											
											<td>&#x20B1; <?php echo number_format($sql_data['od_total_amt_due'], 2); ?></td>
											<td>
												<span 	style="
											display:inline-block;
											padding:6px 14px;
											border-radius:20px;
											font-size:13px;
											font-weight:600;
											color:#fff;
											background: <?= $sql_data['is_paid'] > 0 ? '#28a745' : '#dc3545' ?>;
										"><?php echo ucfirst($sql_data['is_paid'] > 0 ? 'Paid' : 'Unpaid') ?></span>
											
											<td><?php echo $orderdate; ?></td>
											<td><?php echo $datedue; ?></td>
											<td class="center">
												<?php if($user_data['is_sale_v_access'] == 1){ ?>
													<a class="btn btn-primary" href="javascript:detail(<?php echo $sql_data['od_id']; ?>);">
														<i class="icon-edit icon-white icon-eye-open"></i>  
														view                                            
													</a>	
												<?php }else{ echo "-- --"; }?>
					
											</td>
										</tr>
										<!-- End display list of orders !-->
							<?php
									}
								}
								else
								{
									echo '<tr><td colspan="8" class="center">No records found.</td></tr>';
								}
							?>
							
						  </tbody>
						</table>            
					</div>
				</div><!--/span-->
			
			</div><!--/row-->

<script>
$(document).ready(function () {

    function loadCollectionData() {
        var from   = $('#txtFromDate').val();
        var to     = $('#txtToDate').val();
        var cust   = $('#selectError').val();   // customer dropdown
        var status = $('#selectStatus').val();  // paid / unpaid / all

        $('#collectionTableBody').html(
            '<tr><td colspan="8" class="center">Loading...</td></tr>'
        );

        $.ajax({
            url: 'ajax_collection_filter.php', // place this file next to list_collection.php, or update the path
            type: 'POST',
            data: { from: from, to: to, cust: cust, status: status },
            success: function (response) {
                $('#collectionTableBody').html(response);
            },
            error: function () {
                $('#collectionTableBody').html(
                    '<tr><td colspan="8" class="center">Failed to load data. Please try again.</td></tr>'
                );
            }
        });
    }

    // Dropdowns refresh the table the instant they change
    $('#selectError, #selectStatus').on('change', function () {
        loadCollectionData();
    });

    // Date pickers fire 'change' when a date is selected
    $('#txtFromDate, #txtToDate').on('change', function () {
        loadCollectionData();
    });

    // Debounce, in case dates are typed by hand instead of picked
    var debounceTimer;
    $('#txtFromDate, #txtToDate').on('keyup', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(loadCollectionData, 600);
    });

    $('#btnClearFilters').on('click', function () {
        $('#txtFromDate, #txtToDate').val('');
        $('#selectError').val('').trigger('chosen:updated'); // remove this line if you're not using Chosen.js
        $('#selectStatus').val('');
        loadCollectionData();
    });

});
</script>