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

                    <!-- creator email -->
                    <div class="mb-3 text-start fw-bold">
                        <label class="form-label" for="creator_email">Creator Email:</label>
                        <input type="email" class="form-control" id="creator_email" name="creator_email" value= <?php echo $_SESSION['email']?> required>
                    </div>

                    <!-- Dance name -->
                    <div class="mb-3 text-start fw-bold">
                        <label class="form-label" for="title">Dance Name:</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <!-- Region -->
                    <div class="mb-3 text-start fw-bold">
                        <label class="form-label" for="region">Region:</label>
                        <input type="text" class="form-control" id="region" name="region" required>
                    </div>

                    <!-- Style -->
                    <div class="mb-3 text-start fw-bold">
                        <label class="form-label" for="style">Style:</label>
                        <input type="style" class="form-control" id="style" name="style" required>
                    </div>
                    <!-- Style, Tags, Region-->
                    <!-- Description -->
                    <div class="mb-3 text-start fw-bold">
                        <label class="form-label" for="description">Description:</label><br>
                        <textarea id="description" class="form-control" name="description" rows="4" cols="50" required></textarea>
                    </div>
                   

                    <!-- video link -->
                     <!-- This text field is for inserting links into the database.
                      These links will be outputted and put on the home page under the index cards -->
                      <!-- ***The youtube video links only display if they are (Embedded html) under share*** -->

                      <!-- Video -->
                    <div class="mb-3 text-start fw-bold">
                        <label class="form-label" for="link">Dance Video link:</label>
                        <input type="text" class="form-control" id="link" name="link" size="70">
                    </div>

                    <!-- upload photos-->
                    <div class="mb-3 text-start fw-bold">
                        <label class="form-label" for="photos">Upload Photos:</label>
                        <input type="file" class="form-control" id="photos" name="photos" multiple>
                    </div>
                    <button class="btn btn-outline-success" type="submit">Create Dance</button>
                    
                    
                    <!-- Confirmation to the user that a dance was added to the database -->
                        <?php
                        if (isset($_GET["Successful"])) {
                            
                            echo('<Div style="margin-top: 20px"><span style="color:Green;padding: 15px;font-size:larger; font-family:Sans-serif; background-color:lightblue; opacity: 0.7s; border-radius: 25px;">  Dance added! </span></div>');
                        }
                        ?>
                    


        </div>
    </section>
</main>


<!-- footer -->
<?php include "includes/footer.php"; ?>

<!-- Include Chatbot -->
<?php include "includes/chatbot_code.php"; ?>


</body>
</html>



