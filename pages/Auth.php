<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion - BoardGameHub</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }
    body {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  background: url('assets/assets_task_01jtg0dbcpewd96az1eijygwzt_1745921519_img_0.webp') no-repeat center center fixed;
  background-size: cover;
}


.container {
  background: rgba(255, 255, 255, 0.92); /* au lieu de #fff */
  padding: 2.5rem;
  border-radius: 16px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.15);
  width: 380px;
  transition: 0.3s;
}

    .container:hover {
      transform: scale(1.02);
    }
    .container h2 {
      text-align: center;
      margin-bottom: 1.5rem;
      color: #333;
      font-size: 1.8rem;
    }
    .form-group {
      margin-bottom: 1.2rem;
    }
    .form-group input {
      width: 100%;
      padding: 1rem;
      border-radius: 10px;
      border: 1px solid #ccc;
      background: #f9f9f9;
      transition: 0.3s;
    }
    .form-group input:focus {
      border-color: #0071e3;
      background: #fff;
      outline: none;
      box-shadow: 0 0 5px rgba(0,113,227,0.3);
    }
    .btn {
      width: 100%;
      padding: 1rem;
      background: #0071e3;
      color: #fff;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      font-weight: 600;
      margin-top: 1rem;
      transition: 0.3s;
      font-size: 1rem;
    }
    .btn:hover {
      background: #005bb5;
    }
    .toggle {
      text-align: center;
      margin-top: 1.5rem;
      cursor: pointer;
      color: #0071e3;
      font-size: 0.95rem;
    }
    .toggle:hover {
      text-decoration: underline;
    }
    .message {
      padding: 12px;
      margin-bottom: 15px;
      border-radius: 8px;
      font-size: 0.95rem;
      text-align: center;
      font-weight: 500;
    }
    .success {
      background: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }
    .error {
      background: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }
  </style>
</head>
<body>

<div class="container">

<?php if (isset($_SESSION['success'])): ?>
  <div class="message success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
  <div class="message error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>

  <h2 id="form-title">Se connecter</h2>

  <form id="login-form" action="auth_backend.php" method="POST">
    <input type="hidden" name="action" value="login">
    <div class="form-group">
      <input type="text" name="username" placeholder="Nom d'utilisateur" required>
    </div>
    <div class="form-group">
      <input type="password" name="password" placeholder="Mot de passe" required>
    </div>
    <button class="btn" type="submit">Connexion</button>
  </form>

  <form id="register-form" action="auth_backend.php" method="POST" style="display:none;">
    <input type="hidden" name="action" value="register">
    <div class="form-group">
      <input type="text" name="signup_username" placeholder="Nom d'utilisateur" required>
    </div>
    <div class="form-group">
      <input type="email" name="signup_email" placeholder="Email" required>
    </div>
    <div class="form-group">
      <input type="password" name="signup_password" placeholder="Mot de passe" required>
    </div>
    <button class="btn" type="submit">S'inscrire</button>
  </form>

  <div class="toggle" id="toggle-link">Pas encore de compte ? S'inscrire</div>

</div>

<script>
const loginForm = document.getElementById('login-form');
const registerForm = document.getElementById('register-form');
const toggleLink = document.getElementById('toggle-link');
const formTitle = document.getElementById('form-title');

toggleLink.addEventListener('click', () => {
  if (loginForm.style.display === 'none') {
    loginForm.style.display = 'block';
    registerForm.style.display = 'none';
    formTitle.innerText = 'Se connecter';
    toggleLink.innerText = "Pas encore de compte ? S'inscrire";
  } else {
    loginForm.style.display = 'none';
    registerForm.style.display = 'block';
    formTitle.innerText = "Créer un compte";
    toggleLink.innerText = 'Déjà inscrit ? Se connecter';
  }
});
</script>

</body>
</html>
