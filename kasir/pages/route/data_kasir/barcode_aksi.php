<?php
include "../../../../config/koneksi.php";
include '../../../../config/fungsi_rupiah.php';
header('Content-Type: application/json');
$kd_kota = isset($_SESSION['kd_kota']) ? $_SESSION['kd_kota'] : 'BDG';
$kd_cus = isset($_SESSION['kd_cus']) ? $_SESSION['kd_cus'] : '1308';
$kd_aplikasi = isset($_SESSION['kd_aplikasi']) ? $_SESSION['kd_aplikasi'] : '11';
$kodeinput = $_GET['kode'];
$kodeAppValue = $_COOKIE['kode_kategori'] ?? null;

$tgl = date('Y-m-d');
$data = array();
$sql = "SELECT b.kd_brg,b.nama,b.kd_subgrup,b.kd_grup,b.photo, b.hrg_satuan1 AS harga, 
        b.Satuan1, b.qty_satuan1, b.ktg_online, b.ktg_ms, b.ktg_mg, b.ktg_mp,b.ktg_grosir,b.Satuan2,b.Satuan3,b.Satuan4,b.Satuan5,
        b.qty_satuan2,qty_satuan3,qty_satuan4,qty_satuan5

        FROM barang b
        WHERE 
        b.nama!='' AND b.kd_brg='$kodeinput';";
