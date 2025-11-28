<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BorneoPedia - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <?php include 'navbar.php'; ?>

    <div class="container text-center mt-5">
        <div class="p-5 mb-4 bg-white rounded-3 shadow-sm">
            <h1 class="display-5 fw-bold text-success">Selamat Datang di BorneoPedia</h1>
            <p class="col-md-8 fs-4 mx-auto">Ensiklopedia terlengkap tentang kekayaan budaya, flora, fauna, serta kuliner khas Kalimantan.</p>
            <a href="contents.php" class="btn btn-success btn-lg">Jelajahi Sekarang</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>