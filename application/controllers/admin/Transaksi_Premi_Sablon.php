<?php

class Transaksi_Premi_Sablon extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!isset($this->session->userdata['username'])) {
            $this->session->set_flashdata('pesan', 
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Anda Belum Login
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>');
            redirect('admin/auth');
        }
        if ($this->session->userdata['menu_hrd'] != 'hrd_premi') {
			$this->session->set_userdata('menu_hrd', 'hrd_premi');
			$this->session->set_userdata('kode_menu', 'ST0016');
			$this->session->set_userdata('keyword_hrd_premi', '');
			$this->session->set_userdata('order_hrd_premi', 'no_id');
        }
    }

    var $column_order = array(null, null, null, 'no_bukti', 'ms', 'notes', 'dr');
    var $column_search = array('no_bukti', 'ms', 'notes', 'dr');
    var $order = array('no_bukti' => 'asc');

    private function _get_datatables_query() {
        $dr = $this->session->userdata['dr'];
        $per = $this->session->userdata['periode'];
        $where = array(
            'dr' => $dr,
            'per' => $per,
            'flag' => 'SABLON'
        );
        $this->db->select('*');
        $this->db->from('hrd_premi');
        $this->db->where($where);
        $i = 0;
        foreach ($this->column_search as $item) {
            if (@$_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables() {
        $this->_get_datatables_query();
        if (@$_POST['length'] != -1)
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all() {
        $dr = $this->session->userdata['dr'];
        $per = $this->session->userdata['periode'];
        $where = array(
            'dr' => $dr,
            'per' => $per,
            'flag' => 'SABLON'
        );
        $this->db->from('hrd_premi');
        $this->db->where($where);
        return $this->db->count_all_results();
    }

    function get_ajax_hrd_premi() {
        $list = $this->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $hrd_premi) {
            $JASPER = "window.open('JASPER/" . $hrd_premi->no_id . "','', 'width=1000','height=900');";
            $no++;
            $row = array();
            $row[] = "<input type='checkbox' class='singlechkbox' name='check[]' value='" . $hrd_premi->no_id . "'>";
            $row[] = '<div class="dropdown">
                        <a style="background-color: #9c774c;" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bars icon" style="font-size: 13px;"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_Premi_Sablon/update/' . $hrd_premi->no_id) . '"> <i class="fa fa-edit"></i> Edit</a>
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_Premi_Sablon/delete/' . $hrd_premi->no_id) . '" onclick="return confirm(&quot; Apakah Anda Yakin Ingin Menghapus? &quot;)"><i class="fa fa-trash"></i> Delete</a>
                            <a name="no_id" class="dropdown-item" href="#" onclick="' . $JASPER . '");"><i class="fa fa-print"></i> Print</a>
                        </div>
                    </div>';
            $row[] = $no . ".";
            $row[] = $hrd_premi->no_bukti;
            $row[] = $hrd_premi->ms;
            $row[] = $hrd_premi->notes;
            $row[] = $hrd_premi->dr;
            $data[] = $row;
        }
        $output = array(
            "draw" => @$_POST['draw'],
            "recordsTotal" => $this->count_all(),
            "recordsFiltered" => $this->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function index_Transaksi_Premi_Sablon() {
        $dr = $this->session->userdata['dr'];
        $per = $this->session->userdata['periode'];
        $this->session->set_userdata('judul', 'Transaksi Premi Sablon');
        $where = array(
            'dr' => $dr,
            'per' => $per,
            'flag' => 'SABLON'
        );
        $data['hrd_premi'] = $this->transaksi_model->tampil_data($where,'hrd_premi','no_id')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_Premi_Sablon/Transaksi_Premi_Sablon', $data);
        $this->load->view('templates_admin/footer');
    }

    public function input() {
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_Premi_Sablon/Transaksi_Premi_Sablon_form');
        $this->load->view('templates_admin/footer');
    }

    public function input_aksi() {
        $dr = $this->session->userdata['dr']; 
        $per= $this->session->userdata['periode'];
        $nomer= $this->db->query("SELECT MAX(no_bukti) AS NO_BUKTI FROM hrd_premi WHERE per='$per' AND flag='SABLON' AND dr='$dr'")->result();
        $nom = array_column($nomer,'NO_BUKTI');
        $value11 = substr($nom[0],-4);
        $value22 = STRVAL($value11) + 1;
        $urut= str_pad($value22,4,"0",STR_PAD_LEFT);
        $tahun = substr($this->session->userdata['periode'],-2);
        $bulan = substr($this->session->userdata['periode'],0,2);
        $bukti=$tahun.$bulan.'-'.'DR'.$dr.'-'.$urut;
        $datah = array(
            'flag' => 'SABLON',
            'no_bukti' => $bukti, 
            'notes' => $this->input->post('NOTES',TRUE),
            'ms' => str_replace(',','',$this->input->post('MS',TRUE)),
            'dr' => $this->session->userdata['dr'],
            'per' => $this->session->userdata['periode'],
            'usrnm' => $this->session->userdata['username'],
            'i_tgl' => date("Y-m-d h:i a")
        );
        $this->transaksi_model->input_datah('hrd_premi',$datah);
        $ID= $this->db ->query("SELECT MAX(no_id) AS no_id FROM hrd_premi WHERE no_bukti = '$bukti' AND dr='$dr' AND per='$per' GROUP BY no_bukti")->result();
        $REC = $this->input->post('REC');
        $KD_BAG = $this->input->post('KD_BAG');
        $NM_BAG = $this->input->post('NM_BAG');
        $KIK_NETT = str_replace(',','',$this->input->post('KIK_NETT',TRUE));
        $TMS = str_replace(',','',$this->input->post('TMS',TRUE));
        $LAIN = str_replace(',','',$this->input->post('LAIN',TRUE));
        $SABLON = str_replace(',','',$this->input->post('SABLON',TRUE));
        $INJECT = str_replace(',','',$this->input->post('INJECT',TRUE));
        $LAIN1 = str_replace(',','',$this->input->post('LAIN1',TRUE));
        $LUNAS_BS = str_replace(',','',$this->input->post('LUNAS_BS',TRUE));
        $BON_BARU = str_replace(',','',$this->input->post('BON_BARU',TRUE));
        $TJUMLAH = str_replace(',','',$this->input->post('TJUMLAH',TRUE));
        $TNB = str_replace(',','',$this->input->post('TNB',TRUE));
        $BLA = str_replace(',','',$this->input->post('BLA',TRUE));
        $NETTO = str_replace(',','',$this->input->post('NETTO',TRUE));
        $KASI = str_replace(',','',$this->input->post('KASI',TRUE));
        $MAINT1 = str_replace(',','',$this->input->post('MAINT1',TRUE));
        $MAINT2 = str_replace(',','',$this->input->post('MAINT2',TRUE));
        $KABAG = str_replace(',','',$this->input->post('KABAG',TRUE));
        $QC1 = str_replace(',','',$this->input->post('QC1',TRUE));
        $QC2 = str_replace(',','',$this->input->post('QC2',TRUE));
        $WK_MANAG = str_replace(',','',$this->input->post('WK_MANAG',TRUE));
        $KA_QC = str_replace(',','',$this->input->post('KA_QC',TRUE));
        $WK_QC = str_replace(',','',$this->input->post('WK_QC',TRUE));
        $KAGRUP = str_replace(',','',$this->input->post('KAGRUP',TRUE));
        $ADM = str_replace(',','',$this->input->post('ADM',TRUE));
        $ADMIN1 = str_replace(',','',$this->input->post('ADMIN1',TRUE));
        $MANAG = str_replace(',','',$this->input->post('MANAG',TRUE));
        $KAPROD = str_replace(',','',$this->input->post('KAPROD',TRUE));
        $KAMAINT = str_replace(',','',$this->input->post('KAMAINT',TRUE));
        $PREMI = str_replace(',','',$this->input->post('PREMI',TRUE));
        $i = 0;
        foreach($REC as $a) {
            $datad = array(
                'id' => $ID[0]->no_id,
                'no_bukti' => $bukti,
                'flag' => 'SABLON',
                'rec' => $REC[$i],
                'kd_bag' => $KD_BAG[$i],
                'nm_bag' => $NM_BAG[$i],
                'kik_nett' => str_replace(',','',$KIK_NETT[$i]),
                'tms' => str_replace(',','',$TMS[$i]),
                'lain' => str_replace(',','',$LAIN[$i]),
                'sablon' => str_replace(',','',$SABLON[$i]),
                'inject' => str_replace(',','',$INJECT[$i]),
                'lain1' => str_replace(',','',$LAIN1[$i]),
                'lunas_bs' => str_replace(',','',$LUNAS_BS[$i]),
                'bon_baru' => str_replace(',','',$BON_BARU[$i]),
                'tjumlah' => str_replace(',','',$TJUMLAH[$i]),
                'tnb' => str_replace(',','',$TNB[$i]),
                'bla' => str_replace(',','',$BLA[$i]),
                'netto' => str_replace(',','',$NETTO[$i]),
                'kasi' => str_replace(',','',$KASI[$i]),
                'maint1' => str_replace(',','',$MAINT1[$i]),
                'maint2' => str_replace(',','',$MAINT2[$i]),
                'kabag' => str_replace(',','',$KABAG[$i]),
                'qc1' => str_replace(',','',$QC1[$i]),
                'qc2' => str_replace(',','',$QC2[$i]),
                'wk_manag' => str_replace(',','',$WK_MANAG[$i]),
                'ka_qc' => str_replace(',','',$KA_QC[$i]),
                'wk_qc' => str_replace(',','',$WK_QC[$i]),
                'kagrup' => str_replace(',','',$KAGRUP[$i]),
                'adm' => str_replace(',','',$ADM[$i]),
                'admin1' => str_replace(',','',$ADMIN1[$i]),
                'manag' => str_replace(',','',$MANAG[$i]),
                'kaprod' => str_replace(',','',$KAPROD[$i]),
                'kamaint' => str_replace(',','',$KAMAINT[$i]),
                'premi' => str_replace(',','',$PREMI[$i]),
                'per' => $this->session->userdata['periode'],
                'dr' => $this->session->userdata['dr'],
                'usrnm' => $this->session->userdata['username'],
                'i_tgl' => date("Y-m-d h:i a")
            );
            $this->transaksi_model->input_datad('hrd_premid',$datad);
            $i++;
        }
        $this->session->set_flashdata('pesan',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                Data succesfully Inserted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>');
        redirect('admin/Transaksi_Premi_Sablon/index_Transaksi_Premi_Sablon'); 
    }

    public function update($id) {
        $q1="SELECT hrd_premi.no_id as ID,
                hrd_premi.no_bukti AS NO_BUKTI,
                hrd_premi.notes AS NOTES,
                hrd_premi.ms AS MS,

                hrd_premid.no_id AS NO_ID,
                hrd_premid.rec AS REC,
                hrd_premid.kd_bag AS KD_BAG,
                hrd_premid.nm_bag AS NM_BAG,
                hrd_premid.kik_nett AS KIK_NETT,
                (SELECT TJUMLAH from hrd_kik where kd_bag=hrd_premid.kd_bag and per=hrd_premid.per limit 1) AS KIK_NETTX,
                hrd_premid.tms AS TMS,
                (SELECT TNB from hrd_absen where hrd_absen.kd_bag=hrd_premid.kd_bag and hrd_absen.per=hrd_premid.per limit 1) AS TNBX,
                hrd_premid.lain AS LAIN,
                hrd_premid.sablon AS SABLON,
                hrd_premid.inject AS INJECT,
                hrd_premid.lain1 AS LAIN1,
                hrd_premid.lunas_bs AS LUNAS_BS,
                hrd_premid.bon_baru AS BON_BARU,
                hrd_premid.tjumlah AS TJUMLAH,
                hrd_premid.tnb AS TNB,
                hrd_premid.bla AS BLA,
                hrd_premid.netto AS NETTO,
                hrd_premid.kasi AS KASI,
                hrd_premid.maint1 AS MAINT1,
                hrd_premid.maint2 AS MAINT2,
                hrd_premid.kabag AS KABAG,
                hrd_premid.qc1 AS QC1,
                hrd_premid.qc2 AS QC2,
                hrd_premid.wk_manag AS WK_MANAG,
                hrd_premid.ka_qc AS KA_QC,
                hrd_premid.wk_qc AS WK_QC,
                hrd_premid.kagrup AS KAGRUP,
                hrd_premid.adm AS ADM,
                hrd_premid.admin1 AS ADMIN1,
                hrd_premid.manag AS MANAG,
                hrd_premid.kaprod AS KAPROD,
                hrd_premid.kamaint AS KAMAINT,
                hrd_premid.premi AS PREMI
            FROM hrd_premi,hrd_premid 
            WHERE hrd_premi.no_id=$id 
            AND hrd_premi.no_id=hrd_premid.id 
            ORDER BY hrd_premid.rec";
        $data['transaksi_premi_sablon']= $this->transaksi_model->edit_data($q1)->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_Premi_Sablon/Transaksi_Premi_Sablon_update', $data);
        $this->load->view('templates_admin/footer');
    }

    public function update_aksi() {
        $datah = array(
            'flag' => 'SABLON',
            'no_bukti' => $this->input->post('NO_BUKTI',TRUE), 
            'notes' => $this->input->post('NOTES',TRUE),
            'ms' => str_replace(',','',$this->input->post('MS',TRUE)),
            'per' => $this->session->userdata['periode'],
            'dr' => $this->session->userdata['dr'],
            'e_pc' => $this->session->userdata['username'],
            'e_tgl' => date("Y-m-d h:i a")
        );
        $where = array(
            'no_id' => $this->input->post('ID', TRUE)
        );
        $this->transaksi_model->update_data($where, $datah, 'hrd_premi');
        $id = $this->input->post('ID', TRUE);
        $q1="SELECT hrd_premi.no_id as ID,
                hrd_premi.no_bukti AS NO_BUKTI,
                hrd_premi.notes AS NOTES,
                hrd_premi.ms AS MS,

                hrd_premid.no_id AS NO_ID,
                hrd_premid.rec AS REC,
                hrd_premid.kd_bag AS KD_BAG,
                hrd_premid.nm_bag AS NM_BAG,
                hrd_premid.kik_nett AS KIK_NETT,
                hrd_premid.tms AS TMS,
                hrd_premid.lain AS LAIN,
                hrd_premid.sablon AS SABLON,
                hrd_premid.inject AS INJECT,
                hrd_premid.lain1 AS LAIN1,
                hrd_premid.lunas_bs AS LUNAS_BS,
                hrd_premid.bon_baru AS BON_BARU,
                hrd_premid.tjumlah AS TJUMLAH,
                hrd_premid.tnb AS TNB,
                hrd_premid.bla AS BLA,
                hrd_premid.netto AS NETTO,
                hrd_premid.kasi AS KASI,
                hrd_premid.maint1 AS MAINT1,
                hrd_premid.maint2 AS MAINT2,
                hrd_premid.kabag AS KABAG,
                hrd_premid.qc1 AS QC1,
                hrd_premid.qc2 AS QC2,
                hrd_premid.wk_manag AS WK_MANAG,
                hrd_premid.ka_qc AS KA_QC,
                hrd_premid.wk_qc AS WK_QC,
                hrd_premid.kagrup AS KAGRUP,
                hrd_premid.adm AS ADM,
                hrd_premid.admin1 AS ADMIN1,
                hrd_premid.manag AS MANAG,
                hrd_premid.kaprod AS KAPROD,
                hrd_premid.kamaint AS KAMAINT,
                hrd_premid.premi AS PREMI
            FROM hrd_premi,hrd_premid 
            WHERE hrd_premi.no_id=$id 
            AND hrd_premi.no_id=hrd_premid.id 
            ORDER BY hrd_premid.rec";
        $data = $this->transaksi_model->edit_data($q1)->result();
        $NO_ID = $this->input->post('NO_ID');
        $REC = $this->input->post('REC');
        $KD_BAG = $this->input->post('KD_BAG');
        $NM_BAG = $this->input->post('NM_BAG');
        $KIK_NETT = str_replace(',','',$this->input->post('KIK_NETT',TRUE));
        $TMS = str_replace(',','',$this->input->post('TMS',TRUE));
        $LAIN = str_replace(',','',$this->input->post('LAIN',TRUE));
        $SABLON = str_replace(',','',$this->input->post('SABLON',TRUE));
        $INJECT = str_replace(',','',$this->input->post('INJECT',TRUE));
        $LAIN1 = str_replace(',','',$this->input->post('LAIN1',TRUE));
        $LUNAS_BS = str_replace(',','',$this->input->post('LUNAS_BS',TRUE));
        $BON_BARU = str_replace(',','',$this->input->post('BON_BARU',TRUE));
        $TJUMLAH = str_replace(',','',$this->input->post('TJUMLAH',TRUE));
        $TNB = str_replace(',','',$this->input->post('TNB',TRUE));
        $BLA = str_replace(',','',$this->input->post('BLA',TRUE));
        $NETTO = str_replace(',','',$this->input->post('NETTO',TRUE));
        $KASI = str_replace(',','',$this->input->post('KASI',TRUE));
        $MAINT1 = str_replace(',','',$this->input->post('MAINT1',TRUE));
        $MAINT2 = str_replace(',','',$this->input->post('MAINT2',TRUE));
        $KABAG = str_replace(',','',$this->input->post('KABAG',TRUE));
        $QC1 = str_replace(',','',$this->input->post('QC1',TRUE));
        $QC2 = str_replace(',','',$this->input->post('QC2',TRUE));
        $WK_MANAG = str_replace(',','',$this->input->post('WK_MANAG',TRUE));
        $KA_QC = str_replace(',','',$this->input->post('KA_QC',TRUE));
        $WK_QC = str_replace(',','',$this->input->post('WK_QC',TRUE));
        $KAGRUP = str_replace(',','',$this->input->post('KAGRUP',TRUE));
        $ADM = str_replace(',','',$this->input->post('ADM',TRUE));
        $ADMIN1 = str_replace(',','',$this->input->post('ADMIN1',TRUE));
        $MANAG = str_replace(',','',$this->input->post('MANAG',TRUE));
        $KAPROD = str_replace(',','',$this->input->post('KAPROD',TRUE));
        $KAMAINT = str_replace(',','',$this->input->post('KAMAINT',TRUE));
        $PREMI = str_replace(',','',$this->input->post('PREMI',TRUE));
        $jum = count($data);
        $ID = array_column($data, 'NO_ID');
        $jumy = count($NO_ID);
        $i = 0;
        while ($i < $jum) {
            if (in_array($ID[$i], $NO_ID)) {
                $URUT = array_search($ID[$i], $NO_ID);
                $datad = array(
                    'flag' => 'SABLON',
                    'no_bukti' => $this->input->post('NO_BUKTI'),
                    'rec' => $REC[$URUT],
                    'kd_bag' => $KD_BAG[$URUT],
                    'nm_bag' => $NM_BAG[$URUT],
                    'kik_nett' => str_replace(',','',$KIK_NETT[$URUT]),
                    'tms' => str_replace(',','',$TMS[$URUT]),
                    'lain' => str_replace(',','',$LAIN[$URUT]),
                    'sablon' => str_replace(',','',$SABLON[$URUT]),
                    'inject' => str_replace(',','',$INJECT[$URUT]),
                    'lain1' => str_replace(',','',$LAIN1[$URUT]),
                    'lunas_bs' => str_replace(',','',$LUNAS_BS[$URUT]),
                    'bon_baru' => str_replace(',','',$BON_BARU[$URUT]),
                    'tjumlah' => str_replace(',','',$TJUMLAH[$URUT]),
                    'tnb' => str_replace(',','',$TNB[$URUT]),
                    'bla' => str_replace(',','',$BLA[$URUT]),
                    'netto' => str_replace(',','',$NETTO[$URUT]),
                    'kasi' => str_replace(',','',$KASI[$URUT]),
                    'maint1' => str_replace(',','',$MAINT1[$URUT]),
                    'maint2' => str_replace(',','',$MAINT2[$URUT]),
                    'kabag' => str_replace(',','',$KABAG[$URUT]),
                    'qc1' => str_replace(',','',$QC1[$URUT]),
                    'qc2' => str_replace(',','',$QC2[$URUT]),
                    'wk_manag' => str_replace(',','',$WK_MANAG[$URUT]),
                    'ka_qc' => str_replace(',','',$KA_QC[$URUT]),
                    'wk_qc' => str_replace(',','',$WK_QC[$URUT]),
                    'kagrup' => str_replace(',','',$KAGRUP[$URUT]),
                    'adm' => str_replace(',','',$ADM[$URUT]),
                    'admin1' => str_replace(',','',$ADMIN1[$URUT]),
                    'manag' => str_replace(',','',$MANAG[$URUT]),
                    'kaprod' => str_replace(',','',$KAPROD[$URUT]),
                    'kamaint' => str_replace(',','',$KAMAINT[$URUT]),
                    'premi' => str_replace(',','',$PREMI[$URUT]),
                    'per' => $this->session->userdata['periode'],
                    'dr' => $this->session->userdata['dr'],
                    'e_pc' => $this->session->userdata['username'],
                    'e_tgl' => date("Y-m-d h:i a")
                );
                $where = array(
                    'no_id' => $NO_ID[$URUT]
                );
                $this->transaksi_model->update_data($where, $datad, 'hrd_premid');
            } else {
                $where = array(
                    'no_id' => $ID[$i]
                );
                $this->transaksi_model->hapus_data($where, 'hrd_premid');
            }
            $i++;
        }
        $i = 0;
        while ($i < $jumy) {
            if ($NO_ID[$i] == "0") {
                $datad = array(
                    'flag' => 'SABLON',
                    'id' => $this->input->post('ID', TRUE),
                    'no_bukti' => $this->input->post('NO_BUKTI'),
                    'rec' => $REC[$i],
                    'kd_bag' => $KD_BAG[$i],
                    'nm_bag' => $NM_BAG[$i],
                    'kik_nett' => str_replace(',','',$KIK_NETT[$i]),
                    'tms' => str_replace(',','',$TMS[$i]),
                    'lain' => str_replace(',','',$LAIN[$i]),
                    'sablon' => str_replace(',','',$SABLON[$i]),
                    'inject' => str_replace(',','',$INJECT[$i]),
                    'lain1' => str_replace(',','',$LAIN1[$i]),
                    'lunas_bs' => str_replace(',','',$LUNAS_BS[$i]),
                    'bon_baru' => str_replace(',','',$BON_BARU[$i]),
                    'tjumlah' => str_replace(',','',$TJUMLAH[$i]),
                    'tnb' => str_replace(',','',$TNB[$i]),
                    'bla' => str_replace(',','',$BLA[$i]),
                    'netto' => str_replace(',','',$NETTO[$i]),
                    'kasi' => str_replace(',','',$KASI[$i]),
                    'maint1' => str_replace(',','',$MAINT1[$i]),
                    'maint2' => str_replace(',','',$MAINT2[$i]),
                    'kabag' => str_replace(',','',$KABAG[$i]),
                    'qc1' => str_replace(',','',$QC1[$i]),
                    'qc2' => str_replace(',','',$QC2[$i]),
                    'wk_manag' => str_replace(',','',$WK_MANAG[$i]),
                    'ka_qc' => str_replace(',','',$KA_QC[$i]),
                    'wk_qc' => str_replace(',','',$WK_QC[$i]),
                    'kagrup' => str_replace(',','',$KAGRUP[$i]),
                    'adm' => str_replace(',','',$ADM[$i]),
                    'admin1' => str_replace(',','',$ADMIN1[$i]),
                    'manag' => str_replace(',','',$MANAG[$i]),
                    'kaprod' => str_replace(',','',$KAPROD[$i]),
                    'kamaint' => str_replace(',','',$KAMAINT[$i]),
                    'premi' => str_replace(',','',$PREMI[$i]),
                    'per' => $this->session->userdata['periode'],
                    'dr' => $this->session->userdata['dr'],
                    'e_pc' => $this->session->userdata['username'],
                    'e_tgl' => date("Y-m-d h:i a")
                );
                $this->transaksi_model->input_datad('hrd_premid', $datad);
            }
            $i++;
        }
        $this->session->set_flashdata('pesan', 
            '<div class="alert alert-success alert-dismissible fade show" role="alert"> Bukti ' . $this->input->post('NO_MANUAL') . $this->input->post('NO_BUKTI') . ' Berhasil Di Update.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>');
        redirect('admin/Transaksi_Premi_Sablon/index_Transaksi_Premi_Sablon');
    }

    public function delete($id) {
        $where = array('no_id' => $id);
        $this->transaksi_model->hapus_data($where, 'hrd_premi');
        $where = array('id' => $id);
        $this->transaksi_model->hapus_data($where, 'hrd_premid');
        $this->session->set_flashdata('pesan', 
            '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                Data succesfully Deleted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>');
        redirect('admin/Transaksi_Premi_Sablon/index_Transaksi_Premi_Sablon');
    }

    function delete_multiple() {
        $this->transaksi_model->remove_checked('hrd_premi', 'hrd_premid');
        redirect('admin/Transaksi_Premi_Sablon/index_Transaksi_Premi_Sablon');
    }

    function filter_kik_grup() {
        $kik_grup = $this->input->get('kik_grup');
        $per = $this->session->userdata['periode'];
		$dr= $this->session->userdata['dr'];
        $q1 = "SELECT kd_bag AS KD_BAG, 
                nm_bag AS NM_BAG, 
				ROUND(hrd_kik.pot_bon, 2) AS KIK_NETT
            FROM hrd_kik 
            WHERE hrd_kik.kik_grup='$kik_grup' AND hrd_kik.per='$per' AND hrd_kik.dr='$dr' 
            ORDER BY kd_bag ";
        $q2 = $this->db->query($q1);
        if($q2->num_rows() > 0){
            foreach($q2->result() as $row){
                $hasil[] = $row;
            }
        };
        echo json_encode($hasil);
    }

    function JASPER($id) {
        $CI = &get_instance();
        $CI->load->database();
        $servername = $CI->db->hostname;
        $username = $CI->db->username;
        $password = $CI->db->password;
        $database = $CI->db->database;
        $conn = mysqli_connect($servername, $username, $password, $database);
        error_reporting(E_ALL);
        ob_start();
        include_once('phpjasperxml/class/tcpdf/tcpdf.php');
        include_once("phpjasperxml/class/PHPJasperXML.inc.php");
        include_once("phpjasperxml/setting.php");
        $PHPJasperXML = new \PHPJasperXML();
        $PHPJasperXML->load_xml_file("phpjasperxml/Transaksi_Premi_Sablon.jrxml");
        $no_id = $id;
        $query = "SELECT hrd_premi.no_id as ID,
                hrd_premi.no_sp AS MODEL,
                hrd_premi.perke AS PERKE,
                hrd_premi.tgl_sp AS TGL_SP,
                hrd_premi.nodo AS NODO,
                hrd_premi.tgldo AS TGLDO,
                hrd_premi.tlusin AS TLUSIN,
                hrd_premi.tpair AS TPAIR,

                hrd_premid.no_id AS NO_ID,
                hrd_premid.rec AS REC,
                CONCAT(hrd_premid.article,' - ',hrd_premid.warna) AS ARTICLE,
                hrd_premid.size AS SIZE,
                hrd_premid.golong AS GOLONG,
                hrd_premid.stok AS STOK,
                hrd_premid.lusin AS LUSIN,
                hrd_premid.pair AS PAIR,
                CONCAT(hrd_premid.kodecus,' - ',hrd_premid.nama) AS KODECUS,
                hrd_premid.kota AS KOTA
            FROM hrd_premi,hrd_premid 
            WHERE hrd_premi.no_id=$id 
            AND hrd_premi.no_id=hrd_premid.id 
            ORDER BY hrd_premid.rec";
        $PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
        $PHPJasperXML->arraysqltable = array();
        $result1 = mysqli_query($conn, $query);
        while ($row1 = mysqli_fetch_assoc($result1)) {
            array_push($PHPJasperXML->arraysqltable, array(
                "KDMTS" => $row1["KDMTS"],
                "MODEL" => $row1["MODEL"],
                "TGL_SP" => $row1["TGL_SP"],
                "KODECUS" => $row1["KODECUS"],
                "ARTICLE" => $row1["ARTICLE"],
                "LUSIN" => $row1["LUSIN"],
                "PAIR" => $row1["PAIR"],
                "REC" => $row1["REC"],
            ));
        }
        ob_end_clean();
        $PHPJasperXML->outpage("I");
    }

}