<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {

    function __construct() {
        parent:: __construct();

        $admin_login = $this->session->userdata('admin');
        if(empty($admin_login)){
          redirect('admin/login');
        }
        $this->load->model('blog_model');
	      $this->lang->load('login');
        //check_user_logged();
    }

    public function index(){
      $data['view']='index';
      $data['blogs']= $this->blog_model->get_blogs();
      // print_r($data);

      $this->load->view('backend/admin-layout', $data);
    }

    public function view_blog($blog_id){
      
      $data['view']='view-blog';
      $data['blog']= $this->blog_model->get_blog_description($blog_id);
      // print_r($data);
      $this->load->view('backend/admin-layout', $data);

    }

    public function add_blog(){
      $data['view']='add-blog';
      $this->load->view('backend/admin-layout', $data);
    }



    public function save_blog(){

      $this->form_validation->set_rules('txttitle', 'Title ', 'required');
      $this->form_validation->set_rules('txtprojectdescription', 'Description', 'required');
      if ($this->form_validation->run() == TRUE) {

        if(empty($_FILES['txtimage']['name'])){
          echo 'Choose an image to upload';
          exit();
        }
        
        $filename=time() . date('Ymd');
        $image = '';
        if(isset($_FILES['txtimage'])&&$_FILES['txtimage']['error']=='0'){           
          $config = array(
            'upload_path' => "assets/upload/blog/",
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

        $save = $this->blog_model->save_blog($image);
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

    public function edit_blog($blog_id){
      $data['view']='edit-blog';
      $data['blog']= $this->blog_model->get_blog_description($blog_id);
      // print_r($data);
      
      $this->load->view('backend/admin-layout', $data);
    }

    public function save_edit_blog(){

      $this->form_validation->set_rules('blog_id', 'Blog Data ', 'required');
      $this->form_validation->set_rules('txttitle', 'Title ', 'required');
      $this->form_validation->set_rules('txtprojectdescription', 'Description', 'required');
      if ($this->form_validation->run() == TRUE) {

        // if(empty($_FILES['txtimage']['name'])){
        //   echo 'Choose an image to upload';
        //   exit();
        // }
        
        $filename=time() . date('Ymd');
        $image = '';
        if(isset($_FILES['txtimage'])&&$_FILES['txtimage']['error']=='0'){           
          $config = array(
            'upload_path' => "assets/upload/blog/",
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
        $save = $this->blog_model->save_edit_blog($image);
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


     public function delete_blog(){

      $this->form_validation->set_rules('txtblogid', 'Blog Data ', 'required');
      if ($this->form_validation->run() == TRUE) {
          $delete = $this->blog_model->delete_blog();
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