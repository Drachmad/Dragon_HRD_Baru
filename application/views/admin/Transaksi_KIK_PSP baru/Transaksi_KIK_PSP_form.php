<style>
	input[type=text]:focus { width: 100%; }
	table { table-layout: fixed; }
	table th,
	table td { overflow: hidden; }
	.bodycontainer { max-height: 300px; margin: 0; overflow-y: auto; }
	.table-scrollable { margin: 0; padding: 0; }
	.modal-bodys { max-height: 250px; overflow-y: auto; }
	.select2-dropdown { width: 500px !important; }
	#datatable,
	#datatable input { color: black; }
	body,
	body input { color: black; }
	#datatable td { padding: 2px !important; vertical-align: middle; }
	#datatable th { padding: 5px !important; vertical-align: middle; }
	.form-control { font-size: 12px !important; }
	.select2-selection__rendered,
	.select2-search__field,
	.select2-results__option { font-size: 12px !important; }
	.select2-container .select2-selection--single .select2-selection__rendered { padding: 1px .75rem !important; }
	.form-group { margin-bottom: 0; }
	table.dataTable { font-size: 13px; padding: 0.50rem; }
	table.dataTable td { font-size: 13px; padding: 0.50rem; }
	table.dataTable tbody tr:hover { background-color: #ffa; cursor: pointer; }
</style>

<div class="container-fluid">
	<div class="alert alert-success" role="alert"><i class="fas fa-university"></i>Input <?php echo $this->session->userdata['judul']; ?></div>
	<form id="kik_psp" action="<?php echo base_url('admin/Transaksi_KIK_PSP/input_aksi'); ?>" class="form-horizontal" method="post">
		<div class="form-body">
			<div class="row">
				<div class="col-md-6 hdx">
					<div class="form-group row">
						<div class="col-md-2 mt-1"><label>No Bukti </label></div>
						<div class="col-md-5 input-group">
							<div class="input-group-prepend"><span class="input-group-text form-control"><?= $this->session->userdata['flag'] . substr($this->session->userdata['periode'], 5, 2) . substr($this->session->userdata['periode'], 0, 2) . 'B.'; ?></span></div><input type="hidden" id="NO_BUKTI1" name="NO_BUKTI1" value='<?= $this->session->userdata['flag'] . substr($this->session->userdata['periode'], 5, 2) . substr($this->session->userdata['periode'], 0, 2) . 'B.'; ?>' class="form-control " readonly><input type="text" id="NO_BUKTI2" name="NO_BUKTI2" value='' onclick="select()" class="form-control " minlength="4" maxlength="4" required>
						</div>
						<div class="w-100"></div>
						<div class="col-md-2 mt-2"><label>Tanggal</label></div>
						<div class="col-md-5 mt-1">
							<input 
								type="text" 
								class="date form-control" 
								id="TGL" 
								name="TGL" 
								data-date-format="dd-mm-yyyy" 
								value="<?php if (isset($_POST["tampilkan"])) { echo $_POST["TGL"];} else echo date('d-m-Y'); ?>" 
								required
							>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 mt-2">
					<div class="table-responsive bodycontainer scrollable">
						<table id="datatable" class="table table-hoverx table-stripedx table-borderedx table-condensed table-scrollable">
							<thead>
								<tr>
									<th width="60px" style="text-align:right">No</th>
									<th width="350px" style="text-align:left">Perk</th>
									<th style="text-align:center">Uraian</th>
									<th width="120px" style="text-align:center">Referensi</th>
									<th width="160px" style="text-align:right">Debet</th>
									<th width="160px" style="text-align:right">Kredit</th>
									<th width="60px"></th>
								</tr>
							</thead>
							<tbody id="detail">
								<tr>
									<td width="80px"><input name="REC[]" id="REC0" type="text" value="1" class="form-control REC" readonly></td>
									<td width="200px">
										<div class="input-group"><select class="js-example-responsive form-control ACNO0" name="ACNO[]" id="ACNO0" required></select></div><input name="NACNO[]" id="NACNO0" type="hidden" class="form-control NACNO" readonly>
									</td>
									<td width="200px"><input name="URAIAN[]" id="URAIAN0" type="text" class="form-control URAIAN " required></td>
									<td width="200px"><input name="REFF[]" id="REFF0" type="text" class="form-control REFF"></td>
									<td width="200px"><input name="DEBET[]" onkeyup="hitung()" onclick="select()" value="0" id="DEBET0" type="text" class="form-control DEBET rightJustified numinput"></td>
									<td width="200px"><input name="KREDIT[]" onkeyup="hitung()" onclick="select()" data-rw="0" value="0" id="KREDIT0" type="text" class="form-control KREDIT rightJustified numinput"></td>
									<td width="60px"><button type="button" class="btn btn-sm btn-circle btn-outline-danger btn-delete ml-3"><i class="fa fa-fw fa-trash"></i></button></td>
								</tr>
							</tbody>
							<tfoot>
								<TD width="80px"></td>
								<TD width="200px"></td>
								<TD width="200px"></td>
								<TD width="200px"></td>
								<TD width="200px"><input class="form-control TDEBET rightJustified numinput text-primary font-weight-bold" id="TDEBET" name="TDEBET" value="0.00" readonly></td>
								<TD width="200px"><input class="form-control TKREDIT rightJustified numinput text-danger font-weight-bold" id="TKREDIT" name="TKREDIT" value="0.00" readonly></td>
								<TD width="60px"></td>
							</tfoot>
						</table>
					</div>
				</div>
				<div class="col-md-2 row"><button type="button" id="tambah" class="btn btn-sm btn-success"><i class="fas fa-plus fa-sm md-3"></i></button></div>
			</div><br>
			<div class="row">
				<div class="col-xs-9">
					<div class="wells">
						<div class="btn-group"><button type="submit" class="btn btn-success"><i class="fa fa-save"></i>Save</button><a type="button" href="javascript:javascript:history.go(-1)" class="btn btn-danger">Cancel</a></div>
						<h4><span id="error" style="display:none; color:#F00">Terjadi Kesalahan... </span><span id="success" style="display:none; color:#0C0">Savings.done...</span></h4>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<div class="modal fade" id="myModalx" tabindex="-1" role="dialog" aria-labelledby="Label" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="max-width:275px">
		<div class="modal-content">
			<div class="modal-body">
				<p class="text-center font-italic text-danger font-weight-bold">*Debet / Kredit Tidak Balance !!!</p><button class="btn btn-sm btn-danger btn-user btn-block" style="border-radius:10rem;" data-dismiss="modal">Oke</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#example').DataTable({
			dom: "<'row'<'col-md-6'><'col-md-6'>>" +
				"<'row'<'col-md-6'f><'col-md-6'l>>" + // peletakan entries, search, dan test_btn
				"<'row'<'col-md-12't>><'row'<'col-md-12'ip>>", // peletakan show dan halaman
			buttons: [
				'copy', 'csv', 'excel', 'pdf', 'print'
			],
			order: true,
		});
		$('#exampleb').DataTable({
			dom: "<'row'<'col-md-6'><'col-md-6'>>" + // 
				"<'row'<'col-md-6'f><'col-md-6'l>>" + // peletakan entries, search, dan test_btn
				"<'row'<'col-md-12't>><'row'<'col-md-12'ip>>", // peletakan show dan halaman
			buttons: [
				'copy', 'csv', 'excel', 'pdf', 'print'
			],
			order: true,
		});
		$('.modal-footer').on('click', '#close', function() {
			$('input[type=search]').val('').keyup(); // this line and next one clear the search dialog
		});

	});
