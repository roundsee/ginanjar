<?php
  $host = "127.0.0.1"; 
  $user = "ginanjar_user"; //user database //boganast_testwaroeng
  $pass = "ginanjar_pass"; //password database // test123
  $nama_db = "ginanjar"; //nama database // boganast_testwaroeng
  $koneksi = mysqli_connect($host,$user,$pass,$nama_db); //pastikan urutan nya seperti ini, jangan tertukar

  if(!$koneksi){ //jika tidak terkoneksi maka akan tampil error
    die ("Koneksi dengan database gagal: ".mysqli_connect_error());
  }
?>
