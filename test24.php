<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: Login.html");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Replace with your database password
$dbname = "shutterstory_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the total amount and payment method from the form
$total_amount = $_POST['total_amount'];
$payment_method = $_POST['payment_method'];
$email = $_SESSION['email']; // Get the user's email from the session

// Here, you can add payment processing logic.
// For demonstration, we'll assume payment is successful.

try {
    // Start a transaction
    $conn->begin_transaction();

    // Insert order details into an orders table
    $stmt = $conn->prepare("INSERT INTO orders (email, total_amount, payment_method, order_date) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sds", $email, $total_amount, $payment_method);
    if (!$stmt->execute()) {
        throw new Exception("Failed to create order: " . $stmt->error);
    }

    // Get the last inserted order ID
    $order_id = $conn->insert_id;

    // Fetch cart items for this user
    $stmt = $conn->prepare("SELECT product_id, quantity FROM cart WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Insert each cart item into an order_items table
    $insert_order_items_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
    while ($item = $result->fetch_assoc()) {
        $insert_order_items_stmt->bind_param("iii", $order_id, $item['product_id'], $item['quantity']);
        if (!$insert_order_items_stmt->execute()) {
            throw new Exception("Failed to insert order item: " . $insert_order_items_stmt->error);
        }
    }

    // Commit the transaction
    $conn->commit();

    // Clear the user's cart after successful payment
    $stmt = $conn->prepare("DELETE FROM cart WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $message = "Payment processed successfully! Your order ID is: " . $order_id;

} catch (Exception $e) {
    // Rollback the transaction on error
    $conn->rollback();
    $message = "Payment failed: " . $e->getMessage();
}

// Close the statements and the connection
$stmt->close();
$insert_order_items_stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ShutterStory</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" />
    <link rel="stylesheet" href="oricontact.css" />
  </head>
  <body>
        <a href="rental_product.php" class="rental-service">Photography Service</a
        ><span class="contact-2">Contact</span>
        <a href="Homepage.php" class="home">Home</a>
        <span class="shop">Product</span>
        <div class="mdi-account-alert-outline"></div>
      </div>
      <div class="rectangle-3">
        <div class="meubel-house-logos"></div>
        <span class="contact-4">Contact</span>
      </div>
      <div class="rectangle-5">
        <span class="get-in-touch">Get In Touch With Us</span>
        <div class="flex-row-d">
          <span class="product-services-info"
            >For More Information About Our Product & Services. Please Feel Free
            To Drop Us An Email. Our Staff Always Be There To Help You Out. Do
            Not Hesitate!</span
          >
          <div class="rectangle-6">
            <div class="flex-column-ca">
              <span class="phone">Phone</span
              ><span class="mobile-hotline"
                >Mobile: 0123 456789<br />Hotline: 0123456789</span
              ><span class="working-time">Working Time</span
              ><span class="opening-hours"
                >Monday-Friday: 9:00 - 22:00 <br />Saturday-Sunday: 9:00 -
                21:00</span
              >
            </div>
            <div class="flex-column-fae">
              <div class="bxs-phone"><div class="vector-7"></div></div>
              <div class="bi-clock-fill"><div class="vector-8"></div></div>
            </div>
          </div>
          <div class="rectangle-9">
            <span class="your-name">Your name</span>
            <div class="rectangle-a">               
              <input type="text" id="name" name="name" class="login-input" placeholder="Your Name" />
            </div>
            <span class="email-address">Email address</span>
            <div class="rectangle-b">
              <input type="text" id="email" name="email" class="login-input" placeholder="Email Address" />
            </div>
            <span class="subject">Message</span>
            <div class="rectangle-d">
              <input type="text" id="message" name="message" class="login-input" placeholder="Your Message" />
            </div>
            <div class="rectangle-e">
              <button class="submit">Submit</span>              
            </div>
          </div>

        </div>
      </div>
      <div class="rectangle-f">
        <div class="flex-row-ddd">
          <span class="free-delivery">Free Delivery</span
          ><span class="secure-payment">Secure Payment</span>
        </div>
        <div class="flex-row-d-10">
          <span class="orders-over-rm">For all orders over Rm 5000.</span
          ><span class="secure-payment-11">100% secure payment.</span>
        </div>
      </div>
      <div class="rectangle-12">
        <div class="flex-row-a">
          <span class="links">Links</span><span class="help">Help</span>
        </div>
        <div class="flex-row">
          <a href="Homepage.php" class="home-13">Home</a
          ><span class="photography-service">Photography Service</span>
        </div>
        <div class="flex-row-a-14">
          <span class="shop-15">Product</span
          ><span class="rental-policy">Rental Policy</span>
        </div>
        <span class="about">About</span><span class="contact-16">Contact</span
        ><span class="all-rights-reserved"
          >2024 ShutterStory. All rights reserved</span
        >
      </div>
      <div class="line"></div>
    </div>
  </body>
</html>













<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: Login.html");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Replace with your database password
$dbname = "shutterstory_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the total amount and payment method from the form
$total_amount = $_POST['total_amount'];
$payment_method = $_POST['payment_method'];
$email = $_SESSION['email']; // Get the user's email from the session

// Here, you can add payment processing logic.
// For demonstration, we'll assume payment is successful.

try {
    // Start a transaction
    $conn->begin_transaction();

    // Insert order details into an orders table
    $stmt = $conn->prepare("INSERT INTO orders (email, total_amount, payment_method, order_date) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sds", $email, $total_amount, $payment_method);
    if (!$stmt->execute()) {
        throw new Exception("Failed to create order: " . $stmt->error);
    }

    // Get the last inserted order ID
    $order_id = $conn->insert_id;

    // Fetch cart items for this user
    $stmt = $conn->prepare("SELECT product_id, quantity FROM cart WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Insert each cart item into an order_items table
    $insert_order_items_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
    while ($item = $result->fetch_assoc()) {
        $insert_order_items_stmt->bind_param("iii", $order_id, $item['product_id'], $item['quantity']);
        if (!$insert_order_items_stmt->execute()) {
            throw new Exception("Failed to insert order item: " . $insert_order_items_stmt->error);
        }
    }

    // Commit the transaction
    $conn->commit();

    // Clear the user's cart after successful payment
    $stmt = $conn->prepare("DELETE FROM cart WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $message = "Payment processed successfully! Your order ID is: " . $order_id;

} catch (Exception $e) {
    // Rollback the transaction on error
    $conn->rollback();
    $message = "Payment failed: " . $e->getMessage();
}

// Close the statements and the connection
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
    <link rel="stylesheet" href="payment_done.css"> <!-- Link to your CSS file -->
    <title>Payment Result</title>
</head>
<body>
    <div class="main-container">
        <h1>Payment Result</h1>
        <p><?php echo htmlspecialchars($message); ?></p>
        <a href="Homepage.php">Go to Home</a>
    </div>
</body>
</html>
