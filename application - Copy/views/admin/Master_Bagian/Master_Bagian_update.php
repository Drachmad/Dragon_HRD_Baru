<style>
	#myInput {
		background-image: url('<?php echo base_url()?>assets/img/search-icon-blue.png'); 
		background-position: 10px 12px; 
		background-repeat: no-repeat; 
		width: 100%; 
		padding: 10px 20px 10px 40px;
		border: 1px solid #ddd; 
		margin-bottom: 10px; 
	}
	.pd-1 {padding: 1px;}
	#myTable { border-collapse: collapse;  width: 100%; border: 1px solid #ddd; }
	#myTable th, #myTable td { text-align: left;}
	#myTable tr { border-bottom: 1px solid #ddd; }
	#myTable tr.header, #myTable tr:hover { background-color: #f1f1f1; }
	input[type=text]:focus { width: 100%; }
	table { table-layout: fixed; }
	table th, table td { overflow: hidden;}
	.rightJustified { text-align: right; }
	.total{ font-weight: bold; color: blue; }
	.bodycontainer { width: 1280px; max-height: 300PX; margin: 0; overflow-y: auto; }
	.table-scrollable { margin: 0; padding: 0; }
	.modal-bodys { max-height:250px; overflow-y: auto; }
	.label { font-weight: bold; color: black; }
	.label_header { font-weight: bold; color: black; text-align: center; }
	.text_input { color: black; text-transform: uppercase; }
	.number_input { color: black; text-align: right; }
	.number_total { font-weight: bold; color: black; text-align: right; }
	.btn_back {color: black;}
	.btn_back:hover {transition: 0.4s; color: white;}
	.btn_cancel {color: black;}
	.btn_cancel:hover {transition: 0.4s; color: white;}
	.btn_save {background-color: #1b8526; color: black;}
	.btn_save:hover {transition: 0.4s; color: white;}
	/* Style tab */
	.tab { overflow: hidden; border: 1px solid #ccc; background-color: #f1f1f1; }
	.tab button { background-color: inherit; float: left; border: none; outline: none; cursor: pointer; padding: 14px 16px; transition: 0.4s;}
	.tab button:hover { background-color: #9ae6ae;  transition: 0.4s; }
	.tab button.active { background-color: #9c774c; color: white; }
	.tabcontent { display: none; padding: 6px 12px; }
    .alert-container { background-color: #9c774c; color: black; font-weight: bolder;}
</style>

<div class="container-fluid">
    <br>
    <div class="alert alert-success alert-container" role="alert">
        <i class="fas fa-university"></i> Update Master Bagian
    </div>
	<form id="form_master_customer" name="form_master_customer" action="<?php echo base_url('admin/Master_Bagian/update_aksi'); ?>" class="form-horizontal needs-validation" method="post" novalidate>
        <br><br>
        <div class="form-body">
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-1">
						<label class="label">Kode Bagian</label>
					</div>
					<div class="col-md-3 ">
						<input type="hidden" id="NO_ID" name="NO_ID" class="form-control" value="<?= $NO_ID ?>">
						<input type="text" id="KD_BAG" name="KD_BAG" class="form-control text_input KD_BAG" value="<?= $KD_BAG ?>" required>
					</div>
					<div class="col-md-1">
						<label class="label">Nama Bagian</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="NM_BAG" name="NM_BAG" class="form-control text_input NM_BAG" value="<?= $NM_BAG ?>" required>
					</div>
					<div class="col-md-1">
						<label class="label">Prefix</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="PREFIX" name="PREFIX" class="form-control text_input PREFIX" value="<?php echo $PREFIX; ?>">
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-1">
						<label class="label">Kode Kasi</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="KD_KASI" name="KD_KASI" class="form-control text_input KD_KASI" value="<?php echo $KD_KASI; ?>">
					</div>
					<div class="col-md-1">
						<label class="label">Nama Kasi</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="NM_KASI" name="NM_KASI" class="form-control text_input NM_KASI" value="<?php echo $NM_KASI; ?>">
					</div>
                    <div class="col-md-1">
						<label class="label">Kode Grup</label>
					</div>
					<div class="col-md-3">
						<select class="js-example-responsive-kd_grup form-control KD_GRUP" name="KD_GRUP" id="KD_GRUP" onchange="kd_grup(this.id)" required>
							<option value="<?php echo $KD_GRUP; ?>" selected id="KD_GRUP"><?php echo $KD_GRUP; ?></option>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group row">
                    <div class="col-md-1">
						<label class="label">Nama Grup</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="NM_GRUP" name="NM_GRUP" class="form-control text_input NM_GRUP" value="<?php echo $NM_GRUP; ?>" readonly>
					</div>
					<div class="col-md-1">
						<label class="label">Acno</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="ACNO" name="ACNO" class="form-control text_input ACNO" value="<?php echo $ACNO; ?>" readonly>
					</div>
					<div class="col-md-1">
						<label class="label">DR</label>
					</div>
					<div class="col-md-3">
						<select class="form-control DR text_input" id="DR" value="<? $DR;?>" style="width: 100%;" name="DR">
							<?php if ($DR=="I"){
								echo "<option value='I' selected>Dragon 1</option>";
								echo "<option value='II'>Dragon 2</option>";
								echo "<option value='III'>Dragon 3</option>";
								echo "<option value='IV'>Dragon 4</option>";
								echo "<option value='AB'>AB</option>";
								echo "<option value='PY'>PY</option>";
								echo "<option value='N1'>N1</option>";
							} if ($DR=="II") {
								echo "<option value='I'>Dragon 1</option>";
								echo "<option value='II' selected>Dragon 2</option>";
								echo "<option value='III'>Dragon 3</option>";
								echo "<option value='IV'>Dragon 4</option>";
								echo "<option value='AB'>AB</option>";
								echo "<option value='PY'>PY</option>";
								echo "<option value='N1'>N1</option>";
							} if ($DR=="III") {
								echo "<option value='I'>Dragon 1</option>";
								echo "<option value='II'>Dragon 2</option>";
								echo "<option value='III' selected>Dragon 3</option>";
								echo "<option value='IV'>Dragon 4</option>";
								echo "<option value='AB'>AB</option>";
								echo "<option value='PY'>PY</option>";
								echo "<option value='N1'>N1</option>";
							} if ($DR=="IV") {
								echo "<option value='I'>Dragon 1</option>";
								echo "<option value='II'>Dragon 2</option>";
								echo "<option value='III'>Dragon 3</option>";
								echo "<option value='IV' selected>Dragon 4</option>";
								echo "<option value='AB'>AB</option>";
								echo "<option value='PY'>PY</option>";
								echo "<option value='N1'>N1</option>";
							} if ($DR=="AB") {
								echo "<option value='I'>Dragon 1</option>";
								echo "<option value='II'>Dragon 2</option>";
								echo "<option value='III'>Dragon 3</option>";
								echo "<option value='IV'>Dragon 4</option>";
								echo "<option value='AB' selected>AB</option>";
								echo "<option value='PY'>PY</option>";
								echo "<option value='N1'>N1</option>";
							} if ($DR=="PY") {
								echo "<option value='I'>Dragon 1</option>";
								echo "<option value='II'>Dragon 2</option>";
								echo "<option value='III'>Dragon 3</option>";
								echo "<option value='IV'>Dragon 4</option>";
								echo "<option value='AB'>AB</option>";
								echo "<option value='PY' selected>PY</option>";
								echo "<option value='N1'>N1</option>";
							} if ($DR=="N1") {
								echo "<option value='I'>Dragon 1</option>";
								echo "<option value='II'>Dragon 2</option>";
								echo "<option value='III'>Dragon 3</option>";
								echo "<option value='IV'>Dragon 4</option>";
								echo "<option value='AB'>AB</option>";
								echo "<option value='PY'>PY</option>";
								echo "<option value='N1' selected>N1</option>";
							}
							?>
						</select>
					</div>
				</div>
			</div>
        </div>
		<br><br>
        <div class="row">
			<div class="col-xs-9">
				<div class="wells">		
					<div class="btn-group">
						<button type="submit" class="btn btn_save"><i class="fa fa-save"></i> Save</button>										
						<a type="button" href="<?php echo base_url('admin/Master_Bagian/index_Master_Bagian') ?>" class="btn btn-danger btn_cancel">Cancel</a>
					</div>
					<h4>
                        <span id="error" style="display:none; color:#F00">Terjadi Kesalahan... </span> 
                        <span id="success" style="display:none; color:#0C0">Data sudah disimpan...</span>
                    </h4>								
				</div>						
			</div>													
        </div>  
    </form>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#example').DataTable({
			dom: 
				"<'row'<'col-md-6'><'col-md-6'>>" + // 
				"<'row'<'col-md-6'f><'col-md-6'l>>" + // peletakan entries, search, dan test_btn
				"<'row'<'col-md-12't>><'row'<'col-md-12'ip>>", // peletakan show dan halaman
			buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
			],
			order: true,
		});
	});
