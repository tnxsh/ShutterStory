<?php
session_start();
include 'config.php'; 

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

$id = $_GET['id'];

$sql = "SELECT * FROM products WHERE product_id = $id";
$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    
    if ($_FILES['image']['tmp_name']) {
        $image = $_FILES['image']['tmp_name'];
        $image_data = addslashes(file_get_contents($image));
        $sql = "UPDATE products SET product_name='$product_name', description='$description', price='$price', image='$image_data' WHERE product_id=$id";
    } else {
        $sql = "UPDATE products SET product_name='$product_name', description='$description', price='$price' WHERE product_id=$id";
    }
    
    if (mysqli_query($conn, $sql)) {
        header("Location: manage_products.php");
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
    <title>Edit Product</title>
    <style>
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            width: 400px;
            background-color: #fff;
            padding: 52px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            color: #555;
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        textarea {
            resize: vertical;
            height: 80px;
        }

        button[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s;
        }

        .back-link:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Edit Product</h2>

    <form action="edit_product.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
        <label>Product Name:</label>
        <input type="text" name="product_name" value="<?php echo $product['product_name']; ?>" required>
        
        <label>Description:</label>
        <textarea name="description" required><?php echo $product['description']; ?></textarea>
        
        <label>Price:</label>
        <input type="text" name="price" value="<?php echo $product['price']; ?>" required>
        
        <label>Image:</label>
        <input type="file" name="image" accept="image/*">
        
        <button type="submit">Update Product</button>
    </form>

    <a href="manage_products.php" class="back-link">Back to Manage Products</a>
</div>

</body>
</html>
