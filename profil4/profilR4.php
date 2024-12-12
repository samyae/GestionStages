<?php
include 'db_connect.php';

// Récupérer les informations de l'entreprise
function getEntrepriseById($conn, $id_entreprise) {
    $sql = "SELECT * FROM entreprises WHERE id_entreprise = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_entreprise);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Récupérer les offres d'une entreprise
function getOffresByEntrepriseId($conn, $id_entreprise) {
    $sql = "SELECT e.nom_entreprise, o.* 
            FROM entreprises e
            LEFT JOIN offres o ON e.id_entreprise = o.id_entreprise
            WHERE e.id_entreprise = ?
            ORDER BY o.date_creation DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_entreprise);
    $stmt->execute();
    $result = $stmt->get_result();
    $offres = [];
    while ($row = $result->fetch_assoc()) {
        $offres[] = $row;
    }
    return $offres;
}

// ID à récupérer
$id_entreprise = $_GET['id_entreprise'] ?? null;

// Si l'ID est manquant, on affiche une erreur (sans tuer le script avec die)
if (!$id_entreprise) {
    echo "ID d'entreprise manquant.";
    exit;
}

$entreprise = getEntrepriseById($conn, $id_entreprise);
if (!$entreprise) {
    echo "Aucune entreprise trouvée.";
    exit;
}

$offres = getOffresByEntrepriseId($conn, $id_entreprise);

// Traitement de la mise à jour
$updateMessage = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données soumises
    $nom_entreprise = $_POST['nom_entreprise'];
    $secteur = $_POST['secteur'];
    $taille = $_POST['taille'];
    $localisation = $_POST['localisation'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email']; // L'email ne change pas

    // Requête pour mettre à jour les informations de l'entreprise
    $sql = "UPDATE entreprises SET 
            nom_entreprise = ?, 
            secteur = ?, 
            taille = ?, 
            localisation = ?, 
            telephone = ?
            WHERE id_entreprise = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Lier les paramètres
        $stmt->bind_param("sssssi", $nom_entreprise, $secteur, $taille, $localisation, $telephone, $id_entreprise);

        // Exécuter la requête
        if ($stmt->execute()) {
            $updateMessage = "Les informations ont été mises à jour avec succès.";
        } else {
            $updateMessage = "Erreur lors de la mise à jour des informations.";
        }

        // Fermer la requête
        $stmt->close();
    } else {
        $updateMessage = "Erreur lors de la préparation de la requête : " . $conn->error;
    }
}












// Vérifiez que l'ID de l'entreprise est bien passé
$id_entreprise = $_GET['id_entreprise']; // Ou récupérez-le d'une autre manière (par exemple session)

// Vérifiez que la connexion à la base de données est établie
if (!$conn) {
    die("Connexion échouée: " . mysqli_connect_error());
}

// Requête pour récupérer les candidatures de l'entreprise selon l'id
$sql = "SELECT * FROM candidatures WHERE id_entreprise = ?";

// Préparer la requête
$stmt = $conn->prepare($sql);

// Vérifiez si la préparation a échoué
if ($stmt === false) {
    die("Erreur de préparation de la requête : " . $conn->error);
}

// Lier les paramètres
$stmt->bind_param("i", $id_entreprise); // 'i' pour un entier (id_entreprise est un entier dans la base)

$stmt->execute();
$result = $stmt->get_result();

// Vérifiez si des candidatures existent
if ($result->num_rows > 0) {
    // Stocker les candidatures dans un tableau
    $candidatures = [];
    while ($row = $result->fetch_assoc()) {
        $candidatures[] = $row;
    }
} else {
    $candidatures = []; // Aucun résultat trouvé
}





    






// Vérifiez que l'ID de l'entreprise est bien passé
$id_entreprise = $_GET['id_entreprise']; // Ou récupérez-le d'une autre manière (par exemple session)

// Vérifiez que la connexion à la base de données est établie
if (!$conn) {
    die("Connexion échouée: " . mysqli_connect_error());
}

// Requête pour récupérer les évaluations de l'entreprise
$sql = "SELECT * FROM evaluations WHERE id_entreprise = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_entreprise);
$stmt->execute();
$result = $stmt->get_result();

