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

    try {
        $query = "SELECT id, first_name, last_name, email, active, role, created_time, modified_time FROM users ";
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