<?php
session_start();
require_once '../config/db.php';

$user_id = 1; // temporary — will come from login later

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
?>
<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmed</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .box { background: white; padding: 40px; border-radius: 8px; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .token { font-size: 72px; font-weight: bold; color: #e65c00; }
        h2 { color: #333; }
        p { color: #666; }
    </style>
</head>
<body>
    <div class="box">
        <h2>✅ Order Placed!</h2>
        <p>Your token number is</p>
        <div class="token"><?= $next_token ?></div>
        <p>Please collect your order when your number is called.</p>
        <a href="menu.php">Order More</a>
    </div>
</body>
</html>
