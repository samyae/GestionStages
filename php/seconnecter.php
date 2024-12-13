<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gestiondestage";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Vérifier si l'utilisateur est un recruteur
    $sql_recruteur = "SELECT * FROM recruteurs WHERE email = ? AND mot_de_passe = ?";
    $stmt = $conn->prepare($sql_recruteur);
    $stmt->bind_param("ss", $email, $mot_de_passe);
    $stmt->execute();
    $result_recruteur = $stmt->get_result();

    if ($result_recruteur->num_rows > 0) {
        $_SESSION['type'] = 'recruteur';
        $_SESSION['email'] = $email;
        header('Location: ../html/index.php'); // Redirection vers la page d'accueil
        exit;
    }

    // Vérifier si l'utilisateur est un chercheur
    $sql_chercheur = "SELECT * FROM chercheurs WHERE email = ? AND mot_de_passe = ?";
    $stmt = $conn->prepare($sql_chercheur);
    $stmt->bind_param("ss", $email, $mot_de_passe);
    $stmt->execute();
    $result_chercheur = $stmt->get_result();

    if ($result_chercheur->num_rows > 0) {
        $_SESSION['type'] = 'chercheur';
        $_SESSION['email'] = $email;
        header('Location: ../html/index.php'); // Redirection vers la page d'accueil
        exit;
    }

    // Si aucune correspondance
    echo "Email ou mot de passe incorrect.";
    $stmt->close();
    $conn->close();
}
?>
