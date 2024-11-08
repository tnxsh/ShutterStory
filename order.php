<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_email = $_SESSION['email']; 
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity']; 

    $result = mysqli_query($conn, "SELECT price FROM products WHERE product_id = '$product_id'");
    $product = mysqli_fetch_assoc($result);
    $total_price = $product['price'] * $quantity;

    $sql = "INSERT INTO orders (user_email, product_id, quantity, total_price) VALUES ('$user_email', '$product_id', '$quantity', '$total_price')";
    
    if (mysqli_query($conn, $sql)) {
        echo "Order placed successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
