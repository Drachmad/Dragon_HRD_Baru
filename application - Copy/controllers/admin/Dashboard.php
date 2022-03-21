<?php

class Dashboard extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['username'])) {
			$this->session->set_flashdata(
				'pesan',
				'<div class="alert alert-success alert-dismissible fade show" role="alert">
					Anda Belum Login
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>'
			);
			redirect('admin/auth');
		}
	}

	public function index()
	{
		$data = $this->user_model->ambil_data($this->session->userdata['username']);
		$data = array(
			'na_dev' => $data->NA_DEV,
			'username' => $data->USERNAME,
			'level' => $data->AKSES,
			'dr' => $data->DR,
			'pt' => $data->PT,
			'fase' => $this->session->userdata['fase'],
			'periode' => $this->session->userdata['periode'],
		);
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/navbar');
		$this->load->view('admin/dashboard', $data);
		$this->load->view('templates_admin/footer');
	}

	public function ganti_periode()
	{
		$month = $this->input->post('bulan');
		$year = $this->input->post('tahun');
		$fase = $this->input->post('fase');
		$periode = $month . '/' . $year;
		$this->session->set_userdata('periode', $periode);
		$this->session->set_userdata('fase', $fase);
		$data = $this->user_model->ambil_data($this->session->userdata['username']);
		$data = array(
			'username' => $data->username,
			'level'   => $data->level,
			'periode' => $this->session->userdata['periode'],
			'fase' => $this->session->userdata['fase'],
		);
		redirect('admin/dashboard');
	}

	// fungsi untuk ganti font
	public function ganti_font($id)
	{
		$font = $this->input->post('font');
		$size = $this->input->post('size');
		$data = [
			'FONT' => $font,
			'SIZE' => $size
		];
		$this->font_model->update($id, $data);
		redirect('admin/dashboard');
	}
}
