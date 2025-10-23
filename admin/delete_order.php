<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../auth/login.php");
    exit();
}

include '../includes/db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM orders WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Order deleted successfully!";
    } else {
        $_SESSION['message'] = "Error deleting order!";
    }

    $stmt->close();
    $conn->close();
}

header("Location: manage_orders.php");
exit();
?>
