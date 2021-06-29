<?php

if (!defined('BASEPATH')) {
    exit('No Direct Script access allowed');
}

class Admin_model extends CI_Model {
 
    function __construct() {
        parent::__construct();
    }

    public function get_user_id($uniqueid)  {
        $this->db->where('unique_code', $uniqueid);
        $this->db->select('*');
        $this->db->from('user');
        $query = $this->db->get();
        $result = $query->row(); 
        $id = 0;
        if(!empty($result)){
            $id = $result->id; 
        }
        return $id;   
    }
    

    public function dashboard() {
        
         
    }

    public function get_users($searchtext, $page = 0) {
        
        $this->db->select('*')->from('user');

        if(!empty($searchtext)){
           $this->db->or_like(
                array(
                    'name' => $searchtext, 
                    'redmine_username' => $searchtext, 
                    'email' => $searchtext, 
                    'phone' => $searchtext 
                )
            );
        }
        if($page > 0){
            $page = $page * 25;
        }
        $this->db->where('deleted', 0);
        $this->db->limit(25, $page);
        return $this->db->get()->result();
    }
 
    public function user_profile($user_code)  {
        $this->db->where('id', $this->get_user_id($user_code));
        $this->db->select('*');
        $this->db->from('user');
        $query = $this->db->get();
        return $result = $query->row();     
    }



    // -----


    public function user_clients($user_code, $searchtext, $page = 0) {
        
        $sql = "SELECT c.id, c.unique_code, c.company_name, c.client_fee, c.name, c.surname,  c.address_line1, c.pincode, c.city, c.vat_tin_number, c.email, c.telephone, c.mobile_no, c.kvat_percent, u.name as u_name, u.unique_code as user_code, u.email as u_email FROM  client_management c INNER JOIN user u ON u.id = c.user_id WHERE u.unique_code = '$user_code'";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }

    public function user_client_detail($client_code) {
        
        $sql = "SELECT c.*, u.name as u_name, u.unique_code as user_code, u.email as u_email FROM  client_management c INNER JOIN user u ON u.id = c.user_id WHERE c.unique_code = '$client_code'";
        $query = $this->db->query($sql);
        return $result = $query->row();
    }


    public function user_models($user_code, $searchtext, $page = 0) {
        
   
        $sql = "SELECT m.id, m.unique_code, m.model_name, m.service_fee, m.name, m.surname,  m.address_line1, m.pincode, m.city, m.vat_tin_number, m.email, m.telephone, m.mobile_no, m.kvat_percent, u.name as u_name, u.unique_code as user_code, u.email as u_email FROM  model_management m INNER JOIN user u ON u.id = m.user_id WHERE u.unique_code = '$user_code'";
        $query = $this->db->query($sql);
        return $result = $query->result();

        
    }
    public function user_model_detail($model_code) {
         
        $sql = "SELECT m.*, u.name as u_name, u.unique_code as user_code, u.email as u_email FROM  model_management m INNER JOIN user u ON u.id = m.user_id WHERE m.unique_code = '$model_code'";
        $query = $this->db->query($sql);
        return $result = $query->row();
    }


    public function user_invoices($user_code, $searchtext, $page = 0) {
        
        $sql = "SELECT i.id, i.user_id, i.client_id, c.company_name, c.client_fee, c.name as client_name, i.model_id, m.model_name, m.service_fee, i.issue_id, i.invoice_number, i.model_budget, i.model_total_agreed FROM  invoice i INNER JOIN user u ON u.id = i.user_id INNER JOIN client_management c ON c.id = i.client_id INNER JOIN model_management m ON m.id = i.model_id WHERE u.unique_code = '$user_code'";
        $query = $this->db->query($sql);
        return $result = $query->result();
        
    }


     public function invoices_for_approval($searchtext, $page = 0) {
        
        $sql = "SELECT i.id, i.user_id, u.name as user_name, u.username, u.unique_code, u.email as user_email, i.client_id, c.company_name, c.client_fee, c.name as client_name, i.model_id, m.model_name, m.service_fee, i.issue_id, i.invoice_number, i.model_budget, i.model_total_agreed FROM  invoice i INNER JOIN user u ON u.id = i.user_id INNER JOIN client_management c ON c.id = i.client_id INNER JOIN model_management m ON m.id = i.model_id WHERE i.approve = 2";
        $query = $this->db->query($sql);
        return $result = $query->result();
        
    }

     public function approve_user_invoice() {

        $invoive_id = $this->input->post('invoive_id');
        
        $array['approve'] = 1;
        $array['modification_date'] = date('Y-m-d H:i:s');

        $this->db->where('invoice_number', $invoive_id);
        return $this->db->update('invoice', $array);  
    }



    public function user_refund($user_code, $searchtext, $page = 0) {
        
        $sql = "SELECT i.id, i.user_id, i.client_id, c.company_name, c.client_fee, c.name as client_name, i.model_id, m.model_name, m.service_fee, i.issue_id, i.invoice_number, i.model_budget, i.model_total_agreed FROM  invoice i INNER JOIN user u ON u.id = i.user_id INNER JOIN client_management c ON c.id = i.client_id INNER JOIN model_management m ON m.id = i.model_id WHERE u.unique_code = '$user_code' AND (approve_refund = 1 || approve_refund = 2)";
        $query = $this->db->query($sql);
        return $result = $query->result();
        
    }

