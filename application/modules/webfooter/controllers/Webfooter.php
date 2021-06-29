<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Webfooter extends CI_Controller {

    function __construct() {
        parent:: __construct();

        $admin_login = $this->session->userdata('admin');
        if(empty($admin_login)){
          redirect('admin/login');
        }
        $this->load->model('webfooter_model');
	      $this->lang->load('login');
        //check_user_logged();
    }

    public function index(){
      $data['view']='index';
      $data['footers']= $this->webfooter_model->get_footer_navigate();
      // print_r($data);
      $this->load->view('backend/admin-layout', $data);
    }

    public function add_footer_page($footer_id){
      $data['view']='add-footer-page';
      $data['footer']= $this->webfooter_model->get_footer_navigate_detail($footer_id);
      // print_r($data);
      $this->load->view('backend/admin-layout', $data);
    }

    public function save_footer_page(){
      
      $this->form_validation->set_rules('txtfooterpageid', 'Footer Data ', 'required');
      $this->form_validation->set_rules('txttitle', 'Page Title ', 'required');
      $this->form_validation->set_rules('txtfootername', 'Footer Link Name ', 'required');
      
      $link = $this->input->post('txtotherlink');
      $desc = $this->input->post('txtdescription');
      if(empty($link)){
        $this->form_validation->set_rules('txtdescription', 'Page Contents ', 'required');
      }
      if(empty($desc)){
        $this->form_validation->set_rules('txtotherlink', 'Redirect Link ', 'required');
      }

      if ($this->form_validation->run() == TRUE) {
          $delete = $this->webfooter_model->save_footer_page();
          if($delete){
            echo "success";
            exit();
          }
      }
      else{
        echo  validation_errors();
        exit();
      }
      echo "error";
    }



    public function save_footer_title(){
      
      $this->form_validation->set_rules('txteditfooterid', 'Footer Data ', 'required');
      $this->form_validation->set_rules('txteditfootername', 'Footer Name ', 'required');

      if ($this->form_validation->run() == TRUE) {
          $delete = $this->webfooter_model->save_footer_title();
          if($delete){
            echo "success";
            exit();
          }
      }
      else{
        echo  validation_errors();
        exit();
      }
      echo "error";
    }


    public function edit_footer_page($page_id){
      $data['view']='edit-footer-page';
      $data['footer']= $this->webfooter_model->get_footer_page_detail($page_id);
      // print_r($data);
      $this->load->view('backend/admin-layout', $data);
    }

    public function save_edit_footer_page(){
      
      $this->form_validation->set_rules('txtpageid', 'Page Data ', 'required');
      $this->form_validation->set_rules('txttitle', 'Page Title ', 'required');
      $this->form_validation->set_rules('txtfootername', 'Footer Link Name ', 'required');
      
      $link = $this->input->post('txtotherlink');
      $desc = $this->input->post('txtdescription');
      if(empty($link)){
        $this->form_validation->set_rules('txtdescription', 'Page Contents ', 'required');
      }
      if(empty($desc)){
        $this->form_validation->set_rules('txtotherlink', 'Redirect Link ', 'required');
      }

      if ($this->form_validation->run() == TRUE) {
          $delete = $this->webfooter_model->save_edit_footer_page();
          if($delete){
            echo "success";
            exit();
          }
      }
      else{
        echo  validation_errors();
        exit();
      }
      echo "error";
    }

    public function delete_footer_page(){
      
      $this->form_validation->set_rules('txtdelpageid', 'Page Data ', 'required');

      if ($this->form_validation->run() == TRUE) {
          $delete = $this->webfooter_model->delete_footer_page();
          if($delete){
            echo "success";
            exit();
          }
      }
      else{
        echo  validation_errors();
        exit();
      }
      echo "error";
    }





    // ================================================================


    public function social_icon(){
      $data['view']='social-icons';
      $data['icons']= $this->webfooter_model->get_social_icons();
      // print_r($data);
      $this->load->view('backend/admin-layout', $data);
    }

    public function add_social_icon(){
      
      $this->form_validation->set_rules('txtname', 'Name ', 'required');
      $this->form_validation->set_rules('txticon', 'Icon image ', 'required');
      $this->form_validation->set_rules('txtlink', 'Link ', 'required');
      
      if ($this->form_validation->run() == TRUE) {
          $delete = $this->webfooter_model->add_social_icon();
          if($delete){
            echo "success";
            exit();
          }
      }
      else{
        echo  validation_errors();
        exit();
      }
      echo "error";
    }


    public function save_social_icon(){
      
      $this->form_validation->set_rules('txticonid', 'Icon Data ', 'required');
      $this->form_validation->set_rules('etxtname', 'Name ', 'required');
      $this->form_validation->set_rules('etxticon', 'Icon image ', 'required');
      $this->form_validation->set_rules('etxtlink', 'Link  ', 'required');
      
      if ($this->form_validation->run() == TRUE) {
          $delete = $this->webfooter_model->save_social_icon();
          if($delete){
            echo "success";
            exit();
          }
      }
      else{
        echo  validation_errors();
        exit();
      }
      echo "error";
    }

    public function delete_social_icon(){
      
      $this->form_validation->set_rules('txtsocialicon', 'Icon Data ', 'required');
      
      if ($this->form_validation->run() == TRUE) {
          $delete = $this->webfooter_model->delete_social_icon();
          if($delete){
            echo "success";
            exit();
          }
      }
      else{
        echo  validation_errors();
        exit();
      }
      echo "error";
    }













    // -----------------------------------------

    public function view_publication($publication_id){
      
      $data['view']='view-publication';
      $data['publication']= $this->webfooter_model->get_publication_description($publication_id);
      // print_r($data);
      $this->load->view('backend/admin-layout', $data);

    }

    public function add_publication(){
      $data['view']='add-publication';
      $this->load->view('backend/admin-layout', $data);
    }



    public function save_publication(){

      $this->form_validation->set_rules('txttitle', 'Title ', 'required');
      $this->form_validation->set_rules('txtprojectdescription', 'Description', 'required');
      $this->form_validation->set_rules('client_name', 'Client Name', 'required');
      $this->form_validation->set_rules('designation', 'Designation', 'required');

      if ($this->form_validation->run() == TRUE) {

        if(empty($_FILES['txtimage']['name'])){
          echo 'Choose an image to upload';
          exit();
        }

        $filename=time() . date('Ymd');
        $image = '';
        if(isset($_FILES['txtimage'])&&$_FILES['txtimage']['error']=='0'){           
          $config = array(
            'upload_path' => "assets/upload/publication/",
            'allowed_types' => "gif|jpg|png|jpeg",
            'overwrite' => false,
            'max_size' => "2048000", 
            'file_name' => $filename
          );

          $this->load->library('upload', $config);
          if($this->upload->do_upload('txtimage'))
          {  
              $data = array('upload_data' => $this->upload->data());
              $image = $data['upload_data']['file_name'];
          }
          else
          {
              $error = array('error' => $this->upload->display_errors());
              echo $error['error'];
              die;
          }
        }

 
        $save = $this->webfooter_model->save_publication($image);
        if($save){
          echo "success";
          exit();
        }
      }
      else{
        echo  validation_errors();
        exit();
      }
      echo "error";
    }

    public function edit_publication($publication_id){
      $data['view']='edit-publication';
      $data['publication']= $this->webfooter_model->get_publication_description($publication_id);
      // print_r($data);
      
      $this->load->view('backend/admin-layout', $data);
    }

    public function save_edit_publication(){

      $this->form_validation->set_rules('publication_id', 'publication Data ', 'required');
      $this->form_validation->set_rules('txttitle', 'Title ', 'required');
      $this->form_validation->set_rules('txtprojectdescription', 'Description', 'required');
      $this->form_validation->set_rules('client_name', 'Client Name', 'required');
      $this->form_validation->set_rules('designation', 'Designation', 'required');
      if ($this->form_validation->run() == TRUE) {

        // if(empty($_FILES['txtimage']['name'])){
        //   echo 'Choose an image to upload';
        //   exit();
        // }
        
        $filename=time() . date('Ymd');
        $image = '';
        if(isset($_FILES['txtimage'])&&$_FILES['txtimage']['error']=='0'){           
          $config = array(
            'upload_path' => "assets/upload/publication/",
            'allowed_types' => "gif|jpg|png|jpeg",
            'overwrite' => false,
            'max_size' => "2048000", 
            'file_name' => $filename
          );

          $this->load->library('upload', $config);
          if($this->upload->do_upload('txtimage'))
          {  
              $data = array('upload_data' => $this->upload->data());
              $image = $data['upload_data']['file_name'];
          }
          else
          {
              $error = array('error' => $this->upload->display_errors());
              echo $error['error'];
              die;
          }
        }


        


        $save = $this->webfooter_model->save_edit_publication($image);
        if($save){
          echo "success";
          exit();
        }
      }
      else{
        echo  validation_errors();
        exit();
      }
      echo "error";
    }


     public function delete_publication(){

      $this->form_validation->set_rules('txtpublicationid', 'publication Data ', 'required');
      if ($this->form_validation->run() == TRUE) {
          $delete = $this->webfooter_model->delete_publication();
          if($delete){
            echo "success";
            exit();
          }
      }
      else{
        echo  validation_errors();
        exit();
      }
      echo "error";
    }


    public function save_publication_title(){

      $this->form_validation->set_rules('txtpagetitle', 'Title ', 'required');
      if ($this->form_validation->run() == TRUE) {
          $delete = $this->webfooter_model->save_publication_title();
          if($delete){
            echo "success";
            exit();
          }
      }
      else{
        echo  validation_errors();
        exit();
      }
      echo "error";
    }




     
}