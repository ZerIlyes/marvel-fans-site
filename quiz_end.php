<?php
session_start();

require 'config.php';
require 'leaderboard.php';

// Vérifiez si le quiz est terminé
if (!isset($_SESSION['score']) || !isset($_SESSION['quiz_id'])) {
    header('Location: quiz_list.php'); // Redirigez vers la liste des quiz si aucun quiz n'est en cours
    exit;
}

// Affichez le score final
$final_score = $_SESSION['score'];
$quiz_id = $_SESSION['quiz_id'];

// Enregistrez le score final dans la base de données si nécessaire
// ...

// Détruisez les données du quiz dans la session
unset($_SESSION['quiz_id']);
unset($_SESSION['current_question_index']);
unset($_SESSION['score']);
unset($_SESSION['questions']);

// Vous pouvez également terminer complètement la session si vous le souhaitez
// session_destroy();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fin du Quiz</title>
    <link rel="stylesheet" href="quiz_end.css">
</head>
<body>
<div class="quiz-end-background">
    <div class="quiz-end-container">
    <h1>Fin du Quiz</h1>
    <p class="final-score">Votre score final est de <?php echo htmlspecialchars($final_score); ?> points.</p>
    <div class="leaderboard-container">
        <?php display_leaderboard($conn, $quiz_id); ?>
    </div>
    <a href="quiz_list.php" class="back-to-list">Retour à la liste des quiz</a>
</div>
</body>
</html>
