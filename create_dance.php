<?php
session_start();
?>

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
            <h2>Create a Dance</h2>
            <br>
                <form action="create_dance_connection.php" method="POST" enctype="multipart/form-data">

                    <label for="creator_email">Creator Email:</label>
                    <input type="email" id="creator_email" name="creator_email" value= <?php echo $_SESSION['email']?> required><br><br>

                    <label for="title">Dance Name:</label>
                    <input type="text" id="title" name="title" required><br><br>

                    <label for="region">Region:</label>
                    <input type="text" id="region" name="region" required><br><br>

                    <label for="style">Style</label>
                    <input type="style" id="style" name="style" required><br><br>

                    <!-- Style, Tags, Region-->

                    <label for="description">Description:</label><br>
                    <textarea id="description" name="description" rows="4" cols="50" required></textarea><br><br>

                    <!--
                    <label for="tags">Tags:</label><br>
                    <textarea id="tags" name="tags" rows="4" cols="50"></textarea><br><br> -->

                    <!-- video link -->
                     <!-- This text field is for inserting links into the database.
                      These links will be outputted and put on the home page under the index cards -->
                      <!-- ***The youtube video links only display if they are (Embedded html) under share*** -->
                    <label for="link">Dance Video link:</label>
                    <input type="text" id="link" name="link" size="70"><br><br>

                    <label for="photos">Upload Photos:</label>
                    <input type="file" id="photos" name="photos" multiple><br><br>

                    <button class="btn btn-outline-success" type="submit">Create Dance</button>


        </div>
    </section>
</main>


<!-- footer -->
<?php include "includes/footer.php"; ?>

<!-- Include Chatbot -->
<?php include "includes/chatbot_code.php"; ?>


</body>
</html>

<!-- Confirmation to the user that a dance was added to the database -->
<?php
if (isset($_GET["Successful"])) {
    echo('<span style="color:Green;background-color:yellow">  Dance added! </span>');
}
?>

