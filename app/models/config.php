<?php
// config.php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'rayane');
define('DB_PASSWORD', 'rayane');
define('DB_NAME', 'marvel_fans');

// Connexion à la base de données MySQL
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Vérifier la connexion
if($conn === false){
    die("ERREUR : Impossible de se connecter. " . $conn->connect_error);
}
?>
