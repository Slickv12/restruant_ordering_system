<?php
require_once '../includes/db_connect.php';

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']); // Convert to integer for security

    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        header("Location: manage_users.php?success=User deleted successfully!");
        exit();
    } else {
        header("Location: manage_users.php?error=Failed to delete user.");
        exit();
    }
} else {
    header("Location: manage_users.php");
    exit();
}
?>
