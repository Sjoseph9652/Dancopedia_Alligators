<?php

if (isset($_SESSION['email']))
{
    echo "Logged in as: " . $_SESSION['email'];
} else {
    session_save_path('/tmp');
    session_start();
    echo "User is not logged in.";
}
?>

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
.header {
    background-image: url('images/blog_dance2_480x480.webp');
}
</style>
<body>

 <!-- navbar -->
 <?php include "includes/navbar.php"; ?>


<main>
<section class="text-center py-5">
    <div class="container">
        <h2>Dance Details</h2>
    <div class="row" id="details-container">
       <!-- details dynamically added here -->
    </div>
</div>
</section>


<section class="interactions list py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Recent Interactions</h2>
            <?php if (isset($_SESSION['user_id'])): ?>
                <button type="button" class="btn btn-primary btn-sm square-btn" data-bs-toggle="modal" data-bs-target="#interactionModal">
                    +
                </button>
            <?php endif; ?>
        </div>
        <div class="row" id="interactions-container">
            <!-- interactions will append here dynamically -->
        </div>
    </div>
</section>

</main>
<!-- footer -->
 <?php include "includes/footer.php"; ?>

 <!-- interaction modal -->
 <div class="modal fade" id="interactionModal">
   <div class="modal-dialog">
     <form id="interactionForm" class="modal-content" tabindex="-1" aria-labelledby="interactionModalLabel" aria-hidden="true">
       <div class="modal-header">
         <h5 class="modal-title" id="interactionModalLabel">Leave a Review or Comment</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body">
           <div class="mb-3">
               <label for="interactionTitle" class="form-label">Title</label>
               <input type="text" class="form-control" id="interactionTitle" name="title">
           </div>
           <div class="mb-3">
               <label for="interactionComment" class="form-label">Comment</label>
               <textarea class="form-control" id="interactionComment" name="comment"></textarea>
           </div>
           <div class="mb-3">
               <label for="interactionStars" class="form-label">Stars (1–5)</label>
               <input type="number" class="form-control" id="interactionStars" name="stars" min="0" max="5" step=".1">
           </div>
       </div>
       <div class="modal-footer">
         <button type="submit" class="btn btn-primary">Submit Review/Comment</button>
       </div>
     </form>
   </div>
 </div>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        const container = $('#details-container');
        container.empty(); // clears previous results

        // get dance from localstorage and parse it
        const dance = JSON.parse(localStorage.getItem('dance'));

        // display error if no object in localstorage
        if (!dance) {
            alert("No dance selected!");
            return;
        }

        const left_card = `<div class="col-sm-4">
                                     <div class="card shadow-sm">
                                         <div class="card-body">
                                             <h5 class="card-title">${dance.name}</h5>
                                             <img src="${dance.image || 'images/default-dance.webp'}" alt="dance image" width="100%">
                                         </div>
                                     </div>
                                 </div>`;
        const right_card = `<div class="col-sm-8">
                                      <div class="card shadow-sm">
                                          <div class="card-body">
                                              <p class="text-muted">Region: ${dance.region} | Style: ${dance.style}</p>
                                              <p>${dance.description}</p>
                                          </div>
                                      </div>
                                  </div>`
        container.append(left_card);
        container.append(right_card);
    });
</script>


<script>

    $(document).ready(function () {
        fetch_interactions();

        $('#interactionForm').on('submit', function (e) {
                e.preventDefault();

                const title = $('#interactionTitle').val().trim();
                const comment = $('#interactionComment').val().trim();
                const stars = $('#interactionStars').val().trim();
                const dance = JSON.parse(localStorage.getItem('dance'));
                const danceId = dance.dance_ID;

                // debug log
                console.log({ title, comment, stars, danceId });

                if (!title && !comment && !stars) {
                    alert("Please enter a title, comment, or star rating.");
                    return;
                }

                $.ajax({
                    url: 'create_interaction.php',
                    method: 'POST',
                    data: {
                        title: title || null,
                        comment: comment || null,
                        stars: stars || null,
                        dance_id: danceId
                    },
                    success: function (response) {
                        alert("Review/Comment submitted!");
                        $('#interactionModal').modal('hide');
                        $('#interactionForm')[0].reset();
                        fetch_interactions();
                    },
                    error: function () {
                        alert("Error submitting interaction.");
                    }
                });
            });
    });


    function fetch_interactions() {

        const container = $('#interactions-container');
            container.empty(); // clears previous results

            // get dance from localstorage and parse it
            const dance = JSON.parse(localStorage.getItem('dance'));
            // display error if no object in localstorage
            if (!dance) {
                alert("No dance selected!");
                return;
            }
        // fetch with ajax
        $.ajax({
            url: 'fetch_dance_interactions.php',
            method: 'GET',
            data: { dance_id: dance.dance_id },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const interactions = response.data;
                    const container = $('#interactions-container');

                    // dynamically creates cards based on returned results
                    interactions.forEach(interaction => {
                        const card = `
                            <div class="col-sm-6 col-md-4 col-lg-3 d-flex">
                                <div class="card mb-4 shadow-sm w-100 d-flex flex-column">
                                    <div class="card-body d-flex flex-column">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <p class="text-muted mb-0">${interaction.stars} ⭐</p>
                                        </div>
                                        <h5 class="card-title">${interaction.title}</h5>
                                        <p class="card-text">${interaction.comment}</p>
                                        <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
                                            <small class="text-muted">by ${interaction.first_name}</small>
                                            <small class="text-muted">${timeAgo(interaction.created_on)}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;

                        const $card = $(card);
                        $card.on('click', function() {
                            localStorage.setItem('dance', JSON.stringify(interaction)); // <-- fixed: use interaction
                            window.location.href = 'dance_detail.php';
                        });

                        $('#interactions-container').append($card);
                    });


                } else {
                    alert('Failed to fetch dances: ' + response.error);
                }
            },
            error: function() {
                alert('An error occurred while fetching dances.');
            }
        });
    }

    function timeAgo(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const seconds = Math.floor((now - date) / 1000);

        const intervals = [
            { label: "year", seconds: 31536000 },
            { label: "month", seconds: 2592000 },
            { label: "week", seconds: 604800 },
            { label: "day", seconds: 86400 }
        ];

        for (const interval of intervals) {
            const count = Math.floor(seconds / interval.seconds);
            if (count >= 1) {
                return `${count} ${interval.label}${count > 1 ? 's' : ''} ago`;
            }
        }

        return "Today";
    }
</script>


</body>

<!-- Include Chatbot -->
<?php include "includes/chatbot_code.php"; ?>

</html>
