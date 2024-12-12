<?php
session_start();
include 'db_connect.php';

// Vérifier si l'utilisateur soumet le formulaire de connexion
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Requête pour vérifier les identifiants de l'utilisateur
    $sql = "SELECT * FROM candidats WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Si l'utilisateur est trouvé
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Stocker l'ID de l'utilisateur dans la session
        $_SESSION['id_candidat'] = $user['id_candidature']; // Stocker l'ID dans la session
        header("Location: profile.php"); // Rediriger vers le profil
    } else {
        echo "Identifiants incorrects.";
    }
}
?>
