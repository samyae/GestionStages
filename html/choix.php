<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StageNow</title>
    <link rel="stylesheet" href="../style/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/choix.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="logo">StageNow</div>
        <ul class="nav-links">
            <li><a href="../html/index.html">Accueil</a></li>
            <li><a href="../html/recherche.html">Recherche</a></li>
            <li><a href="../html/offre.html">Offres de stages</a></li>
        </ul>
        <div class="auth-buttons">
            <a href="../html/choix.html" class="btn btn-signup" aria-label="Inscription">
                <i class="fas fa-user-plus"></i> Inscription
            </a>
            <a href="../html/choix.html" class="btn btn-login" aria-label="Connexion">
                <i class="fas fa-sign-in-alt"></i> Connexion
            </a>
        </div>
        
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Rejoignez-nous sur StageNow</h1>
            <p>Que vous soyez recruteur ou chercheur de stage, nous avons la solution pour vous !</p>
            <div class="hero-buttons">
                <a href="../html/inscription.html?type=recruteur" class="btn hero-btn hero-recruteur">
                    <i class="fas fa-briefcase"></i> Recruteur
                </a>
                <a href="../html/inscription.html?type=stagiaire" class="btn hero-btn hero-chercheur">
                    <i class="fas fa-user-graduate"></i> Chercheur de Stage
                </a>
            </div>
        </div>
    </section>

    <footer class="footer bg-dark text-white mt-5 p-4">
        <div class="container">
            <div class="row footer-sections">
                <!-- À propos -->
                <div class="col-md">
                    <h4>À propos</h4>
                    <ul>
                        <li><a href="../html/quiSommesNous.html" class="text-white">Qui sommes-nous</a></li>
                        <li><a href="../html/mission.html" class="text-white">Notre mission</a></li>
                        <li><a href="../html/index.html#team" class="text-white">Équipe</a></li>
                    </ul>
                </div>
    
                <!-- Liens rapides -->
                <div class="col-md">
                    <h4>Liens rapides</h4>
                    <ul>
                        <li><a href="../html/index.html" class="text-white">Accueil</a></li>
                        <li><a href="../html/offre.html" class="text-white">Offres d'emploi</a></li>
                        <li><a href="../html/faq.html" class="text-white">FAQ</a></li>
                    </ul>
                </div>
    
                <!-- Suivez-nous -->
                <div class="col-md">
                    <h4>Suivez-nous</h4>
                    <ul class="social-media">
                        <li>
                            <a href="https://www.facebook.com" target="_blank" class="text-white">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </a>
                        </li>
                        <li>
                            <a href="https://www.instagram.com" target="_blank" class="text-white">
                                <i class="fab fa-instagram"></i> Instagram
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
    
            <div class="footer-bottom text-center mt-4">
                <p>&copy; 2024 StageNow. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
    
</body>
</html>
