<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: Login.html"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ShutterStory</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" />
    <link rel="stylesheet" href="contact.css" />
  </head>
  <body>
    <div class="main-container">
      <div class="rectangle">
        <div class="account-alert-outline"></div>
        <div class="shutter-story">
          <span class="shutter">Shutter</span><span class="story">Story</span>
        </div>
        <a href="cart.php">
        <div class="shopping-cart-outlined">
            <div class="vector-1"></div>
        </a>
        </div>

        <?php
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            echo '<a style="left: 1800px;" href="my_account.php" class="account">My Account</a>';
        } else {
            echo '<a href="Login.html" class="account">Account</a>';
        }
        ?>
        <span class="rental-service">Photography Service</span>
        <a href="Contact.php" class="contact-2">Contact</a>
        <a href="Homepage.php" class="home">Home</a>
        <a href="Product.php" class="shop">Product</a>
        <a href="Contact.php">
        <div class="mdi-account-alert-outline">
        </div>
        </a>
      </div>
      <div class="rectangle-3">
        <div class="meubel-house-logos"></div>
        <span class="contact-4">Cart</span>
      </div>

      <?php

session_start(); 

$conn = new mysqli('localhost', 'root', '', 'shutterstory_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$session_id = session_id();

$sql = "SELECT products.product_name, products.price, products.image, cart.quantity, cart.product_id 
        FROM cart 
        INNER JOIN products ON cart.product_id = products.product_id
        WHERE cart.session_id = '$session_id'";

$result = $conn->query($sql);

$grand_total = 0;

if ($result->num_rows > 0) {
    echo '<h2>Your Cart</h2>';
    echo '<table border="1">';
    echo '<tr><th>Product Image</th><th>Product Name</th><th>Quantity</th><th>Price</th><th>Total</th><th>Action</th></tr>';
    
    while($row = $result->fetch_assoc()) {
        $product_id = $row['product_id'];
        $product_name = $row['product_name'];
        $quantity = $row['quantity'];
        $price = $row['price'];
        $total = $price * $quantity;
        $image_src = $row['image'] ? 'data:image/jpeg;base64,' . base64_encode($row['image']) : 'path_to_placeholder_image.jpg'; // Use placeholder image
        
        $grand_total += $total;
        
        echo '<tr>';
        echo '<td><img src="' . $image_src . '" alt="Product Image" style="width:100px; height:100px;"></td>';
        echo '<td>' . $product_name . '</td>';
        echo '<td>' . $quantity . '</td>';
        echo '<td>RM' . $price . '</td>';
        echo '<td>RM' . number_format($total, 2) . '</td>';
        echo '<td>';

        echo '<form action="delete_from_cart.php" method="POST" onsubmit="return confirm(\'Are you sure you want to delete this item?\')">';
        echo '<input type="hidden" name="product_id" value="' . $product_id . '">';
        echo '<button type="submit" style="padding:5px 10px; font-size:14px; cursor:pointer;">Delete</button>';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }

    echo '<tr>';
    echo '<td colspan="5" style="text-align:right;"><strong>Grand Total:</strong></td>';
    echo '<td><strong>RM' . number_format($grand_total, 2) . '</strong></td>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<td colspan="6" style="text-align:center;">';
    
    echo '<form action="product.php" method="GET" style="display:inline-block; margin-right: 10px;">';
    echo '<button type="submit" style="padding:10px 20px; font-size:16px; cursor:pointer;">Continue Shopping</button>';
    echo '</form>';
    
    echo '<form action="checkout.php" method="POST" style="display:inline-block;">';
    echo '<input type="hidden" name="session_id" value="' . $session_id . '">';
    echo '<input type="hidden" name="grand_total" value="' . $grand_total . '">'; // Optional: include grand total
    echo '<button type="submit" style="padding:10px 20px; font-size:16px; cursor:pointer;">Proceed to Checkout</button>';
    echo '</form>';
    
    echo '</td>';
    echo '</tr>';

    echo '</table>';
} else {
    echo '<p>Your cart is empty.</p>';
}
?>

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
  </body>
</html>
