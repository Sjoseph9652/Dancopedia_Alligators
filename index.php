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
     <!-- navbar -->
    <?php include "includes/navbar.php"; ?>

    <!-- Header -->
    <header class="header">
        <h1 class="text-center" style="color: white; font-weight: bold;">Dancopedia</style></h1>
        <p class="text-center" style="color:white;">Discover Dances of Mexico</style></p>
    </header>


<!-- dynamic card section -->
<section class="dance-list py-5">
    <div class="container">
        <h2 class="text-center mb-4">Popular Dances</h2>
        <div class="row" id="dances-container">
             <!-- dances will be appended here dynamically -->
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

    <!-- footer -->
    <?php include "includes/footer.php"; ?>

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
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        let col_pref = 4; // default
        // fetch column number prefrence with ajax
        $.ajax({
            url: 'fetch_prefs.php',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    col_pref = response.columns;
                } else {
                    console.warn('Failed to fetch preferences:', response.error);
                }
            },
            error: function () {
                console.warn('Error fetching preferences.');
            }
        });

        $(document).ready(function () {
            // fetch search results with ajax
            $.ajax({
                url: 'index_dances.php',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        const dances = response.data;
                        const container = $('#dances-container');

                        // dynamically creates cards based on returned results
                        dances.forEach(dance => {
                            let card_start = ''
                            switch (col_pref) {
                                case 2:
                                    card_start = `
                            <div class="col-md-6">
                                <div class="card mb-2 shadow-sm">`
                                    break;
                                case 3:
                                    card_start = `
                            <div class="col-md-4">
                                <div class="card mb-3 shadow-sm">`
                                    break;
                                case 4:
                                    card_start = `
                            <div class="col-md-3">
                                <div class="card mb-4 shadow-sm">`
                                    break;
                                case 5:
                                    card_start = `
                            <div class="col-md-2">
                                <div class="card mb-5 shadow-sm">`
                                    break;
                                case 6:
                                    card_start = `
                            <div class="col-md-2">
                                <div class="card mb-6 shadow-sm">`
                                    break;
                            }
                            const card_body = `
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title">${dance.name}</h5>
                                            <p class="text-muted">Region: ${dance.region} | Style: ${dance.style}</p>
                                            <img src="${dance.image || 'images/default-dance.webp'}" alt="dance image" width="100%">                                    </div>
                                    </div>
                                </div>`;

                                // opens new page on click
                                const $card = $(card_start + card_body);
                                $card.on('click', function() {
                                    localStorage.setItem('dance', JSON.stringify(dance));
                                    window.location.href = 'dance_detail.php';
                                });

                                container.append($card);
                            });
                    } else {
                        alert('Failed to fetch dances: ' + response.error);
                    }
                },

            });
        });
    });
</script>
</body>
</html>
