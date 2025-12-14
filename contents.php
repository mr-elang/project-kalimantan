<?php
session_start();
include 'koneksi.php';

if(isset($_GET['cari'])){
    $keyword = $_GET['cari'];
    $query = mysqli_query($conn, "SELECT * FROM contents WHERE nama LIKE '%$keyword%' OR tipe LIKE '%$keyword%' ORDER BY id DESC");
} else {
    $query = mysqli_query($conn, "SELECT * FROM contents ORDER BY id DESC");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BorneoPedia - Contents</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        /* RESET CSS */
        * { margin: 0; padding: 0; box-sizing: border-box; text-decoration: none; }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('asset/bg_kedua.png');
            background-attachment: fixed; 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex; flex-direction: column;
        }

        /* --- NAVBAR STYLES (Didesain Ulang untuk Hamburger) --- */
        nav {
            background-color: #2F9E58;
            padding: 15px 50px; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: sticky; top: 0; z-index: 1000;
            display: flex; justify-content: space-between; align-items: center;
            flex-wrap: wrap; /* Penting agar menu bisa turun ke bawah */
        }

        .logo { font-size: 24px; font-weight: 800; color: #ffea00ff; display: flex; align-items: center; }
        .logo-img { height: 40px; width: auto; margin-right: 5px; }

        /* Tombol Hamburger (Default: Sembunyi di Laptop) */
        .hamburger {
            display: none; /* Sembunyi di layar besar */
            font-size: 28px;
            color: white;
            background: none;
            border: none;
            cursor: pointer;
        }

        /* Wadah Menu (Links + User Actions) */
        .nav-menu {
            display: flex;
            align-items: center;
            gap: 30px;
            width: auto;
        }

        .nav-links a, .nav-user a, .nav-user span {
            color: #1a2e35; font-weight: 600; font-size: 16px; transition: color 0.3s; margin: 0 10px;
        }
        .nav-links a:hover, .nav-user a:hover { color: #fff; }

        /* --- CONTENT STYLES --- */
        .content-container {
            flex: 1; padding: 40px 50px; display: flex; flex-direction: column; align-items: center;
        }

        .content-container h1 {
            font-family: 'Poppins', serif; color: #ffff; font-size: 42px; margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5); text-align: center;
        }

        /* Search Box */
        .search-box {
            background: white; width: 100%; max-width: 600px;
            border-radius: 50px; padding: 5px; display: flex;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05); margin-bottom: 40px;
        }
        .search-box input {
            flex: 1; border: none; outline: none; padding: 12px 25px;
            border-radius: 50px; font-family: 'Poppins', sans-serif; font-size: 16px; min-width: 0;
        }
        .search-box button {
            background-color: #3CCF68; color: white; border: none;
            padding: 10px 30px; border-radius: 50px; font-weight: 600; cursor: pointer; white-space: nowrap;
        }
        .search-box button:hover { background-color: #2eb858; }

        /* Grid & Card */
        .grid-container {
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px; width: 100%; max-width: 1200px;
        }

        .card {
            background: white; border-radius: 15px; overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05); transition: transform 0.3s;
            display: flex; flex-direction: column; height: 100%;
        }
        .card:hover { transform: translateY(-5px); }
        .card-img { width: 100%; height: 200px; object-fit: cover; background-color: #eee; }

        .card-body { padding: 20px; display: flex; flex-direction: column; flex: 1; }

        .badge-type {
            background-color: #e6f7ed; color: #2F9E58; padding: 5px 12px;
            border-radius: 20px; font-size: 12px; font-weight: 600;
            align-self: flex-start; margin-bottom: 10px;
        }
        .card-title { font-family: 'Merriweather', serif; font-size: 18px; color: #1a2e35; margin-bottom: 10px; line-height: 1.4;}
        .card-desc {
            font-size: 14px; color: #666; margin-bottom: 20px;
            display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; flex: 1;
        }
        
        .btn-detail {
            text-align: center; background-color: #3CCF68; color: white; padding: 10px;
            border-radius: 50px; font-size: 14px; font-weight: 700; margin-top: auto; display: block; 
        }
        .btn-detail:hover { background-color: #258548; }

        .empty-msg { 
            color: #fff; font-style: italic; margin-top: 20px; 
            background: rgba(0,0,0,0.5); padding: 10px 20px; border-radius: 10px; text-align: center;
        }

        /* --- MEDIA QUERIES (Mobile Responsiveness) --- */
        @media (max-width: 768px) {
            nav { padding: 15px 20px; }
            
            /* Tampilkan tombol Hamburger */
            .hamburger { display: block; }

            /* Sembunyikan Menu secara default di HP */
            .nav-menu {
                display: none; /* Hilang dulu */
                width: 100%;
                flex-direction: column;
                background-color: #258548; /* Warna latar menu dropdown */
                margin-top: 15px;
                padding: 20px;
                border-radius: 10px;
                gap: 20px;
                text-align: center;
            }

            /* Class ini akan ditambahkan lewat JavaScript saat tombol diklik */
            .nav-menu.active {
                display: flex; /* Munculkan menu */
            }

            .nav-links, .nav-user {
                display: flex;
                flex-direction: column;
                gap: 15px;
                width: 100%;
            }

            .nav-links a, .nav-user a, .nav-user span {
                color: white; /* Ubah warna teks jadi putih biar kontras */
                display: block;
                padding: 5px;
            }
            
            /* Penyesuaian Konten Lain */
            .content-container { padding: 30px 20px; }
            .content-container h1 { font-size: 32px; }
            .search-box { width: 100%; flex-direction: column; padding: 10px; border-radius: 20px; }
            .search-box input { width: 100%; margin-bottom: 10px; text-align: center; }
            .search-box button { width: 100%; }
        }

    </style>
</head>
<body>

    <nav>
        <a href="index.php" class="logo">
            <img src="asset/logofix.png" class="logo-img"> BorneoPedia
        </a>

        <button class="hamburger" onclick="toggleMenu()">
            ☰ </button>

        <div class="nav-menu" id="navMenu">
            <div class="nav-links">
                <a href="index.php">Home</a>
                <a href="about.php">About Us</a>
                <a href="contents.php">Contents</a>
            </div>
            
            <div class="nav-user">
                <?php if(isset($_SESSION['status']) && $_SESSION['status'] == 'login'): ?>
                    <!-- <span style="border-top: 1px solid rgba(255,255,255,0.2); padding-top:10px; display:block;"></span> <span>Hi, <?php echo $_SESSION['username']; ?></span> -->
                    <a href="upload.php" style="background:white; color:#2F9E58; padding:5px 15px; border-radius:20px;">Upload +</a>
                    <a href="logout.php" style="color:#ffcccc;">Logout</a>
                <?php else: ?>
                    <!-- <span style="border-top: 1px solid rgba(255,255,255,0.2); padding-top:10px; display:block;"></span> -->
                    <a href="login.php">Login</a>
                    <a href="register.php" style="background:white; color:#2F9E58; padding:5px 15px; border-radius:20px;">Daftar</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="content-container">
        <h1>KONTEN ENSIKLOPEDIA</h1>

        <form action="" method="GET" class="search-box">
            <input type="text" name="cari" placeholder="Cari budaya, makanan..." value="<?php echo isset($_GET['cari']) ? $_GET['cari'] : ''; ?>">
            <button type="submit">Cari</button>
        </form>

        <div class="grid-container">
            <?php if(mysqli_num_rows($query) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($query)): ?>
                    <div class="card">
                        <img src="<?php echo $row['foto']; ?>" alt="Gambar" class="card-img" onerror="this.src='https://via.placeholder.com/400x200?text=No+Image'">
                        
                        <div class="card-body">
                            <span class="badge-type"><?php echo $row['tipe']; ?></span>
                            <h3 class="card-title"><?php echo $row['nama']; ?></h3>
                            <p class="card-desc"><?php echo $row['informasi']; ?></p>
                            
                            <a href="detail.php?id=<?php echo $row['id']; ?>" class="btn-detail">Baca Selengkapnya</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                </div> 
                <p class="empty-msg">Data tidak ditemukan atau belum ada konten yang diupload.</p>
                <div style="display:none"> 
            <?php endif; ?>
        </div>
    </main>

    <script>
        function toggleMenu() {
            var menu = document.getElementById("navMenu");
            // Jika menu punya class 'active', hapus. Jika tidak, tambahkan.
            menu.classList.toggle("active");
        }
    </script>

</body>
</html>