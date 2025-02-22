<?php
session_start();

$host = "localhost";
$dbname = "gatorz_db";
$username = "root";
$password = "";



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dance_ID = $_POST['dance_ID'];
    $newName = $_POST['name'];
    $newDesc = $_POST['description'];
    $newRegion = $_POST['region'];
    $newStyle = $_POST['style'];

    $conn = mysqli_connect($host, $username, $password, $dbname, 3306);

    // Sanitize input
    $newName = mysqli_real_escape_string($conn, $newName);
    $newDesc = mysqli_real_escape_string($conn, $newDesc);
    $newRegion = mysqli_real_escape_string($conn, $newRegion);
    $newStyle = mysqli_real_escape_string($conn, $newStyle);

    // Update query
    $query = "UPDATE dances SET name='$newName', description='$newDesc', region='$newRegion', style='$newStyle' WHERE dance_ID='$dance_ID'";

    if (mysqli_query($conn, $query)) {
        header("Location: my_account.php?success=1");
        exit();
    } else {
        echo "Error updating dance: " . mysqli_error($conn);
    }
}
?>
