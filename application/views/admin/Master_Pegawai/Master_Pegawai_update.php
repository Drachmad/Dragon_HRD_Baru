<style>
	#myInput {
		background-image: url('<?php echo base_url() ?>assets/img/search-icon-blue.png');
		background-position: 10px 12px;
		background-repeat: no-repeat;
		width: 100%;
		padding: 10px 20px 10px 40px;
		border: 1px solid #ddd;
		margin-bottom: 10px;
	}

	.pd-1 {
		padding: 1px;
	}

	#myTable {
		border-collapse: collapse;
		width: 100%;
		border: 1px solid #ddd;
	}

	#myTable th,
	#myTable td {
		text-align: left;
	}

	#myTable tr {
		border-bottom: 1px solid #ddd;
	}

	#myTable tr.header,
	#myTable tr:hover {
		background-color: #f1f1f1;
	}

	input[type=text]:focus {
		width: 100%;
	}

	table {
		table-layout: fixed;
	}

	table th,
	table td {
		overflow: hidden;
	}

	.table>thead>tr>th {
		background-color: #9c774c;
		top: 0;
		position: sticky !important;
		z-index: 999;
		text-align: center;
		color: black;
		font-weight: bold;
	}

	.rightJustified {
		text-align: right;
	}

	.total {
		font-weight: bold;
		color: blue;
	}

	.bodycontainer {
		width: 1280px;
		max-height: 300PX;
		margin: 0;
		overflow-y: auto;
	}

	.table-scrollable {
		margin: 0;
		padding: 0;
	}

	.modal-bodys {
		max-height: 250px;
		overflow-y: auto;
	}

	.label {
		font-weight: bold;
		color: black;
	}

	.label_header {
		font-weight: bold;
		color: black;
		text-align: center;
	}

	.text_input {
		color: black;
		text-transform: uppercase;
	}

	.number_input {
		color: black;
		text-align: right;
	}

	.number_total {
		font-weight: bold;
		color: black;
		text-align: right;
	}

	.btn_back {
		color: black;
	}

	.btn_back:hover {
		transition: 0.4s;
		color: white;
	}

	.btn_cancel {
		color: black;
	}

	.btn_cancel:hover {
		transition: 0.4s;
		color: white;
	}

	.btn_save {
		background-color: #1b8526;
		color: black;
	}

	.btn_save:hover {
		transition: 0.4s;
		color: white;
	}

	/* Style tab */
	.tab {
		overflow: hidden;
		border: 1px solid #ccc;
		background-color: #f1f1f1;
	}

	.tab button {
		background-color: inherit;
		float: left;
		border: none;
		outline: none;
		cursor: pointer;
		padding: 14px 16px;
		transition: 0.4s;
	}

	.tab button:hover {
		background-color: #9ae6ae;
		transition: 0.4s;
	}

	.tab button.active {
		background-color: #9c774c;
		color: white;
	}

	.tabcontent {
		display: none;
		padding: 6px 12px;
	}

	.alert-container {
		background-color: #9c774c;
		color: black;
		font-weight: bolder;
	}

	.num {
		color: black;
		text-align: right;
	}
</style>

