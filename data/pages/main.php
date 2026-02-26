<?php
//error_reporting(0);

session_start();

$dir = "../../";
$login_hash = $_SESSION['login_hash'];
$en = $_SESSION['employee_number'];
$to = $_SESSION['to'];
$area_e = $_SESSION['area_e'];
$area_nama = $_SESSION['area_nama'];
$namauser = $_SESSION['namauser'];
$jabatan = $_SESSION['jabatan'];
$pelanggan_nama = $_SESSION['pelanggan_nama'];

// echo '<br><br>';
// echo '<br>login_hash : '.$login_hash;
// echo '<br>namauser : '.$namauser;
// echo '<br>pelanggan_nama : '.$pelanggan_nama;
// echo '<br>employee_number : '.$en;
// echo '<br>kd_cus : '.$kd_cus;
// echo '<br>cabang_e : '.$cabang_e;

if (empty($_SESSION['namauser']) and empty($_SESSION['passuser'])) {
  echo "<link href='../../dist/style.css' rel='stylesheet' type='text/css'>
  <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<div class='wrapper'><a href=../../index.php><b>LOGIN</b></a></div></center>";
} else {
  include $dir . "config/koneksi.php";
  include $dir . "config/fungsi_kode_otomatis.php";
  include $dir . "config/fungsi_rupiah.php";
  include $dir . "config/fungsi_indotgl.php";
  include $dir . "config/library.php";

  $en = $_SESSION['employee_number'];
  $foto = mysqli_query($koneksi, "SELECT * from employee where employee_number='$_SESSION[employee_number]' ");
  $f_foto = mysqli_fetch_array($foto);
  $filefoto = $f_foto['photo'];
  if ($filefoto == 'profil.jpg') {
    $filefoto = 'member.jpg';
  }

?>
  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $perusahaan; ?> system</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../../images/favicon.ico">

    <!-- Font Awesome -->
    <!-- <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css"> -->
    <!-- fontawesome-free-6.3.0-web -->
    <link rel="stylesheet" href="../../assets/fontawesome-free-6.3.0-web/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="../../plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="../../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- tambahan DatePicker -->
    <link rel="stylesheet" href="../../dist/bootstrap-datepicker-1.9.0-dist/css/bootstrap-datepicker.min.css">

    <!-- Tambahkan jqueryUI disini -->
    <script type="text/javascript" src="<?php echo $dir; ?>jquery-ui/js/jquery-1.10.2.js"></script>
    <script src="<?php echo $dir; ?>jquery-ui/js/tableToExcel.js" defer></script>

    <!-- <script type="text/javascript" src="<?php echo $dir; ?>jquery-ui/js/jquery-ui-1.10.4.custom.min.js"></script> -->
    <link type="text/css" rel="stylesheet" href="<?php echo $dir; ?>jquery-ui/css/smoothness/jquery-ui-1.10.4.custom.min.css" />

    <!-- SweetAlert -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- Style sendiri -->
    <link rel="stylesheet" type="text/css" href="../../dist/wib.css">

    <!-- Tuesday Demo Page -->
    <link rel="stylesheet" type="text/css" href="../../dist/animated_tuesday/build/tuesday.css" />
    <!--animate-->
    <link rel="stylesheet" type="text/css" href="../../dist/anima.css" media="all">


    <!-- <script src="<?php echo $dir; ?>dist/js/wow.min.js"></script> -->
    <script>
      new WOW().init();
    </script>
    <!--//end-animate-->

    <style type="text/css">
      /* Full-page overlay */
      #loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        z-index: 9999;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: #fff;
        font-size: 1.2em;
      }

      /* Spinner Animation */
      .spinner {
        width: 60px;
        height: 60px;
        border: 8px solid #f3f3f3;
        border-top: 8px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
      }

      @keyframes spin {
        0% {
          transform: rotate(0deg);
        }

        100% {
          transform: rotate(360deg);
        }
      }

      .table td,
      .table th {
        padding: .575rem;
      }

      .table3 td,
      .table3 th {
        padding: .375rem;
      }
    </style>
  </head>

  <body class="skin-green layout-top-nav control-sidebar-slide-open layout-navbar-fixed layout-footer-fixed text-sm" style="height: auto;">
    <div class="wrapper">

      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand-md navbar-light  dropdown-legacy accent-warning elevation-2 border-bottom-0 bg_primary_2">
        <div class="container-fluid" style="margin:0;">
          <a href="#" class="navbar-brand">
            <img src="../../images/logo3.jpg" alt="Steak & Shake Logo" class="brand-image elevation-2" style="opacity: .8">
            <span class="brand-text font-weight-light" style="color:white;"><?php echo $perusahaan; ?></span>
          </a>

          <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation" style="background-color: gainsboro;">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <!-- Left navbar links -->
            <ul class="navbar-nav" style="font-weight:200;">
              <li class="nav-item">
                <a href="main.php?route=home" class="nav-link warna_primary_2">
                  <i class="fa fa-home"></i> BERANDA
                </a>
              </li>


              <?php if ($login_hash == 0 or $login_hash == 1  or $login_hash == 3 or $login_hash == 6 and $login_hash != 21) { ?>

                <li class="nav-item dropdown">
                  <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle  warna_primary_2">
                    <i class="fa-solid fa-database"></i> DATA</a>
                  <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow " style="left: 0px; right: inherit;">

                    <li><a href="main.php?route=barang&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=barang" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> DATA BARANG</a></li>
                    <li><a href="main.php?route=gudang&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=barang" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> DATA GUDANG</a></li>
                    <!-- <li><a href="main.php?route=kategori_satuan&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=barang" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> DATA KATEGORI SATUAN</a></li> -->

                    <li><a href="main.php?route=member&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=member" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> DATA MEMBER</a></li>

                    <li><a href="main.php?route=supplier&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=supplier" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> DATA SUPPLIER</a></li>
                    <li><a href="main.php?route=sales&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=sales" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> DATA SALES</a></li>

                    <li><a href="main.php?route=kategori&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=kategori" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> DATA KATEGORI</a></li>
                    <li><a href="main.php?route=kategori_buffer&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=barang" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> DATA KATEGORI BUFFER</a></li>

                    <li><a href="main.php?route=account&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=account" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> DATA ACCOUNT</a></li>

                    <li><a href="main.php?route=jenis_transaksi&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=jenis_transaksi" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> JENIS TRANSAKSI </a></li>

                  </ul>
                </li>

                <li class="nav-item dropdown">
                  <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle  warna_primary_2">
                    <i class="fa-solid fa-database"></i> MUTASI </a>
                  <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow " style="left: 0px; right: inherit;">
                    <li><a href="main.php?route=mutasi_stok&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=mutasi_stok" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> MUTASI STOK </a></li>
                    <li><a href="main.php?route=export_pembelian&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=export_pembelian" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> EXPORT PEMBELIAN </a></li>
                    <li><a href="main.php?route=export_pembelian_retur&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=export_pembelian_retur" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> EXPORT PEMBELIAN RETUR </a></li>
                    <li><a href="main.php?route=export_penjualan&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=export_penjualan" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> EXPORT PENJUALAN </a></li>
                    <li><a href="main.php?route=import_pembelian&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=import_pembelian" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> IMPORT PEMBELIAN </a></li>
                    <li><a href="main.php?route=import_pembelian_retur&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=import_pembelian_retur" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> IMPORT PEMBELIAN RETUR </a></li>
                    <li><a href="main.php?route=import_penjualan&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=import_penjualan" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> IMPORT PENJUALAN </a></li>

                  </ul>
                </li>
                <li class="nav-item dropdown">
                  <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle  warna_primary_2">
                    <i class="fa-solid fa-database"></i> SETTING </a>
                  <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow " style="left: 0px; right: inherit;">
                    <li><a href="main.php?route=staff&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=staff" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> CREATE STAFF </a></li>
                    <li><a href="register.php" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> REGISTER LOGIN STAFF </a></li>
                  </ul>
                </li>

              <?php } ?>


              <?php if ($login_hash == 0 or $login_hash == 1 or $login_hash == 2 or $login_hash == 3 or $login_hash == 6  or $login_hash == 21) { ?>

                <li class="nav-item dropdown">
                  <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle  warna_primary_2">
                    <i class="fa-solid fa-database"></i> TRANSAKSI</a>
                  <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow " style="left: 0px; right: inherit;">

                    <!-- <li><a href="main.php?route=pembelian&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=beli" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> PEMBELIAN</a></li> -->
                    <?php if ($login_hash != 21 && $login_hash != 2) { ?>
                      <li><a href="main.php?route=generate_stok&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=beli" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> GENERATE BASED ON QTY</a></li>
                      <li><a href="main.php?route=generate_stok_supplier&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=beli" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> GENERATE BASED ON SUPPLIER</a></li>
                      <li><a href="main.php?route=beli&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=beli" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> PURCHASE REQUEST</a></li>
                      <li><a href="main.php?route=purchase_order&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=purchase_order" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> PURCHASE ORDER</a></li>
                    <?php } ?>
                    <?php if ($login_hash != 2) { ?>
                      <?php if ($login_hash == 21) { ?>
                        <li><a href="main.php?route=purchase_order_gudang&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=purchase_order" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> PURCHASE ORDER GUDANG</a></li>
                      <?php } ?>
                      <li><a href="main.php?route=good_receiving&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=good_receiving" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> GOODS RECEIVING</a></li>
                      <li><a href="main.php?route=pembelian_retur&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=data-pembelian-retur" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> PURCHASE RETURN </a></li>
                      <!-- <li><a href="main.php?route=invoice_pembelian&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=good_receiving" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> INVOICE PEMBELIAN</a></li> -->
                    <?php } ?>
                    <?php if ($login_hash == 2) { ?>
                      <li><a href="main.php?route=good_receiving&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=good_receiving" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> GOODS RECEIVING</a></li>
                      <li><a href="main.php?route=konsinyasi&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=konsinyasi" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> KONSINYASI</a></li>

                      <li><a href="main.php?route=purchase_order_keuangan&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=purchase_order" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> PURCHASE ORDER KEUANGAN</a></li>
                      <!-- <li><a href="main.php?route=invoice_pembelian&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=good_receiving" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> INVOICE PEMBELIAN</a></li> -->

                    <?php } ?>
                  </ul>
                </li>

              <?php } ?>
              <!-- <?php if ($login_hash == 0 or $login_hash == 1 or $login_hash == 2 or $login_hash == 3 or $login_hash == 6) { ?>

                <li class="nav-item dropdown">
                  <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle  warna_primary_2">
                    <i class="fa-solid fa-database"></i> INVOICE </a>
                  <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow " style="left: 0px; right: inherit;">


                  </ul>
                </li>

              <?php } ?> -->

              <?php if ($login_hash == 0 or $login_hash == 1 or $login_hash == 2 or $login_hash == 3 or $login_hash == 6) { ?>

                <li class="nav-item dropdown">
                  <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle  warna_primary_2">
                    <i class="fa-solid fa-database"></i> PAYMENT </a>
                  <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow " style="left: 0px; right: inherit;">
                    <!-- <li><a href="main.php?route=payment&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=good_receiving" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> PAYMENT</a></li> -->
                    <li><a href="main.php?route=payment_based_tanggal&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=payment_based_tanggal" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> PAYMENT BASED ON TANGGAL</a></li>
                    <li><a href="main.php?route=payment_based_supplier&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=payment_based_supplier" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> PAYMENT BASED ON SUPPLIER</a></li>
                    <li><a href="main.php?route=payment_lunas_based_tanggal&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=payment_lunas_based_tanggal" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> PAYMENT LUNAS BASED ON TANGGAL</a></li>
                    <!-- <li><a href="main.php?route=payment_success&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=good_receiving" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> PAYMENT LUNAS</a></li> -->
                    <!-- <li><a href="main.php?route=payment_belum_lunas&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=good_receiving" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> PAYMENT BELUM LUNAS</a></li> -->
                    <li>
                      <hr class="dropdown-divider">
                    </li>
                    <li><a href="main.php?route=outstanding_utang&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=outstanding_utang" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> OUTSTANDING UTANG </a></li>
                    <li><a href="main.php?route=outstanding_utang_detail&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=outstanding_utang" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> OUTSTANDING UTANG DETAIL</a></li>
                  </ul>
                </li>


                <!-- <li class="nav-item dropdown">
                  <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle  warna_primary_2">
                    <i class="fa-solid fa-database"></i> PAYMENT </a>
                  <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow " style="left: 0px; right: inherit;">

                    <li><a href="main.php?route=payment_invoice&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=good_receiving" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> PAYMENT</a></li>
                    <li><a href="main.php?route=payment_lunas&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=good_receiving" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> PAYMENT LUNAS</a></li>
                    <li><a href="main.php?route=payment_belum_lunas&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=good_receiving" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> PAYMENT BELUM LUNAS</a></li>

                  </ul>
                </li> -->

              <?php } ?>



              <?php if ($login_hash == 0 or $login_hash == 1 or $login_hash == 2 or $login_hash == 4 or $login_hash == 5 or $login_hash == 6 or $login_hash == 7 or $login_hash == 8 or $login_hash == 10 or $login_hash == 11) { ?>

                <li class="nav-item dropdown">
                  <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle  warna_primary_2">
                    <i class="fa-solid fa-database"></i> BIAYA </a>
                  <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow " style="left: 0px; right: inherit;">
                    <li><a href="main.php?route=biaya&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=biaya" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> BIAYA</a></li>
                  </ul>
                </li>
                <li class="nav-item dropdown">
                  <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link  warna_primary_2 dropdown-toggle">
                    <i class="fa-solid fa-clipboard"></i> LAPORAN</a>
                  <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow" style="left: 0px; right: inherit;">

                    <li class="dropdown-submenu dropdown-hover">
                      <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle"> MUTASI</a>
                      <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow ">
                        <?php if ($login_hash == 0 or $login_hash == 1 or $login_hash == 2 or $login_hash == 4 or $login_hash == 5 or $login_hash == 6 or $login_hash == 8 or $login_hash == 9 or $login_hash == 12 or $login_hash == 13 or $login_hash == 14) { ?>

                          <li>
                            <a tabindex="-1" href="main.php?route=lap_mutasi_per_barang&act&ide=<?php echo $_SESSION['employee_number']; ?>&tujuan=mutasi" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> Mutasi Stok (Barang)</a>
                          </li>
                          <!-- ---------------- -->


                          <li>
                            <a tabindex="-1" href="main.php?route=lap_mutasi_stok_per_outlet&act&ide=<?php echo $_SESSION['employee_number']; ?>&tujuan=mutasi" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> Mutasi Stok (nilai)</a>
                          </li>
                          <!-- ---------------- -->
                        <?php } ?>

                      </ul>
                    </li>
                    <li class="dropdown-divider"></li>

                    <li><a href="main.php?route=lap_pembelian&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=pb1" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> Laporan Pembelian </a></li>
                    <li><a href="main.php?route=lap_biaya&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=lap_biaya" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> Laporan Biaya </a></li>
                    <li class="dropdown-divider"></li>

                    <li><a href="main.php?route=pb1&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=pb1" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> Daftar Penjualan </a></li>
                    <!-- <li><a href="main.php?route=daftar_pembelian&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=daftar_pembelian" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> Daftar Pembelian </a></li> -->
                  <?php } ?>

                  <?php if ($login_hash == 0 or $login_hash == 1 or $login_hash == 3 or $login_hash == 4 or $login_hash == 5) { ?>

                    <li><a href="main.php?route=daftar_harga_model2&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=daftar_harga" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> Daftar HARGA</a></li>
                  <?php } ?>
                  <?php if ($login_hash == 0 or $login_hash == 1 or $login_hash == 2 or $login_hash == 3 or $login_hash == 6) { ?>

                  <?php } ?>

                  <!-- <?php if ($login_hash == 0 or $login_hash == 1 or $login_hash == 4 or $login_hash == 5) { ?>

                    <li><a href="main.php?route=daftar_diskon&act&ide=<?php echo $_SESSION['employee_number']; ?>&tujuan"   class="dropdown-item"><i class="fa-solid fa-caret-right"></i>  Daftar DISKON & PROMOSI</a></li>
                  <?php } ?> -->

                  <!-- <?php if ($login_hash == 0 or $login_hash == 1 or $login_hash == 2 or $login_hash == 4 or $login_hash == 5) { ?>

                    <li class="dropdown-divider"></li>

                    <li class="dropdown-submenu dropdown-hover">
                      <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle"> Daftar VOUCHER</a>
                      <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow ">

                        <li><a href="main.php?route=daftar_voucher&act&ide=<?php echo $_SESSION['employee_number']; ?>&tujuan=terbit"   class="dropdown-item"><i class="fa-solid fa-caret-right"></i> yg di terbitkan</a></li>
                        <li><a href="main.php?route=daftar_voucher&act&ide=<?php echo $_SESSION['employee_number']; ?>&tujuan=blm"   class="dropdown-item"><i class="fa-solid fa-caret-right"></i> yg Blm di Gunakan</a></li>
                        <li><a href="main.php?route=daftar_voucher&act&ide=<?php echo $_SESSION['employee_number']; ?>&tujuan=sdh"   class="dropdown-item"><i class="fa-solid fa-caret-right"></i> yg Sdh di Gunakan</a></li>

                      </ul>
                    </li>
                  <?php } ?> -->

                  <!-- <?php if ($login_hash == 0 or $login_hash == 1 or $login_hash == 3) { ?>

                    <li class="dropdown-divider"></li>

                    <li><a href="main.php?route=daftar_alat_bayar_model2&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=alat_bayar" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> Daftar ALAT PEMBAYARAN</a></li>
                  <?php } ?> -->



                  <!-- <?php if ($login_hash != 6 and $login_hash != 7) { ?>

                    <li class="dropdown-divider"></li>

                    <li class="dropdown-submenu dropdown-hover">
                      <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle"> Daftar PENJUALAN</a>
                      <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow ">
                        <?php if ($login_hash == 0 or $login_hash == 1 or $login_hash == 2 or $login_hash == 4 or $login_hash == 5 or $login_hash == 8) { ?>

                          <li>
                            <a tabindex="-1" href="main.php?route=rekap_penjualan&act&ide=<?php echo $_SESSION['employee_number']; ?>&tujuan=outlet"  class="dropdown-item"><i class="fa-solid fa-caret-right"></i> Rekap PENJUALAN per OUTLET</a>
                          </li>
                          
                        <?php } ?>

                        <?php if ($login_hash == 0 or $login_hash == 1 or $login_hash == 2 or $login_hash == 8) { ?>

                          <li>
                            <a tabindex="-1" href="main.php?route=rekap_penjualan&act&ide=<?php echo $_SESSION['employee_number']; ?>&tujuan=kasir"  class="dropdown-item"><i class="fa-solid fa-caret-right"></i> Rekap PENJUALAN per KASIR</a>
                          </li>
                          
                        <?php } ?>


                        <?php if ($login_hash == 0 or $login_hash == 1 or $login_hash == 2 or $login_hash == 4 or $login_hash == 5 or $login_hash == 8) { ?>

                          <li><a href="main.php?route=rekap_penjualan&act&ide=<?php echo $_SESSION['employee_number']; ?>&tujuan=aplikasi"   class="dropdown-item"><i class="fa-solid fa-caret-right"></i> Rekap PENJUALAN per APLIKASI</a></li>
                          
                        <?php } ?>


                        <?php if ($login_hash == 0 or $login_hash == 1 or $login_hash == 2 or $login_hash == 10) { ?>

                          <li><a href="main.php?route=rekap_penjualan&act&ide=<?php echo $_SESSION['employee_number']; ?>&tujuan=alatbayar" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> Rekap PENJUALAN per ALAT BAYAR</a></li>
                          
                        <?php } ?>


                        <?php if ($login_hash == 0 or $login_hash == 1 or $login_hash == 2 or $login_hash == 8) { ?>

                          <li><a href="main.php?route=rekap_penjualan&act&ide=<?php echo $_SESSION['employee_number']; ?>&tujuan=carabayar" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> Rekap PENJUALAN dari EDC & APLIKASI</a></li>
                          
                        <?php } ?>


                        <?php if ($login_hash == 0 or $login_hash == 1 or $login_hash == 2 or $login_hash == 4 or $login_hash == 5 or $login_hash == 8) { ?>

                          <li><a href="main.php?route=rekap_penjualan_menu&act&ide=<?php echo $_SESSION['employee_number']; ?>&tujuan=menu" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> Rekap PENJUALAN per MENU</a></li>
                          
                        <?php } ?>

                        <?php if ($login_hash == 0 or $login_hash == 1 or $login_hash == 2 or $login_hash == 4 or $login_hash == 5 or $login_hash == 8) { ?>

                          <li><a href="main.php?route=rekap_penjualan_menu_outlet&act&ide=<?php echo $_SESSION['employee_number']; ?>&tujuan=menu" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> Rekap PENJUALAN per Outlet MENU</a></li>
                          
                        <?php } ?>


                      </ul>
                    </li>
                    <li class="dropdown-divider"></li>
                    
                  <?php } ?> -->

                  <!-- <?php if ($login_hash == 0 or $login_hash == 1 or $login_hash == 2 or $login_hash == 10) { ?>

                    <li><a href="main.php?route=rekap_penjualan_sage&act&ide=<?php echo $_SESSION['employee_number']; ?>&tujuan=alatbayar" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> Rekap PENJUALAN per ALAT BAYAR (Khusus)</a></li>
                    
                  <?php } ?> -->


                  <!-- <?php if ($login_hash == 0 or $login_hash == 1 or $login_hash == 2) { ?>

                    <li class="dropdown-divider"></li>

                    <li class="dropdown-submenu dropdown-hover">
                      <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">  BEBAN ADM Bank</a>
                      <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">

                        <li><a href="main.php?route=menu_lap_beban_adm&act&ide=<?php echo $_SESSION['employee_number']; ?>&tujuan="   class="dropdown-item"><i class="fa-solid fa-caret-right"></i> Laporan BEBAN ADM Bank</a></li>

                        <li><a href="main.php?route=menu_rekap_beban_adm&act&ide=<?php echo $_SESSION['employee_number']; ?>&tujuan="   class="dropdown-item"><i class="fa-solid fa-caret-right"></i> Rekap BEBAN ADM Bank</a></li>

                      </ul>
                    </li>
                  <?php } ?> -->


                  <!-- <?php if ($login_hash == 0 or $login_hash == 1 or $login_hash == 2) { ?>

                    <li class="dropdown-divider"></li>

                    <li class="dropdown-submenu dropdown-hover">
                      <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle"> BEBAN FEE</a>
                      <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow ">

                        <li><a href="main.php?route=lap_beban_fee&act&ide=<?php echo $_SESSION['employee_number']; ?>&tujuan="   class="dropdown-item"><i class="fa-solid fa-caret-right"></i> Laporan BEBAN FEE Penjualan</a></li>

                        <li><a href="main.php?route=rekap_beban_fee&act&ide=<?php echo $_SESSION['employee_number']; ?>&tujuan="   class="dropdown-item"><i class="fa-solid fa-caret-right"></i> Rekap BEBAN FEE Penjualan</a></li>

                      </ul>
                    </li>
                  <?php } ?> -->

                  <?php if ($login_hash == 0 or $login_hash == 1 or $login_hash == 2 or $login_hash == 6 or $login_hash == 7 or $login_hash == 8) { ?>

                    <li class="dropdown-divider"></li>

                    <li><a href="main.php?route=rekap_sales_report&act&ide=<?php echo $_SESSION['employee_number']; ?>&tujuan=menu" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> Sales Report</a></li>


                  <?php } ?>

                  <!-- <?php if ($login_hash == 0 or $login_hash == 1 or $login_hash == 2) { ?>

                    <li class="dropdown-divider"></li>

                    <li class="dropdown-submenu dropdown-hover">
                      <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">  Payment POS</a>
                      <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow ">

                        <li><a href="main.php?route=payment_pos1&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=pos1" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> Payment POS</a></li>
                        <li><a href="main.php?route=payment_pos2&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=pos2" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> Payment POS Detail</a></li>
                        <li><a href="main.php?route=payment_pos2b&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=pos2" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> Payment POS Detail B</a></li>

                      </ul>
                    </li>

                  <?php } ?> -->



                  <?php if ($login_hash == 0 or $login_hash == 1 or $login_hash == 2 or $login_hash == 6 or $login_hash == 7 or $login_hash == 8) { ?>
                    <li class="dropdown-divider"></li>

                    <li class="dropdown-submenu dropdown-hover">
                      <a href="main.php?route=void_pos1&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=pos1" class="dropdown-item"><i class="fa-solid fa-caret-right"></i> VOID POS</a>
                    </li>
                    <!-- <li class="dropdown-divider"></li>

                    <li class="dropdown-submenu dropdown-hover">
                      <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle"> VOID POS</a>
                      <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow ">

                      </ul>
                    </li> -->

                  <?php } ?>

                  <!-- <?php if ($login_hash == 0 or $login_hash == 1 or $login_hash == 2) { ?>

                        <li class="dropdown-divider"></li>

                        <li><a href="main.php?route=omzet&act&ide=<?php echo $_SESSION['employee_number']; ?>&tujuan="   class="dropdown-item"><i class="fa-solid fa-caret-right"></i>  Laporan Omzet</a></li>
                      <?php } ?> -->


                  <li class="dropdown-divider"></li>
                  <?php
                  if ($login_hash == 6) {

                  ?>

                    <li><a href="main.php?route=test_penjualan&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=test1&tujuan=" class="dropdown-item">Test Penjualan</a></li>
                    <li><a href="main.php?route=test_penjualan_detil&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=test1&tujuan=" class="dropdown-item">Test Penjualan detil</a></li>
                  <?php
                  }
                  ?>

                  <?php
                  if ($login_hash == 0) {

                  ?>

                    <li><a href="main.php?route=test_penjualan&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=test1&tujuan=" class="dropdown-item">Test Penjualan</a></li>
                    <li><a href="main.php?route=test_penjualan_detil&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=test1&tujuan=" class="dropdown-item">Test Penjualan detil</a></li>

                    <li><a href="main.php?route=setup&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=setup" class="dropdown-item">SETUP</a></li>

                    <li><a href="main.php?route=void_pos2&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=pos2" class="dropdown-item"> VOID POS Detail</a></li>

                  <?php
                  }
                  ?>

                  </ul>
                </li>

                <?php if (($login_hash == 6 or $login_hash == 7 or $login_hash == 8 or $login_hash == 0 or $login_hash == 21 or $login_hash == 2) and ($to == 'manager' or $to == 'manajer_regional')) { ?>
                  <!-- <li class="nav-item"> -->
                  <a href="../../logout.php" class="nav-link warna_primary_2">
                    <img src="../../assets/icons/person-leave-solid-w.png" width="20px"> LOG OUT
                  </a>
                  <!-- </li> -->
                <?php } ?>

                <?php if (($login_hash == 6 or $login_hash == 7) and $to == 'kasir') { ?>

                  <li class="nav-item">
                    <a href="../../kasir/pages/main.php?route=kasir&to=kasir" class="nav-link warna_primary_2" onclick="window.close()">
                      <img src="../../assets/icons/rotate-left-solid-w.png" width="25px"> Back
                    </a>
                  </li>
                <?php } ?>

            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
              <li class="nav-item" style="margin-left: 1em; margin-top: .9em;">
                <a href="main.php?route=profile&act"><img src="../../images/staff/<?php echo $filefoto; ?>" alt="photo Profile" class="brand-image elevation-2" style="opacity: .8"></a>
              </li>
              <a style="font-weight:100; color:white">
                <?php echo $namauser . '<br>' . $jabatan . ' - ' . $pelanggan_nama; ?>
              </a>
            </ul>
          </div>


        </div>


      </nav>
      <!-- /.navbar -->



      <!-- Control Sidebar -->

      <!-- /.control-sidebar -->

      <!-- Content Wrapper. Contains page content -->
      <div class="list-gds">
        <?php include "content.php"; ?>
      </div>
      <!-- /.content-wrapper -->

      <!-- Main Footer -->
      <footer class="main-footer bg_primary_1" style="padding:.3rem;font-size:.75rem">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
          <b>Version</b> <?php echo $ver; ?>
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; <?php echo $thn_sekarang . " " . $perusahaan; ?>.</strong> by Develop. All rights Reserved.
      </footer>
    </div>

    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="../../plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- InputMask -->
    <script src="../../plugins/moment/moment.min.js"></script>
    <script src="../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
    <!-- date-range-picker -->
    <script src="../../plugins/daterangepicker/daterangepicker.js"></script>
    <!-- DataTables -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <!-- bootstrap color picker -->
    <script src="../../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- ChartJS -->
    <script src="../../plugins/chart.js/Chart.min.js"></script>
    <!-- tambahan utk datepicer -->
    <script src="../../dist/bootstrap-datepicker-1.9.0-dist/js/bootstrap-datepicker.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>


  </body>

  </html>


  <!-- Page script -->
  <script>
    var _delay = 3000;

    function checkLoginStatus() {
      $.get("checkStatus.php", function(data) {
        if (!data) {
          window.location = "../../logout.php";
        }
        setTimeout(function() {
          checkLoginStatus();
        }, _delay);
      });
    }
    checkLoginStatus();
    var tablebaranguntuksearch = $("#examplebarang").DataTable({
      "responsive": true,
      "autoWidth": false,
      'searching': false,
    });
    $(document).on("input", "#cariBarangManual", function() {
      var searchValue = $(this).val();


      $.ajax({
        type: 'GET',
        url: 'route/searchTableBarang.php?value=' + searchValue,
        dataType: 'json',
        success: function(response) {
          tablebaranguntuksearch.clear().draw();
          $("#barangTableBodysearch").empty();

          // Check if the response has data
          if (response.length > 0) {
            // Loop through the response and append rows to the tbody
            $.each(response, function(index, item) {
              const newRow = `
                        <tr align="left">
                            <td>${index + 1}</td>
                            <td>${item.f1}</td>
                            <td>${item.f2}</td>
                            <td>${item.f3}</td>
                            <td>${item.f_41}</td>
                            <td>${item.f_42}</td>
                            <td>${item.f_43}</td>
                            <td>${item.f_44}</td>
                            <td>${item.f_45}</td>
                            <td>${item.f_91}</td>
                            <td>${item.f_92}</td>
                            <td>${item.f_93}</td>
                            <td>${item.f_94}</td>
                            <td>${item.f_95}</td>
                            <td style="text-align: right;">${item.f_31}</td>
                            <td style="text-align: right;">${item.f_32}</td>
                            <td style="text-align: right;">${item.f_33}</td>
                            <td style="text-align: right;">${item.f_34}</td>
                            <td style="text-align: right;">${item.f_35}</td>
                            <td>${item.f31}</td>
                            <td>${item.f32}</td>
                            <td>${item.f33}</td>
                            <td>${item.f34}</td>
                            <td>${item.f35}</td>
                            <td>${item.f36}</td>
                            <td>${item.f37}</td>
                            <td>${item.f9}</td>
                            <td style="text-align: center;"><img src="../../images/menu/${item.datagambar}" class="brand-image elevation-3" style="opacity: 1;width: 60px;"></td>
                            <td>
                                <div style="margin: 10px"></div>
                                <a href="main.php?route=barang&act=edit&id=${item.f1}" title="Edit">
                                    <button class="btn btn-primary btn-sm elevation-2" style="opacity: .7;width:80px"><i class="fa fa-edit"></i> Edit</button>
                                </a>
                                <br />
                                <a href="route/data_barang/aksi_barang.php?route=barang&act=hapus&id=${item.f1}" title="Hapus" onclick="return confirm('Apakah anda yakin ingin menghapus ini ?')">
                                    <button class="btn btn-danger btn-sm elevation-2" style="opacity: .7;width:80px"><i class="fa fa-trash"></i> Hapus</button>
                                </a>
                            </td>
                        </tr>
                    `;
              $("#barangTableBodysearch").append(newRow);
            });

            // Add the new data to the DataTable
            tablebaranguntuksearch.rows.add($("#barangTableBodysearch tr")).draw();
          } else {
            // Optional: handle case when no results found
            const newRow = `
                        <tr align="middle">
                            <td colspan="40">"Tidak ada Data"</td>
                        </tr>
                    `;
            $("#barangTableBodysearch").append(newRow);
            tablebaranguntuksearch.rows.add($("#barangTableBodysearch tr")).draw();

          }
        },
        error: function(xhr, status, error) {
          console.log(xhr.responseText);
        }
      });
    });

    $('#sandbox-container .input-group.date').datepicker({
      format: "dd-mm-yyyy",
      autoclose: true,
      todayHighlight: true
    });
  </script>

  <script>
    $('.datepicker').datepicker({
      format: "dd-mm-yyyy",
      autoclose: true,
      todayHighlight: true
    });
  </script>
  <script>
    $('#table-datatable-outlet').DataTable({
      'paging': true,
      'lengthChange': false,
      'searching': true,
      'ordering': false,
      'info': true,
      'autoWidth': true,
      "pageLength": 50
    });

    $('#table-datatable-kota').DataTable({
      'paging': true,
      'lengthChange': false,
      'searching': true,
      'ordering': false,
      'info': true,
      'autoWidth': true,
      "pageLength": 50
    });

    $('#table-datatable-barang').DataTable({
      'paging': true,
      'lengthChange': false,
      'searching': true,
      'ordering': false,
      'info': true,
      'autoWidth': true,
      "pageLength": 50
    });
  </script>

  <script>
    $(function() {
      $("#example1").DataTable({
        "responsive": true,
        "autoWidth": false,
      });
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>
  <script>
    $(function() {
      //Initialize Select2 Elements
      $('.select2').select2()

      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })

      //Datemask dd/mm/yyyy
      $('#datemask').inputmask('dd/mm/yyyy', {
        'placeholder': 'dd/mm/yyyy'
      })
      //Datemask2 mm/dd/yyyy
      $('#datemask2').inputmask('mm/dd/yyyy', {
        'placeholder': 'mm/dd/yyyy'
      })
      //Money Euro
      $('[data-mask]').inputmask()

      //Date range picker 1
      $('#reservationdate').datetimepicker({
        format: 'DD/MM/YYYY'
      });

      //Date range picker 2
      $('#reservationdate2').datetimepicker({
        format: 'DD/MM/YYYY'
      });
      //Date range picker
      $('#reservation').daterangepicker()
      //Date range picker with time picker
      $('#reservationtime').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        locale: {
          format: 'MM/DD/YYYY'
        }
      })


      //Date range as a button
      $('#daterange-btn').daterangepicker({
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function(start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        }
      )

      //Timepicker
      $('#timepicker').datetimepicker({
        format: 'LT'
      })

      //Bootstrap Duallistbox
      $('.duallistbox').bootstrapDualListbox()

      //Colorpicker
      $('.my-colorpicker1').colorpicker()
      //color picker with addon
      $('.my-colorpicker2').colorpicker()

      $('.my-colorpicker2').on('colorpickerChange', function(event) {
        $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
      });

      $("input[data-bootstrap-switch]").each(function() {
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
      });

    })
  </script>

  <script>
    $(function() {
      $("#datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        yearRange: '-45:+10'
      });
    });
  </script>

  <script>
    $(function() {
      $("#datepicker2").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        yearRange: '-45:+10'
      });
    });
  </script>

  <script>
    $(function() {
      $("#datepicker3").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        yearRange: '-45:+10'
      });
    });
  </script>

  <script>
    function goBack() {
      window.history.back();
    }
  </script>


<?php
}
?>