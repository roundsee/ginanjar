<?php
$judulform = "Laporan Faktur Pajak";

$koneksi = isset($koneksi) ? $koneksi : null;
if ($koneksi === null) {
  include dirname(__FILE__) . '/../../../../config/koneksi.php';
}

function lfp_safe_date($value, $default)
{
  if (!is_string($value)) {
    return $default;
  }
  $value = trim($value);
  if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
    return $value;
  }
  return $default;
}

$tgl_awal = isset($_GET['tgl_awal']) ? lfp_safe_date($_GET['tgl_awal'], date('Y-m-01')) : date('Y-m-01');
$tgl_akhir = isset($_GET['tgl_akhir']) ? lfp_safe_date($_GET['tgl_akhir'], date('Y-m-d')) : date('Y-m-d');

$q = "
  SELECT
    fd.id AS detail_id,
    fd.no_urut,
    fp.id,
    fp.no_faktur_pajak,
    fp.nama_pkp,
    fp.npwp_pkp,
    fp.dasar_pengenaan_pajak,
    fp.harga_jual_total,
    fp.jumlah_ppn,
    COALESCE(fp.tanggal_faktur, DATE(fp.created_at), DATE(fd.created_at)) AS tgl_faktur_report,
    fd.nama_barang,
    fd.satuan,
    fd.qty,
    fd.harga_satuan,
    fd.potongan_harga
  FROM faktur_pembelian_detail fd
  LEFT JOIN faktur_pembelian fp ON fp.id = fd.faktur_pembelian_id
  WHERE COALESCE(fp.tanggal_faktur, DATE(fp.created_at), DATE(fd.created_at)) >= '$tgl_awal'
    AND COALESCE(fp.tanggal_faktur, DATE(fp.created_at), DATE(fd.created_at)) <= '$tgl_akhir'
  ORDER BY COALESCE(fp.tanggal_faktur, DATE(fp.created_at), DATE(fd.created_at)) ASC, fp.id ASC, fd.no_urut ASC, fd.id ASC
";

$listData = mysqli_query($koneksi, $q);

$exportBase = "route/lap_faktur_pajak/export.php?tgl_awal=" . urlencode($tgl_awal) . "&tgl_akhir=" . urlencode($tgl_akhir);
?>

<div class="content-wrapper" style="background-color: ghostwhite;">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="list-gds"><b><?php echo $judulform; ?></b> <small style="font-weight: 100;">report</small></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="main.php?route=home">Beranda</a></li>
            <li class="breadcrumb-item active">Laporan</li>
            <li class="breadcrumb-item active"><?php echo $judulform; ?></li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="card card-default">
        <div class="card-body">
          <form method="get" class="form-inline mb-3">
            <input type="hidden" name="route" value="lap_faktur_pajak">
            <label class="mr-2">Tanggal Awal</label>
            <input type="date" class="form-control mr-3" name="tgl_awal" value="<?php echo htmlspecialchars($tgl_awal); ?>" required>
            <label class="mr-2">Tanggal Akhir</label>
            <input type="date" class="form-control mr-3" name="tgl_akhir" value="<?php echo htmlspecialchars($tgl_akhir); ?>" required>
            <button type="submit" class="btn btn-primary btn-sm mr-2">Tampilkan</button>

            <a class="btn btn-success btn-sm mr-2" href="<?php echo $exportBase; ?>&format=xls">Export Excel</a>
            <a class="btn btn-info btn-sm mr-2" href="<?php echo $exportBase; ?>&format=csv">Export CSV</a>
            <a class="btn btn-danger btn-sm" href="<?php echo $exportBase; ?>&format=pdf" target="_blank">Export PDF</a>
          </form>

          <div class="table-responsive">
            <table id="tableLaporanFakturPajak" class="table table-bordered table-striped table-sm">
              <thead>
                <tr>
                  <th>TGL FAKTUR</th>
                  <th>NO FAKTUR</th>
                  <th>VENDOR</th>
                  <th>NPWP</th>
                  <th>NAMA BARANG</th>
                  <th>SATUAN</th>
                  <th class="text-right">QTY</th>
                  <th class="text-right">HARGA</th>
                  <th class="text-right">DISKON</th>
                  <th class="text-right">BONUS</th>
                  <th class="text-right">DPP</th>
                  <th class="text-right">PPN</th>
                  <th class="text-right">%</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($listData && mysqli_num_rows($listData) > 0) { ?>
                  <?php while ($d = mysqli_fetch_assoc($listData)) { ?>
                    <?php
                    $tglFaktur = '';
                    if (!empty($d['tgl_faktur_report'])) {
                      $parts = explode('-', $d['tgl_faktur_report']);
                      if (count($parts) === 3) {
                        $tglFaktur = $parts[2] . '/' . $parts[1] . '/' . $parts[0];
                      }
                    }
                   // $dpp = (float) $d['dasar_pengenaan_pajak'];
                    $dpp = (float) $d['harga_jual_total'];
                    $ppn = (float) $d['jumlah_ppn'];
                    $persen = $dpp > 0 ? ($ppn / $dpp) * 100 : 0;
                    ?>
                    <tr>
                      <td><?php echo htmlspecialchars($tglFaktur); ?></td>
                      <td><?php echo htmlspecialchars($d['no_faktur_pajak']); ?></td>
                      <td><?php echo htmlspecialchars($d['nama_pkp']); ?></td>
                      <td><?php echo htmlspecialchars($d['npwp_pkp']); ?></td>
                      <td><?php echo htmlspecialchars($d['nama_barang']); ?></td>
                      <td><?php echo htmlspecialchars($d['satuan']); ?></td>
                      <td class="text-right"><?php echo number_format((float) $d['qty'], 2, '.', ','); ?></td>
                      <td class="text-right"><?php echo number_format((float) $d['harga_satuan'], 2, '.', ','); ?></td>
                      <td class="text-right"><?php echo number_format((float) $d['potongan_harga'], 2, '.', ','); ?></td>
                      <td class="text-right">0.00</td>
                      <td class="text-right"><?php echo number_format($dpp, 2, '.', ','); ?></td>
                      <td class="text-right"><?php echo number_format($ppn, 2, '.', ','); ?></td>
                      <td class="text-right"><?php echo number_format($persen, 2, '.', ','); ?>%</td>
                    </tr>
                  <?php } ?>
                <?php } else { ?>
                  <tr>
                    <td colspan="13" class="text-center">Tidak ada data pada rentang tanggal tersebut.</td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
  $(function() {
    $('#tableLaporanFakturPajak').DataTable({
      responsive: true,
      autoWidth: false,
      pageLength: 25
    });
  });
</script>
