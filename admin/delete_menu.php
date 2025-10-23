<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../auth/login.php");
    exit();
}

include '../includes/db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete query
    $query = "DELETE FROM menu_items WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Menu item deleted successfully!";
    } else {
        $_SESSION['message'] = "Error deleting menu item!";
    }

    $stmt->close();
    $conn->close();

    // Redirect back to Manage Menu page
    header("Location: manage_menu.php");
    exit();
} else {
    $_SESSION['message'] = "Invalid menu item!";
    header("Location: manage_menu.php");
    exit();
}
?>
