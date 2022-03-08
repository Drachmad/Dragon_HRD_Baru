<?php

class Laporan_model extends CI_Model
{

	public function tampil_data_daftarabsen_absen()
	{
		$per = $this->session->userdata['periode'];
		$kd_bag_1 = $this->input->post('KD_BAG_1');
		$q1 = "SELECT hrd_peg.kd_peg AS KD_PEG,
				hrd_peg.nm_peg AS NM_PEG,
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
		return $this->db->query($q1);
	}

	public function tampil_data_daftarabsen_lemburan()
	{
		$kd_bag_1 = $this->input->post('KD_BAG_1');
		$tgl_1 = date("Y-m-d", strtotime($this->input->post('TGL_1', TRUE)));
		$q1 = "SELECT hrd_peg.kd_peg AS KD_PEG,
				hrd_peg.nm_peg AS NM_PEG,
				CONCAT(hrd_peg.kd_bag,' - ',hrd_peg.nm_bag) AS BAGIAN,
				'$tgl_1' AS TGL,
				hrd_peg.ulembur AS ULEMBUR
			FROM hrd_peg, hrd_bag
			WHERE hrd_peg.kd_bag=hrd_bag.kd_bag 
			AND hrd_peg.aktif='1' 
			AND hrd_peg.kd_bag='$kd_bag_1'
			ORDER BY hrd_peg.kd_peg";
		return $this->db->query($q1);
	}

	public function tampil_data_lemburperbagian_harian()
	{
		$kd_bag_1 = $this->input->post('KD_BAG_1');
		$tgl_1 = date("Y-m-d", strtotime($this->input->post('TGL_1', TRUE)));
		$q1 = "SELECT hrd_lemd.nm_peg AS NM_PEG,
				hrd_lemd.no_bukti AS NO_BUKTI,
				CONCAT(hrd_lemd.kd_peg,' - ',hrd_lemd.nm_peg) AS PEGAWAI,
				CONCAT(hrd_lemd.kd_bag,' - ',hrd_lemd.nm_bag) AS BAGIAN,
				hrd_lemd.tgl AS TGL,
				hrd_lemd.ulembur AS ULEMBUR
			FROM hrd_lemd, hrd_bag
			WHERE hrd_lemd.kd_bag=hrd_bag.kd_bag
			AND hrd_lemd.kd_bag='$kd_bag_1'
			AND hrd_lemd.tgl='$tgl_1'
			AND hrd_lemd.flag='HR'
			ORDER BY hrd_lemd.kd_peg";
		return $this->db->query($q1);
	}

	public function tampil_data_lemburperbagian_borongan()
	{
		$kd_bag_1 = $this->input->post('KD_BAG_1');
		$tgl_1 = date("Y-m-d", strtotime($this->input->post('TGL_1', TRUE)));
		$q1 = "SELECT hrd_lemd.nm_peg AS NM_PEG,
				hrd_lemd.no_bukti AS NO_BUKTI,
				CONCAT(hrd_lemd.kd_peg,' - ',hrd_lemd.nm_peg) AS PEGAWAI,
				CONCAT(hrd_lemd.kd_bag,' - ',hrd_lemd.nm_bag) AS BAGIAN,
				hrd_lemd.tgl AS TGL,
				hrd_lemd.ulembur AS ULEMBUR
			FROM hrd_lemd, hrd_bag
			WHERE hrd_lemd.kd_bag=hrd_bag.kd_bag 
			AND hrd_lemd.kd_bag='$kd_bag_1'
			AND hrd_lemd.tgl='$tgl_1'
			AND hrd_lemd.flag='BR'
			ORDER BY hrd_lemd.kd_peg";
		return $this->db->query($q1);
	}

	public function tampil_data_lemburperbagian_perjam()
	{
		$kd_bag_1 = $this->input->post('KD_BAG_1');
		$tgl_1 = date("Y-m-d", strtotime($this->input->post('TGL_1', TRUE)));
		$q1 = "SELECT hrd_lemd.nm_peg AS NM_PEG,
				hrd_lemd.no_bukti AS NO_BUKTI,
				CONCAT(hrd_lemd.kd_peg,' - ',hrd_lemd.nm_peg) AS PEGAWAI,
				CONCAT(hrd_lemd.kd_bag,' - ',hrd_lemd.nm_bag) AS BAGIAN,
				hrd_lemd.tgl AS TGL,
				hrd_lemd.ulembur AS ULEMBUR
			FROM hrd_lemd, hrd_bag
			WHERE hrd_lemd.kd_bag=hrd_bag.kd_bag 
			AND hrd_lemd.kd_bag='$kd_bag_1'
			AND hrd_lemd.tgl='$tgl_1'
			AND hrd_lemd.flag='PJ'
			ORDER BY hrd_lemd.kd_peg";
		return $this->db->query($q1);
	}

