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
    $tanggal_invoice = date('Y-m-d'); // Tanggal hari ini

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
        $update_status = mysqli_query($koneksi, "UPDATE pembelian SET status_pembelian = 4 WHERE kd_po = '$kd_beli'");

        // Ambil urutan terakhir surat jalan untuk tanggal yang dipilih
        $result = mysqli_query($koneksi, "SELECT surat_jalan FROM penerimaan_barang WHERE tgl_terima = '$tanggal_invoice' ORDER BY surat_jalan DESC LIMIT 1");
        $last_sj = mysqli_fetch_assoc($result);

        if ($last_sj) {
            // Ambil nomor urutan dari surat jalan terakhir dan increment
            $last_number = (int)substr($last_sj['surat_jalan'], -4);
            $new_number = str_pad($last_number + 1, 4, '0', STR_PAD_LEFT);
        } else {
            // Jika belum ada surat jalan pada tanggal tersebut, mulai dari 0001
            $new_number = '0001';
        }

        // Format surat jalan baru
        $surat_jalan = "SJ-$tanggal_invoice-$new_number";

        // Insert ke tabel pembelian_invoice
        $query_invoice = "INSERT INTO pembelian_invoice (no_invoice, tanggal_invoice, kd_po, kd_supp, ppn, ongkir)
                          VALUES ('$no_invoice', '$tanggal_invoice', '$kd_beli', '$kd_supp', '$ppn', '$ongkir')";
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


                $query_penerimaan_barang = "INSERT INTO penerimaan_barang ( kd_po, surat_jalan, tgl_terima, kd_brg,jumlah,  jumlah_datang, penerima)
                                 VALUES ( '$kd_beli', '$surat_jalan','$tanggal_invoice', '$kd_brg', '$jumlah', '$jumlah', 'WG0214')";
                mysqli_query($koneksi, $query_penerimaan_barang);
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
