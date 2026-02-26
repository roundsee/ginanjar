<?php

$judulform = "Daftar Barang";

$data = 'data_barang';
$rute = 'barang';
$aksi = 'aksi_barang';

$tabel = 'barang';

$f1 = 'kd_brg';
$f2 = 'nama';
$f3 = 'satuan';
$f4 = 'harga';
$f5 = 'kd_subgrup';
$f6 = 'kd_grup';
$f7 = 'photo';
$f8 = 'rating';
$f9 = 'Quantity';
$f10 = 'Pcs';
$f11 = 'Renteng';
$f12 = 'Pak';
$f13 = 'ikat';
$f14 = 'Ball';
$f15 = 'Box';
$f16 = 'Dus';
$f17 = 'hrg_pcs';
$f18 = 'hrg_renteng';
$f19 = 'hrg_pak';
$f20 = 'hrg_ikat';
$f21 = 'hrg_ball';
$f22 = 'hrg_box';
$f23 = 'hrg_dus';
$f24 = 'disc_pcs';
$f25 = 'disc_renteng';
$f26 = 'disc_pak';
$f27 = 'disc_ikat';
$f28 = 'disc_ball';
$f29 = 'disc_box';
$f30 = 'disc_dus';
$f31 = 'id_kategori';


$j1 = 'Kode Barang';
$j2 = 'Nama';
$j3 = 'Satuan';
$j4 = 'Harga';
$j5 = 'kd_subgrup';
$j6 = 'kd_grup';
$j7 = 'photo';
$j8 = 'rating';
$j9 = 'Quantity';
$j10 = 'Pcs';
$j11 = 'Renteng';
$j12 = 'Pak';
$j13 = 'Ikat';
$j14 = 'Ball';
$j15 = 'Box';
$j16 = 'Dus';
$j17 = 'Harga Pcs';
$j18 = 'Harga Renteng';
$j19 = 'Harga Pak';
$j20 = 'Harga Ikat';
$j21 = 'Harga Ball';
$j22 = 'Harga Box';
$j23 = 'Harga Dus';
$j24 = 'Disc Pcs';
$j25 = 'Disc Renteng';
$j26 = 'Disc Pak';
$j27 = 'Disc Ikat';
$j28 = 'Disc Ball';
$j29 = 'Disc Box';
$j30 = 'Disc Dus';
$j31 = 'ID Kategori';

$data2 = 'import_barang';

