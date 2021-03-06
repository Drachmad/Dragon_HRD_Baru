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
        <i class="fas fa-university"></i> Entry Master Bagian
    </div>
	<form id="form_master_customer" name="form_master_customer" action="<?php echo base_url('admin/Master_Status_Borongan/update_aksi'); ?>" class="form-horizontal needs-validation" method="post" novalidate>
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
						<label class="label">Status</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="STAT" name="STAT" class="form-control text_input STAT" value="<?= $STAT ?>">
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-1">
						<label class="label">PK</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="PK" name="PK" class="form-control text_input PK num" value="<?php echo number_format($PK,0,'.',',');?>">
					</div>
					<div class="col-md-1">
						<label class="label">PK + PH</label>
					</div>
					<div class="col-md-3 ">
						<input type="text" id="PKPH" name="PKPH" class="form-control text_input PKPH num" value="<?php echo number_format($PKPH,0,'.',',');?>">
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
						<a type="button" href="<?php echo base_url('admin/Master_Status_Borongan/index_Master_Status_Borongan') ?>" class="btn btn-danger btn_cancel">Cancel</a>
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