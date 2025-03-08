<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dancopedia - Search</title>
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

 <!-- navbar -->
 <?php include "includes/navbar.php"; ?>

<header class="header">
    <h1 class="text-center">Search</h1>
    <p class="text-center">Explore traditional and popular dances</p>
</header>

<div class="text-center">
    <form action="search.php" method="POST">
        <label>Search by:</label>
        <br><br>

        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
            <input type="radio" class="btn-check" name="search-button" id="name-button" autocomplete="off" checked>
            <label class="btn btn-outline-primary" for="name-button">Name</label>

            <input type="radio" class="btn-check" name="search-button" id="region-button" autocomplete="off">
            <label class="btn btn-outline-primary" for="region-button">Region</label>

            <input type="radio" class="btn-check" name="search-button" id="style-button" autocomplete="off">
            <label class="btn btn-outline-primary" for="style-button">Style</label>
        </div>
        <br>
        <br>
        <div class="d-flex justify-content-center mt-3">
            <div class="d-flex align-items-center" style="max-width: 300px;">
                <input class="form-control mr-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </div>
        </div>
    </form>
</div>

<section class="dance-list py-5">
    <div class="container">
        <h2 class="text-center mb-4">Search Results</h2>
        <div class="row" id="dances-container">
            <!-- dances appear on cards dynamically -->
        </div>
    </div>
</section>

<footer class="text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>Account</h5>
                <ul class="list-unstyled">
                    <li><a href="my_account.php">Profile</a></li>
                    <li><a href="my_account.php">Saved Dances</a></li>
                    <li><a href="#">Change Password</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Explore</h5>
                <ul class="list-unstyled">
                    <li><a href="index.php">Home Page</a></li>
                    <li><a href="search_results.html">Search</a></li>
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
                url: 'fetch_dances.php',
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
                                        <p class="card-text">${dance.description}</p>
                                        <p class="text-muted">Region: ${dance.region} | Style: ${dance.style}</p>
                                        <img src="${dance.image || 'images/default-dance.webp'}" alt="dance image" width="100%">                                    </div>
                                </div>
                            </div>`;
                            container.append($(card_start + card_body));
                        });
                    } else {
                        alert('Failed to fetch dances: ' + response.error);
                    }
                },
                error: function () {
                    alert('An error occurred while fetching dances.');
                }
            });
        });
    });
</script>
</body>
</html>
