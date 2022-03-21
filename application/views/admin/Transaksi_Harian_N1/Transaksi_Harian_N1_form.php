<style>
	#myInput {
		background-image: url('<?php echo base_url() ?>assets/img/search-icon-blue.png');
		background-position: 10px 12px;
		background-repeat: no-repeat;
		width: 100%;
		padding: 12px 20px 12px 40px;
		border: 1px solid #ddd;
		margin-bottom: 12px;
	}

	#myTable {
		border-collapse: collapse;
		width: 100%;
		border: 1px solid #ddd;
	}

	#myTable th,
	#myTable td {
		text-align: left;
		padding: 5px;
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

	table th {
		color: black;
		text-align: center;
	}

	table td {
		overflow: hidden;
	}

	.label {
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

	.form-control {
		font-size: small;
	}

	.bodycontainer {
		/* width: 1000px; */
		max-height: 500px;
		margin: 0;
		overflow-y: auto;
	}

	#datatable td {
		padding: 2px !important;
		vertical-align: middle;
	}

	.table-scrollable {
		margin: 0;
		padding: 0;
	}

	.modal-bodys {
		max-height: 250px;
		overflow-y: auto;
	}

	.select2-dropdown {
		width: 500px !important;
	}

	.text_input {
		font-size: small;
		color: black;
	}

	.alert-container {
		background-color: #9c774c;
		color: black;
		font-weight: bolder;
	}
</style>

