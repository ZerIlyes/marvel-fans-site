<?php
require_once 'app/models/Model.php';

class TopicController {
    private $topicModel;

    public function __construct() {
        $this->topicModel = new TopicModel();
    }

    public function showTopic($topicId) {
        $posts = $this->topicModel->getPostsByTopicId($topicId);
        require 'app/views/forum/topic_view.php';
    }

}
