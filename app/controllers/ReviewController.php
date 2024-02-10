<?php
// ReviewController.php

require_once 'app/models/Model.php';

class ReviewController {
    private $model;

    public function __construct()
    {
        $this->model = new ReviewModel();
    }

    public function writeAndListReviews() {
        // Get all reviews
        $reviews = $this->model->getReviews();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Process form submission
            $title = $_POST['movie_series_title'];
            $reviewText = $_POST['review'];
            $rating = intval($_POST['rating']);
            $userId = $_SESSION['user_id'];

            // Save the review
            $saveResult = $this->model->saveReview($userId, $title, $reviewText, $rating);

            header('Location: index.php?action=write_review');
            exit();
        }
        include 'app/views/review/write_review_view.php';
    }
}