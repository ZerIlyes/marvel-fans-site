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

    public function getUserInfo($userId) {
        $stmt = $this->db->prepare("SELECT avatar_path, email FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            // Chemin par défaut si l'utilisateur n'a pas d'avatar
            return ['avatar_path' => 'public/images/default-avatar.png', 'email' => ''];
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


    // Inscription d'un nouvel utilisateur
    public function registerUser($username, $email, $passwordHash) {
        global $conn; // Utilisez la connexion globale

        // Préparation de la requête
        $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $passwordHash);

        // Exécution et vérification
        if ($stmt->execute()) {
            return $conn->insert_id; // Retourne le dernier ID inséré
        } else {
            return false;
        }
    }

    // Vérification des informations de connexion de l'utilisateur
    public function loginUser($email, $password) {
        global $conn;

        // Préparation de la requête
        $stmt = $conn->prepare("SELECT user_id, username, password_hash, is_admin FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['password_hash'])) {
                    return $user; // Connexion réussie
                }
            }
        }
        return false; // Échec de la connexion
    }

    public function updateUserProfile($userId, $username, $email, $avatarPath, $hashedPassword = null) {
        global $conn; // Utilisez la connexion globale

        // Préparez la requête SQL
        $sql = "UPDATE users SET username = ?, email = ?, avatar_path = ?";

        // Ajoutez le mot de passe à la requête s'il est fourni
        if ($hashedPassword !== null) {
            $sql .= ", password_hash = ?";
        }

        $sql .= " WHERE user_id = ?";

        // Préparez la requête
        $stmt = $conn->prepare($sql);

        // Liaison des paramètres
        if ($hashedPassword !== null) {
            $stmt->bind_param("ssssi", $username, $email, $avatarPath, $hashedPassword, $userId);
        } else {
            $stmt->bind_param("sssi", $username, $email, $avatarPath, $userId);
        }

        if ($stmt->execute()) {
            return true; // Mise à jour réussie
        } else {
            return false; // Échec de la mise à jour
        }
    }

    public function getUsers() {
        $sql = "SELECT user_id, username, email, is_admin FROM users";
        $result = $this->db->query($sql);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return []; // Retourner un tableau vide si aucun utilisateur n'est trouvé
        }
    }

    public function deleteUser($userId) {
        $this->db->begin_transaction();

        try {
            // Supprimez d'abord tous les topics associés à l'utilisateur
            $stmt = $this->db->prepare("DELETE FROM topics WHERE user_id = ?");
            $stmt->bind_param("i", $userId);
            if (!$stmt->execute()) {
                throw new Exception("Erreur lors de la suppression des topics: " . $stmt->error);
            }
            $stmt->close();

            // Puis supprimez toutes les reviews associées à l'utilisateur
            $stmt = $this->db->prepare("DELETE FROM reviews WHERE user_id = ?");
            $stmt->bind_param("i", $userId);
            if (!$stmt->execute()) {
                throw new Exception("Erreur lors de la suppression des reviews: " . $stmt->error);
            }
            $stmt->close();

            // Finalement, supprimez l'utilisateur
            $stmt = $this->db->prepare("DELETE FROM users WHERE user_id = ?");
            $stmt->bind_param("i", $userId);
            if (!$stmt->execute()) {
                throw new Exception("Erreur lors de la suppression de l'utilisateur: " . $stmt->error);
            }
            $stmt->close();

            $this->db->commit();
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            $this->db->rollback();
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit();
    }

    public function addUser($username, $email, $password, $avatarPath) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password_hash, avatar_path) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $passwordHash, $avatarPath);

        if ($stmt->execute()) {
            $stmt->close();
            return ['success' => true];
        } else {
            $error = $this->db->error;
            $stmt->close();
            return ['success' => false, 'message' => $error];
        }
    }




}

class ReviewModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getReviews() {
        $sql = "SELECT reviews.*, users.username, users.avatar_path FROM reviews JOIN users ON reviews.user_id = users.user_id ORDER BY created_at DESC";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function saveReview($userId, $title, $review, $rating) {
        $stmt = $this->db->prepare("INSERT INTO reviews (user_id, movie_series_title, review, rating) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issi", $userId, $title, $review, $rating);
        return $stmt->execute();
    }
}


class ForumModel
{
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getTopics($searchQuery = '')
    {
        $likeSearchQuery = '%' . $searchQuery . '%';
        $sql = "SELECT t.topic_id, t.title, t.created_at AS topic_created_at, u.username, 
           (SELECT COUNT(p.post_id) FROM posts p WHERE p.topic_id = t.topic_id) as post_count, 
           (SELECT MAX(p.created_at) FROM posts p WHERE p.topic_id = t.topic_id) as last_post_date 
    FROM topics t
    JOIN users u ON t.user_id = u.user_id
    WHERE t.title LIKE ?
    GROUP BY t.topic_id
    ORDER BY last_post_date DESC, topic_created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s', $likeSearchQuery);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
    public function savePost($topicId, $userId, $content) {
        $stmt = $this->db->prepare("INSERT INTO posts (topic_id, user_id, content) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $topicId, $userId, $content);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    public function createTopic($title, $userId) {
        $stmt = $this->db->prepare("INSERT INTO topics (title, user_id) VALUES (?, ?)");
        $stmt->bind_param("si", $title, $userId);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    public function deleteTopic($topicId) {
        $stmt = $this->db->prepare("DELETE FROM topics WHERE topic_id = ?");
        $stmt->bind_param("i", $topicId);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }

}

class TopicModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getPostsByTopicId($topicId) {
        $stmt = $this->db->prepare("SELECT posts.*, users.username, users.avatar_path 
                                FROM posts 
                                JOIN users ON posts.user_id = users.user_id 
                                WHERE topic_id = ? 
                                ORDER BY created_at DESC");
        $stmt->bind_param("i", $topicId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
}

class UserTopicsModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getUserTopics($userId) {
        $sql = "SELECT topic_id, title, created_at FROM topics WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getUsername($userId) {
        $stmt = $this->db->prepare("SELECT username FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}





