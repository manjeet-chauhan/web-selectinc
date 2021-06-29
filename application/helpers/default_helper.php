<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
// ------------------------------------------------------------------------

/**
 * @access  public
 * @param   mixed   Script src's or an array
 * @param   string  language
 * @param   string  type
 * @param   string  title
 * @param   boolean should index_page be added to the script path
 * @return  string
 */
 // mail function ----
 function send_mail($email,$subject,$message){

    $from = "manjeet@webitexperts.com";
    $sender_name = "Paanduv";
    $ci = &get_instance();
    $config = Array(
        'mailpath' => '/usr/sbin/sendmail',
        'protocol' => 'sendmail',
        'smtp_host' => 'uitgaande.email',
        'smtp_port' => '587',
        'smtp_user' => 'manjeet@webitexperts.com',
        'smtp_pass' => ';5?U]wtLtDi6',
        'mailtype'  => 'html', 
        'charset'   => 'iso-8859-1',
    );
    $ci->load->library('email');    
    $ci->email->initialize($config);
    $ci->email->from($from, $sender_name);
    $ci->email->to(trim($email));           
    $ci->email->subject($subject);
    $ci->email->message($message);
    if($ci->email->send()){
        return true;
    }else{
        return false;
    }   
}


function autoIncrementer(){
    $ci = & get_instance();
    return $query = $ci->db->get('admin')->row()->autoincrement;
}

function saveautoIncrementer(){

    $ci = & get_instance();
    $sql = "update admin set autoincrement = autoincrement + 1";
    $ci->db->query($sql); 
}



function get_user_access($role){

    $ci =& get_instance();
    $sql = "SELECT access FROM role_management WHERE id = $role";
    $query = $ci->db->query($sql);
    $result = $query->row();
    return $result;
}

function get_user_autho(){

    $ci =& get_instance();
    $sql = "SELECT * FROM role_autho WHERE 1 order by id asc";
    $query = $ci->db->query($sql);
    $result = $query->result();
    return $result;
}


// by assignee
function get_issue_type(){

    $user_type = array(
        '0' => 'Me', 
        '3' => 'Doreen', 
        '4' => 'Caroline', 
        '7' => 'Accounting', 
        '8' => 'Steph', 
        '10' => 'Assistant', 
        '12' => 'Janina', 
        '13' => 'Sina', 
        '15' => 'support', 
        '16' => 'Julia', 
        '17' => 'Paula', 
        '18' => 'Helga', 
        '19' => 'Hagen', 
        '23' => 'Lehrling', 
        '24' => 'Secretary', 
        '25' => 'Sonja', 
    );

    return $user_type;
}
// by status
function get_issue_status(){
    $issue_status = array(
         
        '1' => 'New', 
        '2' => 'Payment prepared', 
        '4' => 'Feedback', 
        '5' => 'Finished/Closed', 
        '7' => 'Payed to Model', 
        '9' => 'Approved', 
        '10' => 'On Hold contract missing', 
        '11' => 'On Hold Buyout', 
        '14' => 'Requested at agent',         
        '15' => 'On Hold Comission', 
        '16' => 'Ready for Payout', 
    );

    return $issue_status;
}


function get_issue_priority(){
    $issue_priority = array(
        '4' => 'Normal', 
        '5' => 'Hoch', 
        '6' => 'Dringend', 
        '7' => 'Sofort',
    );

    return $issue_priority ;
}



function get_issue_hold_status(){
    $issue_status = array(      
        '10' => 'On Hold contract missing', 
        '11' => 'On Hold Buyout',        
        '15' => 'On Hold Comission', 
    );

    return $issue_status;
}

 
function user_profile($id){
    $ci =& get_instance();
    $sql = "SELECT id, name, username, redmine_username, redmine_password, redmine_assignee, email, phone, image FROM user WHERE id = $id";
    $query = $ci->db->query($sql);
    $result = $query->row();
    
    return $result;
}


function date_interval($date1, $date2)
{
    $diff = abs(strtotime($date2) - strtotime($date1));

    $years = floor($diff / (365 * 60 * 60 * 24));
    $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
    $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

    return (($years > 0) ? $years . ' Year' . ($years > 1 ? 's' : '') . ', ' : '') . (($months > 0) ? $months . ' Month' . ($months > 1 ? 's' : '') . ', ' : '') . (($days > 0) ? $days . ' Day' . ($days > 1 ? 's' : '') : '');
}

function calculateExperianceDays($start_date, $end_date){

    if(empty($start_date)){
        return 0;
    }
    if(empty($end_date)){
        return 0;
    }

    $diff = abs(strtotime($end_date) - strtotime($start_date));
    $years = floor($diff / (365*60*60*24));
    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
    $hours = floor($diff / ( 60 * 60 ));

    $experiance = "Today";

    if($years > 0){
        $experiance = $years." year";
    }
    if($months > 0){
        if($years > 0){
            $experiance = $years . " year(s), " . $months . " month(s)";
        }
        else{
            $experiance = $months . " month(s)";
        }
    }
    if($days > 0){
        if($years < 1){
            if($months > 0){
                if($years > 0){
                    $experiance = $years . " year(s), " . $months . " month(s)";
                }
                else{
                    $experiance = $months . " month(s)";
                }
            }
            else{
                $experiance = $days . " day(s)";
            }
        }
        else{
            if($months > 0){
                if($years > 0){
                    $experiance = $years . " year(s), " . $months . " month(s)";
                }
            }
            else{
                $experiance = $years . " year(s)";
            }
        }
    }
    if($days <= 0){        
        $experiance = $hours.' hours';
    }
    
    return $experiance;
}


