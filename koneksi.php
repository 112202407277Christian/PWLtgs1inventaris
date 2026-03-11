<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "inventaris_db";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    // Set error mode ke exception untuk memudahkan debugging
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " || $e->getMessage());
}
?>