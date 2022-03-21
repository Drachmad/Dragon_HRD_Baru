<style>
	.alert-container { background-color: #9c774c; color: black; font-weight: bolder;}
    .label-title { color: black; font-weight: bold; }
    .label { color: black; font-weight: bold; }
    .detail { color: black; text-align: center; }
    .footerCss { color: black; font-weight: bold; }
</style>

<section>
    <div class="container-fluid">
        <br>
		<div class="alert alert-success alert-container" role="alert">
            <i class="fas fa-university"></i> Laporan Rekap THR
        </div>
        <?php echo $this->session->flashdata('pesan') ?>
        <form id="gaji_harianpergrup" method="post" action="<?php echo base_url('admin/laporan/index_Rekap_THR') ?>">
            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-md-1 nopadding">
                        <label class="label">Periode </label>
                    </div>
                    <div class="col-md-3 nopadding">
                        <input type="text" value="<?php echo $this->session->userdata['periode']; ?>" class="form-control form-control-user PER" id="PER" name="PER" readonly>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group row">
					<div class="col-sm-1 nopadding">
						<button class="btn btn-md btn-secondary" id="tampilkan" name="tampilkan"> Tampilkan </button>
					</div>
					<div class="dropdown col-sm-1 nopadding">
						<button class="btn btn-outline secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fas fa-download"></i>
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							<button type="button" class="dropdown-item" id="btnExportCopy">
								<i class="fa fa-clone"></i> Copy
							</button>
							<button type="button" class="dropdown-item" id="btnExportExcel">
								<i class="fa fa-file-excel-o"></i> Excel
							</button>
							<button type="button" class="dropdown-item" id="btnExportCsv">
								<i class="fas fa-file-csv"></i> Csv
							</button>
							<!-- <button type="button" class="dropdown-item" id="btnExportPdf">
								<i class="fa fa-file-pdf-o"></i> Pdf
							</button> -->
							<button class="dropdown-item" id="print" name="print" value="print">
								<i class="fa fa-print"></i> Print
							</button>
						</div>
					</div>
                </div>
            </div>
            <hr class="m-t-10">
            <!-- PASTE DIBAWAH INI -->
            <!-- DISINI BATAS AWAL KOOLREPORT-->
            <?php
                use \koolreport\datagrid\DataTables;
            ?>
            <div class="report-content">
                <?php
                DataTables::create(array(
                    "dataStore" => $rekap_thr,
                    "name" => "example",
                    "fixedHeader" => true,
                    "showFooter"=>true,
                    "showFooter"=>"bottom",
                    "columns" => array(
                        "PER" => array(
                            "label" => "Periode"
                        ),
                        "NO_BUKTI" => array(
                            "label" => "No Bukti",
                        ),
                        "KD_BAG" => array(
                            "label" => "Kode Bagian",
                        ),
                        "NM_BAG" => array(
                            "label" => "Nama Bagian",
                        ),
                        "JASA" => array(
                            "label" => "Jasa",
                        ),
                        "NM_PEG" => array(
                            "label" => "Nama Pegawai",
                        ),
                        "TOTALD" => array(
                            "label" => "Jumlah",
                            "type"=>"number",
                            "decimals"=>2,
                            "decimalPoint"=>".",
                            "thousandSeparator"=>",",
							"footer"=>"sum",
                        ),
                        "TOT_MS" => array(
                            "label" => "Total MS",
                            "type"=>"number",
                            "decimals"=>2,
                            "decimalPoint"=>".",
                            "thousandSeparator"=>",",
							"footer"=>"sum",
                        )
                    ),
                    "cssClass" => array(
                        "table" => "table table-hover table-striped table-bordered compact",
                        "th" => "label-title",
                        "td" => "detail",
                        "tf"=>"footerCss"
                    ),
                    "options" => array(
                        // "columnDefs"=>array(
                        //     array(
                        //         "width"=> 5, "targets"=>2
                        //     ),
                        // ),
                        "paging" => true,
                        "searching" => true,
                        "colReorder" => true,
                        "fixedHeader" => true,
                        "select" => true,
                        "showFooter"=>true,
                        "showFooter"=>"bottom",
                        "dom" => 'lfrtip', // B e dilangi
                        // "dom" => '<"row"<col-md-6"B><"col-md-6"f>> <"row"<"col-md-12"t>><"row"<"col-md-12">>',
                        "buttons" => array(
                            array(
                                "extend" => 'collection',
                                "text" => 'Export',
                                "buttons" => [
                                    'copy',
                                    'excel',
                                    'csv',
                                    'pdf',
                                    'print'
                                ],
                            ),
                        ),
                    )
                ));
                ?>
            </div>
        <!-- DISINI BATAS AKHIR KOOLREPORT-->
        </form>
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function() {
        $("#btnExportCopy").on("click", function() {
            var table = $('#example').DataTable();
            table.button('.buttons-copy').trigger();
        });
        $("#btnExportExcel").on("click", function() {
            var table = $('#example').DataTable();
            table.button('.buttons-excel').trigger();
        });
        $("#btnExportPdf").on("click", function() {
            var table = $('#example').DataTable();
            table.button('.buttons-pdf').trigger();
        });
        $("#btnExportCsv").on("click", function() {
            var table = $('#example').DataTable();
            table.button('.buttons-csv').trigger();
        });
        $("#btnExportPrint").on("click", function() {
            var table = $('#example').DataTable();
            table.button('.buttons-print').trigger();
        });
        $('.date').mask('00-00-0000');
    });
</script>

<script>
    $(document).ready(function() {
        select_grup_1();
        select_grup_2();
    });

    function select_grup_1() {
        $('#KD_GRUP_1').select2({
            ajax: {
                url: "<?= base_url('admin/laporan/getData_master_grup_1') ?>",
                dataType: "json",
                type: "post",
                delay: 250,
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
            placeholder: 'Masukan Grup ...',
            minimumInputLength: 0,
            templateResult: format,
            templateSelection: formatSelection
        });
    }

    function select_grup_2() {
        $('#KD_GRUP_2').select2({
            ajax: {
                url: "<?= base_url('admin/laporan/getData_master_grup_2') ?>",
                dataType: "json",
                type: "post",
                delay: 250,
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
            placeholder: 'Masukan Grup ...',
            minimumInputLength: 0,
            templateResult: format,
            templateSelection: formatSelection
        });
    }

    function format(repo) {
        if (repo.loading) {
            return repo.text;
        }

        var $container = $(
            "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__title'></div>" +
            "</div>"
        );

        $container.find(".select2-result-repository__title").text(repo.text);
        return $container;
    }

    function formatSelection(repo) {
        return repo.text;
    }
</script>