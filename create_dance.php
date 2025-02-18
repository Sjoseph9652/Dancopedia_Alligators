<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create a dance</title>
</head>
<body>
    <h2>Create a dance</h2>
    <form action="create_dance_connection.php" method="POST" enctype="multipart/form-data">
        <label for="creator_email">Creator Email:</label>
        <input type="email" id="creator_email" name="creator_email" required><br><br>

        <label for="title">Dance Name:</label>
        <input type="text" id="title" name="title" required><br><br>

        <label for="region">Region:</label>
        <input type="text" id="region" name="region" required><br><br>

        <label for="style">Style</label>
        <input type="style" id="style" name="style" required><br><br>

        <!-- Style, Tags, Region-->

        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="4" cols="50" required></textarea><br><br>

        <label for="tags">Tags:</label><br>
        <textarea id="tags" name="tags" rows="4" cols="50"></textarea><br><br> 
        
        <label for="photos">Upload Photos:</label>
        <input type="file" id="photos" name="photos" multiple><br><br>

        <button type="submit">Create Dance</button>
    </form>
</body>
</html>