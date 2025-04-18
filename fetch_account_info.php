<?php
session_start(); 
// Connection variables
$host = "metro.proxy.rlwy.net";
$dbname = "railway";
$username = "root";
$password = "ZvOusNgFFhFQyzSIOouCCAUDqYVJFhCJ";
$port = 55656;

// sets up connection to database and does error handling 
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$email = $_SESSION["email"];

// If an image request is made
if (isset($_GET['dance_ID'])) {
    $dance_ID = $_GET['dance_ID'];
    $query = "SELECT image, MimeType FROM dances WHERE dance_ID = :dance_ID";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':dance_ID', $dance_ID, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        header("Content-Type: " . $row['MimeType']);
        echo $row['image'];
    }
    exit;
}

// Fetch dances list for the logged-in user
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');

    try {
        $query = "SELECT dance_ID, name, region, style, description, status, Link FROM dances WHERE creator_email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Add image URL to each dance entry
        foreach ($results as &$dance) {
            $dance['image_url'] = "fetch_account_info.php?dance_ID=" . $dance['dance_ID']; // to be referenced in account page
            $dance['video_link'] = $dance['Link'];
        }

        echo json_encode(['success' => true, 'data' => $results]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }

    exit;
}
?>
