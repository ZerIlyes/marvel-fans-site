<?php
// Connexion à la base de données
require 'config.php'; // Assurez-vous que ce fichier contient les informations de connexion à votre base de données

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
</head>
<body>
<?php if ($quiz): ?>
    <h1><?php echo htmlspecialchars($quiz['title']); ?></h1>
    <p><?php echo htmlspecialchars($quiz['description']); ?></p>
    <a href="start_quiz.php?quiz_id=<?php echo $quiz_id; ?>">Commencer le Quiz</a>
<?php else: ?>
    <p>Quiz non trouvé.</p>
<?php endif; ?>
</body>
</html>