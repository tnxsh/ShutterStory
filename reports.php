<?php
session_start();
include 'config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: admin_login.php');
    exit();
}

$orders_result = mysqli_query($conn, "SELECT COUNT(*) AS total_orders, SUM(total_price) AS total_revenue FROM orders");
$orders_data = mysqli_fetch_assoc($orders_result);

$products_result = mysqli_query($conn, "SELECT COUNT(*) AS total_products FROM products");
$products_data = mysqli_fetch_assoc($products_result);

$users_result = mysqli_query($conn, "SELECT COUNT(*) AS total_users FROM users");
$users_data = mysqli_fetch_assoc($users_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Reports</h2>
    <h3>Orders Summary</h3>
    <p>Total Orders: <?php echo $orders_data['total_orders']; ?></p>
    <p>Total Revenue: $<?php echo number_format($orders_data['total_revenue'], 2); ?></p>

    <h3>Products Summary</h3>
    <p>Total Products: <?php echo $products_data['total_products']; ?></p>

    <h3>Users Summary</h3>
    <p>Total Users: <?php echo $users_data['total_users']; ?></p>
</div>
</body>
</html>
