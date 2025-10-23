<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../auth/login.php");
    exit();
}

include '../includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["order_id"], $_POST["status"])) {
    $order_id = $_POST["order_id"];
    $status = $_POST["status"];

    $query = "UPDATE orders SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $status, $order_id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Order status updated!";
    } else {
        $_SESSION['message'] = "Error updating order!";
    }

    $stmt->close();
    $conn->close();
}

header("Location: manage_orders.php");
exit();
?>
