<?php
$host = "127.0.0.1";  // ⚠️ IMPORTANT CHANGE
$user = "root";
$password = "";
$database = "canteen_db";

$conn = mysqli_connect($host, $user, $password, $database, 3306);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>