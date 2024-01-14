<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.html">
            <img src="../public/Logo.jpg" alt="Logo Marvel Fans" height="40">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <?php
                if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                    // Afficher le nom d'utilisateur et le bouton de déconnexion
                    echo '<li class="nav-item dropdown">';
                    echo '<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                    echo htmlspecialchars($_SESSION["username"]);
                    echo '</a>';
                    echo '<div class="dropdown-menu" aria-labelledby="userDropdown">';
                    echo '<a class="dropdown-item" href="logout.php">Déconnexion</a>';
                    echo '</div>';
                    echo '</li>';
                } else {
                    // Afficher les boutons de modal pour l'inscription et la connexion
                    echo '<li class="nav-item"><a class="nav-link" href="#" data-toggle="modal" data-target="#signupModal">S\'inscrire</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal">Se connecter</a></li>';
                }
                ?>
            </ul>
        </div>
    </nav>
<?php
