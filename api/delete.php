<?php
error_reporting(0);
require_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method !== 'DELETE' && $method !== 'POST') {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method not allowed. Gunakan DELETE atau POST"]);
    exit;
}

// Ambil id (prioritas: dari DELETE parameter URL, lalu dari body POST)
$id = 0;
if ($method === 'DELETE') {
    // DELETE /delete.php?id=123
    $id = $_GET['id'] ?? 0;
} else {
    // POST: bisa dari form-data atau JSON
    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
    if (strpos($contentType, 'application/json') !== false) {
        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);
        $id = $data['id_barang'] ?? 0;
    } else {
        $id = $_POST['id_barang'] ?? 0;
    }
}

if (!$id) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "id_barang diperlukan"]);
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM barang WHERE id_barang = :id");
    $stmt->execute(['id' => $id]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(["status" => "success", "message" => "Barang berhasil dihapus"]);
    } else {
        echo json_encode(["status" => "error", "message" => "ID tidak ditemukan"]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
?>