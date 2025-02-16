<!-- ***This page helps send to data to the database through the form*** -->
<?php

//connection variables
$host = "localhost";
$dbname = "gatorz_db";
$username = "root";
$password = "";

//form variables
/*$creator_email = $_POST["creator_email"];*/
$danceName = $_POST["title"];
$region = $_POST["region"];
$description = $_POST["description"];
$style = $_POST["style"];
/*var_dump($_FILES["photos"])*/ #tells to jpeg lol
$image = file_get_contents($_FILES["photos"]["tmp_name"]);

var_dump(/*$creator_email,*/ $danceName, $region, $description, $style, $image);

//connection object
//***Change to port 3306 when COMPLETE***
$conn = mysqli_connect($host, $username, $password, $dbname, 3308);

//Check for connection error
if (mysqli_connect_errno()) {
    die("Connection Error: " . mysqli_connect_error());
}

//sql statement variable
$sql = "INSERT INTO dances (name, /*creator_email,*/ region, style, description , image)
        VALUES (?,?,?,?,?)";

//prepared statement object
$stmt = mysqli_stmt_init($conn);

//check for prepared statement errors
if (! mysqli_stmt_prepare($stmt, $sql)) {
    die(mysqli_error($conn));
}

//bind variables to prepared statement
mysqli_stmt_bind_param($stmt, "sssss", $danceName, /*$creator_email,*/ $region, $style, $description, $image);

//execute prepared statment
mysqli_stmt_execute($stmt);

// commit changes
mysqli_commit($conn);

$conn->close();
?>