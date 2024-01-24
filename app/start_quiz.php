<?php

session_start();
require 'config.php'; // Assurez-vous que ce fichier contient les informations de connexion à votre base de données

// Vérifiez si l'ID du quiz est passé et est un nombre valide
$quiz_id = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : 0;

if ($quiz_id <= 0) {
    die("ID de quiz invalide.");
}

// Initialisez ou réinitialisez les variables de session pour ce quiz
$_SESSION['quiz_id'] = $quiz_id;
$_SESSION['current_question_index'] = 0;
$_SESSION['score'] = 0;

// Récupérez toutes les questions pour le quiz choisi
$query = "SELECT question_id, question_text FROM questions WHERE quiz_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $quiz_id);
$stmt->execute();
$result = $stmt->get_result();

// Stockez les questions dans la session pour éviter de multiples requêtes à la base de données
$_SESSION['questions'] = $result->fetch_all(MYSQLI_ASSOC);

// Vérifiez s'il y a des questions pour le quiz
if (empty($_SESSION['questions'])) {
    die("Aucune question trouvée pour ce quiz.");
}

// Redirigez vers la page qui affiche la première question
header("Location: quiz_question.php");
exit;