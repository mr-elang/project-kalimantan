<?php
include 'koneksi.php';
session_start();

// Cek Login
if(!isset($_SESSION['status'])){
    header("Location: login.php");
    exit;
}

// Ambil ID dari URL
$id = $_GET['id'];
$user_id_session = $_SESSION['user_id'];

// Ambil data lama, TAPI pastikan yang ambil adalah pemiliknya (WHERE user_id = ...)
$query = mysqli_query($conn, "SELECT * FROM contents WHERE id = '$id' AND user_id = '$user_id_session'");
$data = mysqli_fetch_array($query);

// Jika data tidak ditemukan (artinya dia mencoba edit punya orang lain)
if(mysqli_num_rows($query) < 1){
    die("Akses dilarang! Anda bukan pemilik konten ini.");
}

// Proses Update
if(isset($_POST['update'])){
    $nama = $_POST['nama'];
    $tipe = $_POST['tipe'];
    $informasi = $_POST['informasi'];
    $foto = $_POST['foto'];

    $update = mysqli_query($conn, "UPDATE contents SET nama='$nama', tipe='$tipe', informasi='$informasi', foto='$foto' WHERE id='$id'");
    
    if($update){
        echo "<script>alert('Data berhasil diupdate!'); window.location='contents.php';</script>";
    } else {
        echo "<script>alert('Gagal update.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Konten</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?>
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-info text-white">Edit Data</div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['nama']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Tipe</label>
                        <select name="tipe" class="form-select">
                            <option value="<?= $data['tipe'] ?>" selected><?= $data['tipe'] ?> (Saat ini)</option>
                            <option value="Flora">Flora</option>
                            <option value="Fauna">Fauna</option>
                            <option value="Makanan">Makanan</option>
                            <option value="Minuman">Minuman</option>
                            <option value="Budaya">Budaya</option>
                            <option value="Suku">Suku</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Link Foto</label>
                        <input type="url" name="foto" class="form-control" value="<?= htmlspecialchars($data['foto']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Informasi</label>
                        <textarea name="informasi" class="form-control" rows="5" required><?= htmlspecialchars($data['informasi']) ?></textarea>
                    </div>
                    <button type="submit" name="update" class="btn btn-info text-white">Update Data</button>
                    <a href="contents.php" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>