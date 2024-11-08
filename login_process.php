<?php

// Database connection parameters
$host = "localhost";
$username = "root";
$password = "";
$dbname = "shutterstory_db";

// Establishing connection to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetching user input and sanitizing to prevent SQL Injection
$email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';
$password = isset($_POST['password']) ? $conn->real_escape_string($_POST['password']) : '';

// Query to check if the username and password match
$sql = "SELECT * FROM USERS WHERE email=? AND password=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // User found, login successful
    session_start();
    $_SESSION['email'] = $email; // Storing username in session
    header("Location: Homepage.html"); // Redirecting to dashboard
    exit();
} else {
    // Username or password incorrect
    echo "Invalid username or password. Please try again.";
}

$stmt->close();
$conn->close();
?>s