	public function tampil_data_gaji_harian()
	{
		$kd_bag_1 = $this->input->post('KD_BAG_1');
		$kd_bag_2 = $this->input->post('KD_BAG_2');
		$per = $this->session->userdata['periode'];
		$q1 = " SELECT hrd_absen.per AS PER,
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
			WHERE hrd_absen.per='$per'
			AND hrd_absen.kd_bag BETWEEN '" . $kd_bag_1 . "' AND '" . $kd_bag_2 . "'
			AND hrd_absen.flag='HR'
			ORDER BY hrd_absen.no_bukti, hrd_absend.rec ASC";
		return $this->db->query($q1);
	}

	public function tampil_data_karyawan()
	{
		$kd_peg_1 = $this->input->post('KD_PEG_1');
		$kd_peg_2 = $this->input->post('KD_PEG_2');
		$per = $this->session->userdata['periode'];
		$q1 = "SELECT hrd_peg.no_id AS NO_ID,
				hrd_peg.subdep AS SUBDEP,
				CONCAT(hrd_peg.kd_peg,' - ',hrd_peg.nm_peg) AS PEGAWAI,
				CONCAT(hrd_peg.kd_bag,' - ',hrd_peg.nm_bag) AS BAGIAN,
				hrd_peg.kd_bag AS KD_BAG,
				hrd_peg.kd_peg AS KD_PEG,
				hrd_peg.nm_peg AS NM_PEG
			FROM hrd_peg
			WHERE hrd_peg.kd_peg BETWEEN '$kd_peg_1' AND '$kd_peg_2'
			ORDER BY hrd_peg.kd_peg";
		return $this->db->query($q1);
	}

	public function tampil_data_gaji_borongan()
	{
		$kd_bag_1 = $this->input->post('KD_BAG_1');
		$kd_bag_2 = $this->input->post('KD_BAG_2');
		$bulan = substr($this->input->post('PER'), 0, 2);
		$tahun = substr($this->input->post('PER'), -4);
		$per = $tahun . $bulan;
		$q1 = " SELECT hrd_absen.per AS PER,
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
		return $this->db->query($q1);
	}

	public function tampil_data_gaji_rekapgaji()
	{
		$kd_grup_1 = $this->input->post('KD_GRUP_1');
		$kd_grup_2 = $this->input->post('KD_GRUP_2');
		$per_1 = $this->input->post('PER_1');
		$per_2 = $this->input->post('PER_2');
		$tgl_1 = date("Y-m-d", strtotime($this->input->post('TGL_1', TRUE)));
		$tgl_2 = date("Y-m-d", strtotime($this->input->post('TGL_2', TRUE)));
		$q1 = "SELECT hrd_absen.per AS PER,
				CONCAT(hrd_grup.kd_grup,' - ',hrd_grup.nm_grup) AS GRUP,
				CONCAT(hrd_absen.kd_bag,' - ',hrd_absen.nm_bag) AS BAGIAN,
				'HARIAN' AS FLAG,
				hrd_grup.acno AS ACNO,
				hrd_absen.tjumlah AS JUMLAH,
				'0' AS PPH,
				(hrd_absen.tjumlah-'0') AS NETTO
			FROM hrd_absen, hrd_grup
			WHERE hrd_absen.per BETWEEN '" . $per_1 . "' AND '" . $per_2 . "'
			AND hrd_absen.kd_grup=hrd_grup.kd_grup
			AND hrd_absen.kd_grup BETWEEN '" . $kd_grup_1 . "' AND '" . $kd_grup_2 . "'
			ORDER BY hrd_grup.kd_grup, hrd_grup.nm_grup, hrd_absen.kd_bag";
		return $this->db->query($q1);
	}

