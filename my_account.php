<?php
session_start(); 
// Check if the user is logged in
if (!(isset($_SESSION['email']))) 
{
    echo "<p>You are not logged in. Please <a href='LoginForm.php'>login</a> to view your credentials.</p>";
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
.button-container {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-bottom: 20px;
}
</style>
<body>

<!-- navbar -->
<?php include "includes/navbar.php"; ?>

<header class="header">
    <h1 class="text-center" style="color: white; font-weight: bold;">Dances</h1>
    <p class="text-center" style="color:white;">Explore traditional and popular dances</p>
</header>



<section class="dance-buttons py-5">
    <div class="container">
        <div class="button-container">
            <a href="create_dance.php" class="btn btn-primary">Create a Dance</a>
            <a href="report_inaccuracies.php" class="btn btn-danger">Report Inaccuracies</a>
        </div>
    </div>
</section>

<section class="text-center">
    <div class="row" id="details-container">
       <!-- details dynamically added here -->
    </div>
</section>
<br>

<section class="text-center">
    <div class="row">
        <div class="col-sm-3">
            <div class="card mb-3 shadow-sm">
                <p>activity?</p>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card mb-3 shadow-sm">
                <p>activity?</p>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card mb-3 shadow-sm">
                <p>activity?</p>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card mb-3 shadow-sm">
                <p>activity?</p>
            </div>
        </div>
    </div>
</section>

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
                            <div class="col-md-4" id= "dance-${dance.dance_ID}">
                                <div class="card mb-4 shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title">${dance.name}</h5>
                                        <p class="card-text">${dance.description}</p>
                                        <p class="text-muted">Region: ${dance.region} | Style: ${dance.style}</p>
                                        <img src="blog_dance2_480x480.webp" alt="dance image" width="100%" >
                                        <a href="update_dance.php?dance_ID=${dance.dance_ID}" class="btn-primary">Update</a>
                                        <button class="delete_button btn-primary" data-id="${dance.dance_ID}">Delete</button>
                                    </div>
                                </div>
                            </div>`;

                            // opens new page on click
                                const $card = $(card);
                                $card.on('click', function() {
                                    localStorage.setItem('dance', JSON.stringify(dance));
                                    window.location.href = 'dance_detail.php';
                                });

                        container.append(card);
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
        container.empty(); // clears previous results

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

</body>
</html>

