<?php
include 'connexion.php';

if (isset($_GET['id_notification'])) {
    $id_notification = $_GET['id_notification'];

    // Mettre à jour le statut de la notification
    $sql = "UPDATE notifications SET statut = 'Lu' WHERE id_notification = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_notification);

    if ($stmt->execute()) {
        // Rediriger vers la page précédente ou les notifications
        header("Location: notifications.php");
    } else {
        echo "Erreur lors de la mise à jour de la notification.";
    }
}
?>
