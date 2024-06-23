<?php
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contact</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <h1>Contactez-nous</h1>
</header>
<main>
    <?php if (isset($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>
    <form action="index.php?action=submit_contact" method="POST">
        <label for="name">Nom :</label>
        <input type="text" id="name" name="name" required>
        <br>
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="message">Message :</label>
        <textarea id="message" name="message" required></textarea>
        <br>
        <input type="submit" value="Envoyer">
    </form>
</main>
<footer>
    <p>&copy; 2024 Fans de Comics. Tous droits réservés.</p>
</footer>
</body>
</html>

