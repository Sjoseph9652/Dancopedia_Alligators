<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dancopedia - Discover Dances</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/chatbot.css"> <!-- Link to your external chatbot CSS -->
</head>
<style>
/* Header Background, extra */
.header {
    background-image: url('blog_dance2_480x480.webp'); 
}
</style>

<body>
	<!-- https://getbootstrap.com/docs/5.3/components/navbar/ -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">Dancopedia</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"> <a class="nav-link" id="open-chat" href="#">Chat</a></li>
                    <li class="nav-item"><a class="nav-link" href="search_results.html">Search</a></li>
                    <li class="nav-item"><a class="nav-link" href="my_account.php">Account</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-outline-primary" href="LoginForm.php">Sign In</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-primary text-white" href="#">Settings</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="header">
        <h1 class="text-center" style="color: white; font-weight: bold;">Dancopedia</style></h1>
        <p class="text-center" style="color:white;">Discover Dances of Mexico</style></p>
        <button class="btn btn-primary">Search</button>
    </header>

<body>

    <h1>Forgot Password</h1>

    <form method="post" action="send-password-reset.php">

        <label for="email">email</label>
        <input type="email" name="email" id="email">

        <button>Send</button>

    </form>

</body>

</html>