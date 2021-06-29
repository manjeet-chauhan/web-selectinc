<?php

if (!defined('BASEPATH')) {
    exit('No Direct Script access allowed');
}

class Banner_model extends CI_Model {

    private $tbl_name = 'tbl_login';    
    private $user_name;    
    private $password;    
    private $email;
    
    function __construct() {
        parent::__construct();
    }
     
    public function add_banner($image) {
        $data=array(
            'title' => $this->input->post('txttitle'),
            'sub_title'=>$this->input->post('txtsubtitle'),
            'creation_date'=> date('Y-m-d H:i:s'),
            'modification_date'=> date('Y-m-d H:i:s')
        );

        if($image !=""){
            $data['image'] = $image;
        }
        $this->db->insert('banner',$data);
        return $this->db->insert_id();
    }

    public function get_banner(){
        $this->db->select('*');
        $this->db->from('banner');
        $this->db->order_by('id','ASC');
        $query = $this->db->get();
        return $query->result();
    }


    public function edit_banner($id){
        $this->db->where('id',$id);     
        $query = $this->db->get('banner');
        return $query->row(); 
    }
    public function update_banner($image){

        $id = $this->input->post('txeditid');
        $data['title'] = $this->input->post('txeditttitle');
        $data['sub_title'] = $this->input->post('txteditsubtitle');
        
        if($image !=""){
            $data['image'] = $image;
        }
        $this->db->where('id', $id);
        return $this->db->update('banner', $data);    
    }
 
    public function delete_banner($id) {
        $this->db->where('id', $id);
        return $this->db->delete('banner');
    }
}

    