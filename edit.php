<?php
include 'cek_login.php';
include 'koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

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
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Barang</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 40px; background-color: #f4f7f6; }
        .container { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-width: 500px; margin: auto; }
        input { width: 100%; padding: 10px; margin: 10px 0 20px 0; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button { padding: 10px 15px; background-color: #ffc107; color: #000; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 14px;}
        a.batal { padding: 10px 15px; background-color: #6c757d; color: white; text-decoration: none; border-radius: 4px; margin-left: 10px; font-size: 14px;}
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Detail Barang</h2>
        <form method="POST">
            <label>Nama Barang:</label>
            <input type="text" name="nama_barang" value="<?= htmlspecialchars($data['nama_barang']); ?>" required>
            
            <label>Jumlah:</label>
            <input type="number" name="jumlah" value="<?= $data['jumlah']; ?>" min="0" required>
            
            <label>Harga (Rp):</label>
            <input type="number" name="harga" value="<?= $data['harga']; ?>" min="0" required>
            
            <label>Tanggal Masuk:</label>
            <input type="date" name="tanggal_masuk" value="<?= $data['tanggal_masuk']; ?>" required>
            
            <button type="submit">Update Data</button>
            <a href="index.php" class="batal">Batal</a>
        </form>
    </div>
</body>
</html>
