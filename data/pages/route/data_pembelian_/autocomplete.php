<?php
$dir = '../../../../';
session_start();

include $dir . 'config/koneksi.php';
include $dir . 'config/library.php';

$judulform = "Daftar Pembelian";

$data = 'data_pembelian';
$rute = 'pembelian';
$aksi = 'aksi_pembelian';

$tabel = 'pembelian';

$f1 = 'kd_beli';
$f2 = 'tg_beli';
$f3 = 'kd_supp';
$f4 = 'ket_payment';
$f5 = 'status_payment';
$f6 = 'jenis_po';


$j1 = 'Kode Pembelian';
$j2 = 'Tanggal';
$j3 = 'Kode Supplier';
$j4 = 'Ket Payment';
$j5 = 'Status';
$j6 = 'Jenis';

include '../header.php';

$asal = $_GET['asal'];
?>

<table class="table-responsive">
  <form method="post" enctype="multipart/form-data" action="<?php echo $aksi; ?>.php?route=<?php echo $rute; ?>&act=input&asal=<?php echo $_GET['asal']; ?>">

    <div class="form-group">
      <label><?php echo $j2; ?></label>
      <input type="text" name="<?php echo $f2; ?>" class="form-control" placeholder="Masukan <?php echo $j2; ?> ..." />
    </div>

    <div class="form-group">
      <label><?php echo $j3; ?></label>
      <input type="text" name="<?php echo $f3; ?>" class="form-control" placeholder="Masukan <?php echo $j3; ?> ..." />
    </div>

    <div class="form-group">
      <label><?php echo $j4; ?></label>
      <input type="text" name="<?php echo $f4; ?>" class="form-control" placeholder="Masukan <?php echo $j4; ?> ..." />
    </div>

    <div class="form-group">
      <label><?php echo $j5; ?></label>
      <input type="text" name="<?php echo $f5; ?>" class="form-control" placeholder="Masukan <?php echo $j5; ?> ..." />
    </div>

    <div class="form-group">
      <label><?php echo $j6; ?></label>
      <input type="text" name="<?php echo $f6; ?>" class="form-control" placeholder="Masukan <?php echo $j6; ?> ..." />
    </div>


    <div class="form-group">
      <hr />
      <input type="submit" class="btn btn-primary elevation-2" style="opacity: .7" value="Simpan" />
    </div>


  </form>
  <a href="../../main.php?route=<?php echo $rute; ?>&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=<?php echo $rute; ?>"><button class="btn btn-primary btn-sm elevation-1" style="opacity: .7">Back</button></a>

</table>

<?php include '../footer.php'; ?>