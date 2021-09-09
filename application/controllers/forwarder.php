<?php
class Forwarder extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$masuk = $this->session->userdata('status');
		if ($masuk != "masuk") {
			$this->login();
		} else {
			$data['judul'] = 'Beranda';
			$data['aktif'] = 'active';
			$data['konten'] = 'forwarder/beranda';
			$this->load->view('forwarder/template', $data);
		}
	}

	public function edit($id_forwarder)
	{
		$data['judul'] = 'Kelola Informasi Forwarder';
		$data['konten'] = 'admin/edit_forwarder';
		$data['aktif'] = 'active';
		$data['forwarder'] = $this->mforwarder->get_informasi_forwarder_by_id($id_forwarder);
		$data['kota_asal_kecuali'] = $this->mkota->getAllKotaExcept($data['forwarder'][0]['FORWARDER_NAMA_KOTA_ASAL']);
		$data['kota_tujuan_kecuali'] = $this->mkota->getAllKotaExcept($data['forwarder'][0]['FORWARDER_NAMA_KOTA_TUJUAN']);
		$data['list_kota'] = $this->mkota->getAllKota();
		$this->load->vars($data);
		$this->load->view('admin/pg_admin', $data, FALSE);
	}

	public function edit_forwarder()
	{
		$forwarder_id = $this->input->post('idForwarder');
		$forwarder_nama = $this->input->post('namaForwarder');
		$forwarder_email = $this->input->post('emailForwarder');
		$forwarder_password = $this->input->post('passwordForwarder');
		$forwarder_asal = $this->input->post('cbKotaAsal');
		$forwarder_tujuan = $this->input->post('cbKotaTujuan');
		$data = $this->mforwarder->update_forwarder($forwarder_nama, $forwarder_email, $forwarder_password, $forwarder_asal, $forwarder_tujuan);
		$this->session->set_flashdata('message', 'Forwarder telah berhasil ditambahkan');
		redirect('pg_admin/forwarder', 'refresh');
	}

	public function daftar_kiriman()
	{
		$data['judul'] = 'Urutkan Pengiriman';
		$data['konten'] = 'forwarder/daftar_kiriman';
		$data['aktif'] = 'active';
		$data['belum_urut'] = $this->mpengiriman->getAllPengirimanBelumDiproses();
		$data['kota'] = $this->mkota->getAllKota();
		$data['provinsi'] = $this->mkota->getAllProvinsi();
		$this->load->vars($data);
		$this->load->view('forwarder/template', $data, FALSE);
	}

	public function list_kiriman($id = NULL)
	{
		$data['judul'] = 'List Pengiriman';
		$data['konten'] = 'forwarder/list_kiriman';
		$data['aktif'] = 'active';
		$jml = $this->db->get('view_list_tracking');

		$this->load->library('pagination');

		$config['base_url'] = base_url() . 'index.php/forwarder/list_kiriman';
		$config['total_rows'] = $jml->num_rows();
		$config['per_page'] = 5;
		$config['uri_segment'] = 3;
		$config['num_links'] = 3;
		$config['full_tag_open'] = '<ul>';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = 'Awal';
		$config['last_link'] = 'Akhir';
		$config['next_link'] = '&raquo;';
		$config['prev_link'] = '&laquo;';

		$this->pagination->initialize($config);

		$data['paging'] = $this->pagination->create_links();
		$data['tracking'] = $this->mforwarder->get_informasi_pengiriman($this->session->userdata('FORWARDER_ID'), $config['per_page'], $id);

		$this->load->vars($data);
		$this->load->view('forwarder/template', $data, FALSE);
	}

	public function detail_tracking($no_resi)
	{
		$data['judul'] = 'Detail Tracking';
		$data['konten'] = 'forwarder/detail_tracking';
		$data['aktif'] = 'active';
		$data['status'] = $this->mstatus->getAllStatus();
		$data['tracking'] = $this->mtracking->detil_tracking($no_resi);
		$data['kota'] = $this->mkota->get_all_kota_by_alphabet();
		$this->load->view('forwarder/template', $data);
	}

	public function cetak_dokumen_pengiriman($id)
	{
		$data['judul'] = 'Cetak Dokumen Pengiriman';
		$data['pengiriman'] = $this->mpengiriman->getPengirimanById($id);
		$this->load->vars($data);
		$this->load->view('forwarder/cetak_dokumen_pengiriman', $data, FALSE);
	}

	public function kelola_armada()
	{
		$data['judul'] = 'Kelola Armada';
		$data['konten'] = 'forwarder/kelola_armada';
		$data['aktif'] = 'active';
		$data['armada'] = $this->mforwarder->get_all_armada_by_forwarder_id($this->session->userdata('FORWARDER_ID'));
		$data['kota'] = $this->mkota->getAllKota();
		$this->load->vars($data);
		$this->load->view('forwarder/template', $data, FALSE);
	}

	public function atur_tataletak_armada()
	{
		$data['judul'] = 'Atur Tataletak Armada';
		$data['konten'] = 'forwarder/atur_tataletak_armada';
		$data['aktif'] = 'active';
		$data['armada'] = $this->mforwarder->get_all_armada_by_forwarder_id($this->session->userdata('FORWARDER_ID'));
		$data['kota'] = $this->mkota->getAllKota();
		$this->load->vars($data);
		$this->load->view('forwarder/template', $data, FALSE);
	}

	public function test()
	{
		$this->mforwarder->masukin();
	}

	public function lihat_tataletak_armada($id_armada, $id = NULL)
	{
		$data['judul'] = 'Lihat Tataletak Kiriman';
		$data['konten'] = 'forwarder/lihat_tataletak_armada';
		$data['aktif'] = 'active';
		$data['kiriman_sdh'] = $this->mforwarder->get_all_pengiriman_by_armada_sudah_disusun($id_armada);
		$data['kiriman_blm'] = $this->mforwarder->get_all_pengiriman_by_armada_belum_disusun($id_armada);
		$data['armada'] = $this->mforwarder->get_armada_info_by_id($id_armada);

		$this->load->library('pagination');

		$jml = $this->db->where('MUATAN_ARMADA_ID', $id_armada)->get('muatan_armada');
		$config['base_url'] = base_url() . 'index.php/forwarder/lihat_tataletak_armada/' . $id_armada;
		$config['total_rows'] = $jml->num_rows();
		$config['per_page'] = 10;
		$config['uri_segment'] = 5;
		$config['num_links'] = $jml->num_rows() / 10;
		$config['full_tag_open'] = '<ul>';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = '&raquo;';
		$config['prev_link'] = '&laquo;';

		$this->pagination->initialize($config);

		$data['paging'] = $this->pagination->create_links();
		$data['slot'] = $this->mforwarder->get_muatan_armada_by_id($id_armada, $config['per_page'], $id);
		$this->load->vars($data);
		$this->load->view('forwarder/template', $data, FALSE);
	}

	public function tambah_armada()
	{
		$nama = $this->input->post('namaArmada');
		$forwarder_id = $this->input->post('forwarderId');
		$kapasitas = $this->input->post('kapasitasArmada');
		$panjangArmada = $this->input->post('volPanjangArmada');
		$lebarArmada = $this->input->post('volLebarArmada');
		$tinggiArmada = $this->input->post('volTinggiArmada');
		$asal = $this->input->post('cbKotaAsal');
		$tujuan = $this->input->post('cbKotaTujuan');
		$data = $this->mforwarder->insert_armada($nama, $forwarder_id, $kapasitas, $panjangArmada, $lebarArmada, $tinggiArmada, $asal, $tujuan);
		$this->session->set_flashdata('message', 'Armada telah berhasil ditambahkan');
		redirect('forwarder/kelola_armada', 'refresh');
	}

	public function ubah_armada($id)
	{
		$data['judul'] = 'Ubah Armada';
		$data['konten'] = 'forwarder/ubah_armada';
		$data['aktif'] = 'active';
		$data['armada'] = $this->mforwarder->get_armada_info_by_id($id);
		// echo $data['armada'][0]['NAMA_KOTA_ASAL'];die;
		$data['kota_asal'] = $this->mforwarder->get_all_kota_kecuali_armada_tertentu($data['armada'][0]['NAMA_KOTA_ASAL']);
		$data['kota_tujuan'] = $this->mforwarder->get_all_kota_kecuali_armada_tertentu($data['armada'][0]['NAMA_KOTA_TUJUAN']);
		$this->load->vars($data);
		$this->load->view('forwarder/template', $data, FALSE);
	}

	public function ubah_armada_action()
	{
		$nama = $this->input->post('namaArmada');
		$id_armada = $this->input->post('idArmada');
		$kapasitas = $this->input->post('kapasitasArmada');
		$asal = $this->input->post('cbKotaAsal');
		$tujuan = $this->input->post('cbKotaTujuan');
		$data = $this->mforwarder->ubah_armada($nama, $id_armada, $kapasitas, $asal, $tujuan);
		$this->session->set_flashdata('message', 'Informasi armada berhasil diubah');
		redirect('forwarder/kelola_armada', 'refresh');
	}

	public function detail_tracking_action()
	{
		$no_resi = $this->input->post('txtNoResi');
		$id_pengiriman = $this->input->post('txtIdPengiriman');
		$id_cust = $this->input->post('txtIdCust');
		$status_pengiriman = $this->input->post('cbStatusPengiriman');
		$tanggal = $this->input->post('txtTanggalTracking');
		$posisi = $this->input->post('txtPosisi');
		$ket = $this->input->post('txtKeterangan');
		if (empty($ket)) $keterangan = "";
		else $keterangan = $ket;
		$this->mtracking->insert($no_resi, $id_pengiriman, $id_cust, $status_pengiriman, $tanggal, $posisi, $keterangan);
		$this->session->set_flashdata('message', 'Status pengiriman sudah diperbarui.');
		redirect('forwarder/detail_tracking/' . $no_resi, 'refresh');
		//echo $no_resi." ".$id_pengiriman." ".$id_cust." ".$status_pengiriman." ".$tanggal." ".$posisi." ".$keterangan;
	}

	// public function hapus_armada($id){
	// 	$this->mforwarder->hapus_armada($id);
	// 	$this->session->set_flashdata('message', 'Armada berhasil dihapus!');
	// 	redirect('forwarder/kelola_armada', 'refresh');
	// }

	public function login()
	{
		$data['judul'] = 'Login Halaman Forwarder';
		$this->load->view('forwarder/login', $data);
	}

	public function check_login()
	{
		$this->load->library('encrypt');
		$username = $this->input->post('email');
		$password = $this->input->post('password');
		// $row = $this->mloginadmin->validasi($username, $password);
		$row = $this->mforwarder->validasi_login($username, $password);
		if (count($row) > 0) {
			$item = array(
				'FORWARDER_ID' => $row['FORWARDER_ID'],
				'FORWARDER_EMAIL' => $row['FORWARDER_EMAIL'],
				'FORWARDER_PASSWORD' => $row['FORWARDER_PASSWORD'],
				'status' => 'masuk'
			);
			$this->session->set_userdata($item);
			redirect('forwarder', 'refresh');
		} else {
			$this->session->set_flashdata('error', 'Maaf, silahkan coba lagi!');
			redirect('forwarder/login', 'refresh');
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		$this->session->set_flashdata('result', 'Anda sudah keluar');
		header('location:' . base_url() . 'index.php');
		redirect('index.php', 'refresh');
	}

	public function add()
	{
		$forwarder_nama = $this->input->post('namaForwarder');
		$forwarder_email = $this->input->post('emailForwarder');
		$forwarder_password = $this->input->post('passwordForwarder');
		$forwarder_asal = $this->input->post('cbKotaAsal');
		$forwarder_tujuan = $this->input->post('cbKotaTujuan');
		$data = $this->mforwarder->insert_forwarder($forwarder_nama, $forwarder_email, $forwarder_password, $forwarder_asal, $forwarder_tujuan);
		$this->session->set_flashdata('message', 'Forwarder telah berhasil ditambahkan');
		redirect('pg_admin/forwarder', 'refresh');
	}

	public function remove($id)
	{
		$data = $this->mforwarder->delete_forwarder($id);
		$this->session->set_flashdata('message', 'Forwarder telah berhasil dihapus');
		redirect('pg_admin/forwarder', 'refresh');
	}
}
