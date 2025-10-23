<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Twilio\Rest\Client;

/**
 * Function to send SMS using Twilio API
 * 
 * @param string $to Recipient's phone number (must include country code, e.g., +919876543210)
 * @param string $message The SMS message body
 * @return bool Returns true if SMS is sent successfully, otherwise false
 */
function send_sms($to, $message) {
    // Twilio API credentials from config.php
    $sid    = "AC93bb340470ff8ec7a01d6293272176bc";
    $token  = "1a37bb785caca045aaa777c4c03abd56";
    $twilio = new Client($sid, $token);

    try {
        // Validate phone number format
        if (!preg_match('/^\+\d{10,15}$/', $to)) {
            error_log("Invalid phone number format: $to");
            return false;
        }

        // Send SMS via Twilio
        $twilio->messages->create($to, [
            'from' => TWILIO_PHONE_NUMBER,
            'body' => $message
        ]);

        error_log("SMS sent successfully to $to");
        return true;
    } catch (Exception $e) {
        error_log("SMS sending failed: " . $e->getMessage());
        return false;
    }
}

/**
 * Send order confirmation SMS to the customer
 * 
 * @param int $order_id The order ID
 * @return void
 */
function send_order_confirmation_sms($order_id) {
    global $conn;

    // Fetch order details
    $query = "SELECT o.id, u.phone, u.name, o.total_price 
              FROM orders o 
              JOIN users u ON o.user_id = u.id 
              WHERE o.id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();

    if (!$order) {
        error_log("Order not found: ID $order_id");
        return;
    }

    // Format SMS message
    $phone = $order['phone'];
    $name = $order['name'];
    $total_price = $order['total_price'];
    $message = "Hello $name, your order #$order_id has been confirmed. Total: ₹$total_price. Thank you for ordering with us!";

    // Send SMS
    send_sms($phone, $message);
}
?>
