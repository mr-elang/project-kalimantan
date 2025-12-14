<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BorneoPedia - Home</title>
    
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

        /* --- HERO SECTION STYLES --- */
        .hero-container {
            flex: 1; 
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .card {
            background-color: white;
            padding: 60px 80px;
            border-radius: 30px;
            text-align: center;
            max-width: 800px;
            width: 100%;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1); 
        }

        .card h1 {
            font-family: 'Merriweather', serif; 
            color: #3ccf68;
            font-size: 36px;
            margin-bottom: 20px;
            line-height: 1.3;
        }

        .card p {
            color: #555;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-cta {
            background-color: #3CCF68;
            color: white;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 4px 15px rgba(60, 207, 104, 0.4);
            transition: transform 0.2s, background-color 0.2s;
            display: inline-block;
        }

        .btn-cta:hover {
            background-color: #2eb858;
            transform: translateY(-2px);
        }

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

            /* Hero Card Responsiveness */
            .card { padding: 40px 25px; border-radius: 20px; }
            .card h1 { font-size: 28px; }
            .card p { font-size: 14px; }
            .btn-cta { width: 100%; }
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
                <?php if(isset($_SESSION['status']) && $_SESSION['status'] == 'login'): ?>
                    <!-- <span style="border-top: 1px solid rgba(255,255,255,0.2); padding-top:10px; display:block;"></span> -->
                    <span>Hi, <?php echo $_SESSION['username']; ?></span>
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

    <main class="hero-container">
        <div class="card">
            <h1>Selamat Datang di BorneoPedia</h1>
            <p>
                Forum Ensiklopedia terlengkap tentang kekayaan budaya, flora, fauna, serta kuliner khas Kalimantan.
            </p>
            <a href="contents.php" class="btn-cta">Jelajahi Sekarang</a>
        </div>
    </main>

    <script>
        function toggleMenu() {
            var menu = document.getElementById("navMenu");
            menu.classList.toggle("active");
        }
    </script>

</body>
</html>