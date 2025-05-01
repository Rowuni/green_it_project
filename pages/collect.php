<!-- collect.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ma collection</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f8f8;
      margin: 0;
      padding: 0;
    }

    header {
      background: #fff;
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid #ccc;
    }

    .btn {
      padding: 0.4rem 0.8rem;
      border: 1px solid #000;
      border-radius: 8px;
      background: white;
      cursor: pointer;
    }

    .container {
      max-width: 800px;
      margin: 2rem auto;
      padding: 1rem;
    }

    h2 {
      font-size: 1.8rem;
      margin-bottom: 1.5rem;
    }

    .game-card {
      background: #fff;
      border-radius: 12px;
      padding: 1rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      margin-bottom: 1rem;
    }

    .game-info {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .thumbnail {
      width: 60px;
      height: 60px;
      background-color: #ccc;
      border-radius: 8px;
    }

    .details {
      display: flex;
      flex-direction: column;
    }

    .details h4 {
      margin: 0 0 0.3rem 0;
    }

    .rating-stars {
      color: #999;
      font-size: 0.9rem;
    }

    .btn-remove {
      background: #f0f0f0;
      border: 1px solid #aaa;
      padding: 0.4rem 0.8rem;
      border-radius: 8px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <header>
    <h1>BoardGameHub</h1>
    <button class="btn">Ma collection</button>
  </header>

  <div class="container">
    <h2>Ma collection</h2>

    <div class="game-card">
      <div class="game-info">
        <div class="thumbnail"></div>
        <div class="details">
          <h4>Nom dun</h4>
          <div class="rating-stars">
            ★ 4,5 · ★★☆
          </div>
        </div>
      </div>
      <button class="btn-remove">Retirer</button>
    </div>

    <div class="game-card">
      <div class="game-info">
        <div class="thumbnail"></div>
        <div class="details">
          <h4>Nom du rèv</h4>
          <div class="rating-stars">
            ★ 4,5 · ★★☆
          </div>
        </div>
      </div>
      <button class="btn-remove">Retirer</button>
    </div>

    <div class="game-card">
      <div class="game-info">
        <div class="thumbnail"></div>
        <div class="details">
          <h4>Nom de voux</h4>
          <div class="rating-stars">
            ★ 4,5 · ★★☆
          </div>
        </div>
      </div>
      <button class="btn-remove">Retirer</button>
    </div>

    <div class="game-card">
      <div class="game-info">
        <div class="thumbnail"></div>
        <div class="details">
          <h4>Nom de veux</h4>
          <div class="rating-stars">
            ★ 4,5 · ★★☆
          </div>
        </div>
      </div>
      <button class="btn-remove">Retirer</button>
    </div>
  </div>
</body>
</html>