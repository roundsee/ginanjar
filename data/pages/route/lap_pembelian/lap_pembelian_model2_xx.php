<?php
include "../../../../config/koneksi.php";
include "../../../../config/fungsi_rupiah.php";
include "logging.php";

$tgl_awal  = mysqli_real_escape_string($koneksi, $_GET['tgl_awal'] ?? '');
$tgl_akhir = mysqli_real_escape_string($koneksi, $_GET['tgl_akhir'] ?? '');
$filter    = $_GET['filter'] ?? '';
$nilai     = mysqli_real_escape_string($koneksi, $_GET['nilai'] ?? '');

// Tambahkan filter kondisi jika ada
$kondisi = ($filter == 'supplier' && !empty($nilai)) ? "AND supplier.kd_supp = '$nilai'" : "";
?>

<div id="x2" style="display:none !important;"></div>
<div id="x1" style="display:none !important;"></div>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pembelian</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">
    <style>
        body { font-size: 13px; background: #fff; }
        .table th { background: #eee; text-align: center; vertical-align: middle; }
    </style>
</head>
<body>
<div style="display: none;">
    <div id="isian0"></div>
    <div id="isian1"></div>
    <div id="isian2"></div>
    <div id="isian3"></div>
</div>

<div class="container-fluid mt-3">
    <h4 class="text-center">LAPORAN PEMBELIAN</h4>
    <p class="text-center">Periode: <?= $tgl_awal ?> s/d <?= $tgl_akhir ?></p>

    <table id="mytable" class="table table-bordered table-sm" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Invoice</th>
                <th>Supplier</th>
                <th>Barang</th>
                <th>Qty Datang</th>
                <th>Harga</th>
                <th>Total (+PPN)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1; $grand = 0;
            $q = "
                SELECT 
                    pd.no_invoice, pd.kd_po, pd.kd_brg, pd.nilai, pd.disc, pd.jml_pcs,
                    barang.nama AS nama_barang, 
                    SUM(pembelian_detail.disc) AS tot_disc, 
                    pembelian.ppn, 
                    pb.jumlah_datang AS jumlah_barang_datang, 
                    pembelian.tarif_ppn, 
                    supplier.nama AS nama_supp, 
                    supplier.kd_supp,
                    pembelian_invoice.tanggal_invoice
                FROM pembelian_invoice_detail pd
                JOIN barang ON barang.kd_brg = pd.kd_brg
                JOIN pembelian ON pembelian.kd_po = pd.kd_po
                JOIN supplier ON supplier.kd_supp = pembelian.kd_supp
                JOIN pembelian_invoice ON pembelian_invoice.no_invoice = pd.no_invoice
                JOIN pembelian_detail ON pembelian_detail.kd_po = pd.kd_po AND pembelian_detail.kd_brg = pd.kd_brg
                LEFT JOIN penerimaan_barang pb ON pb.kd_po = pd.kd_po AND pb.kd_brg = pd.kd_brg
                WHERE pembelian_invoice.tanggal_invoice BETWEEN '$tgl_awal' AND '$tgl_akhir'
                $kondisi
                GROUP BY pd.kd_po, pd.kd_brg
                ORDER BY supplier.kd_supp, pembelian_invoice.tanggal_invoice ASC;
            ";
            
            write_log($q);
            $res = mysqli_query($koneksi, $q);
            
            while($r = mysqli_fetch_array($res)){
                // Ambil nilai dari hasil query
                $qty_datang = $r['jumlah_barang_datang'] ?? 0;
                $harga      = $r['nilai'] ?? 0;
                $diskon     = $r['tot_disc'] ?? 0;
                
                // Kalkulasi Total per Baris
                $sub_total   = ($qty_datang * $harga) - $diskon;
                
                // Tambah PPN jika statusnya 1
                if($r['ppn'] == 1) {
                    $nilai_ppn = ($sub_total * $r['tarif_ppn'] / 100);
                    $sub_total += $nilai_ppn;
                }
                
                $grand += $sub_total;
            ?>
            <tr>
                <td align="center"><?= $no++ ?></td>
                <td align="center"><?= $r['tanggal_invoice'] ?></td>
                <td><?= $r['no_invoice'] ?></td>
                <td><?= $r['nama_supp'] ?></td>
                <td><?= $r['nama_barang'] ?></td>
                <td align="right"><?= number_format($qty_datang) ?></td>
                <td align="right"><?= number_format($harga) ?></td>
                <td align="right"><?= number_format($sub_total) ?></td>
            </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr style="font-weight:bold; background:#f9f9f9;">
                <td colspan="7" align="right">GRAND TOTAL KESELURUHAN</td>
                <td align="right"><?= number_format($grand) ?></td>
            </tr>
        </tfoot>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {
    $('#mytable').DataTable({
        dom: 'Bfrtip',
        buttons: ['excel', 'pdf', 'print'],
        pageLength: 50,
        scrollX: true
    });
});
</script>
</body>
</html>