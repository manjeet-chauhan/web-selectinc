<?php

if (!defined('BASEPATH')) {
    exit('No Direct Script access allowed');
}

class Auth_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
     
    public function validate_admin_login() {
        
        $username = $this->input->post('txtemail');
        $password = $this->input->post('txtpassword');

        $this->db->select('*')->from('admin');
        $this->db->where('email', $username);
        $this->db->where('password', md5($password));
        return $this->db->get()->row();
    }

    public function admin_profile($id) {
        $this->db->select('*')->from('admin');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }


    public function save_admin_profile($image) {

        $id = $this->input->post('txtid');
        $array['fname'] = $this->input->post('txtfname');
        $array['lname'] = $this->input->post('txtlname');
        $array['phone'] = $this->input->post('txtcontactno');
        $array['email'] = $this->input->post('txtemail');
        $array['modification_date'] = date('Y-m-d H:i:s');
        if($image != ""){
            $array['image'] = $image;
        }
        $this->db->where('id', $id);
        return $this->db->update('admin', $array);
    }

     public function change_admin_password($id, $oldpass, $array) {

        $msg = "error";
        $this->db->where('id', $id);
        $this->db->where('password', md5($oldpass));
        $this->db->select('*')->from('admin');        
        $retdata = $this->db->get()->row();

        if(!empty($retdata)){
            $this->db->where('id', $id);
            $this->db->update('admin', $array);
            $msg = "success";
        }
        else{
            $msg = "oldpass";
        }
        return $msg;
    }







    public function validate_email($email)  {
        $this->db->where('email', $email);
        $this->db->select('*');
        $this->db->from('user');
        $query = $this->db->get();
        return $result = $query->row();     
    }

    public function user_register() {

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
            'unique_code' => "SELINC".substr(time(), -6),
            'name' => $name,             
            'username' => $username,            
            'redmine_assignee' =>$this->input->post('assignee'),            
            'redmine_username' =>$this->input->post('redmineusername'),            
            'redmine_password' =>$this->input->post('redminepassword'),            
            'email' => $this->input->post('email'),
            'password' => md5($this->input->post('password')),
            'status' => 1,
            'creation_date' => date('Y-m-d H:i:s'),
            'modification_date' => date('Y-m-d H:i:s') 
        );

        $register = $this->db->insert('user', $array);
        return $register;
    }

    public function user_login()  {

        $email=$this->input->post('email');
        $password=md5($this->input->post('password'));

        $this->db->where('email', $email);
        $this->db->where('password', $password);
        $this->db->select('*');
        $this->db->from('user');
        $query = $this->db->get();
        return $query->row();
    }



    // ---------------------------------------------------





    public function checkUserEmail(){
        $email = $this->getEmail();
        $this->db->select('*');
        $this->db->where('email', $email);
        return $this->db->get($this->tbl_name)->row();
    }
    public function password_validate(){
        $password = $this->getPassword();
        $this->db->select('*');
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $this->db->where('password', md5($password));
        return $this->db->get($this->tbl_name)->row();
    }
    public function update_password() {
        $password = $this->getPassword();
        $this->db->where('user_id', $this->session->userdata('user_id'));
        return $this->db->update($this->tbl_name, array('password' => md5($password)));
    }

    public function set_loged_history($username) {
        $data=array(
                'username'=>$username,
                'login_time'=>date('Y-m-d H:i:s'),
                'login_f'=>date('Y-m-d'),
                'ip'=>visiteIp()
            );
       
        $this->db->insert('tbl_loged_history',$data);
        return $this->db->insert_id();
    }

    public function update_loged_history() {
        $data=array(
                
                'logout_time'=>date('Y-m-d H:i:s'),
                
            );
        $this->db->where('id', $this->session->userdata('loged_history_id'));
        $this->db->update('tbl_loged_history',$data);
        return $this->db->insert_id();
    }
	
  
	 /* Check email in database*/
    public function checkemail($u_email){
        
        $this->db->select('*');
        $this->db->where('email',$u_email);
        $this->db->where('status','1');
        return $this->db->get('tbl_users')->result();
    }

     /* Check mobile number in database*/
    public function checkmobile($u_mobile){
        
        $this->db->select('*');
        $this->db->where('contact_no',$u_mobile);
        $this->db->where('status','1');
        return $this->db->get('tbl_users')->result();
    }   

    /* Check OTP number in database*/
    public function checkOTP($otp){
        
        $this->db->select('*');
        $this->db->where('otp',$otp);
        return $this->db->get('tbl_users')->row();
    }
    

    

   public function getUser($users_id){

        $this->db->select('*');
        $this->db->where('users_id',$users_id);
        return $this->db->get('tbl_users')->row();
            
    }

      /* Check checkmobileEmail in database*/
    public function checkmobileEmail($mobileEmail){
        
        $this->db->select('*');
        $this->db->where('contact_no',$mobileEmail);
        $this->db->or_where('email',$mobileEmail);
        return $this->db->get('tbl_users')->result();
    }      
    /* Check checkmobileEmail in database*/
    
    public function get_userOnMobile($u_mobile){
        
        $this->db->select('*');
        $this->db->where('contact_no',$u_mobile);
        $this->db->where('status','1');
        return $this->db->get('tbl_users')->row();
    }   

     /* Check checklogin_password in database*/
    public function checklogin_password($mobileEmail){
        $u_password = MD5($this->input->get('u_password'));
        $this->db->select('*');
        $this->db->where("(email = '$mobileEmail' OR contact_no = '$mobileEmail') AND password = '$u_password'");
        return $this->db->get('tbl_users')->result();
        //echo $this->db->last_query(); die;
    }

    //login user data

    public function getUserData(){
        $mobileEmail = $this->input->post('mobileEmail');
        $u_password = MD5($this->input->post('u_password'));
        $this->db->select('*');
        $this->db->where("(email = '$mobileEmail' OR contact_no = '$mobileEmail') AND password = '$u_password'");
        return $this->db->get('tbl_users')->row();
        //echo  $this->db->last_query(); die;
    }

    public function checkUserEmailForgot(){
        $u_email=$this->input->post('u_email');
        $this->db->select('*');
        $this->db->where('email',$u_email);
        $this->db->where('status','1');
        return $this->db->get('tbl_users')->row();
    }

    public function setUserRestLink($user_id){
   
       $data=array(
            'user_id'=>$user_id,
            'link'=>md5(date('Y-m-d H:i:s').'vinchamp'),
            'date' => date('Y-m-d H:i:s')
        );
        $this->db->insert('tbl_restpass', $data);
        return $this->db->insert_id();
    }

    public function checkUserRestLinkID($id){
           
            $this->db->select('*');
            $this->db->where('id',$id);
            return $this->db->get('tbl_restpass')->row();
    }
	
	public function checkUserRestLink($link){
           
            $this->db->select('*');
            $this->db->where('link',$link);
            $this->db->where('status',0);
            return $this->db->get('tbl_restpass')->row();
    }

    public function get_userByID($users_id){
        $this ->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where('users_id',$users_id);
        return $this->db->get()->row();
    }

      public function getRestLink($id){
           
            $this->db->select('*');
            $this->db->where('id',$id);
            $this->db->where('status',0);
            return $this->db->get('tbl_restpass')->row();
    }

     public function update_RestLink($id){
   
       $data=array(
            'status'=>1,
            
        );
        $this->db->where('id', $id);
        return $this->db->update('tbl_restpass',$data);
    }

    public function update_userRestPassword($user_id){
        $password = $this->input->post('password');
       $data=array(
            'password'=>md5($password),
            
        );
        $this->db->where('users_id', $user_id);
        return $this->db->update('tbl_users',$data);
    }

    public function validate_driver($mobile,$password){
        $this ->db->select('*');
        $this->db->from('tbl_driver_login');
        $this->db->where('mobile_no',$mobile);
        $this->db->where('id',$password);
        return $this->db->get()->row();
    }

    public function validate_new_user() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $pass = md5($password);
        $this->db->select('*');
        $this->db->where("email = '$email' AND password = '$pass'");
        $this->db->where('status', '1');
        return $this->db->get('tbl_users')->row();
        //$query = $this->db->get('tbl_users');
        //echo $this->db->last_query($query);die();
    }
 
 
}

