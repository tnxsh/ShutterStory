<?php
session_start();
include 'config.php'; 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

$rental_id = $_GET['id'];

$sql = "DELETE FROM rentals WHERE rental_id = $rental_id";
if (mysqli_query($conn, $sql)) {
    header("Location: manage_rental.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
