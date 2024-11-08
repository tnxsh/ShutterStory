<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shutterstory_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

$products = [];
if ($result->num_rows > 0) {
    // Store the products in an array
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

$conn->close();
?>