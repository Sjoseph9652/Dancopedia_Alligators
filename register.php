<?php
session_start();
require 'db_configuration.php';

// Handle new user registration
if (isset($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['password'])) {
    $first_name = $db->escape_string($_POST['first_name']);
    $last_name = $db->escape_string($_POST['last_name']);
    $email = $db->escape_string($_POST['email']);
    $hashPass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email_validation = substr(md5(rand(0, 1000)), 0, 10);

    $sql = "INSERT INTO users (first_name, last_name, email, hash, active, role, modified_time, created_time)"
         . " VALUES ('$first_name', '$last_name', '$email', '$hashPass', '$email_validation', 'user', NOW(), NOW())";

    if ($db->query($sql)) {
        $_SESSION['email'] = $email;
        header("Location: LoginForm.php?success=registered");
        exit();
    } else {
        header("Location: LoginForm.php?error=registration_failed");
        exit();
    }
}
?>
