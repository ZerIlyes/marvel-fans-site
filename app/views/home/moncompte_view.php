<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Compte</title>
    <!-- Incluez les fichiers CSS Bootstrap ici -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <h1 class="mb-4">Mon Compte</h1>
            <!-- Informations personnelles actuelles -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Informations Personnelles Actuelles</h5>
                    <!-- Afficher l'avatar actuel de l'utilisateur -->
                    <img src="<?php echo htmlspecialchars($avatarPath); ?>" alt="Avatar actuel" class="img-fluid mb-3">
                    <p><strong>Nom d'utilisateur :</strong> <?php echo htmlspecialchars($_SESSION['username']); ?></p>
                    <!-- Dans moncompte_view.php -->
                    <p><strong>Email :</strong> <?php echo htmlspecialchars($email); ?></p>

                </div>
            </div>
        </div>
        <div class="col-md-8">
            <h2 class="mb-4">Modifier vos informations personnelles</h2>
            <!-- Début du formulaire -->
            <form method="post" action="index.php?action=updateProfile" enctype="multipart/form-data">
                <!-- Sélecteur d'avatar -->
                <div class="form-group">
                <label for="avatar">Choisissez votre avatar :</label>
                <select name="avatar" id="avatar" class="form-control" required onchange="updateAvatarPreview(this.value)">
                    <option value="public/images/Captainamerica.png">Captain</option>
                    <option value="public/images/Deadpool.png">Deadpool</option>
                    <option value="public/images/Ironman.png">Iron man</option>
                    <option value="public/images/spiderman.png">Spiderman</option>
                    <option value="public/images/Venom.png">Venom</option>
                    <option value="public/images/Wolverine.png">Wolverine</option>
                    <!-- Ajoutez les autres options d'avatar ici -->
                </select>
                <!-- Aperçu de l'avatar sélectionné -->
                <img id="avatarPreview" src="public/images/Captainamerica.png" alt="Selected Avatar Preview" width=150px height=150px class="img-fluid mb-3" />
            </div>
            <!-- Formulaire de modification d'informations personnelles -->
            <!-- Champ pour le nom d'utilisateur -->
            <div class="form-group">
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" required>
            </div>
            <!-- Champ pour l'email -->
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>" required>
            </div>
            <!-- Champ pour le mot de passe -->
            <div class="form-group">
                <label for="password">Nouveau mot de passe :</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <!-- Champ pour la confirmation du mot de passe -->
            <div class="form-group">
                <label for="confirm_password">Confirmez le mot de passe :</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <!-- Affichage d'un message d'erreur en cas de non-correspondance des mots de passe -->
            <?php if (isset($passwordError)): ?>
                <p style="color: red;"><?php echo $passwordError; ?></p>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
            </form>
        </div>
    </div>
</div>
<!-- Incluez les fichiers JavaScript Bootstrap ici -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // Fonction pour mettre à jour l'aperçu de l'avatar et la valeur du champ caché
    function updateAvatarPreview(avatarPath) {
        var preview = document.getElementById('avatarPreview');
        preview.src = avatarPath;
        document.getElementById('avatarPath').value = avatarPath;
    }
</script>
</body>
</html>
