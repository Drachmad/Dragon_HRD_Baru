<?php


class Master_Bagian extends CI_Controller
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
        if ($this->session->userdata['menu_hrd'] != 'hrd_bag') {
            $this->session->set_userdata('menu_hrd', 'hrd_bag');
            $this->session->set_userdata('kode_menu', 'M0002');
            $this->session->set_userdata('keyword_hrd_bag', '');
            $this->session->set_userdata('order_hrd_bag', 'no_id');
        }
    }
    var $column_order = array(null, null, null, 'kd_bag', 'nm_bag', 'kd_grup', 'nm_grup', 'dr');
    var $column_search = array('kd_bag', 'nm_bag', 'kd_grup', 'nm_grup', 'dr');
    var $order = array('no_id' => 'asc');

    private function _get_datatables_query()
    {
        $dr = $this->session->userdata['dr'];
        $where = array(
            'dr' => $dr
        );
        $this->db->select('*');
        $this->db->from('hrd_bag');
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
        $where = array(
            'dr' => $dr
        );
        $this->db->from('hrd_bag');
        return $this->db->count_all_results();
    }

    function get_ajax_hrd_bag()
    {
        $list = $this->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        $dr = $this->session->userdata['dr'];
        foreach ($list as $hrd_bag) {
            $no++;
            $row = array();
            $row[] = "<input type='checkbox' class='singlechkbox' name='check[]' value='" . $hrd_bag->no_id . "'>";
            if ($dr === 'SUPER_ADMIN') {
                $row[] = '<div class="dropdown">
                            <a style="background-color: #9c774c;" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-bars icon" style="font-size: 13px;"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="' . site_url('admin/Master_Bagian/update/' . $hrd_bag->no_id) . '"> <i class="fa fa-edit"></i> Edit</a>
                                <a class="dropdown-item" href="' . site_url('admin/Master_Bagian/delete/' . $hrd_bag->no_id) . '"  onclick="return confirm(&quot; Apakah Anda Yakin Ingin Menghapus? &quot;)"><i class="fa fa-trash"></i> Delete</a>
                            </div>
                        </div>';
            } else {
                $row[] = '<div class="dropdown">
                        <a style="background-color: #9c774c;" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bars icon" style="font-size: 13px;"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="' . site_url('admin/Master_Bagian/update/' . $hrd_bag->no_id) . '"> <i class="fa fa-edit"></i> Edit</a>
                            <a hidden class="dropdown-item" href="' . site_url('admin/Master_Bagian/delete/' . $hrd_bag->no_id) . '"  onclick="return confirm(&quot; Apakah Anda Yakin Ingin Menghapus? &quot;)"><i class="fa fa-trash"></i> Delete</a>
                        </div>
                    </div>';
            }
            $row[] = $no . ".";
            $row[] = $hrd_bag->kd_bag;
            $row[] = $hrd_bag->nm_bag;
            $row[] = $hrd_bag->kd_grup;
            $row[] = $hrd_bag->nm_grup;
            $row[] = $hrd_bag->dr;
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

    public function index_Master_Bagian()
    {
        $data['hrd_bag'] = $this->master_model->tampil_data('hrd_bag', 'no_id')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Master_Bagian/Master_Bagian', $data);
        $this->load->view('templates_admin/footer');
    }

    public function getOrder()
    {
        $data['orderBy'] = $this->input->get('order');
        $this->session->set_userdata('order_hrd_bag', $data['orderBy']);
    }

    public function input()
    {
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Master_Bagian/Master_Bagian_form');
        $this->load->view('templates_admin/footer');
    }

    public function input_aksi()
    {
        $data = array(
            'kd_bag' => $this->input->post('KD_BAG', TRUE),
            'nm_bag' => $this->input->post('NM_BAG', TRUE),
            'prefix' => $this->input->post('PREFIX', TRUE),
            'kd_grup' => $this->input->post('KD_GRUP', TRUE),
            'nm_grup' => $this->input->post('NM_GRUP', TRUE),
            'kd_kasi' => $this->input->post('KD_KASI', TRUE),
            'nm_kasi' => $this->input->post('NM_KASI', TRUE),
            'acno' => $this->input->post('ACNO', TRUE),
            'dr' => $this->input->post('DR', TRUE),
            'usrnm' => $this->session->userdata['username'],
            'i_tgl' => date('Y-m-d H:i:s'),
        );
        $this->master_model->input_data('hrd_bag', $data);
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                Data succesfully Inserted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Master_Bagian/index_Master_Bagian');
    }

    public function update($no_id)
    {
        $where = array('no_id' => $no_id);
        $ambildata = $this->master_model->edit_data($where, 'hrd_bag');
        $r = $ambildata->row_array();
        $data = [
            'NO_ID' => $r['no_id'],
            'KD_BAG' => $r['kd_bag'],
            'NM_BAG' => $r['nm_bag'],
            'PREFIX' => $r['prefix'],
            'KD_KASI' => $r['kd_kasi'],
            'NM_KASI' => $r['nm_kasi'],
            'KD_GRUP' => $r['kd_grup'],
            'NM_GRUP' => $r['nm_grup'],
            'ACNO' => $r['acno'],
            'DR' => $r['dr'],
        ];
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Master_Bagian/Master_Bagian_update', $data);
        $this->load->view('templates_admin/footer');
    }

    public function update_aksi()
    {
        $no_id = $this->input->post('NO_ID');
        $data = array(
            'kd_bag' => $this->input->post('KD_BAG', TRUE),
            'nm_bag' => $this->input->post('NM_BAG', TRUE),
            'prefix' => $this->input->post('PREFIX', TRUE),
            'kd_grup' => $this->input->post('KD_GRUP', TRUE),
            'nm_grup' => $this->input->post('NM_GRUP', TRUE),
            'kd_kasi' => $this->input->post('KD_KASI', TRUE),
            'nm_kasi' => $this->input->post('NM_KASI', TRUE),
            'acno' => $this->input->post('ACNO', TRUE),
            'dr' => $this->input->post('DR', TRUE),
            'e_pc' => $this->session->userdata['username'],
            'e_tgl' => date('Y-m-d H:i:s'),
        );
        $where = array(
            'no_id' => $no_id
        );
        $this->master_model->update_data($where, $data, 'hrd_bag');
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-dismissible fade show" role="alert"> 
                Data succesfully Updated.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Master_Bagian/index_Master_Bagian');
    }

    public function delete($no_id)
    {
        $where = array('no_id' => $no_id);
        $this->master_model->hapus_data($where, 'hrd_bag');
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                Data succesfully Deleted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Master_Bagian/index_Master_Bagian');
    }

    function delete_multiple()
    {
        $this->master_model->remove_checked('hrd_bag');
        redirect('admin/Master_Bagian/index_Master_Bagian');
    }

    public function getDataAjax_Grup()
    {
        $search = $this->input->post('search');
        $page = ((int)$this->input->post('page'));
        if ($page == 0) {
            $xa = 0;
        } else {
            $xa = ($page - 1) * 10;
        }
        $perPage = 10;
        $results = $this->db->query("SELECT no_id, kd_grup, nm_grup, acno
            FROM hrd_grup
            WHERE kd_grup LIKE '%$search%' OR nm_grup LIKE '%$search%' OR acno LIKE '%$search%'
            ORDER BY kd_grup LIMIT $xa,$perPage");
        $selectajax = array();
        foreach ($results->RESULT_ARRAY() as $row) {
            $selectajax[] = array(
                'id' => $row['kd_grup'],
                'text' => $row['kd_grup'],
                'kd_grup' => $row['kd_grup'] . " - " . $row['nm_grup'] . " - " . $row['acno'],
                'nm_grup' => $row['nm_grup'],
                'acno' => $row['acno'],
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
