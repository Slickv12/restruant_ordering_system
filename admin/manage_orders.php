<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../auth/login.php");
    exit();
}

include '../includes/db_connect.php';
include '../includes/sms_api.php';

// Handle Delete Order
if (isset($_GET['delete'])) {
    $order_id = $_GET['delete'];

    // First, delete order items
    $delete_items_query = "DELETE FROM order_items WHERE order_id = '$order_id'";
    mysqli_query($conn, $delete_items_query);

    // Then delete order
    $delete_order_query = "DELETE FROM orders WHERE id = '$order_id'";
    if (mysqli_query($conn, $delete_order_query)) {
        $_SESSION['message'] = "Order deleted successfully!";
    } else {
        $_SESSION['message'] = "Error deleting order: " . mysqli_error($conn);
    }

    header("Location: manage_orders.php");
    exit();
}

// Handle Order Status Update
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['order_status'];

    $update_status_query = "UPDATE orders SET status='$new_status' WHERE id='$order_id'";
    if (mysqli_query($conn, $update_status_query)) {
        // Fetch user's phone number
        $user_query = "SELECT u.phone FROM users u JOIN orders o ON u.id = o.user_id WHERE o.id = '$order_id'";
        $user_result = mysqli_query($conn, $user_query);
        $user_data = mysqli_fetch_assoc($user_result);

        if ($user_data) {
            $phone_number = $user_data['phone'];
            $message = "Your order #$order_id status has been updated to: " . ucfirst($new_status);
            send_sms($phone_number, $message);
        }

        $_SESSION['message'] = "Order status updated successfully!";
    } else {
        $_SESSION['message'] = "Error updating status: " . mysqli_error($conn);
    }

    header("Location: manage_orders.php");
    exit();
}

// Fetch Orders
$query = "SELECT o.id, o.user_id, o.total_price, o.status, o.created_at, u.name, u.phone
          FROM orders o 
          JOIN users u ON o.user_id = u.id
          ORDER BY o.created_at DESC";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <link rel="stylesheet" href="../assets/css/manage_orders.css">
</head>
<body>
    <div class="orders-container">
        <div class="top-bar">
            <h2>Manage Orders</h2>
            <a href="dashboard.php" class="dashboard-btn">Go to Dashboard</a>
        </div>

        <!-- Display Success or Error Message -->
        <?php if (isset($_SESSION['message'])): ?>
            <p class="message"><?= $_SESSION['message']; unset($_SESSION['message']); ?></p>
        <?php endif; ?>

        <div class="orders-table">
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Phone</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Items</th>
                    <th>Actions</th>
                </tr>
                
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td class="order-id"><?= $row['id']; ?></td>
                        <td><?= $row['name']; ?></td>
                        <td><?= $row['phone']; ?></td>
                        <td class="order-price">₹<?= $row['total_price']; ?></td>
                        <td>
                            <form method="post" action="manage_orders.php">
                                <input type="hidden" name="order_id" value="<?= $row['id']; ?>">
                                <select name="order_status" onchange="this.form.submit()">
                                    <option value="pending" <?= $row['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="confirmed" <?= $row['status'] == 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                    <option value="delivered" <?= $row['status'] == 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                                    <option value="cancelled" <?= $row['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                </select>
                                <input type="hidden" name="update_status" value="1">
                            </form>
                        </td>
                        <td>
                            <?php
                            // Fetch Order Items
                            $order_id = $row['id'];
                            $item_query = "SELECT mi.name, oi.quantity 
                                           FROM order_items oi 
                                           JOIN menu_items mi ON oi.menu_item_id = mi.id
                                           WHERE oi.order_id = '$order_id'";
                            
                            $item_result = mysqli_query($conn, $item_query);
                            while ($item = mysqli_fetch_assoc($item_result)) {
                                echo "{$item['quantity']}x {$item['name']} <br>";
                            }
                            ?>
                        </td>
                        <td>
                            <a href="edit_order.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                            <a href="manage_orders.php?delete=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this order?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>
