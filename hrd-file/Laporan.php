<?php
defined('BASEPATH') or exit('No direct script access allowed');
// require FCPATH.'/vendor/autoload.php';
include BASEPATH . "/../koolreport/core/autoload.php";

use PHPJasper\PHPJasper;
use \koolreport\processes\ColumnMeta;
use \koolreport\processes\DateTimeFormat;
use \koolreport\processes\CopyColumn;
use \koolreport\processes\Group;
use \koolreport\processes\Filter;
use \koolreport\processes\ValueMap;
use \koolreport\pivot\processes\Pivot;
use \koolreport\pivot\PivotExcelExport;
use \koolreport\pivot\processes\PivotExtract;

class MyReport extends \koolreport\KoolReport {
	use \koolreport\export\Exportable;
}

class Laporan extends CI_Controller {

	function __construct() {
		parent::__construct();
		header('Cache-Control: no-cache, must-revalidate, max-age=0');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragma: no-cache');
		$this->load->helper('file');
		if (!isset($this->session->userdata['username'])) {
			$this->session->set_flashdata('pesan', 
				'<div class="alert alert-danger alert-dismissible fade show" role="alert">
					Anda Belum Login
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>');
			redirect('admin/auth');
		}
	}

	public function index() {
		$tgl1 = date("Y-m-d", strtotime($this->input->post('TGL1', TRUE)));
		$tgl2 = date("Y-m-d", strtotime($this->input->post('TGL2', TRUE)));
		$q1 = "select A.NO_ID AS ID,A.NO_BUKTI,A.TGL,A.MERK,A.NAMA,A.TOTAL AS TTOTAL, A.PPN, B.REC,B.NO_FAKTUR, 
		B.TOTAL,B.NO_ID  from piu_copy A,piud_copy B where A.NO_ID=B.ID and A.TGL>='$tgl1' and A.TGL<='$tgl2' ";
		$data['piu'] = $this->db->query($q1)->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/navbar');
		$this->load->view('admin/report/laporan', $data);
		$this->load->view('templates_admin/footer_report');
	}

	public function index_DaftarAbsen_Absen(){
		if (isset($_POST["print"])){
			$CI =& get_instance();
			$CI->load->database();
			$servername = $CI->db->hostname;
			$username = $CI->db->username;
			$password = $CI->db->password;
			$database = $CI->db->database;	
			$conn = mysqli_connect($servername,$username,$password,$database);
			error_reporting(E_ALL);
			ob_start();
			include('phpjasperxml/class/tcpdf/tcpdf.php');
			include('phpjasperxml/class/PHPJasperXML.inc.php');
			include('phpjasperxml/setting.php');
			$PHPJasperXML = new \PHPJasperXML();
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_DaftarAbsen_Absen.jrxml");
			$PHPJasperXML->transferDBtoArray($servername,$username,$password,$database);
			$per = $this->session->userdata['periode'];
			$kd_bag_1 = $this->input->post('KD_BAG_1');
			$query = "SELECT hrd_peg.kd_peg AS KD_PEG,
					hrd_peg.nm_peg AS NM_PEG,
					hrd_peg.kd_bag AS KD_BAG,
					CONCAT(hrd_peg.kd_bag,' - ',hrd_peg.nm_bag) AS BAGIAN,
					CASE hrd_peg.aktif
					WHEN '1' THEN 'AKTIF'
					WHEN '0' THEN 'TIDAK AKTIF'
					END AS AKTIF,
					'$per' AS PER
				FROM hrd_peg, hrd_bag
				WHERE hrd_peg.kd_bag=hrd_bag.kd_bag 
				AND hrd_peg.kd_bag='$kd_bag_1'
				AND hrd_peg.aktif='1'
				ORDER BY hrd_peg.kd_peg";
			$result1 = mysqli_query($conn,$query);
			while( $row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array( 
					"PER" => $row1["PER"],
					"KD_BAG" => $row1["KD_BAG"],
					"BAGIAN" => $row1["BAGIAN"],
					"NM_PEG" => $row1["NM_PEG"],
				));		
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		} else {
			$data = array(
				'KD_BAG_1' => set_value('KD_BAG_1'),
			);
			$data['daftarabsen_absen'] = $this->laporan_model->tampil_data_daftarabsen_absen()->result();
			$this->load->view('templates_admin/header');
			$this->load->view('templates_admin/navbar');
			$this->load->view('admin/laporan/DaftarAbsen_Absen',$data);
			$this->load->view('templates_admin/footer_report');
		}
	}

	public function index_DaftarAbsen_Lemburan(){
		if (isset($_POST["print"])){
			$CI =& get_instance();
			$CI->load->database();
			$servername = $CI->db->hostname;
			$username = $CI->db->username;
			$password = $CI->db->password;
			$database = $CI->db->database;	
			$conn = mysqli_connect($servername,$username,$password,$database);
			error_reporting(E_ALL);
			ob_start();
			include('phpjasperxml/class/tcpdf/tcpdf.php');
			include('phpjasperxml/class/PHPJasperXML.inc.php');
			include('phpjasperxml/setting.php');
			$PHPJasperXML = new \PHPJasperXML();
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_DaftarAbsen_Lemburan.jrxml");
			$PHPJasperXML->transferDBtoArray($servername,$username,$password,$database);
			$kd_bag_1 = $this->input->post('KD_BAG_1');
			$tgl_1 = date("Y-m-d", strtotime($this->input->post('TGL_1', TRUE)));
			$query = "SELECT hrd_peg.kd_peg AS KD_PEG,
					hrd_peg.nm_peg AS NM_PEG,
					CONCAT(hrd_peg.kd_bag,' - ',hrd_peg.nm_bag) AS BAGIAN,
					'$tgl_1' AS TGL_1,
					hrd_peg.ulembur AS ULEMBUR
				FROM hrd_peg, hrd_bag
				WHERE hrd_peg.kd_bag=hrd_bag.kd_bag 
				AND hrd_peg.aktif='1' 
				AND hrd_peg.kd_bag='$kd_bag_1'
				ORDER BY hrd_peg.kd_peg";
			$result1 = mysqli_query($conn,$query);
			while( $row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array( 
					"TGL" => $row1["TGL"],
					"BAGIAN" => $row1["BAGIAN"],
					"NM_PEG" => $row1["NM_PEG"],
					"ULEMBUR" => $row1["ULEMBUR"],
				));		
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		} else {
			$data = array(
				'KD_BAG_1' => set_value('KD_BAG_1'),
				'TGL_1' => set_value('TGL_1'),
			);
			$data['daftarabsen_lemburan'] = $this->laporan_model->tampil_data_daftarabsen_lemburan()->result();
			$this->load->view('templates_admin/header');
			$this->load->view('templates_admin/navbar');
			$this->load->view('admin/laporan/DaftarAbsen_Lemburan',$data);
			$this->load->view('templates_admin/footer_report');
		}
	}

	public function index_LemburPerBagian_Harian(){
		if (isset($_POST["print"])){
		} else {
			$data = array(
				'KD_BAG_1' => set_value('KD_BAG_1'),
				'TGL_1' => set_value('TGL_1'),
			);
			$data['lemburperbagian_harian'] = $this->laporan_model->tampil_data_lemburperbagian_harian()->result();
			$this->load->view('templates_admin/header');
			$this->load->view('templates_admin/navbar');
			$this->load->view('admin/laporan/LemburPerBagian_Harian',$data);
			$this->load->view('templates_admin/footer_report');
		}
	}

	public function index_LemburPerBagian_Borongan(){
		if (isset($_POST["print"])){
		} else {
			$data = array(
				'KD_BAG_1' => set_value('KD_BAG_1'),
				'TGL_1' => set_value('TGL_1'),
			);
			$data['lemburperbagian_borongan'] = $this->laporan_model->tampil_data_lemburperbagian_borongan()->result();
			$this->load->view('templates_admin/header');
			$this->load->view('templates_admin/navbar');
			$this->load->view('admin/laporan/LemburPerBagian_Borongan',$data);
			$this->load->view('templates_admin/footer_report');
		}
	}

	public function index_LemburPerBagian_PerJam(){
		if (isset($_POST["print"])){
			$CI =& get_instance();
			$CI->load->database();
			$servername = $CI->db->hostname;
			$username = $CI->db->username;
			$password = $CI->db->password;
			$database = $CI->db->database;	
			$conn = mysqli_connect($servername,$username,$password,$database);
			error_reporting(E_ALL);
			ob_start();
			include('phpjasperxml/class/tcpdf/tcpdf.php');
			include('phpjasperxml/class/PHPJasperXML.inc.php');
			include('phpjasperxml/setting.php');
			$PHPJasperXML = new \PHPJasperXML();
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_LemburBagian_PerJam.jrxml");
			$PHPJasperXML->transferDBtoArray($servername,$username,$password,$database);
			$kd_bag_1 = $this->input->post('KD_BAG_1');
			$tgl_1 = date("Y-m-d", strtotime($this->input->post('TGL_1', TRUE)));
			$query = "SELECT hrd_lem.tgl AS TGL,
					hrd_lem.per AS PER,
					hrd_lem.kd_grup AS KD_GRUP,
					hrd_lem.nm_grup AS NM_GRUP,

					hrd_lemd.rec AS REC,
					hrd_lemd.kd_bag AS KD_BAG,
					hrd_lemd.nm_bag AS NM_BAG,
					'-' AS JENIS,
					'-' AS ACNO,
					hrd_lemd.nm_peg AS NM_PEG,
					hrd_lemd.ulembur AS NETT
				FROM hrd_lem, hrd_lemd, hrd_bag
				WHERE hrd_lemd.kd_bag=hrd_bag.kd_bag 
				AND hrd_lemd.kd_bag='$kd_bag_1'
				AND hrd_lemd.tgl='$tgl_1'
				AND hrd_lemd.flag='PJ'
				ORDER BY hrd_lemd.kd_peg";
			$result1 = mysqli_query($conn,$query);
			while( $row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array( 
					"TGL" => $row1["TGL"],
					"PER" => $row1["PER"],
					"KD_GRUP" => $row1["KD_GRUP"],
					"NM_GRUP" => $row1["NM_GRUP"],
					"REC" => $row1["REC"],
					"KD_BAG" => $row1["KD_BAG"],
					"NM_BAG" => $row1["NM_BAG"],
					"JENIS" => $row1["JENIS"],
					"ACNO" => $row1["ACNO"],
					"NM_PEG" => $row1["NM_PEG"],
					"NETT" => $row1["NETT"],
				));		
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		} else {
			$data = array(
				'KD_BAG_1' => set_value('KD_BAG_1'),
				'TGL_1' => set_value('TGL_1'),
			);
			$data['lemburperbagian_perjam'] = $this->laporan_model->tampil_data_lemburperbagian_perjam()->result();
			$this->load->view('templates_admin/header');
			$this->load->view('templates_admin/navbar');
			$this->load->view('admin/laporan/LemburPerBagian_PerJam',$data);
			$this->load->view('templates_admin/footer_report');
		}
	}

	public function index_Gaji_Harian(){
		if (isset($_POST["print"])){
			$CI =& get_instance();
			$CI->load->database();
			$servername = $CI->db->hostname;
			$username = $CI->db->username;
			$password = $CI->db->password;
			$database = $CI->db->database;	
			$conn = mysqli_connect($servername,$username,$password,$database);
			error_reporting(E_ALL);
			ob_start();
			include('phpjasperxml/class/tcpdf/tcpdf.php');
			include('phpjasperxml/class/PHPJasperXML.inc.php');
			include('phpjasperxml/setting.php');
			$PHPJasperXML = new \PHPJasperXML();
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_GajiHarian.jrxml");
			$PHPJasperXML->transferDBtoArray($servername,$username,$password,$database);
			$kd_bag_1 = $this->input->post('KD_BAG_1');
			$kd_bag_2 = $this->input->post('KD_BAG_2');
			$per = $this->session->userdata['periode'];
			$query = " SELECT hrd_absen.per AS PER,
					hrd_absen.no_bukti AS NO_BUKTI,
					hrd_absen.nm_bag AS NM_BAG,
					hrd_absen.kd_bag AS KD_BAG,
					CONCAT(hrd_absen.kd_bag,' - ',hrd_absen.nm_bag) AS BAGIAN,
					CONCAT(hrd_absen.kd_grup,' - ',hrd_absen.nm_grup) AS GRUP,
					CONCAT(hrd_absend.kd_peg,' - ',hrd_absend.nm_peg) AS PEGAWAI,

					hrd_absend.nm_peg AS NM_PEG,
					hrd_absend.ptkp AS PTKP,
					hrd_absend.hr AS HR,
					(hrd_absend.gaji * hrd_absend.hr) AS GAJI,
					(hrd_absend.lain * hrd_absend.hr) AS LB,
					(hrd_absend.jam1 + hrd_absend.jam1rp) AS LEM1,
					(hrd_absend.jam2 + hrd_absend.jam2rp) AS LEM2,
					hrd_absend.lain AS LAIN,
					hrd_absend.jumlah AS JUMLAH,
					hrd_absend.rec AS REC,
					hrd_absend.nett AS NETT
				FROM hrd_absen, hrd_absend
				WHERE hrd_absen.per='$per'
				AND hrd_absen.kd_bag BETWEEN '" . $kd_bag_1 . "' AND '" . $kd_bag_2 . "'
				AND hrd_absen.flag='HR'
				ORDER BY hrd_absen.no_bukti, hrd_absend.rec ASC";
			$result1 = mysqli_query($conn,$query);
			while( $row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array( 
					"NM_BAG" => $row1["NM_BAG"],
					"PER" => $row1["PER"],
					"GRUP" => $row1["GRUP"],
					"PTKP" => $row1["PTKP"],
					"KD_BAG" => $row1["KD_BAG"],
					"NO_BUKTI" => $row1["NO_BUKTI"],
					"REC" => $row1["REC"],
					"NM_PEG" => $row1["NM_PEG"],
					"HR" => $row1["HR"],
					"GAJI" => $row1["GAJI"],
					"LB" => $row1["LB"],
					"LEM1" => $row1["LEM1"],
					"LEM2" => $row1["LEM2"],
					"LAIN" => $row1["LAIN"],
					"JUMLAH" => $row1["JUMLAH"],
					"NETT" => $row1["NETT"],
				));		
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		} else {
			$data = array(
				'KD_BAG_1' => set_value('KD_BAG_1'),
				'KD_BAG_2' => set_value('KD_BAG_2'),
				'PER' => set_value('PER'),
			);
			$data['gaji_harian'] = $this->laporan_model->tampil_data_gaji_harian()->result();
			$this->load->view('templates_admin/header');
			$this->load->view('templates_admin/navbar');
			$this->load->view('admin/laporan/Gaji_Harian',$data);
			$this->load->view('templates_admin/footer_report');
		}
	}

	public function index_Karyawan(){
		if (isset($_POST["print"])){
		} else {
			$data = array(
				'KD_PEG_1' => set_value('KD_PEG_1'),
				'KD_PEG_2' => set_value('KD_PEG_2'),
			);
			$data['karyawan'] = $this->laporan_model->tampil_data_karyawan()->result();
			$this->load->view('templates_admin/header');
			$this->load->view('templates_admin/navbar');
			$this->load->view('admin/laporan/Karyawan',$data);
			$this->load->view('templates_admin/footer_report');
		}
	}

	public function index_Gaji_Borongan(){
		if (isset($_POST["print"])){
			$CI =& get_instance();
			$CI->load->database();
			$servername = $CI->db->hostname;
			$username = $CI->db->username;
			$password = $CI->db->password;
			$database = $CI->db->database;	
			$conn = mysqli_connect($servername,$username,$password,$database);
			error_reporting(E_ALL);
			ob_start();
			include('phpjasperxml/class/tcpdf/tcpdf.php');
			include('phpjasperxml/class/PHPJasperXML.inc.php');
			include('phpjasperxml/setting.php');
			$PHPJasperXML = new \PHPJasperXML();
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_GajiBorongan.jrxml");
			$PHPJasperXML->transferDBtoArray($servername,$username,$password,$database);
			$kd_bag_1 = $this->input->post('KD_BAG_1');
			$kd_bag_2 = $this->input->post('KD_BAG_2');
			$bulan = substr($this->input->post('PER'),0,2);
			$tahun = substr($this->input->post('PER'),-4);
			$per = $tahun.$bulan;
			$query = " SELECT hrd_absen.per AS PER,
					hrd_absen.no_bukti AS NO_BUKTI,
					CONCAT(hrd_absen.kd_bag,' - ',hrd_absen.nm_bag) AS BAGIAN,
					CONCAT(hrd_absen.kd_grup,' - ',hrd_absen.nm_grup) AS GRUP,
					CONCAT(hrd_absend.kd_peg,' - ',hrd_absend.nm_peg) AS PEGAWAI,

					hrd_absend.rec AS REC,
					hrd_absend.kd_bag AS KD_BAG,
					hrd_absend.nm_bag AS NM_BAG,
					hrd_absend.kd_peg AS KD_PEG,
					hrd_absend.nm_peg AS NM_PEG,
					hrd_absend.hr AS HR,
					hrd_absend.gaji AS GAJI,
					hrd_absend.lain AS LAIN,
					hrd_absend.tperbulan AS TPERBULAN,
					(hrd_absend.jam1rp+hrd_absend.jam2rp) AS TOTAL_LEMBUR,
					hrd_absend.nett AS NETT,
					hrd_absend.jumlah AS JUMLAH
				FROM hrd_absen, hrd_absend
				WHERE CONCAT(RIGHT(hrd_absen.per,4),left(hrd_absen.per,2))<='$per'
				AND hrd_absen.kd_bag BETWEEN '" . $kd_bag_1 . "' AND '" . $kd_bag_2 . "'
				AND hrd_absen.flag='BR'
				ORDER BY hrd_absen.no_bukti, hrd_absend.rec ASC";
			$result1 = mysqli_query($conn,$query);
			while( $row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array( 
					"NM_BAG" => $row1["NM_BAG"],
					"PER" => $row1["PER"],
					"GRUP" => $row1["GRUP"],
					"PTKP" => $row1["PTKP"],
					"KD_BAG" => $row1["KD_BAG"],
					"NO_BUKTI" => $row1["NO_BUKTI"],
					"REC" => $row1["REC"],
					"NM_PEG" => $row1["NM_PEG"],
					"HR" => $row1["HR"],
					"GAJI" => $row1["GAJI"],
					"LB" => $row1["LB"],
					"LEM1" => $row1["LEM1"],
					"LEM2" => $row1["LEM2"],
					"LAIN" => $row1["LAIN"],
					"JUMLAH" => $row1["JUMLAH"],
					"NETT" => $row1["NETT"],
				));		
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		} else {
			$data = array(
				'KD_BAG_1' => set_value('KD_BAG_1'),
				'KD_BAG_2' => set_value('KD_BAG_2'),
				'PER' => set_value('PER'),
			);
			$data['gaji_borongan'] = $this->laporan_model->tampil_data_gaji_borongan()->result();
			$this->load->view('templates_admin/header');
			$this->load->view('templates_admin/navbar');
			$this->load->view('admin/laporan/Gaji_Borongan',$data);
			$this->load->view('templates_admin/footer_report');
		}
	}

	public function index_Gaji_HarianPerGrup(){
		if (isset($_POST["print"])){
		} else {
			$data = array(
				'KD_GRUP_1' => set_value('KD_GRUP_1'),
				'KD_GRUP_2' => set_value('KD_GRUP_2'),
				'PER' => set_value('PER'),
			);
			$data['gaji_harianpergrup'] = $this->laporan_model->tampil_data_gaji_harianpergrup()->result();
			$this->load->view('templates_admin/header');
			$this->load->view('templates_admin/navbar');
			$this->load->view('admin/laporan/Gaji_HarianPerGrup',$data);
			$this->load->view('templates_admin/footer_report');
		}
	}

	public function index_Gaji_BoronganPerGrup(){
		if (isset($_POST["print"])){
		} else {
			$data = array(
				'KD_GRUP_1' => set_value('KD_GRUP_1'),
				'KD_GRUP_2' => set_value('KD_GRUP_2'),
				'PER' => set_value('PER'),
			);
			$data['gaji_boronganpergrup'] = $this->laporan_model->tampil_data_gaji_boronganpergrup()->result();
			$this->load->view('templates_admin/header');
			$this->load->view('templates_admin/navbar');
			$this->load->view('admin/laporan/Gaji_BoronganPerGrup',$data);
			$this->load->view('templates_admin/footer_report');
		}
	}

	public function index_KIK_PerBagian(){
		if (isset($_POST["print"])){
			$CI =& get_instance();
			$CI->load->database();
			$servername = $CI->db->hostname;
			$username = $CI->db->username;
			$password = $CI->db->password;
			$database = $CI->db->database;	
			$conn = mysqli_connect($servername,$username,$password,$database);
			error_reporting(E_ALL);
			ob_start();
			include('phpjasperxml/class/tcpdf/tcpdf.php');
			include('phpjasperxml/class/PHPJasperXML.inc.php');
			include('phpjasperxml/setting.php');
			$PHPJasperXML = new \PHPJasperXML();
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_KikPerBagian.jrxml");
			$PHPJasperXML->transferDBtoArray($servername,$username,$password,$database);
			$kd_bag_1 = $this->input->post('KD_BAG_1');
			$kd_bag_2 = $this->input->post('KD_BAG_2');
			$tgl_1 = date("Y-m-d", strtotime($this->input->post('TGL_1', TRUE)));
			$tgl_2 = date("Y-m-d", strtotime($this->input->post('TGL_2', TRUE)));
			$query = "	SELECT *,ROUND(hasil - (1 / 100 * hasil),3) GT FROM (
					SELECT CONCAT(hrd_kik.kd_bag,' - ',hrd_kik.nm_bag) AS BAGIAN,
					hrd_kik.kd_bag AS KD_BAG,
					hrd_kik.nm_bag AS NM_BAG,
					hrd_kik.no_bukti AS NO_BUKTI,
					hrd_kik.flag AS FLAG,
					hrd_kik.tqty AS TQTY,
					hrd_kik.tjumlah AS TJUMLAH,
					'-' AS TUPAH,
					hrd_kik.tsub AS TSUB,
					hrd_kik.gt AS GT,

					hrd_kikd.rec AS REC,
					hrd_kikd.no_kik AS NO_KIK,
					hrd_kikd.tgl_kik AS TGL_KIK,
					hrd_kikd.model AS MODEL,
					hrd_kikd.qty AS QTY,
					hrd_kikd.upah AS UPAH,
					hrd_kikd.org AS ORG,
					hrd_kikd.jumlah AS JUMLAH,
					hrd_kikd.sub AS SUB,

					'-' AS KASI,
					'-' AS KABAG,
					'-' AS MAINT1,

					ROUND(1 / 100 * hrd_kik.tjumlah,3) AS hasil
				FROM hrd_kik, hrd_kikd
				WHERE hrd_kik.no_bukti=hrd_kikd.no_bukti 
				AND hrd_kik.kd_bag BETWEEN '" . $kd_bag_1 . "' AND '" . $kd_bag_2 . "'
				AND hrd_kikd.tgl_kik BETWEEN '" . $tgl_1 . "' AND '" . $tgl_2 . "'
				ORDER BY hrd_kik.flag, hrd_kik.kd_bag, hrd_kik.no_bukti, hrd_kikd.tgl_kik ) AA";
			$result1 = mysqli_query($conn,$query);
			while( $row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"REC" => $row1["REC"],
					"BAGIAN" => $row1["BAGIAN"],
					"KD_BAG" => $row1["KD_BAG"],
					"NM_BAG" => $row1["NM_BAG"],
					"NO_BUKTI" => $row1["NO_BUKTI"],
					"FLAG" => $row1["FLAG"],
					"TQTY" => $row1["TQTY"],
					"TUPAH" => $row1["TUPAH"],
					"TJUMLAH" => $row1["TJUMLAH"],
					"TSUB" => $row1["TSUB"],
					"NO_KIK" => $row1["NO_KIK"],
					"TGL_KIK" => $row1["TGL_KIK"],
					"MODEL" => $row1["MODEL"],
					"QTY" => $row1["QTY"],
					"UPAH" => $row1["UPAH"],
					"ORG" => $row1["ORG"],
					"JUMLAH" => $row1["JUMLAH"],
					"SUB" => $row1["SUB"],
					"KASI" => $row1["KASI"],
					"KABAG" => $row1["KABAG"],
					"MAINT1" => $row1["MAINT1"],
					"hasil" => $row1["hasil"],
					"GT" => $row1["GT"],
				));		
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		} else {
			$data = array(
				'KD_BAG_1' => set_value('KD_BAG_1'),
				'KD_BAG_2' => set_value('KD_BAG_2'),
				'TGL_1' => set_value('TGL_1'),
				'TGL_2' => set_value('TGL_2'),
			);
			$data['kik_perbagian'] = $this->laporan_model->tampil_data_kik_perbagian()->result();
			$this->load->view('templates_admin/header');
			$this->load->view('templates_admin/navbar');
			$this->load->view('admin/laporan/KIK_PerBagian',$data);
			$this->load->view('templates_admin/footer_report');
		}
	}

	public function index_KIK_PerPeriode(){
		if (isset($_POST["print"])){
		} else {
			$data = array(
				'KD_BAG_1' => set_value('KD_BAG_1'),
				'PER' => set_value('PER'),
			);
			$data['kik_perperiode'] = $this->laporan_model->tampil_data_kik_perperiode()->result();
			$this->load->view('templates_admin/header');
			$this->load->view('templates_admin/navbar');
			$this->load->view('admin/laporan/KIK_PerPeriode',$data);
			$this->load->view('templates_admin/footer_report');
		}
	}

	public function index_Insentif_PerBagian(){
		if (isset($_POST["print"])){
			$CI =& get_instance();
			$CI->load->database();
			$servername = $CI->db->hostname;
			$username = $CI->db->username;
			$password = $CI->db->password;
			$database = $CI->db->database;	
			$conn = mysqli_connect($servername,$username,$password,$database);
			error_reporting(E_ALL);
			ob_start();
			include('phpjasperxml/class/tcpdf/tcpdf.php');
			include('phpjasperxml/class/PHPJasperXML.inc.php');
			include('phpjasperxml/setting.php');
			$PHPJasperXML = new \PHPJasperXML();
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_Insentif_PerBagian.jrxml");
			$PHPJasperXML->transferDBtoArray($servername,$username,$password,$database);
			$kd_bag_1 = $this->input->post('KD_BAG_1');
			$kd_bag_2 = $this->input->post('KD_BAG_2');
			$bulan = substr($this->input->post('PER'),0,2);
			$tahun = substr($this->input->post('PER'),-4);
			$per = $tahun.$bulan;
			$query = "SELECT hrd_absen.per AS PER, 
					hrd_absen.no_bukti AS NO_BUKTI, 
					hrd_absen.flag AS FLAG, 
					CONCAT(hrd_absen.kd_bag,' - ',hrd_absen.nm_bag) AS BAGIAN,
					CONCAT(hrd_absen.kd_grup,' - ',hrd_absen.nm_grup) AS GRUP,
					CONCAT(hrd_absend.kd_peg,' - ',hrd_absend.nm_peg) AS PEGAWAI,
					hrd_absend.nm_peg AS NM_PEG,
					hrd_absend.tperbulan AS TPERBULAN
				FROM hrd_absen, hrd_absend
				WHERE hrd_absen.no_bukti=hrd_absend.no_bukti 
				AND CONCAT(RIGHT(hrd_absen.per,4),left(hrd_absen.per,2))<='$per'
				AND hrd_absen.kd_bag BETWEEN '" . $kd_bag_1 . "' AND '" . $kd_bag_2 . "'
				ORDER BY hrd_absen.flag, hrd_absen.kd_bag, hrd_absend.rec";
			$result1 = mysqli_query($conn,$query);
			while( $row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array( 
					"NM_PEG" => $row1["NM_PEG"],
				));		
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		} else {
			$data = array(
				'KD_BAG_1' => set_value('KD_BAG_1'),
				'KD_BAG_2' => set_value('KD_BAG_2'),
				'PER' => set_value('PER'),
			);
			$data['insentif_perbagian'] = $this->laporan_model->tampil_data_insentif_perbagian()->result();
			$this->load->view('templates_admin/header');
			$this->load->view('templates_admin/navbar');
			$this->load->view('admin/laporan/Insentif_PerBagian',$data);
			$this->load->view('templates_admin/footer_report');
		}
	}

	public function index_Insentif_PerGrup(){
		if (isset($_POST["print"])){
			$CI =& get_instance();
			$CI->load->database();
			$servername = $CI->db->hostname;
			$username = $CI->db->username;
			$password = $CI->db->password;
			$database = $CI->db->database;	
			$conn = mysqli_connect($servername,$username,$password,$database);
			error_reporting(E_ALL);
			ob_start();
			include('phpjasperxml/class/tcpdf/tcpdf.php');
			include('phpjasperxml/class/PHPJasperXML.inc.php');
			include('phpjasperxml/setting.php');
			$PHPJasperXML = new \PHPJasperXML();
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_Insentif_PerGrup.jrxml");
			$PHPJasperXML->transferDBtoArray($servername,$username,$password,$database);
			$kd_grup_1 = $this->input->post('KD_GRUP_1');
			$kd_grup_2 = $this->input->post('KD_GRUP_2');
			$bulan = substr($this->input->post('PER'),0,2);
			$tahun = substr($this->input->post('PER'),-4);
			$per = $tahun.$bulan;
			$query = "SELECT hrd_absen.per AS PER, 
					hrd_absen.no_bukti AS NO_BUKTI, 
					hrd_absen.flag AS FLAG,
					hrd_absen.e_tgl AS TGL,
					hrd_absen.kd_grup AS KD_GRUP,
					hrd_absen.nm_grup AS NM_GRUP,


					hrd_absend.rec AS REC,
					hrd_absend.kd_bag AS KD_BAG,
					hrd_absend.nm_bag AS NM_BAG,
					'-' AS TYPE,
					'-' AS ACNO,
					hrd_absend.nm_peg AS NM_PEG,
					hrd_absend.gaji AS INSENTIF,
					CONCAT(hrd_absen.kd_bag,' - ',hrd_absen.nm_bag) AS BAGIAN,
					CONCAT(hrd_absen.kd_grup,' - ',hrd_absen.nm_grup) AS GRUP,
					CONCAT(hrd_absend.kd_peg,' - ',hrd_absend.nm_peg) AS PEGAWAI,
					hrd_absend.tperbulan AS TPERBULAN
				FROM hrd_absen, hrd_absend
				WHERE hrd_absen.no_bukti=hrd_absend.no_bukti 
				AND CONCAT(RIGHT(hrd_absen.per,4),left(hrd_absen.per,2))<='$per'
				AND hrd_absen.kd_grup BETWEEN '" . $kd_grup_1 . "' AND '" . $kd_grup_2 . "'
				ORDER BY hrd_absen.flag, hrd_absen.kd_grup";
			$result1 = mysqli_query($conn,$query);
			while( $row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"PER" => $row1["PER"],
					"TGL" => $row1["TGL"],
					"KD_GRUP" => $row1["KD_GRUP"],
					"NM_GRUP" => $row1["NM_GRUP"], 
					"REC" => $row1["REC"],
					"KD_BAG" => $row1["KD_BAG"],
					"NM_BAG" => $row1["NM_BAG"],
					"TYPE" => $row1["TYPE"],
					"ACNO" => $row1["ACNO"],
					"NM_PEG" => $row1["NM_PEG"],
					"INSENTIF" => $row1["INSENTIF"],
				));		
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		} else {
			$data = array(
				'KD_GRUP_1' => set_value('KD_GRUP_1'),
				'KD_GRUP_2' => set_value('KD_GRUP_2'),
				'PER' => set_value('PER'),
			);
			$data['insentif_pergrup'] = $this->laporan_model->tampil_data_insentif_pergrup()->result();
			$this->load->view('templates_admin/header');
			$this->load->view('templates_admin/navbar');
			$this->load->view('admin/laporan/Insentif_PerGrup',$data);
			$this->load->view('templates_admin/footer_report');
		}
	}

	public function index_Tunjangan_Tunjangan(){
		if (isset($_POST["print"])){
		} else {
			$data = array(
				'KD_BAG_1' => set_value('KD_BAG_1'),
				'TGL_1' => set_value('TGL_1'),
			);
			$data['tunjangan_tunjangan'] = $this->laporan_model->tampil_data_tunjangan_tunjangan()->result();
			$this->load->view('templates_admin/header');
			$this->load->view('templates_admin/navbar');
			$this->load->view('admin/laporan/Tunjangan_Tunjangan',$data);
			$this->load->view('templates_admin/footer_report');
		}
	}

	public function index_Tunjangan_NikahMati(){
		if (isset($_POST["print"])){
		} else {
			$data = array(
				'KD_BAG_1' => set_value('KD_BAG_1'),
				'TGL_1' => set_value('TGL_1'),
			);
			$data['tunjangan_nikahmati'] = $this->laporan_model->tampil_data_tunjangan_nikahmati()->result();
			$this->load->view('templates_admin/header');
			$this->load->view('templates_admin/navbar');
			$this->load->view('admin/laporan/Tunjangan_NikahMati',$data);
			$this->load->view('templates_admin/footer_report');
		}
	}

	public function index_Tunjangan_Obat(){
		if (isset($_POST["print"])){
		} else {
			$data = array(
				'KD_BAG_1' => set_value('KD_BAG_1'),
				'TGL_1' => set_value('TGL_1'),
			);
			$data['tunjangan_obat'] = $this->laporan_model->tampil_data_tunjangan_obat()->result();
			$this->load->view('templates_admin/header');
			$this->load->view('templates_admin/navbar');
			$this->load->view('admin/laporan/Tunjangan_Obat',$data);
			$this->load->view('templates_admin/footer_report');
		}
	}

	public function index_Tunjangan_Jasa(){
		if (isset($_POST["print"])){
		} else {
			$data = array(
				'KD_BAG_1' => set_value('KD_BAG_1'),
				'TGL_1' => set_value('TGL_1'),
			);
			$data['tunjangan_jasa'] = $this->laporan_model->tampil_data_tunjangan_jasa()->result();
			$this->load->view('templates_admin/header');
			$this->load->view('templates_admin/navbar');
			$this->load->view('admin/laporan/Tunjangan_Jasa',$data);
			$this->load->view('templates_admin/footer_report');
		}
	}

	public function index_THR_PerBagian(){
		if (isset($_POST["print"])){
			$CI =& get_instance();
			$CI->load->database();
			$servername = $CI->db->hostname;
			$username = $CI->db->username;
			$password = $CI->db->password;
			$database = $CI->db->database;	
			$conn = mysqli_connect($servername,$username,$password,$database);
			error_reporting(E_ALL);
			ob_start();
			include('phpjasperxml/class/tcpdf/tcpdf.php');
			include('phpjasperxml/class/PHPJasperXML.inc.php');
			include('phpjasperxml/setting.php');
			$PHPJasperXML = new \PHPJasperXML();
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_THRPerBagian.jrxml");
			$PHPJasperXML->transferDBtoArray($servername,$username,$password,$database);
			$kd_bag_1 = $this->input->post('KD_BAG_1');
			$kd_bag_2 = $this->input->post('KD_BAG_2');
			$bulan = substr($this->input->post('PER'),0,2);
			$tahun = substr($this->input->post('PER'),-4);
			$per = $tahun.$bulan;
			$query = "SELECT hrd_thr.per AS PER, 
					hrd_thr.no_bukti AS NO_BUKTI, 
					hrd_thr.flag AS FLAG, 
					CONCAT(hrd_thr.kd_bag,' - ',hrd_thr.nm_bag) AS NM_BAG,
					CONCAT(hrd_thr.kd_grup,' - ',hrd_thr.nm_grup) AS GRUP,
					CONCAT(hrd_thrd.kd_peg,' - ',hrd_thrd.nm_peg) AS PEGAWAI,
					hrd_thrd.thr AS JUMLAH,
					hrd_thrd.nm_peg AS NM_PEG,
					hrd_thrd.tot_ms AS TOT_MS
				FROM hrd_thr, hrd_thrd
				WHERE hrd_thr.no_bukti=hrd_thrd.no_bukti 
				AND CONCAT(RIGHT(hrd_thr.per,4),left(hrd_thr.per,2))<='$per'
				AND hrd_thr.kd_bag BETWEEN '" . $kd_bag_1 . "' AND '" . $kd_bag_2 . "'
				ORDER BY hrd_thr.flag, hrd_thr.kd_bag, hrd_thrd.rec";
			$result1 = mysqli_query($conn,$query);
			while( $row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"NM_BAG" => $row1["NM_BAG"],
					"NM_PEG" => $row1["NM_PEG"],
					"TOT_MS" => $row1["TOT_MS"],
					"JUMLAH" => $row1["JUMLAH"],
				));		
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		} else {
			$data = array(
				'KD_BAG_1' => set_value('KD_BAG_1'),
				'KD_BAG_2' => set_value('KD_BAG_2'),
				'PER' => set_value('PER'),
			);
			$data['thr_perbagian'] = $this->laporan_model->tampil_data_thr_perbagian()->result();
			$this->load->view('templates_admin/header');
			$this->load->view('templates_admin/navbar');
			$this->load->view('admin/laporan/THR_PerBagian',$data);
			$this->load->view('templates_admin/footer_report');
		}
	}

	public function index_THR_PerGrup(){
		if (isset($_POST["print"])){
			$CI =& get_instance();
			$CI->load->database();
			$servername = $CI->db->hostname;
			$username = $CI->db->username;
			$password = $CI->db->password;
			$database = $CI->db->database;	
			$conn = mysqli_connect($servername,$username,$password,$database);
			error_reporting(E_ALL);
			ob_start();
			include('phpjasperxml/class/tcpdf/tcpdf.php');
			include('phpjasperxml/class/PHPJasperXML.inc.php');
			include('phpjasperxml/setting.php');
			$PHPJasperXML = new \PHPJasperXML();
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_THRPerGrup.jrxml");
			$PHPJasperXML->transferDBtoArray($servername,$username,$password,$database);
			$kd_grup_1 = $this->input->post('KD_GRUP_1');
			$kd_grup_2 = $this->input->post('KD_GRUP_2');
			$bulan = substr($this->input->post('PER'),0,2);
			$tahun = substr($this->input->post('PER'),-4);
			$per = $tahun.$bulan;
			$query = "SELECT hrd_thr.per AS PER, 
					hrd_thr.no_bukti AS NO_BUKTI, 
					hrd_thr.flag AS FLAG,
					hrd_thr.kd_bag AS KD_BAG,
					hrd_thr.nm_bag AS NM_BAG, 
					CONCAT(hrd_thr.kd_bag,' - ',hrd_thr.nm_bag) AS BAGIAN,
					CONCAT(hrd_thr.kd_grup,' - ',hrd_thr.nm_grup) AS GRUP,
					CONCAT(hrd_thrd.kd_peg,' - ',hrd_thrd.nm_peg) AS PEGAWAI,
					'-' AS JASA,
					hrd_thrd.rec AS REC,
					hrd_thrd.nm_peg AS NM_PEG,
					hrd_thrd.thr AS TOTALD,
					hrd_thrd.tot_ms AS TOT_MS,
					hrd_thrd.tambah AS BRUT
				FROM hrd_thr, hrd_thrd
				WHERE hrd_thr.no_bukti=hrd_thrd.no_bukti 
				AND CONCAT(RIGHT(hrd_thr.per,4),left(hrd_thr.per,2))<='$per'
				AND hrd_thr.kd_grup BETWEEN '" . $kd_grup_1 . "' AND '" . $kd_grup_2 . "'
				ORDER BY hrd_thr.flag, hrd_thr.kd_grup";
			$result1 = mysqli_query($conn,$query);
			while( $row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"KD_BAG" => $row1["KD_BAG"],
					"NM_BAG" => $row1["NM_BAG"],
					"PER" => $row1["PER"],
					"REC" => $row1["REC"],
					"NM_PEG" => $row1["NM_PEG"],
					"TOT_MS" => $row1["TOT_MS"],
					"BRUT" => $row1["BRUT"],
					"JASA" => $row1["JASA"],
					"TOTALD" => $row1["TOTALD"],
				));		
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		} else {
			$data = array(
				'KD_GRUP_1' => set_value('KD_GRUP_1'),
				'KD_GRUP_2' => set_value('KD_GRUP_2'),
				'PER' => set_value('PER'),
			);
			$data['thr_pergrup'] = $this->laporan_model->tampil_data_thr_pergrup()->result();
			$this->load->view('templates_admin/header');
			$this->load->view('templates_admin/navbar');
			$this->load->view('admin/laporan/THR_PerGrup',$data);
			$this->load->view('templates_admin/footer_report');
		}
	}

	public function index_Kurangan(){
		if (isset($_POST["print"])){
		} else {
			$data = array(
				'KD_BAG_1' => set_value('KD_BAG_1'),
				'TGL_1' => set_value('TGL_1'),
			);
			$data['kurangan'] = $this->laporan_model->tampil_data_kurangan()->result();
			$this->load->view('templates_admin/header');
			$this->load->view('templates_admin/navbar');
			$this->load->view('admin/laporan/Kurangan',$data);
			$this->load->view('templates_admin/footer_report');
		}
	}

	public function index_RekapPremi_Staff(){
		if (isset($_POST["print"])){
			$CI =& get_instance();
			$CI->load->database();
			$servername = $CI->db->hostname;
			$username = $CI->db->username;
			$password = $CI->db->password;
			$database = $CI->db->database;	
			$conn = mysqli_connect($servername,$username,$password,$database);
			error_reporting(E_ALL);
			ob_start();
			include('phpjasperxml/class/tcpdf/tcpdf.php');
			include('phpjasperxml/class/PHPJasperXML.inc.php');
			include('phpjasperxml/setting.php');
			$PHPJasperXML = new \PHPJasperXML();
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_RekapPremi_Staff.jrxml");
			$PHPJasperXML->transferDBtoArray($servername,$username,$password,$database);
			$per = $this->session->userdata['periode'];
			$query = "SELECT hrd_premid.per AS PER, 
				hrd_premid.no_bukti AS NO_BUKTI, 
				hrd_premid.flag AS GOL,
				SUM(hrd_premid.wk_manag) AS WK_MANAG1,
				SUM(hrd_premid.ka_qc) AS KA_QC1,
				SUM(hrd_premid.wk_qc) AS WK_QC1,
				SUM(hrd_premid.admin2) AS ADMIN2,
				SUM(hrd_premid.adm) AS ADM1,
				SUM(hrd_premid.kaprod) AS KAPROD1,
				SUM(hrd_premid.kamaint) AS KAMAINT1
			FROM hrd_premid
			WHERE hrd_premid.per='$per'
			GROUP BY hrd_premid.flag
			ORDER BY hrd_premid.flag, hrd_premid.kd_bag";
			$result1 = mysqli_query($conn,$query);
			while( $row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"PER" => $row1["PER"],
					"GOL" => $row1["GOL"],
					"WK_MANAG1" => $row1["WK_MANAG1"],
					"KA_QC1" => $row1["KA_QC1"],
					"WK_QC1" => $row1["WK_QC1"],
					"ADMIN2" => $row1["ADMIN2"],
					"ADM1" => $row1["ADM1"],
					"KAPROD1" => $row1["KAPROD1"],
					"KAMAINT1" => $row1["KAMAINT1"],
				));		
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		} else {
			$data = array(
				'PER' => set_value('PER'),
			);
			$data['rekappremi_staff'] = $this->laporan_model->tampil_data_rekappremi_staff()->result();
			$this->load->view('templates_admin/header');
			$this->load->view('templates_admin/navbar');
			$this->load->view('admin/laporan/RekapPremi_Staff',$data);
			$this->load->view('templates_admin/footer_report');
		}
	}

	public function index_RekapPremi_PerDevisi(){
		if (isset($_POST["print"])){
			$CI =& get_instance();
			$CI->load->database();
			$servername = $CI->db->hostname;
			$username = $CI->db->username;
			$password = $CI->db->password;
			$database = $CI->db->database;	
			$conn = mysqli_connect($servername,$username,$password,$database);
			error_reporting(E_ALL);
			ob_start();
			include('phpjasperxml/class/tcpdf/tcpdf.php');
			include('phpjasperxml/class/PHPJasperXML.inc.php');
			include('phpjasperxml/setting.php');
			$PHPJasperXML = new \PHPJasperXML();
			$PHPJasperXML->load_xml_file("phpjasperxml/Laporan_RekapPremi_PerDevisi.jrxml");
			$PHPJasperXML->transferDBtoArray($servername,$username,$password,$database);
			$per = $this->session->userdata['periode'];
			$query ="SELECT hrd_premid.per AS PER, 
					hrd_premid.flag AS FLAG,
					hrd_bag.nm_grup AS GRUP, 
					hrd_bag.nm_kasi AS NAMA, 
					hrd_bag.kd_kasi AS JABATAN, 
					(hrd_premid.kasi) AS P01,
					(hrd_premid.maint1) AS P02,
					(hrd_premid.maint2) AS P03,
					(hrd_premid.kabag) AS P04,
					(hrd_premid.qc1) AS P05,
					(hrd_premid.qc2) AS P06,
					(hrd_premid.admin1) AS P07,
					(hrd_premid.admin2) AS P08,
					(hrd_premid.wk_manag) AS P09,
					(hrd_premid.ka_qc) AS P10,
					(hrd_premid.wk_qc) AS P11,
					(hrd_premid.adm) AS P12,
					(hrd_premid.manag) AS P13,
					(hrd_premid.kaprod) AS P14,
					(hrd_premid.kamaint) AS P15,
					(hrd_premid.ksmaint) AS P16,
					(hrd_premid.kagrup) AS P17,
					(hrd_premid.ksmesin) AS P18,
					(kasi+maint1+maint2+kabag+qc1+qc2+admin1+admin2+wk_manag+ka_qc+wk_qc+adm+manag+kaprod+kamaint+ksmaint+kagrup+ksmesin) AS T_PREMI
				FROM hrd_premid, hrd_premi, hrd_bag
				WHERE hrd_premid.per='$per'
				GROUP BY hrd_premid.kd_bag
				ORDER BY hrd_premid.flag, hrd_premid.kd_bag";
			$result1 = mysqli_query($conn,$query);
			while( $row1 = mysqli_fetch_assoc($result1)) {
				array_push($PHPJasperXML->arraysqltable, array(
					"PER" => $row1["PER"],
					"GRUP" => $row1["GRUP"],
					"NAMA" => $row1["NAMA"],
					"JABATAN" => $row1["JABATAN"],
					"P01" => $row1["P01"],
					"P02" => $row1["P02"],
					"P03" => $row1["P03"],
					"P04" => $row1["P04"],
					"P05" => $row1["P05"],
					"P06" => $row1["P06"],
					"P07" => $row1["P07"],
					"P08" => $row1["P08"],
					"P09" => $row1["P09"],
					"P10" => $row1["P10"],
					"P11" => $row1["P11"],
					"P12" => $row1["P12"],
					"P13" => $row1["P13"],
					"P14" => $row1["P14"],
					"P15" => $row1["P15"],
					"P16" => $row1["P16"],
					"P17" => $row1["P17"],
					"P18" => $row1["P18"],
					"T_PREMI" => $row1["T_PREMI"],
				));		
			}
			ob_end_clean();
			$PHPJasperXML->outpage("I");
		} else {
			$data = array(
				'PER' => set_value('PER'),
			);
			$data['rekappremi_perdevisi'] = $this->laporan_model->tampil_data_rekappremi_perdevisi()->result();
			$this->load->view('templates_admin/header');
			$this->load->view('templates_admin/navbar');
			$this->load->view('admin/laporan/RekapPremi_PerDevisi',$data);
			$this->load->view('templates_admin/footer_report');
		}
	}

	public function index_RekapPremi_Inject(){
		if (isset($_POST["print"])){
		} else {
			$data = array(
				'PER' => set_value('PER'),
			);
			$data['rekappremi_inject'] = $this->laporan_model->tampil_data_rekappremi_inject()->result();
			$this->load->view('templates_admin/header');
			$this->load->view('templates_admin/navbar');
			$this->load->view('admin/laporan/RekapPremi_Inject',$data);
			$this->load->view('templates_admin/footer_report');
		}
	}