<div class="container-fluid">
	<br>
	<div class="alert alert-success alert-container" role="alert">
		<i class="fas fa-university"></i> Input <?php echo $this->session->userdata['judul']; ?>
	</div>
	<form id="transaksiharian" name="transaksiharian" action="<?php echo base_url('admin/Transaksi_Harian_N1/input_aksi'); ?>" class="form-horizontal needs-validation" method="post" novalidate>
		<div class="form-body">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">No Bukti </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input NO_BUKTI" id="NO_BUKTI" name="NO_BUKTI" type="text" value='' readonly>
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-1">
							<label class="label">Bagian </label>
						</div>
						<div class="col-md-2 input-group">
							<input name="KD_BAG" id="KD_BAG" maxlength="30" type="text" class="form-control KD_BAG text_input" onkeypress="return tabE(this,event)" readonly>
							<span class="input-group-btn">
								<a class="btn default" onfocusout="hitung()" id="0" data-target="#mymodal_bagian" data-toggle="modal" href="#lupbagian"><i class="fa fa-search"></i></a>
							</span>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input NM_BAG" id="NM_BAG" name="NM_BAG" type="text" readonly>
							<input class="form-control text_input KD_GRUP" id="KD_GRUP" name="KD_GRUP" type="hidden" readonly>
							<input class="form-control text_input NM_GRUP" id="NM_GRUP" name="NM_GRUP" type="hidden" readonly>
							<input class="form-control text_input DR" id="DR" name="DR" type="hidden" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Fase </label>
						</div>
						<div class="col-md-1">
							<select class="form-control text_input FASE" name="FASE" id="FASE" style="width: 100%;">
								<option value="1">1</option>
								<option value="2">2</option>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">Notes </label>
						</div>
						<div class="col-md-3">
							<input class="form-control text_input NOTES" id="NOTES" name="NOTES" type="text" value=''>
						</div>
						<div class="col-md-2">
							<label class="label"><label style="color: red;">*</label>Hitam = 2021, Merah =2022 </label>
						</div>
						<div class="col-md-2">
							<label class="label"><label style="color: red;">*</label>Status Admin Dragon <?php echo $this->session->userdata['dr']; ?> </label>
						</div>
						<div class="col-md-2">
							<label class="label"><label style="color: red;">*</label>
								<label>
									<?php
									if ($this->session->userdata['dr'] == 'I' && $this->session->userdata['pt'] == '1')
										echo 'PT';
									if ($this->session->userdata['dr'] == 'I' && $this->session->userdata['pt'] == '0')
										echo 'CV';
									if ($this->session->userdata['dr'] == 'II' && $this->session->userdata['pt'] == '1')
										echo 'PT';
									if ($this->session->userdata['dr'] == 'II' && $this->session->userdata['pt'] == '0')
										echo 'CV';
									if ($this->session->userdata['dr'] == 'III' && $this->session->userdata['pt'] == '1')
										echo 'PT';
									if ($this->session->userdata['dr'] == 'III' && $this->session->userdata['pt'] == '0')
										echo 'CV';
									if ($this->session->userdata['dr'] == 'PY' && $this->session->userdata['pt'] == '1')
										echo 'PT';
									if ($this->session->userdata['dr'] == 'PY' && $this->session->userdata['pt'] == '0')
										echo 'CV';
									if ($this->session->userdata['dr'] == 'AB' && $this->session->userdata['pt'] == '1')
										echo 'PT';
									if ($this->session->userdata['dr'] == 'AB' && $this->session->userdata['pt'] == '0')
										echo 'CV';
									if ($this->session->userdata['dr'] == 'N1' && $this->session->userdata['pt'] == '1')
										echo 'PT';
									if ($this->session->userdata['dr'] == 'N1' && $this->session->userdata['pt'] == '0')
										echo 'CV';
									?>
								</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive scrollable">
					<table id="datatable" class="table table-hoverx table-stripedx table-borderedx table-condensed table-scrollable">
						<thead>
							<tr>
								<th width="50px">No</th>
								<th width="100px">NIP</th>
								<th width="120px">Nama</th>
								<th width="50px">PT</th>
								<th width="50px">Ptkp</th>
								<th width="100px">Hr</th>
								<th width="110px" style="border-color: black;">Jam 1</th>
								<th width="110px" style="border-color: black;">Jam 2</th>
								<th width="115px" style="border-color: black;">Jam 1 Rp</th>
								<th width="100px" style="border-color: black;">Jam 2 Rp</th>
								<th width="110px" style="border-color: red;">Jam 1</th>
								<th width="110px" style="border-color: red;">Jam 2</th>
								<th width="115px" style="border-color: red;">Jam 1 Rp</th>
								<th width="100px" style="border-color: red;">Jam 2 Rp</th>
								<th width="100px">NK</th>
								<th width="100px">Keliling</th>
								<th width="100px">NO</th>
								<th width="100px">Overtime</th>
								<th width="100px">Lain</th>
								<th width="100px">Potong</th>
								<th width="100px">Insentif Bulan</th>
								<th width="100px">Jumlah</th>
								<th width="50px"></th>
							</tr>
						</thead>
						<tbody id="show-data">
							<tr>
								<td><input name="REC[]" id="REC0" type="text" value="1" class="form-control REC text_input" onkeypress="return tabE(this,event)" readonly></td>
								<td><input name="KD_PEG[]" id="KD_PEG0" type="text" class="form-control KD_PEG text_input" readonly></td>
								<td>
									<input name="GAJI[]" id="GAJI0" type="hidden" value="0" class="form-control GAJI rightJustified text-primary" readonly>
									<input name="NETT[]" id="NETT0" type="hidden" value="0" class="form-control NETT rightJustified text-primary" readonly>
									<input name="HARIAN[]" id="HARIAN0" type="hidden" value="0" class="form-control HARIAN rightJustified text-primary" readonly>
									<select class="js-example-responsive-nm_peg form-control NM_PEG0" name="NM_PEG[]" id="NM_PEG0" onchange="nm_peg(this.id)" onfocusout="hitung()"></select>
								</td>
								<td><input name="PT[]" id="PT0" type="text" class="form-control PT text_input" readonly></td>
								<td><input name="PTKP[]" id="PTKP0" type="text" class="form-control PTKP text_input" readonly></td>
								<td><input name="HR[]" onclick="select()" onchange="hitung()" value="0" id="HR0" type="text" class="form-control HR rightJustified text-primary"></td>
								<td><input name="JAM1THL[]" onclick="select()" onchange="hitung()" value="0" id="JAM1THL0" type="text" class="form-control JAM1THL rightJustified text-primary"></td>
								<td><input name="JAM2THL[]" onclick="select()" onchange="hitung()" value="0" id="JAM2THL0" type="text" class="form-control JAM2THL rightJustified text-primary"></td>
								<td><input name="JAM1RPTHL[]" onchange="hitung()" value="0" id="JAM1RPTHL0" type="text" class="form-control JAM1RPTHL rightJustified text-primary" readonly></td>
								<td><input name="JAM2RPTHL[]" onchange="hitung()" value="0" id="JAM2RPTHL0" type="text" class="form-control JAM2RPTHL rightJustified text-primary" readonly></td>
								<td><input name="JAM1[]" onclick="select()" onchange="hitung()" value="0" id="JAM10" type="text" class="form-control JAM1 rightJustified text-primary"></td>
								<td><input name="JAM2[]" onclick="select()" onchange="hitung()" value="0" id="JAM20" type="text" class="form-control JAM2 rightJustified text-primary"></td>
								<td><input name="JAM1RP[]" onchange="hitung()" value="0" id="JAM1RP0" type="text" class="form-control JAM1RP rightJustified text-primary" readonly></td>
								<td><input name="JAM2RP[]" onchange="hitung()" value="0" id="JAM2RP0" type="text" class="form-control JAM2RP rightJustified text-primary" readonly></td>
								<td><input name="NK[]" onclick="select()" onchange="hitung()" value="0" id="NK0" type="text" class="form-control NK rightJustified text-primary"></td>
								<td><input name="KELILING[]" onclick="select()" onchange="hitung()" value="0" id="KELILING0" type="text" class="form-control KELILING rightJustified text-primary"></td>
								<td><input name="NO[]" onclick="select()" onchange="hitung()" value="0" id="NO0" type="text" class="form-control NO rightJustified text-primary"></td>
								<td><input name="OVERTIME[]" onclick="select()" onchange="hitung()" value="0" id="OVERTIME0" type="text" class="form-control OVERTIME rightJustified text-primary"></td>
								<td><input name="LAIN[]" onclick="select()" onchange="hitung()" value="0" id="LAIN0" type="text" class="form-control LAIN rightJustified text-primary"></td>
								<td><input name="POT[]" onclick="select()" onchange="hitung()" value="0" id="POT0" type="text" class="form-control POT rightJustified text-danger"></td>
								<td><input name="TPERBULAN[]" onchange="hitung()" value="0" id="TPERBULAN0" type="text" class="form-control TPERBULAN rightJustified text-primary" readonly></td>
								<td><input name="JUMLAH[]" onchange="hitung()" value="0" id="JUMLAH0" type="text" class="form-control JUMLAH rightJustified text-primary" readonly></td>
								<td>
									<button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i>
									</button>
								</td>
							</tr>
						</tbody>
						<tfoot>
							<td></td>
							<td></td>
							<td></td>
							<td>
								<input type="hidden" class="form-control THARIAN rightJustified text-primary font-weight-bold" id="THARIAN" name="THARIAN" value="0" readonly>
							</td>
							<td></td>
							<td><input class="form-control T_HR rightJustified text-primary font-weight-bold" id="T_HR" name="T_HR" value="0" readonly></td>
							<td><input class="form-control TJAM1THL rightJustified text-primary font-weight-bold" id="TJAM1THL" name="TJAM1THL" value="0" readonly></td>
							<td><input class="form-control TJAM2THL rightJustified text-primary font-weight-bold" id="TJAM2THL" name="TJAM2THL" value="0" readonly></td>
							<td><input class="form-control TJAM1RPTHL rightJustified text-primary font-weight-bold" id="TJAM1RPTHL" name="TJAM1RPTHL" value="0" readonly></td>
							<td><input class="form-control TJAM2RPTHL rightJustified text-primary font-weight-bold" id="TJAM2RPTHL" name="TJAM2RPTHL" value="0" readonly></td>
							<td><input class="form-control TJAM1 rightJustified text-primary font-weight-bold" id="TJAM1" name="TJAM1" value="0" readonly></td>
							<td><input class="form-control TJAM2 rightJustified text-primary font-weight-bold" id="TJAM2" name="TJAM2" value="0" readonly></td>
							<td><input class="form-control TJAM1RP rightJustified text-primary font-weight-bold" id="TJAM1RP" name="TJAM1RP" value="0" readonly></td>
							<td><input class="form-control TJAM2RP rightJustified text-primary font-weight-bold" id="TJAM2RP" name="TJAM2RP" value="0" readonly></td>
							<td><input class="form-control TNK rightJustified text-primary font-weight-bold" id="TNK" name="TNK" value="0" readonly></td>
							<td><input class="form-control TKELILING rightJustified text-primary font-weight-bold" id="TKELILING" name="TKELILING" value="0" readonly></td>
							<td><input class="form-control TNO rightJustified text-primary font-weight-bold" id="TNO" name="TNO" value="0" readonly></td>
							<td><input class="form-control TOVERTIME rightJustified text-primary font-weight-bold" id="TOVERTIME" name="TOVERTIME" value="0" readonly></td>
							<td><input class="form-control TLAIN rightJustified text-primary font-weight-bold" id="TLAIN" name="TLAIN" value="0" readonly></td>
							<td></td>
							<td><input class="form-control T_TPERBULAN rightJustified text-primary font-weight-bold" id="T_TPERBULAN" name="T_TPERBULAN" value="0" readonly></td>
							<td><input class="form-control TJUMLAH rightJustified text-primary font-weight-bold" id="TJUMLAH" name="TJUMLAH" value="0" readonly></td>
							<td></td>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
		<br><br>
		<!--tab-->
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-1">
					<button type="button" onclick="tambah()" class="btn btn-sm btn-success"><i class="fas fa-plus fa-sm md-3"></i> </button>
				</div>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-xs-9">
				<div class="wells">
					<div class="btn-group cxx">
						<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
						<a type="button" href="javascript:javascript:history.go(-1)" class="btn btn-danger">Cancel</a>
					</div>
					<h4><span id="error" style="display:none; color:#F00">Terjadi Kesalahan... </span> <span id="success" style="display:none; color:#0C0">Savings.done...</span></h4>
				</div>
			</div>
		</div>
	</form>
