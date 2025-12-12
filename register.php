<?php
include 'koneksi.php';
session_start();

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
        * { margin: 0; padding: 0; box-sizing: border-box; text-decoration: none; }

        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('asset/bg_kedua.png');
            background-size: cover;      
            background-position: center; 
            background-repeat: no-repeat; 
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        nav {
            background-color: #2F9E58;
            display: flex; justify-content: space-between; align-items: center;
            padding: 20px 50px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .nav-left { display: flex; align-items: center; gap: 40px; }
        .logo { font-size: 24px; font-weight: 800; color: #ffea00ff; display: flex; align-items: center; }
        .logo-img { height: 50px; width: auto; margin-right: 5px; vertical-align: middle; }
        
        .nav-links a, .nav-right a {
            color: #1a2e35; font-weight: 600; font-size: 16px; transition: color 0.3s;
        }
        .nav-links a { margin-right: 25px; }
        .nav-right a { margin-left: 20px; }
        .nav-links a:hover, .nav-right a:hover { color: #fff; }

        .register-container {
            flex: 1; display: flex; justify-content: center; align-items: center; padding: 20px;
        }

        .card-register {
            background-color: white; padding: 40px 50px; border-radius: 20px;
            width: 100%; max-width: 450px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); text-align: center;
        }

        .card-register h2 {
            font-family: 'Merriweather', serif; color: #2F9E58; font-size: 28px; margin-bottom: 30px;
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
            box-shadow: 0 4px 10px rgba(60, 207, 104, 0.3); transition: background 0.3s;
        }

        .btn-submit:hover { background-color: #2eb858; }
            
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

    <main class="register-container">
        <div class="card-register">
            <h2>Registrasi</h2>
            
            <form action="" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Masukan Username" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukan Password" required>
                </div>

                <button type="submit" name="daftar" class="btn-submit">Daftar</button>
            </form>
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

</body>
</html>