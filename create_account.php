<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create an account</title>
</head>
<body>
    <h2>Create an account</h2>
    <form action="save-account.php" method="POST">
    <label for="firstname">First Name</label><br>
    <input id="firstname" type="text" name="firstname" placeholder="First Name" required><br><br>

    <label for="lastname">Last Name</label><br>
    <input id="lastname" type="text" name="lastname" placeholder="Last name" required><br><br>

    <label for="usermail">Email</label><br>
    <input id="usermail" type="email" name="usermail" placeholder="Yourname@email.com" required><br><br>

    <label for="password">Password</label><br>
    <input id="password" type="password" name="password" placeholder="Password" required><br><br>

    <input type="submit" id="submit-account" value="Create Account"/>
</form>
</body>
</html>