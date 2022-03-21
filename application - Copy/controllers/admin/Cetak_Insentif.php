<!DOCTYPE html>
<html>
<head>
 <title>Panduancode Cetak laporan PDF Di PHP Dan MySQLi</title>
</head>
	<body>
	<style type="text/css">
	body{
	font-family: sans-serif;
	}
	table{
	margin: 20px auto;
	border-collapse: collapse;
	}
	table th,
	table td{
	border: 1px solid #3c3c3c;
	padding: 3px 8px;

	}
	a{
	background: blue;
	color: #fff;
	padding: 8px 10px;
	text-decoration: none;
	border-radius: 2px;
	}

		.tengah{
			text-align: center;
		}
	</style>
	<table>
	<tr>
	<th>No</th>
	<th>Nama Barang</th>
	<th>Lokasi Penyimpanan</th>
	<th>Jumlah Barang</th>
	<th>Kondisi Barang</th>

	</tr>
	<?php 
	// koneksi database
	$koneksi = mysqli_connect("localhost","root","","dragon");

	// menampilkan data pegawai
	$data = mysqli_query($koneksi,"SELECT nm_peg, kd_peg, nm_bag, kd_bag FROM hrd_peg");
	while($d = mysqli_fetch_array($data)){
	?>
	<tr>
	<td style='text-align: center;'><?php echo $d['id'] ?></td>
	<td><?php echo $d['nm_peg']; ?></td>
	<td><?php echo $d['kd_peg']; ?></td>
	<td><?php echo $d['nm_bag']; ?></td>
	<td><?php echo $d['kd_bag']; ?></td>
	</tr>
	<?php 
	}
	?>
		</table>
	<script>
	window.print();
	</script>
	</body>
</html>