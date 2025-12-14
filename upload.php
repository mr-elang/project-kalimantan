<?php
include 'koneksi.php';
session_start();

// Cek Login: Jika belum login, tendang ke login.php
if(!isset($_SESSION['status']) || $_SESSION['status'] != 'login'){
    header("Location: login.php");
    exit;
}

if(isset($_POST['simpan'])){
    $nama = $_POST['nama'];
    $tipe = $_POST['tipe'];
    $informasi = $_POST['informasi'];
    $foto = $_POST['foto']; 
    $user_id = $_SESSION['user_id'];

    $query = mysqli_query($conn, "INSERT INTO contents (user_id, nama, tipe, informasi, foto) VALUES ('$user_id', '$nama', '$tipe', '$informasi', '$foto')");
    
    if($query){
        $berhasil_simpan = true;
    } else {
        echo "<script>alert('Gagal simpan: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BorneoPedia - Upload</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        /* RESET CSS GLOBAL */
        * { margin: 0; padding: 0; box-sizing: border-box; text-decoration: none; }
        
        /* Reset html dan body standar */
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('asset/bg_kedua.png');
            
            /* BACKGROUND FIX */
            background-attachment: fixed; 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat;
            
            min-height: 100vh;
            display: flex; flex-direction: column;
        }

        /* --- NAVBAR STYLES (Hamburger Ready) --- */
        nav {
            background-color: #2F9E58;
            padding: 15px 50px; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: sticky; top: 0; z-index: 1000;
            display: flex; justify-content: space-between; align-items: center;
            flex-wrap: wrap;
        }

        .logo { font-size: 24px; font-weight: 800; color: #ffea00ff; display: flex; align-items: center; }
        .logo-img { height: 40px; width: auto; margin-right: 5px; }

        /* Tombol Hamburger */
        .hamburger {
            display: none;
            font-size: 28px;
            color: white;
            background: none;
            border: none;
            cursor: pointer;
        }

        /* Menu Container */
        .nav-menu {
            display: flex; align-items: center; gap: 30px; width: auto;
        }

        .nav-links a, .nav-user a, .nav-user span {
            color: #1a2e35; font-weight: 600; font-size: 16px; transition: color 0.3s; margin: 0 10px;
        }
        .nav-links a:hover, .nav-user a:hover { color: #fff; }

        /* --- UPLOAD PAGE STYLES --- */
        .upload-container {
            flex: 1; display: flex; justify-content: center; align-items: center; padding: 40px 20px;
        }

        .card-upload {
            background-color: #38A169; /* Warna Hijau agar senada dengan Edit */
            padding: 40px 50px;
            border-radius: 20px;
            width: 100%; max-width: 700px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
            color: #1a2e35;
            position: relative; 
        }

        .btn-back-arrow {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex; justify-content: center; align-items: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            transition: transform 0.2s, background-color 0.2s;
            z-index: 10;
        }
        .btn-back-arrow:hover { background-color: white; transform: scale(1.1); }
        .icon-back { width: 24px; height: 24px; fill: #2F9E58; }

        .card-upload h2 {
            font-family: 'Merriweather', serif; color: white; font-size: 26px;
            margin-bottom: 25px; text-align: center;
        }

        .form-group { margin-bottom: 20px; }
        .form-group label {
            display: block; font-weight: 500; margin-bottom: 8px; font-size: 15px; color: white; /* Label Putih */
        }

        .form-control {
            width: 100%; padding: 12px 20px; border-radius: 50px; border: none;
            background-color: #ffffff; font-family: 'Poppins', sans-serif; font-size: 14px; outline: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        textarea.form-control { border-radius: 20px; resize: vertical; }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23000000%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E");
            background-repeat: no-repeat; background-position: right 20px center; background-size: 12px; cursor: pointer;
        }

        .button-group {
            display: flex; gap: 15px; margin-top: 30px;
        }
        .btn {
            padding: 12px 30px; border-radius: 50px; font-weight: 600; font-size: 15px;
            border: none; cursor: pointer; transition: transform 0.2s, opacity 0.2s;
        }
        .btn-simpan {
            background-color: #3CCF68; color: white; width: 100%;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .btn:hover { opacity: 0.9; transform: translateY(-2px); }
        
        .small-note {
            font-size: 12px; color: #e6f7ed; margin-top: 5px; display: block; font-style: italic;
        }

        /* MODAL POPUP */
        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center;
            z-index: 9999; visibility: hidden; opacity: 0; transition: 0.3s;
        }
        .modal-show { visibility: visible; opacity: 1; }
        .modal-box {
            background: white; padding: 30px; border-radius: 20px;
            width: 90%; max-width: 350px; text-align: center;
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
            transform: scale(0.8); transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .modal-show .modal-box { transform: scale(1); }
        .modal-icon { width: 60px; height: 60px; margin-bottom: 15px; }
        .modal-title { font-size: 20px; font-weight: 700; color: #1a2e35; margin-bottom: 10px; font-family: 'Merriweather', serif; }
        .modal-desc { font-size: 14px; color: #666; margin-bottom: 25px; font-family: 'Poppins', sans-serif;}
        .btn-modal {
            padding: 10px 30px; border-radius: 50px; border: none; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-block; font-family: 'Poppins', sans-serif;
        }
        .btn-green { background-color: #3CCF68; color: white; }

        /* --- MEDIA QUERIES (Mobile Responsiveness) --- */
        @media (max-width: 768px) {
            nav { padding: 15px 20px; }
            .hamburger { display: block; }
            
            /* Navbar Mobile Logic */
            .nav-menu {
                display: none; width: 100%; flex-direction: column;
                background-color: #258548; margin-top: 15px; padding: 20px;
                border-radius: 10px; gap: 20px; text-align: center;
            }
            .nav-menu.active { display: flex; }
            .nav-links, .nav-user { display: flex; flex-direction: column; gap: 15px; width: 100%; }
            .nav-links a, .nav-user a, .nav-user span { color: white; display: block; padding: 5px; }

            /* Upload Card Mobile */
            .upload-container { padding: 30px 15px; }
            .card-upload { padding: 30px 20px; }
            .card-upload h2 { margin-top: 30px; font-size: 22px; }
        }
    </style>
</head>
<body>

    <nav>
        <a href="index.php" class="logo">
            <img src="asset/logofix.png" class="logo-img"> BorneoPedia
        </a>

        <button class="hamburger" onclick="toggleMenu()">
            ☰
        </button>

        <div class="nav-menu" id="navMenu">
            <div class="nav-links">
                <a href="index.php">Home</a>
                <a href="about.php">About Us</a>
                <a href="contents.php">Contents</a>
            </div>
            
            <div class="nav-user">
                <!-- <span style="border-top: 1px solid rgba(255,255,255,0.2); padding-top:10px; display:block;"></span> -->
                <span>Hi, <?php echo $_SESSION['username']; ?></span>
                <a href="upload.php" style="background:white; color:#2F9E58; padding:5px 15px; border-radius:20px;">Upload +</a>
                <a href="logout.php" style="color:#ffcccc;">Logout</a>
            </div>
        </div>
    </nav>

    <main class="upload-container">
        <div class="card-upload">
            
            <a href="contents.php" class="btn-back-arrow" title="Kembali">
                <svg class="icon-back" viewBox="0 0 24 24">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                </svg>
            </a>

            <h2>Upload Konten Baru</h2>
            
            <form action="" method="POST">
                
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" placeholder="Contoh: Orangutan, Soto Banjar" required>
                </div>

                <div class="form-group">
                    <label>Tipe</label>
                    <select name="tipe" class="form-control">
                        <option value="Flora">Flora</option>
                        <option value="Fauna">Fauna</option>
                        <option value="Makanan">Makanan</option>
                        <option value="Minuman">Minuman</option>
                        <option value="Budaya">Budaya</option>
                        <option value="Suku">Suku</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Link Foto (URL Eksternal)</label>
                    <input type="url" name="foto" class="form-control" placeholder="https://..." required>
                    <small class="small-note">Tips: Salin 'Image Address' dari Google Images.</small>
                </div>

                <div class="form-group">
                    <label>Info lengkap</label>
                    <textarea name="informasi" class="form-control" rows="4" placeholder="Masukan deskripsi..." required></textarea>
                </div>

                <div class="button-group">
                    <button type="submit" name="simpan" class="btn btn-simpan">Upload Sekarang</button>
                </div>

            </form>
        </div>
    </main>

    <?php if(isset($berhasil_simpan)): ?>
    <div class="modal-overlay modal-show">
        <div class="modal-box">
            <svg class="modal-icon" viewBox="0 0 24 24" fill="#3CCF68">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
            <div class="modal-title">Berhasil!</div>
            <p class="modal-desc">Konten berhasil diupload ke BorneoPedia.</p>
            <a href="contents.php" class="btn-modal btn-green">Oke, Lanjut</a>
        </div>
    </div>
    <?php endif; ?>

    <script>
        function toggleMenu() {
            var menu = document.getElementById("navMenu");
            menu.classList.toggle("active");
        }
    </script>

</body>
</html>