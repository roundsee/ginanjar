<?php
$dir = "../../../../";
include $dir . "config/koneksi.php";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $id = '';
}

if (isset($_POST['submit'])) {
    $file = $_FILES['file']['name'];
    $ekstensi = explode(".", $file);
    $file_name = "file-" . round(microtime(true)) . "." . end($ekstensi);
    $sumber = $_FILES['file']['tmp_name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . $file_name;
    $upload = move_uploaded_file($sumber, $target_file);


    if ($upload) {
        require 'phpExcel/Classes/PHPExcel.php';
        $obj = PHPExcel_IOFactory::load($target_file);
        $all_data = $obj->getActiveSheet()->toArray(null, true, true, true);

        $batch_size = 1000;
        $chunked_data = array_chunk($all_data, $batch_size, true);
        foreach ($chunked_data as $chunk_index => $data_chunk) {
            $start_row = ($chunk_index * $batch_size) + 1; // Starting row for this batch
            $end_row = $start_row + $batch_size - 1;       // Ending row for this batch

            mysqli_begin_transaction($koneksi); // Start transaction for each batch

            try {
                foreach ($data_chunk as $index => $data) {
                    if ($index == 1) continue; // Skip header row

                    $kd_barang = isset($data['A']) ? mysqli_real_escape_string($koneksi, $data['A']) : '';
                    $durasi_kirim = isset($data['B']) ? mysqli_real_escape_string($koneksi, $data['B']) : 0;
                    $minimum_order = isset($data['C']) ? mysqli_real_escape_string($koneksi, $data['C']) : 0;

                    $sql_insert_barang = "
                INSERT INTO supplier_barang 
                    (kd_brg, kd_supp, durasi_kirim, minimum_order) 
                VALUES 
                    ('$kd_barang', '$id', '$durasi_kirim', '$minimum_order')
            ";
                    mysqli_query($koneksi, $sql_insert_barang);
                }

                mysqli_commit($koneksi); // Commit transaction for this batch

            } catch (Exception $e) {
                mysqli_rollback($koneksi); // Rollback if error occurs in batch
                echo "<script>alert('Batch failed: rows $start_row to $end_row. Error: " . addslashes($e->getMessage()) . "');</script>";
            }
        }
        unlink($target_file);

        echo "<script>alert('Data berhasil di Input.');</script>";
        echo "<script>window.location = '../../main.php?route=supplier_barang&act&id=" . $id . "&asal=supplier';</script>";
    } else {
        echo "<script>alert('File gagal diupload.');</script>";
        echo "<script>window.location = '../../main.php?route=supplier_barang&act&id=" . $id . "&asal=supplier';</script>";
    }
}
