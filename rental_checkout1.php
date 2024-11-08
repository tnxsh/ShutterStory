<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: Login.html");
    exit();
}


// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Your database password
$dbname = "shutterstory_db"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize rental details
$product_id = $pickup_date = $return_date = $daily_rate = $total_cost = "";

// Fetch rental details from POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $pickup_date = $_POST['pickup_date'];
    $return_date = $_POST['return_date'];

    // Fetch daily rental rate
    $stmt = $conn->prepare("SELECT daily_rate FROM rental_rates WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $rental_rate = $result->fetch_assoc();

    if ($rental_rate) {
        $daily_rate = $rental_rate['daily_rate'];
        
        // Calculate total cost
        $total_days = (strtotime($return_date) - strtotime($pickup_date)) / (60 * 60 * 24);
        $total_cost = $total_days * $daily_rate;
    } else {
        echo "<p>Rental rate not found for this product.</p>";
    }
}

// Initialize product name
$product_name = '';

// Fetch rental details from POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $pickup_date = $_POST['pickup_date'];
    $return_date = $_POST['return_date'];

    // Fetch rental rates
    $stmt = $conn->prepare("SELECT daily_rate, weekly_rate, monthly_rate FROM rental_rates WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $rental_rate = $result->fetch_assoc();

    if ($rental_rate) {
        $daily_rate = $rental_rate['daily_rate'];
        
        // Calculate total cost based on rental duration
        $total_days = (strtotime($return_date) - strtotime($pickup_date)) / (60 * 60 * 24);

        if ($total_days < 0) {
            echo "<p>Return date must be after pickup date.</p>";
            exit();
        }

        if ($total_days < 7) {
            $total_cost = $total_days * $daily_rate; // Daily rate
        } elseif ($total_days < 30) {
            // Calculate weekly rate
            $weekly_rate = $rental_rate['weekly_rate'];
            $total_weeks = ceil($total_days / 7);
            $total_cost = $total_days * $weekly_rate; // Weekly rate
        } else {
            // Calculate monthly rate
            $monthly_rate = $rental_rate['monthly_rate'];
            $total_months = ceil($total_days / 30);
            $total_cost = $total_days * $monthly_rate; // Monthly rate
        }
    } else {
        echo "<p>Rental rate not found for this product.</p>";
    }
}

