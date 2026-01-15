<?php
// api.php - Semaphore SMS sending function

function sendSMS($number, $message)
{
    $api_key = "3cac952de7730673782359f51d713d15"; // Your Semaphore API key
    $sender_name = "Luvimar"; // Sender name

    $ch = curl_init();
    $parameters = array(
        'apikey' => $api_key,
        'number' => $number,
        'message' => $message,
        'sendername' => $sender_name
    );

    curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $output = curl_exec($ch);
    curl_close($ch);

    // return $output;
}