</div>

<!-- myModal Bagian-->
<div id="mymodal_bagian" class="modal fade" role="dialog">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" style="font-weight: bold; color: black;">Data Bagian</h4>
			</div>
			<div class="modal-body">
				<table class='table table-bordered' id='modal_bagian'>
					<thead>
						<th>Kode Bagian</th>
						<th>Nama Bagian</th>
						<th>Nama Grup</th>
						<th>Kode Grup</th>
						<th>Dragon</th>
					</thead>
					<tbody>
						<?php
						$per = $this->session->userdata['periode'];
						$dr = $this->session->userdata['dr'];
						$sql = "SELECT hrd_bag.kd_bag AS KD_BAG, 
							hrd_bag.nm_bag AS NM_BAG, 
							hrd_bag.kd_grup AS KD_GRUP, 
							hrd_bag.nm_grup AS NM_GRUP,
							hrd_bag.dr AS DR
							FROM hrd_bag 
							WHERE hrd_bag.dr='$dr' 
							AND kd_bag NOT IN (SELECT kd_bag FROM hrd_absen WHERE per='$per')
							ORDER BY dr, kd_bag";
						$a = $this->db->query($sql)->result();
						foreach ($a as $b) {
						?>
							<tr>
								<td class='KBBVAL'><a href="#" class="select_kd_bag"><?php echo $b->KD_BAG; ?></a></td>
								<td class='NBBVAL text_input'><?php echo $b->NM_BAG; ?></td>
								<td class='KDBVAL text_input'><?php echo $b->KD_GRUP; ?></td>
								<td class='NGBVAL text_input'><?php echo $b->NM_GRUP; ?></td>
								<td class='DRBVAL text_input'><?php echo $b->DR; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" id="close">Close</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#modal_bagian').DataTable({
			dom: "<'row'<'col-md-6'><'col-md-6'>>" + // 
				"<'row'<'col-md-6'f><'col-md-6'l>>" + // peletakan entries, search, dan test_btn
				"<'row'<'col-md-12't>><'row'<'col-md-12'ip>>", // peletakan show dan halaman
			buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
			order: true,
		});
		// $('.modal-footer').on('click', '#close', function() {			 
		// 	$('input[type=search]').val('').keyup();  // this line and next one clear the search dialog
		// });
	});
