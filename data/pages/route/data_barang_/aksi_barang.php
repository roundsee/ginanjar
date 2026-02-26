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
	var_dump($_GET);

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
		// Memeriksa setiap input apakah kosong, jika kosong set NULL atau default value
		$f2_value = !empty($_POST[$f2]) ? $_POST[$f2] : 'NULL';
		$f3_value = !empty($_POST[$f3]) ? $_POST[$f3] : 'NULL';
		$f4_value = !empty($_POST[$f4]) ? $_POST[$f4] : 'NULL';
		$f9_value = !empty($_POST[$f9]) ? $_POST[$f9] : 'NULL';
		$f10_value = !empty($_POST[$f10]) ? $_POST[$f10] : 0; // misalnya ini numerik, ganti jadi 0 jika kosong
		$f11_value = !empty($_POST[$f11]) ? $_POST[$f11] : 0;
		$f12_value = !empty($_POST[$f12]) ? $_POST[$f12] : 0;
		$f13_value = !empty($_POST[$f13]) ? $_POST[$f13] : 0;
		$f14_value = !empty($_POST[$f14]) ? $_POST[$f14] : 0;
		$f15_value = !empty($_POST[$f15]) ? $_POST[$f15] : 0;
		$f16_value = !empty($_POST[$f16]) ? $_POST[$f16] : 0; // misalnya ini numerik, ganti jadi 0 jika kosong
		$f17_value = !empty($_POST[$f17]) ? $_POST[$f17] : 0;
		$f18_value = !empty($_POST[$f18]) ? $_POST[$f18] : 0;
		$f19_value = !empty($_POST[$f19]) ? $_POST[$f19] : 0;
		$f20_value = !empty($_POST[$f20]) ? $_POST[$f20] : 0;
		$f21_value = !empty($_POST[$f21]) ? $_POST[$f21] : 0;
		$f22_value = !empty($_POST[$f22]) ? $_POST[$f22] : 0;
		$f23_value = !empty($_POST[$f23]) ? $_POST[$f23] : 0;
		// dan seterusnya untuk input lainnya...


		// echo '<br> ' . $f2 . ' = ' . $_POST[$f2];
		// echo '<br> ' . $f3 . ' = ' . $_POST[$f3];
		// echo '<br> ' . $f4 . ' = ' . $_POST[$f4];
		// echo '<br> ' . $f5 . ' = ' . $_POST[$f5];
		// echo '<br> ' . $f6 . ' = ' . $_POST[$f6];
		// echo '<br> ' . $f7 . ' = ' . $_POST[$f7];
		// echo '<br> ' . $f8 . ' = ' . $_POST[$f8];
		// echo '<br> ' . $f9 . ' = ' . $_POST[$f9];
		// echo '<br> ' . $f10 . ' = ' . $_POST[$f10];
		// echo '<br> ' . $f11 . ' = ' . $_POST[$f11];
		// echo '<br> ' . $f12 . ' = ' . $_POST[$f12];
		// echo '<br> ' . $f13 . ' = ' . $_POST[$f13];
		// echo '<br> ' . $f14 . ' = ' . $_POST[$f14];
		// echo '<br> ' . $f15 . ' = ' . $_POST[$f15];
		// echo '<br> ' . $f16 . ' = ' . $_POST[$f16];
		// echo '<br> ' . $f17 . ' = ' . $_POST[$f17];
		// echo '<br> ' . $f18 . ' = ' . $_POST[$f18];
		// echo '<br> ' . $f19 . ' = ' . $_POST[$f19];
		// echo '<br> ' . $f20 . ' = ' . $_POST[$f20];
		// echo '<br> ' . $f21 . ' = ' . $_POST[$f21];
		// echo '<br> ' . $f22 . ' = ' . $_POST[$f22];
		// echo '<br> ' . $f23 . ' = ' . $_POST[$f23];
		// echo '<br> ' . $f24 . ' = ' . $_POST[$f24];
		// echo '<br> ' . $f25 . ' = ' . $_POST[$f25];
		// echo '<br> ' . $f26 . ' = ' . $_POST[$f26];
		// echo '<br> ' . $f27 . ' = ' . $_POST[$f27];
		// echo '<br> ' . $f28 . ' = ' . $_POST[$f28];
		// echo '<br> ' . $f29 . ' = ' . $_POST[$f29];
		// echo '<br> ' . $f30 . ' = ' . $_POST[$f30];
		// echo '<br> ' . $f31 . ' = ' . $_POST[$f31];

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
				echo "<script>history.go(-1)</script>";
			}
		} else {
			$query = "INSERT INTO $tabel (
    			$f1, $f2, $f3, $f4, $f9, $f10, $f11, $f12, $f13, $f14, $f15, $f16, $f17, $f18, $f19, $f20, $f21, $f22, $f23, $f24, $f25, $f26,$f27,$f28,$f29,$f30,$f31,$f32) 
    		VALUES (
    			'$kodeBarang', 
    			'$_POST[$f2]', 
    			'$_POST[$f3]', 
    			'$_POST[$f4]', 
    			'$_POST[$f9]', 
    			$f10_value, 
				$f11_value, 
				$f12_value, 
				$f13_value, 
    			$f14_value, 
				$f15_value, 
				$f16_value, 
				$f17_value, 
    			$f18_value, 
				$f19_value, 
				$f20_value, 
				$f21_value, 
				$f22_value, 
				$f23_value,    			
    			0, 
    			0, 
    			0,
				0,
				0,
				0,
				0,
				'$_POST[$f31]',
				'$_POST[$f32]'
    		)";
			$result = mysqli_query($koneksi, $query);

			if (!$result) {
				die("Query gagal dijalankan: " . mysqli_errno($koneksi) .
					" - " . mysqli_error($koneksi));
			} else {
				echo "<script>alert('Data berhasil ditambah.');</script>";
				// echo "<script>history.go(-2)</script>";
			}
		}
	} elseif ($route == $tujuan and $act == 'edit') {

		$photo = $_FILES['photo']['name'];
		$kd_brg = $_POST['kd_brg'];

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
				$f3 = '$_POST[$f3]', 
				$f4 = '$_POST[$f4]', 
				photo = '$namafile', 
				$f9 = '$_POST[$f9]', 
				$f10 = '$_POST[$f10]', 
				$f11 = '$_POST[$f11]', 
				$f12 = '$_POST[$f12]', 
				$f13 = '$_POST[$f13]', 
				$f14 = '$_POST[$f14]', 
				$f15 = '$_POST[$f15]', 
				$f16 = '$_POST[$f16]', 
				$f17 = '$_POST[$f17]', 
				$f18 = '$_POST[$f18]', 
				$f19 = '$_POST[$f19]', 
				$f20 = '$_POST[$f20]', 
				$f21 = '$_POST[$f21]', 
				$f22 = '$_POST[$f22]', 
				$f23 = '$_POST[$f23]'
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
			$f3 = '$_POST[$f3]', 
			$f4 = '$_POST[$f4]', 
			$f9 = '$_POST[$f9]', 
			$f10 = '$_POST[$f10]', 
			$f11 = '$_POST[$f11]', 
			$f12 = '$_POST[$f12]', 
			$f13 = '$_POST[$f13]', 
			$f14 = '$_POST[$f14]', 
			$f15 = '$_POST[$f15]', 
			$f16 = '$_POST[$f16]', 
			$f17 = '$_POST[$f17]', 
			$f18 = '$_POST[$f18]', 
			$f19 = '$_POST[$f19]', 
			$f20 = '$_POST[$f20]', 
			$f21 = '$_POST[$f21]', 
			$f22 = '$_POST[$f22]', 
			$f23 = '$_POST[$f23]',
			$f31='$_POST[$f31]'   
		";
			$query .= "WHERE $f1 = '$_POST[$f1]' ";
			$result = mysqli_query($koneksi, $query);
			echo $query;
			// periska query apakah ada error
			if (!$result) {
				die("Query gagal dijalankan : " . mysqli_errno($koneksi) .
					" - " . mysqli_error($koneksi));
			} else {
				echo "<script>alert('Data berhasil diubah1.')</script>";
				// echo "<script>history.go(-2)</script>";
			}
		}
	} elseif ($route == $tujuan and $act == 'search') {
		// Ambil input pencarian
		$kode_barang = $_GET['kode_barang'] ?? '';
		$nama_barang = $_GET['nama_barang'] ?? '';

		$sql = "SELECT * FROM barang WHERE kd_brg LIKE '%$kode_barang%' AND nama LIKE '%$nama_barang%'";
		$result = $koneksi->query($sql);

		if (!$result) {
			die("Query error: " . $koneksi->error);
		}

		if ($result->num_rows > 0) {
			echo "<table class='table table-bordered'>";
			echo "<thead><tr><th>Kode Barang</th><th>Nama Barang</th><th>Harga</th></tr></thead>";
			echo "<tbody>";
			while ($row = $result->fetch_assoc()) {
				echo "<tr><td>" . htmlspecialchars($row['kd_brg']) . "</td><td>" . htmlspecialchars($row['nama']) . "</td><td>" . htmlspecialchars($row['harga']) . "</td></tr>";
			}
			echo "</tbody></table>";
		} else {
			echo "Tidak ada hasil yang ditemukan.";
		}
	}
}
