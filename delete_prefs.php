<?php
session_start();

$host = "localhost";
$dbname = "gatorz_db";
$username = "root";
$password = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
        echo json_encode(["success" => false, "error" => "Unauthorized"]);
        exit;
    }

    $conn = mysqli_connect($host, $username, $password, $dbname, 3306);
    if (mysqli_connect_errno()) {
        die("Connection Error: " . mysqli_connect_error());
    }

    $id = $_POST['pref_id'];

    $sql = "DELETE FROM preferences WHERE pref_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Failed to delete preference"]);
    }
}
?>