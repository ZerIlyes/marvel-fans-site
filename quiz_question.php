<?php

session_start();
require 'config.php';

// Vérifiez si nous avons un quiz et des questions dans la session
if (!isset($_SESSION['quiz_id'], $_SESSION['questions'], $_SESSION['current_question_index'])) {
    die("Aucun quiz en cours ou index de question invalide.");
}

// Récupérez la question actuelle
$current_question_index = $_SESSION['current_question_index'];
$current_question = $_SESSION['questions'][$current_question_index];

// Vérifiez si une réponse a été soumise
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['answer'])) {
    // Récupérez la réponse de l'utilisateur et vérifiez si elle est correcte
    $selected_option = $_POST['answer'];
    $question_id = $current_question['question_id'];

    $query = "SELECT is_correct FROM options WHERE question_id = ? AND option_text = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('is', $question_id, $selected_option);
    $stmt->execute();
    $result = $stmt->get_result();
    $answer = $result->fetch_assoc();

// Si la réponse est correcte, augmentez le score
if ($answer && $answer['is_correct']) {
    $_SESSION['score'] += 100; // ou la valeur que vous attribuez à une réponse correcte
}

// Passez à la question suivante
$_SESSION['current_question_index']++;

// Vérifiez si nous avons atteint la fin du quiz
if ($_SESSION['current_question_index'] >= count($_SESSION['questions'])) {
    // Redirigez vers la page de fin du quiz
    header("Location: quiz_end.php");
    exit;
} else {
    // Redirigez pour afficher la prochaine question
    header("Location: quiz_question.php");
    exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
    <meta charset="UTF-8">
    <title>Question</title>
    </head>
        <body>
            <h1><?php echo htmlspecialchars($current_question['question_text']); ?></h1>
                <form action="quiz_question.php" method="post">
                <?php
                        // Récupérer les options pour la question actuelle
                        $query = "SELECT option_text FROM options WHERE question_id = ?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param('i', $current_question['question_id']);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($option = $result->fetch_assoc()) {
                            echo '<div>';
                            echo '<input type="radio" name="answer" value="' . htmlspecialchars($option['option_text']) . '" required> ';
                            echo htmlspecialchars($option['option_text']);
                            echo '</div>';
                        }
                        ?>
                            <button type="submit">Soumettre la réponse</button>
                        </form>
        </body>
</html>
