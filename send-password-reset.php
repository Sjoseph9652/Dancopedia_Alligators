
<?php
session_start(); 
if (!(isset($_SESSION['email']))) {
    header("Location: LoginForm.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dancopedia - Reset Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/chatbot.css">
    <link rel="stylesheet" href="css/custom_style.css">
    <style>
        .header {
            background-image: url('images/blog_dance2_480x480.webp');
        }
    </style>
</head>
<body>

<?php include "includes/navbar.php"; ?>

<main>
    <section class="py-5">
        <div class="container text-center">
            <h2>Check Your Email!</h2>
            <br>

            <?php
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $email = $_POST["email"];
                $token = bin2hex(random_bytes(16));
                $token_hash = hash("sha256", $token);
                $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

                $mysqli = require __DIR__ . "/db_configuration.php";

                $sql = "UPDATE users
                        SET reset_token_hash = ?,
                            reset_token_expires_at = ?
                        WHERE email = ?";

                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("sss", $token_hash, $expiry, $email);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    $mail = require __DIR__ . "/mailer.php";

                    $mail->addAddress($email);
                    $mail->Subject = "Password Reset";
                    $mail->Body = <<<HTML
                        <p>We received a request to reset your password.</p>
                        <p>Click <a href="http://localhost/Dancopedia_Alligators/reset-password.php?token=$token">here</a> to reset it.</p>
                        <p>If you did not request this, you can safely ignore this email.</p>
                    HTML;

                    try {
                        $mail->send();
                        echo '<div class="alert alert-success shadow-sm mt-4">Password reset email sent! Please check your inbox.</div>';
                    } catch (Exception $e) {
                        echo '<div class="alert alert-danger shadow-sm mt-4">Message could not be sent. Mailer error: ' . $mail->ErrorInfo . '</div>';
                    }
                } else {
                    echo '<div class="alert alert-warning shadow-sm mt-4">No account found with that email address.</div>';
                }

                $stmt->close();
                $mysqli->close();
            }
            ?>
        </div>
    </section>
</main>

<?php include "includes/footer.php"; ?>
<?php include "includes/chatbot_code.php"; ?>

</body>
</html>
