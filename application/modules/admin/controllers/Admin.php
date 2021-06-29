<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

   function __construct() {
      parent:: __construct();
      $this->load->model('admin_model');
	   $this->lang->load('login');
      //check_user_logged();
      $admin_data = $this->session->userdata('admin');
      if(empty($admin_data)){
         redirect('admin/login');
      }
   }

   public function dashboard(){    
      $searchtext = $this->input->get('search');
      $page = $this->input->get('page');
      $data['users'] = $this->admin_model->get_users($searchtext, $page);     
      // print_r($data); 
      $data['view']='index';
      $data['view_title']='All Users';
      $this->load->view('backend/admin-layout', $data);
   }

   public function users(){    
      $searchtext = $this->input->get('search');
      $page = $this->input->get('page');
      $data['users'] = $this->admin_model->get_users($searchtext, $page);     
      // print_r($data); 
      $data['view']='index';
      $data['view_title']='All Users';
      $this->load->view('backend/admin-layout', $data);
   }

   public function user_profile($user_name, $user_code){
      $data['view']='user-profile';
      $data['profile'] = $this->admin_model->user_profile($user_code);
      // print_r($data);
      $this->load->view('backend/admin-layout', $data);
   }
 
   public function users_status(){    
      
      $enable = $this->admin_model->users_status();
      if($enable == 1){
        echo "success";
        exit();
      }
      echo "error";
      exit();
   }
 

   public function users_delete_account(){ 
      $enable = $this->admin_model->users_delete_account();
      echo $enable;
   }

    public function users_approve_account(){ 
      $enable = $this->admin_model->users_approve_account();
      echo $enable;
   }

   // ----------

   public function user_clients($user_name, $user_code){

      $searchtext = $this->input->get('search');
      $page = $this->input->get('page');

      $data['view']='user-clients';
      $data['clients'] = $this->admin_model->user_clients($user_code, $searchtext, $page);
      // print_r($data);
      $this->load->view('backend/admin-layout', $data);
   }

   public function user_client_detail($client_code){

      $data['view']='user-client-detail';
      $data['client'] = $this->admin_model->user_client_detail($client_code);
      // print_r($data);
      $this->load->view('backend/admin-layout', $data);
   }

   public function user_models($user_name, $user_code){

      $searchtext = $this->input->get('search');
      $page = $this->input->get('page');

      $data['view']='user-models';
      $data['clients'] = $this->admin_model->user_models($user_code, $searchtext, $page);
      // print_r($data);
      $this->load->view('backend/admin-layout', $data);
   }
   public function user_model_detail($model_code){

      $data['view']='user-model-detail';
      $data['model'] = $this->admin_model->user_model_detail($model_code);
      // print_r($data);
      $this->load->view('backend/admin-layout', $data);
   }

   public function user_invoices($user_name, $user_code){

      $searchtext = $this->input->get('search');
      $page = $this->input->get('page');

      $data['view']='user-invoices';
      $data['invoices'] = $this->admin_model->user_invoices($user_code, $searchtext, $page);
      // print_r($data);
      $this->load->view('backend/admin-layout', $data);
   }


   public function invoices_for_approval(){

      $searchtext = $this->input->get('search');
      $page = $this->input->get('page');

      $data['view']='user-invoices-for-approval';
      $data['invoices'] = $this->admin_model->invoices_for_approval($searchtext, $page);
      // print_r($data);
      $this->load->view('backend/admin-layout', $data);
   }

   public function approve_user_invoice(){
 
      $save = $this->admin_model->approve_user_invoice();
      if($save){
         echo 'success';
         exit();
      }
      echo 'error';      
   }



   public function user_refund($user_name, $user_code){

      $searchtext = $this->input->get('search');
      $page = $this->input->get('page');

      $data['view']='user-refunds';
      $data['invoices'] = $this->admin_model->user_refund($user_code, $searchtext, $page);
      // print_r($data);
      $this->load->view('backend/admin-layout', $data);
   }


   public function refund_for_approval(){

      $searchtext = $this->input->get('search');
      $page = $this->input->get('page');

      $data['view']='user-refund-for-approval';
      $data['invoices'] = $this->admin_model->refund_for_approval($searchtext, $page);
      // print_r($data);
      $this->load->view('backend/admin-layout', $data);
   }

   public function approve_user_refund(){
 
      $save = $this->admin_model->approve_user_refund();
      if($save){
         echo 'success';
         exit();
      }
      echo 'error';      
   }










   

  
}

