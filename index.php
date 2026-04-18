<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM barang WHERE user_id = :user_id ORDER BY id_barang DESC");
$stmt->execute(['user_id' => $user_id]);
$barang = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Data Inventaris</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="header-actions">
        <h2>Halo, <?= htmlspecialchars($_SESSION['username']) ?>! - Data Inventaris</h2>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
    <a href="tambah.php" class="btn btn-success">+ Tambah Barang</a>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Tanggal Masuk</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach($barang as $b): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><img src="uploads/<?= htmlspecialchars($b['gambar']) ?>" class="thumb" alt="Gambar"></td>
                <td><?= htmlspecialchars($b['nama_barang']) ?></td>
                <td><?= htmlspecialchars($b['jumlah']) ?></td>
                <td>Rp <?= number_format($b['harga'], 0, ',', '.') ?></td>
                <td><?= htmlspecialchars($b['tanggal_masuk']) ?></td>
                <td>
                    <a href="edit.php?id=<?= $b['id_barang'] ?>" class="btn">Edit</a>
                    <a href="hapus.php?id=<?= $b['id_barang'] ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
