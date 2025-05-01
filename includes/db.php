<?php
$host = '127.0.0.1';
$port = '3306'; // ← très important dans ton cas !
$dbname = 'projetbdd';
$username = 'root';
$password = ''; // tu n’as pas de mot de passe

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("❌ Erreur de connexion : " . $e->getMessage());
}
?>
