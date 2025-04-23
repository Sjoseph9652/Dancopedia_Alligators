<?php
session_start();

$host = "localhost";
$dbname = "gatorz_db";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim(strtolower($_POST['email']));
    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $active = $_POST['active'];
    $created = date("Y-m-d H:i:s");
    $modified = $created;

    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, hash, role, active, created_time, modified_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $first_name, $last_name, $email, $hashed_password, $role, $active, $created, $modified);

    if ($stmt->execute()) {
        header("Location: admin_users.php?success=created");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
