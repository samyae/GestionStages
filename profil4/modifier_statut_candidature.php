<?php
include 'db_connect.php'; // Inclure la configuration de la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_candidature = $_POST['id_candidature'];
    $statut = $_POST['statut'];

    // Vérifiez si les données sont valides
    if (!empty($id_candidature) && in_array($statut, ['En attente', 'Acceptée', 'Refusée'])) {
        // Préparation de la requête SQL avec `mysqli`
        $sql = "UPDATE candidatures SET statut = ? WHERE id_candidature = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Liaison des paramètres
            $stmt->bind_param("si", $statut, $id_candidature);

            // Exécution de la requête
            if ($stmt->execute()) {
                header("Location: voir_candidature.php?id_candidature=$id_candidature&success=1");
                exit();
            } else {
                header("Location: voir_candidature.php?id_candidature=$id_candidature&error=1");
                exit();
            }

            // Fermeture du statement
            $stmt->close();
        } else {
            header("Location: voir_candidature.php?id_candidature=$id_candidature&error=stmt");
            exit();
        }
    } else {
        header("Location: voir_candidature.php?id_candidature=$id_candidature&error=invalid");
        exit();
    }
} 