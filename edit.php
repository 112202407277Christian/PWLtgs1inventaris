<?php
include 'koneksi.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM barang WHERE id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) die("Data tidak ditemukan!");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama  = $_POST['nama_barang'];
    $jml   = $_POST['jumlah'];
    $harga = $_POST['harga'];
    $tgl   = $_POST['tanggal_masuk'];

    $sql = "UPDATE barang SET nama_barang=?, jumlah=?, harga=?, tanggal_masuk=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$nama, $jml, $harga, $tgl, $id])) {
        header("Location: index.php");
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>
</head>
<body>
    <h2>Edit Detail Barang</h2>
    <form method="POST">
        <input type="text" name="nama_barang" value="<?= $data['nama_barang']; ?>" required><br><br>
        <input type="number" name="jumlah" value="<?= $data['jumlah']; ?>" required><br><br>
        <input type="number" name="harga" value="<?= $data['harga']; ?>" required><br><br>
        <input type="date" name="tanggal_masuk" value="<?= $data['tanggal_masuk']; ?>" required><br><br>
        <button type="submit">Update</button>
        <a href="index.php">Batal</a>
    </form>
</body>
</html>