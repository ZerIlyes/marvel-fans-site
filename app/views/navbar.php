<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barre de navigation</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <!-- Ici, vous pouvez ajouter le logo ou le titre du site -->
        <a class="navbar-brand" href="index.php">Marvel Fans</a>

        <!-- Boutons de navigation -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=jarvis">Jarvis</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=quiz_list">Quiz</a>
                </li>
            </ul>
        </div>
        <!-- Inclusion des modaux de connexion et d'inscription -->
        <?php include('app/views/auth/loginModalView.php'); ?>
        <?php include('app/views/auth/registerModalView.php'); ?>
        <!-- Boutons de connexion/inscription/déconnexion -->
        <div class="navbar-nav ml-auto">
            <button class="btn btn-primary mr-2" data-toggle="modal" data-target="#loginModal">Connexion</button>
            <button class="btn btn-secondary" data-toggle="modal" data-target="#signupModal">Inscription</button>
            <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                <a href="index.php?action=logout" class="btn btn-danger">Déconnexion</a>
            <?php endif; ?>
        </div>
    </div>
</nav>



<!-- Bootstrap JS, Popper.js, et jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
