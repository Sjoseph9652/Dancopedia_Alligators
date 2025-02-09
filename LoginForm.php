<?php
ob_start();

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
<title>Register/Login Form</title>
<link href="css/loginForm.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="form">
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#login">Login</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#register">New User</a></li>
        </ul>
        <div class="tab-content">
            <div id="login" class="tab-pane fade show active">
                <h2>Welcome Back!</h2>
                <form action="loginForm.php" method="post">
                    <div class="mb-3">
                        <label>Email Address</label>
                        <input type="email" class="form-control" required name="email">
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" class="form-control" required name="password">
                    </div>
                    <button class="btn btn-primary w-100" name="login">Log In</button>
                    <a href="confirmEmail.php" class="d-block text-center mt-2">Forgot password?</a>
                </form>
            </div>
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
                        <label>Set A Password</label>
                        <input type="password" class="form-control" required name="password">
                    </div>
                    <button class="btn btn-success w-100" name="register">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