</script>

<script>

	$(document).ready(function() {
		$('body').on('keyup keypress', 'form input[type="text"]', function(e) {
			if (e.keyCode == 13) {
				e.preventDefault();
				return false;
			}
		});
		$('body').on('keypress', '.URAIAN', function(e) {
			if (e.which == 13) {
				$(this).closest('tr').find('.REFF').focus().select();
			}
		});
		$('body').on('keypress', '.REFF', function(e) {
			if (e.which == 13) {
				$(this).closest('tr').find('.DEBET').focus().select();
			}
		});
		$('body').on('keypress', '.DEBET', function(e) {
			if (e.which == 13) {
				$(this).closest('tr').find('.KREDIT').focus().select();
			}
		});
		$('body').on('keypress', '.KREDIT', function(e) {
			if (e.which == 13) {
				// alert(idrow);
				if ($(this).data('rw') == (idrow - 1)) {
					$('#tambah').click();
				}
				$('#ACNO' + ($(this).data('rw') + 1)).select2('focus');
				// setTimeout(() => {
				// }, 100);
			}
		});

	});
</script>

<script>

	var target;
	var idrow = 1;

	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}

	function fnum() {
		$(".numinput").autoNumeric('init', {
			aSign: '<?php echo ""; ?>',
			vMax: '999999999999.99',
			vMin: '-999999999999.99'
		});
		$('.numinput').autoNumeric('update');
	};

	$(document).ready(function() {
		fnum();
		$('#NO_BUKTI2').mask('0000');
		$("#TDEBET").autoNumeric('init', {
			aSign: '<?php echo ""; ?>',
			vMin: '-999999999999.99'
		});
		$("#TKREDIT").autoNumeric('init', {
			aSign: '<?php echo ""; ?>',
			vMin: '-999999999999.99'
		});

		$('#myModal').on('show.bs.modal', function(e) {
			target = $(e.relatedTarget);
		});
		$('body').on('click', '.selectacc', function() {
			var val = $(this).parents("tr").find(".ACVAL").text();
			target.parents("tr").find(".ACNO").val(val);
			var val = $(this).parents("tr").find(".NAVAL").text();
			target.parents("tr").find(".NACNO").val(val);
			$('#myModal').modal('toggle');
		});

		$('#myModalb').on('show.bs.modal', function(e) {
			target = $(e.relatedTarget);
		});
		$('body').on('click', '.selectbacc', function() {
			var val = $(this).parents("tr").find(".ACVAL").text();
			target.parents("div").find(".BACNO").val(val);
			var val = $(this).parents("tr").find(".NAVAL").text();
			target.parents("div").find(".BNAMA").val(val);
			$('#myModalb').modal('toggle');
		});

		$('body').on('click', '.btn-delete', function() {
			var val = $(this).parents("tr").remove();
			idrow--;
			nomor();
		});

		$('body').on('change', '.REFF', function() {
			var vv = $(this).closest('tr');
			$.ajax({
				type: 'post',
				url: '<?= base_url('admin/Transaksi_KIK_PSP/cekreff'); ?>',
				data: {
					reff: $(this).val()
				},
				success: function(response) {
					// console.log(response);
					if (response != "") {
						if (response == "0") {
							vv.find(".REFF").val("");
							alert("No. Bukti DPP Tidak Ditemukan..");
							vv.find(".REFF").focus();
						}
					}
					// alert("COBA");
				}
			});
		});

		$('body').on('keyup', '.numinput', function() {
			var xx = $(this).closest('tr').find('.KREDIT').data('rw');
			if ($(this).val() == "") {
				$(this).val("0");
				$(this).select();
			}
			let y = parseFloat($(this).val().replace(/,/g, ''));
			if ($(this).hasClass('KREDIT') && y > 0) {
				$('#DEBET' + xx).val('0.00');
			} else if ($(this).hasClass('DEBET') && y > 0) {
				$('#KREDIT' + xx).val('0.00');
			}
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
		var TDEBETX = 0;

		$(".DEBET").each(function() {
			var val1 = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val1)) val1 = 0;
			TDEBETX += val1;
		});

		$("#TDEBET").val(numberWithCommas(TDEBETX));
		$("#TDEBET").autoNumeric('update');


		var TKREDITX = 0;

		$(".KREDIT").each(function() {
			var val2 = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val2)) val2 = 0;
			TKREDITX += val2;
		});

		$("#TKREDIT").val(numberWithCommas(TKREDITX));
		$("#TKREDIT").autoNumeric('update');
	}

