<?php
session_start();

$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "shutterstory_db"; 
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Error: Invalid email format. Please enter a valid email address.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            session_regenerate_id(true); 
            $_SESSION['logged_in'] = true; 
            $_SESSION['email'] = $email; // Store user email
            $_SESSION['username'] = $user['username']; // Store username if needed


            header("Location: Homepage.php"); 
            exit();
        } else {
            $error_message = "Error: Invalid email or password.";
        }

        $stmt->close();
    }
}

$conn->close();
?>


