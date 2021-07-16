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

	public function add()
	{
		$forwarder_email = $this->input->post('forwarderEmail');
		$forwarder_password = $this->input->post('forwarderPassword');
		$data = $this->mforwarder->insert_forwarder($forwarder_email, $forwarder_password);
		$this->session->set_flashdata('message', 'Forwarder telah berhasil ditambahkan');
		redirect('pg_admin/forwarder', 'refresh');
	}

	public function remove($id){
		$data = $this->mforwarder->delete_forwarder($id);
		$this->session->set_flashdata('message', 'Forwarder telah berhasil dihapus');
		redirect('pg_admin/forwarder', 'refresh');
	}
}

?>