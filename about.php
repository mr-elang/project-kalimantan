<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - BorneoPedia</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700;900&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

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

        /* --- ABOUT PAGE STYLES --- */
        .about-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 60px 20px;
            text-align: center;
        }

        h1 {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 48px;
            color: #ffffff; /* Ubah jadi putih biar kontras sama background */
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        h2 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 28px;
            color: #ffffff;
            margin-bottom: 60px;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
        }

        .team-grid {
            display: flex;
            justify-content: center;
            gap: 40px; 
            flex-wrap: wrap; 
            max-width: 1200px;
            width: 100%;
        }

        .team-member {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 300px;
            background: rgba(255, 255, 255, 0.9); /* Kasih background putih transparan dikit */
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        
        .team-member:hover {
            transform: translateY(-10px);
        }

        .photo-box {
            width: 100%;
            height: 250px;
            background-color: #ffdcb8;
            margin-bottom: 20px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 15px; 
        }

        .photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .member-info {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 18px;
            color: #1a2e35;
        }
        
        .member-role {
            font-weight: 500;
            color: #2F9E58;
            margin-top: 5px;
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

            /* About Content Mobile */
            h1 { font-size: 32px; }
            h2 { font-size: 20px; margin-bottom: 40px; }
            
            .team-grid { gap: 30px; }
            .team-member { width: 100%; max-width: 300px; }
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

    <main class="about-container">
        <h1>OUR TEAMS</h1>
        <h2>Kelompok 4 - Kalimantan</h2>

        <div class="team-grid">
            
            <div class="team-member">
                <div class="photo-box">
                    <img src="asset/teams/rinaldi.jpg" alt="Rinaldi" onerror="this.src='https://via.placeholder.com/250?text=Foto+Tim'">
                </div>
                <div class="member-info">Rinaldi - H1D024065</div>
                <div class="member-role">Frontend</div>
            </div>

            <div class="team-member">
                <div class="photo-box">
                    <img src="asset/teams/farhan.jpg" alt="Farhan" onerror="this.src='https://via.placeholder.com/250?text=Foto+Tim'">
                </div>
                <div class="member-info">Farhan - H1D024064</div>
                <div class="member-role">UI/UX</div>
            </div>

            <div class="team-member">
                <div class="photo-box">
                    <img src="asset/teams/elang.jpg" alt="Elang" onerror="this.src='https://via.placeholder.com/250?text=Foto+Tim'">
                </div>
                <div class="member-info">Elang - H1D024070</div>
                <div class="member-role">Backend</div>
            </div>

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