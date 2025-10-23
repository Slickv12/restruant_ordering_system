<?php
include '../includes/db_connect.php';

$query = "
    SELECT 
        o.id AS order_id,
        u.name AS name,
        o.total_price AS total_amount, 
        p.payment_status, 
        o.status AS order_status, 
        o.created_at AS order_date 
    FROM orders o
    JOIN users u ON o.user_id = u.id
    LEFT JOIN payments p ON o.id = p.order_id
    ORDER BY o.created_at DESC;
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            background: url('../assets/images/restaurant-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            color: white;
            text-align: center;
        }
        .container {
            margin: 50px auto;
            width: 80%;
            background: rgba(0, 0, 0, 0.7); /* Transparent black box */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.2);
        }
        h2 {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            color: white;
        }
        table th, table td {
            padding: 10px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            text-align: center;
        }
        table th {
            background: rgba(255, 255, 255, 0.2);
        }
        table tbody tr:nth-child(even) {
            background: rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Order Reports</h2>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Total Amount</th>
                <th>Payment Status</th>
                <th>Order Status</th>
                <th>Order Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['order_id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['total_amount']; ?></td>
                    <td><?php echo $row['payment_status']; ?></td>
                    <td><?php echo $row['order_status']; ?></td>
                    <td><?php echo $row['order_date']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>
