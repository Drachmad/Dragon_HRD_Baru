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
	.checkbox_container {width: 25px; height: 25px;}
	td input[type="checkbox"] {
		float: left;
		margin: 0 auto;
		width: 100%;
	}
	.text_input {font-size: small; color: black;}
</style>

<div class="container-fluid">
	<br>
	<div class="alert alert-success alert-container" role="alert">
		<i class="fas fa-university"></i> Input <?php echo $this->session->userdata['judul']; ?>
	</div>
	<form id="boronganborongandragon" name="boronganborongandragon" action="<?php echo base_url('admin/Transaksi_Borongan_BoronganDragon/input_aksi'); ?>" class="form-horizontal needs-validation" method="post" novalidate>
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
							<label class="label">Bagian </label>
						</div>
						<div class="col-md-2 input-group">
							<input name="KD_BAG" id="KD_BAG" maxlength="30" type="text" class="form-control KD_BAG text_input" onkeypress="return tabE(this,event)" readonly>
							<span class="input-group-btn">
								<a class="btn default" onfocusout="hitung()" id="0" data-target="#mymodal_bagian" data-toggle="modal" href="#lupbagian" ><i class="fa fa-search"></i></a>
							</span>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input NM_BAG" id="NM_BAG" name="NM_BAG" type="text" readonly>
						</div>
						<div class="col-md-1">
							<input class="form-control text_input KD_GRUP" id="KD_GRUP" name="KD_GRUP" type="text" value='' readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Jml Org </label>
						</div>
						<div class="col-md-1">
							<input class="form-control ORG rightJustified text-primary font-weight-bold" id="ORG" name="ORG" value="0">
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">Total KIK </label>
						</div>
						<div class="col-md-2">
							<input class="form-control KIK_NETT rightJustified text-primary font-weight-bold" id="KIK_NETT" name="KIK_NETT" value="" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Premi </label>
						</div>
						<div class="col-md-1">
							<!-- <input name="PREMI" id="PREMI" type="checkbox" value="0" class="checkbox_container" unchecked> -->
							<input class="form-control LAIN rightJustified text-primary font-weight-bold" onchange="hitung()"  id="LAIN" name="LAIN" value="0">
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-1">
							<label class="label">Tot Bon </label>
						</div>
						<div class="col-md-2">
							<input class="form-control TOT_BON rightJustified text-primary font-weight-bold" id="TOT_BON" name="TOT_BON" value="0">
						</div>
						<div class="col-md-1">
							<label class="label">Lain </label>
						</div>
						<div class="col-md-2">
							<input class="form-control OTHER rightJustified text-primary font-weight-bold" id="OTHER" name="OTHER" value="0">
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">KIK Nett </label>
						</div>
						<div class="col-md-2">
							<input class="form-control NETTO rightJustified text-primary font-weight-bold" id="NETTO" name="NETTO" value="0" readonly>
							<input class="form-control TOT_POT rightJustified text-primary font-weight-bold" type="hidden" id="TOT_POT" name="TOT_POT" value="0" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">TMS </label>
						</div>
						<div class="col-md-1">
							<input onclick="select()" class="form-control TMS rightJustified text-primary font-weight-bold" id="TMS" name="TMS" value="0">
						</div>
						<div class="col-md-1">
							<button type="button" class="btn btn-primary" onclick="isims()">MS</button>
						</div>
						<div class="col-md-1">
							<label class="label">Notes </label>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input NOTES" id="NOTES" name="NOTES" type="text" value=''>
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
								<th width="150px">NIP</th>
								<th width="120px">Nama</th>
								<th width="75px">PTKP</th>
								<th width="75px">ST</th>
								<th width="120px">MS</th>
								<th width="120px">IK</th>
								<th width="100px">NB</th>
								<th width="100px">HR</th>
								<th width="100px">Upah</th>
								<th width="100px">Bon</th>
								<th width="100px">Subsidi</th>
								<th width="100px">Sub</th>
								<th width="100px">Harian</th>
								<th width="100px">Lain</th>
								<th width="100px">Jumlah</th>
								<th width="50px"></th>
							</tr>
						</thead>
						<tbody id="show-data">
							<tr>
								<td><input name="REC[]" id="REC0" type="text" value="1" class="form-control REC text_input" onkeypress="return tabE(this,event)" readonly></td>
								<td><input name="KD_PEG[]" id="KD_PEG0" type="text" class="form-control KD_PEG text_input" readonly></td>
								<td>
									<select class="js-example-responsive-nm_peg form-control NM_PEG0 text_input" name="NM_PEG[]" id="NM_PEG0" onchange="nm_peg(this.id)" onfocusout="hitung()" required></select>
								</td>
								<td><input name="PTKP[]" id="PTKP0" type="text" class="form-control PTKP text_input" readonly></td>
								<td>
									<input name="STAT[]" id="STAT0" type="text" class="form-control STAT text_input" readonly>
									<input name="TARIF1[]" onchange="hitung()" value="0" id="TARIF10" type="hidden" class="form-control TARIF1 rightJustified text-primary">
									<input name="TARIF2[]" onchange="hitung()" value="0" id="TARIF20" type="hidden" class="form-control TARIF2 rightJustified text-primary">
									<input name="GAJI[]" onchange="hitung()" value="0" id="0" type="hidden" class="form-control GAJI rightJustified text-primary">
									<input name="TASTEK[]" onchange="hitung()" value="0" id="TASTEK0" type="hidden" class="form-control TASTEK rightJustified text-primary">
									<input name="LBL[]" onchange="hitung()" value="0" id="LBL0" type="hidden" class="form-control LBL rightJustified text-primary">
									<input name="PREMIPEG[]" onchange="hitung()" value="0" id="PREMIPEG0" type="hidden" class="form-control PREMIPEG rightJustified text-primary">
									<input name="TUNJANGAN[]" onchange="hitung()" value="0" id="TUNJANGAN0" type="hidden" class="form-control TUNJANGAN rightJustified text-primary">
									<input name="NETT[]" onchange="hitung()" value="0" id="NETT0" type="hidden" class="form-control NETT rightJustified text-primary" readonly>
									<input name="TOTALD[]" onchange="hitung()" value="0" id="TOTALD0" type="hidden" class="form-control TOTALD rightJustified text-primary" readonly>
									<input name="POT[]"  value="0" id="POT0" type="hidden" class="form-control POT rightJustified text-primary">
								</td>
								<td><input name="MSD[]" onchange="hitung()" value="0" id="MSD0" type="text" class="form-control MSD rightJustified text-primary"></td>
								<td><input name="IK[]" onchange="hitung()"  value="0" id="IK0" type="text" class="form-control IK rightJustified text-primary"></td>
								<td><input name="NB[]" onclick="select()" onchange="hitung()" value="0" id="NB0" type="text" class="form-control NB rightJustified text-primary" readonly></td>
								<td><input name="HR[]" onclick="select()" onchange="hitung()" value="0" id="HR0" type="text" class="form-control HR rightJustified text-primary"></td>
								<td><input name="TOTAL[]" onchange="hitung()" value="0" id="TOTAL0" type="text" class="form-control TOTAL rightJustified text-primary" readonly></td>
								<td><input name="BON1[]" onclick="select()" onchange="hitung()" value="0" id="BON10" type="text" class="form-control BON1 rightJustified text-primary"></td>
								<td><input name="SUBS[]" onclick="select()" onchange="hitung()" value="0" id="SUBS0" type="text" class="form-control SUBS rightJustified text-primary"></td>
								<td>
									<input name="SUB[]" id="SUB0" type="checkbox" value="1" class="checkbox_container" unchecked>
								</td>
								<td><input name="TOT_HR[]" onclick="select()" onchange="hitung()" value="0" id="TOT_HR0" type="text" class="form-control TOT_HR rightJustified text-primary" readonly></td>
								<td><input name="POTONG[]" onclick="select()" onchange="hitung()" value="0" id="POTONG0" type="text" class="form-control POTONG rightJustified text-primary"></td>
								<td><input name="JUMLAH[]" onchange="hitung()" value="0" id="JUMLAH0" type="text" class="form-control JUMLAH rightJustified text-primary" readonly></td>
								<td>
									<button type="button" class="btn btn-sm btn-circle btn-outline-danger btn-delete" onclick="">
										<i class="fa fa-fw fa-trash-alt"></i>
									</button>
								</td>
							</tr>
						</tbody>
						<tfoot>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td><input class="form-control TMSD rightJustified text-primary font-weight-bold" id="TMSD" name="TMSD" value="0" type="text" readonly></td>
							<td><input class="form-control TIK rightJustified text-primary font-weight-bold" id="TIK" name="TIK" value="0" readonly></td>
							<td><input class="form-control TNB rightJustified text-primary font-weight-bold" id="TNB" name="TNB" value="0" readonly></td>
							<td><input class="form-control THR rightJustified text-primary font-weight-bold" id="THR" name="THR" value="0" readonly></td>
							<td><input class="form-control TTOTAL rightJustified text-primary font-weight-bold" id="TTOTAL" name="TTOTAL" value="0" readonly></td>
							<td><input class="form-control TBON1 rightJustified text-primary font-weight-bold" id="TBON1" name="TBON1" value="0" readonly></td>
							<td><input class="form-control TSUBS rightJustified text-primary font-weight-bold" id="TSUBS" name="TSUBS" value="0" readonly></td>
							<td></td>
							<td><input class="form-control TTOT_HR rightJustified text-primary font-weight-bold" id="TTOT_HR" name="TTOT_HR" value="0" readonly></td>
							<td><input class="form-control TPOTONG rightJustified text-primary font-weight-bold" id="TPOTONG" name="TPOTONG" value="0" readonly></td>
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
						<th>Dragon</th>
						<th>Per</th>
						<th>Kik Nett</th>
						<th>Grup</th>
					</thead>
					<tbody>
					<?php
						$dr= $this->session->userdata['dr'];
						$per = $this->session->userdata['periode'];
						$sql = "SELECT hrd_premid.kd_bag AS KD_BAG, 
								hrd_premid.nm_bag AS NM_BAG, 
								hrd_premid.dr AS DR,
								hrd_premid.per AS PER,
								hrd_premid.tjumlah AS KIK_NETT,							
						
								hrd_bag.kd_grup AS KD_GRUP
							FROM hrd_premid, hrd_bor, hrd_bag 
							WHERE hrd_premid.dr='$dr' 
							AND hrd_premid.per='$per' 
							AND hrd_premid.kd_bag=hrd_bor.kd_bag 
							AND hrd_premid.kd_bag=hrd_bag.kd_bag 
							GROUP BY hrd_premid.kd_bag 
							ORDER BY hrd_premid.dr, hrd_premid.kd_bag";
						$a = $this->db->query($sql)->result();
						foreach($a as $b ) { 
					?>
						<tr>
							<td class='KBBVAL'><a href="#" class="select_kd_bag"><?php echo $b->KD_BAG;?></a></td>
							<td class='NBBVAL text_input'><?php echo $b->NM_BAG;?></td>
							<td class='DRBVAL text_input'><?php echo $b->DR;?></td>
							<td class='PRBVAL text_input'><?php echo $b->PER;?></td>
							<td class='KNBVAL text_input rightJustified text-primary font-weight-bold'><?php echo number_format($b->KIK_NETT,2,'.',',');?></td>
							<td class='KGBVAL text_input'><?php echo $b->KD_GRUP;?></td>
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
	var idrow = 1;
	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
	$(document).ready(function() {
		$("#KIK_NETT").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#LAIN").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#ORG").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#TOT_BON").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#OTHER").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#NETTO").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#TOT_POT").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#TMSD").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#TIK").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#TNB").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#THR").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#TTOTAL").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#TBON1").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#TSUBS").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#TTOT_HR").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#TPOTONG").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#TJUMLAH").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#TARIF1" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#TARIF2" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#GAJI" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#TASTEK" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#LBL" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#PREMIPEG" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#TUNJANGAN" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#NETT" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#TOTALD" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#MSD" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#IK" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#NB" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#HR" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#TOTAL" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#BON1" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#SUBS" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#TOT_HR" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#POTONG" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#POT" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#JUMLAH" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
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
			var val = $(this).parents("tr").find(".KNBVAL").text();
			target.parents("div").find(".KIK_NETT").val(val);


			var val = $(this).parents("tr").find(".KGBVAL").text();
		
			target.parents("div").find(".KD_GRUP").val(val);	
			$('#mymodal_bagian').modal('toggle');
			var kd_bag = $(this).parents("tr").find(".KBBVAL").text();
			$.ajax({
				type:'get',
				url : '<?php echo base_url('index.php/admin/Transaksi_Borongan_BoronganDragon/filter_kd_bag'); ?>',
				data:{ kd_bag : kd_bag},
				dataType: 'json',
				success:function(response) {
				// alert(response);
					var html = '';
                    var i;
                    for(i=0; i<response.length; i++){
                        html += '<tr>'+
									'<td><input name="REC[]" id=REC'+i+' type="text" class="form-control REC text_input" onkeypress="return tabE(this,event)" readonly value='+(i+1)+' ></td>'+
									'<td><input name="KD_PEG[]" value="'+response[i].KD_PEG+'" id=KD_PEG'+i+' type="text" class="form-control KD_PEG text_input" readonly></td>'+
									'<td>'+
										'<input name="NM_PEG[]" value="'+response[i].NM_PEG+'" id=NM_PEG'+i+' type="text" class="form-control NM_PEG text_input" readonly>'+
									'</td>'+
									'<td><input name="PTKP[]" value="'+response[i].PTKP+'" id=PTKP'+i+' type="text" class="form-control PTKP text_input" readonly></td>'+
									'<td>'+
										'<input name="STAT[]"  value="'+response[i].STAT+'" id=STAT'+i+' type="text" class="form-control STAT text_input"  readonly>'+
										'<input name="TARIF1[]" onchange="hitung()" id=TARIF1'+i+' value="'+numberWithCommas(response[i].TARIF1)+'" type="hidden" class="form-control TARIF1 rightJustified text-primary" readonly>'+
										'<input name="TARIF2[]" onchange="hitung()" id=TARIF2'+i+' value="'+numberWithCommas(response[i].TARIF2)+'" type="hidden" class="form-control TARIF2 rightJustified text-primary" readonly>'+
										'<input name="GAJI[]" onchange="hitung()" id=GAJI'+i+' value="'+numberWithCommas(response[i].GAJI)+'" type="hidden" class="form-control GAJI rightJustified text-primary" readonly>'+
										'<input name="TASTEK[]" onchange="hitung()" id=TASTEK'+i+' value="'+numberWithCommas(response[i].TASTEK)+'" type="hidden" class="form-control TASTEK rightJustified text-primary" readonly>'+
										'<input name="LBL[]" onchange="hitung()" id=LBL'+i+' value="'+numberWithCommas(response[i].LBL)+'" type="hidden" class="form-control LBL rightJustified text-primary" readonly>'+
										'<input name="PREMIPEG[]" onchange="hitung()" id=PREMIPEG'+i+' value="'+numberWithCommas(response[i].PREMIPEG)+'" type="hidden" class="form-control PREMIPEG rightJustified text-primary" readonly>'+
										'<input name="TUNJANGAN[]" onchange="hitung()" id=TUNJANGAN'+i+' value="'+numberWithCommas(response[i].TUNJANGAN)+'" type="hidden" class="form-control TUNJANGAN rightJustified text-primary" readonly>'+
										'<input name="NETT[]" value="'+response[i].NETT+'" id=NETT'+i+' type="hidden" class="form-control NETT rightJustified text-primary" readonly>'+
										'<input name="TOTALD[]" value="0" id=TOTALD'+i+' type="hidden" class="form-control TOTALD rightJustified text-primary" readonly>'+
										'<input name="POT[]"  value="0" id=POT'+i+' type="hidden" class="form-control POT rightJustified text-primary">'+
									'</td>'+
									'<td><input name="MSD[]" onchange="hitung()" value="0" id=MSD'+i+' type="text" class="form-control MSD rightJustified text-primary"></td>'+
									'<td><input name="IK[]" onchange="hitung()" value="0" id=IK'+i+' type="text" class="form-control IK rightJustified text-primary"></td>'+
									'<td><input name="NB[]" onchange="hitung()" id=NB'+i+' value="0" type="text" class="form-control NB rightJustified text-primary" readonly></td>'+
									'<td><input name="HR[]" onclick="select()" onchange="hitung()" id=HR'+i+' value="0" type="text" class="form-control HR rightJustified text-primary"></td>'+
									'<td><input name="TOTAL[]" onchange="hitung()" id=TOTAL'+i+' value="0" type="text" class="form-control TOTAL rightJustified text-primary" readonly></td>'+
									'<td><input name="BON1[]" onclick="select()" onchange="hitung()" value="0" id=BON1'+i+' type="text" class="form-control BON1 rightJustified text-primary"></td>'+
									'<td><input name="SUBS[]" onclick="select()" onchange="hitung()" value="0" id=SUBS'+i+' type="text" class="form-control SUBS rightJustified text-primary"></td>'+
									'<td><input name="SUB[]" id=SUB'+i+' type="checkbox" class="checkbox_container" value="0" unchecked></td>'+
									'<td><input name="TOT_HR[]" onclick="select()" onchange="hitung()" value="0" id=TOT_HR'+i+' type="text" class="form-control TOT_HR rightJustified text-primary" readonly></td>'+
									'<td><input name="POTONG[]" onclick="select()" onchange="hitung()" value="0" id=POTONG'+i+' type="text" class="form-control POTONG rightJustified text-primary"></td>'+
									'<td><input name="JUMLAH[]" onchange="hitung()" value="0" id=JUMLAH'+i+' type="text" class="form-control JUMLAH rightJustified text-primary" readonly></td>'+
									'<td><input type="hidden" name="NO_ID[]" id=NO_ID'+i+'  class="form-control"  value="0"  >'+
									'<button type="button" class="btn btn-sm btn-circle btn-outline-danger btn-delete" onclick=""> <i class="fa fa-fw fa-trash-alt"></i> </button></td>'+
								'</tr>';
                    }
					idrow=i;
					$('#show-data').html(html);
					jumlahdata = idrow+1 ;
					for(i=0; i<=jumlahdata; i++){
						$("#TARIF1" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
						$("#TARIF2" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
						$("#GAJI" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
						$("#TASTEK" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
						$("#LBL" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
						$("#PREMIPEG" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
						$("#TUNJANGAN" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
						$("#NETT" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
						$("#TOTALD" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
						$("#MSD" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
						$("#IK" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
						$("#NB" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
						$("#HR" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
						$("#TOTAL" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
						$("#BON1" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
						$("#SUBS" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
						$("#TOT_HR" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
						$("#POTONG" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
						$("#JUMLAH" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
						$("#POT" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
					}
					hitung();
					$('input[type="checkbox"]').on('change', function(){
						this.value ^= 1;
						//console.log( this.value )
					});
				}
			});
		});
		$('body').on('click', '.btn-delete', function() {
			var val = $(this).parents("tr").remove();
			idrow--;
			nomor();
		});
		$('input[type="checkbox"]').on('change', function(){
			this.value ^= 1;
			//console.log( this.value )
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

	function isims() {
		var total_row = idrow;
		for (i=0;i<total_row;i++) {
			var tmsx = parseFloat($('#TMS').val().replace(/,/g, ''));
			var msd = tmsx + 0;
			var msd = msd.toFixed(2);
			if(isNaN(msd)) msd = 0;
			$('#MSD'+i).val(numberWithCommas(msd));
			$('#IK'+i).val(numberWithCommas(msd));

		}
		hitung();
	}

	function hitung() {
		
		var KIK_NETT = parseFloat($('#KIK_NETT').val().replace(/,/g, ''));
		var LAIN = parseFloat($('#LAIN').val().replace(/,/g, ''));
		var KD_GRUP = $('#KD_GRUP'+i).val();
		var PREMI = 0;
		var ORG = 0;
		var TOT_BON = 0;
		var OTHER = 0;
		var NETTO = 0;
		var TOT_POT = 0;
		var TMSD = 0;
		var TIK = 0;
		var TNB = 0;
		var THR = 0;
		var TTOTAL = 0;
		var TBON1 = 0;
		var TSUBS = 0;
		var TTOT_HR = 0;
		var TPOTONG = 0;
		var TJUMLAH = 0;

		NETTO = KIK_NETT - LAIN;
	//	console.log(NETTO+KIK_NETT+LAIN);
	
		var total_row = idrow;
///////////////////////////////////////////// LOOP 1
		for (i=0;i<total_row;i++) {
			var stat = $('#STAT'+i).val();
			var nb = parseFloat($('#NB'+i).val().replace(/,/g, ''));
			var tarif1 = parseFloat($('#TARIF1'+i).val().replace(/,/g, ''));
			var tarif2 = parseFloat($('#TARIF2'+i).val().replace(/,/g, ''));
			var ik = parseFloat($('#IK'+i).val().replace(/,/g, ''));
			var msd = parseFloat($('#MSD'+i).val().replace(/,/g, ''));
			var bon1 = parseFloat($('#BON1'+i).val().replace(/,/g, ''));

			if (PREMI == 1) {
				nb = tarif1*ik;
			} else {
				if (ik < msd) {
					nb = tarif2*ik;
				} else {
					nb = tarif1*msd;
				}
			}
			nb = nb.toFixed(2);
			if(isNaN(nb)) nb = 0;
			$('#NB'+i).val(numberWithCommas(nb));
		}

///////////////////////////////////////////// END LOOP 1

		var x11 = 0;
		var x12 = 0;
		var x13 = 0;
		var x14 = 0;
		var x15 = 0;
		var x31 = 0;
		var x32 = 0;
		var x41 = 0;
		var x42 = 0;

///////////////////////////////////////////// LOOP 2
		for (i=0;i<total_row;i++) {
			var stat = $('#STAT'+i).val();
			var nb = parseFloat($('#NB'+i).val().replace(/,/g, ''));
			if (stat < 'X') {
				x13 = x13+nb;
			}
			x11 = x11+nb;
		}
		TNB = x11;
///////////////////////////////////////////// END LOOP 2

		var x123 = x11;
		var x44 = 0;

///////////////////////////////////////////// LOOP 3
		if (x12 > 0) {
			for (i=0;i<total_row;i++) {
				var stat = $('#STAT'+i).val();
				var ik = parseFloat($('#IK'+i).val().replace(/,/g, ''));
				var nb = parseFloat($('#NB'+i).val().replace(/,/g, ''));

				if (stat < 'X' && ik > 0) {
					x11 = x11-nb+(x13*nb*0.01/ik);
				}
			}
		}

		if (x11 > 0) {
			x14 = NETTO/x11;
			x41 = TOT_BON/x11;
			x44 = TOT_BON/x123;
		
		}


///////////////////////////////////////////// END LOOP 3

		var x1 = 0;
		var x2 = 0;
		var x3 = 0;
		var x4 = 0;
		var x5 = 0;
		var x6 = 0;
		var x7 = 0;
		var x8 = 0;
		var x33 = 0;
		var x34 = 0;
		var xx = 0;
		var zz = 0 ;
        var tik = 0;
	
        var tot_ik = 0;

///////////////////////////////////////////// LOOP 4

		for (i=0;i<total_row;i++) {
			var nm_peg = $('#NM_PEG'+i).val();
			var kd_peg = $('#KD_PEG'+i).val();
			var stat = $('#STAT'+i).val();
			var msd = parseFloat($('#MSD'+i).val().replace(/,/g, ''));
			var ik = parseFloat($('#IK'+i).val().replace(/,/g, ''));
			var nb = parseFloat($('#NB'+i).val().replace(/,/g, ''));
		
			var total = parseFloat($('#TOTAL'+i).val().replace(/,/g, ''));
			var totald = parseFloat($('#TOTALD'+i).val().replace(/,/g, ''));
			var potong = parseFloat($('#POTONG'+i).val().replace(/,/g, ''));
			var bon1 = parseFloat($('#BON1'+i).val().replace(/,/g, ''));
			var tot_hr = parseFloat($('#TOT_HR'+i).val().replace(/,/g, ''));
			var hr = parseFloat($('#HR'+i).val().replace(/,/g, ''));
			var nett = parseFloat($('#NETT'+i).val().replace(/,/g, ''));
			var tastek = parseFloat($('#TASTEK'+i).val().replace(/,/g, ''));
			var lbl = parseFloat($('#LBL'+i).val().replace(/,/g, ''));
			var premipeg = parseFloat($('#PREMIPEG'+i).val().replace(/,/g, ''));
			var tunjangan = parseFloat($('#TUNJANGAN'+i).val().replace(/,/g, ''));
			var gaji = parseFloat($('#GAJI'+i).val().replace(/,/g, ''));
			var jumlah= 0;
			var pot = 0 ;
			var subs = parseFloat($('#SUBS'+i).val().replace(/,/g, ''));
            var sub = parseFloat($('#SUB'+i).val().replace(/,/g, ''));
			x9=0;
		
			tot_ik = tot_ik +ik;
			if (TNB > 0) {
				if (ik > 0) {
					if (stat < 'X') {
						x9 = Math.floor( (x14*nb)+0.5)
							x9 = x9.toFixed(2);
							console.log('1 '+nm_peg+'\n jumlah : '+x14+'\n nb :' +nb+'\n hasil :'+x9);
						} else {
							x9 = Math.floor((x14*x13*nb*0.01/ik)+0.5)
							x9 = x9.toFixed(2);
							//console.log('2 '+nm_peg+'\n jumlah : '+x14+'\n nb :' +nb+'\n hasil :'+x9);
						}
					}
					var x10=0;
					if (msd = ik && stat<'X'){
						if ((x9+(x41*nb)) < (msd*nett) ) {
							x10 = (msd*nett) - (x9+(x41*nb))
						}
					}

					total = x9;
					pot = 0;
					totald = x9+x10+potong;
					tot_hr = hr*(gaji+tastek+lbl+premipeg+tunjangan);
					console.log('hari'+hr+'total hari ='+tot_hr+'gaji = '+gaji+'tastek ='+tastek+' lbl ='+lbl+'premi = '+premipeg+'tunjangan ='+ tunjangan);

					var kodepegawai = kd_peg.substr(0,1);
					console.log(kodepegawai);
					if (kodepegawai != 'D'){
                        pot = 2500 * ik;
						console.log('ok');
					}
                    total = total - pot ;
					x33 = x33 + pot;

                    if(subs == 0){
						sub = 0;
						jumlah = parseInt(total)+parseInt(tot_hr)+parseInt(subs)+parseInt(bon1);
					}

					if (KD_GRUP == 'C01' && stat == 'A1'&& x9 < ( nett * ik) ){
						sub = 0;
						jumlah = parseInt(total)+parseInt(tot_hr)+parseInt(subs)+parseInt(bon1);
                        totald=jumlah;
					} 

					var y1 = 0;
					var y2 = 0;

					y1 = tot_hr;
					y2 = total;


					// jumlah = parseInt(y1)+parseInt(y2);
				//	jumlah = parseInt(total)+parseInt(tot_hr)+parseInt(subs)+parseInt(potong)+parseInt(bon1);
				//	console.log(nm_peg+'\n jumlah : '+jumlah+'\n total : '+total+'\n tot_hr : '+tot_hr+'\n subs : '+subs+'\n potong : '+potong+'\n bon1 : '+bon1);


				    if(isNaN(pot)) pot = 0;
					$('#POT'+i).val(numberWithCommas(pot));
					if(isNaN(total)) total = 0;
					$('#TOTAL'+i).val(numberWithCommas(total));

					if(isNaN(totald)) totald = 0;
					$('#TOTALD'+i).val(numberWithCommas(totald));

					if(isNaN(bon1)) bon1 = 0;
					$('#BON1'+i).val(numberWithCommas(bon1));

					if(isNaN(tot_hr)) tot_hr = 0;
					$('#TOT_HR'+i).val(numberWithCommas(tot_hr));

					if(isNaN(jumlah)) jumlah = 0;
					$('#JUMLAH'+i).val(numberWithCommas(jumlah));
				
			}
		}

/////////////////////////////////////////// LOOP 5
		zz=x33/tot_ik;
		console.log('ZZ = '+zz+' X33 ='+x33+'TOT_IK ='+tot_ik );
		for (i=0;i<total_row;i++) {
			var nm_peg = $('#NM_PEG'+i).val();
			var kd_peg = $('#KD_PEG'+i).val();
			var stat = $('#STAT'+i).val();
			var msd = parseFloat($('#MSD'+i).val().replace(/,/g, ''));
			var ik = parseFloat($('#IK'+i).val().replace(/,/g, ''));
			var nb = parseFloat($('#NB'+i).val().replace(/,/g, ''));
			var gaji = parseFloat($('#GAJI'+i).val().replace(/,/g, ''));
			var total = parseFloat($('#TOTAL'+i).val().replace(/,/g, ''));
			var totald = parseFloat($('#TOTALD'+i).val().replace(/,/g, ''));
			var potong = parseFloat($('#POTONG'+i).val().replace(/,/g, ''));
			var bon1 = parseFloat($('#BON1'+i).val().replace(/,/g, ''));
			var tot_hr = parseFloat($('#TOT_HR'+i).val().replace(/,/g, ''));
			var hr = parseFloat($('#HR'+i).val().replace(/,/g, ''));
			var nett = parseFloat($('#NETT'+i).val().replace(/,/g, ''));
			var tastek = parseFloat($('#TASTEK'+i).val().replace(/,/g, ''));
			var lbl = parseFloat($('#LBL'+i).val().replace(/,/g, ''));
			var premipeg = parseFloat($('#PREMIPEG'+i).val().replace(/,/g, ''));
			var tunjangan = parseFloat($('#TUNJANGAN'+i).val().replace(/,/g, ''));
			var jumlah = parseFloat($('#JUMLAH'+i).val().replace(/,/g, ''));

			if (msd==0) {
				total = 0;
			} else {
				total= Math.round(total+(zz*ik));
			}  
			jumlah = parseInt(total)+parseInt(tot_hr)+parseInt(subs)+parseInt(bon1);
            totald = jumlah;

			if(isNaN(total)) total = 0;
			$('#TOTAL'+i).val(numberWithCommas(total));
			if(isNaN(totald)) totald = 0;

			$('#TOTALD'+i).val(numberWithCommas(totald));
			if(isNaN(jumlah)) jumlah = 0;
			$('#JUMLAH'+i).val(numberWithCommas(jumlah));
		}	

        TOT_POT = 0;
		TMSD = 0;
		TIK = 0;
		TNB = 0;
		THR = 0;
		TTOTAL = 0;
		TBON1 = 0;
		TSUBS = 0;
		TTOT_HR = 0;
		TPOTONG = 0;
		TJUMLAH = 0;

		$(".POT").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			TOT_POT+=val;
		});

		$(".MSD").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			TMSD+=val;
		});

		$(".IK").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			TIK+=val;
		});

		$(".NB").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			TNB+=val;
		});

		$(".HR").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			THR+=val;
		});

		$(".TOTAL").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			TTOTAL+=val;
		});

		$(".BON1").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			TBON1+=val;
		});

		$(".SUBS").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			TSUBS+=val;
		});

		$(".TOT_HR").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			TTOT_HR+=val;
		});

		$(".POTONG").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			TPOTONG+=val;
		});

		$(".JUMLAH").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			TJUMLAH+=val;
		});

		if(isNaN(TOT_POT)) TOT_POT = 0;
		if(isNaN(TMSD)) TMSD = 0
		if(isNaN(TIK)) TIK = 0;
		if(isNaN(TNB)) TNB = 0;
		if(isNaN(THR)) THR = 0;
		if(isNaN(TTOTAL)) TTOTAL = 0;
		if(isNaN(TBON1)) TBON1 = 0;
		if(isNaN(TSUBS)) TSUBS = 0;
		if(isNaN(TTOT_HR)) TTOT_HR = 0;
		if(isNaN(TPOTONG)) TPOTONG = 0;
		if(isNaN(TJUMLAH)) TJUMLAH = 0;

		$('#TOT_POT').val(numberWithCommas(TOT_POT));
		$('#TMSD').val(numberWithCommas(TMSD));
		$('#TIK').val(numberWithCommas(TIK));
		$('#TNB').val(numberWithCommas(TNB));
		$('#THR').val(numberWithCommas(THR));
		$('#TTOTAL').val(numberWithCommas(TTOTAL));
		$('#TBON1').val(numberWithCommas(TBON1));
		$('#TSUBS').val(numberWithCommas(TSUBS));
		$('#TTOT_HR').val(numberWithCommas(TTOT_HR));
		$('#TPOTONG').val(numberWithCommas(TPOTONG));
		$('#TJUMLAH').val(numberWithCommas(TJUMLAH));

		$("#TMSD").autoNumeric('update');
		$("#TIK").autoNumeric('update');
		$("#TNB").autoNumeric('update');
		$("#THR").autoNumeric('update');
		$("#TTOTAL").autoNumeric('update');
		$("#TBON1").autoNumeric('update');
		$("#TSUBS").autoNumeric('update');
		$("#TTOT_HR").autoNumeric('update');
		$("#TPOTONG").autoNumeric('update');
		$("#TJUMLAH").autoNumeric('update');
	
		if(isNaN(NETTO)) NETTO = 0;
		$('#NETTO').val(numberWithCommas(NETTO));
		$("#NETTO").autoNumeric('update');

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

		var nm_peg0 = "<div class='input-group'><select class='js-example-responsive-nm_peg form-control NM_PEG0' name='NM_PEG[]' id=NM_PEG0" + idrow + " onchange='nm_peg(this.id)' onfocusout='hitung()' required></select></div>";
		
		// var nm_peg = nm_peg0+nm_peg1+nm_peg2;

		td1.innerHTML = "<input name='REC[]' id=REC" + idrow + " type='text' class='REC form-control' onkeypress='return tabE(this,event)' readonly>";
		td2.innerHTML = "<input name='KD_PEG[]' id=KD_PEG0" + idrow + " type='text' class='form-control KD_PEG' readonly>";
		td3.innerHTML = nm_peg0;
		td4.innerHTML = "<input name='PTKP[]' id=PTKP0" + idrow + " type='text' class='form-control PTKP' readonly>";
		td5.innerHTML = "<input name='MSD[]' onclick='select()' onchange='hitung()' value='0' id=MSD" + idrow + " type='text' class='form-control MSD rightJustified text-primary'>";
		td6.innerHTML = "<input name='IK[]' onclick='select()' onchange='hitung()' value='0' id=IK" + idrow + " type='text' class='form-control IK rightJustified text-primary'>";
		td7.innerHTML = "<input name='NB[]' onclick='select()' onchange='hitung()' value='0' id=NB" + idrow + " type='text' class='form-control NB rightJustified text-primary'>";
		td8.innerHTML = "<input name='HR[]' onchange='hitung()' value='0' id=HR" + idrow + " type='text' class='form-control HR rightJustified text-primary' readonly>";
		td9.innerHTML = "<input name='TOTAL[]' onchange='hitung()' value='0' id=TOTAL" + idrow + " type='text' class='form-control TOTAL rightJustified text-primary' readonly>";
		td10.innerHTML = "<input name='BON1[]' onclick='select()' onchange='hitung()' value='0' id=BON1" + idrow + " type='text' class='form-control BON1 rightJustified text-primary'>";
		td11.innerHTML = "<input name='SUBS[]' onclick='select()' onchange='hitung()' value='0' id=SUBS" + idrow + " type='text' class='form-control SUBS rightJustified text-primary'>";
		td12.innerHTML = "<input name='SUB[]' id=SUB0" + idrow + " type='text' class='form-control SUB'>";
		td13.innerHTML = "<input name='TOT_HR[]' onchange='hitung()' value='0' id=TOT_HR" + idrow + " type='text' class='form-control TOT_HR rightJustified text-primary' readonly>";
		td14.innerHTML = "<input name='POTONG[]' onclick='select()' onchange='hitung()' value='0' id=POTONG" + idrow + " type='text' class='form-control POTONG rightJustified text-primary'>";
		td15.innerHTML = "<input name='JUMLAH[]' onclick='select()' onchange='hitung()' value='0' id=JUMLAH" + idrow + " type='text' class='form-control JUMLAH rightJustified text-primary' readonly>";
		td16.innerHTML = "<input type='hidden' name='NO_ID[]' id=NO_ID" + idrow + "  class='form-control'>" +
			" <button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>";
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#MSD" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#IK" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#NB" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#HR" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#TOTAL" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#BON1" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#SUBS" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#TOT_HR" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#POTONG" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#JUMLAH" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
		}
		idrow++;
		nomor();
		$(".ronly").on('keydown paste', function(e) {
			e.preventDefault();
			e.currentTarget.blur();
		});
		select_nm_peg();
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
				url: "<?= base_url('admin/Transaksi_Borongan_BoronganDragon/getDataAjax_Pegawai') ?>",
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
			"<div class='select2-result-repository clearfix'>" +
			"<div class='select2-result-repository__title'></div>" +
			"</div>"
		);
		$container.find(".select2-result-repository__title").text(repo_nm_peg.nm_peg);
		return $container;
	}
	var nett = '';
	var kd_peg = '';
	var ptkp = '';
	var stat = '';
	
	function formatSelection_nm_peg(repo_nm_peg) {
		nett = repo_nm_peg.nett;
		kd_peg = repo_nm_peg.kd_peg;
		ptkp = repo_nm_peg.ptkp;
		stat = repo_nm_peg.stat;
		return repo_nm_peg.text;
	}

	function nm_peg(x) {
		var q = x.substring(6, 10);
		$('#TOTAL' + q).val(nett);
		$('#KD_PEG' + q).val(kd_peg);
		$('#PTKP' + q).val(ptkp);
		$('#STAT' + q).val(stat);
	}

</script>