<div class="container-fluid">
	<br>
	<div class="alert alert-success alert-container" role="alert">
		<i class="fas fa-university"></i> Input Master Pegawai
	</div>
	<div class="tab" style="width: max-content; justify-content: center">
		<button class="tablinks" onclick="bukaTab(event, 'MAIN')" id="defaultOpen">Main</button>
		<button class="tablinks" onclick="bukaTab(event, 'BAYAR')">Gaji</button>
		<!-- <button class="tablinks" onclick="bukaTab(event, 'BAGIAN')">Bagian</button> -->
	</div>
	<form id="master_pegawai" name="master_pegawai" action="<?php echo base_url('admin/Master_Pegawai/update_aksi'); ?>" class="form-horizontal needs-validation" method="post" novalidate>
		<br>
		<!-- TAB -->
		<div id="MAIN" class="tabcontent">
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-1">
						<label class="label">NIK</label>
					</div>
					<div class="col-md-3">
						<input type="hidden" id="NO_ID" name="NO_ID" class="form-control" value="<?= $NO_ID ?>">
						<input type="text" id="NIK" name="NIK" class="form-control text_input NIK" value="<?= $NIK ?>">
					</div>
					<div class="col-md-1">
						<label class="label">Nama Pegawai</label>
					</div>
					<div class="col-md-3">
						<input type="text" id="NM_PEG" name="NM_PEG" class="form-control text_input NM_PEG" value="<?= $NM_PEG ?>">
					</div>
					<div class="col-md-1">
						<label class="label">Kode Bagian</label>
					</div>
					<div class="col-md-3">
						<select class="js-example-responsive-kd_bag form-control KD_BAG text_input" name="KD_BAG" id="KD_BAG" onchange="kd_bag(this.id)">
							<option value="<?php echo $KD_BAG; ?>" selected id="KD_BAG"><?php echo $KD_BAG; ?></option>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-1">
						<label class="label">Nama Bagian</label>
					</div>
					<div class="col-md-3">
						<input type="text" id="NM_BAG" name="NM_BAG" class="form-control text_input NM_BAG" readonly value="<?= $NM_BAG ?>">
					</div>
					<div class="col-md-1">
						<label class="label">Status</label>
					</div>
					<div class="col-md-3">
						<select class="form-control AKTIF text_input" id="AKTIF" value="<? $AKTIF; ?>" style="width: 100%;" name="AKTIF">
							<?php if ($AKTIF == "1") {
								echo "<option value='1' selected>Aktif</option>";
								echo "<option value='0'>Tidak Aktif</option>";
							} else {
								echo "<option value='1'>Aktif</option>";
								echo "<option value='0' selected>Tidak Aktif</option>";
							}
							?>
						</select>
					</div>
					<div class="col-md-1">
						<label class="label">Jenis Kelamin</label>
					</div>
					<div class="col-md-3">
						<select class="form-control JK text_input" id="JK" value="<? $JK; ?>" style="width: 100%;" name="JK">
							<?php if ($JK == "L") {
								echo "<option value='L' selected>Laki-laki</option>";
								echo "<option value='P'>Perempuan</option>";
							} else {
								echo "<option value='L'>Laki-laki</option>";
								echo "<option value='P' selected>Perempuan</option>";
							}
							?>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-1">
						<label class="label">KPJ</label>
					</div>
					<div class="col-md-3">
						<input type="text" id="KPJ" name="KPJ" class="form-control text_input KPJ" value="<?= $KPJ ?>">
					</div>
					<div class="col-md-1">
						<label class="label">Alamat</label>
					</div>
					<div class="col-md-3">
						<textarea rows="4" cols="40" type="text" id="ALAMAT" class="text_area_style form-control text_input" name="ALAMAT">
							<?php echo $ALAMAT; ?>
						</textarea>
					</div>
					<div class="col-md-1">
						<label class="label">No Rek</label>
					</div>
					<div class="col-md-3">
						<input type="text" id="NO_REK" name="NO_REK" class="form-control text_input NO_REK" value="<?= $NO_REK ?>">
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-1">
						<label class="label">Kota</label>
					</div>
					<div class="col-md-3">
						<input type="text" id="KOTA" name="KOTA" class="form-control text_input KOTA" value="<?= $KOTA ?>">
					</div>
					<div class="col-md-1">
						<label class="label">Kabupaten</label>
					</div>
					<div class="col-md-3">
						<input type="text" id="KAB" name="KAB" class="form-control text_input KAB" value="<?= $KAB ?>">
					</div>
					<div class="col-md-1">
						<label class="label">Pendidikan</label>
					</div>
					<div class="col-md-3">
						<input type="text" id="PENDIDIKAN" name="PENDIDIKAN" class="form-control text_input PENDIDIKAN" value="<?= $PENDIDIKAN ?>">
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-1">
						<label class="label">Tgl Masuk</label>
					</div>
					<div class="col-md-3">
						<input type="text" class="date form-control text_input" id="TGL_MASUK" name="TGL_MASUK" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime($TGL_MASUK, TRUE)); ?>">
					</div>
					<div class="col-md-1">
						<label class="label">REC</label>
					</div>
					<div class="col-md-1">
						<input type="text" id="REC" name="REC" class="form-control text_input REC" value="<?php echo number_format($REC, 0, '.', ','); ?>">
					</div>
					<div class="col-md-1">
						<label class="label">PTKP</label>
					</div>
					<div class="col-md-1">
						<select class="form-control text_input PTKP" name="PTKP" id="PTKP" style="width: 100%;" value="<? $PTKP; ?>">
							<?php if ($PTKP == "TK/0") {
								echo "<option value='TK/0' selected>TK/0</option>";
								echo "<option value='K/0'>K/0</option>";
								echo "<option value='K/1'>K/1</option>";
								echo "<option value='K/2'>K/2</option>";
								echo "<option value='K/3'>K/3</option>";
								echo "<option value='K/I/0'>K/I/0</option>";
								echo "<option value='K/I/1'>K/I/1</option>";
								echo "<option value='K/I/2'>K/I/2</option>";
								echo "<option value='K/I/3'>K/I/3</option>";
								echo "<option value='-'>-</option>";
							}
							if ($PTKP == "K/0") {
								echo "<option value='TK/0'>TK/0</option>";
								echo "<option value='K/0' selected>K/0</option>";
								echo "<option value='K/1'>K/1</option>";
								echo "<option value='K/2'>K/2</option>";
								echo "<option value='K/3'>K/3</option>";
								echo "<option value='K/I/0'>K/I/0</option>";
								echo "<option value='K/I/1'>K/I/1</option>";
								echo "<option value='K/I/2'>K/I/2</option>";
								echo "<option value='K/I/3'>K/I/3</option>";
								echo "<option value='-'>-</option>";
							}
							if ($PTKP == "K/1") {
								echo "<option value='TK/0'>TK/0</option>";
								echo "<option value='K/0'>K/0</option>";
								echo "<option value='K/1' selected>K/1</option>";
								echo "<option value='K/2'>K/2</option>";
								echo "<option value='K/3'>K/3</option>";
								echo "<option value='K/I/0'>K/I/0</option>";
								echo "<option value='K/I/1'>K/I/1</option>";
								echo "<option value='K/I/2'>K/I/2</option>";
								echo "<option value='K/I/3'>K/I/3</option>";
								echo "<option value='-'>-</option>";
							}
							if ($PTKP == "K/2") {
								echo "<option value='TK/0'>TK/0</option>";
								echo "<option value='K/0'>K/0</option>";
								echo "<option value='K/1'>K/1</option>";
								echo "<option value='K/2' selected>K/2</option>";
								echo "<option value='K/3'>K/3</option>";
								echo "<option value='K/I/0'>K/I/0</option>";
								echo "<option value='K/I/1'>K/I/1</option>";
								echo "<option value='K/I/2'>K/I/2</option>";
								echo "<option value='K/I/3'>K/I/3</option>";
								echo "<option value='-'>-</option>";
							}
							if ($PTKP == "K/3") {
								echo "<option value='TK/0'>TK/0</option>";
								echo "<option value='K/0'>K/0</option>";
								echo "<option value='K/1'>K/1</option>";
								echo "<option value='K/2'>K/2</option>";
								echo "<option value='K/3' selected>K/3</option>";
								echo "<option value='K/I/0'>K/I/0</option>";
								echo "<option value='K/I/1'>K/I/1</option>";
								echo "<option value='K/I/2'>K/I/2</option>";
								echo "<option value='K/I/3'>K/I/3</option>";
								echo "<option value='-'>-</option>";
							}
							if ($PTKP == "K/I/0") {
								echo "<option value='TK/0'>TK/0</option>";
								echo "<option value='K/0'>K/0</option>";
								echo "<option value='K/1'>K/1</option>";
								echo "<option value='K/2'>K/2</option>";
								echo "<option value='K/3'>K/3</option>";
								echo "<option value='K/I/0' selected>K/I/0</option>";
								echo "<option value='K/I/1'>K/I/1</option>";
								echo "<option value='K/I/2'>K/I/2</option>";
								echo "<option value='K/I/3'>K/I/3</option>";
								echo "<option value='-'>-</option>";
							}
							if ($PTKP == "K/I/1") {
								echo "<option value='TK/0'>TK/0</option>";
								echo "<option value='K/0'>K/0</option>";
								echo "<option value='K/1'>K/1</option>";
								echo "<option value='K/2'>K/2</option>";
								echo "<option value='K/3'>K/3</option>";
								echo "<option value='K/I/0'>K/I/0</option>";
								echo "<option value='K/I/1' selected>K/I/1</option>";
								echo "<option value='K/I/2'>K/I/2</option>";
								echo "<option value='K/I/3'>K/I/3</option>";
								echo "<option value='-'>-</option>";
							}
							if ($PTKP == "K/I/2") {
								echo "<option value='TK/0'>TK/0</option>";
								echo "<option value='K/0'>K/0</option>";
								echo "<option value='K/1'>K/1</option>";
								echo "<option value='K/2'>K/2</option>";
								echo "<option value='K/3'>K/3</option>";
								echo "<option value='K/I/0'>K/I/0</option>";
								echo "<option value='K/I/1'>K/I/1</option>";
								echo "<option value='K/I/2' selected>K/I/2</option>";
								echo "<option value='K/I/3'>K/I/3</option>";
								echo "<option value='-'>-</option>";
							}
							if ($PTKP == "K/I/3") {
								echo "<option value='TK/0'>TK/0</option>";
								echo "<option value='K/0'>K/0</option>";
								echo "<option value='K/1'>K/1</option>";
								echo "<option value='K/2'>K/2</option>";
								echo "<option value='K/3'>K/3</option>";
								echo "<option value='K/I/0'>K/I/0</option>";
								echo "<option value='K/I/1'>K/I/1</option>";
								echo "<option value='K/I/2'>K/I/2</option>";
								echo "<option value='K/I/3' selected>K/I/3</option>";
								echo "<option value='-'>-</option>";
							}
							if ($PTKP == "-") {
								echo "<option value='TK/0'>TK/0</option>";
								echo "<option value='K/0'>K/0</option>";
								echo "<option value='K/1'>K/1</option>";
								echo "<option value='K/2'>K/2</option>";
								echo "<option value='K/3'>K/3</option>";
								echo "<option value='K/I/0'>K/I/0</option>";
								echo "<option value='K/I/1'>K/I/1</option>";
								echo "<option value='K/I/2'>K/I/2</option>";
								echo "<option value='K/I/3'>K/I/3</option>";
								echo "<option value='-' selected>-</option>";
							}
							?>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-1">
						<label class="label">Tgl Keluar</label>
					</div>
					<div class="col-md-3">
						<input type="text" class="date form-control text_input" id="TGL_KELUAR" name="TGL_KELUAR" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime($TGL_KELUAR, TRUE)); ?>">
					</div>
					<div class="col-md-1">
						<label class="label">Status Pegawai</label>
					</div>
					<div class="col-md-3 text_input">
						<select class="form-control text_input STATUS_PEGAWAI" name="STATUS_PEGAWAI" id="STATUS_PEGAWAI" style="width: 100%;" value="<? $STATUS_PEGAWAI; ?>">
							<option value=""></option>
							<?php if ($STATUS_PEGAWAI == "PEGAWAI HARIAN") {
								echo "<option value='PEGAWAI HARIAN' selected>PEGAWAI HARIAN</option>";
								echo "<option value='PEGAWAI BORONGAN'>PEGAWAI BORONGAN</option>";
								echo "<option value=''>-</option>";
							}
							if ($STATUS_PEGAWAI == "PEGAWAI BORONGAN") {
								echo "<option value='PEGAWAI HARIAN'>PEGAWAI HARIAN</option>";
								echo "<option value='PEGAWAI BORONGAN' selected>PEGAWAI BORONGAN</option>";
								echo "<option value=''>-</option>";
							}
							if ($STATUS_PEGAWAI == "") {
								echo "<option value='PEGAWAI HARIAN'>PEGAWAI HARIAN</option>";
								echo "<option value='PEGAWAI BORONGAN'>PEGAWAI BORONGAN</option>";
								echo "<option value='' selected>-</option>";
							}
							?>
						</select>
					</div>
					<div class="col-md-1">
						<label class="label">Stat</label>
					</div>
					<div class="col-md-1">
						<input type="text" id="STAT" name="STAT" class="form-control text_input STAT" value="<?= $STAT ?>">
					</div>
					<div class="col-md-1">
						<label class="label">PT</label>
					</div>
					<div class="col-md-1 text_input">
						<select class="form-control text_input PT" name="PT" id="PT" style="width: 100%;" value="<? $PT; ?>">
							<option value="1">PT</option>
							<option value="<?php echo number_format($POKOK, 0, '.', ','); ?>">CV</option>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-1">
						<label class="label">Tgl Lahir</label>
					</div>
					<div class="col-md-3">
						<input type="text" class="date form-control text_input" id="TGL_LAHIR" name="TGL_LAHIR" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime($TGL_LAHIR, TRUE)); ?>">
					</div>
					<div class="col-md-1">
						<label class="label">Email</label>
					</div>
					<div class="col-md-3">
						<input type="text" id="EMAIL" name="EMAIL" class="form-control text_input EMAIL" value="<?= $EMAIL ?>">
					</div>
					<div class="col-md-1">
						<label class="label">No HP</label>
					</div>
					<div class="col-md-3">
						<input type="text" id="HP" name="HP" class="form-control text_input HP" value="<?= $HP ?>">
					</div>
				</div>
			</div>
		</div>
		<div id="BAYAR" class="tabcontent">
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-1">
						<label class="label">Pokok</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="POKOK" name="POKOK" class="form-control number_input POKOK num" onkeyup="hitung()" value="<?php echo number_format($POKOK, 0, '.', ','); ?>">
					</div>
					<div class="col-md-1">
						<label class="label">U Makan</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="UMAKAN" name="UMAKAN" class="form-control number_input UMAKAN num" value="<?php echo number_format($UMAKAN, 0, '.', ','); ?>">
					</div>
					<div class="col-md-1">
						<label class="label">T Jabatan</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="TJABATAN" name="TJABATAN" class="form-control number_input TJABATAN num" onkeyup="hitung()" value="<?php echo number_format($TJABATAN, 0, '.', ','); ?>">
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-1">
						<label class="label">T Perbulan</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="TPERBULAN" name="TPERBULAN" class="form-control number_input TPERBULAN num" onkeyup="hitung()" value="<?php echo number_format($TPERBULAN, 0, '.', ','); ?>">
					</div>
					<div class="col-md-1">
						<label class="label">T Astek</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="TASTEK" name="TASTEK" class="form-control number_input TASTEK num" onkeyup="hitung()" value="<?php echo number_format($TASTEK, 0, '.', ','); ?>">
					</div>
					<div class="col-md-1">
						<label class="label">BPJS</label>
					</div>
					<div class="col-md-3">
						<input type="text" id="BPJS" name="BPJS" class="form-control text_input BPJS" value="<?php echo number_format($BPJS, 0, '.', ','); ?>">
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-1">
						<label class="label">PL</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="PREMI" name="PREMI" class="form-control number_input PREMI num" onkeyup="hitung()" value="<?php echo number_format($PREMI, 0, '.', ','); ?>">
					</div>
					<div class="col-md-1">
						<label class="label">LBL</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="LBL" name="LBL" class="form-control number_input LBL num" onkeyup="hitung()" value="<?php echo number_format($LBL, 0, '.', ','); ?>">
					</div>
					<div class="col-md-1">
						<label class="label">U Lembur</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="ULEMBUR" name="ULEMBUR" class="form-control number_input ULEMBUR num" value="<?php echo number_format($ULEMBUR, 0, '.', ','); ?>">
					</div>
				</div>
			</div>
			<hr>
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-1">
						<label class="label">Gaji</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="GAJI" name="GAJI" class="form-control number_input GAJI num" value="<?php echo number_format($GAJI, 0, '.', ','); ?>" readonly>
					</div>
					<div class="col-md-1">
						<label class="label">Nett</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="NETT" name="NETT" class="form-control number_input NETT num" value="<?php echo number_format($NETT, 0, '.', ','); ?>" readonly>
					</div>
				</div>
			</div>
			<br><br><br><br><br>
		</div>
		<!-- <div id="BAGIAN" class="tabcontent">
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-2">
						<label class="label">Kode Bagian 2</label>
					</div>
					<div class="col-md-3">
						<select class="js-example-responsive-kd_bag_2 form-control text_input KD_BAG_2" name="KD_BAG_2" id="KD_BAG_2" onchange="kd_bag_2(this.id)"></select>
					</div>
					<div class="col-md-2">
						<label class="label">Nama Bagian 2</label>
					</div>
					<div class="col-md-3">
						<input type="text" id="NM_BAG_2" name="NM_BAG_2" class="form-control text_input NM_BAG_2">
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-2">
						<label class="label">Kode Bagian 3</label>
					</div>
					<div class="col-md-3">
						<input type="text" id="KD_BAG_3" name="KD_BAG_3" class="form-control text_input KD_BAG_3">
					</div>
					<div class="col-md-2">
						<label class="label">Nama Bagian 3</label>
					</div>
					<div class="col-md-3">
						<input type="text" id="NM_BAG_3" name="NM_BAG_3" class="form-control text_input NM_BAG_3">
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-2">
						<label class="label">Kode Bagian 4</label>
					</div>
					<div class="col-md-3">
						<input type="text" id="KD_BAG_4" name="KD_BAG_4" class="form-control text_input KD_BAG_4" required>
					</div>
					<div class="col-md-2">
						<label class="label">Nama Bagian 4</label>
					</div>
					<div class="col-md-3">
						<input type="text" id="NM_BAG_4" name="NM_BAG_4" class="form-control text_input NM_BAG_4">
					</div>
				</div>
			</div>
			<br><br><br><br><br><br><br><br><br>
		</div>
		<br><br> -->
		<div class="row">
			<div class="col-xs-9">
				<div class="wells">
					<div class="btn-group">
						<button type="submit" class="btn btn_save"><i class="fa fa-save"></i> Save</button>
						<a type="button" href="<?php echo base_url('admin/Master_Pegawai/index_Master_Pegawai') ?>" class="btn btn-danger btn_cancel">Cancel</a>
					</div>
					<h4>
						<span id="error" style="display:none; color:#F00">Terjadi Kesalahan... </span>
						<span id="success" style="display:none; color:#0C0">Data sudah disimpan...</span>
					</h4>
				</div>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#example').DataTable({
			dom: "<'row'<'col-md-6'><'col-md-6'>>" + // 
				"<'row'<'col-md-6'f><'col-md-6'l>>" + // peletakan entries, search, dan test_btn
				"<'row'<'col-md-12't>><'row'<'col-md-12'ip>>", // peletakan show dan halaman
			buttons: [
				'copy', 'csv', 'excel', 'pdf', 'print'
			],
			order: true,
		});
	});
