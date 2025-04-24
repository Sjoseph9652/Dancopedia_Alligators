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
    <div class="d-flex justify-content-between align-items-center mb-4">
      <a href="admin_dashboard.php" class="btn btn-outline-secondary btn-sm" title="Go back">
        <i class="bi bi-arrow-left"></i>
      </a>
      <h2 class="flex-grow-1 text-center mb-0">Inaccuracy Reports</h2>
      <div style="width: 32px;"></div>
    </div>

    <div class="mb-3 text-end">
      <button id="deleteBtn" class="btn btn-danger">Delete</button>
    </div>


    <table id="inaccuraciesTable" class="table table-bordered table-hover align-middle text-center">
      <thead class="table-dark">
        <tr>
          <th>Report ID</th>
          <th>Dance Name</th>
          <th>Description</th>
        </tr>
      </thead>
    </table>
  </div>
</section>
</main>

<?php include "includes/footer.php"; ?>

<!-- JS dependencies -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
  $('#inaccuraciesTable').DataTable({
    "ajax": "fetch_admin_inaccuracies.php",
    "columns": [
      { "data": "report_ID" },
      { "data": "dance_name" },
      { "data": "description" },
    ]
  });

  // Select All toggle
  $('#selectAll').on('click', function () {
    $('.row-checkbox').prop('checked', this.checked);
  });

  // Delete
    let selectedDeleteIDs = [];

    $('#deleteBtn').on('click', function () {
      selectedDeleteIDs = $('.row-checkbox:checked').map(function () {
        return this.value;
      }).get();

      if (selectedDeleteIDs.length === 0) {
        alert('Please select at least one report to delete.');
        return;
      }

      const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
      modal.show();
    });

    $('#confirmDeleteBtn').on('click', function () {
      const selectedIds = $('.row-checkbox:checked').map(function () {
        return $(this).val();
      }).get();

      selectedIds.forEach(id => {
        $.post('delete_inaccuracy.php', { report_ID: id }, function (response) {
          if (response.success) {
            $('#inaccuraciesTable').DataTable().ajax.reload();
          } else {
            alert('Error: ' + response.error);
          }
        }, 'json').fail(function (jqXHR, textStatus, errorThrown) {
          console.error("AJAX delete error:", textStatus, jqXHR.responseText);
        });
      });

      const modalElement = document.getElementById('confirmDeleteModal');
      const modalInstance = bootstrap.Modal.getInstance(modalElement);
      modalInstance.hide();
    });

});
</script>
</body>
</html>
