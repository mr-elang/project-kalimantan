<?php
include 'koneksi.php';
session_start();

if(!isset($_SESSION['status'])){
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$user_id_session = $_SESSION['user_id'];

// Hapus data HANYA JIKA id konten cocok DAN user_id nya cocok dengan session (Keamanan)
$hapus = mysqli_query($conn, "DELETE FROM contents WHERE id = '$id' AND user_id = '$user_id_session'");

if(mysqli_affected_rows($conn) > 0){
    echo "<script>alert('Data berhasil dihapus!'); window.location='contents.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus data (Mungkin bukan punya Anda).'); window.location='contents.php';</script>";
}
?>