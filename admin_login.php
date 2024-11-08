<?php
session_start();
include 'config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);


        $sql = "SELECT * FROM USERS WHERE email = '$email' AND password = '$password' AND role = 'admin'";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            die("Error executing query: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($result) == 1) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_email'] = $email;
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error_message = "Invalid login credentials or you are not an admin.";
        }
    } else {
        $error_message = "Please fill in both email and password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa; 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; 
            margin: 0;
        }
        .login-container {
            background-color: #ffffff; 
            padding: 30px;
            border-radius: 10px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
            width: 300px; 
        }
        .login-container h2 {
            margin-bottom: 20px; 
            text-align: center; 
        }
        .form-group {
            margin-bottom: 15px; 
        }
        .btn-login {
            width: 100%; 
        }
        .error-message {
            color: red; 
            text-align: center; 
            margin-top: 10px; 
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Admin Login</h2>
    <?php if (isset($error)): ?>
        <div class="error-message"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="post" action="admin_login.php">
        <div class="form-group">
            <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <input type="submit" class="btn btn-primary btn-login" value="Login">
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
