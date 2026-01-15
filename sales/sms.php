
<?php

// Add expiration

// Always use __DIR__ so paths work in both browser and CLI
require_once __DIR__ . '/../global-library/api.php';
require_once __DIR__ . '/../global-library/database.php';  // <-- add this


$sms = $conn->prepare("SELECT * FROM tbl_sms WHERE status != 'sent'");
$sms->execute();
$sms_data = $sms->fetchAll();

// Current datetime with time
$now = date("Y-m-d H:i:s");

foreach ($sms_data as $sms) {
    $custid = $sms['cust_id'];
    $expiration = $sms['exp_date'];


    // Get expiration data directly using $custid and $pdId
    $exp = $conn->prepare("SELECT * FROM bs_customer WHERE cust_id = '$custid'");
    $exp->execute();
    $exp_data = $exp->fetchAll();

    foreach ($exp_data as $exp) {


        if (empty($expiration)) {
            echo "Theres no sms";
            continue; // skip if no expiration date
        } else {
            $date_expired = date("F j, Y", strtotime($expiration));

            $customer  = $exp['client_name'];
            $contactNo = $exp['contactno'];


            // Reminder datetime (2 minutes before expiration for testing)
            $reminder_datetime = date("Y-m-d H:i:s", strtotime($expiration . ' -2 minutes'));

            if ($now >= $reminder_datetime && $now < $expiration) {
                $message = "Good day Sir/Ms $customer, your Product will expire on $date_expired. Please renew on our FB page or contact 09XXXXXXXX";
                $response = sendSMS($contactNo, $message);
                echo "SMS sent to $customer: $response<br>";

                // Update SMS status to avoid duplicates
                $update = $conn->prepare("UPDATE tbl_sms SET status = 'sent' WHERE cust_id = '$custid'");
                $update->execute();
            } else {
                echo "No SMS for $customer. Reminder date: $reminder_datetime<br>";
            }
        }
    }
}

$url = "../index.php";
echo "<meta http-equiv=\"refresh\" content=\"2;URL=$url\">";
