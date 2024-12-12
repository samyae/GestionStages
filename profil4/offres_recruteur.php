<?php
session_start(); // Démarrer la session

// Vérifiez si l'id_entreprise est défini dans la session
if (isset($_SESSION['id_entreprise'])) {
    $id_entreprise = $_SESSION['id_entreprise']; // L'ID de l'entreprise liée au recruteur
} else {
    echo "Erreur : L'id de l'entreprise n'est pas défini.";
    exit;
}

// Connexion à la base de données
// $conn = new mysqli('host', 'user', 'password', 'database'); // Assurez-vous que la connexion est établie

// Requête SQL pour récupérer les offres de l'entreprise du recruteur
$sql = "SELECT o.*, e.nom_entreprise FROM offres o
        INNER JOIN entreprises e ON o.id_entreprise = e.id_entreprise
        WHERE o.id_entreprise = ? 
        ORDER BY o.date_creation DESC";

// Préparer la requête
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo "Erreur de préparation de la requête : " . $conn->error;
    exit;
}

// Lier l'ID de l'entreprise
$stmt->bind_param("i", $id_entreprise); // "i" pour un entier (ID de l'entreprise)
$stmt->execute();

// Récupérer les résultats
$result = $stmt->get_result();

// Vérifier si des offres existent
if ($result->num_rows > 0) {
    // Enregistrer les offres dans un tableau associatif
    $offres = [];
    while ($row = $result->fetch_assoc()) {
        $offres[] = $row;
    }

    // Affichage des offres
    foreach ($offres as $offre) {
        echo "Titre de l'offre : " . $offre['titre'] . "<br>";
        echo "Entreprise : " . $offre['nom_entreprise'] . "<br>";
        echo "Date de création : " . $offre['date_creation'] . "<br>";
        // Vous pouvez afficher plus de détails ici selon vos besoins
    }
} else {
    echo "Aucune offre trouvée pour cette entreprise.";
}
?>
