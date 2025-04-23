<?php
session_start();
// Check if the user is logged in
if (!(isset($_SESSION['email'])))
{

    header("Location: LoginForm.php");

    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dancopedia - Dances List</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/chatbot.css">
    <link rel="stylesheet" href="css/custom_style.css">

    <!-- References Used ------------------------------------
    	# https://www.w3schools.com/php/php_mysql_connect.asp
    	# https://www.w3schools.com/jquery/jquery_ajax_get_post.asp
    	# https://medium.com/@jenniferehodge1/create-cards-dynamicallyin-javascript-ac46c5eb2296
	--------------------------------------------------------->

</head>
<style>
.header {
    background-image: url('images/blog_dance2_480x480.webp');
}

</style>
<body>

<!-- navbar -->
<?php include "includes/navbar.php"; ?>


<main>

<section class="text-center py-5">
    <div class="container my-5">
        <h2 class="mb-4">Admin Dashboard</h2>
        <div class="row g-4">

          <div class="col-md-4">
            <a href="admin_dances.php" class="text-decoration-none">
              <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                  <h5 class="card-title">Dances</h5>
                  <p class="card-text">View and manage dances and their details.</p>
                </div>
              </div>
            </a>
          </div>

          <div class="col-md-4">
            <a href="admin_users.php" class="text-decoration-none">
              <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                  <h5 class="card-title">Users</h5>
                  <p class="card-text">View and manage user accounts and roles.</p>
                </div>
              </div>
            </a>
          </div>

          <div class="col-md-4">
            <a href="admin_interactions.php" class="text-decoration-none">
              <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                  <h5 class="card-title">Interactions</h5>
                  <p class="card-text">View and manage comments and reviews.</p>
                </div>
              </div>
            </a>
          </div>

          <div class="col-md-4">
            <a href="admin_inaccuracies.php" class="text-decoration-none">
              <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                  <h5 class="card-title">Inaccuracies</h5>
                  <p class="card-text">Review reports of incorrect information.</p>
                </div>
              </div>
            </a>
          </div>

          <div class="col-md-4">
            <a href="admin_preferences.php" class="text-decoration-none">
              <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                  <h5 class="card-title">Preferences</h5>
                  <p class="card-text">Adjust settings and user preferences.</p>
                </div>
              </div>
            </a>
          </div>
        </div>
</section>


</main>

<?php include "includes/footer.php"; ?>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

