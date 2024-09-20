<?php
session_start();
include 'koneksi.php'; // Include your database connection

if (isset($_GET['UlasanID'])) {
    $UlasanID = $_GET['UlasanID'];
    $UserID = $_SESSION['user']['UserID'];
    $query = mysqli_query($koneksi, "DELETE FROM ulasanbuku WHERE UlasanID = '$UlasanID' AND UserID = '$UserID'");

    if ($query) {
        echo '<script>alert("Data berhasil dihapus."); window.location.href="index.php?page=ulasan";</script>'; // Redirect back to main page
    } else {
        echo '<script>alert("Penghapusan data gagal."); window.location.href="index.php?page=ulasan";</script>';
    }
}
?>