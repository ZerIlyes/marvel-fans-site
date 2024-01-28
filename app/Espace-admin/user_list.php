<?php
require_once 'admin.php';
require_once '../config.php';

// Vérifiez la connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Récupération de la liste des utilisateurs depuis la base de données (en excluant l'admin)
$sql = "SELECT user_id, username, email FROM users WHERE is_admin = 0";
$result = $conn->query($sql);

// Vérifiez si des utilisateurs ont été trouvés
if ($result->num_rows > 0) {
    $users = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $users = array(); // Aucun utilisateur trouvé
}

// Fermez la connexion à la base de données
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Utilisateurs</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .delete-btn, .update-btn {
            cursor: pointer;
            color: red; /* Vous pouvez changer la couleur selon vos préférences */
        }
    </style>
    <script>
        function deleteUser(userId) {
            var confirmation = confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?");
            if (confirmation) {
                // Suppression côté client (côté navigateur)
                var row = document.getElementById("userRow" + userId);
                row.style.display = "none";

                // Suppression côté serveur (envoi de la demande à delete_user.php avec l'ID de l'utilisateur)
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "delete_user.php?user_id=" + userId, true);
                xhr.send();
            }
        }

        function updateUser(userId) {
            // Redirection vers la page de mise à jour de l'utilisateur avec l'ID en paramètre
            window.location.href = "update_user.php?user_id=" + userId;
        }
    </script>
</head>
<body>
<h2>Liste des Utilisateurs</h2>
<table>
    <thead>
    <tr>
        <th>ID Utilisateur</th>
        <th>Nom d'utilisateur</th>
        <th>Email</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user): ?>
        <tr id="userRow<?php echo $user['user_id']; ?>">
            <td><?php echo $user['user_id']; ?></td>
            <td><?php echo $user['username']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td>
                <span class="delete-btn" onclick="deleteUser(<?php echo $user['user_id']; ?>)">❌</span>
                - <a href="user_topics.php?user_id=<?php echo $user['user_id']; ?>">Voir les sujets</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<!-- Ajoutez ce lien où vous le souhaitez dans votre page user_list.php -->
<a href="add_user.php">Ajouter un nouvel utilisateur</a>

</body>
</html>