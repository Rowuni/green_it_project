<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['game_id'])) {
    header('Location: wishlist.php');
    exit();
}

$userId = $_SESSION['user_id'];
$gameId = intval($_POST['game_id']);

try {
    $stmt = $pdo->prepare("DELETE FROM wishlist WHERE user_id = ? AND game_id = ?");
    $stmt->execute([$userId, $gameId]);
} catch (Exception $e) {
    error_log("Erreur suppression wishlist : " . $e->getMessage());
}

header('Location: wishlist.php');
exit();
