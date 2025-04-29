<?php
session_start();
header('Content-Type: application/json');

// Connection variables
$host = 'localhost';
$dbname = 'gatorz_db';
$username = 'root';
$password = '';
$port = 3306;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['email'])) {
        echo json_encode(["success" => false, "error" => "Unauthorized"]);
        exit;
    }

    $conn = mysqli_connect($host, $username, $password, $dbname, $port);
    if (mysqli_connect_errno()) {
        echo json_encode(["success" => false, "error" => "Connection Error: " . mysqli_connect_error()]);
        exit;
    }

    $id = $_POST['interaction_id'] ?? null;
    if (!$id) {
        echo json_encode(["success" => false, "error" => "Missing interaction_id"]);
        exit;
    }

    $sql = "DELETE FROM interactions WHERE interaction_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
    }
}
?>
