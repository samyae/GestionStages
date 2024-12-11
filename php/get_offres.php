<?php
// Connexion à la base de données
$conn = new mysqli('localhost', 'root', '', 'gestionDeStage');
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Récupérer les filtres depuis les paramètres GET
$city = $_GET['ville'] ?? '';
$speciality = $_GET['specialite'] ?? '';
$duration = $_GET['duree'] ?? '';
$contrat = $_GET['contrat'] ?? ''; // Nouvelle variable pour le contrat
$page = $_GET['page'] ?? 1;
$offresParPage = 10;
$offset = ($page - 1) * $offresParPage;

// Construction de la requête avec filtres
$query = "SELECT * FROM offres WHERE 1=1";
$params = [];

if ($city) {
    $query .= " AND ville = ?";
    $params[] = $city;
}
if ($speciality) {
    $query .= " AND specialite = ?";
    $params[] = $speciality;
}
if ($duration) {
    $query .= " AND duree = ?";
    $params[] = $duration;
}
if ($contrat) {
    $query .= " AND contrat = ?";
    $params[] = $contrat;
}

$query .= " LIMIT ?, ?";
$params[] = $offset;
$params[] = $offresParPage;

$stmt = $conn->prepare($query);
$stmt->bind_param(str_repeat('s', count($params) - 2) . 'ii', ...$params);
$stmt->execute();
$result = $stmt->get_result();

$offres = [];
while ($row = $result->fetch_assoc()) {
    $offres[] = $row;
}

// Calcul du nombre total d'offres
$countQuery = "SELECT COUNT(*) FROM offres WHERE 1=1";
$countStmt = $conn->prepare($countQuery);
$countStmt->execute();
$totalOffres = $countStmt->get_result()->fetch_row()[0];

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Offres de Stage</title>
  <link rel="stylesheet" href="../style/styles.css">
</head>
<body>
  <header>
    <!-- Votre navbar ici -->
  </header>

  <section class="hero-section">
    <div class="hero-content">
      <h1>Découvrez Votre Potentiel</h1>
      <p>Accédez à des milliers d'opportunités de stage pour bâtir une carrière éclatante.</p>
      <a href="#offres" class="hero-button">Commencez Maintenant</a>
    </div>
    <div class="background-animations"></div>
  </section>

  <main>
    <div class="container">
      <aside class="filters">
        <h3>Recherche un Stage</h3>
        <form method="GET" action="offre.php">
          <select name="specialite" id="specialite">
            <option value="">Spécialité</option>
            <option value="Informatique" <?= ($speciality == 'Informatique') ? 'selected' : '' ?>>Informatique</option>
            <option value="Santé" <?= ($speciality == 'Santé') ? 'selected' : '' ?>>Santé</option>
            <option value="Marketing" <?= ($speciality == 'Marketing') ? 'selected' : '' ?>>Marketing</option>
            <option value="Finance" <?= ($speciality == 'Finance') ? 'selected' : '' ?>>Finance</option>
            <option value="Droit" <?= ($speciality == 'Droit') ? 'selected' : '' ?>>Droit</option>
            <option value="Ressources Humaines" <?= ($speciality == 'Ressources Humaines') ? 'selected' : '' ?>>Ressources Humaines</option>
            <option value="Ingénierie" <?= ($speciality == 'Ingénierie') ? 'selected' : '' ?>>Ingénierie</option>
            <option value="Communication" <?= ($speciality == 'Communication') ? 'selected' : '' ?>>Communication</option>
            <option value="Data science" <?= ($speciality == 'Data science') ? 'selected' : '' ?>>Data science</option>
          </select>

          <select name="ville" id="ville">
            <option value="">Ville</option>
            <option value="Casablanca" <?= ($city == 'Casablanca') ? 'selected' : '' ?>>Casablanca</option>
            <option value="Marrakech" <?= ($city == 'Marrakech') ? 'selected' : '' ?>>Marrakech</option>
            <option value="Rabat" <?= ($city == 'Rabat') ? 'selected' : '' ?>>Rabat</option>
            <option value="Fès" <?= ($city == 'Fès') ? 'selected' : '' ?>>Fès</option>
            <option value="Tanger" <?= ($city == 'Tanger') ? 'selected' : '' ?>>Tanger</option>
            <option value="Agadir" <?= ($city == 'Agadir') ? 'selected' : '' ?>>Agadir</option>
            <option value="Oujda" <?= ($city == 'Oujda') ? 'selected' : '' ?>>Oujda</option>
          </select>

          <select name="duree" id="duree">
            <option value="">Durée</option>
            <option value="1 - 3 Mois" <?= ($duration == '1 - 3 Mois') ? 'selected' : '' ?>>1 - 3 Mois</option>
            <option value="3 - 6 Mois" <?= ($duration == '3 - 6 Mois') ? 'selected' : '' ?>>3 - 6 Mois</option>
            <option value="6+ Mois" <?= ($duration == '6+ Mois') ? 'selected' : '' ?>>6+ Mois</option>
          </select>

          <select name="contrat" id="contrat">
            <option value="">Type de contrat</option>
            <option value="CDI" <?= ($contrat == 'CDI') ? 'selected' : '' ?>>CDI</option>
            <option value="CDD" <?= ($contrat == 'CDD') ? 'selected' : '' ?>>CDD</option>
            <option value="Stage" <?= ($contrat == 'Stage') ? 'selected' : '' ?>>Stage</option>
            <option value="Freelance" <?= ($contrat == 'Freelance') ? 'selected' : '' ?>>Freelance</option>
          </select>

          <button type="submit">Filtrer</button>
        </form>
      </aside>

      <!-- Section des cartes -->
      <section class="offers">
        <?php foreach ($offres as $offre): ?>
          <div class="offer-card">
            <h5><?= htmlspecialchars($offre['titre']) ?></h5>
            <p><?= htmlspecialchars($offre['description']) ?></p>
            <p><strong>Type:</strong> <?= htmlspecialchars($offre['type_stage']) ?></p>
            <p><strong>Ville:</strong> <?= htmlspecialchars($offre['ville']) ?></p>
            <p><strong>Durée:</strong> <?= htmlspecialchars($offre['duree']) ?> mois</p>
            <!-- Lien vers la page de détails de l'offre -->
            <a href="detail.php?id_offre=<?= $offre['id_offre'] ?>" class="btn btn-primary">Voir Détails</a>
          </div>
        <?php endforeach; ?>
      </section>

      <!-- Pagination -->
      <div class="pagination">
        <?php
        $totalPages = ceil($totalOffres / $offresParPage);
        for ($i = 1; $i <= $totalPages; $i++) {
            echo "<a href='offre.php?page=$i' class='pagination-link'>$i</a>";
        }
        ?>
      </div>
    </div>
  </main>

  <footer class="footer">
    <div class="footer-content">
      <h2>Explorez, découvrez et restez inspiré !</h2>
      <p>Des offres innovantes vous attendent, ne manquez pas l'opportunité de transformer votre avenir avec nous.</p>
    </div>
  </footer>

  <script src="../javascript/script.js"></script>
</body>
</html>
