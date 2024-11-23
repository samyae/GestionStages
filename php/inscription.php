<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connexion à la base de données (assurez-vous d'avoir la bonne configuration)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "stageNow";

    // Crée une connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifie la connexion
    if ($conn->connect_error) {
        die("Connexion échouée: " . $conn->connect_error);
    }

    // Récupération du type d'utilisateur
    $type = $_POST['type'];

    if ($type == 'stagiaire') {
        // Récupération des données pour le stagiaire
        $stagiaire_name = $_POST['stagiaire_name'];
        $stagiaire_email = $_POST['stagiaire_email'];
        $stagiaire_phone = $_POST['stagiaire_phone'];
        $domaine_stage = $_POST['domaine_stage'];

        // Préparez et liez la requête SQL pour le stagiaire
        $stmt = $conn->prepare("INSERT INTO stagiaire (stagiaire_name, stagiaire_email, stagiaire_phone, domaine_stage) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $stagiaire_name, $stagiaire_email, $stagiaire_phone, $domaine_stage);

        // Exécutez la requête
        if ($stmt->execute()) {
            echo "Inscription stagiaire réussie!";
        } else {
            echo "Erreur: " . $stmt->error;
        }
    } elseif ($type == 'recruteur') {
        // Récupération des données pour le recruteur
        $contact_name = $_POST['contact_name'];
        $contact_email = $_POST['contact_email'];
        $contact_phone = $_POST['contact_phone'];
        $position = $_POST['position'];

        // Préparez et liez la requête SQL pour le recruteur
        $stmt = $conn->prepare("INSERT INTO recruteurs (contact_name, contact_email, contact_phone, position) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $contact_name, $contact_email, $contact_phone, $position);

        // Exécutez la requête
        if ($stmt->execute()) {
            echo "Inscription recruteur réussie!";
        } else {
            echo "Erreur: " . $stmt->error;
        }
    }

    // Ferme la connexion
    $stmt->close();
    $conn->close();
}
?>