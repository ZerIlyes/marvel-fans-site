<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $content = $_POST['message_content'];
    $topic_id = $_POST['topic_id'];
    $user_id = $_SESSION['user_id'];
    
    $sql = "INSERT INTO posts (topic_id, user_id, content) VALUES (?, ?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("iis", $topic_id, $user_id, $content);
        
        if ($stmt->execute()) {
            header("location: topic.php?id=" . $topic_id);
            exit();
        } else {
            echo "Erreur lors de l'ajout du message : " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Erreur lors de la préparation de la requête : " . $conn->error;
    }
    
    $conn->close();
}
?>

