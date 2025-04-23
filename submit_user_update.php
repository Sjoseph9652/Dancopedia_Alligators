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
    $user_id = $_POST['user_id'];
    $email = trim(strtolower($_POST['email']));
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $role = $_POST['role'];
    $active = $_POST['active'];
    $modified = date("Y-m-d H:i:s");

    $stmt = $conn->prepare("UPDATE users SET email=?, first_name=?, last_name=?, role=?, active=?, modified_time=? WHERE id=?");
    $stmt->bind_param("ssssssi", $email, $first_name, $last_name, $role, $active, $modified, $user_id);

    if ($stmt->execute()) {
        header("Location: admin_users.php?success=updated");
    } else {
        echo "Error updating user: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
