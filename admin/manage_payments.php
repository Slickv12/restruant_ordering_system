<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../auth/login.php");
    exit();
}

include '../includes/db_connect.php';

// Fetch Payments
$query = "SELECT p.id, p.order_id, p.payment_status, p.transaction_id, p.amount, p.created_at, u.name 
          FROM payments p 
          JOIN users u ON p.user_id = u.id
          ORDER BY p.created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Payments</title>
    <link rel="stylesheet" href="../assets/css/manage_payments.css">
</head>
<body>
    <div class="payments-container">
        <div class="top-bar">
            <h2>Manage Payments</h2>
            <a href="dashboard.php" class="dashboard-btn">Go to Dashboard</a>
        </div>

        <table>
            <tr>
                <th>Payment ID</th>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Transaction ID</th>
                <th>Date</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['order_id']; ?></td>
                    <td><?= $row['name']; ?></td>
                    <td>₹<?= $row['amount']; ?></td>
                    <td class="<?= strtolower($row['payment_status']); ?>"><?= ucfirst($row['payment_status']); ?></td>
                    <td><?= $row['transaction_id']; ?></td>
                    <td><?= $row['created_at']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
