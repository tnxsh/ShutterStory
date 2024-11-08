<?php
session_start();
include 'config.php'; 

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 

    $stmt = $conn->prepare("DELETE FROM feedback WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: admin_dashboard.php?message=Feedback deleted successfully");
        exit();
    } else {
        echo "Error deleting feedback: " . mysqli_error($conn);
    }
} else {
    echo "Invalid feedback ID.";
}
?>