</script>

<script>

	$(document).ready(function() {
		select2x();
		$('body').on('click', '#tambah', function() {
			$('#detail').append(`
				<tr>
					<td><input name="REC[]" id="REC${idrow}" type="text" value="${idrow+1}" class="form-control REC" readonly></td>
					<td>
						<div class="input-group">
							<select class="js-example-responsive form-control ACNO" name="ACNO[]" id="ACNO${idrow}" required></select>
						</div>
					</td>
					<td ><input name="URAIAN[]" id="URAIAN${idrow}" type="text" class="form-control URAIAN  " required></td>
					<td ><input name="REFF[]" id="REFF${idrow}" type="text" class="form-control REFF"></td>
					<td ><input name="DEBET[]" onkeyup="hitung()" onclick="select()" value="0.00" id="DEBET${idrow}" type="text" class="form-control DEBET rightJustified numinput"></td>
					<td ><input name="KREDIT[]" onkeyup="hitung()" onclick="select()" data-rw="${idrow}" value="0.00" id="KREDIT${idrow}" type="text" class="form-control KREDIT rightJustified numinput"></td>
					<td >
						<button type="button" class="btn btn-sm btn-circle btn-outline-danger btn-delete ml-3">
							<i class="fa fa-fw fa-trash"></i>
						</button>
					</td>
				</tr>`);
			idrow++;
			nomor();
			hitung();
			fnum();
			select_no_kik();
			select_model();
		});
	});
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
		$('#no_kik' + x).remove();
		$('#NO_KIK' + x).focus().select();
	}

