<?php
ob_start();
include "../../../config/koneksi.php";
$term = $_GET['term'];
$query = mysqli_query($koneksi,"SELECT * from supplier where nama_supp like '%".$term."%'");
$json = array();
while($produk = mysqli_fetch_array($query)){
$json[] = array(
'label' => $produk['id_supp'].' – '.$produk['nama_supp'], // text sugesti saat user mengetik di input box
'value' => $produk['id_supp'], // nilai yang akan dimasukkan diinputbox saat user memilih salah satu sugesti
'nama' => $produk['nama_supp'],
'type' => $produk['alamat_supp']
);
}
header("Content-Type: text/json");
echo json_encode($json);
ob_flush();
?>