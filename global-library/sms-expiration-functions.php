<?php
// global-library/sms-expiration-functions.php
require_once 'config.php';
require_once 'api.php';
/**
 * Checks for products expiring within the next 2 months, sends SMS
 * reminders to the customers who ordered them, and logs each attempt
 * in tbl_sms. Skips anything already marked 'sent'.
 *
 * @param PDO $conn
 * @return array Summary: ['checked' => int, 'sent' => int, 'failed' => int]
 */
function checkAndSendExpirationSMS($conn)
{
    include 'database.php';
    $summary = ['checked' => 0, 'sent' => 0, 'failed' => 0];

    $sql = $conn->prepare("
        SELECT p.pd_id, p.pd_name, p.pd_expiration, o.cust_id, c.contactno, c.customer_name
        FROM tbl_product p
        INNER JOIN tbl_order_item oi ON oi.pd_id = p.pd_id
        INNER JOIN tbl_order o ON o.od_id = oi.od_id
        INNER JOIN bs_customer c ON c.cust_id = o.cust_id
        WHERE p.pd_expiration IS NOT NULL
          AND p.pd_expiration <= DATE_ADD(CURDATE(), INTERVAL 2 MONTH)
          AND p.pd_expiration >= CURDATE()
    ");
    $sql->execute();

    while ($row = $sql->fetch()) {
        $summary['checked']++;

        $pd_id    = $row['pd_id'];
        $cust_id  = $row['cust_id'];
        $exp_date = $row['pd_expiration'];

        // Skip only if this product+customer+exp_date has already been marked 'sent'.
        $check = $conn->prepare("SELECT id_sms, status FROM tbl_sms WHERE pd_id = ? AND cust_id = ? AND exp_date = ?");
        $check->execute([$pd_id, $cust_id, $exp_date]);
        $existing = $check->fetch();

        if ($existing && $existing['status'] === 'sent') {
            continue;
        }

        $custName = $row['customer_name'] ?: 'Customer';
        $message  = "Hi {$custName}, your product {$row['pd_name']} will expire on "
                  . date("M d, Y", strtotime($exp_date)) . ". Please take note.";

        $result = sendSMS($row['contactno'], $message);
        $sentOk = $result !== false;

        $sentOk ? $summary['sent']++ : $summary['failed']++;

        if ($existing) {
            $update = $conn->prepare("UPDATE tbl_sms SET is_sent = ?, status = ? WHERE id_sms = ?");
            $update->execute([$sentOk ? 1 : 0, $sentOk ? 'sent' : 'failed', $existing['id_sms']]);
        } else {
            $insert = $conn->prepare("INSERT INTO tbl_sms (pd_id, cust_id, is_sent, status, exp_date) VALUES (?, ?, ?, ?, ?)");
            $insert->execute([$pd_id, $cust_id, $sentOk ? 1 : 0, $sentOk ? 'sent' : 'failed', $exp_date]);
        }
    }

    return $summary;
}