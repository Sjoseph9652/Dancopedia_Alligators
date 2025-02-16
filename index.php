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
</head>
<style>
/* Header Background, extra */
.header {
    background-image: url('images/blog_dance2_480x480.webp'); 
}
</style>

<body>
	<!-- https://getbootstrap.com/docs/5.3/components/navbar/ -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Dancopedia</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"> <a class="nav-link" id="open-chat" href="#">Chat</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Search</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Account</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-outline-primary" href="#">Sign In</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-primary text-white" href="#">Settings</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="header">
        <h1>Dancopedia</h1>
        <p>Discover Dances of Mexico</p>
        <button class="btn btn-primary">Search</button>
    </header>
	
<!-- https://getbootstrap.com/docs/5.3/components/card/ --> 
<section class="popular-dances py-5">
    <div class="container">
        <h2 class="text-center mb-4">Popular Dances</h2>
        <p class="text-center text-muted mb-5">Some of the most searched dances around the world</p>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">Dance Name 1</h5>
                        <p class="card-text">A brief description of what makes this dance unique.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">Dance Name 2</h5>
                        <p class="card-text">A brief description of what makes this dance unique.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">Dance Name 3</h5>
                        <p class="card-text">A brief description of what makes this dance unique.</p>
                    </div>
                </div>
            </div>
			 <div class="col">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">Dance Name 3</h5>
                        <p class="card-text">A brief description of what makes this dance unique.</p>
                    </div>
                </div>
            </div>
			 <div class="col">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">Dance Name 3</h5>
                        <p class="card-text">A brief description of what makes this dance unique.</p>
                    </div>
                </div>
            </div>
			 <div class="col">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">Dance Name 3</h5>
                        <p class="card-text">A brief description of what makes this dance unique.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Chatbot Container -->
<div class="chat-container" id="chatbot" style="display: none;">
    <div class="chat-header">
        Chatbot
        <button type="button" class="close" aria-label="Close" id="close-chat">&times;</button>
    </div>
    <div class="chat-body" id="chat-messages"></div>
    <div class="modal-footer">
        <textarea id="message-input" placeholder="Ask a question"></textarea>
        <button id="chat-submit">Send</button>
    </div>
</div>

	<!-- http://www.w3schools.com/TAgs/tag_footer.asp -->
    <!-- Footer -->
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

    <!-- Include Chatbot -->
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	
	<!-- adcd2-main example chatbot -->
    <!-- Chatbot Script -->
    <script>
        $(document).ready(function() {
            // Open chatbot
            $("#open-chat").click(function(e) {
                e.preventDefault();
                $("#chatbot").fadeIn();
            });

            // Close chatbot
            $("#close-chat").click(function() {
                $("#chatbot").fadeOut();
            });

            // Send chat message
            $("#chat-submit").click(function() {
                var message = $("#message-input").val().trim();
                if (message !== "") {
                    $("#chat-messages").append("<div class='user-message'><strong>You:</strong> " + message + "</div>");
                    $("#message-input").val("");

                    // Fetch response from chatbot.php
                    $.ajax({
                        url: "chatbot.php",
                        type: "POST",
                        data: { user_message: message },
                        success: function(response) {
                            $("#chat-messages").append("<div class='bot-message'><strong>Bot:</strong> " + response + "</div>");
                        }
                    });
                }
            });

            // Allow Enter key to send messages
            $("#message-input").keypress(function(e) {
                if (e.which == 13) { // Enter key
                    e.preventDefault();
                    $("#chat-submit").click();
                }
            });
        });
    </script>
</body>
</html>
