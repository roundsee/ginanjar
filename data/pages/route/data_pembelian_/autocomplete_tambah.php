<?php
$dir="../../../../";
include $dir."config/koneksi.php";
include $dir."config/library.php";

//employee
$employee=mysqli_query($koneksi,"SELECT employee_number,name_e from employee where employee_number = '$_GET[en]'");
$e = mysqli_fetch_array($employee);
?>
<html>
<head>
  <title>Form Input PO</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

  <!-- <link href="<?php echo $dir;?>bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" /> -->
  <link href="<?php echo $dir;?>dist/css/adminlte.min.css" rel="stylesheet" type="text/css" />
  
  <link href="<?php echo $dir;?>dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />

  <!-- Tambahkan jqueryUI disini -->
  <script type="text/javascript" src="<?php echo $dir;?>jquery-ui/js/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="<?php echo $dir;?>jquery-ui/js/jquery-ui-1.10.4.custom.min.js"></script>
  <link type="text/css" rel="stylesheet" href="<?php echo $dir;?>jquery-ui/css/smoothness/jquery-ui-1.10.4.custom.min.css"/>

  <!-- style -->
  <link href="<?php echo $dir;?>dist/style-m.css" rel="stylesheet" type="text/css" />

  <!-- Tuesday Demo Page -->
  <link rel="stylesheet" type="text/css" href="<?php echo $dir;?>dist/animated_tuesday/build/tuesday.css" />

  <!--animate-->
  <link rel="stylesheet" type="text/css" href="<?php echo $dir;?>dist/anima.css" media="all">


