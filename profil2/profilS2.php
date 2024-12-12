<?php
// Inclure la connexion
include 'db_connect.php';













// Vérifier si l'ID de la candidature est passé via l'URL
if (isset($_GET['id_candidature'])) {
    $id_candidature = $_GET['id_candidature'];

    // Requête SQL pour récupérer les informations de la candidature
    $sql = "SELECT * FROM candidatures WHERE id_candidature = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_candidature);
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérifier si la candidature existe
    if ($result->num_rows > 0) {
        $candidature = $result->fetch_assoc();
    } else {
        echo "Candidature non trouvée.";
        exit;
    }

    // Traitement de la soumission du formulaire pour changer l'image
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];

        // Vérification de l'image (extension et taille)
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

        if (in_array($image_ext, $allowed_extensions)) {
            // Générer un nouveau nom unique pour l'image
            $new_image_name = uniqid('img_') . '.' . $image_ext;
            $upload_dir = 'uploads';
            $image_path = $upload_dir . $new_image_name;

            // Déplacer l'image téléchargée dans le dossier 'uploads/images'
            if (move_uploaded_file($image_tmp, $image_path)) {
                // Mise à jour de l'image dans la base de données
                $update_sql = "UPDATE candidatures SET image = ? WHERE id_candidature = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("si", $image_path, $id_candidature);
                $update_stmt->execute();

                // Rafraîchir la page pour afficher la nouvelle image
                header("Location: profilS2.php?id_candidature=$id_candidature");
                exit;
            } else {
                echo "Échec du téléchargement de l'image.";
            }
        } 
    }
} else {
    echo "Aucune candidature spécifiée.";
    exit;
}









if (isset($_GET['id_candidature'])) {
  $id_candidature = (int) $_GET['id_candidature'];

  $sql = "SELECT nom_entreprise, texte_avis, note, date_avis 
          FROM avis 
          WHERE texte_avis IS NOT NULL AND id_candidature = ?
          ORDER BY date_avis DESC";

  $stmt = $conn->prepare($sql);

  if ($stmt === false) {
      die("Erreur dans la préparation de la requête : " . $conn->error);
  }

  $stmt->bind_param("i", $id_candidature);
  if (!$stmt->execute()) {
      die("Erreur lors de l'exécution de la requête : " . $stmt->error);
  }

  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $avis[] = $row;
      }
  } else {
      $avis = null;
  }

  $stmt->close();
} else {
  echo "Aucune candidature spécifiée.";
  exit;
}








// Vérifier si l'ID de la candidature est passé dans l'URL
if (isset($_GET['id_candidature'])) {
  $id_candidature = (int) $_GET['id_candidature'];  // Récupérer l'ID de la candidature depuis l'URL
} else {
  die("ID de candidature non spécifié.");
}

// Initialiser la variable pour stocker les avis
$avis = [];

// Modifier la requête pour récupérer les avis d'une candidature spécifique
$sql = "SELECT nom_entreprise, texte_avis, note, date_avis
      FROM avis
      WHERE id_candidature = ? AND texte_avis IS NOT NULL
      ORDER BY date_avis DESC";

// Préparer la requête SQL
$stmt = $conn->prepare($sql);
if ($stmt === false) {
  die("Erreur dans la préparation de la requête : " . $conn->error);
}

// Lier l'ID de la candidature à la requête préparée
$stmt->bind_param("i", $id_candidature);

// Exécuter la requête
$stmt->execute();
$result = $stmt->get_result();

// Débogage : vérifier si la requête a échoué
if ($result === false) {
  die("Erreur dans la requête SQL : " . $conn->error);
}

// Débogage : vérifier le nombre de résultats
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
      $avis[] = $row;
  }
} else {
  $avis = null;
}

// Fermer la requête préparée
$stmt->close();













// Vérifier si une mise à jour a été soumise
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['id_candidature'])) {
      $id_candidature = $_POST['id_candidature'];
      $nomPrenom = $_POST['nomPrenom'];
      $email = $_POST['email'];
      $telephone = $_POST['telephone'];

      // Préparer la requête SQL pour mettre à jour les informations
      $sql = "UPDATE candidatures SET nom_candidature = ?, email = ?, phone = ? WHERE id_candidature = ?";
      $stmt = $conn->prepare($sql);

      // Vérifier si la requête a été correctement préparée
      if ($stmt === false) {
          die('Erreur de préparation de la requête SQL : ' . $conn->error);
      }

      // Lier les paramètres et exécuter la requête
      $stmt->bind_param("sssi", $nomPrenom, $email, $telephone, $id_candidature);
      $stmt->execute();

      // Rediriger vers la même page pour afficher les modifications
      header("Location: profilS2.php?id_candidature=$id_candidature");
      exit;
  }
}






