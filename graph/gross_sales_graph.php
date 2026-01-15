<?php
require_once 'global-library/config.php';
require_once 'global-library/functions.php';

checkUser();

$gpt = "bar";

// Get filter values from dropdowns
$filter = $_GET['filter'] ?? '';
$month_filter = $_GET['month_filter'] ?? '';
$year_filter = $_GET['year_filter'] ?? date('Y'); // Default to current year

if (!$con) {
    echo "Problem in database connection! Contact administrator!" . mysqli_error($con);
} else {

    // Base SQL
    $sql = "SELECT * FROM tr_graph_gross_current WHERE 1=1";

    // Apply filter conditions
    if ($filter == "day") {
        $sql .= " AND DATE(od_date) = CURDATE()";
    } elseif ($filter == "week") {
        $sql .= " AND YEARWEEK(od_date, 1) = YEARWEEK(CURDATE(), 1)";
    } elseif ($filter == "month") {
        $sql .= " AND YEAR(od_date) = YEAR(CURDATE()) 
                  AND MONTH(od_date) = MONTH(CURDATE())";
    } elseif ($filter == "specific_month" && $month_filter && $year_filter) {
        $sql .= " AND YEAR(od_date) = " . intval($year_filter) .
            " AND MONTH(od_date) = " . intval($month_filter);
    }

    $sql .= " ORDER BY od_date";

    $result = mysqli_query($con, $sql);

    $productname = [];
    $sales = [];

    while ($row = mysqli_fetch_array($result)) {
        $productname[] = $row['date_name'];
        $sales[] = $row['total_sales'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graphical Sales Report</title>
    <link rel="shortcut icon" href="<?php echo WEB_ROOT; ?>images/favicon.ico">
</head>

<body>

    <!-- Filter Dropdown -->
    <form method="GET" style="text-align:center; margin-bottom: 20px;">
        <label for="filter">Filter by:</label>
        <select name="filter" id="filter" onchange="this.form.submit()">
            <option value="" <?php if ($filter == '') echo 'selected'; ?>>All</option>
            <option value="day" <?php if ($filter == 'day') echo 'selected'; ?>>Today</option>
            <option value="week" <?php if ($filter == 'week') echo 'selected'; ?>>This Week</option>
            <option value="month" <?php if ($filter == 'month') echo 'selected'; ?>>This Month</option>
            <option value="specific_month" <?php if ($filter == 'specific_month') echo 'selected'; ?>>Specific Month</option>
        </select>

        <?php if ($filter == 'specific_month'): ?>
            <label for="month_filter">Month:</label>
            <select name="month_filter" id="month_filter" onchange="this.form.submit()">
                <?php
                for ($m = 1; $m <= 12; $m++) {
                    $monthName = date('F', mktime(0, 0, 0, $m, 10));
                    echo "<option value='$m'" . ($month_filter == $m ? ' selected' : '') . ">$monthName</option>";
                }
                ?>
            </select>

            <label for="year_filter">Year:</label>
            <select name="year_filter" id="year_filter" onchange="this.form.submit()">
                <?php
                $currentYear = date('Y');
                for ($y = $currentYear; $y >= $currentYear - 5; $y--) {
                    echo "<option value='$y'" . ($year_filter == $y ? ' selected' : '') . ">$y</option>";
                }
                ?>
            </select>
        <?php endif; ?>
    </form>

    <!-- Chart -->
    <div style="width:100%;height:20%;text-align:center">
        <canvas id="chartjs_bar_gross"></canvas>
    </div>

    <script src="graph/jquery.js"></script>
    <script src="graph/Chart.min.js"></script>
    <script type="text/javascript">
        var ctx = document.getElementById("chartjs_bar_gross").getContext('2d');
        var myChart = new Chart(ctx, {
            type: '<?php echo $gpt; ?>',
            data: {
                labels: <?php echo json_encode($productname); ?>,
                datasets: [{
                    backgroundColor: [
                        "#5969ff",
                        "#ff407b",
                        "#25d5f2",
                        "#ffc750",
                        "#2ec551",
                        "#7040fa",
                        "#ff004e"
                    ],
                    data: <?php echo json_encode($sales); ?>,
                }]
            },
            options: {
                legend: {
                    display: false,
                    position: 'bottom',
                    labels: {
                        fontColor: '#71748d',
                        fontFamily: 'Circular Std Book',
                        fontSize: 14,
                    }
                }
            }
        });
    </script>
</body>

</html>