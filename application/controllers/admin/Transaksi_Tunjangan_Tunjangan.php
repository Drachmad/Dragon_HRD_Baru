<?php

class Transaksi_Tunjangan_Tunjangan extends CI_Controller
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
        if ($this->session->userdata['menu_hrd'] != 'hrd_tunjang') {
            $this->session->set_userdata('menu_hrd', 'hrd_tunjang');
            $this->session->set_userdata('kode_menu', 'ST0022');
            $this->session->set_userdata('keyword_hrd_tunjang', '');
            $this->session->set_userdata('order_hrd_tunjang', 'no_id');
        }
    }

    var $column_order = array(null, null, null, 'no_bukti', 'kd_bag', 'nm_bag', 'notes', 'tgl', 'dr');
    var $column_search = array('no_bukti', 'kd_bag', 'nm_bag', 'notes', 'tgl', 'dr');
    var $order = array('no_bukti' => 'asc');

    private function _get_datatables_query()
    {
        $dr = $this->session->userdata['dr'];
        $per = $this->session->userdata['periode'];
        $where = array(
            'dr' => $dr,
            'per' => $per,
            'flag' => 'TJ'
        );
        $this->db->select('*');
        $this->db->from('hrd_tunjang');
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
            'flag' => 'TJ'
        );
        $this->db->from('hrd_tunjang');
        $this->db->where($where);
        return $this->db->count_all_results();
    }

    function get_ajax_hrd_tunjang()
    {
        $list = $this->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $hrd_tunjang) {
            $JASPER = "window.open('JASPER/" . $hrd_tunjang->no_id . "','', 'width=1000','height=900');";
            $no++;
            $row = array();
            $row[] = "<input type='checkbox' class='singlechkbox' name='check[]' value='" . $hrd_tunjang->no_id . "'>";
            $row[] = '<div class="dropdown">
                        <a style="background-color: #9c774c;" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bars icon" style="font-size: 13px;"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_Tunjangan_Tunjangan/update/' . $hrd_tunjang->no_id) . '"> <i class="fa fa-edit"></i> Edit</a>
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_Tunjangan_Tunjangan/delete/' . $hrd_tunjang->no_id) . '" onclick="return confirm(&quot; Apakah Anda Yakin Ingin Menghapus? &quot;)"><i class="fa fa-trash"></i> Delete</a>
                            <a name="no_id" class="dropdown-item" href="#" onclick="' . $JASPER . '");"><i class="fa fa-print"></i> Print</a>
                        </div>
                    </div>';
            $row[] = $no . ".";
            $row[] = $hrd_tunjang->no_bukti;
            $row[] = $hrd_tunjang->kd_bag;
            $row[] = $hrd_tunjang->nm_bag;
            $row[] = $hrd_tunjang->notes;
            $row[] = $hrd_tunjang->tgl;
            $row[] = $hrd_tunjang->dr;
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

    public function index_Transaksi_Tunjangan_Tunjangan()
    {
        $dr = $this->session->userdata['dr'];
        $per = $this->session->userdata['periode'];
        $this->session->set_userdata('judul', 'Transaksi Tunjangan');
        $where = array(
            'dr' => $dr,
            'per' => $per,
            'flag' => 'TJ'
        );
        $data['hrd_tunjang'] = $this->transaksi_model->tampil_data($where, 'hrd_tunjang', 'no_id')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_Tunjangan_Tunjangan/Transaksi_Tunjangan_Tunjangan', $data);
        $this->load->view('templates_admin/footer');
    }

    public function input()
    {
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_Tunjangan_Tunjangan/Transaksi_Tunjangan_Tunjangan_form');
        $this->load->view('templates_admin/footer');
    }

    public function input_aksi()
    {
        $flag = 'TJ';
        $dr = $this->session->userdata['dr'];
        $per = $this->session->userdata['periode'];
        $kd_bag = $this->input->post('KD_BAG', TRUE);
        $nm_bag = $this->input->post('NM_BAG', TRUE);
        $kd_grup = $this->input->post('KD_GRUP', TRUE);
        $nm_grup = $this->input->post('NM_GRUP', TRUE);
        $xx = $this->db->query("CALL NO_BUKTI_TUNJANGAN('TUNJANGAN_$flag','tunjangan','$flag','$per','$dr','$kd_bag')")->result();
        mysqli_next_result($this->db->conn_id);
        $bukti = $xx[0]->BUKTIX;
        $datah = array(
            'flag' => 'TJ',
            'no_bukti' => $bukti,
            'kd_bag' => $this->input->post('KD_BAG', TRUE),
            'nm_bag' => $this->input->post('NM_BAG', TRUE),
            'kd_grup' => $this->input->post('KD_GRUP', TRUE),
            'nm_grup' => $this->input->post('NM_GRUP', TRUE),
            'notes' => $this->input->post('NOTES', TRUE),
            'tgl' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
            't_tjabatan' => str_replace(',', '', $this->input->post('T_TJABATAN', TRUE)),
            'dr' => $this->session->userdata['dr'],
            'per' => $this->session->userdata['periode'],
            'usrnm' => $this->session->userdata['username'],
            'i_tgl' => date("Y-m-d h:i a")
        );
        $this->transaksi_model->input_datah('hrd_tunjang', $datah);
        $ID = $this->db->query("SELECT MAX(no_id) AS no_id FROM hrd_tunjang WHERE no_bukti = '$bukti' AND dr='$dr' AND per='$per' GROUP BY no_bukti")->result();
        $REC = $this->input->post('REC');
        $KD_PEG = $this->input->post('KD_PEG');
        $NM_PEG = $this->input->post('NM_PEG');
        $TJABATAN = str_replace(',', '', $this->input->post('TJABATAN', TRUE));
        $i = 0;
        foreach ($REC as $a) {
            $datad = array(
                'id' => $ID[0]->no_id,
                'no_bukti' => $bukti,
                'kd_bag' => $kd_bag,
                'nm_bag' => $nm_bag,
                'kd_grup' => $kd_grup,
                'nm_grup' => $nm_grup,
                'tgl' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
                'flag' => 'TJ',
                'rec' => $REC[$i],
                'kd_peg' => $KD_PEG[$i],
                'nm_peg' => $NM_PEG[$i],
                'tjabatan' => str_replace(',', '', $TJABATAN[$i]),
                'dr' => $this->session->userdata['dr'],
                'per' => $this->session->userdata['periode'],
                'usrnm' => $this->session->userdata['username'],
                'i_tgl' => date("Y-m-d h:i a")
            );
            $this->transaksi_model->input_datad('hrd_tunjangd', $datad);
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
        redirect('admin/Transaksi_Tunjangan_Tunjangan/index_Transaksi_Tunjangan_Tunjangan');
    }

    public function update($id)
    {
        $q1 = "SELECT hrd_tunjang.no_id as ID,
                hrd_tunjang.no_bukti AS NO_BUKTI,
                hrd_tunjang.kd_bag AS KD_BAG,
                hrd_tunjang.nm_bag AS NM_BAG,
                hrd_tunjang.kd_grup AS KD_GRUP,
                hrd_tunjang.nm_grup AS NM_GRUP,
                hrd_tunjang.notes AS NOTES,
                hrd_tunjang.tgl AS TGL,
                hrd_tunjang.t_tjabatan AS T_TJABATAN,

                hrd_tunjangd.no_id AS NO_ID,
                hrd_tunjangd.rec AS REC,
                hrd_tunjangd.kd_peg AS KD_PEG,
                hrd_tunjangd.nm_peg AS NM_PEG,
                hrd_tunjangd.tjabatan AS TJABATAN
            FROM hrd_tunjang,hrd_tunjangd 
            WHERE hrd_tunjang.no_id=$id 
            AND hrd_tunjang.no_id=hrd_tunjangd.id 
            ORDER BY hrd_tunjangd.rec";
        $data['tunjangan_tunjangan'] = $this->transaksi_model->edit_data($q1)->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_Tunjangan_Tunjangan/Transaksi_Tunjangan_Tunjangan_update', $data);
        $this->load->view('templates_admin/footer');
    }

    public function update_aksi()
    {
        $datah = array(
            'flag' => 'TJ',
            'no_bukti' => $this->input->post('NO_BUKTI', TRUE),
            'kd_bag' => $this->input->post('KD_BAG', TRUE),
            'nm_bag' => $this->input->post('NM_BAG', TRUE),
            'kd_grup' => $this->input->post('KD_GRUP', TRUE),
            'nm_grup' => $this->input->post('NM_GRUP', TRUE),
            'notes' => $this->input->post('NOTES', TRUE),
            'tgl' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
            't_tjabatan' => str_replace(',', '', $this->input->post('T_TJABATAN', TRUE)),
            'dr' => $this->session->userdata['dr'],
            'per' => $this->session->userdata['periode'],
            'e_pc' => $this->session->userdata['username'],
            'e_tgl' => date("Y-m-d h:i a")
        );
        $where = array(
            'no_id' => $this->input->post('ID', TRUE)
        );
        $this->transaksi_model->update_data($where, $datah, 'hrd_tunjang');
        $id = $this->input->post('ID', TRUE);
        $q1 = "SELECT hrd_tunjang.no_id as ID,
                hrd_tunjang.no_bukti AS NO_BUKTI,
                hrd_tunjang.kd_bag AS KD_BAG,
                hrd_tunjang.nm_bag AS NM_BAG,
                hrd_tunjang.kd_grup AS KD_GRUP,
                hrd_tunjang.nm_grup AS NM_GRUP,
                hrd_tunjang.notes AS NOTES,
                hrd_tunjang.tgl AS TGL,
                hrd_tunjang.t_tjabatan AS T_TJABATAN,

                hrd_tunjangd.no_id AS NO_ID,
                hrd_tunjangd.rec AS REC,
                hrd_tunjangd.kd_peg AS KD_PEG,
                hrd_tunjangd.nm_peg AS NM_PEG,
                hrd_tunjangd.tjabatan AS TJABATAN
            FROM hrd_tunjang,hrd_tunjangd 
            WHERE hrd_tunjang.no_id=$id 
            AND hrd_tunjang.no_id=hrd_tunjangd.id 
            ORDER BY hrd_tunjangd.rec";
        $data = $this->transaksi_model->edit_data($q1)->result();
        $NO_ID = $this->input->post('NO_ID');
        $REC = $this->input->post('REC');
        $KD_PEG = $this->input->post('KD_PEG');
        $NM_PEG = $this->input->post('NM_PEG');
        $TJABATAN = str_replace(',', '', $this->input->post('TJABATAN', TRUE));
        $jum = count($data);
        $ID = array_column($data, 'NO_ID');
        $jumy = count($NO_ID);
        $i = 0;
        while ($i < $jum) {
            if (in_array($ID[$i], $NO_ID)) {
                $URUT = array_search($ID[$i], $NO_ID);
                $datad = array(
                    'flag' => 'TJ',
                    'no_bukti' => $this->input->post('NO_BUKTI'),
                    'kd_bag' => $this->input->post('KD_BAG'),
                    'nm_bag' => $this->input->post('NM_BAG'),
                    'kd_grup' => $this->input->post('KD_GRUP'),
                    'nm_grup' => $this->input->post('NM_GRUP'),
                    'tgl' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
                    'rec' => $REC[$URUT],
                    'kd_peg' => $KD_PEG[$URUT],
                    'nm_peg' => $NM_PEG[$URUT],
                    'tjabatan' => str_replace(',', '', $TJABATAN[$URUT]),
                    'dr' => $this->session->userdata['dr'],
                    'per' => $this->session->userdata['periode'],
                    'e_pc' => $this->session->userdata['username'],
                    'e_tgl' => date("Y-m-d h:i a")
                );
                $where = array(
                    'no_id' => $NO_ID[$URUT]
                );
                $this->transaksi_model->update_data($where, $datad, 'hrd_tunjangd');
            } else {
                $where = array(
                    'no_id' => $ID[$i]
                );
                $this->transaksi_model->hapus_data($where, 'hrd_tunjangd');
            }
            $i++;
        }
        $i = 0;
        while ($i < $jumy) {
            if ($NO_ID[$i] == "0") {
                $datad = array(
                    'flag' => 'TJ',
                    'id' => $this->input->post('ID', TRUE),
                    'no_bukti' => $this->input->post('NO_BUKTI'),
                    'kd_bag' => $this->input->post('KD_BAG'),
                    'nm_bag' => $this->input->post('NM_BAG'),
                    'kd_grup' => $this->input->post('KD_GRUP'),
                    'nm_grup' => $this->input->post('NM_GRUP'),
                    'tgl' => date("Y-m-d", strtotime($this->input->post('TGL', TRUE))),
                    'rec' => $REC[$i],
                    'kd_peg' => $KD_PEG[$i],
                    'nm_peg' => $NM_PEG[$i],
                    'tjabatan' => str_replace(',', '', $TJABATAN[$i]),
                    'dr' => $this->session->userdata['dr'],
                    'per' => $this->session->userdata['periode'],
                    'e_pc' => $this->session->userdata['username'],
                    'e_tgl' => date("Y-m-d h:i a")
                );
                $this->transaksi_model->input_datad('hrd_tunjangd', $datad);
            }
            $i++;
        }
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-dismissible fade show" role="alert"> 
                Data Berhasil Di Update.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Transaksi_Tunjangan_Tunjangan/index_Transaksi_Tunjangan_Tunjangan');
    }

    public function delete($id)
    {
        $where = array('no_id' => $id);
        $this->transaksi_model->hapus_data($where, 'hrd_tunjang');
        $where = array('id' => $id);
        $this->transaksi_model->hapus_data($where, 'hrd_tunjangd');
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                Data succesfully Deleted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Transaksi_Tunjangan_Tunjangan/index_Transaksi_Tunjangan_Tunjangan');
    }

    function delete_multiple()
    {
        $this->transaksi_model->remove_checked('hrd_tunjang', 'hrd_tunjangd');
        redirect('admin/Transaksi_Tunjangan_Tunjangan/index_Transaksi_Tunjangan_Tunjangan');
    }

    function filter_kd_bag()
    {
        $kd_bag = $this->input->get('kd_bag');
        $pt = $this->session->userdata['pt'];
        $q1 = "SELECT kd_peg AS KD_PEG, 
                nm_peg AS NM_PEG
            FROM hrd_peg WHERE kd_bag='$kd_bag' AND aktif='1' AND pt='$pt' ORDER BY kd_peg ";
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
        $results = $this->db->query("SELECT no_id, nm_peg, kd_peg, tjabatan
            FROM hrd_peg
            WHERE nm_peg LIKE '%$search%' OR kd_peg LIKE '%$search%' OR tjabatan LIKE '%$search%'
            ORDER BY nm_peg LIMIT $xa,$perPage");
        $selectajax = array();
        foreach ($results->RESULT_ARRAY() as $row) {
            $selectajax[] = array(
                'id' => $row['nm_peg'],
                'text' => $row['nm_peg'],
                'nm_peg' => $row['nm_peg'] . " - " . $row['kd_peg'] . " - " . $row['tjabatan'],
                'kd_peg' => $row['kd_peg'],
                'tjabatan' => $row['tjabatan'],
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
        $PHPJasperXML->load_xml_file("phpjasperxml/Transaksi_Tunjangan_Tunjangan.jrxml");
        $no_id = $id;
        $query = "SELECT hrd_tunjang.no_id as ID,
                hrd_tunjang.no_bukti AS NO_BUKTI,
                hrd_tunjang.per AS PER,
                hrd_tunjang.tgl AS TGL,
                hrd_tunjang.t_tjabatan AS T_TJABATAN,

                hrd_tunjangd.no_id AS NO_ID,
                hrd_tunjangd.rec AS REC,
                CONCAT(hrd_tunjangd.nm_peg,' - ',hrd_tunjangd.kd_peg) AS PEGAWAI,
                hrd_tunjangd.tjabatan AS TJABATAN
            FROM hrd_tunjang,hrd_tunjangd 
            WHERE hrd_tunjang.no_id=$id 
            AND hrd_tunjang.no_id=hrd_tunjangd.id 
            ORDER BY hrd_tunjangd.rec";
        $PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
        $PHPJasperXML->arraysqltable = array();
        $result1 = mysqli_query($conn, $query);
        while ($row1 = mysqli_fetch_assoc($result1)) {
            array_push($PHPJasperXML->arraysqltable, array(
                "NO_BUKTI" => $row1["NO_BUKTI"],
                "PER" => $row1["PER"],
                "TGL" => $row1["TGL"],
                "T_JASA" => $row1["T_JASA"],
                "REC" => $row1["REC"],
                "PEGAWAI" => $row1["PEGAWAI"],
                "JASA" => $row1["JASA"],
            ));
        }
        ob_end_clean();
        $PHPJasperXML->outpage("I");
    }
}
