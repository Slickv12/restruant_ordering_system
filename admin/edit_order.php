<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../auth/login.php");
    exit();
}

include '../includes/db_connect.php';

// Check if order ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: manage_orders.php");
    exit();
}

$order_id = $_GET['id'];

// Fetch order details
$query = "SELECT * FROM orders WHERE id = '$order_id'";
$result = mysqli_query($conn, $query);
$order = mysqli_fetch_assoc($result);

// Update order status
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_status = $_POST['status'];
    $update_query = "UPDATE orders SET status = '$new_status' WHERE id = '$order_id'";
    if (mysqli_query($conn, $update_query)) {
        header("Location: manage_orders.php");
        exit();
    } else {
        $error = "Failed to update order: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    <link rel="stylesheet" href="../assets/css/edit_order.css">
</head>
<body>
    <div class="edit-container">
        <h2>Edit Order</h2>

        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <form method="POST">
            <label>Order ID:</label>
            <input type="text" value="<?= $order['id']; ?>" disabled>

            <label>Total Price:</label>
            <input type="text" value="₹<?= $order['total_price']; ?>" disabled>

            <label>Status:</label>
            <select name="status" required>
                <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                <option value="confirmed" <?= $order['status'] == 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                <option value="delivered" <?= $order['status'] == 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                <option value="cancelled" <?= $order['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
            </select>

            <button type="submit">Update Order</button>
            <a href="manage_orders.php" class="back-btn">Cancel</a>
        </form>
    </div>
</body>
</html>
