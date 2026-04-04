<?php 
session_start();
require_once '../config/db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_id = $_POST['item_id'];
    $prepared = $_POST['prepared_qty'];
    $consumed = $_POST['consumed_qty'];

    $sql = "INSERT INTO Waste_Log (item_id, log_date, prepared_qty, consumed_qty)
            VALUES (?, CURDATE(), ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iii", $item_id, $prepared, $consumed);
    mysqli_stmt_execute($stmt);

    $success = "Waste log saved successfully!";
}

$items = mysqli_query($conn, "SELECT item_id, name FROM menu WHERE is_available = 1");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Waste Log - ServeSync</title>
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
    <h2 style="color: #e65c00;">End of Day Waste Log</h2>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    <div class="card shadow-sm p-4 mt-3 bg-white">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label fw-bold">Menu Item</label>
                <select name="item_id" class="form-control">
                    <?php while($row = mysqli_fetch_assoc($items)): ?>
                        <option value="<?= $row['item_id'] ?>"><?= $row['name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Prepared Quantity</label>
                <input type="number" name="prepared_qty" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Consumed Quantity</label>
                <input type="number" name="consumed_qty" class="form-control" required>
            </div>
            <button type="submit" class="btn" style="background-color: #e65c00; color: white;">Save Log</button>
        </form>
    </div>
</div>

</body>
</html>