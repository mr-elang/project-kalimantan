<?php
include 'koneksi.php';
session_start();

// Jika sudah login, lempar ke contents
if (isset($_SESSION['status']) && $_SESSION['status'] == 'login') {
    header("Location: contents.php");
    exit;
}

if(isset($_POST['daftar'])){
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $cek_user = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

    if(mysqli_num_rows($cek_user) > 0){
         echo "<script>alert('Username sudah terdaftar! Gunakan username lain.');</script>";
    } else {
        $query = mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('$username', '$password')");
        
        if($query){
            $registrasi_berhasil = true;
        } else {
            echo "<script>alert('Gagal daftar. Terjadi kesalahan database.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BorneoPedia - Registrasi</title>
    
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

        /* --- REGISTER PAGE STYLES --- */
        .register-container {
            flex: 1; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            padding: 20px;
        }

        .card-register {
            background-color: white; 
            padding: 40px 50px; 
            border-radius: 20px;
            width: 100%; 
            max-width: 450px; 
            box-shadow: 0 15px 30px rgba(0,0,0,0.2); 
            text-align: center;
        }

        .card-register h2 {
            font-family: 'Merriweather', serif; 
            color: #2F9E58; 
            font-size: 28px; 
            margin-bottom: 30px;
        }

        .form-group { text-align: left; margin-bottom: 20px; }
        .form-group label { display: block; color: #1a2e35; font-weight: 600; margin-bottom: 8px; font-size: 14px; }

        .form-group input {
            width: 100%; padding: 12px 20px; border-radius: 50px;
            border: 1px solid #ddd; background-color: #fff;
            font-family: 'Poppins', sans-serif; font-size: 14px; outline: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05); transition: border 0.3s;
        }

        .form-group input:focus { border-color: #3CCF68; }

        .btn-submit {
            width: 100%; background-color: #3CCF68; color: white; padding: 12px;
            border: none; border-radius: 50px; font-weight: 600; font-size: 16px;
            cursor: pointer; margin-top: 10px;
            box-shadow: 0 4px 10px rgba(60, 207, 104, 0.3); transition: background 0.3s, transform 0.2s;
        }

        .btn-submit:hover { background-color: #2eb858; transform: translateY(-2px); }
            
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
                display: none; 
                width: 100%;
                flex-direction: column;
                background-color: #258548;
                margin-top: 15px;
                padding: 20px;
                border-radius: 10px;
                gap: 20px;
                text-align: center;
            }
            .nav-menu.active { display: flex; }
            .nav-links, .nav-user { display: flex; flex-direction: column; gap: 15px; width: 100%; }
            .nav-links a, .nav-user a, .nav-user span { color: white; display: block; padding: 5px; }

            /* Card Responsiveness */
            .card-register { padding: 30px 20px; }
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
                <a href="login.php">Login</a>
                <a href="register.php" style="background:white; color:#2F9E58; padding:5px 15px; border-radius:20px; font-weight:bold;">Daftar</a>
            </div>
        </div>
    </nav>

    <main class="register-container">
        <div class="card-register">
            <h2>Registrasi</h2>
            
            <form action="" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Buat Username" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Buat Password" required>
                </div>

                <button type="submit" name="daftar" class="btn-submit">Daftar Sekarang</button>
            </form>
            
            <div style="margin-top: 20px; font-size: 14px; color: #666;">
                Sudah punya akun? <a href="login.php" style="color: #2F9E58; font-weight: bold;">Login disini</a>
            </div>
        </div>
    </main>

    <?php if(isset($registrasi_berhasil)): ?>
    <div class="modal-overlay modal-show">
        <div class="modal-box">
            <svg class="modal-icon" viewBox="0 0 24 24" fill="#3CCF68">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
            <div class="modal-title">Registrasi Berhasil!</div>
            <p class="modal-desc">Akun Anda telah dibuat. Silakan login untuk melanjutkan.</p>
            <a href="login.php" class="btn-modal btn-green">Login Sekarang</a>
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