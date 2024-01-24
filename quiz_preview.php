<?php
// Connexion à la base de données
require 'config.php'; // Assurez-vous que ce fichier contient les informations de connexion à votre base de données
require 'leaderboard.php'; // Incluez le fichier leaderboard.php ici

// Récupération des détails du quiz sélectionné
$quiz_id = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : 0;
$query = "SELECT title, description, image_path FROM quiz WHERE quiz_id = ?";
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
    <!-- Inclure le lien CDN de Bootstrap ici -->
    <link rel="stylesheet" href="quiz_preview1.css">
    <link href="https://fonts.googleapis.com/css?family=Bangers&display=swap" rel="stylesheet">

    <?php include("navbar.php"); ?>
</head>
<body>
<div class="container-fluid">
    <?php if ($quiz): ?>
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <!-- Contenu principal du Quiz -->
                <div class="quiz-header text-center">
                    <h1 class="quiz-title"><?php echo htmlspecialchars($quiz['title']); ?></h1>
                    <p class="quiz-description"><?php echo htmlspecialchars($quiz['description']); ?></p>
                    <img src="<?php echo $quiz['image_path'] ? $quiz['image_path'] : "public/default_background.png"; ?>" alt="Image du quiz" height="500px" width="500px" img-fluid">
                    <a href="start_quiz.php?quiz_id=<?php echo $quiz_id; ?>" class="btn btn-primary start-quiz-btn mt-2">Commencer le Quiz</a>
                </div>
            </div>

        </div>
    <?php else: ?>
        <p>Quiz non trouvé.</p>
    <?php endif; ?>
</div>

</body>
</html>