// Vérifier si des évaluations existent
if ($result->num_rows > 0) {
    $evaluations = $result->fetch_all(MYSQLI_ASSOC);
} 





// Vérifiez que l'ID de l'entreprise est bien passé
$id_entreprise = $_GET['id_entreprise']; // Ou récupérez-le d'une autre manière (par exemple session)

// Vérifiez que la connexion à la base de données est établie
if (!$conn) {
    die("Connexion échouée: " . mysqli_connect_error());
}
// Requête SQL pour récupérer les notifications de l'entreprise
$sql = "SELECT * FROM notifications WHERE id_entreprise = ? ORDER BY date_creation DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_entreprise);
$stmt->execute();
$result = $stmt->get_result();

// Stocker les notifications dans un tableau
$notifications = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }
} 





?>






<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Recruteur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="styleR.css">

</head>
<body>
    <!-- En-tête -->
    <header>
        <nav class="navbar">
            <div class="logo-container">
                <img src="logo.png" alt="Logo" class="logo-img" width="100px">
                <div class="logo-text">StageNow</div>
            </div>
            <ul class="nav-links">
                <li><a href="../html/index.html">Accueil</a></li>
                <li><a href="../html/recherche.html">Recherche</a></li>
                <li><a href="../html/offre.html">Offres de stages</a></li>
            </ul>
            <div class="auth-buttons">
                <a href="../html/choix.html" class="btn btn-signup"><i class="fas fa-user-plus"></i> Inscription</a>
                <a href="../html/choix.html" class="btn btn-login"><i class="fas fa-sign-in-alt"></i> Connexion</a>
            </div>
            <div class="menu-toggle">☰</div>
        </nav>
    </header>

    <!-- Conteneur principal -->
    <div class="container mt-4">
        <!-- En-tête du Profil -->
        <div class="profile-header text-center">
        <div class="text-center me-4">
            <!-- Logo de l'entreprise -->
            <img id="logoImage" src="<?= !empty($entreprise['image']) ? $entreprise['image'] : 'https://via.placeholder.com/120' ?>" alt="Logo de l'entreprise" class="rounded-circle" width="150" style="width: 150px; height: 150px; object-fit: cover;">
        
        <h2><?= htmlspecialchars($entreprise['nom_entreprise']) ?></h2>
  
        </div>
        </div>
        <!-- Navigation des onglets -->
        <ul class="nav nav-tabs mt-4" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="profil-tab" data-bs-toggle="tab" href="#profil" role="tab" aria-controls="profil" aria-selected="true"><i class="bi bi-person"></i> Profil</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="offres-tab" data-bs-toggle="tab" href="#offres" role="tab" aria-controls="offres" aria-selected="false"><i class="bi bi-briefcase"></i> Offres publiées</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="candidatures-tab" data-bs-toggle="tab" href="#candidatures" role="tab" aria-controls="candidatures" aria-selected="false"><i class="bi bi-file-person"></i> Candidatures</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="evaluations-tab" data-bs-toggle="tab" href="#evaluations" role="tab" aria-controls="evaluations" aria-selected="false"><i class="bi bi-star"></i> Évaluations</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="notifications-tab" data-bs-toggle="tab" href="#notifications" role="tab" aria-controls="notifications" aria-selected="false"><i class="bi bi-bell"></i> Notifications</a>
            </li>
        </ul>

        <!-- Contenu des onglets -->
        <div class="tab-content mt-4" id="myTabContent">
            <!-- Profil -->
            <div class="tab-pane fade show active" id="profil" role="tabpanel" aria-labelledby="profil-tab">
                <div class="row justify-content-center">
                    <!-- Carte du profil de l'entreprise -->
