<?php
session_save_path('/tmp')
session_start();

$host = "metro.proxy.rlwy.net";
$dbname = "railway";
$username = "root";
$password = "ZvOusNgFFhFQyzSIOouCCAUDqYVJFhCJ";
$port = 55656;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$dance_id = isset($_GET['dance_id']) ? intval($_GET['dance_id']) : 0;


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');

    try {
        $query = "SELECT
                    i.*,
                    d.name
                  FROM interactions i
                  JOIN dances d ON i.dance_id = d.dance_ID
                  WHERE i.dance_id = :dance_id
                  ORDER BY i.created_on DESC
                  LIMIT 8";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':dance_id', $dance_id, PDO::PARAM_INT);

        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'data' => $results]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }

    exit;
}
