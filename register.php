<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST['username']);
    $pass = $_POST['password'];

    if (!empty($user) && !empty($pass)) {
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        try {
            $stmt->execute(['username' => $user, 'password' => $hashed_password]);
            header("Location: login.php");
            exit;
        } catch (PDOException $e) {
            $error = "Username sudah digunakan!";
        }
    } else {
        $error = "Username dan password tidak boleh kosong!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Daftar Akun</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container" style="max-width: 400px; margin-top: 50px;">
    <h2>Daftar Akun</h2>
    <?php if(isset($error)) echo "<div class='alert'>$error</div>"; ?>
    <form method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-success">Daftar</button>
        <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </form>
</div>
</body>
</html>
