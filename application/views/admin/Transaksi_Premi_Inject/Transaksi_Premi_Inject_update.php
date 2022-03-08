<?php
	foreach ($transaksi_premi_inject as $rowh) {};
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
	table {	table-layout: fixed !important; }
	table th {color: black; text-align: center;}
	table td { overflow: hidden; }
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
	.label {color: black; font-weight: bold;}
	.text_input {font-size: small; color: black;}
</style>

<div class="container-fluid">
	<br>
	<div class="alert alert-success alert-container" role="alert">
		<i class="fas fa-university"></i> Update <?php echo $this->session->userdata['judul']; ?>
	</div>
	<form id="premiinject" name="premiinject" action="<?php echo base_url('admin/Transaksi_Premi_Inject/update_aksi'); ?>" class="form-horizontal needs-validation" method="post" novalidate>
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
						<div class="col-md-2">
							<input class="form-control text_input NOTES" id="NOTES" name="NOTES" type="text" value="<?php echo $rowh->NOTES ?>">
						</div>
						<div class="col-md-1">
							<label class="label">Ms </label>
						</div>
						<div class="col-md-2">
							<input class="form-control MS rightJustified text-primary" id="MS" name="MS" type="text" value="<?php echo number_format($rowh->MS, 2, '.', ','); ?>">
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
								<th width="100px">Pelunasan</th>
								<th width="100px">Bon</th>
								<th width="100px">Total</th>
								<th width="100px">Total NB</th>
								<th width="100px">BLA</th>
								<th width="100px">Netto</th>
								<th width="50px"></th>
							</tr>
						</thead>
						<tbody>
						<?php
							$no = 0;
							foreach ($transaksi_premi_inject as $row) : 
						?>
							<tr>
								<td><input name="REC[]" id="REC<?php echo $no; ?>" value="<?= $row->REC ?>" type="text" class="form-control REC text_input" onkeypress="return tabE(this,event)" readonly></td>
								<td><input name="KD_BAG[]" id="KD_BAG<?php echo $no; ?>" value="<?= $row->KD_BAG ?>" type="text" class="form-control KD_BAG text_input" readonly></td>
								<td><input name="NM_BAG[]" id="NM_BAG<?php echo $no; ?>" value="<?= $row->NM_BAG ?>" type="text" class="form-control NM_BAG text_input" readonly></td>
								<td>
									<input name="KIK_NETT[]" onkeyup="hitung()" id="KIK_NETT<?php echo $no; ?>" value="<?php echo number_format($row->KIK_NETT, 2, '.', ','); ?>" type="text" class="form-control KIK_NETT rightJustified text-primary" readonly>
									<input name="KIK_NETTX[]" id="KIK_NETTX<?php echo $no; ?>" value="<?php echo number_format($row->KIK_NETTX, 2, '.', ','); ?>" type="text" class="form-control KIK_NETTX rightJustified text-primary" readonly>
								</td>
								<td><input name="TMS[]" onclick="select()" onkeyup="hitung()" id="TMS<?php echo $no; ?>" value="<?php echo number_format($row->TMS, 2, '.', ','); ?>" type="text" class="form-control TMS rightJustified text-primary"></td>
								<td><input name="LUNAS_BS[]" onkeyup="hitung()" id="LUNAS_BS<?php echo $no; ?>" value="<?php echo number_format($row->LUNAS_BS, 2, '.', ','); ?>" type="text" class="form-control LUNAS_BS rightJustified text-primary"></td>
								<td><input name="BON_BARU[]" onclick="select()" onkeyup="hitung()" id="LUNAS_BS<?php echo $no; ?>" value="<?php echo number_format($row->LUNAS_BS, 2, '.', ','); ?>" type="text" class="form-control BON_BARU rightJustified text-primary"></td>
								<td>
									<!-- 15 background proses -->
									<input name="KABAG[]" onkeyup="hitung()" id="KABAG<?php echo $no; ?>" value="<?php echo number_format($row->KABAG, 2, '.', ','); ?>" type="hidden" class="form-control KABAG rightJustified text-primary" readonly>
									<input name="KSMESIN[]" onkeyup="hitung()" id="KSMESIN<?php echo $no; ?>" value="<?php echo number_format($row->KSMESIN, 2, '.', ','); ?>" type="hidden" class="form-control KSMESIN rightJustified text-primary" readonly>
									<input name="KSMAINT[]" onkeyup="hitung()" id="KSMAINT<?php echo $no; ?>" value="<?php echo number_format($row->KSMAINT, 2, '.', ','); ?>" type="hidden" class="form-control KSMAINT rightJustified text-primary" readonly>
									<input name="MAINT1[]" onkeyup="hitung()" id="MAINT1<?php echo $no; ?>" value="<?php echo number_format($row->MAINT1, 2, '.', ','); ?>" type="hidden" class="form-control MAINT1 rightJustified text-primary" readonly>
									<input name="MAINT2[]" onkeyup="hitung()" id="MAINT2<?php echo $no; ?>" value="<?php echo number_format($row->MAINT2, 2, '.', ','); ?>" type="hidden" class="form-control MAINT2 rightJustified text-primary" readonly>
									<input name="PREMI[]" onkeyup="hitung()" id="PREMI<?php echo $no; ?>" value="<?php echo number_format($row->PREMI, 2, '.', ','); ?>" type="hidden" class="form-control PREMI rightJustified text-primary" readonly>
									<input name="TJUMLAH[]" onkeyup="hitung()" id="TJUMLAH<?php echo $no; ?>" value="<?php echo number_format($row->TJUMLAH, 2, '.', ','); ?>" type="text" class="form-control TJUMLAH rightJustified text-primary" readonly>
								</td>
								<td><input name="TNB[]" onkeyup="hitung()" id="TNB<?php echo $no; ?>" value="<?php echo number_format($row->TNB, 2, '.', ','); ?>" type="text" class="form-control TNB rightJustified text-primary" readonly></td>
								<td><input name="BLA[]" onclick="select()" onkeyup="hitung()" id="BLA<?php echo $no; ?>" value="<?php echo number_format($row->BLA, 2, '.', ','); ?>" type="text" class="form-control BLA rightJustified text-primary" readonly></td>
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
						foreach($a as $b ) { 
					?>
						<tr>
							<td class='KGBVAL'><a href="#" class="select_kik_grup"><?php echo $b->KIK_GRUP;?></a></td>
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

		$("#MS").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});

		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#KIK_NETT" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#TMS" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#LUNAS_BS" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#BON_BARU" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#TJUMLAH" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#TNB" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#BLA" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#NETTO" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});

			// 15 background proses
			$("#KABAG" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#KSMESIN" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#KSMAINT" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#MAINT1" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#MAINT2" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#PREMI" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
		}
		//MyModal KIK Grup
			$('#mymodal_kik_grup').on('show.bs.modal', function (e) {
			target = $(e.relatedTarget);
		});
		$('body').on('click', '.select_kik_grup', function() {
			var val = $(this).parents("tr").find(".KGBVAL").text();
			target.parents("div").find(".KIK_GRUP").val(val);
			$('#mymodal_kik_grup').modal('toggle');
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
			$('#KIK_NETT'+i).val($('#KIK_NETTX'+i).val());
			$('#TMS'+i).val($('#TMSX'+i).val());
		}
		alert("Update KIK selesai..");
	}

	function hitung() {
		var total_row = idrow;
		console.clear();
		for (i=0;i<total_row;i++) {
			var kik_nett = parseFloat($('#KIK_NETT'+i).val().replace(/,/g, ''));
			var tms = parseFloat($('#TMS'+i).val().replace(/,/g, ''));
			var lns_bs = parseFloat($('#LUNAS_BS'+i).val().replace(/,/g, ''));
			var bon = parseFloat($('#BON_BARU'+i).val().replace(/,/g, ''));
			var nbdr1 = parseFloat($('#TNB'+i).val().replace(/,/g, ''));
			var nm_bag = $('#NM_BAG'+i).val().substr(0,25);

			var nbkabag = (0.42*tms).toFixed(2);
			// console.log('Nama Bagian : '+nm_bag);
			// console.log('TMs : '+tms);
			// console.log('NbKas : '+nbkas);

			var nbksmesin = (0.93*tms).toFixed(2);
			// console.log('NbKsmaint : '+nbksmesin);

			var nbksmaint = (0.47*tms).toFixed(2);
			// console.log('NbKsmaint : '+nbksmaint);

			var nbmaint1 = (0.74*tms).toFixed(2);
			// console.log('NbMaint 1 : '+nbmaint1);

			var nbmaint2 = (0.12*tms).toFixed(2);
			// console.log('NbMaint 2 : '+nbmaint2);

			var tjumlah = (kik_nett+(bon-lns_bs));
			$('#TJUMLAH'+i).val(numberWithCommas(tjumlah));
			$('#TJUMLAH'+i).autoNumeric('update');
			// console.log('TJumlah : '+tjumlah);
			// console.log('NbDr1 : '+nbdr1);

			var tot_nb = (
							Number(nbkabag)+
							Number(nbksmesin)+
							Number(nbksmaint)+
							Number(nbmaint1)+
							Number(nbmaint2)+
							Number(nbdr1)
						).toFixed(2);
			console.log('Tot_NB : '+tot_nb + ' - Nama Bagian : '+nm_bag);

			var hkas = (tjumlah/tot_nb).toFixed(2);
			console.log('HKas : '+hkas);

			var kabag = hkas*nbkabag;
			$('#KABAG'+i).val(numberWithCommas(kabag));
			$('#KABAG'+i).autoNumeric('update');
			// console.log('Kasi :'+kasi + ' - Nama Bagian : '+nm_bag);

			var ksmesin = hkas*nbksmesin;
			$('#KSMESIN'+i).val(numberWithCommas(ksmesin));
			$('#KSMESIN'+i).autoNumeric('update');
			// console.log('Maint1 :'+maint1 + ' - Nama Bagian : '+nm_bag);

			var ksmaint = hkas*nbksmaint;
			$('#KSMAINT'+i).val(numberWithCommas(ksmaint));
			$('#KSMAINT'+i).autoNumeric('update');
			// console.log('KsMaint :'+ksmaint + ' - Nama Bagian : '+nm_bag);

			var maint1 = hkas*nbmaint1;
			$('#MAINT1'+i).val(numberWithCommas(maint1));
			$('#MAINT1'+i).autoNumeric('update');
			// console.log('Kabag :'+kabag + ' - Nama Bagian : '+nm_bag);

			var maint2 = hkas*nbmaint2;
			$('#MAINT2'+i).val(numberWithCommas(maint2));
			$('#MAINT2'+i).autoNumeric('update');
			// console.log('Qc1 :'+qc1 + ' - Nama Bagian : '+nm_bag);

			var premi = kabag+ksmesin+ksmaint+maint1+maint2;

			$('#PREMI'+i).val(numberWithCommas(premi));
			$('#PREMI'+i).autoNumeric('update');
			console.log('Premi :'+premi + ' - Nama Bagian : '+nm_bag);
			console.log('Nama Bagian : '+nm_bag + 
				'\n' +
				' - Kabag : '+kabag+ 
				'\n' +
				' - KsMesin : '+ksmesin+
				'\n' +
				' - KsMaint : '+ksmaint+
				'\n' +
				' - Maint1 : '+maint1+
				'\n' +
				' - Maint2 : '+maint2
			);
			// console.log('Nama Bagian : '+nm_bag);
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

		var bagian0="<div class='input-group'>";														        
		var bagian1="<input name='KD_BAG[]' type='text' class='form-control KD_BAG text_input text_input' id=KD_BAG text_input"+idrow+" readonly>";
		var bagian2="<span class='input-group-btn'>";
		var bagian3="<a data-target=\"#mymodal_bagian\" data-toggle=\"modal\" class='btn default' href='#lupKD_BAG' id="+idrow+" onfocusout='hitung()'><i class='fa fa-search'></i></a>";	
		var bagian4="</span></div>";	 

		var bagian=bagian0+bagian1+bagian2+bagian3+bagian4;

		td1.innerHTML = "<input name='REC[]' id=REC" + idrow + " type='text' class='REC form-control text_input' onkeypress='return tabE(this,event)' readonly>";
		td2.innerHTML = bagian;
		td3.innerHTML = "<input name='NM_BAG[]' id=NM_BAG" + idrow + " type='text' class='form-control NM_BAG text_input' readonly>";
		td4.innerHTML = "<input name='KIK_NETT[]' onkeyup='hitung()' value='0' id=KIK_NETT" + idrow + " type='text' class='form-control KIK_NETT rightJustified text-primary' readonly>";
		td5.innerHTML = "<input name='TMS[]' onkeyup='hitung()' value='0' id=TMS" + idrow + " type='text' class='form-control TMS rightJustified text-primary'>";
		td6.innerHTML = "<input name='LUNAS_BS[]' onkeyup='hitung()' value='0' id=LUNAS_BS" + idrow + " type='text' class='form-control LUNAS_BS rightJustified text-primary'>";
		td7.innerHTML = "<input name='BON_BARU[]' onclick='select()' onkeyup='hitung()' value='0' id=BON_BARU" + idrow + " type='text' class='form-control BON_BARU rightJustified text-primary'>";
		td8.innerHTML = "<input name='KABAG[]' onkeyup='hitung()' value='0' id=KABAG" + idrow + " type='hidden' class='form-control KABAG rightJustified text-primary' readonly><input name='KSMESIN[]' onkeyup='hitung()' value='0' id=KSMESIN" + idrow + " type='hidden' class='form-control KSMESIN rightJustified text-primary' readonly><input name='KSMAINT[]' onkeyup='hitung()' value='0' id=KSMAINT" + idrow + " type='hidden' class='form-control KSMAINT rightJustified text-primary' readonly><input name='PREMI[]' onkeyup='hitung()' value='0' id=PREMI" + idrow + " type='hidden' class='form-control PREMI rightJustified text-primary' readonly><input name='MAINT1[]' onkeyup='hitung()' value='0' id=MAINT1" + idrow + " type='hidden' class='form-control MAINT1 rightJustified text-primary' readonly><input name='MAINT2[]' onkeyup='hitung()' value='0' id=MAINT2" + idrow + " type='hidden' class='form-control MAINT2 rightJustified text-primary' readonly><input name='TJUMLAH[]' onkeyup='hitung()' value='0' id=TJUMLAH" + idrow + " type='text' class='form-control TJUMLAH rightJustified text-primary' readonly>";
		td9.innerHTML = "<input name='TNB[]' onkeyup='hitung()' value='0' id=TNB" + idrow + " type='text' class='form-control TNB rightJustified text-primary' readonly>";
		td10.innerHTML = "<input name='BLA[]' onclick='select()' onkeyup='hitung()' value='0' id=BLA" + idrow + " type='text' class='form-control BLA rightJustified text-primary'>";
		td11.innerHTML = "<input name='NETTO[]' onkeyup='hitung()' value='0' id=NETTO" + idrow + " type='text' class='form-control NETTO rightJustified text-primary' readonly>";
		td12.innerHTML = "<input type='hidden' name='NO_ID[]' id=NO_ID" + idrow + "  class='form-control' value='0'>" +
			" <button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>";
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#KIK_NETT" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#TMS" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#LUNAS_BS" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#BON_BARU" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#TJUMLAH" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#TNB" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#BLA" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#NETTO" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});

			// 15 background proses
			$("#KABAG" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#KSMESIN" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#KSMAINT" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#MAINT1" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#MAINT2" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#PREMI" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
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