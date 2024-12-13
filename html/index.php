


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="../style/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
    
    <title>Accueil - Site de Stage</title>


</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">StageNow</div>
            <ul class="nav-links">
                <li><a href="../html/index.html">Accueil</a></li>
                <li><?php if ($type === 'recruteurs'): ?>
                <li><a href="../html/poser_stage.html">Poser Stage</a></li>
            <?php elseif ($type === 'stagiaire'): ?>
                <li><a href="../html/choix.html">Recherche</a></li>
                <?php endif; ?></li>
                
                <li>
                <?php
                session_start();
                if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'recruteur') {
                    // Affichez un lien vers le profil avec l'ID de l'entreprise
                    $id_entreprise = $_GET['id_entreprise'] ?? ''; // Récupérer l'ID
                    echo '<a href="../profil4/profilR4.php?id_entreprise=' . htmlspecialchars($id_entreprise) . '"> Profil</a>';
                }
                ?>
                </li>
            </ul>
            <div class="auth-buttons">
                <a href="../html/choix.html" class="btn btn-signup">
                    <i class="fas fa-user-plus"></i> Inscription
                </a>
                <a href="../html/seconnecter.html" class="btn btn-login">
                    <i class="fas fa-sign-in-alt"></i> Connexion
                </a>
                <a href="../php/logout.php" class="btn btn-login">Déconnexion</a>
            </div>
            
        </nav>
    </header>

    <!-- Section avec image de fond  -->
    <section class="hero-section">
        <div class="slideshow-container">
            <div class="slides">
                <img src="../images/image1.jpg" alt="Image 1">
            </div>
            <div class="slides">
                <img src="../images/image2.jpg" alt="Image 2">
            </div>
            <div class="slides">
                <img src="../images/image3.jpg" alt="Image 3">
            </div>
        </div>
    
        <div class="hero-content">
            <h1>Trouvez le stage parfait ou recrutez le talent idéal</h1>
            <p>Explorez un monde d'opportunités pour les chercheurs de stage et les recruteurs</p>
        </div>
    </section>
    
    <!-- Section Avantages Avancée -->
<section class="advanced-features-section" id="advanced-features">
    <div class="features-content">
        <h2>Les Avantages de StageNow</h2>
        <p>Nous vous proposons une plateforme complète pour faciliter la recherche de stages et l’attraction de talents. Découvrez nos atouts !</p>
        
        <div class="feature-cards">
            <div class="feature-card">
                <i class="fas fa-briefcase"></i>
                <h3>Opportunités Variées</h3>
                <p>Explorez des offres de stage dans divers secteurs, y compris la technologie, la finance, le marketing, et bien plus encore.</p>
                <ul>
                    <li>+200 offres de stage chaque mois</li>
                    <li>Stages adaptés aux compétences de chaque candidat</li>
                    <li>Accès à des entreprises de renommée mondiale</li>
                </ul>
                <a href="../html/offre.html" class="cta-btn">Découvrir les offres</a>
            </div>
            <div class="feature-card">
                <i class="fas fa-users"></i>
                <h3>Communauté de Talents</h3>
                <p>Rejoignez une communauté active de jeunes talents et de recruteurs qui favorisent la collaboration et le développement professionnel.</p>
                <ul>
                    <li>Événements et webinaires pour les membres</li>
                    <li>Forums de discussion pour échanger avec des experts</li>
                    <li>Accès aux conseils de carrière personnalisés</li>
                </ul>
                <a href="../html/offre.html" class="cta-btn">Rejoindre la communauté</a>
            </div>
            <div class="feature-card">
                <i class="fas fa-globe"></i>
                <h3>Connexion Internationale</h3>
                <p>Grâce à notre portée mondiale, trouvez des stages non seulement localement, mais aussi à l’international.</p>
                <ul>
                    <li>Partenariats avec des entreprises mondiales</li>
                    <li>Possibilité de stages virtuels et hybrides</li>
                    <li>Accès à des stages en Europe, en Amérique et en Asie</li>
                </ul>
                <a href="../html/offre.html" class="cta-btn">En savoir plus</a>
            </div>
        </div>
    </div>
