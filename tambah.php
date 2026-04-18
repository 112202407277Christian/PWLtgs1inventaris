<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama_barang']);
    $jumlah = trim($_POST['jumlah']);
    $harga = trim($_POST['harga']);
    $tanggal = $_POST['tanggal_masuk'];
    $user_id = $_SESSION['user_id'];
    
    // Validasi Input Server-Side
    if (empty($nama) || !is_numeric($jumlah) || !is_numeric($harga) || empty($tanggal)) {
        $error = "Semua kolom harus diisi dengan format yang benar (Jumlah dan Harga harus angka).";
    } else {
        // Proses Upload Gambar
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        $ext = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));
        $valid_ext = ['jpg', 'jpeg', 'png'];
        $error_upload = $_FILES['gambar']['error'];
        
        // 1. Cek apakah ada error dari PHP saat upload (misal: ukuran terlalu besar)
        if ($error_upload !== UPLOAD_ERR_OK) {
            $error = "Gagal upload! Kode Error PHP: " . $error_upload;
        } 
        // 2. Cek format gambar
        elseif (in_array($ext, $valid_ext)) {
            $nama_gambar_baru = uniqid() . '.' . $ext;
            // Gunakan absolute path agar PHP tidak salah alamat
            $path_tujuan = __DIR__ . '/uploads/' . $nama_gambar_baru;
            
            // 3. Cek apakah file BENAR-BENAR berhasil dipindah ke folder
            if (move_uploaded_file($tmp, $path_tujuan)) {
                $stmt = $pdo->prepare("INSERT INTO barang (user_id, nama_barang, jumlah, harga, tanggal_masuk, gambar) VALUES (:user_id, :nama, :jumlah, :harga, :tanggal, :gambar)");
                $stmt->execute([
                    'user_id' => $user_id, 'nama' => $nama, 'jumlah' => $jumlah, 
                    'harga' => $harga, 'tanggal' => $tanggal, 'gambar' => $nama_gambar_baru
                ]);
                header("Location: index.php");
                exit;
            } else {
                $error = "Sistem gagal memindahkan gambar ke folder uploads! (Cek izin akses folder)";
            }
        } else {
            $error = "Format gambar harus JPG, JPEG, atau PNG.";
        }
    }
}
?>
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
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang">
        </div>
        <div class="form-group">
            <label>Jumlah</label>
            <input type="text" name="jumlah">
        </div>
        <div class="form-group">
            <label>Harga</label>
            <input type="text" name="harga">
        </div>
        <div class="form-group">
            <label>Tanggal Masuk</label>
            <input type="date" name="tanggal_masuk">
        </div>
        <div class="form-group">
            <label>Gambar Barang</label>
            <input type="file" name="gambar" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="index.php" class="btn btn-danger">Batal</a>
    </form>
</div>
</body>
</html>