</script> 

<script>

    (function() {
		'use strict';
		window.addEventListener('load', function() {
			// Fetch all the forms we want to apply custom Bootstrap validation styles to
			var forms = document.getElementsByClassName('needs-validation');
			// Loop over them and prevent submission
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

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}

    function fnum() {
		$(".num").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMax: '999999999999.99',
			vMin: '-999999999999.99'
		});
		$('.num').autoNumeric('update');
	};

	$(document).ready(function() {
		fnum();
		$('body').on('keyup', 'input.num', function() {
			if (event.which != 190) {
				if (event.which >= 37 && event.which <= 40) return;
			}
			this.value = this.value.replace(/(?!^-)[^0-9.]/g, "").replace(/(\..*)\./g, '$1').replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            hitung();
		});
    });

	$(".date").datepicker({
		'dateFormat':'dd-mm-yy',
	});

    function hitung() {}

</script>

<script>
	$(document).ready(function() {
		select_kd_grup();
	});

	function select_kd_grup() {
		$('.js-example-responsive-kd_grup').select2({
			ajax: {
				url: "<?= base_url('admin/Master_Bagian/getDataAjax_Grup') ?>",
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
			placeholder: 'Pilih Grup',
			minimumInputLength: 0,
			templateResult: format_kd_grup,
			templateSelection: formatSelection_kd_grup
		});
	}

	function format_kd_grup(repo_kd_grup) {
		if (repo_kd_grup.loading) {
			return repo_kd_grup.text;
		}
		var $container = $(
			"<div class='select2-result-repository clearfix'>" +
			"<div class='select2-result-repository__title'></div>" +
			"</div>"
		);
		$container.find(".select2-result-repository__title").text(repo_kd_grup.kd_grup);
		return $container;
	}
	var nm_grup = '';
	var acno = '';
	
	function formatSelection_kd_grup(repo_kd_grup) {
		nm_grup = repo_kd_grup.nm_grup;
		acno = repo_kd_grup.acno;
		return repo_kd_grup.text;
	}

	function kd_grup(x) {
		var q = x.substring(7, 9);
		$('#NM_GRUP' + q).val(nm_grup);
		$('#ACNO' + q).val(acno);
		console.log(nm_grup);

	}

</script>