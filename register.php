<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "shutterstory_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $add_line1 = $_POST['add_line1'];
    $add_line2 = $_POST['add_line2'];
    $add_line3 = $_POST['add_line3'];
    $zipcode = $_POST['zipcode'];
    $state = $_POST['state'];
    $country = $_POST['country'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Error: Invalid email format. Please enter a valid email address.");
    }

    if (strlen($password) < 8) {
        die("Error: Password must be at least 8 characters long.");
    }

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, add_line1, add_line2, add_line3, zipcode, state, country) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param("sssssssss", $user, $email, $password, $add_line1, $add_line2, $add_line3, $zipcode, $state, $country);

    if ($stmt->execute()) {
       header("Location: Login.html");
       exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
}

$conn->close();
?>
