<?php
include 'koneksi.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Isi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-img-top { height: 200px; object-fit: cover; }
    </style>
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?>
    
    <div class="container mt-4">
        <h2 class="text-center mb-4 text-success border-bottom pb-2">Ensiklopedia Kalimantan</h2>
        
        <div class="row">
            <?php
            $query = mysqli_query($conn, "SELECT * FROM contents ORDER BY id DESC");
            if(mysqli_num_rows($query) > 0){
                while($data = mysqli_fetch_array($query)){
            ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow h-100">
                        <img src="<?= htmlspecialchars($data['foto']) ?>" class="card-img-top" alt="Gambar">
                        <div class="card-body">
    <span class="badge bg-warning text-dark mb-2"><?= $data['tipe'] ?></span>
    <h5 class="card-title"><?= htmlspecialchars($data['nama']) ?></h5>
    <p class="card-text"><?= substr(htmlspecialchars($data['informasi']), 0, 100) ?>...</p>
    
    <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $data['user_id']): ?>
        <div class="mt-3">
            <a href="edit.php?id=<?= $data['id'] ?>" class="btn btn-sm btn-info text-white">Edit</a>
            <a href="delete.php?id=<?= $data['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
        </div>
    <?php endif; ?>
</div>
                    </div>
                </div>
            <?php 
                }
            } else {
                echo "<p class='text-center'>Belum ada konten yang diupload.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>