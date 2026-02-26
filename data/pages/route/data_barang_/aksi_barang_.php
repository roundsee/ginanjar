<?php
$dir="../../../../";

//$tabel_sebelum="subalat_bayar";
$judulform="DATA MENU";

$data='data_barang';
$tujuan='barang';
$aksi='aksi_barang';

$tabel='barang';
$f1='kd_brg';
$f2='nama';
$f3='satuan';
$f4='harga';
$f5='kd_subgrup';
$f6='kd_grup';
$f7='kd_jenis';
$f8='photo';
$f9='rating';

$j1='Kode Barang';
$j2='Nama Barang';
$j3='Satuan';
$j4='Harga';
$j5='Kode Sub Grup';
$j6='Kode Grup';
$j7='kode Jenis';
$j8='Photo';
$j9='Rating';

$tabelmirror='barangnas';

session_start();
if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
	echo "<link href='style.css' rel='stylesheet' type='text/css'>
	<center>Untuk mengakses modul, Anda harus login <br>";
	echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	include $dir."config/koneksi.php";
	
	$route=$_GET['route'];
	$act=$_GET['act'];

	//Hapus area
	if($route==$tujuan AND $act=='hapus')
	{

		$query = mysqli_query($koneksi, "SELECT * FROM barang_kota WHERE kd_brg = '$_GET[id]' "); 

		if($query->num_rows > 0) {
			echo "<script>alert('Data sudah terdaftar tdk bisa di hapus,hub Admin');</script>";
			echo "<script>history.go(-1)</script>";
		} else{
			mysqli_query($koneksi,"DELETE from $tabel where $f1 = '$_GET[id]'");

			echo "<script>alert('Data berhasil dihapus ');</script>";
			echo "<script>history.go(-1)</script>";
		}
	}

	//Tambah 
	elseif($route==$tujuan AND $act=='input')
	{
		$tgl=date('Y-m-d');

		$id=$_POST['id'];

		$query = mysqli_query($koneksi, "SELECT max(kd_brg) as kodeTerbesar FROM barang where kd_subgrup='$id' ");
		$data = mysqli_fetch_array($query);
		$kodeBarang = $data['kodeTerbesar'];

		$urutan = (int) substr($kodeBarang, 9, 4);
		$tengah = substr($kodeBarang,6,2);
		$awal = substr($kodeBarang,0,5);

		$kd_jenis = substr($id,6,2);
		$kd_grup = substr($id,0,5);

// bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
		$urutan++;

		$kodeBarang = $id.'-'. sprintf("%04s", $urutan);

		$gambar_produk = $_FILES['photo']['name'];

//cek dulu jika ada gambar produk jalankan coding ini
		if($gambar_produk != "") 
		{
  			$ekstensi_diperbolehkan = array('png','jpg','bmp','jpeg'); //ekstensi file gambar yang bisa diupload 
  			$x = explode('.', $gambar_produk); //memisahkan nama file dengan ekstensi yang diupload
  			$ekstensi = strtolower(end($x));
  			$file_tmp = $_FILES['photo']['tmp_name']; 
  			if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  
  			{     
    			move_uploaded_file($file_tmp, '../../../../images/menu/'.$gambar_produk); //memindah file gambar ke folder gambar
    			$query = "INSERT INTO $tabel ($f1, $f2, $f3, $f4, $f5, $f6,$f7, $f8) 
    			VALUES (
    				'$kodeBarang', 
    				'$_POST[$f2]', 
    				'$_POST[$f3]', 
    				'$_POST[$f4]', 
    				'$id', 
    				'$kd_grup', 
    				'$kd_jenis', 
    				'$gambar_produk'
    			)";
    			$result = mysqli_query($koneksi, $query);

    			$query2 = "INSERT INTO $tabelmirror ($f1, $f2, $f3) 
    			VALUES (
    				'$kodeBarang', 
    				'$_POST[$f2]', 
    				'$_POST[$f3]'
    			)";
    			$result2 = mysqli_query($koneksi, $query2);

    			
    			if(!$result){
    				die ("Query gagal dijalankan: ".mysqli_errno($koneksi).
    					" - ".mysqli_error($koneksi));
    			} else {
    				echo "<script>alert('Data berhasil ditambah.');</script>";
    				echo "<script>history.go(-2)</script>";
    			}

    		} else  {
    			echo "<script>alert('Ekstensi gambar yang boleh hanya jpg , bmp , jpeg atau png.');</script>";
    			echo "<script>history.go(-1)</script>";
    		}
    	} else {
    		$query = "INSERT INTO $tabel (
    			$f1, $f2, $f3, $f4, $f5 , $f6, $f7) 
    		VALUES (
    			'$kodeBarang', 
    			'$_POST[$f2]', 
    			'$_POST[$f3]', 
    			'$_POST[$f4]', 
    			'$id',  
    			'$kd_grup',  
    			'$kd_jenis'
    		)";
    		$result = mysqli_query($koneksi, $query);

    		$query2 = "INSERT INTO $tabelmirror (
    			$f1, $f2, $f3) 
    		VALUES (
    			'$kodeBarang', 
    			'$_POST[$f2]', 
    			'$_POST[$f3]'
    		)";
    		$result2 = mysqli_query($koneksi, $query2);

    		if(!$result)
    		{
    			die ("Query gagal dijalankan: ".mysqli_errno($koneksi).
    				" - ".mysqli_error($koneksi));
    		} else {
    			echo "<script>alert('Data berhasil ditambah.');</script>";
    			echo "<script>history.go(-2)</script>";
    		}
    	}
    }

    elseif($route==$tujuan AND $act=='edit')
    {

    	$photo = $_FILES['photo']['name'];

  //cek dulu jika merubah gambar produk jalankan coding ini
    	if($photo != "") {
    $ekstensi_diperbolehkan = array('png','jpg','jpeg','bmp'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $photo); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_tmp = $_FILES['photo']['tmp_name'];   
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {
      move_uploaded_file($file_tmp, '../../../../images/menu/'.$photo); //memindah file gambar ke folder gambar

      $query  = "UPDATE $tabel SET 
      $f2 = '$_POST[$f2]',
      $f3 = '$_POST[$f3]', 
      $f4 = '$_POST[$f4]', 
      photo = '$photo', 
      $f9 = '$_POST[$f9]' ";
      $query .= "WHERE $f1 = '$_POST[$f1]' ";
      $result = mysqli_query($koneksi, $query);

      $query2  = "UPDATE $tabelmirror SET 
      $f2 = '$_POST[$f2]',
      $f3 = '$_POST[$f3]' ";
      $query2 .= "WHERE $f1 = '$_POST[$f1]' ";
      $result2 = mysqli_query($koneksi, $query2);

      if(!$result){
      	die ("Query gagal dijalankan 1: ".mysqli_errno($koneksi).
      		" - ".mysqli_error($koneksi));
      } else {
      	echo "<script>alert('Data berhasil diubah.')</script>";
      	echo "<script>history.go(-2)</script>";
      }
    } else {    
    	echo "<script>alert('Ekstensi gambar yang boleh hanya jpg jpeg bmp atau png.');</script>";
    	echo "<script>history.go(-1)</script>";
    }
  } else {
      // jalankan query UPDATE berdasarkan ID yang produknya kita edit
  	$query  = "UPDATE $tabel SET 
  	$f2 = '$_POST[$f2]',
  	$f3 = '$_POST[$f3]', 
  	$f4 = '$_POST[$f4]', 
  	$f9 = '$_POST[$f9]' ";
  	$query .= "WHERE $f1 = '$_POST[$f1]' ";
  	$result = mysqli_query($koneksi, $query);
  	
  	$query2  = "UPDATE $tabelmirror SET 
  	$f2 = '$_POST[$f2]',
  	$f3 = '$_POST[$f3]' ";
  	$query2 .= "WHERE $f1 = '$_POST[$f1]' ";
  	$result2 = mysqli_query($koneksi, $query2);

      // periska query apakah ada error
  	if(!$result){
  		die ("Query gagal dijalankan : ".mysqli_errno($koneksi).
  			" - ".mysqli_error($koneksi));
  	} else {
  		echo "<script>alert('Data berhasil diubah1.')</script>";
  		echo "<script>history.go(-2)</script>";
  	}
  }
}

}
?>
