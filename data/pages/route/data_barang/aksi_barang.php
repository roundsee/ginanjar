<?php
$dir = "../../../../";

//$tabel_sebelum="subalat_bayar";
$judulform = "DATA MENU";

$data = 'data_barang';
$tujuan = 'barang';
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
$j3 = 'Hargakat$hargakat';
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
$j17 = 'Hargakat$hargakat Pcs';
$j18 = 'Hargakat$hargakat Renteng';
$j19 = 'Hargakat$hargakat Pak';
$j20 = 'Hargakat$hargakat Ikat';
$j21 = 'Hargakat$hargakat Ball';
$j22 = 'Hargakat$hargakat Box';
$j23 = 'Hargakat$hargakat Dus';
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




$tabelmirror = 'barangnas';

session_start();
if (empty($_SESSION['username']) and empty($_SESSION['passuser'])) {
	echo "<link href='style.css' rel='stylesheet' type='text/css'>
	<center>Untuk mengakses modul, Anda harus login <br>";
	echo "<a href=../../index.php><b>LOGIN</b></a></center>";
} else {
	include $dir . "config/koneksi.php";

	$route = $_GET['route'];
	$act = $_GET['act'];

	//Hapus area
	if ($route == $tujuan and $act == 'hapus') {

		$query = mysqli_query($koneksi, "SELECT * FROM barang_kota WHERE kd_brg = '$_GET[id]' ");

		if ($query->num_rows > 0) {
			echo "<script>alert('Data sudah terdaftar tdk bisa di hapus,hub Admin');</script>";
			echo "<script>history.go(-1)</script>";
		} else {
			mysqli_query($koneksi, "DELETE from $tabel where $f1 = '$_GET[id]'");

			echo "<script>alert('Data berhasil dihapus ');</script>";
			echo "<script>history.go(-1)</script>";
		}
	}

	//Tambah 
	elseif ($route == $tujuan and $act == 'input') {
		$tgl = date('Y-m-d');
		/*
		echo '<br> ' . $f2 . ' = ' . $_POST[$f2];
		echo '<br> ' . $f3 . ' = ' . $_POST[$f3];
		echo '<br> ' . $f4 . ' = ' . $_POST[$f4];
		echo '<br> ' . $f5 . ' = ' . $_POST[$f5];
		echo '<br> ' . $f6 . ' = ' . $_POST[$f6];
		echo '<br> ' . $f7 . ' = ' . $_POST[$f7];
		echo '<br> ' . $f8 . ' = ' . $_POST[$f8];
		echo '<br> ' . $f9 . ' = ' . $_POST[$f9];
		echo '<br> ' . $f10 . ' = ' . $_POST[$f10];
		echo '<br> ' . $f11 . ' = ' . $_POST[$f11];
		echo '<br> ' . $f12 . ' = ' . $_POST[$f12];
		echo '<br> ' . $f13 . ' = ' . $_POST[$f13];
		echo '<br> ' . $f14 . ' = ' . $_POST[$f14];
		echo '<br> ' . $f15 . ' = ' . $_POST[$f15];
		echo '<br> ' . $f16 . ' = ' . $_POST[$f16];
		echo '<br> ' . $f17 . ' = ' . $_POST[$f17];
		echo '<br> ' . $f18 . ' = ' . $_POST[$f18];
		echo '<br> ' . $f19 . ' = ' . $_POST[$f19];
		echo '<br> ' . $f20 . ' = ' . $_POST[$f20];
		echo '<br> ' . $f21 . ' = ' . $_POST[$f21];
		echo '<br> ' . $f22 . ' = ' . $_POST[$f22];
		echo '<br> ' . $f23 . ' = ' . $_POST[$f23];
		echo '<br> ' . $f24 . ' = ' . $_POST[$f24];
		echo '<br> ' . $f25 . ' = ' . $_POST[$f25];
		echo '<br> ' . $f26 . ' = ' . $_POST[$f26];
		echo '<br> ' . $f27 . ' = ' . $_POST[$f27];
		echo '<br> ' . $f28 . ' = ' . $_POST[$f28];
		echo '<br> ' . $f29 . ' = ' . $_POST[$f29];
		echo '<br> ' . $f30 . ' = ' . $_POST[$f30];
		echo '<br> ' . $f31 . ' = ' . $_POST[$f31];
		echo '<br> ' . $f32 . ' = ' . $_POST[$f32];
		*/

		$id = $_POST[$f1];

		$query = mysqli_query($koneksi, "SELECT $f1  FROM $tabel where kd_brg='$id' ");
		$data = mysqli_fetch_array($query);

		$cek = mysqli_num_rows($query);

		if ($cek) {
			echo 'data ada';
			echo "<script>alert('Data tersebut sudah ADA.');</script>";
			echo "<script>history.go(-1)</script>";
			exit();
		}
		// else {
		// 	echo 'data tdk ada';
		// 	echo "<script>history.go(-1)</script>";
		// 	exit();
		// }

		$kodeBarang = $id;

		$gambar_produk = $_FILES['photo']['name'];

		//cek dulu jika ada gambar produk jalankan coding ini
		if ($gambar_produk != "") {
			$ekstensi_diperbolehkan = array('png', 'jpg', 'bmp', 'jpeg'); //ekstensi file gambar yang bisa diupload 
			$x = explode('.', $gambar_produk); //memisahkan nama file dengan ekstensi yang diupload
			$ekstensi = strtolower(end($x));
			$file_tmp = $_FILES['photo']['tmp_name'];

			$namafile = $kodeBarang . '.' . $ekstensi;

			$size = $_FILES['photo']['size']; //untuk mengetahui ukuran file

			if ((in_array($ekstensi, $ekstensi_diperbolehkan) === true) && (($size != 0) && ($size < 100000))) {
				move_uploaded_file($file_tmp, '../../../../images/menu/' . $namafile); //memindah file gambar ke folder gambar
				$query = "INSERT INTO $tabel ($f1, $f2, $f3, $f4, $f8) 
    			VALUES (
    				'$kodeBarang', 
    				'$_POST[$f2]', 
    				'$_POST[$f3]', 
    				'$_POST[$f4]', 
    				'$namafile'
    			)";
				$result = mysqli_query($koneksi, $query);


				if (!$result) {
					die("Query gagal dijalankan: " . mysqli_errno($koneksi) .
						" - " . mysqli_error($koneksi));
				} else {
					echo "<script>alert('Data berhasil ditambah.');</script>";
					echo "<script>history.go(-2)</script>";
				}
			} else {
				echo "<script>alert('Ekstensi gambar yang boleh hanya jpg , bmp , jpeg atau png. atau file tsb lebih dari 100 Kb');</script>";
				// echo "<script>history.go(-1)</script>";
			}
		} else {
			$hargake_1inti = !empty($_POST[$f3]) ? $_POST[$f3] : 0;
			$hargake_1 = 0;
			$hargake_2 = 0;
			$hargake_3 = 0;
			$hargake_4 = 0;
			$hargake_5 = 0;

			$satuanke_2 = !empty($_POST[$f_42]) ? $_POST[$f_42] : NULL;
			$satuanke_3 = !empty($_POST[$f_43]) ? $_POST[$f_43] : NULL;
			$satuanke_4 = !empty($_POST[$f_44]) ? $_POST[$f_44] : NULL;
			$satuanke_5 = !empty($_POST[$f_45]) ? $_POST[$f_45] : NULL;

			$quantity_1 = !empty($_POST[$f_91]) ? $_POST[$f_91] : 0;
			$quantity_2 = !empty($_POST[$f_92]) ? $_POST[$f_92] : 0;
			$quantity_3 = !empty($_POST[$f_93]) ? $_POST[$f_93] : 0;
			$quantity_4 = !empty($_POST[$f_94]) ? $_POST[$f_94] : 0;
			$quantity_5 = !empty($_POST[$f_95]) ? $_POST[$f_95] : 0;

			$quantitybarang = !empty($_POST[$f9]) ? $_POST[$f9] : 0;
			$querysql1 = mysqli_query($koneksi, "SELECT 
			IFNULL(layer1,0) AS layer11,
			IFNULL(SUBSTRING_INDEX(layer2, '|', 1),0) AS layer21, 
			IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(layer2, '|', 2), '|', -1),0) AS layer22,
			IFNULL(SUBSTRING_INDEX(layer3, '|', 1),0) AS layer31,  
			IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(layer3, '|', 2), '|', -1),0) AS layer32,  
			IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(layer3, '|', 3), '|', -1),0) AS layer33, 
			IFNULL(SUBSTRING_INDEX(layer4, '|', 1),0) AS layer41, 
			IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(layer4, '|', 2), '|', -1),0) AS layer42, 
			IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(layer4, '|', 3), '|', -1),0) AS layer43, 
			IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(layer4, '|', 4), '|', -1),0) AS layer44,  
			IFNULL(SUBSTRING_INDEX(layer5, '|', 1),0) AS layer51,  
			IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(layer5, '|', 2), '|', -1),0) AS layer52, 
			IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(layer5, '|', 3), '|', -1),0) AS layer53,  
			IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(layer5, '|', 4), '|', -1),0) AS layer54,  
			IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(layer5, '|', 5), '|', -1),0) AS layer55,id_kat,Nama_kategoriNilai
			 FROM kategori_nilai WHERE Nama_kategoriNilai = '$_POST[$f31]' AND id_kat =  1");

			/*SELECT IFNULL(kategori_nilai.layer1,0) AS layer11,IFNULL(SUBSTRING_INDEX(kategori_nilai.layer2, '|', 1),0) AS layer21, IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(kategori_nilai.layer2, '|', 2), '|', -1),0) AS layer22,IFNULL(SUBSTRING_INDEX(kategori_nilai.layer3, '|', 1),0) AS layer31,  IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(kategori_nilai.layer3, '|', 2), '|', -1),0) AS layer32,  IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(kategori_nilai.layer3, '|', 3), '|', -1),0) AS layer33, IFNULL(SUBSTRING_INDEX(kategori_nilai.layer4, '|', 1),0) AS layer41, IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(kategori_nilai.layer4, '|', 2), '|', -1),0) AS layer42, IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(kategori_nilai.layer4, '|', 3), '|', -1),0) AS layer43, IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(kategori_nilai.layer4, '|', 4), '|', -1),0) AS layer44,  IFNULL(SUBSTRING_INDEX(kategori_nilai.layer5, '|', 1),0) AS layer51,  IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(kategori_nilai.layer5, '|', 2), '|', -1),0) AS layer52, IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(kategori_nilai.layer5, '|', 3), '|', -1),0) AS layer53,  IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(kategori_nilai.layer5, '|', 4), '|', -1),0) AS layer54,  IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(kategori_nilai.layer5, '|', 5), '|', -1),0) AS layer55,kategori_nilai.id_kat,kategori_nilai.Nama_kategoriNilai,$tabel.ktg_retail
			FROM $tabel JOIN kategori_nilai ON $tabel.ktg_retail = kategori_nilai.Nama_kategoriNilai 
			where kategori_nilai.id_kat = 1 "*/


			while ($s1 = mysqli_fetch_array($querysql1)) {
				if (!empty($satuanke_5)) {
					$hargake_1 = $hargake_1inti + ($hargake_1inti * $s1["layer51"] / 100);
					$hargake_2 = $hargake_1inti + ($hargake_1inti * $s1["layer52"] / 100);
					$hargake_3 = $hargake_1inti + ($hargake_1inti * $s1["layer53"] / 100);
					$hargake_4 = $hargake_1inti + ($hargake_1inti * $s1["layer54"] / 100);
					$hargake_5 = $hargake_1inti + ($hargake_1inti * $s1["layer55"] / 100);
				} else if (!empty($satuanke_4)) {
					$hargake_1 = $hargake_1inti + ($hargake_1inti * $s1["layer41"] / 100);
					$hargake_2 = $hargake_1inti + ($hargake_1inti * $s1["layer42"] / 100);
					$hargake_3 = $hargake_1inti + ($hargake_1inti * $s1["layer43"] / 100);
					$hargake_4 = $hargake_1inti + ($hargake_1inti * $s1["layer44"] / 100);
				} else if (!empty($satuanke_3)) {
					$hargake_1 = $hargake_1inti + ($hargake_1inti * $s1["layer31"] / 100);
					$hargake_2 = $hargake_1inti + ($hargake_1inti * $s1["layer32"] / 100);
					$hargake_3 = $hargake_1inti + ($hargake_1inti * $s1["layer33"] / 100);
				} else if (!empty($satuanke_2)) {
					$hargake_1 = $hargake_1inti + ($hargake_1inti * $s1["layer21"] / 100);
					$hargake_2 = $hargake_1inti + ($hargake_1inti * $s1["layer22"] / 100);
				} else if (!empty($_POST[$f4])) {
					$hargake_1 = $hargake_1inti + ($hargake_1inti * $s1["layer11"] / 100);
				}
			}
			function roundUpTo100($value)
			{
				return ceil($value / 100) * 100;
			}

			$hargaroundup_1 = roundUpTo100($hargake_1);
			$hargaroundup_2 = roundUpTo100($hargake_2);
			$hargaroundup_3 = roundUpTo100($hargake_3);
			$hargaroundup_4 = roundUpTo100($hargake_4);
			$hargaroundup_5 = roundUpTo100($hargake_5);
			$query = "INSERT INTO $tabel (
    			$f1, $f2, $f3, $f_31,$f_32,$f_33,$f_34,$f_35,$f4,$f_41,$f_42,$f_43,$f_44,$f_45, $f9, $f_91,$f_92,$f_93,$f_94,$f_95, $f31,$f32,$f33, $f34,$f35,$f36,$f37) 
    		VALUES (
    			'$kodeBarang', 
    			'$_POST[$f2]', 
    			'$hargake_1inti', 
				'$hargaroundup_1', 
				'$hargaroundup_2', 
				'$hargaroundup_3', 
				'$hargaroundup_4', 
				'$hargaroundup_5', 
    			'$_POST[$f4]', 
    			'$_POST[$f4]', 
				'$satuanke_2', 
				'$satuanke_3', 
				'$satuanke_4', 
				'$satuanke_5', 
    			'$quantitybarang', 
				'$quantity_1', 
				'$quantity_2', 
				'$quantity_3', 
				'$quantity_4', 
				'$quantity_5', 
    			'$_POST[$f31]',
    			'$_POST[$f32]',
    			'$_POST[$f33]',
    			'$_POST[$f34]',
    			'$_POST[$f35]',
				'$_POST[$f36]',
				'$_POST[$f37]'

    		)";
			$result = mysqli_query($koneksi, $query);

			if (!$result) {
				die("Query gagal dijalankan: " . mysqli_errno($koneksi) .
					" - " . mysqli_error($koneksi));
			} else {
				echo "<script>alert('Data berhasil ditambah.');</script>";
				echo "<script>history.go(-2)</script>";
			}
		}
	} elseif ($route == $tujuan and $act == 'edit') {

		$photo = $_FILES['photo']['name'];
		$kd_brg = $_POST['kd_brg'];
		$hargake_1inti = !empty($_POST[$f3]) ? $_POST[$f3] : 1;
		$hargake_1 = 0;
		$hargake_2 = 0;
		$hargake_3 = 0;
		$hargake_4 = 0;
		$hargake_5 = 0;

		$satuanke_2 = !empty($_POST[$f_42]) ? $_POST[$f_42] : NULL;
		$satuanke_3 = !empty($_POST[$f_43]) ? $_POST[$f_43] : NULL;
		$satuanke_4 = !empty($_POST[$f_44]) ? $_POST[$f_44] : NULL;
		$satuanke_5 = !empty($_POST[$f_45]) ? $_POST[$f_45] : NULL;

		$quantity_1 = !empty($_POST[$f_91]) ? $_POST[$f_91] : 0;
		$quantity_2 = !empty($_POST[$f_92]) ? $_POST[$f_92] : 0;
		$quantity_3 = !empty($_POST[$f_93]) ? $_POST[$f_93] : 0;
		$quantity_4 = !empty($_POST[$f_94]) ? $_POST[$f_94] : 0;
		$quantity_5 = !empty($_POST[$f_95]) ? $_POST[$f_95] : 0;
		$quantitybarang = !empty($_POST[$f9]) ? $_POST[$f9] : 0;

		$querysql1 = mysqli_query($koneksi, "SELECT 
		IFNULL(layer1,0) AS layer11,
		IFNULL(SUBSTRING_INDEX(layer2, '|', 1),0) AS layer21, 
		IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(layer2, '|', 2), '|', -1),0) AS layer22,
		IFNULL(SUBSTRING_INDEX(layer3, '|', 1),0) AS layer31,  
		IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(layer3, '|', 2), '|', -1),0) AS layer32,  
		IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(layer3, '|', 3), '|', -1),0) AS layer33, 
		IFNULL(SUBSTRING_INDEX(layer4, '|', 1),0) AS layer41, 
		IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(layer4, '|', 2), '|', -1),0) AS layer42, 
		IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(layer4, '|', 3), '|', -1),0) AS layer43, 
		IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(layer4, '|', 4), '|', -1),0) AS layer44,  
		IFNULL(SUBSTRING_INDEX(layer5, '|', 1),0) AS layer51,  
		IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(layer5, '|', 2), '|', -1),0) AS layer52, 
		IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(layer5, '|', 3), '|', -1),0) AS layer53,  
		IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(layer5, '|', 4), '|', -1),0) AS layer54,  
		IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(layer5, '|', 5), '|', -1),0) AS layer55,id_kat,Nama_kategoriNilai
		 FROM kategori_nilai WHERE Nama_kategoriNilai = '$_POST[$f31]' AND id_kat =  1");

		/*SELECT IFNULL(kategori_nilai.layer1,0) AS layer11,IFNULL(SUBSTRING_INDEX(kategori_nilai.layer2, '|', 1),0) AS layer21, IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(kategori_nilai.layer2, '|', 2), '|', -1),0) AS layer22,IFNULL(SUBSTRING_INDEX(kategori_nilai.layer3, '|', 1),0) AS layer31,  IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(kategori_nilai.layer3, '|', 2), '|', -1),0) AS layer32,  IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(kategori_nilai.layer3, '|', 3), '|', -1),0) AS layer33, IFNULL(SUBSTRING_INDEX(kategori_nilai.layer4, '|', 1),0) AS layer41, IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(kategori_nilai.layer4, '|', 2), '|', -1),0) AS layer42, IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(kategori_nilai.layer4, '|', 3), '|', -1),0) AS layer43, IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(kategori_nilai.layer4, '|', 4), '|', -1),0) AS layer44,  IFNULL(SUBSTRING_INDEX(kategori_nilai.layer5, '|', 1),0) AS layer51,  IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(kategori_nilai.layer5, '|', 2), '|', -1),0) AS layer52, IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(kategori_nilai.layer5, '|', 3), '|', -1),0) AS layer53,  IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(kategori_nilai.layer5, '|', 4), '|', -1),0) AS layer54,  IFNULL(SUBSTRING_INDEX(SUBSTRING_INDEX(kategori_nilai.layer5, '|', 5), '|', -1),0) AS layer55,kategori_nilai.id_kat,kategori_nilai.Nama_kategoriNilai,$tabel.ktg_retail
		FROM $tabel JOIN kategori_nilai ON $tabel.ktg_retail = kategori_nilai.Nama_kategoriNilai 
		where kategori_nilai.id_kat = 1 "*/


		while ($s1 = mysqli_fetch_array($querysql1)) {
			if (!empty($satuanke_5)) {
				$hargake_1 = $hargake_1inti + ($hargake_1inti * $s1["layer51"] / 100);
				$hargake_2 = $hargake_1inti + ($hargake_1inti * $s1["layer52"] / 100);
				$hargake_3 = $hargake_1inti + ($hargake_1inti * $s1["layer53"] / 100);
				$hargake_4 = $hargake_1inti + ($hargake_1inti * $s1["layer54"] / 100);
				$hargake_5 = $hargake_1inti + ($hargake_1inti * $s1["layer55"] / 100);
			} else if (!empty($satuanke_4)) {
				$hargake_1 = $hargake_1inti + ($hargake_1inti * $s1["layer41"] / 100);
				$hargake_2 = $hargake_1inti + ($hargake_1inti * $s1["layer42"] / 100);
				$hargake_3 = $hargake_1inti + ($hargake_1inti * $s1["layer43"] / 100);
				$hargake_4 = $hargake_1inti + ($hargake_1inti * $s1["layer44"] / 100);
			} else if (!empty($satuanke_3)) {
				$hargake_1 = $hargake_1inti + ($hargake_1inti * $s1["layer31"] / 100);
				$hargake_2 = $hargake_1inti + ($hargake_1inti * $s1["layer32"] / 100);
				$hargake_3 = $hargake_1inti + ($hargake_1inti * $s1["layer33"] / 100);
			} else if (!empty($satuanke_2)) {
				$hargake_1 = $hargake_1inti + ($hargake_1inti * $s1["layer21"] / 100);
				$hargake_2 = $hargake_1inti + ($hargake_1inti * $s1["layer22"] / 100);
			} else if (!empty($_POST[$f4])) {
				$hargake_1 = $hargake_1inti + ($hargake_1inti * $s1["layer11"] / 100);
			}
		}
		function roundUpTo100($value)
		{
			return ceil($value / 100) * 100;
		}

		$hargaroundup_1 = roundUpTo100($hargake_1);
		$hargaroundup_2 = roundUpTo100($hargake_2);
		$hargaroundup_3 = roundUpTo100($hargake_3);
		$hargaroundup_4 = roundUpTo100($hargake_4);
		$hargaroundup_5 = roundUpTo100($hargake_5);
		//cek dulu jika merubah gambar produk jalankan coding ini
		if ($photo != "") {
			$ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg', 'bmp'); //ekstensi file gambar yang bisa diupload 
			$x = explode('.', $photo); //memisahkan nama file dengan ekstensi yang diupload
			$ekstensi = strtolower(end($x));
			$file_tmp = $_FILES['photo']['tmp_name'];
			$namafile = $kd_brg . '.' . $ekstensi;

			$size = $_FILES['photo']['size']; //untuk mengetahui ukuran file


			if ((in_array($ekstensi, $ekstensi_diperbolehkan) === true) && (($size != 0) && ($size < 100000))) {
				// move_uploaded_file($file_tmp, '../../../../images/menu/'.$photo); //memindah file gambar ke folder gambar
				move_uploaded_file($file_tmp, '../../../../images/menu/' . $namafile);

				$query  = "UPDATE $tabel SET     			
			$f2 = '$_POST[$f2]',
			$f3 = '$hargake_1inti', 
			$f_31 = '$hargaroundup_1', 
			$f_32 = '$hargaroundup_2', 
			$f_33 = '$hargaroundup_3', 
			$f_34 = '$hargaroundup_4', 
			$f_35 = '$hargaroundup_5', 
			$f4 = '$_POST[$f4]', 
			$f_41 = '$_POST[$f4]', 
			$f_42 = '$_POST[$f_42]', 
			$f_43 = '$_POST[$f_43]', 
			$f_44 = '$_POST[$f_44]', 
			$f_45 = '$_POST[$f_45]', 
			photo = '$namafile', 
			$f9 = '$quantitybarang', 
			$f_91 = '$_POST[$f_91]', 
			$f_92 = '$_POST[$f_92]', 
			$f_93 = '$_POST[$f_93]', 
			$f_94 = '$_POST[$f_94]', 
			$f_95 = '$_POST[$f_95]', 
			$f31 = '$_POST[$f31]',
			$f32 = '$_POST[$f32]',
			$f33 = '$_POST[$f33]',
			$f34 = '$_POST[$f34]',
			$f35 = '$_POST[$f35]',
			$f36 = '$_POST[$f36]',
			$f37 = '$_POST[$f37]'  
  
			";
				$query .= "WHERE $f1 = '$_POST[$f1]' ";
				$result = mysqli_query($koneksi, $query);

				$query2  = "UPDATE $tabelmirror SET 
			$f2 = '$_POST[$f2]',
			$f3 = '$_POST[$f3]' ";
				$query2 .= "WHERE $f1 = '$_POST[$f1]' ";
				$result2 = mysqli_query($koneksi, $query2);

				if (!$result) {
					die("Query gagal dijalankan 1: " . mysqli_errno($koneksi) .
						" - " . mysqli_error($koneksi));
				} else {
					echo "<script>alert('Data berhasil diubahh.')</script>";
					echo "<script>history.go(-2)</script>";
				}
			} else {
				echo "<script>alert('Ekstensi gambar yang boleh hanya jpg jpeg bmp atau png. atau file tsb lebih dari 100 Kb');</script>";
				echo "<script>history.go(-1)</script>";
			}
		} else {
			// jalankan query UPDATE berdasarkan ID yang produknya kita edit
			$query  = "UPDATE $tabel SET 
			$f2 = '$_POST[$f2]',
			$f3 = '$hargake_1inti', 
			$f_31 = '$hargaroundup_1', 
			$f_32 = '$hargaroundup_2', 
			$f_33 = '$hargaroundup_3', 
			$f_34 = '$hargaroundup_4', 
			$f_35 = '$hargaroundup_5', 
			$f4 = '$_POST[$f4]', 
			$f_41 = '$_POST[$f4]', 
			$f_42 = '$_POST[$f_42]', 
			$f_43 = '$_POST[$f_43]', 
			$f_44 = '$_POST[$f_44]', 
			$f_45 = '$_POST[$f_45]',
			$f9 = '$quantitybarang', 
			$f_91 = '$_POST[$f_91]', 
			$f_92 = '$_POST[$f_92]', 
			$f_93 = '$_POST[$f_93]', 
			$f_94 = '$_POST[$f_94]', 
			$f_95 = '$_POST[$f_95]',
			$f31 = '$_POST[$f31]',
			$f32 = '$_POST[$f32]',
			$f33 = '$_POST[$f33]',
			$f34 = '$_POST[$f34]',
			$f35 = '$_POST[$f35]',
			$f36 = '$_POST[$f36]',
			$f37 = '$_POST[$f37]'  
  
		";
			$query .= "WHERE $f1 = '$_POST[$f1]' ";
			$result = mysqli_query($koneksi, $query);

			// periska query apakah ada error
			if (!$result) {
				die("Query gagal dijalankan : " . mysqli_errno($koneksi) .
					" - " . mysqli_error($koneksi));
			} else {
				echo "<script>alert('Data berhasil diubah.')</script>";
				echo "<script>history.go(-2)</script>";
			}
		}
	} elseif ($route == $tujuan and $act == 'tes') {
		$query = "SELECT kd_brg,id_kat_satuan,hrg_pcs FROM barang";
		$result = mysqli_query($koneksi, $query);

		while ($row = mysqli_fetch_assoc($result)) {
			if (!empty($row["id_kat_satuan"]) && !empty($row["hrg_pcs"])) {
				$idbarang = $row["kd_brg"];
				$idkatbarang = $row["id_kat_satuan"];
				$hargakat = floatval($row["hrg_pcs"]);
				$querykat = "SELECT id_kat_satuan,Satuan_1,Satuan_2,Satuan_3,Satuan_4,Satuan_5,nilai1,nilai2,nilai3,nilai4,nilai5 FROM `kategori_satuan` JOIN `kategori_nilai` ON kategori_nilai.id_kategoriNilai = LEFT(kategori_satuan.id_kat_satuan,1) WHERE id_kat_satuan = '$idkatbarang';";
				$resultkat = mysqli_query($koneksi, $querykat);
				$row2 = mysqli_fetch_assoc($resultkat);

				$Satuan_1 = $row2["Satuan_1"];
				$Satuan_2 = empty($row2["Satuan_2"]) ? $Satuan_1 : $row2["Satuan_2"];
				$Satuan_3 = empty($row2["Satuan_3"]) ? $Satuan_1 : $row2["Satuan_3"];
				$Satuan_4 = empty($row2["Satuan_4"]) ? $Satuan_1 : $row2["Satuan_4"];
				$Satuan_5 = empty($row2["Satuan_5"]) ? $Satuan_1 : $row2["Satuan_5"];

				$nilai1 = $hargakat + ($hargakat * floatval($row2["nilai1"]) / 100);
				$nilai2 = empty($row2["Satuan_2"]) ? $nilai1 : $hargakat + ($hargakat * floatval($row2["nilai2"]) / 100);
				$nilai3 = empty($row2["Satuan_3"]) ? $nilai1 : $hargakat + ($hargakat * floatval($row2["nilai3"]) / 100);
				$nilai4 = empty($row2["Satuan_4"]) ? $nilai1 : $hargakat + ($hargakat * floatval($row2["nilai4"]) / 100);
				$nilai5 = empty($row2["Satuan_5"]) ? $nilai1 : $hargakat + ($hargakat * floatval($row2["nilai5"]) / 100);

				$queryupdate  = "UPDATE $tabel SET 
				`$Satuan_1`='$nilai1', 
				`$Satuan_2`='$nilai2', 
				`$Satuan_3`='$nilai3', 
				`$Satuan_4`='$nilai4', 
				`$Satuan_5`='$nilai5' WHERE `kd_brg` = '$idbarang';";
				$resultupdate = mysqli_query($koneksi, $queryupdate);
			}
		}
		echo "<script>alert('Harga berhasil diubah.')</script>";
		echo "<script>history.back()</script>";
	}
}
