<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Prévisualisation du Quiz</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Bangers&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="public/css/quiz_preview1.css">
</head>
<body>
<div class="blur-background"></div>
<div class="container d-flex justify-content-center">
    <?php if ($quiz): ?>
        <div class="card quiz-card">
            <img class="card-img-top" src="<?php echo $quiz['image_path'] ? $quiz['image_path'] : "public/default_background.png"; ?>" alt="Image du quiz">
            <div class="card-body text-center">
                <h1 class="quiz-title"><?php echo htmlspecialchars($quiz['title']); ?></h1>
                <p class="quiz-description"><?php echo htmlspecialchars($quiz['description']); ?></p>
                <a href="index.php?page=start_quiz&quiz_id=<?php echo $quiz_id; ?>" class="btn btn-primary start-quiz-btn">Commencer le Quiz</a>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center" role="alert">
            Quiz non trouvé.
        </div>
    <?php endif; ?>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
