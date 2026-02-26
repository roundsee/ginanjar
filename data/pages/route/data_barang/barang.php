<?php

$judulform = "Daftar Barang";

$data = 'data_barang';
$rute = 'barang';
$aksi = 'aksi_barang';

$tabel = 'barang';

$f1 = 'kd_brg';
$f2 = 'nama';
$f3 = 'harga';
$f_31 = 'hrg_satuan1';
$f_32 = 'hrg_satuan2';
$f_33 = 'hrg_satuan3';
$f_34 = 'hrg_satuan4';
$f_35 = 'hrg_satuan5';
$f4 = 'satuan';
$f_41 = 'Satuan1';
$f_42 = 'Satuan2';
$f_43 = 'Satuan3';
$f_44 = 'Satuan4';
$f_45 = 'Satuan5';
$f5 = 'kd_subgrup';
$f6 = 'kd_grup';
$f7 = 'photo';
$f8 = 'rating';
$f9 = 'Quantity';
$f_91 = 'qty_satuan1';
$f_92 = 'qty_satuan2';
$f_93 = 'qty_satuan3';
$f_94 = 'qty_satuan4';
$f_95 = 'qty_satuan5';
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
$f31 = 'ktg_retail';
$f32 = 'ktg_grosir';
$f33 = 'ktg_online';
$f34 = 'ktg_ms';
$f35 = 'ktg_mg';
$f36 = 'ktg_mp';
$f37 = 'ktg_buffer';




