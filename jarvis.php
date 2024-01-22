
    <?php include("navbar.php"); ?>
    <link rel="stylesheet" href="public/jarvis.css">
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
    <?php include("footer.php"); ?>