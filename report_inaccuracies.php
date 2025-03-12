<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>report innaccuracies</title>
</head>
<?php include_once 'includes/navbar.php'; ?> <!-- Include the navbar here -->
<?php include 'includes/header.php'; ?>

<body>
    <form action="report_processing.php" method="POST">
        <label for="title">Dance Name</label>
        <input type="text" id="title" name="title" required><br><br>

        <label for="complaint">Complaint:</label><br>
        <textarea id="complaint" name="complaint" rows="4" cols="50" required></textarea><br><br>

        <button type="submit">submit report</button>
</body>
<?php include 'includes/footer.php'; ?>
</html>