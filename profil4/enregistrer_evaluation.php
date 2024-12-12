<?php
// Inclure la connexion à la base de données
include 'db_connect.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_evaluation'], $_POST['note'])) {
    $id_evaluation = intval($_POST['id_evaluation']);
    $note = intval($_POST['note']);

    // Vérifier que la note est entre 1 et 5
    if ($note >= 1 && $note <= 5) {
        // Préparer la mise à jour
        $sql = "UPDATE evaluations SET note = ? WHERE id_evaluation = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $note, $id_evaluation);

        // Exécuter et vérifier le résultat
        if ($stmt->execute()) {
            header("Location: profilR4.php?success=note_updated"); // Redirection après succès
            exit;
        } else {
            echo "Erreur : " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "La note doit être comprise entre 1 et 5.";
    }
} else {
    echo "Données invalides.";
}

$conn->close();
?>
