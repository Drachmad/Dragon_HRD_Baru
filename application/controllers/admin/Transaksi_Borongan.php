<?php

class Transaksi_Borongan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!isset($this->session->userdata['username'])) {
            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Anda Belum Login
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
            );
            redirect('admin/auth');
        }
        if ($this->session->userdata['menu_hrd'] != 'hrd_absen') {
            $this->session->set_userdata('menu_hrd', 'hrd_absen');
            $this->session->set_userdata('kode_menu', 'T0002');
            $this->session->set_userdata('keyword_hrd_absen', '');
            $this->session->set_userdata('order_hrd_absen', 'no_id');
        }
    }

    var $column_order = array(null, null, null, 'no_bukti', 'kd_bag', 'nm_bag', 'notes', 'dr');
    var $column_search = array('no_bukti', 'kd_bag', 'nm_bag', 'notes', 'dr');
    var $order = array('no_bukti' => 'asc');

    private function _get_datatables_query()
    {
        $dr = $this->session->userdata['dr'];
        $per = $this->session->userdata['periode'];
        $pt = $this->session->userdata['pt'];
        if ($dr != 'I') {
            $where = array(
                'dr' => $dr,
                'per' => $per,
                'pt' => $pt,
                'flag' => 'BR'
            );
        } else {
            $where = array(
                'dr' => $dr,
                'per' => $per,
                'flag' => 'BR'
            );
        }
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

    function get_datatables()
    {
        $this->_get_datatables_query();
        if (@$_POST['length'] != -1)
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all()
    {
        $dr = $this->session->userdata['dr'];
        $per = $this->session->userdata['periode'];
        $pt = $this->session->userdata['pt'];
        if ($dr != 'I') {
            $where = array(
                'dr' => $dr,
                'per' => $per,
                'pt' => $pt,
                'flag' => 'BR'
            );
        } else {
            $where = array(
                'dr' => $dr,
                'per' => $per,
                'flag' => 'BR'
            );
        }
        $this->db->from('hrd_absen');
        $this->db->where($where);
        return $this->db->count_all_results();
    }

    function get_ajax_hrd_absen()
    {
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
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_Borongan/update/' . $hrd_absen->no_id) . '"> <i class="fa fa-edit"></i> Edit</a>
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_Borongan/delete/' . $hrd_absen->no_id) . '" onclick="return confirm(&quot; Apakah Anda Yakin Ingin Menghapus? &quot;)"><i class="fa fa-trash"></i> Delete</a>
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

    public function index_Transaksi_Borongan()
    {
        $dr = $this->session->userdata['dr'];
        $per = $this->session->userdata['periode'];
        $pt = $this->session->userdata['pt'];
        $this->session->set_userdata('judul', 'Transaksi Borongan');
        if ($dr != 'I') {
            $where = array(
                'dr' => $dr,
                'per' => $per,
                'pt' => $pt,
                'flag' => 'BR'
            );
        } else {
            $where = array(
                'dr' => $dr,
                'per' => $per,
                'flag' => 'BR'
            );
        }
        $data['hrd_absen'] = $this->transaksi_model->tampil_data($where, 'hrd_absen', 'no_id')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_Borongan/Transaksi_Borongan', $data);
        $this->load->view('templates_admin/footer');
    }

    public function input()
    {
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_Borongan/Transaksi_Borongan_form');
        $this->load->view('templates_admin/footer');
    }

    public function input_aksi()
    {
        $kd_bag = $this->input->post('KD_BAG', TRUE);
        $nm_bag = $this->input->post('NM_BAG', TRUE);
        $fase = $this->input->post('FASE', TRUE);
        $inisialpt = '';
        if ($this->session->userdata['dr'] != 'I' && $this->session->userdata['pt'] == '1') {
            $inisialpt = 'PT';
        } elseif ($this->session->userdata['dr'] != 'I' &&  $this->session->userdata['pt'] == '0') {
            $inisialpt = 'CV';
        }
        $pr = substr($this->session->userdata['periode'], 0, 2);
        $pr1 = substr($this->session->userdata['periode'], -2) . substr($this->session->userdata['periode'], 0, 2);
        $bukti = 'BR' . $pr1 . '.' . $pr . '.' . $inisialpt . $fase . '-' . $kd_bag;
        $datah = array(
            'flag' => 'BR',
            'no_bukti' => $bukti,
            'kd_bag' => $this->input->post('KD_BAG', TRUE),
            'nm_bag' => $this->input->post('NM_BAG', TRUE),
            'kd_grup' => $this->input->post('KD_GRUP', TRUE),
            'nm_grup' => $this->input->post('NM_GRUP', TRUE),
            'notes' => $this->input->post('NOTES', TRUE),
            'fase' => $this->input->post('FASE', TRUE),
            'premi' => str_replace(',', '', $this->input->post('PREMI', TRUE)),
            'tms' => str_replace(',', '', $this->input->post('TMS', TRUE)),
            'tot_pot' => str_replace(',', '', $this->input->post('TOT_POT', TRUE)),
            'netto' => str_replace(',', '', $this->input->post('NETTO', TRUE)),
            'other' => str_replace(',', '', $this->input->post('OTHER', TRUE)),
            'tot_bon' => str_replace(',', '', $this->input->post('TOT_BON', TRUE)),
            'lain' => str_replace(',', '', $this->input->post('LAIN', TRUE)),
            'kik_nett' => str_replace(',', '', $this->input->post('KIK_NETT', TRUE)),
            'tik' => str_replace(',', '', $this->input->post('TIK', TRUE)),
            'tnb' => str_replace(',', '', $this->input->post('TNB', TRUE)),
            'thr' => str_replace(',', '', $this->input->post('THR', TRUE)),
            'ttotal' => str_replace(',', '', $this->input->post('TTOTAL', TRUE)),
            'tbon1' => str_replace(',', '', $this->input->post('TBON1', TRUE)),
            'tsubs' => str_replace(',', '', $this->input->post('TSUBS', TRUE)),
            'ttot_hr' => str_replace(',', '', $this->input->post('TTOT_HR', TRUE)),
            'tpotong' => str_replace(',', '', $this->input->post('TPOTONG', TRUE)),
            'tjumlah' => str_replace(',', '', $this->input->post('TJUMLAH', TRUE)),
            'dr' => $this->session->userdata['dr'],
            'pt' => $this->session->userdata['pt'],
            'cv' => $this->session->userdata['cv'],
            'per' => $this->session->userdata['periode'],
            'usrnm' => $this->session->userdata['username'],
            'i_tgl' => date("Y-m-d h:i a")
        );
        $this->transaksi_model->input_datah('hrd_absen', $datah);
        $ID = $this->db->query("SELECT MAX(no_id) AS no_id FROM hrd_absen WHERE no_bukti = '$bukti' GROUP BY no_bukti")->result();
        $REC = $this->input->post('REC');
        $KD_PEG = $this->input->post('KD_PEG');
        $NM_PEG = $this->input->post('NM_PEG');
        $KD_GRUP = $this->input->post('KD_GRUP');
        $NM_GRUP = $this->input->post('NM_GRUP');
        $PT = $this->input->post('PT');
        $PTKP = $this->input->post('PTKP');
        $STAT = $this->input->post('STAT');
        $TARIF1 = str_replace(',', '', $this->input->post('TARIF1', TRUE));
        $TARIF2 = str_replace(',', '', $this->input->post('TARIF2', TRUE));
        $TASTEK = str_replace(',', '', $this->input->post('TASTEK', TRUE));
        $LBL = str_replace(',', '', $this->input->post('LBL', TRUE));
        $PREMIPEG = str_replace(',', '', $this->input->post('PREMIPEG', TRUE));
        $TUNJANGAN = str_replace(',', '', $this->input->post('TUNJANGAN', TRUE));
        $NETT = str_replace(',', '', $this->input->post('NETT', TRUE));
        $TOTALD = str_replace(',', '', $this->input->post('TOTALD', TRUE));
        $MSD = str_replace(',', '', $this->input->post('MSD', TRUE));
        $IK = str_replace(',', '', $this->input->post('IK', TRUE));
        $NB = str_replace(',', '', $this->input->post('NB', TRUE));
        $HR = str_replace(',', '', $this->input->post('HR', TRUE));
        $TOTAL = str_replace(',', '', $this->input->post('TOTAL', TRUE));
        $BON1 = str_replace(',', '', $this->input->post('BON1', TRUE));
        $SUBS = str_replace(',', '', $this->input->post('SUBS', TRUE));
        $SUB = $this->input->post('SUB');
        $TOT_HR = str_replace(',', '', $this->input->post('TOT_HR', TRUE));
        $POTONG = str_replace(',', '', $this->input->post('POTONG', TRUE));
        $JUMLAH = str_replace(',', '', $this->input->post('JUMLAH', TRUE));
        $i = 0;
        foreach ($REC as $a) {
            $datad = array(
                'id' => $ID[0]->no_id,
                'no_bukti' => $bukti,
                'kd_bag' => $kd_bag,
                'nm_bag' => $nm_bag,
                'kd_grup' => $KD_GRUP,
                'nm_grup' => $NM_GRUP,
                'flag' => 'BR',
                'rec' => $REC[$i],
                'kd_peg' => $KD_PEG[$i],
                'nm_peg' => $NM_PEG[$i],
                'pt' => $PT[$i],
                'ptkp' => $PTKP[$i],
                'stat' => $STAT[$i],
                'tarif1' => str_replace(',', '', $TARIF1[$i]),
                'tarif2' => str_replace(',', '', $TARIF2[$i]),
                'nett' => str_replace(',', '', $NETT[$i]),
                'tastek' => str_replace(',', '', $TASTEK[$i]),
                'lbl' => str_replace(',', '', $LBL[$i]),
                'premipeg' => str_replace(',', '', $PREMIPEG[$i]),
                'tunjangan' => str_replace(',', '', $TUNJANGAN[$i]),
                'nett' => str_replace(',', '', $NETT[$i]),
                'totald' => str_replace(',', '', $TOTALD[$i]),
                'msd' => str_replace(',', '', $MSD[$i]),
                'ik' => str_replace(',', '', $IK[$i]),
                'nb' => str_replace(',', '', $NB[$i]),
                'hr' => str_replace(',', '', $HR[$i]),
                'total' => str_replace(',', '', $TOTAL[$i]),
                'bon1' => str_replace(',', '', $BON1[$i]),
                'subs' => str_replace(',', '', $SUBS[$i]),
                'sub' => isset($SUB[$i]) ? $SUB[$i] : 0,
                'tot_hr' => str_replace(',', '', $TOT_HR[$i]),
                'potong' => str_replace(',', '', $POTONG[$i]),
                'jumlah' => str_replace(',', '', $JUMLAH[$i]),
                'dr' => $this->session->userdata['dr'],
                'per' => $this->session->userdata['periode'],
                'usrnm' => $this->session->userdata['username'],
                'i_tgl' => date("Y-m-d h:i a")
            );
            $this->transaksi_model->input_datad('hrd_absend', $datad);
            $i++;
        }
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-dismissible fade show" role="alert"> 
                Data succesfully Inserted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Transaksi_Borongan/index_Transaksi_Borongan');
    }

    public function update($id)
    {
        $q1 = "SELECT hrd_absen.no_id as ID,
                hrd_absen.no_bukti AS NO_BUKTI,
                hrd_absen.kd_bag AS KD_BAG,
                hrd_absen.nm_bag AS NM_BAG,
                hrd_absen.notes AS NOTES,
                hrd_absen.fase AS FASE,
                hrd_absen.premi AS PREMI,
                hrd_absen.tms AS TMS,
                hrd_absen.tot_pot AS TOT_POT,
                hrd_absen.netto AS NETTO,
                hrd_absen.other AS OTHER,
                hrd_absen.tot_bon AS TOT_BON,
                hrd_absen.lain AS LAIN,
                hrd_absen.kik_nett AS KIK_NETT,
                hrd_absen.tmsd AS TMSD,
                hrd_absen.tik AS TIK,
                hrd_absen.tnb AS TNB,
                hrd_absen.thr AS THR,
                hrd_absen.ttotal AS TTOTAL,
                hrd_absen.tbon1 AS TBON1,
                hrd_absen.tsubs AS TSUBS,
                hrd_absen.ttot_hr AS TTOT_HR,
                hrd_absen.tpotong AS TPOTONG,
                hrd_absen.tjumlah AS TJUMLAH,

                hrd_absend.no_id AS NO_ID,
                hrd_absend.rec AS REC,
                hrd_absend.kd_peg AS KD_PEG,
                hrd_absend.nm_peg AS NM_PEG,
                hrd_absend.pt AS PT,
                hrd_absend.ptkp AS PTKP,
                hrd_absend.stat AS STAT,
                hrd_absend.tarif1 AS TARIF1,
                hrd_absend.tarif2 AS TARIF2,
                hrd_absend.nett AS NETT,
                hrd_absend.tastek AS TASTEK,
                hrd_absend.lbl AS LBL,
                hrd_absend.premipeg AS PREMIPEG,
                hrd_absend.tunjangan AS TUNJANGAN,
                hrd_absend.nett AS NETT,
                hrd_absend.totald AS TOTALD,
                hrd_absend.msd AS MSD,
                hrd_absend.ik AS IK,
                hrd_absend.nb AS NB,
                hrd_absend.hr AS HR,
                hrd_absend.total AS TOTAL,
                hrd_absend.bon1 AS BON1,
                hrd_absend.subs AS SUBS,
                hrd_absend.sub AS SUB,
                hrd_absend.tot_hr AS TOT_HR,
                hrd_absend.potong AS POTONG,
                hrd_absend.jumlah AS JUMLAH
            FROM hrd_absen,hrd_absend 
            WHERE hrd_absen.no_id=$id 
            AND hrd_absen.no_id=hrd_absend.id 
            ORDER BY hrd_absend.rec";
        $data['transaksi_borongan'] = $this->transaksi_model->edit_data($q1)->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_Borongan/Transaksi_Borongan_update', $data);
        $this->load->view('templates_admin/footer');
    }

    public function update_aksi()
    {
        $datah = array(
            'flag' => 'BR',
            'no_bukti' => $this->input->post('NO_BUKTI', TRUE),
            'kd_bag' => $this->input->post('KD_BAG', TRUE),
            'nm_bag' => $this->input->post('NM_BAG', TRUE),
            'notes' => $this->input->post('NOTES', TRUE),
            'fase' => $this->input->post('FASE', TRUE),
            'premi' => str_replace(',', '', $this->input->post('PREMI', TRUE)),
            'tms' => str_replace(',', '', $this->input->post('TMS', TRUE)),
            'tot_pot' => str_replace(',', '', $this->input->post('TOT_POT', TRUE)),
            'netto' => str_replace(',', '', $this->input->post('NETTO', TRUE)),
            'other' => str_replace(',', '', $this->input->post('OTHER', TRUE)),
            'tot_bon' => str_replace(',', '', $this->input->post('TOT_BON', TRUE)),
            'lain' => str_replace(',', '', $this->input->post('LAIN', TRUE)),
            'kik_nett' => str_replace(',', '', $this->input->post('KIK_NETT', TRUE)),
            'tmsd' => str_replace(',', '', $this->input->post('TMSD', TRUE)),
            'tik' => str_replace(',', '', $this->input->post('TIK', TRUE)),
            'tnb' => str_replace(',', '', $this->input->post('TNB', TRUE)),
            'thr' => str_replace(',', '', $this->input->post('THR', TRUE)),
            'ttotal' => str_replace(',', '', $this->input->post('TTOTAL', TRUE)),
            'tbon1' => str_replace(',', '', $this->input->post('TBON1', TRUE)),
            'tsubs' => str_replace(',', '', $this->input->post('TSUBS', TRUE)),
            'ttot_hr' => str_replace(',', '', $this->input->post('TTOT_HR', TRUE)),
            'tpotong' => str_replace(',', '', $this->input->post('TPOTONG', TRUE)),
            'tjumlah' => str_replace(',', '', $this->input->post('TJUMLAH', TRUE)),
            'dr' => $this->session->userdata['dr'],
            'per' => $this->session->userdata['periode'],
            'e_pc' => $this->session->userdata['username'],
            'e_tgl' => date("Y-m-d h:i a")
        );
        $where = array(
            'no_id' => $this->input->post('ID', TRUE)
        );
        $this->transaksi_model->update_data($where, $datah, 'hrd_absen');
        $id = $this->input->post('ID', TRUE);
        $q1 = "SELECT hrd_absen.no_id as ID,
                hrd_absen.no_bukti AS NO_BUKTI,
                hrd_absen.kd_bag AS KD_BAG,
                hrd_absen.nm_bag AS NM_BAG,
                hrd_absen.notes AS NOTES,
                hrd_absen.fase AS FASE,
                hrd_absen.premi AS PREMI,
                hrd_absen.tms AS TMS,
                hrd_absen.tot_pot AS TOT_POT,
                hrd_absen.netto AS NETTO,
                hrd_absen.other AS OTHER,
                hrd_absen.tot_bon AS TOT_BON,
                hrd_absen.lain AS LAIN,
                hrd_absen.kik_nett AS KIK_NETT,
                hrd_absen.tmsd AS TMSD,
                hrd_absen.tik AS TIK,
                hrd_absen.tnb AS TNB,
                hrd_absen.thr AS THR,
                hrd_absen.ttotal AS TTOTAL,
                hrd_absen.tbon1 AS TBON1,
                hrd_absen.tsubs AS TSUBS,
                hrd_absen.ttot_hr AS TTOT_HR,
                hrd_absen.tpotong AS TPOTONG,
                hrd_absen.tjumlah AS TJUMLAH,

                hrd_absend.no_id AS NO_ID,
                hrd_absend.rec AS REC,
                hrd_absend.kd_peg AS KD_PEG,
                hrd_absend.nm_peg AS NM_PEG,
                hrd_absend.pt AS PT,
                hrd_absend.ptkp AS PTKP,
                hrd_absend.stat AS STAT,
                hrd_absend.tarif1 AS TARIF1,
                hrd_absend.tarif2 AS TARIF2,
                hrd_absend.nett AS NETT,
                hrd_absend.tastek AS TASTEK,
                hrd_absend.lbl AS LBL,
                hrd_absend.premipeg AS PREMIPEG,
                hrd_absend.tunjangan AS TUNJANGAN,
                hrd_absend.nett AS NETT,
                hrd_absend.totald AS TOTALD,
                hrd_absend.msd AS MSD,
                hrd_absend.ik AS IK,
                hrd_absend.nb AS NB,
                hrd_absend.hr AS HR,
                hrd_absend.total AS TOTAL,
                hrd_absend.bon1 AS BON1,
                hrd_absend.subs AS SUBS,
                hrd_absend.sub AS SUB,
                hrd_absend.tot_hr AS TOT_HR,
                hrd_absend.potong AS POTONG,
                hrd_absend.jumlah AS JUMLAH
            FROM hrd_absen,hrd_absend 
            WHERE hrd_absen.no_id=$id 
            AND hrd_absen.no_id=hrd_absend.id 
            ORDER BY hrd_absend.rec";
        $data = $this->transaksi_model->edit_data($q1)->result();
        $NO_ID = $this->input->post('NO_ID');
        $REC = $this->input->post('REC');
        $KD_PEG = $this->input->post('KD_PEG');
        $NM_PEG = $this->input->post('NM_PEG');
        $PT = $this->input->post('PT');
        $PTKP = $this->input->post('PTKP');
        $STAT = $this->input->post('STAT');
        $TARIF1 = str_replace(',', '', $this->input->post('TARIF1', TRUE));
        $TARIF2 = str_replace(',', '', $this->input->post('TARIF2', TRUE));
        $NETT = str_replace(',', '', $this->input->post('NETT', TRUE));
        $TASTEK = str_replace(',', '', $this->input->post('TASTEK', TRUE));
        $LBL = str_replace(',', '', $this->input->post('LBL', TRUE));
        $PREMIPEG = str_replace(',', '', $this->input->post('PREMIPEG', TRUE));
        $TUNJANGAN = str_replace(',', '', $this->input->post('TUNJANGAN', TRUE));
        $NETT = str_replace(',', '', $this->input->post('NETT', TRUE));
        $TOTALD = str_replace(',', '', $this->input->post('TOTALD', TRUE));
        $MSD = str_replace(',', '', $this->input->post('MSD', TRUE));
        $IK = str_replace(',', '', $this->input->post('IK', TRUE));
        $NB = str_replace(',', '', $this->input->post('NB', TRUE));
        $HR = str_replace(',', '', $this->input->post('HR', TRUE));
        $TOTAL = str_replace(',', '', $this->input->post('TOTAL', TRUE));
        $BON1 = str_replace(',', '', $this->input->post('BON1', TRUE));
        $SUBS = str_replace(',', '', $this->input->post('SUBS', TRUE));
        $SUB = $this->input->post('SUB');
        $TOT_HR = str_replace(',', '', $this->input->post('TOT_HR', TRUE));
        $POTONG = str_replace(',', '', $this->input->post('POTONG', TRUE));
        $JUMLAH = str_replace(',', '', $this->input->post('JUMLAH', TRUE));
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
                    'rec' => $REC[$URUT],
                    'kd_peg' => $KD_PEG[$URUT],
                    'nm_peg' => $NM_PEG[$URUT],
                    'pt' => $PT[$URUT],
                    'ptkp' => $PTKP[$URUT],
                    'stat' => $STAT[$URUT],
                    'tarif1' => str_replace(',', '', $TARIF1[$URUT]),
                    'tarif2' => str_replace(',', '', $TARIF2[$URUT]),
                    'nett' => str_replace(',', '', $NETT[$URUT]),
                    'tastek' => str_replace(',', '', $TASTEK[$URUT]),
                    'lbl' => str_replace(',', '', $LBL[$URUT]),
                    'premipeg' => str_replace(',', '', $PREMIPEG[$URUT]),
                    'tunjangan' => str_replace(',', '', $TUNJANGAN[$URUT]),
                    'nett' => str_replace(',', '', $NETT[$URUT]),
                    'totald' => str_replace(',', '', $TOTALD[$URUT]),
                    'msd' => str_replace(',', '', $MSD[$URUT]),
                    'ik' => str_replace(',', '', $IK[$URUT]),
                    'nb' => str_replace(',', '', $NB[$URUT]),
                    'hr' => str_replace(',', '', $HR[$URUT]),
                    'total' => str_replace(',', '', $TOTAL[$URUT]),
                    'bon1' => str_replace(',', '', $BON1[$URUT]),
                    'subs' => str_replace(',', '', $SUBS[$URUT]),
                    'sub' => isset($SUB[$URUT]) ? $SUB[$URUT] : 0,
                    'tot_hr' => str_replace(',', '', $TOT_HR[$URUT]),
                    'potong' => str_replace(',', '', $POTONG[$URUT]),
                    'jumlah' => str_replace(',', '', $JUMLAH[$URUT]),
                    'dr' => $this->session->userdata['dr'],
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
                    'rec' => $REC[$i],
                    'kd_peg' => $KD_PEG[$i],
                    'nm_peg' => $NM_PEG[$i],
                    'pt' => $PT[$i],
                    'ptkp' => $PTKP[$i],
                    'stat' => $STAT[$i],
                    'tarif1' => str_replace(',', '', $TARIF1[$i]),
                    'tarif2' => str_replace(',', '', $TARIF2[$i]),
                    'nett' => str_replace(',', '', $NETT[$i]),
                    'tastek' => str_replace(',', '', $TASTEK[$i]),
                    'lbl' => str_replace(',', '', $LBL[$i]),
                    'premipeg' => str_replace(',', '', $PREMIPEG[$i]),
                    'tunjangan' => str_replace(',', '', $TUNJANGAN[$i]),
                    'nett' => str_replace(',', '', $NETT[$i]),
                    'totald' => str_replace(',', '', $TOTALD[$i]),
                    'msd' => str_replace(',', '', $MSD[$i]),
                    'ik' => str_replace(',', '', $IK[$i]),
                    'nb' => str_replace(',', '', $NB[$i]),
                    'hr' => str_replace(',', '', $HR[$i]),
                    'total' => str_replace(',', '', $TOTAL[$i]),
                    'bon1' => str_replace(',', '', $BON1[$i]),
                    'subs' => str_replace(',', '', $SUBS[$i]),
                    'sub' => isset($SUB[$i]) ? $SUB[$i] : 0,
                    'tot_hr' => str_replace(',', '', $TOT_HR[$i]),
                    'potong' => str_replace(',', '', $POTONG[$i]),
                    'jumlah' => str_replace(',', '', $JUMLAH[$i]),
                    'dr' => $this->session->userdata['dr'],
                    'per' => $this->session->userdata['periode'],
                    'e_pc' => $this->session->userdata['username'],
                    'e_tgl' => date("Y-m-d h:i a")
                );
                $this->transaksi_model->input_datad('hrd_absend', $datad);
            }
            $i++;
        }
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-dismissible fade show" role="alert"> 
                No Bukti Berhasil Di Update.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Transaksi_Borongan/index_Transaksi_Borongan');
    }

    public function delete($id)
    {
        $where = array('no_id' => $id);
        $this->transaksi_model->hapus_data($where, 'hrd_absen');
        $where = array('id' => $id);
        $this->transaksi_model->hapus_data($where, 'hrd_absend');
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-dismissible fade show" role="alert"> 
                Data succesfully Deleted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Transaksi_Borongan/index_Transaksi_Borongan');
    }

    function delete_multiple()
    {
        $this->transaksi_model->remove_checked('hrd_absen', 'hrd_absend');
        redirect('admin/Transaksi_Borongan/index_Transaksi_Borongan');
    }

    function filter_kd_bag()
    {
        $kd_bag = $this->input->get('kd_bag');
        $dr = $this->session->userdata['dr'];
        $pt = $this->session->userdata['pt'];
        $cv = $this->session->userdata['cv'];
        if ($this->session->userdata['dr'] == 'I') {
            $q1 = "SELECT hrd_peg.kd_peg AS KD_PEG, 
                hrd_peg.nm_peg AS NM_PEG, 
                CASE 
					WHEN hrd_peg.pt = 0 THEN 'CV'
					WHEN hrd_peg.pt = 1 THEN 'PT'
				END AS PT,
                hrd_peg.ptkp AS PTKP,
                hrd_peg.kd_grup AS KD_GRUP,
                hrd_peg.nm_grup AS NM_GRUP,
                ROUND(hrd_peg.gaji, 2) AS NETT,
                -- ROUND(hrd_peg.nett, 2) AS NETT,
                hrd_peg.STAT,
                ROUND(hrd_peg.tastek, 2) AS TASTEK,
                ROUND(hrd_peg.lbl, 2) AS LBL,
                ROUND(hrd_peg.premi, 2) AS PREMIPEG,
                ROUND(hrd_peg.tunjangan, 2) AS TUNJANGAN,
                IF(hrd_bor.pk IS NULL,0,hrd_bor.pk) AS TARIF1,
                IF(hrd_bor.pkph IS NULL,0,hrd_bor.pkph) AS TARIF2
            FROM hrd_peg 
            LEFT JOIN hrd_bor ON hrd_peg.kd_bag=hrd_bor.kd_bag AND hrd_peg.stat=hrd_bor.stat 
            WHERE hrd_peg.kd_bag='$kd_bag'
            AND hrd_peg.cv!='CKR'
            AND hrd_peg.aktif='1' 
            GROUP BY hrd_peg.kd_peg
            ORDER BY hrd_peg.pt DESC, hrd_peg.STAT
            DESC,hrd_peg.kd_peg ";
        } else {
            $q1 = "SELECT hrd_peg.kd_peg AS KD_PEG, 
                hrd_peg.nm_peg AS NM_PEG, 
                CASE 
					WHEN hrd_peg.pt = 0 THEN 'CV'
					WHEN hrd_peg.pt = 1 THEN 'PT'
				END AS PT,
                hrd_peg.ptkp AS PTKP,
                hrd_peg.kd_grup AS KD_GRUP,
                hrd_peg.nm_grup AS NM_GRUP,
                ROUND(hrd_peg.gaji, 2) AS NETT,
                -- ROUND(hrd_peg.nett, 2) AS NETT,
                hrd_peg.STAT,
                ROUND(hrd_peg.tastek, 2) AS TASTEK,
                ROUND(hrd_peg.lbl, 2) AS LBL,
                ROUND(hrd_peg.premi, 2) AS PREMIPEG,
                ROUND(hrd_peg.tunjangan, 2) AS TUNJANGAN,
                IF(hrd_bor.pk IS NULL,0,hrd_bor.pk) AS TARIF1,
                IF(hrd_bor.pkph IS NULL,0,hrd_bor.pkph) AS TARIF2
            FROM hrd_peg 
            LEFT JOIN hrd_bor ON hrd_peg.kd_bag=hrd_bor.kd_bag AND hrd_peg.stat=hrd_bor.stat 
            WHERE hrd_peg.kd_bag='$kd_bag' 
            AND hrd_peg.aktif='1' 
            AND hrd_peg.pt='$pt'
            AND hrd_peg.cv='$cv'
            GROUP BY hrd_peg.kd_peg
            ORDER BY hrd_peg.STAT 
            DESC,hrd_peg.kd_peg ";
        }
        $q2 = $this->db->query($q1);
        if ($q2->num_rows() > 0) {
            foreach ($q2->result() as $row) {
                $hasil[] = $row;
            }
        };
        echo json_encode($hasil);
    }

    public function getDataAjax_Pegawai()
    {
        $search = $this->input->post('search');
        $page = ((int)$this->input->post('page'));
        if ($page == 0) {
            $xa = 0;
        } else {
            $xa = ($page - 1) * 10;
        }
        $perPage = 10;
        $results = $this->db->query("SELECT no_id, 
                nm_peg, 
                kd_peg, 
                CASE 
					WHEN pt = 0 THEN 'CV'
					WHEN pt = 1 THEN 'PT'
				END AS PT,
                ptkp, 
                nett, 
                premi
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
                'pt' => $row['pt'],
            );
        }
        $select['total_count'] =  $results->NUM_ROWS();
        $select['items'] = $selectajax;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    function JASPER($id)
    {
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
        $PHPJasperXML->load_xml_file("phpjasperxml/Transaksi_Borongan.jrxml");
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
