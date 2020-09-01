<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masterbarang_model extends CI_Model {

    var $table = 'masterbarang'; 
    var $column_order = array(null, 'masterbarang.PCode','masterbarang.NamaLengkap','masterbarang.Harga1c','masterbarang.Image','masterbarang_touch.KdSubKategori','masterbarang_touch.Deskripsi'); 
    var $column_search = array('masterbarang.PCode','masterbarang.NamaLengkap','masterbarang.Harga1c','masterbarang.Image','masterbarang_touch.KdSubKategori','masterbarang_touch.Deskripsi'); 
    var $order = array('masterbarang.NamaLengkap' => 'asc');
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->DBTimbungan = $this->load->database('DBTimbungan',TRUE);
    }
 
    private function _get_datatables_query()
    {
        $this->db->select('masterbarang.PCode,masterbarang.NamaLengkap,masterbarang.Harga1c,masterbarang.Image,masterbarang_touch.KdSubKategori,masterbarang_touch.Deskripsi');
        $this->db->from($this->table);
        $this->db->join('masterbarang_touch','masterbarang.PCode = masterbarang_touch.PCode');
 
        $i = 0;
     
        foreach ($this->column_search as $item)
        {
            if($_POST['search']['value']) 
            {
                 
                if($i===0) 
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function get_kategori(){
        return $this->db->get('subkategoripos');
    }

    public function update_masterbarang($pcode,$nama_lengkap,$kategori,$harga,$image,$deskripsi){
        $this->db->update('masterbarang',array('NamaLengkap'=>$nama_lengkap,'Harga1c'=>$harga,'Image'=>$image),array('PCode'=>$pcode));
        $this->db->update('masterbarang_touch',array('NamaLengkap'=>$nama_lengkap,'KdSubKategori'=>$kategori,'Harga1c'=>$harga,'Deskripsi'=>$deskripsi),array('PCode'=>$pcode));
    }

    public function update_masterbarang_2($pcode,$nama_lengkap,$kategori,$harga,$deskripsi){
        $this->db->update('masterbarang',array('NamaLengkap'=>$nama_lengkap,'Harga1c'=>$harga),array('PCode'=>$pcode));
        $this->db->update('masterbarang_touch',array('NamaLengkap'=>$nama_lengkap,'KdSubKategori'=>$kategori,'Harga1c'=>$harga,'Deskripsi'=>$deskripsi),array('PCode'=>$pcode));
    }

    public function delete_image_old($pcode){

        $this->db->select('Image');
        $this->db->from('masterbarang');
        $this->db->where('PCode',$pcode);
        $query = $this->db->get();
        $arr = $query->row();

        if(!empty($arr->Image)){
            unlink('assets/images/product/'.$arr->Image);          
        }
    }
}

?>