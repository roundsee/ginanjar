<div class="box-body">
	<div class="table-responsive">

		<div style="margin:10px"></div>

		<table id="example" class="table table-bordered table-striped" style="width:600px">

			<thead style="background-color:  lightgray;" class="elevation-2">
				<tr>
					<th style="text-align:center;width: 30px;">No.</th>
					<th style="width: 400px;">Kode Barang</th>
					<th style="width: 400px;">Barang</th>
					<th style="text-align:right ;width:80px;">Qty</th>
					<th style="text-align: right;width: 100px;">Payment</th>
				</tr>
			</thead>
			<tbody>
				<?php

				$query = "SELECT 
				penjualan.tarif_pb1 as penjualan_tarif_pb1,
				sum(penjualan.jumlah) as rekap_jumlah, 
				sum(penjualan.ppn) as rekap_ppn, 
				sum(penjualan.byr_pocer) as rekap_pocer,
				sum(penjualan.subjumlah) as rekap_subjumlah
				FROM penjualan 
				join jenis_transaksi on jenis_transaksi.kd_jenis=penjualan.kd_aplikasi 
				join alat_bayar on alat_bayar.kd_alat=penjualan.kd_alatbayar 
				WHERE penjualan.tanggal>='$tgl_awal' AND penjualan.tanggal <= '$tgl_akhir' +interval 1 day AND penjualan.kd_cus='$nilai'
				";

				$sql = mysqli_query($koneksi, $query);
				$s1 = mysqli_fetch_array($sql);

				$tarif_pb1 = $s1['penjualan_tarif_pb1'];

				$grand_penjualan = $s1['rekap_jumlah'];
				$grand_pajak = $grand_penjualan * ($tarif_pb1 / 100);
				$grand_stlh_pajak = $grand_penjualan + $grand_pajak;
				$grand_ppn = $s1['rekap_ppn'];
				$grand_pocer = $s1['rekap_pocer'];

				$query = "SELECT barang.nama as brg_nama, jualdetil.kd_brg as kodebarang, sum(jualdetil.banyak*jualdetil.qty_satuan) as rekap_jualdetil_banyak
				, sum(jualdetil.jumlah) as rekap_jualdetil_jumlah, jualdetil.satuan,sum(jualdetil.diskon) as discount
				FROM penjualan
				join jualdetil on jualdetil.faktur=penjualan.faktur 
				join barang on barang.kd_brg=jualdetil.kd_brg 
				WHERE penjualan.tanggal>='$tgl_awal' AND penjualan.tanggal <= '$tgl_akhir' +interval 1 day AND penjualan.kd_cus='$nilai'
				GROUP By jualdetil.kd_brg
				HAVING sum(jualdetil.banyak * jualdetil.qty_satuan) > 0
				ORDER BY barang.nama
				";

				$sql1 = mysqli_query($koneksi, $query);
				$no = 1;
				$grand_diskon = 0;
				$tot_subjumlah = 0;
				$tot_ppn = 0;
				$tot_jumlah = 0;

				$tot_penjualan = 0;
				$tot_byr_tunai = 0;
				$tot_byr_non_tunai = 0;
				$tot_pocer = 0;

				$grand_jumlah = 0;
				$nilai_tunai_khusus = 0;

				while ($s1 = mysqli_fetch_array($sql1)) {

				?>
					<tr align="left">
						<td><?php echo $no; ?></td>
						<td><?php echo $s1['kodebarang']; ?></td>
						<td><?php echo $s1['brg_nama']; ?></td>
						<td style="text-align: right;"><?php echo number_format($s1['rekap_jualdetil_banyak']); ?></td>
						<td style="text-align: right;"><?php echo number_format($s1['rekap_jualdetil_jumlah']); ?></td>
					</tr>
				<?php
					$grand_diskon += $s1['discount'];

					$no++;
				}
				?>
			</tbody>
			<tfoot align="right">

				<?php


				$query2 = "SELECT 
				sum(penjualan.byr_tunai) as rekap_tunai
				FROM penjualan 
				WHERE penjualan.tanggal>='$tgl_awal' AND penjualan.tanggal <= '$tgl_akhir' +interval 1 day AND penjualan.kd_cus='$nilai' ";

				$sql2 = mysqli_fetch_array(mysqli_query($koneksi, $query2));

				$nilai_tunai_khusus = $sql2['rekap_tunai'];


				$query1 = "SELECT  
				alat_bayar.nama as ab_nama,
				penjualan.kd_alatbayar as p_alat_bayar, 
				sum(penjualan.byr_tunai) as rekap_tunai,
				sum(penjualan.byr_non_tunai) as rekap_non_tunai
				FROM penjualan
				join alat_bayar on alat_bayar.kd_alat=penjualan.kd_alatbayar 
				WHERE penjualan.tanggal>='$tgl_awal' AND penjualan.tanggal <= '$tgl_akhir' +interval 1 day AND penjualan.kd_cus='$nilai'
				GROUP By p_alat_bayar
				";

				$sql = mysqli_query($koneksi, $query1);


				$jumlah_tunai = 0;
				$jumlah_edc_bca = 0;
				$jumlah_edc_mandiri = 0;

				while ($qq1 = mysqli_fetch_array($sql)) {
					if ($qq1['ab_nama'] == 'TUNAI') {
				?>
						<tr>
							<td colspan="4"><?php echo $qq1['ab_nama']; ?></td>
							<td colspan="2" align="right"><?php echo number_format($nilai_tunai_khusus); ?></td>
						</tr>
					<?php
					} else {
					?>
						<tr>
							<td colspan="4"><?php echo $qq1['ab_nama']; ?></td>
							<td colspan="2" align="right"><?php echo number_format($qq1['rekap_non_tunai']); ?></td>
						</tr>

				<?php
					}
				}

				?>

				<!-- <tr>
					<td colspan="4">Total Voucher </td>
					<td colspan="2" align="right"><?php echo number_format($grand_pocer); ?></td>
				</tr>

				<tr>
					<td colspan="4">Total Jumlah </td>
					<td colspan="2" align="right" style="font-size:105%;font-weight:600"><?php echo number_format($grand_penjualan); ?></td>
				</tr>
				<tr>
					<td colspan="4">Total Pajak </td>
					<td colspan="2" align="right"><?php echo number_format($grand_ppn); ?></td>

				</tr> -->
				<tr>
					<td colspan="3">Total Jumlah </td>
					<td colspan="2" align="right" style="font-size:105%;font-weight:600"><?php echo number_format($grand_penjualan); ?></td>
				</tr>

				<tr>
					<td colspan="3">Total Diskon </td>
					<td colspan="2" align="right"><?php echo number_format($grand_diskon); ?></td>
				</tr>
				<tr>
					<td colspan="3">Total </td>
					<td colspan="2" align="right"><?php echo number_format($grand_penjualan + $grand_diskon); ?></td>

				</tr>
			</tfoot>

		</table>

		<table id="example" class="table table-bordered table-striped" style="width:600px">

			<thead style="background-color:  lightgray;" class="elevation-2">

			</thead>
			<tbody>

			</tbody>
			<tfoot>

				<!-- <tr>
					<td colspan="4">Total Voucher </td>
					<td colspan="2" align="right"><?php echo number_format($grand_pocer); ?></td>
				</tr>

				<tr>
					<td colspan="4">Total Jumlah </td>
					<td colspan="2" align="right" style="font-size:105%;font-weight:600"><?php echo number_format($grand_penjualan); ?></td>
				</tr>
				<tr>
					<td colspan="4">Total Pajak </td>
					<td colspan="2" align="right"><?php echo number_format($grand_ppn); ?></td>
				</tr> -->
				<tr>
					<td colspan="4">Total Jumlah </td>
					<td colspan="2" align="right" style="font-size:105%;font-weight:600"><?php echo number_format($grand_penjualan); ?></td>
				</tr>

				<tr>
					<td colspan="4">Total Diskon </td>
					<td colspan="2" align="right"> <?php echo number_format($grand_diskon); ?></td>
				</tr>
				<tr>
					<td colspan="4">Total </td>
					<td colspan="2" align="right"><?php echo number_format($grand_penjualan + $grand_diskon); ?></td>

				</tr>
			</tfoot>
		</table>
	</div><!-- /.box-body -->

</div><!-- /.box -->