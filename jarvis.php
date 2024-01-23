<?php
// Démarrer la session PHP si ce n'est pas déjà fait
session_start();

// Intégrer le fichier de configuration pour la connexion à la base de données
require 'config.php'; // Assurez-vous que le chemin d'accès est correct

// Vérifier si l'utilisateur est connecté et récupérer son ID
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Initialiser le chemin de l'avatar
$userAvatarPath = 'public/default_avatar.png'; // Chemin par défaut de l'avatar

// Récupérer le chemin de l'avatar de l'utilisateur
if ($userId) {
    $stmt = $conn->prepare("SELECT avatar_path FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $userId); // "i" est le type pour les données integer (nombre entier)
    $stmt->execute();
    $result = $stmt->get_result();

    // Si l'utilisateur a un avatar, utiliser son chemin
    if ($user = $result->fetch_assoc()) {
        $userAvatarPath = $user['avatar_path'];
    }

    $stmt->close();
}
?>



<?php include("navbar.php"); ?> <!-- Incluez votre bar de navigation ici -->
    <link rel="stylesheet" href="jarvis_front.css">

<div class="jarvis-container">
        <h1>Jarvis AI</h1>
        <p>Votre assistant personnel basé sur GPT-4</p>
        <div id="chat-container">

            <!-- Les réponses de Jarvis apparaîtront ici -->
        </div>
        <textarea id="user-input" placeholder="Posez-moi une question..."></textarea>
        <button id="send-button">Envoyer</button>
        <script src="jarvis.js"></script>
        <script type="text/javascript">
            // Déclarer une variable JavaScript pour stocker le chemin de l'avatar de l'utilisateur
            var userAvatarPath = <?php echo json_encode($userAvatarPath); ?>;
        </script>

</div>


    <?php include("footer.php"); ?>

