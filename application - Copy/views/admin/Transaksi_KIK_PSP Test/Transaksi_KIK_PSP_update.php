<?php
	foreach ($kik_psp as $rowh) {};
?>

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
	#myTable td { text-align: left; padding: 5px; }
	#myTable tr { border-bottom: 1px solid #ddd; }
	#myTable tr.header,
	#myTable tr:hover { background-color: #f1f1f1; }
	input[type=text]:focus { width: 100%; }
	table {	table-layout: fixed; }
	table th {color: black; text-align: center;}
	table td { overflow: hidden; }
	.label {color: black; font-weight: bold;}
	.rightJustified { text-align: right; }
	.total { font-weight: bold; color: blue; }
	.form-control {font-size: small;}
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
	.table-scrollable {	margin: 0; padding: 0; }
	.modal-bodys { max-height: 250px; overflow-y: auto; }
	.select2-dropdown {	width: 500px !important; }
	.text_input {font-size: small; color: black;}
</style>

<div class="container-fluid">
	<div class="alert alert-success" role="alert">
		<i class="fas fa-university"></i> Edit <?= $this->session->userdata['judul']; ?>
	</div>
	<form id="kik_psp" action="<?= base_url('admin/Transaksi_KIK_PSP/update_aksi'); ?>" class="form-horizontal" method="post">
		<div class="form-body">
			<div class="row">
			<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">No Bukti </label>
						</div>
						<div class="col-md-2">
                            <input type="hidden" name="ID" class="form-control" value="<?php echo $rowh->ID ?>">
							<input class="form-control text_input NO_BUKTI" id="NO_BUKTI" name="NO_BUKTI" type="text" value="<?php echo $rowh->NO_BUKTI ?>" readonly>
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-1">
							<label class="label">Bagian </label>
						</div>
						<div class="col-md-2 input-group">
                            <input class="form-control text_input KD_BAG" id="KD_BAG" name="KD_BAG" type="text" value="<?php echo $rowh->KD_BAG ?>" readonly>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input NM_BAG" id="NM_BAG" name="NM_BAG" type="text" value="<?php echo $rowh->NM_BAG ?>" readonly>
							<input class="form-control text_input KD_GRUP" id="KD_GRUP" name="KD_GRUP" type="hidden" value="<?php echo $rowh->KD_GRUP ?>" readonly>
							<input class="form-control text_input NM_GRUP" id="NM_GRUP" name="NM_GRUP" type="hidden" value="<?php echo $rowh->NM_GRUP ?>" readonly>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input KIK_GRUP" id="KIK_GRUP" name="KIK_GRUP" type="text" value="<?php echo $rowh->KIK_GRUP ?>" readonly>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">Notes </label>
						</div>
						<div class="col-md-3">
							<input class="form-control text_input NOTES" id="NOTES" name="NOTES" type="text" value="<?php echo $rowh->NOTES ?>">
						</div>
						<div class="col-md-1">
							<label class="label">Periode </label>
						</div>
						<div class="col-md-1">
                            <input class="form-control text_input FASE" id="FASE" name="FASE" type="text" value="<?php echo $rowh->FASE ?>">
						</div>
						<div class="col-md-3">
							<input type="hidden" class="form-control UMR rightJustified text-primary font-weight-bold" id="UMR" name="UMR" value="" readonly>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive bodycontainer scrollable">
					<table id="datatable" class="table table-hoverx table-stripedx table-borderedx table-condensed table-scrollable">
						<thead>
							<tr>
								<th width="50px">No</th>
								<th width="150px">No KIK</th>
								<th width="100px">Tgl</th>
								<th width="130px">Model</th>
								<th width="80px">Item</th>
								<th width="80px">Des 1</th>
								<th width="100px">Qty</th>
								<th width="100px">Upah</th>
								<th width="100px">Jumlah</th>
								<th width="75px">ORG</th>
								<th width="75px">HR</th>
								<th width="50px"></th>
							</tr>
						</thead>
						<tbody id="detail">
							<?php
								$no = 0;
								foreach ($kik_psp as $row) : 
							?>
								<tr>
									<td><input name="REC[]" id="REC<?= $no; ?>" type="text" value="<?= $row->REC; ?>" class="form-control REC text_input" readonly></td>
									<td>
										<div class="input-group">
											<select class="js-example-responsive-no_kik form-control NO_KIK text_input" onchange='no_kik(this.id)' name="NO_KIK[]" id="NO_KIK<?= $no; ?>">
												<option value="<?= $row->NO_KIK; ?>" selected id="NO_KIK<?= $no; ?>"><?= $row->NO_KIK ?></option>
											</select>
										</div>
									</td>
									<td>
										<input 
											name="TGL_KIK[]" 
											id="TGL_KIK<?php echo $no; ?>"
											type="text" 
											class="date form-control text_input" 
											data-date-format="dd-mm-yyyy" 
											value="<?php echo date('d-m-Y', strtotime($row->TGL_KIK, TRUE)); ?>"
											onclick="select()" 
										>
									</td>
									<td>
										<div class="input-group">
											<select class="js-example-responsive-model form-control MODEL text_input" onchange='model(this.id)' name="MODEL[]" id="MODEL<?= $no; ?>">
												<option value="<?= $row->MODEL; ?>" selected id="MODEL<?= $no; ?>"><?= $row->MODEL ?></option>
											</select>
										</div>
									</td>
									<td><input name="ITEM[]" id="ITEM<?= $no; ?>" value="<?= $row->ITEM; ?>" type="text" class="form-control ITEM text_input" readonly></td>
									<td><input name="DES1[]" id="DES1<?= $no; ?>" value="<?= $row->DES1; ?>" type="text" class="form-control DES1 text_input" readonly></td>
									<td><input name="QTY[]" onclick="select()" onkeyup="hitung()" id="QTY<?php echo $no; ?>" value="<?php echo number_format($row->QTY, 2, '.', ','); ?>" type="text" class="form-control QTY rightJustified text-primary numinput"></td>
									<td><input name="UPAH[]" onkeyup="hitung()" id="UPAH<?php echo $no; ?>" value="<?php echo number_format($row->UPAH, 2, '.', ','); ?>" type="text" class="form-control UPAH rightJustified text-primary numinput" readonly></td>
									<td><input name="JUMLAH[]" onkeyup="hitung()" id="JUMLAH<?php echo $no; ?>" value="<?php echo number_format($row->JUMLAH, 2, '.', ','); ?>" type="text" class="form-control JUMLAH rightJustified text-primary numinput" readonly></td>
									<td><input name="ORG[]" onclick="select()" onkeyup="hitung()" id="ORG<?php echo $no; ?>" value="<?php echo number_format($row->ORG, 2, '.', ','); ?>" type="text" class="form-control ORG rightJustified text-primary numinput"></td>
									<td><input name="HR[]" onkeyup="hitung()" id="HR<?php echo $no; ?>" value="<?php echo number_format($row->HR, 2, '.', ','); ?>" type="text" class="form-control HR rightJustified text-primary numinput" readonly></td>
									<td>
										<input name="NO_ID[]" id="NO_ID<?php echo $no; ?>" value="<?= $row->NO_ID ?>" class="form-control" type="hidden">
										<button type="button" class="btn btn-sm btn-circle btn-outline-danger btn-delete" onclick="">
											<i class="fa fa-fw fa-trash-alt"></i>
										</button>
									</td>
								</tr>
								<?php $no++; ?>
							<?php endforeach; ?>
						</tbody>
						<tfoot>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td><input class="form-control TQTY rightJustified text-primary font-weight-bold numinput" id="TQTY" name="TQTY" value="<?php echo number_format($rowh->TQTY, 2, '.', ','); ?>" readonly></td>
							<td></td>
							<td><input class="form-control TJUMLAH rightJustified text-primary font-weight-bold numinput" id="TJUMLAH" name="TJUMLAH" value="<?php echo number_format($rowh->TJUMLAH, 2, '.', ','); ?>" readonly></td>
							<td></td>
							<td><input class="form-control T_HR rightJustified text-primary font-weight-bold numinput" id="T_HR" name="T_HR" value="<?php echo number_format($rowh->T_HR, 2, '.', ','); ?>" readonly></td>
							<td></td>
						</tfoot>
					</table>
				</div>
			</div>
			<div class="col-md-2 row">
				<button type="button" id="tambah" class="btn btn-sm btn-success"><i class="fas fa-plus fa-sm md-3"></i> </button>
			</div>
		</div>
		<!--tab-->
		<br>
		<!--tab-->
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-2 ">						
					<input type="hidden" class="form-control" readonly>
				</div>
				<div class="col-md-1 ">
					<label class="label">Pajak </label>
				</div>
				<div class="col-md-2 ">						
					<input class="form-control PPN rightJustified text-danger font-weight-bold" id="PPN" name="PPN" value="<?php echo number_format($rowh->PPN, 2, '.', ','); ?>" readonly>
				</div>
				<div class="col-md-1 ">
					<label class="label">Minuss </label>
				</div>
				<div class="col-md-2 ">						
					<input class="form-control MINUSS rightJustified text-danger font-weight-bold" id="MINUSS" name="MINUSS" value="<?php echo number_format($rowh->MINUSS, 2, '.', ','); ?>" readonly>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-5 ">						
					<input type="hidden" class="form-control" readonly>
					</div>
					<div class="col-md-1 ">
						<label class="label">Lunas BS</label>
					</div>
					<div class="col-md-2 ">
						<input class="form-control LUNAS_BS rightJustified text-primary font-weight-bold" onclick="select()" onkeyup="hitung()" id="LUNAS_BS" name="LUNAS_BS" value="<?php echo number_format($rowh->LUNAS_BS, 2, '.', ','); ?>">
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-5 ">						
						<input type="hidden" class="form-control" readonly>
					</div>
					<div class="col-md-1 ">
						<label class="label">Upah Tambah</label>
					</div>
					<div class="col-md-2 ">
						<input class="form-control UPAH_TAMBAH rightJustified text-primary font-weight-bold" onclick="select()" onkeyup="hitung()" id="UPAH_TAMBAH" name="UPAH_TAMBAH" value="<?php echo number_format($rowh->UPAH_TAMBAH, 2, '.', ','); ?>">
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-5 ">						
						<input type="hidden" class="form-control" readonly>
					</div>
					<div class="col-md-1 ">
						<label class="label">Gaji KIK Nett </label>
					</div>
					<div class="col-md-2 ">
                        <input class="form-control POT_BON rightJustified text-primary font-weight-bold" id="POT_BON" name="POT_BON" value="<?php echo number_format($rowh->POT_BON, 2, '.', ','); ?>" readonly>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-9">
				<div class="wells">
					<div class="btn-group">
						<button type="submit" class="btn btn-success simpan"><i class="fa fa-save"></i> Save</button>
						<a type="button" href="javascript:javascript:history.go(-1)" class="btn btn-danger">Cancel</a>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<script>

	$(document).ready(function() {
		$('body').on('keyup keypress', 'form input[type="text"]', function(e) {
			if (e.keyCode == 13) {
				e.preventDefault();
				return false;
			}
		});
		$('body').on('keypress', '.NO_KIK', function(e) {
			if (e.which == 13) {
				$(this).closest('tr').find('.TGL_KIK').focus().select();
			}
		});
		$('body').on('keypress', '.MODEL', function(e) {
			if (e.which == 13) {
				$(this).closest('tr').find('.ITEM').focus().select();
			}
		});
		$('body').on('keypress', '.ITEM', function(e) {
			if (e.which == 13) {
				$(this).closest('tr').find('.DES1').focus().select();
			}
		});
		$('body').on('keypress', '.DES1', function(e) {
			if (e.which == 13) {
				$(this).closest('tr').find('.QTY').focus().select();
			}
		});
		$('body').on('keypress', '.QTY', function(e) {
			if (e.which == 13) {
				$(this).closest('tr').find('.UPAH').focus().select();
			}
		});
		$('body').on('keypress', '.UPAH', function(e) {
			if (e.which == 13) {
				$(this).closest('tr').find('.JUMLAH').focus().select();
			}
		});
		$('body').on('keypress', '.JUMLAH', function(e) {
			if (e.which == 13) {
				$(this).closest('tr').find('.ORG').focus().select();
			}
		});
		$('body').on('keypress', '.ORG', function(e) {
			if (e.which == 13) {
				$(this).closest('tr').find('.HR').focus().select();
			}
		});
		$('body').on('keypress', '.HR', function(e) {
			if (e.which == 13) {
				if ($(this).data('rw') == (idrow - 1)) {
					$('#tambah').click();
				}
				$('#MODEL' + ($(this).data('rw') + 1)).select2('focus');
			}
		});
	});

