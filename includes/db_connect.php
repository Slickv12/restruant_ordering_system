<?php
$host = "localhost";
$dbname = "restaurant_db";
$username = "root";  // Default in XAMPP
$password = "";  // Default is empty in XAMPP

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
