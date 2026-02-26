<?php
include '../../../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kd_brg = $_POST['kd_brg'];
    $kd_po = $_POST['kd_po']; // Ambil kd_po dari POST
    $harga_baru = str_replace(",", "", $_POST['harga_baru']); // Menghapus koma dari angka

    // Persiapkan query untuk mencegah SQL Injection
    $stmt = $koneksi->prepare("UPDATE pembelian_detail SET price = ? WHERE kd_brg = ? AND kd_po = ?");
    $stmt->bind_param("iss", $harga_baru, $kd_brg, $kd_po); // "iss" untuk integer dan string

    // Eksekusi query
    if ($stmt->execute()) {
        echo "Harga berhasil diperbarui.";
    } else {
        echo "Gagal memperbarui harga: " . $stmt->error; // Tampilkan error jika ada
    }

    $stmt->close(); // Tutup statement
}
?>
