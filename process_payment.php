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

$total_amount = $_POST['total_amount'];
$payment_method = $_POST['payment_method'];
$email = $_SESSION['email']; 


try {
    $conn->begin_transaction();

    $stmt = $conn->prepare("INSERT INTO orders (email, total_amount, payment_method, order_date) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sds", $email, $total_amount, $payment_method);
    if (!$stmt->execute()) {
        throw new Exception("Failed to create order: " . $stmt->error);
    }

    $order_id = $conn->insert_id;

    $stmt = $conn->prepare("SELECT product_id, quantity FROM cart WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $insert_order_items_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
    while ($item = $result->fetch_assoc()) {
        $insert_order_items_stmt->bind_param("iii", $order_id, $item['product_id'], $item['quantity']);
        if (!$insert_order_items_stmt->execute()) {
            throw new Exception("Failed to insert order item: " . $insert_order_items_stmt->error);
        }
    }

    $conn->commit();

    $stmt = $conn->prepare("DELETE FROM cart WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $message = "Payment processed successfully! Your order ID is: " . $order_id;

} catch (Exception $e) {
    $conn->rollback();
    $message = "Payment failed: " . $e->getMessage();
}

$stmt->close();
$insert_order_items_stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="payment_done.css"> 
    <title>Payment Result</title>
</head>
<body>
    <div class="main-container">
        <h1>Payment Result</h1>
        <p><?php echo htmlspecialchars($message); ?></p>
        <a href="Homepage.php" class="button">Go to Home</a>
    </div>
</body>
</html>
