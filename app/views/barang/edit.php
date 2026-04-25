<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Edit Barang</h2>
    <form action="index.php?action=update&id=<?= $barang['id_barang'] ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group"><label>Nama</label><input type="text" name="nama_barang" value="<?= htmlspecialchars($barang['nama_barang']) ?>"></div>
        <div class="form-group"><label>Jumlah</label><input type="text" name="jumlah" value="<?= htmlspecialchars($barang['jumlah']) ?>"></div>
        <div class="form-group"><label>Harga</label><input type="text" name="harga" value="<?= htmlspecialchars($barang['harga']) ?>"></div>
        <div class="form-group"><label>Tanggal</label><input type="date" name="tanggal_masuk" value="<?= htmlspecialchars($barang['tanggal_masuk']) ?>"></div>
        <div class="form-group">
            <label>Gambar Baru (opsional)</label>
            <input type="file" name="gambar"><br><br>
            <img src="../uploads/<?= htmlspecialchars($barang['gambar']) ?>" class="thumb">
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="index.php" class="btn btn-danger">Batal</a>
    </form>
</div>
</body>
</html>