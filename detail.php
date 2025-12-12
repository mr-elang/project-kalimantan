<?php
session_start();
include 'koneksi.php';

if(!isset($_GET['id'])){
    header("Location: contents.php");
    exit;
}
$id_content = $_GET['id'];

if(isset($_POST['kirim_komentar'])){
    if(!isset($_SESSION['status'])){
        echo "<script>alert('Anda harus login untuk berkomentar!'); window.location='login.php';</script>";
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $isi = $_POST['isi_komentar'];

    if(!empty($isi)){
        $insert = mysqli_query($conn, "INSERT INTO komentar (content_id, user_id, isi) VALUES ('$id_content', '$user_id', '$isi')");
    }
    
    header("Location: detail.php?id=$id_content");
    exit;
}

$query = mysqli_query($conn, "SELECT contents.*, users.username 
                              FROM contents 
                              JOIN users ON contents.user_id = users.id 
                              WHERE contents.id = '$id_content'");
$data = mysqli_fetch_assoc($query);

if(!$data){
    echo "<script>alert('Data tidak ditemukan!'); window.location='contents.php';</script>";
    exit;
}

$query_komen = mysqli_query($conn, "SELECT komentar.*, users.username 
                                    FROM komentar 
                                    JOIN users ON komentar.user_id = users.id 
                                    WHERE content_id = '$id_content' 
                                    ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['nama']; ?> - BorneoPedia</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; text-decoration: none; }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('asset/bg_kedua.png');
            background-size: cover; background-position: center; background-repeat: no-repeat;
            min-height: 100vh;
            display: flex; flex-direction: column;
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

        .detail-container {
            flex: 1; padding: 50px 20px; display: flex; justify-content: center; align-items: flex-start;
        }

        .card-detail {
            background: white; width: 100%; max-width: 900px;
            border-radius: 20px; overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1); margin-bottom: 50px;
            position: relative; 
        }

        .detail-img { width: 100%; height: 450px; object-fit: cover; background-color: #eee; }

        .btn-back-arrow {
            position: absolute; top: 20px; left: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            width: 45px; height: 45px; border-radius: 50%;
            display: flex; justify-content: center; align-items: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2); transition: transform 0.2s, background-color 0.2s; z-index: 10;
        }
        .btn-back-arrow:hover { background-color: white; transform: scale(1.1); }
        .icon-back { width: 24px; height: 24px; fill: #2F9E58; }

        .detail-body { padding: 40px; }

        .meta-header {
            display: flex; align-items: center; gap: 15px; margin-bottom: 20px;
            font-size: 14px; color: #666; flex-wrap: wrap;
        }

        .badge-type {
            background-color: #e6f7ed; color: #2F9E58; padding: 5px 15px;
            border-radius: 50px; font-weight: 600; font-size: 13px; text-transform: uppercase;
        }

        h1 { font-family: 'Merriweather', serif; font-size: 36px; color: #1a2e35; margin-bottom: 25px; }

        .content-text {
            font-size: 16px; line-height: 1.8; color: #444; text-align: justify; margin-bottom: 40px; white-space: pre-line;
        }

        .action-area { border-top: 1px solid #eee; padding-top: 25px; display: flex; gap: 15px; }

        .btn {
            padding: 12px 25px; border-radius: 50px; font-weight: 600; font-size: 14px;
            cursor: pointer; transition: transform 0.2s, opacity 0.2s; display: inline-block;
        }
        .btn:hover { opacity: 0.9; transform: translateY(-2px); }
        .btn-edit { background-color: #0088ff; color: white; }
        .btn-delete { background-color: #ff4d4d; color: white; }

        .comment-section { background-color: #f8fcf9; padding: 30px 40px; border-top: 1px solid #eee; }
        .comment-title { font-family: 'Merriweather', serif; font-size: 20px; color: #1a2e35; margin-bottom: 20px; }
        .comment-list { margin-bottom: 30px; }
        .comment-item { margin-bottom: 15px; font-size: 15px; color: #333; }
        .comment-user { font-weight: 700; color: #1a2e35; margin-right: 5px; }

        .comment-form { display: flex; align-items: center; gap: 15px; width: 100%; }
        .input-comment {
            flex: 1; padding: 15px 25px; border-radius: 50px; border: 1px solid #ddd;
            background-color: white; font-family: 'Poppins', sans-serif; font-size: 14px;
            outline: none; box-shadow: 0 5px 15px rgba(0,0,0,0.03);
        }
        .input-comment:focus { border-color: #00ced1; }

        .btn-send {
            background-color: #00ced1; color: white; border: none; width: 50px; height: 50px;
            border-radius: 50px; display: flex; justify-content: center; align-items: center;
            cursor: pointer; box-shadow: 0 4px 10px rgba(0, 206, 209, 0.3); transition: background 0.3s;
        }
        .btn-send:hover { background-color: #00b5b8; }
        .icon-send { width: 20px; height: 20px; fill: white; margin-left: -2px; }

        /* --- STYLE POPUP MODAL --- */
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

        .btn-modal { padding: 10px 25px; border-radius: 50px; border: none; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-block; font-family: 'Poppins', sans-serif; font-size: 14px;}
        .btn-grey { background-color: #f0f0f0; color: #333; }
        .btn-grey:hover { background-color: #e0e0e0; }
        .btn-red { background-color: #ff4d4d; color: white; }
        .btn-red:hover { background-color: #cc0000; }

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

    <main class="detail-container">
        <div class="card-detail">
            
            <a href="contents.php" class="btn-back-arrow" title="Kembali">
                <svg class="icon-back" viewBox="0 0 24 24">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                </svg>
            </a>

            <img src="<?php echo $data['foto']; ?>" class="detail-img" onerror="this.src='https://via.placeholder.com/800x450?text=Gambar+Tidak+Valid'">
            
            <div class="detail-body">
                <div class="meta-header">
                    <span class="badge-type"><?php echo $data['tipe']; ?></span>
                    <span>Penulis: <b><?php echo $data['username']; ?></b></span>
                    <span>&bull;</span>
                    <span>di upload pada <?php echo date('d M Y', strtotime($data['created_at'])); ?></span>
                </div>

                <h1><?php echo $data['nama']; ?></h1>

                <div class="content-text">
                    <?php echo nl2br(htmlspecialchars($data['informasi'])); ?>
                </div>

                <div class="action-area">
                    <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $data['user_id']): ?>
                        <a href="edit.php?id=<?php echo $data['id']; ?>" class="btn btn-edit">Edit Artikel</a>
                        
                        <a href="#" onclick="bukaPopupHapus(); return false;" class="btn btn-delete">Hapus</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="comment-section">
                <h3 class="comment-title">Komentar</h3>
                <div class="comment-list">
                    <?php if(mysqli_num_rows($query_komen) > 0): ?>
                        <?php while($komen = mysqli_fetch_assoc($query_komen)): ?>
                            <div class="comment-item">
                                <span class="comment-user"><?php echo $komen['username']; ?>:</span>
                                <span><?php echo htmlspecialchars($komen['isi']); ?></span>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p style="color:#aaa; font-style:italic;">Belum ada komentar.</p>
                    <?php endif; ?>
                </div>

                <?php if(isset($_SESSION['status']) && $_SESSION['status'] == 'login'): ?>
                    <form method="POST" class="comment-form">
                        <input type="text" name="isi_komentar" class="input-comment" placeholder="Tulis komentar..." required autocomplete="off">
                        <button type="submit" name="kirim_komentar" class="btn-send">
                            <svg class="icon-send" viewBox="0 0 24 24">
                                <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"></path>
                            </svg>
                        </button>
                    </form>
                <?php else: ?>
                    <p><a href="login.php" style="color:#2F9E58; font-weight:bold;">Login</a> untuk menulis komentar.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <div class="modal-overlay" id="popupHapus">
        <div class="modal-box">
            <svg class="modal-icon" viewBox="0 0 24 24" fill="#ff4d4d">
                <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
            </svg>
            <div class="modal-title">Hapus Artikel?</div>
            <p class="modal-desc">Yakin dek mau dihapus?</p>
            
            <div style="display: flex; justify-content: center; gap: 10px;">
                <button onclick="tutupPopupHapus()" class="btn-modal btn-grey">Batal</button>
                <a href="delete.php?id=<?php echo $data['id']; ?>" class="btn-modal btn-red">Ya, Hapus</a>
            </div>
        </div>
    </div>

    <script>
        function bukaPopupHapus() {
            document.getElementById('popupHapus').classList.add('modal-show');
        }
        function tutupPopupHapus() {
            document.getElementById('popupHapus').classList.remove('modal-show');
        }
    </script>

</body>
</html>