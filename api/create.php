<?php
error_reporting(0);
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method not allowed. Gunakan POST"]);
    exit;
}

// Ambil data dari berbagai source
$input = [];
$contentType = $_SERVER['CONTENT_TYPE'] ?? '';

if (strpos($contentType, 'application/json') !== false) {
    $raw = file_get_contents('php://input');
    $input = json_decode($raw, true);
} elseif (strpos($contentType, 'multipart/form-data') !== false) {
    $input = $_POST;
} else {
    $input = $_POST; // x-www-form-urlencoded
}

$nama = trim($input['nama_barang'] ?? '');
$jumlah = trim($input['jumlah'] ?? '');
$harga = trim($input['harga'] ?? '');
$tanggal = $input['tanggal_masuk'] ?? '';

if (empty($nama) || !is_numeric($jumlah) || !is_numeric($harga) || empty($tanggal)) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Data tidak valid",
        "received" => $input // untuk debugging, hapus nanti
    ]);
    exit;
}

// Upload gambar jika ada
$gambar_nama = 'default.jpg';
if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
    $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
    if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
        $gambar_nama = uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['gambar']['tmp_name'], '../uploads/' . $gambar_nama);
    }
} elseif (isset($input['gambar']) && !empty($input['gambar'])) {
    // jika kirim nama gambar via text (opsional)
    $gambar_nama = $input['gambar'];
}

try {
    $stmt = $pdo->prepare("INSERT INTO barang (user_id, nama_barang, jumlah, harga, tanggal_masuk, gambar) VALUES (1, :nama, :jumlah, :harga, :tanggal, :gambar)");
    $stmt->execute([
        'nama' => $nama,
        'jumlah' => $jumlah,
        'harga' => $harga,
        'tanggal' => $tanggal,
        'gambar' => $gambar_nama
    ]);
    echo json_encode(["status" => "success", "message" => "Barang berhasil ditambahkan", "gambar" => $gambar_nama]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>