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
		<i class="fas fa-university"></i> Input <?php echo $this->session->userdata['judul']; ?>
	</div>
	<form id="transaksithrborongan" name="transaksithrborongan" action="<?php echo base_url('admin/Transaksi_THR_Borongan/input_aksi'); ?>" class="form-horizontal needs-validation" method="post" novalidate>
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
								<a class="btn default" onfocusout="hitung()" id="0" data-target="#mymodal_bagian" data-toggle="modal" href="#lupbagian" ><i class="fa fa-search"></i></a>
							</span>
						</div>
						<div class="col-md-2">
							<input class="form-control text_input NM_BAG" id="NM_BAG" name="NM_BAG" type="text" readonly>
							<input class="form-control text_input KD_GRUP" id="KD_GRUP" name="KD_GRUP" type="hidden" readonly>
							<input class="form-control text_input NM_GRUP" id="NM_GRUP" name="NM_GRUP" type="hidden" readonly>
							<input class="form-control text_input DR" id="DR" name="DR" type="hidden" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Krg Hari </label>
						</div>
						<div class="col-md-1">
							<input class="form-control MS rightJustified text-primary font-weight-bold" id="MS" name="MS" value="0" readonly>
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
						<div class="col-md-1">
							<label class="label">Tgl </label>
						</div>
						<div class="col-md-3">
							<input 
								type="text" 
								class="date form-control TGL" 
								id="TGL" 
								name="TGL" 
								data-date-format="dd-mm-yyyy" 
								value="<?php if (isset($_POST["tampilkan"])) { echo $_POST["TGL"]; } else echo date('d-m-Y'); ?>" 
								onclick="select()" 
							>
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
								<th width="200px">NIP</th>
								<th width="170px">Nama</th>
								<th width="240px">Krg HR</th>
								<th width="200px">MS</th>
								<th width="200px">THR</th>
								<th width="200px">Tambah</th>
								<th width="50px"></th>
							</tr>
						</thead>
						<tbody id="show-data">
							<tr>
								<td><input name="REC[]" id="REC0" type="text" value="1" class="form-control REC" onkeypress="return tabE(this,event)" readonly></td>
								<td><input name="KD_PEG[]" id="KD_PEG0" type="text" class="form-control KD_PEG" readonly></td>
								<td>
									<select class="js-example-responsive-nm_peg form-control NM_PEG0" name="NM_PEG[]" id="NM_PEG0" onchange="nm_peg(this.id)" onfocusout="hitung()" readonly></select>
								</td>
								<td><input name="PERB05[]" onkeyup="hitung()" value="0" id="PERB050" type="text" class="form-control PERB05 rightJustified text-primary" readonly></td>
								<td><input name="TOT_MS[]" onkeyup="hitung()" value="0" id="TOT_MS0" type="text" class="form-control TOT_MS rightJustified text-primary" readonly></td>
								<td><input name="THR[]" onkeyup="hitung()" value="0" id="THR0" type="text" class="form-control THR rightJustified text-primary" readonly></td>
								<td><input name="TAMBAH[]" onkeyup="hitung()" value="0" id="TAMBAH0" type="text" class="form-control TAMBAH rightJustified text-primary" readonly></td>
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
							<td><input class="form-control T_THR rightJustified text-primary font-weight-bold" id="T_THR" name="T_THR" value="0" readonly></td>
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
	var idrow = 1;
	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
	$(document).ready(function() {
		$("#MS").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#T_THR").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#PERB05" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#TOT_MS" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#THR" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#TAMBAH" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
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
				url : '<?php echo base_url('index.php/admin/Transaksi_THR_Borongan/filter_kd_bag'); ?>',
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
									'</td>'+
									'<td><input name="PERB05[]" onkeyup="hitung()" value="0" id=PERB05'+i+' type="text" class="form-control PERB05 rightJustified text-primary" readonly></td>'+
									'<td><input name="TOT_MS[]" onkeyup="hitung()" value="0" id=TOT_MS'+i+' type="text" class="form-control TOT_MS rightJustified text-primary" readonly></td>'+
									'<td><input name="THR[]" onkeyup="hitung()" value="'+numberWithCommas(response[i].THR)+'" id=THR'+i+' type="text" class="form-control THR rightJustified text-primary" readonly></td>'+
									'<td><input name="TAMBAH[]" onkeyup="hitung()" value="0" id=TAMBAH'+i+' type="text" class="form-control TAMBAH rightJustified text-primary" readonly></td>'+
									'<td><input type="hidden" name="NO_ID[]" id=NO_ID'+i+'  class="form-control"  value="'+response[i].NO_ID+'"  >'+
									'<button type="button" class="btn btn-sm btn-circle btn-outline-danger btn-delete" onclick=""> <i class="fa fa-fw fa-trash-alt"></i> </button></td>'+
								'</tr>';
                    }
					idrow=i;
					$('#show-data').html(html);
					jumlahdata = 100 ;
					for(i=0; i<=jumlahdata; i++){
						$("#PERB05" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
						$("#TOT_MS" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
						$("#THR" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
						$("#TAMBAH" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
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
		var T_THR = 0;
		var total_row = idrow;
		for (i=0;i<total_row;i++) {
			var thr = parseFloat($('#THR'+i).val().replace(/,/g, ''));

			if(isNaN(thr)) thr = 0;
			$('#THR'+i).val(numberWithCommas(thr));
			$('#THR'+i).autoNumeric('update');

		};
		$(".THR").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if(isNaN(val)) val = 0;
			T_THR+=val;
		});

		if(isNaN(T_THR)) T_THR = 0;

		$('#T_THR').val(numberWithCommas(T_THR));

		$('#T_THR').autoNumeric('update');
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

		var nm_peg0 = "<div class='input-group'><select class='js-example-responsive-nm_peg form-control NM_PEG0' name='NM_PEG[]' id=NM_PEG0" + idrow + " onchange='nm_peg(this.id)' onfocusout='hitung()' required></select></div>";

		var nm_peg = nm_peg0;

		td1.innerHTML = "<input name='REC[]' id=REC" + idrow + " type='text' class='REC form-control' onkeypress='return tabE(this,event)' readonly>";
		td2.innerHTML = "<input name='KD_PEG[]' id=KD_PEG" + idrow + " type='text' class='form-control KD_PEG' readonly>";
		td3.innerHTML = nm_peg;
		td4.innerHTML = "<input name='PERB05[]' onclick='select()' onchange='hitung()' value='0' id=PERB05" + idrow + " type='text' class='form-control PERB05 rightJustified text-primary' readonly>";
		td5.innerHTML = "<input name='TOT_MS[]' onclick='select()' onchange='hitung()' value='0' id=TOT_MS" + idrow + " type='text' class='form-control TOT_MS rightJustified text-primary' readonly>";
		td6.innerHTML = "<input name='THR[]' onclick='select()' onchange='hitung()' value='0' id=THR" + idrow + " type='text' class='form-control THR rightJustified text-primary' readonly>";
		td7.innerHTML = "<input name='TAMBAH[]' onclick='select()' onchange='hitung()' value='0' id=TAMBAH" + idrow + " type='text' class='form-control TAMBAH rightJustified text-primary' readonly>";
		td8.innerHTML = "<input type='hidden' name='NO_ID[]' id=NO_ID" + idrow + " value='0'  class='form-control'>" +
			" <button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>";
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#PERB05" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#TOT_MS" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#THR" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#TAMBAH" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
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
				url: "<?= base_url('admin/Transaksi_THR_Borongan/getDataAjax_Pegawai') ?>",
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
	var kd_peg = '';
	var thr = '';

	function formatSelection_nm_peg(repo_nm_peg) {
		kd_peg = repo_nm_peg.kd_peg;
		thr = repo_nm_peg.thr;
		return repo_nm_peg.text;
	}

	function nm_peg(x) {
		var q = x.substring(7, 9);
		$('#KD_PEG' + q).val(kd_peg);
		$('#THR' + q).val(thr);
		console.log(kd_peg);
	}

</script>