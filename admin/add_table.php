<?php
require_once '../includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $table_number = $_POST['table_number'];
    $capacity = $_POST['capacity'];
    $status = isset($_POST['status']) ? $_POST['status'] : 'Available';  // Default to 'Available'

    // Validate the status input
    if (!in_array($status, ["Available", "Reserved", "Occupied"])) {
        die("Invalid status value.");
    }

    $sql = "INSERT INTO tables (table_number, capacity, status) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sis", $table_number, $capacity, $status);

    if ($stmt->execute()) {
        header("Location: manage_tables.php?success=Table added successfully!");
        exit();
    } else {
        $error = "Failed to add table.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Table</title>
    <link rel="stylesheet" href="../assets/css/add_table.css">
</head>
<body>

<div class="container">
    <h2>Add New Table</h2>

    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>

    <form method="post" action="">
        <label>Table Number:</label>
        <input type="text" name="table_number" required>

        <label>Capacity:</label>
        <input type="number" name="capacity" min="1" required>

        <label>Status:</label>
        <select name="status">
            <option value="Available">Available</option>
            <option value="Reserved">Reserved</option>
            <option value="Occupied">Occupied</option>
        </select>

        <button type="submit">Add Table</button>
    </form>

    <a href="manage_tables.php" class="back-btn">Back to Manage Tables</a>
</div>

</body>
</html>
