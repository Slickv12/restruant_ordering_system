<?php
include "../includes/db_connect.php"; // Database connection
include "../includes/sms_api.php";    // SMS function

// Sample order processing logic
$user_phone = "8180075339"; // Replace with actual user phone number from DB
$order_id = rand(10000, 99999); // Generate a random order ID
$message = "Your order #$order_id has been successfully placed! Thank you for ordering with us.";

// Send SMS
$response = sendSMS($user_phone, $message);
echo "SMS Sent: " . $response;  // Debugging output
?>
