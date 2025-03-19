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
    <h1 class="text-center" style="color: white; font-weight: bold;">Dance Management</h1>
    <p class="text-center" style="color:white;">Add, Delete, or Edit Dances</p>
</header>


<section class="text-center">
    <div class="button-container">
        <a href="#" class="btn btn-primary">Create a User</a>
    </div>
    <div class="container mt-4">
        <div class="row">
            <!-- user list -->
            <div class="col-md-8">
                <div id="user-list-container" class="list-group">
                    <!-- users will be added here dynamically -->
                </div>
            </div>

            <!-- selected user card -->
            <div class="col-md-4">
                <div id="user-card-container">
                    <!-- user card will be displayed here dynamically -->
                </div>
            </div>
        </div>
    </div>
</section>
<br>

<!-- footer -->
<?php include 'includes/footer.php'; ?>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        // fetch with ajax
        $.ajax({
            url: 'fetch_users_admin.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const users = response.data;
                    const list_container = $('#user-list-container');

                    // dynamically creates list items based on returned results
                    const list_start = `<div class="list-group" id="list-tab" role="tablist">
                                                <a href="#" class="list-group-item list-group-item-action">Username</a>`
                    list_container.append(list_start);
                    users.forEach(user => {
                        const $list_item = $(`<a href="#" class="list-group-item list-group-item-action" data-user='${JSON.stringify(user)}'>${user.email}</a>`);

                        $list_item.on('click', function() {
                            const userData = JSON.parse($(this).attr('data-user'));
                            $('#user-card-container').html(`
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">${userData.first_name} ${userData.last_name}</h5>
                                        <p class="card-text">Email: ${userData.email}</p>
                                        <p class="card-text">Role: ${userData.role}</p>
                                    </div>
                                </div>
                            `);
                        });

                        list_container.append($list_item);
                    });
                    const list_end = '</div> </div>'
                    list_container.append(list_end);

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
                    alert('Failed to fetch users: ' + response.error);
                }
            },
            error: function() {
                alert('An error occurred while fetching users.');
            }
        });
    });
</script>


</body>
</html>

