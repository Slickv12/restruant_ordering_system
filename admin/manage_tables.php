<?php
require_once '../includes/db_connect.php';

$result = $conn->query("SELECT * FROM tables");

if (!$result) {
    die("Error fetching data: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Tables</title>
    <link rel="stylesheet" href="../assets/css/manage_tables.css">
</head>
<body>

<div class="container">
    <h2>Manage Tables</h2>

    <a href="add_table.php" class="add-btn">Add New Table</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Table Number</th>
                <th>Capacity</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['table_number']) ?></td>
                    <td><?= htmlspecialchars($row['capacity']) ?></td>
                    <td>
                        <?php 
                        if ($row['status'] === "Available") {
                            echo "<span style='color: green;'>Available</span>";
                        } elseif ($row['status'] === "Reserved") {
                            echo "<span style='color: orange;'>Reserved</span>";
                        } elseif ($row['status'] === "Occupied") {
                            echo "<span style='color: red;'>Occupied</span>";
                        } else {
                            echo "<span style='color: gray;'>Unknown</span>";
                        }
                        ?>
                    </td>
                    <td>
                        <a href="edit_table.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                        <a href="delete_table.php?id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="dashboard.php" class="dashboard-btn">Go to Dashboard</a>
</div>

</body>
</html>
