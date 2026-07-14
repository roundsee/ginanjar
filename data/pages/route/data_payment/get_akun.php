<?php
include '../../../../config/koneksi.php'; // Sesuaikan dengan file koneksi Anda
include 'logging.php'; // Pastikan file logging.php ada dan berfungsi dengan baik
if (isset($_POST['kd_jenis'])) {
    $kd_jenis = $_POST['kd_jenis'];

    // Query untuk mengambil akun berdasarkan kd_jenis
    $q = "SELECT no_account, deskripsi FROM account WHERE kd_jenis = '$kd_jenis'";
    write_log("Query: $q"); // Log query yang dijalankan
    $query = mysqli_query($koneksi, $q);

    $akun_options = [];

    while ($row = mysqli_fetch_assoc($query)) {
        $akun_options[] = [
            'no_account' => $row['no_account'],
            'deskripsi' => $row['deskripsi']
        ];
    }

    // Mengirim hasil dalam format JSON
    echo json_encode($akun_options);
}
?>
