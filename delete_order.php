<?php
session_start();
include 'config.php'; 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    $conn->begin_transaction();

    try {
        $stmt = $conn->prepare("DELETE FROM order_items WHERE order_id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();

        $stmt = $conn->prepare("DELETE FROM orders WHERE order_id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();

        $conn->commit();

        header('Location: manage_orders.php?status=deleted'); 
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error deleting order: " . $e->getMessage();
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
    }
} else {
    echo "No order ID provided.";
}

$conn->close();
?>
