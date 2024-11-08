//register.php

<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "1234"; // Database password
$dbname = "shutterstory_db"; // Database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form data
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

    // Hash the password for security
    $pass = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL statement to insert data including address fields
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, add_line1, add_line2, add_line3, zipcode, state, country) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param("sssssssss", $user, $email, $pass, $add_line1, $add_line2, $add_line3, $zipcode, $state, $country);

    // Execute the query and provide feedback
    if ($stmt->execute()) {
        header("Location: Login.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    
    
    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
