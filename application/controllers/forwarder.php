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