function get_model_info($id){
    $ci =& get_instance();
    $sql = "SELECT id, user_id, unique_code, model_name, service_fee  FROM model_management WHERE id = $id"; //user_id = $id";
    $query = $ci->db->query($sql);
    $result = $query->row();
    
    return $result;
}

function get_model_info_by_code($u_code){
    $ci =& get_instance();
    $sql = "SELECT id, user_id, unique_code, model_name, service_fee  FROM model_management WHERE unique_code = '$u_code'"; //user_id = $id";
    $query = $ci->db->query($sql);
    $result = $query->row();
    
    return $result;
}

function get_models($id){
    $ci =& get_instance();
    $sql = "SELECT id, user_id, unique_code, model_name, model_name, name, service_fee, kvat, kvat_percent  FROM model_management WHERE 1"; //user_id = $id";
    $query = $ci->db->query($sql);
    $result = $query->result();
    
    return $result;
}


function get_clients($id){
    $ci =& get_instance();
    $sql = "SELECT id, unique_code, company_name, client_fee, kvat, kvat_percent, name, ingermany FROM client_management WHERE 1"; //user_id = $id";
    $query = $ci->db->query($sql);
    $result = $query->result();
    
    return $result;
}

function get_invoice_no($checkInvoic=NULL){
    $ci =& get_instance();
    $invoice_no = "SELINC".substr(time(), -9);

    if($checkInvoic!=NULL){
        $invoice_no = $checkInvoic;
    }

      
    $sql = "SELECT * FROM invoice WHERE invoice_number = '$invoice_no'";
    $query = $ci->db->query($sql);
    $result = $query->result();
    if(empty($result)){
        return $invoice_no;
    }else{
            if($checkInvoic!=NULL){
                return ;
            }

        get_invoice_no();
    }
    

}

function get_agency_comission(){
    $ci =& get_instance();
 
    $sql = "SELECT * FROM mwm_agency WHERE id = 1";
    $query = $ci->db->query($sql);
    return $result = $query->row();
}

function checkForGermany($model_id){
    $ci =& get_instance();

    $ci->db->select('ingermany');
    $ci->db->where('id',$model_id);
  return  $ci->db->get('model_management')->row();

}



function getAmountConverter(){
    $ci=& get_instance();

    // $ci->db->select('ingermany');
    // $ci->db->where('id',$model_id);
    // return  $ci->db->get('model_management')->row();
    return "30";

}


function get_footer_contents(){
    $ci =& get_instance();
    $sql = "SELECT id, row_order, font_size, bold, content_text, status FROM footer_contents WHERE 1 ORDER BY row_order ASC";
    $query = $ci->db->query($sql);
    $result = $query->result();
    
    return $result;
}


// -------------

// by assignee
function get_months(){
    $months = array(
        '01' => 'January', 
        '02' => 'February', 
        '03' => 'March', 
        '04' => 'April', 
        '05' => 'May', 
        '06' => 'June', 
        '07' => 'July', 
        '08' => 'August', 
        '09' => 'September', 
        '10' => 'October', 
        '11' => 'November', 
        '12' => 'December'
    );
    return $months;
}

function get_years(){
    $years = array();

    $yr_p = date('Y') - 10;
    $yr_n = date('Y') + 10;
    for($i = $yr_p; $i <= $yr_n; $i++){
        array_push($years, $i);
    }
    return $years;
}


function get_mwm_vat(){
    $ci =& get_instance();
    $sql = "SELECT DISTINCT vat_price FROM invoice WHERE 1 ORDER BY vat_price ASC";
    $query = $ci->db->query($sql);
    $result = $query->result();
    
    return $result;
}


function get_settings(){
    $ci =& get_instance();
    $sql = "SELECT *FROM settings WHERE id = 1";
    $query = $ci->db->query($sql);
    $result = $query->row();
    
    return $result;
}



function get_invoice_list($user_id){
    $ci =& get_instance();
    $sql = "SELECT invoice_number FROM invoice WHERE user_id = $user_id ORDER BY id DESC";
    $query = $ci->db->query($sql);
    $result = $query->result();
    
    return $result;
}





function get_currency_list(){
    // $currency_array = array(
    //     'euro' => '<i class="fa fa-eur"></i>',
    //     'ch' => 'CH',
    // );
    // return $currency_array;

    $ci =& get_instance();
    $sql = "SELECT * FROM currency WHERE 1";
    $query = $ci->db->query($sql);
    $result = $query->result();
    
    return $result;

}


function get_mwm_vat_no($invoice_no){
    
    $ci =& get_instance();
    $sql = "SELECT reverse_invoice FROM invoice WHERE invoice_number ='$invoice_no'";
    $query = $ci->db->query($sql);
    $result = $query->row();

    if(!empty($result)){

        if($result->reverse_invoice == 1){
            return 'DE 21 89 67 131';
        }
    }

    return '';    
}



