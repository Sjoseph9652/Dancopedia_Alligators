<?php
session_start();

$host = "localhost";
$dbname = "gatorz_db";
$username = "root";
$password = "";


$conn = mysqli_connect($host, $username, $password, $dbname, 3306);

// Check if dance_ID is in the URL
if (!isset($_GET['dance_ID'])) {
    die("Dance ID not provided.");
}

$dance_ID = $_GET['dance_ID'];

// Fetch dance details
$query = "SELECT * FROM dances WHERE dance_ID = '$dance_ID'";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Dance not found.");
}

$dance = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Dance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/chatbot.css"> <!-- Link to your external chatbot CSS -->
</head>
<style>
.header 
{
    background-image: url('images/blog_dance2_480x480.webp'); 
}
</style>
<body>
	<!-- https://getbootstrap.com/docs/5.3/components/navbar/ -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">Dancopedia</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"> <a class="nav-link" id="open-chat" href="#">Chat</a></li>
                    <li class="nav-item"><a class="nav-link" href="search_results.php">Search</a></li>
                    <li class="nav-item"><a class="nav-link" href="my_account.php">Account</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-outline-primary" href="LoginForm.php">Sign In</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-primary text-white" href="#">Settings</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="header">
        <h1 class="text-center">Dancopedia</h1>
        <p class="text-center">Discover Dances of Mexico</p>
        <button class="btn btn-primary">Search</button>
    </header>

<div class="container mt-5">
    <h2>Update Dance</h2>
    <form action="process_dance_update.php" method="POST">
        <input type="hidden" name="dance_ID" value="<?php echo $dance['dance_ID']; ?>">

        <div class="mb-3">
            <label for="name" class="form-label">Dance Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($dance['name']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" required><?php echo htmlspecialchars($dance['description']); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="region" class="form-label">Region</label>
            <input type="text" class="form-control" id="region" name="region" value="<?php echo htmlspecialchars($dance['region']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="style" class="form-label">Style</label>
            <input type="text" class="form-control" id="style" name="style" value="<?php echo htmlspecialchars($dance['style']); ?>" required>
        </div>

        <button type="submit" class="btn btn-success">Save Changes</button>
        <a href="my_account.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<footer class="text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Account</h5>
                    <ul class="list-unstyled">
                        <li><a href="my_account.php">Profile</a></li>
                        <li><a href="my_account.php">Saved Dances</a></li>
                        <li><a href="#">Change Password</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Explore</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php">Home Page</a></li>
                        <li><a href="search_results.php">Search</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Resources</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Documentation</a></li>
                        <li><a href="#">Requirements</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>


</body>
</html>