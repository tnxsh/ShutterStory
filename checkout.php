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

$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "User not found.";
    exit();
}

$stmt = $conn->prepare("SELECT p.product_name, p.price, c.quantity FROM cart c JOIN products p ON c.product_id = p.product_id WHERE c.email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
$total_amount = 0;

while ($item = $result->fetch_assoc()) {
    $cart_items[] = $item;
    $total_amount += $item['price'] * $item['quantity'];
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
    <link rel="stylesheet" href="contact.css"> 
    <title>Checkout</title>
    <script>
        function toggleCreditCardDetails() {
            const paymentMethod = document.querySelector('select[name="payment_method"]').value;
            const creditCardDetails = document.getElementById('creditCardDetails');
            const creditCardInputs = creditCardDetails.querySelectorAll('input');

            if (paymentMethod === 'credit_card') {
                creditCardDetails.style.display = 'block';
                creditCardInputs.forEach(input => input.setAttribute('required', 'required'));
            } else {
                creditCardDetails.style.display = 'none';
                creditCardInputs.forEach(input => input.removeAttribute('required'));
            }
        }
    </script>
</head>
<body>
    <div class="main-container">
        <div class="rectangle">
            <div class="account-alert-outline"></div>
            <div class="shutter-story">
                <span class="shutter">Shutter</span><span class="story">Story</span>
            </div>
            <div class="shopping-cart-outlined"><div class="vector-1"></div></div>
            <span class="rental-service">Photography Service</span>
            <span class="contact-2">Contact</span>
            <a href="Homepage.php" class="home">Home</a>
            <span class="shop">Product</span>
            <div class="mdi-account-alert-outline"></div>
        </div>
        <div class="rectangle-3">
            <div class="meubel-house-logos"></div>
            <span class="contact-4">Checkout</span>
        </div>
        <div class="checkout-container">
            <h2>User Information</h2>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
            <p><strong>Address:</strong> 
    <?php 
        echo htmlspecialchars($user['add_line1']); 
        if (!empty($user['add_line2'])) echo ' ' . htmlspecialchars($user['add_line2']); 
        if (!empty($user['add_line3'])) echo ' ' . htmlspecialchars($user['add_line3']); 
    ?>
</p>

            <h2>Your Cart</h2>
            <table>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                            <td>RM <?php echo number_format($item['price'], 2); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>RM <?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h3 style=" margin-left: 1320px;">Total Amount: RM <?php echo number_format($total_amount, 2); ?></h3>

            <h2>Payment Information</h2>
            <form action="process_payment.php" method="POST">
                <input type="hidden" name="total_amount" value="<?php echo $total_amount; ?>">
                <div>
                        <label for="payment_method" style="font-size: xx-large;
                        margin-left: 100px;">Payment Method:</label> 
                        <select name="payment_method" onchange="toggleCreditCardDetails()" required>
                        <option value="" disabled selected style="color: black;">Choose payment method</option>
                        <option value="credit_card">Credit Card</option>
                        <option value="paypal">Cash on Delivery</option>
                    </select>
                </div>

                <div id="creditCardDetails" style="display: none;">
                    <h3>Credit Card Details</h3>
                    <div>
                        <label for="card_number">Card Holder Name:</label>
                        <input type="text" name="card_number" required>
                    </div>
                    <div>
                        <label for="card_number">Card Number:</label>
                        <input type="number" name="card_number" required>
                    </div>
                    <div>
                        <label for="card_expiry">Expiry Date (MM/YY):</label>
                        <input type="month" name="card_expiry" required>
                    </div>
                    <div>
                        <label for="card_cvc">CCV:</label>
                        <input type="number" name="card_cvc" required>
                    </div>
                </div>

                <button type="submit">Complete Purchase</button>
              </form>

              <style>
   
   #creditCardDetails {
      margin-left: 222px;
      margin-right: 670px;
      margin-top: 38px;
      background-color: #f9f9f9;
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);    }

    #creditCardDetails h3 {
        color: #333; 
        margin-bottom: 15px;
    }

    #creditCardDetails div {
        margin-bottom: 15px; 
    }

    #creditCardDetails label {
        display: block; 
        font-weight: bold; 
        margin-bottom: 5px; 
        color: #555; 
    }

    #creditCardDetails input {
        width: 100%; 
        padding: 10px; 
        border: 1px solid #ccc;
        border-radius: 5px; 
        font-size: 16px; 
        transition: border-color 0.3s; 
    }

    #creditCardDetails input:focus {
        border-color: #007bff; 
        outline: none; 
    }
</style>


        </div>
    </div>
</body>
</html>
