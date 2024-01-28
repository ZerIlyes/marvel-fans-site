<?php
require_once 'admin.php';
require_once '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Vérifiez si l'ID de l'utilisateur est présent dans l'URL
    if (isset($_GET["user_id"])) {
        $userId = $_GET["user_id"];

        // Supprimez l'utilisateur de la base de données
        $sql = "DELETE FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->close();

        // Réponse indiquant que la suppression a réussi avec un message de confirmation
        echo json_encode(array("success" => true, "message" => "L'utilisateur a été supprimé avec succès."));
        exit();
    }
}

// Réponse en cas d'échec de la suppression
echo json_encode(array("success" => false, "message" => "Échec de la suppression de l'utilisateur."));
exit();
?>
