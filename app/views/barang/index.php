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
    <a href="index.php?action=create" class="btn btn-success">+ Tambah Barang</a>
    
    <table>
        <thead>
            <tr><th>No</th><th>Gambar</th><th>Nama Barang</th><th>Jumlah</th><th>Harga</th><th>Tanggal Masuk</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            <?php $no=1; foreach($barang as $b): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><img src="../uploads/<?= htmlspecialchars($b['gambar']) ?>" class="thumb"></td>
                <td><?= htmlspecialchars($b['nama_barang']) ?></td>
                <td><?= htmlspecialchars($b['jumlah']) ?></td>
                <td>Rp <?= number_format($b['harga'], 0, ',', '.') ?></td>
                <td><?= htmlspecialchars($b['tanggal_masuk']) ?></td>
                <td>
                    <a href="index.php?action=edit&id=<?= $b['id_barang'] ?>" class="btn">Edit</a>
                    <a href="index.php?action=delete&id=<?= $b['id_barang'] ?>" class="btn btn-danger" onclick="return confirm('Yakin?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>