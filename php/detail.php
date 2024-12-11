<?php
// Connexion à la base de données
$conn = new mysqli('localhost', 'root', '', 'gestionDeStage');
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Vérifier l'ID de l'offre passé dans l'URL
if (isset($_GET['id_offre']) && is_numeric($_GET['id_offre'])) {
    $id_offre = $_GET['id_offre'];

    // Requête pour récupérer les détails de l'offre, entreprise, recruteur et détails supplémentaires
    $query = "
    SELECT o.*, e.nom_entreprise, e.secteur, e.taille, e.localisation AS entreprise_localisation, 
    e.telephone AS entreprise_telephone, e.email AS entreprise_email, e.image AS entreprise_logo, 
    r.nom AS recruteur_nom, r.prenom AS recruteur_prenom, d.competence, d.exigence 
    FROM offres o
    LEFT JOIN entreprises e ON o.id_entreprise = e.id_entreprise
    LEFT JOIN recruteurs r ON o.id_recruteur = r.id_recruteur
    LEFT JOIN details_offres d ON o.id_offre = d.id_offre
    WHERE o.id_offre = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id_offre);
    $stmt->execute();
    $result = $stmt->get_result();
    $offre = $result->fetch_assoc();

    if (!$offre) {
        die("Offre introuvable.");
    }
} else {
    die("ID d'offre invalide.");
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'offre - <?= htmlspecialchars($offre['titre']) ?></title>
    <link rel="stylesheet" href="../style\detail.css">
    <link href="../style/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">StageNow</div>
            <ul class="nav-links">
                <li><a href="index.php">Accueil</a></li>
                <li><a href="get_offres.php">Offres de stages</a></li>
                <li><a href="profil.php" class="active">Profil</a></li>
            </ul>
            <div class="auth-buttons">
                <a href="inscription.php" class="btn btn-signup">
                    <i class="fas fa-user-plus"></i> Inscription
                </a>
                <a href="../html/seconnecter.html" class="btn btn-login">
                    <i class="fas fa-sign-in-alt"></i> Connexion
                </a>
            </div>
        </nav>
    </header>

    <section class="hero-section">
    <section class="slogans mt-5">
        <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000">
            <div class="carousel-inner">
                <!-- Slogan 1 -->
                <div class="carousel-item active">
                    <img src="../images/team-job-photo-young-businessmans-working-with-new-project-office.jpg" class="d-block w-100" alt="Slogan 1">
                </div>
                <!-- Slogan 2 -->
                <div class="carousel-item">
                    <img src="../images/people-office-working-new-project.jpg" class="d-block w-100" alt="Slogan 2">
                </div>
                <!-- Slogan 3 -->
                <div class="carousel-item">
                    <img src="../images/co-working-people-working-together.jpg" class="d-block w-100" alt="Slogan 3">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Précédent</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Suivant</span>
            </button>
        </div>
    </section>
</section>

    <div class="container mt-5">
        <div class="row">
            <!-- Première colonne (Détails de l'offre) -->
            <div class="col-lg-4 col-md-12" style="background-color: #f3f3f3; padding: 20px; border-radius: 10px;">
                <h5>Résumé du poste</h5>
                <ul>
                    <li><span style="color: #6D5B98;">Type de stage: </span> <?= htmlspecialchars($offre['type_stage']) ?></li>
                    <li><span style="color: #6D5B98;">Ville: </span> <?= htmlspecialchars($offre['ville']) ?></li>
                    <li><span style="color: #6D5B98;">Durée: </span> <?= htmlspecialchars($offre['duree']) ?> mois</li>
                    <li><span style="color: #6D5B98;">Salaire: </span> <?= htmlspecialchars($offre['salaire']) ?> €</li>
                    <li><span style="color: #6D5B98;">Type de contrat: </span> <?= htmlspecialchars($offre['contrat']) ?></li>
                    <li><span style="color: #6D5B98;">Date de début: </span> <?= htmlspecialchars($offre['date_debut']) ?></li>
                    <li><span style="color: #6D5B98;">Date de fin: </span> <?= htmlspecialchars($offre['date_fin']) ?></li>
                </ul>
                <!-- Détails de l'entreprise -->
                <h5>Entreprise</h5>
                <p>
                    <strong>
                        <?php if (!empty($offre['entreprise_logo'])): ?>
                            <!-- Afficher l'image si elle existe -->
                            <img src="../images/imagesLogo/<?= htmlspecialchars($offre['entreprise_logo']) ?>" alt="Logo de l'entreprise" style="width: 50px; height: auto; margin-right: 10px;">
                        <?php endif; ?>
                        
                    </strong>
                </p>
                <p><span style="color: #6D5B98;">le Nom de l'entreprise : </span><?= htmlspecialchars($offre['nom_entreprise']) ?></p>
                <p><span style="color: #6D5B98;">Secteur : </span><?= htmlspecialchars($offre['secteur']) ?></p>
                <p><span style="color: #6D5B98;">Localisation : </span><?= htmlspecialchars($offre['entreprise_localisation']) ?></p>
                <p><span style="color: #6D5B98;">Téléphone : </span><?= htmlspecialchars($offre['entreprise_telephone']) ?></p>
                <p><span style="color: #6D5B98;">Email: </span><?= htmlspecialchars($offre['entreprise_email']) ?></p>

                <h5>Recruteur</h5>
                <p><span style="color: #6D5B98;">Nom de recruteur : </span><?= htmlspecialchars($offre['recruteur_nom']) ?> <?= htmlspecialchars($offre['recruteur_prenom']) ?></p>
            </div>

            <!-- Deuxième colonne (Description détaillée de l'offre) -->
            <div class="col-lg-8 col-md-12">
                <section class="job-description">
                    <h5>Description de l'offre</h5>
                    <p><?= nl2br(htmlspecialchars($offre['description'])) ?></p>

                    <h5>Compétences requises</h5>
                    <p><?= htmlspecialchars($offre['competence']) ?></p>

                    <h5>Exigences</h5>
                    <p><?= htmlspecialchars($offre['exigence']) ?></p>

                    <button class="btn btn-primary" onclick="window.location.href='../php/candidature.php?offre_id=<?= $id_offre ?>';">Postuler</button>
                </section>
            </div>
        </div>
    </div>

    <footer>
    <div class="footer-sections">
        <div class="about">
            <h4>À propos</h4>
            <ul>
                <li><a href="../html/quiSommesNous.html" class="footer-link">Qui sommes-nous</a></li>
                <li><a href="../html/mission.html" class="footer-link">Notre mission</a></li>
                <li><a href="index.php#team" class="footer-link">Équipe</a></li>
            </ul>
        </div>
        <div class="quick-links">
            <h4>Liens rapides</h4>
            <ul>
                <li><a href="index.php" class="footer-link">Accueil</a></li>
                <li><a href='detail.php?id_offre=<?php echo $_GET['offre_id'];?>' class="footer-link">Offres d'emploi</a></li>
                <li><a href="../html/faq.html" class="footer-link">FAQ</a></li>
            </ul>
        </div>
        <div class="social-media">
            <h4>Suivez-nous</h4>
            <ul>
                <li><a href="https://www.facebook.com" target="_blank" class="footer-link"><i class="fab fa-facebook-f"></i> Facebook</a></li>
                <li><a href="https://www.instagram.com" target="_blank" class="footer-link"><i class="fab fa-instagram"></i> Instagram</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom text-center mt-3">
        <p>&copy; 2024 MonSite. Tous droits réservés.</p>
    </div>
</footer>
<!-- Ajoutez ceci avant la fermeture de </body> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var carousel = new bootstrap.Carousel(document.querySelector('#carouselExampleAutoplaying'), {
            interval: 2000,
            ride: 'carousel'
        });
    });
</script>

</body>
</html>
