<?php
// Connexion à la base de données
require 'config.php'; // Assurez-vous que ce fichier contient les informations de connexion à votre base de données
require 'leaderboard.php'; // Incluez le fichier leaderboard.php ici

// Récupération des détails du quiz sélectionné
$quiz_id = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : 0;
$query = "SELECT title, description FROM quiz WHERE quiz_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $quiz_id);
$stmt->execute();
$result = $stmt->get_result();
$quiz = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Prévisualisation du Quiz</title>
    <link rel="stylesheet" href="public/quiz_preview.css">
    <?php include("navbar.php"); ?> <!-- Incluez votre bar de navigation ici -->
</head>
<body>
<?php if ($quiz): ?>
    <div class="quiz-container">
        <div class="quiz-header">
            <h1 class="quiz-title"><?php echo htmlspecialchars($quiz['title']); ?></h1>
            <p class="quiz-description"><?php echo htmlspecialchars($quiz['description']); ?></p>
        </div>
        <img src="public/Wanda_3.png" alt="Image du quiz" class="quiz-image"> <!-- Remplacez 'public/votre-image.jpg' par le chemin réel vers votre image -->
        <a href="start_quiz.php?quiz_id=<?php echo $quiz_id; ?>" class="start-quiz-btn">Commencer le Quiz</a>
    </div>

    <!-- Afficher le leaderboard ici -->
    <?php display_leaderboard($conn, $quiz_id); ?>
<?php else: ?>
    <p>Quiz non trouvé.</p>
<?php endif; ?>
</body>
</html>