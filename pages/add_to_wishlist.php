<?php
// Affiche les erreurs (utile en développement)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include '../includes/db.php';

header('Content-Type: application/json');

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'not_logged_in']);
    exit;
}

$userId = $_SESSION['user_id'];
$gameId = isset($_POST['game_id']) ? intval($_POST['game_id']) : 0;

if ($gameId <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'ID de jeu invalide.']);
    exit;
}

try {
    // Vérifie si le jeu est déjà dans la wishlist
    $stmt = $pdo->prepare("SELECT 1 FROM wishlist WHERE user_id = ? AND game_id = ?");
    $stmt->execute([$userId, $gameId]);
    $exists = $stmt->fetch();

    if ($exists) {
        // Retirer le jeu
        $stmt = $pdo->prepare("DELETE FROM wishlist WHERE user_id = ? AND game_id = ?");
        $stmt->execute([$userId, $gameId]);
        echo json_encode(['status' => 'removed']);
    } else {
        // Ajouter le jeu
        $stmt = $pdo->prepare("INSERT INTO wishlist (user_id, game_id) VALUES (?, ?)");
        $stmt->execute([$userId, $gameId]);
        echo json_encode(['status' => 'added']);
    }

} catch (PDOException $e) {
    echo json_encode([
        'status' => 'db_error',
        'message' => $e->getMessage()
    ]);
}
