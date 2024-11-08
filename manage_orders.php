<?php
session_start();
include 'config.php'; 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$sql = "SELECT orders.order_id, order_items.quantity, orders.total_amount, orders.order_date, orders.status, users.username, products.product_name 
        FROM orders 
        JOIN users ON orders.email = users.email 
        JOIN order_items ON orders.order_id = order_items.order_id
        JOIN products ON order_items.product_id = products.product_id"; 
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $update_sql = "UPDATE orders SET status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("si", $status, $order_id);
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Order status updated successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error updating status: " . $stmt->error . "</div>";
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h2 class="mt-5">Manage Orders</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Order Date</th>
                <th>Status</th> 
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['order_id']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['product_name']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo number_format($row['total_amount'], 2); ?></td>
                    <td><?php echo date('Y-m-d H:i:s', strtotime($row['order_date'])); ?></td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                            <select name="status" onchange="this.form.submit()">
                                <option value="Pending" <?php echo ($row['status'] === 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                <option value="Shipped" <?php echo ($row['status'] === 'Shipped') ? 'selected' : ''; ?>>Shipped</option>
                                <option value="Delivered" <?php echo ($row['status'] === 'Delivered') ? 'selected' : ''; ?>>Delivered</option>
                                <option value="Cancelled" <?php echo ($row['status'] === 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <form action="delete_order.php" method="POST" style="display:inline;">
                         <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                           <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php } 
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
