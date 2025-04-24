<?php
session_start();

//connection variables

$host = "localhost";
$dbname = "gatorz_db";
$username = "root";
$password = "";

//connection object
$mysqli = new mysqli($host, $username, $password, $dbname);

//Check for connection error
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}


//Logic to check for users email and password from users table in gatorz_db
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_email = strtolower(trim($_POST['email']));
    $user_password = trim($_POST['password']);

    if (!empty($user_email) && !empty($user_password)) {
        // Prepare the MySQLi statement
        $stmt = $mysqli->prepare("SELECT user_ID, email, user_password FROM users WHERE email = ?");
        $stmt->bind_param("s", $user_email); // "s" means string
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && $user_password === $user['user_password']) {
            $_SESSION['user_ID'] = $user['user_ID'];
            $_SESSION['username'] = $user['email']; // Assuming email is used as username
            header("Location: index.php"); // Redirect to home page
            exit();
        } else {
            echo "<p style='color: red;'>Invalid username or password.</p>";
        }

        // Close statement
        $stmt->close();
    } else {
        echo "<p style='color: red;'>Please fill in all fields.</p>";
    }
}

$mysqli->close();
?>