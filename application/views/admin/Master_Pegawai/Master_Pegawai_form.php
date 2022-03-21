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
	<form id="master_pegawai" name="master_pegawai" action="<?php echo base_url('admin/Master_Pegawai/input_aksi'); ?>" class="form-horizontal needs-validation" method="post" novalidate>
		<br>
		<!-- TAB -->
		<div id="MAIN" class="tabcontent">
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-1">
						<label class="label">NIK</label>
					</div>
					<div class="col-md-3">
						<input type="text" id="NIK" name="NIK" class="form-control text_input NIK">
					</div>
					<div class="col-md-1">
						<label class="label">Nama Pegawai</label>
					</div>
					<div class="col-md-3">
						<input type="text" id="NM_PEG" name="NM_PEG" class="form-control text_input NM_PEG">
					</div>
					<div class="col-md-1">
						<label class="label">Status</label>
					</div>
					<div class="col-md-3">
						<select class="form-control text_input AKTIF" name="AKTIF" id="AKTIF" style="width: 100%;">
							<option value="1">Aktif</option>
							<option value="0">Tidak Aktif</option>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-1">
						<label class="label">Kode Bagian</label>
					</div>
					<div class="col-md-3">
						<select class="js-example-responsive-kd_bag form-control text_input KD_BAG" name="KD_BAG" id="KD_BAG" onchange="kd_bag(this.id)" required></select>
					</div>
					<div class="col-md-1">
						<label class="label"></label>
					</div>
					<div class="col-md-3">
						<input type="text" id="NM_BAG" name="NM_BAG" class="form-control text_input NM_BAG" readonly>
					</div>
					<div class="col-md-1">
						<label class="label">Jenis Kelamin</label>
					</div>
					<div class="col-md-3">
						<select class="form-control text_input JK" name="JK" id="JK" style="width: 100%;">
							<option value="L">Laki-laki</option>
							<option value="P">Perempuan</option>
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
						<input type="text" id="KPJ" name="KPJ" class="form-control text_input KPJ">
					</div>
					<div class="col-md-1">
						<label class="label">Alamat</label>
					</div>
					<div class="col-md-3">
						<textarea style="text-align: left;" rows="4" cols="40" id="ALAMAT" name="ALAMAT" class="form-control text_input ALAMAT">
						</textarea>
					</div>
					<div class="col-md-1">
						<label class="label">No Rek</label>
					</div>
					<div class="col-md-3">
						<input type="text" id="NO_REK" name="NO_REK" class="form-control text_input NO_REK">
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-1">
						<label class="label">Kota</label>
					</div>
					<div class="col-md-3">
						<input type="text" id="KOTA" name="KOTA" class="form-control text_input KOTA">
					</div>
					<div class="col-md-1">
						<label class="label">Kabupaten</label>
					</div>
					<div class="col-md-3">
						<input type="text" id="KAB" name="KAB" class="form-control text_input KAB">
					</div>
					<div class="col-md-1">
						<label class="label">Pendidikan</label>
					</div>
					<div class="col-md-3">
						<input type="text" id="PENDIDIKAN" name="PENDIDIKAN" class="form-control text_input PENDIDIKAN">
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group row">
					<!-- <div class="col-md-1">
						<label class="label">Agama</label>
					</div>
					<div class="col-md-3">
						<select class="form-control text_input AGAMA" name="AGAMA" id="AGAMA" style="width: 100%;" >
							<option value="ISLAM">Islam</option> 
							<option value="KRISTEN">Kristen</option>
							<option value="KATHOLIK">Katholik</option>
							<option value="HINDU">Hindu</option>
							<option value="BUDHA">Budha</option>
							<option value="KONGHUCU">Kong Hu Cu</option>
						</select>						                
					</div> -->
					<div class="col-md-1">
						<label class="label">Tgl Lahir</label>
					</div>
					<div class="col-md-3">
						<input type="text" id="TGL_LAHIR" name="TGL_LAHIR" class="date form-control text_input" data-date-format="dd-mm-yyyy" value="<?php if (isset($_POST["tampilkan"])) {
																																							echo $_POST["TGL_LAHIR"];
																																						} else echo date('d-m-Y'); ?>">
					</div>
					<!-- <div class="col-md-1">
						<label class="label">DR</label>
					</div>
					<div class="col-md-3">
						<select class="form-control text_input DR" name="DR" id="DR" style="width: 100%;" >
							<option value="I" selected>Dragon 1</option> 
							<option value="II">Dragon 2</option>
							<option value="III">Dragon 3</option>
							<option value="IV">Dragon 4</option>
							<option value="AB">AB</option>
							<option value="PY">PY</option>
							<option value="N1">N1</option>
						</select>
					</div> -->
					<div class="col-md-1">
						<label class="label">REC</label>
					</div>
					<div class="col-md-1">
						<input type="text" id="REC" name="REC" class="form-control text_input REC" value="0" readonly>
					</div>
					<div class="col-md-1">
						<label class="label">PTKP</label>
					</div>
					<div class="col-md-1">
						<select class="form-control text_input PTKP" name="PTKP" id="PTKP" style="width: 100%;">
							<option value="TK/0">TK/0</option>
							<option value="K/0">K/0</option>
							<option value="K/1">K/1</option>
							<option value="K/2">K/2</option>
							<option value="K/3">K/3</option>
							<option value="K/I/0">K/I/0</option>
							<option value="K/I/1">K/I/1</option>
							<option value="K/I/2">K/I/2</option>
							<option value="K/I/3">K/I/3</option>
							<option value="-">-</option>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-1">
						<label class="label">Tgl Masuk</label>
					</div>
					<div class="col-md-3">
						<input type="text" id="TGL_MASUK" name="TGL_MASUK" class="date form-control text_input" data-date-format="dd-mm-yyyy" value="<?php if (isset($_POST["tampilkan"])) {
																																							echo $_POST["TGL_MASUK"];
																																						} else echo date('d-m-Y'); ?>">
					</div>
					<div class="col-md-1">
						<label class="label">Status Pegawai</label>
					</div>
					<div class="col-md-1 text_input">
						<select class="form-control text_input STATUS_PEGAWAI" name="STATUS_PEGAWAI" id="STATUS_PEGAWAI" style="width: 100%;">
							<option class="text_input" value="A">A</option>
							<option class="text_input" value="A1">A1</option>
							<option class="text_input" value="A2">A2</option>
							<option class="text_input" value="B">B</option>
							<option class="text_input" value="B1">B1</option>
							<option class="text_input" value="B2">B2</option>
							<option class="text_input" value="C">C</option>
							<option class="text_input" value="C1">C1</option>
							<option class="text_input" value="C2">C2</option>
							<option class="text_input" value="D">D</option>
							<option class="text_input" value="D1">D1</option>
							<option class="text_input" value="D2">D2</option>
						</select>
					</div>
					<div class="col-md-1">
						<label class="label">Stat</label>
					</div>
					<div class="col-md-3 text_input">
						<select class="form-control text_input STAT" name="STAT" id="STATUS_PEGAWAI" style="width: 100%;">
							<option value="PEGAWAI HARIAN">Pegawai Harian</option>
							<option value="PEGAWAI BORONGAN">Pegawai Borongan</option>
							<option value=""></option>
						</select>
					</div>
					<?php
					if ($this->session->userdata['dr'] == 'I') {
						echo '<div class="col-md-1">
							<label class="label">PT</label>
						</div>
						<div class="col-md-1 text_input">
						<select class="form-control text_input PT" name="PT" id="PT" style="width: 100%;">
							<option value="1">PT</option>
							<option value="0">CV</option>
						</select>
						</div>';
					}
					?>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-1">
						<label class="label">Tgl Keluar</label>
					</div>
					<div class="col-md-3">
						<input type="text" id="TGL_KELUAR" name="TGL_KELUAR" class="date form-control text_input" data-date-format="dd-mm-yyyy" value="<?php if (isset($_POST["tampilkan"])) {
																																							echo $_POST["TGL_KELUAR"];
																																						} else echo date('d-m-Y'); ?>">
					</div>
					<div class="col-md-1">
						<label class="label">Email</label>
					</div>
					<div class="col-md-3">
						<input type="text" id="EMAIL" name="EMAIL" class="form-control text_input EMAIL">
					</div>
					<div class="col-md-1">
						<label class="label">No HP</label>
					</div>
					<div class="col-md-3">
						<input type="text" id="HP" name="HP" class="form-control text_input HP">
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
						<input type="text" id="POKOK" name="POKOK" class="form-control number_input POKOK num" onkeyup="hitung()" value="0">
					</div>
					<div class="col-md-1">
						<label class="label">U Makan</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="UMAKAN" name="UMAKAN" class="form-control number_input UMAKAN num" value="0">
					</div>
					<div class="col-md-1">
						<label class="label">T Jabatan</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="TJABATAN" name="TJABATAN" class="form-control number_input TJABATAN num" onkeyup="hitung()" value="0">
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-1">
						<label class="label">T Perbulan</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="TPERBULAN" name="TPERBULAN" class="form-control number_input TPERBULAN num" value="0">
					</div>
					<div class="col-md-1">
						<label class="label">T Astek</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="TASTEK" name="TASTEK" class="form-control number_input TASTEK num" onkeyup="hitung()" value="0">
					</div>
					<div class="col-md-1">
						<label class="label">BPJS</label>
					</div>
					<div class="col-md-3">
						<input type="text" id="BPJS" name="BPJS" class="form-control BPJS number_input num" value="0">
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-1">
						<label class="label">PL</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="PREMI" name="PREMI" class="form-control number_input PREMI num" onkeyup="hitung()" value="0">
					</div>
					<div class="col-md-1">
						<label class="label">LBL</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="LBL" name="LBL" class="form-control number_input LBL num" onkeyup="hitung()" value="0">
					</div>
					<div class="col-md-1">
						<label class="label">U Lembur</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="ULEMBUR" name="ULEMBUR" class="form-control number_input ULEMBUR num" value="0">
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
						<input type="text" id="GAJI" name="GAJI" class="form-control number_input GAJI num" value="0" readonly>
					</div>
					<div class="col-md-1">
						<label class="label">Nett</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="NETT" name="NETT" class="form-control number_input NETT num" value="0" readonly>
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
		var tastek = parseFloat($('#TASTEK').val().replace(/,/g, ''));
		var premi = parseFloat($('#PREMI').val().replace(/,/g, ''));
		var lbl = parseFloat($('#LBL').val().replace(/,/g, ''));
		var ulembur = parseFloat($('#ULEMBUR').val().replace(/,/g, ''));
		var nett = parseFloat($('#NETT').val().replace(/,/g, ''));

		var gaji = pokok + umakan + tjabatan;
		if (isNaN(gaji)) gaji = 0;
		$('#GAJI').val(numberWithCommas(gaji));
		$("#GAJI").autoNumeric('update');

		var nett = gaji + tastek + premi + lbl;
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
			"<div class='select2-result-repository clearfix'>" +
			"<div class='select2-result-repository__title'></div>" +
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