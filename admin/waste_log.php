<?php 
session_start();
require_once '../config/db.php'; 
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_id = $_POST['item_id'];
    $prepared = $_POST['prepared_qty'];
    $consumed = $_POST['consumed_qty'];

    $sql = "INSERT INTO Waste_Log (item_id, log_date, prepared_qty, consumed_qty)
            VALUES (?, CURDATE(), ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iii", $item_id, $prepared, $consumed);
    mysqli_stmt_execute($stmt);

<<<<<<< HEAD
    $success = "Waste log saved successfully!";
}

$items = mysqli_query($conn, "SELECT item_id, name FROM menu WHERE is_available = 1");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Waste Log</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
    <h2>End of Day Waste Log</h2>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label>Menu Item</label>
            <select name="item_id" class="form-control">
                <?php while($row = mysqli_fetch_assoc($items)): ?>
                    <option value="<?= $row['item_id'] ?>"><?= $row['name'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Prepared Quantity</label>
            <input type="number" name="prepared_qty" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Consumed Quantity</label>
            <input type="number" name="consumed_qty" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Save Log</button>
    </form>
</body>
</html>
=======
    echo "<p>Waste log saved successfully.</p>";
}

$items = mysqli_query($conn, "SELECT item_id, name FROM Menu WHERE is_available = 1");
?>

<form method="POST">
    <select name="item_id">
        <?php while($row = mysqli_fetch_assoc($items)): ?>
            <option value="<?= $row['item_id'] ?>"><?= $row['name'] ?></option>
        <?php endwhile; ?>
    </select>
    <input type="number" name="prepared_qty" placeholder="Prepared quantity">
    <input type="number" name="consumed_qty" placeholder="Consumed quantity">
    <button type="submit">Save Log</button>
</form>
>>>>>>> 4f8c4e5a745ca9b2bbfce0d69d8626b91ca061cb
