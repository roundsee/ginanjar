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
$j38 = 'Jumlah Stock Awal';


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
                <div class="wrapper">
                  <form method="post" enctype="multipart/form-data" action="route/<?php echo $data; ?>/<?php echo $aksi; ?>.php?route=<?php echo $rute; ?>&act=input">

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
                          <input type="text" name="<?php echo $f_91; ?>" class="form-control" placeholder="Masukan <?php echo $j9; ?> ..." />
                        </div>
                      </div>


                      <div class="col-md-6">
                        <div class="form-group">
                          <label><?php echo $j4; ?></label>
                          <input type="text" name="<?php echo $f_42; ?>" class="form-control" placeholder="Masukan <?php echo $j4; ?> ..." />
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label><?php echo $j9; ?></label>
                          <input type="text" name="<?php echo $f_92; ?>" class="form-control" placeholder="Masukan <?php echo $j9; ?> ..." />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label><?php echo $j4; ?></label>
                          <input type="text" name="<?php echo $f_43; ?>" class="form-control" placeholder="Masukan <?php echo $j4; ?> ..." />
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label><?php echo $j9; ?></label>
                          <input type="text" name="<?php echo $f_93; ?>" class="form-control" placeholder="Masukan <?php echo $j9; ?> ..." />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label><?php echo $j4; ?></label>
                          <input type="text" name="<?php echo $f_44; ?>" class="form-control" placeholder="Masukan <?php echo $j4; ?> ..." />
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label><?php echo $j9; ?></label>
                          <input type="text" name="<?php echo $f_94; ?>" class="form-control" placeholder="Masukan <?php echo $j9; ?> ..." />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label><?php echo $j4; ?></label>
                          <input type="text" name="<?php echo $f_45; ?>" class="form-control" placeholder="Masukan <?php echo $j4; ?> ..." />
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label><?php echo $j9; ?></label>
                          <input type="text" name="<?php echo $f_95; ?>" class="form-control" placeholder="Masukan <?php echo $j9; ?> ..." />
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="<?php echo $f31; ?>"><?php echo $j31; ?> </label>
                          <select id="<?php echo $f31; ?>" name="<?php echo $f31; ?>" class="form-control">
                            <?php
                            $query = mysqli_query($koneksi, "SELECT Nama_kategoriNilai FROM kategori_nilai WHERE id_kat = 1 GROUP BY Nama_kategoriNilai");
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
                            <?php
                            $query = mysqli_query($koneksi, "SELECT Nama_kategoriNilai FROM kategori_nilai WHERE id_kat = 2 GROUP BY Nama_kategoriNilai");
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
                            <?php
                            $query = mysqli_query($koneksi, "SELECT Nama_kategoriNilai FROM kategori_nilai WHERE id_kat = 3 GROUP BY Nama_kategoriNilai");
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
                            <?php
                            $query = mysqli_query($koneksi, "SELECT Nama_kategoriNilai FROM kategori_nilai WHERE id_kat = 4 GROUP BY Nama_kategoriNilai");
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
                            <?php
                            $query = mysqli_query($koneksi, "SELECT Nama_kategoriNilai FROM kategori_nilai WHERE id_kat = 5 GROUP BY Nama_kategoriNilai");
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
                            <?php
                            $query = mysqli_query($koneksi, "SELECT Nama_kategoriNilai FROM kategori_nilai WHERE id_kat = 6 GROUP BY Nama_kategoriNilai");
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
                            <?php
                            $query = mysqli_query($koneksi, "SELECT kd_kat , nilai FROM kategori_buffer ");
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
                          <label><?php echo $j38; ?></label>
                          <input type="text" name="<?php echo $f9; ?>" class="form-control" placeholder="Masukan <?php echo $j9; ?> ..." />
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
                    <hr>
                    <input type="submit" class="btn btn-primary btn-sm elevation-2" style="opacity: .7" value="Simpan" />
                  </form><br>
                  <a href="main.php?route=<?php echo $rute; ?>&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=<?php echo $rute; ?>">
                    <button class="btn btn-primary btn-sm elevation-2" style="opacity: .7">Back</button>
                  </a>
                </div>

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