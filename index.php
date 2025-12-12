<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BorneoPedia - Home</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-decoration: none;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('asset/bg_kedua.png');
            background-size: cover;      
            background-position: center; 
            background-repeat: no-repeat;

            height: 100vh;
            display: flex;
            flex-direction: column;
        
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        nav {
            background-color: #2F9E58; 
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 40px;
        }

        .logo-img {
        height: 50px;
        width: auto; 
        margin-right: 5px; 
        vertical-align: middle; 
        }

        .logo {
        font-size: 24px;
        font-weight: 800;
        color: #ffea00ff;
        display: flex; 
        align-items: center; 

        }

        .nav-links a {
            color: #1a2e35;
            font-weight: 600;
            margin-right: 25px;
            font-size: 16px;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #fff;
        }

        .nav-right a {
            color: #1a2e35;
            font-weight: 600;
            margin-left: 20px;
            font-size: 16px;
        }
        
        .nav-right a:hover {
            color: #fff;
        }

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
            box-shadow: 0 20px 40px rgba(0,0,0,0.1); 
        }

        .card h1 {
            font-family: 'Merriweather', serif; 
            color: #3ccf68;
            font-size: 32px;
            margin-bottom: 20px;
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
            <a href="login.php">Login</a>
            <a href="register.php">Daftar</a>
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

</body>
</html>