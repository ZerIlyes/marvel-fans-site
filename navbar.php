<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ajoutez des messages d'erreur pour le débogage
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    error_log('L\'utilisateur n\'est pas connecté ou la variable de session "loggedin" n\'est pas définie.');
}
?>
    <!-- Liens vers les fichiers CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Liens vers vos fichiers CSS personnalisés -->
    <link rel="stylesheet" href="public/style.css">
    <!-- Optionnel : Liens vers les icônes Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">


    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php"> <img src = "public/Logo.jpg" width="100" height="50"> </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="quiz_list.php">Quiz</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="topics.php">Topics</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="write_review.php">Review</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="jarvis.php">Jarvis</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto"> <!-- Cette classe va pousser votre menu utilisateur à droite -->
                <?php
                if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                    echo '<li class="nav-item dropdown">';
                    echo '<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                    echo htmlspecialchars($_SESSION["username"]);
                    echo '</a>';
                    echo '<div class="dropdown-menu" aria-labelledby="userDropdown">';
                    echo '<a class="dropdown-item" href="logout.php">Déconnexion</a>';
                    echo '</div>';
                    echo '</li>';
                } else {
                    echo '<li class="nav-item"><a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal">Se connecter</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="#" data-toggle="modal" data-target="#signupModal">Sinscrire</a></li>';
                }
                ?>
            </ul>
        </div>
    </nav>


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
                            <img id="selectedAvatar" src="public/captain.png" alt="Selected Avatar" width="128" height="128">
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
                <div class="modal-body">
                    <!-- Formulaire de connexion -->
                    <form method="post" action="login.php">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Se connecter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Liens vers les scripts JavaScript de Bootstrap (jQuery et Popper.js) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <!-- Lien vers le fichier JavaScript de Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php
