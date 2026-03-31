php
<?php require_once '../config/db.php'; ?>
<?php
$sql = "SELECT m.name, SUM(w.wasted_qty) AS total_wasted
        FROM Waste_Log w
        JOIN Menu m ON w.item_id = m.item_id
        WHERE w.log_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
        GROUP BY m.name
        ORDER BY total_wasted DESC";

$result = mysqli_query($conn, $sql);
?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Item</th>
            <th>Total Wasted This Week</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['name'] ?></td>
            <td><?= $row['total_wasted'] ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
