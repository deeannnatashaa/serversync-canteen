<?php 
session_start();
require_once '../config/db.php'; 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Waste Report - ServeSync</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background: #f4f4f4; }
        th { background-color: #e65c00; color: white; }
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
    <h2 style="color: #e65c00;">Weekly Waste Report</h2>
    <table class="table table-bordered shadow-sm bg-white mt-3">
        <thead>
            <tr>
                <th>Item</th>
                <th>Total Wasted This Week</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT m.name, SUM(w.wasted_qty) AS total_wasted
                    FROM waste_log w
                    JOIN menu m ON w.item_id = m.item_id
                    WHERE w.log_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                    GROUP BY m.name
                    ORDER BY total_wasted DESC";

            $result = mysqli_query($conn, $sql);

            while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td><?= $row['total_wasted'] ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>