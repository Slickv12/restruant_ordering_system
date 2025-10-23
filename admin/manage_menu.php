<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../auth/login.php");
    exit();
}

include '../includes/db_connect.php';

// Handle adding a menu item
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_menu"])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $query = "INSERT INTO menu_items (name, price, description) VALUES ('$name', '$price', '$description')";
    if (mysqli_query($conn, $query)) {
        $message = "Menu item added successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

// Handle deleting a menu item
if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete']);
    $delete_query = "DELETE FROM menu_items WHERE id='$id'";
    if (mysqli_query($conn, $delete_query)) {
        header("Location: manage_menu.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Menu</title>
    <link rel="stylesheet" href="../assets/css/manage_menu.css">
</head>
<body>
    <div class="menu-container">
        <div class="top-bar">
            <h2>Manage Menu</h2>
            <a href="dashboard.php" class="dashboard-btn">Go to Dashboard</a>
        </div>

        <!-- Add Menu Form -->
        <div class="add-menu-form">
            <h3>Add New Menu Item</h3>
            <form method="POST">
                <input type="text" name="name" placeholder="Item Name" required>
                <input type="number" step="0.01" name="price" placeholder="Price" required>
                <textarea name="description" placeholder="Description" required></textarea>
                <button type="submit" name="add_menu">Add Item</button>
            </form>
            <?php if (isset($message)) echo "<p class='message'>$message</p>"; ?>
        </div>

        <!-- Menu List Table -->
        <div class="menu-list">
            <h3>Menu Items</h3>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
                <?php
                $result = mysqli_query($conn, "SELECT * FROM menu_items");
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['price']}</td>
                            <td>{$row['description']}</td>
                            <td>
                                <a href='edit_menu.php?id={$row['id']}' class='edit-btn'>Edit</a>
                                <a href='manage_menu.php?delete={$row['id']}' class='delete-btn' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                            </td>
                          </tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
