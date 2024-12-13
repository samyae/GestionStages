<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "stageofppt";

    // Créer une connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Connexion échouée: " . $conn->connect_error);
    }

    // Récupération du type d'utilisateur
    $type = $_POST['type'];

    if ($type == 'stagiaire') {
        // Récupération des données pour le stagiaire
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $mot_de_passe = $_POST['mot_de_passe'];
        $telephone = $_POST['telephone'];
        $ville = $_POST['ville'];

        // Préparer et exécuter la requête SQL pour le stagiaire
        $stmt = $conn->prepare("INSERT INTO chercheurs (nom, prenom, email, mot_de_passe, telephone, ville) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $nom, $prenom, $email, $mot_de_passe, $telephone, $ville);

        if ($stmt->execute()) {
            // Récupérez l'ID de la candidature (si votre table utilise AUTO_INCREMENT)
            $id_candidature = $stmt->insert_id;

            // Stockez les informations nécessaires dans les variables de session
            session_start();
            $_SESSION['user_id'] = $id_candidature; // L'ID de la candidature
            $_SESSION['user_type'] = 'stagiaire'; // Spécifiez le type d'utilisateur (ici, 'stagiaire')
            $_SESSION['id_candidature'] = $id_candidature; // L'ID de la candidature

            // Redirigez vers la page d'accueil avec l'ID de candidature dans l'URL
            header("Location: ../html/index.php?id_candidature=" . htmlspecialchars($id_candidature));
            exit; // Arrêtez l'exécution après la redirection
        } else {
            echo "Erreur: " . $stmt->error;
        }

        $stmt->close();
    } elseif ($type == 'recruteur') {
        // Vérification si le formulaire a été soumis et si l'image a été téléchargée
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Récupération du fichier et définition du chemin d'upload
            $image = $_FILES['image']['name'];
            $image_tmp = $_FILES['image']['tmp_name'];
            $image_path = "../uploads/imagesEntreprise/" . basename($image);  // Chemin d'upload correct
        
            // Vérification de l'upload et déplacement du fichier
            if (move_uploaded_file($image_tmp, $image_path)) {
                echo "Image téléchargée avec succès!";
            } else {
                die("Erreur lors du téléchargement de l'image.");
            }
        } else {
            die("Aucune image téléchargée ou une erreur s'est produite lors du téléchargement.");
        }
        
        // Récupérer les autres données du formulaire
        $nom_entreprise = $_POST['nom_entreprise'];
        $secteur = $_POST['secteur'];
        $taille = intval($_POST['taille']);
        $localisation = $_POST['localisation'];
        $telephone = $_POST['telephone'];
        $email = $_POST['email'];
        $date_creation = $_POST['date_creation'];

        // Préparer la requête d'insertion pour l'entreprise
        $stmt = $conn->prepare("INSERT INTO entreprises (nom_entreprise, secteur, taille, localisation, telephone, email, image, date_creation) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisssss", $nom_entreprise, $secteur, $taille, $localisation, $telephone, $email, $image_path, $date_creation);

        if ($stmt->execute()) {
            $id_entreprise = $conn->insert_id; // Récupérer l'ID de l'entreprise insérée

            // Récupérer les données pour le recruteur
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $adresse = $_POST['adresse'];
            $mot_de_passe = $_POST['mot_de_passe'];

            // Préparer et exécuter la requête pour le recruteur
            $stmt = $conn->prepare("INSERT INTO recruteurs (nom, prenom, adresse, email, mot_de_passe, telephone, id_entreprise) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssi", $nom, $prenom, $adresse, $email, $mot_de_passe, $telephone, $id_entreprise);

            if ($stmt->execute()) {
                // Démarrer une session pour gérer la connexion de l'utilisateur
                session_start();
                $_SESSION['user_id'] = $conn->insert_id; // ID du recruteur
                $_SESSION['user_type'] = 'recruteur';
                $_SESSION['user_name'] = $nom; // Nom du recruteur (optionnel)
            
                // Récupérer l'ID de l'entreprise
                $id_entreprise = $id_entreprise; // Assurez-vous que cette variable contient bien l'ID de l'entreprise
             
                // Redirection vers la page de profil
                header("Location: ../html/index.php?id_entreprise=" . $id_entreprise);
                exit();
            } else {
                echo "Erreur lors de l'inscription : " . $stmt->error;
            }
        }            

        $stmt->close();
    }

    // Fermer la connexion
    $conn->close();
}
?>     
