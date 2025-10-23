<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../auth/login.php");
    exit();
}

include '../includes/db_connect.php';

// Check if an ID is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: manage_menu.php");
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

// Fetch existing menu item data
$result = mysqli_query($conn, "SELECT * FROM menu_items WHERE id='$id'");
if (mysqli_num_rows($result) == 0) {
    header("Location: manage_menu.php");
    exit();
}
$row = mysqli_fetch_assoc($result);

// Handle update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $update_query = "UPDATE menu_items SET name='$name', price='$price', description='$description' WHERE id='$id'";
    
    if (mysqli_query($conn, $update_query)) {
        $message = "Menu item updated successfully!";
        header("Location: manage_menu.php");
        exit();
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu Item</title>
    <link rel="stylesheet" href="../assets/css/edit_menu.css">
</head>
<body>
    <div class="edit-menu-container">
        <h2>Edit Menu Item</h2>

        <form method="POST">
            <label for="name">Item Name:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($row['name']) ?>" required>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" value="<?= htmlspecialchars($row['price']) ?>" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?= htmlspecialchars($row['description']) ?></textarea>

            <button type="submit">Update Item</button>
            <a href="manage_menu.php" class="back-btn">Cancel</a>
        </form>

        <?php if (isset($message)) echo "<p class='message'>$message</p>"; ?>
    </div>
</body>
</html>
