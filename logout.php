<?php
session_start();

include 'config/koneksi.php';

$username = $_SESSION['namauser'];
$password = $_SESSION['passuser'];
// echo $username;

$aktif=mysqli_query($koneksi,"UPDATE user_login SET aktif='0' where username='$username' and password='$password'");

  // session_start();
  session_destroy();


  echo "<script>alert('Anda telah keluar dari Halaman'); window.location = 'index.php'</script>";
?>
