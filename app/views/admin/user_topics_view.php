<!DOCTYPE html>
<html lang="fr">
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="public/js/js.js"></script>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/redirection.css">
    <?php include 'public/redirection.php'; ?>
</head>
<body>
<div class="container">
    <h2>Les sujets créés par <?= htmlspecialchars($user['username']) ?></h2>

    <?php if (empty($userTopics)): ?>
        <p>Aucun sujet créé par cet utilisateur.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($userTopics as $topic): ?>
                <li id="topicRow<?= htmlspecialchars($topic['topic_id']) ?>">
                    <a href="topic.php?id=<?= htmlspecialchars($topic['topic_id']) ?>">
                        <?= htmlspecialchars($topic['title']) ?>
                    </a>
                    - <?= htmlspecialchars($topic['created_at']) ?>
                    <button type="button" class="btn btn-danger" onclick="deleteTopic(<?= htmlspecialchars($topic['topic_id']) ?>)">Supprimer</button>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>


</body>
</html>
