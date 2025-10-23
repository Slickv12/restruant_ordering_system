<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/admin_dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="manage_menu.php">Manage Menu</a></li>
                <li><a href="manage_orders.php">Manage Orders</a></li>
                <li><a href="manage_tables.php">Manage Tables</a></li>
                <li><a href="manage_users.php">Manage Users</a></li>
                <li><a href="manage_payments.php">Manage Payments</a></li>
                <li><a href="reports.php">Reports</a></li>
                 <li><a href="../auth/logout.php">Logout</a></li>
            </ul>
        </div>

        <div class="main-content">
            <h1>Welcome, Admin</h1>
            <p>Manage the restaurant system efficiently.</p>
            <div class="dashboard-cards">
                <div class="card">
                    <h3>Menu Items</h3>
                    <p>View & edit menu</p>
                    <a href="manage_menu.php" class="btn">Go</a>
                </div>
                <div class="card">
                    <h3>Orders</h3>
                    <p>Manage customer orders</p>
                    <a href="manage_orders.php" class="btn">Go</a>
                </div>
                <div class="card">
                    <h3>Reservations</h3>
                    <p>Manage table bookings</p>
                    <a href="manage_tables.php" class="btn">Go</a>
                </div>
                <div class="card">
                    <h3>Users</h3>
                    <p>View registered users</p>
                    <a href="manage_users.php" class="btn">Go</a>
                </div>
                <div class="card">
                    <h3>Payments</h3>
                    <p>Manage transactions</p>
                    <a href="manage_payments.php" class="btn">Go</a>
                </div>
                <div class="card">
                    <h3>Reports</h3>
                    <p>View business insights</p>
                    <a href="reports.php" class="btn">Go</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
