<?php
session_start();

// Dummy user data (replace with actual user session data)(to corespond with the logged user)
// $user_name = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
// $user_status = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : 'Guest';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Account Details</h3>
        </div>
        <div class="card-body">
            <p><strong>Account Name:</strong> <?php echo htmlspecialchars($user_name); ?></p>
            <p><strong>Account Status:</strong> 
                <span class="badge 
                    <?php echo ($user_status == 'Admin') ? 'bg-danger' : 
                                (($user_status == 'Registered User') ? 'bg-success' : 'bg-secondary'); ?>">
                    <?php echo htmlspecialchars($user_status); ?>
                </span>
            </p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
