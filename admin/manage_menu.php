<?php 
require_once '../config/db.php';

// Handle add new item
if(isset($_POST['add'])) {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $qty = $_POST['quantity'];
    
    $sql = "INSERT INTO Menu (name, category, price, available_date, quantity_prepared) VALUES (?, ?, ?, CURDATE(), ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssdi", $name, $category, $price, $qty);
    mysqli_stmt_execute($stmt);
}

// Handle toggle availability
if(isset($_POST['toggle'])) {
    $item_id = $_POST['item_id'];
    $current = $_POST['current'];
    $new = $current == 1 ? 0 : 1;
    mysqli_query($conn, "UPDATE Menu SET is_available = $new WHERE item_id = $item_id");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Menu</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f4f4f4; }
        .navbar { background: #e65c00; color: white; padding: 15px 20px; }
        .container { padding: 20px; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 30px; }
        th { background: #e65c00; color: white; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #eee; }
        .form-box { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        input, select { padding: 8px; margin: 5px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #e65c00; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; }
        h2 { color: #e65c00; }
    </style>
</head>
<body>
    <div class="navbar">🍽️ Menu Management</div>
    <div class="container">
        <h2>Today's Menu Items</h2>
        <table>
            <tr>
                <th>Item</th>
                <th>Category</th>
                <th>Price</th>
                <th>Qty Prepared</th>
                <th>Available</th>
                <th>Action</th>
            </tr>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM Menu WHERE available_date = CURDATE()");
            while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td><?= $row['category'] ?></td>
                <td>₹<?= $row['price'] ?></td>
                <td><?= $row['quantity_prepared'] ?></td>
                <td><?= $row['is_available'] ? '✅ Yes' : '❌ No' ?></td>
                <td>
                    <form method="POST" style="display:inline">
                        <input type="hidden" name="item_id" value="<?= $row['item_id'] ?>">
                        <input type="hidden" name="current" value="<?= $row['is_available'] ?>">
                        <button type="submit" name="toggle">Toggle</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>

        <h2>Add New Item</h2>
        <div class="form-box">
            <form method="POST">
                <input type="text" name="name" placeholder="Item name" required>
                <input type="text" name="category" placeholder="Category" required>
                <input type="number" name="price" placeholder="Price" step="0.01" required>
                <input type="number" name="quantity" placeholder="Quantity prepared" required>
                <button type="submit" name="add">Add Item</button>
            </form>
        </div>
    </div>
</body>
</html>