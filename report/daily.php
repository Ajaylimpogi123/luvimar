<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

$userId = $_SESSION['user_id'];

$dfrom = $_POST['date1'] ?? '';
$dto = $_POST['date1'] ?? '';
$stype = $_POST['stype'] ?? '';
$rmk = $_POST['rmk'] ?? '';
$branch = $_POST['branch'] ?? '';

if ($branch == "db_luvimar") {
    $branchname = "Bacolod Branch";
    $img = "logo.png";
} else {
    $branchname = "Other Branch";
    $img = "main.png";
}

if ($stype == 0) {
    $typ_state = "";
} else if ($stype == 'Cash') {
    $typ_state = "AND payment_mode = 'Cash'";
} else {
    $typ_state = "AND payment_mode = 'collection'";
}

if ($rmk == 0) {
    $rmk_state = "";
} else {
    $rmk_state = "AND remarks != ''";
}

# Format Date to words
$wfrom = date("M d, Y", strtotime($dfrom));
$wto = date("M d, Y", strtotime($dto));

# Format Date to match date in db
$newfrom = date("Y-m-d", strtotime($dfrom));
$newto = date("Y-m-d", strtotime($dto));

$oddate = "od_date_1";
$from = $newfrom;
$to = $newto;

// Query to get purchased items for the day
$topItemsQuery = $conn->prepare("SELECT o.od_id,
        o.$oddate,
        c.customer_name,
        p.pd_barcode,
        p.pd_name,
        i.od_qty,
        i.od_price,
        (i.od_qty * i.od_price) as total_amount
    FROM $branch.tbl_order_item i
    JOIN $branch.tbl_product p ON i.pd_id = p.pd_id
    JOIN $branch.tbl_order o ON i.od_id = o.od_id
    JOIN $branch.bs_customer c ON i.cust_id = c.cust_id
    WHERE o.$oddate BETWEEN '$from' AND '$to' AND o.is_deleted != '1' AND payment_mode != 'collection'
    ORDER BY o.$oddate ASC
");
$topItemsQuery->execute();
$topItems = $topItemsQuery->fetchAll(PDO::FETCH_ASSOC);

// Grand total sales for the period (used for the summary line)
$salesTotalQuery = $conn->prepare("SELECT SUM(od_total_amt_due) as grand_total 
    FROM $branch.tbl_order
    WHERE ($oddate BETWEEN '$from' and '$to') $typ_state $rmk_state AND is_deleted != '1'
");
$salesTotalQuery->execute();
$grandTotalData = $salesTotalQuery->fetch();
$grandTotalSales = $grandTotalData['grand_total'] ?? 0;

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>
<!DOCTYPE html>
<html>
<head>
    <title>Combined Sales Report</title>
    <link rel="shortcut icon" href="<?php echo WEB_ROOT; ?>images/favicon.png">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #1a1a1a;
            margin: 20px;
            	margin: 0 20% 0 20%;
        }

        .report-header {
            text-align: center;
            margin-bottom: 18px;
            border-bottom: 3px solid #000;
            padding-bottom: 14px;
        }

        .report-header img {
            height: 90px;
            width: auto;
            object-fit: contain;
            margin-bottom: 8px;
        }

        .report-header h2 {
            margin: 0 0 4px 0;
            font-size: 20px;
            letter-spacing: 0.5px;
        }

        .report-header h4 {
            margin: 2px 0;
            font-size: 13px;
            font-weight: normal;
            color: #444;
        }

        .item-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
            table-layout: fixed;
        }

        .item-table th {
            background: #1a1a1a;
            color: #fff;
            text-align: left;
            font-size: 11.5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 8px 10px;
            border: 1px solid #1a1a1a;
        }

        .item-table th.num,
        .item-table td.num {
            text-align: right;
        }

        .item-table td {
            padding: 7px 10px;
            border: 1px solid #e2e2e2;
            vertical-align: top;
        }

        .item-table tbody tr:nth-child(even) {
            background: #f7f8fa;
        }

        .col-customer { width: 24%; }
        .col-product  { width: 24%; }
        .col-serial   { width: 18%; }
        .col-qty      { width: 12%; }
        .col-price    { width: 11%; }
        .col-total    { width: 11%; }

        .no-items td {
            text-align: center;
            color: #999;
            font-style: italic;
            padding: 16px;
        }

        .total-row td {
            border: none;
            border-top: 3px double #000;
            font-weight: bold;
            font-size: 14px;
            padding-top: 12px;
        }
    </style>
</head>

<body>

    <div class="report-header">
        <img src="<?php echo WEB_ROOT; ?>images/branch_logo/main.png" alt="logo">
        <h2>Daily Sales Report</h2>
        <h4><?php echo $branchname; ?></h4>
        <h4><?php echo $wfrom; ?></h4>
        <h4>Terra Plaza, Cor. Rizal - Gatuslao Sts., Bacolod City</h4>
    </div>

    <table class="item-table">
        <colgroup>
            <col class="col-customer">
            <col class="col-product">
            <col class="col-serial">
            <col class="col-qty">
            <col class="col-price">
            <col class="col-total">
        </colgroup>
        <thead>
            <tr>
                <th>Customer Name</th>
                <th>Product Name</th>
                <th>Serial #</th>
                <th class="num">Qty Sold</th>
                <th class="num">Unit Price</th>
                <th class="num">Total Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (empty($topItems)) {
            ?>
                <tr class="no-items">
                    <td colspan="6">No items found for the selected period</td>
                </tr>
            <?php
            } else {
                $itemsTotal = 0;
                foreach ($topItems as $item) {
                    $itemsTotal += $item['total_amount'];
            ?>
                <tr>
                    <td><?php echo $item['customer_name']; ?></td>
                    <td><?php echo $item['pd_name']; ?></td>
                    <td><?php echo $item['pd_barcode']; ?></td>
                    <td class="num"><?php echo number_format($item['od_qty'], 0); ?></td>
                    <td class="num">&#x20B1;<?php echo number_format($item['od_price'], 2); ?></td>
                    <td class="num">&#x20B1;<?php echo number_format($item['total_amount'], 2); ?></td>
                </tr>
            <?php
                }
            ?>
                <tr class="total-row">
                    <td colspan="5" class="num">Total Items</td>
                    <td class="num">&#x20B1;<?php echo number_format($itemsTotal, 2); ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

</body>
</html>