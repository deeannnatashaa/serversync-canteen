<?php 
session_start();
require_once '../config/db.php';

$sql = "SELECT * FROM Menu WHERE available_date = CURDATE() AND is_available = TRUE";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Today's Menu</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        h2 { color: #e65c00; text-align: center; }
        .menu-grid { display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; }
        .card { background: white; border-radius: 8px; padding: 20px; width: 200px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); text-align: center; }
        .card h3 { color: #333; margin: 0 0 10px 0; }
        .price { color: #e65c00; font-size: 18px; font-weight: bold; }
        .qty { width: 60px; padding: 5px; text-align: center; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #e65c00; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; }
        button:hover { background: #cf5200; }
        .navbar { background: #e65c00; color: white; padding: 15px 20px; margin: -20px -20px 20px -20px; }
    </style>
</head>
<body>
    <div class="navbar">🍽️ Canteen — Today's Menu</div>
    <h2>What would you like to order?</h2>
    <form method="POST" action="place_order.php">
        <div class="menu-grid">
            <?php while($item = mysqli_fetch_assoc($result)): ?>
            <div class="card">
                <h3><?= $item['name'] ?></h3>
                <p><?= $item['category'] ?></p>
                <p class="price">₹<?= $item['price'] ?></p>
                <input type="number" class="qty" name="qty[<?= $item['item_id'] ?>]" value="0" min="0" max="10">
            </div>
            <?php endwhile; ?>
        </div>
        <br>
        <center><button type="submit">Place Order</button></center>
    </form>
</body>
</html>
