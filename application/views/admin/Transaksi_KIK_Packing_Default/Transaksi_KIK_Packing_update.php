<?php
	foreach ($kik_packing as $rowh) {};
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
	<br>
	<div class="alert alert-success alert-container" role="alert">
		<i class="fas fa-university"></i> Update <?php echo $this->session->userdata['judul']; ?>
	</div>
	<form id="kikpacking" name="kikpacking" action="<?php echo base_url('admin/Transaksi_KIK_Packing/update_aksi'); ?>" class="form-horizontal needs-validation" method="post" novalidate>
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
				<div class="table-responsive scrollable">
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
						<tbody>
                        <?php
							$no = 0;
							foreach ($kik_packing as $row) : 
						?>
							<tr>
								<td><input name="REC[]" id="REC<?php echo $no; ?>" value="<?= $row->REC ?>" type="text" class="form-control REC text_input" onkeypress="return tabE(this,event)" readonly></td>
								<td>
									<div class="input-group">
										<select class="js-example-responsive-no_kik form-control NO_KIK text_input" name="NO_KIK[]" id="NO_KIK<?php echo $no; ?>" onchange="no_kik(this.id)" required>
											<option value="<?php echo $row->NO_KIK; ?>" selected id="NO_KIK<?php echo $no; ?>"><?php echo $row->NO_KIK; ?></option>
										</select>
									</div>
								</td>
                                <!-- <td><input name="NO_KIK[]" id="NO_KIK<?php echo $no; ?>" value="<?= $row->NO_KIK ?>" type="text" class="form-control NO_KIK text_input" readonly></td> -->
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
										<select class="js-example-responsive-model form-control MODEL text_input" name="MODEL[]" id="MODEL<?php echo $no; ?>" onchange="model(this.id)" required>
										<option value="<?php echo $row->MODEL; ?>" selected id="MODEL<?php echo $no; ?>"><?php echo $row->MODEL; ?></option>
										</select>
									</div>
								</td>
                                <!-- <td><input name="MODEL[]" id="MODEL<?php echo $no; ?>" value="<?= $row->MODEL ?>" type="text" class="form-control NO_KIK text_input" readonly></td> -->
                                <td><input name="ITEM[]" id="ITEM<?php echo $no; ?>" value="<?= $row->ITEM ?>" type="text" class="form-control ITEM text_input" onkeypress="return tabE(this,event)" readonly></td>
                                <td><input name="DES1[]" id="DES1<?php echo $no; ?>" value="<?= $row->DES1 ?>" type="text" class="form-control DES1 text_input" onkeypress="return tabE(this,event)" readonly></td>
								<td><input name="QTY[]" onclick="select()" onkeyup="hitung()" id="QTY<?php echo $no; ?>" value="<?php echo number_format($row->QTY, 2, '.', ','); ?>" type="text" class="form-control QTY rightJustified text-primary"></td>
								<td><input name="UPAH[]" onkeyup="hitung()" id="UPAH<?php echo $no; ?>" value="<?php echo number_format($row->UPAH, 2, '.', ','); ?>" type="text" class="form-control UPAH rightJustified text-primary" readonly></td>
								<td><input name="JUMLAH[]" onkeyup="hitung()" id="JUMLAH<?php echo $no; ?>" value="<?php echo number_format($row->JUMLAH, 2, '.', ','); ?>" type="text" class="form-control JUMLAH rightJustified text-primary" readonly></td>
								<td><input name="ORG[]" onclick="select()" onkeyup="hitung()" id="ORG<?php echo $no; ?>" value="<?php echo number_format($row->ORG, 2, '.', ','); ?>" type="text" class="form-control ORG rightJustified text-primary"></td>
								<td><input name="HR[]" onkeyup="hitung()" id="HR<?php echo $no; ?>" value="<?php echo number_format($row->HR, 2, '.', ','); ?>" type="text" class="form-control HR rightJustified text-primary" readonly></td>
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
							<td><input class="form-control TQTY rightJustified text-primary font-weight-bold" id="TQTY" name="TQTY" value="<?php echo number_format($row->TQTY, 2, '.', ','); ?>" readonly></td>
							<td></td>
							<td><input class="form-control TJUMLAH rightJustified text-primary font-weight-bold" id="TJUMLAH" name="TJUMLAH" value="<?php echo number_format($row->TJUMLAH, 2, '.', ','); ?>" readonly></td>
							<td></td>
							<td><input class="form-control T_HR rightJustified text-primary font-weight-bold" id="T_HR" name="T_HR" value="<?php echo number_format($row->T_HR, 2, '.', ','); ?>" readonly></td>
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
					<input class="form-control PPN rightJustified text-danger font-weight-bold" id="PPN" name="PPN" value="<?php echo number_format($row->PPN, 2, '.', ','); ?>" readonly>
				</div>
				<div class="col-md-1 ">
					<label class="label">Minuss </label>
				</div>
				<div class="col-md-2 ">						
					<input class="form-control MINUSS rightJustified text-danger font-weight-bold" id="MINUSS" name="MINUSS" value="<?php echo number_format($row->MINUSS, 2, '.', ','); ?>" readonly>
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
						<input class="form-control LUNAS_BS rightJustified text-danger font-weight-bold" onclick="select()" onkeyup="hitung()" id="LUNAS_BS" name="LUNAS_BS" value="<?php echo number_format($row->LUNAS_BS, 2, '.', ','); ?>">
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
						<input class="form-control UPAH_TAMBAH rightJustified text-primary font-weight-bold" onclick="select()" onkeyup="hitung()" id="UPAH_TAMBAH" name="UPAH_TAMBAH" value="<?php echo number_format($row->UPAH_TAMBAH, 2, '.', ','); ?>">
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
						<input class="form-control POT_BON rightJustified text-primary font-weight-bold" id="POT_BON" name="POT_BON" value="<?php echo number_format($row->POT_BON, 2, '.', ','); ?>" readonly>
					</div>
				</div>
			</div>
		<div class="row">
			<div class="col-xs-9">
				<div class="wells">
					<div class="btn-group cxx">
						<button type="submit"  class="btn btn-success"><i class="fa fa-save"></i> Save</button>
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
						<th>KIK Grup</th>
						<th>Dragon</th>
					</thead>
					<tbody>
					<?php
						$dr= $this->session->userdata['dr'];
						$sql = "SELECT hrd_bag.kd_bag AS KD_BAG, 
								hrd_bag.nm_bag AS NM_BAG, 
								hrd_bag.kd_grup AS KD_GRUP, 
								hrd_bag.nm_grup AS NM_GRUP,
								hrd_bag.kik_grup AS KIK_GRUP,
								hrd_bag.dr AS DR
							FROM hrd_bag WHERE hrd_bag.dr='$dr' ORDER BY dr, kd_bag";
						$a = $this->db->query($sql)->result();
						foreach($a as $b ) { 
					?>
						<tr>
							<td class='KBBVAL'><a href="#" class="select_kd_bag"><?php echo $b->KD_BAG;?></a></td>
							<td class='NBBVAL text_input'><?php echo $b->NM_BAG;?></td>
							<td class='KDBVAL text_input'><?php echo $b->KD_GRUP;?></td>
							<td class='NGBVAL text_input'><?php echo $b->NM_GRUP;?></td>
							<td class='KGBVAL text_input'><?php echo $b->KIK_GRUP;?></td>
							<td class='DRBVAL text_input'><?php echo $b->DR;?></td>
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
			dom: 
				"<'row'<'col-md-6'><'col-md-6'>>" + // 
				"<'row'<'col-md-6'f><'col-md-6'l>>" + // peletakan entries, search, dan test_btn
				"<'row'<'col-md-12't>><'row'<'col-md-12'ip>>", // peletakan show dan halaman
			buttons: [ 'copy', 'csv', 'excel', 'pdf', 'print' ],
			order: true,
		});
		$('.modal-footer').on('click', '#close', function() {			 
			$('input[type=search]').val('').keyup();  // this line and next one clear the search dialog
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
	var idrow = <?php echo $no ?>;

	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
	$(document).ready(function() {
		$("#UMR").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#T_HR").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#TQTY").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#TJUMLAH").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#LUNAS_BS").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#UPAH_TAMBAH").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#PPN").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#MINUSS").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#POT_BON").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#ORG" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#QTY" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#UPAH" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#JUMLAH" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#HR" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
		}
		//MyModal Bagian
			$('#mymodal_bagian').on('show.bs.modal', function (e) {
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
			var val = $(this).parents("tr").find(".KGBVAL").text();
			target.parents("div").find(".KIK_GRUP").val(val);	
			var val = $(this).parents("tr").find(".DRBVAL").text();
			target.parents("div").find(".DR").val(val);	
			$('#mymodal_bagian').modal('toggle');
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
				x7 = x7+jumlah;
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
		// if(isNaN(LUNAS_BS)) LUNAS_BS = 0;
		// if(isNaN(UPAH_TAMBAH)) UPAH_TAMBAH = 0;
		if(isNaN(MINUSS)) MINUSS = 0;
		if(isNaN(POT_BON)) POT_BON = 0;

		$('#T_HR').val(numberWithCommas(T_HR));
		$('#TQTY').val(numberWithCommas(TQTY));
		$('#TJUMLAH').val(numberWithCommas(TJUMLAH));
		$('#PPN').val(numberWithCommas(PPN));
		// $('#LUNAS_BS').val(numberWithCommas(LUNAS_BS));
		// $('#UPAH_TAMBAH').val(numberWithCommas(UPAH_TAMBAH));
		$('#MINUSS').val(numberWithCommas(MINUSS));
		$('#POT_BON').val(numberWithCommas(POT_BON));

		$("#T_HR").autoNumeric('update');
		$("#TQTY").autoNumeric('update');
		$("#TJUMLAH").autoNumeric('update');
		$("#PPN").autoNumeric('update');
		// $("#LUNAS_BS").autoNumeric('update');
		// $("#UPAH_TAMBAH").autoNumeric('update');
		$("#MINUSS").autoNumeric('update');
		$("#POT_BON").autoNumeric('update');
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

		var no_kik0 = "<div class='input-group'><select class='js-example-responsive-no_kik form-control NO_KIK0' name='NO_KIK[]' id=NO_KIK" + idrow + " onchange='no_kik(this.id)' onfocusout='hitung()' required></select></div>";
		var no_kik = no_kik0;
		// <select class="js-example-responsive-model form-control MODEL0" name="MODEL[]" id="MODEL0" onchange="model(this.id)" onfocusout="hitung()"></select>

		var model0 = "<div class='input-group'><select class='js-example-responsive-model form-control MODEL0' name='MODEL[]' id=MODEL" + idrow + " onchange='model(this.id)' onfocusout='hitung()'></select></div>";
		var model = model0;

		td1.innerHTML = "<input name='REC[]' id=REC" + idrow + " type='text' class='REC form-control' onkeypress='return tabE(this,event)' readonly>";
		td2.innerHTML = no_kik;
		td3.innerHTML = "<input name='TGL_KIK[]' id=TGL_KIK" + idrow + " type='text' class='date form-control TGL_KIK' data-date-format='dd-mm-yyyy' value='<?php if(isset($_POST["tampilkan"])) { echo $_POST["TGL_KIK"]; } else echo date('d-m-Y'); ?>'>";
		td4.innerHTML = model;
		td5.innerHTML = "<input name='ITEM[]' id=ITEM" + idrow + " type='text' class='form-control ITEM' readonly>";
		td6.innerHTML = "<input name='DES1[]' id=DES1" + idrow + " type='text' class='form-control DES1' readonly>";
		td7.innerHTML = "<input name='QTY[]' onclick='select()' onkeyup='hitung()' value='0' id=QTY" + idrow + " type='text' class='form-control QTY rightJustified text-primary'>";
		td8.innerHTML = "<input name='UPAH[]' onclick='select()' onkeyup='hitung()' value='0' id=UPAH" + idrow + " type='text' class='form-control UPAH rightJustified text-primary' readonly>";
		td9.innerHTML = "<input name='JUMLAH[]' onkeyup='hitung()' value='0' id=JUMLAH" + idrow + " type='text' class='form-control JUMLAH rightJustified text-primary' readonly>";
		td10.innerHTML = "<input name='ORG[]' onkeyup='hitung()' onclick='select()' value='0' id=ORG" + idrow + " type='text' class='form-control ORG rightJustified text-primary'>";
		td11.innerHTML = "<input name='HR[]' onkeyup='hitung()' value='0' id=HR" + idrow + " type='text' class='form-control HR rightJustified text-primary' readonly>";
		td12.innerHTML = "<input type='hidden' name='NO_ID[]' id=NO_ID" + idrow + "  class='form-control' value='0'>" +
			" <button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>";
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#ORG" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#HR" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#QTY" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#UPAH" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#JUMLAH" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
		}
		idrow++;
		nomor();
		$(".ronly").on('keydown paste', function(e) {
			e.preventDefault();
			e.currentTarget.blur();
		});
		$(".date").datepicker({
			'dateFormat': 'dd-mm-yy',
		})
		select_no_kik();
		select_model();
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
		select_no_kik();
		select_model();
	});

// NO_KIK
	function select_no_kik() {
		$('.js-example-responsive-no_kik').select2({
			ajax: {
				url: "<?= base_url('admin/Transaksi_KIK_Packing/getDataAjax_KIK') ?>",
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
			placeholder: 'Pilih No KIK',
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
		var q = x.substring(6, 10);
		// console.log(q);
	}

// MODEL
	function select_model() {
		var kik_grup = $('#KIK_GRUP').val();
		$('.js-example-responsive-model').select2({
			ajax: {
				url: "<?= base_url('admin/Transaksi_KIK_Packing/getDataAjax_Model') ?>",
				dataType: "json",
				// data:{proses_1: proses_1},
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
			placeholder: 'Pilih Model',
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

	function model(xx) {
		var qq = xx.substring(5, 13);
		$('#URUT_KE' + qq).val(urut_ke);
		$('#KODE' + qq).val(kode);
		$('#ITEM' + qq).val(item);
		$('#PROSES' + qq).val(proses);
		$('#DES1' + qq).val(des1);
		$('#UPAH' + qq).val(upah);
		console.log(proses);
	}

</script>