php
<?php
require_once 'config/db.php';

// Query 1 - Place an order and generate token
$user_id = 1;

$token_sql = "SELECT COALESCE(MAX(token_no), 0) + 1 AS next_token FROM Orders WHERE DATE(order_date) = CURDATE()";
$token_result = mysqli_query($conn, $token_sql);
$token_row = mysqli_fetch_assoc($token_result);
$next_token = $token_row['next_token'];

$sql = "INSERT INTO Orders (user_id, token_no) VALUES (?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $user_id, $next_token);
mysqli_stmt_execute($stmt);

echo "Order placed! Order ID: " . mysqli_insert_id($conn) . "<br>";

// Query 2 - Admin view of today's orders
$sql = "SELECT m.name, SUM(oi.quantity) AS total_ordered
FROM Order_Items oi
JOIN Menu m ON oi.item_id = m.item_id
JOIN Orders o ON oi.order_id = o.order_id
WHERE DATE(o.order_date) = CURDATE()
GROUP BY m.name
ORDER BY total_ordered DESC";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    echo $row['name'] . " — " . $row['total_ordered'] . "<br>";
}

// Query 3 - Mark token as collected
$order_id = 1;

$sql1 = "UPDATE Tokens SET collected = 'Y' WHERE order_id = ?";
$stmt = mysqli_prepare($conn, $sql1);
mysqli_stmt_bind_param($stmt, "i", $order_id);
mysqli_stmt_execute($stmt);

$sql2 = "UPDATE Orders SET status = 'collected' WHERE order_id = ?";
$stmt = mysqli_prepare($conn, $sql2);
mysqli_stmt_bind_param($stmt, "i", $order_id);
mysqli_stmt_execute($stmt);

echo "Token marked as collected!<br>";

// Query 4 - Log waste at end of day
$item_id = 1;
$prepared = 50;
$consumed = 35;

$sql = "INSERT INTO Waste_Log (item_id, log_date, prepared_qty, consumed_qty)
VALUES (?, CURDATE(), ?, ?)";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "iii", $item_id, $prepared, $consumed);
mysqli_stmt_execute($stmt);

echo "Waste log saved! Wasted: " . ($prepared - $consumed) . " items<br>";

// Query 5 - Most wasted items this week
$sql = "SELECT m.name, SUM(w.wasted_qty) AS total_wasted
FROM Waste_Log w
JOIN Menu m ON w.item_id = m.item_id
WHERE w.log_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
GROUP BY m.name
ORDER BY total_wasted DESC";

$result = mysqli_query($conn, $sql);

echo "Most wasted this week:<br>";
while ($row = mysqli_fetch_assoc($result)) {
    echo $row['name'] . " — wasted: " . $row['total_wasted'] . "<br>";
}
?>