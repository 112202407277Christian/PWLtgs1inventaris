<?php
class BarangController {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function index() {
        $user_id = $_SESSION['user_id'];
        $barang = $this->model->getAll($user_id);
        require '../app/views/barang/index.php'; // Memanggil View HTML
    }

    public function create() {
        require '../app/views/barang/create.php';
    }

    public function store() {
        $user_id = $_SESSION['user_id'];
        $nama = trim($_POST['nama_barang']);
        $jumlah = trim($_POST['jumlah']);
        $harga = trim($_POST['harga']);
        $tanggal = $_POST['tanggal_masuk'];
        
        if (empty($nama) || !is_numeric($jumlah) || !is_numeric($harga) || empty($tanggal)) {
            $error = "Data tidak valid! Pastikan jumlah dan harga berupa angka.";
            require '../app/views/barang/create.php';
            return;
        }

        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        $ext = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));
        $nama_gambar_baru = uniqid() . '.' . $ext;
        
        if (move_uploaded_file($tmp, '../uploads/' . $nama_gambar_baru)) {
            $this->model->save([
                'user_id' => $user_id, 'nama' => $nama, 'jumlah' => $jumlah, 
                'harga' => $harga, 'tanggal' => $tanggal, 'gambar' => $nama_gambar_baru
            ]);
            header("Location: index.php");
        } else {
            $error = "Sistem gagal mengupload gambar!";
            require '../app/views/barang/create.php';
        }
    }

    public function edit($id) {
        $user_id = $_SESSION['user_id'];
        $barang = $this->model->getById($id, $user_id);
        require '../app/views/barang/edit.php';
    }

    public function update($id) {
        $user_id = $_SESSION['user_id'];
        $barang_lama = $this->model->getById($id, $user_id);

        $nama = trim($_POST['nama_barang']);
        $jumlah = trim($_POST['jumlah']);
        $harga = trim($_POST['harga']);
        $tanggal = $_POST['tanggal_masuk'];
        $nama_gambar_baru = $barang_lama['gambar'];

        if (!empty($_FILES['gambar']['name'])) {
            $gambar = $_FILES['gambar']['name'];
            $tmp = $_FILES['gambar']['tmp_name'];
            $ext = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                $nama_gambar_baru = uniqid() . '.' . $ext;
                move_uploaded_file($tmp, '../uploads/' . $nama_gambar_baru);
                if(file_exists('../uploads/' . $barang_lama['gambar'])) unlink('../uploads/' . $barang_lama['gambar']);
            }
        }

        $this->model->update([
            'nama' => $nama, 'jumlah' => $jumlah, 'harga' => $harga, 
            'tanggal' => $tanggal, 'gambar' => $nama_gambar_baru, 
            'id' => $id, 'user_id' => $user_id
        ]);
        header("Location: index.php");
    }

    public function destroy($id) {
        $user_id = $_SESSION['user_id'];
        $barang = $this->model->getById($id, $user_id);
        if ($barang && file_exists('../uploads/' . $barang['gambar'])) {
            unlink('../uploads/' . $barang['gambar']);
        }
        $this->model->delete($id, $user_id);
        header("Location: index.php");
    }
}
?>