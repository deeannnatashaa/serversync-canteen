php
<?php require_once '../config/db.php'; ?>
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
