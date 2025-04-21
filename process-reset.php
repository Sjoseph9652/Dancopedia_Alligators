<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $token = $_POST["token"];
    $password = $_POST["password"];
    $password_confirmation = $_POST["password_confirmation"];

    if ($password !== $password_confirmation) {
        die("Passwords do not match.");
    }

    $token_hash = hash("sha256", $token);

    $mysqli = require __DIR__ . "/db_configuration.php";

    // Step 1: Find user with valid token
    $sql = "SELECT * FROM users
            WHERE reset_token_hash = ?
            AND reset_token_expires_at > NOW()";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $token_hash);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        die("Token is invalid or has expired.");
    }

    // Step 2: Hash the new password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Step 3: Update password and clear token
    $sql = "UPDATE users
            SET hash = ?, reset_token_hash = NULL, reset_token_expires_at = NULL
            WHERE id = ?";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("si", $password_hash, $user["id"]);
    $stmt->execute();

    echo "Password updated successfully. You can now <a href='LoginForm.php'>log in</a>.";
}
?>
