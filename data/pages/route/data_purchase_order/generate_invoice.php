<?php
include '../../../../config/koneksi.php';
session_start();

$employee = $_SESSION['employee_number'];

// Cek apakah form telah di-submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Ambil data dari form
    $no_invoice = $_POST['no_invoice'];
    $kd_beli = $_POST['kd_beli'];
    $kd_supp = $_POST['kd_supp'];
    $ongkir = $_POST['ongkos_kirim'];
    $ppn = $_POST['ppn'];
    // Ambil nilai retur dan nomor bukti retur
    $nilai_retur = !empty($_POST['nilai_retur']) ? $_POST['nilai_retur'] : 0;
    $bukti_retur = !empty($_POST['bukti_retur']) ? $_POST['bukti_retur'] : null;


    $tanggal_invoice = date('Y-m-d');
    // Hapus prefix "Rp" jika ada dan karakter titik (misalnya 140.000 menjadi 140000)
    $nilai_retur = str_replace('Rp', '', $nilai_retur); // Hapus "Rp"
    $nilai_retur = str_replace('.', '', $nilai_retur);  // Hapus titik

    // Konversi ke format angka
    $nilai_retur = (float) $nilai_retur;


    // die();

    // Cek apakah no_invoice sudah ada dalam database untuk kd_po yang berbeda
    $query_check_invoice = "SELECT no_invoice FROM pembelian_invoice WHERE no_invoice = '$no_invoice' AND kd_po != '$kd_beli'";
    $result_check_invoice = mysqli_query($koneksi, $query_check_invoice);

    if (mysqli_num_rows($result_check_invoice) > 0) {
        // Jika ditemukan nomor invoice yang sama dengan kd_po yang berbeda
        echo "<script>alert('Nomor Invoice sudah ada dan tidak boleh sama!');</script>";
        echo "<script>history.go(-1);</script>";
    } else {
        // Lakukan insert jika nomor invoice unik untuk kd_po ini

        // Update status invoice menjadi 1
        $update_status = mysqli_query($koneksi, "UPDATE pembelian SET status_invoice = 1 WHERE kd_po = '$kd_beli'");
        // Jika ada nomor bukti, ubah menjadi array dan gabungkan dengan pemisah '|'
        if ($bukti_retur) {
            $nomor_bukti = explode(', ', $bukti_retur); // Mengubah string menjadi array
            $nomor_bukti_gabung = implode(' | ', $nomor_bukti); // Menggabungkan array dengan pemisah '|'
        } else {
            $nomor_bukti_gabung = null; // Jika tidak ada bukti retur, set ke null
        }

        // Loop untuk update status_pakai di tabel pembelian_retur jika nomor_bukti terdefinisi
        if (!empty($nomor_bukti)) {
            foreach ($nomor_bukti as $bukti) {
                $query_update_status = "UPDATE pembelian_retur SET status_pakai = 1 WHERE no_bukti = '$bukti' AND vendor = '$kd_supp'";
                $result_update_status = mysqli_query($koneksi, $query_update_status);

                if (!$result_update_status) {
                    echo "Error: " . mysqli_error($koneksi);
                    exit;
                }
            }
        }


        // Insert ke tabel pembelian_invoice
        $query_invoice = "INSERT INTO pembelian_invoice (no_invoice, tanggal_invoice, kd_po, kd_supp, ppn, ongkir,bukti_retur, nilai_retur)
                          VALUES ('$no_invoice', '$tanggal_invoice', '$kd_beli', '$kd_supp', '$ppn', '$ongkir', '$nomor_bukti_gabung', '$nilai_retur')";
        mysqli_query($koneksi, $query_invoice);

        if (mysqli_affected_rows($koneksi) > 0) {
            // Insert ke tabel pembelian_invoice_detail
            foreach ($_POST['jumlah'] as $index => $jumlah) {
                $kd_brg = $_POST['kd_brg'][$index];
                $harga = str_replace(",", "", $_POST['harga'][$index]);
                $diskon = str_replace(",", "", $_POST['diskon'][$index]);

                $query_detail = "INSERT INTO pembelian_invoice_detail (no_invoice, kd_po, kd_brg, nilai, disc, jml_pcs)
                                 VALUES ('$no_invoice', '$kd_beli', '$kd_brg', '$harga', '$diskon', '$jumlah')";
                mysqli_query($koneksi, $query_detail);
            }

            echo "<script>alert('Invoice berhasil dicatat');</script>";
            echo "<script>history.go(-2);</script>";
        } else {
            echo "<script>alert('Gagal menambahkan data invoice');</script>";
        }
    }
} else {
    echo "Form belum di-submit.";
}