	public function tampil_data_gaji_boronganpergrup()
	{
		$kd_grup_1 = $this->input->post('KD_GRUP_1');
		$kd_grup_2 = $this->input->post('KD_GRUP_2');
		$bulan = substr($this->input->post('PER'), 0, 2);
		$tahun = substr($this->input->post('PER'), -4);
		$per = $tahun . $bulan;
		$q1 = "SELECT hrd_absen.per AS PER,
				CONCAT(hrd_grup.kd_grup,' - ',hrd_grup.nm_grup) AS GRUP,
				CONCAT(hrd_absen.kd_bag,' - ',hrd_absen.nm_bag) AS BAGIAN,
				'HARIAN' AS FLAG,
				hrd_grup.acno AS ACNO,
				hrd_absen.tjumlah AS JUMLAH,
				'0' AS PPH,
				(hrd_absen.tjumlah-'0') AS NETTO
			FROM hrd_absen, hrd_grup
			WHERE CONCAT(RIGHT(hrd_absen.per,4),left(hrd_absen.per,2))<='$per'
			AND hrd_absen.kd_grup=hrd_grup.kd_grup
			AND hrd_absen.kd_grup BETWEEN '" . $kd_grup_1 . "' AND '" . $kd_grup_2 . "'
			AND hrd_absen.flag='BR'
			ORDER BY hrd_grup.kd_grup, hrd_grup.nm_grup, hrd_absen.kd_bag";
		return $this->db->query($q1);
	}

