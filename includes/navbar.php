<!-- navbar.php -->

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="images/Dance_icon.webp" alt="Dancopedia Logo" width="40" height="40" class="me-2">
            Dancopedia
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" id="open-chat" href="#">Chat</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="search_results.php">Search</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="account_details.php">Account</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-primary text-white" href="settings.php">Settings</a>
                </li>

                <!-- Login / Logout -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Show Logout button when logged in -->
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger" href="logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <!-- Show Sign In button when logged out -->
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-primary" href="LoginForm.php">Sign In</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
