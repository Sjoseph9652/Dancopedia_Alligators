<?php
session_save_path('/tmp');
session_start(); // log user session
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

// default columns if not logged in
$default_columns = 4;

// login check
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => true, 'columns' => $default_columns]); // Default to 4 columns for guests
    exit;
}

$user_id = $_SESSION['user_id']; // pull user_id from session

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');

    try {
        // pull columnn pref for user from db based on user_id
        $query = "SELECT value FROM preferences WHERE name = 'columns' AND user_id = :user_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // get user pref for column or use default if not available
        $columns = $result ? intval($result['value']) : $default_columns;

        echo json_encode(['success' => true, 'columns' => $columns]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }

    exit;
}
?>