<?php

class MasterModel extends CI_Controller
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
        if ($this->session->userdata['menu_hrd'] != 'hrd_model') {
            $this->session->set_userdata('menu_hrd', 'hrd_model');
            $this->session->set_userdata('kode_menu', 'M0005');
            $this->session->set_userdata('keyword_hrd_model', '');
            $this->session->set_userdata('order_hrd_model', 'no_id');
        }
    }

    var $column_order = array(null, null, null, 'model', 'notes', 'dr');
    var $column_search = array('model', 'notes', 'dr');
    var $order = array('model' => 'asc');

    private function _get_datatables_query()
    {
        $dr = $this->session->userdata['dr'];
        $where = array(
            'dr' => $dr,
        );
        $this->db->select('*');
        $this->db->from('hrd_model');
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
        $this->db->from('hrd_model');
        $this->db->where($where);
        return $this->db->count_all_results();
    }

    function get_ajax_hrd_model()
    {
        $list = $this->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        $dr = $this->session->userdata['dr'];
        foreach ($list as $hrd_model) {
            $JASPER = "window.open('JASPER/" . $hrd_model->no_id . "','', 'width=1000','height=900');";
            $no++;
            $row = array();
            $row[] = "<input type='checkbox' class='singlechkbox' name='check[]' value='" . $hrd_model->no_id . "'>";
            if ($dr === 'SUPER_ADMIN') {
                $row[] = '<div class="dropdown">
                            <a style="background-color: #9c774c;" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-bars icon" style="font-size: 13px;"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="' . site_url('admin/MasterModel/update/' . $hrd_model->no_id) . '"> <i class="fa fa-edit"></i> Edit</a>
                                <a class="dropdown-item" href="' . site_url('admin/MasterModel/delete/' . $hrd_model->no_id) . '"  onclick="return confirm(&quot; Apakah Anda Yakin Ingin Menghapus? &quot;)"><i class="fa fa-trash"></i> Delete</a>
                            </div>
                        </div>';
            } else {
                $row[] = '<div class="dropdown">
                        <a style="background-color: #9c774c;" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bars icon" style="font-size: 13px;"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="' . site_url('admin/MasterModel/update/' . $hrd_model->no_id) . '"> <i class="fa fa-edit"></i> Edit</a>
                            <a class="dropdown-item" href="' . site_url('admin/MasterModel/delete/' . $hrd_model->no_id) . '"  onclick="return confirm(&quot; Apakah Anda Yakin Ingin Menghapus? &quot;)"><i class="fa fa-trash"></i> Delete</a>
                        </div>
                    </div>';
            }
            $row[] = $no . ".";
            $row[] = $hrd_model->model;
            $row[] = $hrd_model->notes;
            $row[] = $hrd_model->dr;
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

    public function index_MasterModel()
    {
        $dr = $this->session->userdata['dr'];
        $this->session->set_userdata('judul', 'Master Model');
        $where = array(
            'dr' => $dr
        );
        $data['hrd_model'] = $this->transaksi_model->tampil_data($where, 'hrd_model', 'no_id')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/MasterModel/MasterModel', $data);
        $this->load->view('templates_admin/footer');
    }

    public function input()
    {
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/MasterModel/MasterModel_form');
        $this->load->view('templates_admin/footer');
    }

    public function input_aksi()
    {
        // $dr= $this->session->userdata['dr'];  
        $nomer = $this->db->query("SELECT left(MAX(model),4) as NO_BUKTI FROM hrd_model")->result();
        $nom = array_column($nomer, 'NO_BUKTI');
        $urut = str_pad($nom[0] + 1, 4, "0", STR_PAD_LEFT);
        $bukti = $urut . '/' . 'MD';
        $datah = array(
            'model' => $bukti,
            'notes' => $this->input->post('NOTES', TRUE),
            'dr' => $this->session->userdata['dr'],
            'usrnm' => $this->session->userdata['username'],
            'i_tgl' => date("Y-m-d h:i a")
        );
        $this->transaksi_model->input_datah('hrd_model', $datah);
        $ID = $this->db->query("SELECT MAX(no_id) AS no_id FROM hrd_model WHERE model = '$bukti' AND model='$bukti' GROUP BY model")->result();
        $REC = $this->input->post('REC');
        $KD_BAG = $this->input->post('KD_BAG');
        $NM_BAG = $this->input->post('NM_BAG');
        $PROSES = $this->input->post('PROSES');
        $URUT_KE = $this->input->post('URUT_KE');
        $KODE = $this->input->post('KODE');
        $ITEM = $this->input->post('ITEM');
        $DES1 = $this->input->post('DES1');
        $UPAH = str_replace(',', '', $this->input->post('UPAH', TRUE));
        $i = 0;
        foreach ($REC as $a) {
            $datad = array(
                'id' => $ID[0]->no_id,
                'model' => $bukti,
                'rec' => $REC[$i],
                'kd_bag' => $KD_BAG[$i],
                'nm_bag' => $NM_BAG[$i],
                'proses' => $PROSES[$i],
                'urut_ke' => $URUT_KE[$i],
                'kode' => $KODE[$i],
                'item' => $ITEM[$i],
                'des1' => $DES1[$i],
                'upah' => str_replace(',', '', $UPAH[$i]),
                'dr' => $this->session->userdata['dr'],
                'usrnm' => $this->session->userdata['username'],
                'i_tgl' => date("Y-m-d h:i a")
            );
            $this->transaksi_model->input_datad('hrd_modeld', $datad);
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
        redirect('admin/MasterModel/index_MasterModel');
    }

    public function update($id)
    {
        $q1 = "SELECT hrd_model.no_id as ID,
                hrd_model.model AS MODEL,
                hrd_model.notes AS NOTES,

                hrd_modeld.no_id AS NO_ID,
                hrd_modeld.rec AS REC,
                hrd_modeld.kd_bag AS KD_BAG,
                hrd_modeld.nm_bag AS NM_BAG,
                hrd_modeld.proses AS PROSES,
                hrd_modeld.urut_ke AS URUT_KE,
                hrd_modeld.kode AS KODE,
                hrd_modeld.item AS ITEM,
                hrd_modeld.des1 AS DES1,
                hrd_modeld.upah AS UPAH
            FROM hrd_model,hrd_modeld 
            WHERE hrd_model.no_id=$id 
            AND hrd_model.no_id=hrd_modeld.id 
            ORDER BY hrd_modeld.rec";
        $data['master_model'] = $this->transaksi_model->edit_data($q1)->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/MasterModel/MasterModel_update', $data);
        $this->load->view('templates_admin/footer');
    }

    public function update_aksi()
    {
        redirect('admin/MasterModel/index_MasterModel');
    }

    public function delete($id)
    {
        $where = array('no_id' => $id);
        $this->transaksi_model->hapus_data($where, 'hrd_model');
        $where = array('id' => $id);
        $this->transaksi_model->hapus_data($where, 'hrd_modeld');
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                Data succesfully Deleted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/MasterModel/index_MasterModel');
    }

    function delete_multiple()
    {
        $this->transaksi_model->remove_checked('hrd_model', 'hrd_modeld');
        redirect('admin/MasterModel/index_MasterModel');
    }

    public function getDataAjax_Bagian()
    {
        $search = $this->input->post('search');
        $page = ((int)$this->input->post('page'));
        if ($page == 0) {
            $xa = 0;
        } else {
            $xa = ($page - 1) * 10;
        }
        $perPage = 10;
        $results = $this->db->query("SELECT no_id, kd_bag, nm_bag, kd_grup, nm_grup 
            FROM hrd_bag
            WHERE kd_bag LIKE '%$search%' OR nm_bag LIKE '%$search%' OR kd_grup LIKE '%$search%' OR nm_grup LIKE '%$search%' 
            ORDER BY kd_bag LIMIT $xa,$perPage");
        $selectajax = array();
        foreach ($results->RESULT_ARRAY() as $row) {
            $selectajax[] = array(
                'id' => $row['kd_bag'],
                'text' => $row['kd_bag'],
                'kd_bag' => $row['kd_bag'] . " - " . $row['nm_bag'] . " - " . $row['kd_grup'] . " - " . $row['nm_grup'],
                'nm_bag' => $row['nm_bag'],
                'kd_grup' => $row['kd_grup'],
                'nm_grup' => $row['nm_grup'],
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
        $PHPJasperXML->load_xml_file("phpjasperxml/MasterModel.jrxml");
        $no_id = $id;
        $query = "SELECT hrd_model.no_id as ID,
                hrd_model.no_sp AS MODEL,
                hrd_model.perke AS PERKE,
                hrd_model.tgl_sp AS TGL_SP,
                hrd_model.nodo AS NODO,
                hrd_model.tgldo AS TGLDO,
                hrd_model.tlusin AS TLUSIN,
                hrd_model.tpair AS TPAIR,

                hrd_modeld.no_id AS NO_ID,
                hrd_modeld.rec AS REC,
                CONCAT(hrd_modeld.article,' - ',hrd_modeld.warna) AS ARTICLE,
                hrd_modeld.size AS SIZE,
                hrd_modeld.golong AS GOLONG,
                hrd_modeld.stok AS STOK,
                hrd_modeld.lusin AS LUSIN,
                hrd_modeld.pair AS PAIR,
                CONCAT(hrd_modeld.kodecus,' - ',hrd_modeld.nama) AS KODECUS,
                hrd_modeld.kota AS KOTA
            FROM hrd_model,hrd_modeld 
            WHERE hrd_model.no_id=$id 
            AND hrd_model.no_id=hrd_modeld.id 
            ORDER BY hrd_modeld.rec";
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
