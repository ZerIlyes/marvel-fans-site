<?php

require_once 'navbar.php';
require_once 'config.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit;
}

// Récupérer les informations actuelles de l'utilisateur depuis la base de données (ex. à partir de la table users)
try{

    $stmt = $conn->prepare("SELECT username, email, avatar_path FROM users WHERE user_id=?");
    $stmt->bind_param("i", $_SESSION["user_id"]);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentUsername = $row["username"];
        $currentEmail = $row["email"];
        $currentAvatar = $row["avatar_path"];
    } else {
        echo "Erreur : Aucun utilisateur trouvé.";
    }
    // ...
// Traitement du formulaire de mise à jour
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupérer les nouvelles données depuis le formulaire
        $newUsername = $_POST["new_username"];
        $newEmail = $_POST["new_email"];
        $newPassword = $_POST["new_password"];
        $newAvatar = $_POST["new_avatar"];

        // Vérifier si le nouveau nom d'utilisateur existe déjà
        if (!empty($newUsername)) {
            $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ? AND user_id != ?");
            $stmt->bind_param("si", $newUsername, $_SESSION["user_id"]);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                echo "Erreur : Le nom d'utilisateur '$newUsername' est déjà utilisé. Veuillez en choisir un autre.";
            }
        }

        // Vérifier si la nouvelle adresse e-mail existe déjà
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ? AND user_id != ?");
        $stmt->bind_param("si", $newEmail, $_SESSION["user_id"]);
        $stmt->execute();
        $stmt->store_result();
        $existingEmail = $stmt->num_rows > 0;

        // Vérifier si l'adresse e-mail est vide
        // Vérifier si le nom d'utilisateur est vide
        if (empty($newUsername)) {
            echo "Veuillez fournir un nom d'utilisateur.";
        } elseif (!preg_match('/^[a-zA-Z]+$/', $newUsername)) {
            echo "Nom d'utilisateur invalide. Utilisez uniquement des lettres.";
        } elseif (empty($newEmail)) {
            echo "Veuillez fournir une adresse e-mail.";
        } elseif (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
            echo "Veuillez fournir une adresse e-mail valide.";
        } elseif ($existingEmail) {
            echo "Erreur : L'adresse e-mail '$newEmail' est déjà associée à un autre compte. Veuillez en choisir une autre.";
        } else {
            // Préparer la requête SQL de mise à jour
            $updateStmt = $conn->prepare("UPDATE users SET username = ?, email = ?, avatar_path = ? " .
                (!empty($newPassword) ? ", password_hash = ?" : "") .
                " WHERE user_id = ?");

            // Liaison des paramètres communs
            if (!empty($newPassword)) {
                $passhashed = password_hash($newPassword, PASSWORD_DEFAULT);
                $updateStmt->bind_param("ssssi", $newUsername, $newEmail, $newAvatar, $passhashed, $_SESSION["user_id"]);
            } else {
                $updateStmt->bind_param("sssi", $newUsername, $newEmail, $newAvatar, $_SESSION["user_id"]);
            }

            // ...

// Exécution de la mise à jour
            if ($updateStmt->execute()) {
                $updatedFields = [];

                // Vérifier les champs mis à jour
                if (!empty($newUsername) && $newUsername !== $currentUsername) {
                    $updatedFields[] = "Nom d'utilisateur";
                }

                if (!empty($newEmail) && $newEmail !== $currentEmail) {
                    $updatedFields[] = "Email";
                }

                if (!empty($newAvatar) && $newAvatar !== $currentAvatar) {
                    $updatedFields[] = "Avatar";
                }

                if (!empty($newPassword)) {
                    $updatedFields[] = "Mot de passe";
                }

                // Afficher le message personnalisé
                if (!empty($updatedFields)) {
                    $message = "Mise à jour réussie pour : " . implode(", ", $updatedFields);
                    echo $message;
                } else {
                    echo "Aucune mise à jour effectuée. Les valeurs sont déjà à jour.";
                }

            } else {
                echo "Erreur lors de la mise à jour : " . $updateStmt->errorInfo()[2];
            }

// ...



        }
    }
}catch (mysqli_sql_exception $e) {
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
            background: url('public/captain.png') no-repeat scroll right center transparent;
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
    <h2>Nom d'utilisateur actuel : <?php echo isset($newUsername) ? htmlspecialchars($newUsername) : htmlspecialchars($_SESSION["username"]); ?></h2>
    <img src="<?php echo htmlspecialchars($currentAvatar); ?>" alt="Avatar de l'utilisateur">

</div>


<!-- Afficher le formulaire de mise à jour -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <label for="new_username">Nouveau Nom d'utilisateur :</label>
    <input type="text" id="new_username" name="new_username" value="<?php echo isset($newUsername) ? htmlspecialchars($newUsername) : htmlspecialchars($currentUsername); ?>">

    <label for="new_email">Nouvel Email :</label>
    <input type="email" id="new_email" name="new_email" value="<?php echo isset($newEmail) ? htmlspecialchars($newEmail) : htmlspecialchars($currentEmail); ?>">

    <label for="new_password">Nouveau Mot de passe :</label>
    <input type="password" id="new_password" name="new_password">

    <label for="new_avatar">Nouvel Avatar :</label>
    <select name="new_avatar" id="new_avatar" class="form-control" required>
        <option value="public/captain.png" class="captain" <?php echo ($currentAvatar == 'public/captain.png') ? 'selected' : ''; ?>>
            Captain America <img src="public/captain.png" alt="Captain America" style="width: 20px; height: 20px;">
        </option>
        <option value="public/ironman.png" class="ironman" <?php echo ($currentAvatar == 'public/ironman.png') ? 'selected' : ''; ?>>
            Iron Man <img src="public/ironman.png" alt="Iron Man" style="width: 20px; height: 20px;">
        </option>
        <option value="public/spiderman.png" class="spiderman" <?php echo ($currentAvatar == 'public/spiderman.png') ? 'selected' : ''; ?>>
            Spider-Man <img src="public/spiderman.png" alt="Spider-Man" style="width: 20px; height: 20px;">
        </option>
        <option value="public/the-flash.png" class="the-flash" <?php echo ($currentAvatar == 'public/the-flash.png') ? 'selected' : ''; ?>>
            The Flash <img src="public/the-flash.png" alt="The Flash" style="width: 20px; height: 20px;">
        </option>
        <!-- Ajoutez les autres options d'avatar ici -->
    </select>

    <input type="submit" value="Mettre à jour">
</form>

<!-- Liens vers les scripts JavaScript, etc. -->
</body>
</html>
