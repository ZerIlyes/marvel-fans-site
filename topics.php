<?php
// Assurez-vous de démarrer la session et de vous connecter à la base de données
session_start();
require_once 'config.php'; // Assurez-vous que ce fichier contient les informations de connexion à votre base de données

// Récupération des sujets depuis la base de données
$sql = "SELECT t.topic_id, t.title, t.created_at, u.username FROM topics t JOIN users u ON t.user_id = u.user_id ORDER BY t.created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Marvel - Sujets</title>
    <?php include("navbar.php"); ?> <!-- Incluez votre bar de navigation ici -->
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Sujets de discussion</h1>
        <?php if ($result && $result->num_rows > 0): ?>
            <div class="list-group">
                <?php while($row = $result->fetch_assoc()): ?>
                    <a href="topic.php?id=<?php echo $row['topic_id']; ?>" class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1"><?php echo htmlspecialchars($row['title']); ?></h5>
                            <small>Commencé par <?php echo htmlspecialchars($row['username']); ?> le <?php echo $row['created_at']; ?></small>
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>Aucun sujet à afficher.</p>
        <?php endif; ?>
        
        <!-- Le lien vers la page de création de sujet -->
        <a href="create_topic.php" class="btn btn-primary mt-4">Créer un nouveau sujet</a>
    </div>
</body>
</html>
