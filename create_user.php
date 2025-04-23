<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <section class="py-5">
        <div class="container text-center">
            <h2>Create a New User</h2>
            <br>
            <form action="create_user_connection.php" method="POST" class="text-start mx-auto" style="max-width: 600px;">

                <div class="mb-3 fw-bold">
                    <label for="first_name" class="form-label">First Name:</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                </div>

                <div class="mb-3 fw-bold">
                    <label for="last_name" class="form-label">Last Name:</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                </div>

                <div class="mb-3 fw-bold">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="mb-3 fw-bold">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="mb-3 fw-bold">
                    <label for="role" class="form-label">Role:</label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div class="mb-3 fw-bold">
                    <label for="active" class="form-label">Active:</label>
                    <select name="active" id="active" class="form-select" required>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success">Create User</button>
                </div>
            </form>
        </div>
    </section>
</main>

<!-- Footer -->
<?php include "includes/footer.php"; ?>
<?php include "includes/chatbot_code.php"; ?>

</body>
</html>