// Récupérer l'ID de la candidature dynamiquement depuis l'URL ou une autre source
$id_candidature = isset($_GET['id_candidature']) ? (int)$_GET['id_candidature'] : null;

if ($id_candidature !== null) {
    // Requête SQL pour récupérer les candidatures pour un id_candidature spécifique
    $sql = "SELECT c.id_candidature, c.nom_candidature, c.statut, o.titre AS offre, e.nom_entreprise 
            FROM candidatures c
            INNER JOIN offres o ON c.id_offre = o.id_offre
            INNER JOIN entreprises e ON o.id_entreprise = e.id_entreprise
            WHERE c.id_candidature = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_candidature);
    $stmt->execute();
    $result = $stmt->get_result();

    // Stocker les résultats dans un tableau
    $candidatures = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $candidatures[] = $row;
        }
    }
} else {
    $candidatures = null; // Aucun ID de candidature fourni
}










// Fermer la connexion
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil Stagiaire</title>
  
  <!-- Liens vers les fichiers CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="profilS2.css" >

</head>
<body>
  <header>
    <nav class="navbar">
        <div class="logo-container">
            <img src="logo.png" alt="Logo" class="logo-img" width="90">
            <div class="logo-text">StageNow</div>
        </div>
        <ul class="nav-links">
            <li><a href="../html/index.html">Accueil</a></li>
            <li><a href="../html/recherche.html">Recherche</a></li>
            <li><a href="../html/offre.html">Offres de stages</a></li>
        </ul>
        <div class="auth-buttons">
            <a href="../html/choix.html" class="btn btn-signup">
                <i class="fas fa-user-plus"></i> Inscription
            </a>
            <a href="../html/choix.html" class="btn btn-login">
                <i class="fas fa-sign-in-alt"></i> Connexion
            </a>
        </div>
        <div class="menu-toggle">☰</div>
    </nav>
</header>
<!-- Profile Header -->
<div class="container my-4">
  <div class="profile-header text-center">
    <!-- Vérification de l'image -->
    <?php if (!empty($candidature['image']) && file_exists($candidature['image'])) : ?>
      <img src="<?php echo htmlspecialchars($candidature['image']); ?>" alt="Profile Picture" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
    <?php else : ?>
      <img src="https://via.placeholder.com/120" alt="Profile Picture" class="rounded-circle mb-3" width="150">
    <?php endif; ?>

    <!-- Affichage du nom et du poste -->
    <h2 class="card-title"><?php echo htmlspecialchars($candidature['nom_candidature']); ?></h2>
    <p class="text"><?php echo htmlspecialchars($candidature['poste']); ?></p>

    <!-- Bouton pour modifier l'image -->
    <form action="" method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <input type="file" id="inputImageFile" name="image" accept="image/*" class="form-control">
      </div>
      <button type="submit" class="btn btn-warning">Modifier l'image</button>
    </form>
  </div>
</div>









            <!-- Modal pour modifier le logo -->
            <div class="modal fade" id="modifierLogoModal" tabindex="-1" aria-labelledby="modifierLogoLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modifierLogoLabel">Modifier le Logo</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="modifier_logo.php" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="logoFile" class="form-label">Télécharger un nouveau logo</label>
                                    <input type="file" class="form-control" id="logoFile" name="logoFile" accept="image/*" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                    $('#modifierLogoForm').submit(function(e) {
    e.preventDefault(); // Empêche la soumission normale du formulaire
    let formData = new FormData(this); // Crée un objet FormData avec le fichier

    $.ajax({
        url: 'modifier_logo.php', // Le fichier PHP qui traitera le téléchargement
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            let data = JSON.parse(response);
            if (data.success) {
                // Mettre à jour l'image dans la page
                $('img#logoImage').attr('src', data.imageSrc);
                alert('Logo modifié avec succès!');
                $('#modifierLogoModal').modal('hide'); // Fermer le modal
            } else {
                alert('Erreur: ' + data.message);
            }
        },
        error: function(xhr, status, error) {
            alert('Une erreur s\'est produite');
        }
    });
});





                </script>

