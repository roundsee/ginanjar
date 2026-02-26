<?php
include "../../../../config/koneksi.php";
header('Content-Type: application/json');
$keteranganvoid = isset($_GET['keteranganvoid']) ? $_GET['keteranganvoid'] : '';
$nomorfaktur = isset($_GET['nomorfaktur']) ? $_GET['nomorfaktur'] : '';

$query = mysqli_query($koneksi, "SELECT * FROM penjualan WHERE faktur='$nomorfaktur' ");
while ($q = mysqli_fetch_array($query)) {
    $tanggal = $q['tanggal'];
    $kd_cus = $q['kd_cus'];
    $kd_aplikasi = $q['kd_aplikasi'];
    $no_meja = $q['no_meja'];
    $oleh = $q['oleh'];
    $subjumlah = $q['subjumlah'];
    $ppn = $q['ppn'];
    $jumlah = $q['jumlah'];
    $byr_pocer = $q['byr_pocer'];
    $byr_tunai = $q['byr_tunai'];
    $byr_non_tunai = $q['byr_non_tunai'];
    $kd_alatbayar = $q['kd_alatbayar'];
    $no_urut = $q['no_urut'];
    $tahun = date('Y');
    $bulan = date('Ym');
    $jam = date("H:i:s");
    $kdsub_alatbayar = $q['kdsub_alatbayar'];
    $subjumlah_offline = $q['subjumlah_offline'];
    $ket_aplikasi = $q['ket_aplikasi'];
    $dasar_fee = $q['dasar_fee'];
    $acuan_fee = $q['acuan_fee'];
    $tarif_fee = $q['tarif_fee'];
    $b_paking = $q['b_paking'];
    $no_online = $q['no_online'];
    $no_ofline = $q['no_ofline'];
    $tarif_pb1 = $q['tarif_pb1'];
    $faktur_refund = $q['faktur_refund'];
    $dasar_faktur = $q['dasar_faktur'];
    $no_ref = $q['no_ref'];

    $insert = mysqli_query($koneksi, "INSERT INTO batal_penjualan values(
        '$nomorfaktur','$tanggal','$kd_cus','$kd_aplikasi','$no_meja','$oleh','$subjumlah','$ppn','$jumlah','$byr_pocer','$byr_tunai',
        '$byr_non_tunai','$kd_alatbayar','$no_urut','$tahun','$bulan','$jam','$kdsub_alatbayar','$subjumlah_offline','$ket_aplikasi',
        '$dasar_fee','$acuan_fee','$tarif_fee','$b_paking','$no_online','$no_ofline','$tarif_pb1',NULL,'$dasar_faktur','$no_ref',
        '$keteranganvoid')") or die(mysqli_errno($koneksi));
}


$query = mysqli_query($koneksi, "SELECT * FROM jualdetil WHERE faktur='$nomorfaktur' ");
while ($q = mysqli_fetch_array($query)) {

    $jadi_detil = $q['jadi'];
    $tanggal_detil = $q['tanggal'];
    $kd_cus_detil = $q['kd_cus'];
    $kd_aplikasi_detil = $q['kd_aplikasi'];
    $kd_promo_detil = $q['kd_promo'];
    $kd_brg_detil = $q['kd_brg'];
    $banyak_detil = $q['banyak'];
    $harga_detil = $q['harga'];
    $diskon_detil = $q['diskon'];
    $jumlah_detil = $q['jumlah'];
    $penyajian_detil = $q['penyajian'];
    $harga_dasar_detil = $q['harga_dasar'];
    $jumlahquantity = $q['qty_satuan'] * $q['banyak'];
    mysqli_query($koneksi, "UPDATE barang SET Quantity=Quantity-'$jumlahquantity'WHERE kd_brg='$kd_brg_detil' ") or die(mysqli_errno($koneksi));

    mysqli_query($koneksi, "INSERT into batal_jualdetil values('$jadi_detil','$nomorfaktur','$tanggal_detil','$kd_cus_detil',
    '$kd_aplikasi_detil','$kd_promo_detil','$kd_brg_detil','$banyak_detil','$harga_detil','$diskon_detil','$jumlah_detil',
    NULL,'$penyajian_detil','$harga_dasar_detil')") or die(mysqli_errno($koneksi));
}

mysqli_query($koneksi, "UPDATE penjualan SET tanggal='$tanggal' ,subjumlah=0 , ppn=0 , jumlah=0 , byr_pocer=0, byr_tunai=0,byr_non_tunai=0, subjumlah_offline=0 , dasar_fee=0 , b_paking=0 ,faktur_void='$nomorfaktur'
WHERE faktur='$nomorfaktur' ") or die(mysqli_errno($koneksi));

mysqli_query($koneksi, "UPDATE jualdetil SET banyak=0 , diskon=0, jumlah=0 
WHERE faktur='$nomorfaktur' ") or die(mysqli_errno($koneksi));

$data = $nomorfaktur;
echo json_encode($data);
exit;
