<?php
include 'koneksi.php';
session_start();

// Jika sudah login, lempar ke contents
if (isset($_SESSION['status']) && $_SESSION['status'] == 'login') {
    header("Location: contents.php");
    exit;
}

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    
    if(mysqli_num_rows($result) === 1){
        $row = mysqli_fetch_assoc($result);
        
        if(password_verify($password, $row['password'])){
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['status'] = 'login'; 
            
            header("Location: contents.php");
            exit;
        }
    }
    $error = true;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BorneoPedia - Login</title>
    
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

        /* --- LOGIN PAGE STYLES --- */
        .login-container {
            flex: 1; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            padding: 20px;
        }

        .card-login {
            background-color: white; 
            padding: 40px 50px; 
            border-radius: 20px;
            width: 100%; 
            max-width: 450px; 
            box-shadow: 0 15px 30px rgba(0,0,0,0.2); 
            text-align: center;
        }

        .card-login h2 {
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
            font-family: 'Poppins', sans-serif; outline: none; transition: border 0.3s;
        }
        .form-group input:focus { border-color: #007BFF; } 

        .btn-login {
            width: 100%; 
            background-color: #0088ff; 
            color: white; padding: 12px; border: none; border-radius: 50px;
            font-weight: 600; font-size: 16px; cursor: pointer; margin-top: 10px;
            box-shadow: 0 4px 10px rgba(0, 136, 255, 0.3); transition: background 0.3s, transform 0.2s;
        }
        .btn-login:hover { background-color: #0066cc; transform: translateY(-2px); }

        .error-msg {
            color: #ff4d4d; font-size: 14px; margin-bottom: 15px; font-style: italic; background: #ffe6e6; padding: 10px; border-radius: 10px;
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

            /* Login Card Mobile */
            .card-login { padding: 30px 20px; }
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
                <a href="login.php" style="font-weight:bold; color:white;">Login</a>
                <a href="register.php" style="background:white; color:#2F9E58; padding:5px 15px; border-radius:20px;">Daftar</a>
            </div>
        </div>
    </nav>

    <main class="login-container">
        <div class="card-login">
            <h2>Login User</h2>
            
            <?php if(isset($error)) : ?>
                <p class="error-msg">Username atau Password salah!</p>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan username" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                </div>

                <button type="submit" name="login" class="btn-login">Masuk</button>
            </form>
            
            <div style="margin-top: 20px; font-size: 14px; color: #666;">
                Belum punya akun? <a href="register.php" style="color: #2F9E58; font-weight: bold;">Daftar disini</a>
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