<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <title>Accueil - Site Fans Marvel</title>
</head>  
<body>
<!-- Navbar -->
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


<!-- Scripts pour Bootstrap et dépendances -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.7.12/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>