</script>

<script>
	(function() {
		'use strict';
		window.addEventListener('load', function() {
			var forms = document.getElementsByClassName('needs-validation');
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
	var target;
	var idrow = 1;

	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
	$(document).ready(function() {
		$("#T_HR").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TJAM1THL").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TJAM2THL").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TJAM1RPTHL").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TJAM2RPTHL").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TJAM1").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TJAM2").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TJAM1RP").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TJAM2RP").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TLAIN").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#T_TPERBULAN").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TJUMLAH").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TPL_HR").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#THARIAN").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#GAJI" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#NETT" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#HARIAN" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#HR" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#JAM1THL" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#JAM2THL" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#JAM1RPTHL" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#JAM2RPTHL" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#JAM1" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#JAM2" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#JAM1RP" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#JAM2RP" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#LAIN" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#POT" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#TPERBULAN" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#JUMLAH" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
		}
		//MyModal Bagian
		$('#mymodal_bagian').on('show.bs.modal', function(e) {
			target = $(e.relatedTarget);
		});
		$('body').on('click', '.select_kd_bag', function() {
			var val = $(this).parents("tr").find(".KBBVAL").text();
			target.parents("div").find(".KD_BAG").val(val);
			var val = $(this).parents("tr").find(".NBBVAL").text();
			target.parents("div").find(".NM_BAG").val(val);
			var val = $(this).parents("tr").find(".KDBVAL").text();
			target.parents("div").find(".KD_GRUP").val(val);
			var val = $(this).parents("tr").find(".NGBVAL").text();
			target.parents("div").find(".NM_GRUP").val(val);
			var val = $(this).parents("tr").find(".DRBVAL").text();
			target.parents("div").find(".DR").val(val);
			$('#mymodal_bagian').modal('toggle');
			var kd_bag = $(this).parents("tr").find(".KBBVAL").text();
			$.ajax({
				type: 'get',
				url: '<?php echo base_url('index.php/admin/Transaksi_Harian_N1/filter_kd_bag'); ?>',
				data: {
					kd_bag: kd_bag
				},
				dataType: 'json',
				success: function(response) {
					// alert(response);
					var html = '';
					var i;
					for (i = 0; i < response.length; i++) {
						html += '<tr>' +
							'<td><input name="REC[]" id=REC' + i + ' type="text" class="form-control REC text_input" onkeypress="return tabE(this,event)" readonly value=' + (i + 1) + ' ></td>' +
							'<td><input name="KD_PEG[]" value="' + response[i].KD_PEG + '" id=KD_PEG' + i + ' type="text" class="form-control KD_PEG text_input" readonly></td>' +
							'<td>' +
							'<input name="NM_PEG[]" value="' + response[i].NM_PEG + '" id=NM_PEG' + i + ' type="text" class="form-control NM_PEG text_input" readonly>' +
							'<input name="GAJI[]" type="hidden" onkeyup="hitung()" value="' + numberWithCommas(response[i].GAJI) + '" id=GAJI' + i + ' readonly class="form-control GAJI rightJustified text-primary">' +
							'<input name="NETT[]" type="hidden" onkeyup="hitung()" value="' + numberWithCommas(response[i].NETT) + '" id=NETT' + i + ' readonly class="form-control NETT rightJustified text-primary">' +
							'<input name="HARIAN[]" type="hidden" onkeyup="hitung()" id=HARIAN' + i + ' value="0" class="form-control HARIAN rightJustified text-primary" readonly>' +
							'</td>' +
							'<td><input name="PT[]" value="' + response[i].PT + '" id=PT' + i + ' type="text" class="form-control PT text_input" readonly></td>' +
							'<td><input name="PTKP[]" value="' + response[i].PTKP + '" id=PTKP' + i + ' type="text" class="form-control PTKP text_input" readonly></td>' +
							'<td><input name="HR[]" onclick="select()" onkeyup="hitung()" value="' + numberWithCommas(response[i].HR) + '" id=HR' + i + ' type="text" class="form-control HR rightJustified text-primary"></td>' +
							'<td><input name="JAM1THL[]" onclick="select()" onkeyup="hitung()" value="0" id=JAM1THL' + i + ' type="text" class="form-control JAM1THL rightJustified text-primary"></td>' +
							'<td><input name="JAM2THL[]" onclick="select()" onkeyup="hitung()" value="0" id=JAM2THL' + i + ' type="text" class="form-control JAM2THL rightJustified text-primary"></td>' +
							'<td><input name="JAM1RPTHL[]" onkeyup="hitung()" id=JAM1RPTHL' + i + ' value="0" type="text" class="form-control JAM1RPTHL rightJustified text-primary" readonly></td>' +
							'<td><input name="JAM2RPTHL[]" onkeyup="hitung()" id=JAM2RPTHL' + i + ' value="0" type="text" class="form-control JAM2RPTHL rightJustified text-primary" readonly></td>' +
							'<td><input name="JAM1[]" onclick="select()" onkeyup="hitung()" value="0" id=JAM1' + i + ' type="text" class="form-control JAM1 rightJustified text-primary"></td>' +
							'<td><input name="JAM2[]" onclick="select()" onkeyup="hitung()" value="0" id=JAM2' + i + ' type="text" class="form-control JAM2 rightJustified text-primary"></td>' +
							'<td><input name="JAM1RP[]" onkeyup="hitung()" id=JAM1RP' + i + ' value="0" type="text" class="form-control JAM1RP rightJustified text-primary" readonly></td>' +
							'<td><input name="JAM2RP[]" onkeyup="hitung()" id=JAM2RP' + i + ' value="0" type="text" class="form-control JAM2RP rightJustified text-primary" readonly></td>' +
							'<td><input name="NK[]" onclick="select()" onkeyup="hitung()" value="0" id=NK' + i + ' type="text" class="form-control NK rightJustified text-primary"></td>' +
							'<td><input name="KELILING[]" onclick="select()" onkeyup="hitung()" value="0" id=KELILING' + i + ' type="text" class="form-control KELILING rightJustified text-primary"></td>' +
							'<td><input name="NO[]" onclick="select()" onkeyup="hitung()" value="0" id=NO' + i + ' type="text" class="form-control NO rightJustified text-primary"></td>' +
							'<td><input name="OVERTIME[]" onclick="select()" onkeyup="hitung()" value="0" id=OVERTIME' + i + ' type="text" class="form-control OVERTIME rightJustified text-primary"></td>' +
							'<td><input name="LAIN[]" onclick="select()" onkeyup="hitung()" value="0" id=LAIN' + i + ' type="text" class="form-control LAIN rightJustified text-primary"></td>' +
							'<td><input name="POT[]" onclick="select()" onkeyup="hitung()" value="0" id=POT' + i + ' type="text" class="form-control POT rightJustified text-danger"></td>' +
							'<td><input name="TPERBULAN[]" onkeyup="hitung()" value="' + numberWithCommas(response[i].TPERBULAN) + '" id=TPERBULAN' + i + ' type="text" class="form-control TPERBULAN rightJustified text-primary" readonly></td>' +
							'<td><input name="JUMLAH[]" onkeyup="hitung()" value="0" id=JUMLAH' + i + ' type="text" class="form-control JUMLAH rightJustified text-primary" readonly></td>' +
							'<td>' +
							'<button type="button" class="btn btn-sm btn-circle btn-outline-danger btn-delete" onclick=""> <i class="fa fa-fw fa-trash"></i> </button>' +
							'</tr>';
					}
					idrow = i;
					$('#show-data').html(html);
					jumlahdata = 100;
					for (i = 0; i <= jumlahdata; i++) {
						$("#GAJI" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#NETT" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#HARIAN" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#HR" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#JAM1THL" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#JAM2THL" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#JAM1RPTHL" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#JAM2RPTHL" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#JAM1" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#JAM2" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#JAM1RP" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#JAM2RP" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#LAIN" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#POT" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#TPERBULAN" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#JUMLAH" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
					}
				}
			});
		});
		$('body').on('click', '.btn-delete', function() {
			var val = $(this).parents("tr").remove();
			idrow--;
			nomor();
		});
		$(".date").datepicker({
			'dateFormat': 'dd-mm-yy',
		})
	});

	function nomor() {
		var i = 1;
		$(".REC").each(function() {
			$(this).val(i++);
		});
		hitung();
	}

	function hitung() {
		var T_HR = 0;
		var TJAM1 = 0;
		var TJAM2 = 0;
		var TJAM1RP = 0;
		var TJAM2RP = 0;
		var TLAIN = 0;
		var T_TPERBULAN = 0;
		var THARIAN = 0;
		var TJUMLAH = 0;
		var total_row = idrow;
		for (i = 0; i < total_row; i++) {
			var gaji = parseFloat($('#GAJI' + i).val().replace(/,/g, ''));
			var nett = parseFloat($('#NETT' + i).val().replace(/,/g, ''));
			var hr = parseFloat($('#HR' + i).val().replace(/,/g, ''));
			var jam1thl = parseFloat($('#JAM1THL' + i).val().replace(/,/g, ''));
			var jam2thl = parseFloat($('#JAM2THL' + i).val().replace(/,/g, ''));
			var jam1 = parseFloat($('#JAM1' + i).val().replace(/,/g, ''));
			var jam2 = parseFloat($('#JAM2' + i).val().replace(/,/g, ''));
			var lain = parseFloat($('#LAIN' + i).val().replace(/,/g, ''));
			var tperbulan = parseFloat($('#TPERBULAN' + i).val().replace(/,/g, ''));
			var pot = parseFloat($('#POT' + i).val().replace(/,/g, ''));

			var jam1rpthl = jam1thl * (104000 * 25 / 173 * 1.5);
			var jam1rpthl = Math.round(jam1rpthl);
			if (isNaN(jam1rpthl)) jam1rpthl = 0;
			$('#JAM1RPTHL' + i).val(numberWithCommas(jam1rpthl));
			$('#JAM1RPTHL' + i).autoNumeric('update');

			var jam2rpthl = jam2thl * (104000 * 25 / 173 * 2);
			var jam2rpthl = Math.round(jam2rpthl);
			if (isNaN(jam2rpthl)) jam2rpthl = 0;
			$('#JAM2RPTHL' + i).val(numberWithCommas(jam2rpthl));
			$('#JAM2RPTHL' + i).autoNumeric('update');

			// var jam1rp = jam1 * (gaji * 25 / 173 * 1.5);
			var jam1rp = jam1 * (106000 * 25 / 173 * 1.5);
			var jam1rp = Math.round(jam1rp);
			if (isNaN(jam1rp)) jam1rp = 0;
			$('#JAM1RP' + i).val(numberWithCommas(jam1rp));
			$('#JAM1RP' + i).autoNumeric('update');

			// var jam2rp = jam2 * (gaji * 25 / 173 * 2);
			var jam2rp = jam2 * (106000 * 25 / 173 * 2);
			var jam2rp = Math.round(jam2rp);
			if (isNaN(jam2rp)) jam2rp = 0;
			$('#JAM2RP' + i).val(numberWithCommas(jam2rp));
			$('#JAM2RP' + i).autoNumeric('update');

			var harian = (hr * nett) + lain;
			if (isNaN(harian)) harian = 0;
			$('#HARIAN' + i).val(numberWithCommas(harian));
			$('#HARIAN' + i).autoNumeric('update');
			// console.log(harian);

			var jumlah = harian + (jam1rp + jam2rp + jam1rpthl + jam2rpthl) - pot;
			jumlah = jumlah.toFixed(2);
			if (isNaN(jumlah)) jumlah = 0;
			$('#JUMLAH' + i).val(numberWithCommas(jumlah));
			$('#JUMLAH' + i).autoNumeric('update');
			//			console.log(jumlah);
		};
		$(".HR").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			T_HR += val;
		});
		$(".JAM1THL").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			TJAM1THL += val;
		});
		$(".JAM2THL").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			TJAM2THL += val;
		});
		$(".JAM1RPTHL").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			TJAM1RPTHL += val;
		});
		$(".JAM2RPTHL").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			TJAM2RPTHL += val;
		});
		$(".JAM1").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			TJAM1 += val;
		});
		$(".JAM2").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			TJAM2 += val;
		});
		$(".JAM1RP").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			TJAM1RP += val;
		});
		$(".JAM2RP").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			TJAM2RP += val;
		});
		$(".LAIN").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			TLAIN += val;
		});
		$(".TPERBULAN").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			T_TPERBULAN += val;
		});
		$(".HARIAN").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			THARIAN += val;
		});
		$(".JUMLAH").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			TJUMLAH += val;
		});

		if (isNaN(T_HR)) T_HR = 0;
		if (isNaN(TJAM1THL)) TJAM1THL = 0;
		if (isNaN(TJAM2THL)) TJAM2THL = 0;
		if (isNaN(TJAM1RPTHL)) TJAM1RPTHL = 0;
		if (isNaN(TJAM2RPTHL)) TJAM2RPTHL = 0;
		if (isNaN(TJAM1)) TJAM1 = 0;
		if (isNaN(TJAM2)) TJAM2 = 0;
		if (isNaN(TJAM1RP)) TJAM1RP = 0;
		if (isNaN(TJAM2RP)) TJAM2RP = 0;
		if (isNaN(TLAIN)) TLAIN = 0;
		if (isNaN(T_TPERBULAN)) T_TPERBULAN = 0;
		if (isNaN(THARIAN)) THARIAN = 0;
		if (isNaN(TJUMLAH)) TJUMLAH = 0;

		$('#T_HR').val(numberWithCommas(T_HR));
		$('#TJAM1THL').val(numberWithCommas(TJAM1THL));
		$('#TJAM2THL').val(numberWithCommas(TJAM2THL));
		$('#TJAM1RPTHL').val(numberWithCommas(TJAM1RPTHL));
		$('#TJAM2RPTHL').val(numberWithCommas(TJAM2RPTHL));
		$('#TJAM1').val(numberWithCommas(TJAM1));
		$('#TJAM2').val(numberWithCommas(TJAM2));
		$('#TJAM1RP').val(numberWithCommas(TJAM1RP));
		$('#TJAM2RP').val(numberWithCommas(TJAM2RP));
		$('#TLAIN').val(numberWithCommas(TLAIN));
		$('#T_TPERBULAN').val(numberWithCommas(T_TPERBULAN));
		$('#THARIAN').val(numberWithCommas(THARIAN));
		$('#TJUMLAH').val(numberWithCommas(TJUMLAH));

		$("#T_HR").autoNumeric('update');
		$('#TJAM1THL').autoNumeric('update');
		$('#TJAM2THL').autoNumeric('update');
		$('#TJAM1RPTHL').autoNumeric('update');
		$('#TJAM2RPTHL').autoNumeric('update');
		$('#TJAM1').autoNumeric('update');
		$('#TJAM2').autoNumeric('update');
		$('#TJAM1RP').autoNumeric('update');
		$('#TJAM2RP').autoNumeric('update');
		$('#TLAIN').autoNumeric('update');
		$('#T_TPERBULAN').autoNumeric('update');
		$('#THARIAN').autoNumeric('update');
		$('#TJUMLAH').autoNumeric('update');
	}

	function tambah() {

		var x = document.getElementById('datatable').insertRow(idrow + 1);
		var td1 = x.insertCell(0);
		var td2 = x.insertCell(1);
		var td3 = x.insertCell(2);
		var td4 = x.insertCell(3);
		var td5 = x.insertCell(4);
		var td6 = x.insertCell(5);
		var td7 = x.insertCell(6);
		var td8 = x.insertCell(7);
		var td9 = x.insertCell(8);
		var td10 = x.insertCell(9);
		var td11 = x.insertCell(10);
		var td12 = x.insertCell(11);
		var td13 = x.insertCell(12);
		var td14 = x.insertCell(13);
		var td15 = x.insertCell(14);
		var td16 = x.insertCell(15);
		var td17 = x.insertCell(16);
		var td18 = x.insertCell(17);
		var td19 = x.insertCell(18);

		var nm_peg0 = "<div class='input-group'><select class='js-example-responsive-nm_peg form-control NM_PEG' name='NM_PEG[]' id=NM_PEG" + idrow + " onchange='nm_peg(this.id)' onfocusout='hitung()'></select></div>";
		var nm_peg1 = "<input name='NETT[]' onclick='select()' onkeyup='hitung()' value='0' id=NETT" + idrow + " type='hidden' class='form-control NETT rightJustified text-primary'>";
		var nm_peg2 = "<input name='GAJI[]' onclick='select()' onkeyup='hitung()' value='0' id=GAJI" + idrow + " type='hidden' class='form-control GAJI rightJustified text-primary'>";
		var nm_peg3 = "<input name='HARIAN[]' onclick='select()' onkeyup='hitung()' value='0' id=HARIAN" + idrow + " type='hidden' class='form-control HARIAN rightJustified text-primary'>";

		var nm_peg = nm_peg0 + nm_peg1 + nm_peg2 + nm_peg3;

		td1.innerHTML = "<input name='REC[]' id=REC" + idrow + " type='text' class='REC form-control text_input' onkeypress='return tabE(this,event)' readonly>";
		td2.innerHTML = "<input name='KD_PEG[]' id=KD_PEG0" + idrow + " type='text' class='form-control KD_PEG text_input' readonly>";
		td3.innerHTML = nm_peg;
		td4.innerHTML = "<input name='PTKP[]' id=PTKP0" + idrow + " type='text' class='form-control PTKP text_input' readonly>";
		td5.innerHTML = "<input name='PTKP[]' id=PTKP0" + idrow + " type='text' class='form-control PTKP text_input' readonly>";
		td6.innerHTML = "<input name='HR[]' onclick='select()' onkeyup='hitung()' value='0' id=HR" + idrow + " type='text' class='form-control HR rightJustified text-primary'>";
		td7.innerHTML = "<input name='JAM1THL[]' onclick='select()' onkeyup='hitung()' value='0' id=JAM1THL" + idrow + " type='text' class='form-control JAM1THL rightJustified text-primary'>";
		td8.innerHTML = "<input name='JAM2THL[]' onclick='select()' onkeyup='hitung()' value='0' id=JAM2THL" + idrow + " type='text' class='form-control JAM2THL rightJustified text-primary'>";
		td9.innerHTML = "<input name='JAM1RPTHL[]' onclick='select()' onkeyup='hitung()' value='0' id=JAM1RPTHL" + idrow + " type='text' class='form-control JAM1RPTHL rightJustified text-primary' readonly>";
		td10.innerHTML = "<input name='JAM2RPTHL[]' onclick='select()' onkeyup='hitung()' value='0' id=JAM2RPTHL" + idrow + " type='text' class='form-control JAM2RPTHL rightJustified text-primary' readonly>";
		td11.innerHTML = "<input name='JAM1[]' onclick='select()' onkeyup='hitung()' value='0' id=JAM1" + idrow + " type='text' class='form-control JAM1 rightJustified text-primary'>";
		td12.innerHTML = "<input name='JAM2[]' onclick='select()' onkeyup='hitung()' value='0' id=JAM2" + idrow + " type='text' class='form-control JAM2 rightJustified text-primary'>";
		td13.innerHTML = "<input name='JAM1RP[]' onclick='select()' onkeyup='hitung()' value='0' id=JAM1RP" + idrow + " type='text' class='form-control JAM1RP rightJustified text-primary' readonly>";
		td14.innerHTML = "<input name='JAM2RP[]' onclick='select()' onkeyup='hitung()' value='0' id=JAM2RP" + idrow + " type='text' class='form-control JAM2RP rightJustified text-primary' readonly>";
		td15.innerHTML = "<input name='NK[]' onclick='select()' onkeyup='hitung()' value='0' id=NK" + idrow + " type='text' class='form-control NK rightJustified text-primary'>";
		td15.innerHTML = "<input name='KELILING[]' onclick='select()' onkeyup='hitung()' value='0' id=KELILING" + idrow + " type='text' class='form-control KELILING rightJustified text-primary'>";
		td15.innerHTML = "<input name='NO[]' onclick='select()' onkeyup='hitung()' value='0' id=NO" + idrow + " type='text' class='form-control NO rightJustified text-primary'>";
		td15.innerHTML = "<input name='OVERTIME[]' onclick='select()' onkeyup='hitung()' value='0' id=OVERTIME" + idrow + " type='text' class='form-control OVERTIME rightJustified text-primary'>";
		td15.innerHTML = "<input name='LAIN[]' onclick='select()' onkeyup='hitung()' value='0' id=LAIN" + idrow + " type='text' class='form-control LAIN rightJustified text-primary'>";
		td16.innerHTML = "<input name='POT[]' onclick='select()' onkeyup='hitung()' value='0' id=POT" + idrow + " type='text' class='form-control POT rightJustified text-danger'>";
		td17.innerHTML = "<input name='TPERBULAN[]' onclick='select()' onkeyup='hitung()' value='0' id=TPERBULAN" + idrow + " type='text' class='form-control TPERBULAN rightJustified text-primary' readonly>";
		td18.innerHTML = "<input name='JUMLAH[]' onclick='select()' onkeyup='hitung()' value='0' id=JUMLAH" + idrow + " type='text' class='form-control JUMLAH rightJustified text-primary' readonly>";
		td19.innerHTML = "<input type='hidden' value='0' name='NO_ID[]' id=NO_ID" + idrow + "  class='form-control'>" +
			" <button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>";
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#GAJI" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#NETT" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#HR" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#HARIAN" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#JAM1THL" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#JAM2THL" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#JAM1RPTHL" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#JAM2RPTHL" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#JAM1" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#JAM2" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#JAM1RP" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#JAM2RP" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#LAIN" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#POT" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#TPERBULAN" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#JUMLAH" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
		}
		idrow++;
		nomor();
		$(".ronly").on('keydown paste', function(e) {
			e.preventDefault();
			e.currentTarget.blur();
		});
		select_nm_peg();
		hitung();
	}

	function hapus() {
		if (idrow > 1) {
			var x = document.getElementById('datatable').deleteRow(idrow);
			idrow--;
			nomor();
		}
	}
