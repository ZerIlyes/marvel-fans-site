<?php
session_start();
require_once 'config.php';
require_once 'leaderboard.php';

// Récupérez l'ID du quiz et l'ID de l'utilisateur à partir de la session
$quiz_id = $_SESSION['quiz_id'] ?? 1;
$user_id = $_SESSION['user_id'] ?? null; // Vous devez vous assurer que l'ID de l'utilisateur est correctement défini lors de la connexion ou de l'inscription de l'utilisateur.


$current_question_index = $_SESSION['current_question_index'] ?? 0;
if (!isset($_SESSION['questions'][$current_question_index])) {
    // Redirect or handle the error if the current question index is not set
    header("Location: error_page.php"); // Use an appropriate redirection
    exit;
}

$current_question = $_SESSION['questions'][$current_question_index];

// Récupérez le nombre total de questions pour le quiz actuel
$total_questions_query = "SELECT COUNT(question_id) as total FROM questions WHERE quiz_id = ?";
$stmt = $conn->prepare($total_questions_query);
$stmt->bind_param('i', $quiz_id);
$stmt->execute();
$total_questions_result = $stmt->get_result();
$total_questions_row = $total_questions_result->fetch_assoc();
$total_questions = $total_questions_row['total'];

// Récupérez la question actuelle et l'index de la question
$current_question_index = $_SESSION['current_question_index'] ?? 0;

// Logique de traitement de la réponse à une question
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['answer'])) {
    // Votre logique existante pour traiter la réponse, augmenter le score, etc.
    // ...

    // Passez à la question suivante
    $_SESSION['current_question_index']++;

    // Si nous avons atteint la fin du quiz, mettez à jour le score avant de rediriger.
    if ($_SESSION['current_question_index'] >= $total_questions) {
        if (isset($_SESSION['score'])) {
            update_quiz_score($conn, $quiz_id, $_SESSION['user_id'], $_SESSION['score']);
        }
        // Redirection vers la page de fin du quiz
        header("Location: quiz_end.php");
        exit;
    } else {
        // Redirigez pour afficher la prochaine question si le quiz n'est pas terminé.
        header("Location: quiz_question.php");
        exit;
    }
}
// Redirect to the results page if the quiz is finished
if ($current_question_index >= $total_questions) {
    header("Location: quiz_end.php");
    exit;
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Question du quiz</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="quiz_question.css">
</head>
<body>


<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="quiz-card card text-center">
                <div class="card-header">
                    Question <?php echo ($current_question_index + 1); ?> sur <?php echo count($_SESSION['questions']); ?>
                </div>
                <div class="card-body">
                    <h2 class="quiz-question"><?php echo htmlspecialchars($current_question['question_text']); ?></h2>
                    <form action="quiz_question.php" method="post" class="quiz-options">
                        <?php
                        // Code PHP pour récupérer les options de la question actuelle
                        $query = "SELECT option_text FROM options WHERE question_id = ?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param('i', $current_question['question_id']);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($option = $result->fetch_assoc()) {
                            echo '<div class="quiz-option" onclick="selectOption(this)">';
                            echo htmlspecialchars($option['option_text']);
                            echo '<input type="radio" name="answer" value="' . htmlspecialchars($option['option_text']) . '" hidden required>';
                            echo '</div>';
                        }
                        ?>
                        <button type="submit" class="btn btn-submit mt-4">Valider</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function selectOption(element) {
        document.querySelectorAll('.quiz-option').forEach(function(option) {
            option.classList.remove('selected');
        });
        element.classList.add('selected');
        let radio = element.querySelector('input[type=radio]');
        radio.checked = true;
    }
</script>

<!-- Bootstrap JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>