</section>
<!-- Section Témoignages -->
<section class="testimonials-section" id="testimonials">
    <div class="testimonials-content">
        <h2>Découvrez l'avis de nos utilisateurs</h2>
        <p>Découvrez les avis et témoignages de ceux qui utilisent StageNow pour trouver des stages ou recruter des talents.</p>
        
        <div class="testimonial-cards">
            <div class="testimonial-card">
                <p class="testimonial-text">"StageNow m'a permis de trouver un stage incroyable dans une entreprise de renommée internationale ! L'interface est intuitive et les filtres de recherche m'ont fait gagner beaucoup de temps."</p>
                <div class="testimonial-info">
                    <img src="../images/sara.jpg" alt="Utilisateur 1">
                    <div>
                        <h3>Sarah B.</h3>
                        <span>Étudiante en Marketing</span>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card">
                <p class="testimonial-text">"En tant que recruteur, j'apprécie la facilité avec laquelle je peux publier des annonces et trouver des candidats qualifiés. La communauté est engagée et le support client est excellent."</p>
                <div class="testimonial-info">
                    <img src="../images/image1.jpg" alt="Utilisateur 2">
                    <div>
                        <h3>Mehdi L.</h3>
                        <span>Recruteur chez TechSoft</span>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card">
                <p class="testimonial-text">"La plateforme StageNow a élargi mes horizons professionnels. J'ai pu postuler à des stages en ligne tout en découvrant de nouvelles opportunités dans mon domaine."</p>
                <div class="testimonial-info">
                    <img src="../images/amine.jpg" alt="Utilisateur 3">
                    <div>
                        <h3>Amine R.</h3>
                        <span>Étudiant en Informatique</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="cta-section">
    <div class="cta-container">
        <h2>Rejoignez-nous dès maintenant!</h2>
        <p>Ne manquez pas l'opportunité de découvrir des milliers d'offres de stage et de rencontrer des recruteurs qui recherchent des talents comme vous.</p>
        <div class="cta-buttons">
            <a href="../html/choix.html" class="btn btn-primary">Inscrivez-vous maintenant</a>
            <a href="../html/offre.html" class="btn btn-secondary">Voir les offres de stage</a>
        </div>
    </div>
</section>
<section class="team-section" id="team">
    <div class="team-container">
        <h2>Notre Équipe</h2>
        <p>Rencontrez les talents qui ont contribué à créer StageNow</p>
        <div class="team-members">
            <div class="team-member">
                <img src="../images/samira.jpg" alt="Membre de l'équipe 1">
                <h3>ELHOUARI Samira</h3>
                <p>Fondatrice et Développeuse Front-end</p>
            </div>
            <div class="team-member">
                <img src="../images/rania.jpg" alt="Membre de l'équipe 2">
                <h3>BARGHAZI Rania</h3>
                <p>Développeur Back-end</p>
            </div>
            <div class="team-member">
                <img src="../images/fati.jpg" alt="Membre de l'équipe 3">
                <h3>BOUNOU Fatimazahra</h3>
                <p>Responsable Marketing</p>
            </div>
            <div class="team-member">
                <img src="../images/zainab.jpg" alt="Membre de l'équipe 3">
                <h3>HRIGUICH Zainab</h3>
                <p>Responsable du design</p>
            </div>
        </div>
    </div>
</section>
<section class="how-it-works" id="how-it-works">
    <div class="section-header">
        <h2>Comment ça marche ?</h2>
        <p>Découvrez en quelques étapes simples comment rejoindre StageNow et profiter de toutes les fonctionnalités.</p>
    </div>
    <div class="steps-container">
        <!-- Step 1 -->
        <div class="step">
            <div class="step-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <h3>1. Créez votre compte</h3>
            <p>Inscrivez-vous gratuitement en tant que recruteur ou chercheur de stage pour commencer à explorer nos offres.</p>
        </div>
        <!-- Step 2 -->
        <div class="step">
            <div class="step-icon">
                <i class="fas fa-search"></i>
            </div>
            <h3>2. Cherchez des opportunités</h3>
            <p>Utilisez notre moteur de recherche puissant pour trouver des stages adaptés à vos compétences et préférences.</p>
        </div>
        <!-- Step 3 -->
        <div class="step">
            <div class="step-icon">
                <i class="fas fa-briefcase"></i>
            </div>
            <h3>3. Postulez ou Publiez</h3>
            <p>Postulez aux stages disponibles ou publiez vos offres de stage si vous êtes recruteur.</p>
        </div>
        <!-- Step 4 -->
        <div class="step">
            <div class="step-icon">
                <i class="fas fa-thumbs-up"></i>
            </div>
            <h3>4. Réussissez et grandissez</h3>
            <p>Une fois accepté, démarrez votre stage ou trouvez le bon candidat pour le poste et faites grandir votre réseau professionnel.</p>
        </div>
    </div>
</section>
<section class="partners" id="partners">
    <div class="section-header">
        <h2>Nos Partenaires et Sponsors</h2>
        <p>Merci à nos précieux partenaires et sponsors qui rendent possible l'accès à des opportunités de stage sur StageNow.</p>
    </div>
    <div class="partners-logos">
        <div class="partner">
            <img src="../images/entreprise1.jpg" alt="Partenaire 1">
            <p>Entreprise 1 - Des stages de qualité pour vos étudiants</p>
        </div>
        <div class="partner">
            <img src="../images/entreprise2.jpg" alt="Partenaire 2">
            <p>Entreprise 2 - Aide à la formation et à l'emploi des jeunes talents</p>
        </div>
        <div class="partner">
            <img src="../images/entreprise3.jpg" alt="Partenaire 3">
            <p>Entreprise 3 - Un engagement pour un avenir professionnel prometteur</p>
        </div>
        <div class="partner">
            <img src="../images/entreprise4.jpg" alt="Partenaire 4">
            <p>Entreprise 4 - Partenaire clé dans la réussite de StageNow</p>
        </div>
    </div>
    
</section>


        
       

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

<!-- Lien vers Font Awesome pour les icônes -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script src="../javascript/slide.js"></script>
</body>
</html>
