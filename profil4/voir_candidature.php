<?php
// Connexion à la base de données (Assurez-vous de remplacer les informations par vos propres informations)
include 'db_connect.php';

// Vérifier si l'ID de la candidature est passé via l'URL
if (isset($_GET['id_candidature'])) {
    $id_candidature = $_GET['id_candidature'];

    // Préparer la requête pour récupérer les détails de la candidature
    $sql = "SELECT * FROM candidatures WHERE id_candidature = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_candidature);
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérifier si la candidature existe
    if ($result->num_rows > 0) {
        $candidature = $result->fetch_assoc();
    } else {
        echo "<div class='container'><p>La candidature n'existe pas.</p></div>";
        exit;
    }
} else {
    echo "<div class='container'><p>Aucune candidature spécifiée.</p></div>";
    exit;
}
?>

<!-- Affichage des détails de la candidature -->
<div class="container">
    <h2>Détails de la candidature</h2>
    <div class="details">
        <p><strong>Nom :</strong> <?php echo htmlspecialchars($candidature['nom_candidature']); ?></p>
        <p><strong>Poste :</strong> <?php echo htmlspecialchars($candidature['poste']); ?></p>
        <p><strong>Email :</strong> <?php echo htmlspecialchars($candidature['email']); ?></p>
        <p><strong>Téléphone :</strong> <?php echo htmlspecialchars($candidature['phone']); ?></p>
        <p><strong>Motivation :</strong> <?php echo nl2br(htmlspecialchars($candidature['motivation'])); ?></p>
        <p><strong>Date de candidature :</strong> <?php echo date("d M Y", strtotime($candidature['date_candidature'])); ?></p>
    </div>

    <?php if (!empty($candidature['cv'])) { ?>
    <div class="cv-display">
        <p><strong>CV :</strong></p>
        <?php
        $file_extension = strtolower(pathinfo($candidature['cv'], PATHINFO_EXTENSION));

        if ($file_extension === 'pdf') {
            echo '<iframe src="uploads' . htmlspecialchars($candidature['cv']) . '" width="100%" height="500px"></iframe>';
        } elseif (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo '<img src="uploads' . htmlspecialchars($candidature['cv']) . '" alt="CV de ' . htmlspecialchars($candidature['nom_candidature']) . '" />';
        } else {
            echo "<p>Le fichier n'est pas un PDF ou une image compatible.</p>";
        }
        ?>
    </div>
    <?php } else { ?>
    <p>Le CV n'est pas disponible.</p>
    <?php } ?>



    <a href="javascript:history.back()" class="btn-back">Retour</a>
</div>
<style>
body {
        font-family: 'Roboto', sans-serif;
        background-color: #f3f0ff;
        padding: 20px;
    }
    .container {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 40px;
        margin: 20px auto;
        max-width: 750px;
        border: 2px solid #8e44ad;
    }
    h2 {
        font-size: 26px;
        color: #8e44ad;
        text-align: center;
        margin-bottom: 25px;
        font-weight: bold;
    }
    .details p {
        font-size: 18px;
        color: #333333;
        margin-bottom: 15px;
    }
    .details p strong {
        color: #8e44ad;
    }
    .cv-display {
        margin-top: 30px;
    }
    iframe {
        border-radius: 10px;
        border: 1px solid #f39c12;
    }
    img {
        border-radius: 10px;
        max-width: 100%;
        height: auto;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .alert {
        font-size: 16px;
        margin-top: 25px;
    }
    .btn-back {
        margin-top: 30px;
        display: inline-block;
        text-align: center;
        font-size: 16px;
        color: #ffffff;
        background-color: #f39c12;
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }
    .btn-back:hover {
        background-color: #d35400;
    }
</style>
