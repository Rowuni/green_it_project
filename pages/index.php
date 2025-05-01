<?php include '../includes/db.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BoardGameHub</title>
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
    }
    
    header {
      background-color: rgba(255, 255, 255, 0.8);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      padding: 1rem 2rem;
      position: sticky;
      top: 0;
      z-index: 100;
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .header-content {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    .logo {
      font-size: 1.5rem;
      font-weight: 600;
      color: var(--primary);
      display: flex;
      align-items: center;
    }
    
    .logo svg {
      margin-right: 0.5rem;
    }
    
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 0.6rem 1.2rem;
      background-color: var(--primary);
      color: white;
      border: none;
      border-radius: 12px;
      font-size: 0.95rem;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.2s ease;
    }
    
    .btn:hover {
      background-color: #0062c4;
      transform: translateY(-1px);
    }
    
    .container {
      max-width: 1200px;
      margin: 2rem auto;
      padding: 0 2rem;
    }
    
    .hero {
      text-align: center;
      margin: 3rem 0;
    }
    
    .hero h1 {
      font-size: 2.8rem;
      font-weight: 600;
      margin-bottom: 1rem;
      background: linear-gradient(90deg, #0071e3, #00a1e7);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    
    .hero p {
      font-size: 1.2rem;
      color: var(--text-secondary);
      max-width: 700px;
      margin: 0 auto 2rem;

    }
    
    .search-bar {
      max-width: 600px;
      margin: 0 auto;
      position: relative;
    }
    
    .search-input {
      width: 100%;
      padding: 1rem 1.5rem 1rem 3rem;
      border-radius: 12px;
      border: none;
      font-size: 1rem;
      background-color: var(--card-bg);
      box-shadow: var(--shadow);
      transition: all 0.2s ease;
      padding-left: 3rem; 

    }
    
    .search-input:focus {
      outline: none;
      box-shadow: 0 0 0 4px rgba(0, 113, 227, 0.1);
    }
    
    .search-icon {
      position: absolute;
      left: 1rem;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-secondary);
      pointer-events: none;

    }
    
    .section-title {
      font-size: 1.5rem;
      font-weight: 600;
      margin: 3rem 0 1.5rem;
      display: flex;
      align-items: center;
    }
    
    .section-title svg {
      margin-right: 0.5rem;
    }
    
    .scroll-container {
      display: flex;
      overflow-x: auto;
      gap: 1.5rem;
      padding-bottom: 2rem;
      scroll-behavior: smooth;
    }
    
    .scroll-container::-webkit-scrollbar {
      height: 6px;
    }
    
    .scroll-container::-webkit-scrollbar-thumb {
      background-color: rgba(0, 0, 0, 0.2);
      border-radius: 3px;
    }
    
    .game-card {
      min-width: 220px;
      background-color: var(--card-bg);
      border-radius: var(--border-radius);
      overflow: hidden;
      box-shadow: var(--shadow);
      transition: all 0.3s ease;
      flex-shrink: 0;
    }
    
    .game-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .game-thumbnail {
      width: 100%;
      height: 220px;
      object-fit: contain;
      background: linear-gradient(135deg, #f5f5f7 0%, #e1e1e6 100%);
      padding: 1rem;
    }
    
    .game-info {
      padding: 1.2rem;
    }
    
    .game-name {
      font-size: 1rem;
      font-weight: 500;
      margin-bottom: 0.5rem;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    
    .game-meta {
      font-size: 0.85rem;
      color: var(--text-secondary);
      margin-bottom: 0.5rem;
    }
    
    .game-rating {
      display: flex;
      align-items: center;
      font-size: 0.9rem;
      font-weight: 500;
    }
    
    .game-categories {
      margin-top: 0.25rem;
      font-size: 0.8rem;
      color: var(--text-secondary);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    
    .modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      backdrop-filter: blur(10px);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 1000;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
    }
    
    .modal.show {
      opacity: 1;
      visibility: visible;
    }
    
    .modal-content {
      background-color: var(--card-bg);
      border-radius: var(--border-radius);
      width: 90%;
      max-width: 800px;
      max-height: 90vh;
      overflow-y: auto;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
      transform: scale(0.95);
      transition: all 0.3s ease;
    }
    
    .modal.show .modal-content {
      transform: scale(1);
    }
    
    .close-btn {
      position: absolute;
      top: 1.5rem;
      right: 1.5rem;
      background: none;
      border: none;
      font-size: 1.5rem;
      color: var(--text-secondary);
      cursor: pointer;
    }
    
    @media (max-width: 768px) {
      .hero h1 {
        font-size: 2rem;
      }
      
      .game-card {
        min-width: 180px;
      }
      
      .game-thumbnail {
        height: 180px;
      }
    }
    
  </style>

<style>
.search-ui {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 1rem;
  margin-top: 2rem;
  flex-wrap: wrap;
}

.search-box {
  position: relative;
  max-width: 500px;
  width: 100%;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
  display: flex;
  align-items: center;
  transition: box-shadow 0.2s ease;
}

.search-box:hover {
  box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
}

.icon-search {
  position: absolute;
  left: 1rem;
  width: 20px;
  height: 20px;
  color: #999;
  pointer-events: none;
}

.search-input-pro {
  width: 100%;
  padding: 1rem 1rem 1rem 3rem;
  border: none;
  border-radius: 12px;
  font-size: 1rem;
  outline: none;
  background: transparent;
}

.btn-filter-pro {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.9rem 1.2rem;
  background: #0071e3;
  color: #fff;
  border: none;
  border-radius: 12px;
  font-size: 0.95rem;
  font-weight: 500;
  cursor: pointer;
  box-shadow: 0 4px 10px rgba(0, 113, 227, 0.15);
  transition: background 0.2s ease, transform 0.2s ease;
}

.btn-filter-pro:hover {
  background: #005bb5;
  transform: translateY(-1px);
}

.icon-filter {
  width: 20px;
  height: 20px;
}
</style>
</head>
<body>
  <header>
    <div class="header-content">
      <div class="logo">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2"/>
          <path d="M8 14C8 14 9.5 16 12 16C14.5 16 16 14 16 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          <path d="M9 9H9.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          <path d="M15 9H15.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
        BoardGameHub
      </div>
      <div style="display: flex; gap: 1rem;">
  <a href="/boardgamehub/pages/wishlist.php" class="btn">❤️ Wishlist</a>
  <form method="POST" action="/boardgamehub/pages/logout.php" style="display: inline;">
  <button type="submit" class="btn">🚪 Déconnexion</button>
</form>

</div>


    </div>
  </header>
  
  <div class="container">
    <div class="hero">
      <h1>Découvrez votre prochain jeu favori</h1>
      <p>Explorez notre collection de jeux de société soigneusement sélectionnés pour des heures de divertissement.</p>
      <div class="search-ui">
  <div class="search-box">
    <svg class="icon-search" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
    </svg>
    <input type="text" class="search-input-pro" placeholder="Rechercher un jeu, une catégorie...">
  </div>
  <button class="btn-filter-pro" onclick="toggleFilters()">
    <svg xmlns="http://www.w3.org/2000/svg" class="icon-filter" viewBox="0 0 24 24" fill="currentColor">
      <path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L15 14.414V20a1 1 0 01-1.447.894l-4-2A1 1 0 019 18v-3.586L3.293 6.707A1 1 0 013 6V4z" />
    </svg>
    Filtres
  </button>
</div>



<form id="filter-panel" class="filter-panel" style="display: none;" onsubmit="event.preventDefault(); applyFilters();">
  <div>
    <label>🎯 Catégorie</label>
    <select id="category">
      <option value="">--</option>
      <option value="Strategy">Strategy</option>
      <option value="Family">Family</option>
    </select>
  </div>

  <div>
    <label>⚙️ Mécaniques</label><br>
    <label><input type="checkbox" name="mechanic" value="Deck Building"> Deck Building</label>
    <label><input type="checkbox" name="mechanic" value="Worker Placement"> Worker Placement</label>
  </div>

  <div>
    <label>👥 Joueurs min</label>
    <input type="number" id="min_players" min="1" />
  </div>

  <div>
    <label>🌟 Note moyenne (min) : <span id="rating-value">5</span></label>
    <input type="range" id="min_rating" min="0" max="10" step="0.1" value="5" />
  </div>

  <button class="btn" type="submit">Appliquer</button>
</form>


</button>

      
      </div>
      <div id="search-results" class="scroll-container" style="margin-top: 2rem;"></div>

    </div>
    
    <h2 class="section-title">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
      Jeux les mieux notés
    </h2>
    
    <div class="scroll-container">
    <?php
$stmt = $pdo->query("SELECT id, name, thumbnail, average_rating, year_published, categories FROM games ORDER BY average_rating DESC LIMIT 10");
while ($row = $stmt->fetch()):
    $categories = [];
    if (!empty($row['categories']) && $row['categories'] !== 'categories') {
        $decoded = json_decode($row['categories'], true);
        if (is_array($decoded)) $categories = $decoded;
    }
?>
<div class="game-card" style="position: relative;">
  <div onclick="openModal(<?= $row['id'] ?>)">
    <img src="<?= htmlspecialchars($row['thumbnail']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" class="game-thumbnail">
    <div class="game-info">
      <h3 class="game-name"><?= htmlspecialchars($row['name']) ?></h3>
      <div class="game-meta"><?= htmlspecialchars($row['year_published']) ?></div>
      <div class="game-rating">⭐ <?= number_format($row['average_rating'], 2) ?></div>
      <?php if (!empty($categories)): ?>
        <div class="game-categories">
          <?= htmlspecialchars(implode(', ', array_slice($categories, 0, 2))) ?>
          <?= count($categories) > 2 ? '...' : '' ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- ❤️ Bouton wishlist vide au début -->
  <button onclick="toggleWishlist(this, <?= $row['id'] ?>)" 
        style="position: absolute; bottom: 10px; right: 10px; background: none; border: none; font-size: 1.8rem; cursor: pointer; color: #ccc;" 
        title="Ajouter à la wishlist"
        data-wished="false">🤍</button>
</div>
<?php endwhile; ?>


    </div>
    
    <h2 class="section-title">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M22 12H18L15 21L9 3L6 12H2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
      Recommandé pour vous
    </h2>
    
    <div class="scroll-container">
<?php
$stmt = $pdo->query("SELECT id, name, thumbnail, average_rating, year_published, categories FROM games ORDER BY RAND() LIMIT 10");
while ($row = $stmt->fetch()):
    $categories = [];
    if (!empty($row['categories']) && $row['categories'] !== 'categories') {
        $decoded = json_decode($row['categories'], true);
        if (is_array($decoded)) $categories = $decoded;
    }
?>
<div class="game-card" style="position: relative;">
  <div onclick="openModal(<?= $row['id'] ?>)">
    <img src="<?= htmlspecialchars($row['thumbnail']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" class="game-thumbnail">
    <div class="game-info">
      <h3 class="game-name"><?= htmlspecialchars($row['name']) ?></h3>
      <div class="game-meta"><?= htmlspecialchars($row['year_published']) ?></div>
      <div class="game-rating">⭐ <?= number_format($row['average_rating'], 2) ?></div>
      <?php if (!empty($categories)): ?>
        <div class="game-categories">
          <?= htmlspecialchars(implode(', ', array_slice($categories, 0, 2))) ?>
          <?= count($categories) > 2 ? '...' : '' ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- ❤️ Bouton wishlist vide au début -->
  <button onclick="toggleWishlist(this, <?= $row['id'] ?>)" style="
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: none;
    border: none;
    font-size: 1.8rem;
    cursor: pointer;
    color: #ccc;
  " title="Ajouter à la wishlist">🤍</button>
</div>
<?php endwhile; ?>
</div>

  </div>
  
  <!-- Modal -->
  <div id="modal" class="modal">
    <div class="modal-content" id="modalContent">
      <button class="close-btn" onclick="closeModal()">×</button>
      <div style="padding: 2rem;">
        <h2>Chargement...</h2>
      </div>
    </div>
  </div>
  
  <script>
    function openModal(id) {
      const modal = document.getElementById("modal");
      const content = document.getElementById("modalContent");
      
      modal.classList.add("show");
      content.innerHTML = `
        <button class="close-btn" onclick="closeModal()">×</button>
        <div style="padding: 2rem; text-align: center;">
          <h2>Chargement...</h2>
        </div>
      `;
      
      fetch(`detjeux.php?id=${id}`)
        .then(res => res.text())
        .then(html => {
          content.innerHTML = `
            <button class="close-btn" onclick="closeModal()">×</button>
            ${html}
          `;
        })
        .catch(err => {
          content.innerHTML = `
            <button class="close-btn" onclick="closeModal()">×</button>
            <div style="padding: 2rem;">
              <h2>Erreur</h2>
              <p>Impossible de charger les détails du jeu.</p>
            </div>
          `;
        });
    }
    
    function closeModal() {
      document.getElementById("modal").classList.remove("show");
    }
    
    // Close modal when clicking outside
    document.getElementById("modal").addEventListener("click", function(e) {
      if (e.target === this) {
        closeModal();
      }
    });
  </script>
<script>

let searchTimeout;

document.querySelector('.search-input-pro').addEventListener('input', function () {
  const query = this.value.trim();

  if (query.length < 3) {
    document.getElementById('search-results').innerHTML = '';
    return;
  }

  clearTimeout(searchTimeout);
  searchTimeout = setTimeout(() => {
    const cacheKey = `search_cache_${query}`;
    const cached = sessionStorage.getItem(cacheKey);

    if (cached) {
      console.log('✅ Résultat chargé depuis le cache.');
      renderSearchResults(JSON.parse(cached));
      return;
    }

    fetch('/boardgamehub/pages/search.php?q=' + encodeURIComponent(query))
      .then(res => {
        if (!res.ok) throw new Error('Erreur réseau');
        return res.json();
      })
      .then(data => {
        sessionStorage.setItem(cacheKey, JSON.stringify(data));
        renderSearchResults(data);
      })
      .catch(() => {
        document.getElementById('search-results').innerHTML = '<p style="color:red;">Erreur de recherche</p>';
      });
  }, 300);
});

function renderSearchResults(data) {
  const container = document.getElementById('search-results');
  container.innerHTML = '';

  if (data.length === 0) {
    container.innerHTML = '<p style="color: gray;">Aucun jeu trouvé.</p>';
    return;
  }

  data.forEach(game => {
    const div = document.createElement('div');
    div.className = 'game-card';
    div.style.position = 'relative';

    const heart = game.is_wished ? '❤️' : '🤍';
    const color = game.is_wished ? '#e63946' : '#ccc';

    div.innerHTML = `
      <div onclick="openModal(${game.id})">
        <img src="${game.thumbnail}" alt="${game.name}" class="game-thumbnail" loading="lazy">
        <div class="game-info">
          <h3 class="game-name">${game.name}</h3>
          <div class="game-meta">${game.year_published ?? ''}</div>
          <div class="game-rating">⭐ ${parseFloat(game.average_rating ?? 0).toFixed(2)}</div>
        </div>
      </div>
      <button onclick="event.stopPropagation(); toggleWishlist(this, ${game.id});"
        style="position: absolute; bottom: 10px; right: 10px; background: none; border: none; font-size: 1.8rem; cursor: pointer; color: ${color};"
        title="Ajouter à la wishlist"
        data-wished="${game.is_wished}">${heart}</button>
    `;
    container.appendChild(div);
  });
}
</script>



<script>
 function toggleFilters() {
  const panel = document.getElementById('filter-panel');
  panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
}

document.getElementById('min_rating').addEventListener('input', function () {
  document.getElementById('rating-value').textContent = this.value;
});

const input = document.querySelector('.search-input-pro');
const resultsContainer = document.getElementById('search-results');

// ❌ On supprime cette partie pour éviter la recherche auto à chaque frappe
// input.addEventListener('input', () => {
//   if (input.value.trim().length >= 2) applyFilters();
// });

function applyFilters() {
  const query = input.value.trim();
  const category = document.getElementById('category').value;
  const minPlayers = document.getElementById('min_players').value;
  const rating = document.getElementById('min_rating').value;
  const mechanics = Array.from(document.querySelectorAll('input[name="mechanic"]:checked')).map(cb => cb.value);

  let url = '/boardgamehub/pages/search.php?q=' + encodeURIComponent(query);
  if (category) url += '&category=' + encodeURIComponent(category);
  if (minPlayers) url += '&min_players=' + encodeURIComponent(minPlayers);
  if (rating) url += '&rating_min=' + encodeURIComponent(rating);
  if (mechanics.length > 0) url += '&mechanic=' + encodeURIComponent(JSON.stringify(mechanics));

  fetch(url)
    .then(res => res.json())
    .then(data => {
      resultsContainer.innerHTML = '';

      if (data.length === 0) {
        resultsContainer.innerHTML = '<p style="color: gray;">Aucun jeu trouvé.</p>';
        return;
      }

      data.forEach(game => {
  const div = document.createElement('div');
  div.classList.add('game-card');
  div.style.position = 'relative';

  const heart = game.is_wished ? '❤️' : '🤍';
  const color = game.is_wished ? '#e63946' : '#ccc';

  div.innerHTML = `
    <div onclick="openModal(${game.id})">
      <img src="${game.thumbnail}" alt="${game.name}" class="game-thumbnail">
      <div class="game-info" style="display: flex; justify-content: space-between; align-items: center;">
        <h3 class="game-name" style="margin: 0;">${game.name}</h3>
        <button onclick="event.stopPropagation(); toggleWishlist(this, ${game.id});"
          style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: ${color};"
          title="Ajouter à la wishlist"
          data-wished="${game.is_wished}">${heart}</button>
      </div>
    </div>
  `;

  resultsContainer.appendChild(div);
});


      // ✅ Cacher le panneau de filtre après clic sur Appliquer
      document.getElementById('filter-panel').style.display = 'none';
    })
    .catch(() => {
      resultsContainer.innerHTML = '<p style="color:red;">Erreur de recherche</p>';
    });
}

</script>

<script>
function toggleWishlist(button, gameId) {
  console.log("Game ID envoyé:", gameId); // ✅ pour vérifier

  fetch('/boardgamehub/pages/add_to_wishlist.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: `game_id=${encodeURIComponent(gameId)}`
  })
  .then(response => {
    if (!response.ok) throw new Error("Erreur réseau");
    return response.json(); // ✅ Attention : ça attend un vrai JSON
  })
  .then(data => {
    console.log('Réponse du serveur:', data); // ✅ debug visuel
    if (data.status === 'added') {
      button.innerText = '❤️';
      button.style.color = '#e63946';
      button.setAttribute('data-wished', 'true');
    } else if (data.status === 'removed') {
      button.innerText = '🤍';
      button.style.color = '#ccc';
      button.setAttribute('data-wished', 'false');
    } else if (data.status === 'not_logged_in') {
      alert('Veuillez vous connecter pour ajouter à votre wishlist.');
      window.location.href = '/boardgamehub/pages/auth.php';
    } else {
      console.error("Réponse inconnue :", data);
    }
  })
  .catch(error => {
    console.error('Erreur lors de l’ajout à la wishlist :', error);
  });
}
</script>




</body>
</html>