<?php
session_start();


// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: LoginForm.php");
    exit;
}

$user_id = $_GET['user_id'] ?? null;
if (!$user_id || (int)$_SESSION['user_id'] !== (int)$user_id) {
    die("Unauthorized access.");
}

$host = "localhost";
$dbname = "gatorz_db";
$username = "root";
$password = "";
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $column_pref = (int)$_POST['column_pref'];

    // Update user info
    $stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=?, email=? WHERE id=?");
    $stmt->bind_param("sssi", $first_name, $last_name, $email, $user_id);
    $stmt->execute();

    // Update session email if it changed
    $_SESSION['email'] = $email;

    // Upsert column preference
    $stmt = $conn->prepare("
        INSERT INTO preferences (user_id, name, value)
        VALUES (?, 'columns', ?)
        ON DUPLICATE KEY UPDATE value = VALUES(value)
    ");
    $stmt->bind_param("ii", $user_id, $column_pref);
    $stmt->execute();

    $_SESSION['success'] = "Account details updated!";
    header("Location: my_account.php");
    exit;
}

// Fetch user info
$stmt = $conn->prepare("SELECT first_name, last_name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
if (!$user) {
    die("User not found.");
}

// Fetch column preference
$stmt = $conn->prepare("SELECT value FROM preferences WHERE user_id = ? AND name = 'columns'");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$pref = $result->fetch_assoc();
$column_pref = $pref['value'] ?? 4;
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

<body class="p-5">
<!-- Navbar -->
<?php include "includes/navbar.php"; ?>

<main>
    <br>
<div class="container">
  <h2>Edit Your Account</h2>

  <form method="POST">
    <div class="mb-3">
      <label for="first_name" class="form-label">First Name</label>
      <input type="text" class="form-control" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required>
    </div>

    <div class="mb-3">
      <label for="last_name" class="form-label">Last Name</label>
      <input type="text" class="form-control" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required>
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email Address</label>
      <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
    </div>

    <div class="mb-3">
      <label for="column_pref" class="form-label">Column Preference</label>
      <select class="form-select" name="column_pref" required>
        <?php foreach ([2, 3, 4, 6] as $option): ?>
          <option value="<?= $option ?>" <?= $column_pref == $option ? 'selected' : '' ?>><?= $option ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="my_account.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>
</main>

<!-- Footer -->
<?php include "includes/footer.php"; ?>
<?php include "includes/chatbot_code.php"; ?>

</body>
</html>
