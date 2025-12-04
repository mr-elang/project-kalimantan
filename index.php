<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BorneoPedia - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-image: url('asset/background_kalimantan.png'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh; 
        }
        .glass-effect {
            background-color: rgba(255, 255, 255, 0.9) !important; /* 0.9 adalah tingkat transparansi */
            backdrop-filter: blur(5px); /* Efek blur di belakang kotak */
        }
    </style>
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container text-center mt-5">
        <div class="p-5 mb-4 rounded-3 shadow-sm glass-effect">
            <h1 class="display-5 fw-bold text-success">Selamat Datang di BorneoPedia</h1>
            <p class="col-md-8 fs-4 mx-auto">Ensiklopedia terlengkap tentang kekayaan budaya, flora, fauna, serta kuliner khas Kalimantan.</p>
            <a href="contents.php" class="btn btn-success btn-lg">Jelajahi Sekarang</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>