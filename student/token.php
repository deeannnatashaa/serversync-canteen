<?php 
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmed - ServeSync</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background: #f4f4f4; }
        .token-number { font-size: 100px; color: #e65c00; font-weight: bold; }
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

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div class="card p-5 shadow">
                <h2 class="text-success mb-3">✅ Order Placed!</h2>
                <p class="text-muted">Your token number is</p>
                <div class="token-number"><?= $_SESSION['token_no'] ?></div>
                <p class="text-muted mt-3">Please collect your order when your number is called.</p>
                <a href="/serversync-canteen/student/menu.php" class="btn btn-lg mt-3" style="background-color: #e65c00; color: white;">Order More</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>