<?php
session_start();

$host = "metro.proxy.rlwy.net";
$dbname = "railway";
$username = "root";
$password = "ZvOusNgFFhFQyzSIOouCCAUDqYVJFhCJ";
$port = 55656;

$email = $_SESSION['email'] ?? null;
$title = $_POST['title'] ?? null;
$comment = $_POST['comment'] ?? null;
$stars = isset($_POST['stars']) && $_POST['stars'] !== '' ? floatval($_POST['stars']) : null;
$dance_id = $_POST['dance_id'] ?? null;

if (!$email || !$dance_id || (!$title && !$comment && !$stars)) {
    http_response_code(400);
    echo "Missing required fields";
    exit;
}

// connect to db
$conn = mysqli_connect($host, $username, $password, $dbname);
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}

// get user id from session email
$user_sql = "SELECT id FROM users WHERE email = ?";
$user_stmt = mysqli_prepare($conn, $user_sql);
mysqli_stmt_bind_param($user_stmt, "s", $email);
mysqli_stmt_execute($user_stmt);
$result = mysqli_stmt_get_result($user_stmt);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    http_response_code(403);
    echo "User not found.";
    exit;
}

$user_id = $user['id'];

// insert interaction
$sql = "INSERT INTO interactions (title, comment, stars, dance_id, user_id, created_on)
        VALUES (?, ?, ?, ?, ?, NOW())";

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    die("Prepare failed: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "ssddi", $title, $comment, $stars, $dance_id, $user_id);
$success = mysqli_stmt_execute($stmt);

if ($success) {
    echo "Success";
} else {
    echo "Insert failed: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
