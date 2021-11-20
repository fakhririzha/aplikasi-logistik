<?php
/**
* @author Thony Hermawan
*/
class Mdetilpengiriman extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function insert($id_barang, $id_pengiriman)
	{
		$data = array('id_barang' => $id_barang, 'id_pengiriman' => $id_pengiriman);
		$this->db->insert('detil_pengiriman', $data);
	}

	public function delete($id_barang, $id_pengiriman)
	{
		$current_id_biaya = $this->db->get_where('pengiriman', ['id_pengiriman' => $id_pengiriman])->row()->ID_BIAYA;
		$base_biaya = $this->db->get_where('biaya_pengiriman', ['id_biaya' => $current_id_biaya])->row()->BIAYA;
		$berat_to_reduce = $this->db->get_where('barang', ['id_barang' => $id_barang])->row()->BERAT_BARANG;
		$current_berat = $this->db->get_where('pengiriman', ['id_pengiriman' => $id_pengiriman])->row()->BERAT_PENGIRIMAN;
		$new_berat = $current_berat - $berat_to_reduce;

		$updated_biaya = $base_biaya * intval($new_berat);

		if(intval($new_berat) == 0) {
			$updated_biaya = $base_biaya;
		}

		$data = array('id_barang' => $id_barang, 'id_pengiriman' => $id_pengiriman);
		$this->db->delete('detil_pengiriman', $data);

		$this->db->where('id_pengiriman', $id_pengiriman);
		$this->db->update('pengiriman', [
			'berat_pengiriman' => $new_berat,
			'biaya_pengiriman' => $updated_biaya
		]);
	}

}
?>