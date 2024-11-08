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

$email = $_SESSION['email']; 

$new_username = $_POST['username'];
$new_add_line1 = $_POST['add_line1'];
$new_add_line2 = $_POST['add_line2'];
$new_add_line3 = $_POST['add_line3'];
$new_zipcode = $_POST['zipcode'];
$new_state = $_POST['state'];
$new_country = $_POST['country'];

$stmt = $conn->prepare("UPDATE users SET username=?, add_line1=?, add_line2=?, add_line3=?, zipcode=?, state=?, country=? WHERE email=?");
$stmt->bind_param("ssssssss", $new_username, $new_add_line1, $new_add_line2, $new_add_line3, $new_zipcode, $new_state, $new_country, $email);

if ($stmt->execute()) {
    echo "Account details updated successfully!";
    header("Location: my_account.php"); 
} else {
    echo "Error updating account details: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
