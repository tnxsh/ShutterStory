<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Confirmation</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .confirmation-container {
            margin-top: 100px;
            padding: 40px;
            max-width: 500px;
            text-align: center;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-left: auto;
            margin-right: auto;
        }
        .confirmation-container h1 {
            font-size: 28px;
            color: #28a745;
            font-weight: bold;
        }
        .confirmation-container p {
            font-size: 18px;
            color: #555;
            margin-bottom: 20px;
        }
        .btn-home {
            font-size: 16px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn-home:hover {
            background-color: #0056b3;
            color: #ffffff;
        }
    </style>
</head>
<body>

<div class="container confirmation-container">
    <h1>Rental Payment Successful!</h1>
    <p>Your rental has been successfully submitted. Thank you for choosing ShutterStory!</p>
    <a href="homepage.php" class="btn-home">Go to Home</a>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
