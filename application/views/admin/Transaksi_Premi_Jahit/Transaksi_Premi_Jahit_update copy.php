<?php
	foreach ($transaksi_premi_jahit as $rowh) {};
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
	table {	table-layout: auto !important; }
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
</style>

<div class="container-fluid">
	<br>
	<div class="alert alert-success alert-container" role="alert">
		<i class="fas fa-university"></i> Update <?php echo $this->session->userdata['judul']; ?>
	</div>
	<form id="transaksipremijahit" name="transaksipremijahit" action="<?php echo base_url('admin/Transaksi_Premi_Jahit/update_aksi'); ?>" class="form-horizontal needs-validation" method="post" novalidate>
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
						<div class="col-md-1">
							<label class="label">Notes </label>
						</div>
						<div class="col-md-3">
							<input class="form-control text_input NOTES" id="NOTES" name="NOTES" type="text" value="<?php echo $rowh->NOTES ?>">
						</div>
						<div class="col-md-1">
							<label class="label">Ms </label>
						</div>
						<div class="col-md-2">
							<input class="form-control MS rightJustified text-primary font-weight-bold" id="MS" name="MS" value="<?php echo number_format($rowh->MS, 2, '.', ','); ?>" readonly>
						</div>
						<div class="col-md-2">
							<button type="button" class="btn btn-primary" onclick="updatekik()">Update KIK</button>
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
								<th width="100px">Pelatihan</th>
								<th width="100px">Sablon</th>
								<th width="100px">Jahit Lemek</th>
								<th width="100px">Jumlah</th>
								<th width="100px">Total NB</th>
								<th width="100px">BLA</th>
								<th width="100px">Cakra</th>
								<th width="100px">PT</th>
								<th width="50px"></th>
							</tr>
						</thead>
						<tbody>
						<?php
							$no = 0;
							foreach ($transaksi_premi_jahit as $row) : 
						?>
							<tr>
								<td><input name="REC[]" id="REC<?php echo $no; ?>" value="<?= $row->REC ?>" type="text" class="form-control REC" onkeypress="return tabE(this,event)" readonly></td>
								<td>
									<div class="input-group">														        
										<input name="KD_BAG[]" id="KD_BAG<?php echo $no; ?>" value="<?= $row->KD_BAG ?>" type="text" class="form-control KD_BAG" readonly>
										<span class="input-group-btn">
											<a class="btn default" id="0" data-target="#mymodal_bagian" data-toggle="modal" href="#lupKD_BAG" onfocusout="hitung()"><i class="fa fa-search"></i></a>
										</span>
									</div>
								</td>
								<td><input name="NM_BAG[]" id="NM_BAG<?php echo $no; ?>" value="<?= $row->NM_BAG ?>" type="text" class="form-control NM_BAG" readonly></td>
								<td>
									<input name="NETT[]" onkeyup="hitung()" id="NETT<?php echo $no; ?>" value="<?php echo number_format($row->NETT, 2, '.', ','); ?>" type="text" class="form-control NETT rightJustified text-primary" readonly>
									<input name="NETTX[]" id="NETTX<?php echo $no; ?>" value="<?php echo number_format($row->NETTX, 2, '.', ','); ?>" type="text" class="form-control NETTX rightJustified text-primary">
								</td>
								<td><input name="TMS[]" onkeyup="hitung()" id="TMS<?php echo $no; ?>" value="<?php echo number_format($row->TMS, 2, '.', ','); ?>" type="text" class="form-control TMS rightJustified text-primary"></td>
								<td><input name="TMSQC[]" onclick="select()" onkeyup="hitung()" id="TMSQC<?php echo $no; ?>" value="<?php echo number_format($row->TMSQC, 2, '.', ','); ?>" type="text" class="form-control TMSQC rightJustified text-primary"></td>
								<td><input name="UPAH_TAMBAH[]" onkeyup="hitung()" id="UPAH_TAMBAH<?php echo $no; ?>" value="<?php echo number_format($row->UPAH_TAMBAH, 2, '.', ','); ?>" type="text" class="form-control UPAH_TAMBAH rightJustified text-primary"></td>
								<td><input name="OL[]" onclick="select()" onkeyup="hitung()" id="OL<?php echo $no; ?>" value="<?php echo number_format($row->OL, 2, '.', ','); ?>" type="text" class="form-control OL rightJustified text-primary"></td>
								<td><input name="LUNAS_BS[]" onkeyup="hitung()" id="LUNAS_BS<?php echo $no; ?>" value="<?php echo number_format($row->LUNAS_BS, 2, '.', ','); ?>" type="text" class="form-control LUNAS_BS rightJustified text-primary"></td>
								<td><input name="BON_BARU[]" onclick="select()" onkeyup="hitung()" id="BON_BARU<?php echo $no; ?>" value="<?php echo number_format($row->BON_BARU, 2, '.', ','); ?>" type="text" class="form-control BON_BARU rightJustified text-primary"></td>
								<td><input name="PELATIHAN[]" onclick="select()" onkeyup="hitung()" id="PELATIHAN<?php echo $no; ?>" value="<?php echo number_format($row->PELATIHAN, 2, '.', ','); ?>" type="text" class="form-control PELATIHAN rightJustified text-primary"></td>
								<td><input name="SABLON[]" onclick="select()" onkeyup="hitung()" id="SABLON<?php echo $no; ?>" value="<?php echo number_format($row->SABLON, 2, '.', ','); ?>" type="text" class="form-control SABLON rightJustified text-primary"></td>
								<td><input name="JAHIT_LEMEK[]" onclick="select()" onkeyup="hitung()" id="JAHIT_LEMEK<?php echo $no; ?>" value="<?php echo number_format($row->JAHIT_LEMEK, 2, '.', ','); ?>" type="text" class="form-control JAHIT_LEMEK rightJustified text-primary"></td>
								<td>
									<!-- 15 background proses -->
									<input name="KASI[]" onkeyup="hitung()" id="KASI<?php echo $no; ?>" value="<?php echo number_format($row->KASI, 2, '.', ','); ?>" type="hidden" class="form-control KASI rightJustified text-primary" readonly>
									<input name="MAINT1[]" onkeyup="hitung()" id="MAINT1<?php echo $no; ?>" value="<?php echo number_format($row->MAINT1, 2, '.', ','); ?>" type="hidden" class="form-control MAINT1 rightJustified text-primary" readonly>
									<input name="MAINT2[]" onkeyup="hitung()" id="MAINT2<?php echo $no; ?>" value="<?php echo number_format($row->MAINT2, 2, '.', ','); ?>" type="hidden" class="form-control MAINT2 rightJustified text-primary" readonly>
									<input name="KABAG[]" onkeyup="hitung()" id="KABAG<?php echo $no; ?>" value="<?php echo number_format($row->KABAG, 2, '.', ','); ?>" type="hidden" class="form-control KABAG rightJustified text-primary" readonly>
									<input name="QC1[]" onkeyup="hitung()" id="QC1<?php echo $no; ?>" value="<?php echo number_format($row->QC1, 2, '.', ','); ?>" type="hidden" class="form-control QC1 rightJustified text-primary" readonly>
									<input name="ADMIN1[]" onkeyup="hitung()" id="ADMIN1<?php echo $no; ?>" value="<?php echo number_format($row->ADMIN1, 2, '.', ','); ?>" type="hidden" class="form-control ADMIN1 rightJustified text-primary" readonly>
									<input name="ADMIN2[]" onkeyup="hitung()" id="ADMIN2<?php echo $no; ?>" value="<?php echo number_format($row->ADMIN2, 2, '.', ','); ?>" type="hidden" class="form-control ADMIN2 rightJustified text-primary" readonly>
									<input name="WK_MANAG[]" onkeyup="hitung()" id="WK_MANAG<?php echo $no; ?>" value="<?php echo number_format($row->WK_MANAG, 2, '.', ','); ?>" type="hidden" class="form-control WK_MANAG rightJustified text-primary" readonly>
									<input name="KA_QC[]" onkeyup="hitung()" id="KA_QC<?php echo $no; ?>" value="<?php echo number_format($row->KA_QC, 2, '.', ','); ?>" type="hidden" class="form-control KA_QC rightJustified text-primary" readonly>
									<input name="WK_QC[]" onkeyup="hitung()" id="WK_QC<?php echo $no; ?>" value="<?php echo number_format($row->WK_QC, 2, '.', ','); ?>" type="hidden" class="form-control WK_QC rightJustified text-primary" readonly>
									<input name="ADM[]" onkeyup="hitung()" id="ADM<?php echo $no; ?>" value="<?php echo number_format($row->ADM, 2, '.', ','); ?>" type="hidden" class="form-control ADM rightJustified text-primary" readonly>
									<input name="MANAG[]" onkeyup="hitung()" id="MANAG<?php echo $no; ?>" value="<?php echo number_format($row->MANAG, 2, '.', ','); ?>" type="hidden" class="form-control MANAG rightJustified text-primary" readonly>
									<input name="KAPROD[]" onkeyup="hitung()" id="KAPROD<?php echo $no; ?>" value="<?php echo number_format($row->KAPROD, 2, '.', ','); ?>" type="hidden" class="form-control KAPROD rightJustified text-primary" readonly>
									<input name="KAMAINT[]" onkeyup="hitung()" id="KAMAINT<?php echo $no; ?>" value="<?php echo number_format($row->KAMAINT, 2, '.', ','); ?>" type="hidden" class="form-control KAMAINT rightJustified text-primary" readonly>
									<input name="KSMAINT[]" onkeyup="hitung()" id="KSMAINT<?php echo $no; ?>" value="<?php echo number_format($row->KSMAINT, 2, '.', ','); ?>" type="hidden" class="form-control KSMAINT rightJustified text-primary" readonly>
									<!-- batas 15 background proses -->
									<input name="TJUMLAH[]" onkeyup="hitung()" id="TJUMLAH<?php echo $no; ?>" value="<?php echo number_format($row->TJUMLAH, 2, '.', ','); ?>" type="text" class="form-control TJUMLAH rightJustified text-primary" readonly>
								</td>
								<td>
									<input name="TNB[]" onkeyup="hitung()" id="TNB<?php echo $no; ?>" value="<?php echo number_format($row->TNB, 2, '.', ','); ?>" type="text" class="form-control TNB rightJustified text-primary" readonly>
									<input name="TNBX[]" id="TNBX<?php echo $no; ?>" value="<?php echo number_format($row->TNBX, 2, '.', ','); ?>" type="text" class="form-control TNBX rightJustified text-primary">
								</td>
								<td><input name="BLA[]" onclick="select()" onkeyup="hitung()" id="BLA<?php echo $no; ?>" value="<?php echo number_format($row->BLA, 2, '.', ','); ?>" type="text" class="form-control BLA rightJustified text-primary" readonly></td>
								<td><input name="CAKRA[]" onclick="select()" onkeyup="hitung()" id="CAKRA<?php echo $no; ?>" value="<?php echo number_format($row->CAKRA, 2, '.', ','); ?>" type="text" class="form-control CAKRA rightJustified text-primary" readonly></td>
								<td><input name="NETTO[]" onclick="select()" onkeyup="hitung()" id="NETTO<?php echo $no; ?>" value="<?php echo number_format($row->NETTO, 2, '.', ','); ?>" type="text" class="form-control NETTO rightJustified text-primary" readonly></td>
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
						<button type="submit"  class="btn btn-success"><i class="fa fa-save"></i> Save</button>										
							<a type="button" href="javascript:javascript:history.go(-1)" class="btn btn-danger">Cancel</a>
					</div>
					<h4><span id="error" style="display:none; color:#F00">Terjadi Kesalahan... </span> <span id="success" style="display:none; color:#0C0">Savings.done...</span></h4>
				</div>
			</div>
		</div>
	</form>
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
						<th>Dragon</th>
						<th>Per</th>
						<th>Nett</th>
					</thead>
					<tbody>
					<?php
						$dr= $this->session->userdata['dr'];
						$per = $this->session->userdata['periode'];
						$sql = "SELECT hrd_kik.kd_bag AS KD_BAG, 
								hrd_kik.nm_bag AS NM_BAG, 
								hrd_kik.dr AS DR,
								hrd_kik.per AS PER,
								hrd_kik.tjumlah AS NETT
							FROM hrd_kik WHERE hrd_kik.dr='$dr' AND hrd_kik.per='$per' ORDER BY hrd_kik.dr, hrd_kik.kd_bag";
						$a = $this->db->query($sql)->result();
						foreach($a as $b ) { 
					?>
						<tr>
							<td class='KBBVAL'><a href="#" class="select_kd_bag"><?php echo $b->KD_BAG;?></a></td>
							<td class='NBBVAL text_input'><?php echo $b->NM_BAG;?></td>
							<td class='DRBVAL text_input'><?php echo $b->DR;?></td>
							<td class='PRBVAL text_input'><?php echo $b->PER;?></td>
							<td class='NTBVAL text_input'><?php echo number_format($b->NETT,2,'.',',');?></td>
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
		$("#MS").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});

		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#NETT" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#UPAH_TAMBAH" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#OL" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#TMS" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#TMSQC" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#LAIN" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#PELATIHAN" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#SABLON" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#JAHIT_LEMEK" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#LUNAS_BS" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#BON_BARU" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#TJUMLAH" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#TNB" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#BLA" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#CAKRA" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#NETTO" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});

			// 15 background proses
			$("#KASI" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#MAINT1" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#MAINT2" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#KABAG" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#QC1" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#ADMIN1" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#ADMIN2" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#WK_MANAG" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#KA_QC" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#WK_QC" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#ADM" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#MANAG" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#KAPROD" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#KAMAINT" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#KSMAINT" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
		}
		//MyModal Bagian
		$('#mymodal_bagian').on('show.bs.modal', function (e) {
			target = $(e.relatedTarget);
		});
		$('body').on('click', '.select_kd_bag', function() {
			var val = $(this).parents("tr").find(".KBBVAL").text();
			target.parents("tr").find(".KD_BAG").val(val);
			var val = $(this).parents("tr").find(".NBBVAL").text();
			target.parents("tr").find(".NM_BAG").val(val);
			var val = $(this).parents("tr").find(".NTBVAL").text();
			target.parents("tr").find(".NETT").val(val);
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

	function updatekik() {
		var total_row = idrow;
		for (i=0;i<total_row;i++) {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			$('#NETT'+i).val($('#NETTX'+i).val());
			$('#TNB'+i).val($('#TNBX'+i).val());
		}
		alert("Update KIK selesai..");
	}

	function hitung() {
		var total_row = idrow;
		for (i=0;i<total_row;i++) {
			var nett = parseFloat($('#NETT'+i).val().replace(/,/g, ''));
			var tms = parseFloat($('#TMS'+i).val().replace(/,/g, ''));
			var lain = parseFloat($('#UPAH_TAMBAH'+i).val().replace(/,/g, ''));
			var ol = parseFloat($('#OL'+i).val().replace(/,/g, ''));
			var lns_bs = parseFloat($('#LUNAS_BS'+i).val().replace(/,/g, ''));
			var bon = parseFloat($('#BON_BARU'+i).val().replace(/,/g, ''));
			var lain1 = parseFloat($('#PELATIHAN'+i).val().replace(/,/g, ''));
			var sablon = parseFloat($('#SABLON'+i).val().replace(/,/g, ''));
			var jht_lemek = parseFloat($('#JAHIT_LEMEK'+i).val().replace(/,/g, ''));

			var nbkas = 0.38*tms;
			var nbkab = 0.106*tms;
			var nbmaint1 = 0.068*tms;
			if ($('#KD_BAG'+i).val()=='711.03.N' ){
				var nbmaint2 = 0*tms;
			} if ($('#KD_BAG'+i).val()=='711.03.T' ){
				var nbmaint2 = 0*tms;
			} else {
				var nbmaint2 = 0.068*tms;
			}
			var nbqc1 = 0.36*tms;
			var nbqc2 = 0;
			var nbadmin1 = 0;
			var nbadm = 0.012*tms;
			var nbmanag = 0;
			var nbkaprod = 0.020*tms;
			var nbkamaint = 0.010*tms;
			var nbksmaint = 0.021*tms;
			var nbadmin = 0.017*tms;
			var wkmag = 0.020*tms;
			var kaqc = 0.015*tms;
			var wkqc = 0.012*tms;

			var tot_nb = nbkas+nbkab+nbmaint1+nbmaint2+nbqc1+nbqc2+nbadmin+nbadmin1+wkmag+kaqc+wkqc+nbadm+nbmanag+nbkaprod+nbkamaint+nbksmaint;
			var tjumlah = nett+(bon-lns_bs)+ol+lain+sablon+jht_lemek+lain1;
			var hkas = tjumlah/tot_nb;

			var kasi = hkas*nbkas;
			var maint1 = hkas*nbmaint1;
			var maint2 = hkas*nbmaint2;
			var kabag = hkas*nbkab;
			var qc1 = hkas*nbqc1;
			var admin1 = hkas*nbadmin;
			var admin2 = hkas*nbadmin1;
			var wk_manag = hkas*wkmag;
			var ka_qc = hkas*kaqc;
			var wk_qc = hkas*wkqc;
			var adm = hkas*nbadm;
			var manag = hkas*nbmanag;
			var kaprod = hkas*nbkaprod;
			var kamaint = hkas*nbkamaint;
			var ksmaint = hkas*nbksmaint;
			// console.log("KASI : ",kasi);
			// console.log("TOT_NB :",tot_nb);
			// console.log("TOTAL :",total);
			// console.log("KASI :",kasi);
			$('#KASI'+i).val(numberWithCommas(kasi));
			$('#KASI'+i).autoNumeric('update');
			// if(isNaN(tot_nb)) tot_nb = 0;
			$('#MAINT1'+i).val(numberWithCommas(maint1));
			$('#MAINT1'+i).autoNumeric('update');

			$('#MAINT2'+i).val(numberWithCommas(maint2));
			$('#MAINT2'+i).autoNumeric('update');

			$('#KABAG'+i).val(numberWithCommas(kabag));
			$('#KABAG'+i).autoNumeric('update');

			$('#QC1'+i).val(numberWithCommas(qc1));
			$('#QC1'+i).autoNumeric('update');

			$('#ADMIN1'+i).val(numberWithCommas(admin1));
			$('#ADMIN1'+i).autoNumeric('update');

			$('#ADMIN2'+i).val(numberWithCommas(admin2));
			$('#ADMIN2'+i).autoNumeric('update');

			$('#WK_MANAG'+i).val(numberWithCommas(wk_manag));
			$('#WK_MANAG'+i).autoNumeric('update');

			$('#KA_QC'+i).val(numberWithCommas(ka_qc));
			$('#KA_QC'+i).autoNumeric('update');

			$('#WK_QC'+i).val(numberWithCommas(wk_qc));
			$('#WK_QC'+i).autoNumeric('update');

			$('#ADM'+i).val(numberWithCommas(adm));
			$('#ADM'+i).autoNumeric('update');

			$('#MANAG'+i).val(numberWithCommas(manag));
			$('#MANAG'+i).autoNumeric('update');

			$('#KAPROD'+i).val(numberWithCommas(kaprod));
			$('#KAPROD'+i).autoNumeric('update');

			$('#KAMAINT'+i).val(numberWithCommas(kamaint));
			$('#KAMAINT'+i).autoNumeric('update');

			$('#KSMAINT'+i).val(numberWithCommas(ksmaint));
			$('#KSMAINT'+i).autoNumeric('update');

			$('#TJUMLAH'+i).val(numberWithCommas(tjumlah));
			$('#TJUMLAH'+i).autoNumeric('update');
		};
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

		var bagian0="<div class='input-group'>";														        
		var bagian1="<input name='KD_BAG[]' type='text' class='form-control KD_BAG text_input' id=KD_BAG text_input"+idrow+" readonly>";
		var bagian2="<span class='input-group-btn'>";
		var bagian3="<a data-target=\"#mymodal_bagian\" data-toggle=\"modal\" class='btn default' href='#lupKD_BAG' id="+idrow+" onfocusout='hitung()'><i class='fa fa-search'></i></a>";	
		var bagian4="</span></div>";	 

		var bagian=bagian0+bagian1+bagian2+bagian3+bagian4;

		td1.innerHTML = "<input name='REC[]' id=REC" + idrow + " type='text' class='REC form-control' onkeypress='return tabE(this,event)' readonly>";
		td2.innerHTML = bagian;
		td3.innerHTML = "<input name='NM_BAG[]' id=NM_BAG" + idrow + " type='text' class='form-control NM_BAG' readonly>";
		td4.innerHTML = "<input name='NETT[]' onkeyup='hitung()' value='0' id=NETT" + idrow + " type='text' class='form-control NETT rightJustified text-primary' readonly>";
		td5.innerHTML = "<input name='TMS[]' onkeyup='hitung()' value='0' id=TMS" + idrow + " type='text' class='form-control TMS rightJustified text-primary'>";
		td6.innerHTML = "<input name='TMSQC[]' onclick='select()' onkeyup='hitung()' value='0' id=TMSQC" + idrow + " type='text' class='form-control TMSQC rightJustified text-primary'>";
		td7.innerHTML = "<input name='UPAH_TAMBAH[]' onkeyup='hitung()' value='0' id=UPAH_TAMBAH" + idrow + " type='text' class='form-control UPAH_TAMBAH rightJustified text-primary'>";
		td8.innerHTML = "<input name='OL[]' onclick='select()' onkeyup='hitung()' value='0' id=OL" + idrow + " type='text' class='form-control OL rightJustified text-primary'>";
		td9.innerHTML = "<input name='LUNAS_BS[]' onkeyup='hitung()' value='0' id=LUNAS_BS" + idrow + " type='text' class='form-control LUNAS_BS rightJustified text-primary'>";
		td10.innerHTML = "<input name='BON_BARU[]' onclick='select()' onkeyup='hitung()' value='0' id=BON_BARU" + idrow + " type='text' class='form-control BON_BARU rightJustified text-primary'>";
		td11.innerHTML = "<input name='PELATIHAN[]' onclick='select()' onkeyup='hitung()' value='0' id=PELATIHAN" + idrow + " type='text' class='form-control PELATIHAN rightJustified text-primary'>";
		td12.innerHTML = "<input name='SABLON[]' onclick='select()' onkeyup='hitung()' value='0' id=SABLON" + idrow + " type='text' class='form-control SABLON rightJustified text-primary'>";
		td13.innerHTML = "<input name='JAHIT_LEMEK[]' onclick='select()' onkeyup='hitung()' value='0' id=JAHIT_LEMEK" + idrow + " type='text' class='form-control JAHIT_LEMEK rightJustified text-primary'>";
		td14.innerHTML = "<input name='KASI[]' onkeyup='hitung()' value='0' id=KASI" + idrow + " type='hidden' class='form-control KASI rightJustified text-primary' readonly><input name='MAINT1[]' onkeyup='hitung()' value='0' id=MAINT1" + idrow + " type='hidden' class='form-control MAINT1 rightJustified text-primary' readonly><input name='MAINT2[]' onkeyup='hitung()' value='0' id=MAINT2" + idrow + " type='hidden' class='form-control MAINT2 rightJustified text-primary' readonly><input name='KABAG[]' onkeyup='hitung()' value='0' id=KABAG" + idrow + " type='hidden' class='form-control KABAG rightJustified text-primary' readonly><input name='QC1[]' onkeyup='hitung()' value='0' id=QC1" + idrow + " type='hidden' class='form-control QC1 rightJustified text-primary' readonly><input name='ADMIN1[]' onkeyup='hitung()' value='0' id=ADMIN1" + idrow + " type='hidden' class='form-control ADMIN1 rightJustified text-primary' readonly><input name='ADMIN2[]' onkeyup='hitung()' value='0' id=ADMIN2" + idrow + " type='hidden' class='form-control ADMIN2 rightJustified text-primary' readonly><input name='WK_MANAG[]' onkeyup='hitung()' value='0' id=WK_MANAG" + idrow + " type='hidden' class='form-control WK_MANAG rightJustified text-primary' readonly><input name='KA_QC[]' onkeyup='hitung()' value='0' id=KA_QC" + idrow + " type='hidden' class='form-control KA_QC rightJustified text-primary' readonly><input name='WK_QC[]' onkeyup='hitung()' value='0' id=WK_QC" + idrow + " type='hidden' class='form-control WK_QC rightJustified text-primary' readonly><input name='ADM[]' onkeyup='hitung()' value='0' id=ADM" + idrow + " type='hidden' class='form-control ADM rightJustified text-primary' readonly><input name='MANAG[]' onkeyup='hitung()' value='0' id=MANAG" + idrow + " type='hidden' class='form-control MANAG rightJustified text-primary' readonly><input name='KAPROD[]' onkeyup='hitung()' value='0' id=KAPROD" + idrow + " type='hidden' class='form-control KAPROD rightJustified text-primary' readonly><input name='KAMAINT[]' onkeyup='hitung()' value='0' id=KAMAINT" + idrow + " type='hidden' class='form-control KAMAINT rightJustified text-primary' readonly><input name='KSMAINT[]' onkeyup='hitung()' value='0' id=KSMAINT" + idrow + " type='hidden' class='form-control KSMAINT rightJustified text-primary' readonly><input name='TJUMLAH[]' onkeyup='hitung()' value='0' id=TJUMLAH" + idrow + " type='text' class='form-control TJUMLAH rightJustified text-primary' readonly>";
		td15.innerHTML = "<input name='TNB[]' onkeyup='hitung()' value='0' id=TNB" + idrow + " type='text' class='form-control TNB rightJustified text-primary' readonly>";
		td16.innerHTML = "<input name='BLA[]' onclick='select()' onkeyup='hitung()' value='0' id=BLA" + idrow + " type='text' class='form-control BLA rightJustified text-primary' readonly>";
		td17.innerHTML = "<input name='CAKRA[]' onkeyup='hitung()' value='0' id=CAKRA" + idrow + " type='text' class='form-control CAKRA rightJustified text-primary' readonly>";
		td18.innerHTML = "<input name='NETTO[]' onkeyup='hitung()' value='0' id=NETTO" + idrow + " type='text' class='form-control NETTO rightJustified text-primary' readonly>";
		td19.innerHTML = "<input type='hidden' name='NO_ID[]' id=NO_ID" + idrow + " value='0' class='form-control'>" +
			" <button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>";
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#NETT" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#TMS" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#TMSQC" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#UPAH_TAMBAH" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#OL" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#LUNAS_BS" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#BON_BARU" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#TJUMLAH" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#PELATIHAN" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#SABLON" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#JAHIT_LEMEK" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#TNB" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#BLA" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#CAKRA" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#NETTO" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});

			// 15 background proses
			$("#KASI" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#MAINT1" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#MAINT2" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#KABAG" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#QC1" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#ADMIN1" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#ADMIN2" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#WK_MANAG" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#KA_QC" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#WK_QC" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#ADM" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#MANAG" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#KAPROD" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#KAMAINT" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#KSMAINT" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
		}
		idrow++;
		nomor();
		$(".ronly").on('keydown paste', function(e) {
			e.preventDefault();
			e.currentTarget.blur();
		});
	}

	function hapus() {
		if (idrow > 1) {
			var x = document.getElementById('datatable').deleteRow(idrow);
			idrow--;
			nomor();
		}
	}

</script>