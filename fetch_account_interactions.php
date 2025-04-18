<?php
session_start(); // log user session

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

// default columns if not logged in
$default_columns = 4;

// login check
if (!isset($_SESSION['email'])) {
    exit;
}

$email = $_SESSION['email']; // pull user_id from session

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');

    try {
        $query = "SELECT
                        i.*,
                        u.first_name,
                        d.name
                    FROM interactions i
                    JOIN users u ON i.user_id = u.id
                    JOIN dances d ON i.dance_id = d.dance_ID
                    WHERE u.email = :email
                    ORDER BY i.created_on DESC
                    LIMIT 8";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['success' => true, 'data' => $result]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }

    exit;
}
?>
