<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Forum Marvel - Discussion</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/topic.css">
</head>
<body>
<div class="container mt-2">
    <h1 class="mb-4 text-center">Messages</h1>
    <div class="forum-messages message-container">
        <?php if (!empty($posts)): ?>
            <?php foreach ($posts as $post): ?>
                <div class="message mb-4">
                    <div class="user-info">
                        <img src="<?php echo htmlspecialchars($post['avatar_path']); ?>" alt="Avatar" class="user-avatar">
                        <p class="username"><?php echo htmlspecialchars($post['username']); ?></p>
                        <p class="message-time text-muted"><?php echo date('H:i', strtotime($post['created_at'])); ?></p>
                    </div>
                    <p><?php echo htmlspecialchars($post['content']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="alert alert-info">Aucun message dans ce sujet pour l'instant.</p>
        <?php endif; ?>
    </div>

    <div class="new-message-form text-center">
        <h2 class="mt-5">Répondre</h2>
        <form action="index.php?action=submit_post" method="post">
            <div class="form-group">
                <textarea name="message_content" class="form-control" rows="4" required></textarea>
            </div>
            <input type="hidden" name="topic_id" value="<?php echo $topicId; ?>">
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
