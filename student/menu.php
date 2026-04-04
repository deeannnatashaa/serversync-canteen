<?php 
session_start();
require_once '../config/db.php';

$sql = "SELECT * FROM Menu WHERE available_date = CURDATE() AND is_available = TRUE";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Today's Menu - ServeSync</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background: #f4f4f4; }
        .card { text-align: center; }
        .price { color: #e65c00; font-size: 18px; font-weight: bold; }
        .qty { width: 70px; text-align: center; }
    </style>
</head>
<body>

<nav class="navbar navbar-dark" style="background-color: #e65c00;">
    <div class="container">
        <a class="navbar-brand fw-bold">🍽️ ServeSync</a>
        <div class="d-flex">
            <span class="navbar-text text-white me-3">Welcome, <?= $_SESSION['name'] ?></span>
            <a href="/serversync-canteen/logout.php" class="btn btn-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h2 class="text-center mb-4" style="color: #e65c00;">What would you like to order?</h2>
    <form method="POST" action="place_order.php">
        <div class="row justify-content-center g-3">
            <?php while($item = mysqli_fetch_assoc($result)): ?>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card p-3 shadow-sm h-100">
                    <h5 class="card-title"><?= $item['name'] ?></h5>
                    <p class="text-muted mb-1"><?= $item['category'] ?></p>
                    <p class="price">₹<?= $item['price'] ?></p>
                    <input type="number" class="form-control qty mx-auto" name="qty[<?= $item['item_id'] ?>]" value="0" min="0" max="10">
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-lg" style="background-color: #e65c00; color: white;">Place Order</button>
        </div>
    </form>
</div>

</body>
</html>