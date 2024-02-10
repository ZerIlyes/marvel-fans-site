<?php
require_once 'app/models/Model.php';

class UserTopicsController {
    private $topicModel;
    private $userTopicsModel;
    private $forumModel;

    public function __construct() {
        $this->topicModel = new TopicModel();
        $this->userTopicsModel = new UserTopicsModel();
        $this->forumModel = new forumModel();
    }
    public function showTopic($topicId) {
        $posts = $this->topicModel->getPostsByTopicId($topicId);
        require 'app/views/forum/topic_view.php';
    }
    public function showUserTopics($userId) {
        $user = $this->userTopicsModel->getUsername($userId);
        $userTopics = $this->userTopicsModel->getUserTopics($userId);

        include 'app/views/admin/user_topics_view.php';
    }
    public function deleteTopic($topicId) {
        if ($this->forumModel->deleteTopic($topicId)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => "Impossible de supprimer le sujet"]);
        }
        exit();
    }


}
