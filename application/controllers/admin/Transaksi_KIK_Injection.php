<?php

class Transaksi_KIK_Injection extends CI_Controller
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
        if ($this->session->userdata['menu_hrd'] != 'hrd_kik') {
            $this->session->set_userdata('menu_hrd', 'hrd_kik');
            $this->session->set_userdata('kode_menu', 'ST0010');
            $this->session->set_userdata('keyword_hrd_kik', '');
            $this->session->set_userdata('order_hrd_kik', 'no_id');
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
            'flag' => 'INJECTION'
        );
        $this->db->select('*');
        $this->db->from('hrd_kik');
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
            'flag' => 'INJECTION'
        );
        $this->db->from('hrd_kik');
        $this->db->where($where);
        return $this->db->count_all_results();
    }

    function get_ajax_hrd_kik()
    {
        $list = $this->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $hrd_kik) {
            $JASPER = "window.open('JASPER/" . $hrd_kik->no_id . "','', 'width=1000','height=900');";
            $no++;
            $row = array();
            $row[] = "<input type='checkbox' class='singlechkbox' name='check[]' value='" . $hrd_kik->no_id . "'>";
            $row[] = '<div class="dropdown">
                        <a style="background-color: #9c774c;" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bars icon" style="font-size: 13px;"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_KIK_Injection/update/' . $hrd_kik->no_id) . '"> <i class="fa fa-edit"></i> Edit</a>
                            <a class="dropdown-item" href="' . site_url('admin/Transaksi_KIK_Injection/delete/' . $hrd_kik->no_id) . '" onclick="return confirm(&quot; Apakah Anda Yakin Ingin Menghapus? &quot;)"><i class="fa fa-trash"></i> Delete</a>
                            <a name="no_id" class="dropdown-item" href="#" onclick="' . $JASPER . '");"><i class="fa fa-print"></i> Print</a>
                        </div>
                    </div>';
            $row[] = $no . ".";
            $row[] = $hrd_kik->no_bukti;
            $row[] = $hrd_kik->kd_bag;
            $row[] = $hrd_kik->nm_bag;
            $row[] = $hrd_kik->notes;
            $row[] = $hrd_kik->dr;
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

    public function index_Transaksi_KIK_Injection()
    {
        $dr = $this->session->userdata['dr'];
        $per = $this->session->userdata['periode'];
        $this->session->set_userdata('judul', 'Transaksi KIK Injection');
        $where = array(
            'dr' => $dr,
            'per' => $per,
            'flag' => 'INJECTION'
        );
        $data['hrd_kik'] = $this->transaksi_model->tampil_data($where, 'hrd_kik', 'no_id')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_KIK_Injection/Transaksi_KIK_Injection', $data);
        $this->load->view('templates_admin/footer');
    }

    public function input()
    {
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_KIK_Injection/Transaksi_KIK_Injection_form');
        $this->load->view('templates_admin/footer');
    }

    public function input_aksi()
    {
        $dr = $this->session->userdata['dr'];
        $per = $this->session->userdata['periode'];
        $kd_bag = $this->input->post('KD_BAG', TRUE);
        $nm_bag = $this->input->post('NM_BAG', TRUE);
        $kd_grup = $this->input->post('KD_GRUP', TRUE);
        $nm_grup = $this->input->post('NM_GRUP', TRUE);
        $fase = $this->input->post('FASE', TRUE);
        $per = $this->session->userdata['periode'];
        $nomer = $this->db->query("SELECT MAX(no_bukti) as NO_BUKTI FROM hrd_kik WHERE per='$per' AND flag='INJECTION' AND dr='$dr' AND fase='$fase'")->result();
        $nom = array_column($nomer, 'NO_BUKTI');
        $value11 = substr($nom[0], -4);
        $value22 = STRVAL($value11) + 1;
        $urut = str_pad($value22, 4, "0", STR_PAD_LEFT);
        $tahun = substr($this->session->userdata['periode'], -2);
        $bulan = substr($this->session->userdata['periode'], 0, 2);
        $bukti = $tahun . $bulan . '.' . $fase . '-' . 'DR' . $dr . '-' . $kd_bag;
        $datah = array(
            'flag' => 'INJECTION',
            'no_bukti' => $bukti,
            'kd_bag' => $this->input->post('KD_BAG', TRUE),
            'nm_bag' => $this->input->post('NM_BAG', TRUE),
            'kd_grup' => $this->input->post('KD_GRUP', TRUE),
            'nm_grup' => $this->input->post('NM_GRUP', TRUE),
            'kik_grup' => $this->input->post('KIK_GRUP', TRUE),
            'notes' => $this->input->post('NOTES', TRUE),
            'fase' => $this->input->post('FASE', TRUE),
            'lunas_bs' => str_replace(',', '', $this->input->post('LUNAS_BS', TRUE)),
            'upah_tambah' => str_replace(',', '', $this->input->post('UPAH_TAMBAH', TRUE)),
            'ppn' => str_replace(',', '', $this->input->post('PPN', TRUE)),
            'umr' => str_replace(',', '', $this->input->post('UMR', TRUE)),
            'tqty' => str_replace(',', '', $this->input->post('TQTY', TRUE)),
            't_hr' => str_replace(',', '', $this->input->post('T_HR', TRUE)),
            'tjumlah' => str_replace(',', '', $this->input->post('TJUMLAH', TRUE)),
            'minuss' => str_replace(',', '', $this->input->post('MINUSS', TRUE)),
            'pot_bon' => str_replace(',', '', $this->input->post('POT_BON', TRUE)),
            'dr' => $this->session->userdata['dr'],
            'per' => $this->session->userdata['periode'],
            'usrnm' => $this->session->userdata['username'],
            'i_tgl' => date("Y-m-d h:i a")
        );
        $this->transaksi_model->input_datah('hrd_kik', $datah);
        $ID = $this->db->query("SELECT MAX(no_id) AS NO_ID FROM hrd_kik WHERE no_bukti = '$bukti' GROUP BY no_bukti")->result();
        $REC = $this->input->post('REC');
        $NO_KIK = $this->input->post('NO_KIK');
        $TGL_KIK = $this->input->post('TGL_KIK');
        $MODEL = $this->input->post('MODEL');
        $ITEM = $this->input->post('ITEM');
        $DES1 = $this->input->post('DES1');
        $QTY = str_replace(',', '', $this->input->post('QTY', TRUE));
        $UPAH = str_replace(',', '', $this->input->post('UPAH', TRUE));
        $JUMLAH = str_replace(',', '', $this->input->post('JUMLAH', TRUE));
        $ORG = str_replace(',', '', $this->input->post('ORG', TRUE));
        $HR = str_replace(',', '', $this->input->post('HR', TRUE));
        $i = 0;
        foreach ($REC as $a) {
            $datad = array(
                'id' => $ID[0]->NO_ID,
                'no_bukti' => $bukti,
                'kd_bag' => $kd_bag,
                'nm_bag' => $nm_bag,
                'kd_grup' => $kd_grup,
                'nm_grup' => $nm_grup,
                'fase' => $this->input->post('FASE', TRUE),
                'flag' => 'INJECTION',
                'rec' => $REC[$i],
                'no_kik' => isset($NO_KIK[$i]) ? $NO_KIK[$i] : '',
                'tgl_kik' => date("Y-m-d", strtotime($TGL_KIK[$i])),
                'model' => $MODEL[$i],
                'item' => $ITEM[$i],
                'des1' => $DES1[$i],
                'qty' => str_replace(',', '', $QTY[$i]),
                'upah' => str_replace(',', '', $UPAH[$i]),
                'jumlah' => str_replace(',', '', $JUMLAH[$i]),
                'org' => str_replace(',', '', $ORG[$i]),
                'hr' => str_replace(',', '', $HR[$i]),
                'dr' => $this->session->userdata['dr'],
                'per' => $this->session->userdata['periode'],
                'usrnm' => $this->session->userdata['username'],
                'i_tgl' => date("Y-m-d h:i a")
            );
            $this->transaksi_model->input_datad('hrd_kikd', $datad);
            $i++;
        }
        // var_dump($datad);
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                Data succesfully Inserted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Transaksi_KIK_Injection/index_Transaksi_KIK_Injection');
    }

    public function update($id)
    {
        $q1 = "SELECT hrd_kik.no_id as ID,
                hrd_kik.no_bukti AS NO_BUKTI,
                hrd_kik.kd_bag AS KD_BAG,
                hrd_kik.nm_bag AS NM_BAG,
                hrd_kik.kd_grup AS KD_GRUP,
                hrd_kik.nm_grup AS NM_GRUP,
                hrd_kik.kik_grup AS KIK_GRUP,
                hrd_kik.notes AS NOTES,
                hrd_kik.fase AS FASE,
                hrd_kik.lunas_bs AS LUNAS_BS,
                hrd_kik.upah_tambah AS UPAH_TAMBAH,
                hrd_kik.ppn AS PPN,
                hrd_kik.umr AS UMR,
                hrd_kik.tqty AS TQTY,
                hrd_kik.t_hr AS T_HR,
                hrd_kik.tjumlah AS TJUMLAH,
                hrd_kik.pot_bon AS POT_BON,
                hrd_kik.minuss AS MINUSS,

                hrd_kikd.no_id AS NO_ID,
                hrd_kikd.rec AS REC,
                hrd_kikd.no_kik AS NO_KIK,
                hrd_kikd.tgl_kik AS TGL_KIK,
                hrd_kikd.model AS MODEL,
                hrd_kikd.item AS ITEM,
                hrd_kikd.des1 AS DES1,
                hrd_kikd.qty AS QTY,
                hrd_kikd.upah AS UPAH,
                hrd_kikd.jumlah AS JUMLAH,
                hrd_kikd.org AS ORG,
                hrd_kikd.hr AS HR
            FROM hrd_kik,hrd_kikd 
            WHERE hrd_kik.no_id=$id 
            AND hrd_kik.no_id=hrd_kikd.id 
            ORDER BY hrd_kikd.rec";
        $data['kik_injection'] = $this->transaksi_model->edit_data($q1)->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/navbar');
        $this->load->view('admin/Transaksi_KIK_Injection/Transaksi_KIK_Injection_update', $data);
        $this->load->view('templates_admin/footer');
    }

    public function update_aksi()
    {
        $datah = array(
            'flag' => 'INJECTION',
            'no_bukti' => $this->input->post('NO_BUKTI', TRUE),
            'kd_bag' => $this->input->post('KD_BAG', TRUE),
            'nm_bag' => $this->input->post('NM_BAG', TRUE),
            'kd_grup' => $this->input->post('KD_GRUP', TRUE),
            'nm_grup' => $this->input->post('NM_GRUP', TRUE),
            'kik_grup' => $this->input->post('KIK_GRUP', TRUE),
            'notes' => $this->input->post('NOTES', TRUE),
            'fase' => $this->input->post('FASE', TRUE),
            'lunas_bs' => str_replace(',', '', $this->input->post('LUNAS_BS', TRUE)),
            'upah_tambah' => str_replace(',', '', $this->input->post('UPAH_TAMBAH', TRUE)),
            'ppn' => str_replace(',', '', $this->input->post('PPN', TRUE)),
            'umr' => str_replace(',', '', $this->input->post('UMR', TRUE)),
            'tqty' => str_replace(',', '', $this->input->post('TQTY', TRUE)),
            't_hr' => str_replace(',', '', $this->input->post('T_HR', TRUE)),
            'tjumlah' => str_replace(',', '', $this->input->post('TJUMLAH', TRUE)),
            'minuss' => str_replace(',', '', $this->input->post('MINUSS', TRUE)),
            'pot_bon' => str_replace(',', '', $this->input->post('POT_BON', TRUE)),
            'dr' => $this->session->userdata['dr'],
            'per' => $this->session->userdata['periode'],
            'e_pc' => $this->session->userdata['username'],
            'e_tgl' => date("Y-m-d h:i a")
        );
        $where = array(
            'no_id' => $this->input->post('ID', TRUE)
        );
        $this->transaksi_model->update_data($where, $datah, 'hrd_kik');
        $id = $this->input->post('ID', TRUE);
        $q1 = "SELECT hrd_kik.no_id as ID,
                hrd_kik.no_bukti AS NO_BUKTI,
                hrd_kik.kd_bag AS KD_BAG,
                hrd_kik.nm_bag AS NM_BAG,
                hrd_kik.kd_grup AS KD_GRUP,
                hrd_kik.nm_grup AS NM_GRUP,
                hrd_kik.kik_grup AS KIK_GRUP,
                hrd_kik.notes AS NOTES,
                hrd_kik.fase AS FASE,
                hrd_kik.lunas_bs AS LUNAS_BS,
                hrd_kik.upah_tambah AS UPAH_TAMBAH,
                hrd_kik.ppn AS PPN,
                hrd_kik.umr AS UMR,
                hrd_kik.tqty AS TQTY,
                hrd_kik.t_hr AS T_HR,
                hrd_kik.tjumlah AS TJUMLAH,
                hrd_kik.pot_bon AS POT_BON,
                hrd_kik.minuss AS MINUSS,

                hrd_kikd.no_id AS NO_ID,
                hrd_kikd.rec AS REC,
                hrd_kikd.no_kik AS NO_KIK,
                hrd_kikd.tgl_kik AS TGL_KIK,
                hrd_kikd.model AS MODEL,
                hrd_kikd.item AS ITEM,
                hrd_kikd.des1 AS DES1,
                hrd_kikd.qty AS QTY,
                hrd_kikd.upah AS UPAH,
                hrd_kikd.jumlah AS JUMLAH,
                hrd_kikd.org AS ORG,
                hrd_kikd.hr AS HR
            FROM hrd_kik,hrd_kikd 
            WHERE hrd_kik.no_id=$id 
            AND hrd_kik.no_id=hrd_kikd.id 
            ORDER BY hrd_kikd.rec";
        $data = $this->transaksi_model->edit_data($q1)->result();
        $NO_ID = $this->input->post('NO_ID');
        $REC = $this->input->post('REC');
        $NO_KIK = $this->input->post('NO_KIK');
        $TGL_KIK = $this->input->post('TGL_KIK');
        $MODEL = $this->input->post('MODEL');
        $ITEM = $this->input->post('ITEM');
        $DES1 = $this->input->post('DES1');
        $QTY = str_replace(',', '', $this->input->post('QTY', TRUE));
        $UPAH = str_replace(',', '', $this->input->post('UPAH', TRUE));
        $JUMLAH = str_replace(',', '', $this->input->post('JUMLAH', TRUE));
        $ORG = str_replace(',', '', $this->input->post('ORG', TRUE));
        $HR = str_replace(',', '', $this->input->post('HR', TRUE));
        $jum = count($data);
        $ID = array_column($data, 'NO_ID');
        $jumy = count($NO_ID);
        $i = 0;
        while ($i < $jum) {
            if (in_array($ID[$i], $NO_ID)) {
                $URUT = array_search($ID[$i], $NO_ID);
                $datad = array(
                    'flag' => 'INJECTION',
                    'no_bukti' => $this->input->post('NO_BUKTI'),
                    'kd_bag' => $this->input->post('KD_BAG'),
                    'nm_bag' => $this->input->post('NM_BAG'),
                    'kd_grup' => $this->input->post('KD_GRUP'),
                    'nm_grup' => $this->input->post('NM_GRUP'),
                    'rec' => $REC[$URUT],
                    'no_kik' => $NO_KIK[$URUT],
                    'tgl_kik' => date("Y-m-d", strtotime($TGL_KIK[$URUT])),
                    'model' => $MODEL[$URUT],
                    'item' => $ITEM[$URUT],
                    'des1' => $DES1[$URUT],
                    'qty' => str_replace(',', '', $QTY[$URUT]),
                    'upah' => str_replace(',', '', $UPAH[$URUT]),
                    'jumlah' => str_replace(',', '', $JUMLAH[$URUT]),
                    'org' => str_replace(',', '', $ORG[$URUT]),
                    'hr' => str_replace(',', '', $HR[$URUT]),
                    'dr' => $this->session->userdata['dr'],
                    'per' => $this->session->userdata['periode'],
                    'e_pc' => $this->session->userdata['username'],
                    'e_tgl' => date("Y-m-d h:i a")
                );
                $where = array(
                    'no_id' => $NO_ID[$URUT]
                );
                $this->transaksi_model->update_data($where, $datad, 'hrd_kikd');
            } else {
                $where = array(
                    'no_id' => $ID[$i]
                );
                $this->transaksi_model->hapus_data($where, 'hrd_kikd');
            }
            $i++;
        }
        $i = 0;
        while ($i < $jumy) {
            if ($NO_ID[$i] == "0") {
                $datad = array(
                    'flag' => 'INJECTION',
                    'id' => $this->input->post('ID', TRUE),
                    'no_bukti' => $this->input->post('NO_BUKTI'),
                    'kd_bag' => $this->input->post('KD_BAG'),
                    'nm_bag' => $this->input->post('NM_BAG'),
                    'kd_grup' => $this->input->post('KD_GRUP'),
                    'nm_grup' => $this->input->post('NM_GRUP'),
                    'rec' => $REC[$i],
                    'no_kik' => $NO_KIK[$i],
                    'tgl_kik' => date("Y-m-d", strtotime($TGL_KIK[$i])),
                    'model' => $MODEL[$i],
                    'item' => $ITEM[$i],
                    'des1' => $DES1[$i],
                    'qty' => str_replace(',', '', $QTY[$i]),
                    'upah' => str_replace(',', '', $UPAH[$i]),
                    'jumlah' => str_replace(',', '', $JUMLAH[$i]),
                    'org' => str_replace(',', '', $ORG[$i]),
                    'hr' => str_replace(',', '', $HR[$i]),
                    'dr' => $this->session->userdata['dr'],
                    'per' => $this->session->userdata['periode'],
                    'e_pc' => $this->session->userdata['username'],
                    'e_tgl' => date("Y-m-d h:i a")
                );
                $this->transaksi_model->input_datad('hrd_kikd', $datad);
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
        redirect('admin/Transaksi_KIK_Injection/index_Transaksi_KIK_Injection');
    }

    public function delete($id)
    {
        $where = array('no_id' => $id);
        $this->transaksi_model->hapus_data($where, 'hrd_kik');
        $where = array('id' => $id);
        $this->transaksi_model->hapus_data($where, 'hrd_kikd');
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                Data succesfully Deleted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>'
        );
        redirect('admin/Transaksi_KIK_Injection/index_Transaksi_KIK_Injection');
    }

    function delete_multiple()
    {
        $this->transaksi_model->remove_checked('hrd_kik', 'hrd_kikd');
        redirect('admin/Transaksi_KIK_Injection/index_Transaksi_KIK_Injection');
    }

    public function getDataAjax_KIK2()
    {
        $kik_grup = $this->input->post('kik_grup');
        $dr = $this->session->userdata['dr'];
        $search = $this->input->post('search');
        $page = ((int)$this->input->post('page'));
        if ($page == 0) {
            $xa = 0;
        } else {
            $xa = ($page - 1) * 10;
        }
        $perPage = 10;
        $results = $this->db->query("SELECT gd_kik.no_kik, hrd_modeld.model, gd_kik.qty, hrd_modeld.upah, hrd_modeld.urut_ke, hrd_modeld.kode, hrd_modeld.item, hrd_modeld.des1
            FROM gd_kik, hrd_modeld
            WHERE gd_kik.model_bsg=hrd_modeld.model AND (hrd_modeld.proses='$kik_grup' OR hrd_modeld.proses='INJECT2') AND hrd_modeld.dr='$dr' AND ( gd_kik.no_kik LIKE '%$search%' OR hrd_modeld.model LIKE '%$search%' )
            GROUP BY gd_kik.no_kik, hrd_modeld.upah
            ORDER BY gd_kik.no_kik, hrd_modeld.upah DESC LIMIT $xa,$perPage");
        $selectajax = array();
        foreach ($results->RESULT_ARRAY() as $row) {
            $selectajax[] = array(
                'id' => $row['no_kik'],
                'text' => $row['no_kik'],
                'no_kik' => $row['no_kik'] . " - " . $row['model'] .  " - " . $row['des1'] . " - " . $row['qty']  . " - " . $row['upah'],
                'model' => $row['model'],
                'qty' => $row['qty'],
                'upah' => $row['upah'],
                'urut_ke' => $row['urut_ke'],
                'kode' => $row['kode'],
                'item' => $row['item'],
                'des1' => $row['des1'],
            );
        }
        $select['total_count'] =  $results->NUM_ROWS();
        $select['items'] = $selectajax;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function getDataAjax_KIK()
    {
        $search = $this->input->post('search');
        $page = ((int)$this->input->post('page'));
        if ($page == 0) {
            $xa = 0;
        } else {
            $xa = ($page - 1) * 10;
        }
        $perPage = 10;
        $results = $this->db->query("SELECT no_id, no_kik
            FROM gd_kik
            WHERE no_kik LIKE '%$search%' OR model LIKE '%$search%'
            ORDER BY no_kik LIMIT $xa,$perPage");
        $selectajax = array();
        foreach ($results->RESULT_ARRAY() as $row) {
            $selectajax[] = array(
                'id' => $row['no_kik'],
                'text' => $row['no_kik'],
                'no_kik' => $row['no_kik'],
            );
        }
        $select['total_count'] =  $results->NUM_ROWS();
        $select['items'] = $selectajax;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function getDataAjax_Model()
    {
        $kik_grup = $this->input->post('kik_grup');
        $search = $this->input->post('search');
        $page = ((int)$this->input->post('page'));
        if ($page == 0) {
            $xa = 0;
        } else {
            $xa = ($page - 1) * 10;
        }
        $perPage = 10;
        $results = $this->db->query("SELECT no_id, model, urut_ke, kode, item, proses, des1, upah
            FROM hrd_modeld
            WHERE proses='INJECTION' AND (model LIKE '%$search%' OR proses LIKE '%$search%' OR upah LIKE '%$search%') 
            ORDER BY model LIMIT $xa,$perPage");
        $selectajax = array();
        foreach ($results->RESULT_ARRAY() as $row) {
            $selectajax[] = array(
                'id' => $row['model'],
                'text' => $row['model'],
                'model' => $row['model'] . " - " . $row['proses'] . " - " . $row['upah'],
                'urut_ke' => $row['urut_ke'],
                'kode' => $row['kode'],
                'item' => $row['item'],
                'proses' => $row['proses'],
                'des1' => $row['des1'],
                'upah' => $row['upah'],
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
        $PHPJasperXML->load_xml_file("phpjasperxml/Transaksi_KIK_Injection.jrxml");
        $no_id = $id;
        $query = "SELECT hrd_kik.no_id as ID,
                hrd_kik.no_sp AS MODEL,
                hrd_kik.perke AS PERKE,
                hrd_kik.tgl_sp AS TGL_SP,
                hrd_kik.nodo AS NODO,
                hrd_kik.tgldo AS TGLDO,
                hrd_kik.tlusin AS TLUSIN,
                hrd_kik.tpair AS TPAIR,

                hrd_kikd.no_id AS NO_ID,
                hrd_kikd.rec AS REC,
                CONCAT(hrd_kikd.article,' - ',hrd_kikd.warna) AS ARTICLE,
                hrd_kikd.size AS SIZE,
                hrd_kikd.golong AS GOLONG,
                hrd_kikd.stok AS STOK,
                hrd_kikd.lusin AS LUSIN,
                hrd_kikd.pair AS PAIR,
                CONCAT(hrd_kikd.kodecus,' - ',hrd_kikd.nama) AS KODECUS,
                hrd_kikd.kota AS KOTA
            FROM hrd_kik,hrd_kikd 
            WHERE hrd_kik.no_id=$id 
            AND hrd_kik.no_id=hrd_kikd.id 
            ORDER BY hrd_kikd.rec";
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
