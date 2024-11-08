<?php
session_start(); 

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: Login.html"); 
    exit();
}

$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "shutterstory_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$product_id = $_POST['product_id'];
$email = $_POST['email'];
$pickup_date = $_POST['pickup_date'];
$return_date = $_POST['return_date'];
$rental_date = $_POST['rental_date'];
$total_cost = calculateTotalCost($product_id); 

$id_card_path = '';
if (isset($_FILES['id_card']) && $_FILES['id_card']['error'] == UPLOAD_ERR_OK) {
    $id_card_path = 'uploads/' . basename($_FILES['id_card']['name']);
    move_uploaded_file($_FILES['id_card']['tmp_name'], $id_card_path);
}

$stmt = $conn->prepare("INSERT INTO rental_orders (product_id, email, pickup_date, return_date, total_cost, id_card_path, rental_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issdsss", $product_id, $email, $pickup_date, $return_date, $total_cost, $id_card_path, $rental_date);

if ($stmt->execute()) {
    echo "Rental order placed successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

function calculateTotalCost($product_id) {
}
?>
