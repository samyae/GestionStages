<?php
// Paramètres de connexion
$host = 'localhost';
$dbname = 'stageofppt';
$username = 'root';
$password = '';

// Connexion à la base de données
$conn = new mysqli($host, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}
?>