</script>

<script>
	(function() {
		'use strict';
		window.addEventListener('load', function() {
			// Fetch all the forms we want to apply custom Bootstrap validation styles to
			var forms = document.getElementsByClassName('needs-validation');
			// Loop over them and prevent submission
			var validation = Array.prototype.filter.call(forms, function(form) {
				form.addEventListener('submit', function(event) {
					if (form.checkValidity() === false) {
						event.preventDefault();
						event.stopPropagation();
					} else {
						$(this).submit(function() {
							return false;
						});
					}
					form.classList.add('was-validated');
				}, false);
			});
		}, false);
	})();

	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}

	function fnum() {
		$(".num").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMax: '999999999999.99',
			vMin: '-999999999999.99'
		});
		$('.num').autoNumeric('update');
	};

	$(document).ready(function() {
		fnum();
		$('body').on('keyup', 'input.num', function() {
			if (event.which != 190) {
				if (event.which >= 37 && event.which <= 40) return;
			}
			this.value = this.value.replace(/(?!^-)[^0-9.]/g, "").replace(/(\..*)\./g, '$1').replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			hitung();
		});
		$(".date").datepicker({
			'dateFormat': 'dd-mm-yy',
		});
	});

	function hitung() {
		var pokok = parseFloat($('#POKOK').val().replace(/,/g, ''));
		var umakan = parseFloat($('#UMAKAN').val().replace(/,/g, ''));
		var tjabatan = parseFloat($('#TJABATAN').val().replace(/,/g, ''));
		var tperbulan = parseFloat($('#TPERBULAN').val().replace(/,/g, ''));
		var tastek = parseFloat($('#TASTEK').val().replace(/,/g, ''));
		var premi = parseFloat($('#PREMI').val().replace(/,/g, ''));
		var lbl = parseFloat($('#LBL').val().replace(/,/g, ''));
		var ulembur = parseFloat($('#ULEMBUR').val().replace(/,/g, ''));
		var nett = parseFloat($('#NETT').val().replace(/,/g, ''));

		var gaji = pokok + umakan + tjabatan;
		if (isNaN(gaji)) gaji = 0;
		$('#GAJI').val(numberWithCommas(gaji));
		$("#GAJI").autoNumeric('update');

		var nett = gaji + tperbulan + tastek + premi + lbl;
		if (isNaN(nett)) nett = 0;
		$('#NETT').val(numberWithCommas(nett));
		$("#NETT").autoNumeric('update');
	}
