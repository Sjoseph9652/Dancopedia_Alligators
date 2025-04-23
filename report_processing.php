<?php
session_start(); 

// Connection variables
$host = "localhost";
$dbname = "gatorz_db";
$username = "root";
$password = "";


$title = $_POST["title"];
$complaint = $_POST["complaint"];

// Connection object
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check for connection error
if (mysqli_connect_errno()) {
    $_SESSION['report_feedback'] = "Error: Could not connect to the database.";
    $_SESSION['feedback_type'] = "danger";
    header("Location: report_inaccuracies.php");
    exit();
}


$sql = "INSERT INTO inaccuracies (dance_name, description) VALUES (?, ?)";

$stmt = mysqli_stmt_init($conn);

// Check for prepared statement errors
if (!mysqli_stmt_prepare($stmt, $sql)) {
    $_SESSION['report_feedback'] = "Error: Could not prepare the statement.";
    $_SESSION['feedback_type'] = "danger";
    header("Location: report_inaccuracies.php");
    exit();
}

mysqli_stmt_bind_param($stmt, "ss", $title, $complaint);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['report_feedback'] = "Thank you! Your report has been submitted successfully.";
    $_SESSION['feedback_type'] = "success";
} else {
    $_SESSION['report_feedback'] = "There was an issue submitting your report. Please try again.";
    $_SESSION['feedback_type'] = "danger";
}

$conn->close();

header("Location: report_inaccuracies.php");
exit();
?>
