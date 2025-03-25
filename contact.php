<?php
session_start();
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

    <!-- Include Chatbot -->
    <?php include "includes/chatbot_code.php"; ?>



<main>
<h2 class="text-center mb-4 py-5">Contact Us</h2>
  <div class="row justify-content-center">
    <div class="col-md-8">
      <form action="submit_contact.php" method="POST" class="w3-card p-4 bg-white shadow rounded">
        <div class="mb-3">
          <label for="name" class="form-label"><h2>Name</h2></label>
          <input type="text" class="form-control" id="name" name="name" required />
        </div>

        <div class="mb-3">
          <label for="email" class="form-label"><strong>Email</strong></label>
          <input type="email" class="form-control" id="email" name="email" required />
        </div>

        <div class="mb-3">
          <label for="message" class="form-label"><strong>Message</strong></label>
          <textarea class="form-control" id="message" name="message" rows="6" required></textarea>
        </div>

        <button type="submit" class="btn btn-danger w-100">Send Message</button>
      </form>
    </div>
  </div>
  <section class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Contact Information</h4>
            <p class="card-text mb-1"><strong>Address:</strong> 123 Dance Street,
             Mexico City,
             MX 01234</p>
            <p class="card-text mb-1"><strong>Email:</strong> <a href="mailto:info@dancopedia.com">info@dancopedia.com</a></p>
            
            
        </div>
    </div>
</section>
</main>

<?php include "includes/footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>