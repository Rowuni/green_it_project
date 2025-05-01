<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['action']) && $_POST['action'] === 'login') {
        // Connexion
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        $stmt = $pdo->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: /boardgamehub/pages/index.php');
            exit();
        } else {
            $_SESSION['error'] = "Identifiants incorrects.";
            header('Location: /boardgamehub/pages/auth.php');
            exit();
        }

    } elseif (isset($_POST['action']) && $_POST['action'] === 'register') {
        // Inscription
        $username = trim($_POST['signup_username']);
        $email = trim($_POST['signup_email']);
        $password = trim($_POST['signup_password']);

        if (!empty($username) && !empty($email) && !empty($password)) {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->execute([$username]);

            if ($stmt->fetch()) {
                $_SESSION['error'] = "Nom d'utilisateur déjà utilisé.";
                header('Location: /boardgamehub/pages/auth.php');
                exit();
            } else {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                $stmt->execute([$username, $email, $hashedPassword]);

                $_SESSION['success'] = "Inscription réussie ! Connectez-vous maintenant.";
                header('Location: /boardgamehub/pages/auth.php');
                exit();
            }
        } else {
            $_SESSION['error'] = "Veuillez remplir tous les champs.";
            header('Location: /boardgamehub/pages/auth.php');
            exit();
        }
    }
} else {
    header('Location: /boardgamehub/pages/auth.php');
    exit();
}
?>
