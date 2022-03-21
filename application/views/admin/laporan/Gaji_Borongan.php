<style>
    .alert-container {
        background-color: #9c774c;
        color: black;
        font-weight: bolder;
    }

    .label-title {
        color: black;
        font-weight: bold;
    }

    .label {
        color: black;
        font-weight: bold;
    }

    .detail {
        color: black;
        text-align: center;
    }

    .footerCss {
        color: black;
        font-weight: bold;
    }

    .text_input {
        color: black;
    }
</style>

<section>
    <div class="container-fluid">
        <br>
        <div class="alert alert-success alert-container" role="alert">
            <i class="fas fa-university"></i> Laporan Gaji Borongan
        </div>
        <?php echo $this->session->flashdata('pesan') ?>
        <form id="gaji_borongan" method="post" action="<?php echo base_url('admin/laporan/index_Gaji_Borongan') ?>">
            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-md-1">
                        <label class="label">Periode </label>
                    </div>
                    <div class="col-md-2">
                        <input type="text" value="<?= $PER_1 ?>" class="form-control form-control-user text_input" id="PER_1" placeholder="mm/yyyy" name="PER_1">
                    </div>
                    <div class="col-md-1">
                        <label class="label">s/d</label>
                    </div>
                    <div class="col-md-2">
                        <input type="text" value="<?= $PER_2 ?>" class="form-control form-control-user text_input" id="PER_2" placeholder="mm/yyyy" name="PER_2">
                    </div>
                    <div class="col-md-1">
                        <label class="label">Bagian </label>
                    </div>
                    <div class="col-md-3">
                        <select class="js-example-responsive form-control KD_BAG_1" name="KD_BAG_1" id="KD_BAG_1" style="width: 100%;">
                            <?php
                            if (isset($_POST["tampilkan"]) &&  $_POST["KD_BAG_1"] == $KD_BAG_1) {
                                echo '<option value="' . $KD_BAG_1 . '" selected >' . $KD_BAG_1 . '</option>';
                            } ?>
                        </select>
                    </div>
                    <!-- <div class="col-md-1">
                        <label class="label">s/d</label>
                    </div>
                    <div class="col-md-3">
                        <select class="js-example-responsive form-control KD_BAG_2" name="KD_BAG_2" id="KD_BAG_2" style="width: 100%;">
                            <?php
                            if (isset($_POST["tampilkan"]) &&  $_POST["KD_BAG_2"] == $KD_BAG_2) {
                                echo '<option value="' . $KD_BAG_2 . '" selected >' . $KD_BAG_2 . '</option>';
                            } ?>
                        </select>
                    </div> -->
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-md-1">
                        <label class="label">Fase </label>
                    </div>
                    <div class="col-md-2">
                        <input type="text" value="<?= $FASE_1 ?>" class="form-control form-control-user text_input" id="FASE_1" placeholder="Pilih Fase" name="FASE_1">
                    </div>
                    <div class="col-md-1">
                        <label class="label">s/d</label>
                    </div>
                    <div class="col-md-2">
                        <input type="text" value="<?= $FASE_2 ?>" class="form-control form-control-user text_input" id="FASE_2" placeholder="Pilih Fase" name="FASE_2">

                    </div>
                    <div class="col-sm-1"></div>
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
                    "dataStore" => $gaji_borongan,
                    "name" => "example",
                    "fixedHeader" => true,
                    "showFooter" => true,
                    "showFooter" => "bottom",
                    "columns" => array(
                        "NO_BUKTI" => array(
                            "label" => "No Bukti"
                        ),
                        "PEGAWAI" => array(
                            "label" => "Pegawai"
                        ),
                        "BAGIAN" => array(
                            "label" => "Bagian"
                        ),
                        "GRUP" => array(
                            "label" => "Grup"
                        ),
                        "HR" => array(
                            "label" => "HR",
                            "type" => "number",
                            "decimals" => 2,
                            "decimalPoint" => ".",
                            "thousandSeparator" => ",",
                            "footer" => "sum",
                        ),
                        "GAJI" => array(
                            "label" => "Gaji",
                            "type" => "number",
                            "decimals" => 2,
                            "decimalPoint" => ".",
                            "thousandSeparator" => ",",
                            "footer" => "sum",
                        ),
                        "TOTAL_LEMBUR" => array(
                            "label" => "Lembur",
                            "type" => "number",
                            "decimals" => 2,
                            "decimalPoint" => ".",
                            "thousandSeparator" => ",",
                            "footer" => "sum",
                        ),
                        "LAIN" => array(
                            "label" => "Lain",
                            "type" => "number",
                            "decimals" => 2,
                            "decimalPoint" => ".",
                            "thousandSeparator" => ",",
                            "footer" => "sum",
                        ),
                        "TPERBULAN" => array(
                            "label" => "Tunjangan",
                            "type" => "number",
                            "decimals" => 2,
                            "decimalPoint" => ".",
                            "thousandSeparator" => ",",
                            "footer" => "sum",
                        ),
                        "NETT" => array(
                            "label" => "Nett",
                            "type" => "number",
                            "decimals" => 2,
                            "decimalPoint" => ".",
                            "thousandSeparator" => ",",
                            "footer" => "sum",
                        ),
                        "JUMLAH" => array(
                            "label" => "Jumlah",
                            "type" => "number",
                            "decimals" => 2,
                            "decimalPoint" => ".",
                            "thousandSeparator" => ",",
                            "footer" => "sum",
                        )
                    ),
                    "cssClass" => array(
                        "table" => "table table-hover table-striped table-bordered compact",
                        "th" => "label-title",
                        "td" => "detail",
                        "tf" => "footerCss"
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
        // select_bagian_2();
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
            placeholder: 'Semua Bagian ...',
            minimumInputLength: 0,
            templateResult: format,
            templateSelection: formatSelection
        });
    }

    function select_bagian_2() {
        $('#KD_BAG_2').select2({
            ajax: {
                url: "<?= base_url('admin/laporan/getData_master_bagian_2') ?>",
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
            "<div class='select2-result-repository clearfix text_input'>" +
            "<div class='select2-result-repository__title text_input'></div>" +
            "</div>"
        );

        $container.find(".select2-result-repository__title").text(repo.text);
        return $container;
    }

    function formatSelection(repo) {
        return repo.text;
    }
</script>