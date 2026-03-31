<?php
session_start();
include 'koneksi.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Inventaris</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: white; padding: 40px 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); width: 320px; text-align: center; }
        h2 { margin-top: 0; margin-bottom: 25px; color: #000; font-weight: bold; }
        input { width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; font-size: 14px; }
        input:focus { outline: none; border-color: #4a47f6; }
        button { width: 100%; padding: 12px; background-color: #4a47f6; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: bold; margin-top: 5px; }
        button:hover { background-color: #3b39c6; }
        .error { color: #dc3545; margin-bottom: 15px; font-size: 14px; }
        .buat-akun-link { display: block; text-align: right; margin-bottom: 15px; font-size: 13px; margin-top: -5px; }
        .buat-akun-link a { color: #4a47f6; text-decoration: none; }
        .buat-akun-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Login Sistem</h2>
        <?php if ($error) echo "<div class='error'>$error</div>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            
            <div class="buat-akun-link">
                <a href="register.php">Buat akun baru?</a>
            </div>
            
            <button type="submit">Masuk</button>
        </form>
    </div>
</body>
</html>