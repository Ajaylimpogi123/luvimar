<?php
// api.php - Semaphore SMS sending function

function sendSMS($number)
{
    $api_key = "3cac952de7730673782359f51d713d15"; // Your Semaphore API key
    $sender_name = "Luvimar"; // Sender name

    $ch = curl_init();
    $parameters = array(
        'apikey' => $api_key,
        'number' => $number,
        'message' => 'Dear Valued Customer,
Your fire extinguisher will expire soon, Please take the necessary steps to have it inspected, refilled, or replaced before the expiration date to ensure it remains effective in case of an emergency. Thank you for your continued trust and support.',
        'sendername' => $sender_name
    );

     curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
 
    $output = curl_exec($ch);
    if (curl_errno($ch)) {
        error_log('Semaphore SMS error: ' . curl_error($ch));
    }
    curl_close($ch);
 
    return $output;
}
