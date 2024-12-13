
-- Utiliser la base de données
USE stages;

-- Créer la table des offres
CREATE TABLE offres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255),
    entreprise VARCHAR(255),
    type_stage VARCHAR(100),
    specialite VARCHAR(100),
    ville VARCHAR(100),
    duree VARCHAR(50),
    contrat VARCHAR(50),
    disponibilite VARCHAR(50),
    date_debut DATE,
    description TEXT
);

-- Insertion des données dans la table "offres"
INSERT INTO offres (titre, entreprise, type_stage, specialite, ville, duree, contrat, disponibilite, date_debut, description)
VALUES
    ('Développeur Web', 'WebInnov', 'Temps plein', 'Informatique', 'Casablanca', '6 mois', 'Stage', NULL, '2024-01-15', NULL),
    ('Assistant Marketing Digital', 'DigitalWave', 'Temps partiel', 'Marketing', 'Rabat', '12 mois', 'Alternance', NULL, '2024-02-01', NULL),
    ('Analyste Data', 'DataMasters', 'Temps plein', 'Data Science', 'Marrakech', '4 mois', 'Stage', NULL, '2024-03-01', NULL),
    ('Designer Graphique', 'CreativeDesign', 'Temps plein', 'Design Graphique', 'Tanger', '3 mois', 'Stage', NULL, '2024-01-25', NULL),
    ('Ingénieur Réseaux', 'NetSolutions', 'Temps plein', 'Réseaux', 'Fès', '5 mois', 'Stage', NULL, '2024-02-10', NULL),
    ('Community Manager', 'SocialBuzz', 'Temps plein', 'Communication', 'Casablanca', '6 mois', 'Stage', NULL, '2024-02-15', NULL),
    ('Consultant Junior', 'MarocConsult', 'Temps partiel', 'Conseil', 'Rabat', '12 mois', 'Alternance', NULL, '2024-03-05', NULL),
    ('Chargé de Recrutement', 'TalentPro', 'Temps plein', 'Ressources Humaines', 'Tanger', '3 mois', 'Stage', NULL, '2024-01-30', NULL),
    ('Développeur Mobile', 'AppTech', 'Temps plein', 'Informatique', 'Casablanca', '6 mois', 'Stage', NULL, '2024-04-01', NULL),
    ('Analyste Financier', 'FinanceExpert', 'Temps plein', 'Finance', 'Casablanca', '4 mois', 'Stage', NULL, '2024-01-20', NULL),
    ('Chargé de Projets', 'InnovMaroc', 'Temps plein', 'Management', 'Rabat', '6 mois', 'Stage', NULL, '2024-02-10', NULL),
    ('Chef de Produit', 'MarketLeaders', 'Temps partiel', 'Marketing', 'Marrakech', '12 mois', 'Alternance', NULL, '2024-03-15', NULL),
    ('Ingénieur IA', 'AIInnov', 'Temps plein', 'Intelligence Artificielle', 'Casablanca', '6 mois', 'Stage', NULL, '2024-04-10', NULL),
    ('Développeur Full Stack', 'DevExperts', 'Temps plein', 'Informatique', 'Fès', '5 mois', 'Stage', NULL, '2024-02-15', NULL),
    ('Responsable Logistique', 'SupplyChain', 'Temps plein', 'Logistique', 'Tanger', '3 mois', 'Stage', NULL, '2024-01-20', NULL),
    ('Gestionnaire Administratif', 'AdminSolutions', 'Temps plein', 'Administration', 'Rabat', '4 mois', 'Stage', NULL, '2024-02-05', NULL),
    ('Analyste en Cybersécurité', 'SecureTech', 'Temps plein', 'Cybersécurité', 'Casablanca', '6 mois', 'Stage', NULL, '2024-03-10', NULL),
    ('Gestionnaire de Contenus', 'ContentKing', 'Temps partiel', 'Communication', 'Marrakech', '12 mois', 'Alternance', NULL, '2024-02-25', NULL),
    ('Responsable Qualité', 'QualityMaroc', 'Temps plein', 'Qualité', 'Fès', '4 mois', 'Stage', NULL, '2024-01-15', NULL),
    ('Assistant RH', 'TalentMaroc', 'Temps plein', 'Ressources Humaines', 'Tanger', '6 mois', 'Stage', NULL, '2024-03-01', NULL),
    ('Chargé D\'affaires Junior', 'AKT ADVISOR LLP', 'Stage Pré-embauche', 'Management', 'Casablanca', '3 - 6 Mois', 'Temps plein', 'Temps plein', '2024-11-21', 'Gérer des projets avec autonomie.'),
    ('Offre De Stage Rémunéré (Prothésiste Dentaire)', 'Cabinet dentaire benabad', 'Stage Opérationnel', 'Santé', 'Marrakech', '1 - 3 Mois', 'Temps plein', 'Temps partiel', '2024-11-18', 'Stage en cabinet dentaire.'),
    ('Assistante', 'GEOCONSEIL CDI', 'Stage Pré-embauche', 'Secrétariat', 'Rabat', '1 - 3 Mois', 'Temps plein', 'Temps plein', '2024-11-04', 'Stage en gestion administrative.');
