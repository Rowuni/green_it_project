<?php
session_start();
include '../includes/db.php';

// Vérifie que l'identifiant du jeu est présent dans l'URL
if (!isset($_GET['id'])) {
    die("Jeu non spécifié.");
}

$id = intval($_GET['id']);

// Gérer la soumission d'une nouvelle note
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $note = max(1, min(10, intval($_POST['note'])));  // Note sur 10
    $userId = $_SESSION['user_id'];
    $commentaire = trim($_POST['commentaire']);

    // Récupérer la note actuelle de l'utilisateur pour ce jeu
$stmt = $pdo->prepare("SELECT average FROM rating WHERE user_id = ? AND game_id = ?");
$stmt->execute([$userId, $id]);
$userNote = $stmt->fetchColumn();


    // Remplace ou insère la note de l'utilisateur
    $stmt = $pdo->prepare("REPLACE INTO rating (user_id, game_id, average, commentaire) VALUES (?, ?, ?, ?)");
    $stmt->execute([$userId, $id, $note, $commentaire]);
    

    // Recalcule la moyenne des notes
    $stmt = $pdo->prepare("SELECT AVG(average) FROM rating WHERE game_id = ?");
    $stmt->execute([$id]);
    $avg = $stmt->fetchColumn();

    // Met à jour la moyenne dans la table `games`
    $stmt = $pdo->prepare("UPDATE games SET average_rating = ? WHERE id = ?");
    $stmt->execute([$avg, $id]);

    // Recharge la page pour afficher la mise à jour
    header("Location: detjeux.php?id=$id");
    exit;
}