//session_start();
if (empty($_SESSION['username']) and empty($_SESSION['passuser'])) {
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
  <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
} else {

  switch ($_GET['act']) {
      //Tampil Data 
    default:
?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper" style="background-color: ghostwhite;">
        <!-- Content Header (Page header) -->
        <section class="content-header  wow fadeInDown" data-wow-duration=".3s" data-wow-delay=".3s">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="list-gds">
                  <b><?php echo $judulform; ?></b> <small style="font-weight: 100;"></small>
                </h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="main.php?route=home">Beranda</a></li>
                  <li class="breadcrumb-item active">Data</li>
                  <li class="breadcrumb-item active"><?php echo $judulform; ?></li>
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content wow fadeInUp" data-wow-duration=".2s" data-wow-delay=".1s">
          <div class="container-fluid">
            <div class="card card-default">
              <!-- /.card-header -->
              <div class="card-body">
                <!-- Main row -->
                <div class="row">
                  <!-- Left col -->
                  <section class="col-lg-12 connectedSortable">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="box">
                      <div class="box-body">
                        <div class="table-responsive">

                          <!-- <button class="btn btn-primary btn-sm elevation-2 " style="opacity: .7;" onclick="window.location='route/<?php echo $data; ?>/index.php'"><i class="fa fa-plus";></i> Tambah</button> -->
                          <div class="d-flex justify-content-between">
                            <!-- Tombol di kiri -->
                            <div>
                              <button class="btn btn-primary btn-sm elevation-2" style="opacity: .7;" onclick="window.location='main.php?route=barang_tambah'">
                                <i class="fa fa-plus"></i> Tambah
                              </button>
                              <button class="btn btn-success btn-sm elevation-2" style="opacity: .7;" onclick="window.location='../../data/pages/main.php?route=<?php echo $data2; ?>'">
                                <i class="fa-solid fa-file-excel"></i> Import
                              </button>
                            </div>

                            <!-- Tombol di kanan -->
                            <div>
                              <button class="btn btn-info btn-sm elevation-2" style="opacity: .7;" data-toggle="modal" data-target="#searchModal">
                                <i class="fa fa-search"></i> Cari
                              </button>
                              <a href="main.php?route=<?php echo $rute; ?>&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=<?php echo $rute; ?>">
                                <button type="button" class="btn btn-secondary btn-sm elevation-2" style="opacity: .7">
                                  <i class="fa fa-sync-alt"></i> Refresh
                                </button>
                              </a>
                            </div>
                          </div>

                          <!-- Modal Section -->
                          <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="searchModalLabel">Cari Barang</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <!-- Form Search -->
                                  <form id="searchForm" method="GET">
                                    <input type="hidden" name="route" value="<?php echo $rute; ?>">
                                    <input type="hidden" name="act" value="search">
                                    <div class="form-group">
                                      <label for="kodeBarang">Kode Barang</label>
                                      <input type="text" class="form-control" id="kodeBarang" name="kode_barang" placeholder="Masukkan kode barang">
                                    </div>
                                    <div class="form-group">
                                      <label for="namaBarang">Nama Barang</label>
                                      <input type="text" class="form-control" id="namaBarang" name="nama_barang" placeholder="Masukkan nama barang">
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                      <button type="submit" class="btn btn-primary">Cari</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>


                          <div style="margin:10px"></div>

                          <?php
                          // Mendapatkan parameter pencarian
                          $kode_barang = $_GET['kode_barang'] ?? '';
                          $nama_barang = $_GET['nama_barang'] ?? '';

                          // Membangun query SQL berdasarkan parameter pencarian
                          $sql1 = "SELECT * FROM $tabel WHERE 1=1 ";

                          if (!empty($kode_barang)) {
                            $sql1 .= " AND kd_brg LIKE '%$kode_barang%'";
                          }

                          if (!empty($nama_barang)) {
                            $sql1 .= " AND nama LIKE '%$nama_barang%'";
                          }

                          $limit = 1000; // Ubah angka 10 dengan jumlah limit yang diinginkan
                          $sql1 .= " ORDER BY $f1 ASC LIMIT $limit";

                          $result = mysqli_query($koneksi, $sql1);

                          if (!$result) {
                            die("Query error: " . $koneksi->error);
                          }
                          ?>

                          <table id="example1" class="table table-bordered table-striped">
                            <thead style="background-color: lightgray;" class="elevation-2">
                              <tr>
                                <th>No.</th>
                                <th><?php echo $j1; ?></th>
                                <th><?php echo $j2; ?></th>
                                <th><?php echo $j3; ?></th>
                                <th><?php echo $j9; ?></th>
                                <th><?php echo $j10; ?></th>
                                <th><?php echo $j11; ?></th>
                                <th><?php echo $j12; ?></th>
                                <th><?php echo $j13; ?></th>
                                <th><?php echo $j14; ?></th>
                                <th><?php echo $j15; ?></th>
                                <th><?php echo $j16; ?></th>
                                <th><?php echo $j17; ?></th>
                                <th><?php echo $j18; ?></th>
                                <th><?php echo $j19; ?></th>
                                <th><?php echo $j20; ?></th>
                                <th><?php echo $j21; ?></th>
                                <th><?php echo $j22; ?></th>
                                <th><?php echo $j23; ?></th>
                                <!-- <th><?php echo $j24; ?></th>
                                <th><?php echo $j25; ?></th>
                                <th><?php echo $j26; ?></th> -->
                                <th>ID Kategori</th>
                                <th>Photo</th>
                                <th width="60px">Aksi</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $no = 1;
                              while ($s1 = mysqli_fetch_array($result)) {
                                $datagambar = $s1[$f7] == "" ? "images.jpeg" : $s1[$f8];
                              ?>
                                <tr align="left">
                                  <td><?php echo $no; ?></td>
                                  <td><?php echo $s1[$f1]; ?></td>
                                  <td><?php echo $s1[$f2]; ?></td>
                                  <td><?php echo $s1[$f3]; ?></td>
                                  <td><?php echo $s1[$f9]; ?></td>
                                  <td><?php echo $s1[$f10]; ?></td>
                                  <td><?php echo $s1[$f11]; ?></td>
                                  <td><?php echo $s1[$f12]; ?></td>
                                  <td><?php echo $s1[$f13]; ?></td>
                                  <td><?php echo $s1[$f14]; ?></td>
                                  <td><?php echo $s1[$f15]; ?></td>
                                  <td style="text-align: right;"><?php echo format_rupiah($s1[$f16]); ?></td>
                                  <td style="text-align: right;"><?php echo format_rupiah($s1[$f17]); ?></td>
                                  <td style="text-align: right;"><?php echo format_rupiah($s1[$f18]); ?></td>
                                  <td style="text-align: right;"><?php echo format_rupiah($s1[$f19]); ?></td>
                                  <td style="text-align: right;"><?php echo format_rupiah($s1[$f20]); ?></td>
                                  <td style="text-align: right;"><?php echo format_rupiah($s1[$f21]); ?></td>
                                  <td style="text-align: right;"><?php echo format_rupiah($s1[$f22]); ?></td>
                                  <td style="text-align: right;"><?php echo format_rupiah($s1[$f23]); ?></td>
                                  <!-- <td style="text-align: right;"><?php echo format_rupiah($s1[$f24]); ?></td>
                                  <td style="text-align: right;"><?php echo format_rupiah($s1[$f25]); ?></td>
                                  <td style="text-align: right;"><?php echo format_rupiah($s1[$f26]); ?></td> -->
                                  <td><?php echo $s1[$f31]; ?></td>
                                  <td style="text-align: center;"><img src="../../images/menu/<?php echo $datagambar; ?>" class="brand-image elevation-3" style="opacity: 1;width: 60px;"></td>
                                  <td>
                                    <div style="margin: 10px"></div>
                                    <a href="main.php?route=<?php echo $rute; ?>&act=edit&id=<?php echo $s1[$f1]; ?>" title="Edit"><button class="btn btn-primary btn-sm elevation-2" style="opacity: .7;width:80px"><i class="fa fa-edit"></i> Edit</button></a>
                                    <br />
                                    <a href="route/<?php echo $data; ?>/<?php echo $aksi; ?>.php?route=<?php echo $rute; ?>&act=hapus&id=<?php echo $s1[$f1]; ?>" title="Hapus" onclick="return confirm('Apakah anda yakin ingin menghapus ini ?')">
                                      <button class="btn btn-danger btn-sm elevation-2" style="opacity: .7;width:80px"><i class="fa fa-trash"></i> Hapus</button></a>
                                  </td>
                                </tr>
                              <?php
                                $no++;
                              }
                              ?>
                            </tbody>
                          </table>

                        </div>
                      </div><!-- /.box-body -->
                    </div><!-- /.box -->
                  </section><!-- /.Left col -->
                </div><!-- /.row (main row) -->
              </div>
            </div>
          </div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

    <?php
      break;

      //Form Tambah area
    case "tambah":

    ?>


      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="list-gds wow slideInUp" data-wow-duration=".5s" data-wow-delay="1.1s">
                  <b><?php echo $judulform; ?> <small style="font-weight: 100;">tambah</small></b>
                </h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="main.php?route=home">Beranda</a></li>
                  <li class="breadcrumb-item active">Data</li>
                  <li class="breadcrumb-item active"><?php echo $judulform; ?></li>
                  <li class="breadcrumb-item active">tambah</li>
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="card card-default">
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <!-- right column -->
                  <div class="col-md-12">
                    <!-- general form elements disabled -->
                    <div class="box box-warning">
                      <div class="box-body">
                        <form method="POST" action="route/data_alat_bayar/aksi_alat_bayar.php?route=alat_bayar&act=input" enctype="multipart/form-data">

                          <!-- <form method="post" enctype="multipart/form-data" action="<?php echo $aksi; ?>.php?route=<?php echo $rute; ?>&act=input"> -->

                          <div class="form-group">
                            <label><?php echo $j1; ?></label>
                            <input type="text" onkeyup="isi_otomatis()" name="<?php echo $f1; ?>" id="<?php echo $f1; ?>" required="required" class="form-control" style="width: 100px;" />
                            <input type="text" id="<?php echo $f2; ?>" class="form-control" style="width: 300px;" disabled />
                            <input type="text" id="nama" class="form-control" style="width: 300px;" />

                          </div>

                          <div class="form-group">
                            <label><?php echo $j2; ?></label>
                            <input type="text" name="<?php echo $f2; ?>" class="form-control" placeholder="Masukan <?php echo $j2; ?> ..." required="required" />
                          </div>

                          <div class="form-group">
                            <label><?php echo $j4; ?></label>
                            <select name="<?php echo $f4; ?>" class="form-control" style="width:200px;height: 40px;">
                              <option value="Non Tunai">Non Tunai</option>
                              <option value="Tunai">Tunaii</option>
                            </select>
                          </div>

                          <div class="form-group">
                            <label><?php echo $j5; ?></label>
                            <select name="<?php echo $f5; ?>" class="form-control" style="width:200px;height: 40px;">
                              <option></option>
                              <?php

                              $produk = mysqli_query($koneksi, "SELECT * from jenis_transaksi order by kd_jenis asc");
                              while ($pro = mysqli_fetch_array($produk)) {
                                echo "<option value='$pro[kd_jenis]'>$pro[kd_jenis] - $pro[nama]</option>";
                              }
                              ?>
                            </select>
                          </div>

                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <div id="msg"></div>
                                <input type="file" name="photo" class="file">
                                <div class="input-group my-3">
                                  <input type="text" class="form-control" disabled placeholder="Upload Gambar" id="file">
                                  <div class="input-group-append">
                                    <button type="button" id="pilih_gambar" class="browse btn btn-dark">Pilih Gambar</button>
                                  </div>
                                </div>

                                <img src="route/data_alat_bayar/gambar/images.jpeg" id="preview" class="img-thumbnail">
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <hr />
                            <input type="submit" class="btn btn-primary" value="Simpan" />
                          </div>

                        </form>
                      </div><!-- /.box-body -->
                    </div><!-- /.box -->
                  </div><!--/.col (right) -->
                </div> <!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->


      <style>
        .file {
          visibility: hidden;
          position: absolute;
        }
      </style>
      <script>
        // Fungsi untuk mereset form saat halaman di-refresh
        document.addEventListener('DOMContentLoaded', function() {
          document.getElementById('searchForm').reset();
        });

        // Fungsi untuk menangani pengiriman form dan menampilkan hasil pencarian
        document.getElementById('searchForm').addEventListener('submit', function(event) {
          event.preventDefault(); // Mencegah pengiriman formulir secara default

          var formData = new FormData(this);

          fetch('route/<?php echo $data; ?>/<?php echo $aksi; ?>.php?route=<?php echo $rute; ?>&act=search', {
              method: 'GET',
              body: formData
            })
            .then(response => response.text())
            .then(data => {
              document.getElementById('searchResultsBody').innerHTML = data;
              var myModal = new bootstrap.Modal(document.getElementById('searchResultsModal'));
              myModal.show();
            })
            .catch(error => console.error('Error:', error));
        });
      </script>


      <script>
        function isi_otomatis() {
          var <?php echo $f1; ?> = $("#<?php echo $f1; ?>").val();
          $.ajax({
            url: 'route/data_alat_bayar/ajax.php',
            data: "<?php echo $f1; ?>=" + <?php echo $f1; ?>,
          }).success(function(data) {
            var json = data,
              obj = JSON.parse(json);
            $('#<?php echo $f2; ?>').val(obj.<?php echo $f2; ?>);

          });
        }
      </script>

      <script>
        function konfirmasi() {
          konfirmasi = confirm("Apakah anda yakin ingin menghapus gambar ini?")
          document.writeln(konfirmasi)
        }

        $(document).on("click", "#pilih_gambar", function() {
          var file = $(this).parents().find(".file");
          file.trigger("click");
        });

        $('input[type="file"]').change(function(e) {
          var fileName = e.target.files[0].name;
          $("#file").val(fileName);

          var reader = new FileReader();
          reader.onload = function(e) {
            // get loaded data and render thumbnail.
            document.getElementById("preview").src = e.target.result;
          };
          // read the image file as a data URL.
          reader.readAsDataURL(this.files[0]);
        });
      </script>



      <!-- Page script -->
      <script type="text/javascript">
        $(function() {
          //Datemask dd/mm/yyyy
          $("#datemask").inputmask("dd/mm/yyyy", {
            "placeholder": "dd/mm/yyyy"
          });
          //Datemask2 mm/dd/yyyy
          $("#datemask2").inputmask("mm/dd/yyyy", {
            "placeholder": "mm/dd/yyyy"
          });
          //Money Euro
          $("[data-mask]").inputmask();

          //Date range picker
          $('#reservation').daterangepicker();
          //Date range picker with time picker
          $('#reservationtime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            format: 'MM/DD/YYYY h:mm A'
          });
          //Date range as a button
          $('#daterange-btn').daterangepicker({
              ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                'Last 7 Days': [moment().subtract('days', 6), moment()],
                'Last 30 Days': [moment().subtract('days', 29), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
              },
              startDate: moment().subtract('days', 29),
              endDate: moment()
            },
            function(start, end) {
              $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }
          );

          //iCheck for checkbox and radio inputs
          $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
          });
          //Red color scheme for iCheck
          $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass: 'iradio_minimal-red'
          });
          //Flat red color scheme for iCheck
          $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
          });

          //Colorpicker
          $(".my-colorpicker1").colorpicker();
          //color picker with addon
          $(".my-colorpicker2").colorpicker();

          //Timepicker
          $(".timepicker").timepicker({
            showInputs: false
          });
        });
      </script>

      <script>
        $(function() {
          var dt = '';
          $('#d1').datepicker();


          $('#d2').datepicker({
            changeMonth: true,
            dateFormat: 'yy-mm-dd',
            changeYear: true,
          });

          $('#d3').datepicker({
            changeMonth: true,
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            onClose: function(date) {
              dt = date;
              $("#d4").datepicker("destroy");
              showdate();

            }
          });

          $('#d5').datepicker({
            changeYear: true,
          });

          $("#d6").datepicker();
          $("#hFormat").change(function() {
            $("#d6").datepicker("option", "dateFormat", $(this).val());
          });



          function showdate() {
            $('#d4').datepicker({
              changeMonth: true,
              dateFormat: 'yy-mm-dd',
              changeYear: true,
              minDate: new Date(dt),
              hideIfNoPrevNext: true
            });
          }

        });
      </script>
    <?php
      break;

      //Form Edit
    case "edit":
      $edit = mysqli_query($koneksi, "SELECT * from $tabel where $f1='$_GET[id]'");
      $e = mysqli_fetch_array($edit);

      // $sql=mysqli_query($koneksi,"SELECT * from $tabel2 where $ff1='$e[$f5]'");
      // $s1=mysqli_fetch_array($sql);

    ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper" style="background-color: ghostwhite;">
        <!-- Content Header (Page header) -->
        <section class="content-header  wow fadeInDown" data-wow-duration=".3s" data-wow-delay=".3s">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="list-gds">
                  <b><?php echo $judulform; ?></b> <small style="font-weight: 100;">edit</small>
                </h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="main.php?route=home">Beranda</a></li>
                  <li class="breadcrumb-item active">Data</li>
                  <li class="breadcrumb-item active"><?php echo $judulform; ?></li>
                  <li class="breadcrumb-item active">edit</li>
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content wow fadeInUp" data-wow-duration=".2s" data-wow-delay=".1s">
          <div class="container-fluid">
            <div class="card card-default">
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <!-- right column -->
                  <div class="col-md-12">
                    <!-- general form elements disabled -->
                    <div class="box box-warning">
                      <div class="box-body">

                        <form method="POST" action="route/<?php echo $data; ?>/<?php echo $aksi; ?>.php?route=<?php echo $rute; ?>&act=edit&id=<?php echo $e['kd_brg']; ?>" enctype="multipart/form-data">
                          <section>
                            <div class="box">
                              <div class="box-body">
                                <div class="wrapper">
                                  <div class="row">
                                    <!-- Kolom Pertama -->
                                    <div class="col-md-3">
                                      <div class="form-group">
                                        <label><?php echo $j1; ?></label>
                                        <input type="text" name="<?php echo $f1; ?>" class="form-control" value="<?php echo $e[$f1]; ?>" readonly />
                                      </div>
                                    </div>

                                    <div class="col-md-3">
                                      <div class="form-group">
                                        <label><?php echo $j2; ?></label>
                                        <input type="text" name="<?php echo $f2; ?>" class="form-control" value="<?php echo $e[$f2]; ?>" required="required" />
                                      </div>
                                    </div>

                                    <div class="col-md-3">
                                      <div class="form-group">
                                        <label><?php echo $j3; ?></label>
                                        <input type="text" name="<?php echo $f3; ?>" class="form-control" value="<?php echo $e[$f3]; ?>" required="required" />
                                      </div>
                                    </div>
                                    <!-- Kolom Kedua -->
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label><?php echo $j4; ?></label>
                                        <input type="text" name="<?php echo $f4; ?>" class="form-control" value="<?php echo $e[$f4]; ?>" required="required" />
                                      </div>
                                    </div>

                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label><?php echo $j9; ?></label>
                                        <input type="text" name="<?php echo $f9; ?>" class="form-control" value="<?php echo $e[$f9]; ?>" />
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <div class="form-group">
                                        <label><?php echo $j10; ?></label>
                                        <input type="text" name="<?php echo $f10; ?>" class="form-control" value="<?php echo $e[$f10]; ?>" />
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <div class="form-group">
                                        <label><?php echo $j17; ?></label>
                                        <input type="text" name="<?php echo $f17; ?>" class="form-control" value="<?php echo $e[$f17]; ?>" />
                                      </div>
                                    </div>
                                    <!-- <div class="col-md-4">
                                      <div class="form-group">
                                        <label><?php echo $j24; ?></label>
                                        <input type="text" name="<?php echo $f24; ?>" class="form-control" value="<?php echo $e[$f24]; ?>" />
                                      </div>
                                    </div> -->
                                    <div class="col-md-3">
                                      <div class="form-group">
                                        <label><?php echo $j11; ?></label>
                                        <input type="text" name="<?php echo $f11; ?>" class="form-control" value="<?php echo $e[$f11]; ?>" />
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <div class="form-group">
                                        <label><?php echo $j18; ?></label>
                                        <input type="text" name="<?php echo $f18; ?>" class="form-control" value="<?php echo $e[$f18]; ?>" />
                                      </div>
                                    </div>
                                    <!-- <div class="col-md-4">
                                      <div class="form-group">
                                        <label><?php echo $j25; ?></label>
                                        <input type="text" name="<?php echo $f25; ?>" class="form-control" value="<?php echo $e[$f18]; ?>" />
                                      </div>
                                    </div> -->
                                    <div class="col-md-3">
                                      <div class="form-group">
                                        <label><?php echo $j12; ?></label>
                                        <input type="text" name="<?php echo $f12; ?>" class="form-control" value="<?php echo $e[$f12]; ?>" />
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <div class="form-group">
                                        <label><?php echo $j19; ?></label>
                                        <input type="text" name="<?php echo $f19; ?>" class="form-control" value="<?php echo $e[$f19]; ?>" />
                                      </div>
                                    </div>
                                    <!-- <div class="col-md-4">
                                      <div class="form-group">
                                        <label><?php echo $j26; ?></label>
                                        <input type="text" name="<?php echo $f26; ?>" class="form-control" value="<?php echo $e[$f26]; ?>" />
                                      </div>
                                    </div> -->
                                    <div class="col-md-3">
                                      <div class="form-group">
                                        <label><?php echo $j13; ?></label>
                                        <input type="text" name="<?php echo $f13; ?>" class="form-control" value="<?php echo $e[$f13]; ?>" />
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <div class="form-group">
                                        <label><?php echo $j20; ?></label>
                                        <input type="text" name="<?php echo $f20; ?>" class="form-control" value="<?php echo $e[$f20]; ?>" />
                                      </div>
                                    </div>
                                    <!-- <div class="col-md-4">
                                      <div class="form-group">
                                        <label><?php echo $j27; ?></label>
                                        <input type="text" name="<?php echo $f27; ?>" class="form-control" value="<?php echo $e[$f27]; ?>" />
                                      </div>
                                    </div> -->
                                    <div class="col-md-3">
                                      <div class="form-group">
                                        <label><?php echo $j14; ?></label>
                                        <input type="text" name="<?php echo $f14; ?>" class="form-control" value="<?php echo $e[$f14]; ?>" />
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <div class="form-group">
                                        <label><?php echo $j21; ?></label>
                                        <input type="text" name="<?php echo $f21; ?>" class="form-control" value="<?php echo $e[$f21]; ?>" />
                                      </div>
                                    </div>
                                    <!-- <div class="col-md-4">
                                      <div class="form-group">
                                        <label><?php echo $j28; ?></label>
                                        <input type="text" name="<?php echo $f28; ?>" class="form-control" value="<?php echo $e[$f28]; ?>" />
                                      </div>
                                    </div> -->
                                    <div class="col-md-3">
                                      <div class="form-group">
                                        <label><?php echo $j15; ?></label>
                                        <input type="text" name="<?php echo $f15; ?>" class="form-control" value="<?php echo $e[$f15]; ?>" />
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <div class="form-group">
                                        <label><?php echo $j22; ?></label>
                                        <input type="text" name="<?php echo $f22; ?>" class="form-control" value="<?php echo $e[$f22]; ?>" />
                                      </div>
                                    </div>
                                    <!-- <div class="col-md-4">
                                      <div class="form-group">
                                        <label><?php echo $j29; ?></label>
                                        <input type="text" name="<?php echo $f29; ?>" class="form-control" value="<?php echo $e[$f29]; ?>" />
                                      </div>
                                    </div> -->
                                    <div class="col-md-3">
                                      <div class="form-group">
                                        <label><?php echo $j16; ?></label>
                                        <input type="text" name="<?php echo $f16; ?>" class="form-control" value="<?php echo $e[$f16]; ?>" />
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <div class="form-group">
                                        <label><?php echo $j23; ?></label>
                                        <input type="text" name="<?php echo $f23; ?>" class="form-control" value="<?php echo $e[$f23]; ?>" />
                                      </div>
                                    </div>
                                    <!-- <div class="col-md-4">
                                      <div class="form-group">
                                        <label><?php echo $j30; ?></label>
                                        <input type="text" name="<?php echo $f30; ?>" class="form-control" value="<?php echo $e[$f30]; ?>" />
                                      </div>
                                    </div> -->
                                    <div class="col-md-3">
                                      <div class="form-group">
                                        <label>ID Kategori</label>
                                        <select name="id_kategori" class="form-control select2">
                                          <option value="<?php echo $e[$f31]; ?>"><?php echo $e[$f31]; ?></option>
                                          <?php

                                          $query = mysqli_query($koneksi, "SELECT * from kategori order by id_kat asc");
                                          while ($x = mysqli_fetch_array($query)) {
                                            echo "<option value='$x[id_kat]'>$x[id_kat]</option>";
                                          }
                                          ?>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-lg-7">
                                    <div class="row">
                                      <div class="col-sm-6">
                                        <div class="form-group">
                                          <div id="msg"></div>
                                          <input type="file" name="photo" class="file">
                                          <div class="input-group my-3">
                                            <input type="text" class="form-control" disabled placeholder="Upload Gambar (max 100kb)" id="file">
                                          </div>

                                          <img src="../../images/images.jpeg" id="preview" class="img-thumbnail elevation-3" style="width:200px">
                                        </div>
                                        <div class="input-group-append">
                                          <button type="button" id="pilih_gambar" class="browse btn btn-dark elevation-3">Pilih Gambar</button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <hr>
                                <input type="submit" class="btn btn-primary btn-sm elevation-2" style="opacity: .7" value="Simpan" />
                                <a href="main.php?route=<?php echo $rute; ?>&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=<?php echo $rute; ?>">
                                  <button type="button" class="btn btn-primary btn-sm elevation-2" style="opacity: .7">Back</button>
                                </a>
                              </div>
                            </div>
                          </section>
                        </form>
                      </div><!-- /.box-body -->
                    </div><!-- /.box -->
                  </div><!--/.col (right) -->
                </div> <!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <style>
        .file {
          visibility: hidden;
          position: absolute;
        }
      </style>

      <script>
        function konfirmasi() {
          konfirmasi = confirm("Apakah anda yakin ingin menghapus gambar ini?")
          document.writeln(konfirmasi)
        }

        $(document).on("click", "#pilih_gambar", function() {
          var file = $(this).parents().find(".file");
          file.trigger("click");
        });

        $('input[type="file"]').change(function(e) {
          var fileName = e.target.files[0].name;
          $("#file").val(fileName);

          var reader = new FileReader();
          reader.onload = function(e) {
            // get loaded data and render thumbnail.
            document.getElementById("preview").src = e.target.result;
          };
          // read the image file as a data URL.
          reader.readAsDataURL(this.files[0]);
        });
      </script>

      <!-- Page script -->
      <script type="text/javascript">
        $(function() {
          //Datemask dd/mm/yyyy
          $("#datemask").inputmask("dd/mm/yyyy", {
            "placeholder": "dd/mm/yyyy"
          });
          //Datemask2 mm/dd/yyyy
          $("#datemask2").inputmask("mm/dd/yyyy", {
            "placeholder": "mm/dd/yyyy"
          });
          //Money Euro
          $("[data-mask]").inputmask();

          //Date range picker
          $('#reservation').daterangepicker();
          //Date range picker with time picker
          $('#reservationtime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            format: 'MM/DD/YYYY h:mm A'
          });
          //Date range as a button
          $('#daterange-btn').daterangepicker({
              ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                'Last 7 Days': [moment().subtract('days', 6), moment()],
                'Last 30 Days': [moment().subtract('days', 29), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
              },
              startDate: moment().subtract('days', 29),
              endDate: moment()
            },
            function(start, end) {
              $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }
          );

          //iCheck for checkbox and radio inputs
          $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
          });
          //Red color scheme for iCheck
          $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass: 'iradio_minimal-red'
          });
          //Flat red color scheme for iCheck
          $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
          });

          //Colorpicker
          $(".my-colorpicker1").colorpicker();
          //color picker with addon
          $(".my-colorpicker2").colorpicker();

          //Timepicker
          $(".timepicker").timepicker({
            showInputs: false
          });
        });
      </script>

      <script>
        $(function() {
          var dt = '';
          $('#d1').datepicker();


          $('#d2').datepicker({
            changeMonth: true,
            dateFormat: 'yy-mm-dd',
            changeYear: true,
          });

          $('#d3').datepicker({
            changeMonth: true,
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            onClose: function(date) {
              dt = date;
              $("#d4").datepicker("destroy");
              showdate();

            }
          });

          $('#d5').datepicker({
            changeYear: true,
          });

          $("#d6").datepicker();
          $("#hFormat").change(function() {
            $("#d6").datepicker("option", "dateFormat", $(this).val());
          });



          function showdate() {
            $('#d4').datepicker({
              changeMonth: true,
              dateFormat: 'yy-mm-dd',
              changeYear: true,
              minDate: new Date(dt),
              hideIfNoPrevNext: true
            });
          }

        });
      </script>
<?php
      break;
  }
}
?>