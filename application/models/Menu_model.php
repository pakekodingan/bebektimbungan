<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model {

	public function getKategoriMenu() {
		$this->db->select('subkategoripos.KdSubKategori,subkategoripos.NamaSubKategori');
		$this->db->from('masterbarang_touch');
		$this->db->join('subkategoripos', 'masterbarang_touch.KdSubKategori = subkategoripos.KdSubKategori', 'INNER');
		$this->db->join('masterbarang', 'masterbarang_touch.PCode = masterbarang.PCode', 'INNER');
		$this->db->where('masterbarang.Status', 'A');
		$this->db->order_by('subkategoripos.NamaSubKategori', 'DESC');
		$this->db->group_by('subkategoripos.KdSubKategori');
		return $this->db->get();
	}

	public function getMenuByKategori($KdSubKategori) {
		$this->db->select(
			'masterbarang_touch.PCode,
			masterbarang_touch.NamaLengkap,
			masterbarang_touch.Deskripsi,
			masterbarang_touch.KdSubKategori,
			masterbarang_touch.Harga1c,
			masterbarang.Service_charge,
			masterbarang.PPN'
		);
		$this->db->from('masterbarang_touch');
		$this->db->join('masterbarang', 'masterbarang_touch.PCode = masterbarang.PCode', 'INNER');
		$this->db->where('masterbarang_touch.KdSubKategori', $KdSubKategori);
		$this->db->where('masterbarang.Status', 'A');
		return $this->db->get();
	}

	public function getMenu() {
		$this->db->select(
			'masterbarang_touch.PCode,
			masterbarang_touch.NamaLengkap,
			masterbarang_touch.Deskripsi,
			masterbarang_touch.KdSubKategori,
			masterbarang_touch.Harga1c,
			masterbarang.Service_charge,
			masterbarang.PPN'
		);
		$this->db->from('masterbarang_touch');
		$this->db->join('masterbarang', 'masterbarang_touch.PCode = masterbarang.PCode');
		$this->db->where('masterbarang.Status', 'A');
		$this->db->order_by('NamaLengkap');
		return $this->db->get();
	}

	public function addOrderDetailTemp($data) {
		$result = $this->db->insert('order_detail_temp', $data);
		return $result;
	}

	public function cekOrderDetail($PCode, $KdTable) {
		$where = array('KdTable' => $KdTable, 'PCode' => $PCode, 'StatusDetail' => '0');
		$result = $this->db->get_where('order_detail_temp', $where);

		return $result;
	}

	public function editOrderDetailTemp($KdTable, $PCode, $Qty) {
		$this->db->set('Qty', 'Qty + ' . $Qty, FALSE);
		$this->db->where('KdTable', $KdTable);
		$this->db->where('PCode', $PCode);
		$this->db->where('StatusDetail', '0');
		$result = $this->db->update('order_detail_temp');

		return $result;
	}

	public function totalQtyOrder($KdTable) {
		$this->db->select_sum('Qty');
		$this->db->from('order_detail_temp');
		$this->db->where('KdTable', $KdTable);
		$this->db->where('StatusDetail', '0');
		$result = $this->db->get();

		return $result;
	}

	public function getPesanan($KdTable) {
		$this->db->select(
			'order_detail_temp.IdOrderDetailTemp,
			order_temp.IdOrder,
			order_detail_temp.KdTable,
			order_detail_temp.PCode,
			order_detail_temp.Qty,
			order_detail_temp.Note,
			masterbarang_touch.NamaLengkap,
			masterbarang_touch.Harga1c'
		);

		$this->db->from('order_temp');
		$this->db->join('order_detail_temp', 'order_temp.IdOrder = order_detail_temp.IdOrder');
		$this->db->join('masterbarang_touch', 'order_detail_temp.PCOde = masterbarang_touch.PCode');
		$this->db->where('order_temp.KdTable', $KdTable);
		$this->db->where('order_temp.Status', '0');
		$this->db->where('order_detail_temp.StatusDetail', '0');
		$this->db->order_by('order_detail_temp.Note', 'DESC');

		$result = $this->db->get();

		return $result;
	}

	public function getPesananFix($KdTable) {
		$this->db->select(
			'order_temp.NamaCustomer,
			order_detail_temp.IdOrderDetailTemp,
			order_temp.IdOrder,
			order_detail_temp.KdTable,
			order_detail_temp.PCode,
			SUM(order_detail_temp.Qty) AS Qty,
			order_detail_temp.Note,
			masterbarang_touch.NamaLengkap,
			masterbarang_touch.Harga1c'
		);

		$this->db->from('order_temp');
		$this->db->join('order_detail_temp', 'order_temp.IdOrder = order_detail_temp.IdOrder');
		$this->db->join('masterbarang_touch', 'order_detail_temp.PCOde = masterbarang_touch.PCode');
		$this->db->where('order_temp.KdTable', $KdTable);
		$this->db->where('order_temp.Status', '0');
		$this->db->where('order_detail_temp.StatusDetail', '1');
		$this->db->group_by(array("order_detail_temp.IdOrder", "order_detail_temp.PCode"));
		$this->db->order_by('order_detail_temp.Note', 'DESC');

		$result = $this->db->get();

		return $result;
	}

	public function updateOrderDetailTemp($IdOrderDetailTemp, $Qty, $Note) {
		$this->db->where('IdOrderDetailTemp', $IdOrderDetailTemp);
		$result = $this->db->update('order_detail_temp', array('Qty' => $Qty, 'Note' => $Note));
		return $result;
	}

	public function cancelDetailOrder($IdOrderDetailTemp) {
		$result = $this->db->delete('order_detail_temp', array('IdOrderDetailTemp' => $IdOrderDetailTemp));
		return $result;
	}
}
