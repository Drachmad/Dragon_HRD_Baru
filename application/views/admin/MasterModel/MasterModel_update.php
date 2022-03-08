<?php
foreach ($master_model as $rowh) {
};
?>

<style>
	#myInput {
		background-image: url('<?php echo base_url() ?>assets/img/search-icon-blue.png');
		background-position: 10px 12px;
		background-repeat: no-repeat;
		width: 100%;
		font-size: 14px;
		padding: 12px 20px 12px 40px;
		border: 1px solid #ddd;
		margin-bottom: 12px;
	}

	#myTable {
		border-collapse: collapse;
		width: 100%;
		border: 1px solid #ddd;
		font-size: 14px;
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

	.text_input {
		color: black;
		text-transform: uppercase;
	}

	.rightJustified {
		text-align: right;
	}

	.total {
		font-size: 14px;
		font-weight: bold;
		color: blue;
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
		width: 400px !important;
	}

	.text_input {
		color: black;
		text-transform: uppercase;
	}
</style>

<div class="container-fluid">
	<br>
	<div class="alert alert-success alert-container" role="alert">
		<i class="fas fa-university"></i> Update <?php echo $this->session->userdata['judul']; ?>
	</div>
	<form id="mastermodel" name="mastermodel" action="<?php echo base_url('admin/MasterModel/update_aksi'); ?>" class="form-horizontal needs-validation" method="post" novalidate>
		<div class="form-body">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-1">
							<label class="label">Model </label>
						</div>
						<div class="input-group col-md-3">
							<input type="hidden" name="ID" class="form-control" value="<?php echo $rowh->ID ?>">
							<input class="form-control text_input MODEL" id="MODEL" name="MODEL" type="text" value="<?php echo $rowh->MODEL ?>" readonly>
						</div>
						<div class="col-md-1">
							<label class="label">Notes </label>
						</div>
						<div class="input-group col-md-3">
							<input class="form-control text_input NOTES" id="NOTES" name="NOTES" type="text" value="<?php echo $rowh->NOTES ?>" readonly>
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
								<!-- <th width="50px">No</th> -->
								<th width="175px">Kode Bag</th>
								<th width="175px">Nama Bag</th>
								<th width="125px">Proses</th>
								<th width="75px">Urut Ke</th>
								<th width="100px">Kode</th>
								<th width="150px">Item</th>
								<th width="150px">Des 1</th>
								<th width="150px">Upah</th>
								<th width="50px"></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 0;
							foreach ($master_model as $row) :
							?>
								<tr>
									<!-- <td><input name="REC[]" id="REC0" type="text" value="1" class="form-control REC" onkeypress="return tabE(this,event)" readonly></td> -->
									<!-- <td>
									<div class="input-group">
										<select class="js-example-responsive-kd_bag form-control KD_BAG" name="KD_BAG[]" id="KD_BAG<?php echo $no; ?>" onchange="kd_bag(this.id)" readonly>
											<option value="<?php echo $row->KD_BAG; ?>" selected id="KD_BAG<?php echo $no; ?>" readonly><?php echo $row->KD_BAG; ?></option>
										</select>
									</div>
								</td> -->
									<td><input name="KD_BAG[]" id="KD_BAG<?php echo $no; ?>" value="<?= $row->KD_BAG ?>" type="text" class="form-control KD_BAG text_input" readonly></td>
									<td><input name="NM_BAG[]" id="NM_BAG<?php echo $no; ?>" value="<?= $row->NM_BAG ?>" type="text" class="form-control NM_BAG text_input" readonly></td>
									<td><input name="PROSES[]" onclick="select()" id="PROSES<?php echo $no; ?>" value="<?= $row->PROSES ?>" type="text" class="form-control PROSES text_input" readonly></td>
									<td><input name="URUT_KE[]" onclick="select()" id="URUT_KE<?php echo $no; ?>" value="<?= $row->URUT_KE ?>" type="text" class="form-control URUT_KE text_input" readonly></td>
									<td><input name="KODE[]" onclick="select()" id="KODE<?php echo $no; ?>" value="<?= $row->KODE ?>" type="text" class="form-control KODE text_input" readonly></td>
									<td><input name="ITEM[]" onclick="select()" id="ITEM<?php echo $no; ?>" value="<?= $row->ITEM ?>" type="text" class="form-control ITEM text_input" readonly></td>
									<td><input name="DES1[]" onclick="select()" id="DES1<?php echo $no; ?>" value="<?= $row->DES1 ?>" type="text" class="form-control DES1 text_input" readonly></td>
									<td><input name="UPAH[]" onclick="select()" onkeyup="hitung()" id="UPAH<?php echo $no; ?>" value="<?php echo number_format($row->UPAH, 2, '.', ','); ?>" type="text" class="form-control UPAH rightJustified text-primary" readonly></td>
									<td>
										<!-- <td><input name="REC[]" id="REC<?php echo $no; ?>" value="<?= $row->REC ?>" type="text" class="form-control REC" onkeypress="return tabE(this,event)" readonly></td> -->
										<input name="NO_ID[]" id="NO_ID<?php echo $no; ?>" value="<?= $row->NO_ID ?>" class="form-control" type="hidden">
										<!-- <button type="button" class="btn btn-sm btn-circle btn-outline-danger btn-delete" onclick="" type="hidden">
										<i class="fa fa-fw fa-trash" type="hidden"></i>
									</button> -->
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
							<td></td>
							<td></td>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
		<br><br>
		<!--tab-->
		<!-- <div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-4">
					<button type="button" onclick="tambah()" class="btn btn-sm btn-success"><i class="fas fa-plus fa-sm md-3"></i> </button>
				</div>
			</div>
		</div> -->
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
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#UPAH" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
		}
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

	function hitung() {}

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

		var kd_bag0 = "<div class='input-group'><select class='js-example-responsive-kd_bag form-control KD_BAG0' name='KD_BAG[]' id=KD_BAG0" + idrow + " onchange='kd_bag(this.id)' onfocusout='hitung()'></select></div>";
		var kd_bag = kd_bag0;

		var proses0 = "<div class='input-group'>";
		var proses1 = "<select class='form-control PROSES text_input' name='PROSES[]' id='PROSES0" + idrow + "' style='width: 100%;' >";
		var proses2 = "<option value='PACKING'>Packing</option>";
		var proses3 = "<option value='PLONG'>Plong</option>";
		var proses4 = "<option value='SABLON'>Sablon</option>";
		var proses5 = "<option value='JAHIT'>Jahit</option>";
		var proses6 = "<option value='PSP'>Psp</option>";
		var proses7 = "<option value='INJECT'>Inject</option>";
		var proses8 = "<option value='BAHAN'>Bahan</option>";
		var proses9 = "<option value='OFFSET'>Offset</option>";
		var proses10 = "</select></div>";
		var proses = proses0 + proses1 + proses2 + proses3 + proses4 + proses5 + proses6 + proses7 + proses8 + proses9 + proses10;

		td1.innerHTML = "<input name='REC[]' id=REC" + idrow + " type='text' class='REC form-control' onkeypress='return tabE(this,event)' readonly>";
		td2.innerHTML = kd_bag;
		td3.innerHTML = "<input name='NM_BAG[]' id=NM_BAG0" + idrow + " type='text' class='form-control NM_BAG' readonly>";
		td4.innerHTML = proses;
		td5.innerHTML = "<input name='URUT_KE[]' onclick='select()' id=URUT_KE0" + idrow + " type='text' class='form-control URUT_KE'>";
		td6.innerHTML = "<input name='KODE[]' onclick='select()' id=KODE0" + idrow + " type='text' class='form-control KODE' >";
		td7.innerHTML = "<input name='ITEM[]' onclick='select()' id=ITEM0" + idrow + " type='text' class='form-control ITEM' >";
		td8.innerHTML = "<input name='DES1[]' onclick='select()' id=DES10" + idrow + " type='text' class='form-control DES1' >";
		td9.innerHTML = "<input name='UPAH[]' onclick='select()' value='0' id=UPAH" + idrow + " type='text' class='form-control UPAH rightJustified text-primary'>";
		td10.innerHTML = "<input type='hidden' name='NO_ID[]' id=NO_ID" + idrow + "  class='form-control'  value='0'  >" +
			" <button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>";
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#UPAH" + i.toString()).autoNumeric('init', {
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
		select_kd_bag();
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
		select_kd_bag();
	});

	function select_kd_bag() {
		$('.js-example-responsive-kd_bag').select2({
			ajax: {
				url: "<?= base_url('admin/MasterModel/getDataAjax_Bagian') ?>",
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
		var q = x.substring(6, 8);
		$('#NM_BAG' + q).val(nm_bag);
		console.log(nm_bag);
	}
</script>