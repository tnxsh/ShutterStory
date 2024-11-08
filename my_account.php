<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="my_account.css"> 
    <title>My Account</title>
</head>
<body>

<div class="account-container">

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

$stmt = $conn->prepare("SELECT * FROM users WHERE email = ? ");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    echo "<h1>My Account</h1>";
    echo "<p><strong>Email:</strong> " . htmlspecialchars($user['email']) . "</p>";
    echo "<p><strong>Name:</strong> " . htmlspecialchars($user['username']) . "</p>";
    
    $address_parts = array();
    if (!empty($user['add_line1'])) {
        $address_parts[] = $user['add_line1'];
    }
    if (!empty($user['add_line2'])) {
        $address_parts[] = $user['add_line2'];
    }
    if (!empty($user['add_line3'])) {
        $address_parts[] = $user['add_line3'];
    }
    if (!empty($user['zipcode'])) {
        $address_parts[] = $user['zipcode'];
    }
    if (!empty($user['state'])) {
        $address_parts[] = $user['state'];
    }
    if (!empty($user['country'])) {
        $address_parts[] = $user['country'];
    }

    $full_address = implode(" ", $address_parts);
    
    echo "<p><strong>Address:</strong> " . htmlspecialchars($full_address) . "</p>";
} else {
    echo "<p>Error: Unable to fetch user details.</p>";
}


echo "<h2>Order Status</h2>";

$order_stmt = $conn->prepare("SELECT * FROM orders WHERE email = ?");
$order_stmt->bind_param("s", $email);
$order_stmt->execute();
$order_result = $order_stmt->get_result();

if ($order_result->num_rows > 0) {

echo '<table class="order-status-table">'; 
echo '<tr><th>Order ID</th><th>Order Date</th><th>Status</th><th>Total Amount</th></tr>';

while ($order = $order_result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($order['order_id']) . '</td>';
    echo '<td>' . htmlspecialchars($order['order_date']) . '</td>';
    echo '<td>' . htmlspecialchars($order['status']) . '</td>';
    echo '<td>RM' . htmlspecialchars($order['total_amount']) . '</td>';
    echo '</tr>';
}    
    echo '</table>';
} else {
    echo "<p>No orders found.</p>";
}

$order_stmt->close();

echo "<h2>Rental History</h2>";

$rental_stmt = $conn->prepare("
    SELECT r.rental_id, p.product_name, r.pickup_date, r.return_date, r.total_cost 
    FROM rentals r
    JOIN products p ON r.product_id = p.product_id
    WHERE r.email = ?
");
$rental_stmt->bind_param("s", $email);
$rental_stmt->execute();
$rental_result = $rental_stmt->get_result();

if ($rental_result->num_rows > 0) {
    echo '<table class="rental-history-table">';
    echo '<tr><th>Rental ID</th><th>Product</th><th>Pickup Date</th><th>Return Date</th><th>Total Cost</th></tr>';

    while ($rental = $rental_result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($rental['rental_id']) . '</td>';
        echo '<td>' . htmlspecialchars($rental['product_name']) . '</td>';
        echo '<td>' . htmlspecialchars($rental['pickup_date']) . '</td>';
        echo '<td>' . htmlspecialchars($rental['return_date']) . '</td>';
        echo '<td>RM' . htmlspecialchars($rental['total_cost']) . '</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo "<p>No rental history found.</p>";
}

$rental_stmt->close();

$stmt->close();
$conn->close();
?>


<button onclick="document.getElementById('editForm').style.display='block'">Edit</button>

<div id="editForm" style="display:none;">
    <form action="update_account.php" method="POST">
        <label for="username">Name:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        
        <label for="add_line1">Address Line 1:</label>
        <input type="text" id="add_line1" name="add_line1" value="<?php echo htmlspecialchars($user['add_line1']); ?>" required>
        
        <label for="add_line2">Address Line 2:</label>
        <input type="text" id="add_line2" name="add_line2" value="<?php echo htmlspecialchars($user['add_line2']); ?>">
        
        <label for="add_line3">Address Line 3:</label>
        <input type="text" id="add_line3" name="add_line3" value="<?php echo htmlspecialchars($user['add_line3']); ?>">
        
        <label for="zipcode">Zip Code:</label>
        <input type="text" id="zipcode" name="zipcode" value="<?php echo htmlspecialchars($user['zipcode']); ?>" required>
        
        <label for="state">State:</label>
        <input type="text" id="state" name="state" value="<?php echo htmlspecialchars($user['state']); ?>" required>
        
        <label for="country">Country:</label>
        <input type="text" id="country" name="country" value="<?php echo htmlspecialchars($user['country']); ?>" required>

        <button type="submit">Update</button>
    </form>
</div>

<form action="logout.php" method="POST">
    <button type="submit">Logout</button>
</form>

</div>

</body>
</html>
