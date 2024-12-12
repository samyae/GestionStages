<?php
// Configuration de la base de données
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'stageofppt';

// Connexion à la base de données
$conn = new mysqli($host, $user, $password, $dbname);

// Vérifiez la connexion
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}
?>