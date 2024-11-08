<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'shutterstory_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $session_id = session_id();

    $sql = "DELETE FROM cart WHERE session_id = '$session_id' AND product_id = '$product_id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: cart.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Product ID is not set.";
}

$conn->close();
?>
