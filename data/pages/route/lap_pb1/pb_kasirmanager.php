<table id="example" class="table table-bordered table-striped">
	<thead style="background-color:  lightgray;font-size: 90%;" class="elevation-2">
		<tr>
			<th width="30px">No.</th>
			<th width="180px"><?php echo $j2; ?></th>
			<th width="160px"><?php echo $j1; ?></th>
			<th width="160px">Nama Admin</th>

			<!--<th>Ket Aplikasi</th>
			<th>Kode Aplikasi</th>-->
			<th width="120px">Sub alat Bayar</th>
			<!--<th><?php echo $j7; ?></th>
			<th><?php echo $j8; ?></th>-->
			<th><?php echo $j9; ?></th>
			<?php if (($login_hash == 6  or $filter == 'outlet') && $tgl_awal == date("Y-m-d")) { ?>
				<th width="140px">Void</th>

			<?php } ?>
			<th width="140px">Print Ulang</th>
		</tr>
	</thead>
	<tbody>
		<?php

		$query = "SELECT  
		faktur,tanggal,kd_aplikasi,subjumlah,ppn,jumlah,ket_aplikasi,oleh,
		-- jenis_transaksi.nama as jt_nama,
		subalat_bayar.nama as sb_nama
		FROM penjualan 
		-- join jenis_transaksi on jenis_transaksi.kd_jenis=penjualan.kd_aplikasi
		join subalat_bayar on subalat_bayar.kdsub_alat=penjualan.kdsub_alatbayar
		WHERE (tanggal between '$tgl_awal' and '$tgl_akhir'  +interval 1 day) $kondisi AND penjualan.subjumlah <> 0
		";


		$sql1 = mysqli_query($koneksi, $query);
		$no = 1;

		$tot_subjumlah = 0;
		$tot_ppn = 0;
		$tot_jumlah = 0;

		while ($s1 = mysqli_fetch_array($sql1)) {

		?>
			<tr align="left">
				<td><?php echo $no; ?></td>
				<td><?php echo $s1[$f2]; ?></td>
				<td width="160px"><?php echo $s1[$f1]; ?></td>
				<td width="160px"><?php echo $s1['oleh']; ?></td>

				<!--<td><?php echo $s1[$f20]; ?></td>
				<td style="text-align: center;"><?php echo $s1[$f4]; ?></td>-->
				<td><?php echo $s1['sb_nama']; ?></td>
				<!--<td style="text-align: right;"><?php echo number_format($s1[$f7]); ?></td>

				<td style="text-align: right;"><?php echo number_format($s1[$f8]); ?></td>-->
				<td style="text-align: right;"><?php echo number_format($s1[$f9]); ?></td>

				<?php if (($login_hash == 6  or $filter == 'outlet') && $tgl_awal == date("Y-m-d")) { ?>
					<td align='center' width="100px;">
						<button type="button" onclick="navigateVoid(this)" class="btn btn-danger"><i class="fa fa-close"></i><strong style="color: whitesmoke; opacity: .7;"> VOID</strong></button>

					</td>
				<?php } ?>
				<td align='center' width="100px;">
					<button type="button" onclick="navigatePrintUlang(this)" class="btn btn-primary"><i class="fa fa-close"></i><strong style="color: whitesmoke; opacity: .7;"> PRINT</strong></button>

				</td>
			</tr>

		<?php
			$no++;
			$tot_subjumlah = $tot_subjumlah + $s1[$f7];

			$tot_ppn = $tot_ppn + $s1[$f8];
			$tot_jumlah = $tot_jumlah + $s1[$f9];
		}
		?>
	</tbody>
	<tfoot>
		<tr style="font-weight:800;background-color: antiquewhite">
			<td colspan="5" style="text-align:right;"> Total :</td>
			<!--<td style="text-align:right;"><?php echo number_format($tot_subjumlah); ?></td>

			<td style="text-align:right;"><?php echo number_format($tot_ppn); ?></td>-->
			<td style="text-align:right;"><?php echo number_format($tot_jumlah); ?></td>
			<?php if (($login_hash == 6  or $filter == 'outlet') && $tgl_awal == date("Y-m-d")) { ?>
				<td style="text-align:right;"></td>

			<?php } ?>
			<td style="text-align:right;"></td>

		</tr>
	</tfoot>

