<?php
session_start();
// Connection variables 
$host = "localhost";
$dbname = "gatorz_db";
$username = "root";
$password = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['email'])) {
        echo json_encode(["success" => false, "error" => "Unauthorized"]);
        exit;
    }
// connection object
    $conn = mysqli_connect($host, $username, $password, $dbname, 3306);

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