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
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password); #;port=3308
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

//$email = $_SESSION["email"];
$email = $_SESSION["email"] ?? null;

// ajax get request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');

    try {
        $query = "SELECT dance_ID, name, region, style, description, status, link, MimeType, TO_BASE64(image) AS image_base64
                    FROM dances
                    ORDER BY RAND()
                    LIMIT 12 ";
        $stmt = $pdo->prepare($query);
        $stmt->execute();

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
