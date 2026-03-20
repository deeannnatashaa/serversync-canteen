<?php
$conn = new mysqli("localhost", "root", "", "canteen_db", 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Database connected successfully!";
?>