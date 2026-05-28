<?php
error_reporting(0);
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method not allowed. Gunakan POST"]);
    exit;
}

// Ambil data dari form-data atau x-www-form-urlencoded
$id = $_POST['id_barang'] ?? 0;
$nama = trim($_POST['nama_barang'] ?? '');
$jumlah = trim($_POST['jumlah'] ?? '');
$harga = trim($_POST['harga'] ?? '');
$tanggal = $_POST['tanggal_masuk'] ?? '';

if (!$id || empty($nama) || !is_numeric($jumlah) || !is_numeric($harga) || empty($tanggal)) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Data tidak valid. Semua field harus diisi"]);
    exit;
}

// Ambil gambar lama dari database
$stmt = $pdo->prepare("SELECT gambar FROM barang WHERE id_barang = :id");
$stmt->execute(['id' => $id]);
$old = $stmt->fetch(PDO::FETCH_ASSOC);
$gambar_nama = $old ? $old['gambar'] : 'default.jpg';

// Proses upload gambar BARU jika ada file yang diupload
if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
    $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
    if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
        $gambar_baru = uniqid() . '.' . $ext;
        $target_path = '../uploads/' . $gambar_baru;
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_path)) {
            // Hapus gambar lama jika bukan default.jpg dan file ada
            if ($gambar_nama && $gambar_nama != 'default.jpg' && file_exists('../uploads/' . $gambar_nama)) {
                unlink('../uploads/' . $gambar_nama);
            }
            $gambar_nama = $gambar_baru;
        }
    }
}

// Update database
try {
    $stmt = $pdo->prepare("UPDATE barang SET nama_barang=:nama, jumlah=:jumlah, harga=:harga, tanggal_masuk=:tanggal, gambar=:gambar WHERE id_barang=:id");
    $stmt->execute([
        'nama' => $nama,
        'jumlah' => $jumlah,
        'harga' => $harga,
        'tanggal' => $tanggal,
        'gambar' => $gambar_nama,
        'id' => $id
    ]);
    echo json_encode(["status" => "success", "message" => "Barang berhasil diupdate", "gambar" => $gambar_nama]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>