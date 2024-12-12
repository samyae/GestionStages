<?php
// Inclure la connexion à la base de données
include 'db_connect.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_evaluation'])) {
    $id_evaluation = intval($_POST['id_evaluation']);

    // Préparer la mise à jour pour supprimer le message
    $sql = "UPDATE evaluations SET message = NULL WHERE id_evaluation = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_evaluation);

    // Exécuter et vérifier le résultat
    if ($stmt->execute()) {
        header("Location: profilR4.php?success=message_deleted"); // Redirection après succès
        exit;
    } else {
        echo "Erreur : " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Données invalides.";
}

$conn->close();
?>
