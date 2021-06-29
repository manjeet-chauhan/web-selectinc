<?php
//error_reporting(0);
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller{
	 
	public function __construct(){
		parent::__construct();
		$this->load->model('home_model');
		$this->load->helper('form');
		$this->load->library('form_validation');

    $this->load->library('m_pdf');

    $user_session = $this->session->userdata('user');
    if(empty($user_session)){
      redirect(base_url('login'));
    }
  }

     
 public function index(){

    $limit = 8;

    $data['view'] = 'index';
		$data['user_id'] = $this->home_model->user_id();   
    $data['draft_invoices'] = $this->home_model->get_draft_open_invoive($limit, '', '', '', '', ''); 
    $data['open_invoices'] = $this->home_model->get_user_open_invoive($limit, '', '', '', '', '');
    $data['approve_invoices'] = $this->home_model->get_user_approve_invoive($limit, '', '', '', '', '');
    $data['reminder_invoices'] = $this->home_model->get_user_reminder_invoive($limit, '', '', '', '', '');
    $data['refund_invoices'] = $this->home_model->get_user_refund_invoive($limit, '', '', '', '', '');
    $data['payed_model_overview'] = $this->home_model->get_payed_model_overview($limit, '', '', '', '', '');

    $data['seLect_expenses'] = $this->home_model->get_seLect_expenses($limit);
    $data['payed_refund'] = $this->home_model->get_payed_refund($limit);
    $data['approve_invoices_email'] = $this->home_model->get_user_approve_invoive($limit, '', '', '', '', '');
    $data['payed_refund_invoices'] = $this->home_model->get_user_refund_invoive($limit, '', '', '', '', '');
    $this->load->view('frontend/layout', $data);   
	}

  public function view_issues_issues(){
    $data['view']='redmine-data';
    $data['user_id']= $this->home_model->user_id();
    $this->load->view('frontend/layout', $data);   
  }

  public function view_issues_issues_detail(){
    $data['view']='redmine-data-detail';
    $data['user_id']= $this->home_model->user_id();
    $this->load->view('frontend/layout', $data);   
  }

 
 

  // =========== Client Management ==================

  public function client_management(){

    $searchtext = $this->input->get('search');
    
    $data['view']='client-management';
    $data['client_mgmt'] = $this->home_model->get_client_management($searchtext);
    $data['searchtext'] = $searchtext; // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }

  public function all_client_management(){

    $searchtext = $this->input->get('search');
    $page = $this->input->get('page'); 

    $data['view']='all-client-management';
    $data['searchtext']=$searchtext;
    $data['client_mgmt'] = $this->home_model->get_client_management_list($searchtext, $page);
    $data['page']=$page;
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }



  public function add_client_management(){
    $data['view']='add-client-management';
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }

  public function save_client_management(){ 

    $this->form_validation->set_rules('companyname', 'Company Name ', 'required');
    $this->form_validation->set_rules('client_fee', 'Client Fee ', 'required'); 

    // $this->form_validation->set_rules('name', 'Name ', 'required');
    // $this->form_validation->set_rules('surname', 'Surname ', 'required');
    // $this->form_validation->set_rules('addressline1', 'Address Line 1 ', 'required');
    // $this->form_validation->set_rules('addressline2', 'Address Line 2 ', 'required');
    // $this->form_validation->set_rules('postcode', 'Postcode ', 'required');
    // $this->form_validation->set_rules('city', 'City ', 'required');

    // $this->form_validation->set_rules('vat_tin_no', 'VAT/TIN Number ', 'required');
    // $this->form_validation->set_rules('country', 'Country ', 'required');
    // $this->form_validation->set_rules('email', 'Email ', 'required');
    // $this->form_validation->set_rules('telephone', 'Telephone ', 'required');
    // $this->form_validation->set_rules('phone', 'Mobile Number ', 'required');
    // $this->form_validation->set_rules('internal_notes', 'Internal Notes ', 'required'); 
    // $this->form_validation->set_rules('shipping_companyname', ' Shipping Company Name ', 'required');
    // $this->form_validation->set_rules('shipping_name', 'Shipping Name ', 'required');
    // $this->form_validation->set_rules('shipping_surname', 'Shipping Surname ', 'required');
    // $this->form_validation->set_rules('shipping_addressline1', 'Shipping Address Line 1 ', 'required');
    // $this->form_validation->set_rules('shipping_addressline2', 'Shipping Address Line 2 ', 'required');
    // $this->form_validation->set_rules('shipping_postcode', 'Shipping Postcode ', 'required'); 
    // $this->form_validation->set_rules('shipping_city', 'Shipping City ', 'required');
    
    // $kvat = (int)$this->input->post('kvatornot');
    // if($kvat == 1){
    //   $this->form_validation->set_rules('kvat_percent', ' Kleinunternehmer with VAT Percentege ', 'required');
    // }

    if ($this->form_validation->run() == TRUE) { 
      $save = $this->home_model->save_client_management();
      if ($save) {
        echo 'success';
        exit();
      }
    }
    else{
      echo validation_errors();
      exit();
    }
    echo 'error';
  }


  public function edit_client_management($profilecode){
    $data['view'] = 'edit-client-management';
    $data['uniquecode'] = $profilecode;
    $data['client'] = $this->home_model->get_client_management_detail($profilecode);
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }


  public function save_edit_client_management(){ 

    $this->form_validation->set_rules('uniquecode', 'Profile Data ', 'required');
    $this->form_validation->set_rules('companyname', 'Company Name ', 'required');
    $this->form_validation->set_rules('client_fee', 'Client Fee ', 'required'); 
    // $this->form_validation->set_rules('name', 'Name ', 'required');
    // $this->form_validation->set_rules('surname', 'Surname ', 'required');
    // $this->form_validation->set_rules('addressline1', 'Address Line 1 ', 'required');
    // $this->form_validation->set_rules('addressline2', 'Address Line 2 ', 'required');
    // $this->form_validation->set_rules('postcode', 'Postcode ', 'required');
    // $this->form_validation->set_rules('city', 'City ', 'required');
    // $this->form_validation->set_rules('vat_tin_no', 'VAT/TIN Number ', 'required');
    // $this->form_validation->set_rules('country', 'Country ', 'required');
    // $this->form_validation->set_rules('email', 'Email ', 'required');
    // $this->form_validation->set_rules('telephone', 'Telephone ', 'required');
    // $this->form_validation->set_rules('phone', 'Mobile Number ', 'required');
    // $this->form_validation->set_rules('internal_notes', 'Internal Notes ', 'required'); 
    // $this->form_validation->set_rules('shipping_companyname', ' Shipping Company Name ', 'required');
    // $this->form_validation->set_rules('shipping_name', 'Shipping Name ', 'required');
    // $this->form_validation->set_rules('shipping_surname', 'Shipping Surname ', 'required');
    // $this->form_validation->set_rules('shipping_addressline1', 'Shipping Address Line 1 ', 'required');
    // $this->form_validation->set_rules('shipping_addressline2', 'Shipping Address Line 2 ', 'required');
    // $this->form_validation->set_rules('shipping_postcode', 'Shipping Postcode ', 'required'); 
    // $this->form_validation->set_rules('shipping_city', 'Shipping City ', 'required');
    
    // $kvat = (int)$this->input->post('kvatornot');
    // if($kvat == 1){
    //   $this->form_validation->set_rules('kvat_percent', ' Kleinunternehmer with VAT Percentege ', 'required');
    // }

    if ($this->form_validation->run() == TRUE) { 
      $save = $this->home_model->save_edit_client_management();
      if ($save) {
        echo 'success';
        exit();
      }
    }
    else{
      echo validation_errors();
      exit();
    }
    echo 'error';
  }

  public function client_management_detail($profilecode){
    $data['view'] = 'client-management-detail';
    $data['uniquecode'] = $profilecode;
    $data['client'] = $this->home_model->get_client_management_detail($profilecode);
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }


  


  // ========================================


  public function model_management(){
    $searchtext = $this->input->get('search');
    $data['searchtext']=$searchtext;
    $data['view']='model-management';    
    $data['models'] = $this->home_model->get_model_management($searchtext);
    // print_r($data);   
    $this->load->view('frontend/layout', $data);   
  }

  public function all_model_management(){

    $searchtext = $this->input->get('search');
    $page = $this->input->get('page'); 
    $data['searchtext']=$searchtext;
    $data['page']=$page;

    $data['view']='all-model-management';    
    $data['models'] = $this->home_model->get_model_management_list($searchtext, $page);
    // print_r($data);   
    $this->load->view('frontend/layout', $data);   
  }


  public function add_model_management(){
    $data['view']='add-model-management';
    $this->load->view('frontend/layout', $data);   
  }

  public function save_model_management(){ 

    $this->form_validation->set_rules('model_name', 'Model Name ', 'required');
    // $this->form_validation->set_rules('service_fee', 'Service Fee ', 'required'); 
    // $this->form_validation->set_rules('name', 'Name ', 'required');
    $this->form_validation->set_rules('surname', 'Surname ', 'required');
    // $this->form_validation->set_rules('addressline1', 'Address Line 1 ', 'required');
    // $this->form_validation->set_rules('addressline2', 'Address Line 2 ', 'required');
    // $this->form_validation->set_rules('city', 'City ', 'required');
    // $this->form_validation->set_rules('postcode', 'Postcode ', 'required');    
    // $this->form_validation->set_rules('vat_tin_no', 'VAT/TIN Number ', 'required');
    // $this->form_validation->set_rules('country', 'Country ', 'required');
    

    // $this->form_validation->set_rules('email', 'Email ', 'required');
    // $this->form_validation->set_rules('telephone', 'Telephone ', 'required');
    // $this->form_validation->set_rules('phone', 'Mobile Number ', 'required');
    // $this->form_validation->set_rules('kvatornot', 'Kleinunternehmer with VAT ', 'required'); 
   
    // $kvat = (int)$this->input->post('kvatornot');
    // if($kvat == 1){
    //   $this->form_validation->set_rules('kvat_percent', ' Kleinunternehmer with VAT Percentege ', 'required');
    // }

    if ($this->form_validation->run() == TRUE) { 


      $save = $this->home_model->save_model_management();
      if ($save) {
        echo 'success';
        exit();
      }
    }
    else{
      echo validation_errors();
      exit();
    }
    echo 'error';
  }


  public function edit_model_management($uniquecode){
    $data['view']='edit-model-management';
    $data['uniquecode'] = $uniquecode;
    $data['model'] = $this->home_model->get_model_management_detail($uniquecode);
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }


  public function save_edit_model_management(){ 

    $this->form_validation->set_rules('modelcode', 'Model Data ', 'required');
    $this->form_validation->set_rules('model_name', 'Model Name ', 'required');
    // $this->form_validation->set_rules('service_fee', 'Service Fee ', 'required'); 
    // $this->form_validation->set_rules('name', 'Name ', 'required');
    $this->form_validation->set_rules('surname', 'Surname ', 'required');
    // $this->form_validation->set_rules('addressline1', 'Address Line 1 ', 'required');
    // $this->form_validation->set_rules('addressline2', 'Address Line 2 ', 'required');
    // $this->form_validation->set_rules('city', 'City ', 'required');
    // $this->form_validation->set_rules('postcode', 'Postcode ', 'required');    
    // $this->form_validation->set_rules('vat_tin_no', 'VAT/TIN Number ', 'required');
    // $this->form_validation->set_rules('country', 'Country ', 'required');
    // $this->form_validation->set_rules('email', 'Email ', 'required');
    // $this->form_validation->set_rules('telephone', 'Telephone ', 'required');
    // $this->form_validation->set_rules('phone', 'Mobile Number ', 'required');
    // $this->form_validation->set_rules('kvatornot', 'Kleinunternehmer with VAT ', 'required'); 
   
    // $kvat = (int)$this->input->post('kvatornot');
    // if($kvat == 1){
    //   $this->form_validation->set_rules('kvat_percent', ' Kleinunternehmer with VAT Percentege ', 'required');
    // }

    if ($this->form_validation->run() == TRUE) { 


      $save = $this->home_model->save_edit_model_management();
      if ($save) {
        echo 'success';
        exit();
      }
    }
    else{
      echo validation_errors();
      exit();
    }
    echo 'error';
  }


  public function model_management_detail($uniquecode){
    $data['view'] = 'model-management-detail';
    $data['uniquecode'] = $uniquecode;
    $data['model'] = $this->home_model->get_model_management_detail($uniquecode);
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }




// ===================================================

 

  public function mwm_agency_management(){

    $limit = 8;

    $month = $this->input->get('month');
    $year = $this->input->get('year');
    $vat = $this->input->get('vat');
    $total_amount = $this->input->get('total_amount');
    $other = trim($this->input->get('other'));

    $data['view']='mwm-agency-management';
    $data['invoices'] = $this->home_model->get_mwm_invoices(0, $month, $year, $vat, $total_amount, $other);
    $data['collected_last_month_vat'] = $this->home_model->get_collected_last_month_vat($limit);
    $data['collected_net'] = $this->home_model->get_collected_net($limit);
    $data['collected_invoice_last_no_vat'] = $this->home_model->get_collected_invoice_last_no_vat($limit);
    $data['advances_on_behalf_of_mwm'] = $this->home_model->get_advances_on_behalf_of_mwm($limit);

    $data['month'] = $month;
    $data['year'] = $year;
    $data['mvat'] = $vat;
    $data['total_amount'] = $total_amount;
    $data['other'] = trim($other);

    $this->load->view('frontend/layout', $data);   
  }

  public function save_mwm_agency_management(){ 

    $models = $this->home_model->save_mwm_agency_management();
    if(!empty($models)){
      echo 'success';
      exit();
      
    }
    echo 'error';
  }

  public function invoice(){


    $month = $this->input->get('month');
    $year = $this->input->get('year');
    $vat = $this->input->get('vat');
    $total_amount = $this->input->get('total_amount');
    $other = trim($this->input->get('other'));


    $limit = 8;
    $data['view']='invoice';
    // print_r($data);
    $data['draft_invoices'] = $this->home_model->get_draft_open_invoive($limit, $month, $year, $vat, $total_amount, $other); 
    $data['open_invoices'] = $this->home_model->get_user_open_invoive($limit, $month, $year, $vat, $total_amount, $other);
    $data['approve_invoices'] = $this->home_model->get_user_approve_invoive($limit, $month, $year, $vat, $total_amount, $other);
    $data['reminder_invoices'] = $this->home_model->get_user_reminder_invoive($limit, $month, $year, $vat, $total_amount, $other);
    $data['general_invoices'] = $this->home_model->get_user_general_invoive($limit);
    $data['refund_invoices'] = $this->home_model->get_user_refund_invoive($limit, $month, $year, $vat, $total_amount, $other);
    $data['sent_email'] = $this->home_model->get_accepted_invoices($limit, $month, $year, $vat, $total_amount, $other);
    $data['invoices'] = $this->home_model->get_invoices($month, $year, $vat, $total_amount, $other);



    $data['month'] = $month;
    $data['year'] = $year;
    $data['mvat'] = $vat;
    $data['total_amount'] = $total_amount;
    $data['other'] = trim($other);

    // print_r($data['general_invoices']);
    $this->load->view('frontend/layout', $data);   
  }


  public function accepted_invoice(){


    $month = $this->input->get('month');
    $year = $this->input->get('year');
    $vat = $this->input->get('vat');
    $total_amount = $this->input->get('total_amount');
    $other = trim($this->input->get('other'));

    $data['view']='accepted-invoice';
    
   
    $data['invoices'] = $this->home_model->get_accepted_invoices(0, $month, $year, $vat, $total_amount, $other);
    // print_r($data);

    $data['month'] = $month;
    $data['year'] = $year;
    $data['mvat'] = $vat;
    $data['total_amount'] = $total_amount;
    $data['other'] = trim($other);

    // print_r($data['general_invoices']);
    $this->load->view('frontend/layout', $data);   
  }


  public function save_accepted_invoice_email_send(){ 

    $this->form_validation->set_rules('email_ckecked', 'Email Check/Uncheck ', 'required');
    $this->form_validation->set_rules('invoice_no', 'Invoice Number ', 'required');
   
    if ($this->form_validation->run() == TRUE) { 
      $save = $this->home_model->save_accepted_invoice_email_send();
      if ($save) {
        echo 'success';
        exit();
      }
    }
    else{
      echo validation_errors();
      exit();
    }
    echo 'error';
  }


  public function generate_new_invoice(){
    $data['view']='generate-new-invoice';
    $data['user_id']= $this->home_model->user_id();
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }

  public function generate_reverse_charge_invoice(){
    $data['view']='generate-new-invoice-reverse-charge';
    $data['user_id']= $this->home_model->user_id();
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }

  public function models_for_invoice(){
    $data['error'] = 'error';
    $data['data'] = [];

    $model_id = $this->input->post('model_id');
    $models = $this->home_model->get_model_management_detail($model_id);
    if(!empty($models)){
      $data['error'] = 'success';
      $data['data'] = $models;
    }
    echo json_encode($data);
  }

  public function clients_for_invoice(){
    $data['error'] = 'error';
    $data['data'] = [];

    $client_id = $this->input->post('client_id');
    $models = $this->home_model->get_client_management_detail($client_id);
    if(!empty($models)){
      $data['error'] = 'success';
      $data['data'] = $models;
    }
    echo json_encode($data);
  }

  public function invoice_no_info(){
    $data['error'] = 'error';
    $data['data'] = [];

    $invoice_number = $this->input->post('invoice_number');
    $Checkinvoice_number = get_invoice_no($invoice_number);
    if(!empty($Checkinvoice_number)){
      $data['error'] = 'success';
      $data['data'] = $Checkinvoice_number;
    }
    echo json_encode($data);
  }


 
  public function save_new_invoice(){

    // echo "<pre>";
    // print_r($_POST);
    // exit();
  
    $this->form_validation->set_rules('sel_currency', 'Currency ', 'required');
    $this->form_validation->set_rules('invoice_number', 'Invoice Number ', 'required');
    // $this->form_validation->set_rules('invoice_number', 'Invoice Number ', 'required|min_length[15]|max_length[15]');
    $this->form_validation->set_rules('issue_id', 'Issue Data ', 'required');
    $this->form_validation->set_rules('i_company_name', 'Client company name', 'required');
    // $this->form_validation->set_rules('i_name', 'Client Name ', 'required');
    // $this->form_validation->set_rules('i_address_line1', 'Client Address1 ', 'required'); 
    // $this->form_validation->set_rules('i_pincode', 'Client Pincode ', 'required');
    // $this->form_validation->set_rules('i_vat_tin_number', 'Client Vat Tin Number ', 'required');
    // $this->form_validation->set_rules('i_email', 'Client Email', 'required');
    // $this->form_validation->set_rules('i_mobile_no', 'Client Mobile No ', 'required');
    $this->form_validation->set_rules('i_fee', 'Client Fee', 'required');
    // $this->form_validation->set_rules('i_surname', 'Surname ', 'required');    
    // $this->form_validation->set_rules('i_address_line2', 'Client Address2 ', 'required');
    $this->form_validation->set_rules('i_city', 'Client City', 'required');
    // $this->form_validation->set_rules('i_country', 'Client Country ', 'required');
    // $this->form_validation->set_rules('i_telephone', 'Client Telephone ', 'required');
    // $this->form_validation->set_rules('i_internal_notes', 'Internal Notes ', 'required');
    // $this->form_validation->set_rules('shipping_company_name', 'Shipping Company Name ', 'required');
    // $this->form_validation->set_rules('shipping_name', 'Shipping Name ', 'required');
    // $this->form_validation->set_rules('shipping_address_line1', 'Shipping Address1 ', 'required');
    // $this->form_validation->set_rules('shipping_pincode', 'Shipping Pincode ', 'required');
    // $this->form_validation->set_rules('shipping_surname', 'Shipping Surname', 'required');
    // $this->form_validation->set_rules('shipping_address_line2', 'Shipping Address2 ', 'required');
    // $this->form_validation->set_rules('shipping_city', 'Shipping City ', 'required');
    $this->form_validation->set_rules('payment_terms', 'Payment Terms ', 'required');
    $this->form_validation->set_rules('job_date', 'Job Date From', 'required');
    $this->form_validation->set_rules('job_date_till', 'Job Date Till', 'required');

    $this->form_validation->set_rules('invoice_date', 'Invoice Date ', 'required');
    $this->form_validation->set_rules('uses', 'Uses ', 'required');
    // $this->form_validation->set_rules('invoive_due_date', 'Invoice Due Date ', 'required');
    $this->form_validation->set_rules('reminder', 'Reminder ', 'required');
    $this->form_validation->set_rules('interval_in_days', 'Interval in Days ', 'required');
    $this->form_validation->set_rules('m_model_name', 'Model Name', 'required');
    $this->form_validation->set_rules('m_surname', 'Model Surname ', 'required'); 
    $this->form_validation->set_rules('m_service_fee', 'Service Fee ', 'required');
    // $this->form_validation->set_rules('m_address_line1', 'Model Address1 ', 'required');
    // $this->form_validation->set_rules('m_pincode', 'Model Pincode ', 'required');
    // $this->form_validation->set_rules('m_vat_tin_number', 'Model vat_tin_no ', 'required'); 
    // $this->form_validation->set_rules('m_email', 'Model Email ', 'required');
    $this->form_validation->set_rules('m_name', 'Model Name ', 'required');
    // $this->form_validation->set_rules('m_address_line2', 'Model Address2 ', 'required');
    // $this->form_validation->set_rules('m_city', 'Model City', 'required');
    $this->form_validation->set_rules('m_country', 'Model Country ', 'required');
    // $this->form_validation->set_rules('m_internal_notes', 'Model Internal Notes ', 'required');
    


    // $this->form_validation->set_rules('m_vat', 'Model Vat', 'required');
    // $this->form_validation->set_rules('m_vat_percent', 'Mobile Number ', 'required');
    // $this->form_validation->set_rules('internal_notes', 'Internal Notes ', 'required'); 
    $this->form_validation->set_rules('modelAgencyComission', 'Model Agency Comission', 'required'); 
    $this->form_validation->set_rules('model_budget', 'Model Budget ', 'required');     
    // $this->form_validation->set_rules('modelInclComission', 'Model Vat Comission ', 'required'); 
    $this->form_validation->set_rules('model_total_agreed', 'Model Total Agreed ', 'required'); 
    // $this->form_validation->set_rules('apply_model_fee', 'Model Fee for Apply ', 'required'); 

    // $this->form_validation->set_rules('kvatornot', 'Kleinunternehmer with VAT ', 'required'); 
    // $this->form_validation->set_rules('model_expense1', 'model_expense ', 'required'); 
    
      $expCounter = $this->input->post('manageexp');
      $serCounter = $this->input->post('manageser');
      $modelCounter = $this->input->post('txtmodalIncreaseValue');

      $reverseCounter = $this->input->post('reverserowcount');

      $mModelRow=[];
      $mExpList=[];
      $mSerList=[];
      $mReverse=[];

      for($i = 1; $i <= $reverseCounter; $i++){
        
        $delete = 'reverseTextdel'.$i;
        $name = 'reverseinvoice'.$i;
        $text1 = 'modelText1Name'.$i;
        $price = 'reverseAmount'.$i;

        $is_del = $this->input->post($delete);
        if($is_del == 1){
            continue;
        }

        $r_name = $this->input->post($name);
        $r_text1 = $this->input->post($text1);
        $r_price = $this->input->post($price);

        if(empty($r_name) AND  empty($r_text1) AND empty($r_price)){
          echo ' Reverse  row -'.$i.' atleast (Name/Text1) value required';
          exit();
        }
        // if(empty($m_price) ){
        //   echo ' Reverse row -'.$i.' price required';
        //   exit();
        // }

        $mdlArr['name'] = $r_name;
        $mdlArr['title'] = $r_text1;
        $mdlArr['amount'] = $r_price;
       
        array_push($mReverse, $mdlArr);
      }



      for($i = 1; $i <= $modelCounter; $i++){
        
        $delete = 'modelTextdel'.$i;
        $name = 'modelTextName'.$i;
        $text1 = 'modelText1Name'.$i;
        $text2 = 'modelText2Name'.$i;
        $price = 'modelPriceValue'.$i;

        $is_del = $this->input->post($delete);
        if($is_del == 1){
            continue;
        }

        $m_name = $this->input->post($name);
        $m_text1 = $this->input->post($text1);
        $m_text2 = $this->input->post($text2);
        $m_price = $this->input->post($price);

        if(empty($m_name) AND  empty($m_text1) AND empty($m_text2)){
          echo ' Model Agreed Model addition row -'.$i.' atleast (Name/Text1/Text2) value required';
          exit();
        }
        if(empty($m_price) ){
          echo ' Model Agreed Model addition row -'.$i.' price required';
          exit();
        }

       
        $mdlArr['invoice_number'] = $this->input->post('invoice_number');
        $mdlArr['model_row_id'] = 0;
        $mdlArr['name'] = $m_name;
        $mdlArr['title_1'] = $m_text1;
        $mdlArr['title_2'] = $m_text2;
        $mdlArr['amount'] = $m_price;
        $mdlArr['status'] = 1;
        $mdlArr['creation_date'] = date('Y-m-d H:i:s');
        $mdlArr['modification_date'] = date('Y-m-d H:i:s');

        array_push($mModelRow, $mdlArr);

      }

      // print_r($mModelRow);

      for($i = 1; $i<$expCounter; $i++){
        
        $strexp = 'model_expense'.$i;
        $strexpamt = 'model_exp_amount'.$i;
        $strvatinclude = 'vat_include'.$i;
        $strvatpercent = 'expences_vat_percent'.$i;

        $delete = 'model_expense_del'.$i;
        $is_del = $this->input->post($delete);
        if($is_del == 1){
          continue;
        }

        $this->form_validation->set_rules($strexp,  ucwords(implode(" ", explode("_", $strexp))), 'required');
        $this->form_validation->set_rules($strexpamt,  ucwords(implode(" ", explode("_", $strexpamt))), 'required');
        $this->form_validation->set_rules($strvatinclude,  ucwords(implode(" ", explode("_", $strvatinclude))), 'required');

        $m_vatinclude = $this->input->post($strvatinclude);
        if($m_vatinclude == 1){
          $mypercentval = $this->input->post($strvatpercent);
          // $this->form_validation->set_rules($strvatinclude,  ucwords(implode(" ", explode("_", $strvatpercent))), 'required');
          if((int)$mypercentval <= 0){
            echo implode(" ", explode("_", $strvatpercent)).' required' ;
            exit();
          }
        }

        if ($this->form_validation->run() == TRUE) { 

          $m_exp=$this->input->post($strexp);
          $m_expamt=$this->input->post($strexpamt);
          $m_vatinclude=$this->input->post($strvatinclude);
          $m_vat_percent = $this->input->post($strvatpercent);
         
          $expArr['invoice_number'] =$this->input->post('invoice_number');
          $expArr['model_expense_id'] = 0;
          $expArr['model_expense'] =$m_exp;
          $expArr['model_exp_amount'] =$m_expamt;
          $expArr['vat_include'] =$m_vatinclude;
          $expArr['vat_percent'] = $m_vat_percent;
          $expArr['creation_date'] = date('Y-m-d H:i:s');
          $expArr['modification_date'] = date('Y-m-d H:i:s');


            array_push($mExpList, $expArr);

         }
         else{
          echo validation_errors();
          exit();
        }

      }

      for($i = 1; $i<$serCounter; $i++){
        
        $strser = 'model_service'.$i;
        $strseramt = 'model_service_amount'.$i;
        $strservatinclude = 'service_vat_include'.$i;
        $strserpercent = 'special_need_percent'.$i;



        $delete = 'model_ser_del'.$i;
        $is_del = $this->input->post($delete);
        if($is_del == 1){
          continue;
        }


         $this->form_validation->set_rules($strser,  ucwords(implode(" ", explode("_", $strser))), 'required');
         $this->form_validation->set_rules($strseramt,  ucwords(implode(" ", explode("_", $strseramt))), 'required');
         $this->form_validation->set_rules($strservatinclude,  ucwords(implode(" ", explode("_", $strservatinclude))), 'required');


          $m_vatinclude = $this->input->post($strservatinclude);
          if($m_vatinclude == 1){
            $mypercentval = $this->input->post($strserpercent);
            if((int)$mypercentval <= 0){
              echo implode(" ", explode("_", $strserpercent)).' required' ;
              exit();
            }
          }


         if ($this->form_validation->run() == TRUE) { 

          $strserid = 0;
          $m_ser=$this->input->post($strser);
          $m_seramt=$this->input->post($strseramt);
          $m_servatinclude=$this->input->post($strservatinclude);
          $m_vat_percent = $this->input->post($strserpercent);
         

          $serArr['invoice_number'] =$this->input->post('invoice_number');
          $serArr['model_service_id'] = $strserid;
          $serArr['model_service'] =$m_ser;
          $serArr['model_ser_amount'] =$m_seramt;
          $serArr['vat_include'] =$m_servatinclude;
          $serArr['vat_percent'] = $m_vat_percent;
          $serArr['creation_date'] = date('Y-m-d H:i:s');
          $serArr['modification_date'] = date('Y-m-d H:i:s');

          array_push($mSerList, $serArr);

         }
         else{
          echo validation_errors();
          exit();
        } 
      }
      $kvat = (int)$this->input->post('m_vat_yes_checked');
      if($kvat == 1){
        $this->form_validation->set_rules('m_vat_percent', ' Kleinunternehmer with VAT Percentege ', 'required');
      }



      if ($this->form_validation->run() == TRUE) {  

    // $this->form_validation->set_rules('apply_model_fee', 'Model Fee for Apply ', 'required'); 
        $apply_model_fee = $this->input->post('apply_model_fee');
        if(empty($apply_model_fee)){

          echo 'Model Fee for Apply is required';
          exit();
        }


        $mbd = $this->input->post('model_budget');
        $apmf = $this->input->post('apply_model_fee');
        $mda = $this->input->post('model_total_agreed');

        $amt = (int)$mbd;
        if($apmf == 2){
          $amt = (int)$mda;
        }

        if($amt <= 0){
          echo 'No Modal Price Selected';
          exit();
        }

      
        // $save = $this->home_model->save_new_invoice();
        $modelRow = $this->home_model->save_model_row($mModelRow);
        $saveExp = $this->home_model->save_expenses($mExpList);
        $saveSer = $this->home_model->save_service($mSerList);
        $save = $this->home_model->save_user_new_invoice();
        $save = 1;
        if ($save) {
          if(!empty($mReverse)){

            $invoice_no = $this->input->post('invoice_number');
            $this->home_model->save_reverse_invoice_data($invoice_no, $mReverse);
          }
          echo 'success';
          exit();
        }
    }
    else{
      echo validation_errors();
      exit();
    }
    echo 'error';
  }





  public function save_edit_invoice(){

    // echo '<pre>';
    // print_r($_POST);
    // exit();
  
    // $this->form_validation->set_rules('invoice_number', 'Invoice Number ', 'required|min_length[15]|max_length[15]');
    $this->form_validation->set_rules('sel_currency', 'Currency ', 'required');
    $this->form_validation->set_rules('invoice_number', 'Invoice Number ', 'required');
    $this->form_validation->set_rules('issue_id', 'Issue Data ', 'required');
    $this->form_validation->set_rules('i_company_name', 'Client company name', 'required');
    // $this->form_validation->set_rules('i_name', 'Client Name ', 'required');
    // $this->form_validation->set_rules('i_address_line1', 'Client Address1 ', 'required'); 
    // $this->form_validation->set_rules('i_pincode', 'Client Pincode ', 'required');
    // $this->form_validation->set_rules('i_vat_tin_number', 'Client Vat Tin Number ', 'required');
    // $this->form_validation->set_rules('i_email', 'Client Email', 'required');
    // $this->form_validation->set_rules('i_mobile_no', 'Client Mobile No ', 'required');
    $this->form_validation->set_rules('i_fee', 'Fee', 'required');
    // $this->form_validation->set_rules('i_surname', 'Client Surname ', 'required');    
    // $this->form_validation->set_rules('i_address_line2', 'Client Address2 ', 'required');
    // $this->form_validation->set_rules('i_city', 'Client City', 'required');
    // $this->form_validation->set_rules('i_country', 'Client Country ', 'required');
    // $this->form_validation->set_rules('i_telephone', 'Client Telephone ', 'required');
    // $this->form_validation->set_rules('i_internal_notes', 'Internal Notes ', 'required');
    // $this->form_validation->set_rules('shipping_company_name', 'Shipping Company Name ', 'required');
    // $this->form_validation->set_rules('shipping_name', 'Shipping Name ', 'required');
    // $this->form_validation->set_rules('shipping_address_line1', 'Shipping Address1 ', 'required');
    // $this->form_validation->set_rules('shipping_pincode', 'Shipping Pincode ', 'required');
    // $this->form_validation->set_rules('shipping_surname', 'Shipping Surname', 'required');
    // $this->form_validation->set_rules('shipping_address_line2', 'Shipping Address2 ', 'required');
    // $this->form_validation->set_rules('shipping_city', 'Shipping City ', 'required');
    $this->form_validation->set_rules('payment_terms', 'Payment Terms ', 'required');
    $this->form_validation->set_rules('job_date', 'Job Date From', 'required');
    $this->form_validation->set_rules('job_date_till', 'Job Date Till', 'required');
    $this->form_validation->set_rules('invoice_date', 'Invoice Date ', 'required');
    $this->form_validation->set_rules('uses', 'Uses ', 'required');
    // $this->form_validation->set_rules('invoive_due_date', 'Invoice Due Date ', 'required');
    $this->form_validation->set_rules('reminder', 'Reminder ', 'required');
    $this->form_validation->set_rules('interval_in_days', 'Interval in Days ', 'required');
    // $this->form_validation->set_rules('m_model_name', 'Model Name', 'required');
    // $this->form_validation->set_rules('m_surname', 'Model Surname ', 'required'); 
    // $this->form_validation->set_rules('m_address_line1', 'Model Address1 ', 'required');
    // $this->form_validation->set_rules('m_pincode', 'Model Pincode ', 'required');
    // $this->form_validation->set_rules('m_vat_tin_number', 'Model vat_tin_no ', 'required'); 
    // $this->form_validation->set_rules('m_email', 'Model Email ', 'required');
    $this->form_validation->set_rules('m_name', 'Model Name ', 'required');
    // $this->form_validation->set_rules('m_address_line2', 'Model Address2 ', 'required');
    // $this->form_validation->set_rules('m_city', 'Model City', 'required');
    // $this->form_validation->set_rules('m_country', 'Model Country ', 'required');
    // $this->form_validation->set_rules('m_internal_notes', 'Model Internal Notes ', 'required');
    $this->form_validation->set_rules('m_service_fee', 'Service Fee ', 'required');
    // $this->form_validation->set_rules('m_vat', 'Model Vat', 'required');
    // $this->form_validation->set_rules('m_vat_percent', 'Mobile Number ', 'required');
    // $this->form_validation->set_rules('internal_notes', 'Internal Notes ', 'required'); 
    $this->form_validation->set_rules('modelAgencyComission', 'Model Agency Comission', 'required'); 
    $this->form_validation->set_rules('model_budget', 'Model Budget ', 'required'); 
    // $this->form_validation->set_rules('modelInclComission', 'Model Vat Comission ', 'required'); 
    $this->form_validation->set_rules('model_total_agreed', 'Model Total Agreed ', 'required'); 
    // $this->form_validation->set_rules('apply_model_fee', 'Model Fee for Apply ', 'required'); 


    // $this->form_validation->set_rules('kvatornot', 'Kleinunternehmer with VAT ', 'required'); 
    // $this->form_validation->set_rules('model_expense1', 'model_expense ', 'required'); 
    
      $expCounter = $this->input->post('manageexp');
      $serCounter = $this->input->post('manageser');
      $modelCounter = $this->input->post('txtmodalIncreaseValue');


      $expCounterStart = $this->input->post('manageexpstart');
      $expCounter = $this->input->post('manageexp');      
      $serCounterStart = $this->input->post('manageexp');
      $serCounter = $this->input->post('manageser');

      $modelCounterStart = $this->input->post('txtmodalIncreaseValueStart');
      $modelCounter = $this->input->post('txtmodalIncreaseValue');


      $mModelRow=[];
      $mExpList=[];
      $mSerList=[];

      $mModelRowDel=[];
      $mExpListDel=[];
      $mSerListDel=[];


      for($i = 1; $i <= $modelCounter; $i++){
        
        $id = 'modelTextid'.$i;
        $delete = 'modelTextdel'.$i;
        $name = 'modelTextName'.$i;
        $text1 = 'modelText1Name'.$i;
        $text2 = 'modelText2Name'.$i;
        $price = 'modelPriceValue'.$i;

        $is_del = $this->input->post($delete);
        $is_id = $this->input->post($id);
        if($is_del == 1){
            if($is_id > 0){
              array_push($mModelRowDel, $is_id);
            }          
            continue;
        }

        $m_name = $this->input->post($name);
        $m_text1 = $this->input->post($text1);
        $m_text2 = $this->input->post($text2);
        $m_price = $this->input->post($price);

        if(empty($m_name) AND  empty($m_text1) AND empty($m_text2)){
          echo ' Model Agreed Model addition row -'.$i.' atleast (Name/Text1/Text2) value required';
          exit();
        }
        if(empty($m_price) ){
          echo ' Model Agreed Model addition row -'.$i.' price required';
          exit();
        }

       
        $mdlArr['invoice_number'] = $this->input->post('invoice_number');
        $mdlArr['model_row_id'] = $is_id;
        $mdlArr['name'] = $m_name;
        $mdlArr['title_1'] = $m_text1;
        $mdlArr['title_2'] = $m_text2;
        $mdlArr['amount'] = $m_price;
        $mdlArr['status'] = 1;
        $mdlArr['creation_date'] = date('Y-m-d H:i:s');
        $mdlArr['modification_date'] = date('Y-m-d H:i:s');


        array_push($mModelRow, $mdlArr);

      }

      // print_r($mModelRow);
      // exit();



      for($i = 1; $i<$expCounter; $i++){
        
        $strexpid = 'model_expense_id'.$i;
        $strexp = 'model_expense'.$i;
        $strexpamt = 'model_exp_amount'.$i;
        $strvatinclude = 'vat_include'.$i;
        $strvatpercent = 'expences_vat_percent'.$i;

        $delete = 'model_expense_del'.$i;
        $is_del = $this->input->post($delete);
        $is_id = $this->input->post($strexpid);
        if($is_del == 1){
          if($is_id > 0){
            array_push( $mExpListDel, $is_id);
          }
          continue;
        }

        $this->form_validation->set_rules($strexp,  ucwords(implode(" ", explode("_", $strexp))), 'required');
        $this->form_validation->set_rules($strexpamt,  ucwords(implode(" ", explode("_", $strexpamt))), 'required');
        $this->form_validation->set_rules($strvatinclude,  ucwords(implode(" ", explode("_", $strvatinclude))), 'required');

        $m_vatinclude = $this->input->post($strvatinclude);
        if($m_vatinclude == 1){
          $mypercentval = $this->input->post($strvatpercent);
          // $this->form_validation->set_rules($strvatinclude,  ucwords(implode(" ", explode("_", $strvatpercent))), 'required');
          if((int)$mypercentval <= 0){
            echo implode(" ", explode("_", $strvatpercent)).' required' ;
            exit();
          }
        }

        if ($this->form_validation->run() == TRUE) { 

          $m_exp=$this->input->post($strexp);
          $m_expamt=$this->input->post($strexpamt);
          $m_vatinclude=$this->input->post($strvatinclude);
          $m_vat_percent = $this->input->post($strvatpercent);
         
          $expArr['invoice_number'] =$this->input->post('invoice_number');
          $expArr['model_expense_id'] = $is_id;
          $expArr['model_expense'] =$m_exp;
          $expArr['model_exp_amount'] =$m_expamt;
          $expArr['vat_include'] =$m_vatinclude;
          $expArr['vat_percent'] = $m_vat_percent;
          $expArr['creation_date'] = date('Y-m-d H:i:s');
          $expArr['modification_date'] = date('Y-m-d H:i:s');


          array_push($mExpList, $expArr);

         }
         else{
          echo validation_errors();
          exit();
        }

      }

      for($i = 1; $i<$serCounter; $i++){
        
        $strserid = 'model_service_id'.$i;
        $strser = 'model_service'.$i;
        $strseramt = 'model_service_amount'.$i;
        $strservatinclude = 'service_vat_include'.$i;
        $strserpercent = 'special_need_percent'.$i;

        $delete = 'model_ser_del'.$i;
        $is_del = $this->input->post($delete);
        $is_id = $this->input->post($strserid);
        if($is_del == 1){
          if($is_id > 0){

            array_push($mSerListDel, $is_id);

          }
 
          continue;
        }


         $this->form_validation->set_rules($strser,  ucwords(implode(" ", explode("_", $strser))), 'required');
         $this->form_validation->set_rules($strseramt,  ucwords(implode(" ", explode("_", $strseramt))), 'required');
         $this->form_validation->set_rules($strservatinclude,  ucwords(implode(" ", explode("_", $strservatinclude))), 'required');


          $m_vatinclude = $this->input->post($strservatinclude);
          if($m_vatinclude == 1){
            $mypercentval = $this->input->post($strserpercent);
            if((int)$mypercentval <= 0){
              echo implode(" ", explode("_", $strserpercent)).' required' ;
              exit();
            }
          }


         if ($this->form_validation->run() == TRUE) {  

          $m_ser=$this->input->post($strser);
          $m_seramt=$this->input->post($strseramt);
          $m_servatinclude=$this->input->post($strservatinclude);
          $m_vat_percent = $this->input->post($strserpercent);
         

          $serArr['invoice_number'] =$this->input->post('invoice_number');
          $serArr['model_service_id'] = $is_id;
          $serArr['model_service'] =$m_ser;
          $serArr['model_ser_amount'] =$m_seramt;
          $serArr['vat_include'] =$m_servatinclude;
          $serArr['vat_percent'] = $m_vat_percent;
          $serArr['creation_date'] = date('Y-m-d H:i:s');
          $serArr['modification_date'] = date('Y-m-d H:i:s');

          array_push($mSerList, $serArr);

         }
         else{
          echo validation_errors();
          exit();
        } 
      }
      $kvat = (int)$this->input->post('m_vat_yes_checked');
      if($kvat == 1){
        $this->form_validation->set_rules('m_vat_percent', ' Kleinunternehmer with VAT Percentege ', 'required');
      }



      if ($this->form_validation->run() == TRUE) {  

    // $this->form_validation->set_rules('apply_model_fee', 'Model Fee for Apply ', 'required'); 
        $apply_model_fee = $this->input->post('apply_model_fee');
        if(empty($apply_model_fee)){

          echo 'Model Fee for Apply is required';
          exit();
        }

        $modelRow = $this->home_model->save_model_row($mModelRow);
        $saveExp = $this->home_model->save_expenses($mExpList);
        $saveSer = $this->home_model->save_service($mSerList);
        $save = $this->home_model->save_edit_invoice();


        // check refund
        $refund_d = (int)$this->input->post('refund_invoice');
        if($refund_d == 1){

        	$invoice_number = $this->input->post('invoice_number');
        	$save = $this->home_model->save_create_refund($invoice_number);
        }

        // print_r($save);
        // exit();
 

      if(!empty($mModelRowDel)){
        $this->home_model->delete_invoice_support_table_data(1, $mModelRowDel);
      }
      if(!empty($mExpListDel)){
        $this->home_model->delete_invoice_support_table_data(2, $mExpListDel);
      }
      if(!empty($mSerListDel)){
        $this->home_model->delete_invoice_support_table_data(3, $mSerListDel);
      }

        $save = 1;
        if ($save) {
          echo 'success';
          exit();
        }
    }
    else{
      echo validation_errors();
      exit();
    }
    echo 'error';
  }


  public function invoice_correction(){
    $data['view'] = 'invoice-lists-correction';
    $data['invoices'] = $this->home_model->invoice_correction();
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }





  public function save_edit_invoice_correction(){
  

    // echo '<pre>';
    // print_r($_POST);
    // exit();
  
    // $this->form_validation->set_rules('invoice_number', 'Invoice Number ', 'required|min_length[15]|max_length[15]');
    $this->form_validation->set_rules('invoice_number', 'Invoice Number ', 'required');
    $this->form_validation->set_rules('issue_id', 'Issue Data ', 'required');
    $this->form_validation->set_rules('i_company_name', 'Client company name', 'required');
    // $this->form_validation->set_rules('i_name', 'Client Name ', 'required');
    // $this->form_validation->set_rules('i_address_line1', 'Client Address1 ', 'required'); 
    // $this->form_validation->set_rules('i_pincode', 'Client Pincode ', 'required');
    // $this->form_validation->set_rules('i_vat_tin_number', 'Client Vat Tin Number ', 'required');
    // $this->form_validation->set_rules('i_email', 'Client Email', 'required');
    // $this->form_validation->set_rules('i_mobile_no', 'Client Mobile No ', 'required');
    // $this->form_validation->set_rules('i_fee', 'Client Fee', 'required');
    // $this->form_validation->set_rules('i_surname', 'Client Surname ', 'required');    
    // $this->form_validation->set_rules('i_address_line2', 'Client Address2 ', 'required');
    // $this->form_validation->set_rules('i_city', 'Client City', 'required');
    // $this->form_validation->set_rules('i_country', 'Client Country ', 'required');
    // $this->form_validation->set_rules('i_telephone', 'Client Telephone ', 'required');
    // $this->form_validation->set_rules('i_internal_notes', 'Internal Notes ', 'required');
    // $this->form_validation->set_rules('shipping_company_name', 'Shipping Company Name ', 'required');
    // $this->form_validation->set_rules('shipping_name', 'Shipping Name ', 'required');
    // $this->form_validation->set_rules('shipping_address_line1', 'Shipping Address1 ', 'required');
    // $this->form_validation->set_rules('shipping_pincode', 'Shipping Pincode ', 'required');
    // $this->form_validation->set_rules('shipping_surname', 'Shipping Surname', 'required');
    // $this->form_validation->set_rules('shipping_address_line2', 'Shipping Address2 ', 'required');
    // $this->form_validation->set_rules('shipping_city', 'Shipping City ', 'required');
    $this->form_validation->set_rules('payment_terms', 'Payment Terms ', 'required');
    $this->form_validation->set_rules('job_date', 'Job Date Form', 'required');
    $this->form_validation->set_rules('job_date_till', 'Job Date Till', 'required');
    $this->form_validation->set_rules('invoice_date', 'Invoice Date ', 'required');
    $this->form_validation->set_rules('uses', 'Uses ', 'required');
    // $this->form_validation->set_rules('invoive_due_date', 'Invoice Due Date ', 'required');
    $this->form_validation->set_rules('reminder', 'Reminder ', 'required');
    $this->form_validation->set_rules('interval_in_days', 'Interval in Days ', 'required');
    // $this->form_validation->set_rules('m_model_name', 'Model Name', 'required');
    // $this->form_validation->set_rules('m_surname', 'Model Surname ', 'required'); 
    // $this->form_validation->set_rules('m_address_line1', 'Model Address1 ', 'required');
    // $this->form_validation->set_rules('m_pincode', 'Model Pincode ', 'required');
    // $this->form_validation->set_rules('m_vat_tin_number', 'Model vat_tin_no ', 'required'); 
    // $this->form_validation->set_rules('m_email', 'Model Email ', 'required');
    $this->form_validation->set_rules('m_name', 'Model Name ', 'required');
    // $this->form_validation->set_rules('m_address_line2', 'Model Address2 ', 'required');
    // $this->form_validation->set_rules('m_city', 'Model City', 'required');
    // $this->form_validation->set_rules('m_country', 'Model Country ', 'required');
    // $this->form_validation->set_rules('m_internal_notes', 'Model Internal Notes ', 'required');
    $this->form_validation->set_rules('m_service_fee', 'Service Fee ', 'required');
    // $this->form_validation->set_rules('m_vat', 'Model Vat', 'required');
    // $this->form_validation->set_rules('m_vat_percent', 'Mobile Number ', 'required');
    // $this->form_validation->set_rules('internal_notes', 'Internal Notes ', 'required'); 
    $this->form_validation->set_rules('modelAgencyComission', 'Model Agency Comission', 'required'); 
    $this->form_validation->set_rules('model_budget', 'Model Budget ', 'required'); 
    // $this->form_validation->set_rules('modelInclComission', 'Model Vat Comission ', 'required'); 
    $this->form_validation->set_rules('model_total_agreed', 'Model Total Agreed ', 'required'); 
    // $this->form_validation->set_rules('apply_model_fee', 'Model Fee for Apply ', 'required'); 
    $this->form_validation->set_rules('correction_input', 'Correction message for invoice ', 'required'); 





    // $this->form_validation->set_rules('kvatornot', 'Kleinunternehmer with VAT ', 'required'); 
    // $this->form_validation->set_rules('model_expense1', 'model_expense ', 'required'); 
    
      $expCounter = $this->input->post('manageexp');
      $serCounter = $this->input->post('manageser');
      $modelCounter = $this->input->post('txtmodalIncreaseValue');


      $expCounterStart = $this->input->post('manageexpstart');
      $expCounter = $this->input->post('manageexp');      
      $serCounterStart = $this->input->post('manageexp');
      $serCounter = $this->input->post('manageser');

      $modelCounterStart = $this->input->post('txtmodalIncreaseValueStart');
      $modelCounter = $this->input->post('txtmodalIncreaseValue');


      $mModelRow=[];
      $mExpList=[];
      $mSerList=[];

      $mModelRowDel=[];
      $mExpListDel=[];
      $mSerListDel=[];


      for($i = 1; $i <= $modelCounter; $i++){
        
        $id = 'modelTextid'.$i;
        $delete = 'modelTextdel'.$i;
        $name = 'modelTextName'.$i;
        $text1 = 'modelText1Name'.$i;
        $text2 = 'modelText2Name'.$i;
        $price = 'modelPriceValue'.$i;

        $is_del = $this->input->post($delete);
        $is_id = $this->input->post($id);
        if($is_del == 1){
            if($is_id > 0){
              array_push($mModelRowDel, $is_id);
            }          
            continue;
        }

        $m_name = $this->input->post($name);
        $m_text1 = $this->input->post($text1);
        $m_text2 = $this->input->post($text2);
        $m_price = $this->input->post($price);

        if(empty($m_name) AND  empty($m_text1) AND empty($m_text2)){
          echo ' Model Agreed Model addition row -'.$i.' atleast (Name/Text1/Text2) value required';
          exit();
        }
        if(empty($m_price) ){
          echo ' Model Agreed Model addition row -'.$i.' price required';
          exit();
        }

       
        $mdlArr['invoice_number'] = $this->input->post('invoice_number');
        $mdlArr['model_row_id'] = $is_id;
        $mdlArr['name'] = $m_name;
        $mdlArr['title_1'] = $m_text1;
        $mdlArr['title_2'] = $m_text2;
        $mdlArr['amount'] = $m_price;
        $mdlArr['status'] = 1;
        $mdlArr['creation_date'] = date('Y-m-d H:i:s');
        $mdlArr['modification_date'] = date('Y-m-d H:i:s');


        array_push($mModelRow, $mdlArr);

      }

      // print_r($mModelRow);
      // exit();



      for($i = 1; $i<$expCounter; $i++){
        
        $strexpid = 'model_expense_id'.$i;
        $strexp = 'model_expense'.$i;
        $strexpamt = 'model_exp_amount'.$i;
        $strvatinclude = 'vat_include'.$i;
        $strvatpercent = 'expences_vat_percent'.$i;

        $delete = 'model_expense_del'.$i;
        $is_del = $this->input->post($delete);
        $is_id = $this->input->post($strexpid);
        if($is_del == 1){
          if($is_id > 0){
            array_push( $mExpListDel, $is_id);
          }
          continue;
        }

        $this->form_validation->set_rules($strexp,  ucwords(implode(" ", explode("_", $strexp))), 'required');
        $this->form_validation->set_rules($strexpamt,  ucwords(implode(" ", explode("_", $strexpamt))), 'required');
        $this->form_validation->set_rules($strvatinclude,  ucwords(implode(" ", explode("_", $strvatinclude))), 'required');

        $m_vatinclude = $this->input->post($strvatinclude);
        if($m_vatinclude == 1){
          $mypercentval = $this->input->post($strvatpercent);
          // $this->form_validation->set_rules($strvatinclude,  ucwords(implode(" ", explode("_", $strvatpercent))), 'required');
          if((int)$mypercentval <= 0){
            echo implode(" ", explode("_", $strvatpercent)).' required' ;
            exit();
          }
        }

        if ($this->form_validation->run() == TRUE) { 

          $m_exp=$this->input->post($strexp);
          $m_expamt=$this->input->post($strexpamt);
          $m_vatinclude=$this->input->post($strvatinclude);
          $m_vat_percent = $this->input->post($strvatpercent);
         
          $expArr['invoice_number'] =$this->input->post('invoice_number');
          $expArr['model_expense_id'] = $is_id;
          $expArr['model_expense'] =$m_exp;
          $expArr['model_exp_amount'] =$m_expamt;
          $expArr['vat_include'] =$m_vatinclude;
          $expArr['vat_percent'] = $m_vat_percent;
          $expArr['creation_date'] = date('Y-m-d H:i:s');
          $expArr['modification_date'] = date('Y-m-d H:i:s');


          array_push($mExpList, $expArr);

         }
         else{
          echo validation_errors();
          exit();
        }

      }

      for($i = 1; $i<$serCounter; $i++){
        
        $strserid = 'model_service_id'.$i;
        $strser = 'model_service'.$i;
        $strseramt = 'model_service_amount'.$i;
        $strservatinclude = 'service_vat_include'.$i;
        $strserpercent = 'special_need_percent'.$i;

        $delete = 'model_ser_del'.$i;
        $is_del = $this->input->post($delete);
        $is_id = $this->input->post($strserid);
        if($is_del == 1){
          if($is_id > 0){

            array_push($mSerListDel, $is_id);

          }
 
          continue;
        }


         $this->form_validation->set_rules($strser,  ucwords(implode(" ", explode("_", $strser))), 'required');
         $this->form_validation->set_rules($strseramt,  ucwords(implode(" ", explode("_", $strseramt))), 'required');
         $this->form_validation->set_rules($strservatinclude,  ucwords(implode(" ", explode("_", $strservatinclude))), 'required');


          $m_vatinclude = $this->input->post($strservatinclude);
          if($m_vatinclude == 1){
            $mypercentval = $this->input->post($strserpercent);
            if((int)$mypercentval <= 0){
              echo implode(" ", explode("_", $strserpercent)).' required' ;
              exit();
            }
          }


         if ($this->form_validation->run() == TRUE) {  

          $m_ser=$this->input->post($strser);
          $m_seramt=$this->input->post($strseramt);
          $m_servatinclude=$this->input->post($strservatinclude);
          $m_vat_percent = $this->input->post($strserpercent);
         

          $serArr['invoice_number'] =$this->input->post('invoice_number');
          $serArr['model_service_id'] = $is_id;
          $serArr['model_service'] =$m_ser;
          $serArr['model_ser_amount'] =$m_seramt;
          $serArr['vat_include'] =$m_servatinclude;
          $serArr['vat_percent'] = $m_vat_percent;
          $serArr['creation_date'] = date('Y-m-d H:i:s');
          $serArr['modification_date'] = date('Y-m-d H:i:s');

          array_push($mSerList, $serArr);

         }
         else{
          echo validation_errors();
          exit();
        } 
      }
      $kvat = (int)$this->input->post('m_vat_yes_checked');
      if($kvat == 1){
        $this->form_validation->set_rules('m_vat_percent', ' Kleinunternehmer with VAT Percentege ', 'required');
      }



      if ($this->form_validation->run() == TRUE) {  

    // $this->form_validation->set_rules('apply_model_fee', 'Model Fee for Apply ', 'required'); 
        $apply_model_fee = $this->input->post('apply_model_fee');
        if(empty($apply_model_fee)){

          echo 'Model Fee for Apply is required';
          exit();
        }

        $modelRow = $this->home_model->save_model_row($mModelRow);
        $saveExp = $this->home_model->save_expenses($mExpList);
        $saveSer = $this->home_model->save_service($mSerList);
        $save = $this->home_model->save_edit_invoice_correction();

        // print_r($save);
        // exit();
 

      if(!empty($mModelRowDel)){
        $this->home_model->delete_invoice_support_table_data(1, $mModelRowDel);
      }
      if(!empty($mExpListDel)){
        $this->home_model->delete_invoice_support_table_data(2, $mExpListDel);
      }
      if(!empty($mSerListDel)){
        $this->home_model->delete_invoice_support_table_data(3, $mSerListDel);
      }

        $save = 1;
        if ($save) {
          echo 'success';
          exit();
        }
    }
    else{
      echo validation_errors();
      exit();
    }
    echo 'error';
  }

 
 
  public function generate_invoice($invoice_number){
    
    $data['view'] = 'generate-invoice';
    $data['invoice'] = $this->home_model->get_invoive_detail($invoice_number);
    $data['model_data'] = $this->home_model->model_agreed_data($invoice_number);
    $data['headers'] = $this->home_model->get_invoive_headers($invoice_number);
    $data['expenses'] = $this->home_model->get_invoice_expenses($invoice_number);
    $data['services'] = $this->home_model->get_invoice_service($invoice_number);
    $data['_clients'] = $this->home_model->get_clients_for_invoice_approval();
    
    // print_r($data);
    $data['user_id'] = $this->home_model->user_id();
    $data['invoice_no'] = $invoice_number;

    $this->load->view('frontend/layout', $data);   
  }

  public function generate_invoice_headers(){ 

    $data['error'] = 'error';
    $data['data'] = 0;

    $this->form_validation->set_rules('inv_number', 'Invoice Number ', 'required');
    $this->form_validation->set_rules('inv_id', 'Invoice id ', 'required');
    $this->form_validation->set_rules('inv_title', 'Invoice Title  ', 'required'); 
    $this->form_validation->set_rules('inv_value', 'Invoice Value ', 'required');
    if ($this->form_validation->run() == TRUE) { 
      $invoice_id = $this->home_model->generate_invoice_headers();
      if ($invoice_id) {
          $data['error'] = 'success';
          $data['data'] = $invoice_id;
      }
    }
    else{
      $data['data'] = validation_errors();
    }
    echo json_encode($data);
  }

  public function delete_invoice_headers(){ 

    $data['error'] = 'error';
    $data['data'] = 0;

    $this->form_validation->set_rules('inv_id', 'Invoice id ', 'required');
    if ($this->form_validation->run() == TRUE) { 
      $invoice_id = $this->home_model->delete_invoice_headers();
      if ($invoice_id) {
          $data['error'] = 'success';

      }
    }
    else{
      $data['data'] = validation_errors();
    }
    echo json_encode($data);
  }


  public function forward_invoice_approval(){ 
 
    $this->form_validation->set_rules('sendapprovalinvoice', 'No Invoice selected ', 'required');
    $this->form_validation->set_rules('assignee', 'Assign User  ', 'required');
    if ($this->form_validation->run() == TRUE) { 
      $approval = $this->home_model->forward_invoice_approval();
      if ($approval) {
          echo 'success';
          exit();
      }
    }
    else{
      echo validation_errors();
      exit();
    }
    echo 'error';
  }

  public function invoice_approve_or_change_request(){ 
 
    $this->form_validation->set_rules('approve_invoice_id', 'No Invoice Found ', 'required');
    $this->form_validation->set_rules('approve_status', ' Select Approve / Change for request  ', 'required');
    if ($this->form_validation->run() == TRUE) { 
      $approval = $this->home_model->invoice_approve_or_change_request();
      if ($approval) {
          echo 'success';
          exit();
      }
    }
    else{
      echo validation_errors();
      exit();
    }
    echo 'error';
  }


  public function forward_refund_approval(){ 

    // print_r($_POST);
 
    $this->form_validation->set_rules('sendapprovalinvoice', 'No Invoice selected ', 'required');
    $this->form_validation->set_rules('assignee', 'Assign User  ', 'required');
    if ($this->form_validation->run() == TRUE) { 
      $approval = $this->home_model->forward_refund_approval();
      if ($approval) {
          echo 'success';
          exit();
      }
    }
    else{
      echo validation_errors();
      exit();
    }
    echo 'error';
  }


 
  public function generate_invoice_preview(){
    $data['view']='generate-invoice-preview';
    $data['user_id']= $this->home_model->user_id();
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }

  

  public function refund_overview(){
    $limit = 8;
    $data['view']='refund-overview';
    $data['draft_invoices'] = $this->home_model->get_draft_refund_invoive($limit); 
    $data['open_invoices'] = $this->home_model->get_open_refund_invoive($limit);
    $data['approve_invoices'] = $this->home_model->get_approve_refund_invoive($limit);
    $data['reminder_invoices'] = []; //$this->home_model->get_user_reminder_invoive($limit);
    // $data['refund_invoices'] = $this->home_model->get_user_refund_invoive($limit);
    $data['refund_invoices'] = $this->home_model->get_refund_invoive($limit, '', '', '', '', '');

    $data['invoices'] = $this->home_model->get_user_refund_invoive(0, '', '', '', '', '');
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }


  public function invoive_refund(){
    
    $invoice_number = '0';
    if(!empty($this->input->get('invoive'))){
        $invoice_number = $this->input->get('invoive');
    }

    $data['view'] = 'generate-invoice-refund';

    $data['invoices'] = $this->home_model->get_invoive_list();    
    $data['user_id'] = $this->home_model->user_id();
 
    $data['invoice'] = $this->home_model->get_invoive_detail($invoice_number);
    $data['model_data'] = $this->home_model->model_agreed_data($invoice_number);
    $data['headers'] = $this->home_model->get_invoive_headers($invoice_number);
    $data['expenses'] = $this->home_model->get_invoice_expenses($invoice_number);
    $data['services'] = $this->home_model->get_invoice_service($invoice_number);
    $data['_clients'] = $this->home_model->get_clients_for_invoice_approval();
    $data['invoice_no'] = $invoice_number;
 
    // print_r($data['invoice']);

    $this->load->view('frontend/layout', $data);   
  }

  public function save_invoive_refund(){ 
 
    $this->form_validation->set_rules('refaund_service_id', 'Refaund Serviced Data', 'required');
    if ($this->form_validation->run() == TRUE) { 
      $invoice_id = $this->home_model->save_invoive_refund();
      if ($invoice_id) {
        echo 'success';
        exit();
      }
    }
    else{
     echo validation_errors();
     exit();
    }
    echo 'error';
  }



   public function get_draft_refunds(){
    $data['view'] = 'refund-lists';
    $data['page'] = 'Draft';
    $data['invoices'] = $this->home_model->get_draft_refund_invoive(0);
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }

  public function get_open_refunds(){
    $data['view'] = 'refund-lists';
    $data['page'] = 'Open';
    $data['invoices'] = $this->home_model->get_open_refund_invoive(0);
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }

  public function get_approve_refunds(){
    $data['view'] = 'refund-lists';
    $data['page'] = 'Approve';
    $data['invoices'] = $this->home_model->get_approve_refund_invoive(0);
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }

  // public function get_reminder_refund(){
  //   $data['view'] = 'refund-lists';
  //   $data['page'] = 'Reminder';
  //   $data['invoices'] = $this->home_model->get_user_reminder_invoive(0);
  //   // print_r($data);
  //   $this->load->view('frontend/layout', $data);   
  // }

  public function get_prepared_refunds(){
    $data['view'] = 'refund-lists';
    $data['page'] = 'Refund';
    $data['invoices'] = []; //$this->home_model->get_user_refund_invoive(0);
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }




  public function edit_invoice(){

    $invoice_number = '';
    if(!empty($this->input->get('invoive'))){
        $invoice_number = $this->input->get('invoive');
    }

    $data['view']='edit-invoice';
    $data['invoices'] = $this->home_model->get_invoive_list();
    $data['invoice_number'] = $invoice_number;
    
    $data['invoice_info'] = $this->home_model->get_invoive_detail($invoice_number);
    $data['model_data'] = $this->home_model->model_agreed_data($invoice_number);
    $data['headers'] = $this->home_model->get_invoive_headers($invoice_number);
    $data['expenses'] = $this->home_model->get_invoice_expenses($invoice_number);
    $data['services'] = $this->home_model->get_invoice_service($invoice_number);
    
    $data['user_id'] = $this->home_model->user_id();
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }

  public function edit_reverse_charge_invoice(){

    $invoice_number = '';
    if(!empty($this->input->get('invoive'))){
        $invoice_number = $this->input->get('invoive');
    }

    $data['view']='edit-reverse-charge-invoice';
    $data['invoices'] = $this->home_model->get_invoive_list();
    $data['invoice_number'] = $invoice_number;
    
    $data['invoice_info'] = $this->home_model->get_invoive_detail($invoice_number);
    $data['model_data'] = $this->home_model->model_agreed_data($invoice_number);
    $data['headers'] = $this->home_model->get_invoive_headers($invoice_number);
    $data['expenses'] = $this->home_model->get_invoice_expenses($invoice_number);
    $data['services'] = $this->home_model->get_invoice_service($invoice_number);
    
    $data['user_id'] = $this->home_model->user_id();
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }



  public function edit_invoice_correction(){

    $invoice_number = '';
    if(!empty($this->input->get('invoive'))){
        $invoice_number = $this->input->get('invoive');
    }

    $data['view']='edit-invoice-correction';
    $data['invoices'] = $this->home_model->get_invoive_list();
    $data['invoice_number'] = $invoice_number;
    
    $data['invoice_info'] = $this->home_model->get_invoive_detail($invoice_number);
    $data['model_data'] = $this->home_model->model_agreed_data($invoice_number);
    $data['headers'] = $this->home_model->get_invoive_headers($invoice_number);
    $data['expenses'] = $this->home_model->get_invoice_expenses($invoice_number);
    $data['services'] = $this->home_model->get_invoice_service($invoice_number);
    
    $data['user_id'] = $this->home_model->user_id();
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }




 

  public function edit_refund_invoice(){
    $invoice_number = '';
    if(!empty($this->input->get('invoive'))){
        $invoice_number = $this->input->get('invoive');

      $data['invoice_number'] = $invoice_number;

      $inv_info =  $this->home_model->get_invoive_detail($invoice_number);
      // print_r($inv_info);
      $data['invoice_info'] = $inv_info;
      if(!empty($inv_info)){
        $data['model'] = $this->home_model->get_model_management_detail_id($inv_info->model_id);
      }
       
      $data['deduction_info'] = $this->home_model->get_user_wallet($invoice_number);
     
      $data['model_data'] = $this->home_model->model_agreed_data($invoice_number);
      $data['headers'] = $this->home_model->get_invoive_headers($invoice_number);
      $data['expenses'] = $this->home_model->get_invoice_expenses($invoice_number);
      $data['services'] = $this->home_model->get_invoice_service($invoice_number);
    }
    $data['invoices'] = $this->home_model->get_invoive_list();
    $data['view']='edit-refund-invoice';
    $data['user_id'] = $this->home_model->user_id();
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }





  public function deductions(){

    // $month = $this->input->get('month');
    // $year = $this->input->get('year');
    // $vat = $this->input->get('vat');
    // $total_amount = $this->input->get('total_amount');
    $search = trim($this->input->get('search'));

    $data['view']='deductions';
    $data['models'] = $this->home_model->get_model_management_list_deduction($search);

   
    $data['search'] = trim($search);

    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }

  public function create_deduction_transaction($model_id){
    $data['view']='creation-deduction-transction';
    $data['model_id'] = $model_id;
    $data['_model_expenses'] = $this->home_model->create_deduction_transaction($model_id);
    $data['model'] = get_model_info_by_code($model_id);
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }


  public function expences_deduction(){
    $data['view']='expences-deduction';
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }

  public function reports_overview(){
    $limit = 12;
    $data['view']='reports-overview';
    $data['open_invoices'] = $this->home_model->get_user_open_invoive($limit, '', '', '', '', '');
    $data['open_refunds'] = $this->home_model->get_open_refund_invoive($limit);
    $data['mwm_invoices'] = $this->home_model->get_mwm_invoices($limit, '', '', '', '', '');
    $data['select_income'] = $this->home_model->get_select_income($limit);
    $data['expenses'] = $this->home_model->get_expenses($limit);

    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }

  public function reports_detail_view(){
    $data['view']='reports-detail-view';
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }

  public function administration(){
    $data['view']='administration';
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }

  public function save_logo(){  

      $filename = 'logo_'.time() . date('Ymd');
      $image = '';

      if(isset($_FILES['image'])&&$_FILES['image']['error']=='0'){
          
          $original_file_name = $_FILES['image']['name'];
          $config = array(
            'upload_path' => "assets/frontend/images/",
            'allowed_types' => "jpg|png|jpeg",
            'overwrite' => false,
            'max_size' => "2560", 
            'file_name' => $filename
          );

          $this->load->library('upload', $config);
          if($this->upload->do_upload('image')) {  
              $data = array('upload_data' => $this->upload->data());
              $image=$data['upload_data']['file_name'];
          }
          else {
            $error = array('error' => $this->upload->display_errors());
            echo $error['error'];die;
          }
       }

      $save = $this->home_model->save_logo($image);
      if ($save) {
        echo 'success';
        exit();
      }
    
    echo 'error';
  }



   public function get_footer_contents(){
    
    $data['error'] = 'error';
    $data['message'] = 'Error to get details';
    $data['data'] = []; 

    $footer = get_footer_contents();
      
    if(!empty($footer)){     
      $data['error'] = 'success';
      $data['message'] = 'Detail get successfully.';
      $data['data'] = $footer;
    }
    echo json_encode($data);    
  }


  public function save_footer_contents(){ 

    $this->form_validation->set_rules('selectname', 'Name ', 'required');
    $this->form_validation->set_rules('address1', 'Address 1 ', 'required'); 
    $this->form_validation->set_rules('address2', 'Address 2 ', 'required');
    $this->form_validation->set_rules('address3', 'Address 3 ', 'required');
    $this->form_validation->set_rules('address4', 'Address 4 ', 'required');
    
    if ($this->form_validation->run() == TRUE) {
      $save = $this->home_model->save_footer_contents();
      if ($save) {
        echo 'success';
        exit();
      }
    }
    else{
      echo validation_errors();
      exit();
    }
    echo 'error';
  }






  public function profile(){
    $data['view'] = 'user-profile';
    $data['profile'] = $this->home_model->get_profile();;
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }
  public function settings(){
    $data['view']='settings';
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }

  public function save_profile(){ 

    $this->form_validation->set_rules('name', 'Name ', 'required');
    $this->form_validation->set_rules('phone', 'Contact Number ', 'required'); 
    $this->form_validation->set_rules('address', 'Address ', 'required');
    $this->form_validation->set_rules('city', 'City ', 'required');
    $this->form_validation->set_rules('state', 'State ', 'required');
    $this->form_validation->set_rules('country', 'Country ', 'required');
    $this->form_validation->set_rules('pincode', 'Pincode ', 'required');
     
    if ($this->form_validation->run() == TRUE) { 

      $filename = time() . date('Ymd');
      $image = '';

      if(isset($_FILES['image'])&&$_FILES['image']['error']=='0'){
          
          $original_file_name = $_FILES['image']['name'];
          $config = array(
            'upload_path' => "assets/upload/images/",
            'allowed_types' => "jpg|png|jpeg|pdf",
            'overwrite' => false,
            'max_size' => "2560", 
            'file_name' => $filename
          );

          $this->load->library('upload', $config);
          if($this->upload->do_upload('image')) {  
              $data = array('upload_data' => $this->upload->data());
              $image=$data['upload_data']['file_name'];
          }
          else {
            $error = array('error' => $this->upload->display_errors());
            echo $error['error'];die;
          }
       }

      $save = $this->home_model->save_profile($image);
      if ($save) {
        echo 'success';
        exit();
      }
    }
    else{
      echo validation_errors();
      exit();
    }
    echo 'error';
  }

  public function change_settings(){ 

    $this->form_validation->set_rules('oldpassword', 'Old Password ', 'required');
    $this->form_validation->set_rules('newpassword', 'New Password ', 'required');
    $this->form_validation->set_rules('confirmpassword', 'Confirm Password ', 'required'); 
    
    if ($this->form_validation->run() == TRUE) {

      $oldpassword =  $this->input->post('oldpassword');
      $newpassword =  $this->input->post('newpassword');
      $confirmpassword =  $this->input->post('confirmpassword');

      if($newpassword != $confirmpassword){
        echo 'pass';
        exit();
      }

      $verify_password = $this->home_model->change_password_verify($oldpassword);
      if(!empty($verify_password)){

         $save = $this->home_model->change_settings_password($confirmpassword);
        if ($save) {
          echo 'success';
          exit();
        }
      }
      echo 'oldpass';
      exit();
    }
    else{
      echo validation_errors();
      exit();
    }
    echo 'error';
  }



  // =================

  public function get_invoice_details($invoice_number){
    
    $data['view'] = 'generate-invoice-detail';
    $data['invoice'] = $this->home_model->get_invoive_detail($invoice_number);
    $data['model_data'] = $this->home_model->model_agreed_data($invoice_number);
    $data['headers'] = $this->home_model->get_invoive_headers($invoice_number);
    $data['expenses'] = $this->home_model->get_invoice_expenses($invoice_number);
    $data['services'] = $this->home_model->get_invoice_service($invoice_number);
    $data['_clients'] = $this->home_model->get_clients_for_invoice_approval();
    $data['user_id'] = $this->home_model->user_id();
    $data['invoice_no'] = $invoice_number;

    // print_r( $data);

    $this->load->view('frontend/layout', $data);   
  }


 public function get_invoice_refund_details($invoice_number){
    
    $data['view'] = 'generate-invoice-refund-detail';
    // $data['invoice'] = $this->home_model->get_invoive_detail($invoice_number);
    // $data['model_data'] = $this->home_model->model_agreed_data($invoice_number);
    // $data['headers'] = $this->home_model->get_invoive_headers($invoice_number);
    // // $data['expenses'] = $this->home_model->get_invoice_expenses($invoice_number);
    // $data['services'] = $this->home_model->get_invoice_service($invoice_number);
    $data['_clients'] = $this->home_model->get_clients_for_invoice_approval();
    // $data['user_id'] = $this->home_model->user_id();
    $data['invoice_no'] = $invoice_number;


    $inv_info =  $this->home_model->get_invoive_detail($invoice_number);
      $data['invoice_info'] = $inv_info;      
      $data['model'] = $this->home_model->get_model_management_detail_id($inv_info->model_id);
      
      $data['deduction_info'] = $this->home_model->get_user_wallet($invoice_number);
     
      $data['model_data'] = $this->home_model->model_agreed_data($invoice_number);
      $data['headers'] = $this->home_model->get_invoive_headers($invoice_number);
      $data['expenses'] = $this->home_model->get_invoice_expenses($invoice_number);
      $data['services'] = $this->home_model->get_invoice_service($invoice_number);
 
    
    $data['user_id'] = $this->home_model->user_id();

    // print_r( $data);

    $this->load->view('frontend/layout', $data);   
  }

// generate-invoice-refund-detail.php

  public function get_draft_invoices(){

    $month = $this->input->get('month');
    $year = $this->input->get('year');
    $vat = $this->input->get('vat');
    $total_amount = $this->input->get('total_amount');
    $other = trim($this->input->get('other'));


    $data['view'] = 'invoice-lists';
    $data['page'] = 'Draft';
    $data['invoices'] = $this->home_model->get_draft_open_invoive(0, $month, $year, $vat, $total_amount, $other);

    $data['month'] = $month;
    $data['year'] = $year;
    $data['mvat'] = $vat;
    $data['total_amount'] = $total_amount;
    $data['other'] = trim($other);

    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }

  public function get_open_invoices(){

    $month = $this->input->get('month');
    $year = $this->input->get('year');
    $vat = $this->input->get('vat');
    $total_amount = $this->input->get('total_amount');
    $other = trim($this->input->get('other'));

    $data['view'] = 'invoice-lists';
    $data['page'] = 'Open';
    $data['invoices'] = $this->home_model->get_user_open_invoive(0, $month, $year, $vat, $total_amount, $other);
    // print_r($data);

    $data['month'] = $month;
    $data['year'] = $year;
    $data['mvat'] = $vat;
    $data['total_amount'] = $total_amount;
    $data['other'] = trim($other);

    $this->load->view('frontend/layout', $data);   
  }

  public function get_approve_invoices(){

    $month = $this->input->get('month');
    $year = $this->input->get('year');
    $vat = $this->input->get('vat');
    $total_amount = $this->input->get('total_amount');
    $other = trim($this->input->get('other'));

    $data['view'] = 'invoice-lists';
    $data['page'] = 'Approve';
    $data['invoices'] = $this->home_model->get_user_approve_invoive(0, $month, $year, $vat, $total_amount, $other);
    // print_r($data);

    $data['month'] = $month;
    $data['year'] = $year;
    $data['mvat'] = $vat;
    $data['total_amount'] = $total_amount;
    $data['other'] = trim($other);

    $this->load->view('frontend/layout', $data);   
  }

  public function get_reminder_invoices(){

    $month = $this->input->get('month');
    $year = $this->input->get('year');
    $vat = $this->input->get('vat');
    $total_amount = $this->input->get('total_amount');
    $other = trim($this->input->get('other'));

    $data['view'] = 'invoice-lists';
    $data['page'] = 'Reminder';
    $data['invoices'] = $this->home_model->get_user_reminder_invoive(0, $month, $year, $vat, $total_amount, $other);
    // print_r($data);

    $data['month'] = $month;
    $data['year'] = $year;
    $data['mvat'] = $vat;
    $data['total_amount'] = $total_amount;
    $data['other'] = trim($other);
    $this->load->view('frontend/layout', $data);   
  }

  public function get_refund_invoices(){

    $month = $this->input->get('month');
    $year = $this->input->get('year');
    $vat = $this->input->get('vat');
    $total_amount = $this->input->get('total_amount');
    $other = trim($this->input->get('other'));

    $data['view'] = 'invoice-lists';
    $data['page'] = 'Refund';
    $data['invoices'] = $this->home_model->get_user_refund_invoive(0, $month, $year, $vat, $total_amount, $other);
    // print_r($data);
    $data['month'] = $month;
    $data['year'] = $year;
    $data['mvat'] = $vat;
    $data['total_amount'] = $total_amount;
    $data['other'] = trim($other);
    $this->load->view('frontend/layout', $data);   
  }


  public function edit_generate_invoice_client(){
    
    $data['error'] = 'error';
    $data['data'] = []; 

    $clientcode = $this->input->post('clientcode');
    $client = $this->home_model->get_client_management_detail($clientcode);
     

    if(!empty($client)){    	
    	$data['error'] = 'success';
    	$data['data'] = $client;
    }
    echo json_encode($data);    
  }

  public function edit_generate_invoice_modal(){
    
    $data['error'] = 'error';
    $data['data'] = []; 

   	$modelcode = $this->input->post('modelcode');
   	$model = $this->home_model->get_model_management_detail($modelcode);
      
    if(!empty($model)){    	
    	$data['error'] = 'success';
    	$data['data'] = $model;
    }
    echo json_encode($data);    
  }

 


// ====================


  public function get_invoice_for_approval(){
    $data['view'] = 'invoice-lists-for-approval';
    $data['invoices'] = $this->home_model->get_invoice_for_approval();
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }


   public function changes_requestinvoice_lists_for_approval(){
    $data['view'] = 'changes-requestinvoice-lists-for-approval';
    $data['invoices'] = $this->home_model->changes_requestinvoice_lists_for_approval();
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }

   public function approve_user_invoice(){
 
      $save = $this->home_model->approve_user_invoice();
      if($save){
         echo 'success';
         exit();
      }
      echo 'error';      
   }


     public function get_refund_for_approval(){
    $data['view'] = 'refund-lists-for-approval';
    $data['invoices'] = $this->home_model->get_refund_for_approval();
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }

   public function approve_user_refund(){
 
      $save = $this->home_model->approve_user_refund();
      if($save){
         echo 'success';
         exit();
      }
      echo 'error';      
   }




// ============== General Invoicing ==============

  public function generate_new_general_invoice(){
    $data['view']='generate-general-invoice';
    $data['user_id']= $this->home_model->user_id();
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }



   public function save_new_general_invoice(){

      // echo "<pre>";
      // print_r($_POST);
      // exit();
    
      // $this->form_validation->set_rules('invoice_number', 'Invoice Number ', 'required|min_length[15]|max_length[15]');
      $this->form_validation->set_rules('invoice_number', 'Invoice Number ', 'required');
      $this->form_validation->set_rules('invoice_currency', 'Invoice currency ', 'required');
      $this->form_validation->set_rules('issue_id', 'Issue Data ', 'required');
      $this->form_validation->set_rules('save_clients', 'Client Data ', 'required');
      $this->form_validation->set_rules('save_model', 'Model Data Data ', 'required');
      
      $modelCounter = $this->input->post('txtmodalIncreaseValue');
      $modelHeader = $this->input->post('addtitlecount');

      $mModelRow=[];
      $mModelHeader=[];

      $headers = '';

      for($i = 1; $i <= $modelHeader; $i++){

        $delete = 'delheaderid'.$i;
        $title = 'titleheader'.$i;
        $details = 'descheader'.$i;

        $is_del = $this->input->post($delete);
        if($is_del == 1){
            continue;
        }

        $titler = $this->input->post($title);
        $detailsr = $this->input->post($details);

        if(!empty($titler) && !empty($detailsr)){

            $array['title'] = $titler;
            $array['details'] = $detailsr;

            array_push($mModelHeader, $array);
        }

      }

      if(!empty($mModelHeader)){
        $headers = json_encode($mModelHeader);
      }

      for($i = 1; $i <= $modelCounter; $i++){
        
        $delete = 'modelTextdel'.$i;
        $name = 'modelTextName'.$i;
        $text1 = 'modelText1Name'.$i;
        $text2 = 'modelText2Name'.$i;
        $price = 'modelPriceValue'.$i;
        $pricepercent = 'modelPricePercent'.$i;

        $is_del = $this->input->post($delete);
        if($is_del == 1){
            continue;
        }

        $m_name = $this->input->post($name);
        $m_text1 = $this->input->post($text1);
        $m_text2 = $this->input->post($text2);
        $m_price = $this->input->post($price);
        $m_price_percent = $this->input->post($pricepercent);

        if(empty($m_name) AND  empty($m_text1) AND empty($m_text2)){
          echo ' General Invoice addition row -'.$i.' atleast (Name/Text1/Text2) value required';
          exit();
        }
        if(empty($m_price) ){
          echo ' General Invoice addition row -'.$i.' price required';
          exit();
        }
        
        $mdlArr['headers'] = $headers;
        $mdlArr['model_row_id'] = 0;
        $mdlArr['name'] = $m_name;
        $mdlArr['title_1'] = $m_text1;
        $mdlArr['title_2'] = $m_text2;
        $mdlArr['amount'] = $m_price;
        $mdlArr['percentage'] = $m_price_percent;
        $mdlArr['status'] = 1;
        $mdlArr['creation_date'] = date('Y-m-d H:i:s');
        $mdlArr['modification_date'] = date('Y-m-d H:i:s');

        array_push($mModelRow, $mdlArr);
      }

      if ($this->form_validation->run() == TRUE) {  
 
        $modelRow = $this->home_model->save_general_invoice($mModelRow);
        
        $save = 1;
        if ($save) {
          echo 'success';
          exit();
        }
    }
    else{
      echo validation_errors();
      exit();
    }
    echo 'error';
  }


  public function client_list_invoice(){

    $client_id = $this->input->get('save_clients');
    $date_from = $this->input->get('date_from');
    $date_to = $this->input->get('date_to');

    $data['view']='client-list-invoice';
    $data['client_id']= $client_id;
    $data['date_from']= $date_from;
    $data['date_to']= $date_to;
   
    $data['user_id']= $this->home_model->user_id();
    $data['invoices'] = $this->home_model->client_list_invoice_data($client_id, $date_from, $date_to);
    $data['_client'] = $this->home_model->client_details_pdf($client_id);
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }


  public function client_list_invoice_without_vat(){

    $client_id = $this->input->get('save_clients');
    $date_from = $this->input->get('date_from');
    $date_to = $this->input->get('date_to');

    $data['view']='client-list-invoice-without-vat';
    $data['client_id']= $client_id;
    $data['date_from']= $date_from;
    $data['date_to']= $date_to;
   
    $data['user_id']= $this->home_model->user_id();
    $data['invoices'] = $this->home_model->client_list_invoice_data($client_id, $date_from, $date_to);
    $data['_client'] = $this->home_model->client_details_pdf($client_id);
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }


    public function general_invoices(){
    $data['view']='general-invoice';
    $data['user_id']= $this->home_model->user_id();
    $data['invoices'] = $this->home_model->general_invoices();
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }
  



   public function generate_invoice_details($invoice_id){
    $data['view']='general-invoice-details';
    $data['user_id']= $this->home_model->user_id();
    $data['invoive_id']= $invoice_id;
    $data['invoice'] = $this->home_model->generate_invoice_details($invoice_id);
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }
  
  
  
  public function collective_invoice(){

    // $selected_invoices = $this->input->post('selected_invoices');
    $serchText = $this->input->get('serchText');
    $date_from = $this->input->get('date_from');
    $date_to = $this->input->get('date_to');

    $SISinv = '';
    // print_r($_POST);
    $data['view']='collective-invoice';
    if(!empty($selected_invoices)){
            $SISinv = "'".implode("','", $selected_invoices)."'";
    }
    
    $data['SISinv'] = $SISinv;
    // $data['selected_invoices'] = $selected_invoices;

    $data['serchText']= $serchText;
    $data['date_from']= $date_from;
    $data['date_to']= $date_to;
   
    $data['user_id']= $this->home_model->user_id();
    // $data['invoices'] = $this->home_model->collective_list_invoice_data($SISinv, $date_from, $date_to);
    $data['invoices'] = $this->home_model->collective_list_invoice_data($serchText, $date_from, $date_to);
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
    
  }
  




public function save_deduction_transaction(){ 

    $this->form_validation->set_rules('deduction_model_id', 'Model id ', 'required');
    $this->form_validation->set_rules('d_expenses_name', 'Expense Name ', 'required');
    $this->form_validation->set_rules('d_expenses_quantity', 'Quantity ', 'required'); 
    $this->form_validation->set_rules('d_expenses_amount', 'Expense Amount ', 'required'); 
    // $this->form_validation->set_rules('d_expenses_msg', 'Description ', 'required');
    $this->form_validation->set_rules('d_expenses_date', 'Deduction Date ', 'required');
 
     
    if ($this->form_validation->run() == TRUE) { 

      $filename = time() . date('Ymd');
      $deduction_attachment = '';
       $original_file_name = '';

      if(isset($_FILES['d_expenses_attachment'])&&$_FILES['d_expenses_attachment']['error']=='0'){
          
          $original_file_name = $_FILES['d_expenses_attachment']['name'];
          $config = array(
            'upload_path' => "assets/upload/images/",
            'allowed_types' => "*",
            'overwrite' => false,
            'max_size' => "2048000", 
            'file_name' => $filename
          );

          $this->load->library('upload', $config);
          if($this->upload->do_upload('d_expenses_attachment')) {  
              $data = array('upload_data' => $this->upload->data());
              $deduction_attachment=$data['upload_data']['file_name'];
          }
          else {
            $error = array('error' => $this->upload->display_errors());
            echo $error['error'];die;
          }
       }

      $save = $this->home_model->save_deduction_transaction_data($deduction_attachment, $original_file_name);
      if ($save) {
        echo 'success';
        exit();
      }
    }
    else{
      echo validation_errors();
      exit();
    }
    echo 'error';
  }



  public function hold_tickets(){
    $data['view']='hold-tickets';
    $data['user_id']= $this->home_model->user_id();
    // $data['invoive_id']= $invoice_id;
    // $data['invoice'] = $this->home_model->generate_invoice_details($invoice_id);
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }



  public function select_expenses_invoice(){
    $data['view'] = 'invoice-lists';
    $data['page'] = 'Select Expenses';
    $data['invoices'] = $this->home_model->get_seLect_expenses(0);
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }

   public function payed_models_overview(){
    $data['view'] = 'invoice-lists';
    $data['page'] = 'Payed To Models Overview';
    $data['invoices'] = $this->home_model->get_payed_model_overview(0, '', '', '', '', '');
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }

   public function payed_refund(){
    $data['view'] = 'invoice-lists';
    $data['page'] = 'Payed Refund';
    $data['invoices'] = $this->home_model->get_payed_refund(0);
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }


 public function approve_invoices_ready_for_email_send(){
    $data['view'] = 'invoice-lists';
    $data['page'] = 'Approve Invoices Ready for Email Send';
    $data['invoices'] = $this->home_model->get_user_approve_invoive(0, '', '', '', '', '');
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }

 public function payed_invoices_ready_for_refund(){
    $data['view'] = 'invoice-lists';
    $data['page'] = 'Payed Invoices Ready For Refund';
    $data['invoices'] = $this->home_model->get_user_refund_invoive(0, '', '', '', '', '');
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }



  public function upload_client_csv_data(){

    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    $k = 0;
      if(!empty($_FILES['clientcsv']['name']) && in_array($_FILES['clientcsv']['type'], $csvMimes)){
        
        if(is_uploaded_file($_FILES['clientcsv']['tmp_name'])){
            $csvFile = fopen($_FILES['clientcsv']['tmp_name'], 'r');
            $mydata = fgetcsv($csvFile);

             while(($line = fgetcsv($csvFile)) !== FALSE){

              $mt = explode(' ', microtime());
              $uc = substr(microtime(), 2, 6);

                $inj = 0;
                if(!empty($line[8])){
                  if(trim(strtolower($line[8])) == 'germany'){
                    $inj = 1;
                  }
                }

               $array = array(                 
                  'user_id' => 1, 
                  'unique_code' => 'SELINC'.$uc, 
                  'company_name' => $line[0], 
                  'client_fee' => $line[1], 
                  'name' => $line[2], 
                  'surname' => $line[3],
                  'address_line1' => $line[4],
                  'address_line2' => $line[5],
                  'pincode' => $line[6],
                  'city'  => $line[7],
                  'country' => $line[8],
                  'vat_tin_number' => $line[9],
                  'email' => $line[10],
                  'telephone' => $line[11],
                  'mobile_no' => $line[12],
                  'internal_notes' => $line[13],
                  'ingermany' => $inj,
                  'kvat' => 0,
                  'kvat_percent' => 0,
                  'shipping_company_name' => $line[15],
                  'shipping_name' => $line[16],
                  'shipping_surname' => $line[17],
                  'shipping_address_line1' => $line[18],
                  'shipping_address_line2' => $line[19],
                  'shipping_pincode' => $line[20],
                  'shipping_city' => $line[21],
                  'status' => 1,
                  'creation_date' => date('Y-m-d H:i:s'),
                  'modification_date' => date('Y-m-d H:i:s'),
               );

              $this->db->insert('client_management',$array);
              $k = 1;
            
            }
        }
      }

      if($k == 1){
        redirect(base_url('all-client-management'));
      }
      echo "error";
  }


  public function upload_model_csv_data(){

    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

    // user_id, xl_model_id, unique_code, model_name, service_fee, name, surname, address_line1, address_line2, city, pincode, vat_tin_number, country, email, telephone, mobile_no, kvat, kvat_percent, creation_date, modification_date
    $k = 0;
      if(!empty($_FILES['clientcsv']['name']) && in_array($_FILES['clientcsv']['type'], $csvMimes)){
        
        if(is_uploaded_file($_FILES['clientcsv']['tmp_name'])){
            $csvFile = fopen($_FILES['clientcsv']['tmp_name'], 'r');
            $mydata = fgetcsv($csvFile);

             while(($line = fgetcsv($csvFile)) !== FALSE){

              $mt = explode(' ', microtime());
              $uc = substr(microtime(), 2, 6);// ((int)$mt[1]) * 1000 + ((int)round($mt[0] * 1000));

                $kvt = 0;
                if((int)$line[13] > 0){
                  $kvt = 1;
                }
               $array = array(                 
                  'user_id' => 1, 
                  'unique_code' => 'SELINC'.$uc, 
                  'model_name' => $line[0], 
                  'service_fee' => $line[1], 
                  'name' => $line[2], 
                  'surname' => $line[3],
                  'address_line1' => $line[4],
                  'address_line2' => $line[5],
                  'pincode' => $line[6],
                  'city'  => $line[7],
                  'country' => $line[8],
                  'vat_tin_number' => $line[9],
                  'email' => $line[10],
                  'telephone' => $line[11],
                  'mobile_no' => $line[12],
                  'kvat' => $kvt,
                  'kvat_percent' => $line[13],
                  'status' => 1,
                  'creation_date' => date('Y-m-d H:i:s'),
                  'modification_date' => date('Y-m-d H:i:s'),
               );

               // print_r($array);
               $this->db->insert('model_management',$array);
                $k = 1;
            
            }
        }
      }

      if($k == 1){
        redirect(base_url('all-model-management'));
      }

      echo "error";
  }



  // ================


  public function collected_invoice_last_month_with_vat(){

    $data['view']='mwm-agency-management-list';
    $data['page_title'] = 'Collected Invoice Last Month With VAT';
    $data['invoices'] = $this->home_model->get_collected_last_month_vat(0);
    $this->load->view('frontend/layout', $data);   
  }

  public function collected_net(){

    $data['view']='mwm-agency-management-list';
    $data['page_title'] = 'Collected Net';
    $data['invoices'] = $this->home_model->get_collected_net(0);
    $this->load->view('frontend/layout', $data);   
  }

  public function collected_vat(){

    $data['view']='mwm-agency-management-list';
    $data['page_title'] = 'Collected Vat';
    $data['invoices'] = $this->home_model->get_collected_vat(0);
    $this->load->view('frontend/layout', $data);   
  }

  public function collected_invoice_last_no_vat(){

    $data['view']='mwm-agency-management-list';
    $data['page_title'] = 'Collected Invoice Last No Vat';
    $data['invoices'] = $this->home_model->get_collected_invoice_last_no_vat(0);
    $this->load->view('frontend/layout', $data);   
  }


  public function advances_on_behalf_of_mwm(){

    $data['view']='mwm-agency-management-list';
    $data['page_title'] = 'Advances On Behalf Of MWM';
    $data['invoices'] = $this->home_model->get_advances_on_behalf_of_mwm(0);
    $this->load->view('frontend/layout', $data);   
  }

  public function reports_select_income_list(){
    $data['page'] = 'Select Income';
    $data['view']='reports-select-income-list';
    $data['invoices'] = $this->home_model->get_select_income(0);
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }

  public function reports_select_income($invoice){
    $data['view']='reports-overview-select';
    $data['invoices'] = $this->home_model->reports_select_income($invoice);
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }

  public function reports_expenses_overview_list(){
    $data['page'] = 'Expenses Overview';
    $data['view']='reports-select-income-list';
    $data['invoices'] = $this->home_model->get_expenses(0);
    $this->load->view('frontend/layout', $data);   
  }

  public function reports_expenses_overview($invoice){
    $data['view']='reports-overview-expenses';
    $data['invoices'] = $this->home_model->reports_expenses_overview($invoice);
    // print_r($data);
    $this->load->view('frontend/layout', $data);   
  }


  public function get_modified_date(){

    $date = $this->input->post('date');
    $days = $this->input->post('days');

    $date = date_create($date);
    date_add($date,date_interval_create_from_date_string(" $days days"));
    echo date_format($date,"Y-m-d");    
  }


   public function user_management(){

    $searchtext = trim($this->input->get('searchtext'));
    $role = trim($this->input->get('role'));

    $data['view']='users-management';
    $data['users'] = $this->home_model->user_management($role, $searchtext);

    $data['searchtext'] = trim($searchtext);
    $data['role'] = trim($role);
    $this->load->view('frontend/layout', $data);   
  }



  public function save_user_profile(){

    $this->form_validation->set_rules('empcode', 'User data', 'required');
    $this->form_validation->set_rules('name', 'Username', 'required');
    $this->form_validation->set_rules('assignee_role', 'Redmine User Role', 'required');
    $this->form_validation->set_rules('runame', 'Redmine Username', 'required');
    $this->form_validation->set_rules('rupassword', 'Redmine Password', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required');
    // $this->form_validation->set_rules('password', 'Password', 'required');
    
    if ($this->form_validation->run() == TRUE) {

      $email = $this->input->post('email');
      $empcode = $this->input->post('empcode');

      $email_validate = $this->home_model->validate_email($email, $empcode);
      if(!empty($email_validate)){
         echo 'email';
         exit();
      }

      $validate = $this->home_model->save_user_profile();   

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


 
  public function save_created_refund(){

    // print_r($_POST);
    // exit();

    $this->form_validation->set_rules('txtcreditnotes', 'Credit Note', 'required');
    $this->form_validation->set_rules('deductiontext', 'Deduction Text', 'required');
    $this->form_validation->set_rules('modeldeduction', 'Modal data', 'required');
    $this->form_validation->set_rules('invoice_number', 'Invoice Data', 'required');
    $this->form_validation->set_rules('modelDeductionValue', 'Deduction amount', 'required');
    // $this->form_validation->set_rules('honorariumtext', 'Honorarium Text', 'required');
    
    
    if ($this->form_validation->run() == TRUE) {

      $invoice_number = $this->input->post('invoice_number');
      $save = $this->home_model->save_create_refund($invoice_number);
      if(!empty($save)){
         echo 'success';
         exit();
      }    
    }
    else{
      echo validation_errors();
      exit();
    }
    echo "error" ;
  }




   public function get_client_list(){ 
    
    $user_id = $this->home_model->user_id();

    $data['error'] = 'error';
    $data['data'] = [];    
    $clients = get_clients($user_id);

    if(!empty($clients)){
      $data['error'] = 'success';
      $data['data'] = $clients;    
    }
  
    echo json_encode($data);
  }






}