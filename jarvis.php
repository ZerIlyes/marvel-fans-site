<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include("navbar.php"); ?> <!-- Incluez votre bar de navigation ici -->
    <meta charset="UTF-8">
    <title>Jarvis AI - Votre Assistant Virtuel</title>
    <!-- Inclure votre fichier CSS ici -->
    <link rel="stylesheet" href="public/jarvis.css">
</head>
<body>
<div class="jarvis-container">
    <h1>Jarvis AI</h1>
    <p>Votre assistant personnel basé sur GPT-4</p>
    <div id="chat-container">
        <p id="jarvis-response"></p>
    </div>
    <textarea id="user-input" placeholder="Posez-moi une question..."></textarea>
    <button id="send-button">Envoyer</button>

</div>

    <!-- Inclure votre fichier JavaScript ici -->
    <script src="public/jarvis.js"></script>
</body>
</html>

