<?php
// index.php à la racine de votre projet

session_start();
require_once 'app/controllers/QuizController.php';

$quizController = new QuizController();

// Vérifiez l'URI pour décider de l'action à exécuter
if (!isset($_GET['page'])) {
    $quizController->listQuizzes();
} else {
    switch ($_GET['page']) {
        case 'quiz_preview':
            if (isset($_GET['quiz_id'])) {
                $quiz_id = intval($_GET['quiz_id']);
                $quizController->previewQuiz($quiz_id);
            }
            break;
        case 'start_quiz':
            if (isset($_GET['quiz_id'])) {
                $quiz_id = intval($_GET['quiz_id']);
                $quizController->startQuiz($quiz_id);
            }
            break;
        case 'quiz_question':
            $quizController->showCurrentQuestion();
            break;
        case 'quiz_end':
            $quizController->endQuiz();
            break;
        default:
            // Gérer d'autres pages ou afficher une erreur 404
            break;
    }
}

// Gérer la soumission des réponses
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['answer'])) {
    $quizController->handleQuestionSubmission();
}
?>
