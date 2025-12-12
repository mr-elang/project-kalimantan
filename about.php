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
        * { margin: 0; padding: 0; box-sizing: border-box; text-decoration: none; }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(180deg, #FFFFFF 0%, #E3EBF5 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        nav {
            background-color: #2F9E58;
            display: flex; justify-content: space-between; align-items: center;
            padding: 20px 50px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .nav-left { display: flex; align-items: center; gap: 40px; }
        .logo { font-size: 24px; font-weight: 800; color: #1a2e35; }
        .nav-links a, .nav-right a, .nav-right span {
            color: #1a2e35; font-weight: 600; font-size: 16px; transition: color 0.3s;
        }
        .nav-links a { margin-right: 25px; } .nav-right a { margin-left: 20px; }
        .nav-links a:hover, .nav-right a:hover { color: #fff; }

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

        .about-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 60px 20px;
            text-align: center;
        }

        h1 {
            font-family: 'Poppins', sans-serif; /* Di gambar terlihat bold sans-serif */
            font-weight: 800;
            font-size: 48px;
            color: #1a2e35;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        h2 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 28px;
            color: #1a2e35;
            margin-bottom: 60px;
        }

        .team-grid {
            display: flex;
            justify-content: center;
            gap: 40px; 
            flex-wrap: wrap; 
            max-width: 1200px;
        }

        .team-member {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 300px;
        }

        .photo-box {
            width: 250px;
            height: 250px;
            background-color: #ffdcb8;
            margin-bottom: 25px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: flex-end; 
            border-radius: 10px; 
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
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

    <main class="about-container">
        <h1>OUR TEAMS</h1>
        <h2>Kelompok 4 - Kalimantan</h2>

        <div class="team-grid">
            
            <div class="team-member">
                <div class="photo-box">
                    <img src="https://via.placeholder.com/250x250?text=Foto+Rinaldi" alt="Rinaldi">
                </div>
                <div class="member-info">Rinaldi - H1d0240</div>
            </div>

            <div class="team-member">
                <div class="photo-box">
                    <img src="https://via.placeholder.com/250x250?text=Foto+Farhan" alt="Farhan">
                </div>
                <div class="member-info">Farhan - H1d0240</div>
            </div>

            <div class="team-member">
                <div class="photo-box">
                    <img src="https://via.placeholder.com/250x250?text=Foto+Elang" alt="Elang">
                </div>
                <div class="member-info">Elang - H1d0240</div>
            </div>

        </div>
    </main>

</body>
</html>