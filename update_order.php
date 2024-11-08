<?php
session_start();
include 'config.php'; 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$order_id = $_GET['order_id'];

$sql = "SELECT orders.order_id, orders.total_amount, orders.order_date, orders.status, users.username, products.product_name 
        FROM orders 
        JOIN users ON orders.email = users.email 
        JOIN order_items ON orders.order_id = order_items.order_id
        JOIN products ON order_items.product_id = products.product_id
        WHERE orders.order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Order not found.");
}

$order = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_status = $_POST['status'];

    $update_sql = "UPDATE orders SET status = ? WHERE order_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("si", $new_status, $order_id);

    if ($update_stmt->execute()) {
        echo "Order status updated successfully.";
    } else {
        echo "Error updating order status: " . $conn->error;
    }

    header("Location: manage_orders.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h2 class="mt-5">Update Order Status</h2>
    <form action="update_order.php?order_id=<?php echo $order_id; ?>" method="POST">
        <div class="form-group">
            <label for="username">User:</label>
            <input type="text" class="form-control" id="username" value="<?php echo htmlspecialchars($order['username']); ?>" disabled>
        </div>
        <div class="form-group">
            <label for="product_name">Product:</label>
            <input type="text" class="form-control" id="product_name" value="<?php echo htmlspecialchars($order['product_name']); ?>" disabled>
        </div>
        <div class="form-group">
            <label for="total_amount">Total Amount:</label>
            <input type="text" class="form-control" id="total_amount" value="RM <?php echo number_format($order['total_amount'], 2); ?>" disabled>
        </div>
        <div class="form-group">
            <label for="status">Order Status:</label>
            <select name="status" id="status" class="form-control" required>
                <option value="Pending" <?php echo $order['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                <option value="Shipped" <?php echo $order['status'] === 'Shipped' ? 'selected' : ''; ?>>Shipped</option>
                <option value="Delivered" <?php echo $order['status'] === 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                <option value="Cancelled" <?php echo $order['status'] === 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Status</button>
    </form>
</div>

</body>
</html>
