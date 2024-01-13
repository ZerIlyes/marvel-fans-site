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
</head>
<body>
<h1>Liste des Quiz</h1>
<div>
    <?php if ($result->num_rows > 0): ?>
        <ul>
            <?php while ($quiz = $result->fetch_assoc()): ?>
                <li>
                    <a href="quiz_preview.php?quiz_id=<?php echo $quiz['quiz_id']; ?>">
                        <?php echo htmlspecialchars($quiz['title']); ?>
                    </a>
                    - <?php echo htmlspecialchars($quiz['description']); ?>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>Aucun quiz trouvé.</p>
    <?php endif; ?>
</div>
</body>
</html>