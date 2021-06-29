<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Banner extends CI_Controller {

    function __construct() {
        parent:: __construct();
        $this->load->model('banner_model');
	      $this->lang->load('login');
        //check_user_logged();
    }

    public function index(){    
      $data['view']='index';
        $data['banners'] = $this->banner_model->get_banner();
      $this->load->view('backend/admin-layout', $data);
    }

    public function add_banner(){ 

      if($_FILES['bannerimage']['error'] > 0){
          echo "imageerror";
          exit();
      }
      $this->form_validation->set_rules('txttitle', 'Title', 'required');
      $this->form_validation->set_rules('txtsubtitle', 'Sub-title', 'required');
      // $this->form_validation->set_rules('bannerimage', 'Banner Image', 'required');
  
      if ($this->form_validation->run() == TRUE) {
        $filename=time() . date('Ymd');
        $bannerimage='';
        if(isset($_FILES['bannerimage'])&&$_FILES['bannerimage']['error']=='0'){
          $config = array(
            'upload_path' => "assets/upload/banner",
            'allowed_types' => "gif|jpg|png|jpeg",
            'overwrite' => TRUE,
            'max_size' => "2048000",
            'file_name' => $filename
          );
          $this->load->library('upload', $config);
          if($this->upload->do_upload('bannerimage')){
            $data = array('upload_data' => $this->upload->data());
            $bannerimage=$data['upload_data']['file_name'];
          }
          else {
            $error = array('error' => $this->upload->display_errors());
            echo $error['error'];die;
          }
        }
        $save = $this->banner_model->add_banner($bannerimage);
        if($save){ echo "success"; exit(); }
        else{ echo "error"; exit(); }
      }
      else{
        echo validation_errors();
      }
    }

    public  function editbanner($id){
      $data['view']='editbanner';
      $data['banner'] = $this->banner_model->edit_banner($id);
      $this->load->view('backend/layout', $data);
    }

    public function updatebanner(){ 

      $this->form_validation->set_rules('txeditttitle', 'Title', 'required');
      $this->form_validation->set_rules('txteditsubtitle', 'Sub-title', 'required');

      if ($this->form_validation->run() == TRUE) {
        $filename=time() . date('Ymd');
        $image = '';
        if(isset($_FILES['bannereditimage'])&&$_FILES['bannereditimage']['error']=='0'){
          $config = array(
              'upload_path' => "assets/upload/banner/",
              'allowed_types' => "gif|jpg|png|jpeg",
              'overwrite' => TRUE,
              'max_size' => "2048000", 
              'file_name' => $filename
          );
          $this->load->library('upload', $config);
          if($this->upload->do_upload('bannereditimage'))
          {
              $data = array('upload_data' => $this->upload->data());
              $image =$data['upload_data']['file_name'];
          }
          else{
            $error = array('error' => $this->upload->display_errors());
            echo $error['error'];die;
          }
        }
        $save = $this->banner_model->update_banner($image);
        if($save){ echo "success"; exit(); }
        else{ echo "error"; exit();}
      }
      else{
        echo validation_errors();
        exit();
      }
      echo "error";
    }
  
    public function deletebanner(){        
      $id = $this->input->post('txtdelid');
      $save = $this->banner_model->delete_banner($id);     
      if($save){ echo "success"; exit(); }
      echo "error"; exit();
    }
 

}

