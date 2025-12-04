<?php
include 'koneksi.php';
session_start();

// Tangkap ID dari URL
if(!isset($_GET['id'])){
    header("Location: contents.php");
    exit;
}

$id = $_GET['id'];

// --- PERBAIKAN 1: JOIN SQL ---
// Gunakan contents.user_id = users.id, BUKAN contents.id
$query = mysqli_query($conn, "SELECT contents.*, users.username 
                              FROM contents 
                              JOIN users ON contents.id = users.id 
                              WHERE contents.id = '$id'");

$data = mysqli_fetch_array($query);

// Cek jika data tidak ditemukan
if(!$data){
    echo "Data tidak ditemukan!";
    exit;
}

// --- PERBAIKAN 2: LOGIKA GAMBAR PINTAR ---
$foto_db = $data['foto'];
if (strpos($foto_db, 'http') === 0) {
    $src_gambar = $foto_db;
} else {
    $src_gambar = "uploads/" . $foto_db;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title><?= htmlspecialchars($data['nama']) ?> - BorneoPedia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <?php include 'navbar.php'; ?>

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <a href="contents.php" class="btn btn-outline-secondary mb-3">&larr; Kembali ke Daftar</a>

                <div class="card shadow-lg border-0">
                    
                    <img src="<?= htmlspecialchars($src_gambar) ?>" class="card-img-top" alt="<?= $data['nama'] ?>" style="max-height: 500px; object-fit: cover;">
                    
                    <div class="card-body p-4">
                        <h1 class="fw-bold text-success"><?= htmlspecialchars($data['nama']) ?></h1>
                        
                        <div class="text-muted mb-4 border-bottom pb-3">
                            <span class="badge bg-warning text-dark me-2"><?= $data['tipe'] ?></span>
                            <small class="me-3">Uploaded by: <b><?= htmlspecialchars($data['username']) ?></b></small>
                            <small>Tanggal: <?= date('d F Y', strtotime($data['created_at'])) ?></small>
                        </div>

                        <div class="content-text fs-5" style="text-align: justify; line-height: 1.8;">
                            <?= nl2br(htmlspecialchars($data['informasi'])) ?>
                        </div>

                        <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $data['id']): ?>
                            <div class="mt-5 pt-3 border-top">
                                <h5>Kelola Postingan Ini:</h5>
                                <a href="edit.php?id=<?= $data['id'] ?>" class="btn btn-info text-white">Edit</a>
                                <a href="delete.php?id=<?= $data['id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>