//////		AJAX GLOBAL		/////

	public function getData_master_bagian_1() {
		$dr = $this->session->userdata['dr'];
		$search = $this->input->post('search');
		$page = ((int)$this->input->post('page'));
		if ($page == 0) {
			$xa = 0;
		} else {
			$xa = ($page - 1) * 10;
		}
		$perPage = 10;
		$results = $this->db->query("SELECT no_id as NO_ID, kd_bag as KD_BAG_1, nm_bag as NM_BAG_1, dr as DR_1
			FROM hrd_bag
			WHERE dr='$dr' AND (kd_bag LIKE '%$search%' OR nm_bag LIKE '%$search%' OR dr LIKE '%$search%')
			GROUP BY kd_bag
			ORDER BY no_id LIMIT $xa,$perPage");
		$selectajax = array();
		foreach ($results->RESULT_ARRAY() as $row) {
			$selectajax[] = array(
				'id' => $row['KD_BAG_1'],
				'text' => $row['KD_BAG_1'] . " - " . $row['NM_BAG_1'] . " - " . $row['DR_1']
			);
		}
		$select['total_count'] =  $results->NUM_ROWS();
		$select['items'] = $selectajax;
		$this->output->set_content_type('application/json')->set_output(json_encode($select));
	}


	public function getData_master_bagian_2() {
		$dr = $this->session->userdata['dr'];
		$search = $this->input->post('search');
		$page = ((int)$this->input->post('page'));
		if ($page == 0) {
			$xa = 0;
		} else {
			$xa = ($page - 1) * 10;
		}
		$perPage = 10;
		$results = $this->db->query("SELECT no_id as NO_ID, kd_bag as KD_BAG_2, nm_bag as NM_BAG_2, dr as DR_2
			FROM hrd_bag
			WHERE dr='$dr' AND (kd_bag LIKE '%$search%' OR nm_bag LIKE '%$search%' OR dr LIKE '%$search%')
			GROUP BY kd_bag
			ORDER BY no_id LIMIT $xa,$perPage");
		$selectajax = array();
		foreach ($results->RESULT_ARRAY() as $row) {
			$selectajax[] = array(
				'id' => $row['KD_BAG_2'],
				'text' => $row['KD_BAG_2'] . " - " . $row['NM_BAG_2'] . " - " . $row['DR_2']
			);
		}
		$select['total_count'] =  $results->NUM_ROWS();
		$select['items'] = $selectajax;
		$this->output->set_content_type('application/json')->set_output(json_encode($select));
	}

	public function getData_master_grup_1() {
		$dr = $this->session->userdata['dr'];
		$search = $this->input->post('search');
		$page = ((int)$this->input->post('page'));
		if ($page == 0) {
			$xa = 0;
		} else {
			$xa = ($page - 1) * 10;
		}
		$perPage = 10;
		$results = $this->db->query("SELECT no_id as NO_ID, kd_grup as KD_GRUP_1, nm_grup as NM_GRUP_1
			FROM hrd_grup
			WHERE kd_grup LIKE '%$search%' OR nm_grup LIKE '%$search%'
			ORDER BY no_id LIMIT $xa,$perPage");
		$selectajax = array();
		foreach ($results->RESULT_ARRAY() as $row) {
			$selectajax[] = array(
				'id' => $row['KD_GRUP_1'],
				'text' => $row['KD_GRUP_1'] . " - " . $row['NM_GRUP_1']
			);
		}
		$select['total_count'] =  $results->NUM_ROWS();
		$select['items'] = $selectajax;
		$this->output->set_content_type('application/json')->set_output(json_encode($select));
	}

	public function getData_master_grup_2() {
		$dr = $this->session->userdata['dr'];
		$search = $this->input->post('search');
		$page = ((int)$this->input->post('page'));
		if ($page == 0) {
			$xa = 0;
		} else {
			$xa = ($page - 1) * 10;
		}
		$perPage = 10;
		$results = $this->db->query("SELECT no_id as NO_ID, kd_grup as KD_GRUP_2, nm_grup as NM_GRUP_2
			FROM hrd_grup
			WHERE kd_grup LIKE '%$search%' OR nm_grup LIKE '%$search%'
			ORDER BY no_id LIMIT $xa,$perPage");
		$selectajax = array();
		foreach ($results->RESULT_ARRAY() as $row) {
			$selectajax[] = array(
				'id' => $row['KD_GRUP_2'],
				'text' => $row['KD_GRUP_2'] . " - " . $row['NM_GRUP_2']
			);
		}
		$select['total_count'] =  $results->NUM_ROWS();
		$select['items'] = $selectajax;
		$this->output->set_content_type('application/json')->set_output(json_encode($select));
	}

	public function getData_master_pegawai_1() {
		$dr = $this->session->userdata['dr'];
		$search = $this->input->post('search');
		$page = ((int)$this->input->post('page'));
		if ($page == 0) {
			$xa = 0;
		} else {
			$xa = ($page - 1) * 10;
		}
		$perPage = 10;
		$results = $this->db->query("SELECT no_id as NO_ID, kd_peg as KD_PEG_1, nm_peg as NM_PEG_1
			FROM hrd_peg
			WHERE kd_peg LIKE '%$search%' OR nm_peg LIKE '%$search%'
			ORDER BY no_id LIMIT $xa,$perPage");
		$selectajax = array();
		foreach ($results->RESULT_ARRAY() as $row) {
			$selectajax[] = array(
				'id' => $row['KD_PEG_1'],
				'text' => $row['KD_PEG_1'] . " - " . $row['NM_PEG_1']
			);
		}
		$select['total_count'] =  $results->NUM_ROWS();
		$select['items'] = $selectajax;
		$this->output->set_content_type('application/json')->set_output(json_encode($select));
	}

	public function getData_master_pegawai_2() {
		$dr = $this->session->userdata['dr'];
		$search = $this->input->post('search');
		$page = ((int)$this->input->post('page'));
		if ($page == 0) {
			$xa = 0;
		} else {
			$xa = ($page - 1) * 10;
		}
		$perPage = 10;
		$results = $this->db->query("SELECT no_id as NO_ID, kd_peg as KD_PEG_2, nm_peg as NM_PEG_2
			FROM hrd_peg
			WHERE kd_peg LIKE '%$search%' OR nm_peg LIKE '%$search%'
			ORDER BY no_id LIMIT $xa,$perPage");
		$selectajax = array();
		foreach ($results->RESULT_ARRAY() as $row) {
			$selectajax[] = array(
				'id' => $row['KD_PEG_2'],
				'text' => $row['KD_PEG_2'] . " - " . $row['NM_PEG_2']
			);
		}
		$select['total_count'] =  $results->NUM_ROWS();
		$select['items'] = $selectajax;
		$this->output->set_content_type('application/json')->set_output(json_encode($select));
	}

//////		BATAS AJAX GLOBAL		/////

}