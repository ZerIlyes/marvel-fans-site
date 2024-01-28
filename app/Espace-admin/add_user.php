<?php
require_once 'admin.php';
require_once '../config.php';

// Traitement du formulaire d'ajout d'utilisateur
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUsername = $_POST["new_username"];
    $newEmail = $_POST["new_email"];
    $newPassword = $_POST["new_password"];
    $newAvatar = $_POST["new_avatar"];

    // Vérifier si le nouveau nom d'utilisateur existe déjà
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
    $stmt->bind_param("s", $newUsername);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Erreur : Le nom d'utilisateur '$newUsername' est déjà utilisé. Veuillez en choisir un autre.";
    } else {
        // Préparer la requête SQL d'insertion
        $insertStmt = $conn->prepare("INSERT INTO users (username, email, password_hash, is_admin, avatar_path) VALUES (?, ?, ?, 0, ?)");

        // Générer le hash du mot de passe
        $passhashed = password_hash($newPassword, PASSWORD_DEFAULT);

        // Liaison des paramètres
        $insertStmt->bind_param("ssss", $newUsername, $newEmail, $passhashed, $newAvatar);

        // Exécution de l'insertion
        if ($insertStmt->execute()) {
            echo "Nouvel utilisateur ajouté avec succès.";
        } else {
            echo "Erreur lors de l'ajout de l'utilisateur : " . $insertStmt->errorInfo()[2];
        }

        $insertStmt->close();
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Mettez ici les balises meta, les liens vers les fichiers CSS, etc. -->
    <title>Ajouter un Utilisateur</title>
    <style>
        /* Ajoutez votre style CSS ici */
    </style>
</head>
<body>
<!-- Afficher le formulaire d'ajout d'utilisateur -->
<h2>Ajouter un Utilisateur</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <label for="new_username">Nom d'utilisateur :</label>
    <input type="text" id="new_username" name="new_username" required>

    <label for="new_email">Email :</label>
    <input type="email" id="new_email" name="new_email" required>

    <label for="new_password">Mot de passe :</label>
    <input type="password" id="new_password" name="new_password" required>

    <label for="new_avatar">Avatar :</label>
    <select name="new_avatar" id="new_avatar" class="form-control" required>
        <option value="../public/captain.png" class="captain">Captain America</option>
        <option value="../public/ironman.png" class="ironman">Iron Man</option>
        <option value="../public/spiderman.png" class="spiderman">Spider-Man</option>
        <option value="../public/the-flash.png" class="the-flash">The Flash</option>
        <!-- Ajoutez les autres options d'avatar ici -->
    </select>

    <input type="submit" value="Ajouter Utilisateur">
</form>

<!-- Liens vers les scripts JavaScript, etc. -->
</body>
</html>
