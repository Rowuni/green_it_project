<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>BoardGameHub - Découvrez</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=SF+Pro+Display:wght@400;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #0071e3;
      --text: #1d1d1f;
      --background: #ffffff;
      --overlay: rgba(0, 0, 0, 0.5);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    body, html {
      height: 100%;
    }

    .hero {
      position: relative;
      width: 100%;
      height: 100vh;
      background-image: url('../assets/image/assets_task_01jt0et40hf7q8szkwsmtn5efw_1745919831_img_0.webp'); /* adapte ici */
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }

    .overlay {
      position: absolute;
      inset: 0;
      background-color: var(--overlay);
    }

    .hero-content {
      position: relative;
      z-index: 2;
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      color: white;
      text-align: center;
      padding: 2rem;
    }

    .hero-content h1 {
      font-size: 3rem;
      margin-bottom: 1rem;
      background: linear-gradient(90deg, #0071e3, #00a1e7);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .hero-content p {
      font-size: 1.2rem;
      margin-bottom: 2rem;
      color: #f0f0f0;
    }

    .btn {
      background: var(--primary);
      color: white;
      padding: 1rem 2rem;
      border: none;
      border-radius: 12px;
      font-size: 1rem;
      font-weight: 500;
      text-decoration: none;
      transition: all 0.3s ease;
    }

    .btn:hover {
      background: #005bb5;
      transform: translateY(-2px);
    }

    footer {
      text-align: center;
      padding: 1rem;
      background-color: #f5f5f7;
      color: #86868b;
      font-size: 0.9rem;
    }

    @media (max-width: 768px) {
      .hero-content h1 {
        font-size: 2rem;
      }

      .hero-content p {
        font-size: 1rem;
      }

      .btn {
        padding: 0.8rem 1.5rem;
        font-size: 0.9rem;
      }
    }
  </style>
</head>
<body>

  <section class="hero">
    <div class="overlay"></div>
    <div class="hero-content">
      <h1>Bienvenue sur BoardGameHub 🎲</h1>
      <p>Explorez, collectionnez et partagez vos jeux de société préférés.</p>
      <a href="/boardgamehub/pages/auth.php" class="btn">Commencer</a>
    </div>
  </section>

  <footer>
    &copy; <?= date('Y') ?> BoardGameHub. Tous droits réservés.
  </footer>

</body>
</html>
