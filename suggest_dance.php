<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
</head>
<body>
    <h2>Dance Suggestion</h2>
    <form action= "suggestion_review.php" method="POST">
    <label for="title">Dance Name:</label>
    <input type="text" id="title" name="title" required><br><br>

    <label for="region">Region:</label>
    <input type="text" id="region" name="region" reguired><br><br>

    <label for="style">Style</label>
    <input type="style" id="style" name="style" reguired><br><br>

    <label for="description">Description:</label><br>
    <textarea id="description" name="description" rows="4" cols="50" required></textarea><br><br>

    <button type="submit">Suggest dance</button>
</body>
</html>