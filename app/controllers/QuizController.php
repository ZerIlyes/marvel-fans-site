<?php
// app/controllers/QuizController.php

require_once 'app/models/Model.php';

class QuizController
{
    private $model;

    public function __construct()
    {
        $this->model = new QuizModel();
    }

    public function listQuizzes()
    {
        $quizzes = $this->model->getAllQuizzes();

        // Fixed the path with __DIR__
        require_once 'app/views/quiz/quiz_list_view.php';
    }

    public function previewQuiz($quiz_id) {
        $quiz = $this->model->getQuizDetails($quiz_id);
        require_once 'app/views/quiz/quiz_preview_view.php';
    }

    public function startQuiz($quiz_id) {
        if ($quiz_id <= 0) {
            die("ID de quiz invalide.");
        }
        $questions = $this->model->getQuestionsByQuizId($quiz_id);
        if (empty($questions)) {
            die("Aucune question trouvée pour ce quiz.");
        }
        $_SESSION['quiz_id'] = $quiz_id;
        $_SESSION['current_question_index'] = 0;
        $_SESSION['score'] = 0;
        $_SESSION['questions'] = $questions;
        header("Location: index.php?page=quiz_question");
        exit;
    }

    public function showCurrentQuestion() {
        if (!isset($_SESSION['questions']) || !isset($_SESSION['current_question_index'])) {
            die("Erreur : Les questions du quiz ne sont pas chargées correctement.");
        }

        $questions = $_SESSION['questions'];
        $currentQuestionIndex = $_SESSION['current_question_index'];

        if ($currentQuestionIndex >= count($questions)) {
            header("Location: index.php?page=quiz_end");
            exit;
        }

        $currentQuestion = $questions[$currentQuestionIndex];
        $options = $this->model->getOptionsByQuestionId($currentQuestion['question_id']);
        require_once 'app/views/quiz/quiz_question_view.php';
    }

    public function handleQuestionSubmission() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['answer'])) {
            $selected_option_id = intval($_POST['answer']);
            $current_question_id = $_SESSION['questions'][$_SESSION['current_question_index']]['question_id'];

            if ($this->model->checkIfOptionIsCorrect($current_question_id, $selected_option_id)) {
                $_SESSION['score'] += 100; // Update score if the answer is correct.
            }

            $_SESSION['current_question_index']++;

            if ($_SESSION['current_question_index'] < count($_SESSION['questions'])) {
                header("Location: index.php?page=quiz_question");
                exit;
            } else {
                $this->finalizeQuiz();
            }
        }
    }

    private function finalizeQuiz() {
        $userId = $_SESSION['user_id'];
        $finalScore = $_SESSION['score'];
        $quizId = $_SESSION['quiz_id'];

        $this->model->updateQuizScore($userId, $quizId, $finalScore);
        header("Location: index.php?page=quiz_end");
        exit;
    }

    public function endQuiz() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: login.php'); // Redirigez vers la page de connexion si l'utilisateur n'est pas connecté
            exit;
        }

        $userId = $_SESSION['user_id'];
        $finalScore = $_SESSION['score'];
        $quizId = $_SESSION['quiz_id'];

        // Assurez-vous que la méthode updateQuizScore est correctement appelée ici
        $this->model->updateQuizScore($userId, $quizId, $finalScore);
        $leaderboardData = $this->model->getLeaderboardData($quizId);

        // Passez le score final et les données du leaderboard à la vue
        require_once 'app/views/quiz/quiz_end_view.php';
    }





}