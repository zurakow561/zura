<?php
$id = $_GET['id'];
$query = mysqli_query($koneksi, "DELETE FROM kategoribuku WHERE KategoriID='$id'");
?>
<script>
    alert('hapus data berhasil');
    location.href = "index.php?page=kategori";
</script>