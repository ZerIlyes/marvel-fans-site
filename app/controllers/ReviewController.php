<?php
// app/controllers/ReviewController.php

require_once 'app/models/Model.php';

class ReviewController {
    private $reviewModel;

    public function __construct() {
        $this->reviewModel = new ReviewModel();
    }

    public function writeReview($movieSeriesTitle, $reviewText, $rating, $userId) {
        if (empty($movieSeriesTitle) || empty($reviewText) || empty($rating)) {
            return "Veuillez remplir tous les champs.";
        } else {
            if ($this->reviewModel->insertReview($movieSeriesTitle, $reviewText, $rating, $userId)) {
                header("location: write_review_view.php");
                exit();
            } else {
                return "Oops! Quelque chose s'est mal passé. Veuillez réessayer plus tard.";
            }
        }
    }

    public function displayReviews() {
        $reviews = $this->reviewModel->getReviews();
        require_once 'app/views/review/write_review_view.php';
    }
}
?>