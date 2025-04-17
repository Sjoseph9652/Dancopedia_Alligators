<?php
// Handles adding the report into the inaccuracies table in the database
//connection variables
$servername = "metro.proxy.rlwy.net";
$dbname = "railway";
$username = "root";
$password = "ZvOusNgFFhFQyzSIOouCCAUDqYVJFhCJ";
$port = 55656;

//form variables
$title = $_POST["title"];
$complaint = $_POST["complaint"];


var_dump($title, $complaint);

//connection object
$conn = mysqli_connect($host, $username, $password, $dbname);

//Check for connection error
if (mysqli_connect_errno()) {
    die("Connection Error: " . mysqli_connect_error());
}

//sql statement variable
$sql = "INSERT INTO inaccuracies (dance_name, description)
        VALUES (?, ?)";

//prepared statement object
$stmt = mysqli_stmt_init($conn);

//check for prepared statement errors
if (! mysqli_stmt_prepare($stmt, $sql)) {
    die(mysqli_error($conn));
}

//bind variables to prepared statement
mysqli_stmt_bind_param($stmt, "ss", $title, $complaint);

//execute prepared statment
mysqli_stmt_execute($stmt);

$conn->close();

header("Location: my_account.php");
exit();
?>