</script>

<script>
	var target;
	var idrow = <?= $no ?>;

	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}

	function fnum() {
		$(".numinput").autoNumeric('init', {
			aSign: '<?= ''; ?>',
			vMax: '999999999999.99',
			vMin: '-999999999999.99'
		});
		$('.numinput').autoNumeric('update');
	};

	$(document).ready(function() {
		fnum();
		$("#TQTY").autoNumeric('init', {
			aSign: '<?= ''; ?>',
			vMax: '999999999999.99',
			vMin: '-999999999999.99'
		});
		$("#TJUMLAH").autoNumeric('init', {
			aSign: '<?= ''; ?>',
			vMax: '999999999999.99',
			vMin: '-999999999999.99'
		});
		$("#T_HR").autoNumeric('init', {
			aSign: '<?= ''; ?>',
			vMax: '999999999999.99',
			vMin: '-999999999999.99'
		});
		$("#PPN").autoNumeric('init', {
			aSign: '<?= ''; ?>',
			vMax: '999999999999.99',
			vMin: '-999999999999.99'
		});
		$("#MINUSS").autoNumeric('init', {
			aSign: '<?= ''; ?>',
			vMax: '999999999999.99',
			vMin: '-999999999999.99'
		});
		$("#LUNAS_BS").autoNumeric('init', {
			aSign: '<?= ''; ?>',
			vMax: '999999999999.99',
			vMin: '-999999999999.99'
		});
		$("#UPAH_TAMBAH").autoNumeric('init', {
			aSign: '<?= ''; ?>',
			vMax: '999999999999.99',
			vMin: '-999999999999.99'
		});
		$("#POT_BON").autoNumeric('init', {
			aSign: '<?= ''; ?>',
			vMax: '999999999999.99',
			vMin: '-999999999999.99'
		});
		$('body').on('click', '.btn-delete', function() {
			var val = $(this).parents("tr").remove();
			idrow--;
			nomor();
		});
		$('body').on('keyup', '.numinput', function() {
			hitung();
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
		var TQTY = 0;
		var T_HR = 0;
		var TJUMLAH = 0;
		var LUNAS_BS = parseFloat($('#LUNAS_BS').val().replace(/,/g, ''));
		var UPAH_TAMBAH = parseFloat($('#UPAH_TAMBAH').val().replace(/,/g, ''));
		var PPN = 0;
		var MINUSS = 0;
		var POT_BON = 0;
		var umr = 104167;
		var umrd = 104167;

		var total_row = idrow;
		for (i=0;i<total_row;i++) {
			var qty = parseFloat($('#QTY'+i).val().replace(/,/g, ''));
			var upah = parseFloat($('#UPAH'+i).val().replace(/,/g, ''));
			var org = parseFloat($('#ORG'+i).val().replace(/,/g, ''));
			var hr = parseFloat($('#HR'+i).val().replace(/,/g, ''));
			var taun = $('#TGL_KIK'+i).val().substr(-4);
			var bulan = $('#TGL_KIK'+i).val().substr(3,2);
			var hari = $('#TGL_KIK'+i).val().substr(0,2);
			var tanggal = taun+bulan+hari;
			var kd_bag = $('#KD_BAG').val().substr(0,9);

			var jumlah = qty*upah;
			jumlah = jumlah.toFixed(2);
			if(isNaN(jumlah)) jumlah = 0;
			$('#JUMLAH'+i).val(numberWithCommas(jumlah));

			if (org != 0) {
				hr = (org*umrd) - jumlah;

				if (hr < 0) {
					hr = 0;

					if(isNaN(hr)) hr = 0;
					$('#HR'+i).val(numberWithCommas(hr));
				}
			}

		};

		x1 = 0;
		x2 = 0;
		x3 = 0;
		x4 = 0;
		x5 = 0;
		x6 = 0;
		x7 = 0;
		x8 = 0;
		x9 = '';
		x10 = tanggal;

		var total_row = idrow;
		for (i=0;i<total_row;i++) {
			var qty = parseFloat($('#QTY'+i).val().replace(/,/g, ''));
			var upah = parseFloat($('#UPAH'+i).val().replace(/,/g, ''));
			var org = parseFloat($('#ORG'+i).val().replace(/,/g, ''));
			var hr = parseFloat($('#HR'+i).val().replace(/,/g, ''));
			var taun = $('#TGL_KIK'+i).val().substr(-4);
			var bulan = $('#TGL_KIK'+i).val().substr(3,2);
			var hari = $('#TGL_KIK'+i).val().substr(0,2);
			var tanggal = taun+bulan+hari;
			var kd_bag = $('#KD_BAG').val().substr(0,9);

			if (tanggal < '20210101' && tanggal != '' && tanggal > x9) {
				x9 = tanggal;
			}
		};

		var total_row = idrow;
		for (i=0;i<total_row;i++) {
			var qty = parseFloat($('#QTY'+i).val().replace(/,/g, ''));
			var hr = parseFloat($('#HR'+i).val().replace(/,/g, ''));
			var jumlah = parseFloat($('#JUMLAH'+i).val().replace(/,/g, ''));

			x1 = x1+qty;
			x2 = x2+hr;
			x6 = x6+jumlah;

			if (tanggal = x9) {
				x3 = x3+jumlah;
				x4 = x4+hr;
			}
			if (tanggal = x10) {
				x5 = x5+jumlah;
				x7 = x7+hr;
			}
		};

		if (x1 > 0) {
			// SELECT KIKD
			// GO R1
		}

		$(".QTY").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			TQTY+=val;
		});
		$(".JUMLAH").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			TJUMLAH+=val;
		});

		$(".HR").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			T_HR+=val;
		});

		TQTY = x1;
		T_HR = x2; 
		TJUMLAH = x6;
		PPN = TJUMLAH*0.01;
		MINUSS = ((TJUMLAH+T_HR) - PPN);
		POT_BON = MINUSS + UPAH_TAMBAH - LUNAS_BS;

		console.log('\nPPN :'+PPN+'\nMINUSS :'+MINUSS+'\nPOT_BON :'+POT_BON);

		if(isNaN(T_HR)) T_HR = 0;
		if(isNaN(TQTY)) TQTY = 0;
		if(isNaN(TJUMLAH)) TJUMLAH = 0;
		if(isNaN(PPN)) PPN = 0;
		if(isNaN(LUNAS_BS)) LUNAS_BS = 0;
		if(isNaN(UPAH_TAMBAH)) UPAH_TAMBAH = 0;
		if(isNaN(MINUSS)) MINUSS = 0;
		if(isNaN(POT_BON)) POT_BON = 0;

		$('#T_HR').val(numberWithCommas(T_HR));
		$('#TQTY').val(numberWithCommas(TQTY));
		$('#TJUMLAH').val(numberWithCommas(TJUMLAH));
		$('#PPN').val(numberWithCommas(PPN));
		$('#LUNAS_BS').val(numberWithCommas(LUNAS_BS));
		$('#UPAH_TAMBAH').val(numberWithCommas(UPAH_TAMBAH));
		$('#MINUSS').val(numberWithCommas(MINUSS));
		$('#POT_BON').val(numberWithCommas(POT_BON));

		$("#T_HR").autoNumeric('update');
		$("#TQTY").autoNumeric('update');
		$("#TJUMLAH").autoNumeric('update');
		$("#PPN").autoNumeric('update');
		$("#LUNAS_BS").autoNumeric('update');
		$("#UPAH_TAMBAH").autoNumeric('update');
		$("#MINUSS").autoNumeric('update');
		$("#POT_BON").autoNumeric('update');
	}

