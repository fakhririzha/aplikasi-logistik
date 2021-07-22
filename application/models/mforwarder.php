<?php
/**
* 
*/
class Mforwarder extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

    public function get_all_forwarder(){
        $data = array();
        $query = $this->db->get('view_all_forwarder');
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$data[] = $row;
			}
		}
		$query->free_result();
		return $data;
    }

	public function insert_forwarder($nama, $email, $password, $asal, $tujuan){
		$data = array(
			'FORWARDER_NAMA' => $nama,
			'FORWARDER_EMAIL' => $email,
			'FORWARDER_PASSWORD' => $password,
			'FORWARDER_ID_KOTA_ASAL' => $asal,
			'FORWARDER_ID_KOTA_TUJUAN' => $tujuan,
			);
		$this->db->insert('forwarder', $data);
	}

	public function delete_forwarder($forwarder_id){
		$data = array('FORWARDER_ID' => $forwarder_id);
		$this->db->delete('forwarder', $data);
	}

	function validasi_login($email, $password)
	{
		$this->db->select('FORWARDER_ID, FORWARDER_EMAIL, FORWARDER_PASSWORD');
		$this->db->where('FORWARDER_EMAIL', $email);
		$this->db->where('FORWARDER_PASSWORD', $password);
		$this->db->limit(1);
		$query = $this->db->get('forwarder');
		$this->session->set_userdata('lastquery', $this->db->last_query());
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			return $row;
		} else {
			$this->session->set_flashdata('error', 'Maaf, silahkan coba lagi!');
			return array();
		}
	}
}

?>