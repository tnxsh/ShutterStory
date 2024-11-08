<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: Login.html");
    exit();
}

$email = $_GET['email'];

$sql = "DELETE FROM USERS WHERE email='$email'";

if (mysqli_query($conn, $sql)) {
    header("Location: manage_users.php");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
?>
