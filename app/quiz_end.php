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
</head>
<body>
<h1>Fin du Quiz</h1>
<p>Votre score final est de <?php echo htmlspecialchars($final_score); ?> points.</p>
<?php display_leaderboard($conn, $quiz_id); ?>

<a href="quiz_list.php">Retour à la liste des quiz</a>
</body>
</html>