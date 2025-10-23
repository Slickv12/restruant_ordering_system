<?php
require_once '../includes/db_connect.php';

if (isset($_GET['id'])) {
    $table_id = intval($_GET['id']); // Convert to integer for security

    // Prepare delete statement
    $sql = "DELETE FROM tables WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $table_id);

    if ($stmt->execute()) {
        header("Location: manage_tables.php?success=Table deleted successfully!");
        exit();
    } else {
        header("Location: manage_tables.php?error=Failed to delete table.");
        exit();
    }
} else {
    header("Location: manage_tables.php");
    exit();
}
?>