     public function refund_for_approval($searchtext, $page = 0) {
        
        $sql = "SELECT i.id, i.user_id, u.name as user_name, u.username, u.unique_code, u.email as user_email, i.client_id, c.company_name, c.client_fee, c.name as client_name, i.model_id, m.model_name, m.service_fee, i.issue_id, i.invoice_number, i.model_budget, i.model_total_agreed FROM  invoice i INNER JOIN user u ON u.id = i.user_id INNER JOIN client_management c ON c.id = i.client_id INNER JOIN model_management m ON m.id = i.model_id WHERE i.approve_refund = 2";
        $query = $this->db->query($sql);
        return $result = $query->result();
        
    }

     public function approve_user_refund() {

        $invoive_id = $this->input->post('invoive_id');
        
        $array['approve_refund'] = 1;
        $array['modification_date'] = date('Y-m-d H:i:s');

        $this->db->where('invoice_number', $invoive_id);
        return $this->db->update('invoice', $array);  
    }

































    // ================== 

    public function get_expert_detail($user_code)  {
        
        $user_id = $this->get_user_id($user_code);    
         
        $this->db->where('user_id', $user_id);
        $this->db->select('*');
        $this->db->from('experts_detail');
        $query = $this->db->get();
        return $result = $query->row();
    }

    public function get_expert_education($user_code)  {
        
        $user_id = $this->get_user_id($user_code);    
         
        $this->db->where('status', 1);
        $this->db->where('user_id', $user_id);
        $this->db->select('*');
        $this->db->from('experts_education');
        $query = $this->db->get();
        return $result = $query->result();
    }

