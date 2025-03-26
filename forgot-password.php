
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
    <section>
        <br>
        <div class="container text-center py-5">
            <h2>Forgot Password</h2>
                <br>
                <form method="post" action="send-password-reset.php">

                    <label for="email">Email</label>
                    <input type="email" name="email" id="email">

                    <button class="btn btn-outline-success" type="submit">Send</button>

                </form>
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
session_start();
//var_dump($_SESSION);
if (isset($_SESSION['email']))
{
    echo "Logged in as: " . $_SESSION['email'];
} else {
    echo "User is not logged in.";
}
?>