// Fetch product name if rental details are set
if (!empty($product_id)) {
    $stmt = $conn->prepare("SELECT product_name FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $product_name = $product ? htmlspecialchars($product['product_name']) : 'Product not found';
}

// Handle form submission for rental checkout
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['id_card'])) {
    if ($_FILES['id_card']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $file_name = basename($_FILES['id_card']['name']);
        $target_file = $upload_dir . $file_name;

        // Check if upload directory exists, if not create it
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        // Move uploaded file
        if (move_uploaded_file($_FILES['id_card']['tmp_name'], $target_file)) {
            $id_card_path = $target_file;

            // Insert rental details into the database
            $user_id = $_SESSION['user_id']; // Assuming user ID is stored in session
            $stmt = $conn->prepare("INSERT INTO rentals (product_id, user_id, pickup_date, return_date, total_cost, id_card_path) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iissds", $product_id, $user_id, $pickup_date, $return_date, $total_cost, $id_card_path);

            if ($stmt->execute()) {
                // Rental successful
                echo "<p>Rental successful!</p>";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error uploading ID card.";
        }
    } else {
        echo "No ID card uploaded or upload error.";
    }
}

$conn->close(); // Close connection only after all operations are complete
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="rental_checkout.css"> <!-- Link to your external CSS -->
    <title>Rental Checkout</title>
    <style>
        .payment-methods {
            margin-top: 20px;
        }
        .credit-card-form {
            display: none; /* Initially hidden */
            margin-top: 10px;
        }
        .rental-agreement {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
        }
    </style>
    <script>
        function togglePaymentForm() {
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
            const creditCardForm = document.getElementById('credit-card-form');
            if (paymentMethod === 'credit_card') {
                creditCardForm.style.display = 'block';
            } else {
                creditCardForm.style.display = 'none';
            }
        }
    </script>
</head>
<body>
    <div class="rental-container">
        <h1>Rental Checkout</h1>
        
        <?php if ($total_cost > 0): ?>
            <div class="rental-agreement">
                <h2>Rental Details</h2>
                <p>Product Name: <?php echo $product_name; ?></p>
                <p>Pickup Date: <?php echo htmlspecialchars($pickup_date); ?></p>
                <p>Return Date: <?php echo htmlspecialchars($return_date); ?></p>
                <p>Daily Rate: RM<?php echo htmlspecialchars($daily_rate); ?></p>
                <p>Total Cost: RM<?php echo number_format($total_cost, 2); ?></p>
            </div>

            <h2>Rental Agreement</h2>
               <h3>1. Rental Term</h3>
                <p>The rental period begins on the specified start date and ends on the specified end date. 
                    Extensions may be requested and are subject to availability.</p>

                <h3>2. Rental Rates</h3>
                <p>The Lessee agrees to pay the rental rate as specified at the time of rental. 
                    Payment must be made in full prior to the commencement of the rental term.</p>

                <h3>3. Security Deposit</h3>
                <p>A security deposit may be required at the time of rental. 
                    This deposit will be held to cover any potential damages or unpaid fees and will be 
                    returned within a specified period after the rental term, 
                    subject to deductions for any damages or outstanding charges.</p>

                <h3>4. Usage Restrictions</h3>
                <p>The Lessee agrees to use the rented equipment for its intended purpose and in compliance with all applicable laws. 
                    The Lessee shall not modify or sub-rent the equipment without prior written consent from the Lessor.</p>

                <h3>5. Care and Maintenance</h3>
                <p>The Lessee is responsible for the proper care and maintenance of the rented equipment during the rental period. 
                    Any damage or malfunctions must be reported to the Lessor immediately.</p>

                <h3>6. Insurance</h3>
                <p>The Lessee may be required to maintain insurance coverage for the rented equipment throughout the rental period. 
                    Proof of insurance may be requested by the Lessor.</p>

                <h3>7. Liability</h3>
                <p>The Lessee assumes all risks associated with the use of the rented equipment and agrees to indemnify 
                    the Lessor against any claims or damages arising from the use of the equipment.</p>

                <h3>8. Damage and Loss</h3>
                <p>In the event of damage, loss, or theft of the rented equipment, the Renter is responsible for 
                    repair or replacement costs as determined by the Renter.</p>

                <h3>9. Termination</h3>
                <p>Either party may terminate this Agreement upon written notice if the other party fails to
                     comply with any terms of this Agreement.</p>

                <h3>10. Governing Law</h3>
                <p>This Agreement shall be governed by the laws of the applicable jurisdiction.</p>

                <h3>11. Acceptance of Terms</h3>
                <p>By completing the rental process, the Lessee acknowledges and accepts the terms and 
                    conditions outlined in this Agreement.</p>

            <h2>Upload ID Card</h2>
                <label for="id_card">To confirm your acceptance of this agreement, Please Upload a Copy of Your ID Card:</label>
                <input type="file" id="id_card" name="id_card" accept="image/*" required>
                
                <!-- Hidden fields to retain rental details -->
                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>">
                <input type="hidden" name="pickup_date" value="<?php echo htmlspecialchars($pickup_date); ?>">
                <input type="hidden" name="return_date" value="<?php echo htmlspecialchars($return_date); ?>">

                <h2>Choose Payment Method</h2>
                <div class="payment-methods">
                    <label>
                        <input type="radio" name="payment_method" value="credit_card" onclick="togglePaymentForm()" required>
                        Credit Card
                    </label>
                </div>

                <form action="rental_confirm.php" method="POST">
                <div id="credit-card-form" class="credit-card-form">
                    <h3>Credit Card Information</h3>
                    <label for="card_name">Name on Card:</label>
                    <input type="text" id="card_name" name="card_name" required>
                    
                    <label for="card_number">Card Number:</label>
                    <input type="text" id="card_number" name="card_number" required>
                    
                    <label for="expiry_date" style="margin-left: 150px;">Expiry Date:</label> 
                    <input type="month" id="expiry_date" name="expiry_date" required>

                    <label for="cvv">CVV:</label>
                    <input type="text" id="cvv" name="cvv" required>
                </div>

                    <input type="hidden" name="total_amount" value="<?php echo $total_amount; ?>">
                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                    <!-- Add any other necessary fields here -->
                    <button type="submit">Confirm Rental</button>
            </form>
        <?php else: ?>
            <p>No rental details found. Please return to the rental details page.</p>
        <?php endif; ?>
    </div>
</body>
</html>
