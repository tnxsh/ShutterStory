<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

$product_id = $pickup_date = $return_date = $daily_rate = $total_cost = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $pickup_date = $_POST['pickup_date'];
    $return_date = $_POST['return_date'];

    if (!DateTime::createFromFormat('Y-m-d', $pickup_date) || !DateTime::createFromFormat('Y-m-d', $return_date)) {
        echo "<p>Error: Please provide valid dates in YYYY-MM-DD format.</p>";
        exit();
    }

    $stmt = $conn->prepare("SELECT daily_rate, weekly_rate, monthly_rate FROM rental_rates WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $rental_rate = $result->fetch_assoc();

    if ($rental_rate) {
        $daily_rate = $rental_rate['daily_rate'];
        
        $total_days = (strtotime($return_date) - strtotime($pickup_date)) / (60 * 60 * 24);
        
        if ($total_days < 0) {
            echo "<p>Return date must be after pickup date.</p>";
            exit();
        }

        if ($total_days < 7) {
            $total_cost = $total_days * $daily_rate;  // Daily rate
        } 
        elseif ($total_days < 30) {
            $weekly_rate = $rental_rate['weekly_rate'];
            $total_weeks = ceil($total_days / 7);
            $total_cost = $total_weeks * $weekly_rate; // Weekly rate
        } 
        else {
            $monthly_rate = $rental_rate['monthly_rate'];
            $total_months = ceil($total_days / 30);
            $total_cost = $total_months * $monthly_rate; // Monthly rate
        }
    } else {
        echo "<p>Rental rate not found for this product.</p>";
    }
}

$product_name = '';
if (!empty($product_id)) {
    $stmt = $conn->prepare("SELECT product_name FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $product_name = $product ? htmlspecialchars($product['product_name']) : 'Product not found';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['id_card'])) {
    if ($_FILES['id_card']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $file_name = basename($_FILES['id_card']['name']);
        $target_file = $upload_dir . $file_name;

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        if (move_uploaded_file($_FILES['id_card']['tmp_name'], $target_file)) {
            $id_card_path = $target_file;

            $email = $_SESSION['email']; 
            $stmt = $conn->prepare("INSERT INTO rentals (product_id, email, pickup_date, return_date, total_cost, id_card_path) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issdss", $product_id, $email, $pickup_date, $return_date, $total_cost, $id_card_path);

            if ($stmt->execute()) {
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

$conn->close(); 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="rental_checkout.css"> 
    <title>Rental Checkout</title>
    <style>
        .payment-methods {
            margin-top: 20px;
        }
        .credit-card-form {
            display: none; 
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
            <h3>11. Acceptance</h3>
            <p>By signing below, the Lessee agrees to the terms and conditions outlined in this Agreement.</p>

            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>">
                <input type="hidden" name="pickup_date" value="<?php echo htmlspecialchars($pickup_date); ?>">
                <input type="hidden" name="return_date" value="<?php echo htmlspecialchars($return_date); ?>">
                <label for="id_card">Upload ID Card:</label>
                <input type="file" name="id_card" id="id_card" required>
                
                <div class="payment-methods">
                    <h3>Select Payment Method</h3>
                    <input type="radio" name="payment_method" value="credit_card" onchange="togglePaymentForm()"> Credit Card
                    <div id="credit-card-form" class="credit-card-form">
                        <h4>Credit Card Details</h4>
                        <label for="card_number">Name on Card</label>
                        <input type="text" name="name_card" required>
                        <label for="card_number">Card Number:</label>
                        <input type="number" name="card_number" required>
                        <label for="expiry_date">Expiry Date:</label>
                        <input type="month" name="expiry_date" required>
                        <label for="cvv">CVV:</label>
                        <input type="number" name="cvv" required>
                    </div>
                </div>
                
                <button type="submit">Confirm Rental</button>
                
            </form>
        <?php else: ?>
            <p>No rental details available. Please select a product to rent.</p>
        <?php endif; ?>
    </div>
</body>
</html>
