<?php session_start(); if (!isset($_SESSION['user_id'])) { header("Location: ../auth/login.php"); exit(); } $user_name = $_SESSION['user_name']; ?> <!DOCTYPE html> <html lang="en"> <head> <meta charset="UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>User Dashboard - Restaurant Ordering System</title> <link rel="stylesheet" href="../assets/css/dashboard_user.css"> </head> <body> <div class="dashboard-container"> <!-- Sidebar --> <div class="sidebar"> <h2>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h2> <ul> <li><a href="user_dashboard.php">🏠 Dashboard</a></li> <li><a href="order_food.php">🍔 Order Food</a></li> <li><a href="book_table.php">🍽️ Book Table</a></li> <li><a href="view_orders.php">🧾 View Orders</a></li> <li><a href="feedback.php">💬 Feedback</a></li> <li><a href="profile.php">👤 Profile</a></li> <li><a href="../auth/logout.php">🚪 Logout</a></li> </ul> </div>
  <div class="main-content">
        <h1>User Dashboard</h1>
        <p>Welcome to your account, where you can order food, reserve tables, and manage your activities.</p>

        <div class="dashboard-cards">
            <div class="card">
                <h3>🍔 Order Food</h3>
                <p>Explore our delicious menu and place your order now.</p>
                <a href="order_food.php" class="btn">Order Now</a>
            </div>

            <div class="card">
                <h3>🍽️ Book a Table</h3>
                <p>Reserve your spot and dine comfortably without waiting.</p>
                <a href="book_table.php" class="btn">Book Now</a>
            </div>

            <div class="card">
                <h3>🧾 View Orders</h3>
                <p>Check your current and past food orders anytime.</p>
                <a href="view_orders.php" class="btn">View Orders</a>
            </div>

            <div class="card">
                <h3>💬 Feedback</h3>
                <p>We value your feedback! Share your dining experience.</p>
                <a href="feedback.php" class="btn">Give Feedback</a>
            </div>
        </div>
    </div>
</div>
</body> </html>