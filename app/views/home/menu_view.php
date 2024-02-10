<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Carrousel 3D de Bandes Dessinées</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/menu.css">

</head>
<body>
<div class="dropdown">
    <?php if (isset($_SESSION['username'])): ?>
        <button class="btn btn-secondary dropdown-toggle username-btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo htmlspecialchars($_SESSION['username']); ?>
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="index.php?action=logout">Déconnexion</a>
            <a class="dropdown-item" href="index.php?action=moncompte">Mon Compte</a>
            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                <a class="dropdown-item" href="index.php?action=admin_panel">Administrateur</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>


<!-- Intégration du Carrousel 3D ici -->
<div id="drag-container">
    <div id="spin-container">
        <!-- Lien vers Quizz -->
        <a href="index.php?action=quiz_list">
            <img src="public/images/Quizzz.png" alt="Quiz" >
        </a>
        <!-- Lien vers Forum -->
        <a href="index.php?action=forum_topics">
            <img src="public/images/Forums.png" alt="Forum" >
        </a>
        <!-- Lien vers Review -->
        <a href="index.php?action=write_review">
            <img src="./public/images/Review.png" alt="Review">
        </a>
        <!-- Lien vers Jarvis -->
        <a href="index.php?action=jarvis">
            <img src="public/images/Jarviss.png" alt="Jarvis" >
        </a>
        <!-- Texte au centre du carrousel -->
        <p>©2024 Tous droits réservés : ComicsFan.com</p>
    </div>
    <div id="ground"></div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three/build/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three/examples/js/controls/OrbitControls.js"></script>
<script type="module" src="public/js/menu.js"></script>

</body>
</html>
