<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $site_title = $_POST['site_title'];

    $stmt = $conn->prepare("UPDATE settings SET value = ? WHERE name = 'site_title'");
    $stmt->bind_param("s", $site_title);
    
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Settings updated successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error updating settings: " . $conn->error . "</div>";
    }
}

$settings_result = mysqli_query($conn, "SELECT * FROM settings");
$settings = [];
while ($row = mysqli_fetch_assoc($settings_result)) {
    $settings[$row['name']] = $row['value'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Settings</h2>
    <form method="post" action="settings.php">
        <div class="form-group">
            <label for="site_title">Site Title</label>
            <input type="text" class="form-control" id="site_title" name="site_title" value="<?php echo isset($settings['site_title']) ? $settings['site_title'] : ''; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>
</div>
</body>
</html>
