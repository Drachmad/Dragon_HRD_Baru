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
		table-layout: fixed !important;
	}

	table th {
		color: black;
		text-align: center;
	}

	table td {
		overflow: hidden;
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

	.label {
		color: black;
		font-weight: bold;
	}

	.text_input {
		font-size: small;
		color: black;
	}
</style>

<div class="container-fluid">
	<br>
	<div class="alert alert-success alert-container" role="alert">
		<i class="fas fa-university"></i> Input <?php echo $this->session->userdata['judul']; ?>
	</div>
	<form id="premijahit" name="premijahit" action="<?php echo base_url('admin/Transaksi_Premi_Jahit/input_aksi'); ?>" class="form-horizontal needs-validation" method="post" novalidate>
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
						<div class="col-md-1">
							<label class="label">Notes </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input NOTES" id="NOTES" name="NOTES" type="text" value=''>
						</div>
						<div class="col-md-1">
							<label class="label">Ms </label>
						</div>
						<div class="col-md-2">
							<input class="form-control MS rightJustified text-primary" id="MS" name="MS" type="text" value='0'>
						</div>
						<div class="col-md-1">
							<label class="label">KIK Grup </label>
						</div>
						<div class="col-md-2 input-group">
							<input name="KIK_GRUP" id="KIK_GRUP" maxlength="30" type="text" class="form-control KIK_GRUP text_input" onkeypress="return tabE(this,event)" readonly>
							<span class="input-group-btn">
								<a class="btn default" onfocusout="hitung()" id="0" data-target="#mymodal_kik_grup" data-toggle="modal" href="#lupkik_grup"><i class="fa fa-search"></i></a>
							</span>
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
								<th width="150px">Kode Bag</th>
								<th width="120px">Nama Bag</th>
								<th width="160px">Nett</th>
								<th width="75px">MS</th>
								<th width="100px">MS-QC</th>
								<th width="100px">Tambah</th>
								<th width="100px">OL</th>
								<th width="100px">Lunas BS</th>
								<th width="100px">Bon Baru</th>
								<th width="100px">Total</th>
								<th width="100px">Harian</th>
								<th width="100px">Sablon</th>
								<th width="100px">Jht Lemek</th>
								<th width="100px">Total NB</th>
								<th width="100px">BLA</th>
								<th width="100px">Cakra</th>
								<th width="100px">PT</th>
								<th width="50px"></th>
							</tr>
						</thead>
						<tbody id="show-data">
							<tr>
								<td><input name="REC[]" id="REC0" type="text" value="1" class="form-control REC text_input" onkeypress="return tabE(this,event)" readonly></td>
								<td>
									<div class="input-group">
										<input name="KD_BAG[]" id="KD_BAG0" type="text" class="form-control KD_BAG text_input" readonly>
										<span class="input-group-btn">
											<a class="btn default" id="0" data-target="#mymodal_bagian" data-toggle="modal" href="#lupKD_BAG" onfocusout="hitung()"><i class="fa fa-search"></i></a>
										</span>
									</div>
								</td>
								<td><input name="NM_BAG[]" id="NM_BAG0" type="text" class="form-control NM_BAG text_input" readonly></td>
								<td><input name="KIK_NETT[]" onkeyup="hitung()" value="0" id="KIK_NETT0" type="text" class="form-control KIK_NETT rightJustified text-primary" readonly></td>
								<td><input name="TMS[]" onclick="select()" onkeyup="hitung()" value="0" id="TMS0" type="text" class="form-control TMS rightJustified text-primary"></td>
								<td><input name="TMSQC[]" onclick="select()" onkeyup="hitung()" value="0" id="TMSQC0" type="text" class="form-control TMSQC rightJustified text-primary"></td>
								<td><input name="UPAH_TAMBAH[]" onkeyup="hitung()" value="0" id="UPAH_TAMBAH0" type="text" class="form-control UPAH_TAMBAH rightJustified text-primary"></td>
								<td><input name="OL[]" onclick="select()" onkeyup="hitung()" value="0" id="OL0" type="text" class="form-control OL rightJustified text-primary"></td>
								<td><input name="LUNAS_BS[]" onkeyup="hitung()" value="0" id="LUNAS_BS0" type="text" class="form-control LUNAS_BS rightJustified text-primary"></td>
								<td><input name="BON_BARU[]" onclick="select()" onkeyup="hitung()" value="0" id="BON_BARU0" type="text" class="form-control BON_BARU rightJustified text-primary"></td>
								<td>
									<!-- 15 background proses -->
									<input name="KASI[]" onkeyup="hitung()" value="0" id="KASI0" type="hidden" class="form-control KASI rightJustified text-primary" readonly>
									<input name="MAINT1[]" onkeyup="hitung()" value="0" id="MAINT10" type="hidden" class="form-control MAINT1 rightJustified text-primary" readonly>
									<input name="MAINT2[]" onkeyup="hitung()" value="0" id="MAINT20" type="hidden" class="form-control MAINT2 rightJustified text-primary" readonly>
									<input name="KABAG[]" onkeyup="hitung()" value="0" id="KABAG0" type="hidden" class="form-control KABAG rightJustified text-primary" readonly>
									<input name="QC1[]" onkeyup="hitung()" value="0" id="QC10" type="hidden" class="form-control QC1 rightJustified text-primary" readonly>
									<input name="ADMIN1[]" onkeyup="hitung()" value="0" id="ADMIN10" type="hidden" class="form-control ADMIN1 rightJustified text-primary" readonly>
									<input name="ADMIN2[]" onkeyup="hitung()" value="0" id="ADMIN20" type="hidden" class="form-control ADMIN2 rightJustified text-primary" readonly>
									<input name="WK_MANAG[]" onkeyup="hitung()" value="0" id="WK_MANAG0" type="hidden" class="form-control WK_MANAG rightJustified text-primary" readonly>
									<input name="KA_QC[]" onkeyup="hitung()" value="0" id="KA_QC0" type="hidden" class="form-control KA_QC rightJustified text-primary" readonly>
									<input name="WK_QC[]" onkeyup="hitung()" value="0" id="WK_QC0" type="hidden" class="form-control WK_QC rightJustified text-primary" readonly>
									<input name="ADM[]" onkeyup="hitung()" value="0" id="ADM0" type="hidden" class="form-control ADM rightJustified text-primary" readonly>
									<input name="MANAG[]" onkeyup="hitung()" value="0" id="MANAG0" type="hidden" class="form-control MANAG rightJustified text-primary" readonly>
									<input name="KAPROD[]" onkeyup="hitung()" value="0" id="KAPROD0" type="hidden" class="form-control KAPROD rightJustified text-primary" readonly>
									<input name="KAMAINT[]" onkeyup="hitung()" value="0" id="KAMAINT0" type="hidden" class="form-control KAMAINT rightJustified text-primary" readonly>
									<input name="KSMAINT[]" onkeyup="hitung()" value="0" id="KSMAINT0" type="hidden" class="form-control KSMAINT rightJustified text-primary" readonly>
									<input name="PREMI[]" onkeyup="hitung()" value="0" id="PREMI0" type="hidden" class="form-control PREMI rightJustified text-primary" readonly>
									<!-- batas 15 background proses -->
									<input name="TJUMLAH[]" onkeyup="hitung()" value="0" id="TJUMLAH0" type="text" class="form-control TJUMLAH rightJustified text-primary" readonly>
								</td>
								<td><input name="PELATIHAN[]" onclick="select()" onkeyup="hitung()" value="0" id="PELATIHAN0" type="text" class="form-control PELATIHAN rightJustified text-primary"></td>
								<td><input name="SABLON[]" onclick="select()" onkeyup="hitung()" value="0" id="SABLON0" type="text" class="form-control SABLON rightJustified text-primary"></td>
								<td><input name="JAHIT_LEMEK[]" onclick="select()" onkeyup="hitung()" value="0" id="JAHIT_LEMEK0" type="text" class="form-control JAHIT_LEMEK rightJustified text-primary"></td>
								<td><input name="TNB[]" onkeyup="hitung()" value="0" id="TNB0" type="text" class="form-control TNB rightJustified text-primary" readonly></td>
								<td><input name="BLA[]" onclick="select()" onkeyup="hitung()" value="0" id="BLA0" type="text" class="form-control BLA rightJustified text-primary" readonly></td>
								<td><input name="CAKRA[]" onclick="select()" onkeyup="hitung()" value="0" id="CAKRA0" type="text" class="form-control CAKRA rightJustified text-primary" readonly></td>
								<td><input name="NETTO[]" onclick="select()" onkeyup="hitung()" value="0" id="NETTO0" type="text" class="form-control NETTO rightJustified text-primary" readonly></td>

							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<br><br>
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

<!-- myModal KIK Grup-->
<div id="mymodal_kik_grup" class="modal fade" role="dialog">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" style="font-weight: bold; color: black;">Data KIK Grup</h4>
			</div>
			<div class="modal-body">
				<table class='table table-bordered' id='modal_kik_grup'>
					<thead>
						<th>Kik Grup</th>
					</thead>
					<tbody>
						<?php
						$per = $this->session->userdata['periode'];
						$dr = $this->session->userdata['dr'];
						$sql = "SELECT hrd_bag.kik_grup AS KIK_GRUP
							FROM hrd_bag 
							WHERE hrd_bag.dr='$dr' 
							AND kd_bag NOT IN (SELECT kd_bag FROM hrd_kik WHERE per='$per')
							GROUP BY hrd_bag.kik_grup
							ORDER BY kik_grup";
						$a = $this->db->query($sql)->result();
						foreach ($a as $b) {
						?>
							<tr>
								<td class='KGBVAL'><a href="#" class="select_kik_grup"><?php echo $b->KIK_GRUP; ?></a></td>
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
		$('#modal_kik_grup').DataTable({
			dom: "<'row'<'col-md-6'><'col-md-6'>>" + // 
				"<'row'<'col-md-6'f><'col-md-6'l>>" + // peletakan entries, search, dan test_btn
				"<'row'<'col-md-12't>><'row'<'col-md-12'ip>>", // peletakan show dan halaman
			buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
			order: true,
		});
		$('.modal-footer').on('click', '#close', function() {
			$('input[type=search]').val('').keyup(); // this line and next one clear the search dialog
		});
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

		$("#MS").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});

		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#KIK_NETT" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#UPAH_TAMBAH" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#OL" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#TMS" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#TMSQC" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#LAIN" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#PELATIHAN" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#SABLON" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#JAHIT_LEMEK" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#LUNAS_BS" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#BON_BARU" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#TJUMLAH" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#TNB" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#BLA" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#CAKRA" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#NETTO" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});

			// 15 background proses
			$("#KASI" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#MAINT1" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#MAINT2" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#KABAG" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#QC1" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#ADMIN1" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#ADMIN2" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#WK_MANAG" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#KA_QC" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#WK_QC" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#ADM" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#MANAG" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#KAPROD" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#KAMAINT" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#KSMAINT" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#PREMI" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
		}
		//MyModal KIK Grup
		$('#mymodal_kik_grup').on('show.bs.modal', function(e) {
			target = $(e.relatedTarget);
		});
		$('body').on('click', '.select_kik_grup', function() {
			var val = $(this).parents("tr").find(".KGBVAL").text();
			target.parents("div").find(".KIK_GRUP").val(val);
			$('#mymodal_kik_grup').modal('toggle');
			var kik_grup = $(this).parents("tr").find(".KGBVAL").text();
			$.ajax({
				type: 'get',
				url: '<?php echo base_url('index.php/admin/Transaksi_Premi_Jahit/filter_kik_grup'); ?>',
				data: {
					kik_grup: kik_grup
				},
				dataType: 'json',
				success: function(response) {
					// alert(response);
					var html = '';
					var i;
					for (i = 0; i < response.length; i++) {
						html += '<tr>' +
							'<td><input name="REC[]" id=REC' + i + ' type="text" class="form-control REC text_input" onkeypress="return tabE(this,event)" readonly value=' + (i + 1) + ' ></td>' +
							'<td><input name="KD_BAG[]" value="' + response[i].KD_BAG + '" id=KD_BAG' + i + ' type="text" class="form-control KD_BAG text_input" readonly></td>' +
							'<td><input name="NM_BAG[]" value="' + response[i].NM_BAG + '" id=NM_BAG' + i + ' type="text" class="form-control NM_BAG text_input" readonly></td>' +
							'<td><input name="KIK_NETT[]" onkeyup="hitung()" value="' + numberWithCommas(response[i].KIK_NETT) + '" id=KIK_NETT' + i + ' type="text" class="form-control KIK_NETT rightJustified text-primary" readonly></td>' +
							'<td><input name="TMS[]" onclick="select()" onkeyup="hitung()" value="28" id=TMS' + i + ' type="text" class="form-control TMS rightJustified text-primary"></td>' +
							'<td><input name="TMSQC[]" onclick="select()" onkeyup="hitung()" value="28" id=TMSQC' + i + ' type="text" class="form-control TMSQC rightJustified text-primary"></td>' +
							'<td><input name="UPAH_TAMBAH[]" onclick="select()" onkeyup="hitung()" value="0" id=UPAH_TAMBAH' + i + ' type="text" class="form-control UPAH_TAMBAH rightJustified text-primary"></td>' +
							'<td><input name="OL[]" onclick="select()" onkeyup="hitung()" id=OL' + i + ' value="0" type="text" class="form-control OL rightJustified text-primary"></td>' +
							'<td><input name="LUNAS_BS[]" onclick="select()" onkeyup="hitung()" id=LUNAS_BS' + i + ' value="0" type="text" class="form-control LUNAS_BS rightJustified text-primary"></td>' +
							'<td><input name="BON_BARU[]" onclick="select()" onkeyup="hitung()" value="0" id=BON_BARU' + i + ' type="text" class="form-control BON_BARU rightJustified text-primary"></td>' +
							'<td>' +
							'<input name="KASI[]" onkeyup="hitung()" value="0" id=KASI' + i + ' type="hidden" class="form-control KASI rightJustified text-primary" readonly>' +
							'<input name="MAINT1[]" onkeyup="hitung()" value="0" id=MAINT1' + i + ' type="hidden" class="form-control MAINT1 rightJustified text-primary" readonly>' +
							'<input name="MAINT2[]" onkeyup="hitung()" value="0" id=MAINT2' + i + ' type="hidden" class="form-control MAINT2 rightJustified text-primary" readonly>' +
							'<input name="KABAG[]" onkeyup="hitung()" value="0" id=KABAG' + i + ' type="hidden" class="form-control KABAG rightJustified text-primary" readonly>' +
							'<input name="QC1[]" onkeyup="hitung()" value="0" id=QC1' + i + ' type="hidden" class="form-control QC1 rightJustified text-primary" readonly>' +
							'<input name="ADMIN1[]" onkeyup="hitung()" value="0" id=ADMIN1' + i + ' type="hidden" class="form-control ADMIN1 rightJustified text-primary" readonly>' +
							'<input name="ADMIN2[]" onkeyup="hitung()" value="0" id=ADMIN2' + i + ' type="hidden" class="form-control ADMIN2 rightJustified text-primary" readonly>' +
							'<input name="WK_MANAG[]" onkeyup="hitung()" value="0" id=WK_MANAG' + i + ' type="hidden" class="form-control WK_MANAG rightJustified text-primary" readonly>' +
							'<input name="KA_QC[]" onkeyup="hitung()" value="0" id=KA_QC' + i + ' type="hidden" class="form-control KA_QC rightJustified text-primary" readonly>' +
							'<input name="WK_QC[]" onkeyup="hitung()" value="0" id=WK_QC' + i + ' type="hidden" class="form-control WK_QC rightJustified text-primary" readonly>' +
							'<input name="ADM[]" onkeyup="hitung()" value="0" id=ADM' + i + ' type="hidden" class="form-control ADM rightJustified text-primary" readonly>' +
							'<input name="MANAG[]" onkeyup="hitung()" value="0" id=MANAG' + i + ' type="hidden" class="form-control MANAG rightJustified text-primary" readonly>' +
							'<input name="KAPROD[]" onkeyup="hitung()" value="0" id=KAPROD' + i + ' type="hidden" class="form-control KAPROD rightJustified text-primary" readonly>' +
							'<input name="KAMAINT[]" onkeyup="hitung()" value="0" id=KAMAINT' + i + ' type="hidden" class="form-control KAMAINT rightJustified text-primary" readonly>' +
							'<input name="KSMAINT[]" onkeyup="hitung()" value="0" id=KSMAINT' + i + ' type="hidden" class="form-control KSMAINT rightJustified text-primary" readonly>' +
							'<input name="PREMI[]" onkeyup="hitung()" value="0" id=PREMI' + i + ' type="hidden" class="form-control PREMI rightJustified text-primary" readonly>' +
							'<input name="TJUMLAH[]" onkeyup="hitung()" value="0" id=TJUMLAH' + i + ' type="text" class="form-control TJUMLAH rightJustified text-primary" readonly>' +
							'</td>' +
							'<td><input name="PELATIHAN[]" onkeyup="hitung()" value="0" id=PELATIHAN' + i + ' type="text" class="form-control PELATIHAN rightJustified text-primary"></td>' +
							'<td><input name="SABLON[]" onkeyup="hitung()" value="0" id=SABLON' + i + ' type="text" class="form-control SABLON rightJustified text-primary"></td>' +
							'<td><input name="JAHIT_LEMEK[]" onclick="select()" onkeyup="hitung()" value="0" id=JAHIT_LEMEK' + i + ' type="text" class="form-control JAHIT_LEMEK rightJustified text-primary"></td>' +
							'<td><input name="TNB[]" onkeyup="hitung()" value="0" id=TNB' + i + ' type="text" class="form-control TNB rightJustified text-primary"></td>' +
							'<td><input name="BLA[]" onkeyup="hitung()" value="0" id=BLA' + i + ' type="text" class="form-control BLA rightJustified text-primary" readonly></td>' +
							'<td><input name="CAKRA[]" onkeyup="hitung()" value="0" id=CAKRA' + i + ' type="text" class="form-control CAKRA rightJustified text-primary" readonly></td>' +
							'<td><input name="NETTO[]" onkeyup="hitung()" value="0" id=NETTO' + i + ' type="text" class="form-control NETTO rightJustified text-primary" readonly></td>' +
							'</tr>';
					}
					idrow = i;
					$('#show-data').html(html);
					jumlahdata = 100;
					for (i = 0; i <= jumlahdata; i++) {
						$("#KIK_NETT" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#UPAH_TAMBAH" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#OL" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#TMS" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#TMSQC" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#LAIN" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#PELATIHAN" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#SABLON" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#JAHIT_LEMEK" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#LUNAS_BS" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#BON_BARU" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#TJUMLAH" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#TNB" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#BLA" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#CAKRA" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#NETTO" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});

						// 15 background proses
						$("#KASI" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#MAINT1" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#MAINT2" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#KABAG" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#QC1" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#ADMIN1" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#ADMIN2" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#WK_MANAG" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#KA_QC" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#WK_QC" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#ADM" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#MANAG" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#KAPROD" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#KAMAINT" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#KSMAINT" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#PREMI" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
					}
				}
			});
		});

	});

	function nomor() {
		var i = 1;
		$(".REC").each(function() {
			$(this).val(i++);
		});
		hitung();
	}

	function hitung() {
		var total_row = idrow;
		for (i = 0; i < total_row; i++) {
			var kik_nett = parseFloat($('#KIK_NETT' + i).val().replace(/,/g, ''));
			var tms = parseFloat($('#TMS' + i).val().replace(/,/g, ''));
			var tmsqc = parseFloat($('#TMSQC' + i).val().replace(/,/g, ''));
			var lain = parseFloat($('#UPAH_TAMBAH' + i).val().replace(/,/g, ''));
			var ol = parseFloat($('#OL' + i).val().replace(/,/g, ''));
			var lns_bs = parseFloat($('#LUNAS_BS' + i).val().replace(/,/g, ''));
			var bon = parseFloat($('#BON_BARU' + i).val().replace(/,/g, ''));
			var lain1 = parseFloat($('#PELATIHAN' + i).val().replace(/,/g, ''));
			var sablon = parseFloat($('#SABLON' + i).val().replace(/,/g, ''));
			var jht_lemek = parseFloat($('#JAHIT_LEMEK' + i).val().replace(/,/g, ''));
			var nbdr1 = parseFloat($('#TNB' + i).val().replace(/,/g, ''));

			var nm_bag = $('#NM_BAG' + i).val().substr(0, 15);

			var nbkas = (0.38 * tms).toFixed(2);
			// console.clear();
			console.log('Nama Bagian : ' + nm_bag);
			// console.log('TMs : '+tms);
			// console.log('NbKas : '+nbkas);

			var nbkab = (0.106 * tms).toFixed(2);
			// console.log('NbKab : '+nbkab);

			var nbmaint1 = (0.068 * tms).toFixed(2);
			// console.log('NbMaint 1 : '+nbmaint1);

			var nbmaint2 = (0.068 * tms).toFixed(2);
			// console.log('NbMaint 2 : '+nbmaint2);

			var nbqc1 = (0.36 * tmsqc).toFixed(2);
			// console.log('NbQc 1 : '+nbqc1);

			var nbqc2 = 0;
			var nbadmin1 = 0;

			var nbadm = (0.012 * tms).toFixed(2);
			// console.log('NbAdm : '+nbadm);

			var nbmanag = 0;

			var nbkaprod = (0.020 * tms).toFixed(2);
			// console.log('NbKaprod : '+nbkaprod);

			var nbkamaint = (0.010 * tms).toFixed(2);
			// console.log('NbKamaint : '+nbkamaint);

			var nbksmaint = (0.021 * tms).toFixed(2);
			// console.log('NbKsmaint : '+nbksmaint);

			if ($('#KD_BAG' + i).val() == '711.03.N') {
				var nbmaint2 = 0;
			}
			if ($('#KD_BAG' + i).val() == '711.03.T') {
				var nbmaint2 = 0;
			}

			var nbadmin = (0.017 * tms).toFixed(2);
			// console.log('NbAdmin : '+nbadmin);

			var wkmag = (0.020 * tms).toFixed(2);
			// console.log('WkMag : '+wkmag);

			var kaqc = (0.015 * tms).toFixed(2);
			// console.log('KaQc : '+kaqc);

			var wkqc = (0.012 * tms).toFixed(2);
			// console.log('WkQc : '+wkqc);

			// var tjumlah = (kik_nett+((bon-lns_bs)+ol+lain+sablon+jht_lemek)-lain1);
			var tjumlah = Math.ceil(kik_nett + ((bon - lns_bs) + ol + lain + sablon + jht_lemek) - lain1);
			$('#TJUMLAH' + i).val(numberWithCommas(tjumlah));
			$('#TJUMLAH' + i).autoNumeric('update');
			// console.log('TJumlah : '+tjumlah);
			// console.log('NbDr1 : '+nbdr1);

			var tot_nb = (
				Number(nbdr1) +
				Number(nbkab) +
				Number(nbkas) +
				Number(nbmaint1) +
				Number(nbmaint2) +
				Number(nbadm) +
				Number(nbmanag) +
				Number(nbkaprod) +
				Number(nbkamaint) +
				Number(nbksmaint) +
				Number(nbadmin) +
				Number(wkmag) +
				Number(kaqc) +
				Number(wkqc) +
				Number(nbqc1)
			).toFixed(2);
			// console.log('Tot_NB : '+tot_nb + ' - Nama Bagian : '+nm_bag);

			var hkas = (tjumlah / tot_nb).toFixed(2);
			// console.log('HKas : '+hkas);

			var kasi = hkas * nbkas;
			$('#KASI' + i).val(numberWithCommas(kasi));
			$('#KASI' + i).autoNumeric('update');
			// console.log('Kasi :'+kasi + ' - Nama Bagian : '+nm_bag);

			var maint1 = hkas * nbmaint1;
			$('#MAINT1' + i).val(numberWithCommas(maint1));
			$('#MAINT1' + i).autoNumeric('update');
			// console.log('Maint1 :'+maint1 + ' - Nama Bagian : '+nm_bag);

			var maint2 = hkas * nbmaint2;
			$('#MAINT2' + i).val(numberWithCommas(maint2));
			$('#MAINT2' + i).autoNumeric('update');
			// console.log('Maint2 :'+maint2 + ' - Nama Bagian : '+nm_bag);

			var kabag = hkas * nbkab;
			$('#KABAG' + i).val(numberWithCommas(kabag));
			$('#KABAG' + i).autoNumeric('update');
			// console.log('Kabag :'+kabag + ' - Nama Bagian : '+nm_bag);

			var qc1 = hkas * nbqc1;
			$('#QC1' + i).val(numberWithCommas(qc1));
			$('#QC1' + i).autoNumeric('update');
			// console.log('Qc1 :'+qc1 + ' - Nama Bagian : '+nm_bag);

			var admin1 = hkas * nbadmin;
			$('#ADMIN1' + i).val(numberWithCommas(admin1));
			$('#ADMIN1' + i).autoNumeric('update');
			// console.log('Admin1 :'+admin1 + ' - Nama Bagian : '+nm_bag);

			var admin2 = hkas * nbadmin1;
			$('#ADMIN2' + i).val(numberWithCommas(admin2));
			$('#ADMIN2' + i).autoNumeric('update');
			// console.log('Admin2 :'+admin2 + ' - Nama Bagian : '+nm_bag);

			var wk_manag = hkas * wkmag;
			$('#WK_MANAG' + i).val(numberWithCommas(wk_manag));
			$('#WK_MANAG' + i).autoNumeric('update');
			// console.log('WkManag :'+wk_manag + ' - Nama Bagian : '+nm_bag);

			var ka_qc = hkas * kaqc;
			$('#KA_QC' + i).val(numberWithCommas(ka_qc));
			$('#KA_QC' + i).autoNumeric('update');
			// console.log('KaQc :'+ka_qc + ' - Nama Bagian : '+nm_bag);

			var wk_qc = hkas * wkqc;
			$('#WK_QC' + i).val(numberWithCommas(wk_qc));
			$('#WK_QC' + i).autoNumeric('update');
			// console.log('WkQc :'+wk_qc + ' - Nama Bagian : '+nm_bag);

			var adm = hkas * nbadm;
			$('#ADM' + i).val(numberWithCommas(adm));
			$('#ADM' + i).autoNumeric('update');
			// console.log('Adm :'+adm + ' - Nama Bagian : '+nm_bag);

			var manag = hkas * nbmanag;
			$('#MANAG' + i).val(numberWithCommas(manag));
			$('#MANAG' + i).autoNumeric('update');
			// console.log('Manag :'+manag + ' - Nama Bagian : '+nm_bag);

			var kaprod = hkas * nbkaprod;
			$('#KAPROD' + i).val(numberWithCommas(kaprod));
			$('#KAPROD' + i).autoNumeric('update');
			// console.log('Kaprod :'+kaprod + ' - Nama Bagian : '+nm_bag);

			var kamaint = hkas * nbkamaint;
			$('#KAMAINT' + i).val(numberWithCommas(kamaint));
			$('#KAMAINT' + i).autoNumeric('update');
			// console.log('Kamaint :'+kamaint + ' - Nama Bagian : '+nm_bag);

			var ksmaint = hkas * nbksmaint;
			$('#KSMAINT' + i).val(numberWithCommas(ksmaint));
			$('#KSMAINT' + i).autoNumeric('update');
			// console.log('Ksmaint :'+ksmaint + ' - Nama Bagian : '+nm_bag);

			// wk_manag+ka_qc+wk_qc+kasi+admin1+maint1+maint2+kabag+qc1+ADM+manag+kaprod+kamaint+ksmaint

			// var premi = kasi+maint1+maint2+kabag+qc1+admin1+admin2+wk_manag+ka_qc+wk_qc+adm+manag+kaprod+kamaint+ksmaint;
			var premi = wk_manag + ka_qc + wk_qc + kasi + admin1 + maint1 + maint2 + kabag + qc1 + adm + manag + kaprod + kamaint + ksmaint;

			$('#PREMI' + i).val(numberWithCommas(premi));
			$('#PREMI' + i).autoNumeric('update');
			console.log('Premi :' + premi + ' - Nama Bagian : ' + nm_bag);
		};
	}
</script>