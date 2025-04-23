<?php
session_start();
// Connection variables 
$host = 'localhost';
$dbname = 'gatorz_db';
$username = 'root';
$password = '';

// Connection object 
$conn = mysqli_connect($host, $username, $password, $dbname, $port);

// form variables in IF
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dance_ID = $_POST['dance_ID'];
    $newName = $_POST['name'];
    $newDesc = $_POST['description'];
    $newRegion = $_POST['region'];
    $newStyle = $_POST['style'];
    $newLink = $_POST['link'];

    // Sanitize input
    $newName = mysqli_real_escape_string($conn, $newName);
    $newDesc = mysqli_real_escape_string($conn, $newDesc);
    $newRegion = mysqli_real_escape_string($conn, $newRegion);
    $newStyle = mysqli_real_escape_string($conn, $newStyle);
    $newLink = mysqli_real_escape_string($conn, $newLink);

    if(!empty($_FILES['photo']['tmp_name']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK)
    {
        $image = file_get_contents($_FILES['photo']['tmp_name']);
        $MimeType = $_FILES['photo']['type'];

        $query = "UPDATE dances SET name=?, description=?, region=?, style=?, image=?, MimeType=?, link=? WHERE dance_ID=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssssssi", $newName, $newDesc, $newRegion, $newStyle, $image, $MimeType, $newLink, $dance_ID);
    }
    else 
    {
        // Update query without image
        $query = "UPDATE dances SET name=?, description=?, region=?, style=?, link=? WHERE dance_ID=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssssi", $newName, $newDesc, $newRegion, $newStyle, $newLink, $dance_ID);
    }

    // Update query
    //$query = "UPDATE dances SET name='$newName', description='$newDesc', region='$newRegion', style='$newStyle' WHERE dance_ID='$dance_ID'";

    if (mysqli_stmt_execute($stmt)) {
        header("Location: my_account.php?success=1");
        exit();
    } else {
        echo "Error updating dance: " . mysqli_stmt_error($conn);
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
