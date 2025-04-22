<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
header('Content-Type: application/json');

file_put_contents("log.txt", print_r($_POST, true));

$host = "localhost";
$dbname = "gatorz_db";
$username = "root";
$password = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
        echo json_encode(["success" => false, "error" => "Unauthorized"]);
        exit;
    }

    $conn = new mysqli($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        echo json_encode(["success" => false, "error" => "DB connection failed"]);
        exit;
    }

    $ids = $_POST['dance_ids'] ?? [];
    $new_status = $_POST['new_status'] ?? null;

    if (!is_array($ids) || !in_array($new_status, ['0', '1'], true)) {
        echo json_encode(["success" => false, "error" => "Invalid input"]);
        exit;
    }

    foreach ($ids as $id) {
        $stmt = $conn->prepare("UPDATE dances SET status = ? WHERE dance_ID = ?");
        $stmt->bind_param("ii", $new_status, $id);
        $stmt->execute();
        $stmt->close();
    }

    $conn->close();
    echo json_encode(["success" => true]);
    exit;
}

echo json_encode(["success" => false, "error" => "Invalid request method"]);
exit;
?>