// MODEL
	function select_model() {
		var kik_grup = $('#KIK_GRUP').val();
		$('.js-example-responsive-model').select2({
			ajax: {
				url: "<?= base_url('admin/Transaksi_KIK_PSP/getDataAjax_Model') ?>",
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

<script>
	jQuery.fn.preventDoubleSubmission = function() {
		$(this).on('submit', function(e) {
			var $form = $(this);

			if ($form.data('submitted') === true) {
				// Previously submitted - don't submit again
				e.preventDefault();
			} else {
				if ($("#TGL").val().replace(/-/g, "/").substring(3, 10) == '<?= $this->session->userdata['periode'] ?>') {
					if ($('#TDEBET').val() != $('#TKREDIT').val()) {
						alert("Debet / Kredit Tidak Balance !!!");
						// $("#myModalx").modal();
						e.preventDefault();
					} else {
						e.preventDefault();
						let bktxx = $('#NO_BUKTI2').val();
						// alert(bktxx);
						$.ajax({
							type: 'post',
							url: '<?php echo base_url("index.php/admin/Transaksi_KIK_PSP/cekx_bkt"); ?>',
							data: {
								no_bank: bktxx
							},
							dataType: 'json',
							success: function(response) {
								// alert(response);
								if (response == 0) {
									//INPUT BENAR DAN BUKTI BELUM ADA
									simpanx();
								} else {
									//BUKTI SUDAH ADA HARUS GANTI
									alert('No Bukti Sudah Ada!!');
									$('#NO_BUKTI2').focus().select();
								}
							}
						});
						// Mark it so that the next submit can be ignored
						// $form.data('submitted', true);
					}
				} else {
					alert("Entry Tidak Sesuai Periode !!");
					e.preventDefault();
				}

			}
		});

		// Keep chainability
		return this;
	};

	$('#kik_psp').preventDoubleSubmission();

	function simpanx() {
		// alert('simpan');
		let dtd = '';
		let dth = [];
		var ojk = {};
		$('.hdx input').each(function(index, input) {
			ojk[$(input).attr('name')] = $(input).val();
		});
		dth.push(ojk);
		let datah = JSON.stringify(dth);
		console.log(datah);

		let myRows = [];
		$('#datatable tbody tr').each(function(i, tr) {
			// var obj = {};
			$('tr:eq(' + (i + 1) + ') .form-control').each(function(index) {
				// obj[i] = $(this).val();
				dtd = $('tr:eq(' + (i + 1) + ') .form-control').map(function() {
					// let x = "''";
					// if ($(this).val()) {
					let x = "'" + (($(this).hasClass("numinput")) ? $(this).val().replace(/,/g,
						'') : $(this).val().replace(/'/g, "''")) + "'";
					// }
					return x
				}).get();
			});
			myRows.push(dtd);
		});
		let datad = JSON.stringify(myRows);
		console.log(datad);
		// $('#wrapper').fadeOut("fast");
		// $('.loadx').fadeIn("slow");
		$('.simpan').prop("disabled", true);
		$.ajax({
			type: "POST",
			url: $('#kik_psp').attr("action"),
			data: {
				datah: datah,
				datad: datad
			},
			success: function(data) {
				window.open("<?php echo base_url('admin/Transaksi_KIK_PSP/index_Transaksi_KIK_PSP') ?>", "_self")
			}
		});
	}
</script>