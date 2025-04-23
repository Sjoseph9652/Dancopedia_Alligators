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
    <link rel="stylesheet" href="css/custom_style.css">
    
    <!-- References Used ------------------------------------
    	# https://www.w3schools.com/php/php_mysql_connect.asp
    	# https://www.w3schools.com/jquery/jquery_ajax_get_post.asp
    	# https://medium.com/@jenniferehodge1/create-cards-dynamicallyin-javascript-ac46c5eb2296
	--------------------------------------------------------->
    
</head>
<style>

</style>
<body>

 <!-- navbar -->
 <?php include "includes/navbar.php"; ?>

 <!-- Include Chatbot -->
<?php include "includes/chatbot_code.php"; ?>

<main>

<section class="text-center dance-list py-5">
    <div class="container">
        <h2>Search</h2>
        <form method="get">
            <br>
                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                    <input type="radio" class="btn-check" name="search-button" id="name-button" autocomplete="off" checked>
                    <label class="btn btn-outline-primary" for="name-button">Name</label>

                    <input type="radio" class="btn-check" name="search-button" id="region-button" autocomplete="off">
                    <label class="btn btn-outline-primary" for="region-button">Region</label>

                    <input type="radio" class="btn-check" name="search-button" id="style-button" autocomplete="off">
                    <label class="btn btn-outline-primary" for="style-button">Style</label>
                </div>
                <br>

                <div class="d-flex justify-content-center mt-3">
                    <div class="d-flex align-items-center" style="max-width: 300px;">
                        <input class="form-control mr-2" name="search" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </div>
                </div>
            </form>
        <br>
        <div class="row" id="dances-container">
            <!-- dances appear on cards dynamically -->
        </div>
    </div>
</div>
</section>
</main>

<!-- footer -->
 <?php include "includes/footer.php"; ?>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        col_pref = 4; // default in case no pref exists
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

        // gets results based on query and after clicking search
        $('form').on('submit', function(event) {
            event.preventDefault(); // prevents page refresh when searching

            let query = $('input[type="search"]').val().trim();
            let searchType = $('input[name="search-button"]:checked').attr('id');

            // fetch search results with ajax
            $.ajax({
                url: 'fetch_dances.php',
                method: 'GET',
                data: { search: query, type: searchType },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        const dances = response.data;
                        const container = $('#dances-container');
                        container.empty(); // clears previous results

                        // dynamically creates cards based on returned results
                        dances.forEach(dance => {
                            let card_start = ''
                            switch (col_pref) {
                                case 2:
                                    card_start = `
                            <div class="col-md-6">
                                <div class="card mb-2 shadow-sm align-items-stretch">`
                                    break;
                                case 3:
                                    card_start = `
                            <div class="col-md-4">
                                <div class="card mb-3 shadow-sm align-items-stretch">`
                                    break;
                                case 4:
                                    card_start = `
                            <div class="col-md-3">
                                <div class="card mb-4 shadow-sm align-items-stretch">`
                                    break;
                                case 5:
                                    card_start = `
                            <div class="col-md-2">
                                <div class="card mb-5 shadow-sm align-items-stretch">`
                                    break;
                                case 6:
                                    card_start = `
                            <div class="col-md-2">
                                <div class="card mb-6 shadow-sm align-items-stretch">`
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
                error: function () {
                    alert('An error occurred while fetching dances.');
                }
            });
        });
    });
</script>
</body>
</html>