$query = mysqli_query($koneksi, $sql);
function roundUpTo100($value)
{
    return ceil($value / 100) * 100;
}
if (mysqli_num_rows($query) > 0) {
    $data = array('status' => 1, 'msg' => 'Data Found');
    $data['data'] = mysqli_fetch_all($query, MYSQLI_ASSOC);
    foreach ($data['data'] as $key => &$d) {
        $harga_dasar = 0;
        if ($kd_aplikasi == 11) {
            $harga_dasar = $d['harga'];
        } elseif ($d['harga_dine_in'] == 0) {
            $harga_dasar = $d['harga'] - ($d['harga'] * 10 / 100);
        } else {
            $harga_dasar = $d['harga_dine_in'];
        }

        $d['harga_dasar'] = format_rupiah($harga_dasar);

        $data1 = mysqli_query($koneksi, "SELECT kd_promo,diskon,ket FROM tarif_diskon
            WHERE
            tgl_awal<= '{$tgl}' AND
            tgl_akhir>= '{$tgl}' AND
            kd_jenis = '{$kd_aplikasi}' AND
            (cakupan = 'Nasional' OR kd_kota = '{$kd_kota}' OR kd_cus = '{$kd_cus}' ) AND
            (kd_brg = 'Semua' OR kd_brg = '{$d['kd_brg']}' ) 
            ORDER BY diskon;");


        $d1 = mysqli_fetch_array($data1);

        if ($d1 == null) {
            $disc = 0;
            $kd_promo = '';
        } else {
            if ($d1['ket'] == 'Persen') {
                $disc = ($d1['diskon'] / 100) * $d['harga'];
                $kd_promo = $d1['kd_promo'];
            } else {
                $disc = $d1['diskon'];
                $kd_promo = $d1['kd_promo'];
            }
        }
        $kode_ktg = '';
        $kode_barang23 = $d['kd_brg'];


        if ($kodeAppValue == 2) {
            $kode_ktg = 'ktg_grosir';
        } elseif ($kodeAppValue == 3) {
            $kode_ktg = 'ktg_online';
        } elseif ($kodeAppValue == 4) {
            $kode_ktg = 'ktg_ms';
        } elseif ($kodeAppValue == 5) {
            $kode_ktg = 'ktg_mg';
        } elseif ($kodeAppValue == 6) {
            $kode_ktg = 'ktg_mp';
        }
        if ($kodeAppValue != 1) {
            $querysql1 = mysqli_query($koneksi, "SELECT IFNULL(kategori_nilai.layer1,0) AS layer11,
            IFNULL(SUBSTRING_INDEX(kategori_nilai.layer2, '|', 1),0) AS layer21,
            IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(kategori_nilai.layer2, '|', 2), '|', -1),0) AS layer22,
            IFNULL(SUBSTRING_INDEX(kategori_nilai.layer3, '|', 1),0) AS layer31,
            IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(kategori_nilai.layer3, '|', 3), '|', -1),0) AS layer33,
            IFNULL(SUBSTRING_INDEX(kategori_nilai.layer4, '|', 1),0) AS layer41,
            IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(kategori_nilai.layer4, '|', 4), '|', -1),0) AS layer44,
            IFNULL(SUBSTRING_INDEX(kategori_nilai.layer5, '|', 1),0) AS layer51,
            IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(kategori_nilai.layer5, '|', 5), '|', -1),0) AS layer55,
            kategori_nilai.id_kat,kategori_nilai.Nama_kategoriNilai,barang.`$kode_ktg`,barang.harga
            FROM barang JOIN kategori_nilai ON barang.`$kode_ktg` = kategori_nilai.Nama_kategoriNilai 
            where kategori_nilai.id_kat = '$kodeAppValue' AND barang.kd_brg = '$kode_barang23' ");

            while ($s1 = mysqli_fetch_array($querysql1)) {
                if ($kodeAppValue == 2) {
                    if (!empty($d['Satuan5'])) {
                        $d['harga'] = $s1['harga'] + ($s1['harga'] * $s1['layer55'] / 100);
                        $d['harga'] = roundUpTo100($d['harga']);
                        $d['qty_satuan1'] =  $d['qty_satuan5'];
                        $d['Satuan1'] = $d['Satuan5'];
                    } else if (!empty($d['Satuan4'])) {
                        $d['harga'] = $s1['harga'] + ($s1['harga'] * $s1['layer44'] / 100);
                        $d['harga'] = roundUpTo100($d['harga']);
                        $d['qty_satuan1'] =  $d['qty_satuan4'];
                        $d['Satuan1'] = $d['Satuan4'];
                    } else if (!empty($d['Satuan3'])) {
                        $d['harga'] = $s1['harga'] + ($s1['harga'] * $s1['layer33'] / 100);
                        $d['harga'] = roundUpTo100($d['harga']);
                        $d['qty_satuan1'] =  $d['qty_satuan3'];
                        $d['Satuan1'] = $d['Satuan3'];
                    } else if (!empty($d['Satuan2'])) {
                        $d['harga'] = $s1['harga'] + ($s1['harga'] * $s1['layer22'] / 100);
                        $d['harga'] = roundUpTo100($d['harga']);
                        $d['qty_satuan1'] =  $d['qty_satuan2'];
                        $d['Satuan1'] = $d['Satuan2'];
                    } else if (!empty($d['Satuan1'])) {
                        $d['harga'] = $s1['harga'] + ($s1['harga'] * $s1['layer11'] / 100);
                        $d['harga'] = roundUpTo100($d['harga']);
                    }
                } else {
                    if (!empty($d['Satuan5'])) {
                        $d['harga'] = $s1['harga'] + ($s1['harga'] * $s1['layer51'] / 100);
                        $d['harga'] = roundUpTo100($d['harga']);
                    } else if (!empty($d['Satuan4'])) {
                        $d['harga'] = $s1['harga'] + ($s1['harga'] * $s1['layer41'] / 100);
                        $d['harga'] = roundUpTo100($d['harga']);
                    } else if (!empty($d['Satuan3'])) {
                        $d['harga'] = $s1['harga'] + ($s1['harga'] * $s1['layer31'] / 100);
                        $d['harga'] = roundUpTo100($d['harga']);
                    } else if (!empty($d['Satuan2'])) {
                        $d['harga'] = $s1['harga'] + ($s1['harga'] * $s1['layer21'] / 100);
                        $d['harga'] = roundUpTo100($d['harga']);
                    } else if (!empty($d['Satuan1'])) {
                        $d['harga'] = $s1['harga'] + ($s1['harga'] * $s1['layer11'] / 100);
                        $d['harga'] = roundUpTo100($d['harga']);
                    }
                }
            }
        }

        $d['diskon'] = strval($disc);
        $d['kd_promo'] = $kd_promo;
    }
} else {
    $data = array('status' => 0, 'msg' => 'Data Not Found');
}
echo json_encode($data);
exit;
