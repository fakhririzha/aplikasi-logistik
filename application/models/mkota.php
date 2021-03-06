<?php

/**
 * 
 */
class Mkota extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('mprovinsi');
	}

	public function getAllKota()
	{
		$data = array();
		$query = $this->db->query("
			SELECT
				kota.ID_KOTA AS id_kota,
				provinsi.NAMA_PROVINSI AS nama_provinsi,
				kota.NAMA_KOTA AS nama_kota
			FROM
				kota,
				provinsi
			WHERE
				provinsi.ID_PROVINSI = kota.ID_PROVINSI
			ORDER BY
				kota.NAMA_KOTA ASC
		");
		// $this->db->order_by('nama_provinsi', 'asc');
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$data[] = $row;
			}
		}
		$query->free_result();
		return $data;
	}

	public function getAllKotaExcept($nama_kota)
	{
		$data = array();
		$query = $this->db->query("
			SELECT
				kota.ID_KOTA AS id_kota,
				provinsi.NAMA_PROVINSI AS nama_provinsi,
				kota.NAMA_KOTA AS nama_kota
			FROM
				kota,
				provinsi
			WHERE
				kota.NAMA_KOTA != '" . $nama_kota . "'
				AND provinsi.ID_PROVINSI = kota.ID_PROVINSI
			ORDER BY
				kota.NAMA_KOTA ASC
		");
		// $this->db->order_by('nama_provinsi', 'asc');
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$data[] = $row;
			}
		}
		$query->free_result();
		return $data;
	}

	public function get_all_kota_by_alphabet()
	{
		$data = array();
		$query = $this->db->order_by('nama_kota', 'asc')->get('kota');
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$data[] = $row;
			}
		}
		$query->free_result();
		return $data;
	}

	public function getAllKotaBiaya()
	{
		$data = array();
		$query = $this->db->get('view_all_kota_biaya');
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$data[] = $row;
			}
		}
		$query->free_result();
		return $data;
	}
	public function getKotaNotEqual($nama_kota)
	{
		$data = array();
		$this->db->select('id_kota, nama_kota');
		$this->db->from('kota');
		$this->db->where('nama_kota !=', $nama_kota);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$data[] = $row;
			}
		}
		$query->free_result();
		return $data;
	}

	public function getIdKota($id_provinsi, $kota)
	{
		$data = array();
		$param = array(
			'id_provinsi' => $id_provinsi,
			'nama_kota' => $kota
		);
		$this->db->select('id_kota');
		$query = $this->db->get_where('kota', $param, 1);
		if ($query->num_rows() > 0) {
			$data[] = $query->row_array();
		}
		$query->free_result();
		return $data;
	}

	public function getNamaKotaById($id_kota)
	{
		$data = array();
		$this->db->select('nama_kota');
		$this->db->where('id_kota', $id_kota);
		$this->db->limit(1);
		$query = $this->db->get('kota');
		if ($query->num_rows() > 0) {
			$data[] = $query->row_array();
		}
		$query->free_result();
		return $data;
	}

	public function getAllProvinsi()
	{
		$data = array();
		$this->db->select('id_provinsi, nama_provinsi');
		$query = $this->db->get('provinsi');
		$this->db->order_by('nama_provinsi', 'asc');
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$data[] = $row;
			}
		}
		$query->free_result();
		return $data;
	}

	public function addProvinsi($nama_provinsi)
	{
		$data = array('nama_provinsi' => $nama_provinsi);
		$this->db->insert('provinsi', $data);
	}

	public function addKota($id_provinsi, $nama_kota)
	{
		$data = array(
			'id_provinsi' => $id_provinsi,
			'nama_kota' => $nama_kota
		);
		$this->db->insert('kota', $data);
		return $data;
	}
}
