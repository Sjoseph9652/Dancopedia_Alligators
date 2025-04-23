<?php
session_start();
// Connection variables
$host = 'localhost';
$dbname = 'gatorz_db';
$username = 'root';
$password = '';

// sets up connection to database and does error handling 
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$email = $_SESSION["email"];

// ajax get request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');

    // pull search query parts from form
    $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
    $searchType = isset($_GET['type']) ? $_GET['type'] : '';

    try {
        // determines type of search query and pulls results
        if ($searchType === "name-button") {
            $query = "SELECT dance_ID, name, region, style, description, status, link, MimeType, TO_BASE64(image) AS image_base64 FROM dances WHERE name LIKE ?";
        } elseif ($searchType === "region-button") {
            $query = "SELECT dance_ID, name, region, style, description, status, link, MimeType, TO_BASE64(image) AS image_base64 FROM dances WHERE region LIKE ?";
        } elseif ($searchType === "style-button") {
            $query = "SELECT dance_ID, name, region, style, description, status, link, MimeType, TO_BASE64(image) AS image_base64 FROM dances WHERE style LIKE ?";
        }
        $stmt = $pdo->prepare($query);
        $stmt->execute(["%$searchQuery%"]);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // image handling
        foreach ($results as &$dance) {
                    if (!empty($dance['image_base64'])) {
                        $dance['image'] = "data:" . $dance['MimeType'] . ";base64," . $dance['image_base64'];
                    } else {
                        $dance['image'] = null; // Handle missing images
                    }
                    unset($dance['image_base64']); // Remove raw Base64 data to keep response clean
                }

        // return json
        echo json_encode(['success' => true, 'data' => $results]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }

    exit;
}
?>
