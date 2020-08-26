<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

	public function __construct() {
		parent::__construct();
		// if(!$this->session->userdata('isLogin')){
		//  redirect('login');

		$this->load->model('Menu_model', 'menu_model');

	}

	public function index() {
		$KdTable = decrypt($this->input->get('tbl'));

		$arrMenuAll = $this->menu_model->getMenu()->result_array();
		$arrKategori = $this->menu_model->getKategoriMenu()->result_array();
		$arrDataMenu = array();
		foreach ($arrKategori as $key => $valKategori) {
			$menuKategori = $this->menu_model->getMenuByKategori($valKategori['KdSubKategori'])->result_array();
			foreach ($menuKategori as $key => $valMenuKategori) {
				$arrDataMenu[$valKategori['KdSubKategori']][] = array(
					'PCode' => $valMenuKategori['PCode'],
					'NamaLengkap' => $valMenuKategori['NamaLengkap'],	
					'Deskripsi' => $valMenuKategori['Deskripsi'],
					'Harga1c' => $valMenuKategori['Harga1c'],
					'KdSubKategori' => $valMenuKategori['KdSubKategori'],
				);
			}
		}
		$arrQtyOrder = $this->menu_model->totalQtyOrder($KdTable)->row();
		$totalQtyOrder = $arrQtyOrder->Qty;
		$data['kategori'] = $arrKategori;
		$data['menu'] = $arrDataMenu;
		$data['menu_all'] = $arrMenuAll;
		$data['KdTable'] = $KdTable;
		$data['totalQtyOrder'] = $totalQtyOrder;
		$this->load->view('view_menu', $data);
	}

	public function addOrderTemp() {
		$KdTable = $this->input->post('KdTable');
		$PCode = $this->input->post('PCode');
		$Qty = $this->input->post('Qty');
		$Note = $this->input->post('Note');

		$cekOrderHeader = $this->db->get_where('order_temp', array('KdTable' => $KdTable, 'Status' => '0'))->row();
		if (empty($cekOrderHeader)) {
			$insertOrder = $this->db->insert('order_temp', array('KdTable' => $KdTable, 'Status' => '0'));
			$IdOrder = $this->db->insert_id();
		} else {
			$arrOrderHeader = $this->db->get_where('order_temp', array('KdTable' => $KdTable, 'Status' => '0'))->row();
			$IdOrder = $arrOrderHeader->IdOrder;
		}

		$cekOrderDetail = $this->menu_model->cekOrderDetail($PCode, $KdTable)->result_array();
		if (empty($cekOrderDetail)) {
			$data = array(
				'IdOrder' => $IdOrder,
				'PCode' => $PCode,
				'Qty' => $Qty,
				'Note' => $Note,
				'KdTable' => $KdTable,
				'StatusDetail' => '0',
			);
			$insertDetail = $this->menu_model->addOrderDetailTemp($data);
			if ($insertDetail == TRUE) {
				$return = "success";
			} else {
				$return = "failed";
			}
		} else {
			$updateDetail = $this->menu_model->editOrderDetailTemp($KdTable, $PCode, $Qty);
			if ($updateDetail == TRUE) {
				$return = "success";
			} else {
				$return = "failed";
			}
		}
		$arrQtyOrder = $this->menu_model->totalQtyOrder($KdTable)->row();
		$totalQtyOrder = $arrQtyOrder->Qty;
		echo json_encode(array('message' => $return, 'totalQtyOrder' => $totalQtyOrder));
	}

	public function getPesanan() {
		$KdTable = $this->input->post('KdTable');

		$arrQtyOrder = $this->menu_model->totalQtyOrder($KdTable)->row();
		$totalQtyOrder = $arrQtyOrder->Qty;

		$ArrPesanan = $this->menu_model->getPesanan($KdTable)->result_array();

		$QCodeNameFile2 = '';
		if (!empty($ArrPesanan)) {
			$dataQRCode = '';
			foreach ($ArrPesanan as $key => $value) {
				$dataQRCode .= $value['KdTable'] . "*" . $value['PCode'] . "*" . $value['Qty'] . "*" . $value['Note'] . "**";
			}

			$namafile2 = $ArrPesanan[0]['IdOrder'] . "-2";
			$QCodeNameFile2 = $this->generateQRCode($dataQRCode, $namafile2);
			$this->db->update('order_temp', array('QRCOde2' => $QCodeNameFile2), array('IdOrder' => $ArrPesanan[0]['IdOrder']));

		} else {
			// hapus barcode
			$arrOrderHeader = $this->db->get_where('order_temp', array('KdTable' => $KdTable, 'Status' => '0'))->row();
			if(!empty($arrOrderHeader)){
				$QRCode2 = $arrOrderHeader->QRCode2;
				if (!empty($QRCode2)) {
					if (unlink('assets/images/QRCodeOrder/' . $QRCode2)) {
						$this->db->update('order_temp', array('QRCode2' => ''), array('KdTable' => $KdTable, 'Status' => '0'));
					}
				}
			}
		}

		echo json_encode(array('message' => 'success', 'QRCode2' => $QCodeNameFile2, 'totalQtyOrder' => $totalQtyOrder, 'data' => $ArrPesanan));
	}

	public function getPesananFix() {
		$KdTable = $this->input->post('KdTable');

		$ArrPesanan = $this->menu_model->getPesananFix($KdTable)->result_array();

		$QCodeNameFile1 = '';
		if (!empty($ArrPesanan)) {
			$dataQRCode = '';
			foreach ($ArrPesanan as $key => $value) {
				$dataQRCode .= $value['KdTable'] . "*" . $value['PCode'] . "*" . $value['Qty'] . "*" . $value['Note'] . "**";
			}

			$namafile1 = $ArrPesanan[0]['IdOrder'] . "-1";
			$QCodeNameFile1 = $this->generateQRCode($dataQRCode, $namafile1);
			$this->db->update('order_temp', array('QRCOde1' => $QCodeNameFile1), array('IdOrder' => $ArrPesanan[0]['IdOrder']));
		}
		echo json_encode(array('message' => 'success', 'QRCode1' => $QCodeNameFile1, 'data' => $ArrPesanan));
	}

	public function editOrderTemp() {
		$IdOrderDetailTemp = $this->input->post('IdOrderDetailTemp');
		$KdTable = $this->input->post('KdTable');
		$Qty = $this->input->post('Qty');
		$Note = $this->input->post('Note');
		$updateDetail = $this->menu_model->updateOrderDetailTemp($IdOrderDetailTemp, $Qty, $Note);
		if ($updateDetail == TRUE) {
			$return = "success";
		} else {
			$return = "failed";
		}
		$arrQtyOrder = $this->menu_model->totalQtyOrder($KdTable)->row();
		$totalQtyOrder = $arrQtyOrder->Qty;
		echo json_encode(array('message' => $return, 'totalQtyOrder' => $totalQtyOrder));
	}

	public function cancelDetailOrder() {
		$IdOrderDetailTemp = $this->input->post('IdOrderDetailTemp');
		$KdTable = $this->input->post('KdTable');
		$cancelDetail = $this->menu_model->cancelDetailOrder($IdOrderDetailTemp);
		if ($cancelDetail == TRUE) {
			$return = "success";
		} else {
			$return = "failed";
		}
		$arrQtyOrder = $this->menu_model->totalQtyOrder($KdTable)->row();
		$totalQtyOrder = $arrQtyOrder->Qty;
		echo json_encode(array('message' => $return, 'totalQtyOrder' => $totalQtyOrder));
	}

	public function pesan() {
		$KdTable = $this->input->post('KdTable');
		$NamaPemesan = $this->input->post('NamaPemesan');

		$this->db->where(array('KdTable' => $KdTable, 'Status' => '0'));
		$insertOrder = $this->db->update('order_temp', array('KdTable' => $KdTable, 'NamaCustomer' => $NamaPemesan));

		$this->db->where(array('KdTable' => $KdTable, 'StatusDetail' => '0'));
		$updateDetail = $this->db->update('order_detail_temp', array('StatusDetail' => '1'));

		if ($updateDetail == TRUE) {
			$return = "success";
		} else {
			$return = "failed";
		}

		echo json_encode(array('message' => $return));

	}

	public function clearTable(){
		$KdTable = $this->input->post('KdTable');
		$this->db->where(array('KdTable' => $KdTable, 'Status' => '0'));
		$updateOrder = $this->db->update('order_temp', array('Status' => '2'));
		if ($updateOrder == TRUE) {
			$this->db->where(array('KdTable' => $KdTable, 'StatusDetail' => '0'));
			$this->db->update('order_detail_temp', array('StatusDetail' => '2'));

			$return = "success";
		} else {
			$return = "failed";
		}

		echo json_encode(array('message' => $return));

	}

	public function generateQRCode($data = '', $name_image = 'test') {
		$this->load->library('ciqrcode'); //pemanggilan library QR CODE

		$config['cacheable'] = true; //boolean, the default is true
		$config['cachedir'] = './assets/'; //string, the default is application/cache/
		$config['errorlog'] = './assets/'; //string, the default is application/logs/
		$config['imagedir'] = './assets/images/QRCodeOrder/'; //direktori penyimpanan qr code
		$config['quality'] = true; //boolean, the default is true
		$config['size'] = '1024'; //interger, the default is 1024
		$config['black'] = array(224, 255, 255); // array, default is array(255,255,255)
		$config['white'] = array(70, 130, 180); // array, default is array(0,0,0)
		$this->ciqrcode->initialize($config);

		$image_name = $name_image . '.png'; //buat name dari qr code sesuai dengan nim

		$params['data'] = $data; //data yang akan di jadikan QR CODE
		$params['level'] = 'H'; //H=High
		$params['size'] = 10;
		$params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
		$this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

		return $image_name;
	}
}
