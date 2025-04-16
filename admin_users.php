<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: LoginForm.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dancopedia - Users List</title>

  <!-- Bootstrap & DataTables CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/chatbot.css">
  <link rel="stylesheet" href="css/custom_style.css">
</head>

<style>
.header {
  background-image: url('images/blog_dance2_480x480.webp');
}
</style>

<body>

<!-- Navbar -->
<?php include "includes/navbar.php"; ?>

<main>
<section class="text-center py-5">
  <div class="container">
    <h2 class="mb-4">Users</h2>
    <table id="usersTable" class="table table-bordered table-hover align-middle text-center">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Created</th>
          <th>Modified</th>
        </tr>
      </thead>
    </table>
  </div>
</section>
</main>

<!-- footer -->
<?php include 'includes/footer.php'; ?>

<!-- Include Chatbot -->
<?php include "includes/chatbot_code.php"; ?>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
  $('#usersTable').DataTable({
    "ajax": "fetch_admin_users.php",
    "columns": [
      { "data": "id" },
      { "data": "first_name" },
      { "data": "last_name" },
      { "data": "email" },
      { "data": "role" },
      { "data": "created_time" },
      { "data": "modified_time" }
    ]
  });
});
</script>


</body>
</html>

