<?php
foreach ($transaksi_harian as $rowh) {
};
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

	.rightJustified {
		text-align: right;
	}

	.total {
		font-weight: bold;
		color: blue;
	}

	.form-control {
		font-size: small;
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
		width: 500px !important;
	}

	.text_input {
		font-size: small;
		color: black;
	}
</style>

<div class="container-fluid">
	<br>
	<div class="alert alert-success alert-container" role="alert">
		<i class="fas fa-university"></i> Update <?php echo $this->session->userdata['judul']; ?>
	</div>
	<form id="transaksiharian" name="transaksiharian" action="<?php echo base_url('admin/Transaksi_Harian/update_aksi'); ?>" class="form-horizontal needs-validation" method="post" novalidate>
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
								<th width="100px">NIP</th>
								<th width="120px">Nama</th>
								<th width="50px">Ptkp</th>
								<th width="100px">Hr</th>
								<th width="110px">Jam 1</th>
								<th width="110px">Jam 2</th>
								<th width="115px">Jam 1 Rp</th>
								<th width="100px">Jam 2 Rp</th>
								<th width="100px">Lain</th>
								<th width="100px">Potong</th>
								<th width="100px">Insentif Bulan</th>
								<th width="100px">Jumlah</th>
								<th width="50px"></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 0;
							foreach ($transaksi_harian as $row) :
							?>
								<tr>
									<td><input name="REC[]" id="REC<?php echo $no; ?>" value="<?= $row->REC ?>" type="text" class="form-control REC text_input" onkeypress="return tabE(this,event)" readonly></td>
									<td><input name="KD_PEG[]" id="KD_PEG<?php echo $no; ?>" value="<?= $row->KD_PEG ?>" type="text" class="form-control KD_PEG text_input" readonly></td>
									<td>
										<input name="GAJI[]" id="GAJI<?php echo $no; ?>" value="<?php echo number_format($row->GAJI, 2, '.', ','); ?>" type="hidden" class="form-control GAJI rightJustified text-primary" readonly>
										<input name="NETT[]" id="NETT<?php echo $no; ?>" value="<?php echo number_format($row->NETT, 2, '.', ','); ?>" type="hidden" class="form-control NETT rightJustified text-primary" readonly>
										<input name="HARIAN[]" id="HARIAN<?php echo $no; ?>" value="<?php echo number_format($row->HARIAN, 2, '.', ','); ?>" type="hidden" class="form-control HARIAN rightJustified text-primary" readonly>
										<input name="NM_PEG[]" id="NM_PEG<?php echo $no; ?>" value="<?= $row->NM_PEG ?>" type="text" class="form-control NM_PEG text_input" required readonly>
									</td>
									<td><input name="PTKP[]" id="PTKP<?php echo $no; ?>" value="<?= $row->PTKP ?>" type="text" class="form-control PTKP text_input" readonly></td>
									<td><input name="HR[]" onclick="select()" onchange="hitung()" id="HR<?php echo $no; ?>" value="<?php echo number_format($row->HR, 2, '.', ','); ?>" type="text" class="form-control HR rightJustified text-primary"></td>
									<td><input name="JAM1[]" onclick="select()" onchange="hitung()" id="JAM1<?php echo $no; ?>" value="<?php echo number_format($row->JAM1, 2, '.', ','); ?>" type="text" class="form-control JAM1 rightJustified text-primary"></td>
									<td><input name="JAM2[]" onclick="select()" onchange="hitung()" id="JAM2<?php echo $no; ?>" value="<?php echo number_format($row->JAM2, 2, '.', ','); ?>" type="text" class="form-control JAM2 rightJustified text-primary"></td>
									<td><input name="JAM1RP[]" onchange="hitung()" id="JAM1RP<?php echo $no; ?>" value="<?php echo number_format($row->JAM1RP, 2, '.', ','); ?>" type="text" class="form-control JAM1RP rightJustified text-primary" readonly></td>
									<td><input name="JAM2RP[]" onchange="hitung()" id="JAM2RP<?php echo $no; ?>" value="<?php echo number_format($row->JAM2RP, 2, '.', ','); ?>" type="text" class="form-control JAM2RP rightJustified text-primary" readonly></td>
									<td><input name="LAIN[]" onclick="select()" onchange="hitung()" id="LAIN<?php echo $no; ?>" value="<?php echo number_format($row->LAIN, 2, '.', ','); ?>" type="text" class="form-control LAIN rightJustified text-primary"></td>
									<td><input name="POT[]" onclick="select()" onchange="hitung()" id="POT<?php echo $no; ?>" value="<?php echo number_format($row->POT, 2, '.', ','); ?>" type="text" class="form-control LAIN rightJustified text-danger"></td>
									<td><input name="TPERBULAN[]" onchange="hitung()" id="TPERBULAN<?php echo $no; ?>" value="<?php echo number_format($row->TPERBULAN, 2, '.', ','); ?>" type="text" class="form-control TPERBULAN rightJustified text-primary" readonly></td>
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
								<input type="hidden" class="form-control THARIAN rightJustified text-primary font-weight-bold" id="THARIAN" name="THARIAN" value="<?php echo number_format($row->THARIAN, 2, '.', ','); ?>" readonly>
							</td>
							<td><input class="form-control T_HR rightJustified text-primary font-weight-bold" id="T_HR" name="T_HR" value="<?php echo number_format($row->T_HR, 2, '.', ','); ?>" readonly></td>
							<td><input class="form-control TJAM1 rightJustified text-primary font-weight-bold" id="TJAM1" name="TJAM1" value="<?php echo number_format($row->TJAM1, 2, '.', ','); ?>" readonly></td>
							<td><input class="form-control TJAM2 rightJustified text-primary font-weight-bold" id="TJAM2" name="TJAM2" value="<?php echo number_format($row->TJAM2, 2, '.', ','); ?>" readonly></td>
							<td><input class="form-control TJAM1RP rightJustified text-primary font-weight-bold" id="TJAM1RP" name="TJAM1RP" value="<?php echo number_format($row->TJAM1RP, 2, '.', ','); ?>" readonly></td>
							<td><input class="form-control TJAM2RP rightJustified text-primary font-weight-bold" id="TJAM2RP" name="TJAM2RP" value="<?php echo number_format($row->TJAM2RP, 2, '.', ','); ?>" readonly></td>
							<td><input class="form-control TLAIN rightJustified text-primary font-weight-bold" id="TLAIN" name="TLAIN" value="<?php echo number_format($row->TLAIN, 2, '.', ','); ?>" readonly></td>
							<td></td>
							<td><input class="form-control T_TPERBULAN rightJustified text-primary font-weight-bold" id="T_TPERBULAN" name="T_TPERBULAN" value="<?php echo number_format($row->T_TPERBULAN, 2, '.', ','); ?>" readonly></td>
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
						<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
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
						$dr = $this->session->userdata['dr'];
						$sql = "SELECT hrd_bag.kd_bag AS KD_BAG, 
								hrd_bag.nm_bag AS NM_BAG, 
								hrd_bag.kd_grup AS KD_GRUP, 
								hrd_bag.nm_grup AS NM_GRUP,
								hrd_bag.dr AS DR
							FROM hrd_bag WHERE hrd_bag.dr='$dr' ORDER BY dr, kd_bag";
						$a = $this->db->query($sql)->result();
						foreach ($a as $b) {
						?>
							<tr>
								<td class='KBBVAL'><a href="#" class="select_kd_bag"><?php echo $b->KD_BAG; ?></a></td>
								<td class='NBBVAL text_input'><?php echo $b->NM_BAG; ?></td>
								<td class='KDBVAL text_input'><?php echo $b->KD_GRUP; ?></td>
								<td class='NGBVAL text_input'><?php echo $b->NM_GRUP; ?></td>
								<td class='DRBVAL text_input'><?php echo $b->DR; ?></td>
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
			dom: "<'row'<'col-md-6'><'col-md-6'>>" + // 
				"<'row'<'col-md-6'f><'col-md-6'l>>" + // peletakan entries, search, dan test_btn
				"<'row'<'col-md-12't>><'row'<'col-md-12'ip>>", // peletakan show dan halaman
			buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
			order: true,
		});
		$('.modal-footer').on('click', '#close', function() {
			$('input[type=search]').val('').keyup(); // this line and next one clear the search dialog
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
		$("#T_HR").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TJAM1").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TJAM2").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TJAM1RP").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TJAM2RP").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TLAIN").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#T_TPERBULAN").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TJUMLAH").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#TPL_HR").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		$("#THARIAN").autoNumeric('init', {
			aSign: '<?php echo ''; ?>',
			vMin: '-999999999.99'
		});
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#GAJI" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#NETT" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#PL_HR" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#PL" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#HARIAN" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#HR" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#JAM1" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#JAM2" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#JAM1RP" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#JAM2RP" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#LAIN" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#POT" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#TPERBULAN" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#JUMLAH" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
		}
		//MyModal Bagian
		$('#mymodal_bagian').on('show.bs.modal', function(e) {
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
				type: 'get',
				url: '<?php echo base_url('index.php/admin/Transaksi_Harian/filter_kd_bag'); ?>',
				data: {
					kd_bag: kd_bag
				},
				dataType: 'json',
				success: function(response) {
					// alert(response);
					var html = '';
					var i;
					for (i = 0; i < response.length; i++) {
						html += '<tr>' +
							'<td><input name="REC[]" id=REC' + i + ' type="text" class="form-control REC" onkeypress="return tabE(this,event)" readonly value=' + (i + 1) + ' ></td>' +
							'<td><input name="KD_PEG[]" value="' + response[i].KD_PEG + '" id=KD_PEG' + i + ' type="text" class="form-control KD_PEG" readonly></td>' +
							'<td>' +
							'<input name="NM_PEG[]" value="' + response[i].NM_PEG + '" id=NM_PEG' + i + ' type="text" class="form-control NM_PEG" readonly>' +
							'<input name="GAJI[]" type="hidden" onchange="hitung()" value="' + numberWithCommas(response[i].GAJI) + '" id=GAJI' + i + ' readonly class="form-control GAJI rightJustified text-primary">' +
							'<input name="NETT[]" type="hidden" onchange="hitung()" value="' + numberWithCommas(response[i].NETT) + '" id=NETT' + i + ' readonly class="form-control NETT rightJustified text-primary">' +
							'<input name="HARIAN[]" type="hidden" onchange="hitung()" id=HARIAN' + i + ' value="0" class="form-control HARIAN rightJustified text-primary" readonly>' +
							'</td>' +
							'<td><input name="PTKP[]" id=PTKP' + i + ' type="text" class="form-control PTKP"></td>' +
							'<td><input name="HR[]" onclick="select()" onchange="hitung()" value="0" id=HR' + i + ' type="text" class="form-control HR rightJustified text-primary"></td>' +
							'<td><input name="JAM1[]" onclick="select()" onchange="hitung()" value="0" id=JAM1' + i + ' type="text" class="form-control JAM1 rightJustified text-primary"></td>' +
							'<td><input name="JAM2[]" onclick="select()" onchange="hitung()" value="0" id=JAM2' + i + ' type="text" class="form-control JAM2 rightJustified text-primary"></td>' +
							'<td><input name="JAM1RP[]" onchange="hitung()" id=JAM1RP' + i + ' value="0" type="text" class="form-control JAM1RP rightJustified text-primary" readonly></td>' +
							'<td><input name="JAM2RP[]" onchange="hitung()" id=JAM2RP' + i + ' value="0" type="text" class="form-control JAM2RP rightJustified text-primary" readonly></td>' +
							'<td><input name="LAIN[]" onclick="select()" onchange="hitung()" value="0" id=LAIN' + i + ' type="text" class="form-control LAIN rightJustified text-primary"></td>' +
							'<td><input name="POT[]" onclick="select()" onchange="hitung()" value="0" id=POT' + i + ' type="text" class="form-control POT rightJustified text-danger"></td>' +
							'<td><input name="TPERBULAN[]" onchange="hitung()" value="' + numberWithCommas(response[i].TPERBULAN) + '" id=TPERBULAN' + i + ' type="text" class="form-control TPERBULAN rightJustified text-primary" readonly></td>' +
							'<td><input name="JUMLAH[]" onchange="hitung()" value="0" id=JUMLAH' + i + ' type="text" class="form-control JUMLAH rightJustified text-primary" readonly></td>' +
							'<td><input type="hidden" name="NO_ID[]" id=NO_ID' + i + '  class="form-control"  value="' + response[i].NO_ID + '"  >' +
							'<button type="button" class="btn btn-sm btn-circle btn-outline-danger btn-delete" onclick=""> <i class="fa fa-fw fa-trash-alt"></i> </button></td>' +
							'</tr>';
					}
					idrow = i;
					$('#show-data').html(html);
					jumlahdata = 100;
					for (i = 0; i <= jumlahdata; i++) {
						$("#GAJI" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#NETT" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#HARIAN" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#HR" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#JAM1" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#JAM2" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#JAM1RP" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#JAM2RP" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#LAIN" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#POT" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#TPERBULAN" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
						$("#JUMLAH" + i.toString()).autoNumeric('init', {
							aSign: '<?php echo ''; ?>',
							vMin: '-999999999.99'
						});
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
		var T_HR = 0;
		var TJAM1 = 0;
		var TJAM2 = 0;
		var TJAM1RP = 0;
		var TJAM2RP = 0;
		var TLAIN = 0;
		var T_TPERBULAN = 0;
		var THARIAN = 0;
		var TJUMLAH = 0;
		var total_row = idrow;
		for (i = 0; i < total_row; i++) {
			var gaji = parseFloat($('#GAJI' + i).val().replace(/,/g, ''));
			var nett = parseFloat($('#NETT' + i).val().replace(/,/g, ''));
			var hr = parseFloat($('#HR' + i).val().replace(/,/g, ''));
			var jam1 = parseFloat($('#JAM1' + i).val().replace(/,/g, ''));
			var jam2 = parseFloat($('#JAM2' + i).val().replace(/,/g, ''));
			var lain = parseFloat($('#LAIN' + i).val().replace(/,/g, ''));
			var tperbulan = parseFloat($('#TPERBULAN' + i).val().replace(/,/g, ''));
			var pot = parseFloat($('#POT' + i).val().replace(/,/g, ''));

			var jam1rp = jam1 * (gaji * 25 / 173 * 1.5);
			var jam1rp = Math.round(jam1rp);
			if (isNaN(jam1rp)) jam1rp = 0;
			console.log(jam1rp + ' JAM1RP');
			$('#JAM1RP' + i).val(numberWithCommas(jam1rp));
			$('#JAM1RP' + i).autoNumeric('update');

			var jam2rp = jam2 * (gaji * 25 / 173 * 2);
			var jam2rp = Math.round(jam2rp);
			if (isNaN(jam2rp)) jam2rp = 0;
			$('#JAM2RP' + i).val(numberWithCommas(jam2rp));
			$('#JAM2RP' + i).autoNumeric('update');

			var harian = (hr * nett) + lain;
			if (isNaN(harian)) harian = 0;
			$('#HARIAN' + i).val(numberWithCommas(harian));
			$('#HARIAN' + i).autoNumeric('update');
			// console.log(harian);

			var jumlah = harian + (jam1rp + jam2rp) - pot;
			jumlah = jumlah.toFixed(2);
			if (isNaN(jumlah)) jumlah = 0;
			$('#JUMLAH' + i).val(numberWithCommas(jumlah));
			$('#JUMLAH' + i).autoNumeric('update');
			console.log(jumlah);
		};
		$(".HR").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			T_HR += val;
		});
		$(".JAM1").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			TJAM1 += val;
		});
		$(".JAM2").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			TJAM2 += val;
		});
		$(".JAM1RP").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			TJAM1RP += val;
		});
		$(".JAM2RP").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			TJAM2RP += val;
		});
		$(".LAIN").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			TLAIN += val;
		});
		$(".TPERBULAN").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			T_TPERBULAN += val;
		});
		$(".HARIAN").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			THARIAN += val;
		});
		$(".JUMLAH").each(function() {
			var val = parseFloat($(this).val().replace(/,/g, ''));
			if (isNaN(val)) val = 0;
			TJUMLAH += val;
		});

		if (isNaN(T_HR)) T_HR = 0;
		if (isNaN(TJAM1)) TJAM1 = 0;
		if (isNaN(TJAM2)) TJAM2 = 0;
		if (isNaN(TJAM1RP)) TJAM1RP = 0;
		if (isNaN(TJAM2RP)) TJAM2RP = 0;
		if (isNaN(TLAIN)) TLAIN = 0;
		if (isNaN(T_TPERBULAN)) T_TPERBULAN = 0;
		if (isNaN(THARIAN)) THARIAN = 0;
		if (isNaN(TJUMLAH)) TJUMLAH = 0;

		$('#T_HR').val(numberWithCommas(T_HR));
		$('#TJAM1').val(numberWithCommas(TJAM1));
		$('#TJAM2').val(numberWithCommas(TJAM2));
		$('#TJAM1RP').val(numberWithCommas(TJAM1RP));
		$('#TJAM2RP').val(numberWithCommas(TJAM2RP));
		$('#TLAIN').val(numberWithCommas(TLAIN));
		$('#T_TPERBULAN').val(numberWithCommas(T_TPERBULAN));
		$('#THARIAN').val(numberWithCommas(THARIAN));
		$('#TJUMLAH').val(numberWithCommas(TJUMLAH));

		$("#T_HR").autoNumeric('update');
		$('#TJAM1').autoNumeric('update');
		$('#TJAM2').autoNumeric('update');
		$('#TJAM1RP').autoNumeric('update');
		$('#TJAM2RP').autoNumeric('update');
		$('#TLAIN').autoNumeric('update');
		$('#T_TPERBULAN').autoNumeric('update');
		$('#THARIAN').autoNumeric('update');
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

		var nm_peg0 = "<div class='input-group'><select class='js-example-responsive-nm_peg form-control NM_PEG text_input' name='NM_PEG[]' id=NM_PEG" + idrow + " onchange='nm_peg(this.id)' onfocusout='hitung()' required></select></div>";
		var nm_peg1 = "<input name='NETT[]' onclick='select()' onchange='hitung()' value='0' id=NETT" + idrow + " type='hidden' class='form-control NETT rightJustified text-primary'>";
		var nm_peg2 = "<input name='GAJI[]' onclick='select()' onchange='hitung()' value='0' id=GAJI" + idrow + " type='hidden' class='form-control GAJI rightJustified text-primary'>";
		var nm_peg3 = "<input name='HARIAN[]' onclick='select()' onchange='hitung()' value='0' id=HARIAN" + idrow + " type='hidden' class='form-control HARIAN rightJustified text-primary'>";

		var nm_peg = nm_peg0 + nm_peg1 + nm_peg2 + nm_peg2;

		td1.innerHTML = "<input name='REC[]' id=REC" + idrow + " type='text' class='REC form-control text_input' onkeypress='return tabE(this,event)' readonly>";
		td2.innerHTML = "<input name='KD_PEG[]' id=KD_PEG" + idrow + " type='text' class='form-control KD_PEG text_input' readonly>";
		td3.innerHTML = nm_peg;
		td4.innerHTML = "<input name='PTKP[]' id=PTKP" + idrow + " type='text' class='form-control PTKP text_input' readonly>";
		td5.innerHTML = "<input name='HR[]' onclick='select()' onchange='hitung()' value='0' id=HR" + idrow + " type='text' class='form-control HR rightJustified text-primary'>";
		td6.innerHTML = "<input name='JAM1[]' onclick='select()' onchange='hitung()' value='0' id=JAM1" + idrow + " type='text' class='form-control JAM1 rightJustified text-primary'>";
		td7.innerHTML = "<input name='JAM2[]' onclick='select()' onchange='hitung()' value='0' id=JAM2" + idrow + " type='text' class='form-control JAM2 rightJustified text-primary'>";
		td8.innerHTML = "<input name='JAM1RP[]' onclick='select()' onchange='hitung()' value='0' id=JAM1RP" + idrow + " type='text' class='form-control JAM1RP rightJustified text-primary' readonly>";
		td9.innerHTML = "<input name='JAM2RP[]' onclick='select()' onchange='hitung()' value='0' id=JAM2RP" + idrow + " type='text' class='form-control JAM2RP rightJustified text-primary' readonly>";
		td10.innerHTML = "<input name='LAIN[]' onclick='select()' onchange='hitung()' value='0' id=LAIN" + idrow + " type='text' class='form-control LAIN rightJustified text-primary'>";
		td11.innerHTML = "<input name='POT[]' onclick='select()' onchange='hitung()' value='0' id=POT" + idrow + " type='text' class='form-control POT rightJustified text-danger'>";
		td12.innerHTML = "<input name='TPERBULAN[]' onclick='select()' onchange='hitung()' value='0' id=TPERBULAN" + idrow + " type='text' class='form-control TPERBULAN rightJustified text-primary' readonly>";
		td13.innerHTML = "<input name='JUMLAH[]' onclick='select()' onchange='hitung()' value='0' id=JUMLAH" + idrow + " type='text' class='form-control JUMLAH rightJustified text-primary' readonly>";
		td14.innerHTML = "<input type='hidden' name='NO_ID[]' id=NO_ID" + idrow + " value='0'  class='form-control'>" +
			" <button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>";
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#GAJI" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#NETT" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#HR" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#HARIAN" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#JAM1" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#JAM2" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#JAM1RP" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#JAM2RP" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#LAIN" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#POT" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#TPERBULAN" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>',
				vMin: '-999999999.99'
			});
			$("#JUMLAH" + i.toString()).autoNumeric('init', {
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
				url: "<?= base_url('admin/Transaksi_Harian/getDataAjax_Pegawai') ?>",
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
			"<div class='select2-result-repository clearfix text_input'>" +
			"<div class='select2-result-repository__title text_input'></div>" +
			"</div>"
		);
		$container.find(".select2-result-repository__title").text(repo_nm_peg.nm_peg);
		return $container;
	}
	var gaji = '';
	var nett = '';
	var kd_peg = '';
	var tperbulan = '';
	var ptkp = '';

	function formatSelection_nm_peg(repo_nm_peg) {
		gaji = repo_nm_peg.gaji;
		nett = repo_nm_peg.nett;
		kd_peg = repo_nm_peg.kd_peg;
		tperbulan = repo_nm_peg.tperbulan;
		ptkp = repo_nm_peg.ptkp;
		return repo_nm_peg.text;
	}

	function nm_peg(x) {
		var q = x.substring(6, 10);
		$('#GAJI' + q).val(gaji);
		$('#NETT' + q).val(nett);
		$('#KD_PEG' + q).val(kd_peg);
		$('#TPERBULAN' + q).val(tperbulan);
		$('#PTKP' + q).val(ptkp);
		console.log(q);
	}
</script>