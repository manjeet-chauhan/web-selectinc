<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    function __construct() {
        parent:: __construct();
        $this->load->model('auth_model');
	      $this->lang->load('login');
        //check_user_logged();
    }

    public function index(){    
       $this->load->view('admin-login');
    }

    public function login() {
      $this->load->view('admin-login');
    }

    public function login_admin(){    
      
      $this->form_validation->set_rules('txtemail', 'Username', 'required');
      $this->form_validation->set_rules('txtpassword', 'Password', 'required');
      
      if ($this->form_validation->run() == TRUE) {        
        $validate = $this->auth_model->validate_admin_login();   

        if(!empty($validate)) {              
          
          $admin_data = []; 
          $array['id'] = $validate->id;
          $array['fname'] = $validate->fname;
          $array['lname'] = $validate->lname;
          $array['username'] = $validate->username;
          $array['email'] = $validate->email;
          $array['phone'] = $validate->phone;
          $array['image'] = $validate->image;

          $admin_data['admin'] = $array;
          $this->session->set_userdata($admin_data);

          echo "success";
          exit();
        }        
      }
      else{
        echo validation_errors();
        exit();
      }
      echo "error" ;
    }

    public function logout() {
      $admin_data = $this->session->userdata('admin');
      $this->session->sess_destroy($admin_data);
      redirect('admin/login');
    } 



    public function admin_profile(){    
      $admin_data = $this->session->userdata('admin');
      if(!empty($admin_data)){
        $id = $admin_data['id'];
        $data['profile'] = $this->auth_model->admin_profile($id);
        $data['view']='profile-setting';
        $this->load->view('backend/admin-layout', $data);
      }
      else{
        redirect('admin/login');
      }
    }


    public function update_profile(){ 

      $this->form_validation->set_rules('txtfname', 'First Name', 'required');
      $this->form_validation->set_rules('txtcontactno', 'Contact No', 'required');
      $this->form_validation->set_rules('txtemail', 'Email id', 'required');

      if ($this->form_validation->run() == TRUE) {        
        $filename=time() . date('Ymd');
        $profileimage='';
        if(isset($_FILES['profileimag'])&&$_FILES['profileimag']['error']=='0'){
          $config = array(
            'upload_path' => "assets/admin/images",
            'allowed_types' => "gif|jpg|png|jpeg",
            'overwrite' => TRUE,
            'max_size' => "2048000",
            'file_name' => $filename
          );
          $this->load->library('upload', $config);
          if($this->upload->do_upload('profileimag')){
            $data = array('upload_data' => $this->upload->data());
            $profileimage=$data['upload_data']['file_name'];
          }
          else {
            $error = array('error' => $this->upload->display_errors());
            echo $error['error'];die;
          }
        }
        $save = $this->auth_model->save_admin_profile($profileimage);
        if($save){
          echo "success";
        }else{
          echo "error";
        }
      }
      else{
        echo validation_errors();
      }
      // redirect('admin/profile');
    }


    public function admin_change_password(){    
      $admin_data = $this->session->userdata('admin');
      if(!empty($admin_data)){
        $id = $admin_data['id'];
        $data['id']= $id;
        $data['view']='change-password';
        $this->load->view('backend/admin-layout', $data);
      }
      else{
        redirect('admin/login');
      }
    }


    public function admin_update_password(){ 

      $this->form_validation->set_rules('txtoldpassword', 'Old Password', 'required');
      $this->form_validation->set_rules('txtnewpassword', 'New Password', 'required');
      $this->form_validation->set_rules('txtconfirmpassword', 'Confirm Password', 'required');

      if ($this->form_validation->run() == TRUE) {  

        $id = $this->input->post('txtid');
        $oldpass = $this->input->post('txtoldpassword');
        $newpass = $this->input->post('txtnewpassword');
        $conpass = $this->input->post('txtconfirmpassword'); 
        if($newpass != $conpass){
          echo "mismatch";
          exit();
        }
        $array['password'] = md5($conpass);
        $array['modification_date'] = date('Y-m-d H:i:s');

        $save = $this->auth_model->change_admin_password($id, $oldpass, $array);
        echo $save;
      }
      else{
        echo validation_errors();
      }
    }


    //  user dattattt =====================================


  public function my_login(){
    $data = [];
    $this->load->view('user/login', $data);   
  }

  public function user_login(){

    $this->form_validation->set_rules('email', 'Email', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');
    
    if ($this->form_validation->run() == TRUE) { 
      $validate = $this->auth_model->user_login();  
      if(!empty($validate)) {        
        $user_data['user'] = $validate;
        $this->session->set_userdata($user_data);
        echo "success";
        exit();
      }        
    }
    else{
      echo validation_errors();
      exit();
    }
    echo "error" ;
  }

  public function my_register(){
    $data = [];
    $this->load->view('user/register', $data);   
  }

  public function user_register(){

    $this->form_validation->set_rules('name', 'Username', 'required');
    $this->form_validation->set_rules('assignee', 'Redmine User Role', 'required');
    $this->form_validation->set_rules('redmineusername', 'Redmine Username', 'required');
    $this->form_validation->set_rules('redminepassword', 'Redmine Password', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');
    
    if ($this->form_validation->run() == TRUE) {

      $email = $this->input->post('email');
      $email_validate = $this->auth_model->validate_email($email);
      if(!empty($email_validate)){
         echo 'email';
         exit();
      }

      $validate = $this->auth_model->user_register();   

      if(!empty($validate)) {
        // $user_data['user'] = $validate;
        // $this->session->set_userdata($user_data);
        echo "success";
        exit();
      }        
    }
    else{
      echo validation_errors();
      exit();
    }
    echo "error" ;
  }

  public function user_logout() {     
     
      $user_data['user'] = [];
      $this->session->set_userdata($user_data);
      redirect(base_url('login'));
  }






   

}

