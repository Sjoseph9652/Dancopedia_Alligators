<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$dbname = "gatorz_db";
$username = "root";
$password = "";
$port = 3306;

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
        $query = "SELECT
                    p.*, u.email
                    FROM preferences p
                    JOIN users u ON p.user_id = u.id";

        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // return json
        echo json_encode(['success' => true, 'data' => $results]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }

    exit;
}
?>