</script>

<script>
	function bukaTab(evt, cityName) {
		var i, tabcontent, tablinks;
		tabcontent = document.getElementsByClassName("tabcontent");
		for (i = 0; i < tabcontent.length; i++) {
			tabcontent[i].style.display = "none";
		}
		tablinks = document.getElementsByClassName("tablinks");
		for (i = 0; i < tablinks.length; i++) {
			tablinks[i].className = tablinks[i].className.replace(" active", "");
		}
		document.getElementById(cityName).style.display = "block";
		evt.currentTarget.className += " active";
	}
	// Get the element with id="defaultOpen" and click on it
	document.getElementById("defaultOpen").click();
</script>

<script>
	$(document).ready(function() {
		select_kd_bag();
	});

	function select_kd_bag() {
		$('.js-example-responsive-kd_bag').select2({
			ajax: {
				url: "<?= base_url('admin/Master_Pegawai/getDataAjax_Bagian') ?>",
				dataType: "json",
				type: "post",
				delay: 10,
				data: function(params) {
					return {
						search: params.term,
						page: params.page
					}
				},
				processResults: function(data, params) {
					params.page = params.page || 1;
					return {
						results: data.items,
						pagination: {
							more: data.total_count
						}
					};
				},
				cache: true
			},
			placeholder: 'Pilih Bagian',
			minimumInputLength: 0,
			templateResult: format_kd_bag,
			templateSelection: formatSelection_kd_bag
		});
	}

	function format_kd_bag(repo_kd_bag) {
		if (repo_kd_bag.loading) {
			return repo_kd_bag.text;
		}
		var $container = $(
			"<div class='select2-result-repository clearfix text_input'>" +
			"<div class='select2-result-repository__title text_input'></div>" +
			"</div>"
		);
		$container.find(".select2-result-repository__title").text(repo_kd_bag.kd_bag);
		return $container;
	}
	var nm_bag = '';

	function formatSelection_kd_bag(repo_kd_bag) {
		nm_bag = repo_kd_bag.nm_bag;
		return repo_kd_bag.text;
	}

	function kd_bag(x) {
		var q = x.substring(6, 10);
		$('#NM_BAG' + q).val(nm_bag);
		console.log(q);
	}
</script>