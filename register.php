<?php
// register.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "marvel_fans";

    // Créer une connexion
    $conn = new mysqli($servername, $username, $password, $database);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion a échoué : " . $conn->connect_error);
    }

    // Récupérer les données du formulaire
    $user_username = $_POST['username'];
    $user_email = $_POST['email'];
    $user_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $user_avatar = $_POST['avatar']; // Récupérer le chemin de l'avatar sélectionné

    // Préparer la requête SQL pour insérer les données de l'utilisateur y compris l'avatar
    $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash, avatar_path) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $user_username, $user_email, $user_password, $user_avatar);

    // Exécuter la requête
    if ($stmt->execute()) {
        echo "Nouvel utilisateur enregistré avec succès.";
        // Rediriger l'utilisateur vers la page de connexion ou de profil après l'inscription
        header("Location: login.php");
        exit();
    } else {
        echo "Erreur : " . $stmt->error;
    }

    // Fermer la déclaration et la connexion
    $stmt->close();
    $conn->close();
}
?>

