<?php
function update_quiz_score($conn, $quiz_id, $user_id, $new_score) {
    // Vérifiez si un score existe déjà pour cet utilisateur et ce quiz
    $check_score_sql = "SELECT result_id, score FROM results WHERE user_id = ? AND quiz_id = ?";
    if ($check_stmt = $conn->prepare($check_score_sql)) {
        $check_stmt->bind_param('ii', $user_id, $quiz_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_row = $check_result->fetch_assoc()) {
            // Mise à jour du score existant si le nouveau score est supérieur
            if ($new_score > $check_row['score']) {
                $update_score_sql = "UPDATE results SET score = ?, quiz_date = NOW() WHERE result_id = ?";
                if ($update_stmt = $conn->prepare($update_score_sql)) {
                    $update_stmt->bind_param('ii', $new_score, $check_row['result_id']);
                    $update_stmt->execute();
                    $update_stmt->close();
                }
            }
        } else {
            // Insertion d'un nouveau score
            $insert_score_sql = "INSERT INTO results (user_id, quiz_id, score, quiz_date) VALUES (?, ?, ?, NOW())";
            if ($insert_stmt = $conn->prepare($insert_score_sql)) {
                $insert_stmt->bind_param('iii', $user_id, $quiz_id, $new_score);
                $insert_stmt->execute();
                $insert_stmt->close();
            }
        }
        $check_stmt->close();
    }
}

function display_leaderboard($conn, $quiz_id) {
    $leaderboard_query = "SELECT users.username, users.avatar_path, results.score FROM results JOIN users ON results.user_id = users.user_id WHERE results.quiz_id = ? ORDER BY results.score DESC, results.quiz_date ASC LIMIT 10";
    if ($leaderboard_stmt = $conn->prepare($leaderboard_query)) {
        $leaderboard_stmt->bind_param('i', $quiz_id);
        $leaderboard_stmt->execute();
        $leaderboard_result = $leaderboard_stmt->get_result();

        // Affichage du leaderboard
        echo "<div class='leaderboard'>";
        echo "<h2>Leaderboard</h2>";
        echo "<ol>";
        while ($row = $leaderboard_result->fetch_assoc()) {
            $avatarPath = $row['avatar_path'] ?: 'public/default_avatar.png'; // Si l'avatar n'existe pas, utilisez l'avatar par défaut
            echo "<li><img src='" . htmlspecialchars($avatarPath) . "' alt='Avatar' class='avatar'>" . htmlspecialchars($row['username']) . " - " . $row['score'] . "</li>";
        }
        echo "</ol>";
        echo "</div>";

        $leaderboard_stmt->close();
    } else {
        // Gérer l'erreur si la requête ne peut pas être préparée
        echo "Erreur lors de la préparation de la requête leaderboard.";
    }
}

?>