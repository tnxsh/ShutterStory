<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$email = $_GET['email'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $sql = "UPDATE USERS SET username='$username', password='$password', role='$role' WHERE email='$email'";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: manage_users.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

$sql = "SELECT * FROM USERS WHERE email='$email'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h2 class="mt-5">Edit User</h2>
    <form action="edit_user.php?email=<?php echo $email; ?>" method="post">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" name="username" value="<?php echo $user['username']; ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" name="password" value="<?php echo $user['password']; ?>" required>
        </div>
        <div class="form-group">
            <label for="role">Role:</label>
            <select class="form-control" name="role" required>
                <option value="user" <?php if ($user['role'] == 'user') echo 'selected'; ?>>User</option>
                <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>

</body>
</html>
