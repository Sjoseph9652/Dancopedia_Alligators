<?php
session_save_path('/tmp');
session_start();
if (!isset($_SESSION['redirect_back'])) {
    if (!empty($_SERVER['HTTP_REFERER'])) {
        $_SESSION['redirect_back'] = $_SERVER['HTTP_REFERER'];
    }
}

$servername = "metro.proxy.rlwy.net";
$dbname = "railway";
$username = "root";
$password = "ZvOusNgFFhFQyzSIOouCCAUDqYVJFhCJ";
$port = 55656;

$conn = mysqli_connect($host, $username, $password, $dbname, $port);

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
    <title>Dancopedia - Discover Dances</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/chatbot.css"> <!-- Link to your external chatbot CSS -->
    <link rel="stylesheet" href="css/custom_style.css">
</head>
<style>
    /* Header Background, extra */
    .header {
        background-image: url('images/blog_dance2_480x480.webp');
    }


</style>

<body>
<!-- https://getbootstrap.com/docs/5.3/components/navbar/ -->

<!-- navbar -->
<?php include "includes/navbar.php"; ?>


<main>
    <section class="dance-list py-5">
        <div class="container">
            <h2>Update Dance</h2>
            <br>
                <form action="process_dance_update.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="dance_ID" value="<?php echo $dance['dance_ID']; ?>">

                    <!-- Dance name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Dance Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($dance['name']); ?>" required>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" required><?php echo htmlspecialchars($dance['description']); ?></textarea>
                    </div>

                    <!-- Region -->
                    <div class="mb-3">
                        <label for="region" class="form-label">Region</label>
                        <input type="text" class="form-control" id="region" name="region" value="<?php echo htmlspecialchars($dance['region']); ?>" required>
                    </div>

                    <!-- Style -->
                    <div class="mb-3">
                        <label for="style" class="form-label">Style</label>
                        <input type="text" class="form-control" id="style" name="style" value="<?php echo htmlspecialchars($dance['style']); ?>" required>
                    </div>

                    <!-- Links -->
                    <div class="mb-3">
                        <label for="style" class="form-label">Link</label>
                        <input type="text" class="form-control" id="link" name="link" value="<?php echo htmlspecialchars($dance['Link']); ?>">
                    </div>

                    <!-- Upload photos -->
                    <div class="mb-3 text-start fw-bold">
                        <label class="form-label" for="photos">Upload Photos:</label>
                        <input type="file" class="form-control" id="photo" name="photo">
                    </div>

                    <button type="submit" class="btn btn-success">Save Changes</button>
                    <a href="my_account.php" class="btn btn-secondary">Cancel</a>
                    <input type="hidden" name="redirect_back" value="<?php echo htmlspecialchars($_SESSION['redirect_back'] ?? 'my_account.php'); ?>">
                </form>
        </div>
    </section>
</main>


<!-- footer -->
<?php include "includes/footer.php"; ?>

<!-- Include Chatbot -->
<?php include "includes/chatbot_code.php"; ?>


</body>
</html>

<?php
session_start();
//var_dump($_SESSION);
if (isset($_SESSION['email']))
{
    echo "Logged in as: " . $_SESSION['email'];
} else {
    echo "User is not logged in.";
}
?>
