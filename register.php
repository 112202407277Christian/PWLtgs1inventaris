<?php
session_start();
include 'koneksi.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Cek apakah password dan konfirmasi password sama
    if ($password !== $confirm_password) {
        $error = "Konfirmasi password tidak cocok!";
    } else {
        // Cek apakah username sudah dipakai di database
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        
        if ($stmt->fetch()) {
            $error = "Username sudah terdaftar! Silakan gunakan username lain.";
        } else {
            // Enkripsi password dan simpan ke database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            
            if ($stmt->execute([$username, $hashed_password])) {
                $success = "Akun berhasil dibuat! Silakan masuk.";
            } else {
                $error = "Terjadi kesalahan sistem. Gagal membuat akun.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun - Inventaris</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: white; padding: 40px 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); width: 320px; text-align: center; }
        h2 { margin-top: 0; margin-bottom: 25px; color: #000; font-weight: bold; }
        input { width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; font-size: 14px; }
        input:focus { outline: none; border-color: #28a745; }
        button { width: 100%; padding: 12px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: bold; margin-top: 5px; }
        button:hover { background-color: #218838; }
        .error { color: #dc3545; margin-bottom: 15px; font-size: 14px; }
        .success { color: #28a745; margin-bottom: 15px; font-size: 14px; font-weight: bold; }
        .kembali-login { display: block; text-align: center; margin-top: 20px; font-size: 14px; }
        .kembali-login a { color: #4a47f6; text-decoration: none; }
        .kembali-login a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Buat Akun</h2>
        
        <?php if ($error) echo "<div class='error'>$error</div>"; ?>
        <?php if ($success) echo "<div class='success'>$success</div>"; ?>
        
        <form method="POST">
            <input type="text" name="username" placeholder="Username Baru" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Ulangi Password" required>
            
            <button type="submit">Daftar Sekarang</button>
            
            <div class="kembali-login">
                Sudah punya akun? <a href="login.php">Masuk di sini</a>
            </div>
        </form>
    </div>
</body>
</html>