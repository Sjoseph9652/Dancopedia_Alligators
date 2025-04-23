<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dancopedia - Redesigned</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Work+Sans:wght@400;600&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="test-style.css">
</head>
<body>
    <!-- Navbar Include -->
    <?php include 'test-navbar.php'; ?>

    <!-- Hero Banner -->
    <section class="py-5 text-center bg-light hero-section">
        <div class="container">
            <h1 class="display-4">Bienvenidos a Dancopedia</h1>
            <p class="lead">Explora la rica herencia de las danzas tradicionales mexicanas</p>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container-fluid py-4">
        <div class="row g-4 justify-content-center" id="dances-container">
            <!-- Sample Dance Card -->
            <div class="col-md-4">
                <div class="card h-100">
                    <img src="images/danza1.jpg" class="card-img-top" alt="Danza Image">
                    <div class="card-body">
                        <h5 class="card-title">Jarabe Tapatío</h5>
                        <p class="card-text">El Jarabe Tapatío es un baile folclórico mexicano tradicionalmente reconocido por su estilo colorido y pasos vibrantes.</p>
                        <a href="#" class="btn btn-primary">Ver más</a>
                    </div>
                </div>
            </div>
            <!-- Repeat for other dances -->
        </div>
    </main>

    <!-- Footer Include -->
    <?php include 'test-footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>