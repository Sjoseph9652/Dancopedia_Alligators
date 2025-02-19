<!-- ***This page helps retreive data from the database to the home page*** -->
<?php

//connection variables
$host = "localhost";
$dbname = "gatorz_db";
$username = "root";
$password = "";

//connection object
//***Change to port 3306 when COMPLETE***
$conn = mysqli_connect($host, $username, $password, $dbname, 3306);

//Check for connection error
if (mysqli_connect_errno()) {
    die("Connection Error: " . mysqli_connect_error());
}

//sql statement variable
$sql = " SELECT name, description, MimeType, image FROM dances limit 6";
$result = $conn->query($sql);

/*
$counter = 0;
// Array varibles 
$name = [];
$desc = [];
$img = [];
*/
$result_rows = [];

//table rows
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $result_rows[] = $row;
     /* echo  "Name: " . $row["name"]. " " . $row["description"]. "<br>";*/
      //ame[$counter]=$row["name"];
      //esc[$counter]=$row["description"];
      //mg[$counter]=$row["image"];
      //$counter++;
    }
  } 

  /*
  else {
    echo "0 results";
  }
echo $name[1];
/*

//prepared statement object
$stmt = mysqli_stmt_init($conn);

//check for prepared statement errors
if (! mysqli_stmt_prepare($stmt, $sql)) {
    die(mysqli_error($conn));
}

//bind variables to prepared statement
mysqli_stmt_bind_param($stmt, "sssss", $danceName, $region, $style, $description, $image);

//execute prepared statment
mysqli_stmt_execute($stmt);

// commit changes
mysqli_commit($conn);
 */
$conn->close();

?>