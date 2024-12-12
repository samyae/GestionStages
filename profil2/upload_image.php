<?php
session_start();
include('db.php'); // Inclure la connexion à la base de données

// Vérifier si un fichier a été téléchargé
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    $file = $_FILES['image'];

    // Vérifier les erreurs
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo "Erreur lors du téléchargement du fichier.";
        exit;
    }

    // Définir le dossier où l'image sera téléchargée
    $uploadDir = 'uploads/images/';
    $fileName = basename($file['name']);
    $uploadFilePath = $uploadDir . $fileName;

    // Vérifier l'extension du fichier
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (!in_array($fileExtension, $allowedExtensions)) {
        echo "Extension de fichier non autorisée.";
        exit;
    }

    // Déplacer le fichier téléchargé vers le dossier approprié
    if (move_uploaded_file($file['tmp_name'], $uploadFilePath)) {
        // Mise à jour de l'image dans la base de données
        $idCandidature = $_SESSION['user_id']; // ID de l'utilisateur (peut-être à adapter)
        $sql = "UPDATE candidatures SET image = ? WHERE id_candidature = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $fileName, $idCandidature);

        if ($stmt->execute()) {
            echo "Image mise à jour avec succès.";
        } else {
            echo "Erreur lors de la mise à jour de l'image.";
        }
    } else {
        echo "Erreur lors du téléchargement du fichier.";
    }
}
?>
