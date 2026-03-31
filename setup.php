<?php
include 'koneksi.php';

$username = 'admin';
$password = password_hash('admin123', PASSWORD_DEFAULT);

try {
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $password]);
    echo "<h3>Akun berhasil dibuat!</h3>";
    echo "Username: <strong>admin</strong><br>";
    echo "Password: <strong>admin123</strong><br><br>";
    echo "<a href='login.php'>Klik di sini untuk Login</a>";
} catch (PDOException $e) {
    echo "Akun sudah ada atau terjadi kesalahan: " . $e->getMessage();
}
?>