<!-- Carte des informations de l'entreprise -->
<div class="col-md-6 mb-3">
<h4><i class="bi bi bi-person"></i> Profil</h4>
    <div class="d-flex align-items-start">
    

        <div class="card shadow-sm" id="entrepriseCard" style="width: 100%;">
        
            <div class="card-body">
                <h4 class="card-title text-center mb-4"><strong>Informations de l'entreprise</strong></h4>
                
                <div class="mb-3">
                    <p><strong>Nom de l'entreprise:</strong> <?= htmlspecialchars($entreprise['nom_entreprise']) ?></p>
                </div>

                <div class="mb-3">
                    <p><strong>Secteur d'activité:</strong> <?= htmlspecialchars($entreprise['secteur'] ?? 'Non spécifié') ?></p>
                </div>

                <div class="mb-3">
                    <p><strong>Taille de l'entreprise:</strong> <?= htmlspecialchars($entreprise['taille'] ?? 'Non spécifiée') ?> employés</p>
                </div>

                <div class="mb-3">
                    <p><strong>Localisation:</strong> <?= htmlspecialchars($entreprise['localisation'] ?? 'Non spécifiée') ?></p>
                </div>

                <div class="mb-3">
                    <p><strong>Téléphone:</strong> <?= htmlspecialchars($entreprise['telephone'] ?? 'Non spécifié') ?></p>
                </div>

                <div class="mb-3">
                    <p><strong>Email:</strong> <?= htmlspecialchars($entreprise['email'] ?? 'Non spécifié') ?></p>
                </div>

                <!-- Bouton pour modifier les informations -->
                <div class="text-center mt-4">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modifierEntrepriseModal">Modifier les informations</button>
                </div>
            </div>
        </div>
    </div>




