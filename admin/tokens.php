<?php 
session_start();
require_once '../config/db.php';

if(isset($_POST['collect'])) {
    $order_id = $_POST['order_id'];
    mysqli_query($conn, "UPDATE Tokens SET collected = 'Y' WHERE order_id = $order_id");
    mysqli_query($conn, "UPDATE Orders SET status = 'collected' WHERE order_id = $order_id");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Token Management - ServeSync</title>
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
    <h2 style="color: #e65c00;">Today's Tokens</h2>
    <table class="table table-bordered shadow-sm bg-white mt-3">
        <thead>
            <tr>
                <th>Token No</th>
                <th>Student</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT o.order_id, o.token_no, o.status, u.name 
                    FROM Orders o 
                    JOIN Users u ON o.user_id = u.user_id
                    WHERE DATE(o.order_date) = CURDATE()
                    ORDER BY o.token_no";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['token_no'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['status'] == 'collected' ? '<span class="text-success fw-bold">✅ Collected</span>' : ucfirst($row['status']) ?></td>
                <td>
                    <?php if($row['status'] != 'collected'): ?>
                    <form method="POST">
                        <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
                        <button type="submit" name="collect" class="btn btn-success btn-sm">Mark Collected</button>
                    </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>