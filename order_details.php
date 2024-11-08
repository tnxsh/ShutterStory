<?php
session_start();
include 'config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: admin_login.php');
    exit();
}

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    $stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();

    $user_stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $user_stmt->bind_param("i", $order['user_id']);
    $user_stmt->execute();
    $user_result = $user_stmt->get_result();
    $user = $user_result->fetch_assoc();

    $product_stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
    $product_stmt->bind_param("i", $order['product_id']);
    $product_stmt->execute();
    $product_result = $product_stmt->get_result();
    $product = $product_result->fetch_assoc();
?>

<h2>Order Details</h2>
<p><strong>Order ID:</strong> <?php echo $order['order_id']; ?></p>
<p><strong>User:</strong> <?php echo $user['username']; ?></p>
<p><strong>Product:</strong> <?php echo $product['product_name']; ?></p>
<p><strong>Quantity:</strong> <?php echo $order['quantity']; ?></p>
<p><strong>Total Price:</strong> <?php echo $order['total_price']; ?></p>
<p><strong>Order Date:</strong> <?php echo $order['order_date']; ?></p>
<p><strong>Status:</strong> <?php echo $order['status']; ?></p>

<a href="manage_orders.php">Back to Manage Orders</a>

<?php
} else {
    header('Location: manage_orders.php');
    exit();
}
?>
