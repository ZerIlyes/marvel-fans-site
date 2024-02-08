<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Quiz</title>
    <link rel="stylesheet" href="public/css/quizz_list.css">
    <link rel="stylesheet" href="public/css/redirection.css">

    <link href="https://fonts.googleapis.com/css2?family=Bangers&display=swap" rel="stylesheet">
</head>
<body>
<div class="header">
    <h1 class="title">Liste des Quiz</h1>
</div>
<?php include 'public/redirection.php'; ?>
<div class="quiz-container">
    <?php if (!empty($quizzes)): ?>
        <?php foreach ($quizzes as $quiz): ?>
            <a href="index.php?page=quiz_preview&quiz_id=<?php echo $quiz['quiz_id']; ?>" class="quiz-card-link">
            <div class="quiz-card">
                    <img src="<?php echo htmlspecialchars($quiz['image_path']); ?>" alt="Image du quiz">
                    <div class="content">
                        <h2 class="title"><?php echo htmlspecialchars($quiz['title']); ?></h2>
                        <p class="description"><?php echo htmlspecialchars($quiz['description']); ?></p>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucun quiz trouvé.</p>
    <?php endif; ?>
</div>
</body>
</html>
