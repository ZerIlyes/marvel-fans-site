<?php
// config.php
define('DB_SERVER', 'db');
define('DB_USERNAME', 'marvel');
define('DB_PASSWORD', 'password');
define('DB_NAME', 'marvel_fans');

// Connexion à la base de données MySQL
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Vérifier la connexion
if($conn === false){
    die("ERREUR : Impossible de se connecter. " . $conn->connect_error);
}
?>
