<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Prévisualisation du Quiz</title>
    <link rel="stylesheet" href="public/css/quiz_preview1.css">
    <link href="https://fonts.googleapis.com/css?family=Bangers&display=swap" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <?php if ($quiz): ?>
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="quiz-header text-center">
                    <h1 class="quiz-title"><?php echo htmlspecialchars($quiz['title']); ?></h1>
                    <p class="quiz-description"><?php echo htmlspecialchars($quiz['description']); ?></p>
                    <img src="<?php echo $quiz['image_path'] ? $quiz['image_path'] : "public/default_background.png"; ?>" alt="Image du quiz" class="img-fluid">
                    <!-- Modifiez le href pour utiliser un paramètre de requête GET -->
                    <a href="index.php?page=start_quiz&quiz_id=<?php echo $quiz_id; ?>" class="btn btn-primary start-quiz-btn mt-2">Commencer le Quiz</a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <p>Quiz non trouvé.</p>
    <?php endif; ?>
</div>
</body>
</html>
