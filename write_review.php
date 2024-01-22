<?php
session_start();

require_once 'config.php';


$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $movie_series_title = trim($_POST["movie_series_title"]);
    $review = trim($_POST["review"]);
    $rating = trim($_POST["rating"]);
    $user_id = $_SESSION["user_id"];

    if (empty($movie_series_title) || empty($review) || empty($rating)) {
        $error = "Veuillez remplir tous les champs.";
    } else {
        $sql = "INSERT INTO reviews (movie_series_title, review, rating, user_id) VALUES (?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssii", $param_movie_series_title, $param_review, $param_rating, $param_user_id);

            $param_movie_series_title = $movie_series_title;
            $param_review = $review;
            $param_rating = $rating;
            $param_user_id = $user_id;

            if ($stmt->execute()) {
                header("location: write_review.php");
                exit();
            } else {
                $error = "Oops! Quelque chose s'est mal passé. Veuillez réessayer plus tard.";
            }

            $stmt->close();
        }
    }

    $conn->close();
}

$sql = "SELECT reviews.*, users.username, users.avatar_path FROM reviews JOIN users ON reviews.user_id = users.user_id ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<?php require_once 'navbar.php';?>

<div class="container">
    <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="review-form">
                    <h2>Écrire une Critique</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
    <div class="review">
        <!-- Ajouter l'avatar ici -->
        <img src="<?php echo htmlspecialchars($row['avatar_path']); ?>" alt="Avatar" width="50" height="50">
        <h3><?php echo htmlspecialchars($row['movie_series_title']); ?></h3>
        <p>Par <?php echo htmlspecialchars($row['username']); ?> le <?php echo $row['created_at']; ?></p>
        <p>Note :
            <?php for($i = 0; $i < $row['rating']; $i++): ?>
                ★
            <?php endfor; ?>
        </p>
        <p><?php echo nl2br(htmlspecialchars($row['review'])); ?></p>
    </div>
<?php endwhile; ?>

                <?php else: ?>
                    <p>Aucune critique disponible.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>

