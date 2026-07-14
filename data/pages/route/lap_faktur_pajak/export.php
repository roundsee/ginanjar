<?php
$dir = '../../../../';
include $dir . 'config/koneksi.php';

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

function lfp_get_rows($koneksi, $tgl_awal, $tgl_akhir)
{
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

  $rows = array();
  $res = mysqli_query($koneksi, $q);
  if ($res) {
    while ($d = mysqli_fetch_assoc($res)) {
      $dpp = (float) $d['harga_jual_total'];
      $ppn = (float) $d['jumlah_ppn'];
      $persen = $dpp > 0 ? ($ppn / $dpp) * 100 : 0;
      $tglFaktur = '';
      if (!empty($d['tgl_faktur_report'])) {
        $parts = explode('-', $d['tgl_faktur_report']);
        if (count($parts) === 3) {
          $tglFaktur = $parts[2] . '/' . $parts[1] . '/' . $parts[0];
        }
      }

      $rows[] = array(
        'tgl_faktur' => $tglFaktur,
        'no_faktur' => (string) $d['no_faktur_pajak'],
        'vendor' => $d['nama_pkp'],
        'npwp' => (string) $d['npwp_pkp'],
        'nama_barang' => $d['nama_barang'],
        'satuan' => $d['satuan'],
        'qty' => (float) $d['qty'],
        'harga' => (float) $d['harga_satuan'],
        'diskon' => (float) $d['potongan_harga'],
        'bonus' => 0,
        'dpp' => $dpp,
        'ppn' => $ppn,
        'persen' => $persen
      );
    }
  }

  return $rows;
}

function lfp_excel_text_value($value)
{
  $value = (string) $value;
  $value = str_replace('"', '""', $value);
  // Excel: force text so leading zeros and long digits are preserved.
  return '="' . $value . '"';
}

function lfp_render_table_html($rows)
{
  ob_start();
  ?>
  <table border="1" cellpadding="4" cellspacing="0" style="border-collapse: collapse; font-size: 10px; width: 100%;">
    <thead>
      <tr>
        <th>TGL FAKTUR</th>
        <th>NO FAKTUR</th>
        <th>VENDOR</th>
        <th>NPWP</th>
        <th>NAMA BARANG</th>
        <th>SATUAN</th>
        <th>QTY</th>
        <th>HARGA</th>
        <th>DISKON</th>
        <th>BONUS</th>
        <th>DPP</th>
        <th>PPN</th>
        <th>%</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($rows)) { ?>
        <?php foreach ($rows as $r) { ?>
          <tr>
            <td><?php echo htmlspecialchars($r['tgl_faktur']); ?></td>
            <td style="mso-number-format:'\@';"><?php echo htmlspecialchars($r['no_faktur']); ?></td>
            <td><?php echo htmlspecialchars($r['vendor']); ?></td>
            <td style="mso-number-format:'\@';"><?php echo htmlspecialchars($r['npwp']); ?></td>
            <td><?php echo htmlspecialchars($r['nama_barang']); ?></td>
            <td><?php echo htmlspecialchars($r['satuan']); ?></td>
            <td style="text-align:right;"><?php echo number_format($r['qty'], 2, '.', ','); ?></td>
            <td style="text-align:right;"><?php echo number_format($r['harga'], 2, '.', ','); ?></td>
            <td style="text-align:right;"><?php echo number_format($r['diskon'], 2, '.', ','); ?></td>
            <td style="text-align:right;"><?php echo number_format($r['bonus'], 2, '.', ','); ?></td>
            <td style="text-align:right;"><?php echo number_format($r['dpp'], 2, '.', ','); ?></td>
            <td style="text-align:right;"><?php echo number_format($r['ppn'], 2, '.', ','); ?></td>
            <td style="text-align:right;"><?php echo number_format($r['persen'], 2, '.', ','); ?>%</td>
          </tr>
        <?php } ?>
      <?php } else { ?>
        <tr><td colspan="13" style="text-align:center;">Tidak ada data</td></tr>
      <?php } ?>
    </tbody>
  </table>
  <?php
  return ob_get_clean();
}

$format = isset($_GET['format']) ? strtolower(trim($_GET['format'])) : 'csv';
$tgl_awal = isset($_GET['tgl_awal']) ? lfp_safe_date($_GET['tgl_awal'], date('Y-m-01')) : date('Y-m-01');
$tgl_akhir = isset($_GET['tgl_akhir']) ? lfp_safe_date($_GET['tgl_akhir'], date('Y-m-d')) : date('Y-m-d');
$rows = lfp_get_rows($koneksi, $tgl_awal, $tgl_akhir);
$fileStamp = date('Ymd_His');

if ($format === 'csv') {
  header('Content-Type: text/csv; charset=UTF-8');
  header('Content-Disposition: attachment; filename=laporan_faktur_pajak_' . $fileStamp . '.csv');

  $out = fopen('php://output', 'w');
  fputcsv($out, array('TGL FAKTUR', 'NO FAKTUR', 'VENDOR', 'NPWP', 'NAMA BARANG', 'SATUAN', 'QTY', 'HARGA', 'DISKON', 'BONUS', 'DPP', 'PPN', '%'));
  foreach ($rows as $r) {
    fputcsv($out, array(
      $r['tgl_faktur'],
      lfp_excel_text_value($r['no_faktur']),
      $r['vendor'],
      lfp_excel_text_value($r['npwp']),
      $r['nama_barang'],
      $r['satuan'],
      number_format($r['qty'], 2, '.', ''),
      number_format($r['harga'], 2, '.', ''),
      number_format($r['diskon'], 2, '.', ''),
      number_format($r['bonus'], 2, '.', ''),
      number_format($r['dpp'], 2, '.', ''),
      number_format($r['ppn'], 2, '.', ''),
      number_format($r['persen'], 2, '.', '')
    ));
  }
  fclose($out);
  exit;
}

if ($format === 'xls' || $format === 'excel') {
  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment; filename=laporan_faktur_pajak_' . $fileStamp . '.xls');
  echo lfp_render_table_html($rows);
  exit;
}

if ($format === 'pdf') {
  require_once $dir . 'assets/pdf/_tcpdf_5.0.002/tcpdf.php';

  $pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
  $pdf->SetCreator(PDF_CREATOR);
  $pdf->SetAuthor('Ginanjar Mart');
  $pdf->SetTitle('Laporan Faktur Pajak');
  $pdf->SetMargins(8, 8, 8);
  $pdf->SetAutoPageBreak(true, 8);
  $pdf->AddPage();
  $pdf->SetFont('helvetica', '', 8);

  $html = '<h3>Laporan Faktur Pajak</h3>';
  $html .= '<p>Periode: ' . htmlspecialchars($tgl_awal) . ' s/d ' . htmlspecialchars($tgl_akhir) . '</p>';
  $html .= lfp_render_table_html($rows);

  $pdf->writeHTML($html, true, false, true, false, '');
  $pdf->Output('laporan_faktur_pajak_' . $fileStamp . '.pdf', 'D');
  exit;
}

header('Location: ../../main.php?route=lap_faktur_pajak');
exit;
