<?php
session_start();
require_once '../config/db.php';

$user_id = $_SESSION['user_id'];

// Get next token number
$token_sql = "SELECT COALESCE(MAX(token_no), 0) + 1 AS next_token FROM Orders WHERE DATE(order_date) = CURDATE()";
$token_result = mysqli_query($conn, $token_sql);
$token_row = mysqli_fetch_assoc($token_result);
$next_token = $token_row['next_token'];

// Insert order
$sql = "INSERT INTO Orders (user_id, token_no) VALUES (?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $user_id, $next_token);
mysqli_stmt_execute($stmt);
$order_id = mysqli_insert_id($conn);

// Insert order items
if(isset($_POST['qty'])) {
    foreach($_POST['qty'] as $item_id => $quantity) {
        if($quantity > 0) {
            $sql2 = "INSERT INTO Order_Items (order_id, item_id, quantity) VALUES (?, ?, ?)";
            $stmt2 = mysqli_prepare($conn, $sql2);
            mysqli_stmt_bind_param($stmt2, "iii", $order_id, $item_id, $quantity);
            mysqli_stmt_execute($stmt2);
        }
    }
}

// Insert token
$tok_sql = "INSERT INTO Tokens (order_id) VALUES (?)";
$stmt3 = mysqli_prepare($conn, $tok_sql);
mysqli_stmt_bind_param($stmt3, "i", $order_id);
mysqli_stmt_execute($stmt3);

// Save in session and redirect to token page
$_SESSION['token_no'] = $next_token;
$_SESSION['order_id'] = $order_id;
header("Location: token.php");
exit();
?>