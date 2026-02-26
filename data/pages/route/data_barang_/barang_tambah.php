<?php
// include 'header.php';
include '../../config/koneksi.php';

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
$f32 = 'kategori_satuan';


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
$j32 = 'Kategori Satuan';

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-color: ghostwhite;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <div style="margin:10px;"></div>
          <h1 class="list-gds">
            <b><?php echo $judulform; ?></b>
            <small style="font-weight: 100;">tambah</small>
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
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="card card-default">
      <div class="card-body">
        <div class="row">
          <section>
            <div class="box">
              <div class="box-body">
                <form method="post" enctype="multipart/form-data" action="route/<?php echo $data; ?>/<?php echo $aksi; ?>.php?route=<?php echo $rute; ?>&act=input">
                  <div class="wrapper">
                    <div class="row">
                      <!-- Kolom Pertama -->
                      <div class="col-md-3">
                        <div class="form-group">
                          <label><?php echo $j1; ?></label>
                          <input type="text" name="<?php echo $f1; ?>" class="form-control" placeholder="Masukan <?php echo $j1; ?> ..." required="required" />
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label><?php echo $j2; ?></label>
                          <input type="text" name="<?php echo $f2; ?>" class="form-control" placeholder="Masukan <?php echo $j2; ?> ..." required="required" />
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label><?php echo $j3; ?></label>
                          <input type="text" name="<?php echo $f3; ?>" class="form-control" placeholder="Masukan <?php echo $j3; ?> ..." required="required" />
                        </div>
                      </div>
                      <!-- Kolom Kedua -->
                      <div class="col-md-6">
                        <div class="form-group">
                          <label><?php echo $j4; ?></label>
                          <input type="text" name="<?php echo $f4; ?>" class="form-control" placeholder="Masukan <?php echo $j4; ?> ..." required="required" />
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label><?php echo $j9; ?></label>
                          <input type="text" name="<?php echo $f9; ?>" class="form-control" placeholder="Masukan <?php echo $j9; ?> ..." />
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label><?php echo $j10; ?></label>
                          <input type="text" name="<?php echo $f10; ?>" id="pcs" class="form-control" placeholder="Masukan <?php echo $j10; ?> ..." />
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label><?php echo $j17; ?></label>
                          <input type="text" name="<?php echo $f17; ?>" id="harga_pcs" class="form-control" placeholder="Masukan <?php echo $j17; ?> ..." />
                        </div>
                      </div>
                      <!-- <div class="col-md-4">
                        <div class="form-group">
                          <label><?php echo $j24; ?></label>
                          <input type="text" name="<?php echo $f24; ?>" class="form-control" placeholder="Masukan <?php echo $j24; ?> ..." />
                        </div>
                      </div> -->
                      <div class="col-md-3">
                        <div class="form-group">
                          <label><?php echo $j11; ?></label>
                          <input type="text" name="<?php echo $f11; ?>" id="renteng" class="form-control" placeholder="Masukan <?php echo $j11; ?> ..." />
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label><?php echo $j18; ?></label>
                          <input type="text" name="<?php echo $f18; ?>" id="harga_renteng" class="form-control" placeholder="Masukan <?php echo $j18; ?> ..." />
                        </div>
                      </div>
                      <!-- <div class="col-md-4">
                        <div class="form-group">
                          <label><?php echo $j25; ?></label>
                          <input type="text" name="<?php echo $f25; ?>" class="form-control" placeholder="Masukan <?php echo $j25; ?> ..." />
                        </div>
                      </div> -->
                      <div class="col-md-3">
                        <div class="form-group">
                          <label><?php echo $j12; ?></label>
                          <input type="text" name="<?php echo $f12; ?>" id="pak" class="form-control" placeholder="Masukan <?php echo $j12; ?> ..." />
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label><?php echo $j19; ?></label>
                          <input type="text" name="<?php echo $f19; ?>" id="harga_pak" class="form-control" placeholder="Masukan <?php echo $j19; ?> ..." />
                        </div>
                      </div>
                      <!-- <div class="col-md-4">
                        <div class="form-group">
                          <label><?php echo $j26; ?></label>
                          <input type="text" name="<?php echo $f26; ?>" class="form-control" placeholder="Masukan <?php echo $j26; ?> ..." />
                        </div>
                      </div> -->
                      <div class="col-md-3">
                        <div class="form-group">
                          <label><?php echo $j13; ?></label>
                          <input type="text" name="<?php echo $f13; ?>" id="ikat" class="form-control" placeholder="Masukan <?php echo $j13; ?> ..." />
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label><?php echo $j20; ?></label>
                          <input type="text" name="<?php echo $f20; ?>" id="harga_ikat" class="form-control" placeholder="Masukan <?php echo $j20; ?> ..." />
                        </div>
                      </div>
                      <!-- <div class="col-md-4">
                        <div class="form-group">
                          <label><?php echo $j27; ?></label>
                          <input type="text" name="<?php echo $f27; ?>" class="form-control" placeholder="Masukan <?php echo $j27; ?> ..." />
                        </div>
                      </div> -->
                      <div class="col-md-3">
                        <div class="form-group">
                          <label><?php echo $j14; ?></label>
                          <input type="text" name="<?php echo $f14; ?>" id="ball" class="form-control" placeholder="Masukan <?php echo $j14; ?> ..." />
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label><?php echo $j21; ?></label>
                          <input type="text" name="<?php echo $f21; ?>" id="harga_ball" class="form-control" placeholder="Masukan <?php echo $j21; ?> ..." />
                        </div>
                      </div>
                      <!-- <div class="col-md-4">
                        <div class="form-group">
                          <label><?php echo $j28; ?></label>
                          <input type="text" name="<?php echo $f28; ?>" class="form-control" placeholder="Masukan <?php echo $j28; ?> ..." />
                        </div>
                      </div> -->
                      <div class="col-md-3">
                        <div class="form-group">
                          <label><?php echo $j15; ?></label>
                          <input type="text" name="<?php echo $f15; ?>" id="box" class="form-control" placeholder="Masukan <?php echo $j15; ?> ..." />
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label><?php echo $j22; ?></label>
                          <input type="text" name="<?php echo $f22; ?>" id="harga_box" class="form-control" placeholder="Masukan <?php echo $j22; ?> ..." />
                        </div>
                      </div>
                      <!-- <div class="col-md-4">
                        <div class="form-group">
                          <label><?php echo $j29; ?></label>
                          <input type="text" name="<?php echo $f29; ?>" class="form-control" placeholder="Masukan <?php echo $j29; ?> ..." />
                        </div>
                      </div> -->
                      <div class="col-md-3">
                        <div class="form-group">
                          <label><?php echo $j16; ?></label>
                          <input type="text" name="<?php echo $f16; ?>" id="dus" class="form-control" placeholder="Masukan <?php echo $j16; ?> ..." />
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label><?php echo $j23; ?></label>
                          <input type="text" name="<?php echo $f23; ?>" id="harga_dus" class="form-control" placeholder="Masukan <?php echo $j23; ?> ..." />
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>ID Kategori</label>
                          <select name="id_kategori" class="form-control select2">
                            <option></option>
                            <?php

                            $query = mysqli_query($koneksi, "SELECT * from kategori order by id_kat asc");
                            while ($x = mysqli_fetch_array($query)) {
                              echo "<option value='$x[id_kat]'>$x[id_kat]</option>";
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Kategori Satuan</label>
                          <select name="kategori_satuan2" id="kategori_satuan" class="form-control select2">
                            <option></option>
                            <?php

                            $query = mysqli_query($koneksi, "SELECT * from kategori_satuan order by id_kategori asc");
                            while ($x = mysqli_fetch_array($query)) {
                              echo "<option value='$x[id_kategori] - $x[pcs] - $x[renteng]-$x[pak]-$x[ikat]-$x[ball]-$x[box]-$x[dus]'>$x[id_kategori]- $x[pcs]- $x[renteng]-$x[pak]-$x[ikat]-$x[ball]-$x[box]-$x[dus]</option>";
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label><?php echo $j32; ?></label>
                          <input type="text" name="<?php echo $f32; ?>" id="kategori" class="form-control" placeholder="Masukan <?php echo $j32; ?> ..." />
                        </div>
                      </div>
                      <!-- <div class="col-md-4">
                        <div class="form-group">
                          <label><?php echo $j30; ?></label>
                          <input type="text" name="<?php echo $f30; ?>" class="form-control" placeholder="Masukan <?php echo $f30; ?> ..." />
                        </div>
                      </div> -->
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
                  <!-- <a href="main.php?route=<?php echo $rute; ?>&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=<?php echo $rute; ?>">
                    <button class="btn btn-primary btn-sm elevation-2" style="opacity: .7">Back</button>
                  </a> -->
                </form>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </section>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<?php
include 'wibjs.php';
?>
<script type="text/javascript">
  $(document).ready(function() {

    // Fungsi untuk autofill berdasarkan kategori satuan
    function autosplitaccount() {
      var input = $('#kategori_satuan').val();
      var parts = input.split('-'); // Menggunakan - sebagai pemisah

      // Autofill nilai-nilai berdasarkan kategori satuan yang dipilih
      $('#kategori').val(parts[0]);
      $('#pcs').val(parts[1]);
      $('#renteng').val(parts[2]);
      $('#pak').val(parts[3]);
      $('#ikat').val(parts[4]);
      $('#ball').val(parts[5]);
      $('#box').val(parts[6]);
      $('#dus').val(parts[7]);

      // Hitung harga otomatis setelah autofill
      calculatePrices();
    }

    // Fungsi untuk menghitung harga otomatis
    function calculatePrices() {
      var harga_pcs = parseFloat($('#harga_pcs').val()) || 0; // Harga per PCS
      var renteng = parseFloat($('#renteng').val()) || 1; // Jumlah PCS per Renteng
      var pak = parseFloat($('#pak').val()) || 1; // Jumlah PCS per Pak
      var ikat = parseFloat($('#ikat').val()) || 1; // Jumlah PCS per Ikat
      var ball = parseFloat($('#ball').val()) || 1; // Jumlah PCS per Ball
      var box = parseFloat($('#box').val()) || 1; // Jumlah PCS per Box
      var dus = parseFloat($('#dus').val()) || 1; // Jumlah PCS per Dus

      // Hitung harga untuk setiap kolom berdasarkan harga PCS
      $('#harga_renteng').val(harga_pcs * renteng);
      $('#harga_pak').val(harga_pcs * pak);
      $('#harga_ikat').val(harga_pcs * ikat);
      $('#harga_ball').val(harga_pcs * ball);
      $('#harga_box').val(harga_pcs * box);
      $('#harga_dus').val(harga_pcs * dus);
    }

    // Ketika kategori satuan berubah, autofill nilai dan hitung harga
    $('#kategori_satuan').on('change', autosplitaccount);

    // Ketika harga PCS diisi atau diubah, harga lainnya dihitung
    $('#harga_pcs').on('input', calculatePrices);

    // Ketika jumlah renteng, pak, ikat, dll. diubah, harga juga dihitung ulang
    $('#renteng, #pak, #ikat, #ball, #box, #dus').on('input', calculatePrices);
  });
</script>

<script>
  function displayHasil(tgl_awal) {
    document.getElementById("tgl_awalHasil").value = tgl_awal;
  };
</script>

<script type="text/javascript">
  jQuery(document).ready(function(event) {
    var x0 = document.getElementById("isian0");
    var x1 = document.getElementById("isian1");
    var x2 = document.getElementById("isian2");

    x1.style.display = "none";
    x2.style.display = "none";

  });
</script>

<!-- Cakupan ========== -->
<script>
  function displayResult(cakup) {
    document.getElementById("result").value = cakup;
    var x = document.getElementById("result").value;
    var x0 = document.getElementById("isian0");
    var x1 = document.getElementById("isian1");
    var x2 = document.getElementById("isian2");
    if (x == "Nasional") {
      x0.style.display = "block";
      x1.style.display = "none";
      x2.style.display = "none";
      // alert(x + " adalah Cakupan 2");
    } else if (x == "Kota") {
      x0.style.display = "none";
      x1.style.display = "block";
      x2.style.display = "none";
      // alert(x + " adalah Cakupan 3");
    } else if (x == "Outlet") {

      x0.style.display = "none";
      x1.style.display = "none";
      x2.style.display = "block";
      // alert(x + " adalah Cakupan 4");
    }
  }
</script>
<!-- Cakupan ========== -->

<script type="text/javascript">
  <?php
  if (isset($_GET['alert'])) {
    if ($_GET['alert'] == "gagal") {
      echo "<div class='alert alert-danger'>File yang diperbolehkan hanya file gambar!</div>";
    } elseif ($_GET['alert'] == "duplikat") {
      echo "<div class='alert alert-danger'><b>Kode Barang</b> sudah pernah digunakan!</div>";
    }
  }
  ?>
</script>

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