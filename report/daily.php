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


if ($branch == "db_gleamz_main") {
    $branchname = "Terra Plaza, Cor. Rizal - Gatualas Sts., Bacolod City
";
    $img = "logo.png";
} else {
    $branchname = "Bacolod Branch";
    $img = "main.png";
}

if ($stype == 0) {
    $typ_state = "";
} else if ($stype == 'Cash') {
    $typ_state = "AND payment_mode = 'Cash'";
} else {
    $typ_state = "AND payment_mode = 'Gcash'";
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


// Query to get top purchased items for the day
$topItemsQuery = $conn->prepare("
    SELECT p.pd_name, SUM(i.od_qty) as total_qty, SUM(i.od_qty * i.od_price) as total_amount
    FROM $branch.tbl_order_item i
    JOIN $branch.tbl_product p ON i.pd_id = p.pd_id
    JOIN $branch.tbl_order o ON i.od_id = o.od_id
    WHERE o.$oddate BETWEEN '$from' AND '$to' AND o.is_deleted != '1'
    GROUP BY p.pd_name
    ORDER BY total_qty DESC
    LIMIT 10
");
$topItemsQuery->execute();
$topItems = $topItemsQuery->fetchAll(PDO::FETCH_ASSOC);

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>

<head>
    <title>Combined Sales Report</title>
    <link rel="shortcut icon" href="<?php echo WEB_ROOT; ?>images/favicon.png">
    <style rel="stylesheet">
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .report-title {
            font-size: 18px;
            font-weight: bold;
        }

        .report-period {
            font-size: 16px;
        }

        .report-address {
            font-size: 14px;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .main-table th {
            background-color: #f2f2f2;
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .main-table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        .section-header {
            background-color: #e6e6e6;
            font-weight: bold;
        }

        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="<?php echo WEB_ROOT; ?>images /branch_logo/main.png" style="height: 150px; width:250px;" />
        <div class="report-title">Daily Sales Report</div>
        <h4><?php echo $wfrom; ?></h4>
        <div class="report-address">3KC convenience store door 4, Carmela arcade, lasalle Ave., Bgry 5, Bacolod City. Philippines 6100.</div>
    </div>

    <table class="main-table">
        <!-- Top Purchased Items Section -->
        <tr class="section-header">
            <th colspan="6">Top Purchased Items</th>
        </tr>
        <tr>
            <th width="5%">Rank</th>
            <th width="35%">Product Name</th>
            <th width="15%">Quantity Sold</th>
            <th width="15%">Unit Price</th>
            <th width="15%">Total Amount</th>

        </tr>
        <?php
        $rank = 1;
        $grandTotalSales = 0;
        $topItemsTotal = 0;

        // First calculate grand total sales for percentage calculation
        $salesTotalQuery = $conn->prepare("
            SELECT SUM(od_total_amt_due) as grand_total 
            FROM $branch.tbl_order
            WHERE ($oddate BETWEEN '$from' and '$to') $typ_state $rmk_state AND is_deleted != '1'
        ");
        $salesTotalQuery->execute();
        $grandTotalData = $salesTotalQuery->fetch();
        $grandTotalSales = $grandTotalData['grand_total'] ?? 0;

        foreach ($topItems as $item) {
            $percentage = $grandTotalSales > 0 ? ($item['total_amount'] / $grandTotalSales) * 100 : 0;
            $topItemsTotal += $item['total_amount'];

            // Get the unit price (assuming same price for all sales of this item)
            $priceQuery = $conn->prepare("
                SELECT od_price FROM $branch.tbl_order_item i
                JOIN $branch.tbl_product p ON i.pd_id = p.pd_id
                JOIN $branch.tbl_order o ON i.od_id = o.od_id
                WHERE p.pd_name = ? AND o.$oddate BETWEEN '$from' AND '$to' AND o.is_deleted != '1'
                LIMIT 1
            ");
            $priceQuery->execute([$item['pd_name']]);
            $priceData = $priceQuery->fetch();
            $unitPrice = $priceData['od_price'] ?? 0;
        ?>
            <tr>
                <td class="text-center"><?php echo $rank; ?></td>
                <td><?php echo $item['pd_name']; ?></td>
                <td class="text-right"><?php echo number_format($item['total_qty'], 0); ?></td>
                <td class="text-right">&#x20B1;<?php echo number_format($unitPrice, 2); ?></td>
                <td class="text-right">&#x20B1;<?php echo number_format($item['total_amount'], 2); ?></td>

            </tr>
        <?php
            $rank++;
        }

        if (empty($topItems)) {
            echo '<tr><td colspan="6" class="text-center">No top items found for the selected period</td></tr>';
        } else {
            $otherItemsTotal = $grandTotalSales - $topItemsTotal;
            $otherPercentage = $grandTotalSales > 0 ? ($otherItemsTotal / $grandTotalSales) * 100 : 0;
        ?>
            <tr class="total-row">
                <td colspan="4">Total (Top Items)</td>
                <td class="text-right">&#x20B1;<?php echo number_format($topItemsTotal, 2); ?></td>

            </tr>

        <?php
        }
        ?>


</body>