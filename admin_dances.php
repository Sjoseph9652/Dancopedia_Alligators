<?php
session_save_path('/tmp');
session_start();


// Check if the user is logged in
if (!(isset($_SESSION['email'])))
{

    header("Location: LoginForm.php");

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
    <link rel="stylesheet" href="css/custom_style.css">

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


<main>

<section class="text-center py-5">
    <div class="container">
      <h2 class="mb-4">Dances</h2>
      <div class="mb-3 text-end">
          <button id="editBtn" class="btn btn-warning me-2" style="display: none;">Edit</button>
          <button id="statusBtn" class="btn btn-info me-2">Change Status</button>
          <button id="deleteBtn" class="btn btn-danger">Delete</button>
        </div>
      <table id="danceTable" class="table table-bordered table-hover align-middle text-center">
        <thead class="table-dark">
          <tr>
            <th><input type="checkbox" id="selectAll"></th>
            <th>ID</th>
            <th>Name</th>
            <th>Creator</th>
            <th>Region</th>
            <th>Style</th>
            <th>Description</th>
            <th>Status</th>
            <th>Image</th>
            <th>Link</th>
          </tr>
        </thead>
      </table>
    </div>

</section>


</main>

<!-- deletion modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-dark">
        Are you sure you want to delete the selected dance(s)? This action <strong>cannot</strong> be undone.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button id="confirmDeleteBtn" type="button" class="btn btn-danger">Delete</button>
      </div>
    </div>
  </div>
</div>

<!-- footer -->
<?php include 'includes/footer.php'; ?>

</body>


<!-- Include Chatbot -->
<?php include "includes/chatbot_code.php"; ?>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.24.1/dist/bootstrap-table.min.js"></script>


<script>
$(document).ready(function () {
  $('#danceTable').DataTable({
    "ajax": "fetch_admin_dances.php",

    "columns": [
      {
        "data": null,
        "orderable": false,
        "className": 'dt-body-center',
        "render": function (data, type, row) {
          return `<input type="checkbox" class="row-checkbox" value="${row.dance_ID}">`;
        }
      },
      { "data": "dance_ID" },
      { "data": "name" },
      { "data": "creator_email" },
      { "data": "region" },
      { "data": "style" },
      { "data": "description" },
      {
        "data": "status",
        "render": function(data) {
          return data == 1 ? "Active" : "Inactive";
        }
      },
      {
        "data": "image",
        "render": function(data, type, row) {
          if (data && row.MimeType) {
            return `<img src="data:${row.MimeType};base64,${data}" style="max-width:100px;">`;
          }
          return "No Image";
        }
      },
      {
        "data": "Link",
        "render": function(data) {
          return data ? `<a href="${data}" target="_blank">View</a>` : "No Link";
        }
      }
    ]
  });
});

$('#selectAll').on('click', function () {
  const isChecked = $(this).is(':checked');
  $('.row-checkbox').prop('checked', isChecked);
});
function updateButtonVisibility() {
  const checkedCount = $('.row-checkbox:checked').length;
  $('#editBtn').toggle(checkedCount === 1);
}


$(document).on('change', '.row-checkbox', function () {
  updateButtonVisibility();
});

$('#selectAll').on('click', function () {
  $('.row-checkbox').prop('checked', this.checked);
  updateButtonVisibility();
});

let selectedDeleteIDs = [];

$('#deleteBtn').on('click', function () {
  selectedDeleteIDs = $('.row-checkbox:checked').map(function () {
    return this.value;
  }).get();

  if (selectedDeleteIDs.length === 0) {
    alert('Please select at least one dance to delete.');
    return;
  }

  // modal
  const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
  modal.show();
});

$('#statusBtn').on('click', function () {
  const ids = $('.row-checkbox:checked').map(function () {
    return this.value;
  }).get();

  if (ids.length === 0) {
    alert('Please select at least one item to change status.');
    return;
  }

  // You would send these IDs to the server via AJAX
  console.log('Change status of these IDs:', ids);
  // TODO: Add AJAX to toggle status
});

$('#editBtn').on('click', function () {
  const table = $('#danceTable').DataTable();
  const selectedCheckbox = $('.row-checkbox:checked');

  if (selectedCheckbox.length !== 1) return;

  const row = selectedCheckbox.closest('tr');
  const rowData = table.row(row).data();

  const danceID = rowData.dance_ID;

  window.location.href = `update_dance.php?dance_ID=${danceID}`;
});

</script>



</html>

