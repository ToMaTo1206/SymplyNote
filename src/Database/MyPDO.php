<?php
$host = "localhost";
$db   = "symplynote"; // le nom de ta base
$user = "root";          // par défaut sous XAMPP
$pass = "";              // vide par défaut
$charset = "utf8mb4";

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
    // Active les erreurs en mode exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie avec PDO";
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>
