<?php
session_start();
if (!isset($_SESSION['redirect_back'])) {
    if (!empty($_SERVER['HTTP_REFERER'])) {
        $_SESSION['redirect_back'] = $_SERVER['HTTP_REFERER'];
    }
}
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$host = "localhost";
$dbname = "gatorz_db";
$username = "root";
$password = "";

$conn = mysqli_connect($host, $username, $password, $dbname, 3306);

if (!isset($_GET['user_id'])) {
    die("User ID not provided.");
}

$user_id = $_GET['user_id'];
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    die("User not found.");
}

$user = mysqli_fetch_assoc($result);
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
        <div class="container">
            <h2>Update User</h2>
                <form action="submit_user_update.php" method="post">
                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $user['email']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label>First Name</label>
                        <input type="text" name="first_name" class="form-control" value="<?php echo $user['first_name']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label>Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="<?php echo $user['last_name']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role:</label>
                        <select name="role" id="role" class="form-select" required>
                            <option value="user" <?php if ($user['role'] == 'user') echo 'selected'; ?>>User</option>
                            <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="active" class="form-label">Active:</label>
                        <select name="active" id="active" class="form-select" required>
                            <option value="yes" <?php if (!empty($user['active']) && $user['active'] != 'no') echo 'selected'; ?>>Active</option>
                            <option value="no" <?php if (empty($user['active']) || $user['active'] == 'no') echo 'selected'; ?>>Inactive</option>

                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Update User</button>
                </form>
        </div>
    </section>
</main>

<!-- Footer -->
<?php include "includes/footer.php"; ?>
<?php include "includes/chatbot_code.php"; ?>

</body>
</html>