</script>

<script>

	$(document).ready(function() {
		select_no_kik();
		select_model();
		$('body').on('click', '#tambah', function() {
			$('#detail').append(`
				<tr>
					<td><input name="REC[]" id="REC${idrow}" type="text" value="${idrow+1}" class="form-control REC text_input" readonly></td>
					<td>
						<div class="input-group">
							<select class="js-example-responsive-no_kik form-control NO_KIK text_input" onchange='no_kik(this.id)' name="NO_KIK[]" id="NO_KIK${idrow}"></select>
						</div>
					</td>
					<td>
						<input 
							name="TGL_KIK[]" 
							id="TGL_KIK${idrow}" 
							type="text" 
							class="date form-control TGL_KIK text_input"
							data-date-format="dd-mm-yyyy"
							value="<?php echo date('d-m-Y', strtotime($row->TGL_KIK, TRUE)); ?>"
							onclick="select()"
						>
					</td>
					<td>
						<div class="input-group">
							<select class="js-example-responsive-model form-control MODEL text_input" onchange='model(this.id)' name="MODEL[]" id="MODEL${idrow}"></select>
						</div>
					</td>
					<td><input name="ITEM[]" id="ITEM${idrow}" type="text" class="form-control ITEM text_input" readonly></td>
					<td><input name="DES1[]" id="DES1${idrow}" type="text" class="form-control DES1 text_input" readonly></td>
					<td><input name="QTY[]" onkeyup="hitung()" onclick="select()" value="0.00" id="QTY${idrow}" type="text" class="form-control QTY rightJustified text-primary numinput"></td>
					<td><input name="UPAH[]" onkeyup="hitung()" value="0.00" id="UPAH${idrow}" type="text" class="form-control UPAH rightJustified text-primary numinput" readonly></td>
					<td><input name="JUMLAH[]" onkeyup="hitung()" value="0.00" id="JUMLAH${idrow}" type="text" class="form-control JUMLAH rightJustified text-primary numinput" readonly></td>
					<td><input name="ORG[]" onkeyup="hitung()" onclick="select()" value="0.00" id="ORG${idrow}" type="text" class="form-control ORG rightJustified text-primary numinput"></td>
					<td><input name="HR[]" onkeyup="hitung()" value="0.00" id="HR${idrow}" data-rw="${idrow}" type="text" class="form-control HR rightJustified text-primary numinput" readonly></td>
					<td>
						<input type="hidden" name="NO_ID[]" id="NO_ID${idrow}" class="form-control NO_ID" value="0">
						<button type="button" class="btn btn-sm btn-circle btn-outline-danger btn-delete ml-3">
						<i class="fa fa-fw fa-trash"></i>
						</button>
					</td>
				</tr>`);
			idrow++;
			nomor();
			select_no_kik();
			select_model();
			hitung();
			fnum();
		});
	});

	function select_no_kik() {
		$('.js-example-responsive-no_kik').on('select2:select', function(e) {
			no_kik($(this).closest('tr').find('.TGL_KIK').data('rw'));
		});
		$('.js-example-responsive-no_kik').select2({
			ajax: {
				url: "<?= base_url('admin/Transaksi_KIK_PSP/getDataAjax_KIK') ?>",
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
			placeholder: 'No. Kik',
			minimumInputLength: 0,
			templateResult: format_no_kik,
			templateSelection: formatSelection_no_kik
		});
	}

	function format_no_kik(repo_no_kik) {
		if (repo_no_kik.loading) {
			return repo_no_kik.text;
		}
		var $container = $(
			"<div class='select2-result-repository clearfix'>" +
			"<div class='select2-result-repository__title'></div>" +
			"</div>"
		);
		$container.find(".select2-result-repository__title").text(repo_no_kik.no_kik);
		return $container;
	}

	function formatSelection_no_kik(repo_no_kik) {
		return repo_no_kik.text;
	}

	function no_kik(x) {
		// var q = x.substring(6, 10);
		// console.log(q);
	}

	function select_model() {
		$('.js-example-responsive-model').on('select2:select', function(e) {
			model($(this).closest('tr').find('.HR').data('rw'));
		});
		var kik_grup = $('#KIK_GRUP').val();
		$('.js-example-responsive-model').select2({
			ajax: {
				url: "<?= base_url('admin/Transaksi_KIK_PSP/getDataAjax_Model') ?>",
				dataType: "json",
				type: "post",
				delay: 10,
				data: function(params) {
					return {
						search: params.term,
						page: params.page,
						kik_grup : $('#KIK_GRUP').val(),
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
			placeholder: 'Model',
			minimumInputLength: 0,
			templateResult: format_model,
			templateSelection: formatSelection_model
		});
	}

	function format_model(repo_model) {
		if (repo_model.loading) {
			return repo_model.text;
		}
		var $container = $(
			"<div class='select2-result-repository clearfix'>" +
			"<div class='select2-result-repository__title'></div>" +
			"</div>"
		);
		$container.find(".select2-result-repository__title").text(repo_model.model);
		return $container;
	}
	var urut_ke = '';
	var kode = '';
	var item = '';
	var proses = '';
	var des1 = '';
	var upah = '';

	function formatSelection_model(repo_model) {
		urut_ke = repo_model.urut_ke;
		kode = repo_model.kode;
		item = repo_model.item;
		proses = repo_model.proses;
		des1 = repo_model.des1;
		upah = repo_model.upah;
		return repo_model.text;
	}

	// function model(xx) {
	// 	var qq = xx.substring(5, 13);
	// 	$('#URUT_KE' + qq).val(urut_ke);
	// 	$('#KODE' + qq).val(kode);
	// 	$('#ITEM' + qq).val(item);
	// 	$('#PROSES' + qq).val(proses);
	// 	$('#DES1' + qq).val(des1);
	// 	$('#UPAH' + qq).val(upah);
	// 	console.log(proses);
	// }

	function model(xx) {
		// var qq = xx.substring(5, 10);
		$('#URUT_KE' + xx).val(urut_ke);
		$('#KODE' + xx).val(kode);
		$('#ITEM' + xx).val(item);
		$('#PROSES' + xx).val(proses);
		$('#DES1' + xx).val(des1);
		$('#UPAH' + xx).val(upah);
		console.log(upah);
	}

</script>

<script>
	jQuery.fn.preventDoubleSubmission = function() {
		$(this).on('submit', function(e) {
			var $form = $(this);
			if ($form.data('submitted') === true) {
				// Previously submitted - don't submit again
				e.preventDefault();
			} else {
				if ($('#QTY').val() > 0) {
					alert("Qty Tidak Boleh Minus !!!");
					// $("#myModalx").modal();
					e.preventDefault();
				} else {
					e.preventDefault();
					$('.simpan').prop("disabled", true);
					let daftar_hrd_kik = [];
					var jrow = $('#datatable').find('tbody').find('tr').length;
					// console.log(jrow);
					let x = 0;
					for (let i = 0; i < jrow; i++) {
						let tr = $('#datatable').find('tbody').find('tr:eq(' + i + ')');
						daftar_hrd_kik[x] = {
							NO_ID: tr.find('.NO_ID').val(),
							REC: tr.find('.REC').val(),
							NO_KIK: tr.find('.NO_KIK').val(),
							TGL_KIK: tr.find('.TGL_KIK').val(),
							MODEL: tr.find('.MODEL').val(),
							ITEM: tr.find('.ITEM').val(),
							DES1: tr.find('.DES1').val(),
							QTY: tr.find('.QTY').val(),
							UPAH: tr.find('.UPAH').val(),
							JUMLAH: tr.find('.JUMLAH').val(),
							ORG: tr.find('.ORG').val(),
							HR: tr.find('.HR').val(),
						}
						x++;
					};
					var hrd_kik = JSON.stringify(daftar_hrd_kik);
					// console.log(hrd_kik);
					// header
					var TGL = $('#TGL').val();
					// $('#wrapper').fadeOut("fast");
					// $('.loadx').fadeIn("slow");
					$.ajax({
						type: "POST",
						url: $('#kik_psp').attr("action"),
						data: {
							daftar_hrd_kik: hrd_kik,
							KD_BAG: KD_BAG,
							NM_BAG: NM_BAG,
							KD_GRUP: KD_GRUP,
							NM_GRUP: NM_GRUP,
							KIK_GRUP: KIK_GRUP,
							NOTES: NOTES,
							FASE: FASE,
							ID: $('#ID').val()
						},
						success: function(data) {
							window.open("<?= base_url('admin/Transaksi_KIK_PSP/index_Transaksi_KIK_PSP') ?>", "_self")
						}
					});
					// Mark it so that the next submit can be ignored
					// $form.data('submitted', true);
				}
			}
		});
		// Keep chainability
		return this;
	};
	$('#kik_psp').preventDoubleSubmission();
</script>