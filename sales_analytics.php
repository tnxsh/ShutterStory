<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'config.php'; 

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

$totalSalesResult = mysqli_query($conn, "SELECT SUM(total_amount) AS total_sales FROM orders");
$totalSales = mysqli_fetch_assoc($totalSalesResult)['total_sales'];

$totalOrdersResult = mysqli_query($conn, "SELECT COUNT(order_id) AS total_orders FROM orders");
$totalOrders = mysqli_fetch_assoc($totalOrdersResult)['total_orders'];

$monthlySalesResult = mysqli_query($conn, "SELECT DATE_FORMAT(order_date, '%Y-%m') AS month, SUM(total_amount) AS monthly_sales FROM orders GROUP BY month");

$topSaleProductResult = mysqli_query($conn, "
    SELECT product_id, COUNT(*) AS sale_count 
    FROM order_items 
    GROUP BY product_id 
    ORDER BY sale_count DESC 
    LIMIT 1
");


$topSaleProduct = mysqli_fetch_assoc($topSaleProductResult);
$productName = "N/A";
$saleCount = 0;

if ($topSaleProduct) {
    $productId = $topSaleProduct['product_id'];
    $saleCount = $topSaleProduct['sale_count'];
    
    $productNameResult = mysqli_query($conn, "SELECT product_name FROM products WHERE product_id = $productId");
    $productNameRow = mysqli_fetch_assoc($productNameResult);
    $productName = $productNameRow['product_name'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Analytics</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="sales.css">

</head>
<body>

<div class="container">
<div class="container">
    <h2>Sales Analytics</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Figure</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Total Sales</td>
                <td>RM <?php echo number_format($totalSales, 2); ?></td>
            </tr>
            <tr>
                <td>Total Orders</td>
                <td><?php echo $totalOrders; ?></td>
            </tr>
            <tr>
                <td>Top Sale Product</td>
                <td><?php echo htmlspecialchars($productName) . " (Sales: " . $saleCount . ")"; ?></td>
            </tr>
        </tbody>
    </table>

    <h4>Monthly Sales</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Month</th>
                <th>Sales</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($monthlySalesResult)) { ?>
                <tr>
                    <td><?php echo $row['month']; ?></td>
                    <td>RM <?php echo number_format($row['monthly_sales'], 2); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
