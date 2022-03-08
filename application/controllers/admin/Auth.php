<?php

class Auth extends CI_Controller
{

    public function index()
    {
        $this->load->view('templates_admin/header');
        $this->load->view('admin/login');
        $this->load->view('templates_admin/footer');
    }

    public function proses_login()
    {
        // function get_client_ip() {
        // 	$ipaddress = '';
        // 	if (isset($_SERVER['HTTP_CLIENT_IP']))
        // 		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        // 	else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        // 		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        // 	else if(isset($_SERVER['HTTP_X_FORWARDED']))
        // 		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        // 	else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        // 		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        // 	else if(isset($_SERVER['HTTP_FORWARDED']))
        // 		$ipaddress = $_SERVER['HTTP_FORWARDED'];
        // 	else if(isset($_SERVER['REMOTE_ADDR']))
        // 		$ipaddress = $_SERVER['REMOTE_ADDR'];
        // 	else
        // 		$ipaddress = 'UNKNOWN';
        // 	return $ipaddress;
        // }
        $this->form_validation->set_rules('username', 'username', 'required', ['required' => 'Username wajib di isi!!']);
        $this->form_validation->set_rules('password', 'password', 'required', ['required' => 'Password wajib di isi!!']);
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates_admin/header');
            $this->load->view('admin/login');
            $this->load->view('templates_admin/footer');
        } else {
            /// COBA
            $perix = $this->db->query(
                "SELECT PERI as PERI FROM peri WHERE 
                (date(now()) >= peri.TGL_AWAL AND 
                date(now()) <= peri.TGL_AKHIR)"
            )->result();
            $nom = array_column($perix, 'PERI');
            $peri = $nom[0];
            $periode = $peri;
            // if ($peri == '01/2022') {
            //     $periode = '01/2022';
            // } else if ($peri == '02/2022') {
            //     $periode = '02/2022';
            // } else if ($peri == '03/2022') {
            //     $periode = '03/2022';
            // } else if ($peri == '04/2022') {
            //     $periode = '04/2022';
            // } else if ($peri == '05/2022') {
            //     $periode = '05/2022';
            // } else if ($peri == '06/2022') {
            //     $periode = '06/2022';
            // } else if ($peri == '07/2022') {
            //     $periode = '07/2022';
            // } else if ($peri == '08/2022') {
            //     $periode = '08/2022';
            // } else if ($peri == '09/2022') {
            //     $periode = '09/2022';
            // } else if ($peri == '10/2022') {
            //     $periode = '10/2022';
            // } else if ($peri == '11/2022') {
            //     $periode = '11/2022';
            // } else if ($peri == '12/2022') {
            //     $periode = '12/2022';
            // }
            /// BATAS COBA
            // $month = date('m');
            // $year = date('Y');
            // $periode = $month . '/' . $year;
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $user = $username;
            $pass = MD5($password);
            $cek = $this->login_model->cek_login($user, $pass);
            if ($cek->num_rows() > 0) {
                foreach ($cek->result() as $ck) {
                    $sess_data['id'] = $ck->NO_ID;
                    // set data font dari model
                    $font       = $this->font_model->get_font($sess_data['id']);
                    $id_font    = $this->font_model->get_id($sess_data['id']);
                    $size_font  = $this->font_model->get_size($sess_data['id']);
                    // masukan ke sesi
                    $sess_data['font'] = $font;
                    $sess_data['id_font'] = $id_font;
                    $sess_data['size_font'] = $size_font;
                    $sess_data['username'] = $ck->USERNAME;
                    $sess_data['level'] = $ck->AKSES;
                    $sess_data['super_admin'] = $ck->SUPER_ADMIN;
                    $sess_data['periode'] = $periode;
                    $sess_data['dr'] = $ck->DR;
                    $sess_data['pt'] = $ck->PT;
                    $sess_data['flag'] = '';
                    $sess_data['judul'] = '';
                    $sess_data['menu_hrd'] = '';
                    // $sess_data ['fase'] = 1;
                    $this->session->set_userdata($sess_data);
                }
                // var_dump($periode);
                if ($sess_data['level'] != '') {
                    // var_dump($peri);
                    redirect('admin/dashboard');
                } else {
                    $this->session->set_flashdata(
                        'pesan',
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Username atau Password Anda Salah!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>'
                    );
                    redirect('admin/auth');
                }
            } else {
                $this->session->set_flashdata(
                    'pesan',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Username atau Password Anda Salah!!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>'
                );
                redirect('admin/auth');
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('admin/auth');
    }
}