</table>


<br>
<br>

<div style="
    font-weight: 900;
    font-size: large;
">
	SUMMARY REPORT
</div>

<table id="example" class="table table-bordered table-striped" style="width:600px">
	<thead style="background-color:  lightgray;" class="elevation-2">
		<th>Uraian</th>
		<th>Faktur</th>
		<!-- <th style="text-align:right;">Sub Jumlah</th>
		<th style="text-align:right;">Pajak</th>-->
		<th style="text-align:right;width: 180px;">Jumlah</th>
	</thead>
	<tbody>
		<?php
		$query = "SELECT 
		pelanggan.nama as p_nama,
		kotabaru.nama as kb_nama ,
		alat_bayar.keterangan as jt_nama,
		-- jenis_transaksi.nama as jt_nama,
		sum(penjualan.jumlah) as pj_jumlah,
		count(penjualan.jumlah) as count_jumlah,
		sum(penjualan.subjumlah) as pj_subjumlah,
		sum(penjualan.ppn) as pj_ppn
		FROM penjualan 
		join pelanggan on pelanggan.kd_cus=penjualan.kd_cus
		join kotabaru on kotabaru.kode=pelanggan.kd_kota
		join alat_bayar on alat_bayar.kd_alat=penjualan.kd_alatbayar
		-- join jenis_transaksi on jenis_transaksi.kd_jenis=penjualan.kd_aplikasi
		WHERE (tanggal between '$tgl_awal' and '$tgl_akhir'  +interval 1 day) 
		$kondisi AND penjualan.subjumlah <> 0
		-- group by jenis_transaksi.kd_jenis 
		group by alat_bayar.keterangan 
		HAVING sum(penjualan.subjumlah) <> 0
		";

		$sql1 = mysqli_query($koneksi, $query);
		$tot_rekap_ppn = 0;
		$tot_rekap_subjumlah = 0;
		$tot_rekap_jumlah = 0;
		$tot_line = 0;

		while ($s1 = mysqli_fetch_array($sql1)) {
		?>

			<tr>
				<td width="200px"><?php echo $s1['jt_nama']; ?></td>
				<td align="right"><?php echo number_format($s1['count_jumlah']); ?></td>
				<!--<td align="right"><?php echo number_format($s1['pj_subjumlah']); ?></td>

				<td align="right"><?php echo number_format($s1['pj_ppn']); ?></td>-->
				<td align="right"><?php echo number_format($s1['pj_jumlah']); ?></td>
			</tr>

		<?php
			$tot_rekap_ppn = $tot_rekap_ppn + $s1['pj_ppn'];
			$tot_rekap_jumlah = $tot_rekap_jumlah + $s1['pj_jumlah'];

			$tot_line = $tot_line + $s1['count_jumlah'];
			$tot_rekap_subjumlah = $tot_rekap_subjumlah + $s1['pj_subjumlah'];
		}

		?>
	</tbody>
	<tr style="font-weight:600;font-size:110%">
		<td width="200px">Total Rekap </td>
		<td align="right"><?php echo number_format($tot_line); ?></td>
		<!--<td align="right"><?php echo number_format($tot_rekap_subjumlah); ?></td>

		<td align="right"><?php echo number_format($tot_rekap_ppn); ?></td>-->
		<td align="right"><?php echo number_format($tot_rekap_jumlah); ?></td>

	</tr>

</table>
<script>
	function navigateVoid(button) {
		var row = button.closest('tr');
		var tdValue = row.querySelector('td:nth-child(3)').textContent;
		const keteranganvoid = prompt("Masukan Keterangan VOID");
		if (keteranganvoid) {
			$.ajax({
				type: 'GET',
				url: 'route/lap_pb1/ajax_void.php?keteranganvoid=' + keteranganvoid + '&nomorfaktur=' + tdValue,
				dataType: 'json',
				success: function(response) {
					location.reload();
				},
				error: function(xhr, status, error) {
					console.log(xhr.responseText);
				}
			});
		}
	}

	function navigatePrintUlang(button) {
		var row = button.closest('tr');
		var tdValue = row.querySelector('td:nth-child(3)').textContent;
		window.location.href = 'route/lap_pb1/ajax_cetak.php?nomorfaktur=' + tdValue;
	}
</script>