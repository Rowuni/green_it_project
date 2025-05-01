<?php
session_start();
include '../includes/db.php';

$where = [];
$params = [];

if (!empty($_GET['q'])) {
  $where[] = "name LIKE ?";
  $params[] = "%" . $_GET['q'] . "%";
}
if (!empty($_GET['category'])) {
  $where[] = "categories LIKE ?";
  $params[] = '%' . $_GET['category'] . '%';
}
if (!empty($_GET['min_players']) && is_numeric($_GET['min_players'])) {
  $where[] = "min_players <= ?";
  $params[] = $_GET['min_players'];
}
if (!empty($_GET['rating_min']) && is_numeric($_GET['rating_min'])) {
  $where[] = "average_rating >= ?";
  $params[] = $_GET['rating_min'];
}
if (!empty($_GET['mechanic'])) {
  $mechanics = json_decode($_GET['mechanic'], true);
  if (is_array($mechanics)) {
    $likes = [];
    foreach ($mechanics as $m) {
      $likes[] = "mechanics LIKE ?";
      $params[] = '%' . $m . '%';
    }
    $where[] = '(' . implode(' OR ', $likes) . ')';
  }
}

$sql = "SELECT id, name, thumbnail, average_rating, year_published FROM games";

if (!empty($where)) {
  $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY name LIMIT 20";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ❤️ Ajouter les jeux déjà en wishlist
$userId = $_SESSION['user_id'] ?? null;
if ($userId && count($results) > 0) {
  $ids = array_column($results, 'id');
  $placeholders = implode(',', array_fill(0, count($ids), '?'));
  $wishStmt = $pdo->prepare("SELECT game_id FROM wishlist WHERE user_id = ? AND game_id IN ($placeholders)");
  $wishStmt->execute(array_merge([$userId], $ids));
  $wished = $wishStmt->fetchAll(PDO::FETCH_COLUMN);

  foreach ($results as &$game) {
    $game['is_wished'] = in_array($game['id'], $wished);
  }
} else {
  foreach ($results as &$game) {
    $game['is_wished'] = false;
  }
}

header('Content-Type: application/json');
echo json_encode($results);
