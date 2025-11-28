<?php
include 'koneksi.php';
session_start();

// Cek keamanan: tendang user kalau belum login
if(!isset($_SESSION['status'])){
    header("Location: login.php");
    exit;
}

if(isset($_POST['simpan'])){
    $nama = $_POST['nama'];
    $tipe = $_POST['tipe'];
    $informasi = $_POST['informasi'];
    $foto = $_POST['foto'];

    $user_id = $_SESSION['user_id']; // Ambil ID dari session

    $query = mysqli_query($conn, "INSERT INTO contents (user_id, nama, tipe, informasi, foto) VALUES ('$user_id', '$nama', '$tipe', '$informasi', '$foto')");
    
    if($query){
        echo "<script>alert('Data berhasil diupload!'); window.location='contents.php';</script>";
    } else {
        echo "<script>alert('Gagal upload.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Konten</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?>
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-success text-white">Form Upload Ensiklopedia</div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label>Nama Budaya/Makanan/Flora</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Tipe</label>
                        <select name="tipe" class="form-select">
                            <option value="Flora">Flora</option>
                            <option value="Fauna">Fauna</option>
                            <option value="Makanan">Makanan</option>
                            <option value="Minuman">Minuman</option>
                            <option value="Budaya">Budaya</option>
                            <option value="Suku">Suku</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Link Foto (URL Eksternal)</label>
                        <input type="url" name="foto" class="form-control" placeholder="https://..." required>
                        <small class="text-muted">Copy link gambar dari Google Images.</small>
                    </div>
                    <div class="mb-3">
                        <label>Informasi Lengkap</label>
                        <textarea name="informasi" class="form-control" rows="5" required></textarea>
                    </div>
                    <button type="submit" name="simpan" class="btn btn-success">Simpan Data</button>
                    <a href="contents.php" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>