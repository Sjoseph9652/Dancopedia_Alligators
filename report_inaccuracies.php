<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dancopedia - Discover Dances</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/chatbot.css"> <!-- Link to your external chatbot CSS -->
    <link rel="stylesheet" href="css/custom_style.css">
</head>
<style>
    /* Header Background, extra */
    .header {
        background-image: url('images/blog_dance2_480x480.webp');
    }


</style>

<body>
<!-- https://getbootstrap.com/docs/5.3/components/navbar/ -->

<!-- navbar -->
<?php include "includes/navbar.php"; ?>


<main>
    <section class="dance-list py-5">
        <div class="container text-center">
            <h2 class="text-center mb-4">Report Inaccuracy</h2>
        
            <form action="report_processing.php" method="POST">
            <div class="mb-3 text-start fw-bold">
                <label class="form-label" for="title">Dance Name</label>
                <input type="text" class="form-control" id="title" name="title" required><br>
            </div>
            <div class="mb-3 text-start fw-bold">
                <label class="form-label" for="complaint">Complaint:</label><br>
                <textarea id="complaint" class="form-control" name="complaint" rows="4" cols="50" required></textarea><br>
            </div>
                <button class="btn btn-outline-success" type="submit">Submit</button>
        </div>
    </section>
</main>


<!-- footer -->
<?php include "includes/footer.php"; ?>

<!-- Include Chatbot -->
<?php include "includes/chatbot_code.php"; ?>


</body>
</html>

<?php
<?php
session_start();
if (isset($_SESSION['report_feedback'])) {
    $type = $_SESSION['feedback_type'] ?? 'info';
    echo '<div class="alert alert-' . htmlspecialchars($type) . ' text-center" role="alert">'
         . htmlspecialchars($_SESSION['report_feedback']) .
         '</div>';
    unset($_SESSION['report_feedback'], $_SESSION['feedback_type']);
}
?>