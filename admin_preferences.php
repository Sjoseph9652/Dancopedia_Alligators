<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: LoginForm.php");
    exit;
}
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dancopedia - User Preferences</title>

  <!-- Bootstrap & DataTables CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


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
      <a href="javascript:history.back()" class="btn btn-outline-secondary btn-sm" title="Go back">
        <i class="bi bi-arrow-left"></i>
      </a>
      <h2 class="flex-grow-1 text-center mb-0">User Preferences</h2>
      <div style="width: 32px;"></div> <!-- Spacer to balance the back button on the left -->
    </div>

    <div class="mb-3 text-end">
      <button id="editBtn" class="btn btn-warning me-2" style="display: none;">Edit</button>
      <button id="deleteBtn" class="btn btn-danger">Delete</button>
    </div>

    <table id="preferencesTable" class="table table-bordered table-hover align-middle text-center">
      <thead class="table-dark">
        <tr>
          <th><input type="checkbox" id="selectAll"></th>
          <th>ID</th>
          <th>User ID</th>
          <th>Username</th>
          <th>Type</th>
          <th>Value</th>
        </tr>
      </thead>
    </table>
  </div>
</section>
</main>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-dark">
        Are you sure you want to delete the selected preference(s)?
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button id="confirmDeleteBtn" class="btn btn-danger">Delete</button>
      </div>
    </div>
  </div>
</div>


<!-- Footer -->
<?php include 'includes/footer.php'; ?>
<?php include 'includes/chatbot_code.php'; ?>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
  const table = $('#preferencesTable').DataTable({
    "ajax": "fetch_admin_preferences.php",
    "columns": [
      {
        "data": null,
        "orderable": false,
        "className": 'dt-body-center',
        "render": function (data, type, row) {
          return `<input type="checkbox" class="row-checkbox" value="${row.pref_ID}">`;
        }
      },
      { "data": "pref_ID" },
      { "data": "user_id" },
      { "data": "email"},
      { "data": "name" },
      { "data": "value" }
    ]
  });

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

  let selectedDeleteIDs = [];

  $('#deleteBtn').on('click', function () {
    selectedDeleteIDs = $('.row-checkbox:checked').map(function () {
      return this.value;
    }).get();

    if (selectedDeleteIDs.length === 0) {
      alert('Please select at least one preference to delete.');
      return;
    }

    const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
    modal.show();
  });

  $('#confirmDeleteBtn').on('click', function () {
    selectedDeleteIDs.forEach(id => {
      $.post('delete_prefs.php', { preference_id: id }, function (response) {
        if (response.success) {
          $('#preferencesTable').DataTable().ajax.reload();
        } else {
          alert('Error: ' + response.error);
        }
      }, 'json');
    });

    selectedDeleteIDs = [];

    const modalElement = document.getElementById('confirmDeleteModal');
    const modalInstance = bootstrap.Modal.getInstance(modalElement);
    modalInstance.hide();
  });

  $('#editBtn').on('click', function () {
    const selectedCheckbox = $('.row-checkbox:checked');
    if (selectedCheckbox.length !== 1) return;

    const row = selectedCheckbox.closest('tr');
    const rowData = table.row(row).data();
    const prefID = rowData.pref_ID;

    window.location.href = `update_preference.php?pref_ID=${prefID}`;
  });
});
</script>

</body>
</html>
