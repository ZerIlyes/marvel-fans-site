<?php
require_once 'app/models/Model.php';


class ForumController {
    private $forumModel;

    public function __construct() {
        $this->forumModel = new ForumModel(); // Créer une instance de ForumModel
    }

    public function showTopics() {
        $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
        $topics = $this->forumModel->getTopics($searchQuery); // Récupérer les sujets
        require 'app/views/forum/forum_view.php'; // Assurez-vous que le chemin vers la vue est correct
    }
    public function submitPost($postData) {
        $userId = $_SESSION['user_id'] ?? null;
        $topicId = $postData['topic_id'] ?? null;
        $content = $postData['message_content'] ?? '';

        if ($userId && $topicId && $content) {
            // Utilisez $this->forumModel pour appeler savePost()
            $result = $this->forumModel->savePost($topicId, $userId, $content);

            if ($result) {
                header("Location: index.php?action=view_topic&id=" . $topicId);
                exit();
            } else {
                // Gérer l'erreur d'insertion
            }
        } else {
            // Gérer l'erreur de données manquantes
        }
    }

    public function createTopic() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = trim($_POST['title']);
            $userId = $_SESSION["user_id"];

            if (!empty($title)) {
                $result = $this->forumModel->createTopic($title, $userId);

                if ($result) {
                    header("location: index.php?action=forum_topics");
                    exit();
                } else {
                    // Gérer l'erreur
                }
            } else {
                // Gérer le titre vide
            }
        } else {
            require 'app/views/forum/create_topic_view.php';
        }
    }
}