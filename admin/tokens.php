<?php 
require_once '../config/db.php';

// Handle mark as collected
if(isset($_POST['collect'])) {
    $order_id = $_POST['order_id'];
    mysqli_query($conn, "UPDATE Tokens SET collected = 'Y' WHERE order_id = $order_id");
    mysqli_query($conn, "UPDATE Orders SET status = 'collected' WHERE order_id = $order_id");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Token Management</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f4f4f4; }
        .navbar { background: #e65c00; color: white; padding: 15px 20px; }
        .container { padding: 20px; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        th { background: #e65c00; color: white; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #eee; }
        button { background: #28a745; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; }
        .collected { color: green; font-weight: bold; }
        h2 { color: #e65c00; }
    </style>
</head>
<body>
    <div class="navbar">🍽️ Token Management</div>
    <div class="container">
        <h2>Today's Tokens</h2>
        <table>
            <tr>
                <th>Token No</th>
                <th>Student</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
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
                <td><?= $row['status'] == 'collected' ? '<span class="collected">✅ Collected</span>' : $row['status'] ?></td>
                <td>
                    <?php if($row['status'] != 'collected'): ?>
                    <form method="POST">
                        <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
                        <button type="submit" name="collect">Mark Collected</button>
                    </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
