<?php

if (!defined('BASEPATH')) {
    exit('No Direct Script access allowed');
}

class Webfooter_model extends CI_Model {

    private $tbl_name = 'tbl_login';    
    private $user_name;    
    private $password;    
    private $email;
    
    function __construct() {
        parent::__construct();
    }
    

    public function get_footer_navigate() {
        $this->db->select('*')->from('footer_navigate');
        $this->db->where('status', 1);
        return $result = $this->db->get()->result();
    }

    public function get_footer_navigate_detail($footer_id) {
        $this->db->select('*')->from('footer_navigate');
        $this->db->where('status', 1);
        $this->db->where('footer_id', $footer_id);

        return $this->db->get()->row();
    }


     public function save_footer_page(){
        $footer_id = $this->input->post('txtfooterpageid');
        $title = $this->input->post('txttitle');
        $footerlinkname = $this->input->post('txtfootername');
        $description = $this->input->post('txtdescription');
        $redirect_link = $this->input->post('txtotherlink');
      
        $slug = $footerlinkname;
        $slug = str_replace(" ", "-", strtolower($slug));
        $slug = str_replace("(", "-", strtolower($slug));
        $slug = str_replace(")", "-", strtolower($slug));
        $slug = str_replace("@", "-", strtolower($slug));

        $array = array(
            'page_id' => 'PNDUVPG'.substr(time(), -5),
            'slug' => $slug,
            'footer_id' => $footer_id,
            'page_title' => $title,
            'footer_link_name' => $footerlinkname,
            'redirect_other' => $redirect_link, 
            'description' => $description, 
            'creation_date' => date('Y-m-d H:i:s'),
            'modification_date' => date('Y-m-d H:i:s'),
        );
        
        return $this->db->insert('footer_page_info', $array);
    }


    public function save_footer_title(){
        $footer_id = $this->input->post('txteditfooterid');
        $name = $this->input->post('txteditfootername');
        
        $array = array(
            'name' => $name, 
            // 'modification_date' => date('Y-m-d H:i:s'),
        );
        $this->db->where('id', $footer_id);
        return $this->db->update('footer_navigate', $array);
    }
    public function get_footer_page_detail($page_id) {
        $this->db->select('*')->from('footer_page_info');
        $this->db->where('status', 1);
        $this->db->where('page_id', $page_id);

        return $this->db->get()->row();
    }



    public function save_edit_footer_page(){
        $page_id = $this->input->post('txtpageid');
        $title = $this->input->post('txttitle');
        $footerlinkname = $this->input->post('txtfootername');
        $description = $this->input->post('txtdescription');
        $redirect_link = $this->input->post('txtotherlink');
      
        $slug = $footerlinkname;
        $slug = str_replace(" ", "-", strtolower($slug));
        $slug = str_replace("(", "-", strtolower($slug));
        $slug = str_replace(")", "-", strtolower($slug));
        $slug = str_replace("@", "-", strtolower($slug));

        $array = array(
            'slug' => $slug,
            'page_title' => $title,
            'footer_link_name' => $footerlinkname,
            'redirect_other' => $redirect_link, 
            'description' => $description, 
            'modification_date' => date('Y-m-d H:i:s'),
        );
        
        $this->db->where('id', $page_id);
        return $this->db->update('footer_page_info', $array);
    }


    public function delete_footer_page(){
        $page_id = $this->input->post('txtdelpageid');
         
        $array = array(
            'status' => 0,
            'modification_date' => date('Y-m-d H:i:s'),
        );
        
        $this->db->where('id', $page_id);
        return $this->db->update('footer_page_info', $array);
    }

    // =====================================================


    public function get_social_icons() {
        $this->db->select('*')->from('social_icon');
        $this->db->where('status', 1);
        return $result = $this->db->get()->result();
    }

     public function add_social_icon(){

        $name = $this->input->post('txtname');
        $icon = $this->input->post('txticon');
        $link = $this->input->post('txtlink');

        $array = array(
            'name' => $name,
            'icon' => $icon,
            'link' => $link,
            'status' => 1, 
            'creation_date' => date('Y-m-d H:i:s'),
            'modification_date' => date('Y-m-d H:i:s'),
        );
        return $this->db->insert('social_icon', $array);
    }

    public function save_social_icon(){
        $icon_id = $this->input->post('txticonid');
        $name = $this->input->post('etxtname');
        $icon = $this->input->post('etxticon');
        $link = $this->input->post('etxtlink');
      
         $array = array(
            'name' => $name,
            'icon' => $icon,
            'link' => $link,
            'modification_date' => date('Y-m-d H:i:s'),
        );
        
        $this->db->where('id', $icon_id);
        return $this->db->update('social_icon', $array);
    }


    public function delete_social_icon(){
        $icon_id = $this->input->post('txtsocialicon');
        
         $array = array(
            'status' => 0,
            'modification_date' => date('Y-m-d H:i:s'),
        );
        
        $this->db->where('id', $icon_id);
        return $this->db->update('social_icon', $array);
    }










    // -----------------------------------------------------------------









    public function get_publication_description($publication_id) {
        $this->db->select('*')->from('publication');
        $this->db->where('publication_id', $publication_id);
        return $this->db->get()->row();
    }

    public function save_edit_publication($image){
        $publication_id = $this->input->post('publication_id');
        $title = $this->input->post('txttitle');
        $description = $this->input->post('txtprojectdescription');
        $client_name = $this->input->post('client_name');
        $designation = $this->input->post('designation');
        $keywords = $this->input->post('keywords');
      
        $tslug = $title;
        $tslug = str_replace(" ", "-", strtolower($tslug));
        $tslug = str_replace("(", "-", strtolower($tslug));
        $tslug = str_replace(")", "-", strtolower($tslug));
        $tslug = str_replace("@", "-", strtolower($tslug));

        // $unique = 0;
        // $inc = 0;
        $slug = $tslug;
        // while($unique == 0){
        //     $this->db->select('*')->from('publication');
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
            'client_name' => $client_name,
            'designation' => $designation,
            'keywords' => $keywords, 
            'modification_date' => date('Y-m-d H:i:s'),
        );
        if(!empty($image)){
           $array['image'] = $image;
        }
        
        $this->db->where('publication_id', $publication_id);
        return $this->db->update('publication', $array);
    }

    public function delete_publication(){
        $publication_id = $this->input->post('txtpublicationid');
         
        $array = array(
            'status' => 0,
            'modification_date' => date('Y-m-d H:i:s'),
        );
        $this->db->where('publication_id', $publication_id);
        return $this->db->update('publication', $array);
    }


    public function save_whychoose_title(){
        $pagetitle = $this->input->post('txtpagetitle');
         
        $array = array(
            'whychoose_title' => $pagetitle
        );
        $this->db->where('id', 1);
        return $this->db->update('page_settings', $array);
    }


 
}

