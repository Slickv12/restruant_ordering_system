<?php
include '../includes/db_connect.php';

// Fetch users
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="../assets/css/manage_users.css">
</head>
<body>

<div class="container">
    <h1>Manage Users</h1>

    <!-- Search & Back Button Container -->
    <div class="search-bar-container">
        <div class="search-container">
            <input type="text" id="searchUser" placeholder="Search users...">
            <button onclick="searchUsers()">Search</button>
        </div>
        <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
    </div>

    <!-- User Table -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td>
                        <a href="edit_user.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                        <a href="delete_user.php?id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
function searchUsers() {
    let input = document.getElementById("searchUser").value.toLowerCase();
    let rows = document.querySelectorAll("tbody tr");

    rows.forEach(row => {
        let name = row.cells[1].innerText.toLowerCase();
        let email = row.cells[2].innerText.toLowerCase();

        if (name.includes(input) || email.includes(input)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}
</script>

</body>
</html>
