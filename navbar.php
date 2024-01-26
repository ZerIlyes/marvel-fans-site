<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ajoutez des messages d'erreur pour le débogage
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    error_log('L\'utilisateur n\'est pas connecté ou la variable de session "loggedin" n\'est pas définie.');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Titre de Page</title>
    <!-- Liens vers les fichiers CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Liens vers vos fichiers CSS personnalisés -->
    <link rel="stylesheet" href="public/css/navbar1.css">
    <!-- Optionnel : Liens vers les icônes Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>
<body>

<a href="index.php?action=login">Connexion</a>
<a href="index.php?action=register">Inscription</a>
<?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
    <a href="index.php?action=logout">Déconnexion</a>
<?php endif; ?>


<!-- Modal d'inscription -->
<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="signupModalLabel">Inscription</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulaire d'inscription -->
                <form method="post" action="register.php">
                    <div class="form-group">
                        <label for="avatar">Choisissez votre avatar :</label>
                        <select name="avatar" id="avatar" class="form-control" required>
                            <option value="public/captain.png">Captain</option>
                            <option value="public/ironman.png">Iron Man</option>
                            <option value="public/spiderman.png">Spider-Man</option>
                            <option value="public/the-flash.png">The Flash</option>
                            <option value="public/selim.png">The Selim du 95</option>
                            <!-- Ajoutez les autres options d'avatar ici -->
                        </select>
                    </div>
                    <div class="d-flex justify-content-center mb-3">
                        <img id="selectedAvatar" src="public/images/captain.png" alt="Selected Avatar" width="128" height="128">
                    </div>
                    <div class="form-group">
                        <label for="username">Nom d'utilisateur</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Nom d'utilisateur" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" required>
                    </div>
                    <button type="submit" class="btn btn-primary">S'inscrire</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Écouter l'événement de changement de sélection dans la liste déroulante d'avatar
        document.getElementById("avatar").addEventListener("change", function () {
            // Mettre à jour l'image affichée en fonction de la sélection de l'utilisateur
            const selectedAvatar = this.value;
            document.getElementById("selectedAvatar").src = selectedAvatar;
        });
    });
</script>
<!-- Modal de connexion -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Se connecter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body d-flex">
                <!-- Zone d'image ou d'illustration -->
                <div class="login-illustration">
                    <img src="public/images/Image-connexion.png" alt="Connexion" style="max-width:100%;height:auto;">
                </div>

                <!-- Formulaire de connexion -->
                <div class="login-form">
                    <form method="post" action="login.php">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" required>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember-me">
                                <label class="form-check-label" for="remember-me">Se souvenir de moi</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Se connecter</button>
                    </form>
                    <div class="login-help">
                        <a href="#">Mot de passe oublié?</a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="login-register">
                    Vous n'avez pas de compte? <a href="#">Inscrivez-vous</a>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Liens vers les scripts JavaScript de Bootstrap (jQuery et Popper.js) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<!-- Lien vers le fichier JavaScript de Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

