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

	public function insert_forwarder($email, $password){
		$data = array(
			'FORWARDER_EMAIL' => $email,
			'FORWARDER_PASSWORD' => $password
			);
		$this->db->insert('forwarder', $data);
	}

	public function delete_forwarder($forwarder_id){
		$data = array('FORWARDER_ID' => $forwarder_id);
		$this->db->delete('forwarder', $data);
	}
}

?>