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

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    
    $stmt = $conn->prepare("
        SELECT p.*, r.daily_rate, r.weekly_rate, r.monthly_rate 
        FROM products p
        JOIN rental_rates r ON p.product_id = r.product_id
        WHERE p.product_id = ?
    ");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        echo "<h1>" . htmlspecialchars($product['product_name']) . "</h1>";
        echo "<p><strong>Description:</strong> " . htmlspecialchars($product['description']) . "</p>";
        echo "<p><strong>Daily Rate:</strong> RM" . htmlspecialchars($product['daily_rate']) . "</p>";
        echo "<p><strong>Weekly Rate / Day:</strong> RM" . htmlspecialchars($product['weekly_rate']) . "</p>";
        echo "<p><strong>Monthly Rate / Day:</strong> RM" . htmlspecialchars($product['monthly_rate']) . "</p>";

        echo '<form action="rental_checkout.php" method="POST">';
        echo '<label for="pickup_date">Pickup Date:</label>';
        echo '<input type="date" id="pickup_date" name="pickup_date" required>';
        
        echo '<label for="return_date">Return Date:</label>';
        echo '<input type="date" id="return_date" name="return_date" required>';
        
        echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($product['product_id']) . '">';
        
        echo '<button type="submit">Rent Now</button>';
        echo '</form>';
    } else {
        echo "<p>Product not found.</p>";
    }
} else {
    echo "<p>Invalid product ID.</p>";
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="rental_detail.css"> 
    <title>Rental Detail</title>
</head>
<body>

    </div>
</body>
</html>
