<?php
// Inclure la connexion à la base de données
require_once 'db_connect.php'; // Adapte ce chemin selon ton fichier de connexion à la base de données

// Vérifier si l'ID de la candidature est passé dans l'URL
if (isset($_GET['id_candidature'])) {
    $id_candidature = $_GET['id_candidature'];

    // Récupérer les informations actuelles de la candidature
    $sql = "SELECT * FROM candidatures WHERE id_candidature = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_candidature);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $candidature = $result->fetch_assoc();
    } else {
        echo "Candidature non trouvée.";
        exit;
    }
} else {
    echo "Aucune candidature spécifiée.";
    exit;
}
?>
