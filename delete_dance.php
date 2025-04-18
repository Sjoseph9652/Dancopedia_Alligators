<?php
session_save_path('/tmp')
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

    $id = $_POST['dance_ID'];

    $sql = "DELETE FROM dances WHERE dance_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Failed to delete dance"]);
    }
}
?>