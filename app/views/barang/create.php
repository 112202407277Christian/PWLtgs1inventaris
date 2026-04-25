<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Tambah Barang</h2>
    <?php if(isset($error)) echo "<div class='alert'>$error</div>"; ?>
    <form action="index.php?action=store" method="POST" enctype="multipart/form-data">
        <div class="form-group"><label>Nama</label><input type="text" name="nama_barang"></div>
        <div class="form-group"><label>Jumlah</label><input type="text" name="jumlah"></div>
        <div class="form-group"><label>Harga</label><input type="text" name="harga"></div>
        <div class="form-group"><label>Tanggal</label><input type="date" name="tanggal_masuk"></div>
        <div class="form-group"><label>Gambar</label><input type="file" name="gambar" required></div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="index.php" class="btn btn-danger">Batal</a>
    </form>
</div>
</body>
</html>