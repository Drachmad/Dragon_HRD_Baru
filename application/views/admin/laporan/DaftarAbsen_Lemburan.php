<style>
	.alert-container { background-color: #9c774c; color: black; font-weight: bolder;}
    .label-title { color: black; font-weight: bold; }
    .label { color: black; font-weight: bold; }
    .detail { color: black; text-align: center; }
    .footerCss { color: black; font-weight: bold; }
    .text_input { color: black; }
</style>

<section>
    <div class="container-fluid">
        <br>
		<div class="alert alert-success alert-container" role="alert">
            <i class="fas fa-university"></i> Laporan Absen
        </div>
        <?php echo $this->session->flashdata('pesan') ?>
        <form id="daftarabsen_lemburan" method="post" action="<?php echo base_url('admin/laporan/index_DaftarAbsen_Lemburan') ?>">
            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-md-1">
                        <label class="label">Bagian </label>
                    </div>
                    <div class="col-md-3">
                        <select class="js-example-responsive form-control KD_BAG_1 text_input" name="KD_BAG_1" id="KD_BAG_1" style="width: 100%;">
                            <?php
                            if (isset($_POST["tampilkan"]) &&  $_POST["KD_BAG_1"] == $KD_BAG_1) {
                                echo '<option value="' . $KD_BAG_1 . '" selected >' . $KD_BAG_1 . '</option>';
                            } ?>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label class="label">Tanggal</label>
                    </div>
                    <div class="col-md-3 nopadding">
                        <input type="text" class="date form-control text_input" id="TGL_1" name="TGL_1" data-date-format="dd-mm-yyyy" value="<?php if (isset($_POST["tampilkan"])) { echo $_POST["TGL_1"]; } else echo date('d-m-Y'); ?>">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <div class="col-sm-2 nopadding">
                        <button class="btn btn-md btn-secondary" id="tampilkan" name="tampilkan"> Tampilkan </button>
                    </div>
                    <div class="dropdown col-sm-2 nopadding">
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
                    "dataStore" => $daftarabsen_lemburan,
                    "name" => "example",
                    "fixedHeader" => true,
                    "showFooter"=>true,
                    "showFooter"=>"bottom",
                    "columns" => array(
                        "KD_PEG" => array(
                            "label" => "Kode Pegawai"
                        ),
                        "NM_PEG" => array(
                            "label" => "Nama Pegawai"
                        ),
                        "BAGIAN" => array(
                            "label" => "Bagian"
                        ),
                        "TGL" => array(
                            "label" => "Tanggal"
                        ),
                        "ULEMBUR" => array(
                            "label" => "U Lembur",
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
                        "paging" => true,
                        "searching" => true,
                        "colReorder" => true,
                        "fixedHeader" => true,
                        "select" => true,
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
        </form>
    <!-- DISINI BATAS AKHIR KOOLREPORT-->
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
        select_bagian_1();
    });

    function select_bagian_1() {
        $('#KD_BAG_1').select2({
            ajax: {
                url: "<?= base_url('admin/laporan/getData_master_bagian_1') ?>",
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
            placeholder: 'Masukan Bagian ...',
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