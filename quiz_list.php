<?php
// Connexion à la base de données
require 'config.php'; // Assurez-vous que ce fichier contient les informations de connexion à votre base de données

// Récupération de tous les quiz
$query = "SELECT quiz_id, title, description FROM quiz";
$result = $conn->query($query);
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Quiz</title>
    <link rel="stylesheet" href="public/style.css"> <!-- Assurez-vous que le chemin est correct -->
</head>
<body>
<?php include("navbar.php"); ?>
<div class="header">
    <h1 class="title">Liste des Quiz</h1>
    <select class="sort-dropdown">
        <option value="date">Date de publication</option>
        <!-- Ajoutez d'autres options de tri si nécessaire -->
    </select>
</div>


<div class="quiz-container">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($quiz = $result->fetch_assoc()): ?>
            <!-- Chaque carte est enveloppée dans un élément 'a' pour la rendre cliquable -->
            <a href="quiz_preview.php?quiz_id=<?php echo $quiz['quiz_id']; ?>" class="quiz-card-link">
                <div class="quiz-card">
                    <img src="public/<?php
                    if ($quiz['title'] === 'Le Monde de Wanda Maximoff') {
                        echo 'wanda';
                    } elseif ($quiz['title'] === 'Les Mystères de Doctor Strange') {
                        echo 'strange';
                    } // Ajoutez d'autres elseif pour d'autres quiz
                    ?>.png" alt="Image du quiz">
                    <div class="content">
                        <h2 class="title"><?php echo htmlspecialchars($quiz['title']); ?></h2>
                        <p class="description"><?php echo htmlspecialchars($quiz['description']); ?></p>
                    </div>
                </div>
            </a>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Aucun quiz trouvé.</p>
    <?php endif; ?>
</div>

</body>
</html>
