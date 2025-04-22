<?php
session_start();

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

    $ids = $_POST['user_ids'] ?? [];
    $new_status = $_POST['new_status'] ?? null;

    if (!is_array($ids) || !$new_status) {
        echo json_encode(["success" => false, "error" => "Invalid input"]);
        exit;
    }

    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $types = str_repeat('i', count($ids));
    $stmt = $conn->prepare("UPDATE users SET active = ? WHERE id IN ($placeholders)");

    $params = array_merge([$new_status], $ids);
    $bind_types = 's' . $types;

    $stmt->bind_param($bind_types, ...$params);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Failed to update status"]);
    }

    $stmt->close();
    $conn->close();
}
?>
