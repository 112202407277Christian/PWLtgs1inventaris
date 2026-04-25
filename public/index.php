<?php
session_start();
require_once '../app/config.php';

// Proteksi halaman (wajib login)
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Memuat Model dan Controller
require_once '../app/models/BarangModel.php';
require_once '../app/controllers/BarangController.php';

$model = new BarangModel($pdo);
$controller = new BarangController($model);

// Membaca URL parameter
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? 0;

// Mengatur alur berdasarkan action
switch ($action) {
    case 'index': $controller->index(); break;
    case 'create': $controller->create(); break;
    case 'store': $controller->store(); break;
    case 'edit': $controller->edit($id); break;
    case 'update': $controller->update($id); break;
    case 'delete': $controller->destroy($id); break;
    default: $controller->index(); break;
}
?>