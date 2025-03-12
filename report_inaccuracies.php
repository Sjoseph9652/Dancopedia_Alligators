<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dancopedia - Report Inaccuracies</title>
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

<?php include_once 'includes/navbar.php'; ?> <!-- Include the navbar here -->

<header class="header">
        <h1 class="text-center" style="color: white; font-weight: bold;">Report Inaccuracies</h1>
        <p class="text-center" style="color:white;">Report Bad Information</p>
</header>

<body>
    <form action="report_processing.php" method="POST">
        <label for="title">Dance Name</label>
        <input type="text" id="title" name="title" required><br><br>

        <label for="complaint">Complaint:</label><br>
        <textarea id="complaint" name="complaint" rows="4" cols="50" required></textarea><br><br>

        <button type="submit">submit report</button>
</body>
<?php include 'includes/footer.php'; ?>
</html>