<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

$feedback = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(trim($_POST["message"]));

    if (empty($name) || empty($email) || empty($message)) {
        $feedback = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $feedback = "Invalid email format.";
    } else {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USERNAME;
            $mail->Password = SMTP_PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = SMTP_PORT;

            $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
            $mail->addAddress(SMTP_FROM_EMAIL); // Send to yourself or another recipient

            $mail->isHTML(true);
            $mail->Subject = "Contact Message from $name";
            $mail->Body = "
                <h4>New Contact Submission</h4>
                <p><strong>Name:</strong> $name</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Message:</strong><br>$message</p>
            ";

            $mail->send();
            $feedback = "Message sent! Please check your inbox.";
        } catch (Exception $e) {
            $feedback = "Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Dancopedia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/chatbot.css">
    <link rel="stylesheet" href="css/custom_style.css">
</head>
<body>

<?php include "includes/navbar.php"; ?>

<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <?php if (!empty($feedback)): ?>
                <div class="alert <?= str_starts_with($feedback, "Message sent") ? 'alert-success' : 'alert-danger' ?>" role="alert">
                    <?= $feedback ?>
                </div>
            <?php endif; ?>

            <a href="contact.php" class="btn btn-outline-primary mt-3">Back to Contact Page</a>
        </div>
    </div>
</main>

<?php include "includes/footer.php"; ?>
<?php include "includes/chatbot_code.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
