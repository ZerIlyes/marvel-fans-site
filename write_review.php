<?php
session_start();

require_once 'config.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

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

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <style>
        body {
            background-color: #f0f0f0;
        }

        .navbar {
            background-color: #fff;
        }

        .navbar-brand img {
            margin-top: 5px;
        }

        .user-info {
            margin-right: 20px;
        }

        .review-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }

        .review-form h2 {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 5px;
        }

        .reviews-display {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        .review {
    margin-bottom: 20px;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;    
    overflow: hidden; /* Ajouté pour éviter le débordement du texte */
    word-wrap: break-word; /* Assurez-vous que les mots longs ne débordent pas */
    
}



        .review h3 {
            margin-top: 0;
        }

        .review p {
            margin-bottom: 0;
        }
    </style>
    <title>Accueil - Site Fans Marvel</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="index.html">
        <img src="../public/Logo.jpg" alt="Logo Marvel Fans" height="40">
    </a>
    <div class="collapse navbar-collapse justify-content-end user-info">
        <ul class="navbar-nav ml-auto">
            <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo htmlspecialchars($_SESSION["username"]); ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="logout.php">Déconnexion</a>
                    </div>
                </li>
            <?php else: ?>
                <li class="nav-item"><a class="nav-link" href="register.php">S'inscrire</a></li>
                <li class="nav-item"><a class="nav-link" href="login.php">Se connecter</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
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
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.7.12/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

