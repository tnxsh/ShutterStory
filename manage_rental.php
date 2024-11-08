<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'config.php'; 

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

$sql = "SELECT r.rental_id, p.product_name, r.email, r.pickup_date, r.return_date, r.total_cost, r.id_card_path 
        FROM rentals r 
        JOIN products p ON r.product_id = p.product_id";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Rentals</title>
    <link rel="stylesheet" href="manage_rental.css"> 
</head>
<body>
    <h2 style="margin-bottom: 925px; margin-left: 950px;">Manage Rentals</h2>               
        <table class="table table-bordered">
        <thead>
            <tr>
                <th>Rental ID</th>
                <th>Product Name</th>
                <th>User Email</th>
                <th>Pickup Date</th>
                <th>Return Date</th>
                <th>Total Cost</th>
                <th>ID Card</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['rental_id']; ?></td>
                    <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['pickup_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['return_date']); ?></td>
                    <td>RM<?php echo number_format($row['total_cost'], 2); ?></td>
                    <td><a href="<?php echo htmlspecialchars($row['id_card_path']); ?>" target="_blank">View ID</a></td>
                    <td>
                        <a href="delete_rental.php?id=<?php echo $row['rental_id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
