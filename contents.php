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
        * { margin: 0; padding: 0; box-sizing: border-box; text-decoration: none; }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('asset/bg_kedua.png');
            
            /* Background Fix: Supaya gambar background diam dan tidak zoom aneh saat scroll */
            background-attachment: fixed; 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat;
            
            min-height: 100vh;
            display: flex; flex-direction: column;
        }

        nav {
            background-color: #2F9E58;
            display: flex; justify-content: space-between; align-items: center;
            padding: 20px 50px; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            
            /* Navbar Fix: Supaya navbar nempel di atas */
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .nav-left { display: flex; align-items: center; gap: 40px; }
        .logo { font-size: 24px; font-weight: 800; color: #ffea00ff; display: flex; align-items: center; }
        .logo-img { height: 50px; width: auto; margin-right: 5px; vertical-align: middle; }
        
        .nav-links a, .nav-right a, .nav-right span {
            color: #1a2e35; font-weight: 600; font-size: 16px; transition: color 0.3s;
        }
        .nav-links a { margin-right: 25px; } .nav-right a { margin-left: 20px; }
        .nav-links a:hover, .nav-right a:hover { color: #fff; }

        .content-container {
            flex: 1; padding: 50px 50px; display: flex; flex-direction: column; align-items: center;
        }

        .content-container h1 {
            font-family: 'Poppins', serif; color: #ffff; font-size: 50px; margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .search-box {
            background: white; width: 100%; max-width: 600px;
            border-radius: 50px; padding: 5px; display: flex;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05); margin-bottom: 50px;
        }
        .search-box input {
            flex: 1; border: none; outline: none; padding: 15px 25px;
            border-radius: 50px; font-family: 'Poppins', sans-serif; font-size: 16px;
        }
        .search-box button {
            background-color: #3CCF68; color: white; border: none;
            padding: 10px 40px; border-radius: 50px; font-weight: 600; cursor: pointer;
        }
        .search-box button:hover { background-color: #2eb858; }

        .grid-container {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px; width: 100%; max-width: 1200px;
        }

        .card {
            background: white; border-radius: 20px; overflow: hidden;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05); transition: transform 0.3s;
            display: flex; flex-direction: column;
        }
        .card:hover { transform: translateY(-5px); }
        .card-img { width: 100%; height: 200px; object-fit: cover; background-color: #eee; }

        .card-body { padding: 20px; display: flex; flex-direction: column; flex: 1; }

        .badge-type {
            background-color: #e6f7ed; color: #2F9E58; padding: 5px 12px;
            border-radius: 20px; font-size: 12px; font-weight: 600;
            align-self: flex-start; margin-bottom: 10px;
        }
        .card-title { font-family: 'Merriweather', serif; font-size: 18px; color: #1a2e35; margin-bottom: 10px; }
        .card-desc {
            font-size: 14px; color: #666; margin-bottom: 20px;
            display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; flex: 1;
        }
        
        /* Style Tombol Baca Selengkapnya */
        .btn-detail {
            text-align: center; background-color: #3CCF68; color: white; padding: 12px;
            border-radius: 50px; font-size: 14px; font-weight: 700; margin-top: auto;
            display: block; 
        }
        .btn-detail:hover { background-color: #258548; }

        .empty-msg { 
            color: #fff; font-style: italic; margin-top: 20px; 
            background: rgba(0,0,0,0.5); padding: 10px 20px; border-radius: 10px;
        }

    </style>
</head>
<body>

    <nav>
        <div class="nav-left">
             <a href="index.php" class="logo">
            <img src="asset/logofix.png" class="logo-img"> BorneoPedia</a>
            <div class="nav-links">
                <a href="index.php">Home</a>
                <a href="about.php">About Us</a>
                <a href="contents.php">Contents</a>
            </div>
        </div>
        <div class="nav-right">
            <?php if(isset($_SESSION['status']) && $_SESSION['status'] == 'login'): ?>
                <span>Hi, <?php echo $_SESSION['username']; ?></span>
                <a href="upload.php">Upload +</a>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php">Daftar</a>
            <?php endif; ?>
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

</body>
</html>