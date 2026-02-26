<?php

$judulform = "Data Barang Supplier";
if (isset($_GET['id'])) {
  $id = $_GET['id'];
} else {
  $id = '';
}
?>

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper" style="background-color: ghostwhite;">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="list-gds">
            <b><?php echo $judulform; ?></b> <small style="font-weight: 100;">import</small>
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
  <div id="loading-overlay" style="display: none;">
    <div class="spinner"></div>
  </div>

  <div class="container">
    <h1>Excel Upload Barang Supplier <?php echo $id ?></h1>
    <form id="uploadForm" action="route/import_barang_supplier/import.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data" onsubmit="showLoading()">
      <div class="form-group">
        <label>Upload Excel File</label>
        <input type="file" id="fileInput" name="file" accept=".xls,.xlsx" class="form-control">
      </div>
      <div class="form-group">
        <button type="submit" name="submit" class="btn btn-success">Upload</button>
      </div>
    </form>
    <a href="route/import_barang_supplier/Book22.xlsx" download="mydata.xlsx">
      <button class="btn btn-primary">Download Format Excel</button>
    </a>
    <script>

    </script>
  </div>
</div>
<script>
  function showLoading() {
    document.getElementById('loading-overlay').style.display = 'flex';
  }
</script>