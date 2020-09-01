<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masterbarang extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // if(!$this->session->userdata('isLogin')){
        //  redirect('login');

        $this->load->model('Masterbarang_model', 'masterbarang_model');

    }

    function index(){
        $data['Kategori'] = $this->masterbarang_model->get_kategori()->result_array();
        $this->load->view('view_masterbarang',$data);
    }
 
    function get_data_masterbarang()
    {
        $list = $this->masterbarang_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $no.".";
            $row[] = $field->PCode;
            $row[] = $field->NamaLengkap;
            $row[] = '<img src="'.base_url('assets/images/product/'.$field->Image).'" alt="..." class="img-thumbnail" width="40">';
            $row[] = '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" onclick="edit(\''.$field->PCode.'\',\''.$field->NamaLengkap.'\',\''.$field->Harga1c.'\',\''.$field->Image.'\',\''.$field->KdSubKategori.'\',\''.$field->Deskripsi.'\')">Edit</button>';
 
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->masterbarang_model->count_all(),
            "recordsFiltered" => $this->masterbarang_model->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    function save(){
        $pcode = $this->input->post('pcode');
        $nama_lengkap = $this->input->post('nama_lengkap');
        $kategori = $this->input->post('kategori');
        $harga = $this->input->post('harga');
        $deskripsi = $this->input->post('deskripsi');
        $gambar = $_FILES['gambar'];

        if(!empty($_FILES['gambar']['name'])){ 
            $image = str_replace(" ", "_", $_FILES['gambar']['name']);
            $config['upload_path']          = './assets/images/product/';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['filename']          = $image;
            // $config['max_width']         = 1024;
            // $config['max_height']        = 768;

            $this->masterbarang_model->delete_image_old($pcode);
            
            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('gambar'))
            {
                $error = array('error' => $this->upload->display_errors());
            }
            else
            {   
                $this->masterbarang_model->update_masterbarang($pcode,$nama_lengkap,$kategori,$harga,$image,$deskripsi);
                $data = array('upload_data' => $this->upload->data());
            }
        }else{
             $this->masterbarang_model->update_masterbarang_2($pcode,$nama_lengkap,$kategori,$harga,$deskripsi);
        }

        echo json_encode(array('message'=>'success'));
    }

}

?>