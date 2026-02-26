<?php
  $host = "localhost"; 
  $user = "mutiara7_ginanjarmart"; //user database //boganast_testwaroeng
  $pass = "lupalagi123"; //password database // test123
  $nama_db = "mutiara7_ginanjarmart"; //nama database // boganast_testwaroeng
  $koneksi = mysqli_connect($host,$user,$pass,$nama_db); //pastikan urutan nya seperti ini, jangan tertukar

  if(!$koneksi){ //jika tidak terkoneksi maka akan tampil error
    die ("Koneksi dengan database gagal: ".mysqli_connect_error());
  }
?>