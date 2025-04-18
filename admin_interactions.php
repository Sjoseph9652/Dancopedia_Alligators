<?php
session_save_path('/tmp')
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
    <h2 class="mb-4">Interactions</h2>

    <div class="mb-3 text-end">
      <button id="editBtn" class="btn btn-warning me-2" style="display: none;">Edit</button>
      <button id="deleteBtn" class="btn btn-danger">Delete</button>
    </div>

    <table id="interactionsTable" class="table table-bordered table-hover align-middle text-center">
      <thead class="table-dark">
        <tr>
          <th><input type="checkbox" id="selectAll"></th>
          <th>ID</th>
          <th>Dance Name</th>
          <th>Author</th>
          <th>Title</th>
          <th>Comment</th>
          <th>Stars</th>
          <th>Created Date</th>
        </tr>
      </thead>
    </table>
  </div>
</section>
</main>

<!-- Delete Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-dark">
        Are you sure you want to delete the selected interaction(s)? This action <strong>cannot</strong> be undone.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button id="confirmDeleteBtn" type="button" class="btn btn-danger">Delete</button>
      </div>
    </div>
  </div>
</div>

<?php include "includes/footer.php"; ?>

<!-- JS dependencies -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
  const table = $('#interactionsTable').DataTable({
    "ajax": "fetch_admin_interactions.php",
    "columns": [
      {
        "data": null,
        "orderable": false,
        "className": 'dt-body-center',
        "render": function (data, type, row) {
          return `<input type="checkbox" class="row-checkbox" value="${row.interaction_id}">`;
        }
      },
      { "data": "interaction_id" },
      { "data": "name" },
      { "data": "email" },
      { "data": "title" },
      { "data": "comment" },
      { "data": "stars" },
      { "data": "created_on" }
    ]
  });

  // Checkbox logic
  function updateButtonVisibility() {
    const checkedCount = $('.row-checkbox:checked').length;
    $('#editBtn').toggle(checkedCount === 1);
  }

  $('#selectAll').on('click', function () {
    $('.row-checkbox').prop('checked', this.checked);
    updateButtonVisibility();
  });

  $(document).on('change', '.row-checkbox', function () {
    updateButtonVisibility();
  });

  // Delete
  let selectedDeleteIDs = [];

  $('#deleteBtn').on('click', function () {
    selectedDeleteIDs = $('.row-checkbox:checked').map(function () {
      return this.value;
    }).get();

    if (selectedDeleteIDs.length === 0) {
      alert('Please select at least one interaction to delete.');
      return;
    }

    const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
    modal.show();
  });



  // Edit
  $('#editBtn').on('click', function () {
    const selectedCheckbox = $('.row-checkbox:checked');

    if (selectedCheckbox.length !== 1) return;

    const row = selectedCheckbox.closest('tr');
    const rowData = table.row(row).data();

    const interactionID = rowData.interaction_id;

    window.location.href = `update_interaction.php?interaction_id=${interactionID}`;
  });

});
</script>

</body>
</html>
