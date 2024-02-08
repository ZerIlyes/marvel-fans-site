<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fin du Quiz</title>
    <link rel="stylesheet" href="public/css/quiz_end.css">
</head>
<body>
<div class="quiz-end-background">
    <div class="quiz-end-container">
        <h1>Fin du Quiz</h1>
        <p class="final-score">Votre score final est de <?php echo htmlspecialchars($finalScore); ?> points.</p>
        <div class="leaderboard-container">
            <h2>Leaderboard</h2>
            <ol>
                <?php foreach ($leaderboardData as $row): ?>
                    <li>
                        <img src="<?php echo htmlspecialchars($row['avatar_path'] ?: 'public/images/default_avatar.png'); ?>" alt="Avatar" width=64px class="avatar">
                        <?php echo htmlspecialchars($row['username']) . " - " . $row['score']; ?>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
        <a href="index.php?page=quiz_list" class="back-to-list">Retour à la liste des quiz</a>
    </div>
</div>
</body>
</html>
