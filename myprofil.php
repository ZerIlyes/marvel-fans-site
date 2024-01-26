<?php
require_once 'navbar.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit;
}

// Récupérer les informations actuelles de l'utilisateur depuis la base de données (ex. à partir de la table users)
$host = "localhost";
$dbname = "marvel_fans";
$user = "root";
$password = "";

try{
    $pdo = new PDO("mysql:host=$host;dbname=$dbname",$user,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("SELECT username,email,avatar_path FROM users WHERE user_id=:user_id");
    $stmt->bindParam(":user_id", $_SESSION["user_id"]); // Assurez-vous d'ajuster le nom de la colonne de l'identifiant
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    // si des résultats ont été obtenus
    if ($result) {
        $currentUsername = $result["username"];
        $currentEmail = $result["email"];
        $currentAvatar = $result["avatar_path"];
    } else {

        echo "Erreur : Aucun utilisateur trouvé.";
    }
    // Traitement du formulaire de mise à jour
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupérer les nouvelles données depuis le formulaire
        $newUsername = $_POST["new_username"];
        $newEmail = $_POST["new_email"];
        $newPassword = $_POST["new_password"];
        $newAvatar = $_POST["new_avatar"];

        // Vérifier si l'adresse e-mail est vide
        // Vérifier si le nom d'utilisateur est vide
        if (empty($newUsername)) {
            echo "Veuillez fournir un nom d'utilisateur.";
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $newUsername)) {
            echo "Nom d'utilisateur invalide. Utilisez uniquement des lettres, des chiffres et des underscores.";
        } elseif (empty($newEmail)) {
            echo "Veuillez fournir une adresse e-mail.";
        } elseif (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
            echo "Veuillez fournir une adresse e-mail valide.";
        } elseif (empty($newPassword)) {
            echo "Veuillez fournir un mot de passe.";
        } else {
            // Préparer la requête SQL de mise à jour
            $updateStmt = $pdo->prepare("UPDATE users SET username = :new_username, email = :new_email, password_hash = :new_password, avatar_path = :new_avatar WHERE user_id = :user_id");
            $passhashed = password_hash($newPassword, PASSWORD_DEFAULT);
            // Liaison des paramètres
            $updateStmt->bindParam(":new_username", $newUsername);
            $updateStmt->bindParam(":new_email", $newEmail);
            $updateStmt->bindParam(":new_password", $passhashed); // Notez que vous devrez probablement gérer le mot de passe de manière sécurisée
            $updateStmt->bindParam(":new_avatar", $newAvatar);

            // Assurez-vous de définir la bonne valeur pour :user_id
            $updateStmt->bindParam(":user_id", $_SESSION["user_id"]);

            // Exécution de la mise à jour
            if ($updateStmt->execute()) {
                echo "Mise à jour réussie !";
            } else {
                echo "Erreur lors de la mise à jour : " . $updateStmt->errorInfo()[2];
            }
        }
    }


}catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Mettez ici les balises meta, les liens vers les fichiers CSS, etc. -->
    <title>Mon Profil</title>
    <style>
        .profile-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            margin: auto;
        }
        h2 {
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background: url('public/images/captain.png') no-repeat scroll right center transparent;
            background-size: 20px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        img {
            max-width: 100%;
            height: auto;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .avatar-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .avatar-options label {
            flex-grow: 1;
            margin-right: 10px;
        }
    </style>

</head>
<body>

<div class="profile-container">
    <!-- Afficher les informations actuelles de l'utilisateur -->
    <h2>Nom d'utilisateur actuel : <?php echo htmlspecialchars($_SESSION["username"]); ?></h2>
    <img src="<?php echo htmlspecialchars($currentAvatar); ?>" alt="Avatar de l'utilisateur">

</div>


<!-- Afficher le formulaire de mise à jour -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <label for="new_username">Nouveau Nom d'utilisateur :</label>
    <input type="text" id="new_username" name="new_username" value="<?php echo htmlspecialchars($currentUsername); ?>">

    <label for="new_email">Nouvel Email :</label>
    <input type="email" id="new_email" name="new_email" value="<?php echo htmlspecialchars($currentEmail); ?>">

    <label for="new_password">Nouveau Mot de passe :</label>
    <input type="password" id="new_password" name="new_password">

    <label for="new_avatar">Nouvel Avatar :</label>
    <select name="new_avatar" id="new_avatar" class="form-control" required>
        <option value="public/captain.png" <?php echo ($currentAvatar == 'public/captain.png') ? 'selected' : ''; ?>>
            Captain America <img src="public/images/captain.png" alt="Captain America">
        </option>
        <option value="public/ironman.png" <?php echo ($currentAvatar == 'public/ironman.png') ? 'selected' : ''; ?>>
            Iron Man <img src="public/images/ironman.png" alt="Iron Man">
        </option>
        <option value="public/spiderman.png" <?php echo ($currentAvatar == 'public/spiderman.png') ? 'selected' : ''; ?>>
            Spider-Man <img src="public/images/spiderman.png" alt="Spider-Man">
        </option>
        <option value="public/the-flash.png" <?php echo ($currentAvatar == 'public/the-flash.png') ? 'selected' : ''; ?>>
            The Flash <img src="public/images/the-flash.png" alt="The Flash">
        </option>
        <option value="public/selim.png" <?php echo ($currentAvatar == 'public/selim.png') ? 'selected' : ''; ?>>
            The Selim du 95 <img src="public/selim.png" alt="The Selim du 95">
        </option>
        <!-- Ajoutez les autres options d'avatar ici -->
    </select>



    <input type="submit" value="Mettre à jour">
</form>

<!-- Liens vers les scripts JavaScript, etc. -->
</body>
</html>