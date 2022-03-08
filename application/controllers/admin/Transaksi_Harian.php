<?php

class Transaksi_Harian extends CI_Controller
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
            $this->session->set_userdata('kode_menu', 'T0001');
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
        $where = array(
            'dr' => $dr,
            'per' => $per,
            'flag' => 'HR'
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
        $where = array(
            'dr' => $dr,
            'per' => $per,
            'flag' => 'HR'
        );
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
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_Harian/update/' . $hrd_absen->no_id) . '"> <i class="fa fa-edit"></i> Edit</a>
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_Harian/delete/' . $hrd_absen->no_id) . '" onclick="return confirm(&quot; Apakah Anda Yakin Ingin Menghapus? &quot;)"><i class="fa fa-trash"></i> Delete</a>
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

    public function index_Transaksi_Harian()
    {
        $dr = $this->session->userdata['dr'];
        $per = $this->session->userdata['periode'];
        $this->session->set_userdata('judul', 'Transaksi Harian');
        $where = array(
            'dr' => $dr,
            'per' => $per,
            'flag' => 'HR'
        );
        $data['hrd_absen'] = $this->transaksi_model->tampil_data($where, 'hrd_absen', 'no_id')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_Harian/Transaksi_Harian', $data);
        $this->load->view('templates_admin/footer');
    }

    public function input()
    {
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_Harian/Transaksi_Harian_form');
        $this->load->view('templates_admin/footer');
    }

    public function input_aksi()
    {
        $kd_bag = $this->input->post('KD_BAG', TRUE);
        $nm_bag = $this->input->post('NM_BAG', TRUE);
        $kd_grup = $this->input->post('KD_GRUP', TRUE);
        $nm_grup = $this->input->post('NM_GRUP', TRUE);
        $dr = $this->input->post('DR', TRUE);
        $per = $this->session->userdata['periode'];
        $pr = substr($this->session->userdata['periode'], 0, 2);
        $pr1 = substr($this->session->userdata['periode'], -2) . substr($this->session->userdata['periode'], 0, 2);
        $bukti = 'HR' . $pr1 . '.' . $pr . '-' . $kd_bag;
        $datah = array(
            'flag' => 'HR',
            'no_bukti' => $bukti,
            'kd_bag' => $this->input->post('KD_BAG', TRUE),
            'nm_bag' => $this->input->post('NM_BAG', TRUE),
            'kd_grup' => $this->input->post('KD_GRUP', TRUE),
            'nm_grup' => $this->input->post('NM_GRUP', TRUE),
            'dr' => $this->input->post('DR', TRUE),
            'notes' => $this->input->post('NOTES', TRUE),
            'tharian' => str_replace(',', '', $this->input->post('THARIAN', TRUE)),
            't_hr' => str_replace(',', '', $this->input->post('T_HR', TRUE)),
            'tjam1thl' => str_replace(',', '', $this->input->post('TJAM1THL', TRUE)),
            'tjam2thl' => str_replace(',', '', $this->input->post('TJAM2THL', TRUE)),
            'tjam1rpthl' => str_replace(',', '', $this->input->post('TJAM1RPTHL', TRUE)),
            'tjam2rpthl' => str_replace(',', '', $this->input->post('TJAM2RPTHL', TRUE)),
            'tjam1' => str_replace(',', '', $this->input->post('TJAM1', TRUE)),
            'tjam2' => str_replace(',', '', $this->input->post('TJAM2', TRUE)),
            'tjam1rp' => str_replace(',', '', $this->input->post('TJAM1RP', TRUE)),
            'tjam2rp' => str_replace(',', '', $this->input->post('TJAM2RP', TRUE)),
            'tlain' => str_replace(',', '', $this->input->post('TLAIN', TRUE)),
            't_tperbulan' => str_replace(',', '', $this->input->post('T_TPERBULAN', TRUE)),
            'tjumlah' => str_replace(',', '', $this->input->post('TJUMLAH', TRUE)),
            'per' => $this->session->userdata['periode'],
            'usrnm' => $this->session->userdata['username'],
            'i_tgl' => date("Y-m-d h:i a")
        );
        $this->transaksi_model->input_datah('hrd_absen', $datah);
        $ID = $this->db->query("SELECT MAX(no_id) AS no_id FROM hrd_absen WHERE no_bukti = '$bukti' AND dr='$dr' AND per='$per' GROUP BY no_bukti")->result();
        $REC = $this->input->post('REC');
        $KD_PEG = $this->input->post('KD_PEG');
        $PL = str_replace(',', '', $this->input->post('PL', TRUE));
        $GAJI = str_replace(',', '', $this->input->post('GAJI', TRUE));
        $NETT = str_replace(',', '', $this->input->post('NETT', TRUE));
        $PL_HR = str_replace(',', '', $this->input->post('PL_HR', TRUE));
        $HARIAN = str_replace(',', '', $this->input->post('HARIAN', TRUE));
        $NM_PEG = $this->input->post('NM_PEG');
        $PTKP = $this->input->post('PTKP');
        $HR = str_replace(',', '', $this->input->post('HR', TRUE));
        $JAM1THL = str_replace(',', '', $this->input->post('JAM1THL', TRUE));
        $JAM2THL = str_replace(',', '', $this->input->post('JAM2THL', TRUE));
        $JAM1RPTHL = str_replace(',', '', $this->input->post('JAM1RPTHL', TRUE));
        $JAM2RPTHL = str_replace(',', '', $this->input->post('JAM2RPTHL', TRUE));
        $JAM1 = str_replace(',', '', $this->input->post('JAM1', TRUE));
        $JAM2 = str_replace(',', '', $this->input->post('JAM2', TRUE));
        $JAM1RP = str_replace(',', '', $this->input->post('JAM1RP', TRUE));
        $JAM2RP = str_replace(',', '', $this->input->post('JAM2RP', TRUE));
        $LAIN = str_replace(',', '', $this->input->post('LAIN', TRUE));
        $POT = str_replace(',', '', $this->input->post('POT', TRUE));
        $TPERBULAN = str_replace(',', '', $this->input->post('TPERBULAN', TRUE));
        $JUMLAH = str_replace(',', '', $this->input->post('JUMLAH', TRUE));
        $i = 0;
        foreach ($REC as $a) {
            $datad = array(
                'id' => $ID[0]->no_id,
                'no_bukti' => $bukti,
                'kd_bag' => $kd_bag,
                'nm_bag' => $nm_bag,
                'kd_grup' => $kd_grup,
                'nm_grup' => $nm_grup,
                'dr' => $dr,
                'flag' => 'HR',
                'rec' => $REC[$i],
                'kd_peg' => $KD_PEG[$i],
                'gaji' => str_replace(',', '', $GAJI[$i]),
                'nett' => str_replace(',', '', $NETT[$i]),
                'harian' => str_replace(',', '', $HARIAN[$i]),
                'nm_peg' => $NM_PEG[$i],
                'ptkp' => $PTKP[$i],
                'hr' => str_replace(',', '', $HR[$i]),
                'jam1thl' => str_replace(',', '', $JAM1THL[$i]),
                'jam2thl' => str_replace(',', '', $JAM2THL[$i]),
                'jam1rpthl' => str_replace(',', '', $JAM1RPTHL[$i]),
                'jam2rpthl' => str_replace(',', '', $JAM2RPTHL[$i]),
                'jam1' => str_replace(',', '', $JAM1[$i]),
                'jam2' => str_replace(',', '', $JAM2[$i]),
                'jam1rp' => str_replace(',', '', $JAM1RP[$i]),
                'jam2rp' => str_replace(',', '', $JAM2RP[$i]),
                'lain' => str_replace(',', '', $LAIN[$i]),
                'pot' => str_replace(',', '', $POT[$i]),
                'tperbulan' => str_replace(',', '', $TPERBULAN[$i]),
                'jumlah' => str_replace(',', '', $JUMLAH[$i]),
                'per' => $this->session->userdata['periode'],
                'usrnm' => $this->session->userdata['username'],
                'i_tgl' => date("Y-m-d h:i a")
            );
            $this->transaksi_model->input_datad('hrd_absend', $datad);
            $i++;
        }
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                Data succesfully Inserted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Transaksi_Harian/index_Transaksi_Harian');
    }

    public function update($id)
    {
        $q1 = "SELECT hrd_absen.no_id as ID,
                hrd_absen.no_bukti AS NO_BUKTI,
                hrd_absen.kd_bag AS KD_BAG,
                hrd_absen.nm_bag AS NM_BAG,
                hrd_absen.kd_grup AS KD_GRUP,
                hrd_absen.nm_grup AS NM_GRUP,
                hrd_absen.dr AS DR,
                hrd_absen.notes AS NOTES,
                hrd_absen.tharian AS THARIAN,
                hrd_absen.t_hr AS T_HR,
                hrd_absen.tjam1thl AS TJAM1THL,
                hrd_absen.tjam2thl AS TJAM2THL,
                hrd_absen.tjam1rpthl AS TJAM1RPTHL,
                hrd_absen.tjam2rpthl AS TJAM2RPTHL,
                hrd_absen.tjam1 AS TJAM1,
                hrd_absen.tjam2 AS TJAM2,
                hrd_absen.tjam1rp AS TJAM1RP,
                hrd_absen.tjam2rp AS TJAM2RP,
                hrd_absen.tlain AS TLAIN,
                hrd_absen.t_tperbulan AS T_TPERBULAN,
                hrd_absen.tjumlah AS TJUMLAH,

                hrd_absend.no_id AS NO_ID,
                hrd_absend.rec AS REC,
                hrd_absend.kd_peg AS KD_PEG,
                hrd_absend.gaji AS GAJI,
                hrd_absend.nett AS NETT,
                hrd_absend.harian AS HARIAN,
                hrd_absend.nm_peg AS NM_PEG,
                hrd_absend.ptkp AS PTKP,
                hrd_absend.hr AS HR,
                hrd_absend.jam1thl AS JAM1THL,
                hrd_absend.jam2thl AS JAM2THL,
                hrd_absend.jam1rpthl AS JAM1RPTHL,
                hrd_absend.jam2rpthl AS JAM2RPTHL,
                hrd_absend.jam1 AS JAM1,
                hrd_absend.jam2 AS JAM2,
                hrd_absend.jam1rp AS JAM1RP,
                hrd_absend.jam2rp AS JAM2RP,
                hrd_absend.lain AS LAIN,
                hrd_absend.pot AS POT,
                hrd_absend.tperbulan AS TPERBULAN,
                hrd_absend.jumlah AS JUMLAH
            FROM hrd_absen,hrd_absend 
            WHERE hrd_absen.no_id=$id 
            AND hrd_absen.no_id=hrd_absend.id 
            ORDER BY hrd_absend.rec";
        $data['transaksi_harian'] = $this->transaksi_model->edit_data($q1)->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_Harian/Transaksi_Harian_update', $data);
        $this->load->view('templates_admin/footer');
    }

    public function update_aksi()
    {
        $datah = array(
            'flag' => 'HR',
            'no_bukti' => $this->input->post('NO_BUKTI', TRUE),
            'kd_bag' => $this->input->post('KD_BAG', TRUE),
            'nm_bag' => $this->input->post('NM_BAG', TRUE),
            'kd_grup' => $this->input->post('KD_GRUP', TRUE),
            'nm_grup' => $this->input->post('NM_GRUP', TRUE),
            'dr' => $this->input->post('DR', TRUE),
            'notes' => $this->input->post('NOTES', TRUE),
            'tharian' => str_replace(',', '', $this->input->post('THARIAN', TRUE)),
            't_hr' => str_replace(',', '', $this->input->post('T_HR', TRUE)),
            'tjam1thl' => str_replace(',', '', $this->input->post('TJAM1THL', TRUE)),
            'tjam2thl' => str_replace(',', '', $this->input->post('TJAM2THL', TRUE)),
            'tjam1rpthl' => str_replace(',', '', $this->input->post('TJAM1RPTHL', TRUE)),
            'tjam2rpthl' => str_replace(',', '', $this->input->post('TJAM2RPTHL', TRUE)),
            'tjam1' => str_replace(',', '', $this->input->post('TJAM1', TRUE)),
            'tjam2' => str_replace(',', '', $this->input->post('TJAM2', TRUE)),
            'tjam1rp' => str_replace(',', '', $this->input->post('TJAM1RP', TRUE)),
            'tjam2rp' => str_replace(',', '', $this->input->post('TJAM2RP', TRUE)),
            'tlain' => str_replace(',', '', $this->input->post('TLAIN', TRUE)),
            't_tperbulan' => str_replace(',', '', $this->input->post('T_TPERBULAN', TRUE)),
            'tjumlah' => str_replace(',', '', $this->input->post('TJUMLAH', TRUE)),
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
                hrd_absen.kd_grup AS KD_GRUP,
                hrd_absen.nm_grup AS NM_GRUP,
                hrd_absen.dr AS DR,
                hrd_absen.notes AS NOTES,
                hrd_absen.tharian AS THARIAN,
                hrd_absen.t_hr AS T_HR,
                hrd_absen.tjam1thl AS TJAM1THL,
                hrd_absen.tjam2thl AS TJAM2THL,
                hrd_absen.tjam1rpthl AS TJAM1RPTHL,
                hrd_absen.tjam2rpthl AS TJAM2RPTHL,
                hrd_absen.tjam1 AS TJAM1,
                hrd_absen.tjam2 AS TJAM2,
                hrd_absen.tjam1rp AS TJAM1RP,
                hrd_absen.tjam2rp AS TJAM2RP,
                hrd_absen.tlain AS TLAIN,
                hrd_absen.t_tperbulan AS T_TPERBULAN,
                hrd_absen.tjumlah AS TJUMLAH,

                hrd_absend.no_id AS NO_ID,
                hrd_absend.rec AS REC,
                hrd_absend.kd_peg AS KD_PEG,
                hrd_absend.gaji AS GAJI,
                hrd_absend.nett AS NETT,
                hrd_absend.harian AS HARIAN,
                hrd_absend.nm_peg AS NM_PEG,
                hrd_absend.ptkp AS PTKP,
                hrd_absend.hr AS HR,
                hrd_absend.jam1thl AS JAM1THL,
                hrd_absend.jam2thl AS JAM2THL,
                hrd_absend.jam1rpthl AS JAM1RPTHL,
                hrd_absend.jam2rpthl AS JAM2RPTHL,
                hrd_absend.jam1 AS JAM1,
                hrd_absend.jam2 AS JAM2,
                hrd_absend.jam1rp AS JAM1RP,
                hrd_absend.jam2rp AS JAM2RP,
                hrd_absend.lain AS LAIN,
                hrd_absend.pot AS POT,
                hrd_absend.tperbulan AS TPERBULAN,
                hrd_absend.jumlah AS JUMLAH
            FROM hrd_absen,hrd_absend 
            WHERE hrd_absen.no_id=$id 
            AND hrd_absen.no_id=hrd_absend.id 
            ORDER BY hrd_absend.rec";
        $data = $this->transaksi_model->edit_data($q1)->result();
        $NO_ID = $this->input->post('NO_ID');
        $REC = $this->input->post('REC');
        $KD_PEG = $this->input->post('KD_PEG');
        $PL = str_replace(',', '', $this->input->post('PL', TRUE));
        $GAJI = str_replace(',', '', $this->input->post('GAJI', TRUE));
        $NETT = str_replace(',', '', $this->input->post('NETT', TRUE));
        $PL_HR = str_replace(',', '', $this->input->post('PL_HR', TRUE));
        $HARIAN = str_replace(',', '', $this->input->post('HARIAN', TRUE));
        $NM_PEG = $this->input->post('NM_PEG');
        $PTKP = $this->input->post('PTKP');
        $HR = str_replace(',', '', $this->input->post('HR', TRUE));
        $JAM1THL = str_replace(',', '', $this->input->post('JAM1THL', TRUE));
        $JAM2THL = str_replace(',', '', $this->input->post('JAM2THL', TRUE));
        $JAM1RPTHL = str_replace(',', '', $this->input->post('JAM1RPTHL', TRUE));
        $JAM2RPTHL = str_replace(',', '', $this->input->post('JAM2RPTHL', TRUE));
        $JAM1 = str_replace(',', '', $this->input->post('JAM1', TRUE));
        $JAM2 = str_replace(',', '', $this->input->post('JAM2', TRUE));
        $JAM1RP = str_replace(',', '', $this->input->post('JAM1RP', TRUE));
        $JAM2RP = str_replace(',', '', $this->input->post('JAM2RP', TRUE));
        $LAIN = str_replace(',', '', $this->input->post('LAIN', TRUE));
        $POT = str_replace(',', '', $this->input->post('POT', TRUE));
        $TPERBULAN = str_replace(',', '', $this->input->post('TPERBULAN', TRUE));
        $JUMLAH = str_replace(',', '', $this->input->post('JUMLAH', TRUE));
        $jum = count($data);
        $ID = array_column($data, 'NO_ID');
        $jumy = count($NO_ID);
        $i = 0;
        while ($i < $jum) {
            if (in_array($ID[$i], $NO_ID)) {
                $URUT = array_search($ID[$i], $NO_ID);
                $datad = array(
                    'flag' => 'HR',
                    'no_bukti' => $this->input->post('NO_BUKTI'),
                    'kd_bag' => $this->input->post('KD_BAG'),
                    'nm_bag' => $this->input->post('NM_BAG'),
                    'kd_grup' => $this->input->post('KD_GRUP'),
                    'nm_grup' => $this->input->post('NM_GRUP'),
                    'dr' => $this->input->post('DR'),
                    'rec' => $REC[$URUT],
                    'kd_peg' => $KD_PEG[$URUT],
                    'gaji' => str_replace(',', '', $GAJI[$URUT]),
                    'nett' => str_replace(',', '', $NETT[$URUT]),
                    'harian' => str_replace(',', '', $HARIAN[$URUT]),
                    'nm_peg' => $NM_PEG[$URUT],
                    'ptkp' => $PTKP[$URUT],
                    'hr' => str_replace(',', '', $HR[$URUT]),
                    'jam1thl' => str_replace(',', '', $JAM1THL[$URUT]),
                    'jam2thl' => str_replace(',', '', $JAM2THL[$URUT]),
                    'jam1rpthl' => str_replace(',', '', $JAM1RPTHL[$URUT]),
                    'jam2rpthl' => str_replace(',', '', $JAM2RPTHL[$URUT]),
                    'jam1' => str_replace(',', '', $JAM1[$URUT]),
                    'jam2' => str_replace(',', '', $JAM2[$URUT]),
                    'jam1rp' => str_replace(',', '', $JAM1RP[$URUT]),
                    'jam2rp' => str_replace(',', '', $JAM2RP[$URUT]),
                    'lain' => str_replace(',', '', $LAIN[$URUT]),
                    'pot' => str_replace(',', '', $POT[$URUT]),
                    'tperbulan' => str_replace(',', '', $TPERBULAN[$URUT]),
                    'jumlah' => str_replace(',', '', $JUMLAH[$URUT]),
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
                    'flag' => 'HR',
                    'id' => $this->input->post('ID', TRUE),
                    'no_bukti' => $this->input->post('NO_BUKTI'),
                    'kd_bag' => $this->input->post('KD_BAG'),
                    'nm_bag' => $this->input->post('NM_BAG'),
                    'kd_grup' => $this->input->post('KD_GRUP'),
                    'nm_grup' => $this->input->post('NM_GRUP'),
                    'dr' => $this->input->post('DR'),
                    'rec' => $REC[$i],
                    'kd_peg' => $KD_PEG[$i],
                    'gaji' => str_replace(',', '', $GAJI[$i]),
                    'nett' => str_replace(',', '', $NETT[$i]),
                    'harian' => str_replace(',', '', $HARIAN[$i]),
                    'nm_peg' => $NM_PEG[$i],
                    'ptkp' => $PTKP[$i],
                    'hr' => str_replace(',', '', $HR[$i]),
                    'jam1thl' => str_replace(',', '', $JAM1THL[$i]),
                    'jam2thl' => str_replace(',', '', $JAM2THL[$i]),
                    'jam1rpthl' => str_replace(',', '', $JAM1RPTHL[$i]),
                    'jam2rpthl' => str_replace(',', '', $JAM2RPTHL[$i]),
                    'jam1' => str_replace(',', '', $JAM1[$i]),
                    'jam2' => str_replace(',', '', $JAM2[$i]),
                    'jam1rp' => str_replace(',', '', $JAM1RP[$i]),
                    'jam2rp' => str_replace(',', '', $JAM2RP[$i]),
                    'lain' => str_replace(',', '', $LAIN[$i]),
                    'pot' => str_replace(',', '', $POT[$i]),
                    'tperbulan' => str_replace(',', '', $TPERBULAN[$i]),
                    'jumlah' => str_replace(',', '', $JUMLAH[$i]),
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
            '<div class="alert alert-success alert-dismissible fade show" role="alert"> Bukti ' . $this->input->post('NO_MANUAL') . $this->input->post('NO_BUKTI') . ' Berhasil Di Update.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Transaksi_Harian/index_Transaksi_Harian');
    }

    public function delete($id)
    {
        $where = array('no_id' => $id);
        $this->transaksi_model->hapus_data($where, 'hrd_absen');
        $where = array('id' => $id);
        $this->transaksi_model->hapus_data($where, 'hrd_absend');
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                Data succesfully Deleted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Transaksi_Harian/index_Transaksi_Harian');
    }

    function delete_multiple()
    {
        $this->transaksi_model->remove_checked('hrd_absen', 'hrd_absend');
        redirect('admin/Transaksi_Harian/index_Transaksi_Harian');
    }

    function filter_kd_bag()
    {
        $kd_bag = $this->input->get('kd_bag');
        $q1 = "SELECT kd_peg AS KD_PEG, 
                nm_peg AS NM_PEG, 
                ptkp AS PTKP, 
                hari AS HR, 
                ROUND(tperbulan, 0) AS TPERBULAN, 
                ROUND(gaji, 0) AS GAJI,
                ROUND(nett, 0) AS NETT
            FROM hrd_peg WHERE kd_bag='$kd_bag' AND aktif='1'";
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
        $results = $this->db->query("SELECT no_id, nm_peg, kd_peg, ptkp, gaji, nett, tperbulan
            FROM hrd_peg
            WHERE nm_peg LIKE '%$search%' OR kd_peg LIKE '%$search%' OR ptkp LIKE '%$search%' OR nett LIKE '%$search%' OR tperbulan LIKE '%$search%' 
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
                'gaji' => $row['gaji'],
                'tperbulan' => $row['tperbulan'],
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
        $PHPJasperXML->load_xml_file("phpjasperxml/Transaksi_Harian.jrxml");
        $per = $this->session->userdata['periode'];
        $query = "SELECT hrd_absen.no_id as ID,
                hrd_absen.no_bukti AS NO_BUKTI,
                hrd_absen.nm_bag AS NM_BAG,
                hrd_absen.per AS PER,
                CONCAT(hrd_absen.kd_grup,' - ',hrd_absen.nm_grup) AS GRUP,
                hrd_absen.t_hr AS T_HR,
                hrd_absen.tharian AS THARIAN,
                hrd_absen.tjam1rp AS TJAM1RP,
                hrd_absen.tjam2rp AS TJAM2RP,
                hrd_absen.tlain AS TLAIN,
                hrd_absen.tjumlah AS TJUMLAH,

                (SELECT SUM(hrd_lemd.ulembur)
					FROM hrd_absen, hrd_absend, hrd_lemd
					WHERE hrd_absen.no_id='$id'
					AND hrd_peg.kd_peg=hrd_absend.kd_peg
					AND hrd_absen.no_id=hrd_absend.id
					AND hrd_lemd.kd_peg=hrd_absend.kd_peg
					AND hrd_lemd.kd_bag=hrd_absen.kd_bag
					AND hrd_lemd.per='$per'
                ) AS TUNJANGAN,
                hrd_absend.no_id AS NO_ID,
                hrd_absend.rec AS REC,
                hrd_absend.nm_peg AS NM_PEG,
                hrd_absend.hr AS HR,
                hrd_absend.harian AS HARIAN,
                hrd_peg.lbl AS LBL,
                hrd_absend.jam1rp AS JAM1RP,
                hrd_absend.jam2rp AS JAM2RP,
                hrd_peg.tastek AS TASTEK,
                '0' AS LIBUR,
                '0' AS DP,
                '0' AS TAMBAHAN,
                hrd_absend.lain AS LAIN,
                hrd_absend.jumlah AS JUMLAH
            FROM hrd_absen,hrd_absend,hrd_peg
            WHERE hrd_absen.no_id='$id'
            AND hrd_peg.kd_peg=hrd_absend.kd_peg
            AND hrd_absen.no_id=hrd_absend.id
			GROUP BY hrd_absend.kd_peg
            ORDER BY hrd_absend.rec";
        $PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
        $PHPJasperXML->arraysqltable = array();
        $result1 = mysqli_query($conn, $query);
        while ($row1 = mysqli_fetch_assoc($result1)) {
            array_push($PHPJasperXML->arraysqltable, array(
                "NO_BUKTI" => $row1["NO_BUKTI"],
                "NM_BAG" => $row1["NM_BAG"],
                "PER" => $row1["PER"],
                "GRUP" => $row1["GRUP"],
                "T_HR" => $row1["T_HR"],
                "THARIAN" => $row1["THARIAN"],
                "TJAM1RP" => $row1["TJAM1RP"],
                "TJAM2RP" => $row1["TJAM2RP"],
                "TLAIN" => $row1["TLAIN"],
                "TJUMLAH" => $row1["TJUMLAH"],
                "REC" => $row1["REC"],
                "NM_PEG" => $row1["NM_PEG"],
                "HR" => $row1["HR"],
                "HARIAN" => $row1["HARIAN"],
                "LBL" => $row1["LBL"],
                "TASTEK" => $row1["TASTEK"],
                "LIBUR" => $row1["LIBUR"],
                "DP" => $row1["DP"],
                "TUNJANGAN" => $row1["TUNJANGAN"],
                "TAMBAHAN" => $row1["TAMBAHAN"],
                "JAM1RP" => $row1["JAM1RP"],
                "JAM2RP" => $row1["JAM2RP"],
                "LAIN" => $row1["LAIN"],
                "JUMLAH" => $row1["JUMLAH"],
            ));
        }
        ob_end_clean();
        $PHPJasperXML->outpage("I");
    }
}
