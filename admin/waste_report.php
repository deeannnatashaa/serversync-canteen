<?php 
session_start();
require_once '../config/db.php'; 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Waste Report</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
    <h2>Weekly Waste Report</h2>
    <table class="table table-bordered">
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
</body>
</html>