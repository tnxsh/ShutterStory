<?php
// Get product ID from the URL
$product_id = $_GET['id'];

// Fetch product details from the `products` table
$query = "SELECT * FROM products WHERE product_id = $product_id AND is_rental = 1";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);
?>

<html>
<head>
    <title><?php echo $product['product_name']; ?> - Rental</title>
    <!-- Include necessary CSS and JS -->
</head>
<body>
    <h1><?php echo $product['product_name']; ?></h1>
    <img src="data:image/jpeg;base64,<?php echo base64_encode($product['image']); ?>" />
    <p><?php echo $product['description']; ?></p>
    <p>Rental Price: $<?php echo $product['rental_price']; ?> per day</p>

    <!-- Rental period selection -->
    <form action="rental_checkout.php" method="POST">
        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" required>

        <label for="end_date">End Date:</label>
        <input type="date" name="end_date" required>

        <!-- Hidden fields to pass product data -->
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
        <button type="submit">Rent Now</button>
    </form>
</body>
</html>
