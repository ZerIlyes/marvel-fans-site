<?php
session_start();
require_once 'config.php';

// Récupérez la question actuelle et l'index de la question
$current_question_index = $_SESSION['current_question_index'] ?? null;
$current_question = $_SESSION['questions'][$current_question_index] ?? null;

// Vérifiez si vous êtes à la fin du quiz
if ($current_question_index >= count($_SESSION['questions'])) {
    // Logique pour l'insertion ou la mise à jour des scores
    $user_id = $_SESSION['user_id'] ?? null;
    $quiz_id = $_SESSION['quiz_id'];
    $current_score = $_SESSION['score'];

    // Vérifiez d'abord si un score existe
    $check_score_query = "SELECT result_id FROM results WHERE user_id = ? AND quiz_id = ?";
    $stmt = $conn->prepare($check_score_query);
    $stmt->bind_param('ii', $user_id, $quiz_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // Mise à jour du score existant
        $row = $result->fetch_assoc();
        $update_score_query = "UPDATE results SET score = ?, quiz_date = NOW() WHERE result_id = ?";
        $stmt = $conn->prepare($update_score_query);
        $stmt->bind_param('ii', $current_score, $row['result_id']);
        $stmt->execute();
    } else {
        // Insertion d'un nouveau score
        $insert_score_query = "INSERT INTO results (user_id, quiz_id, score, quiz_date) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($insert_score_query);
        $stmt->bind_param('iii', $user_id, $quiz_id, $current_score);
        $stmt->execute();
    }

    // Redirection vers la page de fin du quiz
    header("Location: quiz_end.php");
    exit;
    }

    // Si une réponse est soumise
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['answer'], $current_question)) {
    $selected_option = $_POST['answer'];
    $question_id = $current_question['question_id'];

    // Vérifiez si la réponse est correcte
    $query = "SELECT is_correct FROM options WHERE question_id = ? AND option_text = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('is', $question_id, $selected_option);
    $stmt->execute();
    $result = $stmt->get_result();
    $answer = $result->fetch_assoc();

        // Si la réponse est correcte, augmentez le score
    if ($answer && $answer['is_correct']) {
        $_SESSION['score'] += 100; // ou la valeur que vous attribuez à une réponse correcte
    }

        // Passez à la question suivante
    $_SESSION['current_question_index']++;

        // Redirigez pour afficher la prochaine question
    header("Location: quiz_question.php");
    exit; }

        // Si vous êtes ici, cela signifie que vous n'êtes pas à la fin du quiz et qu'aucune réponse n'a été soumise
        // Afficher la question actuelle et les options
?>

        <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Question du quiz</title>
    <link rel="stylesheet" href="style.css"> <!-- Assurez-vous d'inclure votre fichier CSS correctement ici -->
</head>

<body>
<?php include("navbar.php"); ?> <!-- Incluez votre bar de navigation ici -->

<h1><?php echo htmlspecialchars($current_question['question_text']); ?></h1>

<form action="quiz_question.php" method="post">
    <?php
    // Récupérer les options pour la question actuelle
    $query = "SELECT option_text FROM options WHERE question_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $current_question['question_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($option = $result->fetch_assoc()) {
        echo '<div>';
        echo '<input type="radio" name="answer" value="' . htmlspecialchars($option['option_text']) . '" required> ';
        echo htmlspecialchars($option['option_text']);
        echo '</div>';
    }
    ?>
    <button type="submit">Soumettre la réponse</button>
</form>
</body>
</html>