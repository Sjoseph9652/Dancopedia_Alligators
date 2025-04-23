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
    
    <style>
        .header {
            background-image: url('images/blog_dance2_480x480.webp');
        }
        /* Optional: Make sure dance cards indicate they are clickable */
        .dance-card {
            cursor: pointer;
            position: relative;
            z-index: 2;
        }
    </style>
</head>
<body>

<!-- navbar -->
<?php include "includes/navbar.php"; ?>


<main>
    <section class="text-center py-5">
      <div class="container">
        <div class="d-flex justify-content-end mb-3">
          <a href="edit_my_account.php?user_id=<?= $_SESSION['user_id'] ?>" class="btn btn-outline-primary btn-sm">Edit My Details</a>
        </div>
        <div class="row" id="details-container">
          <!-- Account details dynamically added here -->
        </div>

      </div>
    </section>

    <section class="dance-list py-5">
        <div class="container">
            <div class="button-container">
                <a href="create_dance.php" class="btn btn-primary">Create a Dance</a>
                <a href="report_inaccuracies.php" class="btn btn-danger">Report Inaccuracies</a>
            </div>
            <div class="container">
                <h2 class="text-center mb-4">Dances List</h2>
                <div class="row" id="dances-container">
                    <!-- Dances will be appended here dynamically -->
                </div>
            </div>
        </div>
    </section>

<section class="interactions list py-5">
    <div class="container">
        <h2 class="text-center mb-4">Recent Interactions</h2>
        <div class="row" id="interactions-container">
            <!-- interactions will append here dynamically -->
        </div>
    </div>
</section>

</main>

<?php include "includes/footer.php"; ?>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    // Fetch dances using AJAX
    $.ajax({
        url: 'fetch_account_info.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                const dances = response.data;
                const container = $('#dances-container');
                console.log("Dances received from AJAX:", dances);

                // Dynamically create cards based on returned results
                dances.forEach(dance => {
                    let mediaContent = '';

                    if (dance.video_link) {
                        mediaContent = `<iframe width="100%" height="200" src="${dance.video_link}" frameborder="0" allowfullscreen></iframe>`;
                    } else if (dance.image_url) {
                        mediaContent = `<img src="${dance.image_url}" alt="dance image" width="100%">`;
                    }
                    const cardHTML = `
                        <div class="col-md-4">
                            <div class="card mb-4 shadow-sm dance-card" data-id="${dance.dance_ID}">
                                <div class="card-body">
                                    <h5 class="card-title">${dance.name}</h5>
                                    <p class="card-text">${dance.description}</p>
                                    <p class="text-muted">Region: ${dance.region} | Style: ${dance.style}</p>
                                    ${mediaContent}
                                    <div class="mt-auto pt-3 d-flex justify-content-between">
                                        <a href="update_dance.php?dance_ID=${dance.dance_ID}" class="btn btn-primary">Update</a>
                                        <button class="delete_button btn btn-danger" data-id="${dance.dance_ID}">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>`;

                    const $card = $(cardHTML);

                    $card.on('click', function(e) {
                        localStorage.setItem('dance', JSON.stringify(dance));
                        window.location.href = 'dance_detail.php';
                    });

                        container.append($card);
                    });

                    //Delete Button
                    $('.delete_button').click(function()
                    {
                        const dance_ID = $(this).data('id');
                        console.log(dance_ID);
                        $.ajax({
                            url: 'delete_dance.php',
                            method: 'POST',
                            data: { dance_ID:dance_ID},
                            success: function(response)
                            {
                                location.reload();
                            }
                        });
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

<script>
$(document).ready(function() {
    const container = $('#details-container');
    container.empty(); // Clear previous results

        $.ajax({
            url: 'fetch_account_details.php',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    const account = response.data[0];
                    const container = $('#details-container');
                    container.empty(); // clears previous results

                    const left_card = `<div class="col-sm-4">
                                                 <div class="card shadow-sm">
                                                     <div class="card-body">
                                                         <h5 class="card-title">${account.first_name} ${account.last_name}</h5>
                                                         <img src="images/default-profile-pic.webp" alt="account image" width="100%">
                                                     </div>
                                                 </div>
                                             </div>`;
                    const right_card = `<div class="col-sm-8">
                                                  <div class="card shadow-sm">
                                                      <div class="card-body">
                                                          <p>Email: ${account.email}</p>
                                                          <p>Account Type: ${account.role}</p>
                                                          <p>Display Column Preference: ${account.value}</p>
                                                      </div>
                                                  </div>
                                              </div>`;
                    container.append(left_card);
                    container.append(right_card);
                    console.log("Cards appended successfully!");
                } else {
                    alert('Failed to fetch account details: ' + response.error);
                }
            },
            error: function () {
                alert('An error occurred while fetching account details.');
            }
        });
});
</script>

<script>
    $(document).ready(function() {
        // fetch with ajax
        $.ajax({
            url: 'fetch_account_interactions.php',
            method: 'GET',
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
                                            <p class="card-text mb-0 fw-semibold">${interaction.name}</p>
                                            <p class="text-muted mb-0">${interaction.stars} ⭐</p>
                                        </div>
                                        <h5 class="card-title">${interaction.title}</h5>
                                        <p class="card-text">${interaction.comment}</p>
                                        <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
                                            <small class="text-muted">by ${interaction.first_name}</small>
                                            <small class="text-muted">${timeAgo(interaction.created_on)}</small>
                                        </div>
                                        <button class="delete_button btn btn-primary" data-id="${interaction.interaction_id}">Delete</button>
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

                    //Delete Button
                   $('.delete_button').click(function()
                    {
                        const dance_ID = $(this).data('id');
                        console.log(dance_ID);
                        $.ajax({
                            url: 'delete_interaction.php',
                            method: 'POST',
                            data: { dance_ID:dance_ID},
                            success: function(response)
                            {
                                location.reload();
                            }
                        });
                    });


                } else {
                    alert('Failed to fetch dances: ' + response.error);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error", {
                    textStatus: textStatus,
                    errorThrown: errorThrown,
                    responseText: jqXHR.responseText
                });

                alert('An error occurred while fetching interactions.');
            }
        });
    });

    function timeAgo(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const seconds = Math.floor((now - date) / 1000);

        const intervals = [
            { label: "year", seconds: 31536000 },
            { label: "month", seconds: 2592000 },
            { label: "week", seconds: 604800 },
            { label: "day", seconds: 86400 },
        ];

        for (const interval of intervals) {
            const count = Math.floor(seconds / interval.seconds);
            if (count >= 1) {
                return `${count} ${interval.label}${count > 1 ? 's' : ''} ago`;
            }
        }

        return "Today";
    }

$(document).on('click', '.delete_button', function () {
  const interactionId = $(this).data('id');

  $.post('delete_interaction.php', { interaction_id: interactionId }, function (response) {
    if (response.success) {
      alert('Interaction deleted successfully.');
    } else {
      alert('Error: ' + response.error);
    }
  }, 'json');
});

$('#editBtn').on('click', function () {
  window.location.href = 'edit_my_account.php';
});

</script>



</body>

<!-- Include Chatbot -->
<?php include "includes/chatbot_code.php"; ?>

</html>