$j1 = 'Kode Barang';
$j2 = 'Nama';
$j3 = 'Harga';
$j4 = 'Satuan';
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
$j31 = 'ID kategori Retali';
$j32 = 'ID Kategori Grosir';
$j33 = 'ID Kategori Online';
$j34 = 'ID Kategori Member Silver';
$j35 = 'ID Kategori Member Gold';
$j36 = 'ID Kategori Member Platinum';
$j37 = 'ID Kategori Buffer';
$j38 = 'Jumlah Stock';


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
      <style>
        #loadingSpinner {
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          background: rgba(255, 255, 255, 0.8);
          display: flex;
          justify-content: center;
          align-items: center;
          z-index: 9999;
        }

        .spinner {
          border: 8px solid rgba(255, 255, 255, 0.3);
          border-top: 8px solid #3498db;
          border-radius: 50%;
          width: 60px;
          height: 60px;
          animation: spin 1.5s linear infinite;
        }

        @keyframes spin {
          0% {
            transform: rotate(0deg);
          }

          100% {
            transform: rotate(360deg);
          }
        }
      </style>
      <div id="loadingSpinner" style="display:none;">
        <div class="spinner"></div>
      </div>
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
                        <?php $sql123 = mysqli_query($koneksi, " SELECT COUNT(*) AS jumlah_data from $tabel");
                        while ($s123 = mysqli_fetch_array($sql123)) {
                        ?>
                          <p>Jumlah data sebanyak : <?php echo $s123["jumlah_data"]; ?></p>
                        <?php } ?>
                        <div class="table-responsive">

                          <!-- <button class="btn btn-primary btn-sm elevation-2 " style="opacity: .7;" onclick="window.location='route/<?php echo $data; ?>/index.php'"><i class="fa fa-plus";></i> Tambah</button> -->
                          <!--button sebelum tambah cari
                           <button class="btn btn-primary btn-sm elevation-2 " style="opacity: .7;" onclick="window.location='main.php?route=barang_tambah'"><i class="fa fa-plus" ;></i> Tambah</button>
                          <button class="btn btn-success btn-sm elevation-2 " style="opacity: .7;" onclick="window.location='../../data/pages/main.php?route=<?php echo $data2; ?>'"> <i class="fa-solid fa-file-excel"></i> Import</button> -->

                          <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                              <button class="btn btn-primary btn-sm elevation-2" style="opacity: .7; margin-right: 10px;"
                                onclick="window.location='main.php?route=barang_tambah'">
                                <i class="fa fa-plus"></i> Tambah
                              </button>
                              <button class="btn btn-success btn-sm elevation-2" style="opacity: .7;"
                                onclick="window.location='../../data/pages/main.php?route=<?php echo $data2; ?>'">
                                <i class="fa-solid fa-file-excel"></i> Import
                              </button>
                              <button class="btn btn-secondary btn-sm elevation-2" style="opacity: .7; margin-left: 10px;" id="barangtoExcel" type="button">
                                <i class="fa fa-print"></i> Export semua barang
                              </button>
                            </div>
                            <div class="d-flex align-items-center">
                              <label for="cariBarangManual" class="form-label mb-1" style="font-weight: bold; font-size: 15px;">Cari Barang:<span style="margin-left: 5px;"></span></label>
                              <input type="text" name="cariBarangManual" class="form-control" id="cariBarangManual" style="width: auto; height: 30px; padding: 5px; border: 1px solid #ced4da; border-radius: 4px; margin-top: 5px;" placeholder="Masukkan nama barang..." />

                            </div>
                          </div>

                          <!--<a href="route/<?php echo $data; ?>/<?php echo $aksi; ?>.php?route=<?php echo $rute; ?>&act=tes">
                            <button class="btn btn-primary btn-sm elevation-2 float-right" style="opacity: .7;"><i class="fa-solid fa-gear""></i>  Generate Harga</button></a>
                            -->
                          <div style=" margin:10px">
                          </div>

                          <table id="example4" class="table table-bordered table-striped">
                            <thead style="background-color:  lightgray;" class="elevation-2">
                              <tr>
                                <th>No.</th>
                                <th><?php echo $j1; ?></th>
                                <th><?php echo $j2; ?></th>
                                <th><?php echo $j3; ?></th>
                                <th><?php echo $j4; ?> 1</th>
                                <th><?php echo $j4; ?> 2</th>
                                <th><?php echo $j4; ?> 3</th>
                                <th><?php echo $j4; ?> 4</th>
                                <th><?php echo $j4; ?> 5</th>
                                <th><?php echo $j9; ?> 1</th>
                                <th><?php echo $j9; ?> 2</th>
                                <th><?php echo $j9; ?> 3</th>
                                <th><?php echo $j9; ?> 4</th>
                                <th><?php echo $j9; ?> 5</th>
                                <th><?php echo $j3; ?> 1</th>
                                <th><?php echo $j3; ?> 2</th>
                                <th><?php echo $j3; ?> 3</th>
                                <th><?php echo $j3; ?> 4</th>
                                <th><?php echo $j3; ?> 5</th>
                                <th><?php echo $j31; ?></th>
                                <th><?php echo $j32; ?></th>
                                <th><?php echo $j33; ?></th>
                                <th><?php echo $j34; ?></th>
                                <th><?php echo $j35; ?></th>
                                <th><?php echo $j36; ?></th>
                                <th><?php echo $j37; ?></th>
                                <th><?php echo $j38; ?></th>




                                <th>Photo</th>
                                <th width="60px">Aksi</th>
                              </tr>
                            </thead>
                            <tbody id="barangTableBodysearch">
                              <?php

                              $sql1 = mysqli_query($koneksi, "SELECT * from $tabel  order by $f1 asc LIMIT 100");

                              // $query="SELECT a.$f1,a.$f2,a.$f3,a.$f4,a.$f5,j.nama as nama_aplikasi
                              // from $tabel a
                              // join $tabel2 j on a.$f5=j.$ff1
                              // order by a.$f1 asc";

                              // $sql1=mysqli_query($koneksi,$query);
                              $no = 1;
                              while ($s1 = mysqli_fetch_array($sql1)) {
                                if ($s1[$f7] == "") {
                                  $datagambar = "images.jpeg";
                                } else {
                                  $datagambar = $s1[$f8];
                                }

                              ?>
                                <tr align="left">
                                  <td><?php echo $no; ?></td>
                                  <td><?php echo $s1[$f1]; ?></td>
                                  <td><?php echo $s1[$f2]; ?></td>
                                  <td><?php echo format_rupiah($s1[$f3]); ?></td>
                                  <td><?php echo $s1[$f_41]; ?></td>
                                  <td><?php echo $s1[$f_42]; ?></td>
                                  <td><?php echo $s1[$f_43]; ?></td>
                                  <td><?php echo $s1[$f_44]; ?></td>
                                  <td><?php echo $s1[$f_45]; ?></td>
                                  <td><?php echo $s1[$f_91]; ?></td>
                                  <td><?php echo $s1[$f_92]; ?></td>
                                  <td><?php echo $s1[$f_93]; ?></td>
                                  <td><?php echo $s1[$f_94]; ?></td>
                                  <td><?php echo $s1[$f_95]; ?></td>
                                  <td style="text-align: right;"><?php echo format_rupiah($s1[$f_31]); ?></td>
                                  <td style="text-align: right;"><?php echo format_rupiah($s1[$f_32]); ?></td>
                                  <td style="text-align: right;"><?php echo format_rupiah($s1[$f_33]); ?></td>
                                  <td style="text-align: right;"><?php echo format_rupiah($s1[$f_34]); ?></td>
                                  <td style="text-align: right;"><?php echo format_rupiah($s1[$f_35]); ?></td>
                                  <td><?php echo $s1[$f31]; ?></td>
                                  <td><?php echo $s1[$f32]; ?></td>
                                  <td><?php echo $s1[$f33]; ?></td>
                                  <td><?php echo $s1[$f34]; ?></td>
                                  <td><?php echo $s1[$f35]; ?></td>
                                  <td><?php echo $s1[$f36]; ?></td>
                                  <td><?php echo $s1[$f37]; ?></td>
                                  <td><?php echo $s1[$f9]; ?></td>




                                  <td style="text-align: center;"><img src="../../images/menu/<?php echo $datagambar; ?>" class="brand-image elevation-3" style="opacity: 1;width: 60px;"></td>

                                  <td>
                                    <div style="margin: 10px"></div>
                                    <a href="main.php?route=<?php echo $rute; ?>&act=edit&id=<?php echo $s1[$f1]; ?>" title="Edit"> <button class="btn btn-primary btn-sm elevation-2" style="opacity: .7;width:80px"><i class="fa fa-edit"></i> Edit</button></a>
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
      <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
      <script>
        document.querySelector('#barangtoExcel').addEventListener('click', () => {
          // Show full-page loading spinner
          document.querySelector('#loadingSpinner').style.display = 'flex';

          fetch('route/data_barang/get_alltable.php')
            .then(response => {
              if (!response.ok) throw new Error('Network response was not ok');
              return response.text();
            })
            .then(html => {
              let tempDiv = document.createElement('div');
              tempDiv.innerHTML = html;
              let table = tempDiv.querySelector('table');
              if (!table) {
                throw new Error('No table found in the response');
              }

              // Export table to Excel
              TableToExcel.convert(table, {
                name: "ExportedTable.xlsx",
                sheet: {
                  name: "Sheet1"
                }
              });

              // Remove the temporary div and hide the loading spinner
              tempDiv.remove();
              document.querySelector('#loadingSpinner').style.display = 'none';
            })
            .catch(error => {
              console.error('Error:', error);
              alert('Failed to export the table. Please try again.');

              // Hide loading spinner on error
              document.querySelector('#loadingSpinner').style.display = 'none';
            });
        });
      </script>
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

                        <form method="POST" action="route/<?php echo $data; ?>/<?php echo $aksi; ?>.php?route=<?php echo $rute; ?>&act=edit&id=<?php echo $e['kd_subgrup']; ?>" enctype="multipart/form-data">

                          <section class="base">

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
                                  <input type="text" name="<?php echo $f2; ?>" class="form-control" value="<?php echo $e[$f2]; ?>" />
                                </div>
                              </div>

                              <div class="col-md-3">
                                <div class="form-group">
                                  <label><?php echo $j3; ?></label>
                                  <input type="text" name="<?php echo $f3; ?>" class="form-control" value="<?php echo $e[$f3]; ?>" />
                                </div>
                              </div>
                              <!-- Kolom Kedua -->
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label><?php echo $j4; ?></label>
                                  <input type="text" name="<?php echo $f4; ?>" class="form-control" value="<?php echo $e[$f4]; ?>" />
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label><?php echo $j9; ?></label>
                                  <input type="text" name="<?php echo $f_91; ?>" class="form-control" value="<?php echo $e[$f_91]; ?>" />
                                </div>
                              </div>


                              <div class="col-md-6">
                                <div class="form-group">
                                  <label><?php echo $j4; ?></label>
                                  <input type="text" name="<?php echo $f_42; ?>" class="form-control" value="<?php echo $e[$f_42]; ?>" />
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-group">
                                  <label><?php echo $j9; ?></label>
                                  <input type="text" name="<?php echo $f_92; ?>" class="form-control" value="<?php echo $e[$f_92]; ?>" />
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label><?php echo $j4; ?></label>
                                  <input type="text" name="<?php echo $f_43; ?>" class="form-control" value="<?php echo $e[$f_43]; ?>" />
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-group">
                                  <label><?php echo $j9; ?></label>
                                  <input type="text" name="<?php echo $f_93; ?>" class="form-control" value="<?php echo $e[$f_93]; ?>" />
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label><?php echo $j4; ?></label>
                                  <input type="text" name="<?php echo $f_44; ?>" class="form-control" value="<?php echo $e[$f_44]; ?>" />
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-group">
                                  <label><?php echo $j9; ?></label>
                                  <input type="text" name="<?php echo $f_94; ?>" class="form-control" value="<?php echo $e[$f_94]; ?>" />
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label><?php echo $j4; ?></label>
                                  <input type="text" name="<?php echo $f_45; ?>" class="form-control" value="<?php echo $e[$f_45]; ?>" />
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-group">
                                  <label><?php echo $j9; ?></label>
                                  <input type="text" name="<?php echo $f_95; ?>" class="form-control" value="<?php echo $e[$f_95]; ?>" />
                                </div>
                              </div>

                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="<?php echo $f31; ?>"><?php echo $j31; ?> </label>
                                  <select id="<?php echo $f31; ?>" name="<?php echo $f31; ?>" class="form-control">
                                    <option value="<?php echo $e[$f31]; ?>"><?php echo $e[$f31]; ?></option>

                                    <?php
                                    $query = mysqli_query($koneksi, "SELECT Nama_kategoriNilai FROM kategori_nilai WHERE id_kat = 1 GROUP BY Nama_kategoriNilai ");
                                    while ($j = mysqli_fetch_array($query)) {
                                      $kategorigroip = $j["Nama_kategoriNilai"];

                                    ?>
                                      <option value="<?php echo $kategorigroip; ?>"><?php echo $kategorigroip; ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="<?php echo $f32; ?>"><?php echo $j32; ?> </label>
                                  <select id="<?php echo $f32; ?>" name="<?php echo $f32; ?>" class="form-control">
                                    <option value="<?php echo $e[$f32]; ?>"><?php echo $e[$f32]; ?></option>

                                    <?php
                                    $query = mysqli_query($koneksi, "SELECT Nama_kategoriNilai FROM kategori_nilai WHERE id_kat = 2 GROUP BY Nama_kategoriNilai ");
                                    while ($j = mysqli_fetch_array($query)) {
                                      $kategorigroip = $j["Nama_kategoriNilai"];

                                    ?>
                                      <option value="<?php echo $kategorigroip; ?>"><?php echo $kategorigroip; ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="<?php echo $f33; ?>"><?php echo $j33; ?> </label>
                                  <select id="<?php echo $f33; ?>" name="<?php echo $f33; ?>" class="form-control">
                                    <option value="<?php echo $e[$f33]; ?>"><?php echo $e[$f33]; ?></option>

                                    <?php
                                    $query = mysqli_query($koneksi, "SELECT Nama_kategoriNilai FROM kategori_nilai WHERE id_kat = 3 GROUP BY Nama_kategoriNilai ");
                                    while ($j = mysqli_fetch_array($query)) {
                                      $kategorigroip = $j["Nama_kategoriNilai"];

                                    ?>
                                      <option value="<?php echo $kategorigroip; ?>"><?php echo $kategorigroip; ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="<?php echo $f34; ?>"><?php echo $j34; ?> </label>
                                  <select id="<?php echo $f34; ?>" name="<?php echo $f34; ?>" class="form-control">
                                    <option value="<?php echo $e[$f34]; ?>"><?php echo $e[$f34]; ?></option>

                                    <?php
                                    $query = mysqli_query($koneksi, "SELECT Nama_kategoriNilai FROM kategori_nilai WHERE id_kat = 4 GROUP BY Nama_kategoriNilai ");
                                    while ($j = mysqli_fetch_array($query)) {
                                      $kategorigroip = $j["Nama_kategoriNilai"];

                                    ?>
                                      <option value="<?php echo $kategorigroip; ?>"><?php echo $kategorigroip; ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="<?php echo $f35; ?>"><?php echo $j35; ?> </label>
                                  <select id="<?php echo $f35; ?>" name="<?php echo $f35; ?>" class="form-control">
                                    <option value="<?php echo $e[$f35]; ?>"><?php echo $e[$f35]; ?></option>

                                    <?php
                                    $query = mysqli_query($koneksi, "SELECT Nama_kategoriNilai FROM kategori_nilai WHERE id_kat = 5 GROUP BY Nama_kategoriNilai ");
                                    while ($j = mysqli_fetch_array($query)) {
                                      $kategorigroip = $j["Nama_kategoriNilai"];

                                    ?>
                                      <option value="<?php echo $kategorigroip; ?>"><?php echo $kategorigroip; ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="<?php echo $f36; ?>"><?php echo $j36; ?> </label>
                                  <select id="<?php echo $f36; ?>" name="<?php echo $f36; ?>" class="form-control">
                                    <option value="<?php echo $e[$f36]; ?>"><?php echo $e[$f36]; ?></option>

                                    <?php
                                    $query = mysqli_query($koneksi, "SELECT Nama_kategoriNilai FROM kategori_nilai WHERE id_kat = 6 GROUP BY Nama_kategoriNilai ");
                                    while ($j = mysqli_fetch_array($query)) {
                                      $kategorigroip = $j["Nama_kategoriNilai"];

                                    ?>
                                      <option value="<?php echo $kategorigroip; ?>"><?php echo $kategorigroip; ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="<?php echo $f37; ?>"><?php echo $j37; ?> </label>
                                  <select id="<?php echo $f37; ?>" name="<?php echo $f37; ?>" class="form-control">
                                    <option value="<?php echo $e[$f37]; ?>"><?php echo $e[$f37]; ?></option>

                                    <?php
                                    $query = mysqli_query($koneksi, "SELECT kd_kat FROM kategori_buffer ");
                                    while ($j = mysqli_fetch_array($query)) {
                                      $kategoribuffer = $j["kd_kat"];

                                    ?>
                                      <option value="<?php echo $kategoribuffer; ?>"><?php echo $kategoribuffer; ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label><?php echo $j9; ?></label>
                                  <input type="text" name="<?php echo $f9; ?>" class="form-control" value="<?php echo $e[$f9]; ?>" />
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <div id="msg"></div>
                                  <input type="file" name="photo" class="file">
                                  <div class="input-group my-3">
                                    <input type="text" class="form-control" disabled placeholder="Upload Gambar" id="file">
                                    <div class="input-group-append">
                                      <button type="button" id="pilih_gambar" class="browse btn btn-dark elevation-2">Pilih Gambar</button>
                                    </div>
                                  </div>
                                  <?php
                                  if ($e['photo'] == "") {
                                    $datagambar = "images.jpeg";
                                  } else {
                                    $datagambar = $e['photo'];
                                  } ?>

                                  <img src="../../images/menu/<?php echo $datagambar; ?>" id="preview" class="img-thumbnail elevation-3" style="width: 120px;float: left;margin-bottom: 5px;">
                                </div>
                              </div>
                            </div>
                            <hr />

                            <div class="form-group">
                              <button type="submit" class="btn btn-primary elevation-2" style="opacity: .7">Simpan Perubahan</button>
                            </div>

                          </section>
                        </form>
                        <a href="main.php?route=<?php echo $rute; ?>&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=<?php echo $rute; ?>"><button class="btn btn-primary btn-sm elevation-1" style="opacity: .7">Back</button></a>
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