</div>


                </div>
            </div>










            <!-- Offres publiées -->
            <div class="tab-pane fade" id="offres" role="tabpanel" aria-labelledby="offres-tab">
                <div class="section">
                    <h4><i class="bi bi-briefcase-fill"></i> Offres en ligne</h4>
                    <ul class="list-group">
                        <?php
                        if (!empty($offres)) {
                            foreach ($offres as $offre) {
                                $id_offre = $offre['id_offre'];
                                $titre = $offre['titre'];
                                $date_publication = $offre['date_creation'];
                                $lieu = $offre['ville'];
                                $nom_entreprise = $offre['nom_entreprise'];
                                ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5><?php echo htmlspecialchars($titre); ?></h5>
                                        <p class="mb-1"><strong>Date de publication:</strong> <?php echo date("d M Y", strtotime($date_publication)); ?></p>
                                        <p><strong>Lieu:</strong> <?php echo htmlspecialchars($lieu); ?></p>
                                        <p><strong>Entreprise:</strong> <?php echo htmlspecialchars($nom_entreprise); ?></p>
                                    </div>
                                    <div>
                                        <form action="supprimer_offre.php" method="POST" class="d-inline">
                                        <input type="hidden" name="id_entreprise" value="<?php echo $id_entreprise; ?>"> <!-- Utiliser l'ID de l'entreprise -->
                                     
                                            
                                          
                                        </form>
                                    </div>
                                </li>
                                <?php
                            }
                        } else {
                            echo "<li class='list-group-item'>Aucune offre publiée.</li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>

<!-- Candidatures -->
<div class="tab-pane fade" id="candidatures" role="tabpanel" aria-labelledby="candidatures-tab">
    <div class="section">
        <h4><i class="bi bi-person-lines-fill"></i> Candidatures reçues</h4>
        <ul class="list-group">
            <?php
            if (!empty($candidatures)) {
                foreach ($candidatures as $candidature) {
                    $nom = $candidature['nom_candidature'];
                    $poste = $candidature['poste'];
                    $date_candidature = $candidature['date_candidature'];
                    $statut = $candidature['statut'];
                    $id_candidature = $candidature['id_candidature'];
                    ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h5><?php echo htmlspecialchars($nom); ?></h5>
                            <p class="mb-1"><strong>Poste:</strong> <?php echo htmlspecialchars($poste); ?></p>
                            <p><strong>Date de la candidature:</strong> <?php echo date("d M Y", strtotime($date_candidature)); ?></p>
                            <p><strong>Statut:</strong> <?php echo htmlspecialchars($statut); ?></p>
                        </div>
                        <div>
                            <a href="voir_candidature.php?id_candidature=<?php echo $id_candidature; ?>" class="btn btn-primary">Voir</a>
                            
                                <input type="hidden" name="id_candidature" value="<?php echo $id_candidature; ?>">
                                
                            </form>
                            <form action="modifier_statut_candidature.php" method="POST" class="d-inline">
                                <input type="hidden" name="id_candidature" value="<?php echo $id_candidature; ?>">
                                <label for="statut-<?php echo $id_candidature; ?>"><strong>Statut:</strong></label>
                                <select name="statut" id="statut-<?php echo $id_candidature; ?>" class="form-select d-inline w-auto">
                                    <option value="En attente" <?php if ($statut == 'En attente') echo 'selected'; ?>>En attente</option>
                                    <option value="Acceptée" <?php if ($statut == 'Acceptée') echo 'selected'; ?>>Acceptée</option>
                                    <option value="Refusée" <?php if ($statut == 'Refusée') echo 'selected'; ?>>Refusée</option>
                                </select>
                                <button type="submit" class="btn btn-success mt-2">Enregistrer</button>
                            </form>
                        </div>
                    </li>
                    <?php
                }
            } else {
                // Message lorsque la liste des candidatures est vide
                echo "<li class='list-group-item text-center'>Aucune candidature reçue.</li>";
            }
            ?>
        </ul>
    </div>
</div>






         




<!-- Affichage des évaluations -->
<div class="tab-pane fade" id="evaluations" role="tabpanel" aria-labelledby="evaluations-tab">
    <div class="section">
        <h4><i class="bi bi bi-star"></i> Evaluation</h4>
        <ul class="list-group">
            <?php
            // Vérifier si des évaluations existent
            if (empty($evaluations)) {
                echo '<li class="list-group-item">Pas d\'évaluation disponible.</li>';
            } else {
                // Afficher chaque évaluation
                foreach ($evaluations as $evaluation) {
                    $nom = $evaluation['nom_candidature'];
                    $note = $evaluation['note'] ?? '';  // Si la note existe, l'afficher, sinon laisser vide
                    $id_evaluation = $evaluation['id_evaluation'];
                    $message  = $evaluation['message'] ?? '';  // Si un message existe, l'afficher, sinon laisser vide
                    ?>
                    <li class="list-group-item">
                        <h5><?php echo htmlspecialchars($nom); ?></h5>
                        <p><strong>Note actuelle:</strong> <?php echo $note ? $note : 'Aucune note attribuée'; ?>/5</p>
                        
                        <!-- Formulaire de saisie de note -->
                        <form action="enregistrer_evaluation.php" method="POST" class="d-inline">
                            <input type="hidden" name="id_evaluation" value="<?php echo $id_evaluation; ?>">
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" name="note" min="1" max="5" value="<?php echo $note; ?>" placeholder="Note (1-5)" required>
                                <button type="submit" class="btn btn-success">OK</button>
                            </div>
                        </form>
                        
                        <!-- Champ de message -->
                        <form action="ajouter_commentaire.php" method="POST" class="d-inline">
                            <input type="hidden" name="id_evaluation" value="<?php echo $id_evaluation; ?>">
                            <div class="mb-3">
                                <textarea class="form-control <?php echo $success_message ? 'border-success' : ''; ?>" name="message" rows="3" placeholder="Laisser un message "><?php echo htmlspecialchars($message ); ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Enregistrer le message</button>
                        </form>

                        <!-- Formulaire de suppression du message -->
                        <form action="supprimer_message.php" method="POST" class="d-inline">
                            <input type="hidden" name="id_evaluation" value="<?php echo $id_evaluation; ?>">
                            <button type="submit" class="btn btn-danger">Supprimer le message</button>
                        </form>

                    </li>
                <?php
                }
            }
            ?>
        </ul>
    </div>
</div>









<!-- Notifications -->
<div class="tab-pane fade" id="notifications" role="tabpanel" aria-labelledby="notifications-tab">
    <div class="section">
    <h4><i class="bi bi-bell"></i> Notification</h4>
        <ul class="list-group">
            <?php if (!empty($notifications)) : ?>
                <?php foreach ($notifications as $notification) : ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <p><?php echo htmlspecialchars($notification['message']); ?></p>
                            <small class="text-muted">
                                <?php echo date("d M Y H:i", strtotime($notification['date_creation'])); ?>
                            </small>
                        </div>
                        <div>
                            <?php if ($notification['statut'] === 'Non lu') : ?>
                                <span class="badge bg-warning">Non lu</span>
                            <?php else : ?>
                                <span class="badge bg-success">Lu</span>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else : ?>
                <li class="list-group-item">Aucune notification.</li>
            <?php endif; ?>
        </ul>
    </div>
</div>
        </div>
    </div>






<!-- Modal Modifier Entreprise -->
<div class="modal fade" id="modifierEntrepriseModal" tabindex="-1" aria-labelledby="modifierEntrepriseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modifierEntrepriseModalLabel">Modifier Entreprise</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulaire pour modifier les informations de l'entreprise -->
                <form method="POST" action="profilR4.php?id_entreprise=<?= htmlspecialchars($id_entreprise) ?>">
            <input type="hidden" name="id_entreprise" value="<?= htmlspecialchars($entreprise['id_entreprise']) ?>">

            <div class="mb-3">
                <label for="nomEntreprise" class="form-label">Nom de l'entreprise</label>
                <input type="text" class="form-control" id="nomEntreprise" name="nom_entreprise" value="<?= htmlspecialchars($entreprise['nom_entreprise']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="secteurEntreprise" class="form-label">Secteur</label>
                <input type="text" class="form-control" id="secteurEntreprise" name="secteur" value="<?= htmlspecialchars($entreprise['secteur']) ?>" required>
            </div>
            <div class="mb-3">
            <label for="tailleEntreprise" class="form-label">Taille</label>
                <input type="text" class="form-control" id="tailleEntreprise" name="taille" value="<?= htmlspecialchars($entreprise['taille']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="localisationEntreprise" class="form-label">Localisation</label>
                <input type="text" class="form-control" id="localisationEntreprise" name="localisation" value="<?= htmlspecialchars($entreprise['localisation']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="telEntreprise" class="form-label">Téléphone</label>
                <input type="text" class="form-control" id="telEntreprise" name="telephone" value="<?= htmlspecialchars($entreprise['telephone']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="emailEntreprise" class="form-label">Email</label>
                <input type="email" class="form-control" id="emailEntreprise" name="email" value="<?= htmlspecialchars($entreprise['email']) ?>" readonly>
            </div>

            <button type="submit" class="btn btn-primary">Sauvegarder</button>
        </form>

            </div>
        </div>
    </div>
</div>

  











   


    <!-- Modal Supprimer Profil -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAccountModalLabel">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer votre profil ? Cette action est irréversible.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="supprimer_profil.php" method="POST">
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>


    <footer class="bg-dark text-white mt-5 p-4">
        <div class="footer-sections">
            <div class="about">
                <h4>À propos</h4>
                <ul>
                    <li><a href="../html/quiSommesNous.html" class="text-white">Qui sommes-nous</a></li>
                    <li><a href="../html/mission.html" class="text-white">Notre mission</a></li>
                    <li><a href="../html/index.html#team" class="text-white">Équipe</a></li>
                </ul>
            </div>
            <div class="quick-links">
                <h4>Liens rapides</h4>
                <ul>
                    <li><a href="../html/index.html" class="text-white">Accueil</a></li>
                    <li><a href="../html/offre.html" class="text-white">Offres d'emploi</a></li>
                    <li><a href="../html/faq.html" class="text-white">FAQ</a></li>
                </ul>
            </div>
            <div class="social-media">
                <h4>Suivez-nous</h4>
                <ul>
                    <li><a href="https://www.facebook.com" target="_blank" class="text-white"><i class="fab fa-facebook-f"></i> Facebook</a></li>
                    <li><a href="https://www.instagram.com" target="_blank" class="text-white"><i class="fab fa-instagram"></i> Instagram</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom text-center mt-3">
            <p>&copy; 2024 MonSite. Tous droits réservés.</p>
        </div>
    </footer>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
 


<div id="updateMessage"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Écouter la soumission du formulaire
    $('#updateEntrepriseForm').on('submit', function(e) {
        e.preventDefault();  // Empêcher le rechargement de la page

        // Récupérer les données du formulaire
        var formData = $(this).serialize();

        // Envoyer la requête AJAX
        $.ajax({
            url: 'profilR4.php',  // L'URL de traitement
            type: 'POST',
            data: formData,
            success: function(response) {
                // Afficher le message de succès ou d'erreur
                $('#updateMessage').html(response);
            },
            error: function() {
                $('#updateMessage').html('<div class="alert alert-danger">Une erreur est survenue.</div>');
            }
        });
    });
});
</script>





                
</body>
</html>