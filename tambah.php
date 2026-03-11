<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama  = $_POST['nama_barang'];
    $jml   = $_POST['jumlah'];
    $harga = $_POST['harga'];
    $tgl   = $_POST['tanggal_masuk'];

    $sql = "INSERT INTO barang (nama_barang, jumlah, harga, tanggal_masuk) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$nama, $jml, $harga, $tgl])) {
        header("Location: index.php");
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Barang</title>
</head>
<body>
    <h2>Tambah Barang Baru</h2>
    <form method="POST">
        <label>Nama Barang:</label><br>
        <input type="text" name="nama_barang" required><br><br>
        <label>Jumlah:</label><br>
        <input type="number" name="jumlah" required><br><br>
        <label>Harga:</label><br>
        <input type="number" name="harga" required><br><br>
        <label>Tanggal Masuk:</label><br>
        <input type="date" name="tanggal_masuk" required><br><br>
        <button type="submit">Simpan</button>
        <a href="index.php">Batal</a>
    </form>
</body>
</html>