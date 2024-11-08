<?php
session_start();
include 'config.php'; 

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

$id = $_GET['id'];

$sql = "DELETE FROM products WHERE product_id = $id";
if (mysqli_query($conn, $sql)) {
    header("Location: manage_product.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
