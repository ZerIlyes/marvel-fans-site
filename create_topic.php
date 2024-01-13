<?php
// Assurez-vous de démarrer la session et de vous connecter à la base de données
session_start();
require_once 'config.php';
// Vérifiez si l'utilisateur est connecté sinon redirigez vers la page de connexion
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Traitement du formulaire à la soumission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer le titre du sujet depuis le formulaire
    $title = trim($_POST['title']);
    $user_id = $_SESSION["user_id"]; // L'ID de l'utilisateur connecté

    // Vérifier si le titre n'est pas vide
    if (!empty($title)) {
        // Préparer la requête d'insertion
        $stmt = $conn->prepare("INSERT INTO topics (title, user_id) VALUES (?, ?)");
        $stmt->bind_param("si", $title, $user_id);

        // Exécuter la requête
        if ($stmt->execute()) {
            // Redirection vers la liste des sujets
            header("location: topics.php");
            exit();
        } else {
            echo "Erreur : " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Veuillez entrer un titre pour le sujet.";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un sujet - Forum Marvel</title>
    <!-- Liens vers les fichiers CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Liens vers vos fichiers CSS personnalisés -->
    <link rel="stylesheet" href="votre-style.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Créer un nouveau sujet</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="title">Titre du sujet :</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Créer</button>
        </form>
    </div>

    <!-- Liens vers les scripts JavaScript de Bootstrap (jQuery et Popper.js) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <!-- Lien vers le fichier JavaScript de Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