</script>

<script>
	$(document).ready(function() {
		select_nm_peg();
	});

	function select_nm_peg() {
		$('.js-example-responsive-nm_peg').select2({
			ajax: {
				url: "<?= base_url('admin/Transaksi_Harian_N1/getDataAjax_Pegawai') ?>",
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
			placeholder: 'Pilih Pegawai',
			minimumInputLength: 0,
			templateResult: format_nm_peg,
			templateSelection: formatSelection_nm_peg
		});
	}

	function format_nm_peg(repo_nm_peg) {
		if (repo_nm_peg.loading) {
			return repo_nm_peg.text;
		}
		var $container = $(
			"<div class='select2-result-repository clearfix text_input'>" +
			"<div class='select2-result-repository__title text_input'></div>" +
			"</div>"
		);
		$container.find(".select2-result-repository__title").text(repo_nm_peg.nm_peg);
		return $container;
	}
	var gaji = '';
	var nett = '';
	var kd_peg = '';
	var tperbulan = '';
	var ptkp = '';
	var pt = '';

	function formatSelection_nm_peg(repo_nm_peg) {
		gaji = repo_nm_peg.gaji;
		nett = repo_nm_peg.nett;
		kd_peg = repo_nm_peg.kd_peg;
		tperbulan = repo_nm_peg.tperbulan;
		ptkp = repo_nm_peg.ptkp;
		pt = repo_nm_peg.pt;
		return repo_nm_peg.text;
	}

	function nm_peg(x) {
		var q = x.substring(6, 10);
		$('#GAJI' + q).val(gaji);
		$('#NETT' + q).val(nett);
		$('#KD_PEG' + q).val(kd_peg);
		$('#TPERBULAN' + q).val(tperbulan);
		$('#PTKP' + q).val(ptkp);
		$('#PT' + q).val(pt);
		console.clear();
		console.log('kd_peg : ' + kd_peg + '\n' + 'gaji : ' + gaji + '\n' + 'nett : ' + nett);
	}
</script>