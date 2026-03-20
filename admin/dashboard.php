<?php require_once '../config/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f4f4f4; }
        .navbar { background: #e65c00; color: white; padding: 15px 20px; }
        .container { padding: 20px; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        th { background: #e65c00; color: white; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #eee; }
        tr:hover { background: #fff8f5; }
        h2 { color: #e65c00; }
    </style>
</head>
<body>
    <div class="navbar">🍽️ Admin Dashboard</div>
    <div class="container">
        <h2>Today's Orders Summary</h2>
        <table>
            <tr>
                <th>Item</th>
                <th>Total Ordered</th>
            </tr>
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
        </table>
    </div>
</body>
</html>

