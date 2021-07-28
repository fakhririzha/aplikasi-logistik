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

	public function daftar_kiriman(){
		$data['judul'] = 'Urutkan Pengiriman';
		$data['konten'] = 'forwarder/daftar_kiriman';
		$data['aktif'] = 'active';
		$data['belum_urut'] = $this->mpengiriman->getAllPengirimanBelumDiproses();
		$data['kota'] = $this->mkota->getAllKota();
		$data['provinsi'] = $this->mkota->getAllProvinsi();
		$this->load->vars($data);
		$this->load->view('forwarder/template', $data, FALSE);
	}

	public function list_kiriman(){
		$data['judul'] = 'List Pengiriman';
		$data['konten'] = 'forwarder/list_kiriman';
		$data['aktif'] = 'active';
		$data['belum_urut'] = $this->mforwarder->get_all_pengiriman_by_forwarder();
		$data['kota'] = $this->mkota->getAllKota();
		$data['provinsi'] = $this->mkota->getAllProvinsi();
		$this->load->vars($data);
		$this->load->view('forwarder/template', $data, FALSE);
	}

	public function kelola_armada(){
		$data['judul'] = 'Kelola Armada';
		$data['konten'] = 'forwarder/kelola_armada';
		$data['aktif'] = 'active';
		$data['armada'] = $this->mforwarder->get_all_armada_by_forwarder_id($this->session->userdata('FORWARDER_ID'));
		$data['kota'] = $this->mkota->getAllKota();
		$this->load->vars($data);
		$this->load->view('forwarder/template', $data, FALSE);
	}

	public function tambah_armada(){
		$nama = $this->input->post('namaArmada');
		$forwarder_id = $this->input->post('forwarderId');
		$kapasitas = $this->input->post('kapasitasArmada');
		$asal = $this->input->post('cbKotaAsal');
		$tujuan = $this->input->post('cbKotaTujuan');
		$data = $this->mforwarder->insert_armada($nama, $forwarder_id, $kapasitas, $asal, $tujuan);
		$this->session->set_flashdata('message', 'Armada telah berhasil ditambahkan');
		redirect('forwarder/kelola_armada', 'refresh');
	}

	public function ubah_armada($id){
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

	public function ubah_armada_action(){
		$nama = $this->input->post('namaArmada');
		$id_armada = $this->input->post('idArmada');
		$kapasitas = $this->input->post('kapasitasArmada');
		$asal = $this->input->post('cbKotaAsal');
		$tujuan = $this->input->post('cbKotaTujuan');
		$data = $this->mforwarder->ubah_armada($nama, $id_armada, $kapasitas, $asal, $tujuan);
		$this->session->set_flashdata('message', 'Informasi armada berhasil diubah');
		redirect('forwarder/kelola_armada', 'refresh');
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
		header('location:'.base_url().'index.php/forwarder/login');
		redirect('forwarder/login', 'refresh');
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

	public function remove($id){
		$data = $this->mforwarder->delete_forwarder($id);
		$this->session->set_flashdata('message', 'Forwarder telah berhasil dihapus');
		redirect('pg_admin/forwarder', 'refresh');
	}
}