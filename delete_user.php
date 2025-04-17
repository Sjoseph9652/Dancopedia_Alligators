<?php
session_start();
// Connection variables
$servername = "metro.proxy.rlwy.net";
$dbname = "railway";
$username = "root";
$password = "ZvOusNgFFhFQyzSIOouCCAUDqYVJFhCJ";
$port = 55656;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['email'])) {
        echo json_encode(["success" => false, "error" => "Unauthorized"]);
        exit;
    }
// connection object
    $conn = mysqli_connect($host, $username, $password, $dbname, $port);

// checks for a connection error 
    if (mysqli_connect_errno()) 
    {
        die("Connection Error: " . mysqli_connect_error());
    }

    $id = $_POST['user_id'];

    $sql = "DELETE FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Failed to delete dance"]);
    }
}
?>