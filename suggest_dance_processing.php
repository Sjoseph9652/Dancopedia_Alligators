<?php
// Handles adding the dance suggestions from the form into the dancesuggestion table in the database
//connection variables
$host = "metro.proxy.rlwy.net";
$dbname = "railway";
$username = "root";
$password = "ZvOusNgFFhFQyzSIOouCCAUDqYVJFhCJ";
$port = 55656;

//form variables
$title = $_POST["title"];
$region = $_POST["region"];
$style = $_POST["style"];
$description = $_POST["description"];

var_dump($title, $region, $style, $description);

//connection object
$conn = mysqli_connect($host, $username, $password, $dbname);

//Check for connection error
if (mysqli_connect_errno()) {
    die("Connection Error: " . mysqli_connect_error());
}

//sql statement variable
$sql = "INSERT INTO dancesuggestion (dance_name, style, region, description)
        VALUES (?, ?, ?, ?)";

//prepared statement object
$stmt = mysqli_stmt_init($conn);

//check for prepared statement errors
if (! mysqli_stmt_prepare($stmt, $sql)) {
    die(mysqli_error($conn));
}

//bind variables to prepared statement
mysqli_stmt_bind_param($stmt, "ssss", $title, $region, $style, $description);

//execute prepared statment
mysqli_stmt_execute($stmt);

$conn->close();
?>