<?php
session_start(); // start session

error_reporting(E_ALL);
ini_set('display_errors', 1);
// connection variables 
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

// default columns
$default_columns = 4;

// debug session
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in', 'columns' => $default_columns]);
    exit;
}

$user_id = $_SESSION['user_id']; // get user_id from session

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');

    try {
        // get col_pref based on user_id
        $query = "SELECT value FROM preferences WHERE name = 'columns' AND user_id = :user_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            throw new Exception("No column preference found for user_id: $user_id");
        }

        // use default or pref
        $columns = intval($result['value']) ?? $default_columns;

        echo json_encode(['success' => true, 'columns' => $columns]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }

    exit;
}
?>
