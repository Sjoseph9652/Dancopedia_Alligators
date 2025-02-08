<!-- ***This page helps send to data to the database through the form*** -->
<?php

//connection variables
$host = "localhost";
$dbname = "gatorz_db";
$username = "root";
$password = "";

//form variables
/*$creatorEmail = $_POST["email"];*/
$danceName = $_POST["title"];
$region = $_POST["region"];
$description = $_POST["description"];
$style = $_POST["style"];
/*$image = $_POST["image"];*/

var_dump(/*$creatorEmail,*/ $danceName, $region, $description, $style, /*$image*/);

//connection object
$conn = mysqli_connect($host, $username, $password, $dbname, 3306);

//Check for connection error
if (mysqli_connect_errno()) {
    die("Connection Error: " . mysqli_connect_error());
}

//sql statement variable
$sql = "INSERT INTO dances (name, region, style, description/*, image*/)
        VALUES (?,?,?,?/*, ?*/)";

//prepared statement object
$stmt = mysqli_stmt_init($conn);

//check for prepared statement errors
if (! mysqli_stmt_prepare($stmt, $sql)) {
    die(mysqli_error($conn));
}

//bind variables to prepared statement
mysqli_stmt_bind_param($stmt, "ssss", $danceName, $region, $style, $description/*, $image*/);

//execute prepared statment
mysqli_stmt_execute($stmt);

// commit changes
mysqli_commit($conn);

$conn->close();
?>