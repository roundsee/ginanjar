<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cetak Purchase Order</title>
<?php
include"../../../config/koneksi.php";
include "../../../config/library.php";
include "../../../config/fungsi_indotgl.php";
include "../../../config/fungsi_rupiah.php";
	
	//orders trad
$cetak=mysqli_query($koneksi,"SELECT * from purchase where id_po='$_GET[id]'");
$r=mysqli_fetch_array($cetak);
//outlet
$cetak2=mysqli_query($koneksi,"SELECT * from supplier where id_supp='$r[id_supp]'");
$s=mysqli_fetch_array($cetak2);
//sales
// $jadwal=mysqli_query($koneksi,"select * from employee where employee_number='$r[employee_number]'");
// $j=mysqli_fetch_array($jadwal);

?>
<style>
table {
    border-collapse: collapse;
	font-family:Arial, Helvetica, sans-serif;
	font-size:11px;
}


</style>
</head>

<body>
<p align="center"><img src="../../../images/logokop.png" width="200px"/></p>
<p align="center" style="font-size:14px; font-family:Arial, Helvetica, sans-serif;"><b></b></p>

<table width="100%" border="0">
  <tr>
    <td width="80%">Jakarta, <?php echo tgl_indo(date('Y-m-d')); ?></td>
    <td><b>PT CDC</b></td>
  </tr>
  <tr>
    <td>Attn : <?php echo $s['nama_kontak']; ?></td>
    <td>Jalan Dewi Sartika No. 239A</td>
  </tr>
  <tr>
    <td></td>
    <td>Jakarta Timur 13630</td>
  </tr>

  <tr>
    <td><?php echo $s['nama_supp']; ?></td>
    <td>Indonesia</td>
  </tr>
  <tr>
    <td><?php echo $s['alamat_supp']; ?></td>
    <td>Tel  : +62 21 8013333</td>
  </tr>
  <tr>
    <td><?php echo $s['alamat2_supp']; ?></td>
    <td>Fax  : +62 21 8013434</td>
  </tr>
  <tr>
    <td><?php echo $s['telp_supp']; ?></td>
  </tr>
  <tr>
    <td><?php echo $s['fax_supp']; ?></td>
  </tr>
</table>

<br />
<legend><b><center>PURCHASE ORDER</center></b></legend>
<br/>
<table  width="100%">
  <tr>
    <td width="20%">No.PO : <?php echo $r['nopo']; ?></td>
    <td width="50%" align="right">PI </td>
    <td width="30%"><?php echo $r['pi']; ?></td>
  </tr>
</table>
<table width="100%" border="1px">

  <tr bgcolor="#FFFF00">
    <td align="center"><b>NO</b></td>
    <td align="center"><b>PRODUCT</b></td>
    <td align="center"><b>Packaging</b></td>
    <td align="center"><b>Qty</b></td>
    <td align="center"><b>PRICE (<?php echo $r['mata_uang']; ?>)</b></td>
    <td align="center"><b>AMOUNT (<?php echo $r['mata_uang']; ?>)</b></td>
  </tr>
  <?php
    $no = 1;
	$sql=mysqli_query($koneksi,"SELECT * from orders_request_import_detail where id_or='$_GET[id]'");
	$total=0;
	$diskon=0;
    $granqty=0;
    $granamount=0;
    $amount=0;
  while($s=mysqli_fetch_array($sql))
  {

    $amount=$s['harga_or']*$s['qty_or'];
    $granqty=$granqty+$s['qty_or'];
    $granamount=$granamount+$amount;
    $prd=mysqli_query($koneksi,"select * from produk where id_produk='$s[id_produk]'");
    $t=mysqli_fetch_array($prd);
  	
    ?>
    <tr bgcolor="#FFFFFF">
      <td align="center"><?php echo $no; echo "<input type='hidden' name='id[$no]' value='$s[id_or]'"; ?></td>
      <td align="center"><?php echo $t['nama_produk']; ?></td>
      <td align="center"><?php echo $t['ukuran'].' '.$t['ukuran_isi'].' '.$t['satuan']; ?></td>
      <td align="center"><?php echo $s['qty_or']; ?></td>
      <td align="center"><?php echo $s['harga_or']; ?></td>
      <td align="center"><?php echo $amount; ?></td>
    </tr>
    <?php
    $no++;
  }
  ?>
  <tr>
    <td colspan="2" style="text-align: center;"><b>Total :</b></td>
    <td></td>
    <td align="center"><b><?php echo $granqty; ?></b></td>
    <td></td>
    <td align="center"><b><?php echo $granamount; ?></b></td>
  </tr>

</table>
<br />
<br />
<br />
<br />
<a style="font-size: 12px">
CFR JAKARTA<br/>
PAYMENT : <?php echo $r['payment']; ?><br>
BANK : <?php echo $r['bank']; ?><br/>
BANK ACCOUNT  : <?php echo $r['bank_acc']; ?><br/>
BRANCH <?php echo $r['branch']; ?><br/>
ACCOUNT NAME : <?php echo $r['acc_name']; ?><br/>
SWIFT : <?php echo $r['swift_code']; ?><br/>
ETA : <?php echo $r['eta']; ?><br/>
ETD :<?php echo $r['etd']; ?><br/>
<br/>
</a>

<table width="100%" align="center" >
  <tr align="center">
    <td style="width:20%">Ordered By,</td>
    <td style="width:60%" colspan="3">Checked By,</td>
    <td style="width:20%">Approved By,</td>
  </tr>

  <tr>
    <td>.</td>
  </tr><tr>
    <td>.</td>
  </tr><tr>
    <td>.</td>
  </tr><tr>
    <td>.</td>
  </tr><tr>
    <td>.</td>
  </tr>

  <tr  align="center">
  	<td><u>Lucyana Susanti</u><br />Purchasing</td>
    <td><u>Windy Putri Kirana</u><br/>Ops Manager & Purchasing Import</td>
    <td><u>Wediastuti</u><br/>Finance Manager</td>
    <td><u>Sarmudji</u><br/>Marketing Manager</td>
    <td><u>Abdullah Djafar</u><br/>President Director</td>
  </tr>
  <tr align="center">
  	<!-- <td style="width:25%">( <?php echo $r['manager']; ?> )</td>
    <td style="width:25%">( <?php echo $j['name_e']; ?> )</td> -->
  </tr>
</table>
<br/>
<br/>
<a style="font-size: 12px">
THIS PURCHASE ORDER IS NOT VALID AS PURCHASE AGREEMENT UNITIL. <br/>
PRFORMA INVOICE SIGNED AND STANPED TO CONFIRM THE ORDER
</a>
<p align="left"><img src="../../../images/logobawahalamat.png" height="100px"/></p>
</body>
</html>