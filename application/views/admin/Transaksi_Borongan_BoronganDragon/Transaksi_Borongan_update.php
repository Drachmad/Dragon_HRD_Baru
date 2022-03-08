<?php
	foreach ($transaksi_borongan as $rowh) {};
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
</style>

<div class="container-fluid">
	<br>
	<div class="alert alert-success alert-container" role="alert">
		<i class="fas fa-university"></i> Update <?php echo $this->session->userdata['judul']; ?>
	</div>
	<form id="transaksiborongan" name="transaksiborongan" action="<?php echo base_url('admin/Transaksi_Borongan/update_aksi'); ?>" class="form-horizontal needs-validation" method="post" novalidate>
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
							<input class="form-control text_input DR" id="DR" name="DR" type="hidden" value="<?php echo $rowh->DR ?>" readonly>
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
							<label class="label">Premi </label>
						</div>
						<div class="col-md-2">
							<input class="form-control TPREMI rightJustified text-primary font-weight-bold" id="TPREMI" name="TPREMI" value="<?php echo number_format($rowh->TPREMI, 2, '.', ','); ?>" readonly>
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
								<th width="75px">Ptkp</th>
								<th width="120px">Ms</th>
								<th width="120px">Ik</th>
								<th width="120px">Nb</th>
								<th width="100px">Hr</th>
								<th width="100px">Gaji</th>
								<th width="100px">Bon</th>
								<th width="100px">Subsidi</th>
								<th width="100px">Sub</th>
								<th width="100px">Harian</th>
								<th width="100px">Lain</th>
								<th width="100px">Jumlah</th>
								<th width="50px"></th>
							</tr>
						</thead>
						<tbody>
						<?php
							$no = 0;
							foreach ($transaksi_borongan as $row) : 
						?>
							<tr>
								<td><input name="REC[]" id="REC<?php echo $no; ?>" value="<?= $row->REC ?>" type="text" class="form-control REC" onkeypress="return tabE(this,event)" readonly></td>
								<td><input name="KD_PEG[]" id="KD_PEG<?php echo $no; ?>" value="<?= $row->KD_PEG ?>" type="text" class="form-control KD_PEG" readonly></td>
								<td>
									<input name="PREMI[]" id="PREMI<?php echo $no; ?>" value="<?php echo number_format($row->PREMI, 2, '.', ','); ?>" type="hidden" class="form-control PREMI rightJustified text-primary" readonly>
									<input name="PREMI_HR[]" id="PREMI_HR<?php echo $no; ?>" value="<?php echo number_format($row->PREMI_HR, 2, '.', ','); ?>" type="hidden" class="form-control PREMI_HR rightJustified text-primary" readonly>
									<input name="NM_PEG[]" id="NM_PEG<?php echo $no; ?>" value="<?= $row->NM_PEG ?>" type="text" class="form-control NM_PEG" readonly>
								</td>
								<td><input name="PTKP[]" id="PTKP<?php echo $no; ?>" value="<?= $row->PTKP ?>" type="text" class="form-control PTKP" readonly></td>
								<td><input name="MS[]" onclick="select()" onchange="hitung()" id="MS<?php echo $no; ?>" value="<?php echo number_format($row->MS, 2, '.', ','); ?>" type="text" class="form-control MS rightJustified text-primary"></td>
								<td><input name="IK[]" onclick="select()" onchange="hitung()" id="IK<?php echo $no; ?>" value="<?php echo number_format($row->IK, 2, '.', ','); ?>" type="text" class="form-control IK rightJustified text-primary"></td>
								<td><input name="NB[]" onclick="select()" onchange="hitung()" id="NB<?php echo $no; ?>" value="<?php echo number_format($row->NB, 2, '.', ','); ?>" type="text" class="form-control NB rightJustified text-primary"></td>
								<td><input name="HR[]" onclick="select()" onchange="hitung()" id="HR<?php echo $no; ?>" value="<?php echo number_format($row->HR, 2, '.', ','); ?>" type="text" class="form-control HR rightJustified text-primary" readonly></td>
								<td><input name="NETT[]" onchange="hitung()" id="NETT<?php echo $no; ?>" value="<?php echo number_format($row->NETT, 2, '.', ','); ?>" type="text" class="form-control NETT rightJustified text-primary" readonly></td>
								<td><input name="BON[]" onclick="select()" onchange="hitung()" id="BON<?php echo $no; ?>" value="<?php echo number_format($row->BON, 2, '.', ','); ?>" type="text" class="form-control BON rightJustified text-primary"></td>
								<td><input name="SUBSIDI[]" onclick="select()" onchange="hitung()" id="SUBSIDI<?php echo $no; ?>" value="<?php echo number_format($row->SUBSIDI, 2, '.', ','); ?>" type="text" class="form-control SUBSIDI rightJustified text-primary"></td>
								<td><input name="SUB[]" id="SUB<?php echo $no; ?>" value="<?= $row->SUB ?>" type="text" class="form-control SUB"></td>
								<td><input name="HARIAN[]" onchange="hitung()" id="HARIAN<?php echo $no; ?>" value="<?php echo number_format($row->HARIAN, 2, '.', ','); ?>" type="text" class="form-control HARIAN rightJustified text-primary" readonly></td>
								<td><input name="LAIN[]" onclick="select()" onchange="hitung()" id="LAIN<?php echo $no; ?>" value="<?php echo number_format($row->LAIN, 2, '.', ','); ?>" type="text" class="form-control LAIN rightJustified text-primary"></td>
								<td><input name="JUMLAH[]" onchange="hitung()" id="JUMLAH<?php echo $no; ?>" value="<?php echo number_format($row->JUMLAH, 2, '.', ','); ?>" type="text" class="form-control JUMLAH rightJustified text-primary" readonly></td>
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
							<td>
								<input type="hidden" class="form-control TPREMI_HR rightJustified text-primary font-weight-bold" id="TPREMI_HR" name="TPREMI_HR" value="<?php echo number_format($rowh->TPREMI_HR, 2, '.', ','); ?>" readonly>
								<input type="hidden" class="form-control THARIAN rightJustified text-primary font-weight-bold" id="THARIAN" name="THARIAN" value="<?php echo number_format($rowh->THARIAN, 2, '.', ','); ?>" readonly>
							</td>
							<td><input class="form-control TMS rightJustified text-primary font-weight-bold" id="TMS" name="TMS" value="<?php echo number_format($rowh->TMS, 2, '.', ','); ?>" readonly></td>
							<td><input class="form-control TIK rightJustified text-primary font-weight-bold" id="TIK" name="TIK" value="<?php echo number_format($rowh->TIK, 2, '.', ','); ?>" readonly></td>
							<td><input class="form-control TNB rightJustified text-primary font-weight-bold" id="TNB" name="TNB" value="<?php echo number_format($rowh->TNB, 2, '.', ','); ?>" readonly></td>
							<td><input class="form-control T_HR rightJustified text-primary font-weight-bold" id="T_HR" name="T_HR" value="<?php echo number_format($rowh->T_HR, 2, '.', ','); ?>" readonly></td>
							<td><input class="form-control TNETT rightJustified text-primary font-weight-bold" id="TNETT" name="TNETT" value="<?php echo number_format($rowh->TNETT, 2, '.', ','); ?>" readonly></td>
							<td><input class="form-control TBON rightJustified text-primary font-weight-bold" id="TBON" name="TBON" value="<?php echo number_format($rowh->TBON, 2, '.', ','); ?>" readonly></td>
							<td><input class="form-control TSUBSIDI rightJustified text-primary font-weight-bold" id="TSUBSIDI" name="TSUBSIDI" value="<?php echo number_format($rowh->TSUBSIDI, 2, '.', ','); ?>" readonly></td>
							<td></td>
							<td></td>
							<td><input class="form-control TJUMLAH rightJustified text-primary font-weight-bold" id="TJUMLAH" name="TJUMLAH" value="<?php echo number_format($row->TJUMLAH, 2, '.', ','); ?>" readonly></td>
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
						<th>Nama Grup</th>
						<th>Kode Grup</th>
						<th>Dragon</th>
					</thead>
					<tbody>
					<?php
						$dr= $this->session->userdata['dr'];
						$sql = "SELECT hrd_bag.kd_bag AS KD_BAG, 
								hrd_bag.nm_bag AS NM_BAG, 
								hrd_bag.kd_grup AS KD_GRUP, 
								hrd_bag.nm_grup AS NM_GRUP,
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
		$("#TPREMI").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#TPREMI_HR").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#THARIAN").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#TMS").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#TIK").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#TNB").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#T_HR").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#TNETT").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#TBON").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#TSUBSIDI").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#TJUMLAH").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#PREMI" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#PREMI_HR" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#MS" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#IK" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#NB" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#HR" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#NETT" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#BON" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#SUBSIDI" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#HARIAN" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#LAIN" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
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
			var val = $(this).parents("tr").find(".KDBVAL").text();
			target.parents("div").find(".KD_GRUP").val(val);	
			var val = $(this).parents("tr").find(".NGBVAL").text();
			target.parents("div").find(".NM_GRUP").val(val);	
			var val = $(this).parents("tr").find(".DRBVAL").text();
			target.parents("div").find(".DR").val(val);	
			$('#mymodal_bagian').modal('toggle');
			var kd_bag = $(this).parents("tr").find(".KBBVAL").text();
			$.ajax({
				type:'get',
				url : '<?php echo base_url('index.php/admin/Transaksi_Borongan/filter_kd_bag'); ?>',
				data:{ kd_bag : kd_bag},
				dataType: 'json',
				success:function(response) {
				// alert(response);
					var html = '';
                    var i;
                    for(i=0; i<response.length; i++){
                        html += '<tr>'+
									'<td><input name="REC[]" id=REC'+i+' type="text" class="form-control REC" onkeypress="return tabE(this,event)" readonly value='+(i+1)+' ></td>'+
									'<td><input name="KD_PEG[]" value="'+response[i].KD_PEG+'" id=KD_PEG'+i+' type="text" class="form-control KD_PEG" readonly></td>'+
									'<td>'+
										'<input name="NM_PEG[]" value="'+response[i].NM_PEG+'" id=NM_PEG'+i+' type="text" class="form-control NM_PEG" readonly>'+
										'<input name="PREMI[]" type="hidden" onchange="hitung()" value="'+numberWithCommas(response[i].PREMI)+'" id=PREMI'+i+' readonly class="form-control PREMI rightJustified text-primary">'+
										'<input name="PREMI_HR[]" type="hidden" onchange="hitung()" id=PREMI_HR'+i+' value="0" class="form-control PREMI_HR rightJustified text-primary" readonly>'+
									'</td>'+
									'<td><input name="PTKP[]" id=PTKP'+i+' type="text" class="form-control PTKP"></td>'+
									'<td><input name="MS[]" onclick="select()" onchange="hitung()" value="0" id=MS'+i+' type="text" class="form-control MS rightJustified text-primary"></td>'+
									'<td><input name="IK[]" onclick="select()" onchange="hitung()" value="0" id=IK'+i+' type="text" class="form-control IK rightJustified text-primary"></td>'+
									'<td><input name="NB[]" onclick="select()" onchange="hitung()" value="0" id=NB'+i+' type="text" class="form-control NB rightJustified text-primary"></td>'+
									'<td><input name="HR[]" onclick="select()" onchange="hitung()" id=HR'+i+' value="0" type="text" class="form-control HR rightJustified text-primary" readonly></td>'+
									'<td><input name="NETT[]" onchange="hitung()" id=NETT'+i+' value="'+numberWithCommas(response[i].NETT)+'" type="text" class="form-control NETT rightJustified text-primary" readonly></td>'+
									'<td><input name="BON[]" onclick="select()" onchange="hitung()" value="0" id=BON'+i+' type="text" class="form-control BON rightJustified text-primary"></td>'+
									'<td><input name="SUBSIDI[]" onclick="select()" onchange="hitung()" value="0" id=SUBSIDI'+i+' type="text" class="form-control SUBSIDI rightJustified text-primary"></td>'+
									'<td><input name="SUB[]" id=SUB'+i+' type="text" class="form-control SUB"></td>'+
									'<td><input name="HARIAN[]" onchange="hitung()" value="0" id=HARIAN'+i+' type="text" class="form-control HARIAN rightJustified text-primary" readonly></td>'+
									'<td><input name="LAIN[]" onclick="select()" onchange="hitung()" value="0" id=LAIN'+i+' type="text" class="form-control LAIN rightJustified text-primary"></td>'+
									'<td><input name="JUMLAH[]" onchange="hitung()" value="0" id=JUMLAH'+i+' type="text" class="form-control JUMLAH rightJustified text-primary" readonly></td>'+
									'<td><input type="hidden" name="NO_ID[]" id=NO_ID'+i+'  class="form-control NO_ID"  value="'+response[i].NO_ID+'"  >'+
									'<button type="button" class="btn btn-sm btn-circle btn-outline-danger btn-delete" onclick=""> <i class="fa fa-fw fa-trash-alt"></i> </button></td>'+
								'</tr>';
                    }
					idrow=i;
					$('#show-data').html(html);
					jumlahdata = 100 ;
					for(i=0; i<=jumlahdata; i++){
						$("#PREMI" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
						$("#PREMI_HR" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
						$("#MS" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
						$("#IK" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
						$("#NB" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
						$("#HR" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
						$("#NETT" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
						$("#BON" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
						$("#SUBSIDI" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
						$("#HARIAN" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
						$("#LAIN" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
						$("#JUMLAH" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
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
		var TPREMI = 0;
		var TPREMI_HR = 0;
		var THARIAN = 0;
		var TMS = 0;
		var TIK = 0;
		var TNB = 0;
		var T_HR = 0;
		var TNETT = 0;
		var TBON = 0;
		var TSUBSIDI = 0;
		var TJUMLAH = 0;
		var total_row = idrow;
		for (i=0;i<total_row;i++) {
			var pl = parseFloat($('#PREMI'+i).val().replace(/,/g, ''));
			var ms = parseFloat($('#MS'+i).val().replace(/,/g, ''));
			var ik = parseFloat($('#IK'+i).val().replace(/,/g, ''));
			var nb = parseFloat($('#NB'+i).val().replace(/,/g, ''));
			var hr = parseFloat($('#HR'+i).val().replace(/,/g, ''));
			var nett = parseFloat($('#NETT'+i).val().replace(/,/g, ''));
			var bon = parseFloat($('#BON'+i).val().replace(/,/g, ''));
			var subsidi = parseFloat($('#SUBSIDI'+i).val().replace(/,/g, ''));
			var lain = parseFloat($('#LAIN'+i).val().replace(/,/g, ''));

			var harian = nett*ms;
			if(isNaN(harian)) harian = 0;
			$('#HARIAN'+i).val(numberWithCommas(harian));
			$('#HARIAN'+i).autoNumeric('update');

			var pl_hr = pl*hr;
			if(isNaN(pl_hr)) pl_hr = 0;
			$('#PREMI_HR'+i).val(numberWithCommas(pl_hr));
			$('#PREMI_HR'+i).autoNumeric('update');

			var jumlah = ik+nb+hr+bon+subsidi+harian+lain;
			jumlah = jumlah.toFixed(2);
			if(isNaN(jumlah)) jumlah = 0;
			$('#JUMLAH'+i).val(numberWithCommas(jumlah));
			$('#JUMLAH'+i).autoNumeric('update');
		};
		$(".PREMI").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			TPREMI+=val;
		});
		$(".PREMI_HR").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			TPREMI_HR+=val;
		});
		$(".HARIAN").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			THARIAN+=val;
		});
		$(".MS").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			TMS+=val;
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
			T_HR+=val;
		});
		$(".NETT").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			TNETT+=val;
		});
		$(".BON").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			TBON+=val;
		});
		$(".SUBSIDI").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			TSUBSIDI+=val;
		});
		$(".JUMLAH").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			TJUMLAH+=val;
		});

		if(isNaN(TPREMI)) TPREMI = 0;
		if(isNaN(TPREMI_HR)) TPREMI_HR = 0;
		if(isNaN(THARIAN)) THARIAN = 0;
		if(isNaN(TMS)) TMS = 0;
		if(isNaN(TIK)) TIK = 0;
		if(isNaN(TNB)) TNB = 0;
		if(isNaN(T_HR)) T_HR = 0;
		if(isNaN(TNETT)) TNETT = 0;
		if(isNaN(TBON)) TBON = 0;
		if(isNaN(TSUBSIDI)) TSUBSIDI = 0;
		if(isNaN(TJUMLAH)) TJUMLAH = 0;

		$('#TPREMI').val(numberWithCommas(TPREMI));
		$('#TPREMI_HR').val(numberWithCommas(TPREMI_HR));
		$('#THARIAN').val(numberWithCommas(THARIAN));
		$('#TMS').val(numberWithCommas(TMS));
		$('#TIK').val(numberWithCommas(TIK));
		$('#TNB').val(numberWithCommas(TNB));
		$('#T_HR').val(numberWithCommas(T_HR));
		$('#TNETT').val(numberWithCommas(TNETT));
		$('#TBON').val(numberWithCommas(TBON));
		$('#TSUBSIDI').val(numberWithCommas(TSUBSIDI));
		$('#TJUMLAH').val(numberWithCommas(TJUMLAH));

		$("#TPREMI").autoNumeric('update');
		$("#TPREMI_HR").autoNumeric('update');
		$('#THARIAN').autoNumeric('update');
		$('#TMS').autoNumeric('update');
		$('#TIK').autoNumeric('update');
		$('#TNB').autoNumeric('update');
		$('#T_HR').autoNumeric('update');
		$('#TNETT').autoNumeric('update');
		$('#TBON').autoNumeric('update');
		$('#TSUBSIDI').autoNumeric('update');
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

		var nm_peg0 = "<div class='input-group'><select class='js-example-responsive-nm_peg form-control NM_PEG0' name='NM_PEG[]' id=NM_PEG0" + idrow + " onchange='nm_peg(this.id)' onfocusout='hitung()' required></select></div>";
		var nm_peg1="<input name='PREMI_HR[]' onchange='hitung()' value='0' id=PREMI_HR" + idrow + " type='hidden' class='form-control PREMI_HR rightJustified text-primary'>";
		var nm_peg2="<input name='PREMI[]' onchange='hitung()' value='0' id=PREMI" + idrow + " type='hidden' class='form-control PREMI rightJustified text-primary'>";
		
		var nm_peg = nm_peg0+nm_peg1+nm_peg2;

		td1.innerHTML = "<input name='REC[]' id=REC" + idrow + " type='text' class='REC form-control' onkeypress='return tabE(this,event)' readonly>";
		td2.innerHTML = "<input name='KD_PEG[]' id=KD_PEG0" + idrow + " type='text' class='form-control KD_PEG' readonly>";
		td3.innerHTML = nm_peg;
		td4.innerHTML = "<input name='PTKP[]' id=PTKP0" + idrow + " type='text' class='form-control PTKP'>";
		td5.innerHTML = "<input name='MS[]' onclick='select()' onchange='hitung()' value='0' id=MS" + idrow + " type='text' class='form-control MS rightJustified text-primary'>";
		td6.innerHTML = "<input name='IK[]' onclick='select()' onchange='hitung()' value='0' id=IK" + idrow + " type='text' class='form-control IK rightJustified text-primary'>";
		td7.innerHTML = "<input name='NB[]' onclick='select()' onchange='hitung()' value='0' id=NB" + idrow + " type='text' class='form-control NB rightJustified text-primary'>";
		td8.innerHTML = "<input name='HR[]' onchange='hitung()' value='0' id=HR" + idrow + " type='text' class='form-control HR rightJustified text-primary' readonly>";
		td9.innerHTML = "<input name='NETT[]' onchange='hitung()' value='0' id=NETT" + idrow + " type='text' class='form-control NETT rightJustified text-primary' readonly>";
		td10.innerHTML = "<input name='BON[]' onclick='select()' onchange='hitung()' value='0' id=BON" + idrow + " type='text' class='form-control BON rightJustified text-primary'>";
		td11.innerHTML = "<input name='SUBSIDI[]' onclick='select()' onchange='hitung()' value='0' id=SUBSIDI" + idrow + " type='text' class='form-control SUBSIDI rightJustified text-primary'>";
		td12.innerHTML = "<input name='SUB[]' id=SUB0" + idrow + " type='text' class='form-control SUB'>";
		td13.innerHTML = "<input name='HARIAN[]' onchange='hitung()' value='0' id=HARIAN" + idrow + " type='text' class='form-control HARIAN rightJustified text-primary' readonly>";
		td14.innerHTML = "<input name='LAIN[]' onclick='select()' onchange='hitung()' value='0' id=LAIN" + idrow + " type='text' class='form-control LAIN rightJustified text-primary'>";
		td15.innerHTML = "<input name='JUMLAH[]' onclick='select()' onchange='hitung()' value='0' id=JUMLAH" + idrow + " type='text' class='form-control JUMLAH rightJustified text-primary' readonly>";
		td16.innerHTML = "<input type='hidden' name='NO_ID[]' id=NO_ID" + idrow + " value='0'  class='form-control'>" +
			" <button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>";
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#PREMI" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#PREMI_HR" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#MS" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#IK" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#NB" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#HR" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#NETT" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#BON" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#SUBSIDI" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#HARIAN" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#LAIN" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
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
				url: "<?= base_url('admin/Transaksi_Borongan/getDataAjax_Pegawai') ?>",
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
	var premi = '';
	var ptkp = '';

	function formatSelection_nm_peg(repo_nm_peg) {
		nett = repo_nm_peg.nett;
		kd_peg = repo_nm_peg.kd_peg;
		premi = repo_nm_peg.premi;
		ptkp = repo_nm_peg.ptkp;
		return repo_nm_peg.text;
	}

	function nm_peg(x) {
		var q = x.substring(6, 10);
		$('#NETT' + q).val(nett);
		$('#KD_PEG' + q).val(kd_peg);
		$('#PREMI' + q).val(premi);
		$('#PTKP' + q).val(ptkp);
		console.log(q);
	}

</script>