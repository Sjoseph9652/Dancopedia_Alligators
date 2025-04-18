<?php
session_save_path('/tmp');
session_start(); 
ob_start();
require 'db_configuration.php';
include('header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        require 'login.php';
    } elseif (isset($_POST['register'])) {
        require 'register.php';
    }
}
ob_flush();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dancopedia - Discover Dances</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> <!-- THis style sheet is needed for the "Eye" icon -->
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/chatbot.css"> <!-- Link to your external chatbot CSS -->
    <link rel="stylesheet" href="css/custom_style.css">
</head>
<body>
    <!-- navbar -->
    <?php include "includes/navbar.php"; ?>

    <!-- Include Chatbot -->
    <?php include "includes/chatbot_code.php"; ?>

    <main>
<div class="container mt-5">
    <div class="form">
        <ul class="nav nav-tabs mb-3">
            <!-- navigation tabs for Login and New users -->
            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#login">Login</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#register">New User</a></li>
        </ul>
        <!-- These tabs are shown when the user logins in --> 
        <div class="tab-content">
            <div id="login" class="tab-pane fade show active">
                <h2>Welcome Back!</h2>
                <form action="LoginForm.php" method="post">
                    <div class="mb-3">
                        <label>Email Address</label>
                        <input type="email" class="form-control" required name="email">
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" class="form-control eye" id="password1" required name="password">
                        <i class="bi bi-eye-slash eye1" id="togglePass1"></i>
                            <script src="passwordToggle2.js"></script>
                    </div>
                    <button class="btn btn-primary w-100" name="login">Log In</button>
                    <a href="confirmEmail.php" class="d-block text-center mt-2">Forgot password?</a>
                </form>
            </div>
            <!-- These tabs are shown when there is a new user --> 
            <div id="register" class="tab-pane fade">
                <h2>Register as a new user</h2>
                <form action="register.php" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <label>First Name</label>
                            <input type="text" class="form-control" required name="first_name">
                        </div>
                        <div class="col-md-6">
                            <label>Last Name</label>
                            <input type="text" class="form-control" required name="last_name">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Email Address</label>
                        <input type="email" class="form-control" required name="email">
                    </div>
                    <div class="mb-3">
                        <p>
                            <label>Set A Password</label>
                            <input type="password" class="form-control eye" id="password" required name="password" pattern="(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%?^&*])[A-Za-z\d!@#$%?^&*]+" minlength=8 maxlength=20 title="Password must contain at least one Uppercase, Lowercase, Digit, Special Character, and be 8 characters long" style="width:100%">
                            <i class="bi bi-eye-slash eye1" id="togglePass"></i>
                            <script src="passwordToggle.js"></script>
                        </p>
                    </div>
                    <button class="btn btn-success w-100" name="register">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>
</main>


<!-- Include footer -->
<?php include "includes/footer.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
