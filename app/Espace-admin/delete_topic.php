<?php
require_once 'admin.php';
require_once '../config.php';

// Vérifiez si la méthode de requête est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérez le topic_id depuis le formulaire POST
    $topic_id = $_POST['topic_id'];

    $user_id = $_SESSION["user_id"] ?? null;

    // Vérifiez les autorisations de suppression ici (par exemple, si l'utilisateur est l'auteur du sujet)

    // Supprimez le sujet
    $sql = "DELETE FROM topics WHERE topic_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $topic_id); // "i" indique un paramètre de type entier
    $stmt->execute();

    // Définissez un message de confirmation
    $_SESSION['success_message'] = "Le sujet a été supprimé avec succès.";

    // Répondre avec l'ID de l'utilisateur
    echo json_encode(['success' => true, 'user_id' => $user_id]);
    exit();
}
?>