// Récupérer les informations du jeu
$stmt = $pdo->prepare("
    SELECT id, name, thumbnail, description, average_rating, year_published,
           min_players, max_players, playing_time, min_age, categories, mechanics
    FROM games
    WHERE id = ?
");
$stmt->execute([$id]);
$game = $stmt->fetch();

if (!$game) {
    die("Jeu introuvable.");
}
// Récupérer tous les commentaires avec le nom des utilisateurs
$stmt = $pdo->prepare("
    SELECT u.username, r.average, r.commentaire
    FROM rating r
    JOIN users u ON r.user_id = u.id
    WHERE r.game_id = ?
    ORDER BY r.id DESC
");
$stmt->execute([$id]);
$commentaires = $stmt->fetchAll();

// Extraire les catégories
$categories = [];
if (!empty($game['categories']) && $game['categories'] !== 'categories') {
    preg_match_all("/'([^']+)'/", $game['categories'], $matches);
    $categories = $matches[1];
}

// Extraire les mécaniques
$mechanics = [];
if (!empty($game['mechanics']) && $game['mechanics'] !== 'mechanics') {
    preg_match_all("/'([^']+)'/", $game['mechanics'], $matches);
    $mechanics = $matches[1];
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BoardGameHub - <?= htmlspecialchars($game['name']) ?></title>
  <link href="https://fonts.googleapis.com/css2?family=SF+Pro+Display:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --bg-color: #f5f5f7;
      --card-bg: #ffffff;
      --primary: #0071e3;
      --text-primary: #1d1d1f;
      --text-secondary: #86868b;
      --border-radius: 18px;
      --shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }
    
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, sans-serif;
    }
    
    body {
      background-color: var(--bg-color);
      color: var(--text-primary);
      line-height: 1.5;
      padding: 0;
      margin: 0;
    }
    
    .game-container {
      max-width: 1200px;
      margin: 2rem auto;
      padding: 0 2rem;
      display: grid;
      grid-template-columns: 300px 1fr;
      gap: 2.5rem;
    }
    
    .game-cover {
      width: 100%;
      height: 400px;
      border-radius: var(--border-radius);
      object-fit: contain;
      box-shadow: var(--shadow);
      background: linear-gradient(135deg, #f5f5f7 0%, #e1e1e6 100%);
      padding: 1rem;
    }
    
    .game-header {
      margin-bottom: 1.5rem;
    }
    
    .game-title {
      font-size: 2.2rem;
      font-weight: 600;
      margin-bottom: 0.5rem;
      color: var(--text-primary);
    }
    
    .game-meta {
      display: flex;
      gap: 1.5rem;
      margin-bottom: 1.5rem;
      color: var(--text-secondary);
      font-size: 0.95rem;
    }
    
    .game-rating {
      display: inline-flex;
      align-items: center;
      background-color: var(--card-bg);
      padding: 0.5rem 1rem;
      border-radius: 20px;
      box-shadow: var(--shadow);
      font-weight: 500;
      margin-bottom: 1.5rem;
    }
    
    .game-details {
      background-color: var(--card-bg);
      border-radius: var(--border-radius);
      padding: 2rem;
      box-shadow: var(--shadow);
      margin-bottom: 2rem;
    }
    
    .detail-section {
      margin-bottom: 2rem;
    }
    
    .detail-title {
      font-size: 1.2rem;
      font-weight: 500;
      margin-bottom: 1rem;
      color: var(--text-primary);
      display: flex;
      align-items: center;
    }
    
    .detail-title svg {
      margin-right: 0.5rem;
    }
    
    .detail-content {
      color: var(--text-secondary);
      line-height: 1.6;
    }
    
    .tag-container {
      display: flex;
      flex-wrap: wrap;
      gap: 0.5rem;
    }
    
    .tag {
      background-color: #f5f5f7;
      padding: 0.5rem 1rem;
      border-radius: 20px;
      font-size: 0.85rem;
      color: var(--text-primary);
    }
    
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 0.8rem 1.5rem;
      background-color: var(--primary);
      color: white;
      border: none;
      border-radius: 12px;
      font-size: 1rem;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.2s ease;
      text-decoration: none;
    }
    
    .btn:hover {
      background-color: #0062c4;
      transform: translateY(-1px);
    }
    
    .btn-outline {
      background-color: transparent;
      border: 1px solid var(--primary);
      color: var(--primary);
    }
    
    .btn-outline:hover {
      background-color: rgba(0, 113, 227, 0.1);
    }
    
    .btn-group {
      display: flex;
      gap: 1rem;
      margin-top: 2rem;
    }
    
    .no-data {
      color: var(--text-secondary);
      font-style: italic;
    }
    
    @media (max-width: 768px) {
      .game-container {
        grid-template-columns: 1fr;
        padding: 0 1.5rem;
      }
      
      .game-cover {
        height: 300px;
      }
    }
  </style>
</head>
<body>
  <div class="game-container">
    <div>
      <img src="<?= htmlspecialchars($game['thumbnail']) ?>" alt="<?= htmlspecialchars($game['name']) ?>" class="game-cover">
    </div>
    
    <div>
      <div class="game-header">
        <h1 class="game-title"><?= htmlspecialchars($game['name']) ?></h1>
        <div class="game-rating">⭐ <?= number_format($game['average_rating'], 1) ?>/10</div>

        <div class="game-meta">
          <span><?= $game['year_published'] ?></span>
          <span><?= $game['min_players'] ?>-<?= $game['max_players'] ?> joueurs</span>
          <span><?= $game['playing_time'] ?> min</span>
          <span>Âge <?= $game['min_age'] ?>+</span>
        </div>
      </div>
      
      <div class="game-details">
        <div class="detail-section">
          <h3 class="detail-title">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M9 6L21 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              <path d="M9 12L21 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              <path d="M9 18L21 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              <path d="M3 6H3.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              <path d="M3 12H3.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              <path d="M3 18H3.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            Catégories
          </h3>
          <div class="tag-container">
            <?php if (!empty($categories)): ?>
              <?php foreach ($categories as $category): ?>
                <span class="tag"><?= htmlspecialchars($category) ?></span>
              <?php endforeach; ?>
            <?php else: ?>
              <span class="no-data">Aucune catégorie spécifiée</span>
            <?php endif; ?>
          </div>
        </div>
        
        <div class="detail-section">
          <h3 class="detail-title">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2"/>
              <path d="M12 8V12L15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            Mécaniques de jeu
          </h3>
          <div class="tag-container">
            <?php if (!empty($mechanics)): ?>
              <?php foreach ($mechanics as $mechanic): ?>
                <span class="tag"><?= htmlspecialchars($mechanic) ?></span>
              <?php endforeach; ?>
            <?php else: ?>
              <span class="no-data">Aucune mécanique spécifiée</span>
            <?php endif; ?>
          </div>
        </div>
        
        <div class="detail-section">
          <h3 class="detail-title">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M14 2H6C5.46957 2 4.96086 2.21071 4.58579 2.58579C4.21071 2.96086 4 3.46957 4 4V20C4 20.5304 4.21071 21.0391 4.58579 21.4142C4.96086 21.7893 5.46957 22 6 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V8L14 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M14 2V8H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M16 13H8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              <path d="M16 17H8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              <path d="M10 9H9H8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            Description
          </h3>
          <div class="detail-content">
            <?php if (!empty($game['description'])): ?>
              <p><?= nl2br(html_entity_decode($game['description'])) ?></p>

            <?php else: ?>
              <p class="no-data">Aucune description disponible</p>
            <?php endif; ?>
          </div>
        </div>

        <?php if (isset($_SESSION['user_id'])): ?>
  <div class="detail-section">
    <h3 class="detail-title">Donner une note</h3>
    <form method="post">
    <label for="note">Votre note : <span id="noteValue"><?= isset($userNote) ? $userNote : 5 ?></span>/10</label>

      <input type="range" name="note" id="note" min="1" max="10" value="<?= isset($userNote) ? $userNote : 5 ?>" oninput="noteValue.textContent = this.value">
      <label for="commentaire">Votre commentaire :</label><br>
<textarea name="commentaire" id="commentaire" rows="4" cols="50" placeholder="Partagez votre avis..."><?= isset($userNote) ? htmlspecialchars($commentaire ?? '') : '' ?></textarea>

      <br><br>
      <button type="submit" class="btn">Noter</button>
    </form>
    <?php if (!empty($commentaires)): ?>
  <div class="detail-section">
    <h3 class="detail-title">Commentaires des utilisateurs</h3>
    <?php foreach ($commentaires as $com): ?>
      <div class="detail-content">
        <p><strong><?= htmlspecialchars($com['username']) ?></strong> a noté <?= $com['average'] ?>/10</p>
        <p><?= nl2br(htmlspecialchars($com['commentaire'])) ?></p>
        <hr>
      </div>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <p class="no-data">Aucun commentaire pour ce jeu.</p>
<?php endif; ?>

  </div>
<?php else: ?>
  <p><a href="../login.php">Connectez-vous</a> pour noter ce jeu.</p>
<?php endif; ?>

      
    
    </div>
  </div>
</body>
</html>