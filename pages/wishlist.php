<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: auth.php');
    exit();
}

$userId = $_SESSION['user_id'];

$wishlistGames = [];

try {
    $stmt = $pdo->prepare("
        SELECT games.* 
        FROM games
        JOIN wishlist ON games.id = wishlist.game_id
        WHERE wishlist.user_id = ?
    ");
    $stmt->execute([$userId]);
    $wishlistGames = $stmt->fetchAll();
} catch (Exception $e) {
    error_log("Erreur lors de la récupération de la wishlist : " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Ma Wishlist</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: #f0f2f5;
      margin: 0;
      padding: 2rem;
      color: #1d1d1f;
    }
    h1 {
      text-align: center;
      font-size: 2.5rem;
      color: #0071e3;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
    }
    .home-link {
      display: flex;
      justify-content: center;
      margin-bottom: 2rem;
    }
    .btn-home {
      background-color: #0071e3;
      color: white;
      padding: 0.8rem 1.6rem;
      border: none;
      border-radius: 12px;
      font-size: 1rem;
      font-weight: 500;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      transition: all 0.2s ease;
      box-shadow: 0 4px 14px rgba(0, 113, 227, 0.15);
    }
    .btn-home:hover {
      background-color: #005bb5;
      transform: translateY(-2px);
    }
    .game-list {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 1.5rem;
      max-width: 1200px;
      margin: 0 auto;
    }
    .game-card {
      background: white;
      border-radius: 18px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
      padding: 1rem;
      transition: all 0.2s ease;
      cursor: pointer;
      display: flex;
  flex-direction: column;
  justify-content: space-between;
    }
    .game-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
    }
    .game-card img {
      width: 100%;
      height: 160px;
      object-fit: contain;
      margin-bottom: 1rem;
      border-radius: 10px;
      background: #f5f5f7;
    }
    .game-name {
      font-weight: 600;
      font-size: 1.1rem;
      margin-bottom: 0.3rem;
      color: #1d1d1f;
    }
    .game-meta {
      font-size: 0.9rem;
      color: #666;
    }
    .empty {
      text-align: center;
      margin-top: 3rem;
      color: #888;
      font-size: 1.1rem;
    }
  </style>
</head>
<body>

<h1>🍇 Ma Wishlist</h1>
<div class="home-link">
  <a href="index.php" class="btn-home">🏠 Retour à l'accueil</a>
</div>

<div class="game-list">
  <?php if (!empty($wishlistGames)): ?>
    <?php foreach ($wishlistGames as $game): ?>
        <div class="game-card">
    
  <a href="detjeux.php?id=<?= $game['id'] ?>" style="text-decoration: none; color: inherit;">
    <img src="<?= htmlspecialchars($game['thumbnail']) ?>" alt="<?= htmlspecialchars($game['name']) ?>">
    <div class="game-name"><?= htmlspecialchars($game['name']) ?></div>
    <div class="game-meta"><?= htmlspecialchars($game['year_published']) ?></div>
  </a>

  <div style="margin-top: 0.8rem; display: flex; justify-content: center;">
  <form method="POST" action="remove_from_wishlist.php">
    <input type="hidden" name="game_id" value="<?= $game['id'] ?>">
    <button type="submit" style="
      background: none;
      border: none;
      color: #e63946;
      font-size: 0.9rem;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 0.3rem;
    ">
      🗑 <span>Retirer</span>
    </button>
  </form>
</div>

</div>


    <?php endforeach; ?>
  <?php else: ?>
    <div class="empty">Votre wishlist est vide !</div>
  <?php endif; ?>
</div>
<script>
(function () {
  // Empêche de revenir en arrière avec les flèches du navigateur
  history.pushState(null, null, location.href);
  window.addEventListener("popstate", function (event) {
    history.pushState(null, null, location.href);
  });
})();
</script>


</body>
</html>
