<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class Home_model extends CI_Model {
 
    function __construct() {
        parent::__construct();
    }

    public function user_id()  {
        $id = 0;
        $user_session = $this->session->userdata('user');
        if(!empty($user_session)){
            $id = $user_session->id;
        }
        return $id;
    }

    public function get_client_management($searchtext)  {
        
        $user_id = $this->user_id();

        $this->db->select('*');
        $this->db->from('client_management');        
        if(!empty($searchtext)) {
           $this->db->or_like(
                array(
                    'company_name' => $searchtext, 
                    'name' => $searchtext, 
                    'surname' => $searchtext, 
                    'address_line1' => $searchtext, 
                    'address_line2' => $searchtext, 
                    'pincode' => $searchtext, 
                    'vat_tin_number' => $searchtext, 
                    'country' => $searchtext, 
                    'city' => $searchtext, 
                )
            );
        }
        
        $this->db->limit(25, 0);
        $this->db->where('user_id', $user_id);
        $this->db->order_by("id", "desc");
        return $this->db->get()->result();

    }
     

    public function get_client_management_list($searchtext, $page = 0) {

        $user_id = $this->user_id();
        $this->db->select('*');
        $this->db->from('client_management');        
        if(!empty($searchtext)) {
           $this->db->or_like(
                array(
                    'company_name' => $searchtext, 
                    'name' => $searchtext, 
                    'surname' => $searchtext, 
                    'address_line1' => $searchtext, 
                    'address_line2' => $searchtext, 
                    'pincode' => $searchtext, 
                    'vat_tin_number' => $searchtext, 
                    'country' => $searchtext, 
                    'city' => $searchtext, 
                )
            );
        }
        if($page > 0){
            $page = $page * 10;
        }
        $this->db->limit(100, $page);
        $this->db->where('user_id', $user_id);
        $this->db->order_by("id", "desc");
        return $this->db->get()->result();
    }
    public function get_client_management_detail($profilecode)  {
        
        $user_id = $this->user_id();

        $sql = "SELECT * FROM client_management WHERE unique_code = '$profilecode' ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $result = $query->row();
    }



    public function save_client_management()  {
        $user_id = $this->user_id();
        $kvat = 0;
        $selKvat = (int)$this->input->post('kvatornot');
        if($selKvat == 1){
            $kvat = $this->input->post('kvat_percent');
        }
        $array = array(
            'user_id' => $user_id, 
            'unique_code' => 'SELINCC'.substr(time(), -5), 
            'company_name' => $this->input->post('companyname'), 
            'client_fee' => $this->input->post('client_fee'), 
            'name' => $this->input->post('name'), 
            'surname' => $this->input->post('surname'),
            'address_line1' => $this->input->post('addressline1'), 
            'address_line2' => $this->input->post('addressline2'), 
            'pincode' => $this->input->post('postcode'), 
            'city' => $this->input->post('city'), 
            'vat_tin_number' => $this->input->post('vat_tin_no'), 
            'country' => $this->input->post('country'), 
            'email' => $this->input->post('email'), 
            'telephone' => $this->input->post('telephone'), 
            'mobile_no' => $this->input->post('phone'), 
            'ingermany' => $this->input->post('ingermany'), 
            'kvat' => $selKvat,
            'kvat_percent' => $kvat,
            'internal_notes' => $this->input->post('internal_notes'), 
            'shipping_company_name' => $this->input->post('shipping_companyname'), 
            'shipping_name' => $this->input->post('shipping_name'), 
            'shipping_surname' => $this->input->post('shipping_surname'), 
            'shipping_address_line1' => $this->input->post('shipping_addressline1'), 
            'shipping_address_line2' => $this->input->post('shipping_addressline2'), 
            'shipping_pincode' => $this->input->post('shipping_postcode'), 
            'shipping_city' => $this->input->post('shipping_city'), 
            'status' => 1, 
            'creation_date' => date('Y-m-d H:i:s'), 
            'modification_date' => date('Y-m-d H:i:s'),
        );

        return $this->db->insert('client_management',$array);
    }

    public function save_edit_client_management()  {

        $user_id = $this->user_id();
        $uniquecode = $this->input->post('uniquecode');

        $kvat = 0;
        $selKvat = (int)$this->input->post('kvatornot');
        if($selKvat == 1){
            $kvat = $this->input->post('kvat_percent');
        }

        $array = array(
            
            'company_name' => $this->input->post('companyname'), 
            'client_fee' => $this->input->post('client_fee'), 
            'name' => $this->input->post('name'), 
            'surname' => $this->input->post('surname'),
            'address_line1' => $this->input->post('addressline1'), 
            'address_line2' => $this->input->post('addressline2'), 
            'pincode' => $this->input->post('postcode'), 
            'city' => $this->input->post('city'), 
            'vat_tin_number' => $this->input->post('vat_tin_no'), 
            'country' => $this->input->post('country'), 
            'email' => $this->input->post('email'), 
            'telephone' => $this->input->post('telephone'), 
            'mobile_no' => $this->input->post('phone'),
            'ingermany' => $this->input->post('ingermany'),
            'kvat' => $selKvat,
            'kvat_percent' => $kvat,
            'internal_notes' => $this->input->post('internal_notes'), 
            'shipping_company_name' => $this->input->post('shipping_companyname'), 
            'shipping_name' => $this->input->post('shipping_name'), 
            'shipping_surname' => $this->input->post('shipping_surname'), 
            'shipping_address_line1' => $this->input->post('shipping_addressline1'), 
            'shipping_address_line2' => $this->input->post('shipping_addressline2'), 
            'shipping_pincode' => $this->input->post('shipping_postcode'), 
            'shipping_city' => $this->input->post('shipping_city'), 
            'modification_date' => date('Y-m-d H:i:s'),
        );

        $this->db->where('unique_code', $uniquecode);
        return $this->db->update('client_management',$array);
    }



   



    // =========== Model Management =============
        // user_id, unique_code, model_name, service_fee, name, surname, address_line1, address_line2, city, pincode, vat_tin_number, country, email, telephone, mobile_no, kvat, kvat_percent, status, creation_date, modification_date 
    public function save_model_management()  {
        $user_id = $this->user_id();
        $kvat = 0;
        $selKvat = (int)$this->input->post('kvatornot');
        if($selKvat == 1){
            $kvat = $this->input->post('kvat_percent');
        }
        $array = array(
            'user_id' => $user_id, 
            'unique_code' => 'SELINCM'.substr(time(), -5), 
            'model_name' => $this->input->post('model_name'), 
            'service_fee' => $this->input->post('service_fee'), 
            'name' => $this->input->post('name'), 
            'surname' => $this->input->post('surname'),
            'address_line1' => $this->input->post('addressline1'), 
            'address_line2' => $this->input->post('addressline2'), 
            'pincode' => $this->input->post('postcode'), 
            'city' => $this->input->post('city'), 
            'vat_tin_number' => $this->input->post('vat_tin_no'), 
            'country' => $this->input->post('country'), 
            

            'email' => $this->input->post('email'), 
            'telephone' => $this->input->post('telephone'), 
            'mobile_no' => $this->input->post('phone'),
            'kvat' => $selKvat,
            'kvat_percent' => $kvat,
            'status' => 1, 
            'creation_date' => date('Y-m-d H:i:s'), 
            'modification_date' => date('Y-m-d H:i:s'),
        );

        return $this->db->insert('model_management',$array);
    }


     public function save_edit_model_management()  {
        $user_id = $this->user_id();
        $uniquecode = $this->input->post('modelcode');

        $kvat = 0;
        $selKvat = (int)$this->input->post('kvatornot');
        if($selKvat == 1){
            $kvat = $this->input->post('kvat_percent');
        }

        $array = array(             
            'model_name' => $this->input->post('model_name'), 
            'service_fee' => $this->input->post('service_fee'), 
            'name' => $this->input->post('name'), 
            'surname' => $this->input->post('surname'),
            'address_line1' => $this->input->post('addressline1'), 
            'address_line2' => $this->input->post('addressline2'), 
            'pincode' => $this->input->post('postcode'), 
            'city' => $this->input->post('city'), 
            'vat_tin_number' => $this->input->post('vat_tin_no'), 
            'country' => $this->input->post('country'), 
            
            'email' => $this->input->post('email'), 
            'telephone' => $this->input->post('telephone'), 
            'mobile_no' => $this->input->post('phone'),
            'kvat' => $selKvat,
            'kvat_percent' => $kvat,
            'modification_date' => date('Y-m-d H:i:s'),
        );
        $this->db->where('unique_code', $uniquecode);
        return $this->db->update('model_management',$array);
    }



    public function get_model_management($searchtext)  {
        
        $user_id = $this->user_id();

        $this->db->select('*');
        $this->db->from('model_management');        
        if(!empty($searchtext)) {
           $this->db->or_like(
                array(
                    'model_name' => $searchtext, 
                    'name' => $searchtext, 
                    'surname' => $searchtext, 
                    'address_line1' => $searchtext, 
                    'address_line2' => $searchtext, 
                    'pincode' => $searchtext, 
                    'vat_tin_number' => $searchtext, 
                    'country' => $searchtext, 
                    'city' => $searchtext, 
                )
            );
        }
        
        $this->db->limit(25, 0);
        $this->db->where('user_id', $user_id);
        $this->db->order_by("id", "desc");
        return $this->db->get()->result();

    }

    public function get_model_management_list($searchtext, $page = 0)  {
        
        $user_id = $this->user_id();

        // $sql = "SELECT * FROM model_management WHERE user_id = $user_id ORDER BY id DESC";
        // $query = $this->db->query($sql);
        // return $result = $query->result();

         $user_id = $this->user_id();
        $this->db->select('*');
        $this->db->from('model_management');        
        if(!empty($searchtext)) {
           $this->db->or_like(
                array(
                    'model_name' => $searchtext, 
                    'name' => $searchtext, 
                    'surname' => $searchtext, 
                    'address_line1' => $searchtext, 
                    'address_line2' => $searchtext, 
                    'pincode' => $searchtext, 
                    'vat_tin_number' => $searchtext, 
                    'country' => $searchtext, 
                    'city' => $searchtext, 
                )
            );
        }
        if($page > 0){
            $page = $page * 10;
        }
        $this->db->limit(100, $page);
        $this->db->where('user_id', $user_id);
        $this->db->order_by("id", "desc");
        return $this->db->get()->result();

    }

    public function get_model_management_detail($uniquecode)  {
        
        $user_id = $this->user_id();

        $sql = "SELECT * FROM model_management WHERE unique_code = '$uniquecode' ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $result = $query->row();
    }

     public function get_model_management_detail_id($id)  {
        
        $user_id = $this->user_id();

        $sql = "SELECT * FROM model_management WHERE id = $id";
        $query = $this->db->query($sql);
        return $result = $query->row();
    }


    // ========== Model Management End ============

    public function get_profile()  {
        
        $user_id = $this->user_id();

        $sql = "SELECT * FROM user WHERE id = '$user_id' AND deleted = 0";
        $query = $this->db->query($sql);
        return $result = $query->row();
    }

    public function save_profile($image)  {

        $user_id = $this->user_id();
        $name = trim($this->input->post('name'));
        $tusername = $name;
        $tusername = str_replace(" ", "-", strtolower($tusername));
        $tusername = str_replace("@", "", strtolower($tusername));
        $tusername = str_replace("}", "", strtolower($tusername));
        $tusername = str_replace("{", "", strtolower($tusername));
        $tusername = str_replace("/", "", strtolower($tusername));

        $unique = 0;
        $inc = 0;
        $username = $tusername;
        while($unique == 0){
            $this->db->select('*')->from('user');
            $this->db->where('username', $tusername);
            $retdata = $this->db->get()->row();

            if(empty($retdata)){
                $username = $tusername;
                $unique = 1;
                break;
            }
            else{
                $tusername = $username.++$inc;
            }
        }

        $array = array(            
            'name' => $name, 
            'username' => $username, 
            'phone' => $this->input->post('phone'), 
            'address' => $this->input->post('address'), 
            'city' => $this->input->post('city'),
            'state' => $this->input->post('state'), 
            'country' => $this->input->post('country'), 
            'zipcode' => $this->input->post('pincode'), 
            'modification_date' => date('Y-m-d H:i:s'),
        );

        if(!empty($image)){
            $array['image'] = $image;
        }

        $this->db->where('id', $user_id);
        return $this->db->update('user',$array);
    }

    public function save_new_invoice()  {

        $user_id = $this->user_id();
        $uniquecode = $this->input->post('uniquecode');
        $array = array(
            
            'currency' => $this->input->post('sel_currency'),
            'client_id' => $this->input->post('save_clients'), 
            'model_id' => $this->input->post('save_model'),  
            'company_name' => $this->input->post('companyname'), 
            'client_fee' => $this->input->post('client_fee'), 
            'name' => $this->input->post('name'), 
            'surname' => $this->input->post('surname'),
            'address_line1' => $this->input->post('addressline1'), 
            'address_line2' => $this->input->post('addressline2'), 
            'pincode' => $this->input->post('postcode'), 
            'city' => $this->input->post('city'), 
            'vat_tin_number' => $this->input->post('vat_tin_no'), 
            'country' => $this->input->post('country'), 
            'email' => $this->input->post('email'), 
            'telephone' => $this->input->post('telephone'), 
            'mobile_no' => $this->input->post('phone'), 
            'internal_notes' => $this->input->post('internal_notes'), 
            'shipping_company_name' => $this->input->post('shipping_companyname'), 
            'shipping_name' => $this->input->post('shipping_name'), 
            'shipping_surname' => $this->input->post('shipping_surname'), 
            'shipping_address_line1' => $this->input->post('shipping_addressline1'), 
            'shipping_address_line2' => $this->input->post('shipping_addressline2'), 
            'shipping_pincode' => $this->input->post('shipping_postcode'), 
            'shipping_city' => $this->input->post('shipping_city'), 
            'modification_date' => date('Y-m-d H:i:s'),
        );

        $this->db->where('unique_code', $uniquecode);
        return $this->db->update('client_management',$array);
    }



     public function save_model_row($rowList){
        // return $this->db->insert_batch('invoice_expense',$mExpList);  
        $insert = 0;
        foreach ($rowList as $model) {

            $model_id = $model['model_row_id'];

            $myarr['name'] = $model['name'];
            $myarr['title_1'] = $model['title_1'];
            $myarr['title_2'] = $model['title_2'];           
            $myarr['amount'] = $model['amount'];           
            $myarr['modification_date'] = $model['modification_date'];

            if($model_id > 0){
                
                $this->db->where('id', $model_id);
                $this->db->update('model_agreed_fields', $myarr);
                $insert = 1;
                continue;
            }

            $myarr['invoice_number'] = $model['invoice_number'];
            $myarr['creation_date'] = $model['creation_date'];

            $this->db->insert('model_agreed_fields',$myarr);
            $insert = 1;
        }  
        return $insert;
    }  





    public function save_expenses($mExpList){
        // return $this->db->insert_batch('invoice_expense',$mExpList);  
        $insert = 0;
        foreach ($mExpList as $expences) {

            $exp_id = $expences['model_expense_id'];

            $myarr['model_expense'] = $expences['model_expense'];
            $myarr['model_exp_amount'] = $expences['model_exp_amount'];
            $myarr['vat_include'] = $expences['vat_include'];           
            $myarr['vat_percent'] = $expences['vat_percent'];           
            $myarr['modification_date'] = $expences['modification_date'];

            if($exp_id > 0){
                
                $this->db->where('id', $exp_id);
                $this->db->update('invoice_expense', $myarr);
                $insert = 1;
                continue;
            }

            $myarr['invoice_number'] = $expences['invoice_number'];
            $myarr['creation_date'] = $expences['creation_date'];

            $this->db->insert('invoice_expense',$myarr);
            $insert = 1;
        }  
        return $insert;
    }  
    
    public function save_service($mSerList){
        // return $this->db->insert_batch('invoice_service',$mSerList);    
        $insert = 0;
        foreach ($mSerList as $services) {

            $ser_id = $services['model_service_id'];

            $myarr['model_service'] = $services['model_service'];
            $myarr['model_ser_amount'] = $services['model_ser_amount'];
            $myarr['vat_include'] = $services['vat_include'];
            $myarr['vat_percent'] = $services['vat_percent'];  
            $myarr['modification_date'] = $services['modification_date'];

            if($ser_id > 0){  
                $this->db->where('id', $ser_id);
                $this->db->update('invoice_service', $myarr);
                $insert = 1;
                continue;
            }
            
            $myarr['invoice_number'] = $services['invoice_number'];
            $myarr['creation_date'] = $services['creation_date'];

            $this->db->insert('invoice_service',$myarr);
            $insert = 1;
        }  
        return $insert;
    }   


    public function save_reverse_invoice_data($invoice_no, $reverseData){
        // return $this->db->insert_batch('invoice_service',$mSerList);    

        $array['mwm_reverse_data'] = json_encode($reverseData);
        if(!empty($reverseData)){
            $this->db->where('invoice_number', $invoice_no);
            return $this->db->update('invoice', $array);
        }
    }   


    public function save_user_new_invoice(){

        $user_id = $this->user_id();
        // $uniquecode = $this->input->post('uniquecode');

        $array = array(
            'user_id' => $user_id,
            'currency' => $this->input->post('sel_currency'), 
            'modelnametext1' => $this->input->post('modelnametext1'), 
            'modelnametext2' => $this->input->post('modelnametext2'), 
            'client_id' => $this->input->post('save_clients'), 
            'model_id' => $this->input->post('save_model'), 
            'invoice_number' =>$this->input->post('invoice_number'), 
            'issue_id' => $this->input->post('issue_id'), 
            'i_company_name' => $this->input->post('i_company_name'),
            'i_name' => $this->input->post('i_name'), 
            'i_fee' => $this->input->post('i_fee'), 
            'i_surname' => $this->input->post('i_surname'), 
            'i_address_line1' => $this->input->post('i_address_line1'), 
            'i_address_line2' => $this->input->post('i_address_line2'), 
            'i_city' => $this->input->post('i_city'), 
            'i_country' => $this->input->post('i_country'), 
            'i_pincode' => $this->input->post('i_pincode'), 
            'i_vat_tin_number' => $this->input->post('i_vat_tin_number'), 
            'i_email' => $this->input->post('i_email'), 
            'i_mobile_no' => $this->input->post('i_mobile_no'), 
            'i_internal_notes' => $this->input->post('i_internal_notes'), 
            'i_telephone' => $this->input->post('i_telephone'), 
            'shipping_company_name' => $this->input->post('shipping_company_name'), 
            'shipping_name' => $this->input->post('shipping_name'), 
            'shipping_surname' => $this->input->post('shipping_surname'), 
            'shipping_address_line1' => $this->input->post('shipping_address_line1'), 
            'shipping_address_line2' => $this->input->post('shipping_address_line2'), 
            'shipping_pincode' => $this->input->post('shipping_pincode'), 
            'shipping_city' => $this->input->post('shipping_city'), 
            'payment_terms' => $this->input->post('payment_terms'), 
            'job_date' => date('Y-m-d', strtotime($this->input->post('job_date'))), 
            'job_date_till' => date('Y-m-d', strtotime($this->input->post('job_date_till'))), 
            'invoice_date' => date('Y-m-d', strtotime($this->input->post('invoice_date'))), 
            'uses' => $this->input->post('uses'), 
            'invoive_due_date' => date('Y-m-d', strtotime($this->input->post('invoive_due_date'))), 
            'reminder' => $this->input->post('reminder'), 
            'interval_in_days' => $this->input->post('interval_in_days'), 
            'm_model_name' => $this->input->post('m_model_name'), 
            'm_name' => $this->input->post('m_name'), 
            'm_surname' => $this->input->post('m_surname'), 
            'm_address_line1' => $this->input->post('m_address_line1'), 
            'm_address_line2' => $this->input->post('m_address_line2'), 
            'm_pincode' => $this->input->post('m_pincode'), 
            'm_city' => $this->input->post('m_city'), 
            'm_country' => $this->input->post('m_country'), 
            'm_ingermany' => $this->input->post('m_ingermany'), 
            'm_vat_tin_number' => $this->input->post('m_vat_tin_number'), 
            'm_email' => $this->input->post('m_email'), 
            'm_internal_notes' => $this->input->post('m_internal_notes'), 
            'm_service_fee' => $this->input->post('m_service_fee'), 
            'm_vat' => $this->input->post('m_vat_yes_checked'), 
            'm_vat_percent' => $this->input->post('m_vat_percent'), 
            'model_agency_comission' => $this->input->post('modelAgencyComission'),
            'model_budget' => $this->input->post('model_budget'),
            'vat_price' => $this->input->post('modelInclComission'),
            'model_total_agreed' => $this->input->post('model_total_agreed'),
            'additional_modal_price' => $this->input->post('additional_modal_price'),
            'additional_modal_text' => $this->input->post('additional_modal_text'),
            'apply_model_fee' => $this->input->post('apply_model_fee'),
            'internal_notes' => $this->input->post('internal_notes'),
            'modelothertext' => $this->input->post('modelothertext'),
            'acommissionothertext' => $this->input->post('acommissionothertext'),
            'reverse_invoice' => (int)$this->input->post('reverse_invoice'),  
            'creation_date' => date('Y-m-d H:i:s'),
            'modification_date' => date('Y-m-d H:i:s'),
        );

        return $this->db->insert('invoice',$array);

    }





     public function save_edit_invoice(){

        $user_id = $this->user_id();
        $invoice_number = $this->input->post('invoice_number');
        
        $array = array(            
            'currency' => $this->input->post('sel_currency'), 
            'modelnametext1' => $this->input->post('modelnametext1'), 
            'modelnametext2' => $this->input->post('modelnametext2'), 
            // 'client_id' => $this->input->post('client_ids'), 
            // 'model_id' => $this->input->post('model_ids'),
            'client_id' => $this->input->post('save_clients'), 
            'model_id' => $this->input->post('save_model'),    

            'i_company_name' => $this->input->post('i_company_name'),
            'i_name' => $this->input->post('i_name'), 
            'i_fee' => $this->input->post('i_fee'), 
            'i_surname' => $this->input->post('i_surname'), 
            'i_address_line1' => $this->input->post('i_address_line1'), 
            'i_address_line2' => $this->input->post('i_address_line2'), 
            'i_city' => $this->input->post('i_city'), 
            'i_country' => $this->input->post('i_country'), 
            'i_pincode' => $this->input->post('i_pincode'), 
            'i_vat_tin_number' => $this->input->post('i_vat_tin_number'), 
            'i_email' => $this->input->post('i_email'), 
            'i_mobile_no' => $this->input->post('i_mobile_no'), 
            'i_internal_notes' => $this->input->post('i_internal_notes'), 
            'i_telephone' => $this->input->post('i_telephone'), 

            'shipping_company_name' => $this->input->post('shipping_company_name'), 
            'shipping_name' => $this->input->post('shipping_name'), 
            'shipping_surname' => $this->input->post('shipping_surname'), 
            'shipping_address_line1' => $this->input->post('shipping_address_line1'), 
            'shipping_address_line2' => $this->input->post('shipping_address_line2'), 
            'shipping_pincode' => $this->input->post('shipping_pincode'), 
            'shipping_city' => $this->input->post('shipping_city'),

            'payment_terms' => $this->input->post('payment_terms'), 
            'job_date' => date('Y-m-d', strtotime($this->input->post('job_date'))), 
            'job_date_till' => date('Y-m-d', strtotime($this->input->post('job_date_till'))),
            'invoice_date' => date('Y-m-d', strtotime($this->input->post('invoice_date'))), 
            'uses' => $this->input->post('uses'), 
            'invoive_due_date' => date('Y-m-d', strtotime($this->input->post('invoive_due_date'))), 
            'reminder' => $this->input->post('reminder'), 
            'interval_in_days' => $this->input->post('interval_in_days'), 

            'm_model_name' => $this->input->post('m_model_name'), 
            'm_name' => $this->input->post('m_name'), 
            'm_surname' => $this->input->post('m_surname'), 
            'm_address_line1' => $this->input->post('m_address_line1'), 
            'm_address_line2' => $this->input->post('m_address_line2'), 
            'm_pincode' => $this->input->post('m_pincode'), 
            'm_city' => $this->input->post('m_city'), 
            'm_country' => $this->input->post('m_country'), 
            'm_ingermany' => $this->input->post('m_ingermany'), 
            'm_service_fee' => $this->input->post('m_service_fee'),
            'm_vat_tin_number' => $this->input->post('m_vat_tin_number'), 
            'm_email' => $this->input->post('m_email'), 
            'm_internal_notes' => $this->input->post('m_internal_notes'), 
            'm_vat' => $this->input->post('m_vat_yes_checked'), 
            'm_vat_percent' => $this->input->post('m_vat_percent'), 
            'model_agency_comission' => $this->input->post('modelAgencyComission'),
            'model_budget' => $this->input->post('model_budget'),
            'vat_price' => $this->input->post('modelInclComission'),
            'model_total_agreed' => $this->input->post('model_total_agreed'),
            'additional_modal_price' => $this->input->post('additional_modal_price'),
            'additional_modal_text' => $this->input->post('additional_modal_text'),
            'apply_model_fee' => $this->input->post('apply_model_fee'),
            'internal_notes' => $this->input->post('internal_notes'), 
            'modelothertext' => $this->input->post('modelothertext'),
            'acommissionothertext' => $this->input->post('acommissionothertext'),
            'reverse_invoice' => (int)$this->input->post('reverse_invoice'), 
            // 'creation_date' => date('Y-m-d H:i:s'),
            'modification_date' => date('Y-m-d H:i:s'),
        );

        // return $array;

        $this->db->where('invoice_number', $invoice_number);
        return $this->db->update('invoice', $array);

    }


     public function save_edit_invoice_correction(){

        $user_id = $this->user_id();
        $invoice_number = $this->input->post('invoice_number');
        
        $array = array(            
            'client_id' => $this->input->post('client_ids'), 
            'model_id' => $this->input->post('model_ids'),             
             
            'i_company_name' => $this->input->post('i_company_name'),
            'i_name' => $this->input->post('i_name'), 
            'i_fee' => $this->input->post('i_fee'), 
            'i_surname' => $this->input->post('i_surname'), 
            'i_address_line1' => $this->input->post('i_address_line1'), 
            'i_address_line2' => $this->input->post('i_address_line2'), 
            'i_city' => $this->input->post('i_city'), 
            'i_country' => $this->input->post('i_country'), 
            'i_pincode' => $this->input->post('i_pincode'), 
            'i_vat_tin_number' => $this->input->post('i_vat_tin_number'), 
            'i_email' => $this->input->post('i_email'), 
            'i_mobile_no' => $this->input->post('i_mobile_no'), 
            'i_internal_notes' => $this->input->post('i_internal_notes'), 
            'i_telephone' => $this->input->post('i_telephone'), 

            'shipping_company_name' => $this->input->post('shipping_company_name'), 
            'shipping_name' => $this->input->post('shipping_name'), 
            'shipping_surname' => $this->input->post('shipping_surname'), 
            'shipping_address_line1' => $this->input->post('shipping_address_line1'), 
            'shipping_address_line2' => $this->input->post('shipping_address_line2'), 
            'shipping_pincode' => $this->input->post('shipping_pincode'), 
            'shipping_city' => $this->input->post('shipping_city'),

            'payment_terms' => $this->input->post('payment_terms'), 
            'job_date' => $this->input->post('job_date'), 
            'job_date_till' => $this->input->post('job_date_till'), 
            'invoice_date' => $this->input->post('invoice_date'), 
            'uses' => $this->input->post('uses'), 
            'invoive_due_date' => $this->input->post('invoive_due_date'), 
            'reminder' => $this->input->post('reminder'), 
            'interval_in_days' => $this->input->post('interval_in_days'), 

            'm_model_name' => $this->input->post('m_model_name'), 
            'm_name' => $this->input->post('m_name'), 
            'm_surname' => $this->input->post('m_surname'), 
            'm_address_line1' => $this->input->post('m_address_line1'), 
            'm_address_line2' => $this->input->post('m_address_line2'), 
            'm_pincode' => $this->input->post('m_pincode'), 
            'm_city' => $this->input->post('m_city'), 
            'm_country' => $this->input->post('m_country'), 
            'm_ingermany' => $this->input->post('m_ingermany'), 
            'm_service_fee' => $this->input->post('m_service_fee'),
            'm_vat_tin_number' => $this->input->post('m_vat_tin_number'), 
            'm_email' => $this->input->post('m_email'), 
            'm_internal_notes' => $this->input->post('m_internal_notes'), 
            'm_vat' => $this->input->post('m_vat_yes_checked'), 
            'm_vat_percent' => $this->input->post('m_vat_percent'), 
            'model_agency_comission' => $this->input->post('modelAgencyComission'),
            'model_budget' => $this->input->post('model_budget'),
            'vat_price' => $this->input->post('modelInclComission'),
            'model_total_agreed' => $this->input->post('model_total_agreed'),
            'additional_modal_price' => $this->input->post('additional_modal_price'),
            'additional_modal_text' => $this->input->post('additional_modal_text'),
            'apply_model_fee' => $this->input->post('apply_model_fee'),
            'internal_notes' => $this->input->post('internal_notes'), 
            // 'creation_date' => date('Y-m-d H:i:s'),

            'correction' => 1, 
            'correction_input' => $this->input->post('correction_input'), 

            'modification_date' => date('Y-m-d H:i:s'),
        );

        // return $array;

        $this->db->where('invoice_number', $invoice_number);
        return $this->db->update('invoice', $array);

    }


    public function delete_invoice_support_table_data($table_id, $delete_data){

        $array_tables = ['', 'model_agreed_fields', 'invoice_expense', 'invoice_service'];
        $inc = 0;
        foreach ($delete_data as $data) {
            $del_id = $data;
            $this->db->where('id', $del_id);
            $this->db->delete("$array_tables[$table_id]");
            $inc = 1;
        }
        return $inc;
       
    }

    public function get_invoices($month, $year, $vat, $total_amount, $other){

        $strfilter = '';
        if(!empty($month) && !empty($year)){
            $start_date = $year."-".$month."-01";
            $end_date = date('Y-m-t', strtotime($start_date));

            $strfilter = " AND (creation_date >= '$start_date'  AND creation_date <= '$end_date') ";
        }
        else if(!empty($month)){
           $strfilter = " AND DATE_FORMAT(creation_date,'%m') =  $month";
        }
        else if(!empty($year)){
           $strfilter = " AND DATE_FORMAT(creation_date,'%Y') =  $year";
        }

        if(!empty($vat)){
           $strfilter .= " AND vat_price = $vat";
        }

        if(!empty($total_amount)){
           $strfilter .= " AND IF(apply_model_fee == 1, model_budget, model_total_agreed) = $total_amount";
        }

        if(!empty($other)){
            $other = '%'.strtolower(trim($other)).'%';
            $strfilter .= " AND (LOWER(i_company_name) LIKE '$other' || LOWER(m_model_name) LIKE '$other') ";
        }


        $user_id = $this->user_id();
         
        $sql = "SELECT id, invoice_number, i_company_name, m_model_name, model_budget, model_total_agreed, m_vat_percent, model_agency_comission, vat_price, job_date, creation_date, m_ingermany, approve, (SELECT SUM(IF(m_ingermany = 1 AND invoice_expense.vat_include = 1, ((invoice_expense.model_exp_amount) + ((invoice_expense.model_exp_amount * invoice_expense.vat_include )/100)), (invoice_expense.model_exp_amount))) FROM invoice_expense WHERE invoice_expense.invoice_number = invoice.invoice_number AND invoice_expense.status = 1) as modelExp, (SELECT SUM(IF(m_ingermany = 1 AND invoice_service.vat_include = 1, ((invoice_service.model_ser_amount) + ((invoice_service.model_ser_amount * invoice_service.vat_include )/100)), (invoice_service.model_ser_amount))) FROM invoice_service WHERE invoice_service.invoice_number = invoice.invoice_number AND invoice_service.status = 1) as selectInc, IF(m_ingermany = 1 AND vat_price > 0, ((model_total_agreed*model_agency_comission)/100) + IF(vat_price > 0, (((model_total_agreed*model_agency_comission)/100) * vat_price )/ 100, 0), ((model_total_agreed*model_agency_comission)/100) ) as model_comission  FROM invoice WHERE user_id = $user_id AND status = 1 $strfilter ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }





    public function get_accepted_invoices($limit, $month, $year, $vat, $total_amount, $other){

        $lmitStr = '';
        if($limit > 0){
            $lmitStr = " LIMIT 0, $limit";
        }

        $strfilter = '';
        if(!empty($month) && !empty($year)){
            $start_date = $year."-".$month."-01";
            $end_date = date('Y-m-t', strtotime($start_date));

            $strfilter = " AND (creation_date >= '$start_date'  AND creation_date <= '$end_date') ";
        }
        else if(!empty($month)){
           $strfilter = " AND DATE_FORMAT(creation_date,'%m') =  $month";
        }
        else if(!empty($year)){
           $strfilter = " AND DATE_FORMAT(creation_date,'%Y') =  $year";
        }

        if(!empty($vat)){
           $strfilter .= " AND vat_price = $vat";
        }

        if(!empty($total_amount)){
           $strfilter .= " AND IF(apply_model_fee == 1, model_budget, model_total_agreed) = $total_amount";
        }

        if(!empty($other)){
            $other = '%'.strtolower(trim($other)).'%';
            $strfilter .= " AND (LOWER(i_company_name) LIKE '$other' || LOWER(m_model_name) LIKE '$other') ";
        }


        $user_id = $this->user_id();
         
        $sql = "SELECT id, invoice_number, i_company_name, m_model_name, model_budget, model_total_agreed, m_vat_percent, model_agency_comission, vat_price, job_date, creation_date, m_ingermany, approve, approve_email, (SELECT SUM(IF(m_ingermany = 1 AND invoice_expense.vat_include = 1, ((invoice_expense.model_exp_amount) + ((invoice_expense.model_exp_amount * invoice_expense.vat_include )/100)), (invoice_expense.model_exp_amount))) FROM invoice_expense WHERE invoice_expense.invoice_number = invoice.invoice_number AND invoice_expense.status = 1) as modelExp, (SELECT SUM(IF(m_ingermany = 1 AND invoice_service.vat_include = 1, ((invoice_service.model_ser_amount) + ((invoice_service.model_ser_amount * invoice_service.vat_include )/100)), (invoice_service.model_ser_amount))) FROM invoice_service WHERE invoice_service.invoice_number = invoice.invoice_number AND invoice_service.status = 1) as selectInc, IF(m_ingermany = 1 AND vat_price > 0, ((model_total_agreed*model_agency_comission)/100) + IF(vat_price > 0, (((model_total_agreed*model_agency_comission)/100) * vat_price )/ 100, 0), ((model_total_agreed*model_agency_comission)/100) ) as model_comission  FROM invoice WHERE user_id = $user_id AND approve = 1 AND status = 1 $strfilter ORDER BY id DESC $lmitStr";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }


     public function save_accepted_invoice_email_send()  {
        
        $invoice_number =  $this->input->post('invoice_no');
        $email_ckecked =  $this->input->post('email_ckecked');

        $i_array = array(
            'approve_email' => $email_ckecked,
            'modification_date' => date('Y-m-d H:i:s')
        );
        $this->db->where('invoice_number', $invoice_number);
        return $this->db->update('invoice', $i_array);
    }



    public function get_invoive_detail($invoice_number)  {        
        $user_id = $this->user_id();
        $sql = "SELECT invoice.*, (SELECT SUM(IF(invoice_expense.vat_include = 1, (invoice_expense.model_exp_amount * invoice_expense.vat_include )/100, 0)) FROM invoice_expense WHERE invoice_expense.invoice_number = invoice.invoice_number AND invoice_expense.status = 1) as VatmodelExp,  (SELECT 
        SUM(invoice_expense.model_exp_amount) FROM invoice_expense WHERE invoice_expense.invoice_number = invoice.invoice_number AND invoice_expense.status = 1) as modelExp FROM invoice WHERE invoice.invoice_number = '$invoice_number'";
        $query = $this->db->query($sql);
        return $result = $query->row();
    }

     public function model_agreed_data($invoice_number)  {        
        $user_id = $this->user_id();
        $sql = "SELECT * FROM model_agreed_fields WHERE invoice_number = '$invoice_number' AND status = 1";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }

    public function get_invoive_headers($invoice_number)  {        
        
        $user_id = $this->user_id();
        $sql = "SELECT * FROM invoice_additional_header WHERE invoice_number = '$invoice_number'";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }

    public function generate_invoice_headers()  {
        $user_id = $this->user_id();
            // invoice_number, invoive_title, invoive_value, status, creation_date, modification_date 
        $id =  $this->input->post('inv_id');
        $array = array(
            'invoice_number' => $this->input->post('inv_number'),
            'invoive_title' =>  $this->input->post('inv_title'),
            'invoive_value' => $this->input->post('inv_value'),             
            'modification_date' => date('Y-m-d H:i:s'),
        );

        if($id > 0){
            $this->db->where('id', $id);
            $this->db->update('invoice_additional_header',$array);
            return $id;
        }

        $array['status'] = 1; 
        $array['creation_date'] = date('Y-m-d H:i:s');
        $this->db->insert('invoice_additional_header',$array);
        return $this->db->insert_id();
    }


    public function delete_invoice_headers()  {
        $user_id = $this->user_id();
        // invoice_number, invoive_title, invoive_value, status, creation_date, modification_date 
        $id =  $this->input->post('inv_id');
        
        $this->db->where('id', $id);
        return $this->db->delete('invoice_additional_header'); 
    }

    public function forward_invoice_approval()  {

        $user_id = $this->user_id();
        $invoice_number =  $this->input->post('sendapprovalinvoice');
        $assignee =  $this->input->post('assignee');

        $i_array = array(
            'approve' => 2,
            'assignee_to' => $assignee,
            'approve_date' => date('Y-m-d H:i:s'),
            'modification_date' => date('Y-m-d H:i:s')
        );
        $this->db->where('invoice_number', $invoice_number);
        return $this->db->update('invoice', $i_array);
    }

     public function invoice_approve_or_change_request()  {

        $user_id = $this->user_id();
        $invoice_number =  $this->input->post('approve_invoice_id');
        $approve_message =  $this->input->post('approve_message');
        $approve_status =  $this->input->post('approve_status');

        $i_array = array(
            'approve' => $approve_status,
            'approve_message' => $approve_message,
            'approve_date' => date('Y-m-d H:i:s'),
            'modification_date' => date('Y-m-d H:i:s')
        );
        $this->db->where('invoice_number', $invoice_number);
        return $this->db->update('invoice', $i_array);
    }

    // public function forward_refund_approval()  {

    //     $user_id = $this->user_id();
    //     $invoice_number =  $this->input->post('sendapprovalinvoice');
    //     $i_array = array(
    //         'approve_refund' => 2,
    //         'modification_date' => date('Y-m-d H:i:s')
    //     );
    //     $this->db->where('invoice_number', $invoice_number);
    //     return $this->db->update('invoice', $i_array);
        
        
    // }




    public function get_invoice_expenses($invoice_number){
       
        $sql = "SELECT * FROM invoice_expense WHERE invoice_number = '$invoice_number'";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }
    
    public function get_invoice_service($invoice_number){
       
        $sql = "SELECT * FROM invoice_service WHERE invoice_number = '$invoice_number'";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }


    public function get_invoive_list(){
       
        $user_id = $this->user_id();

        $sql = "SELECT id, invoice_number, issue_id FROM invoice WHERE user_id = $user_id AND approve = 1";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }


    public function save_invoive_refund()  {
        $refaund_service_id = $this->input->post('refaund_service_id');
        
        $array['status'] = 0;
        $this->db->where('id', $refaund_service_id);
        return $this->db->update('invoice_service', $array);
    }
  
    public function change_password_verify($password)  {
        
        $user_id = $this->user_id();
        $password = md5($password);

        $sql = "SELECT password FROM user WHERE id = $user_id AND password = '$password'";
        $query = $this->db->query($sql);
        return $result = $query->row();
    }

    public function change_settings_password($password)  {

        $user_id = $this->user_id();        
        $array = array(            
            'password' => md5($password), 
            'modification_date' => date('Y-m-d H:i:s'),
        );

        $this->db->where('id', $user_id);
        return $this->db->update('user',$array);
    }

    // ======================================

    public function get_draft_open_invoive($limit, $month, $year, $vat, $total_amount, $other){  
        $limitStr = '';
        if($limit > 0){
            $limitStr = 'LIMIT 0, '.$limit;
        }


        $strfilter = '';
        if(!empty($month) && !empty($year)){
            $start_date = $year."-".$month."-01";
            $end_date = date('Y-m-t', strtotime($start_date));

            $strfilter = " AND (creation_date >= '$start_date'  AND creation_date <= '$end_date') ";
        }
        else if(!empty($month)){
           $strfilter = " AND DATE_FORMAT(creation_date,'%m') =  $month";
        }
        else if(!empty($year)){
           $strfilter = " AND DATE_FORMAT(creation_date,'%Y') =  $year";
        }

        if(!empty($vat)){
           $strfilter .= " AND vat_price = $vat";
        }

        if(!empty($total_amount)){
           $strfilter .= " AND IF(apply_model_fee == 1, model_budget, model_total_agreed) = $total_amount";
        }

        if(!empty($other)){
            $other = '%'.strtolower(trim($other)).'%';
            $strfilter .= " AND (LOWER(i_company_name) LIKE '$other' || LOWER(m_model_name) LIKE '$other') ";
        }

        $user_id = $this->user_id();
        $sql = "SELECT id, invoice_number, i_company_name, m_model_name, model_budget, model_total_agreed, m_vat_percent, model_agency_comission, vat_price, issue_id, job_date, creation_date, apply_model_fee, m_ingermany, (SELECT SUM(model_ser_amount) FROM invoice_service WHERE invoice_number = invoice.invoice_number) as selectInc FROM invoice WHERE approve = 0 AND user_id = $user_id $strfilter ORDER BY id DESC $limitStr";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }

    public function get_user_open_invoive($limit, $month, $year, $vat, $total_amount, $other){
        $limitStr = '';
        if($limit > 0){
            $limitStr = 'LIMIT 0, '.$limit;
        }

        $strfilter = '';
        if(!empty($month) && !empty($year)){
            $start_date = $year."-".$month."-01";
            $end_date = date('Y-m-t', strtotime($start_date));

            $strfilter = " AND (creation_date >= '$start_date'  AND creation_date <= '$end_date') ";
        }
        else if(!empty($month)){
           $strfilter = " AND DATE_FORMAT(creation_date,'%m') =  $month";
        }
        else if(!empty($year)){
           $strfilter = " AND DATE_FORMAT(creation_date,'%Y') =  $year";
        }

        if(!empty($vat)){
           $strfilter .= " AND vat_price = $vat";
        }

        if(!empty($total_amount)){
           $strfilter .= " AND IF(apply_model_fee == 1, model_budget, model_total_agreed) = $total_amount";
        }

        if(!empty($other)){
            $other = '%'.strtolower(trim($other)).'%';
            $strfilter .= " AND (LOWER(i_company_name) LIKE '$other' || LOWER(m_model_name) LIKE '$other') ";
        }

        $user_id = $this->user_id();
        $sql = "SELECT id, invoice_number, i_company_name, m_model_name, model_budget, model_total_agreed, m_vat_percent, model_agency_comission, vat_price, issue_id, job_date, creation_date, apply_model_fee, m_ingermany, (SELECT SUM(model_ser_amount) FROM invoice_service WHERE invoice_number = invoice.invoice_number) as selectInc FROM invoice WHERE approve = 2 AND user_id = $user_id $strfilter ORDER BY id DESC $limitStr";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }

    public function get_user_approve_invoive($limit, $month, $year, $vat, $total_amount, $other){
        $limitStr = '';
        if($limit > 0){
            $limitStr = 'LIMIT 0, '.$limit;
        }


        $strfilter = '';
        if(!empty($month) && !empty($year)){
            $start_date = $year."-".$month."-01";
            $end_date = date('Y-m-t', strtotime($start_date));

            $strfilter = " AND (creation_date >= '$start_date'  AND creation_date <= '$end_date') ";
        }
        else if(!empty($month)){
           $strfilter = " AND DATE_FORMAT(creation_date,'%m') =  $month";
        }
        else if(!empty($year)){
           $strfilter = " AND DATE_FORMAT(creation_date,'%Y') =  $year";
        }

        if(!empty($vat)){
           $strfilter .= " AND vat_price = $vat";
        }

        if(!empty($total_amount)){
           $strfilter .= " AND IF(apply_model_fee == 1, model_budget, model_total_agreed) = $total_amount";
        }

        if(!empty($other)){
            $other = '%'.strtolower(trim($other)).'%';
            $strfilter .= " AND (LOWER(i_company_name) LIKE '$other' || LOWER(m_model_name) LIKE '$other') ";
        }

        $user_id = $this->user_id();
        $sql = "SELECT id, invoice_number, i_company_name, m_model_name, model_budget, model_total_agreed, m_vat_percent, model_agency_comission, vat_price, issue_id, job_date, creation_date, apply_model_fee, m_ingermany, (SELECT SUM(model_ser_amount) FROM invoice_service WHERE invoice_number = invoice.invoice_number) as selectInc FROM invoice WHERE approve = 1 AND user_id = $user_id $strfilter ORDER BY id DESC $limitStr";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }

    public function get_user_reminder_invoive($limit, $month, $year, $vat, $total_amount, $other){ 
        $limitStr = '';
        if($limit > 0){
            $limitStr = 'LIMIT 0, '.$limit;
        }

        $strfilter = '';
        if(!empty($month) && !empty($year)){
            $start_date = $year."-".$month."-01";
            $end_date = date('Y-m-t', strtotime($start_date));

            $strfilter = " AND (creation_date >= '$start_date'  AND creation_date <= '$end_date') ";
        }
        else if(!empty($month)){
           $strfilter = " AND DATE_FORMAT(creation_date,'%m') =  $month";
        }
        else if(!empty($year)){
           $strfilter = " AND DATE_FORMAT(creation_date,'%Y') =  $year";
        }

        if(!empty($vat)){
           $strfilter .= " AND vat_price = $vat";
        }

        if(!empty($total_amount)){
           $strfilter .= " AND IF(apply_model_fee == 1, model_budget, model_total_agreed) = $total_amount";
        }

        if(!empty($other)){
            $other = '%'.strtolower(trim($other)).'%';
            $strfilter .= " AND (LOWER(i_company_name) LIKE '$other' || LOWER(m_model_name) LIKE '$other') ";
        }

        $user_id = $this->user_id();
        $current_date = date('Y-m-d H:i:s');
        $sql = "SELECT id, invoice_number, i_company_name, m_model_name, model_budget, model_total_agreed, m_vat_percent, model_agency_comission, vat_price, issue_id, job_date, DATE_ADD(creation_date, INTERVAL (reminder * interval_in_days) DAY) as cdate, reminder, interval_in_days, creation_date, apply_model_fee, m_ingermany, (SELECT SUM(model_ser_amount) FROM invoice_service WHERE invoice_number = invoice.invoice_number) as selectInc FROM invoice WHERE DATE_ADD(creation_date, INTERVAL (reminder * interval_in_days) DAY) > '$current_date' AND user_id = $user_id $strfilter ORDER BY id DESC $limitStr";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }

    public function get_user_refund_invoive($limit, $month, $year, $vat, $total_amount, $other){
        $limitStr = '';
        if($limit > 0){
            $limitStr = 'LIMIT 0, '.$limit;
        }

        $strfilter = '';
        if(!empty($month) && !empty($year)){
            $start_date = $year."-".$month."-01";
            $end_date = date('Y-m-t', strtotime($start_date));

            $strfilter = " AND (creation_date >= '$start_date'  AND creation_date <= '$end_date') ";
        }
        else if(!empty($month)){
           $strfilter = " AND DATE_FORMAT(creation_date,'%m') =  $month";
        }
        else if(!empty($year)){
           $strfilter = " AND DATE_FORMAT(creation_date,'%Y') =  $year";
        }

        if(!empty($vat)){
           $strfilter .= " AND vat_price = $vat";
        }

        if(!empty($total_amount)){
           $strfilter .= " AND IF(apply_model_fee == 1, model_budget, model_total_agreed) = $total_amount";
        }

        if(!empty($other)){
            $other = '%'.strtolower(trim($other)).'%';
            $strfilter .= " AND (LOWER(i_company_name) LIKE '$other' || LOWER(m_model_name) LIKE '$other') ";
        }

        $user_id = $this->user_id();
        $current_date = date('Y-m-d H:i:s');
        $sql = "SELECT DISTINCT i.id, i.invoice_number, i.i_company_name, i.m_model_name, i.model_budget, i.model_total_agreed, i.m_vat_percent, i.model_agency_comission, i.vat_price, i.job_date, i.creation_date, i.apply_model_fee, i.m_ingermany, i.approve, i.m_ingermany, (SELECT SUM(IF(m_ingermany = 1 AND invoice_expense.vat_include = 1, ((invoice_expense.model_exp_amount) + ((invoice_expense.model_exp_amount * invoice_expense.vat_include )/100)), (invoice_expense.model_exp_amount))) FROM invoice_expense WHERE invoice_expense.invoice_number = i.invoice_number AND invoice_expense.status = 1) as modelExp, (SELECT SUM(IF(m_ingermany = 1 AND invoice_service.vat_include = 1, ((invoice_service.model_ser_amount) + ((invoice_service.model_ser_amount * invoice_service.vat_include )/100)), (invoice_service.model_ser_amount))) FROM invoice_service WHERE invoice_number = i.invoice_number AND invoice_service.status = 1) as selectInc FROM invoice i INNER JOIN invoice_service iss ON i.invoice_number = iss.invoice_number WHERE iss.status = 0 AND user_id = $user_id $strfilter ORDER BY i.id DESC $limitStr";


        $query = $this->db->query($sql);
        return $result = $query->result();
    }



    public function get_refund_invoive($limit, $month, $year, $vat, $total_amount, $other){
        $limitStr = '';
        if($limit > 0){
            $limitStr = 'LIMIT 0, '.$limit;
        }

        $strfilter = '';
        if(!empty($month) && !empty($year)){
            $start_date = $year."-".$month."-01";
            $end_date = date('Y-m-t', strtotime($start_date));

            $strfilter = " AND (creation_date >= '$start_date'  AND creation_date <= '$end_date') ";
        }
        else if(!empty($month)){
           $strfilter = " AND DATE_FORMAT(creation_date,'%m') =  $month";
        }
        else if(!empty($year)){
           $strfilter = " AND DATE_FORMAT(creation_date,'%Y') =  $year";
        }

        if(!empty($vat)){
           $strfilter .= " AND vat_price = $vat";
        }

        if(!empty($total_amount)){
           $strfilter .= " AND IF(apply_model_fee == 1, model_budget, model_total_agreed) = $total_amount";
        }

        if(!empty($other)){
            $other = '%'.strtolower(trim($other)).'%';
            $strfilter .= " AND (LOWER(i_company_name) LIKE '$other' || LOWER(m_model_name) LIKE '$other') ";
        }

        $user_id = $this->user_id();
        $current_date = date('Y-m-d H:i:s');
        $sql = "SELECT DISTINCT i.id, i.invoice_number, i.i_company_name, i.m_model_name, i.model_budget, i.model_total_agreed, i.m_vat_percent, i.model_agency_comission, i.vat_price, i.job_date, i.creation_date, i.approve, i.m_ingermany, (SELECT SUM(IF(m_ingermany = 1 AND invoice_expense.vat_include = 1, ((invoice_expense.model_exp_amount) + ((invoice_expense.model_exp_amount * invoice_expense.vat_include )/100)), (invoice_expense.model_exp_amount))) FROM invoice_expense WHERE invoice_expense.invoice_number = i.invoice_number AND invoice_expense.status = 1) as modelExp, (SELECT SUM(IF(m_ingermany = 1 AND invoice_service.vat_include = 1, ((invoice_service.model_ser_amount) + ((invoice_service.model_ser_amount * invoice_service.vat_include )/100)), (invoice_service.model_ser_amount))) FROM invoice_service WHERE invoice_number = i.invoice_number AND invoice_service.status = 1) as selectInc FROM invoice i INNER JOIN invoice_service iss ON i.invoice_number = iss.invoice_number WHERE refund = 1 AND user_id = $user_id $strfilter ORDER BY i.id DESC $limitStr";


        $query = $this->db->query($sql);
        return $result = $query->result();
    }


    public function get_payed_model_overview($limit, $month, $year, $vat, $total_amount, $other){  
        $limitStr = '';
        if($limit > 0){
            $limitStr = 'LIMIT 0, '.$limit;
        }

        $strfilter = '';
        if(!empty($month) && !empty($year)){
            $start_date = $year."-".$month."-01";
            $end_date = date('Y-m-t', strtotime($start_date));

            $strfilter = " AND (creation_date >= '$start_date'  AND creation_date <= '$end_date') ";
        }
        else if(!empty($month)){
           $strfilter = " AND DATE_FORMAT(creation_date,'%m') =  $month";
        }
        else if(!empty($year)){
           $strfilter = " AND DATE_FORMAT(creation_date,'%Y') =  $year";
        }

        if(!empty($vat)){
           $strfilter .= " AND vat_price = $vat";
        }

        if(!empty($total_amount)){
           $strfilter .= " AND IF(apply_model_fee == 1, model_budget, model_total_agreed) = $total_amount";
        }

        if(!empty($other)){
            $other = '%'.strtolower(trim($other)).'%';
            $strfilter .= " AND (LOWER(i_company_name) LIKE '$other' || LOWER(m_model_name) LIKE '$other') ";
        }

        $user_id = $this->user_id();
        $sql = "SELECT id, invoice_number, i_company_name, m_model_name, model_budget, model_total_agreed, m_vat_percent, model_agency_comission, vat_price, issue_id, job_date, creation_date, (SELECT SUM(model_ser_amount) FROM invoice_service WHERE invoice_number = invoice.invoice_number) as selectInc FROM invoice WHERE deduction_amout > 0 AND approve = 0 AND user_id = $user_id $strfilter ORDER BY id DESC $limitStr";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }


     public function save_create_refund($invoice_number)  {

        // print_r($_POST);
        // exit();

        $tr_amount = $this->input->post('modelDeductionValue');
        // $model_deduction = $this->input->post('modeldeduction');

        $array = array(
            'refund' => 1,
            'm_vat_percent' =>  $this->input->post('m_vat_percent'),
            'm_service_fee' =>  $this->input->post('myservicefee'),
            'credit_note' => $this->input->post('txtcreditnotes'),
            'deduction_text' => $this->input->post('deductiontext'),
            'honorarium_text' => $this->input->post('honorariumtext'), 
            'special_charget_vat' => $this->input->post('servicechargesvat'),
            'special_charge_amount' => $this->input->post('servicecharges'),
            'travel_cost_amount' => $this->input->post('travelcost'),
            'travelcost_percent' => $this->input->post('travelcost_percent'),
            'travel_cost_vat' => $this->input->post('travelcostvat'),
            'deduction_amout' => $tr_amount, 
            'approve_refund_date' => date('Y-m-d H:i:s'),
            'modification_date' => date('Y-m-d H:i:s'),
        );

        // =================== 

        $user_id = $this->user_id();
        $model_id =  $this->input->post('modeldeduction');

        $sql = "SELECT id, user_id, model_id, wallet FROM user_wallet WHERE user_id = $user_id AND model_id = '$model_id'";
        $query = $this->db->query($sql);
        $wallet_tr = $query->row(); 

        if(empty($wallet_tr)){
            $wallet_i = array(
                'user_id' => $user_id,
                'model_id' => $model_id,
                'wallet' => 0,
                'creation_date' => date('Y-m-d H:i:s'),
                'modification_date' => date('Y-m-d H:i:s'),
            );
            $this->db->insert('user_wallet', $wallet_i);

            $sql = "SELECT id, user_id, model_id, wallet FROM user_wallet WHERE user_id = $user_id AND model_id = '$model_id'";
            $query = $this->db->query($sql);
            $wallet_tr = $query->row(); 
        }


        $wall_amount = 0;

        $quantity = 1;
        // $this->input->post('d_expenses_quantity');
        // $tr_amount = $this->input->post('d_expenses_amount');
        $tr_qty_amt =  $quantity * $tr_amount;

        
        
        if(!empty($wallet_tr)){
            $wall_amount = $wallet_tr->wallet;
        }

        $wall_amount_after = $wall_amount - $tr_amount;
        $sum_after_qty_amt =  $wall_amount - $tr_qty_amt;
  
        $_darray = array(
            'user_id' => $user_id, 
            'model_id' => $model_id, 
            'invoice_id' => $invoice_number,
            'name' => 'Deduct for model expense payment', 
            'amount_before' => $wall_amount,
            'quantity' => 1,
            'amount' => $tr_amount,
            'sum_amount' => $tr_qty_amt,
            'amount_after' => $wall_amount_after,
            'sum_aftre_amount' => $sum_after_qty_amt,
            'attachment' => '', 
            'filename' => '', 
            'description' => 'Amount deduct for modal expense payment.',   
            'expense_date' => date('Y-m-d H:i:s'),  
            'transaction_type' => 'CR',
            'status' => 1, 
            'creation_date' => date('Y-m-d H:i:s'), 
            'modification_date' => date('Y-m-d H:i:s'),
        );

        $is_refund = $this->input->post('is_refund');
        if($is_refund != 1 &&  $tr_amount > 0){

            $wallet_amount = $wall_amount - $tr_qty_amt;
            $wallet = array(
                'wallet' => $wallet_amount,
                'modification_date' => date('Y-m-d H:i:s'),
            );

            $this->db->where('user_id', $user_id);
            $this->db->where('model_id', $model_id);
            $this->db->update('user_wallet', $wallet);

           $this->db->insert('deduction_expenses',$_darray);
       }

        // ==================


        $this->db->where('invoice_number', $invoice_number);
        $data = $this->db->update('invoice',$array);

        if($data){
            saveautoIncrementer();
        }
        return $data;
    }


    public function get_draft_refund_invoive($limit){
        $limitStr = '';
        if($limit > 0){
            $limitStr = 'LIMIT 0, '.$limit;
        }

        $user_id = $this->user_id();
        $current_date = date('Y-m-d H:i:s');
        $sql = "SELECT DISTINCT i.id, i.invoice_number, i.i_company_name, i.m_model_name, i.model_budget, i.model_total_agreed, i.m_vat_percent, i.model_agency_comission, i.vat_price, i.job_date, i.creation_date, i.approve, i.m_ingermany, (SELECT SUM(IF(m_ingermany = 1 AND invoice_expense.vat_include = 1, ((invoice_expense.model_exp_amount) + ((invoice_expense.model_exp_amount * invoice_expense.vat_include )/100)), (invoice_expense.model_exp_amount))) FROM invoice_expense WHERE invoice_expense.invoice_number = i.invoice_number AND invoice_expense.status = 1) as modelExp, (SELECT SUM(IF(m_ingermany = 1 AND invoice_service.vat_include = 1, ((invoice_service.model_ser_amount) + ((invoice_service.model_ser_amount * invoice_service.vat_include )/100)), (invoice_service.model_ser_amount))) FROM invoice_service WHERE invoice_number = i.invoice_number AND invoice_service.status = 1) as selectInc FROM invoice i LEFT JOIN invoice_service iss ON i.invoice_number = iss.invoice_number WHERE i.refund = 1 AND i.approve_refund = 0 AND i.user_id = $user_id ORDER BY i.id DESC $limitStr";

        $query = $this->db->query($sql);
        return $result = $query->result();
    }



     public function get_open_refund_invoive($limit){
        $limitStr = '';
        if($limit > 0){
            $limitStr = 'LIMIT 0, '.$limit;
        }

        $user_id = $this->user_id();
        $current_date = date('Y-m-d H:i:s');

        $sql = "SELECT DISTINCT i.id, i.invoice_number, i.i_company_name, i.m_model_name, i.model_budget, i.model_total_agreed, i.m_vat_percent, i.model_agency_comission, i.vat_price, i.job_date, i.creation_date, i.approve, i.m_ingermany, (SELECT SUM(IF(m_ingermany = 1 AND invoice_expense.vat_include = 1, ((invoice_expense.model_exp_amount) + ((invoice_expense.model_exp_amount * invoice_expense.vat_include )/100)), (invoice_expense.model_exp_amount))) FROM invoice_expense WHERE invoice_expense.invoice_number = i.invoice_number AND invoice_expense.status = 1) as modelExp, (SELECT SUM(IF(m_ingermany = 1 AND invoice_service.vat_include = 1, ((invoice_service.model_ser_amount) + ((invoice_service.model_ser_amount * invoice_service.vat_include )/100)), (invoice_service.model_ser_amount))) FROM invoice_service WHERE invoice_number = i.invoice_number AND invoice_service.status = 1) as selectInc FROM invoice i LEFT JOIN invoice_service iss ON i.invoice_number = iss.invoice_number WHERE  i.user_id = $user_id AND i.approve_refund = 2 AND i.refund = 1 ORDER BY i.id DESC $limitStr";

        $query = $this->db->query($sql);
        return $result = $query->result();
    }


     public function get_approve_refund_invoive($limit){
        $limitStr = '';
        if($limit > 0){
            $limitStr = 'LIMIT 0, '.$limit;
        }

        $user_id = $this->user_id();
        $current_date = date('Y-m-d H:i:s');
        $sql = "SELECT DISTINCT i.id, i.invoice_number, i.i_company_name, i.m_model_name, i.model_budget, i.model_total_agreed, i.m_vat_percent, i.model_agency_comission, i.vat_price, i.job_date, i.creation_date, i.approve, i.m_ingermany, (SELECT SUM(IF(m_ingermany = 1 AND invoice_expense.vat_include = 1, ((invoice_expense.model_exp_amount) + ((invoice_expense.model_exp_amount * invoice_expense.vat_include )/100)), (invoice_expense.model_exp_amount))) FROM invoice_expense WHERE invoice_expense.invoice_number = i.invoice_number AND invoice_expense.status = 1) as modelExp, (SELECT SUM(IF(m_ingermany = 1 AND invoice_service.vat_include = 1, ((invoice_service.model_ser_amount) + ((invoice_service.model_ser_amount * invoice_service.vat_include )/100)), (invoice_service.model_ser_amount))) FROM invoice_service WHERE invoice_number = i.invoice_number AND invoice_service.status = 1) as selectInc FROM invoice i LEFT JOIN invoice_service iss ON i.invoice_number = iss.invoice_number WHERE i.refund = 1 AND i.approve_refund = 1  AND user_id = $user_id ORDER BY i.id DESC $limitStr";

        $query = $this->db->query($sql);
        return $result = $query->result();
    }


    // ===========================

 // model_ser_amount
    public function get_mwm_invoices($limit, $month, $year, $vat, $total_amount, $other){

        $limitStr = '';
        if($limit > 0){
            $limitStr = 'LIMIT 0, '.$limit;
        }

        $strfilter = '';
        if(!empty($month) && !empty($year)){
            $start_date = $year."-".$month."-01";
            $end_date = date('Y-m-t', strtotime($start_date));

            $strfilter = " AND (creation_date >= '$start_date'  AND creation_date <= '$end_date') ";
        }
        else if(!empty($month)){
           $strfilter = " AND DATE_FORMAT(creation_date,'%m') =  $month";
        }
        else if(!empty($year)){
           $strfilter = " AND DATE_FORMAT(creation_date,'%Y') =  $year";
        }

        if(!empty($vat)){
           $strfilter .= " AND vat_price = $vat";
        }

        if(!empty($total_amount)){
           $strfilter .= " AND IF(apply_model_fee == 1, model_budget, model_total_agreed) = $total_amount";
        }

        if(!empty($other)){
            $other = '%'.strtolower(trim($other)).'%';
            $strfilter .= " AND (LOWER(i_company_name) LIKE '$other' || LOWER(m_model_name) LIKE '$other') ";
        }



        $user_id = $this->user_id();
        $sql = "SELECT id, invoice_number, i_company_name, m_model_name, model_budget, model_total_agreed, m_vat_percent, model_agency_comission, vat_price, job_date, creation_date, m_ingermany, (SELECT SUM(IF(m_ingermany = 1 AND invoice_expense.vat_include = 1, ((invoice_expense.model_exp_amount) + ((invoice_expense.model_exp_amount * invoice_expense.vat_include )/100)), (invoice_expense.model_exp_amount))) FROM invoice_expense WHERE invoice_expense.invoice_number = invoice.invoice_number AND invoice_expense.status = 1) as modelExp, (SELECT SUM(IF(m_ingermany = 1 AND invoice_service.vat_include = 1, ((invoice_service.model_ser_amount) + ((invoice_service.model_ser_amount * invoice_service.vat_include )/100)), (invoice_service.model_ser_amount))) FROM invoice_service WHERE invoice_service.invoice_number = invoice.invoice_number AND invoice_service.status = 1) as selectInc, IF(m_ingermany = 1 AND vat_price > 0, ((model_total_agreed*model_agency_comission)/100) + IF(vat_price > 0, (((model_total_agreed*model_agency_comission)/100) * vat_price )/ 100, 0), ((model_total_agreed*model_agency_comission)/100) ) as model_comission  FROM invoice WHERE user_id = $user_id AND status = 1 $strfilter ORDER BY id DESC $limitStr ";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }


     public function get_clients_for_invoice_approval(){ 
        
        $user_id = $this->user_id();
        $sql = "SELECT id, unique_code,  name, username , redmine_username, redmine_assignee FROM user WHERE id != $user_id AND status = 1 ORDER BY id DESC ";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }



    public function get_invoice_for_approval(){
        

        $user_id = $this->user_id();
        // $sql = "SELECT id, invoice_number, i_company_name, m_model_name, model_budget, model_total_agreed, m_vat_percent, model_agency_comission, vat_price, issue_id, job_date, creation_date, (SELECT SUM(model_ser_amount) FROM invoice_service WHERE invoice_number = invoice.invoice_number) as selectInc FROM invoice WHERE approve = 2 ORDER BY id DESC";
        $sql = "SELECT id, invoice_number, i_company_name, m_model_name, model_budget, model_total_agreed, m_vat_percent, model_agency_comission, vat_price, issue_id, job_date, creation_date, (SELECT SUM(model_ser_amount) FROM invoice_service WHERE invoice_number = invoice.invoice_number) as selectInc FROM invoice WHERE approve = 2 AND assignee_to = $user_id ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }

    public function changes_requestinvoice_lists_for_approval(){
        

        $user_id = $this->user_id();
        // $sql = "SELECT id, invoice_number, i_company_name, m_model_name, model_budget, model_total_agreed, m_vat_percent, model_agency_comission, vat_price, issue_id, job_date, creation_date, (SELECT SUM(model_ser_amount) FROM invoice_service WHERE invoice_number = invoice.invoice_number) as selectInc FROM invoice WHERE approve = 2 ORDER BY id DESC";
        $sql = "SELECT id, invoice_number, i_company_name, m_model_name, model_budget, model_total_agreed, m_vat_percent, model_agency_comission, vat_price, issue_id, job_date, creation_date, (SELECT SUM(model_ser_amount) FROM invoice_service WHERE invoice_number = invoice.invoice_number) as selectInc FROM invoice WHERE approve = 3 AND user_id = $user_id ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }


    public function invoice_correction(){
        
        $user_id = $this->user_id();
        
        $sql = "SELECT id, invoice_number, i_company_name, m_model_name, model_budget, model_total_agreed, m_vat_percent, model_agency_comission, vat_price, issue_id, job_date, creation_date, (SELECT SUM(model_ser_amount) FROM invoice_service WHERE invoice_number = invoice.invoice_number) as selectInc, correction, correction_input FROM invoice WHERE correction = 1 AND user_id = $user_id ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }


     public function approve_user_invoice() {

        $invoive_id = $this->input->post('invoive_id');
        
        $array['approve'] = 1;
        $array['approve_date'] = date('Y-m-d H:i:s');
        $array['modification_date'] = date('Y-m-d H:i:s');

        $this->db->where('invoice_number', $invoive_id);
        return $this->db->update('invoice', $array);  
    }


    // public function forward_refund_approval()  {

    //     $user_id = $this->user_id();
    //     $invoice_number =  $this->input->post('sendapprovalinvoice');
    //     $i_array = array(
    //         'approve_refund' => 2,
    //         'modification_date' => date('Y-m-d H:i:s')
    //     );
    //     $this->db->where('invoice_number', $invoice_number);
    //     return $this->db->update('invoice', $i_array);
        
        
    // }


    public function forward_refund_approval()  {

        $user_id = $this->user_id();
        $invoice_number =  $this->input->post('sendapprovalinvoice');
        $assignee =  $this->input->post('assignee');

        $i_array = array(
            'approve_refund' => 2,
            'refund_assign_to' => $assignee,
            'approve_refund_date' => date('Y-m-d H:i:s'),
            'modification_date' => date('Y-m-d H:i:s')
        );
        $this->db->where('invoice_number', $invoice_number);
        return $this->db->update('invoice', $i_array); 
    }



     public function get_refund_for_approval(){
        

        $user_id = $this->user_id();
        // $sql = "SELECT id, invoice_number, i_company_name, m_model_name, model_budget, model_total_agreed, m_vat_percent, model_agency_comission, vat_price, issue_id, job_date, creation_date, (SELECT SUM(model_ser_amount) FROM invoice_service WHERE invoice_number = invoice.invoice_number) as selectInc FROM invoice WHERE approve_refund = 2 ORDER BY id DESC";
        $sql = "SELECT id, invoice_number, i_company_name, m_model_name, model_budget, model_total_agreed, m_vat_percent, model_agency_comission, vat_price, issue_id, job_date, creation_date, (SELECT SUM(model_ser_amount) FROM invoice_service WHERE invoice_number = invoice.invoice_number) as selectInc FROM invoice WHERE approve_refund = 2 AND assignee_to = $user_id ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }


     public function approve_user_refund() {

        $invoive_id = $this->input->post('invoive_id');
        
        $array['approve_refund'] = 1;
        $array['approve_refund_date'] = date('Y-m-d H:i:s');
        $array['modification_date'] = date('Y-m-d H:i:s');

        $this->db->where('invoice_number', $invoive_id);
        return $this->db->update('invoice', $array);  
    }



     public function save_mwm_agency_management()  {

        $mwm_vat = $this->input->post('mwmvat');        
        $user_id = $this->user_id();
         
        $data['vat_price'] = $mwm_vat;
        $data['creation_date'] = date('Y-m-d H:i:s');
        $data['modification_date'] = date('Y-m-d H:i:s');
        
        $this->db->where('id', 1);
        return $this->db->update('mwm_agency', $data); 
    }


    // ------------- General Invoice -------------


     public function save_general_invoice($rowList){
        $user_id = $this->user_id();
        $insert = 0;

        $currency = $this->input->post('invoice_currency'); 
        $currency_amount = $this->input->post('currency_amount'); 
        $model_percentage = $this->input->post('model_percentage'); 
        $total_amount = $this->input->post('model_budget'); 

        $date = $this->input->post('date');
        if(!empty($date)){
          $date = date('Y-m-d', strtotime($date));
        }

        $b_date = $this->input->post('booking_date');
        if(!empty($b_date)){
          $b_date = date('Y-m-d', strtotime($b_date));
        }


        foreach ($rowList as $data) {

            $data_id = $data['model_row_id'];

            $myarr['name'] = $data['name'];
            $myarr['title_1'] = $data['title_1'];
            $myarr['title_2'] = $data['title_2'];           
            $myarr['amount'] = $data['amount']; 
            $myarr['percentage'] = $data['percentage']; 
            $myarr['currency'] = $currency;
            $myarr['currency_amount'] = $currency_amount; 
            $myarr['vat_percentage'] = $model_percentage; 
            $myarr['total_amount'] = $total_amount; 

            $myarr['modification_date'] = $data['modification_date'];

            if($data_id > 0){
                
                $this->db->where('id', $data_id);
                $this->db->update('general_invoice', $myarr);
                $insert = 1;
                continue;
            }

            $myarr['user_id'] = $user_id;
            $myarr['invoice_number'] = $this->input->post('invoice_number');
            $myarr['i_date'] = $date;
            $myarr['booking_date'] = $b_date;
            $myarr['tin'] = $this->input->post('customertin');
            $myarr['issue_id'] = $this->input->post('issue_id');
            $myarr['client_id'] = $this->input->post('save_clients');
            $myarr['model_id'] = $this->input->post('save_model');
            $myarr['headers'] = $data['headers'];
            $myarr['client'] = $this->input->post('client_name');
            $myarr['address1'] = $this->input->post('address1');
            $myarr['address2'] = $this->input->post('address2');
            $myarr['address3'] = $this->input->post('address3');
            $myarr['address4'] = $this->input->post('address4'); 
            $myarr['creation_date'] = $data['creation_date'];
            $this->db->insert('general_invoice',$myarr);
            $insert = 1;
        }  
        return $insert;
    }  


    public function get_user_general_invoive($limit){ 
        $limitStr = '';
        if($limit > 0){
            $limitStr = 'LIMIT 0, '.$limit;
        }

        $user_id = $this->user_id();
        $current_date = date('Y-m-d H:i:s');
        $sql = "SELECT id, invoice_number, issue_id, total_amount, creation_date FROM general_invoice WHERE status = 1 AND user_id = $user_id GROUP BY invoice_number ORDER BY id DESC $limitStr";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }


    public function client_list_invoice_data($client_id, $date_from, $date_to){ 
         
        $user_id = $this->user_id();
        $str = " status = 1 AND user_id = $user_id ";
        if(!empty($client_id)){
             $str .= " AND client_id = client_id ";
        }

        if(!empty($date_from) && !empty($date_to)){
            $str .= " AND (invoice_date >= '$date_from' AND invoice_date <= '$date_to') ";
        }

        $sql = "SELECT id, m_model_name, user_id, invoice_number, issue_id, invoice_date, apply_model_fee, IF(apply_model_fee = 1, model_budget, model_total_agreed) as model_budget, IF(m_ingermany = 1, m_vat_percent, 0) as m_vat_percent, model_agency_comission, IF(m_ingermany = 1, vat_price, 0) as vat_price, (SELECT SUM(IF(m_ingermany = 1 AND invoice_expense.vat_include = 1, ((invoice_expense.model_exp_amount) + ((invoice_expense.model_exp_amount * invoice_expense.vat_include )/100)), (invoice_expense.model_exp_amount))) FROM invoice_expense WHERE invoice_expense.invoice_number = invoice.invoice_number AND invoice_expense.status = 1) as modelExp, (SELECT SUM(IF(m_ingermany = 1 AND invoice_service.vat_include = 1, ((invoice_service.model_ser_amount) + ((invoice_service.model_ser_amount * invoice_service.vat_include )/100)), (invoice_service.model_ser_amount))) FROM invoice_service WHERE invoice_service.invoice_number = invoice.invoice_number AND invoice_service.status = 1) as selectInc,  IF(m_ingermany = 1 AND vat_price > 0, ((model_total_agreed*model_agency_comission)/100) + IF(vat_price > 0, (((model_total_agreed*model_agency_comission)/100) * vat_price )/ 100, 0), ((model_total_agreed*model_agency_comission)/100) ) as model_comission, creation_date FROM invoice WHERE $str GROUP BY invoice_number ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }


     public function general_invoices(){  

        $user_id = $this->user_id();
        $current_date = date('Y-m-d H:i:s');
        $sql = "SELECT DISTINCT i_date, booking_date, invoice_number, currency, currency_amount, total_amount, client, address1, issue_id, vat_percentage FROM general_invoice WHERE user_id = $user_id ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }


    public function generate_invoice_details($invoice_id){  

        $user_id = $this->user_id();
        $current_date = date('Y-m-d H:i:s');
        $sql = "SELECT * FROM general_invoice WHERE invoice_number = '$invoice_id'";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }



    public function client_details_pdf($client_id){  

        $user_id = $this->user_id();

        if(!empty($client_id)){
            $sql = "SELECT id, unique_code, company_name, client_fee, name, surname, address_line1, address_line2, pincode, city, country FROM client_management WHERE id = $client_id";
            $query = $this->db->query($sql);
            return $result = $query->row();
        }
        
    }



     public function create_deduction_transaction($model_id){  

        $user_id = $this->user_id();

        $sql = "SELECT de.*, m.unique_code, m.model_name, m.name as model_s_name, m.surname, de.name as expense_name, de.id, de.status, de.creation_date, de.modification_date FROM deduction_expenses de INNER JOIN model_management m ON de.model_id = m.unique_code WHERE de.user_id = $user_id AND de.model_id = '$model_id' AND de.status = 1 ORDER BY de.id DESc";
        $query = $this->db->query($sql);
        return $result = $query->result();        
    }



    public function save_deduction_transaction_data($deduction_attachment, $original_file_name)  {
        
        $user_id = $this->user_id();
        $model_id =  $this->input->post('deduction_model_id');

        $sql = "SELECT id, user_id, model_id, wallet FROM user_wallet WHERE user_id = $user_id AND model_id = '$model_id'";
        $query = $this->db->query($sql);
        $wallet_tr = $query->row(); 

        if(empty($wallet_tr)){
            $wallet_i = array(
                'user_id' => $user_id,
                'model_id' => $model_id,
                'wallet' => 0,
                'creation_date' => date('Y-m-d H:i:s'),
                'modification_date' => date('Y-m-d H:i:s'),
            );
            $this->db->insert('user_wallet', $wallet_i);

            $sql = "SELECT id, user_id, model_id, wallet FROM user_wallet WHERE user_id = $user_id AND model_id = '$model_id'";
            $query = $this->db->query($sql);
            $wallet_tr = $query->row(); 
        }


        $wall_amount = 0;

        $quantity = $this->input->post('d_expenses_quantity');
        $tr_amount = $this->input->post('d_expenses_amount');

        $tr_qty_amt =  $quantity * $tr_amount;

        
        
        if(!empty($wallet_tr)){
            $wall_amount = $wallet_tr->wallet;
        }

        $wall_amount_after = $wall_amount - $tr_amount;
        $sum_after_qty_amt =  $wall_amount - $tr_qty_amt;
  
        $array = array(
            'user_id' => $user_id, 
            'model_id' => $this->input->post('deduction_model_id'), 
            'name' => $this->input->post('d_expenses_name'), 
            'amount_before' => $wall_amount,
            'quantity' => $quantity,
            'amount' => $tr_amount,
            'sum_amount' => $tr_qty_amt,
            'amount_after' => $wall_amount_after,
            'sum_aftre_amount' => $sum_after_qty_amt,
            'attachment' => $deduction_attachment, 
            'filename' => $original_file_name, 
            'description' => $this->input->post('d_expenses_msg'),   
            'expense_date' => $this->input->post('d_expenses_date'),  
            'transaction_type' => 'DR',
            'status' => 1, 
            'creation_date' => date('Y-m-d H:i:s'), 
            'modification_date' => date('Y-m-d H:i:s'),
        );


        $wallet_amount = $wall_amount + $tr_qty_amt;
        $wallet = array(
            'wallet' => $wallet_amount,
            'modification_date' => date('Y-m-d H:i:s'),
        );
        $this->db->where('user_id', $user_id);
        $this->db->where('model_id', $model_id);
        $this->db->update('user_wallet', $wallet);

        return $this->db->insert('deduction_expenses',$array);
    }


    public function get_user_wallet($invoice_number){  

        $user_id = $this->user_id();

        $sql = "SELECT  uw.id, uw.user_id, uw.model_id, uw.wallet FROM user_wallet uw INNER JOIN model_management mm ON uw.model_id = mm.unique_code INNER JOIN invoice i ON i.model_id = mm.id WHERE uw.user_id = $user_id AND i.invoice_number = '$invoice_number'";
        $query = $this->db->query($sql);
        return $result = $query->row();
    }


     public function get_seLect_expenses($limit){
        $limitStr = '';
        if($limit > 0){
            $limitStr = 'LIMIT 0, '.$limit;
        }

        $user_id = $this->user_id();
        $current_date = date('Y-m-d H:i:s');
        $sql = "SELECT DISTINCT i.id, i.invoice_number, i.i_company_name, i.m_model_name, i.model_budget, i.model_total_agreed, i.m_vat_percent, i.model_agency_comission, i.vat_price, i.job_date, i.creation_date, i.approve, i.m_ingermany, (SELECT SUM(IF(m_ingermany = 1 AND invoice_expense.vat_include = 1, ((invoice_expense.model_exp_amount) + ((invoice_expense.model_exp_amount * invoice_expense.vat_include )/100)), (invoice_expense.model_exp_amount))) FROM invoice_expense WHERE invoice_expense.invoice_number = i.invoice_number AND invoice_expense.status = 1) as modelExp, (SELECT SUM(IF(m_ingermany = 1 AND invoice_service.vat_include = 1, ((invoice_service.model_ser_amount) + ((invoice_service.model_ser_amount * invoice_service.vat_include )/100)), (invoice_service.model_ser_amount))) FROM invoice_service WHERE invoice_number = i.invoice_number AND invoice_service.status = 1) as selectInc FROM invoice i LEFT JOIN invoice_service iss ON i.invoice_number = iss.invoice_number WHERE i.user_id = $user_id HAVING selectInc> 0 ORDER BY i.id DESC $limitStr";

        $query = $this->db->query($sql);
        return $result = $query->result();
    }



    public function get_payed_refund($limit){
        $limitStr = '';
        if($limit > 0){
            $limitStr = 'LIMIT 0, '.$limit;
        }

        $user_id = $this->user_id();
        $current_date = date('Y-m-d H:i:s');
        $sql = "SELECT DISTINCT i.id, i.invoice_number, i.i_company_name, i.m_model_name, i.model_budget, i.model_total_agreed, i.m_vat_percent, i.model_agency_comission, i.vat_price, i.job_date, i.creation_date, i.approve, i.m_ingermany, (SELECT SUM(IF(m_ingermany = 1 AND invoice_expense.vat_include = 1, ((invoice_expense.model_exp_amount) + ((invoice_expense.model_exp_amount * invoice_expense.vat_include )/100)), (invoice_expense.model_exp_amount))) FROM invoice_expense WHERE invoice_expense.invoice_number = i.invoice_number AND invoice_expense.status = 1) as modelExp, (SELECT SUM(IF(m_ingermany = 1 AND invoice_service.vat_include = 1, ((invoice_service.model_ser_amount) + ((invoice_service.model_ser_amount * invoice_service.vat_include )/100)), (invoice_service.model_ser_amount))) FROM invoice_service WHERE invoice_number = i.invoice_number AND invoice_service.status = 1) as selectInc FROM invoice i INNER JOIN invoice_service iss ON i.invoice_number = iss.invoice_number WHERE iss.status = 0 AND user_id = $user_id ORDER BY i.id DESC $limitStr";

        $query = $this->db->query($sql);
        return $result = $query->result();
    }



    // -----------------------------------------------



    public function get_collected_last_month_vat($limit){

        $start_date = date('Y-m-d', strtotime('first day of last month'));
        $end_date =  date('Y-m-d', strtotime('last day of last month'));

        $limitStr = '';
        if($limit > 0){
            $limitStr = 'LIMIT 0, '.$limit;
        }

        $user_id = $this->user_id();
        $sql = "SELECT id, invoice_number, i_company_name, m_model_name, model_budget, model_total_agreed, m_vat_percent, model_agency_comission, vat_price, job_date, creation_date, m_ingermany, (SELECT SUM(IF(m_ingermany = 1 AND invoice_expense.vat_include = 1, ((invoice_expense.model_exp_amount) + ((invoice_expense.model_exp_amount * invoice_expense.vat_include )/100)), (invoice_expense.model_exp_amount))) FROM invoice_expense WHERE invoice_expense.invoice_number = invoice.invoice_number AND invoice_expense.status = 1) as modelExp, (SELECT SUM(IF(m_ingermany = 1 AND invoice_service.vat_include = 1, ((invoice_service.model_ser_amount) + ((invoice_service.model_ser_amount * invoice_service.vat_include )/100)), (invoice_service.model_ser_amount))) FROM invoice_service WHERE invoice_service.invoice_number = invoice.invoice_number AND invoice_service.status = 1) as selectInc, IF(m_ingermany = 1 AND vat_price > 0, ((model_total_agreed*model_agency_comission)/100) + IF(vat_price > 0, (((model_total_agreed*model_agency_comission)/100) * vat_price )/ 100, 0), ((model_total_agreed*model_agency_comission)/100) ) as model_comission  FROM invoice WHERE m_ingermany = 1 AND  vat_price > 0  AND user_id = $user_id AND status = 1 AND (creation_date >= '$start_date' AND creation_date <= '$end_date') ORDER BY id DESC $limitStr ";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }


     public function get_collected_net($limit){

        $start_date = date('Y-m-d', strtotime('first day of last month'));
        $end_date =  date('Y-m-d', strtotime('last day of last month'));

        $limitStr = '';
        if($limit > 0){
            $limitStr = 'LIMIT 0, '.$limit;
        }

        $user_id = $this->user_id();
        $sql = "SELECT id, invoice_number, i_company_name, m_model_name, model_budget, model_total_agreed, m_vat_percent, model_agency_comission, vat_price, job_date, creation_date, m_ingermany, (SELECT SUM(IF(m_ingermany = 1 AND invoice_expense.vat_include = 1, ((invoice_expense.model_exp_amount) + ((invoice_expense.model_exp_amount * invoice_expense.vat_include )/100)), (invoice_expense.model_exp_amount))) FROM invoice_expense WHERE invoice_expense.invoice_number = invoice.invoice_number AND invoice_expense.status = 1) as modelExp, (SELECT SUM(IF(m_ingermany = 1 AND invoice_service.vat_include = 1, ((invoice_service.model_ser_amount) + ((invoice_service.model_ser_amount * invoice_service.vat_include )/100)), (invoice_service.model_ser_amount))) FROM invoice_service WHERE invoice_service.invoice_number = invoice.invoice_number AND invoice_service.status = 1) as selectInc, IF(m_ingermany = 1 AND vat_price > 0, ((model_total_agreed*model_agency_comission)/100) + IF(vat_price > 0, (((model_total_agreed*model_agency_comission)/100) * vat_price )/ 100, 0), ((model_total_agreed*model_agency_comission)/100) ) as model_comission  FROM invoice WHERE user_id = $user_id AND status = 1 ORDER BY id DESC $limitStr ";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }

    public function get_collected_vat($limit){

        $start_date = date('Y-m-d', strtotime('first day of last month'));
        $end_date =  date('Y-m-d', strtotime('last day of last month'));

        $limitStr = '';
        if($limit > 0){
            $limitStr = 'LIMIT 0, '.$limit;
        }

        $user_id = $this->user_id();
        $sql = "SELECT id, invoice_number, i_company_name, m_model_name, model_budget, model_total_agreed, m_vat_percent, model_agency_comission, vat_price, job_date, creation_date, m_ingermany, (SELECT SUM(IF(m_ingermany = 1 AND invoice_expense.vat_include = 1, ((invoice_expense.model_exp_amount) + ((invoice_expense.model_exp_amount * invoice_expense.vat_include )/100)), (invoice_expense.model_exp_amount))) FROM invoice_expense WHERE invoice_expense.invoice_number = invoice.invoice_number AND invoice_expense.status = 1) as modelExp, (SELECT SUM(IF(m_ingermany = 1 AND invoice_service.vat_include = 1, ((invoice_service.model_ser_amount) + ((invoice_service.model_ser_amount * invoice_service.vat_include )/100)), (invoice_service.model_ser_amount))) FROM invoice_service WHERE invoice_service.invoice_number = invoice.invoice_number AND invoice_service.status = 1) as selectInc, IF(m_ingermany = 1 AND vat_price > 0, ((model_total_agreed*model_agency_comission)/100) + IF(vat_price > 0, (((model_total_agreed*model_agency_comission)/100) * vat_price )/ 100, 0), ((model_total_agreed*model_agency_comission)/100) ) as model_comission  FROM invoice WHERE user_id = $user_id AND status = 1 ORDER BY id DESC $limitStr ";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }

     public function get_collected_invoice_last_no_vat($limit){

        $start_date = date('Y-m-d', strtotime('first day of last month'));
        $end_date =  date('Y-m-d', strtotime('last day of last month'));

        $limitStr = '';
        if($limit > 0){
            $limitStr = 'LIMIT 0, '.$limit;
        }

        $user_id = $this->user_id();
        $sql = "SELECT id, invoice_number, i_company_name, m_model_name, model_budget, model_total_agreed, m_vat_percent, model_agency_comission, vat_price, job_date, creation_date, m_ingermany, (SELECT SUM(IF(m_ingermany = 1 AND invoice_expense.vat_include = 1, ((invoice_expense.model_exp_amount) + ((invoice_expense.model_exp_amount * invoice_expense.vat_include )/100)), (invoice_expense.model_exp_amount))) FROM invoice_expense WHERE invoice_expense.invoice_number = invoice.invoice_number AND invoice_expense.status = 1) as modelExp, (SELECT SUM(IF(m_ingermany = 1 AND invoice_service.vat_include = 1, ((invoice_service.model_ser_amount) + ((invoice_service.model_ser_amount * invoice_service.vat_include )/100)), (invoice_service.model_ser_amount))) FROM invoice_service WHERE invoice_service.invoice_number = invoice.invoice_number AND invoice_service.status = 1) as selectInc, IF(m_ingermany = 1 AND vat_price > 0, ((model_total_agreed*model_agency_comission)/100) + IF(vat_price > 0, (((model_total_agreed*model_agency_comission)/100) * vat_price )/ 100, 0), ((model_total_agreed*model_agency_comission)/100) ) as model_comission  FROM invoice WHERE user_id = $user_id AND status = 1 ORDER BY id DESC $limitStr ";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }


    public function get_advances_on_behalf_of_mwm($limit){

        $start_date = date('Y-m-d', strtotime('first day of last month'));
        $end_date =  date('Y-m-d', strtotime('last day of last month'));

        $limitStr = '';
        if($limit > 0){
            $limitStr = 'LIMIT 0, '.$limit;
        }

        $user_id = $this->user_id();
        $sql = "SELECT id, invoice_number, i_company_name, m_model_name, model_budget, model_total_agreed, m_vat_percent, model_agency_comission, vat_price, job_date, creation_date, m_ingermany, (SELECT SUM(IF(m_ingermany = 1 AND invoice_expense.vat_include = 1, ((invoice_expense.model_exp_amount) + ((invoice_expense.model_exp_amount * invoice_expense.vat_include )/100)), (invoice_expense.model_exp_amount))) FROM invoice_expense WHERE invoice_expense.invoice_number = invoice.invoice_number AND invoice_expense.status = 1) as modelExp, (SELECT SUM(IF(m_ingermany = 1 AND invoice_service.vat_include = 1, ((invoice_service.model_ser_amount) + ((invoice_service.model_ser_amount * invoice_service.vat_include )/100)), (invoice_service.model_ser_amount))) FROM invoice_service WHERE invoice_service.invoice_number = invoice.invoice_number AND invoice_service.status = 1) as selectInc, IF(m_ingermany = 1 AND vat_price > 0, ((model_total_agreed*model_agency_comission)/100) + IF(vat_price > 0, (((model_total_agreed*model_agency_comission)/100) * vat_price )/ 100, 0), ((model_total_agreed*model_agency_comission)/100) ) as model_comission  FROM invoice WHERE user_id = $user_id AND status = 1 ORDER BY id DESC $limitStr ";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }



    public function get_model_management_list_deduction($search)  {
        
        $user_id = $this->user_id();

        $strfilter = '';

        if(!empty($search)){
            $search = '%'.strtolower(trim($search)).'%';
            $strfilter .= " AND (LOWER(model_name) LIKE '$search' || LOWER(name) LIKE '$search' || LOWER(surname) LIKE '$search' || LOWER(address_line1) LIKE '$search' || LOWER(address_line2) LIKE '$search' || LOWER(pincode) LIKE '$search' || LOWER(vat_tin_number) LIKE '$search' || LOWER(country) LIKE '$search' || LOWER(city) LIKE '$search') ";
        }

        $sql = "SELECT * FROM model_management WHERE user_id = $user_id $strfilter ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $result = $query->result();

    }



    public function get_select_income($limit)  {


        $limitStr = '';
        if($limit > 0){
            $limitStr = 'LIMIT 0, '.$limit;
        }
        
        $user_id = $this->user_id();

        $sql = "SELECT DISTINCT i.id, i.invoice_number, i.i_company_name, i.m_model_name, i.model_budget, i.model_total_agreed, i.m_vat_percent, i.model_agency_comission, i.vat_price, i.job_date, i.creation_date, i.m_ingermany, i.apply_model_fee, IF(i.id, 1,1) as etype, (SELECT SUM(model_ser_amount) FROM invoice_service WHERE invoice_number = i.invoice_number) as selectInc FROM invoice i INNER JOIN invoice_service iss ON i.invoice_number = iss.invoice_number WHERE i.user_id = $user_id ORDER BY id DESC $limitStr";
        $query = $this->db->query($sql);
        return $result = $query->result();

    }


    public function get_expenses($limit)  {

        $limitStr = '';
        if($limit > 0){
            $limitStr = 'LIMIT 0, '.$limit;
        }
        
        $user_id = $this->user_id();

        $sql = "SELECT DISTINCT i.id, i.invoice_number, i.i_company_name, i.m_model_name, i.model_budget, i.model_total_agreed, i.m_vat_percent, i.model_agency_comission, i.vat_price, i.job_date, i.creation_date, i.m_ingermany, i.apply_model_fee, IF(i.id, 2,2) as etype, (SELECT SUM(model_ser_amount) FROM invoice_service WHERE invoice_number = i.invoice_number) as selectInc FROM invoice i INNER JOIN invoice_expense iss ON i.invoice_number = iss.invoice_number WHERE i.user_id = $user_id ORDER BY id DESC $limitStr";
        $query = $this->db->query($sql);
        return $result = $query->result();

    }



     public function reports_select_income($invoice)  {
        
        $user_id = $this->user_id();

        $sql = "SELECT i.id, i.invoice_number, i.i_company_name, i.m_model_name, i.model_budget, i.model_total_agreed, i.m_vat_percent, i.model_agency_comission, i.vat_price, i.job_date, i.creation_date, i.m_ingermany, iss.invoice_number, iss.model_service, iss.vat_include, iss.vat_percent, iss.model_ser_amount, iss.creation_date FROM invoice i INNER JOIN invoice_service iss ON i.invoice_number = iss.invoice_number WHERE i.user_id = $user_id AND i.invoice_number = '$invoice'";
        $query = $this->db->query($sql);
        return $result = $query->result();

    }

    public function reports_expenses_overview($invoice)  {

        $user_id = $this->user_id();

        $sql = "SELECT DISTINCT i.id, i.invoice_number, i.i_company_name, i.m_model_name, i.model_budget, i.model_total_agreed, i.m_vat_percent, i.model_agency_comission, i.vat_price, i.job_date, i.creation_date, i.m_ingermany, iss.invoice_number, iss.model_expense, iss.vat_include, iss.vat_percent, iss.model_exp_amount, iss.creation_date FROM invoice i INNER JOIN invoice_expense iss ON i.invoice_number = iss.invoice_number WHERE i.user_id = $user_id AND i.invoice_number = '$invoice'";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }


    public function save_logo($image)  {
        $array = array( );
        if(!empty($image)){
            $array['logo'] = $image;
            $this->db->where('id', 1);
            return $this->db->update('settings',$array);
        }        
    }



    public function save_footer_contents()  {


        $selectname = $this->input->post('selectname');
        $address1 = $this->input->post('address1');
        $address2 = $this->input->post('address2');
        $address3 = $this->input->post('address3');
        $address4 = $this->input->post('address4');

        $array['content_text'] = $selectname;
        $this->db->where('id', 1);
        $p = $this->db->update('footer_contents',$array);


        for ($i=2; $i <= 5; $i++) { 
            $array['content_text'] = $this->input->post('address'.($i-1));
            $this->db->where('id', $i);
            $this->db->update('footer_contents',$array);
        }
        return $p;
    }
    
    
    public function collective_list_invoice_data($serchText, $date_from, $date_to){ 
         
        $user_id = $this->user_id();
        $str = " status = 1 AND user_id = $user_id ";
        // if(!empty($selected_invoices)){
            
        //     $inv = $selected_invoices;
        //      $str .= " AND invoice_number IN($inv) ";
        // }

        
        if(!empty($date_from) && !empty($date_to)){            
            $str .= " AND (invoice_date >= '$date_from' AND invoice_date <= '$date_to') ";
        }


        if(!empty($serchText)){
            $serchText = '%'.strtolower($serchText).'%';
            $str .= " AND (LOWER(i_company_name) LIKE '$serchText' || LOWER(invoice_number) LIKE '$serchText' || LOWER(m_model_name) LIKE '$serchText' || LOWER(i_surname) LIKE '$serchText' || LOWER(i_address_line1) LIKE '$serchText' || LOWER(m_name) LIKE '$serchText' || LOWER(m_surname) LIKE '$serchText' || LOWER(m_address_line1) LIKE '$serchText' || LOWER(m_country) LIKE '$serchText') ";
        }

        $sql = "SELECT id, job_date, i_company_name, m_model_name, user_id, invoice_number, issue_id, invoice_date, i_fee, apply_model_fee, IF(apply_model_fee = 1, model_budget, model_total_agreed) as model_budget, IF(m_ingermany = 1, m_vat_percent, 0) as m_vat_percent, model_agency_comission, IF(m_ingermany = 1, vat_price, 0) as vat_price, (SELECT SUM(IF(m_ingermany = 1 AND invoice_expense.vat_include = 1, ((invoice_expense.model_exp_amount) + ((invoice_expense.model_exp_amount * invoice_expense.vat_include )/100)), (invoice_expense.model_exp_amount))) FROM invoice_expense WHERE invoice_expense.invoice_number = invoice.invoice_number AND invoice_expense.status = 1) as modelExp, (SELECT SUM(IF(m_ingermany = 1 AND invoice_service.vat_include = 1, ((invoice_service.model_ser_amount) + ((invoice_service.model_ser_amount * invoice_service.vat_include )/100)), (invoice_service.model_ser_amount))) FROM invoice_service WHERE invoice_service.invoice_number = invoice.invoice_number AND invoice_service.status = 1) as selectInc,  IF(m_ingermany = 1 AND vat_price > 0, ((model_total_agreed*model_agency_comission)/100) + IF(vat_price > 0, (((model_total_agreed*model_agency_comission)/100) * vat_price )/ 100, 0), ((model_total_agreed*model_agency_comission)/100) ) as model_comission, creation_date, vat_price FROM invoice WHERE $str GROUP BY invoice_number ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }

    public function collective_list_invoice_data_pdf($selected_invoices){ 
         
        $user_id = $this->user_id();
        $str = " status = 1 AND user_id = $user_id ";
        if(!empty($selected_invoices)){
            
            $inv = "'".implode("','", $selected_invoices)."'";
             $str .= " AND invoice_number IN($inv) ";
        }

        $sql = "SELECT id, job_date, i_company_name, m_model_name, user_id, invoice_number, issue_id, invoice_date, i_fee, apply_model_fee, IF(apply_model_fee = 1, model_budget, model_total_agreed) as model_budget, IF(m_ingermany = 1, m_vat_percent, 0) as m_vat_percent, model_agency_comission, IF(m_ingermany = 1, vat_price, 0) as vat_price, (SELECT SUM(IF(m_ingermany = 1 AND invoice_expense.vat_include = 1, ((invoice_expense.model_exp_amount) + ((invoice_expense.model_exp_amount * invoice_expense.vat_include )/100)), (invoice_expense.model_exp_amount))) FROM invoice_expense WHERE invoice_expense.invoice_number = invoice.invoice_number AND invoice_expense.status = 1) as modelExp, (SELECT SUM(IF(m_ingermany = 1 AND invoice_service.vat_include = 1, ((invoice_service.model_ser_amount) + ((invoice_service.model_ser_amount * invoice_service.vat_include )/100)), (invoice_service.model_ser_amount))) FROM invoice_service WHERE invoice_service.invoice_number = invoice.invoice_number AND invoice_service.status = 1) as selectInc,  IF(m_ingermany = 1 AND vat_price > 0, ((model_total_agreed*model_agency_comission)/100) + IF(vat_price > 0, (((model_total_agreed*model_agency_comission)/100) * vat_price )/ 100, 0), ((model_total_agreed*model_agency_comission)/100) ) as model_comission, creation_date, vat_price FROM invoice WHERE $str GROUP BY invoice_number ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }


    public function validate_email($email, $empcode)  {
        $this->db->where('email', $email);
        $this->db->where('unique_code !=', $empcode);
        $this->db->select('*');
        $this->db->from('user');
        $query = $this->db->get();
        return $result = $query->row();     
    }


    public function user_management($role, $searchtext)  {
        
        $user_id = $this->user_id();

        $this->db->select('*');
        $this->db->from('user');        
        if(!empty($searchtext)) {
           $this->db->or_like(
                
                array(
                    'unique_code' => $searchtext, 
                    'name' => $searchtext, 
                    'redmine_username' => $searchtext,                     
                    'email' => $searchtext,
                )
            );
        }
        
        // $this->db->limit(25, 0);
        $this->db->where('redmine_assignee', $role);
        $this->db->order_by("id", "desc");
        return $this->db->get()->result();

    }



    public function save_user_profile() {

        $name = trim($this->input->post('name'));

        $tusername = $name;
        $tusername = str_replace(" ", "-", strtolower($tusername));
        $tusername = str_replace("@", "", strtolower($tusername));
        $tusername = str_replace("}", "", strtolower($tusername));
        $tusername = str_replace("{", "", strtolower($tusername));
        $tusername = str_replace("/", "", strtolower($tusername));
 
        $unique = 0;
        $inc = 0;
        $username = $tusername;
        while($unique == 0){
            $this->db->select('*')->from('user');
            $this->db->where('username', $tusername);
            $retdata = $this->db->get()->row();

            if(empty($retdata)){
                $username = $tusername;
                $unique = 1;
                break;
            }
            else{
                $tusername = $username.++$inc;
            }
        }

        $array = array(            
            'name' => $name,             
            'username' => $username,            
            'redmine_assignee' =>$this->input->post('assignee_role'),            
            'redmine_username' =>$this->input->post('runame'),            
            'redmine_password' =>$this->input->post('rupassword'),            
            'email' => $this->input->post('email'),
            'modification_date' => date('Y-m-d H:i:s') 
        );

        $this->db->where('unique_code', $this->input->post('empcode'));
        $profile = $this->db->update('user', $array);
        return $profile;
    }





    











}