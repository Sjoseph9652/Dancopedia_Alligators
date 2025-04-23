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
<!-- dynamic card section -->
<section class="dance-list py-5">
    <div class="container">
        <h2 class="text-center mb-4">Popular Dances</h2>
        <div class="row" id="dances-container">
             <!-- dances will be appended here dynamically -->
        </div>
    </div>
</section>
</main>


<!-- footer -->
<?php include "includes/footer.php"; ?>

<!-- Include Chatbot -->
<?php include "includes/chatbot_code.php"; ?>

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
                            /*NEW up until the :*/
                            const card_body = dance.link ? `<div class="card-body d-flex flex-column h-300"> 
                                            <h5 class="card-title">${dance.name}</h5>
                                            <p class="text-muted">Region: ${dance.region} | Style: ${dance.style}</p>
                                            <iframe src="${dance.link}"></iframe>
                                        </div>
                                    </div>
                                </div>` : `
                                        <div class="card-body d-flex flex-column h-300">
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
