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

	public function get_all_forwarder()
	{
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

	public function get_informasi_forwarder_by_id($id_forwarder)
	{
		$data = array();
		$query = $this->db->where('FORWARDER_ID', $id_forwarder)->get('view_all_forwarder');
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$data[] = $row;
			}
		}
		$query->free_result();
		return $data;
	}

	public function get_all_armada()
	{
		$data = array();
		$query = $this->db->get('view_all_armada');
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$data[] = $row;
			}
		}
		$query->free_result();
		return $data;
	}

	public function get_all_armada_by_forwarder_id($forwarder_id)
	{
		$data = array();
		$query = $this->db->get_where('view_all_armada', [
			'ARMADA_FORWARDER_ID' => $forwarder_id
		]);
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$data[] = $row;
			}
		}
		$query->free_result();
		return $data;
	}

	public function get_armada_info_by_id($armada_id)
	{
		$data = array();
		$query = $this->db->get_where('view_all_armada', [
			'ARMADA_ID' => $armada_id
		]);
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$data[] = $row;
			}
		}
		$query->free_result();
		return $data;
	}

	public function get_all_kota_kecuali_armada_tertentu($nama_kota)
	{
		$data = array();
		$this->db->select('id_kota, nama_provinsi, nama_kota');
		$this->db->where('NAMA_KOTA !=', $nama_kota);
		$this->db->from('kota');
		$this->db->join('provinsi', 'provinsi.id_provinsi = kota.id_provinsi');
		$query = $this->db->get();
		$this->db->order_by('nama_provinsi', 'asc');
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$data[] = $row;
			}
		}
		$query->free_result();
		return $data;
	}

	public function get_all_pengiriman_by_forwarder($id)
	{
		$data = array();
		$query = $this->db->query(
			"
		SELECT * FROM armada
		WHERE ARMADA_FORWARDER_ID = '" . $id . "'
		JOIN pengiriman
		ON ID_ARMADA_PENGIRIMAN = ARMADA_ID
		"
		);
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$data[] = $row;
			}
		}
		$query->free_result();
		return $data;
	}

	public function get_all_pengiriman_by_armada_belum_disusun($id)
	{
		$data = array();
		$query = $this->db->query(
			"
		SELECT * FROM armada
		JOIN view_pengiriman_sudah_diproses
		ON ID_ARMADA_PENGIRIMAN = ARMADA_ID
		WHERE ARMADA_ID = '" . $id . "' AND STATUS_URUTAN = 'Belum'
		"
		);
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$data[] = $row;
			}
		}
		$query->free_result();
		return $data;
	}

	public function get_all_pengiriman_by_armada_sudah_disusun($id)
	{
		$data = array();
		$query = $this->db->query(
			"
		SELECT * FROM armada
		JOIN view_pengiriman_sudah_diproses
		ON ID_ARMADA_PENGIRIMAN = ARMADA_ID
		WHERE ARMADA_ID = '" . $id . "' AND STATUS_URUTAN = 'Sudah'
		"
		);
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$data[] = $row;
			}
		}
		$query->free_result();
		return $data;
	}

	public function get_informasi_pengiriman($forwarder_id, $num, $offset)
	{
		$this->db->where('FORWARDER_ID', $forwarder_id);
		$query = $this->db->get('view_pengiriman_detail', $num, $offset);
		return $query->result_array();
	}

	public function get_muatan_armada_by_id($id_armada, $num, $offset)
	{
		$this->db->where('MUATAN_ARMADA_ID', $id_armada);
		$query = $this->db->get('muatan_armada', $num, $offset);
		return $query->result_array();
	}

	public function update_forwarder($id_forwarder, $nama, $email, $password, $asal, $tujuan)
	{
		$data = array(
			'FORWARDER_NAMA' => $nama,
			'FORWARDER_EMAIL' => $email,
			'FORWARDER_PASSWORD' => $password,
			'FORWARDER_ID_KOTA_ASAL' => $asal,
			'FORWARDER_ID_KOTA_TUJUAN' => $tujuan,
		);
		$this->db->where('FORWARDER_ID', $id_forwarder);
		$this->db->update('forwarder', $data);
	}

	public function insert_forwarder($nama, $email, $password, $asal, $tujuan)
	{
		$data = array(
			'FORWARDER_NAMA' => $nama,
			'FORWARDER_EMAIL' => $email,
			'FORWARDER_PASSWORD' => $password,
			'FORWARDER_ID_KOTA_ASAL' => $asal,
			'FORWARDER_ID_KOTA_TUJUAN' => $tujuan,
		);
		$this->db->insert('forwarder', $data);
	}

	public function masukin()
	{
		for ($x = 1; $x <= 150; $x++) {
			$data = array(
				'MUATAN_ARMADA_ID' => '1',
				'MUATAN_SLOT_ID' => $x,
			);
			$this->db->insert('muatan_armada', $data);
		}
	}

	public function insert_armada($nama, $forwarder_id, $kapasitas, $panjangArmada, $lebarArmada, $tinggiArmada, $asal, $tujuan)
	{
		$data = array(
			'ARMADA_FORWARDER_ID' => $forwarder_id,
			'ARMADA_NAMA' => $nama,
			'ARMADA_KAPASITAS' => $kapasitas,
			'ARMADA_KAPASITAS_TERSEDIA' => $kapasitas,
			'ARMADA_PANJANG' => $panjangArmada,
			'ARMADA_LEBAR' => $lebarArmada,
			'ARMADA_TINGGI' => $tinggiArmada,
			'ARMADA_ID_KOTA_ASAL' => $asal,
			'ARMADA_ID_KOTA_TUJUAN' => $tujuan,
		);
		$this->db->insert('armada', $data);

		$last_id = $this->db->insert_id();

		$volume = intval($panjangArmada) * intval($lebarArmada) * intval($tinggiArmada);
		for ($x = 1; $x <= $volume; $x++) {
			$dataMuatan = array(
				'MUATAN_ARMADA_ID' => $last_id,
				'MUATAN_SLOT_ID' => $x
			);
			$this->db->insert('muatan_armada', $dataMuatan);
		}
	}

	public function ubah_armada($nama, $id_armada, $kapasitas, $asal, $tujuan)
	{
		$data = array(
			'ARMADA_NAMA' => $nama,
			'ARMADA_KAPASITAS' => $kapasitas,
			'ARMADA_ID_KOTA_ASAL' => $asal,
			'ARMADA_ID_KOTA_TUJUAN' => $tujuan,
		);
		$this->db->where('ARMADA_ID', $id_armada);
		$this->db->update('armada', $data);
	}

	public function update_forwarder_armada_pengiriman($id_forwarder, $id_armada, $id_pengiriman, $berat_total_pengiriman)
	{
		$berat_tersedia_armada = $this->db->get_where("armada", [
			"ARMADA_ID" => $id_armada
		])->row_array();
		$berat_sisa = intval($berat_tersedia_armada['ARMADA_KAPASITAS_TERSEDIA']) - $berat_total_pengiriman;

		if ($berat_sisa < 0) {
			return 0;
		} else {
			$data = array(
				'ID_FORWARDER_PENGIRIMAN' => $id_forwarder,
				'ID_ARMADA_PENGIRIMAN' => $id_armada,
				'STATUS_URUTAN' => 'Belum'
			);
			$this->db->where('ID_PENGIRIMAN', $id_pengiriman);
			$this->db->update('pengiriman', $data);

			$data2 = array(
				'ARMADA_KAPASITAS_TERSEDIA' => $berat_sisa
			);
			$this->db->where('ARMADA_ID', $id_armada);
			$this->db->update('armada', $data2);

			return 1;
		}
	}

	// public function hapus_armada($id_armada){
	// 	$this->db->where('ARMADA_ID', $id_armada);
	// 	$this->db->delete('armada');
	// }

	public function delete_forwarder($forwarder_id)
	{
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
