<?php
include 'koneksi.php';
session_start();

if(!isset($_SESSION['status']) || $_SESSION['status'] != 'login'){
    header("Location: login.php");
    exit;
}

if(!isset($_GET['id'])){
    header("Location: contents.php");
    exit;
}
$id = $_GET['id'];
$user_id_session = $_SESSION['user_id'];

$query = mysqli_query($conn, "SELECT * FROM contents WHERE id = '$id' AND user_id = '$user_id_session'");
$data = mysqli_fetch_array($query);

if(mysqli_num_rows($query) < 1){
    echo "<script>alert('Akses Ditolak! Anda bukan pemilik konten ini.'); window.location='contents.php';</script>";
    exit;
}

if(isset($_POST['update'])){
    $nama = $_POST['nama'];
    $tipe = $_POST['tipe'];
    $informasi = $_POST['informasi'];
    $foto = $_POST['foto'];

    $update = mysqli_query($conn, "UPDATE contents SET nama='$nama', tipe='$tipe', informasi='$informasi', foto='$foto' WHERE id='$id'");
    
    if($update){
        $berhasil_update = true;
    } else {
        echo "<script>alert('Gagal update database.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data - BorneoPedia</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; text-decoration: none; }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('asset/bg_kedua.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
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
        .logo { font-size: 24px; font-weight: 800; color: #ffea00ff; display: flex; align-items: center; }
        .logo-img { height: 50px; width: auto; margin-right: 5px; vertical-align: middle; }
        
        .nav-links a, .nav-right a, .nav-right span {
            color: #1a2e35; font-weight: 600; font-size: 16px; transition: color 0.3s;
        }
        .nav-links a { margin-right: 25px; } .nav-right a { margin-left: 20px; }
        .nav-links a:hover, .nav-right a:hover { color: #fff; }

        .edit-container {
            flex: 1; display: flex; justify-content: center; align-items: center; padding: 40px 20px;
        }

        .card-edit {
            background-color: #38A169; 
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

        .card-edit h2 {
            font-family: 'Merriweather', serif; color: white;
            font-size: 26px; margin-bottom: 25px; text-align: center;
        }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 500; margin-bottom: 8px; font-size: 15px; color: #1a2e35; }

        .form-control {
            width: 100%; padding: 12px 20px; border-radius: 50px; border: none;
            background-color: #ffffff; font-family: 'Poppins', sans-serif; font-size: 14px; outline: none;
        }
        textarea.form-control { border-radius: 20px; resize: vertical; }

        select.form-control {
            appearance: none; cursor: pointer;
            background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23000000%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E");
            background-repeat: no-repeat; background-position: right 20px center; background-size: 12px;
        }

        .button-group { display: flex; gap: 15px; margin-top: 30px; }
        .btn { padding: 12px 30px; border-radius: 50px; font-weight: 600; font-size: 15px; border: none; cursor: pointer; transition: transform 0.2s, opacity 0.2s; }
        
        .btn-update { 
            background-color: #3CCF68; color: white; 
            width: 100%;
        } 
        
        .btn:hover { transform: translateY(-2px); opacity: 0.9; }

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
            <span>Hi, <?php echo $_SESSION['username']; ?></span>
            <a href="upload.php">Upload +</a>
            <a href="logout.php">Logout</a>
        </div>
    </nav>

    <main class="edit-container">
        <div class="card-edit">
            
            <a href="detail.php?id=<?php echo $id; ?>" class="btn-back-arrow" title="Kembali">
                <svg class="icon-back" viewBox="0 0 24 24">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                </svg>
            </a>

            <h2>Edit Postingan</h2>
            
            <form action="" method="POST">
                
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" value="<?php echo htmlspecialchars($data['nama']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Tipe</label>
                    <select name="tipe" class="form-control">
                        <option value="Flora" <?php if($data['tipe'] == 'Flora') echo 'selected'; ?>>Flora</option>
                        <option value="Fauna" <?php if($data['tipe'] == 'Fauna') echo 'selected'; ?>>Fauna</option>
                        <option value="Makanan" <?php if($data['tipe'] == 'Makanan') echo 'selected'; ?>>Makanan</option>
                        <option value="Minuman" <?php if($data['tipe'] == 'Minuman') echo 'selected'; ?>>Minuman</option>
                        <option value="Budaya" <?php if($data['tipe'] == 'Budaya') echo 'selected'; ?>>Budaya</option>
                        <option value="Suku" <?php if($data['tipe'] == 'Suku') echo 'selected'; ?>>Suku</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Link Foto (URL Eksternal)</label>
                    <input type="url" name="foto" class="form-control" value="<?php echo htmlspecialchars($data['foto']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Info lengkap</label>
                    <textarea name="informasi" class="form-control" rows="4" required><?php echo htmlspecialchars($data['informasi']); ?></textarea>
                </div>

                <div class="button-group">
                    <button type="submit" name="update" class="btn btn-update">Update Postingan</button>
                </div>

            </form>
        </div>
    </main>

    <?php if(isset($berhasil_update)): ?>
    <div class="modal-overlay modal-show">
        <div class="modal-box">
            <svg class="modal-icon" viewBox="0 0 24 24" fill="#3CCF68">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
            <div class="modal-title">Data Diperbarui!</div>
            <p class="modal-desc">Perubahan artikel berhasil disimpan.</p>
            <a href="detail.php?id=<?php echo $id; ?>" class="btn-modal btn-green">Lihat Artikel</a>
        </div>
    </div>
    <?php endif; ?>

</body>
</html>