<?php

class Transaksi_Borongan_BoronganDragon extends CI_Controller {

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
        if ($this->session->userdata['menu_hrd'] != 'hrd_absen') {
			$this->session->set_userdata('menu_hrd', 'hrd_absen');
			$this->session->set_userdata('kode_menu', 'T0008');
			$this->session->set_userdata('keyword_hrd_absen', '');
			$this->session->set_userdata('order_hrd_absen', 'no_id');
        }
    }

    var $column_order = array(null, null, null, 'no_bukti', 'kd_bag', 'nm_bag', 'notes', 'dr');
    var $column_search = array('no_bukti', 'kd_bag', 'nm_bag', 'notes', 'dr');
    var $order = array('no_bukti' => 'asc');

    private function _get_datatables_query() {
        $dr = $this->session->userdata['dr'];
        $per = $this->session->userdata['periode'];
        $where = array(
            'dr' => $dr,
            'per' => $per,
            'flag' => 'BR'
        );
        $this->db->select('*');
        $this->db->from('hrd_absen');
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
            'flag' => 'BR'
        );
        $this->db->from('hrd_absen');
        $this->db->where($where);
        return $this->db->count_all_results();
    }

    function get_ajax_hrd_absen() {
        $list = $this->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $hrd_absen) {
            $JASPER = "window.open('JASPER/" . $hrd_absen->no_id . "','', 'width=1000','height=900');";
            $no++;
            $row = array();
            $row[] = "<input type='checkbox' class='singlechkbox' name='check[]' value='" . $hrd_absen->no_id . "'>";
            $row[] = '<div class="dropdown">
                        <a style="background-color: #9c774c;" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bars icon" style="font-size: 13px;"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_Borongan_BoronganDragon/update/' . $hrd_absen->no_id) . '"> <i class="fa fa-edit"></i> Edit</a>
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_Borongan_BoronganDragon/delete/' . $hrd_absen->no_id) . '" onclick="return confirm(&quot; Apakah Anda Yakin Ingin Menghapus? &quot;)"><i class="fa fa-trash"></i> Delete</a>
                            <a name="no_id" class="dropdown-item" href="#" onclick="' . $JASPER . '");"><i class="fa fa-print"></i> Print</a>
                        </div>
                    </div>';
            $row[] = $no . ".";
            $row[] = $hrd_absen->no_bukti;
            $row[] = $hrd_absen->kd_bag;
            $row[] = $hrd_absen->nm_bag;
            $row[] = $hrd_absen->notes;
            $row[] = $hrd_absen->dr;
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

    public function index_Transaksi_Borongan_BoronganDragon() {
        $dr = $this->session->userdata['dr'];
        $per = $this->session->userdata['periode'];
        $this->session->set_userdata('judul', 'Transaksi Borongan');
        $where = array(
            'dr' => $dr,
            'per' => $per,
            'flag' => 'BR'
        );
        $data['hrd_absen'] = $this->transaksi_model->tampil_data($where,'hrd_absen','no_id')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_Borongan_BoronganDragon/Transaksi_Borongan_BoronganDragon', $data);
        $this->load->view('templates_admin/footer');
    }

    public function input() {
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_Borongan_BoronganDragon/Transaksi_Borongan_BoronganDragon_form');
        $this->load->view('templates_admin/footer');
    }

    public function input_aksi() {
        $kd_bag = $this->input->post('KD_BAG',TRUE);
        $nm_bag = $this->input->post('NM_BAG',TRUE);
        $kd_grup = $this->input->post('KD_GRUP',TRUE);
        $nm_grup = $this->input->post('NM_GRUP',TRUE);
        $dr = $this->input->post('DR',TRUE);
        $per= $this->session->userdata['periode'];  
        $pr = substr($this->session->userdata['periode'],0,2);
        $pr1 = substr($this->session->userdata['periode'],-2).substr($this->session->userdata['periode'],0,2);
        $bukti='BR'.$pr1.'.'.$pr.'-'.$kd_bag;
        $datah = array(
            'flag' => 'BR',
            'no_bukti' => $bukti, 
            'kd_bag' => $this->input->post('KD_BAG',TRUE),
            'nm_bag' => $this->input->post('NM_BAG',TRUE),
            'notes' => $this->input->post('NOTES',TRUE),
            'pk' => $this->input->post('PK',TRUE),
            'pkph' => $this->input->post('PKPH',TRUE),
            'tms' => str_replace(',','',$this->input->post('TMS',TRUE)),
            'tik' => str_replace(',','',$this->input->post('TIK',TRUE)),
            'tnb' => str_replace(',','',$this->input->post('TNB',TRUE)),
            't_hr' => str_replace(',','',$this->input->post('T_HR',TRUE)),
            'tgaji' => str_replace(',','',$this->input->post('TNETT',TRUE)),
            'tbon' => str_replace(',','',$this->input->post('TBON',TRUE)),
            'tsubsidi' => str_replace(',','',$this->input->post('TSUBSIDI',TRUE)),
            'tjumlah' => str_replace(',','',$this->input->post('TJUMLAH',TRUE)),
            'premi' => str_replace(',','',$this->input->post('PREMI',TRUE)),
            'kik_nett' => str_replace(',','',$this->input->post('KIK_NETT',TRUE)),
            'tbon1' => str_replace(',','',$this->input->post('TBON1',TRUE)),
            'tot_kik' => str_replace(',','',$this->input->post('tot_kik',TRUE)),
            'other' => $this->input->post('OTHER',TRUE),
            'dr' => $this->session->userdata['dr'],
            'per' => $this->session->userdata['periode'],
            'usrnm' => $this->session->userdata['username'],
            'i_tgl' => date("Y-m-d h:i a")
        );
        $this->transaksi_model->input_datah('hrd_absen',$datah);
        $ID= $this->db ->query("SELECT MAX(no_id) AS no_id FROM hrd_absen WHERE no_bukti = '$bukti' AND dr='$dr' AND per='$per' GROUP BY no_bukti")->result();
        $REC = $this->input->post('REC');
        $KD_PEG = $this->input->post('KD_PEG');
        $PREMI = str_replace(',','',$this->input->post('PREMI',TRUE));
        $PREMI_HR = str_replace(',','',$this->input->post('PREMI_HR',TRUE));
        $NM_PEG = $this->input->post('NM_PEG');
        $PTKP = $this->input->post('PTKP');
        $MS = str_replace(',','',$this->input->post('MS',TRUE));
        $IK = str_replace(',','',$this->input->post('IK',TRUE));
        $NB = str_replace(',','',$this->input->post('NB',TRUE));
        $HR = str_replace(',','',$this->input->post('HR',TRUE));
        $NETT = str_replace(',','',$this->input->post('NETT',TRUE));
        $BON = str_replace(',','',$this->input->post('BON',TRUE));
        $SUBSIDI = str_replace(',','',$this->input->post('SUBSIDI',TRUE));        
        $SUB = $this->input->post('SUB');
        $HARIAN = str_replace(',','',$this->input->post('HARIAN',TRUE));        
        $LAIN = str_replace(',','',$this->input->post('LAIN',TRUE));        
        $JUMLAH = str_replace(',','',$this->input->post('JUMLAH',TRUE));        
        $i = 0;
        foreach($REC as $a) {
            $datad = array(
                'id' => $ID[0]->no_id,
                'no_bukti' => $bukti,
                'kd_bag' => $kd_bag,
                'nm_bag' => $nm_bag,
                'flag' => 'BR',
                'rec' => $REC[$i],
                'kd_peg' => $KD_PEG[$i],
                'nm_peg' => $NM_PEG[$i],
                'premi' => str_replace(',','',$PREMI[$i]),
                'premi_hr' => str_replace(',','',$PREMI_HR[$i]),
                'ptkp' => $PTKP[$i],
                'ms' => str_replace(',','',$MS[$i]),
                'ik' => str_replace(',','',$IK[$i]),
                'nb' => str_replace(',','',$NB[$i]),
                'hr' => str_replace(',','',$HR[$i]),
                'gaji' => str_replace(',','',$NETT[$i]),
                'bon' => str_replace(',','',$BON[$i]),
                'per' => $this->session->userdata['periode'],
                'usrnm' => $this->session->userdata['username'],
                'i_tgl' => date("Y-m-d h:i a")
            );
            $this->transaksi_model->input_datad('hrd_absend',$datad);
            $i++;
        }
        $this->session->set_flashdata('pesan',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                Data succesfully Inserted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>');
        redirect('admin/Transaksi_Borongan_BoronganDragon/index_Transaksi_Borongan_BoronganDragon'); 
    }

    public function update($id) {
        $q1="SELECT hrd_absen.no_id as ID,
                hrd_absen.no_bukti AS NO_BUKTI,
                hrd_absen.kd_bag AS KD_BAG,
                hrd_absen.nm_bag AS NM_BAG,
                hrd_absen.kd_grup AS KD_GRUP,
                hrd_absen.nm_grup AS NM_GRUP,
                hrd_absen.dr AS DR,
                hrd_absen.notes AS NOTES,
                hrd_absen.tpremi AS TPREMI,
                hrd_absen.tpremi_hr AS TPREMI_HR,
                hrd_absen.tharian AS THARIAN,
                hrd_absen.tms AS TMS,
                hrd_absen.tik AS TIK,
                hrd_absen.tnb AS TNB,
                hrd_absen.t_hr AS T_HR,
                hrd_absen.tgaji AS TNETT,
                hrd_absen.tbon AS TBON,
                hrd_absen.tsubsidi AS TSUBSIDI,
                hrd_absen.tjumlah AS TJUMLAH,

                hrd_absend.no_id AS NO_ID,
                hrd_absend.rec AS REC,
                hrd_absend.kd_peg AS KD_PEG,
                hrd_absend.nm_peg AS NM_PEG,
                hrd_absend.premi AS PREMI,
                hrd_absend.premi_hr AS PREMI_HR,
                hrd_absend.ptkp AS PTKP,
                hrd_absend.ms AS MS,
                hrd_absend.ik AS IK,
                hrd_absend.nb AS NB,
                hrd_absend.hr AS HR,
                hrd_absend.gaji AS NETT,
                hrd_absend.bon AS BON,
                hrd_absend.subsidi AS SUBSIDI,
                hrd_absend.sub AS SUB,
                hrd_absend.harian AS HARIAN,
                hrd_absend.lain AS LAIN,
                hrd_absend.jumlah AS JUMLAH
            FROM hrd_absen,hrd_absend 
            WHERE hrd_absen.no_id=$id 
            AND hrd_absen.no_id=hrd_absend.id 
            ORDER BY hrd_absend.rec";
        $data['transaksi_borongan']= $this->transaksi_model->edit_data($q1)->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_Borongan_BoronganDragon/Transaksi_Borongan_BoronganDragon_update', $data);
        $this->load->view('templates_admin/footer');
    }

    public function update_aksi() {
        $datah = array(
            'flag' => 'BR',
            'no_bukti' => $this->input->post('NO_BUKTI',TRUE), 
            'kd_bag' => $this->input->post('KD_BAG',TRUE),
            'nm_bag' => $this->input->post('NM_BAG',TRUE),
            'kd_grup' => $this->input->post('KD_GRUP',TRUE),
            'nm_grup' => $this->input->post('NM_GRUP',TRUE),
            'dr' => $this->input->post('DR',TRUE),
            'notes' => $this->input->post('NOTES',TRUE),
            'tpremi' => str_replace(',','',$this->input->post('TPREMI',TRUE)),
            'tpremi_hr' => str_replace(',','',$this->input->post('TPREMI_HR',TRUE)),
            'tharian' => str_replace(',','',$this->input->post('THARIAN',TRUE)),
            'tms' => str_replace(',','',$this->input->post('TMS',TRUE)),
            'tik' => str_replace(',','',$this->input->post('TIK',TRUE)),
            'tnb' => str_replace(',','',$this->input->post('TNB',TRUE)),
            't_hr' => str_replace(',','',$this->input->post('T_HR',TRUE)),
            'tgaji' => str_replace(',','',$this->input->post('TNETT',TRUE)),
            'tbon' => str_replace(',','',$this->input->post('TBON',TRUE)),
            'tsubsidi' => str_replace(',','',$this->input->post('TSUBSIDI',TRUE)),
            'tjumlah' => str_replace(',','',$this->input->post('TJUMLAH',TRUE)),
            'per' => $this->session->userdata['periode'],
            'e_pc' => $this->session->userdata['username'],
            'e_tgl' => date("Y-m-d h:i a")
        );
        $where = array(
            'no_id' => $this->input->post('ID', TRUE)
        );
        $this->transaksi_model->update_data($where, $datah, 'hrd_absen');
        $id = $this->input->post('ID', TRUE);
        $q1="SELECT hrd_absen.no_id as ID,
                hrd_absen.no_bukti AS NO_BUKTI,
                hrd_absen.kd_bag AS KD_BAG,
                hrd_absen.nm_bag AS NM_BAG,
                hrd_absen.kd_grup AS KD_GRUP,
                hrd_absen.nm_grup AS NM_GRUP,
                hrd_absen.dr AS DR,
                hrd_absen.notes AS NOTES,
                hrd_absen.tpremi AS TPREMI,
                hrd_absen.tpremi_hr AS TPREMI_HR,
                hrd_absen.tharian AS THARIAN,
                hrd_absen.tms AS TMS,
                hrd_absen.tik AS TIK,
                hrd_absen.tnb AS TNB,
                hrd_absen.t_hr AS T_HR,
                hrd_absen.tgaji AS TNETT,
                hrd_absen.tbon AS TBON,
                hrd_absen.tsubsidi AS TSUBSIDI,
                hrd_absen.tjumlah AS TJUMLAH,

                hrd_absend.no_id AS NO_ID,
                hrd_absend.rec AS REC,
                hrd_absend.kd_peg AS KD_PEG,
                hrd_absend.nm_peg AS NM_PEG,
                hrd_absend.premi AS PREMI,
                hrd_absend.premi_hr AS PREMI_HR,
                hrd_absend.ptkp AS PTKP,
                hrd_absend.ms AS MS,
                hrd_absend.ik AS IK,
                hrd_absend.nb AS NB,
                hrd_absend.hr AS HR,
                hrd_absend.nett AS NETT,
                hrd_absend.bon AS BON,
                hrd_absend.subsidi AS SUBSIDI,
                hrd_absend.sub AS SUB,
                hrd_absend.harian AS HARIAN,
                hrd_absend.lain AS LAIN,
                hrd_absend.jumlah AS JUMLAH
            FROM hrd_absen,hrd_absend 
            WHERE hrd_absen.no_id=$id 
            AND hrd_absen.no_id=hrd_absend.id 
            ORDER BY hrd_absend.rec";
        $data = $this->transaksi_model->edit_data($q1)->result();
        $NO_ID = $this->input->post('NO_ID');
        $REC = $this->input->post('REC');
        $KD_PEG = $this->input->post('KD_PEG');
        $PREMI = str_replace(',','',$this->input->post('PREMI',TRUE));
        $PREMI_HR = str_replace(',','',$this->input->post('PREMI_HR',TRUE));
        $NM_PEG = $this->input->post('NM_PEG');
        $PTKP = $this->input->post('PTKP');
        $MS = str_replace(',','',$this->input->post('MS',TRUE));
        $IK = str_replace(',','',$this->input->post('IK',TRUE));
        $NB = str_replace(',','',$this->input->post('NB',TRUE));
        $HR = str_replace(',','',$this->input->post('HR',TRUE));
        $NETT = str_replace(',','',$this->input->post('NETT',TRUE));
        $BON = str_replace(',','',$this->input->post('BON',TRUE));
        $SUBSIDI = str_replace(',','',$this->input->post('SUBSIDI',TRUE));        
        $SUB = $this->input->post('SUB');
        $HARIAN = str_replace(',','',$this->input->post('HARIAN',TRUE));        
        $LAIN = str_replace(',','',$this->input->post('LAIN',TRUE));        
        $JUMLAH = str_replace(',','',$this->input->post('JUMLAH',TRUE));    
        $jum = count($data);
        $ID = array_column($data, 'NO_ID');
        $jumy = count($NO_ID);
        $i = 0;
        while ($i < $jum) {
            if (in_array($ID[$i], $NO_ID)) {
                $URUT = array_search($ID[$i], $NO_ID);
                $datad = array(
                    'flag' => 'BR',
                    'no_bukti' => $this->input->post('NO_BUKTI'),
                    'kd_bag' => $this->input->post('KD_BAG'),
                    'nm_bag' => $this->input->post('NM_BAG'),
                    'kd_grup' => $this->input->post('KD_GRUP'),
                    'nm_grup' => $this->input->post('NM_GRUP'),
                    'dr' => $this->input->post('DR'),
                    'rec' => $REC[$URUT],
                    'kd_peg' => $KD_PEG[$URUT],
                    'nm_peg' => $NM_PEG[$URUT],
                    'premi' => str_replace(',','',$PREMI[$URUT]),
                    'premi_hr' => str_replace(',','',$PREMI_HR[$URUT]),
                    'ptkp' => $PTKP[$URUT],
                    'ms' => str_replace(',','',$MS[$URUT]),
                    'ik' => str_replace(',','',$IK[$URUT]),
                    'nb' => str_replace(',','',$NB[$URUT]),
                    'hr' => str_replace(',','',$HR[$URUT]),
                    'nett' => str_replace(',','',$NETT[$URUT]),
                    'bon' => str_replace(',','',$BON[$URUT]),
                    'sub' => $SUB[$URUT],
                    'harian' => str_replace(',','',$HARIAN[$URUT]),
                    'lain' => str_replace(',','',$LAIN[$URUT]),
                    'jumlah' => str_replace(',','',$JUMLAH[$URUT]),
                    'per' => $this->session->userdata['periode'],
                    'e_pc' => $this->session->userdata['username'],
                    'e_tgl' => date("Y-m-d h:i a")
                );
                $where = array(
                    'no_id' => $NO_ID[$URUT]
                );
                $this->transaksi_model->update_data($where, $datad, 'hrd_absend');
            } else {
                $where = array(
                    'no_id' => $ID[$i]
                );
                $this->transaksi_model->hapus_data($where, 'hrd_absend');
            }
            $i++;
        }
        $i = 0;
        while ($i < $jumy) {
            if ($NO_ID[$i] == "0") {
                $datad = array(
                    'flag' => 'BR',
                    'id' => $this->input->post('ID', TRUE),
                    'no_bukti' => $this->input->post('NO_BUKTI'),
                    'kd_bag' => $this->input->post('KD_BAG'),
                    'nm_bag' => $this->input->post('NM_BAG'),
                    'kd_grup' => $this->input->post('KD_GRUP'),
                    'nm_grup' => $this->input->post('NM_GRUP'),
                    'dr' => $this->input->post('DR'),
                    'rec' => $REC[$i],
                    'kd_peg' => $KD_PEG[$i],
                    'premi' => str_replace(',','',$PREMI[$i]),
                    'premi_hr' => str_replace(',','',$PREMI_HR[$i]),
                    'nm_peg' => $NM_PEG[$i],
                    'ptkp' => $PTKP[$i],
                    'ms' => str_replace(',','',$MS[$i]),
                    'ik' => str_replace(',','',$IK[$i]),
                    'nb' => str_replace(',','',$NB[$i]),
                    'hr' => str_replace(',','',$HR[$i]),
                    'nett' => str_replace(',','',$NETT[$i]),
                    'bon' => str_replace(',','',$BON[$i]),
                    'subsidi' => str_replace(',','',$SUBSIDI[$i]),
                    'sub' => $SUB[$i],
                    'harian' => str_replace(',','',$HARIAN[$i]),
                    'lain' => str_replace(',','',$LAIN[$i]),
                    'jumlah' => str_replace(',','',$JUMLAH[$i]),
                    'per' => $this->session->userdata['periode'],
                    'e_pc' => $this->session->userdata['username'],
                    'e_tgl' => date("Y-m-d h:i a")
                );
                $this->transaksi_model->input_datad('hrd_absend', $datad);
            }
            $i++;
        }
        $this->session->set_flashdata('pesan', 
            '<div class="alert alert-success alert-dismissible fade show" role="alert"> 
                No Bukti Berhasil Di Update.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>');
        redirect('admin/Transaksi_Borongan_BoronganDragon/index_Transaksi_Borongan_BoronganDragon');
    }

    public function delete($id) {
        $where = array('no_id' => $id);
        $this->transaksi_model->hapus_data($where, 'hrd_absen');
        $where = array('id' => $id);
        $this->transaksi_model->hapus_data($where, 'hrd_absend');
        $this->session->set_flashdata('pesan', 
            '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                Data succesfully Deleted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>');
        redirect('admin/Transaksi_Borongan_BoronganDragon/index_Transaksi_Borongan_BoronganDragon');
    }

    function delete_multiple() {
        $this->transaksi_model->remove_checked('hrd_absen', 'hrd_absend');
        redirect('admin/Transaksi_Borongan_BoronganDragon/index_Transaksi_Borongan_BoronganDragon');
    }

    function filter_kd_bag() {
        $kd_bag = $this->input->get('kd_bag');
        $q1 = "SELECT hrd_peg.kd_peg AS KD_PEG, 
                hrd_peg.nm_peg AS NM_PEG, 
                hrd_peg.ptkp AS PTKP,
                hrd_peg.kd_grup AS KD_GRUP,
                ROUND(hrd_peg.gaji, 2) AS GAJI,
                ROUND(hrd_peg.nett, 2) AS NETT,
                hrd_peg.STAT,
                ROUND(hrd_peg.tastek, 2) AS TASTEK,
                ROUND(hrd_peg.lbl, 2) AS LBL,
                ROUND(hrd_peg.premi, 2) AS PREMIPEG,
                ROUND(hrd_peg.tunjangan, 2) AS TUNJANGAN,
                IF(hrd_bor.pk IS NULL,0,hrd_bor.pk) AS TARIF1,
                IF(hrd_bor.pkph IS NULL,0,hrd_bor.pkph) AS TARIF2
            FROM hrd_peg 
            LEFT JOIN hrd_bor ON hrd_peg.kd_bag=hrd_bor.kd_bag AND hrd_peg.stat=hrd_bor.stat 
            WHERE hrd_peg.kd_bag='$kd_bag' AND hrd_peg.aktif='1' 
            GROUP BY hrd_peg.kd_peg
            ORDER BY hrd_peg.STAT 
            ASC,hrd_peg.kd_peg ";
        $q2 = $this->db->query($q1);
        if($q2->num_rows() > 0){
            foreach($q2->result() as $row){
                $hasil[] = $row;
            }
        };
        echo json_encode($hasil);
    }

    public function getDataAjax_Pegawai() {
        $search = $this->input->post('search');
        $page = ((int)$this->input->post('page'));
        if ($page == 0) {
            $xa = 0;
        } else {
            $xa = ($page - 1) * 10;
        }
        $perPage = 10;
        $results = $this->db->query("SELECT no_id, nm_peg, kd_peg, ptkp, nett, premi
            FROM hrd_peg
            WHERE nm_peg LIKE '%$search%' OR kd_peg LIKE '%$search%' OR ptkp LIKE '%$search%' OR nett LIKE '%$search%' OR premi LIKE '%$search%' 
            ORDER BY nm_peg LIMIT $xa,$perPage");
        $selectajax = array();
        foreach ($results->RESULT_ARRAY() as $row) {
            $selectajax[] = array(
                'id' => $row['nm_peg'],
                'text' => $row['nm_peg'],
                'nm_peg' => $row['nm_peg'] . " - " . $row['kd_peg'] . " - " . $row['ptkp'] . " - " . $row['nett'],
                'kd_peg' => $row['kd_peg'],
                'ptkp' => $row['ptkp'],
                'nett' => $row['nett'],
                'premi' => $row['premi'],
            );
        }
        $select['total_count'] =  $results->NUM_ROWS();
        $select['items'] = $selectajax;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
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
        $PHPJasperXML->load_xml_file("phpjasperxml/Transaksi_Borongan_BoronganDragon.jrxml");
        $no_id = $id;
        $query = "SELECT hrd_absen.no_id as ID,
                hrd_absen.no_sp AS MODEL,
                hrd_absen.perke AS PERKE,
                hrd_absen.tgl_sp AS TGL_SP,
                hrd_absen.nodo AS NODO,
                hrd_absen.tgldo AS TGLDO,
                hrd_absen.tlusin AS TLUSIN,
                hrd_absen.tpair AS TPAIR,

                hrd_absend.no_id AS NO_ID,
                hrd_absend.rec AS REC,
                CONCAT(hrd_absend.article,' - ',hrd_absend.warna) AS ARTICLE,
                hrd_absend.size AS SIZE,
                hrd_absend.golong AS GOLONG,
                hrd_absend.stok AS STOK,
                hrd_absend.lusin AS LUSIN,
                hrd_absend.pair AS PAIR,
                CONCAT(hrd_absend.kodecus,' - ',hrd_absend.nama) AS KODECUS,
                hrd_absend.kota AS KOTA
            FROM hrd_absen,hrd_absend 
            WHERE hrd_absen.no_id=$id 
            AND hrd_absen.no_id=hrd_absend.id 
            ORDER BY hrd_absend.rec";
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