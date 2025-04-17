<?php
//connection variables
$host = "metro.proxy.rlwy.net";
$dbname = "railway";
$username = "root";
$password = "ZvOusNgFFhFQyzSIOouCCAUDqYVJFhCJ";
$port = 55656;

//form variables
$firstName = $_POST["firstname"];
$lastName = $_POST["lastname"];
$email = $_POST["usermail"];
$userPassword = $_POST["password"];
$defaultRole = "user";

var_dump($firstName, $lastName, $email, $userPassword, $defaultRole);

//connection object
$conn = mysqli_connect($host, $username, $password, $dbname);

//Check for connection error
if (mysqli_connect_errno()) {
    die("Connection Error: " . mysqli_connect_error());
}

//sql statement variable
$sql = "INSERT INTO users (first_name, last_name, email, user_password, user_role)
        VALUES (?, ?, ?, ?, ?)";

//prepared statement object
$stmt = mysqli_stmt_init($conn);

//check for prepared statement errors
if (! mysqli_stmt_prepare($stmt, $sql)) {
    die(mysqli_error($conn));
}

//bind variables to prepared statement
mysqli_stmt_bind_param($stmt, "sssss", $firstName, $lastName, $email, $userPassword, $defaultRole);

//execute prepared statment
mysqli_stmt_execute($stmt);

$conn->close();
?>
