<?php
$host = 'localhost';
$dbname = 'db_inventaris';
$username = 'root'; // Sesuaikan dengan user database kamu
$password = '';     // Sesuaikan dengan password database kamu

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>