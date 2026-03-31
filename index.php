<?php 
include 'cek_login.php'; 
include 'koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Inventaris</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 40px; background-color: #f4f7f6; }
        .container { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .btn { padding: 10px 15px; color: white; text-decoration: none; border-radius: 5px; display: inline-block; font-size: 14px;}
        .btn-tambah { background-color: #28a745; margin-bottom: 15px;}
        .btn-tambah:hover { background-color: #218838; }
        .btn-logout { background-color: #dc3545; }
        .btn-logout:hover { background-color: #c82333; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #007bff; color: white; }
        tr:hover { background-color: #f1f1f1; }
        .aksi a { text-decoration: none; padding: 5px 10px; border-radius: 3px; font-size: 13px; color: #000; }
        .edit { background-color: #ffc107; }
        .hapus { background-color: #dc3545; color: #fff !important; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-flex">
            <h2>📦 Daftar Inventaris Barang</h2>
            <div>
                <span style="margin-right: 15px;">Halo, <strong><?= htmlspecialchars($_SESSION['username']); ?></strong></span>
                <a href="logout.php" class="btn btn-logout">Keluar</a>
            </div>
        </div>
        
        <a href="tambah.php" class="btn btn-tambah">+ Tambah Barang Baru</a>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Tanggal Masuk</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $pdo->query("SELECT * FROM barang ORDER BY id DESC");
                $no = 1;
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><strong><?= htmlspecialchars($row['nama_barang']); ?></strong></td>
                    <td><?= $row['jumlah']; ?></td>
                    <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                    <td><?= date('d M Y', strtotime($row['tanggal_masuk'])); ?></td>
                    <td class="aksi" style="text-align: center;">
                        <a href="edit.php?id=<?= $row['id']; ?>" class="edit">Edit</a> 
                        <a href="hapus.php?id=<?= $row['id']; ?>" class="hapus" onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
