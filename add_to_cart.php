<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'shutterstory_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$user_email = $_SESSION['email']; 

$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];

$session_id = session_id();

$sql = "SELECT * FROM cart WHERE email='$user_email' AND product_id='$product_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    $sql = "UPDATE cart SET quantity = quantity + $quantity WHERE email='$user_email' AND product_id='$product_id'";
} else {

    $sql = "INSERT INTO cart (product_id, quantity, email, session_id) VALUES ('$product_id', '$quantity', '$user_email', '$session_id')";
}
if ($conn->query($sql) === TRUE) {
    echo "Product added to cart!";
    header('Location: cart.php');
    exit; 
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>