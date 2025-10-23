<?php session_start(); if (!isset($_SESSION['user_id'])) { header("Location: ../auth/login.php"); exit(); } $user_name = $_SESSION['user_name']; ?> <!DOCTYPE html> <html lang="en"> <head> <meta charset="UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>Order Food - Restaurant Ordering System</title> <link rel="stylesheet" href="../assets/css/order_food.css"> </head> <body> <div class="dashboard-container"> <!-- Sidebar --> <div class="sidebar"> <h2>Hello, <?php echo htmlspecialchars($user_name); ?> 👋</h2> <ul> <li><a href="user_dashboard.php">🏠 Dashboard</a></li> <li><a href="order_food.php" class="active">🍔 Order Food</a></li> <li><a href="book_table.php">🍽️ Book Table</a></li> <li><a href="view_orders.php">🧾 View Orders</a></li> <li><a href="feedback.php">💬 Feedback</a></li> <li><a href="profile.php">👤 Profile</a></li> <li><a href="../auth/logout.php">🚪 Logout</a></li> </ul> </div>
    <!-- Main Content -->
    <div class="main-content">
        <h1>🍴 Order Your Favorite Food</h1>
        <p>Select your meal and enjoy the best dining experience!</p>

        <div class="menu-container">
            <!-- Sample Menu Items -->
            <div class="food-card">
                <img src="../images/pizza.jpg" alt="Pizza">
                <h3>Cheese Burst Pizza</h3>
                <p>Loaded with extra cheese and crispy crust.</p>
                <span class="price">₹299</span>
                <button class="btn">Add to Cart</button>
            </div>

            <div class="food-card">
                <img src="../images/burger.jpg" alt="Burger">
                <h3>Classic Chicken Burger</h3>
                <p>Juicy grilled chicken with fresh lettuce and mayo.</p>
                <span class="price">₹199</span>
                <button class="btn">Add to Cart</button>
            </div>

            <div class="food-card">
                <img src="../images/pasta.jpg" alt="Pasta">
                <h3>White Sauce Pasta</h3>
                <p>Creamy and delicious Italian-style pasta.</p>
                <span class="price">₹249</span>
                <button class="btn">Add to Cart</button>
            </div>

            <div class="food-card">
                <img src="../images/sandwich.jpg" alt="Sandwich">
                <h3>Grilled Veg Sandwich</h3>
                <p>Healthy and tasty grilled sandwich with veggies.</p>
                <span class="price">₹149</span>
                <button class="btn">Add to Cart</button>
            </div>

            <div class="food-card">
                <img src="../images/momo.jpg" alt="Momos">
                <h3>Steamed Momos</h3>
                <p>Soft and juicy dumplings served with spicy chutney.</p>
                <span class="price">₹129</span>
                <button class="btn">Add to Cart</button>
            </div>

            <div class="food-card">
                <img src="../images/drink.jpg" alt="Drink">
                <h3>Fresh Lime Soda</h3>
                <p>Refreshing lime soda to cool your taste buds.</p>
                <span class="price">₹99</span>
                <button class="btn">Add to Cart</button>
            </div>
        </div>
    </div>
</div>
</body> </html>