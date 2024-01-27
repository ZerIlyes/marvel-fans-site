<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Carrousel 3D de Bandes Dessinées</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/menu.css">
</head>
<body>
<!-- Dropdown Bootstrap pour le nom d'utilisateur -->
<div class="dropdown">
    <?php if (isset($_SESSION['username'])): ?>
        <button class="btn btn-secondary dropdown-toggle username-btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo htmlspecialchars($_SESSION['username']); ?>
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="index.php?action=logout">Déconnexion</a>
            <a class="dropdown-item" href="index.php?action=moncompte">Mon Compte</a>
        </div>
    <?php endif; ?>
</div>

<!-- Reste de votre contenu HTML -->

<!-- Scripts nécessaires pour Bootstrap -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/three/build/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three/examples/js/controls/OrbitControls.js"></script>
<script src="public/js/menu.js"></script>

</body>
</html>
