<?php
require_once 'config.php';

try {
    $stmt = $pdo->prepare("SELECT * FROM barang ORDER BY id_barang DESC");
    $stmt->execute();
    $barang = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($barang) {
        echo json_encode([
            "status" => "success",
            "data" => $barang
        ]);
    } else {
        echo json_encode([
            "status" => "empty",
            "message" => "Belum ada data barang"
        ]);
    }
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>