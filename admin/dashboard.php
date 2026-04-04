<?php 
session_start();
require_once '../config/db.php'; 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - ServeSync</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background: #f4f4f4; }
        th { background-color: #e65c00; color: white; }
        tr:hover { background: #fff8f5; }
    </style>
</head>
<body>

<nav class="navbar navbar-dark" style="background-color: #e65c00;">
    <div class="container">
        <a class="navbar-brand fw-bold">🍽️ ServeSync — Admin</a>
        <div class="d-flex gap-3">
            <a href="/serversync-canteen/admin/dashboard.php" class="btn btn-light btn-sm">Dashboard</a>
            <a href="/serversync-canteen/admin/tokens.php" class="btn btn-light btn-sm">Tokens</a>
            <a href="/serversync-canteen/admin/waste_log.php" class="btn btn-light btn-sm">Waste Log</a>
            <a href="/serversync-canteen/admin/waste_report.php" class="btn btn-light btn-sm">Waste Report</a>
            <a href="/serversync-canteen/logout.php" class="btn btn-dark btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h2 style="color: #e65c00;">Today's Orders Summary</h2>
    <table class="table table-bordered shadow-sm bg-white mt-3">
        <thead>
            <tr>
                <th>Item</th>
                <th>Total Ordered</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT m.name, SUM(oi.quantity) AS total_ordered
                    FROM Order_Items oi
                    JOIN Menu m ON oi.item_id = m.item_id
                    JOIN Orders o ON oi.order_id = o.order_id
                    WHERE DATE(o.order_date) = CURDATE()
                    GROUP BY m.name
                    ORDER BY total_ordered DESC";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td><?= $row['total_ordered'] ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>