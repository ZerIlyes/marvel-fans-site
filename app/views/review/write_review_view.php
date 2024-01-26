<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Écrire une critique</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="">
</head>
<body>

<?php require_once 'app/views/navbar.php'; ?>

<div class="container">
    <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="review-form">
                    <h2>Écrire une Critique</h2>
                    <form action="index.php?page=submit_review" method="post">
                        <div class="form-group">
                            <label for="movie_series_title">Titre du film ou de la série :</label>
                            <input type="text" id="movie_series_title" name="movie_series_title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="review">Votre critique :</label>
                            <textarea id="review" name="review" rows="4" cols="50" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="rating">Note :</label>
                            <input type="number" id="rating" name="rating" min="1" max="5" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Soumettre</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="reviews-display">
                <?php if (!empty($reviews)): ?>
                    <?php foreach ($reviews as $review): ?>
                        <div class="review">
                            <!-- Ajouter l'avatar ici -->
                            <img src="<?php echo htmlspecialchars($review['avatar_path']); ?>" alt="Avatar" width="50" height="50">
                            <h3><?php echo htmlspecialchars($review['movie_series_title']); ?></h3>
                            <p>Par <?php echo htmlspecialchars($review['username']); ?> le <?php echo $review['created_at']; ?></p>
                            <p>Note :
                                <?php for ($i = 0; $i < $review['rating']; $i++): ?>
                                    ★
                                <?php endfor; ?>
                            </p>
                            <p><?php echo nl2br(htmlspecialchars($review['review'])); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucune critique disponible.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
