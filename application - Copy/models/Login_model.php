<?php

class Login_model extends CI_Model
{

    public function cek_login($username, $password)
    {
        $this->db->where("username", $username);
        $this->db->where("password", $password);
        return $this->db->get('users');
    }

    public function getLoginData($user, $pass)
    {
        $u = $user;
        $p = MD5($pass);
        $day = date('d');
        $month = date('m');
        $year = date('Y');

        /// COBA
        $tgl = date_create(date(now()));
        $TGL_SEKARANG = date_format($tgl, "Y-m-d");
        $peri = $this->db->query(
            "SELECT PERI as PERI FROM peri WHERE 
            ($TGL_SEKARANG >= peri.TGL_AWAL AND 
            $TGL_SEKARANG <= peri.TGL_AKHIR)"
        )->result();
        if ($peri == '01/2022') {
            $periode = '01/2022';
        } else if ($peri == '02/2022') {
            $periode = '02/2022';
        } else if ($peri == '03/2022') {
            $periode = '03/2022';
        } else if ($peri == '04/2022') {
            $periode = '04/2022';
        } else if ($peri == '05/2022') {
            $periode = '05/2022';
        } else if ($peri == '06/2022') {
            $periode = '06/2022';
        } else if ($peri == '07/2022') {
            $periode = '07/2022';
        } else if ($peri == '08/2022') {
            $periode = '08/2022';
        } else {
            $periode = '12/2022';
        }
        /// BATAS COBA

        // $periode = $month . '/' . $year;
        $query_cekLogin = $this->db->get_where(
            'users',
            array('username' => $u, 'password' => $p)
        );
        if (count($query_cekLogin->result()) > 0) {
            foreach ($query_cekLogin->result() as $qck) {
                foreach ($query_cekLogin->result() as $ck) {
                    $sess_data['logged_in'] = TRUE;
                    $sess_data['username'] = $ck->USERNAME;
                    $sess_data['password'] = $ck->PASSWORD;
                    $sess_data['level'] = $ck->AKSES;
                    $sess_data['periode'] = $periode;
                    // session hrd
                    $sess_data['super_admin'] = $ck->SUPER_ADMIN;
                    $sess_data['dr'] = $ck->DR;
                    $sess_data['pt'] = $ck->PT;
                    $this->session->set_userdata($sess_data);
                }
                redirect('admin/dashboard');
            }
        } else {
            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
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
