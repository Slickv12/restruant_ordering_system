<?php
require_once '../includes/db_connect.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid Table ID.");
}

$table_id = $_GET['id'];

// Fetch existing table data
$sql = "SELECT * FROM tables WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $table_id);
$stmt->execute();
$result = $stmt->get_result();
$table = $result->fetch_assoc();

if (!$table) {
    die("Table not found.");
}

// Update table data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $table_number = $_POST['table_number'];
    $capacity = $_POST['capacity'];
    $status = $_POST['status'];

    $update_sql = "UPDATE tables SET table_number = ?, capacity = ?, status = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sisi", $table_number, $capacity, $status, $table_id);

    if ($update_stmt->execute()) {
        header("Location: manage_tables.php?success=Table updated successfully!");
        exit();
    } else {
        $error = "Failed to update table.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Table</title>
<link rel="stylesheet" href="../assets/css/edit_table.css?v=<?php echo time(); ?>">
</head>
<body>

<div class="container">
    <h2>Edit Table</h2>

    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>

    <form method="post" action="">
        <label>Table Number:</label>
        <input type="text" name="table_number" value="<?= htmlspecialchars($table['table_number']) ?>" required>

        <label>Capacity:</label>
        <input type="number" name="capacity" value="<?= htmlspecialchars($table['capacity']) ?>" min="1" required>

        <label>Status:</label>
        <select name="status">
            <option value="Available" <?= ($table['status'] == 'Available') ? 'selected' : '' ?>>Available</option>
            <option value="Reserved" <?= ($table['status'] == 'Reserved') ? 'selected' : '' ?>>Reserved</option>
            <option value="Occupied" <?= ($table['status'] == 'Occupied') ? 'selected' : '' ?>>Occupied</option>
        </select>

        <button type="submit">Update Table</button>
    </form>

    <a href="manage_tables.php" class="back-btn">Back to Manage Tables</a>
</div>

</body>
</html>