<!-- Informations Stagiaire -->
<div class="container my-5">
  <div class="card shadow-sm">
    <div class="card-body">
      <h5 class="card-title">Modifier les informations</h5>
      <form action="update_candidature.php?id_candidature=1" method="POST" enctype="multipart/form-data">
  <div class="mb-3">
    <label for="inputNomPrenom" class="form-label">Nom Prénom</label>
    <input type="text" class="form-control" id="inputNomPrenom" name="nomPrenom" placeholder="Entrez votre nom et prénom" value="<?php echo htmlspecialchars($candidature['nom_candidature']); ?>" disabled>
  </div>
  <div class="mb-3">
    <label for="inputEmail" class="form-label">Email</label>
    <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Entrez votre email" value="<?php echo htmlspecialchars($candidature['email']); ?>" disabled>
  </div>
  <div class="mb-3">
    <label for="inputTelephone" class="form-label">Numéro de Téléphone</label>
    <input type="tel" class="form-control" id="inputTelephone" name="telephone" placeholder="Entrez votre numéro de téléphone" value="<?php echo htmlspecialchars($candidature['phone']); ?>" disabled>
  </div>

  <!-- Bouton pour ouvrir le modal -->
<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal">
  Modifier les informations
</button>
</form>


    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Modifier les informations du stagiaire</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id_candidature" value="<?php echo $candidature['id_candidature']; ?>">
          <div class="mb-3">
            <label for="inputNomPrenom" class="form-label">Nom Prénom</label>
            <input type="text" class="form-control" id="inputNomPrenom" name="nomPrenom" 
                   value="<?php echo htmlspecialchars($candidature['nom_candidature']); ?>" required>
          </div>
          <div class="mb-3">
            <label for="inputEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="inputEmail" name="email" 
                   value="<?php echo htmlspecialchars($candidature['email']); ?>" required>
          </div>
          <div class="mb-3">
            <label for="inputTelephone" class="form-label">Numéro de Téléphone</label>
            <input type="tel" class="form-control" id="inputTelephone" name="telephone" 
                   value="<?php echo htmlspecialchars($candidature['phone']); ?>" required>
          </div>


          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-primary">Modifier</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>














  
  <!-- Profile Details -->
  <div class="container">

      


<!-- Avis des Recruteurs -->

<div class="col-lg-12">
  <div class="card shadow-sm">
    <div class="card-body">
      <h5 class="card-title">Avis des Recruteurs</h5>
      <?php if ($avis): ?>
        <?php foreach ($avis as $avis_recruteur): ?>
          <blockquote class="blockquote">
            <p>"<?php echo htmlspecialchars($avis_recruteur['texte_avis']); ?>"</p>
            <footer class="blockquote-footer">
              Recruteur de <cite title="Source Title"><?php echo htmlspecialchars($avis_recruteur['nom_entreprise']); ?></cite>
              <br>
              <!-- Affichage de la note -->
             Votre note est <span class="badge bg-secondary"><?php echo htmlspecialchars($avis_recruteur['note']); ?>/5</span>
            </footer>
          </blockquote>
        <?php endforeach; ?>
      <?php else: ?>
        <p>Aucun avis disponible pour le moment.</p>
      <?php endif; ?>
    </div>
  </div>
</div>



<!-- Applications Status -->
<div class="col-lg-12">
  <div class="card shadow-sm">
    <div class="card-body">
      <h5 class="card-title">Candidatures</h5>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Offre</th>
            <th>Entreprise</th>
            <th>Statut</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($candidatures): ?>
            <?php foreach ($candidatures as $candidature): ?>
              <tr>
                <td><?php echo htmlspecialchars($candidature['offre']); ?></td>
                <td><?php echo htmlspecialchars($candidature['nom_entreprise']); ?></td>
                <td>
                  <?php
                  $badgeClass = '';
                  switch ($candidature['statut']) {
                    case 'Acceptée':
                      $badgeClass = 'badge-status-success';
                      break;
                    case 'Refusée':
                      $badgeClass = 'badge-status-danger';
                      break;
                    case 'En attente':
                    default:
                      $badgeClass = 'badge-status-warning';
                      break;
                  }
                  ?>
                  <span class="badge badge-status <?php echo $badgeClass; ?>">
                    <?php echo htmlspecialchars($candidature['statut']); ?>
                  </span>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="3">Aucune candidature trouvée.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
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
  <!-- Liens vers les fichiers JavaScript -->
<script src="profilS2.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <!-- Lien vers Font Awesome pour les icônes -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</body>
</html>