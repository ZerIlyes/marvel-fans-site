<?php
// Assurez-vous de démarrer la session et de vous connecter à la base de données
session_start();
require_once 'config.php'; // Assurez-vous que ce fichier contient les informations de connexion à votre base de données

// Rechercher un sujet si le formulaire de recherche est soumis
$searchQuery = '';
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['search'])) {
    $searchQuery = $_GET['search'];
}

// Préparez la requête SQL en fonction de la recherche
$sql = "SELECT t.topic_id, t.title, t.created_at, u.username, (SELECT COUNT(*) FROM posts WHERE topic_id = t.topic_id) as post_count, 
        (SELECT MAX(created_at) FROM posts WHERE topic_id = t.topic_id) as last_post_date 
        FROM topics t 
        JOIN users u ON t.user_id = u.user_id 
        WHERE t.title LIKE ? 
        ORDER BY t.created_at DESC";

$stmt = $conn->prepare($sql);
$likeSearchQuery = '%' . $searchQuery . '%';
$stmt->bind_param('s', $likeSearchQuery);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Marvel - Sujets</title>
    <!-- Liens vers les fichiers CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Liens vers vos fichiers CSS personnalisés -->
    <link rel="stylesheet" href="topics.css">
    <!-- Optionnel : Liens vers les icônes Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- Lien vers Google Fonts pour les polices -->
</head>
<body>
<?php include("navbar.php"); ?>
<div class="container mt-5">
    <h1 class="forum-title">Forum Comics</h1>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <!-- Bouton Nouveau sujet à gauche -->
        <a href="create_topic.php" class="btn btn-primary">Nouveau sujet</a>

        <!-- Barre de recherche au milieu -->
        <form action="topics.php" method="get" class="flex-grow-1 mx-3">
            <div class="input-group">
                <input type="text" name="search" placeholder="Rechercher dans le forum" class="form-control" value="<?php echo htmlspecialchars($searchQuery); ?>">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-outline-secondary"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
    </div>
    <!-- Ici le reste de votre contenu... -->
</div>



    <div class="topics-list">
        <?php if ($result && $result->num_rows > 0): ?>
            <div class="topic-header">
                <div class="topic-section">Sujet</div>
                <div class="topic-section">Auteur</div>
                <div class="topic-section">Nb</div>
                <div class="topic-section">Dernier Msg</div>
            </div>
            <?php while($row = $result->fetch_assoc()): ?>
                <?php
                // Vérifiez si le titre du sujet contient les caractères de recherche
                if (strpos($row['title'], $searchQuery) !== false): ?>
                    <div class="topic-item">
                        <a href="topic.php?id=<?php echo $row['topic_id']; ?>" class="topic-link">
                            <div class="topic-section topic-title"><?php echo htmlspecialchars($row['title']); ?></div>
                            <div class="topic-section topic-author"><?php echo htmlspecialchars($row['username']); ?></div>
                            <div class="topic-section topic-count"><?php echo $row['post_count']; ?></div>
                            <div class="topic-section topic-last">
                                <?php
                                // Formatage de la date en fonction d'aujourd'hui ou hier
                                $postDate = new DateTime($row['last_post_date']);
                                $currentDate = new DateTime();
                                $yesterday = new DateTime('-1 day');

                                if ($postDate->format('Y-m-d') === $currentDate->format('Y-m-d')) {
                                    // Aujourd'hui, afficher l'heure
                                    echo $postDate->format('H:i:s');
                                } elseif ($postDate < $yesterday) {
                                    // Plus d'un jour, afficher seulement la date
                                    echo $postDate->format('d/m/Y');
                                } else {
                                    // Sinon, afficher l'heure
                                    echo $postDate->format('H:i:s');
                                }
                                ?>
                            </div>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Aucun sujet trouvé.</p>
        <?php endif; ?>
    </div>

    <!-- Liens vers les scripts JavaScript de Bootstrap (jQuery et Popper.js) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <!-- Lien vers le fichier JavaScript de Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</div>
</body>
</html>




