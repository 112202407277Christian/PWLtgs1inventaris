<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id_barang = $_GET['id'] ?? 0;
$user_id = $_SESSION['user_id'];

// Ambil nama gambar untuk dihapus dari folder
$stmt = $pdo->prepare("SELECT gambar FROM barang WHERE id_barang = :id AND user_id = :user_id");
$stmt->execute(['id' => $id_barang, 'user_id' => $user_id]);
$barang = $stmt->fetch(PDO::FETCH_ASSOC);

if ($barang) {
    if (file_exists('uploads/' . $barang['gambar'])) {
        unlink('uploads/' . $barang['gambar']);
    }
    $delStmt = $pdo->prepare("DELETE FROM barang WHERE id_barang = :id AND user_id = :user_id");
    $delStmt->execute(['id' => $id_barang, 'user_id' => $user_id]);
}

header("Location: index.php");
exit;
?>
