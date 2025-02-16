<?php
session_start(); 
// Check if the user is logged in
if (!(isset($_SESSION['email']))) 
{
    echo "<p>You are not logged in. Please <a href='LoginForm.php'>login</a> to view your credentials.</p>";
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

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">Dancopedia</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href=#>Search</a></li>
                <!-- <li class="nav-item"><a class="nav-link btn btn-outline-primary" href="#">Sign In</a></li>
                <li class="nav-item"><a class="nav-link btn btn-primary text-white" href="#">Register</a></li> -->
            </ul>
        </div>
    </div>
</nav>

<header class="header">
    <h1 class="text-center">Dances</h1>
    <p class="text-center">Explore traditional and popular dances</p>
</header>

<section class="dance-list py-5">
    <div class="container">
        <h2 class="text-center mb-4">Dances List</h2>
        <div class="row" id="dances-container">
            <!-- Dances will be appended here dynamically -->
        </div>
    </div>
</section>

<footer class="text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>Account</h5>
                <ul class="list-unstyled">
                    <li><a href="#">Profile</a></li>
                    <li><a href="#">Saved Dances</a></li>
                    <li><a href="#">Change Password</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Explore</h5>
                <ul class="list-unstyled">
                    <li><a href="#">Home Page</a></li>
                    <li><a href="#">Search</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Resources</h5>
                <ul class="list-unstyled">
                    <li><a href="#">Documentation</a></li>
                    <li><a href="#">Requirements</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        // fetch with ajax
        $.ajax({
            url: 'fetch_account_info.php', 
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const dances = response.data;
                    const container = $('#dances-container');

                    // dynamically creates cards based on returned results
                    dances.forEach(dance => {
                        const card = `
                            <div class="col-md-4">
                                <div class="card mb-4 shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title">${dance.name}</h5>
                                        <p class="card-text">${dance.description}</p>
                                        <p class="text-muted">Region: ${dance.region} | Style: ${dance.style}</p>
                                        <img src="blog_dance2_480x480.webp" alt="dance image" width="100%" >
                                    </div>
                                </div>
                            </div>`;
                        container.append(card);
                    });
                } else {
                    alert('Failed to fetch dances: ' + response.error);
                }
            },
            error: function() {
                alert('An error occurred while fetching dances.');
            }
        });
    });
</script>
</body>
</html>

