<?php
session_start();
include 'config.php'; 

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

$sql = "SELECT * FROM USERS";
$result = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>

<div class="container">
    <h2 class="mt-5">Manage Users</h2>
    <a href="add_user.php" class="btn btn-success mb-3">Add New User</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Email</th>
                <th>Username</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['role']; ?></td>
                    <td>
                        <a href="edit_user.php?email=<?php echo $row['email']; ?>" class="btn btn-primary">Edit</a>
                        <a href="delete_user.php?email=<?php echo $row['email']; ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>
