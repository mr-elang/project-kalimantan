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
$user_id = $_SESSION['user_id'];

$cek = mysqli_query($conn, "SELECT * FROM contents WHERE id = '$id' AND user_id = '$user_id'");

if(mysqli_num_rows($cek) > 0){
    $hapus = mysqli_query($conn, "DELETE FROM contents WHERE id = '$id'");
    mysqli_query($conn, "DELETE FROM komentar WHERE content_id = '$id'");
    
    if($hapus){
        header("Location: contents.php?pesan=hapus");
        exit;
    } else {
        echo "<script>alert('Gagal menghapus data db.'); window.location='contents.php';</script>";
    }
} else {
    echo "<script>alert('Anda tidak berhak menghapus konten ini.'); window.location='contents.php';</script>";
}
?>