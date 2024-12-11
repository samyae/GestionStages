<?php
// Connexion à la base de données
$host = 'localhost'; // Hôte de la base de données
$dbname = 'gestionDeStage'; // Nom de la base de données
$username = 'root'; // Nom d'utilisateur de la base de données
$password = ''; // Mot de passe (par défaut vide pour XAMPP)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $nom = htmlspecialchars($_POST['name']);
    $poste = 'Professeur Permanent'; // Valeur fixe pour ce poste, peut être ajusté selon les besoins
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $offre_id = $_POST['offre_id']; // ID de l'offre de stage

    // Vérifier si l'ID de l'offre existe dans la table `offres`
    $stmt = $pdo->prepare("SELECT id_offre FROM offres WHERE id_offre = ?");
    $stmt->execute([$offre_id]);
    $offre = $stmt->fetch();

    // Si l'offre n'existe pas, afficher un message d'erreur et arrêter l'exécution
    if (!$offre) {
        echo "<script>alert('L\'offre de stage spécifiée n\'existe pas.');</script>";
        exit();
    }

    // Gestion du téléchargement du CV
    $cv_name = $_FILES['cv']['name'];
    $cv_tmp_name = $_FILES['cv']['tmp_name'];
    $cv_size = $_FILES['cv']['size'];
    $cv_ext = pathinfo($cv_name, PATHINFO_EXTENSION);

    // Gestion du téléchargement de la lettre de motivation
    $motivation_name = $_FILES['motivation']['name'];
    $motivation_tmp_name = $_FILES['motivation']['tmp_name'];
    $motivation_size = $_FILES['motivation']['size'];
    $motivation_ext = pathinfo($motivation_name, PATHINFO_EXTENSION);

    // Gestion de l'image
    $image_path = null;
    if (!empty($_FILES['image']['name'])) {
        $image_name = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_size = $_FILES['image']['size'];
        $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);

        $allowed_image_ext = ['jpg', 'jpeg', 'png'];
        if (!in_array($image_ext, $allowed_image_ext) || $image_size > 5 * 1024 * 1024) {
            echo "<script>alert('L\'image doit être au format JPG, JPEG ou PNG et ne pas dépasser 5 Mo.');</script>";
            exit();
        }

        // Déplacer l'image téléchargée dans le répertoire spécifique
        $image_path = $_SERVER['DOCUMENT_ROOT'] . '/gestionDeStage/uploads/images/' . time() . '_' . basename($image_name);

        // Vérifiez si le répertoire existe, sinon le créer
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/gestionDeStage/uploads/images/')) {
            if (!mkdir($_SERVER['DOCUMENT_ROOT'] . '/gestionDeStage/uploads/images/', 0777, true)) {
                echo "<script>alert('Erreur lors de la création du répertoire uploads/images.');</script>";
                exit();
            }
        }

        if (!move_uploaded_file($image_tmp_name, $image_path)) {
            echo "<script>alert('Erreur lors de l\'upload de l\'image.');</script>";
            exit();
        }
    }

    // Vérification des extensions et tailles pour le CV et la lettre de motivation
    $allowed_ext = ['pdf', 'doc', 'docx'];
    $max_size = 5 * 1024 * 1024; // 5 Mo

    if (!in_array($cv_ext, $allowed_ext) || $cv_size > $max_size || !in_array($motivation_ext, $allowed_ext) || $motivation_size > $max_size) {
        echo "<script>alert('Les fichiers doivent être au format PDF, DOC ou DOCX et chaque fichier doit être inférieur à 5 Mo.');</script>";
        exit();
    }

    // Déplacer les fichiers téléchargés dans leurs répertoires respectifs
    $cv_path = $_SERVER['DOCUMENT_ROOT'] . '/gestionDeStage/uploads/cvs/' . time() . '_' . basename($cv_name);
    $motivation_path = $_SERVER['DOCUMENT_ROOT'] . '/gestionDeStage/uploads/motivations/' . time() . '_' . basename($motivation_name);

    // Vérifiez si le répertoire `uploads/cvs/` existe, sinon le créer
    if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/gestionDeStage/uploads/cvs/')) {
        if (!mkdir($_SERVER['DOCUMENT_ROOT'] . '/gestionDeStage/uploads/cvs/', 0777, true)) {
            echo "<script>alert('Erreur lors de la création du répertoire uploads/cvs.');</script>";
            exit();
        }
    }

    // Vérifiez si le répertoire `uploads/motivations/` existe, sinon le créer
    if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/gestionDeStage/uploads/motivations/')) {
        if (!mkdir($_SERVER['DOCUMENT_ROOT'] . '/gestionDeStage/uploads/motivations/', 0777, true)) {
            echo "<script>alert('Erreur lors de la création du répertoire uploads/motivations.');</script>";
            exit();
        }
    }

    // Déplacer les fichiers dans leurs répertoires
    if (!move_uploaded_file($cv_tmp_name, $cv_path) || !move_uploaded_file($motivation_tmp_name, $motivation_path)) {
        echo "<script>alert('Erreur lors de l\'enregistrement des fichiers.');</script>";
        exit();
    }

    // Insérer les données dans la table `candidatures`
    $stmt = $pdo->prepare("
        INSERT INTO candidatures (nom_candidature, poste, email, phone, cv, motivation, image, statut, id_offre)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([$nom, $poste, $email, $phone, $cv_path, $motivation_path, $image_path, 'En attente', $offre_id]);

    echo "<script>alert('Votre candidature a été soumise avec succès.');</script>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidature - Professeur Permanent</title>
    <link rel="stylesheet" href="../style/candidateur.css">
    <!-- Ajouter Bootstrap -->
    <link href="../style/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styles additionnels */
        .form-label {
            color: #6D5B98; /* Couleur qui correspond au style global */
            font-weight: 600;
        }

        .btn-primary {
            width: 50%; /* Largeur augmentée pour plus de visibilité */
            margin: 0 auto; /* Centrage horizontal */
            display: block; /* Bloque le bouton pour qu'il occupe toute la largeur spécifiée */
            background-color: #6D5B98; /* Couleur violette pour correspondre au thème */
            border-color: #6D5B98;
        }

        .btn-primary:hover {
            background-color: #8B79DA; /* Couleur légèrement plus claire pour l'effet de survol */
            border-color: #8B79DA;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">StageNow</div>
            <ul class="nav-links">
                <li><a href="index.php">Accueil</a></li>
                <li><a href="get_offres.php">Offres de stages</a></li>
                <li><a href="profil.php">profil</a></li>
            </ul>
            <div class="auth-buttons">
                <a href="../html/inscription.html" class="btn btn-signup">
                    <i class="fas fa-user-plus"></i> Inscription
                </a>
                <a href="../html/seconnecter.html" class="btn btn-login">
                    <i class="fas fa-sign-in-alt"></i> Connexion
                </a>
            </div>
        </nav>
    </header>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Formulaire de Candidature - Professeur Permanent</h1>
        <form action="candidature.php" method="POST" enctype="multipart/form-data">
            <!-- Information Personnelle -->
            <div class="mb-3">
                <label for="name" class="form-label">Nom complet</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Numéro de téléphone</label>
                <input type="tel" class="form-control" id="phone" name="phone" required>
            </div>

            <!-- CV Upload -->
            <div class="mb-3">
                <label for="cv" class="form-label">Télécharger votre CV</label>
                <input type="file" class="form-control" id="cv" name="cv" accept=".pdf,.doc,.docx" required>
            </div>

            <!-- Lettre de motivation -->
            <div class="mb-3">
                <label for="motivation" class="form-label">Lettre de motivation</label>
                <input type="file" class="form-control" id="motivation" name="motivation" accept=".pdf,.doc,.docx" required>
            </div>

            <!-- Image (optionnel) -->
            <div class="mb-3">
                <label for="image" class="form-label">Télécharger une Image (optionnel)</label>
                <input type="file" class="form-control" id="image" name="image" accept=".jpg,.jpeg,.png">
            </div>

            <!-- Hidden input pour l'ID de l'offre -->
            <input type="hidden" name="offre_id" value='<?php echo htmlspecialchars($_GET['offre_id']);?>'/>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Soumettre ma candidature</button>
        </form>
    </div>

    <footer class="bg-dark text-white mt-5 p-4">
        <div class="footer-sections">
            <div class="about">
                <h4>À propos</h4>
                <ul>
                    <li><a href="../html/quiSommesNous.html" class="text-white">Qui sommes-nous</a></li>
                    <li><a href="../html/mission.html" class="text-white">Notre mission</a></li>
                    <li><a href="index.php#team" class="text-white">Équipe</a></li>
                </ul>
            </div>
            <div class="quick-links">
                <h4>Liens rapides</h4>
                <ul>
                    <li><a href="index.php" class="text-white">Accueil</a></li>
                    <li><a href='detail.php?id_offre=<?php echo $_GET['offre_id'];?>' class="text-white">Offres d'emploi</a></li>

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

    <!-- Ajouter Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-pzjw8f+ua7Kw1TIq0CwL5aA9h73gPMcbTKz5qyskjgWJav6P3+rIq1RfD4N8pQkA" crossorigin="anonymous"></script>
</body>
</html>
