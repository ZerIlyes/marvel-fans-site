<?php
// ReviewController.php

require_once 'app/models/Model.php'; // Make sure that Model.php includes ReviewModel class

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
            $title = $_POST['movie_series_title']; // Sanitize this input
            $reviewText = $_POST['review']; // Sanitize this input
            $rating = intval($_POST['rating']); // Ensure $rating is an integer
            $userId = $_SESSION['user_id']; // Make sure the user is logged in and sanitize this input

            // Save the review
            $saveResult = $this->model->saveReview($userId, $title, $reviewText, $rating);

            // You may want to check if saveResult is true and handle any errors

            // Redirect to clear POST data and avoid form resubmission
            header('Location: index.php?action=write_review');
            exit();
        }

        // Render the view and pass the reviews to it
        include 'app/views/review/write_review_view.php';
    }
}