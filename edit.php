<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id_barang = $_GET['id'] ?? 0;
$user_id = $_SESSION['user_id'];

// Ambil data (pastikan milik user yang sedang login)
$stmt = $pdo->prepare("SELECT * FROM barang WHERE id_barang = :id AND user_id = :user_id");
$stmt->execute(['id' => $id_barang, 'user_id' => $user_id]);
$barang = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$barang) {
    die("Data tidak ditemukan atau Anda tidak memiliki akses.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama_barang']);
    $jumlah = trim($_POST['jumlah']);
    $harga = trim($_POST['harga']);
    $tanggal = $_POST['tanggal_masuk'];
    
    if (empty($nama) || !is_numeric($jumlah) || !is_numeric($harga) || empty($tanggal)) {
        $error = "Validasi gagal: Pastikan format input benar.";
    } else {
        $nama_gambar_baru = $barang['gambar']; // Default gambar lama
        
        // Cek jika ada upload gambar baru
        if (!empty($_FILES['gambar']['name'])) {
            $gambar = $_FILES['gambar']['name'];
            $tmp = $_FILES['gambar']['tmp_name'];
            $ext = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                $nama_gambar_baru = uniqid() . '.' . $ext;
                move_uploaded_file($tmp, 'uploads/' . $nama_gambar_baru);
                // Hapus gambar lama
                if(file_exists('uploads/' . $barang['gambar'])) unlink('uploads/' . $barang['gambar']);
            }
        }
        
        $stmt = $pdo->prepare("UPDATE barang SET nama_barang=:nama, jumlah=:jumlah, harga=:harga, tanggal_masuk=:tanggal, gambar=:gambar WHERE id_barang=:id AND user_id=:user_id");
        $stmt->execute([
            'nama' => $nama, 'jumlah' => $jumlah, 'harga' => $harga, 
            'tanggal' => $tanggal, 'gambar' => $nama_gambar_baru, 
            'id' => $id_barang, 'user_id' => $user_id
        ]);
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Edit Barang</h2>
    <?php if(isset($error)) echo "<div class='alert'>$error</div>"; ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" value="<?= htmlspecialchars($barang['nama_barang']) ?>">
        </div>
        <div class="form-group">
            <label>Jumlah</label>
            <input type="text" name="jumlah" value="<?= htmlspecialchars($barang['jumlah']) ?>">
        </div>
        <div class="form-group">
            <label>Harga</label>
            <input type="text" name="harga" value="<?= htmlspecialchars($barang['harga']) ?>">
        </div>
        <div class="form-group">
            <label>Tanggal Masuk</label>
            <input type="date" name="tanggal_masuk" value="<?= htmlspecialchars($barang['tanggal_masuk']) ?>">
        </div>
        <div class="form-group">
            <label>Gambar Barang (Biarkan kosong jika tidak ingin mengubah)</label>
            <input type="file" name="gambar">
            <br><br>
            <img src="uploads/<?= htmlspecialchars($barang['gambar']) ?>" class="thumb">
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="index.php" class="btn btn-danger">Batal</a>
    </form>
</div>
</body>
</html>
