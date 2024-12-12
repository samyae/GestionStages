<?php
// Inclure la connexion à la base de données
include 'db_connect.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_evaluation'], $_POST['message'])) {
    $id_evaluation = intval($_POST['id_evaluation']);
    $message = htmlspecialchars(trim($_POST['message'])); // Protéger contre les XSS

    // Préparer la mise à jour
    $sql = "UPDATE evaluations SET message = ? WHERE id_evaluation = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $message, $id_evaluation);

    // Exécuter et vérifier le résultat
    if ($stmt->execute()) {
        header("Location: profilR4.php"); // Redirection après succès
        exit;
    }
    $stmt->close();
} else {
    echo "Données invalides.";
}

$conn->close();
?>
