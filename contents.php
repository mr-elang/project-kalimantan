<?php
include 'koneksi.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Isi - BorneoPedia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-img-top { height: 200px; object-fit: cover; transition: 0.3s; }
        .card:hover .card-img-top { transform: scale(1.05); }
        .card { overflow: hidden; }
    </style>
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?>
    
    <div class="container mt-4">
        <h2 class="text-center mb-4 text-success border-bottom pb-2">Ensiklopedia Kalimantan</h2>
        
        <form action="" method="GET" class="mb-4">
            <div class="input-group" style="max-width: 500px; margin: 0 auto;">
                <input type="text" name="cari" class="form-control" placeholder="Cari kuliner, budaya, flora..." value="<?= isset($_GET['cari']) ? $_GET['cari'] : '' ?>">
                <button type="submit" class="btn btn-success">Cari</button>
            </div>
        </form>

        <div class="row">
        <?php
        // LOGIKA PENCARIAN
        if(isset($_GET['cari'])){
            $keyword = $_GET['cari'];
            $query = mysqli_query($conn, "SELECT * FROM contents WHERE nama LIKE '%$keyword%' OR tipe LIKE '%$keyword%' ORDER BY id DESC");
        } else {
            $query = mysqli_query($conn, "SELECT * FROM contents ORDER BY id DESC");
        }

        if(mysqli_num_rows($query) == 0){
            echo '<div class="col-12 text-center text-muted">Data tidak ditemukan.</div>';
        }
        
        while($data = mysqli_fetch_array($query)){
            // LOGIKA GAMBAR PINTAR
            $foto_db = $data['foto'];
            if (strpos($foto_db, 'http') === 0) {
                $src_gambar = $foto_db; 
            } else {
                $src_gambar = "uploads/" . $foto_db;
            }
        ?>
        
            <div class="col-md-4 mb-4">
                <div class="card shadow h-100 border-0">
                    <a href="detail.php?id=<?= $data['id'] ?>">
                        <img src="<?= htmlspecialchars($src_gambar) ?>" class="card-img-top" alt="Gambar">
                    </a>
                    
                    <div class="card-body d-flex flex-column">
                        <span class="badge bg-success w-25 mb-2"><?= $data['tipe'] ?></span>
                        
                        <h5 class="card-title fw-bold">
                            <a href="detail.php?id=<?= $data['id'] ?>" class="text-decoration-none text-dark">
                                <?= htmlspecialchars($data['nama']) ?>
                            </a>
                        </h5>
                        
                        <p class="card-text text-muted">
                            <?= substr(htmlspecialchars($data['informasi']), 0, 100) ?>...
                        </p>
                        
                        <div class="mt-auto">
                            <a href="detail.php?id=<?= $data['id'] ?>" class="btn btn-outline-success w-100 mb-2">Baca Selengkapnya &rarr;</a>

                            <!-- PERBAIKAN DI SINI: ganti $data['id'] jadi $data['user_id'] -->
                            <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $data['user_id']): ?>
                                <div class="d-flex gap-2">
                                    <a href="edit.php?id=<?= $data['id'] ?>" class="btn btn-info btn-sm w-50 text-white">Edit</a>
                                    <a href="delete.php?id=<?= $data['id'] ?>" class="btn btn-danger btn-sm w-50" onclick="return confirm('Yakin ingin menghapus postingan ini?')">Hapus</a>
                                </div>
                            <?php endif; ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>