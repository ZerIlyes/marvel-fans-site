<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Écrire et Voir les Critiques</title>
    <link href="https://fonts.googleapis.com/css?family=Bangers&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/write_review_view.css">
    <link rel="stylesheet" href="public/css/redirection.css">
</head>
<body>
<?php include 'public/redirection.php'; ?>
<div class="container">
    <div class="review-form">
        <div class="review-form-box">
            <h2 class="review-title">Écrire une Critique</h2>
            <form action="index.php?action=write_review" method="post">
                <div class="form-group review-title-div">
                    <label for="movie_series_title">Titre du film ou de la série :</label>
                    <input type="text" id="movie_series_title" name="movie_series_title" class="form-control" required>
                </div>
                <div class="form-group review-textarea-div">
                    <label for="review">Votre critique :</label>
                    <textarea id="review" name="review" rows="4" cols="50" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label>Note :</label>
                    <div class="rating-stars">
                        <i class="fa fa-star" data-value="1"></i>
                        <i class="fa fa-star" data-value="2"></i>
                        <i class="fa fa-star" data-value="3"></i>
                        <i class="fa fa-star" data-value="4"></i>
                        <i class="fa fa-star" data-value="5"></i>
                    </div>
                    <input type="hidden" id="inputRating" name="rating" required>
                </div>

                <button type="submit" class="submit-button">Soumettre</button>
            </form>
        </div>
    </div>


    <div class="review-container">
        <div class="review-box">
            <?php if (!empty($reviews)): ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="review-item" >
                        <img class="avatar-image" src="<?php echo htmlspecialchars($review['avatar_path']); ?>" alt="Avatar">
                        <h3 class="review-title"><?php echo htmlspecialchars($review['movie_series_title']); ?></h3>
                        <p class="review-info">Par <?php echo htmlspecialchars($review['username']); ?> le <?php echo $review['created_at']; ?></p>
                        <p class="review-rating">Note :
                            <?php for ($i = 0; $i < $review['rating']; $i++): ?>
                                <i class="fa fa-star"> </i>
                            <?php endfor; ?>
                        </p>
                        <p class="review-text"><?php echo nl2br(htmlspecialchars($review['review'])); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucune critique disponible.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<script src="public/js/review.js"> </script>
</body>
</html>
