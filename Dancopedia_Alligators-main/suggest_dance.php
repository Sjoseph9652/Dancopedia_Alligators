<!DOCTYPE html>
<html lang="en">
<?php include 'includes/header.php'; ?>
<body>

<?php include 'includes/navbar.php'; ?>
    <h2>Dance Suggestion</h2>
    <form action= "suggest_dance_processing.php" method="POST">
    <label for="title">Dance Name:</label>
    <input type="text" id="title" name="title" required><br><br>

    <label for="region">Region:</label>
    <input type="text" id="region" name="region" reguired><br><br>

    <label for="style">Style</label>
    <input type="style" id="style" name="style" reguired><br><br>

    <label for="description">Description:</label><br>
    <textarea id="description" name="description" rows="4" cols="50" required></textarea><br><br>

    <button type="submit">Suggest dance</button>
	
	 <?php include 'includes/footer.php'; ?>
</body>
</html>