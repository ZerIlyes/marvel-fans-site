<?php
// Connexion à la base de données
require 'config.php'; // Assurez-vous que ce fichier contient les informations de connexion à votre base de données

// Récupération de tous les quiz avec l'image
$query = "SELECT quiz_id, title, description, image_path FROM quiz";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Quiz</title>
    <link rel="stylesheet" href="quizz_list.css"> <!-- Adjust the path as needed -->
    <link href="https://fonts.googleapis.com/css2?family=Bangers&display=swap" rel="stylesheet">
</head>
<body>
<div class="header">
    <h1 class="title">Liste des Quiz</h1>
</div>

<div class="quiz-container">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($quiz = $result->fetch_assoc()): ?>
            <a href="quiz_preview.php?quiz_id=<?php echo $quiz['quiz_id']; ?>" class="quiz-card-link">
                <div class="quiz-card">
                    <img src="<?php echo htmlspecialchars($quiz['image_path']); ?>" alt="Image du quiz">
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
