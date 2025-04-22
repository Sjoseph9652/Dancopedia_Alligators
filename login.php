<?php
session_start();
require 'db_configuration.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim(strtolower($_POST['email']));
    $password = trim($_POST['password']);

    // Include the role column in your SELECT
    $stmt = $db->prepare("SELECT id, first_name, email, hash, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            header("Location: index.php");
            exit();
        } else {
            header("Location: LoginForm.php?error=invalidpassword");
            exit();
        }
    } else {
        header("Location: LoginForm.php?error=nouser");
        exit();
    }
}
?>
