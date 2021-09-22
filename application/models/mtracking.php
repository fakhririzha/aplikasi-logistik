<?php

/**
 * @author Thony Hermawan
 */
class Mtracking extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getAllTracking()
	{
		$data = array();
		$this->db->select('no_resi, id_pengiriman, id_cust, status_pengiriman, tanggal, posisi, keterangan');
		$this->db->from('tracking');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$data[] = $row;
			}
		}
		$query->free_result();
		return $data;
	}

	public function getTrackingForCust($id_cust)
	{
		$data = array();
		$query = $this->db->query('select no_resi, id_pengiriman, id_cust, status_pengiriman, tanggal, posisi, keterangan
			from tracking where id_cust = ' . $id_cust . ' group by no_resi order by tanggal asc');
		//$this->db->select('no_resi, id_pengiriman, id_cust, status_pengiriman, tanggal, posisi, keterangan');
		//$this->db->from('tracking');
		//$this->db->where('id_cust', $id_cust);
		//$query = $this->db->get();
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$data[] = $row;
			}
		}
		$query->free_result();
		return $data;
	}

	public function get_status_pembayaran_by_id_cust($id_cust)
	{
		$data = array();
		$query = $this->db->query(
			'
				SELECT
					t.ID_CUST,
					t.NO_RESI,
					p.ID_PENGIRIMAN,
					p.ID_BIAYA,
					p.BIAYA_PENGIRIMAN,
					p.STATUS_PEMBAYARAN
				FROM
					pengiriman p,
					tracking t
				WHERE
					t.ID_CUST = ' . $id_cust . '
					AND p.ID_PENGIRIMAN = t.ID_PENGIRIMAN
					AND p.STATUS_PEMBAYARAN = "Belum Dibayar"
					AND p.ID_ARMADA_PENGIRIMAN IS NOT NULL
				GROUP BY
					t.NO_RESI
			'
		);
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$data[] = $row;
			}
		}
		$query->free_result();
		return $data;
	}

	public function get_status_pembayaran_paket_by_resi($no_resi)
	{
		$data = array();
		$query = $this->db->query(
			'
				SELECT
					t.ID_CUST,
					t.NO_RESI,
					p.ID_PENGIRIMAN,
					p.ID_BIAYA,
					p.BIAYA_PENGIRIMAN,
					p.STATUS_PEMBAYARAN
				FROM
					pengiriman p,
					tracking t
				WHERE
					t.NO_RESI = \'' . $no_resi . '\'
					AND p.ID_PENGIRIMAN = t.ID_PENGIRIMAN
				GROUP BY
					t.NO_RESI
			'
		);
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$data[] = $row;
			}
		}
		$query->free_result();
		return $data;
	}

	public function update_status_pembayaran($ID_PENGIRIMAN)
	{
		$data = array(
			'STATUS_PEMBAYARAN' => 'Sudah Dibayar'
		);
		$this->db->where('ID_PENGIRIMAN', $ID_PENGIRIMAN);
		$this->db->update('pengiriman', $data);
	}

	public function detil_tracking($no_resi)
	{
		$data = array();
		$query = $this->db->query("select no_resi, id_pengiriman, id_cust, status_pengiriman, tanggal, posisi, keterangan
			from tracking where no_resi = '" . $no_resi . "' order by tanggal desc");
		//$this->db->select('no_resi, id_pengiriman, id_cust, status_pengiriman, tanggal, posisi, keterangan');
		//$this->db->from('tracking');
		//$this->db->where('no_resi', $no_resi);
		//$query = $this->db->get();
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$data[] = $row;
			}
		}
		$query->free_result();
		return $data;
	}

	public function det_tracking($no_resi)
	{
		$data = array();
		$param = array('no_resi' => $no_resi);
		$query = $this->db->get_where('view_det_tracking', $param);
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$data[] = $row;
			}
		}
		$query->free_result();
		return $data;
	}

	public function generate_no_resi()
	{
		$karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$angka = '1234567890';
		$string = '';
		for ($i = 0; $i < 4; $i++) {
			$pos = rand(0, strlen($karakter) - 1);
			$string .= $karakter{
				$pos};
		}
		for ($i = 0; $i < 6; $i++) {
			$pos = rand(0, strlen($angka) - 1);
			$string .= $angka{
				$pos};
		}
		return $string;
	}

	public function insert($no_resi, $id_pengiriman, $id_cust, $status_pengiriman, $tanggal, $posisi, $keterangan)
	{
		if ($status_pengiriman = "Selesai") {

			$berat = $this->db->where("berat_total_pengiriman", $id_pengiriman)->get('view_pengiriman_sedang_diproses');

			$kapasitas = $this->db->where("ARMADA_ID", $berat->row_array()['ID_ARMADA_PENGIRIMAN'])->get('armada')->row_array()['ARMADA_KAPASITAS_TERSEDIA'];
			$berat_pengiriman = $berat->row_array()['berat_total_pengiriman'];
			$this->db->where([
				"ARMADA_KAPASITAS_TERSEDIA" => intval($berat_pengiriman) + $kapasitas,
			])->update("ARMADA");

			$this->sortir_isi_armada($berat->row_array()['ID_ARMADA_PENGIRIMAN']);
		}
		$data = array(
			'no_resi' => $no_resi,
			'id_pengiriman' => $id_pengiriman,
			'id_cust' => $id_cust,
			'status_pengiriman' => $status_pengiriman,
			'tanggal' => $tanggal,
			'posisi' => $posisi,
			'keterangan' => $keterangan
		);
		$this->db->insert('tracking', $data);
	}

	public function sortir_isi_armada($id_armada)
	{
		$check_isi = $this->db->where(["MUATAN_PENGIRIMAN_ID !=" => 0, "MUATAN_ARMADA_ID" => 1])->get("muatan_armada")->num_rows();

		$blm_disusun = $this->mforwarder->get_all_pengiriman_by_armada_belum_disusun($id_armada);

		if ($check_isi > 0) {
			$sdh_disusun = $this->mforwarder->get_all_pengiriman_by_armada_sudah_disusun($id_armada);
			$unsortedPengirimanList = array_merge($blm_disusun, $sdh_disusun);
		} else {
			$unsortedPengirimanList = $blm_disusun;
		}

		$slotArmada = [];
		$query = $this->db->where("MUATAN_ARMADA_ID", $id_armada)->get('muatan_armada');
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$slotArmada[] = $row;
			}
		}

		usort($unsortedPengirimanList, function ($a, $b) {
			$retval = $b['JARAK'] <=> $a['JARAK'];
			// JARAK SAMA
			if ($retval == 0) {
				$retval = intval($a['berat_total_pengiriman']) <=> intval($b['berat_total_pengiriman']);
				if ($retval == 0) {
					$retval = 0;
				}
				// A lebih berat dari B
				else if ($retval == 1) {
					$retval = -1;
				}
				// B lebih berat dari A
				else if ($retval == -1) {
					$retval = 1;
				}
			}
			return $retval;
		});


		$sortedPengirimanList = $unsortedPengirimanList;

		// Fungsi untuk meng-assign pengiriman ke slot tersedia
		for ($i = 1; $i <= $slotArmada; $i++) {
			if (!array_key_exists($i - 1, $sortedPengirimanList)) {
				break;
			}

			$data = array(
				'MUATAN_PENGIRIMAN_ID' => $sortedPengirimanList[$i - 1]["ID_PENGIRIMAN"]
			);
			$this->db->where([
				"MUATAN_ARMADA_ID" => $id_armada,
				"MUATAN_SLOT_ID" => $i
			])->update('muatan_armada', $data);

			$data2 = array(
				'STATUS_URUTAN' => 'Sudah'
			);
			$this->db->where([
				"ID_PENGIRIMAN" => $sortedPengirimanList[$i - 1]["ID_PENGIRIMAN"]
			])->update('pengiriman', $data2);
		}
	}

	public function getNoResi($id_cust, $id_pengiriman)
	{
		$data = array();
		$param = array('id_cust' => $id_cust, 'id_pengiriman' => $id_pengiriman);
		$this->db->select('no_resi');
		$query = $this->db->get_where('tracking', $param, 1);
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$data[] = $row;
			}
		}
		$query->free_result();
		return $data;
	}

	public function ambil_tracking($num, $offset)
	{
		$query = $this->db->get('view_list_tracking', $num, $offset);
		return $query->result_array();
	}

	public function view_list_tracking()
	{
		$query = $this->db->get('view_list_tracking');
		return $query->result_array();
	}

	public function detil_barang($id_cust, $no_resi)
	{
		$param = array('no_resi' => $no_resi, 'id_cust' => $id_cust);
		$query = $this->db->get_where('view_barang_tracking', $param);
		return $query->result_array();
	}

	public function detil_pengiriman($id_cust, $no_resi)
	{
		$param = array('no_resi' => $no_resi, 'id_cust' => $id_cust);
		$query = $this->db->get_where('view_detil_pengiriman_tracking', $param);
		return $query->result_array();
	}
}
