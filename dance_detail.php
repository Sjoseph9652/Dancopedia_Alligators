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
    <h1 class="text-center" style="color: white; font-weight: bold;">Dance Details</h1>
    <p class="text-center" style="color:white;">More Information About This Dance</p>
</header>

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
                <p>comment?</p>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card mb-3 shadow-sm">
                <p>comment?</p>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card mb-3 shadow-sm">
                <p>comment?</p>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card mb-3 shadow-sm">
                <p>comment?</p>
            </div>
        </div>
    </div>
</section>

<!-- footer -->
 <?php include "includes/footer.php"; ?>

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

</body>
</html>
