<?php
include '../../../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data yang dikirimkan
    $kd_brg = $_POST['kd_brg'];
    $kd_po = $_POST['kd_po'];
    $urut = $_POST['urut'];
    $qty_baru = str_replace(",", "", $_POST['qty_baru']); // Menghapus koma dari angka
    $totalqty = $_POST['totalqty']; // Total qty sebelumnya dari parameter POST
    
    // Menghitung perubahan qty
    $perubahan_banyak = $totalqty - $qty_baru;

    // Update stok di tabel barang
    $query_update_stok_barang = mysqli_query($koneksi, "UPDATE barang SET Quantity = Quantity - $perubahan_banyak WHERE kd_brg = '$kd_brg'");

    // Pengecekan jika query update gagal
    if (!$query_update_stok_barang) {
        echo "Error updating stock for kd_brg = {$kd_brg}: " . mysqli_error($koneksi);
    } else {
        // Jika query update stok barang berhasil
        // Update jumlah pembelian di tabel pembelian_detail
        $stmt = $koneksi->prepare("UPDATE pembelian_detail SET jml = ? WHERE kd_brg = ? AND kd_po = ? AND urut = ?");
        $stmt->bind_param("issi", $qty_baru, $kd_brg, $kd_po, $urut); // Formatnya "issi" (integer, string, string, integer)

        // Eksekusi query pembaruan harga
        if ($stmt->execute()) {
            echo "Qty berhasil diperbarui.";
        } else {
            echo "Gagal memperbarui qty: " . $stmt->error; // Tampilkan error jika ada
        }

        $stmt->close(); // Tutup statement
    }
}
?>
