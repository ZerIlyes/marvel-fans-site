<?php
// app/models/Model.php

require_once 'config.php'; // Ajustez le chemin selon votre structure de répertoire

class Database {
    private $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
            if ($this->conn->connect_error) {
                throw new Exception("Connection failed: " . $this->conn->connect_error);
            }
        } catch (Exception $exception) {
            die("ERREUR : Impossible de se connecter. " . $exception->getMessage());
        }

        return $this->conn;
    }
}





class QuizModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getAllQuizzes() {
        $query = "SELECT quiz_id, title, description, image_path FROM quiz";
        $result = $this->db->query($query);

        if (!$result) {
            return [];
        }

        $quizzes = [];
        while ($quiz = $result->fetch_assoc()) {
            $quizzes[] = $quiz;
        }

        return $quizzes;
    }

    public function getQuizDetails($quiz_id) {
        $stmt = $this->db->prepare("SELECT title, description, image_path FROM quiz WHERE quiz_id = ?");
        $stmt->bind_param('i', $quiz_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function getQuestionsByQuizId($quiz_id) {
        $stmt = $this->db->prepare("SELECT question_id, question_text FROM questions WHERE quiz_id = ?");
        $stmt->bind_param('i', $quiz_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getOptionsByQuestionId($questionId) {
        $stmt = $this->db->prepare("SELECT option_id, option_text FROM options WHERE question_id = ?");
        $stmt->bind_param('i', $questionId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function checkIfOptionIsCorrect($questionId, $optionId) {
        $stmt = $this->db->prepare("SELECT is_correct FROM options WHERE question_id = ? AND option_id = ?");
        $stmt->bind_param('ii', $questionId, $optionId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['is_correct'];
    }

    public function getLeaderboardData($quizId) {
        $leaderboard_query = "SELECT users.username, users.avatar_path, results.score FROM results JOIN users ON results.user_id = users.user_id WHERE results.quiz_id = ? ORDER BY results.score DESC, results.quiz_date ASC LIMIT 10";
        $stmt = $this->db->prepare($leaderboard_query);
        $stmt->bind_param('i', $quizId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function updateQuizScore($userId, $quizId, $newScore) {
        // Vérifiez si un score existe déjà pour cet utilisateur et ce quiz
        $check_score_sql = "SELECT result_id, score FROM results WHERE user_id = ? AND quiz_id = ?";
        if ($check_stmt = $this->db->prepare($check_score_sql)) {
            $check_stmt->bind_param('ii', $userId, $quizId);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();

            if ($check_row = $check_result->fetch_assoc()) {
                // Mise à jour du score existant si le nouveau score est supérieur
                if ($newScore > $check_row['score']) {
                    $update_score_sql = "UPDATE results SET score = ?, quiz_date = NOW() WHERE result_id = ?";
                    if ($update_stmt = $this->db->prepare($update_score_sql)) {
                        $update_stmt->bind_param('ii', $newScore, $check_row['result_id']);
                        $update_stmt->execute();
                        $update_stmt->close();
                    }
                }
            } else {
                // Insertion d'un nouveau score
                $insert_score_sql = "INSERT INTO results (user_id, quiz_id, score, quiz_date) VALUES (?, ?, ?, NOW())";
                if ($insert_stmt = $this->db->prepare($insert_score_sql)) {
                    $insert_stmt->bind_param('iii', $userId, $quizId, $newScore);
                    $insert_stmt->execute();
                    $insert_stmt->close();
                }
            }
            $check_stmt->close();
        } else {
            // Gérer une erreur de préparation de la requête
            echo "Erreur lors de la préparation de la requête pour vérifier ou mettre à jour le score.";
        }
    }

}




class UserModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function registerUser($username, $email, $password, $avatar) {
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password_hash, avatar_path) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $password, $avatar);

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }

    public function getUserAvatarPath($userId) {
        $stmt = $this->db->prepare("SELECT avatar_path FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['avatar_path'];
        } else {
            return 'public/default_avatar.png'; // Chemin par défaut de l'avatar
        }
    }


    public function getUserByEmail($email) {
        $stmt = $this->db->prepare("SELECT user_id, username, password_hash FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row; // Retourne les données de l'utilisateur
        } else {
            return null; // L'utilisateur n'a pas été trouvé
        }
        $stmt->close();
    }
}

class ReviewModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function insertReview($movieSeriesTitle, $reviewText, $rating, $userId) {
        $stmt = $this->db->prepare("INSERT INTO reviews (movie_series_title, review, rating, user_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $movieSeriesTitle, $reviewText, $rating, $userId);
        return $stmt->execute();
    }

    public function getReviews() {
        $stmt = $this->db->prepare("SELECT reviews.*, users.username, users.avatar_path FROM reviews JOIN users ON reviews.user_id = users.user_id ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
