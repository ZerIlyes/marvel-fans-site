<!-- write_review_view.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Écrire et Voir les Critiques</title>
    <link href="https://fonts.googleapis.com/css?family=Bangers&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <!-- Include Bootstrap CSS here if not already included in navbar -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bangers&display=swap');
        body , html  {
            height: 100%;
            margin: 0;
            background-image: url('/public/fond_review.png');
            background-position: center;
            background-repeat: repeat;
            background-size: cover;
            font-family: 'Bangers', cursive; /* Cette police a un style qui rappelle celui des titres Marvel/DC */
        }
        .fa-star {
            color: gray; /* Couleur des étoiles non sélectionnées */
            cursor: pointer;
        }

        .fa-solid {
            color: gold; /* Couleur des étoiles sélectionnées */
        }

    </style>
</head>
<body>
<!-- Include your navbar here -->

<div style="width: 80%; margin: auto; overflow: hidden;">
    <!-- Form for writing a review -->
    <div style="display: flex; justify-content: center;">
        <div style="flex-basis: 50%; margin-top: 8%; margin-bottom: 8%;">
            <div style="border-radius: 10px; background-color: #333333; color: #ffffff; padding: 20px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                <h2 style="color: #ff0000; font-family: 'Bangers', cursive; font-size: 28px; margin-bottom: 20px;">Écrire une Critique</h2>
                <form action="index.php?action=submit_review" method="post">
                    <!-- Form inputs and submit button -->
                    <!-- ... -->
                </form>
            </div>
        </div>
    </div>
    <!-- Display of existing reviews -->
    <div style="display: flex; justify-content: center;">
        <div style="flex-basis: 50%;">
            <div>
                <?php if (!empty($reviews)): ?>
                    <?php foreach ($reviews as $review): ?>
                        <!-- Display a single review -->
                        <!-- ... -->
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucune critique disponible.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>