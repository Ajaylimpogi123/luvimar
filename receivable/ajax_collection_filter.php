<?php
/**
 * ajax_collection_filter.php
 *
 * Called via $.ajax() from list_collection.php every time a filter changes.
 * Outputs ONLY the <tr> rows (HTML) — JS drops that straight into #collectionTableBody.
 *
 * This file is hit DIRECTLY by AJAX, so it does NOT go through your normal
 * index.php?view=... router. That means it has to set up its own session and
 * DB connection below — it can't rely on $conn already existing.
 */


// ============================================================================
// ONLY LINE YOU NEED TO CHANGE:
// Point this at whatever file in your project creates the PDO connection as
// $conn (the same one list_collection.php uses). Paste me that file and I'll
// fill this in exactly for you.
// ============================================================================
require_once '../global-library/config.php';
header('Content-Type: text/html; charset=utf-8');



date_default_timezone_set("Asia/Manila");

$dfrom  = isset($_POST['from'])   ? trim($_POST['from'])   : '';
$dto    = isset($_POST['to'])     ? trim($_POST['to'])     : '';
$cust   = isset($_POST['cust'])   ? trim($_POST['cust'])   : '';
$status = isset($_POST['status']) ? trim($_POST['status']) : ''; // '', 'paid', 'unpaid'

// ---- Build the WHERE clause with bound parameters (safe from SQL injection) ----
$where  = ["is_deleted != '1'", "payment_mode = 'collection'"];
$params = [];

if (!empty($dfrom) && !empty($dto)) {
    $where[] = "od_date_1 BETWEEN :dfrom AND :dto"; // kept as od_date_1 to match your original filter field
    $params[':dfrom'] = date("Y-m-d", strtotime($dfrom));
    $params[':dto']   = date("Y-m-d", strtotime($dto));
}

if (!empty($cust)) {
    $where[] = "cust_id = :cust";
    $params[':cust'] = $cust;
}

if ($status === 'paid') {
    $where[] = "is_paid > 0";
} elseif ($status === 'unpaid') {
    $where[] = "(is_paid = 0 OR is_paid IS NULL)";
}

$whereClause = implode(' AND ', $where);

// ---- Logged-in user (needed for the "view" button access check) ----
$userId = $_SESSION['user_id'];
$user = $conn->prepare("SELECT * FROM bs_user WHERE user_id = :uid");
$user->execute([':uid' => $userId]);
$user_data = $user->fetch();

// ---- Filtered query ----
$sql = $conn->prepare("SELECT * FROM tbl_order WHERE $whereClause ORDER BY od_date DESC");
$sql->execute($params);

// ---- Render rows (same markup as the initial page load) ----
if ($sql->rowCount() > 0) {
    while ($sql_data = $sql->fetch()) {
        $cname     = ucwords(strtolower($sql_data['customer_name']));
        $orderdate = date("M d, Y | h:i a", strtotime($sql_data['od_date']));
        $datedue   = date("M d, Y", strtotime($sql_data['date_due']));
        ?>
        <tr>
            <td><?php echo htmlspecialchars($sql_data['ref_num']); ?></td>
            <td><?php echo htmlspecialchars($cname); ?></td>
            <td><?php echo htmlspecialchars($sql_data['payment_mode']); ?></td>
            <td>&#x20B1; <?php echo number_format($sql_data['od_total_amt_due'], 2); ?></td>
            <td>
                <span style="
                    display:inline-block;
                    padding:6px 14px;
                    border-radius:20px;
                    font-size:13px;
                    font-weight:600;
                    color:#fff;
                    background: <?= $sql_data['is_paid'] > 0 ? '#28a745' : '#dc3545' ?>;
                "><?php echo ucfirst($sql_data['is_paid'] > 0 ? 'Paid' : 'Unpaid'); ?></span>
            </td>
            <td><?php echo $orderdate; ?></td>
            <td><?php echo $datedue; ?></td>
            <td class="center">
                <?php if ($user_data['is_sale_v_access'] == 1) { ?>
                    <a class="btn btn-primary" href="javascript:detail(<?php echo $sql_data['od_id']; ?>);">
                        <i class="icon-edit icon-white icon-eye-open"></i>
                        view
                    </a>
                <?php } else { echo "-- --"; } ?>
            </td>
        </tr>
        <?php
    }
} else {
    ?>
    <tr>
        <td colspan="8" class="center">No records found.</td>
    </tr>
    <?php
}