</head>
<body class="sidebar-mini text-sm accent-info" style="height: auto;background-color: ghostwhite;">
  <!-- <div class="wrapper"> -->
    <!-- Navbar -->
    <nav class=" navbar navbar-expand navbar-dark navbar-warning elevation-2" style="border-radius:10px 0 20px;border-bottom: teal;height: 45px;">
      <ul class="circles">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
      </ul>
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-sm-inline-block">
          <a href="#" class="nav-link embos"><?php echo $perusahaan."</b>";?></a>
        </li>
      </ul>

    </nav>
    <!-- /.navbar -->
    <!-- </div> -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="list-gds animated tdFadeInDown">
              Purchase Orders</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="../../main.php?route=home">Beranda</a></li>
                <li class="breadcrumb-item active"><a href="../../main.php?route=order-request&act">Purchase Order</a></li>
                <li class="breadcrumb-item active">tambah</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content scaled">
        <div class="container-fluid">
          <div class="card card-default">            
            <!-- /.card-header -->
            <div class="card-body animated tdFadeIn">
              <!-- Main row -->
              <div class="row"  style="background-color: ghostwhite;">
                <!-- Left col -->
                <section class="col-lg-12 connectedSortable">
                  <!-- Custom tabs (Charts with tabs)--> 
                  <div class="box">

                    <div class="box-body" style="margin-top: -20px" >

                      <form method="post" action="aksi_pr.php?route=purchase&act=input" >
                        <br>
                        <div class="form-group">
                          <h5>A. Data Purchase Orders</h5>
                        </div>

                        <div class="row">
                          <div class="col-lg-2">

                            <div class="form-group">
                              <label>Sales/Kasir:</label>
                              <input type="hidden" name="en" value="<?php echo $e['employee_number']; ?>" required/>
                              <input type="text" name="nama" value="<?php echo $e['name_e']; ?>" class="form-control" data-mini="true" readonly/>
                            </div>
                          </div>

                          <!-- <div class="col-lg-2">

                            <div class="form-group">
                              <label for="basic">No PO:</label>
                              <input type="text" name="nopo" class="form-control" placeholder="Masukan no. po yang tertera di surat pesanan / email ..." required/>
                            </div>
                          </div> -->

                          <div class="col-lg-2">

                            <div class="form-group">
                              <label for="basic">Tgl Purchase Req. :</label>
                              <input type="text" id="datepicker" name="tgl_po"  class="form-control" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask required/>
                            </div>
                          </div>

                          <!-- <div class="col-lg-2">

                            <div class="form-group">
                              <label for="basic">Tgl Expired PO :</label>
                              <input type="text" id="datepicker2" name="tgl_expired"  class="form-control" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask required/>
                            </div>
                          </div> -->

                          <!-- <div class="col-lg-2">
                            <div class="form-group">
                              <label for="basic">Tgl Jatuh Tempo :</label>
                              <input type="text" id="datepicker3" name="tgl_tempo"  class="form-control" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask required/>
                            </div>
                          </div> -->

                        </div>

                        <div class="row">
                          <div class="col-lg-2">

                            <div class="form-group">
                              <label for="basic">Pembayaran :</label>
                              <select name="payment" id="select-choice-0"  class="form-control">
                               <option value="Credit">Credit</option>
                               <option value="Cash">Cash</option>
                             </select>
                           </div>
                         </div>
                         <div class="col-lg-2">
                           <div class="form-group">
                            <label for="basic">Marketing Manager :</label>
                            <input type="text" name="manager"  class="form-control" placeholder="Masukan nama manager marketing terkait ..." required/>
                          </div>
                        </div>
                      </div>

                      <div class="form-group" style="height:40px;background-color: whitesmoke;">
                      </div>


                      <div class="form-group">
                        <h5>B. Data Outlet</h5>
                      </div>

                      <div class="row">
                        <div class="col-lg-2">
                          <div class="form-group">
                            <label for="basic">Outlet :</label>
                            <input type="text" id="kode" name="kode" class="form-control" required/>
                          </div>
                        </div>
                        <div class="col-lg-2">

                          <div class="form-group">
                            <label for="basic" >Nama Outlet :</label>
                            <label id="nama-outlet" >-</label>
                          </div>
                        </div>
                        <div class="col-lg-2">

                          <div class="form-group">
                            <label for="basic">Alamat :</label>
                            <span id="alamat-outlet" style="width:200px;">-</span>
                          </div>
                        </div>
                      </div>
                      <div class="form-group" style="height:40px;background-color: whitesmoke;">
                      </div>


                      <div class="form-group">
                        <h5>C. Data Barang</h5>
                      </div>
                      <div class="row">
                        <div class="col-lg-2">

                          <div class="form-group">
                            <label for="basic">Nama Barang :</label>
                            <select name="produk" id="select-choice-0"  class="form-control">
                             <?php

                             $produk=mysqli_query($koneksi,"select * from produk order by nama_produk asc");
                             while($pro=mysqli_fetch_array($produk))
                             {
                               echo"<option value='$pro[id_produk]'>$pro[id_produk] - $pro[nama_produk] - $pro[stok_gudang] pcs </option>";
                             }
                             ?>
                           </select>
                         </div>
                       </div>
                       <div class="col-lg-2">


                         <div class="form-group">
                          <label for="basic">Harga Barang :</label>
                          <input type="text"  class="form-control" placeholder="Masukan harga produk ..." name="harga" required/>
                        </div>
                      </div>
                      <div class="col-lg-2">

                        <div  class="form-group">
                          <label for="basic">Jumlah Beli :</label>
                          <input type="text" class="form-control" placeholder="Masukan jumlah beli ..." name="qty" required/>
                        </div>
                      </div>

                      <!-- <div class="col-lg-2">

                        <div class="form-group">
                          <label for="basic">Diskon 1 :</label>
                          <input type="text" class="form-control" placeholder="Masukan diskon 1 ..." name="diskon1" />
                        </div>
                      </div>

                      <div class="col-lg-2">

                        <div  class="form-group">
                          <label for="basic">Diskon 2 :</label>
                          <input type="text" class="form-control" placeholder="Masukan diskon 2 ..." name="diskon2" />
                        </div>
                      </div> -->

                    </div>
                      <div class="form-group" style="height:40px;background-color: whitesmoke;">
                      </div>

                    <div  class="form-group">
                     <input type="submit" class="btn btn-primary elevation-1" style="opacity: .7" value="Simpan" />
                   </div>
                 </form>
                 <div class="form-group">
                  <a href="../../main.php?route=order-request&act&ide=<?php echo $_GET['en']; ?>"><button class="btn btn-primary btn-sm elevation-1" style="opacity: .7">Back</button></a> 
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </div>
</section>

</div>

<footer class="main-footer" style="border-radius: 0 20px 0 20px;margin-left: 0px!important;">
  <div class="float-right d-none d-sm-block">
    <b>Version</b> 3.0.5
  </div>
  <strong>Copyright &copy; 2020-<?php echo $thn_sekarang." ".$naper1."</strong><small> ".$naper2;?></small>. by <a href="http://www.wibjazz.com">wibjazz</a>. All rights reserved.
</footer>

<script type="text/javascript">
  $(document).ready(function(){
    $("#kode").autocomplete({
      minLength:2,
      source:'get_product.php',
      select:function(event, ui){
        $('#nama-outlet').html(ui.item.nama);
        $('#alamat-outlet').html(ui.item.type);
      }
    });
  });
</script>

<script>
  $(function() {
   $("#datepicker").datepicker({
    changeMonth:true,
    changeYear:true,
    dateFormat:'yy-mm-dd',
    yearRange:'-45:+10'
  });
 });
</script>

<script>
  $(function() {
   $("#datepicker2").datepicker({
    changeMonth:true,
    changeYear:true,
    dateFormat:'yy-mm-dd',
    yearRange:'-45:+10'
  });
 });
</script>

<script>
  $(function() {
   $("#datepicker3").datepicker({
    changeMonth:true,
    changeYear:true,
    dateFormat:'yy-mm-dd',
    yearRange:'-45:+10'
  });
 });
</script>

<script>
  $('.money2').mask("#.##0,00", {reverse: true});
</script>
</body>
</html>