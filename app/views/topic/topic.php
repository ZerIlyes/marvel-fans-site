<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once 'config.php';

$topic_id = $_GET['id'];

$sql = "SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.user_id WHERE topic_id = ? ORDER BY created_at DESC";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $param_topic_id);
    $param_topic_id = $topic_id;

    if ($stmt->execute()) {
        $result = $stmt->get_result();
    } else {
        echo "Erreur lors de l'exécution de la requête : " . $conn->error;
    }
    $stmt->close();
} else {
    echo "Erreur lors de la préparation de la requête : " . $conn->error;
}

// Reste du code HTML et PHP...
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Marvel - Discussion</title>
    <!-- Liens vers les fichiers CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Liens vers vos fichiers CSS personnalisés -->
    <link rel="stylesheet" href="votre-style.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Messages</h1>
        <div class="forum-messages">
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="message mb-4">
                        <p><?php echo htmlspecialchars($row['content']); ?></p>
                        <p class="text-muted">Écrit par : <?php echo htmlspecialchars($row['username']); ?></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="alert alert-info">Aucun message dans ce sujet pour l'instant.</p>
            <?php endif; ?>
        </div>

        <h2 class="mt-5">Répondre</h2>
        <div class="new-message-form">
            <form action="../../../post_message.php" method="post">
                <div class="form-group">
                    <textarea name="message_content" class="form-control" rows="4" required></textarea>
                </div>
                <input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
        </div>
    </div>

    <!-- Liens vers les scripts JavaScript de Bootstrap (jQuery et Popper.js) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <!-- Lien vers le fichier JavaScript de Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

