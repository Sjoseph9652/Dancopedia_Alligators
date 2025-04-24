<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dancopedia - Password Reset</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/chatbot.css">
    <link rel="stylesheet" href="css/custom_style.css">
</head>
<body>

<?php include "includes/navbar.php"; ?>

<main>
    <section class="py-5">
        <div class="container text-center">

            <h2>Reset Password</h2>
            <br>

            <?php
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $token = $_POST["token"];
                $password = $_POST["password"];
                $password_confirmation = $_POST["password_confirmation"];

                if ($password !== $password_confirmation) {
                    echo '<div class="alert alert-warning shadow-sm">Passwords do not match.</div>';
                    exit;
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
                    echo '<div class="alert alert-danger shadow-sm">Token is invalid or has expired.</div>';
                    exit;
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

                echo '<div class="alert alert-success shadow-sm">Password updated successfully! You can now <a href="LoginForm.php" class="alert-link">log in</a>.</div>';
            }
            ?>

        </div>
    </section>
</main>

<?php include "includes/footer.php"; ?>
<?php include "includes/chatbot_code.php"; ?>

</body>
</html>
