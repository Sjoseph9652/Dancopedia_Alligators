<!-- ***This page helps send to data to the database through the form*** -->
<?php

//connection variables
$host = "localhost";
$dbname = "gatorz_db";
$username = "root";
$password = "";

//form variables
$creator_email = $_POST["creator_email"];
$danceName = $_POST["title"];
$region = $_POST["region"];
$description = $_POST["description"];
$style = $_POST["style"];
$image = file_get_contents($_FILES["photos"]["tmp_name"]);
$MimeType = $_FILES["photos"]["type"]; // Tells what type of image that is.
$link =$_POST["link"];



//connection object
//***Change to port 3306 when COMPLETE***
$conn = mysqli_connect($host, $username, $password, $dbname, 3306);

//Check for connection error
if (mysqli_connect_errno()) {
    die("Connection Error: " . mysqli_connect_error());
}

//sql statement variable
$sql = "INSERT INTO dances (name, creator_email, region, style, description , image, MimeType, link)
        VALUES (?,?,?,?,?,?,?,?)";

//prepared statement object
$stmt = mysqli_stmt_init($conn);

//check for prepared statement errors
if (! mysqli_stmt_prepare($stmt, $sql)) {
    die(mysqli_error($conn));
}

//bind variables to prepared statement
mysqli_stmt_bind_param($stmt, "ssssssss", $danceName, $creator_email, $region, $style, $description, $image, $MimeType,$link);

//execute prepared statment
mysqli_stmt_execute($stmt);

// commit changes
mysqli_commit($conn);

$conn->close();

header("location:create_dance.php?Successful=yes"); #Returns back to the form page.

?>
