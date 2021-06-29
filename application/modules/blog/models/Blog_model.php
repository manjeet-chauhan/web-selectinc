<?php

if (!defined('BASEPATH')) {
    exit('No Direct Script access allowed');
}

class Blog_model extends CI_Model {

    private $tbl_name = 'tbl_login';    
    private $user_name;    
    private $password;    
    private $email;
    
    function __construct() {
        parent::__construct();
    }
    

    public function save_blog($image){
        $title = $this->input->post('txttitle');
        $description = $this->input->post('txtprojectdescription');
      
        $tslug = $title;
        $tslug = str_replace(" ", "-", strtolower($tslug));
        $tslug = str_replace("(", "-", strtolower($tslug));
        $tslug = str_replace(")", "-", strtolower($tslug));
        $tslug = str_replace("@", "-", strtolower($tslug));

        // $unique = 0;
        // $inc = 0;
        $slug = $tslug;
        // while($unique == 0){
        //     $this->db->select('*')->from('blog');
        //     $this->db->where('slug', $tslug);
        //     $retdata = $this->db->get()->row();

        //     if(empty($retdata)){
        //         $slug = $tslug;
        //         $unique = 1;
        //         break;
        //     }
        //     else{
        //         $tslug = $slug.++$inc;
        //     }
        // }

        $array = array(
            'blog_id' => 'PNDVBLG'.substr(time(), -5), 
            'title' => $title,
            'slug' => $slug,
            'image' => $image,
            'description' => $description,
            'status' => 1,
            'creation_date' => date('Y-m-d H:i:s'),
            'modification_date' => date('Y-m-d H:i:s'),
        );

        return $this->db->insert('blog', $array);
    }


    public function get_blogs() {
        $this->db->select('*')->from('blog');
        $this->db->where('status', 1);
        // $this->db->where('password', md5($password));
        return $this->db->get()->result();
    }

    public function get_blog_description($blog_id) {
        $this->db->select('*')->from('blog');
        $this->db->where('blog_id', $blog_id);
        return $this->db->get()->row();
    }

    public function save_edit_blog($image){
        $blog_id = $this->input->post('blog_id');
        $title = $this->input->post('txttitle');
        $description = $this->input->post('txtprojectdescription');
      
        $tslug = $title;
        $tslug = str_replace(" ", "-", strtolower($tslug));
        $tslug = str_replace("(", "-", strtolower($tslug));
        $tslug = str_replace(")", "-", strtolower($tslug));
        $tslug = str_replace("@", "-", strtolower($tslug));

        // $unique = 0;
        // $inc = 0;
        $slug = $tslug;
        // while($unique == 0){
        //     $this->db->select('*')->from('blog');
        //     $this->db->where('slug', $tslug);
        //     $retdata = $this->db->get()->row();

        //     if(empty($retdata)){
        //         $slug = $tslug;
        //         $unique = 1;
        //         break;
        //     }
        //     else{
        //         $tslug = $slug.++$inc;
        //     }
        // }

        $array = array(
            'title' => $title,
            'slug' => $slug,
            'description' => $description,
            'modification_date' => date('Y-m-d H:i:s'),
        );
        if(!empty($image)){
           $array['image'] = $image;
        }
        $this->db->where('blog_id', $blog_id);
        return $this->db->update('blog', $array);
    }

    public function delete_blog(){
        $blog_id = $this->input->post('txtblogid');
         
        $array = array(
            'status' => 0,
            'modification_date' => date('Y-m-d H:i:s'),
        );
        $this->db->where('blog_id', $blog_id);
        return $this->db->update('blog', $array);
    }


 
}

