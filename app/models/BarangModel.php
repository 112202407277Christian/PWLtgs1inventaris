<?php
class BarangModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll($user_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM barang WHERE user_id = :user_id ORDER BY id_barang DESC");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id_barang, $user_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM barang WHERE id_barang = :id AND user_id = :user_id");
        $stmt->execute(['id' => $id_barang, 'user_id' => $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function save($data) {
        $stmt = $this->pdo->prepare("INSERT INTO barang (user_id, nama_barang, jumlah, harga, tanggal_masuk, gambar) VALUES (:user_id, :nama, :jumlah, :harga, :tanggal, :gambar)");
        return $stmt->execute($data);
    }

    public function update($data) {
        $stmt = $this->pdo->prepare("UPDATE barang SET nama_barang=:nama, jumlah=:jumlah, harga=:harga, tanggal_masuk=:tanggal, gambar=:gambar WHERE id_barang=:id AND user_id=:user_id");
        return $stmt->execute($data);
    }

    public function delete($id_barang, $user_id) {
        $stmt = $this->pdo->prepare("DELETE FROM barang WHERE id_barang = :id AND user_id = :user_id");
        return $stmt->execute(['id' => $id_barang, 'user_id' => $user_id]);
    }
}
?>