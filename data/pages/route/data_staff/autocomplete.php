<?php
$dir='../../../../';
session_start();

include $dir.'config/koneksi.php';
include $dir.'config/library.php';

$judulform="Daftar User";

$data='data_staff';
$rute='staff';
$aksi='aksi_staff';

$tabel='employee';
$f1='employee_number';
$f2='name_e';
$f3='birth_place';
$f4='birth_date';
$f5='alamat_e';
$f6='alamat2_e';
$f7='city_e';
$f8='state_e';
$f9='zipcode_e';
$f10='id_jabatan';
$f11='telpon_e';
$f12='hp_e';
$f13='email_e';
$f14='website_e';
$f15='desc_e';
$f16='image';
$f17='cabang_e';

$j1='Kode Staff';
$j2='Nama';
$j3='Tempat Lahir';
$j4='Tgl Lahir';
$j5='Alamat 1';
$j6='Alamat 2';
$j7='Kota';
$j8='Negara';
$j9='KodePos';
$j10='Kode Jabatan ';
$j11='Telp';
$j12='Hp';
$j13='email';
$j14='Website';
$j15='Keterangan';
$j16='Photo';
$j17='Kode Cabang';

include '../header.php';

$asal=$_GET['asal'];
?>



<table class="table-responsive">
  <form method="post" enctype="multipart/form-data" action="<?php echo $aksi;?>.php?route=<?php echo $rute;?>&act=input&asal=<?php echo $_GET['asal'];?>">

    <div class="form-group">
      <label><?php echo $j2;?></label>
      <input type="text" name="<?php echo $f2;?>" class="form-control" placeholder="Masukan <?php echo $j2;?> ..."/>
    </div>

    <div class="form-group">
      <label><?php echo $j10;?></label>
      <select name="<?php echo $f10;?>" class="form-control" style="width:400px;height: 40px;">
        <?php

        $produk=mysqli_query($koneksi,"SELECT * from jabatan WHERE id_jabatan!=1 order by id_jabatan asc");
        while($pro=mysqli_fetch_array($produk))
        {
         echo"<option value='$pro[id_jabatan]'>$pro[nama_jabatan]</option>";
       }
       ?>
     </select>
   </div>

    <div class="form-group">
      <label><?php echo $j17;?></label>
      <select name="<?php echo $f17;?>" class="form-control" style="width:400px;height: 40px;">
        <?php

        $produk=mysqli_query($koneksi,"SELECT * from pelanggan order by kd_cus asc");
        while($pro=mysqli_fetch_array($produk))
        {
         echo"<option value='$pro[kd_cus]'>$pro[kd_cus] - $pro[nama]</option>";
       }
       ?>
     </select>
   </div>


  <div class="form-group">
    <hr />
    <input type="submit" class="btn btn-primary elevation-2" style="opacity: .7" value="Simpan" />
  </div>


</form>
<a href="../../main.php?route=<?php echo $rute;?>&act&ide=<?php echo $_SESSION['employee_number']; ?>&asal=<?php echo $rute;?>"><button class="btn btn-primary btn-sm elevation-1" style="opacity: .7">Back</button></a> 

</table>

<?php include '../footer.php'; ?>