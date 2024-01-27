<?php
// Démarrer la session PHP pour gérer les connexions
session_start();

// Inclure le fichier de configuration de la base de données
require_once 'config.php'; // Assurez-vous d'avoir un fichier config.php qui contient les informations de connexion à la base de données

// Déclarer la variable $stmt en dehors de la condition if
$stmt = null;
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assigner les données POST à des variables
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Valider les données ici (vérifier si elles ne sont pas vides, etc.)

    // Préparer une déclaration de sélection
    $sql = "SELECT user_id, username, password_hash FROM users WHERE email = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Lier les variables à la déclaration préparée comme paramètres
        $stmt->bind_param("s", $param_email);

        // Définir le paramètre
        $param_email = $email;

        // Tenter d'exécuter la déclaration préparée
        if ($stmt->execute()) {
            // Stocker le résultat
            $stmt->store_result();

            // Vérifier si l'email existe, si oui, vérifier le mot de passe
            if ($stmt->num_rows == 1) {
                // Lier les variables de résultat
                $stmt->bind_result($user_id, $username, $hashed_password);
                if ($stmt->fetch()) {
                    if (password_verify($password, $hashed_password)) {
                        // Le mot de passe est correct, donc démarrer une nouvelle session
                        //session_start();

                        // Stocker les données dans les variables de session
                        $_SESSION["loggedin"] = true;
                        $_SESSION["user_id"] = $user_id;
                        $_SESSION["username"] = $username;

                        // Rediriger l'utilisateur vers la page d'accueil
                        header("location: index.php");
                        exit(); // Assurez-vous que rien n'est exécuté après la redirection
                    } else {
                        // Afficher une erreur si le mot de passe n'est pas valide
                        $login_err = "Le mot de passe que vous avez entré n'était pas valide.";
                    }
                }
            } else {
                // Afficher une erreur si l'email n'existe pas
                $login_err = "Aucun compte trouvé avec cet email.";
            }
        } else {
            echo "Oops! Quelque chose s'est mal passé. Veuillez réessayer plus tard.";
        }

        // Fermer la déclaration
        $stmt->close();
    }

    // Fermer la connexion
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Site Fans Marvel</title>
    <!-- Insérez vos liens CSS ici -->
</head>
<body>
<div class="login-form">
    <h2>Connexion</h2>
    <form action="login.php" method="post">
        <!-- Champs pour l'email et le mot de passe -->
        <label for="email">Email :</label>
        <input type="text" name="email" id="email" required>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required>
        <input type="submit" value="Se connecter">
    </form>
</div>
</body>
</html>

