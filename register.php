<?php
include 'koneksi.php';
session_start();

if(isset($_POST['daftar'])){
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password

    $query = mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('$username', '$password')");
    
    if($query){
        echo "<script>alert('Pendaftaran Berhasil! Silakan Login.'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Gagal daftar / Username sudah ada.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?>
    <div class="container" style="max-width: 400px; margin-top: 50px;">
        <div class="card shadow">
            <div class="card-body">
                <h3 class="text-center text-success">Registrasi</h3>
                <form method="POST">
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" name="daftar" class="btn btn-success w-100">Daftar</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>