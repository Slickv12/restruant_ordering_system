<?php
require_once __DIR__ . '/includes/db_connect.php';
require_once __DIR__ . '/includes/sms_api.php';

// Fetch latest order (or specify an order ID manually)
$order_id = 1; // Change this to a specific order ID if needed

$query = "SELECT o.id, u.phone, u.name, o.status 
          FROM orders o 
          JOIN users u ON o.user_id = u.id 
          WHERE o.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order) {
    die("Order not found.");
}

// Extract details
$phone = $order['phone'];
$name = $order['name'];
$status = strtoupper($order['status']); // Convert to uppercase for clarity

// Format SMS message
$message = "Hello $name, your order #$order_id is now $status. Thank you for ordering with us!";

// Send SMS
if (send_sms($phone, $message)) {
    echo "SMS sent successfully to $phone!";
} else {
    echo "Failed to send SMS.";
}
?>
