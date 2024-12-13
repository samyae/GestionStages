<?php
$conn = new mysqli('localhost', 'root', '', 'stages');
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

$city = $_GET['ville'] ?? '';
$speciality = $_GET['specialite'] ?? '';
$duration = $_GET['duree'] ?? '';
$page = $_GET['page'] ?? 1;
$offresParPage = 10;
$offset = ($page - 1) * $offresParPage;

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

$countQuery = "SELECT COUNT(*) FROM offres WHERE 1=1";
$countStmt = $conn->prepare($countQuery);
$countStmt->execute();
$totalOffres = $countStmt->get_result()->fetch_row()[0];

header('Content-Type: application/json');
echo json_encode([
    'offres' => $offres,
    'totalOffres' => $totalOffres,
    'offresParPage' => $offresParPage,
    'currentPage' => $page
]);

$conn->close();
?>