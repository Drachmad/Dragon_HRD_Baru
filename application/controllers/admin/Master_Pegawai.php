<?php


class Master_Pegawai extends CI_Controller
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
        if ($this->session->userdata['menu_hrd'] != 'hrd_peg') {
            $this->session->set_userdata('menu_hrd', 'hrd_peg');
            $this->session->set_userdata('kode_menu', 'M0001');
            $this->session->set_userdata('keyword_hrd_peg', '');
            $this->session->set_userdata('order_hrd_peg', 'no_id');
        }
    }
    var $column_order = array(null, null, null, 'kd_peg', 'nm_peg', 'nm_bag', 'aktif', 'dr', 'pt');
    var $column_search = array('kd_peg', 'nm_peg', 'nm_bag', 'aktif', 'dr', 'pt');
    var $order = array('no_id' => 'asc');

    private function _get_datatables_query()
    {
        $dr = $this->session->userdata['dr'];
        $pt = $this->session->userdata['pt'];
        $cv = $this->session->userdata['cv'];
        if ($dr == 'I') {
            $where = array(
                'dr' => $dr,
            );
        } else {
            $where = array(
                'dr' => $dr,
                'pt' => $pt,
                'cv' => $cv,
            );
        }
        $this->db->select('*');
        $this->db->from('hrd_peg');
        $this->db->where($where);
        $this->db->order_by("pt desc, kd_peg asc");
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
        $pt = $this->session->userdata['pt'];
        $cv = $this->session->userdata['cv'];
        if ($dr == 'I') {
            $where = array(
                'dr' => $dr,
            );
        } else {
            $where = array(
                'dr' => $dr,
                'pt' => $pt,
                'cv' => $cv,
            );
        }
        $this->db->select('*');
        $this->db->from('hrd_peg');
        $this->db->where($where);
        $this->db->order_by("pt desc, kd_peg asc");
        return $this->db->count_all_results();
    }

    function get_ajax_hrd_peg()
    {
        $list = $this->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        $dr = $this->session->userdata['dr'];
        foreach ($list as $hrd_peg) {
            $no++;
            $row = array();
            $row[] = "<input type='checkbox' class='singlechkbox' name='check[]' value='" . $hrd_peg->no_id . "'>";
            if ($dr === 'SUPER_ADMIN') {
                $row[] = '<div class="dropdown">
                            <a style="background-color: #9c774c;" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-bars icon" style="font-size: 13px;"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="' . site_url('admin/Master_Pegawai/update/' . $hrd_peg->no_id) . '"> <i class="fa fa-edit"></i> Edit</a>
                                <a class="dropdown-item" href="' . site_url('admin/Master_Pegawai/delete/' . $hrd_peg->no_id) . '"  onclick="return confirm(&quot; Apakah Anda Yakin Ingin Menghapus? &quot;)"><i class="fa fa-trash"></i> Delete</a>
                            </div>
                        </div>';
            } else {
                $row[] = '<div class="dropdown">
                        <a style="background-color: #9c774c;" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bars icon" style="font-size: 13px;"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="' . site_url('admin/Master_Pegawai/update/' . $hrd_peg->no_id) . '"> <i class="fa fa-edit"></i> Edit</a>
                            <a hidden class="dropdown-item" href="' . site_url('admin/Master_Pegawai/delete/' . $hrd_peg->no_id) . '"  onclick="return confirm(&quot; Apakah Anda Yakin Ingin Menghapus? &quot;)"><i class="fa fa-trash"></i> Delete</a>
                        </div>
                    </div>';
            }
            $row[] = $no . ".";
            $row[] = $hrd_peg->kd_peg;
            $row[] = $hrd_peg->nm_peg;
            $row[] = $hrd_peg->nm_bag;
            $row[] = ($hrd_peg->aktif == 1) ? "AKTIF" : "TIDAK AKTIF";
            $row[] = $hrd_peg->dr;
            $row[] = ($hrd_peg->pt == 1) ? "PT" : "CV";
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

    public function index_Master_Pegawai()
    {
        $data['hrd_peg'] = $this->master_model->tampil_data('hrd_peg', 'no_id')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Master_Pegawai/Master_Pegawai', $data);
        $this->load->view('templates_admin/footer');
    }

    public function getOrder()
    {
        $data['orderBy'] = $this->input->get('order');
        $this->session->set_userdata('order_hrd_peg', $data['orderBy']);
    }

    public function input()
    {
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Master_Pegawai/Master_Pegawai_form');
        $this->load->view('templates_admin/footer');
    }

    public function input_aksi()
    {
        $kd_bag = $this->input->post('KD_BAG', TRUE);
        $rec = 'SELECT (MAX(REC)+1) as REC from hrd_peg where KD_BAG="' . $kd_bag . '" ';
        $get_rec = $this->db->query($rec)->result();
        $nm_peg = $this->input->post('NM_PEG', TRUE);
        $insial = substr($nm_peg, 0, 1);
        if ($this->session->userdata['dr'] == 'I') {
            $INISIALDR = 'DR1';
        } else if ($this->session->userdata['dr'] == 'II') {
            $INISIALDR = 'DR2';
        } else if ($this->session->userdata['dr'] == 'III') {
            $INISIALDR = 'DR3';
        } else if ($this->session->userdata['dr'] == 'IV') {
            $INISIALDR = 'DR4';
        } else if ($this->session->userdata['dr'] == 'PY') {
            $INISIALDR = 'PY';
        } else if ($this->session->userdata['dr'] == 'AB') {
            $INISIALDR = 'AB';
        } else if ($this->session->userdata['dr'] == 'BLA') {
            $INISIALDR = 'BLA';
        }
        $kd_peg = $INISIALDR . '.' . $insial . '.' . str_pad($get_rec[0]->REC, 5, "0", STR_PAD_LEFT);

        if ($this->session->userdata['dr'] == 'I') {
            $pt = $this->input->post('PT', TRUE);
        } else {
            $pt = $this->session->userdata['pt'];
        }

        $data = array(
            'nik' => $this->input->post('NIK', TRUE),
            'nm_peg' => $this->input->post('NM_PEG', TRUE),
            'kd_peg' => $kd_peg,
            'kd_bag' => $this->input->post('KD_BAG', TRUE),
            'nm_bag' => $this->input->post('NM_BAG', TRUE),
            'aktif' => $this->input->post('AKTIF', TRUE),
            'jk' => $this->input->post('JK', TRUE),
            'kpj' => $this->input->post('KPJ', TRUE),
            'bpjs' => $this->input->post('BPJS', TRUE),
            'alamat' => $this->input->post('ALAMAT', TRUE),
            'kota' => $this->input->post('KOTA', TRUE),
            'kab' => $this->input->post('KAB', TRUE),
            'pendidikan' => $this->input->post('PENDIDIKAN', TRUE),
            'rec' => $get_rec[0]->REC,
            // 'agama' => $this->input->post('AGAMA',TRUE),
            'tgl_masuk' => date("Y-m-d", strtotime($this->input->post('TGL_MASUK', TRUE))),
            'pokok' => str_replace(',', '', $this->input->post('POKOK', TRUE)),
            'umakan' => str_replace(',', '', $this->input->post('UMAKAN', TRUE)),
            'tjabatan' => str_replace(',', '', $this->input->post('TJABATAN', TRUE)),
            'tperbulan' => str_replace(',', '', $this->input->post('TPERBULAN', TRUE)),
            'tastek' => str_replace(',', '', $this->input->post('TASTEK', TRUE)),
            'premi' => str_replace(',', '', $this->input->post('PREMI', TRUE)),
            'lbl' => str_replace(',', '', $this->input->post('LBL', TRUE)),
            'ulembur' => str_replace(',', '', $this->input->post('ULEMBUR', TRUE)),
            'gaji' => str_replace(',', '', $this->input->post('GAJI', TRUE)),
            'nett' => str_replace(',', '', $this->input->post('NETT', TRUE)),
            // 'kd_bag_2' => $this->input->post('KD_BAG_2',TRUE),
            'no_rek' => $this->input->post('NO_REK', TRUE),
            'status_pegawai' => $this->input->post('STATUS_PEGAWAI', TRUE),
            'ptkp' => $this->input->post('PTKP', TRUE),
            'stat' => $this->input->post('STAT', TRUE),
            'email' => $this->input->post('EMAIL', TRUE),
            'hp' => $this->input->post('HP', TRUE),
            'pt' => $pt,
            'tgl_keluar' => date("Y-m-d", strtotime($this->input->post('TGL_KELUAR', TRUE))),
            'tgl_lahir' => date("Y-m-d", strtotime($this->input->post('TGL_LAHIR', TRUE))),
            // 'nm_bag_2' => $this->input->post('NM_BAG_2',TRUE),
            // 'kd_bag_3' => $this->input->post('KD_BAG_3',TRUE),
            // 'nm_bag_3' => $this->input->post('NM_BAG_3',TRUE),
            // 'kd_bag_4' => $this->input->post('KD_BAG_4',TRUE),
            // 'nm_bag_4' => $this->input->post('NM_BAG_4',TRUE),
            'dr' => $this->session->userdata['dr'],
            'usrnm' => $this->session->userdata['username'],
            'i_tgl' => date('Y-m-d H:i:s'),
        );
        $this->master_model->input_data('hrd_peg', $data);
        $datad = array(
            'nm_peg' => $this->input->post('NM_PEG', TRUE),
            'kd_peg' => $kd_peg,
            'yer' => substr($this->session->userdata['periode'], -4),
        );
        $this->master_model->input_data('pegd', $datad);
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-dismissible fade show" role="alert"> 
                Data succesfully Inserted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Master_Pegawai/index_Master_Pegawai');
    }

    public function update($no_id)
    {
        $where = array('no_id' => $no_id);
        $ambildata = $this->master_model->edit_data($where, 'hrd_peg');
        $r = $ambildata->row_array();
        $data = [
            'NO_ID' => $r['no_id'],
            'NIK' => $r['nik'],
            'NM_PEG' => $r['nm_peg'],
            'KD_BAG' => $r['kd_bag'],
            'NM_BAG' => $r['nm_bag'],
            'AKTIF' => $r['aktif'],
            'JK' => $r['jk'],
            'KPJ' => $r['kpj'],
            'BPJS' => $r['bpjs'],
            'ALAMAT' => $r['alamat'],
            'KOTA' => $r['kota'],
            'KAB' => $r['kab'],
            'PENDIDIKAN' => $r['pendidikan'],
            // 'AGAMA' => $r['agama'],
            'REC' => $r['rec'],
            'TGL_MASUK' => $r['tgl_masuk'],
            'POKOK' => $r['pokok'],
            'UMAKAN' => $r['umakan'],
            'TJABATAN' => $r['tjabatan'],
            'TPERBULAN' => $r['tperbulan'],
            'TASTEK' => $r['tastek'],
            'PREMI' => $r['premi'],
            'LBL' => $r['lbl'],
            'ULEMBUR' => $r['ulembur'],
            'GAJI' => $r['gaji'],
            'NETT' => $r['nett'],
            // 'KD_BAG_2' => $r['kd_bag_2'],
            'NO_REK' => $r['no_rek'],
            'STATUS_PEGAWAI' => $r['status_pegawai'],
            'PTKP' => $r['ptkp'],
            'STAT' => $r['stat'],
            'EMAIL' => $r['email'],
            'HP' => $r['hp'],
            // 'PT' => $r['pt'],
            'TGL_KELUAR' => $r['tgl_keluar'],
            'TGL_LAHIR' => $r['tgl_lahir'],
            // 'NM_BAG_2' => $r['nm_bag_2'],
            // 'KD_BAG_3' => $r['kd_bag_3'],
            // 'NM_BAG_3' => $r['nm_bag_3'],
            // 'KD_BAG_4' => $r['kd_bag_4'],
            // 'NM_BAG_4' => $r['nm_bag_4'],
            'DR' => $r['dr'],
        ];
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Master_Pegawai/Master_Pegawai_update', $data);
        $this->load->view('templates_admin/footer');
    }

    public function update_aksi()
    {
        $no_id = $this->input->post('NO_ID');
        $data = array(
            'no_id' => $this->input->post('NO_ID', TRUE),
            'nik' => $this->input->post('NIK', TRUE),
            'nm_peg' => $this->input->post('NM_PEG', TRUE),
            'kd_bag' => $this->input->post('KD_BAG', TRUE),
            'nm_bag' => $this->input->post('NM_BAG', TRUE),
            'aktif' => $this->input->post('AKTIF', TRUE),
            'jk' => $this->input->post('JK', TRUE),
            'kpj' => $this->input->post('KPJ', TRUE),
            'bpjs' => $this->input->post('BPJS', TRUE),
            'alamat' => $this->input->post('ALAMAT', TRUE),
            'kota' => $this->input->post('KOTA', TRUE),
            'kab' => $this->input->post('KAB', TRUE),
            'pendidikan' => $this->input->post('PENDIDIKAN', TRUE),
            // 'agama' => $this->input->post('AGAMA',TRUE),
            'tgl_masuk' => date("Y-m-d", strtotime($this->input->post('TGL_MASUK', TRUE))),
            'rec' => str_replace(',', '', $this->input->post('REC', TRUE)),
            'pokok' => str_replace(',', '', $this->input->post('POKOK', TRUE)),
            'umakan' => str_replace(',', '', $this->input->post('UMAKAN', TRUE)),
            'tjabatan' => str_replace(',', '', $this->input->post('TJABATAN', TRUE)),
            'tperbulan' => str_replace(',', '', $this->input->post('TPERBULAN', TRUE)),
            'tastek' => str_replace(',', '', $this->input->post('TASTEK', TRUE)),
            'premi' => str_replace(',', '', $this->input->post('PREMI', TRUE)),
            'lbl' => str_replace(',', '', $this->input->post('LBL', TRUE)),
            'ulembur' => str_replace(',', '', $this->input->post('ULEMBUR', TRUE)),
            'gaji' => str_replace(',', '', $this->input->post('GAJI', TRUE)),
            'nett' => str_replace(',', '', $this->input->post('NETT', TRUE)),
            // 'kd_bag_2' => $this->input->post('KD_BAG_2',TRUE),
            'no_rek' => $this->input->post('NO_REK', TRUE),
            'status_pegawai' => $this->input->post('STATUS_PEGAWAI', TRUE),
            'ptkp' => $this->input->post('PTKP', TRUE),
            'stat' => $this->input->post('STAT', TRUE),
            'email' => $this->input->post('EMAIL', TRUE),
            'hp' => $this->input->post('HP', TRUE),
            'pt' => $this->session->userdata['pt'],
            'tgl_keluar' => date("Y-m-d", strtotime($this->input->post('TGL_KELUAR', TRUE))),
            'tgl_lahir' => date("Y-m-d", strtotime($this->input->post('TGL_LAHIR', TRUE))),
            // 'nm_bag_2' => $this->input->post('NM_BAG_2',TRUE),
            // 'kd_bag_3' => $this->input->post('KD_BAG_3',TRUE),
            // 'nm_bag_3' => $this->input->post('NM_BAG_3',TRUE),
            // 'kd_bag_4' => $this->input->post('KD_BAG_4',TRUE),
            // 'nm_bag_4' => $this->input->post('NM_BAG_4',TRUE),
            'dr' => $this->session->userdata['dr'],
            'e_pc' => $this->session->userdata['username'],
            'e_tgl' => date('Y-m-d H:i:s'),
        );
        $where = array(
            'no_id' => $no_id
        );
        $this->master_model->update_data($where, $data, 'hrd_peg');
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-dismissible fade show" role="alert"> 
                Data succesfully Updated.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Master_Pegawai/index_Master_Pegawai');
    }

    public function delete($no_id)
    {
        $where = array('no_id' => $no_id);
        $this->master_model->hapus_data($where, 'hrd_peg');
        $whered = array('no_id' => $no_id);
        $this->master_model->hapus_data($whered, 'pegd');
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-dismissible fade show" role="alert"> 
                Data succesfully Deleted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Master_Pegawai/index_Master_Pegawai');
    }

    function delete_multiple()
    {
        $this->master_model->remove_checked('hrd_peg');
        redirect('admin/Master_Pegawai/index_Master_Pegawai');
    }

    public function getDataAjax_Bagian()
    {
        $dr = $this->session->userdata['dr'];
        $search = $this->input->post('search');
        $page = ((int)$this->input->post('page'));
        if ($page == 0) {
            $xa = 0;
        } else {
            $xa = ($page - 1) * 10;
        }
        $perPage = 10;
        $results = $this->db->query("SELECT no_id, kd_bag, nm_bag 
            FROM hrd_bag
            WHERE dr='$dr' AND (kd_bag LIKE '%$search%' OR nm_bag LIKE '%$search%')
            ORDER BY kd_bag LIMIT $xa,$perPage");
        $selectajax = array();
        foreach ($results->RESULT_ARRAY() as $row) {
            $selectajax[] = array(
                'id' => $row['kd_bag'],
                'text' => $row['kd_bag'],
                'kd_bag' => $row['kd_bag'] . " - " . $row['nm_bag'],
                'nm_bag' => $row['nm_bag'],
            );
        }
        $select['total_count'] =  $results->NUM_ROWS();
        $select['items'] = $selectajax;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    function JASPER()
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
        include('phpjasperxml/class/tcpdf/tcpdf.php');
        include('phpjasperxml/class/PHPJasperXML.inc.php');
        include('phpjasperxml/setting.php');
        $PHPJasperXML = new \PHPJasperXML();
        $PHPJasperXML->load_xml_file("phpjasperxml/account.jrxml");
        $PHPJasperXML->transferDBtoArray($servername, $username, $password, $database);
        $PHPJasperXML->arraysqltable = array();
        $query = "SELECT account.no_id,
                account.acno,
                account.nama,
                account.nama_kel,
                account.nm_grup
                FROM account 
                ORDER BY account.acno ";
        $result1 = mysqli_query($conn, $query);
        $x = 1;
        while ($row1 = mysqli_fetch_assoc($result1)) {
            array_push($PHPJasperXML->arraysqltable, array(
                "no_id" => $x,
                "ACNO" => $row1["acno"],
                "nama" => $row1["nama"],
                "nama_kel" => $row1["nama_kel"],
                "nm_grup" => $row1["nm_grup"]
            ));
            $x++;
        }
        ob_end_clean();
        $PHPJasperXML->outpage("I");
    }
}
