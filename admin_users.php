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
  <title>Dancopedia - Users List</title>

  <!-- Bootstrap & DataTables CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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
<?php include "includes/navbar.php"; ?>

<main>
<section class="text-center py-5">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <a href="javascript:history.back()" class="btn btn-outline-secondary btn-sm" title="Go back">
        <i class="bi bi-arrow-left"></i>
      </a>
      <h2 class="flex-grow-1 text-center mb-0">Users</h2>
      <div style="width: 32px;"></div>
    </div>

    <div class="mb-3 text-end">
      <a href="create_user.php" class="btn btn-success me-2">Create User</a>
      <button id="statusBtn" class="btn btn-info me-2">Change Status</button>
      <button id="editBtn" class="btn btn-warning me-2" style="display: none;">Edit</button>
      <button id="deleteBtn" class="btn btn-danger">Delete</button>
    </div>

    <table id="usersTable" class="table table-bordered table-hover align-middle text-center">
      <thead class="table-dark">
        <tr>
          <th><input type="checkbox" id="selectAll"></th>
          <th>ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Created</th>
          <th>Status</th>
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
        Are you sure you want to delete the selected user(s)? This action <strong>cannot</strong> be undone.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button id="confirmDeleteBtn" type="button" class="btn btn-danger">Delete</button>
      </div>
    </div>
  </div>
</div>

<!-- Change Status Modal -->
<div class="modal fade" id="changeStatusModal" tabindex="-1" aria-labelledby="changeStatusModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="changeStatusModalLabel">Change User Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-start">
        <label for="newStatus" class="form-label fw-bold">Set selected users to:</label>
        <select class="form-select" id="newStatus">
          <option value="yes">Active</option>
          <option value="no">Inactive</option>
        </select>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button id="confirmStatusBtn" class="btn btn-info">Update Status</button>
      </div>
    </div>
  </div>
</div>


<?php include 'includes/footer.php'; ?>
<?php include "includes/chatbot_code.php"; ?>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
  const table = $('#usersTable').DataTable({
    "ajax": "fetch_admin_users.php",
    "columns": [
      {
        "data": null,
        "orderable": false,
        "className": 'dt-body-center',
        "render": function (data, type, row) {
          return `<input type="checkbox" class="row-checkbox" value="${row.id}">`;
        }
      },
      { "data": "id" },
      { "data": "first_name" },
      { "data": "last_name" },
      { "data": "email" },
      { "data": "role" },
      {
        "data": "created_time",
        "render": function (data) {
          const date = new Date(data);
          return `${date.getMonth() + 1}/${date.getDate()}/${date.getFullYear().toString().slice(-2)}`;
        }
      },
      {
        "data": "active",
        "render": function(data, type, row) {
          return data === 'no' ? 'Inactive' : 'Active';
        }
      }
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

  $('#editBtn').on('click', function () {
    const table = $('#usersTable').DataTable();
    const selectedCheckbox = $('.row-checkbox:checked');

    if (selectedCheckbox.length !== 1) {
      alert('Please select exactly one user to edit.');
      return;
    }

    const rowElement = selectedCheckbox.closest('tr');
    const rowData = table.row(rowElement).data();

    if (!rowData || !rowData.id) {
      alert("Unable to retrieve selected user's ID.");
      return;
    }

    const userId = rowData.id;

    window.location.href = `update_user.php?user_id=${userId}`;
  });

  let selectedDeleteIDs = [];

  $('#deleteBtn').on('click', function () {
    selectedDeleteIDs = $('.row-checkbox:checked').map(function () {
      return this.value;
    }).get();

    if (selectedDeleteIDs.length === 0) {
      alert('Please select at least one user to delete.');
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
      $.post('delete_user.php', { user_id: id }, function (response) {
        if (response.success) {
          $('#usersTable').DataTable().ajax.reload();
        } else {
          alert('Error: ' + response.error);
        }
      }, 'json');
    });

    $('#confirmDeleteModal').modal('hide');
  });

  $('#statusBtn').on('click', function () {
    const selectedIDs = $('.row-checkbox:checked').map(function () {
      return this.value;
    }).get();

    if (selectedIDs.length === 0) {
      alert('Please select at least one user.');
      return;
    }

    $('#changeStatusModal').data('selectedIDs', selectedIDs);
    const modal = new bootstrap.Modal(document.getElementById('changeStatusModal'));
    modal.show();
  });

  $('#confirmStatusBtn').on('click', function () {
    const selectedIDs = $('#changeStatusModal').data('selectedIDs');
    const newStatus = $('#newStatus').val();

    $.post('change_user_status.php', {
      user_ids: selectedIDs,
      new_status: newStatus
    }, function (response) {
      if (response.success) {
        const modalElement = document.getElementById('changeStatusModal');
        const modalInstance = bootstrap.Modal.getInstance(modalElement);
        modalInstance.hide();

        $('#usersTable').DataTable().ajax.reload();

        alert('User status updated successfully.');
      } else {
        alert('Server error: ' + response.error);
      }
    }, 'json').fail(function (jqXHR, textStatus, errorThrown) {
      console.error("AJAX failure:", textStatus, errorThrown, jqXHR.responseText);
      alert('Request failed.');
    });
  });
});
</script>

</body>
</html>
