<?php
include 'includes/db_connect.php'; // Ensure database connection

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

// Fetch Payment Gateway Response
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST['order_id'];
    $payment_id = $_POST['razorpay_payment_id']; // Change this for PayPal/Stripe
    $amount = $_POST['amount']; // Ensure this matches the actual amount

    // Update Payment Status in Database
    $update_query = "UPDATE payments SET 
                    payment_status = 'Completed', 
                    transaction_id = '$payment_id' 
                    WHERE order_id = '$order_id'";

    if (mysqli_query($conn, $update_query)) {
        $_SESSION['message'] = "Payment Successful!";
    } else {
        $_SESSION['message'] = "Error updating payment: " . mysqli_error($conn);
    }
}

// Redirect to a payment confirmation page
header("Location: payment_confirmation.php");
exit();
?>
