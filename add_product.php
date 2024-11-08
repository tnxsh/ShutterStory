<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'config.php'; 

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_Login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $image = $_FILES['image']['tmp_name'];


    if ($image) {
        $image_data = addslashes(file_get_contents($image));
    } else {
        $image_data = null;
    }


    $sql = "INSERT INTO products (product_name, description, price, image) VALUES ('$product_name', '$description', '$price', '$image_data')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: manage_product.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="add_product.css">
</head>
<body>

<h2> Add New Product </h2>

<form action="add_product.php" method="POST" enctype="multipart/form-data">
    <label>Product Name:</label>
    <input type="text" name="product_name" required><br>
    
    <label>Description:</label>
    <textarea name="description" required></textarea><br>
    
    <label>Price:</label>
    <input type="text" name="price" required><br>
    
    <label>Image:</label>
    <input type="file" name="image" accept="image/*"><br>
    
    <button type="submit">Add Product</button>
</form>

<a href="manage_product.php">Back to Manage Products</a>

</body>
</html>
