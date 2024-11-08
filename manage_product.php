<?php
session_start();
include 'config.php'; 

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}


$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Products</title>
    <link rel="stylesheet" href="manage_product.css"> 
</head>
<body>

<h2>Manage Products</h2>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Price (RM)</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo $row['product_id']; ?></td>
        <td><?php echo $row['product_name']; ?></td>
        <td><?php echo $row['description']; ?></td>
        <td><?php echo $row['price']; ?></td>
        <td>
            <a href="edit_product.php?id=<?php echo $row['product_id']; ?>">Edit</a>
            <a href="delete_product.php?id=<?php echo $row['product_id']; ?>">Delete</a>
        </td>
    </tr>
    <?php } ?>
</table>

<a href="add_product.php">Add New Product</a>

</body>
</html>