	public function tampil_data_kik_perbagian()
	{
		$kd_bag_1 = $this->input->post('KD_BAG_1');
		$kd_bag_2 = $this->input->post('KD_BAG_2');
		$tgl_1 = date("Y-m-d", strtotime($this->input->post('TGL_1', TRUE)));
		$tgl_2 = date("Y-m-d", strtotime($this->input->post('TGL_2', TRUE)));
		$q1 = "	SELECT *,ROUND(hasil - (1 / 100 * hasil),2) GT FROM (
			SELECT CONCAT(hrd_kik.kd_bag,' - ',hrd_kik.nm_bag) AS BAGIAN,
			hrd_kik.kd_bag AS KD_BAG,
			hrd_kik.nm_bag AS NM_BAG,
			hrd_kik.no_bukti AS NO_BUKTI,
			hrd_kik.flag AS FLAG,
			hrd_kik.tqty AS TQTY,
			hrd_kik.tjumlah AS TJUMLAH,
			hrd_kik.tsub AS TSUB,
			hrd_kik.gt AS GT,

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

			ROUND(1 / 100 * hrd_kik.tjumlah,2) AS hasil
		FROM hrd_kik, hrd_kikd
		WHERE hrd_kik.no_bukti=hrd_kikd.no_bukti 
		AND hrd_kik.kd_bag BETWEEN '" . $kd_bag_1 . "' AND '" . $kd_bag_2 . "'
		AND hrd_kikd.tgl_kik BETWEEN '" . $tgl_1 . "' AND '" . $tgl_2 . "'
		ORDER BY hrd_kik.flag, hrd_kik.kd_bag, hrd_kik.no_bukti, hrd_kikd.tgl_kik ) AA";
		return $this->db->query($q1);
	}

	public function tampil_data_kik_perperiode()
	{
		$kd_bag_1 = $this->input->post('KD_BAG_1');
		$bulan = substr($this->input->post('PER'), 0, 2);
		$tahun = substr($this->input->post('PER'), -4);
		$per = $tahun . $bulan;
		$q1 = "SELECT hrd_kik.per AS PER,
				hrd_kik.no_bukti AS NO_BUKTI,
				CONCAT(hrd_kik.kd_bag,' - ',hrd_kik.nm_bag) AS BAGIAN,
				hrd_kik.flag AS FLAG,
				hrd_kik.tqty AS TQTY,
				hrd_kik.torg AS TORG,
				hrd_kik.tjumlah AS TJUMLAH,
				hrd_kik.tsub AS TSUB
			FROM hrd_kik
			WHERE CONCAT(RIGHT(hrd_kik.per,4),left(hrd_kik.per,2))<='$per'
			AND hrd_kik.kd_bag='$kd_bag_1'
			ORDER BY hrd_kik.flag, hrd_kik.kd_bag, hrd_kik.no_bukti";
		return $this->db->query($q1);
	}

	public function tampil_data_premi_jahit()
	{
		$kd_bag_1 = $this->input->post('KD_BAG_1');
		$per = $this->session->userdata['periode'];
		$q1 = "SELECT hrd_premi.per AS PER,
				hrd_premid.no_bukti AS NO_BUKTI,
				CONCAT(hrd_premid.kd_bag,' - ',hrd_premid.nm_bag) AS BAGIAN,
				hrd_premid.flag AS FLAG,
				hrd_premi.dr AS DR,
				hrd_premi.ms AS MS,
				hrd_premid.nett AS NETT,
				hrd_premid.tjumlah AS TJUMLAH,
				hrd_premid.cakra AS CAKRA,
				hrd_premid.netto AS NETTO
			FROM hrd_premi, hrd_premid
			WHERE hrd_premid.kd_bag='$kd_bag_1'
			AND hrd_premi.per='$per'
			AND hrd_premid.flag='JAHIT'
			ORDER BY hrd_premid.kd_bag, hrd_premid.nm_bag";
		return $this->db->query($q1);
	}

	public function tampil_data_premi_plong()
	{
		$kd_bag_1 = $this->input->post('KD_BAG_1');
		$per = $this->session->userdata['periode'];
		$q1 = "SELECT hrd_premi.per AS PER,
				hrd_premid.no_bukti AS NO_BUKTI,
				CONCAT(hrd_premid.kd_bag,' - ',hrd_premid.nm_bag) AS BAGIAN,
				hrd_premid.flag AS FLAG,
				hrd_premi.dr AS DR,
				hrd_premi.ms AS MS,
				hrd_premid.nett AS NETT,
				hrd_premid.tjumlah AS TJUMLAH,
				hrd_premid.bla AS BLA,
				hrd_premid.netto AS NETTO
			FROM hrd_premi, hrd_premid
			WHERE hrd_premid.kd_bag='$kd_bag_1'
			AND hrd_premi.per='$per'
			AND hrd_premid.flag='PLONG'
			ORDER BY hrd_premid.kd_bag, hrd_premid.nm_bag";
		return $this->db->query($q1);
	}

	public function tampil_data_premi_packing()
	{
		$kd_bag_1 = $this->input->post('KD_BAG_1');
		$per = $this->session->userdata['periode'];
		$q1 = "SELECT hrd_premi.per AS PER,
				hrd_premid.no_bukti AS NO_BUKTI,
				CONCAT(hrd_premid.kd_bag,' - ',hrd_premid.nm_bag) AS BAGIAN,
				hrd_premid.flag AS FLAG,
				hrd_premi.dr AS DR,
				hrd_premi.ms AS MS,
				hrd_premid.nett AS NETT,
				hrd_premid.tjumlah AS TJUMLAH,
				hrd_premid.bla AS BLA,
				hrd_premid.netto AS NETTO
			FROM hrd_premi, hrd_premid
			WHERE hrd_premid.kd_bag='$kd_bag_1'
			AND hrd_premi.per='$per'
			AND hrd_premid.flag='PACKING'
			ORDER BY hrd_premid.kd_bag, hrd_premid.nm_bag";
		return $this->db->query($q1);
	}

	public function tampil_data_premi_sablon()
	{
		$kd_bag_1 = $this->input->post('KD_BAG_1');
		$per = $this->session->userdata['periode'];
		$q1 = "SELECT hrd_premi.per AS PER,
				hrd_premid.no_bukti AS NO_BUKTI,
				CONCAT(hrd_premid.kd_bag,' - ',hrd_premid.nm_bag) AS BAGIAN,
				hrd_premid.flag AS FLAG,
				hrd_premi.dr AS DR,
				hrd_premi.ms AS MS,
				hrd_premid.nett AS NETT,
				hrd_premid.tjumlah AS TJUMLAH,
				hrd_premid.bla AS BLA,
				hrd_premid.netto AS NETTO
			FROM hrd_premi, hrd_premid
			WHERE hrd_premid.kd_bag='$kd_bag_1'
			AND hrd_premi.per='$per'
			AND hrd_premid.flag='SABLON'
			ORDER BY hrd_premid.kd_bag, hrd_premid.nm_bag";
		return $this->db->query($q1);
	}

	public function tampil_data_premi_injection()
	{
		$kd_bag_1 = $this->input->post('KD_BAG_1');
		$per = $this->session->userdata['periode'];
		$q1 = "SELECT hrd_premi.per AS PER,
				hrd_premid.no_bukti AS NO_BUKTI,
				CONCAT(hrd_premid.kd_bag,' - ',hrd_premid.nm_bag) AS BAGIAN,
				hrd_premid.flag AS FLAG,
				hrd_premi.dr AS DR,
				hrd_premi.ms AS MS,
				hrd_premid.nett AS NETT,
				hrd_premid.tjumlah AS TJUMLAH,
				hrd_premid.bla AS BLA,
				hrd_premid.netto AS NETTO
			FROM hrd_premi, hrd_premid
			WHERE hrd_premid.kd_bag='$kd_bag_1'
			AND hrd_premi.per='$per'
			AND hrd_premid.flag='INJECTION'
			ORDER BY hrd_premid.kd_bag, hrd_premid.nm_bag";
		return $this->db->query($q1);
	}

	public function tampil_data_premi_strong()
	{
		$kd_bag_1 = $this->input->post('KD_BAG_1');
		$per = $this->session->userdata['periode'];
		$q1 = "SELECT hrd_premi.per AS PER,
				hrd_premid.no_bukti AS NO_BUKTI,
				CONCAT(hrd_premid.kd_bag,' - ',hrd_premid.nm_bag) AS BAGIAN,
				hrd_premid.flag AS FLAG,
				hrd_premi.dr AS DR,
				hrd_premi.ms AS MS,
				hrd_premid.nett AS NETT,
				hrd_premid.tjumlah AS TJUMLAH,
				hrd_premid.bla AS BLA,
				hrd_premid.netto AS NETTO
			FROM hrd_premi, hrd_premid
			WHERE hrd_premid.kd_bag='$kd_bag_1'
			AND hrd_premi.per='$per'
			AND hrd_premid.flag='STRONG'
			ORDER BY hrd_premid.kd_bag, hrd_premid.nm_bag";
		return $this->db->query($q1);
	}

	public function tampil_data_premi_inject()
	{
		$kd_bag_1 = $this->input->post('KD_BAG_1');
		$per = $this->session->userdata['periode'];
		$q1 = "SELECT hrd_premi.per AS PER,
				hrd_premid.no_bukti AS NO_BUKTI,
				CONCAT(hrd_premid.kd_bag,' - ',hrd_premid.nm_bag) AS BAGIAN,
				hrd_premid.flag AS FLAG,
				hrd_premi.dr AS DR,
				hrd_premi.ms AS MS,
				hrd_premid.nett AS NETT,
				hrd_premid.tjumlah AS TJUMLAH,
				hrd_premid.bla AS BLA,
				hrd_premid.netto AS NETTO
			FROM hrd_premi, hrd_premid
			WHERE hrd_premid.kd_bag='$kd_bag_1'
			AND hrd_premi.per='$per'
			AND hrd_premid.flag='INJECT'
			ORDER BY hrd_premid.kd_bag, hrd_premid.nm_bag";
		return $this->db->query($q1);
	}

	public function tampil_data_premi_psp()
	{
		$kd_bag_1 = $this->input->post('KD_BAG_1');
		$per = $this->session->userdata['periode'];
		$q1 = "SELECT hrd_premi.per AS PER,
				hrd_premid.no_bukti AS NO_BUKTI,
				CONCAT(hrd_premid.kd_bag,' - ',hrd_premid.nm_bag) AS BAGIAN,
				hrd_premid.flag AS FLAG,
				hrd_premi.dr AS DR,
				hrd_premi.ms AS MS,
				hrd_premid.nett AS NETT,
				hrd_premid.tjumlah AS TJUMLAH,
				hrd_premid.bla AS BLA,
				hrd_premid.netto AS NETTO
			FROM hrd_premi, hrd_premid
			WHERE hrd_premid.kd_bag='$kd_bag_1'
			AND hrd_premi.per='$per'
			AND hrd_premid.flag='PSP'
			ORDER BY hrd_premid.kd_bag, hrd_premid.nm_bag";
		return $this->db->query($q1);
	}

	public function tampil_data_tunjangan_tunjangan()
	{
		$kd_bag_1 = $this->input->post('KD_BAG_1');
		$tgl_1 = date("Y-m-d", strtotime($this->input->post('TGL_1', TRUE)));
		$per = $this->session->userdata['periode'];
		$q1 = "SELECT hrd_tunjang.no_bukti AS NO_BUKTI, 
				hrd_tunjang.per AS PER,
				hrd_tunjang.flag AS FLAG,
				hrd_tunjang.dr AS DR,
				hrd_tunjang.tgl AS TGL,
				CONCAT(hrd_tunjang.kd_bag,' - ',hrd_tunjang.nm_bag) AS BAGIAN,
				CONCAT(hrd_tunjangd.kd_peg,' - ',hrd_tunjangd.nm_peg) AS PEGAWAI,
				hrd_tunjangd.tjabatan AS TJABATAN
			FROM hrd_tunjang, hrd_tunjangd
			WHERE hrd_tunjang.no_bukti=hrd_tunjangd.no_bukti
			AND hrd_tunjang.flag='TJ'
			AND hrd_tunjang.tgl='$tgl_1'
			AND hrd_tunjang.kd_bag='$kd_bag_1'
			AND hrd_tunjang.per='$per'
			ORDER BY hrd_tunjangd.rec";
		return $this->db->query($q1);
	}

	public function tampil_data_tunjangan_nikahmati()
	{
		$kd_bag_1 = $this->input->post('KD_BAG_1');
		$tgl_1 = date("Y-m-d", strtotime($this->input->post('TGL_1', TRUE)));
		$per = $this->session->userdata['periode'];
		$q1 = "SELECT hrd_tunjang.no_bukti AS NO_BUKTI, 
				hrd_tunjang.per AS PER,
				hrd_tunjang.flag AS FLAG,
				hrd_tunjang.dr AS DR,
				hrd_tunjang.tgl AS TGL,
				CONCAT(hrd_tunjang.kd_bag,' - ',hrd_tunjang.nm_bag) AS BAGIAN,
				CONCAT(hrd_tunjangd.kd_peg,' - ',hrd_tunjangd.nm_peg) AS PEGAWAI,
				hrd_tunjangd.nikah_mati AS NIKAH_MATI
			FROM hrd_tunjang, hrd_tunjangd
			WHERE hrd_tunjang.no_bukti=hrd_tunjangd.no_bukti
			AND hrd_tunjang.flag='NM'
			AND hrd_tunjang.tgl='$tgl_1'
			AND hrd_tunjang.kd_bag='$kd_bag_1'
			AND hrd_tunjang.per='$per'
			ORDER BY hrd_tunjangd.rec";
		return $this->db->query($q1);
	}

	public function tampil_data_tunjangan_obat()
	{
		$kd_bag_1 = $this->input->post('KD_BAG_1');
		$tgl_1 = date("Y-m-d", strtotime($this->input->post('TGL_1', TRUE)));
		$per = $this->session->userdata['periode'];
		$q1 = "SELECT hrd_tunjang.no_bukti AS NO_BUKTI, 
				hrd_tunjang.per AS PER,
				hrd_tunjang.flag AS FLAG,
				hrd_tunjang.dr AS DR,
				hrd_tunjang.tgl AS TGL,
				CONCAT(hrd_tunjang.kd_bag,' - ',hrd_tunjang.nm_bag) AS BAGIAN,
				CONCAT(hrd_tunjangd.kd_peg,' - ',hrd_tunjangd.nm_peg) AS PEGAWAI,
				hrd_tunjangd.obat AS OBAT
			FROM hrd_tunjang, hrd_tunjangd
			WHERE hrd_tunjang.no_bukti=hrd_tunjangd.no_bukti
			AND hrd_tunjang.flag='OB'
			AND hrd_tunjang.tgl='$tgl_1'
			AND hrd_tunjang.kd_bag='$kd_bag_1'
			AND hrd_tunjang.per='$per'
			ORDER BY hrd_tunjangd.rec";
		return $this->db->query($q1);
	}

	public function tampil_data_tunjangan_jasa()
	{
		$kd_bag_1 = $this->input->post('KD_BAG_1');
		$tgl_1 = date("Y-m-d", strtotime($this->input->post('TGL_1', TRUE)));
		$per = $this->session->userdata['periode'];
		$q1 = "SELECT hrd_tunjang.no_bukti AS NO_BUKTI, 
				hrd_tunjang.per AS PER,
				hrd_tunjang.flag AS FLAG,
				hrd_tunjang.dr AS DR,
				hrd_tunjang.tgl AS TGL,
				CONCAT(hrd_tunjang.kd_bag,' - ',hrd_tunjang.nm_bag) AS BAGIAN,
				CONCAT(hrd_tunjangd.kd_peg,' - ',hrd_tunjangd.nm_peg) AS PEGAWAI,
				hrd_tunjangd.jasa AS JASA
			FROM hrd_tunjang, hrd_tunjangd
			WHERE hrd_tunjang.no_bukti=hrd_tunjangd.no_bukti
			AND hrd_tunjang.flag='JS'
			AND hrd_tunjang.tgl='$tgl_1'
			AND hrd_tunjang.kd_bag='$kd_bag_1'
			AND hrd_tunjang.per='$per'
			ORDER BY hrd_tunjangd.rec";
		return $this->db->query($q1);
	}

	public function tampil_data_insentif_perbagian()
	{
		$kd_bag_1 = $this->input->post('KD_BAG_1');
		$kd_bag_2 = $this->input->post('KD_BAG_2');
		$per = $this->input->post('PER');
		$per2 = $this->input->post('PER2');
		$q1 = "SELECT hrd_absen.per AS PER, 
				hrd_absen.no_bukti AS NO_BUKTI, 
				hrd_absen.flag AS FLAG, 
				CONCAT(hrd_absen.kd_bag,' - ',hrd_absen.nm_bag) AS BAGIAN,
				CONCAT(hrd_absen.kd_grup,' - ',hrd_absen.nm_grup) AS GRUP,
				CONCAT(hrd_absend.kd_peg,' - ',hrd_absend.nm_peg) AS PEGAWAI,
				hrd_absend.tperbulan AS TPERBULAN
			FROM hrd_absen, hrd_absend
			WHERE hrd_absen.no_bukti=hrd_absend.no_bukti 
			AND hrd_absen.per BETWEEN '$per' AND '$per2'
			AND hrd_absen.kd_bag BETWEEN '$kd_bag_1' AND '$kd_bag_2'
			ORDER BY hrd_absen.flag, hrd_absen.kd_bag, hrd_absend.rec";
		return $this->db->query($q1);
	}

	public function tampil_data_insentif_pergrup()
	{
		$kd_grup_1 = $this->input->post('KD_GRUP_1');
		$kd_grup_2 = $this->input->post('KD_GRUP_2');
		$per = $this->session->userdata('periode');
		$q1 = "SELECT hrd_absen.per AS PER, 
				hrd_absen.no_bukti AS NO_BUKTI, 
				hrd_absen.flag AS FLAG, 
				CONCAT(hrd_absen.kd_bag,' - ',hrd_absen.nm_bag) AS BAGIAN,
				CONCAT(hrd_absen.kd_grup,' - ',hrd_absen.nm_grup) AS GRUP,
				CONCAT(hrd_absend.kd_peg,' - ',hrd_absend.nm_peg) AS PEGAWAI,
				hrd_absend.tperbulan AS TPERBULAN
			FROM hrd_absen, hrd_absend
			WHERE hrd_absen.no_bukti=hrd_absend.no_bukti 
			AND hrd_absen.per='$per'
			AND hrd_absen.kd_grup BETWEEN '$kd_grup_1' AND '$kd_grup_2'
			ORDER BY hrd_absen.flag, hrd_absen.kd_grup";
		return $this->db->query($q1);
	}

	public function tampil_data_thr_perbagian()
	{
		$kd_bag_1 = $this->input->post('KD_BAG_1');
		$kd_bag_2 = $this->input->post('KD_BAG_2');
		$bulan = substr($this->input->post('PER'), 0, 2);
		$tahun = substr($this->input->post('PER'), -4);
		$per = $tahun . $bulan;
		$q1 = "SELECT hrd_thr.per AS PER, 
				hrd_thr.no_bukti AS NO_BUKTI, 
				hrd_thr.flag AS FLAG, 
				CONCAT(hrd_thr.kd_bag,' - ',hrd_thr.nm_bag) AS BAGIAN,
				CONCAT(hrd_thr.kd_grup,' - ',hrd_thr.nm_grup) AS GRUP,
				CONCAT(hrd_thrd.kd_peg,' - ',hrd_thrd.nm_peg) AS PEGAWAI,
				hrd_thrd.thr AS THR
			FROM hrd_thr, hrd_thrd
			WHERE hrd_thr.no_bukti=hrd_thrd.no_bukti 
			AND CONCAT(RIGHT(hrd_thr.per,4),left(hrd_thr.per,2))<='$per'
			AND hrd_thr.kd_bag BETWEEN '" . $kd_bag_1 . "' AND '" . $kd_bag_2 . "'
			ORDER BY hrd_thr.flag, hrd_thr.kd_bag, hrd_thrd.rec";
		return $this->db->query($q1);
	}

	public function tampil_data_thr_pergrup()
	{
		$kd_grup_1 = $this->input->post('KD_GRUP_1');
		$kd_grup_2 = $this->input->post('KD_GRUP_2');
		$bulan = substr($this->input->post('PER'), 0, 2);
		$tahun = substr($this->input->post('PER'), -4);
		$per = $tahun . $bulan;
		$q1 = "SELECT hrd_thr.per AS PER, 
				hrd_thr.no_bukti AS NO_BUKTI, 
				hrd_thr.flag AS FLAG, 
				CONCAT(hrd_thr.kd_bag,' - ',hrd_thr.nm_bag) AS BAGIAN,
				CONCAT(hrd_thr.kd_grup,' - ',hrd_thr.nm_grup) AS GRUP,
				CONCAT(hrd_thrd.kd_peg,' - ',hrd_thrd.nm_peg) AS PEGAWAI,
				hrd_thrd.thr AS THR
			FROM hrd_thr, hrd_thrd
			WHERE hrd_thr.no_bukti=hrd_thrd.no_bukti 
			AND CONCAT(RIGHT(hrd_thr.per,4),left(hrd_thr.per,2))<='$per'
			AND hrd_thr.kd_grup BETWEEN '" . $kd_grup_1 . "' AND '" . $kd_grup_2 . "'
			ORDER BY hrd_thr.flag, hrd_thr.kd_grup";
		return $this->db->query($q1);
	}

	public function tampil_data_thr_rekapthr()
	{
		$per = $this->session->userdata('periode');
		$q1 = "SELECT hrd_thr.per AS PER, 
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
		AND hrd_thr.per='$per'
		ORDER BY hrd_thr.flag, hrd_thr.kd_grup";
		return $this->db->query($q1);
	}

	public function tampil_data_kurangan()
	{
		$kd_bag_1 = $this->input->post('KD_BAG_1');
		$tgl_1 = date("Y-m-d", strtotime($this->input->post('TGL_1', TRUE)));
		$per = $this->session->userdata['periode'];
		$q1 = "SELECT hrd_tunjang.no_bukti AS NO_BUKTI, 
				hrd_tunjang.per AS PER,
				hrd_tunjang.flag AS FLAG,
				hrd_tunjang.dr AS DR,
				hrd_tunjang.tgl AS TGL,
				CONCAT(hrd_tunjang.kd_bag,' - ',hrd_tunjang.nm_bag) AS BAGIAN,
				CONCAT(hrd_tunjangd.kd_peg,' - ',hrd_tunjangd.nm_peg) AS PEGAWAI,
				hrd_tunjangd.jasa AS JASA
			FROM hrd_tunjang, hrd_tunjangd
			WHERE hrd_tunjang.no_bukti=hrd_tunjangd.no_bukti
			AND hrd_tunjang.flag='KR'
			AND hrd_tunjang.tgl='$tgl_1'
			AND hrd_tunjang.kd_bag='$kd_bag_1'
			AND hrd_tunjang.per='$per'
			ORDER BY hrd_tunjangd.rec";
		return $this->db->query($q1);
	}

	public function tampil_data_rekappremi_staff()
	{
		$per = $this->session->userdata['periode'];
		$q1 = "SELECT hrd_premid.per AS PER, 
				hrd_premid.no_bukti AS NO_BUKTI, 
				hrd_premid.flag AS FLAG,
				SUM(hrd_premid.wk_manag) AS WK_MANAG,
				SUM(hrd_premid.ka_qc) AS KA_QC,
				SUM(hrd_premid.wk_qc) AS WK_QC,
				SUM(hrd_premid.admin2) AS ADMIN2,
				SUM(hrd_premid.adm) AS ADM,
				SUM(hrd_premid.kaprod) AS KAPROD,
				SUM(hrd_premid.kamaint) AS KAMAINT
			FROM hrd_premid
			WHERE hrd_premid.per='$per'
			GROUP BY hrd_premid.flag
			ORDER BY hrd_premid.flag, hrd_premid.kd_bag";
		return $this->db->query($q1);
	}

	public function tampil_data_rekappremi_perdevisi()
	{
		$per = $this->session->userdata['periode'];
		$q1 = "SELECT hrd_premid.per AS PER, 
				hrd_premid.flag AS FLAG, 
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
				(hrd_premid.ksmesin) AS P18
			FROM hrd_premid, hrd_bag
			WHERE hrd_premid.per='$per'
			GROUP BY hrd_premid.kd_bag
			ORDER BY hrd_premid.flag, hrd_premid.kd_bag";
		return $this->db->query($q1);
	}

	public function tampil_data_rekappremi_inject()
	{
		$per = $this->session->userdata['periode'];
		$q1 = "SELECT hrd_premid.per AS PER, 
				hrd_premid.flag AS FLAG, 
				hrd_bag.nm_kasi AS NAMA, 
				hrd_bag.kd_kasi AS JABATAN, 
				SUM(hrd_premid.kasi) AS P01,
				SUM(hrd_premid.maint1) AS P02,
				SUM(hrd_premid.maint2) AS P03,
				SUM(hrd_premid.kabag) AS P04,
				SUM(hrd_premid.qc1) AS P05,
				SUM(hrd_premid.qc2) AS P06,
				SUM(hrd_premid.admin1) AS P07,
				SUM(hrd_premid.admin2) AS P08,
				SUM(hrd_premid.wk_manag) AS P09,
				SUM(hrd_premid.ka_qc) AS P10,
				SUM(hrd_premid.wk_qc) AS P11,
				SUM(hrd_premid.adm) AS P12,
				SUM(hrd_premid.manag) AS P13,
				SUM(hrd_premid.kaprod) AS P14,
				SUM(hrd_premid.kamaint) AS P15,
				SUM(hrd_premid.ksmaint) AS P16,
				SUM(hrd_premid.kagrup) AS P17,
				SUM(hrd_premid.ksmesin) AS P18
			FROM hrd_premid, hrd_bag
			WHERE hrd_premid.per='$per'
			AND hrd_premid.flag='INJECT'
			GROUP BY hrd_premid.kd_bag
			ORDER BY hrd_premid.flag, hrd_premid.kd_bag";
		return $this->db->query($q1);
	}
}
