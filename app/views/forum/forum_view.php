<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Marvel - Sujets</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/topics.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>
<body>
<div class="container mt-5 main-container">
    <h1 class="forum-title">Forum Comics</h1>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="index.php?action=create_topic" class="btn btn-primary">Nouveau sujet</a>
        <form action="index.php?action=forum_topics" method="get" class="flex-grow-1 mx-3">
            <div class="input-group">
                <input type="text" name="search" placeholder="Rechercher dans le forum" class="form-control" value="<?php echo htmlspecialchars($searchQuery); ?>">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-outline-secondary"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="container mt-3 content-container">
    <?php if (!empty($topics)): ?>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="bg-danger text-white">
                <tr>
                    <th>Sujet</th>
                    <th>Auteur</th>
                    <th>Nb</th>
                    <th>Dernier Msg</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($topics as $topic): ?>
                    <tr>
                        <td><a href="index.php?action=view_topic&id=<?php echo $topic['topic_id']; ?>" class="text-danger"><?php echo htmlspecialchars($topic['title']); ?></a></td>
                        <td><?php echo htmlspecialchars($topic['username']); ?></td>
                        <td><?php echo $topic['post_count']; ?></td>
                        <td><?php echo htmlspecialchars($topic['last_post_date']); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-center">Aucun sujet trouvé.</p>
    <?php endif; ?>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