    public function get_expert_employement_history($user_code)  {
        
        $user_id = $this->get_user_id($user_code);    
         
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 1);
        $this->db->select('*');
        $this->db->from('employment_history');
        $query = $this->db->get();
        return $result = $query->result();
    }

    public function get_expert_project($user_code)  {
        
        $user_id = $this->get_user_id($user_code);    
         
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 1);
        $this->db->select('*');
        $this->db->from('expert_project');
        $query = $this->db->get();
        return $result = $query->result();
    }


    public function get_expert_testimonials($user_code)  {
        
        $user_id = $this->get_user_id($user_code);    
         
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 1);
        $this->db->select('*');
        $this->db->from('expert_testimonials');
        $query = $this->db->get();
        return $result = $query->result();
    }

    public function get_expert_language($user_code)  {
        
        $user_id = $this->get_user_id($user_code);    
         
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 1);
        $this->db->select('*');
        $this->db->from('expert_language');
        $query = $this->db->get();
        return $result = $query->result();
    }


    // =================== Expert Profile End ===================


    // company profile

    public function get_company_details($user_code)  {
        $user_id = $this->get_user_id($user_code);
    //  $this->db->where('user_id', $this->get_user_id());
     //    $this->db->select('*');
        // $this->db->from('company');
        // $query = $this->db->get();
        // return $result = $query->row();
        $sql = "SELECT c.*, sum(pha.pay_amount) as spent_amount FROM company c LEFT JOIN pay_hire_amount pha ON c.user_id = pha.company_id WHERE c.user_id = $user_id";
        $query = $this->db->query($sql);
        return $result = $query->row();
    }





    public function users_enabled() {

        $id = $this->input->post('accountactiveusrid');
        $array['active'] = $this->input->post('accountactive');
        $array['modification_date'] = date('Y-m-d H:i:s');
        
        $this->db->where('id', $id);
        return $this->db->update('user', $array);
    }


    public function users_status() {

        $id = $this->input->post('accountstatususrid');
        $array['status'] = $this->input->post('accountstatus');
        $array['modification_date'] = date('Y-m-d H:i:s');
        
        $this->db->where('id', $id);
        return $this->db->update('user', $array);
    }


    public function save_users_profile($image){

        $name = $this->input->post('txtfname')."".$this->input->post('txtlname');
        $username = preg_replace('~[^\pL\d]+~u', '-', $name);
        // $username = iconv('utf-8', 'us-ascii//TRANSLIT', $username);
        $username = preg_replace('~[^-\w]+~', '', $username);
        $username = trim($username, '-');
        $username = preg_replace('~-+~', '-', $username);
        $username = strtolower($username);
        if (empty($username)) {
            $username = 'n-a';
        }

        $data = array(
            'fname' => $this->input->post('txtfname'),
            'lname' => $this->input->post('txtlname'),
            'username' => $username,
            'phone' => $this->input->post('txtcont1'),
            // 'email' => $this->input->post('txtemail'),
            // 'home_category' => implode(",", $this->input->post('categories')),
            'address' => $this->input->post('txtaddress'),
            'landmark' => $this->input->post('txtlandmark'),
            'city' => $this->input->post('txtcity'),
            'state' => $this->input->post('txtstate'),
            'country' => $this->input->post('txtcountry'),
            'zip' => $this->input->post('txtzip'),
            'modification_date' => date('y:m:d h:m:s')
        );
        if($image != ""){
            $data['image'] = $image;
        }
        $id = $this->input->post('txtuserid');
        $this->db->where('id', $id);
        $save = $this->db->update('user',$data);
        if(!empty($save)){
            return $username;
        }
        return "";
    }



    public function users_delete_account() {

        $id = $this->input->post('deleteusrid');        
        
        $msg = "error";

        $this->db->select('*')->from('user');
        $this->db->where('id', $id);
        $userdata = $this->db->get()->row();
        if(!empty($userdata)){
            $array['deleted'] = 1;
            $array['modification_date'] = date('Y-m-d H:i:s');
            $array['email'] = $userdata->email."#DELETED";

            $this->db->where('id', $id);
            $retmsg = $this->db->update('user', $array);
            if($retmsg > 0){
                $msg = "success";
            }
        }
        return $msg ;
    }


    public function users_approve_account() {

        $id = $this->input->post('approveusrid');        
        
        $msg = "error";

        $this->db->select('*')->from('user');
        $this->db->where('id', $id);
        $userdata = $this->db->get()->row();
        if(!empty($userdata)){
            $array['approvel'] = 1;
            $array['modification_date'] = date('Y-m-d H:i:s');

            $this->db->where('id', $id);
            $retmsg = $this->db->update('user', $array);
            if($retmsg > 0){
                $msg = "success";
            }
        }
        return $msg ;
    }


    // Application Area

     public function get_application_area($searchtext, $page = 0) {
        
        $this->db->select('*')->from('application_area');
        if(!empty($searchtext)){
           $this->db->or_like(
                array(
                    'name' => $searchtext
                )
            );
        }
        if($page > 0){
            $page = $page * 25;
        }
        
        $this->db->limit(25, $page);
        $this->db->where('status', 1);
        return $this->db->get()->result();
    }


    public function add_application_area() {

        $array['name'] = $this->input->post('txttitle');
        $array['creation_date'] = date('Y-m-d H:i:s');
        return $this->db->insert('application_area', $array);
    }

    public function save_application_area() {

        $id = $this->input->post('txeditid');
        $array['name'] = $this->input->post('txeditttitle');
        $array['creation_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('application_area', $array);
    }

    public function delete_application_area() {

        $id = $this->input->post('txtdelid');
        $array['status'] = 0;
        $array['creation_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('application_area', $array);
    }


    // physics experience

     public function get_physics_experience($searchtext, $page = 0) {
        
        $this->db->select('*')->from('physics_experience');
        if(!empty($searchtext)){
           $this->db->or_like(
                array(
                    'name' => $searchtext
                )
            );
        }
        if($page > 0){
            $page = $page * 25;
        }
        
        $this->db->limit(25, $page);
        $this->db->where('status', 1);
        return $this->db->get()->result();
    }


    public function add_physics_experience() {

        $array['name'] = $this->input->post('txttitle');
        $array['creation_date'] = date('Y-m-d H:i:s');
        return $this->db->insert('physics_experience', $array);
    }

    public function save_physics_experience() {

        $id = $this->input->post('txeditid');
        $array['name'] = $this->input->post('txeditttitle');
        $array['creation_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('physics_experience', $array);
    }

    public function delete_physics_experience() {

        $id = $this->input->post('txtdelid');
        $array['status'] = 0;
        $array['creation_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('physics_experience', $array);
    }


    // Project Length

     public function get_project_length($searchtext, $page = 0) {
        
        $this->db->select('*')->from('project_length');
        if(!empty($searchtext)){
           $this->db->or_like(
                array(
                    'name' => $searchtext
                )
            );
        }
        if($page > 0){
            $page = $page * 25;
        }
        
        $this->db->limit(25, $page);
        $this->db->where('status', 1);
        return $this->db->get()->result();
    }


    public function add_project_length() {

        $array['name'] = $this->input->post('txttitle');
        $array['creation_date'] = date('Y-m-d H:i:s');
        return $this->db->insert('project_length', $array);
    }

    public function save_project_length() {

        $id = $this->input->post('txeditid');
        $array['name'] = $this->input->post('txeditttitle');
        $array['creation_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('project_length', $array);
    }

    public function delete_project_length() {

        $id = $this->input->post('txtdelid');
        $array['status'] = 0;
        $array['creation_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('project_length', $array);
    }



    // project visibility

     public function get_project_visibility($searchtext, $page = 0) {
        
        $this->db->select('*')->from('project_visibility');
        if(!empty($searchtext)){
           $this->db->or_like(
                array(
                    'name' => $searchtext
                )
            );
        }
        if($page > 0){
            $page = $page * 25;
        }
        
        $this->db->limit(25, $page);
        $this->db->where('status', 1);
        return $this->db->get()->result();
    }


    public function add_project_visibility() {

        $array['name'] = $this->input->post('txttitle');
        $array['creation_date'] = date('Y-m-d H:i:s');
        return $this->db->insert('project_visibility', $array);
    }

    public function save_project_visibility() {

        $id = $this->input->post('txeditid');
        $array['name'] = $this->input->post('txeditttitle');
        $array['creation_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('project_visibility', $array);
    }

    public function delete_project_visibility() {

        $id = $this->input->post('txtdelid');
        $array['status'] = 0;
        $array['creation_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('project_visibility', $array);
    }



    // research development experience

     public function get_research_development_experience($searchtext, $page = 0) {
        
        $this->db->select('*')->from('research_development_experience');
        if(!empty($searchtext)){
           $this->db->or_like(
                array(
                    'name' => $searchtext
                )
            );
        }
        if($page > 0){
            $page = $page * 25;
        }
        
        $this->db->limit(25, $page);
        $this->db->where('status', 1);
        return $this->db->get()->result();
    }


    public function add_research_development_experience() {

        $array['name'] = $this->input->post('txttitle');
        $array['creation_date'] = date('Y-m-d H:i:s');
        return $this->db->insert('research_development_experience', $array);
    }

    public function save_research_development_experience() {

        $id = $this->input->post('txeditid');
        $array['name'] = $this->input->post('txeditttitle');
        $array['creation_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('research_development_experience', $array);
    }

    public function delete_research_development_experience() {

        $id = $this->input->post('txtdelid');
        $array['status'] = 0;
        $array['creation_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('research_development_experience', $array);
    }



    // simulations experience

     public function get_simulations_experience($searchtext, $page = 0) {
        
        $this->db->select('*')->from('simulations_experience');
        if(!empty($searchtext)){
           $this->db->or_like(
                array(
                    'name' => $searchtext
                )
            );
        }
        if($page > 0){
            $page = $page * 25;
        }
        
        $this->db->limit(25, $page);
        $this->db->where('status', 1);
        return $this->db->get()->result();
    }


    public function add_simulations_experience() {

        $array['name'] = $this->input->post('txttitle');
        $array['creation_date'] = date('Y-m-d H:i:s');
        return $this->db->insert('simulations_experience', $array);
    }

    public function save_simulations_experience() {

        $id = $this->input->post('txeditid');
        $array['name'] = $this->input->post('txeditttitle');
        $array['creation_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('simulations_experience', $array);
    }

    public function delete_simulations_experience() {

        $id = $this->input->post('txtdelid');
        $array['status'] = 0;
        $array['creation_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('simulations_experience', $array);
    }



    // simulations experience

    public function get_software_experience($searchtext, $page = 0) {
        
        $this->db->select('*')->from('software_experience');
        if(!empty($searchtext)){
           $this->db->or_like(
                array(
                    'name' => $searchtext
                )
            );
        }
        if($page > 0){
            $page = $page * 25;
        }
        
        $this->db->limit(25, $page);
        $this->db->where('status', 1);
        return $this->db->get()->result();
    }


    public function add_software_experience() {

        $array['name'] = $this->input->post('txttitle');
        $array['creation_date'] = date('Y-m-d H:i:s');
        return $this->db->insert('software_experience', $array);
    }

    public function save_software_experience() {

        $id = $this->input->post('txeditid');
        $array['name'] = $this->input->post('txeditttitle');
        $array['creation_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('software_experience', $array);
    }

    public function delete_software_experience() {

        $id = $this->input->post('txtdelid');
        $array['status'] = 0;
        $array['creation_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('software_experience', $array);
    }

    // Soft Skill 

    public function get_soft_skill($searchtext, $page = 0) {
        
        $this->db->select('*')->from('soft_skill');
        if(!empty($searchtext)){
           $this->db->or_like(
                array(
                    'name' => $searchtext
                )
            );
        }
        if($page > 0){
            $page = $page * 25;
        }
        
        $this->db->limit(25, $page);
        $this->db->where('status', 1);
        return $this->db->get()->result();
    }


    public function add_soft_skill() {

        $array['name'] = $this->input->post('txttitle');
        $array['creation_date'] = date('Y-m-d H:i:s');
        return $this->db->insert('soft_skill', $array);
    }

    public function save_soft_skill() {

        $id = $this->input->post('txeditid');
        $array['name'] = $this->input->post('txeditttitle');
        $array['creation_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('soft_skill', $array);
    }

    public function delete_soft_skill() {

        $id = $this->input->post('txtdelid');
        $array['status'] = 0;
        $array['creation_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('soft_skill', $array);
    }


    // Soft Skill 

    public function get_timezone($searchtext, $page = 0) {
        
        $this->db->select('*')->from('timezone');
        if(!empty($searchtext)){
           $this->db->or_like(
                array(
                    'name' => $searchtext
                )
            );
        }
        if($page > 0){
            $page = $page * 25;
        }
        
        // $this->db->limit(25, $page);
        $this->db->where('status', 1);
        return $this->db->get()->result();
    }


    public function add_timezone() {

        $array['name'] = $this->input->post('txttitle');
        $array['creation_date'] = date('Y-m-d H:i:s');
        return $this->db->insert('timezone', $array);
    }

    public function save_timezone() {

        $id = $this->input->post('txeditid');
        $array['name'] = $this->input->post('txeditttitle');
        $array['creation_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('timezone', $array);
    }

    public function delete_timezone() {

        $id = $this->input->post('txtdelid');
        $array['status'] = 0;
        $array['creation_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('timezone', $array);
    }


     // Soft Skill 

    public function get_industry($searchtext, $page = 0) {
        
        $this->db->select('*')->from('type_of_industry');
        if(!empty($searchtext)){
           $this->db->or_like(
                array(
                    'name' => $searchtext
                )
            );
        }
        if($page > 0){
            $page = $page * 25;
        }
        
        // $this->db->limit(25, $page);
        $this->db->where('status', 1);
        return $this->db->get()->result();
    }


    public function add_industry() {

        $array['name'] = $this->input->post('txttitle');
        $array['creation_date'] = date('Y-m-d H:i:s');
        return $this->db->insert('type_of_industry', $array);
    }

    public function save_industry() {

        $id = $this->input->post('txeditid');
        $array['name'] = $this->input->post('txeditttitle');
        $array['creation_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('type_of_industry', $array);
    }

    public function delete_industry() {

        $id = $this->input->post('txtdelid');
        $array['status'] = 0;
        $array['creation_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('type_of_industry', $array);
    }


    // Type of work

    public function get_work($searchtext, $page = 0) {
        
        $this->db->select('*')->from('type_of_work');
        if(!empty($searchtext)){
           $this->db->or_like(
                array(
                    'name' => $searchtext
                )
            );
        }
        if($page > 0){
            $page = $page * 25;
        }
        
        // $this->db->limit(25, $page);
        $this->db->where('status', 1);
        return $this->db->get()->result();
    }


    public function add_work() {

        $array['name'] = $this->input->post('txttitle');
        $array['creation_date'] = date('Y-m-d H:i:s');
        return $this->db->insert('type_of_work', $array);
    }

    public function save_work() {

        $id = $this->input->post('txeditid');
        $array['name'] = $this->input->post('txeditttitle');
        $array['creation_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('type_of_work', $array);
    }

    public function delete_work() {

        $id = $this->input->post('txtdelid');
        $array['status'] = 0;
        $array['creation_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('type_of_work', $array);
    }


    // Language

    public function get_language($searchtext, $page = 0) {
        
        $this->db->select('*')->from('language');
        if(!empty($searchtext)){
           $this->db->or_like(
                array(
                    'name' => $searchtext
                )
            );
        }
        if($page > 0){
            $page = $page * 25;
        }
        
        // $this->db->limit(25, $page);
        $this->db->where('status', 1);
        return $this->db->get()->result();
    }


    public function add_language() {

        $array['name'] = $this->input->post('txttitle');
        $array['creation_date'] = date('Y-m-d H:i:s');
        return $this->db->insert('language', $array);
    }

    public function save_language() {

        $id = $this->input->post('txeditid');
        $array['name'] = $this->input->post('txeditttitle');
        $array['creation_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('language', $array);
    }

    public function delete_language() {

        $id = $this->input->post('txtdelid');
        $array['status'] = 0;
        $array['creation_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('language', $array);
    }



    // Language Proficiency

    public function get_language_proficiency($searchtext, $page = 0) {
        
        $this->db->select('*')->from('language_proficiency');
        if(!empty($searchtext)){
           $this->db->or_like(
                array(
                    'name' => $searchtext
                )
            );
        }
        if($page > 0){
            $page = $page * 25;
        }
        
        // $this->db->limit(25, $page);
        $this->db->where('status', 1);
        return $this->db->get()->result();
    }


    public function add_language_proficiency() {

        $array['name'] = $this->input->post('txttitle');
        $array['creation_date'] = date('Y-m-d H:i:s');
        return $this->db->insert('language_proficiency', $array);
    }

    public function save_language_proficiency() {

        $id = $this->input->post('txeditid');
        $array['name'] = $this->input->post('txeditttitle');
        $array['creation_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('language_proficiency', $array);
    }

    public function delete_language_proficiency() {

        $id = $this->input->post('txtdelid');
        $array['status'] = 0;
        $array['creation_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('language_proficiency', $array);
    }



    // Language

    public function get_degree($searchtext, $page = 0) {
        
        $this->db->select('*')->from('degree');
        if(!empty($searchtext)){
           $this->db->or_like(
                array(
                    'name' => $searchtext
                )
            );
        }
        if($page > 0){
            $page = $page * 25;
        }
        
        // $this->db->limit(25, $page);
        $this->db->where('status', 1);
        return $this->db->get()->result();
    }


    public function add_degree() {

        $array['name'] = $this->input->post('txttitle');
        $array['creation_date'] = date('Y-m-d H:i:s');
        return $this->db->insert('degree', $array);
    }

    public function save_degree() {

        $id = $this->input->post('txeditid');
        $array['name'] = $this->input->post('txeditttitle');
        $array['creation_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('degree', $array);
    }

    public function delete_degree() {

        $id = $this->input->post('txtdelid');
        $array['status'] = 0;
        $array['creation_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('degree', $array);
    }

    public function paanduv_test_link() {

        // $id = $this->input->post('txeditid');
        $array['test_link'] = $this->input->post('txeditttitle');
        $array['test_text'] = $this->input->post('testtext');
        $array['creation_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', 1);
        return $this->db->update('admin', $array);
    }


     public function paanduv_test_pass_mark() {

        $id = $this->input->post('testuserid');
        
        $array['test_pass'] = 1;
        $array['modification_date'] = date('Y-m-d H:i:s');
        
        $this->db->where('id', $id);
        return $this->db->update('user', $array);
    }

    public function save_paanduv_service_fee() {
        // $id = $this->input->post('txeditid');
        $array['service_fee'] = $this->input->post('txeditttitle');
        $array['creation_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', 1);
        return $this->db->update('admin', $array);
    }


    // =======================

     public function get_employer_membership() {
        
        $this->db->select('*')->from('company_membership');
        $this->db->where('status', 1);
        return $this->db->get()->result();
    }

    public function add_employer_membership_plan() {
        
        $array['membership_name'] = $this->input->post('txtmembershipname');
        $array['max_project'] = $this->input->post('txtmax_project');
        $array['price'] = $this->input->post('txtprice');
        $array['percentage_off'] = $this->input->post('txtoff');
        $array['final_report'] = $this->input->post('txtfinal_report');
        $array['status'] = 1;
        $array['creation_date'] = date('Y-m-d H:i:s');
        $array['modification_date'] = date('Y-m-d H:i:s');

        return $this->db->insert('company_membership', $array);
    }

    public function save_employer_membership_plan() {

        $id = $this->input->post('txeditid');

        $unlimited_posted_project = (int)$this->input->post('chkunltpostedpro');
        $unlimited_final_report = (int)$this->input->post('chkunltfinalreport');
        $unlimited_service_fee = (int)$this->input->post('chkunltoff');

        $max_posted_project = $this->input->post('txeditmax_project');
        if($unlimited_posted_project == -1){
           $max_posted_project = -1;
        }

        $max_final_report =  $this->input->post('txteditfinal_report');
        if($unlimited_final_report == -1){
            $max_final_report = -1;
        }

        $max_service_fee = $this->input->post('txeditoff');
        if($unlimited_service_fee == -1){
           $max_service_fee = -1;
        }


        $array['membership_name'] = $this->input->post('txteditmembershipname');
        $array['max_project'] = $max_posted_project;
        $array['price'] = $this->input->post('txeditprice');
        $array['percentage_off'] = $max_service_fee;
        $array['final_report'] = $max_final_report;
        $array['modification_date'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id);
        return $this->db->update('company_membership', $array);
    }

    public function delete_employer_membership_plan() {

        $id = $this->input->post('txtdelid');
        $array['status'] = 0;
        $array['modification_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('company_membership', $array);
    }



    public function get_expert_membership_plan() {
        
        $this->db->select('*')->from('expert_membership');
        $this->db->where('status', 1);
        return $this->db->get()->result();
    }


    public function add_expert_membership_plan() {
        
        $array['membership_name'] = $this->input->post('txtmembershipname');
        $array['max_project'] = $this->input->post('txtmax_project');
        $array['price'] = $this->input->post('txtprice');
        $array['purchase_bid_price'] = $this->input->post('txtbidspurchaseprice');
        $array['status'] = 1;
        $array['creation_date'] = date('Y-m-d H:i:s');
        $array['modification_date'] = date('Y-m-d H:i:s');

        return $this->db->insert('expert_membership', $array);
    }

    public function save_expert_membership_plan() {

        $id = $this->input->post('txeditid');

        $unlimited_posted_project = (int)$this->input->post('chkunltpostedpro');
        $unlimited_purchase_bids = (int)$this->input->post('chkadditionalbits');

        $max_posted_project = $this->input->post('txeditmax_project');
        if($unlimited_posted_project == -1){
           $max_posted_project = -1;
        }

        $max_purchse_bits = $this->input->post('txteditbidspurchaseprice');
        if($unlimited_purchase_bids == -1){
           $max_purchse_bits = -1;
        }

        $array['membership_name'] = $this->input->post('txteditmembershipname');
        $array['max_project'] = $max_posted_project;
        $array['price'] = $this->input->post('txeditprice');
        $array['purchase_bid_price'] = $max_purchse_bits;
        $array['modification_date'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id);
        return $this->db->update('expert_membership', $array);
    }

    public function delete_expert_membership_plan() {

        $id = $this->input->post('txtdelid');
        $array['status'] = 0;
        $array['modification_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('expert_membership', $array);
    }



    // =================== Transaction History ==========================


    public function get_transaction_history($user_code)  {
        $user_id = $this->get_user_id($user_code);
        $sql = "SELECT pmp.txn_id, pmp.mc_currency, pmp.payment_gross, pmp.payment_status, pmp.creation_date, bm.id, bm.type, bm.purchase_hour, bm.paid, bm.amount, p.project_code, p.title, p.slug, eaj.user_id as expert_id, eaj.service_fee, bm.id as milestone_id, bm.admin_paid, bm.milestone_status  FROM project_milestone_payment pmp INNER JOIN budget_milestone bm ON bm.id = pmp.milestone_id INNER JOIN project p ON bm.project_id = p.id INNER JOIN user u ON u.id = p.user_id INNER JOIN expert_applied_job eaj  ON eaj.project_id = bm.project_id WHERE u.unique_code = '$user_code'";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }

    public function profile_for_payout()  {
        $user_id = $this->input->post('expert_id');
        $type = $this->input->post('type');

        $sql = '';
        if($type == 0){
            $sql = "SELECT id, name, last_name, unique_code, email, paypal_username FROM user WHERE id = $user_id";
        }
        if($type == 1){
            $sql = "SELECT u.id, u.name, u.last_name, u.unique_code, u.email, bd.name as bank_name, bd.account_no, bd.ifsc FROM user u INNER JOIN bank_details bd ON u.id = bd.user_id where u.id = $user_id";
        }
        $query = $this->db->query($sql);
        return $result = $query->row();
    }

    
    public function usd_payout_transfer() {
        
        $milestone_id = $this->input->post('txtmilestoneid');

        $this->db->where('id', $milestone_id);
        $this->db->where('admin_paid', 1);
        $this->db->select('*')->from('budget_milestone');
        $result = $this->db->get()->row();
        if(!empty($result)){
            return 'paid';
        }

        
        $array['admin_paid'] = 1;
        $array['service_fees'] = $this->input->post('txtservicefee');
        $array['paypal_id'] = $this->input->post('txtpaypalid');
        $array['bank_ref_no'] = $this->input->post('txtbnrefno');
        $array['expert_fee'] = $this->input->post('txtexpertamount');
        $array['release_date'] = date('Y-m-d H:i:s');
        $array['modification_date'] = date('Y-m-d H:i:s');

        $this->db->where('id', $milestone_id );
        $save = $this->db->update('budget_milestone', $array);
        if($save){
            return 'success';
        }
        return 'error';
    }


    public function inr_payout_transfer() {
        
        $milestone_id = $this->input->post('txtmilestoneidinr');

        $this->db->where('id', $milestone_id);
        $this->db->where('admin_paid', 1);
        $this->db->select('*')->from('budget_milestone');
        $result = $this->db->get()->row();
        if(!empty($result)){
            return 'paid';
        }
        
        $array['admin_paid'] = 1;
        $array['service_fees'] = $this->input->post('txtservicefeeinr');
        $array['paypal_id'] = $this->input->post('txtacountnoinr');
        $array['ifsc_code'] = $this->input->post('txtifsccodeinr');
        $array['bank_name'] = $this->input->post('txtbanknameinr');
        $array['bank_ref_no'] = time();
        $array['expert_fee'] = $this->input->post('txtexpertamountinr');
        $array['release_date'] = date('Y-m-d H:i:s');
        $array['modification_date'] = date('Y-m-d H:i:s');

        $this->db->where('id', $milestone_id );
        $save = $this->db->update('budget_milestone', $array);
        if($save){
            return 'success';
        }
        return 'error';
    }



    // ==================== Home Contents =====================

    public function get_home_banner()  {
        $this->db->where('id', 1);
        $this->db->select('*');
        $this->db->from('home_banner');
        $query = $this->db->get();
        return $result = $query->row(); 
    }


     public function save_home_banner($image) {
      
        $array['title'] = $this->input->post('txttitle');
        $array['description'] = $this->input->post('txtdescription');
        $array['btn1'] = $this->input->post('txtbtn1text');
        $array['btn2'] = $this->input->post('txtbtn2text');
        if(!empty($image)){
            $array['image'] = $image;
        }

        $this->db->where('id', 1);
        return $this->db->update('home_banner', $array);
    }


    public function get_meet_the_talents() {
        
        $sql = "SELECT u.id, u.name, u.last_name, u.unique_code, u.username, u.test_pass, ed.application_area, ed.simulations_experience, ed.software_experience, ed.research_development_experience, ed.physics_experience, ed.soft_skill, ed.title as designation FROM user u INNER JOIN experts_detail ed ON u.id = ed.user_id where u.user = 1";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }

    public function save_talent_selection() {
      
        $array['featured_experts'] = $this->input->post('txttitle');
        $array['selected_experts'] = '';
        if(!empty($this->input->post('expertschkbox'))){ 
            $array['selected_experts'] = implode(",", $this->input->post('expertschkbox'));
        }

        $this->db->where('id', 1);
        return $this->db->update('page_settings', $array);
    }


    public function get_how_we_work()  {
        $this->db->where('id', 1);
        $this->db->select('*');
        $this->db->from('how_we_work');
        $query = $this->db->get();
        return $result = $query->row(); 
    }

    public function save_how_we_work($image1, $image2) {
  
        $array['main_title'] = $this->input->post('main_title');
        $array['title1'] = $this->input->post('title1');
        $array['title2'] = $this->input->post('title2');
         
        if(!empty($image1)){
            $array['image1'] = $image1;
        }
        if(!empty($image2)){
            $array['image2'] = $image2;
        }

        $this->db->where('id', 1);
        return $this->db->update('how_we_work', $array);
    }

    // ------------------------------

    public function save_whychoose_title(){
        $pagetitle = $this->input->post('txtpagetitle');
         
        $array = array(
            'whychoose_title' => $pagetitle
        );
        $this->db->where('id', 1);
        return $this->db->update('page_settings', $array);
    }

     public function get_why_choose()  {
        $this->db->where('status', 1);
        $this->db->select('*');
        $this->db->from('why_choose');
        $query = $this->db->get();
        return $result = $query->result(); 
    }

     public function get_why_choose_detail()  {
        $this->db->where('choose_code', $this->input->post('whychoose_code'));
        $this->db->select('*');
        $this->db->from('why_choose');
        $query = $this->db->get();
        return $result = $query->row(); 
    }

    public function save_why_choose($image) {

        $choose_code = $this->input->post('txtchoosecode');
  
        $array['title'] = $this->input->post('txttitle');
        $array['description'] = $this->input->post('txtdescription');
        // $array['image'] = $this->input->post('title2');
        $array['creation_date'] = date('Y-m-d H:i:s');
        $array['modification_date'] = date('Y-m-d H:i:s');
 
        if(!empty($image)){
            $array['image'] = $image;
        } 
        $this->db->where('choose_code', $choose_code);
        return $this->db->update('why_choose', $array);
    }


    public function save_map_title(){
        $pagetitle = $this->input->post('txtpagetitle');
         
        $array = array(
            'map_title' => $pagetitle
        );
        $this->db->where('id', 1);
        return $this->db->update('page_settings', $array);
    }


    public function save_project_setings($image) {

        $array = array(
            'title1' => $this->input->post('applications'),
            'title2' => $this->input->post('industry'),
            'title3' => $this->input->post('simulations'),
            'title4' => $this->input->post('software'),
            'title5' => $this->input->post('research'),
            'title6' => $this->input->post('physics'),
            'title7' => $this->input->post('skill'),
            'exchange_rate' => $this->input->post('txtinrrate'),
        );
     
        if(!empty($image)){
            $array['logo'] = $image;
        } 

        $sarray = array(
            'service_fee' => $this->input->post('txtservicefeeinr'),
            'service_fee_other' => $this->input->post('txtservicefeeusd')
        );
        $this->db->where('id', 1);
        $this->db->update('admin', $sarray);

        $this->db->where('id', 1);
        return $this->db->update('page_settings', $array);
    }

     public function get_newsletters_subscription() {
        
        $this->db->select('*')->from('user');
        $this->db->where('deleted', 0);
        $this->db->where('newsletter', 1);
        $this->db->where('status', 1);
        
       
        return $this->db->get()->result();
    }
































































    //  public function get_user_car_list($uniqueid){
    //     $user_id = $this->input->post('user_id');
    //     //  user_id, category_id, brand, model, year, number_plate, chassis_number 
    //     $sql = "SELECT c.id, c.user_id, u.fname, u.lname, u.username, u.unique_code, u.email, u.phone, c.category_id, ct.name as category_name, c.brand, b.name as brand_name, c.model, m.name as model_name, year, y.name as year_series, c.number_plate, c.chassis_number FROM user u INNER JOIN cars c on u.id = c.user_id INNER JOIN car_info b ON c.brand = b.id INNER JOIN car_info m ON c.model = m.id INNER JOIN car_info y ON c.year = y.id INNER JOIN category ct ON c.category_id = ct.id WHERE u.unique_code = '$uniqueid' AND c.status = 1";
    //     $query = $this->db->query($sql);
    //     return $result = $query->result(); 
    // }


    // public function delete_user_car() {

    //     $id = $this->input->post('deletcarid');        
        
    //     $msg = "error";

    //     $array['status'] = 0;
    //     $array['modification_date'] = date('Y-m-d H:i:s');

    //     $this->db->where('id', $id);
    //     $retmsg = $this->db->update('cars', $array);
    //     if($retmsg > 0){
    //         $msg = "success";
    //     }
    //     return $msg;
    // }


    // public function get_categories() {
       
    //     $this->db->select('*')->from('category');
    //     $this->db->where('status', 1);
    //     $categories = $this->db->get()->result();
         
    //     return $categories;
    // }

     // $this->db->select('*')->from('user');

     //    if(!empty($searchtext)){
     //       $this->db->or_like(
     //            array(
     //                'fname' => $searchtext, 
     //                'lname' => $searchtext, 
     //                'email' => $searchtext, 
     //                'phone' => $searchtext 
     //            )
     //        );
     //    }
     //    if($page > 0){
     //        $page = $page * 25;
     //    }
     //    $this->db->where('deleted', 0);
     //    $this->db->limit(25, $page);
     //    return $this->db->get()->result();


    // public function get_ad($searchtext, $page = 0) {

    //     if($page > 0){
    //         $page = $page * 25;
    //     }

    //     $sql = "SELECT u.id as user_id, u.fname, u.lname, u.username, u.unique_code as uunique_code, u.email as uemail, u.phone, a.id, a.order_id, a.ad_type, a.image, a.title, a.description, a.state_of_object, a.category, c.name as category_name, a.location, a.lat, a.lon, a.status, a.creation_date FROM ad a INNER JOIN user u on u.id = a.user_id INNER JOIN category c ON c.id = a.category  WHERE 1 order by a.id DESC LIMIT $page, 25";
    //     $query = $this->db->query($sql);
    //     return $result = $query->result();
    // }


    // public function get_ad_detail($order_id) {

    //     $sql = "SELECT u.id as user_id, u.fname, u.lname, u.username, u.unique_code as uunique_code, u.email as uemail, u.phone, a.id, a.order_id, a.ad_type, a.image, a.title, a.description, a.state_of_object, a.category, c.name as category_name, a.location, a.lat, a.lon, a.status, a.creation_date FROM ad a INNER JOIN user u on u.id = a.user_id INNER JOIN category c ON c.id = a.category  WHERE a.order_id = '$order_id'";
    //     $query = $this->db->query($sql);
    //     return $result = $query->row();
    // }

























}

