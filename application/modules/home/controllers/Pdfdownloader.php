<?php

//error_reporting(0);

if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Pdfdownloader extends CI_Controller{

	 
  public $image = '';

	public function __construct(){

		parent::__construct();

		$this->load->model('home_model');

		$this->load->helper('form');

		$this->load->library('form_validation');

    $imgurl = base_url('assets/frontend/images/logo.png');

    $this->load->library('m_pdf');
    $mpdf = $this->m_pdf->load();    
    $image = $mpdf->Image($imgurl, 0, 0, 210, 297, 'png', '', true, false);



    $user_session = $this->session->userdata('user');

    if(empty($user_session)){

      redirect(base_url('login'));

    }

  }

 
	

public function generate_invoice_pdf($invoice_number){

    // $data['view'] = 'generate-invoice-pdf';

    $invoice = $this->home_model->get_invoive_detail($invoice_number);
    $model_data = $this->home_model->model_agreed_data($invoice_number);
    $headers = $this->home_model->get_invoive_headers($invoice_number);
    $expenses = $this->home_model->get_invoice_expenses($invoice_number);
    $services = $this->home_model->get_invoice_service($invoice_number);
    $user_id = $this->home_model->user_id();
    $mwm_vat = get_mwm_vat_no($invoice_number);

    $footer = get_footer_contents();

     $footer_cont = '
      <table style="text-align: center; width:100%; margin-top:10px;">';

      

      foreach ($footer as $data_f) {

        $fs = $data_f->font_size;
        $fb = $data_f->font_size = 1 ? 'bold' : '';
        $footer_cont .= '      
          <tr><td style="padding: 2px; font-size:'.$fs.'px; font-weight:'.$fb.';">'.$data_f->content_text.'</td><tr>
        ';
      }

      $footer_cont .= '
      </table>';

   
    $mpdf = $this->m_pdf->load();    
    $mypdfData = $this->load->view('pdfTesting');
 
    $total_mdl_agreed_amt = 0; 

    $vat_price = 0;
    $ingermany = $invoice->m_ingermany;

    $correction = $invoice->correction == 1 ? '/C' : '';


    $i = 0;
    $hstar = '';              

    foreach ($headers as $header) {  

      if($i%2 == 0){

        $myclass = "singleHRecord alter2";

      }

      else{

        $myclass = "singleHRecord alter1";

      }

      $hstar .= '<div class="'.$myclass.'">

        <div class="singleHRecordTitle"> '.$header->invoive_title.' </div>

        <div class="singleHRecordDesc"> '.$header->invoive_value .'</div>

      </div>';

      $i++;

    }
 
    $model_budget_txt = '';


    if($invoice->model_budget > 0){
      // if($invoice->apply_model_fee == 1){

    if($invoice->model_budget != $invoice->model_total_agreed){

      $model_budget = $invoice->model_budget;
      $showm_db = '&nbsp;';
      if(empty($model_data)){
        if($invoice->m_vat_percent <= 0 || $invoice->m_ingermany != 1){
          $showm_db = $model_budget;
        }
      } 


      $model_budget_txt = ' <div class="model5Coloumn alter2 displaymodelBudget colorwhite ">
        <div class="invoiceHInfoSingleLarge"> 
          <div class="invoiceHInfoTitleLarge "> '.$invoice->modelnametext1.' </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
        </div>

         <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> '.$model_budget .'€  </div>
        </div>
       

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
        </div>  
      </div> ';  
    }
  // }
}


$modal_data_text = '';

// $total_agreed_amount = $invoice->additional_modal_price;
$total_agreed_amount = $invoice->apply_model_fee == 1 ? $invoice->model_budget : $invoice->additional_modal_price;

// if($invoice->reverse_invoice == 1){
//   $total_agreed_amount = $invoice->apply_model_fee == 1 ? $invoice->additional_modal_price : $invoice->model_budget;
// }

if(!empty($model_data)){

  $i = 0;
  $len = count($model_data);
  $tdata_text = '';
  foreach ($model_data as $modeldata) {
    $total_agreed_amount = $total_agreed_amount + $modeldata->amount;
    if($invoice->m_vat_percent <= 0 || $ingermany != 1 ){
      if ($i == $len - 1 && ($ingermany != 1 || $invoice->m_vat_percent <= 0)) {
        $tdata_text = $total_agreed_amount."€";
      }
    }

    $t1 = '&nbsp;';
    $t2 = '&nbsp;';
    $t3 = '&nbsp;';
    if($modeldata->name != ''){
      $t1 = $modeldata->name;
    }
    if($modeldata->title_1 != ''){
      $t2 = $modeldata->title_1;
    }
    if($modeldata->title_2 != ''){
      $t3 = $modeldata->title_2;
    }



      if($i%2 == 0){
        $myclass = "model5Coloumn alter1";
      }
      else{
        $myclass = "model5Coloumn alter2";
      }

      $i++;
      $stext = '';
      if(count($services) == $i){
        $stext = $ser_total."€ ";
      }
 
      $modal_data_text .= '<div style="color:'.$mycolor.'" class="'.$myclass.'">

        <div class="invoiceHInfoSingleLarge"> 
          <div class="invoiceHInfoTitle   "> '.$t1.' </div>
        </div>

         <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescription rightText"> '.$t2.'</div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescription rightText"> '.$t3.'</div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescription rightText"> '.$modeldata->amount.'€ </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescription rightText"> '.$tdata_text.'</div>
        </div> 

      </div>'; 
    }
  }




    $total_mdl_agreed_amt = $total_mdl_agreed_amt +  $total_agreed_amount;
     //checkForGermany($invoice->model_id);

    $modelvattext = '';
    $txtlst  = $invoice->additional_modal_price;

    $vat_price = 0;
    if(!empty($ingermany)&&($ingermany==1 && $invoice->m_vat_percent > 0)){       

	    if($invoice->m_vat_percent > 0){
	        $vat_price = ($total_agreed_amount*$invoice->m_vat_percent)/100;
          $total_mdl_agreed_amt = $total_mdl_agreed_amt + $vat_price; 
          $txtlst  = '&nbsp;';
	    }
 

	   	$modelvattext .= '

      <div class="model5Coloumn alter1 ">
        <div class="invoiceHInfoSingleLarge"> 
          <div class="invoiceHInfoTitleLarge "> + VAT </div>
        </div>

        

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> '. $invoice->m_vat_percent .'% </div>
        </div>

        

         <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText">  &nbsp; </div>
        </div>


        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> '. $vat_price .'€ </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> '. ($total_agreed_amount + $vat_price) .'€ </div>
        </div>  
      </div> ';
 

	 }

 
    $modelExpenses = '';

    if(!empty($expenses)){
 
        $i = 0;        
        $total_sum = 0;        

        foreach ($expenses as $expense) {

          $vat_exp_price = 0;
          $total_mdl_agreed_amt_loc =  $expense->model_exp_amount; 


          $srow1 = '<div>'.$expense->model_expense.'</div>';
          $srow2 = '<div>See receipt</div>';
          $srow3 = '<div>&nbsp;</div>';
          $srow5 = '<div>'. $total_mdl_agreed_amt_loc  .'€</div>';

           
          if($expense->vat_include == 1 && $ingermany==1){ 

	            if($expense->vat_percent > 0){
	                $vat_exp_price = ($expense->model_exp_amount*$expense->vat_percent)/100;
	                $total_mdl_agreed_amt_loc = $total_mdl_agreed_amt_loc + $vat_exp_price;
	            } 

              $srow1 = '<div>'.$expense->model_expense.'</div><div class="secondDiv">  Plus VAT </div>';
              $srow2 = '<div>See receipt</div><div class="secondDiv"> '. $expense->vat_percent .'%</div>';
              $srow3 = '<div>'.$expense->model_exp_amount.'€</div><div class="secondDiv"> '. $vat_exp_price .'€</div>';
              $srow5 = '<div>&nbsp;</div><div class="secondDiv"> '. $total_mdl_agreed_amt_loc  .'€</div>';
  		    }
          $total_mdl_agreed_amt = $total_mdl_agreed_amt + $total_mdl_agreed_amt_loc;
          $total_sum = $total_sum + ($total_mdl_agreed_amt_loc + $vat_exp_price);

          if($i%2 == 0){

            $myclass = "model5Coloumn alter2";

          }

          else{

            $myclass = "model5Coloumn alter1";

          }

           $i++;

           $stext = '';
           if(count($expenses) == $i){  
              $stext =  $total_sum.'€ ';  
            }

          $modelExpenses .= '<div class="'.$myclass.'">

            <div class="invoiceHInfoSingleLarge"> 
              <div class="invoiceHInfoTitle   "> '.$srow1.' </div>
            </div>

             <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> '.$srow2.' </div>
            </div>

             <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> &nbsp; </div>
            </div>

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> '.$srow3.' </div>
            </div> 

            

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> '.$srow5.'</div>
            </div> 

          </div>'; 

    		}

    	} 
 
      // $agency_commission = get_agency_comission();

      $commisssion  = $invoice->model_agency_comission;      

      $com_price_agree = (( ( $invoice->apply_model_fee == 1 ? $invoice->model_budget : $total_agreed_amount) *  $commisssion)/100);
      $total_mdl_agreed_amt = $total_mdl_agreed_amt + $com_price_agree;

      // $conText = '&nbsp;';
       // if($ingermany!=1){ 
        $conText = $com_price_agree .'€';
       // }

        $reverse_count = 0;
       if(!empty($invoice->mwm_reverse_data)){
            $r_array = json_decode($invoice->mwm_reverse_data);
            $reverse_count = count($r_array);
        }


      $modal_commission .= '

      <div class="model5Coloumn alter2 ">
        <div class="invoiceHInfoSingleLarge"> 
          <div class="invoiceHInfoTitleLarge "> Plus Agency Commission <div><small><b>'.$invoice->acommissionothertext.'</b></small></div>'. $mwm_vat.'</div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> '.  $commisssion .'% </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
        </div> ';

        if((($invoice->vat_price > 0)&&!empty($ingermany)&&($ingermany==1))){ 

          $modal_commission .= '<div class="invoiceHInfoSingleSmall"> 
            <div class="invoiceHInfoDescriptionsm rightText"> '.$conText .' </div>
          </div>

          <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
        </div> </div> ';

        }
        else if($reverse_count > 0){
          $modal_commission .= ' <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> '.$conText .' </div>

        </div> <div class="invoiceHInfoSingleSmall"> 
            <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
          </div> </div> ';

        }
        else {

          $modal_commission .= '<div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
          </div> 
          <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescriptionsm rightText"> '.$conText .'</div>
            </div> 
          </div> ';
        }


        $reverse_amount = 0;
       if(!empty($invoice->mwm_reverse_data)){
            $r_array = json_decode($invoice->mwm_reverse_data);

            $r_count = count($r_array);
            $rc_count = 0;
            foreach($r_array as $reverse){
              $reverse_amount = $reverse_amount + $reverse->amount;

              $amtt = 0;
              ++$rc_count;
              if($r_count == $rc_count){
                   $amtt =  $com_price_agree + $reverse_amount;     
              }
        
              $modal_commission .= '

                <div class="model5Coloumn alter1 ">
                  <div class="invoiceHInfoSingleLarge"> 
                    <div class="invoiceHInfoTitleLarge "> '.$reverse->name.' </div>
                  </div>
        
                  <div class="invoiceHInfoSingleSmall"> 
                    <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
                  </div> 

                   <div class="invoiceHInfoSingleSmall"> 
                    <div class="invoiceHInfoDescriptionsm rightText"> '.$reverse->title.'</div>
                  </div>

                  <div class="invoiceHInfoSingleSmall"> 
                    <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
                  </div> 

                  <div class="invoiceHInfoSingleSmall"> 
                    <div class="invoiceHInfoDescriptionsm rightText"> '.$reverse->amount .'€</div>
                  </div>

                  <div class="invoiceHInfoSingleSmall"> 
                    <div class="invoiceHInfoDescriptionsm rightText"> '. $amtt .'€</div>
                  </div>

                </div> ';
            }
          }

         


      if(($invoice->vat_price > 0)&&!empty($ingermany)&&($ingermany==1)){ 
 
        $com_price_agree_vat = (($com_price_agree * $invoice->vat_price)/100); 
        $total_mdl_agreed_amt = $total_mdl_agreed_amt + $com_price_agree_vat; 


        $modal_commission .= '
          <div class="model5Coloumn alter1 ">
            <div class="invoiceHInfoSingleLarge"> 
              <div class="invoiceHInfoTitleLarge "> + VAT </div>
            </div>
  
            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescriptionsm rightText"> '.$invoice->vat_price.'% </div>
            </div> 

             <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
            </div>

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescriptionsm rightText"> '.$com_price_agree_vat .'€</div>
            </div>

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescriptionsm rightText"> '.($com_price_agree + $com_price_agree_vat) .'€  </div>
            </div>
          </div> ';
      }


    $modelServices = '';


    if(!empty($services)){


      $modelServices = '
      <div class=" behalyOfModel">

        <div class="singleHRecordCompany fontbold"> invoicing on behalf of the Select Inc. </div>

      </div>' ;
 


        $i = 0;
        $ser_total = 0;
        foreach ($services as $service) {

          $vat_ser_price = 0;
          $total_mdl_agreed_amt_loc = 0;
          $mycolor = '#f00';
          $showcal = '-';


          $srow1 = '<div>'.$service->model_service.'</div>';
          $srow2 = '<div>See receipt</div>';
          $srow3 = '<div>&nbsp;</div>';
          $srow5 = '<div> (-) '. $service->model_ser_amount  .'€</div>';


          if ($service->status == 1) {   
            $srow5 = '<div> '. $service->model_ser_amount  .'€</div>';
            $total_mdl_agreed_amt_loc = $service->model_ser_amount;
            if(($service->vat_include == 1)&&!empty($ingermany)&&($ingermany==1)){                 

                if($service->vat_percent > 0){
                    $vat_ser_price = ($service->model_ser_amount*$service->vat_percent)/100;
                    $total_mdl_agreed_amt_loc = $total_mdl_agreed_amt_loc + $vat_ser_price;

                    $srow1 = '<div>'.$service->model_service.'</div><div class="secondDiv">  Plus VAT </div>';
                    $srow2 = '<div>See receipt</div><div class="secondDiv"> '. $service->vat_percent .'%</div>';
                    $srow3 = '<div>'.$service->model_ser_amount.'€</div><div class="secondDiv"> '. $vat_ser_price .'€</div>';
                    $srow5 = '<div>&nbsp;</div><div class="secondDiv">'. $total_mdl_agreed_amt_loc  .'€</div>'; 
                }
            }

            $total_mdl_agreed_amt = $total_mdl_agreed_amt + $total_mdl_agreed_amt_loc;
            $mycolor = '';
            

             $ser_total =  $ser_total + ($service->model_ser_amount + $vat_ser_price);

          }

          if($i%2 == 0){
            $myclass = "model5Coloumn alter1";
          }
          else{
            $myclass = "model5Coloumn alter2";
          }

          $i++;
          $stext = '';
          if(count($services) == $i){
            $stext = $ser_total."€ ";
          }



          $modelServices .= '<div style="color:'.$mycolor.'" class="'.$myclass.'">

            <div class="invoiceHInfoSingleLarge"> 
              <div class="invoiceHInfoTitle   "> '.$srow1.' </div>
            </div>

             <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> '.$srow2.' </div>
            </div>

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> &nbsp; </div>
            </div>

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> '.$srow3.'</div>
            </div> 

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> '.$srow5.' </div>
            </div> 

          </div>';

          

        }

      } 


      $invoice->additional_modal_text = $invoice->additional_modal_text != '' ? $invoice->additional_modal_text : '&nbsp;';


        $mystr =  ' 

         <!DOCTYPE html>

          <html>

          <head>

            <title></title>

            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

            <style type="text/css">

              .invoiceHeader{

                  text-align: center;

                  font-size: 15px;
                  font-weight: bold;

                  color: #000;  

                  padding-bottom: 5px; 


              }

              .headerData{

                padding-top: 20px;
                font-size:12px;

              }

              .singleHRecordTitle{

                font-weight:400;

                width:33.33%;

                float:left;

                color: #000;               

              }

              .singleHRecordDesc{

                width:66.66%;

                float:left; 

                color: #000;                 

              }

              .addressHRecord{ 
                padding-bottom: 5px;
 

              }

              .singleHRecordCompany{

                color: #000;

              }

              .fontbold{

               font-weight:bold;

              }

              .font-sm{

                font-size: 13px;

              }

              .invoiceHInfo{

                padding-bottom:20px;

              }

              .invoiceHInfo .invoiceHInfoSingle{

                 width: 33.33%;

                 float: left;
                 font-size:12px;



              }

              .invoiceHInfoTitle{

                color : #000;
                font-size:12px;

              }

              .alter1{

                // background-color:#fff;

                // padding: 8px 5px;
                margin-bottom: 5px;

              }

              .alter2{

                // background-color:#f1f1f1;

                // padding: 5px;
                 margin-bottom: 5px;

              }

              .displaymodelBudget{

                // background-color: #333;

                padding: 20px 0 0 0;
              }



              .displaymodelBudget .singleHRecordTitle, .displaymodelBudget .singleHRecordDesc{

              	// color: #fff !important;
                font-size:12px;

              }

              .behalyOfModel{

                font-style: italic;

                margin-top: 15px;

                padding-bottom:5px;

                // border-bottom: 2px solid #e1e1e1;
                text-decoration:underline;

                color: #000;
                font-size:13px !important;
                margin-bottom:5px;

              }

              .rightText{

                text-align: right;

              }



              .model5Coloumn{

                width: 100%;
                font-size:12px;

              }

              .invoiceHInfoSingleLarge{

                width:30%;

                float:left;

                color: #000;
                font-size:12px;

              }

              .invoiceHInfoSingleSmall{

                width:17%;

                float:left;

                color: #000;

              }

              .colorwhite .invoiceHInfoSingleSmall .invoiceHInfoDescriptionsm, .colorwhite .invoiceHInfoSingleLarge .invoiceHInfoTitleLarge {
                // color: #fff !important;
                font-size:12px;
              }
              .secondDiv{
                margin-top: 5px;
              }
              .top55px{
                margin-top: 50px;
              }
              .totaldispamt{
                padding:4px 0 !important;
                margin-top: 20px;
                border-top: 2px solid #ccc;
                border-bottom: 2px solid #ccc;
              }


            </style>

          </head>

          <body>       

            <div class="headerData">

              <div class="addressHRecord alter1">

                <div class="singleHRecordCompany fontbold top55px" > '. $invoice->i_company_name .' </div>

                <div class="singleHRecordCompany"> '. $invoice->i_address_line1.', '.$invoice->i_address_line2 .' </div>

                <div class="singleHRecordCompany"> '. $invoice->i_city.', '.$invoice->i_pincode .' </div>

                <div class="singleHRecordCompany font-sm"> '. strtoupper($invoice->i_country) .' </div>

              </div>

               <div class="invoiceHeader "> INVOICE  </div>

              <div class="invoiceHInfo alter2">

                <div class="invoiceHInfoSingle"> 

                  <div class="invoiceHInfoTitle fontbold"> Ticket ID </div>

                  <div class="invoiceHInfoDescription"> #'. $invoice->issue_id .'</div>

                </div>

                <div class="invoiceHInfoSingle"> 

                  <div class="invoiceHInfoTitle fontbold"> Invoice Number </div>

                  <div class="invoiceHInfoDescription">'. $invoice->invoice_number.$correction .'</div>

                </div>

                <div class="invoiceHInfoSingle"> 

                  <div class="invoiceHInfoTitle fontbold"> Date </div>

                  <div class="invoiceHInfoDescription">'. date('d/m/Y', strtotime($invoice->job_date)).'</div>

                </div>                 

              </div>



              <div class="singleHRecord alter1">

                <div class="singleHRecordTitle"> Model </div>

                <div class="singleHRecordDesc"> '. $invoice->m_model_name.', '.$invoice->m_name. ', '.$invoice->m_address_line1. ' - '.$invoice->m_pincode. ', '.$invoice->m_city. ', '.$invoice->m_country .'</div>

              </div>

              <div class="singleHRecord alter2">

                <div class="singleHRecordTitle"> TIN </div>

                <div class="singleHRecordDesc"> '. $invoice->m_vat_tin_number .'</div>

              </div>

              <div class="singleHRecord alter1">

                <div class="singleHRecordTitle"> Provided by Trademark </div>

                <div class="singleHRecordDesc">  Most Wanted Model® </div>

              </div>



              <div class="singleHRecord alter2">

                <div class="singleHRecordTitle"> Customer </div>

                <div class="singleHRecordDesc"> '. $invoice->i_company_name .'</div>

              </div>

              <div class="singleHRecord alter1">

                <div class="singleHRecordTitle"> Booking Date </div>

                <div class="singleHRecordDesc"> '. date('d/m/Y', strtotime($invoice->creation_date)) .'-'.date('d/m/Y', strtotime($invoice->job_date_till)).'</div>

              </div>

              <div class="singleHRecord alter2">

                <div class="singleHRecordTitle"> Uses </div>

                <div class="singleHRecordDesc"> '. $invoice->uses .'</div>

              </div>

              '.$hstar .'<div>'. $model_budget_txt .'</div>

        

              

              <div class=" behalyOfModel">

                <div class="singleHRecordCompany fontbold"> Invoicing on behalf of the model </div>

              </div>

                <div class="model5Coloumn alter2 ">
                  <div class="invoiceHInfoSingleLarge"> 
                    <div class="invoiceHInfoTitleLarge "> '.$invoice->modelnametext2.' <p><small><b>'.$invoice->modelothertext.'</b></small></p></div>
                  </div>

                  <div class="invoiceHInfoSingleSmall"> 
                    <div class="invoiceHInfoDescriptionsm rightText"> '.$invoice->additional_modal_text.' </div>
                  </div>

                  <div class="invoiceHInfoSingleSmall"> 
                    <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
                  </div>

                  <div class="invoiceHInfoSingleSmall"> 
                    <div class="invoiceHInfoDescriptionsm rightText"> '.$invoice->additional_modal_price .'€  </div>
                  </div>

                  <div class="invoiceHInfoSingleSmall"> 
                    <div class="invoiceHInfoDescriptionsm rightText"> '.$txtlst.' €</div>
                  </div>  
                </div> 

              </div>' . $modal_data_text . ' '. $modelvattext .' <div>'. $modelExpenses .'</div>

            

            <div class=" behalyOfModel">

                <div class="singleHRecordCompany fontbold"> Invoicing on behalf of the Most Wanted Models ® Agency Germany </div>

              </div> '.$modal_commission.' '.$modelServices.'

           
              <div class="model5Coloumn alter2 displaymodelBudget colorwhite totaldispamt ">
              <div class="invoiceHInfoSingleLarge"> 
                <div class="invoiceHInfoTitleLarge "> <b>Total Amount</b> </div>
              </div>

              <div class="invoiceHInfoSingleSmall"> 
                <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
              </div>

              <div class="invoiceHInfoSingleSmall"> 
                <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
              </div>

              

              <div class="invoiceHInfoSingleSmall"> 
                <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
              </div>  

              <div class="invoiceHInfoSingleSmall"> 
                <div class="invoiceHInfoDescriptionsm rightText"> '.$total_mdl_agreed_amt .'€  </div>
              </div>
            </div>

              


             
            </div>

          </body>

          </html>';

          

        $mpdf->Bookmark('Start of the document');



 $mpdf->SetHTMLHeader('<div class="invoiceHeader fontbold"> <img style="float:right; height:35px; width: auto;" src="'.base_url('assets/frontend/images/logo.png').'"/></div> 
            <div style="font-size: 10px; margin: 8px 0; padding-bottom:50px;">Select Inc. Corregimiento Obarrio, Calle 58 Este y Calle 50 Edificio Office One piso 12 Oficina 1207, Panama City, Panama</div>');

        $mpdf->WriteHTML($mystr);
        $mpdf->SetHTMLFooter($footer_cont);
        
        $invoive_name = $invoice->invoice_number."_".time().'.pdf';
        $mpdf->Output($invoive_name,"D");

}




public function model_invoice_pdf($invoice_number){

    // $data['view'] = 'generate-invoice-pdf';

    $invoice = $this->home_model->get_invoive_detail($invoice_number);
    $model_data = $this->home_model->model_agreed_data($invoice_number);
    $headers = $this->home_model->get_invoive_headers($invoice_number);
    $expenses = $this->home_model->get_invoice_expenses($invoice_number);
    $services = $this->home_model->get_invoice_service($invoice_number);
    $user_id = $this->home_model->user_id();
 
    $mpdf = $this->m_pdf->load();    
    $mypdfData = $this->load->view('pdfTesting');
 
    $total_mdl_agreed_amt = 0; 

    $vat_price = 0;
    $ingermany = $invoice->m_ingermany;
     $correction = $invoice->correction == 1 ? '/C' : '';



    $i = 0;

    $hstar = '';              

    foreach ($headers as $header) {  

      if($i%2 == 0){

        $myclass = "singleHRecord alter2";

      }

      else{

        $myclass = "singleHRecord alter1";

      }

      $hstar .= '<div class="'.$myclass.'">

        <div class="singleHRecordTitle"> '.$header->invoive_title.' </div>

        <div class="singleHRecordDesc"> '.$header->invoive_value .'</div>

      </div>';

      $i++;

    }



    $model_budget_txt = '';


   if($invoice->model_budget > 0){
      // if($invoice->apply_model_fee == 1){

    if($invoice->model_budget != $invoice->model_total_agreed){

      $model_budget = $invoice->model_budget;
      $showm_db = '&nbsp;';
      if(empty($model_data)){
        if($invoice->m_vat_percent <= 0 || $invoice->m_ingermany != 1){
          $showm_db = $model_budget;
        }
      } 


      $model_budget_txt = ' <div class="model5Coloumn alter2 displaymodelBudget colorwhite ">
        <div class="invoiceHInfoSingleLarge"> 
          <div class="invoiceHInfoTitleLarge "> '.$invoice->modelnametext1.' </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
        </div>

        

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> '.$model_budget .'€  </div>
        </div>
        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> '.$showm_db.'€ </div>
        </div>  
      </div> ';  
    }
  // }
}


$modal_data_text = '';

// $total_agreed_amount = $invoice->additional_modal_price;
$total_agreed_amount = $invoice->apply_model_fee == 1 ? $invoice->model_budget : $invoice->additional_modal_price;

if($invoice->reverse_invoice == 1){
  $total_agreed_amount = $invoice->apply_model_fee == 1 ? $invoice->additional_modal_price : $invoice->model_budget;
}

if(!empty($model_data)){

  $i = 0;
  $len = count($model_data);
  $tdata_text = '';
  foreach ($model_data as $modeldata) {
    $total_agreed_amount = $total_agreed_amount + $modeldata->amount;
    if($invoice->m_vat_percent <= 0 || $ingermany != 1){
      if ($i == $len - 1 && ($ingermany != 1 || $invoice->m_vat_percent <= 0)) {
        $tdata_text = $total_agreed_amount."€";
      }
    }

    $t1 = '&nbsp;';
    $t2 = '&nbsp;';
    $t3 = '&nbsp;';
    if($modeldata->name != ''){
      $t1 = $modeldata->name;
    }
    if($modeldata->title_1 != ''){
      $t2 = $modeldata->title_1;
    }
    if($modeldata->title_2 != ''){
      $t3 = $modeldata->title_2;
    }



      if($i%2 == 0){
        $myclass = "model5Coloumn alter1";
      }
      else{
        $myclass = "model5Coloumn alter2";
      }

      $i++;
      $stext = '';
      if(count($services) == $i){
        $stext = $ser_total."€ ";
      }
 
      $modal_data_text .= '<div style="color:'.$mycolor.'" class="'.$myclass.'">

        <div class="invoiceHInfoSingleLarge"> 
          <div class="invoiceHInfoTitle   "> '.$t1.' </div>
        </div>

         <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescription rightText"> '.$t2.'</div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescription rightText"> '.$t3.'</div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescription rightText"> '.$modeldata->amount.'€ </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescription rightText"> '.$tdata_text.'</div>
        </div> 

      </div>'; 
    }
  }




    $total_mdl_agreed_amt = $total_mdl_agreed_amt +  $total_agreed_amount;
     //checkForGermany($invoice->model_id);

    $modelvattext = '';


    $vat_price = 0;
    if( $invoice->m_vat_percent > 0 && $ingermany==1 ){  

        

      if($invoice->m_vat_percent > 0){
          $vat_price = ($total_agreed_amount*$invoice->m_vat_percent)/100;
          $total_mdl_agreed_amt = $total_mdl_agreed_amt + $vat_price; 
      }
 

      $modelvattext .= '

      <div class="model5Coloumn alter1 ">
        <div class="invoiceHInfoSingleLarge"> 
          <div class="invoiceHInfoTitleLarge "> + VAT </div>
        </div>

        

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> '. $invoice->m_vat_percent .'% </div>
        </div>

         <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText">  &nbsp; </div>
        </div>

        

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> '. $vat_price .'€ </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> '. ($total_agreed_amount + $vat_price) .'€ </div>
        </div>  
      </div> ';
 

   }

 
    $modelExpenses = '';



    if(!empty($expenses)){
 
        $i = 0;        
        $total_sum = 0;        

        foreach ($expenses as $expense) {

          $vat_exp_price = 0;
          $total_mdl_agreed_amt_loc =  $expense->model_exp_amount; 


          $srow1 = '<div>'.$expense->model_expense.'</div>';
          $srow2 = '<div>&nbsp;</div>';
          $srow3 = '<div>&nbsp;</div>';
          $srow5 = '<div>'. $total_mdl_agreed_amt_loc  .'€</div>';

           
          if($expense->vat_include == 1 && $ingermany==1){ 

              if($expense->vat_percent > 0){
                  $vat_exp_price = ($expense->model_exp_amount*$expense->vat_percent)/100;
                  $total_mdl_agreed_amt_loc = $total_mdl_agreed_amt_loc + $vat_exp_price;
              } 

              $srow1 = '<div>'.$expense->model_expense.'</div><div class="secondDiv">  Plus VAT </div>';
              $srow2 = '<div>&nbsp;</div><div class="secondDiv"> '. $expense->vat_percent .'%</div>';
              $srow3 = '<div>'.$expense->model_exp_amount.'€</div><div class="secondDiv"> '. $vat_exp_price .'€</div>';
              $srow5 = '<div>&nbsp;</div><div class="secondDiv"> '. $total_mdl_agreed_amt_loc  .'€</div>';
          }
          $total_mdl_agreed_amt = $total_mdl_agreed_amt + $total_mdl_agreed_amt_loc;
          $total_sum = $total_sum + ($total_mdl_agreed_amt_loc + $vat_exp_price);


         


          if($i%2 == 0){

            $myclass = "model5Coloumn alter2";

          }

          else{

            $myclass = "model5Coloumn alter1";

          }

           $i++;

           $stext = '';
           if(count($expenses) == $i){  
              $stext =  $total_sum.'€ ';  
            }

          $modelExpenses .= '<div class="'.$myclass.'">

            <div class="invoiceHInfoSingleLarge"> 
              <div class="invoiceHInfoTitle   "> '.$srow1.' </div>
            </div>

             <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> '.$srow2.' </div>
            </div>

             <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> &nbsp; </div>
            </div>

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> '.$srow3.' </div>
            </div> 

            

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> '.$srow5.'</div>
            </div> 

          </div>'; 

        }

      } 
 
      $invoice->additional_modal_text = $invoice->additional_modal_text != '' ? $invoice->additional_modal_text : '&nbsp;';

        $mystr =  ' 

         <!DOCTYPE html>

          <html>

          <head>

            <title></title>

            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

            <style type="text/css">

             .invoiceHeader{

                  text-align: center;

                  font-size: 15px;
                  font-weight: bold;

                  color: #000;  

                  padding-bottom: 5px; 


              }

              .headerData{

                padding-top: 20px;
                font-size:12px;

              }

              .singleHRecordTitle{

                font-weight:400;

                width:33.33%;

                float:left;

                color: #000;               

              }

              .singleHRecordDesc{

                width:66.66%;

                float:left; 

                color: #000;                 

              }

              .addressHRecord{ 
                padding-bottom: 5px;
 

              }

              .singleHRecordCompany{

                color: #000;

              }

              .fontbold{

               font-weight:bold;

              }

              .font-sm{

                font-size: 13px;

              }

              .invoiceHInfo{

                padding-bottom:20px;

              }

              .invoiceHInfo .invoiceHInfoSingle{

                 width: 33.33%;

                 float: left;
                 font-size:12px;



              }

              .invoiceHInfoTitle{

                color : #000;
                font-size:12px;

              }

              .alter1{

                // background-color:#fff;

                // padding: 8px 5px;
                margin-bottom: 5px;

              }

              .alter2{

                // background-color:#f1f1f1;

                // padding: 5px;
                 margin-bottom: 5px;

              }

              .displaymodelBudget{

                // background-color: #333;

                padding: 20px 0 0 0;
              }



              .displaymodelBudget .singleHRecordTitle, .displaymodelBudget .singleHRecordDesc{

                // color: #fff !important;
                font-size:12px;

              }

              .behalyOfModel{

                font-style: italic;

                margin-top: 15px;

                padding-bottom:5px;

                // border-bottom: 2px solid #e1e1e1;
                text-decoration:underline;

                color: #000;
                font-size:13px !important;
                margin-bottom:5px;

              }

              .rightText{

                text-align: right;

              }



              .model5Coloumn{

                width: 100%;
                font-size:12px;

              }

              .invoiceHInfoSingleLarge{

                width:30%;

                float:left;

                color: #000;
                font-size:12px;

              }

              .invoiceHInfoSingleSmall{

                width:17%;

                float:left;

                color: #000;

              }

              .colorwhite .invoiceHInfoSingleSmall .invoiceHInfoDescriptionsm, .colorwhite .invoiceHInfoSingleLarge .invoiceHInfoTitleLarge {
                // color: #fff !important;
                font-size:12px;
              }
              .secondDiv{
                margin-top: 5px;
              }
              .top55px{
                margin-top: 50px;
              }
              .totaldispamt{
                padding:4px 0 !important;
                margin-top: 20px;
                border-top: 2px solid #ccc;
                border-bottom: 2px solid #ccc;
              }




            </style>

          </head>

          <body>
          

            <div class="headerData">

              <div class="addressHRecord alter1">

                <div class="singleHRecordCompany fontbold top55px"> '. $invoice->i_company_name .' </div>

                <div class="singleHRecordCompany"> '. $invoice->i_address_line1.', '.$invoice->i_address_line2 .' </div>

                <div class="singleHRecordCompany"> '. $invoice->i_city.', '.$invoice->i_pincode .' </div>

                <div class="singleHRecordCompany font-sm"> '. strtoupper($invoice->i_country) .' </div>

              </div>

               <div class="invoiceHeader fontbold"> INVOICE</div> 

              <div class="invoiceHInfo alter2">

                <div class="invoiceHInfoSingle"> 

                  <div class="invoiceHInfoTitle fontbold"> Ticket ID </div>

                  <div class="invoiceHInfoDescription"> #'. $invoice->issue_id .'</div>

                </div>

                <div class="invoiceHInfoSingle"> 

                  <div class="invoiceHInfoTitle fontbold"> Invoice Number </div>

                  <div class="invoiceHInfoDescription">'. $invoice->invoice_number.$correction .'</div>

                </div>

                <div class="invoiceHInfoSingle"> 

                  <div class="invoiceHInfoTitle fontbold"> Date </div>

                  <div class="invoiceHInfoDescription">'. date('d/m/Y', strtotime($invoice->invoice_date)) .'</div>

                </div>                 

              </div>



              <div class="singleHRecord alter1">

                <div class="singleHRecordTitle"> Model </div>

                <div class="singleHRecordDesc"> '. $invoice->m_model_name.', '.$invoice->m_name. ', '.$invoice->m_address_line1. ' - '.$invoice->m_pincode. ', '.$invoice->m_city. ', '.$invoice->m_country .'</div>

              </div>

              <div class="singleHRecord alter2">

                <div class="singleHRecordTitle"> TIN </div>

                <div class="singleHRecordDesc"> '. $invoice->m_vat_tin_number .'</div>

              </div>

              <div class="singleHRecord alter1">

                <div class="singleHRecordTitle"> Provided by Trademark </div>

                <div class="singleHRecordDesc">  Most Wanted Model® </div>

              </div>



              <div class="singleHRecord alter2">

                <div class="singleHRecordTitle"> Customer </div>

                <div class="singleHRecordDesc"> '. $invoice->i_company_name .'</div>

              </div>

               <div class="singleHRecord alter1">

                <div class="singleHRecordTitle"> Booking Date </div>

                <div class="singleHRecordDesc"> '. date('d/m/Y', strtotime($invoice->creation_date)) .'-'.date('d/m/Y', strtotime($invoice->job_date_till)).'</div>

              </div>

              <div class="singleHRecord alter2">

                <div class="singleHRecordTitle"> Uses </div>

                <div class="singleHRecordDesc"> '. $invoice->uses .'</div>

              </div>

              '.$hstar .'<div>'. $model_budget_txt .'</div>

        

              <div class=" behalyOfModel">
                <div class="singleHRecordCompany fontbold">  Invoicing on behalf of the model  </div>
              </div> 

                <div class="model5Coloumn alter2 ">
                  <div class="invoiceHInfoSingleLarge"> 
                   <div class="invoiceHInfoTitleLarge "> '.$invoice->modelnametext2.' <p><small><b>'.$invoice->modelothertext.'</b></small></p></div>
                  </div>

                  <div class="invoiceHInfoSingleSmall"> 
                    <div class="invoiceHInfoDescriptionsm rightText"> '.$invoice->additional_modal_text.' </div>
                  </div>

                  <div class="invoiceHInfoSingleSmall"> 
                    <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
                  </div>

                  <div class="invoiceHInfoSingleSmall"> 
                    <div class="invoiceHInfoDescriptionsm rightText"> '.$invoice->additional_modal_price .'€  </div>
                  </div>

                  <div class="invoiceHInfoSingleSmall"> 
                    <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
                  </div>  
                </div> 


              </div>' . $modal_data_text . ' '. $modelvattext .' <div>'. $modelExpenses .'</div>
 
           
              <div class="model5Coloumn alter2 displaymodelBudget colorwhite totaldispamt">
              <div class="invoiceHInfoSingleLarge"> 
                <div class="invoiceHInfoTitleLarge "> <b>Total Amount</b> </div>
              </div>

              <div class="invoiceHInfoSingleSmall"> 
                <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
              </div>

              <div class="invoiceHInfoSingleSmall"> 
                <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
              </div>

              

              <div class="invoiceHInfoSingleSmall"> 
                <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
              </div>  

              <div class="invoiceHInfoSingleSmall"> 
                <div class="invoiceHInfoDescriptionsm rightText"> '.$total_mdl_agreed_amt .'€  </div>
              </div>
            </div> 
             
            </div>

          </body>

          </html>';
          
          $mpdf->SetHTMLHeader('<div class="invoiceHeader fontbold"> <img style="float:right; height:35px; width: auto;" src="'.base_url('assets/frontend/images/logo.png').'"/></div> 
            <div style="font-size: 10px; margin: 8px 0; padding-bottom:50px;">Select Inc. Corregimiento Obarrio, Calle 58 Este y Calle 50 Edificio Office One piso 12 Oficina 1207, Panama City, Panama</div>');

        $mpdf->Bookmark('Start of the document');

        $mpdf->WriteHTML($mystr);
        
        
         $footer = get_footer_contents();

         $footer_cont = '
          <table style="text-align: center; width:100%; margin-top:10px;">';
    
          
    
          foreach ($footer as $data_f) {
    
            $fs = $data_f->font_size;
            $fb = $data_f->font_size = 1 ? 'bold' : '';
            $footer_cont .= '      
              <tr><td style="padding: 2px; font-size:'.$fs.'px; font-weight:'.$fb.';">'.$data_f->content_text.'</td><tr>
            ';
          }
    
          $footer_cont .= '
          </table>';

        $mpdf->SetHTMLFooter($footer_cont);

        $invoive_name = $invoice->invoice_number."_".time().'.pdf';
        $mpdf->Output($invoive_name,"D");

}






public function model_invoice_expenses_pdf($invoice_number){

    // $data['view'] = 'generate-invoice-pdf';

    $invoice = $this->home_model->get_invoive_detail($invoice_number);
    $model_data = $this->home_model->model_agreed_data($invoice_number);
    $headers = $this->home_model->get_invoive_headers($invoice_number);
    $expenses = $this->home_model->get_invoice_expenses($invoice_number);
    $services = $this->home_model->get_invoice_service($invoice_number);
    $user_id = $this->home_model->user_id();
 
    $mpdf = $this->m_pdf->load();    
    $mypdfData = $this->load->view('pdfTesting');
 
    $total_mdl_agreed_amt = 0; 

    $vat_price = 0;
    $ingermany = $invoice->m_ingermany;

     $correction = $invoice->correction == 1 ? '/C' : '';



    $i = 0;

    $hstar = '';              

    foreach ($headers as $header) {  

      if($i%2 == 0){

        $myclass = "singleHRecord alter2";

      }

      else{

        $myclass = "singleHRecord alter1";

      }

      $hstar .= '<div class="'.$myclass.'">

        <div class="singleHRecordTitle"> '.$header->invoive_title.' </div>

        <div class="singleHRecordDesc"> '.$header->invoive_value .'</div>

      </div>';

      $i++;

    }




    $total_mdl_agreed_amt = 0;

 
    $modelExpenses = '';



    if(!empty($expenses)){
 
        $i = 0;        
        $total_sum = 0;        

        foreach ($expenses as $expense) {

          $vat_exp_price = 0;
          $total_mdl_agreed_amt_loc =  $expense->model_exp_amount; 


          $srow1 = '<div>'.$expense->model_expense.'</div>';
          $srow2 = '<div>&nbsp;</div>';
          $srow3 = '<div>&nbsp;</div>';
          $srow5 = '<div>'. $total_mdl_agreed_amt_loc  .'€</div>';

           
           if($expense->vat_include == 1 && $ingermany==1){ 

              if($expense->vat_percent > 0){
                  $vat_exp_price = ($expense->model_exp_amount*$expense->vat_percent)/100;
                  $total_mdl_agreed_amt_loc = $total_mdl_agreed_amt_loc + $vat_exp_price;
              } 

              $srow1 = '<div>'.$expense->model_expense.'</div><div class="secondDiv">  Plus VAT </div>';
              $srow2 = '<div>&nbsp;</div><div class="secondDiv"> '. $expense->vat_percent .'%</div>';
              $srow3 = '<div>'.$expense->model_exp_amount.'€</div><div class="secondDiv"> '. $vat_exp_price .'€</div>';
              $srow5 = '<div>&nbsp;</div><div class="secondDiv"> '. $total_mdl_agreed_amt_loc  .'€</div>';
          }
          $total_mdl_agreed_amt = $total_mdl_agreed_amt + $total_mdl_agreed_amt_loc;
          $total_sum = $total_sum + ($total_mdl_agreed_amt_loc + $vat_exp_price);


         


          if($i%2 == 0){

            $myclass = "model5Coloumn alter2";

          }

          else{

            $myclass = "model5Coloumn alter1";

          }

           $i++;

           $stext = '';
           if(count($expenses) == $i){  
              $stext =  $total_sum.'€ ';  
            }

          $modelExpenses .= '<div class="'.$myclass.'">

            <div class="invoiceHInfoSingleLarge"> 
              <div class="invoiceHInfoTitle   "> '.$srow1.' </div>
            </div>

             <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> '.$srow2.' </div>
            </div>

             <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> &nbsp; </div>
            </div>

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> '.$srow3.' </div>
            </div> 

            

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> '.$srow5.'</div>
            </div> 

          </div>'; 

        }

      } 
 
     

        $mystr =  ' 

         <!DOCTYPE html>

          <html>

          <head>

            <title></title>

            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

            <style type="text/css">

              .invoiceHeader{

                  text-align: center;

                  font-size: 15px;
                  font-weight: bold;

                  color: #000;  

                  padding-bottom: 5px; 


              }

              .headerData{

                padding-top: 20px;
                font-size:12px;

              }

              .singleHRecordTitle{

                font-weight:400;

                width:33.33%;

                float:left;

                color: #000;               

              }

              .singleHRecordDesc{

                width:66.66%;

                float:left; 

                color: #000;                 

              }

              .addressHRecord{ 
                padding-bottom: 5px;
 

              }

              .singleHRecordCompany{

                color: #000;

              }

              .fontbold{

               font-weight:bold;

              }

              .font-sm{

                font-size: 13px;

              }

              .invoiceHInfo{

                padding-bottom:20px;

              }

              .invoiceHInfo .invoiceHInfoSingle{

                 width: 33.33%;

                 float: left;
                 font-size:12px;



              }

              .invoiceHInfoTitle{

                color : #000;
                font-size:12px;

              }

              .alter1{

                // background-color:#fff;

                // padding: 8px 5px;
                margin-bottom: 5px;

              }

              .alter2{

                // background-color:#f1f1f1;

                // padding: 5px;
                 margin-bottom: 5px;

              }

              .displaymodelBudget{

                // background-color: #333;

                padding: 20px 0 0 0;
              }



              .displaymodelBudget .singleHRecordTitle, .displaymodelBudget .singleHRecordDesc{

                // color: #fff !important;
                font-size:12px;

              }

              .behalyOfModel{

                font-style: italic;

                margin-top: 15px;

                padding-bottom:5px;

                // border-bottom: 2px solid #e1e1e1;
                text-decoration:underline;

                color: #000;
                font-size:13px !important;
                margin-bottom:5px;

              }

              .rightText{

                text-align: right;

              }



              .model5Coloumn{

                width: 100%;
                font-size:12px;

              }

              .invoiceHInfoSingleLarge{

                width:30%;

                float:left;

                color: #000;
                font-size:12px;

              }

              .invoiceHInfoSingleSmall{

                width:17%;

                float:left;

                color: #000;

              }

              .colorwhite .invoiceHInfoSingleSmall .invoiceHInfoDescriptionsm, .colorwhite .invoiceHInfoSingleLarge .invoiceHInfoTitleLarge {
                // color: #fff !important;
                font-size:12px;
              }
              .secondDiv{
                margin-top: 5px;
              }
              .top55px{
                margin-top: 50px;
              }
              .totaldispamt{
                padding:4px 0 !important;
                margin-top: 20px;
                border-top: 2px solid #ccc;
                border-bottom: 2px solid #ccc;
              }



            </style>

          </head>

          <body>
 

            <div class="headerData">

              <div class="addressHRecord alter1">

                <div class="singleHRecordCompany fontbold top55px"> '. $invoice->i_company_name .' </div>

                <div class="singleHRecordCompany"> '. $invoice->i_address_line1.', '.$invoice->i_address_line2 .' </div>

                <div class="singleHRecordCompany"> '. $invoice->i_city.', '.$invoice->i_pincode .' </div>

                <div class="singleHRecordCompany font-sm"> '. strtoupper($invoice->i_country) .' </div>

              </div>

               <div class="invoiceHeader fontbold"> INVOICE </div> 

              <div class="invoiceHInfo alter2">

                <div class="invoiceHInfoSingle"> 

                  <div class="invoiceHInfoTitle fontbold"> Ticket ID </div>

                  <div class="invoiceHInfoDescription"> #'. $invoice->issue_id .'</div>

                </div>

                <div class="invoiceHInfoSingle"> 

                  <div class="invoiceHInfoTitle fontbold"> Invoice Number </div>

                  <div class="invoiceHInfoDescription">'. $invoice->invoice_number.$correction .'</div>

                </div>

                <div class="invoiceHInfoSingle"> 

                  <div class="invoiceHInfoTitle fontbold"> Date </div>

                  <div class="invoiceHInfoDescription">'. date('d/m/Y', strtotime($invoice->invoice_date)) .'</div>

                </div>                 

              </div>



              <div class="singleHRecord alter1">

                <div class="singleHRecordTitle"> Model </div>

                <div class="singleHRecordDesc"> '. $invoice->m_model_name.', '.$invoice->m_name. ', '.$invoice->m_address_line1. ' - '.$invoice->m_pincode. ', '.$invoice->m_city. ', '.$invoice->m_country .'</div>

              </div>

              <div class="singleHRecord alter2">

                <div class="singleHRecordTitle"> TIN </div>

                <div class="singleHRecordDesc"> '. $invoice->m_vat_tin_number .'</div>

              </div>

              <div class="singleHRecord alter1">

                <div class="singleHRecordTitle"> Provided by Trademark </div>

                <div class="singleHRecordDesc">  Most Wanted Model® </div>

              </div>



              <div class="singleHRecord alter2">

                <div class="singleHRecordTitle"> Customer </div>

                <div class="singleHRecordDesc"> '. $invoice->i_company_name .'</div>

              </div>

              <div class="singleHRecord alter1">

                <div class="singleHRecordTitle"> Booking Date </div>

                <div class="singleHRecordDesc"> '. date('d/m/Y', strtotime($invoice->creation_date)) .'-'.date('d/m/Y', strtotime($invoice->job_date_till)).'</div>

              </div>

              <div class="singleHRecord alter2">

                <div class="singleHRecordTitle"> Uses </div>

                <div class="singleHRecordDesc"> '. $invoice->uses .'</div>

              </div>

              '.$hstar .'<div>'. $model_budget_txt .'</div>

        

              <div class=" behalyOfModel">
                <div class="singleHRecordCompany fontbold">  Invoicing on behalf of the model expenses  </div>
              </div> 
              </div>'.' <div>'. $modelExpenses .'</div>

            

            

           
              <div class="model5Coloumn alter2 displaymodelBudget colorwhite totaldispamt">
              <div class="invoiceHInfoSingleLarge"> 
                <div class="invoiceHInfoTitleLarge "> <b>Total Amount</b> </div>
              </div>

              <div class="invoiceHInfoSingleSmall"> 
                <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
              </div>

              <div class="invoiceHInfoSingleSmall"> 
                <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
              </div>

              

              <div class="invoiceHInfoSingleSmall"> 
                <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
              </div>  

              <div class="invoiceHInfoSingleSmall"> 
                <div class="invoiceHInfoDescriptionsm rightText"> '.$total_mdl_agreed_amt .'€  </div>
              </div>
             


             
            </div>

          </body>

          </html>';
          
          $mpdf->SetHTMLHeader('<div class="invoiceHeader fontbold"> <img style="float:right; height:35px; width: auto;" src="'.base_url('assets/frontend/images/logo.png').'"/></div> 
            <div style="font-size: 10px; margin: 8px 0; padding-bottom:50px;">Select Inc. Corregimiento Obarrio, Calle 58 Este y Calle 50 Edificio Office One piso 12 Oficina 1207, Panama City, Panama</div>');


        $mpdf->Bookmark('Start of the document');

        $mpdf->WriteHTML($mystr);
        
        
         $footer = get_footer_contents();

     $footer_cont = '
      <table style="text-align: center; width:100%; margin-top:10px;">';

      

      foreach ($footer as $data_f) {

        $fs = $data_f->font_size;
        $fb = $data_f->font_size = 1 ? 'bold' : '';
        $footer_cont .= '      
          <tr><td style="padding: 2px; font-size:'.$fs.'px; font-weight:'.$fb.';">'.$data_f->content_text.'</td><tr>
        ';
      }

      $footer_cont .= '
      </table>';

        $mpdf->SetHTMLFooter($footer_cont);

        $invoive_name = $invoice->invoice_number."_".time().'.pdf';
        $mpdf->Output($invoive_name,"D");

}





public function mwm_invoice_pdf($invoice_number){

    // $data['view'] = 'generate-invoice-pdf';

    $invoice = $this->home_model->get_invoive_detail($invoice_number);
    $model_data = $this->home_model->model_agreed_data($invoice_number);
    $headers = $this->home_model->get_invoive_headers($invoice_number);
    $expenses = $this->home_model->get_invoice_expenses($invoice_number);
    $services = $this->home_model->get_invoice_service($invoice_number);
    $user_id = $this->home_model->user_id();


    $mpdf = $this->m_pdf->load();    
    $mypdfData = $this->load->view('pdfTesting');
 
    $total_mdl_agreed_amt = 0; 

    $vat_price = 0;
    $ingermany = $invoice->m_ingermany;

     $correction = $invoice->correction == 1 ? '/C' : '';



    $i = 0;

    $hstar = '';              

    foreach ($headers as $header) {  

      if($i%2 == 0){

        $myclass = "singleHRecord alter2";

      }

      else{

        $myclass = "singleHRecord alter1";

      }

      $hstar .= '<div class="'.$myclass.'">

        <div class="singleHRecordTitle"> '.$header->invoive_title.' </div>

        <div class="singleHRecordDesc"> '.$header->invoive_value .'</div>

      </div>';

      $i++;

    }



    $model_budget_txt = '';


   if($invoice->model_budget > 0){
      // if($invoice->apply_model_fee == 1){

    if($invoice->model_budget != $invoice->model_total_agreed){

      $model_budget = $invoice->model_budget;
      $showm_db = '&nbsp;';
      if(empty($model_data)){
        if($invoice->m_vat_percent <= 0 || $invoice->m_ingermany != 1){
          $showm_db = $model_budget;
        }
      } 


      $model_budget_txt = ' <div class="model5Coloumn alter2 displaymodelBudget colorwhite ">
        <div class="invoiceHInfoSingleLarge"> 
          <div class="invoiceHInfoTitleLarge "> '.$invoice->modelnametext1.' </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
        </div>

        

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> '.$model_budget .'€  </div>
        </div>
        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> '.$showm_db.'€ </div>
        </div>  
      </div> ';  
    }
  // }
}


$modal_data_text = '';

// $total_agreed_amount = $invoice->additional_modal_price;
$total_agreed_amount = $invoice->apply_model_fee == 1 ? $invoice->model_budget : $invoice->additional_modal_price;

if($invoice->reverse_invoice == 1){
  $total_agreed_amount = $invoice->apply_model_fee == 1 ? $invoice->additional_modal_price : $invoice->model_budget;
}

if(!empty($model_data)){

  $i = 0;
  $len = count($model_data);
  $tdata_text = '';
  foreach ($model_data as $modeldata) {
    $total_agreed_amount = $total_agreed_amount + $modeldata->amount;
    if($invoice->m_vat_percent > 0 || $ingermany != 1){
      if ($i == $len - 1 && ( $invoice->m_vat_percent > 0 || $ingermany != 1 )) {
        $tdata_text = $total_agreed_amount."€";
      }
    }

    $t1 = '&nbsp;';
    $t2 = '&nbsp;';
    $t3 = '&nbsp;';
    if($modeldata->name != ''){
      $t1 = $modeldata->name;
    }
    if($modeldata->title_1 != ''){
      $t2 = $modeldata->title_1;
    }
    if($modeldata->title_2 != ''){
      $t3 = $modeldata->title_2;
    }



      if($i%2 == 0){
        $myclass = "model5Coloumn alter1";
      }
      else{
        $myclass = "model5Coloumn alter2";
      }

      $i++;
      $stext = '';
      if(count($services) == $i){
        $stext = $ser_total."€ ";
      }
 
      $modal_data_text .= '<div style="color:'.$mycolor.'" class="'.$myclass.'">

        <div class="invoiceHInfoSingleLarge"> 
          <div class="invoiceHInfoTitle   "> '.$t1.' </div>
        </div>

         <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescription rightText"> '.$t2.'</div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescription rightText"> '.$t3.'</div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescription rightText"> '.$modeldata->amount.'€ </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescription rightText"> &nbsp; </div>
        </div> 

      </div>'; 
    }
  }




    $total_mdl_agreed_amt = $total_mdl_agreed_amt +  $total_agreed_amount;
     //checkForGermany($invoice->model_id);

    $modelvattext = '';


    $vat_price = 0;
    if($invoice->m_vat_percent > 0 && $ingermany==1 ){       

      if($invoice->m_vat_percent > 0){
          $vat_price = ($total_agreed_amount*$invoice->m_vat_percent)/100;
          $total_mdl_agreed_amt = $total_mdl_agreed_amt + $vat_price; 
      }
 

      $modelvattext .= '

      <div class="model5Coloumn alter1 ">
        <div class="invoiceHInfoSingleLarge"> 
          <div class="invoiceHInfoTitleLarge "> + VAT </div>
        </div>

        

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> '. $invoice->m_vat_percent .'% </div>
        </div>

         <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText">  &nbsp; </div>
        </div>

        

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> '. $vat_price .'€ </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
        </div>  
      </div> ';
 

   }

     $commisssion  = $invoice->model_agency_comission;      

      $com_price_agree = (( ( $invoice->apply_model_fee == 1 ? $invoice->model_budget : $total_agreed_amount) *  $commisssion)/100);
      $total_mdl_agreed_amt = $total_mdl_agreed_amt + $com_price_agree;

      // $conText = '&nbsp;';
       // if($ingermany!=1){ 
        $conText = $com_price_agree .'€';
       // }

      $modal_commission .= '

      <div class="model5Coloumn alter2 ">
        <div class="invoiceHInfoSingleLarge"> 
          <div class="invoiceHInfoTitleLarge "> Plus Agency Commission <p><small><b>'.$invoice->acommissionothertext.'</b></small></p></div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> '.  $commisssion .'% </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
        </div> ';

        $rev_count = 0;
         if(!empty($invoice->mwm_reverse_data)){
            $r_array = json_decode($invoice->mwm_reverse_data);
            $rev_count = count($r_array);
        }
        if((($invoice->vat_price > 0)&&!empty($ingermany)&&($ingermany==1)) || $rev_count <= 0){ 

          $modal_commission .= '<div class="invoiceHInfoSingleSmall"> 
            <div class="invoiceHInfoDescriptionsm rightText"> '. $conText .' </div>
          </div>

          <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
        </div> </div> ';

        }
        else{

          $modal_commission .= ' <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
        </div> <div class="invoiceHInfoSingleSmall"> 
            <div class="invoiceHInfoDescriptionsm rightText"> '.$conText .' </div>
          </div> </div> ';

        }


      if(($invoice->vat_price > 0)&&!empty($ingermany)&&($ingermany==1)){ 
 
        $com_price_agree_vat = (($com_price_agree * $invoice->vat_price)/100); 
        $total_mdl_agreed_amt = $total_mdl_agreed_amt + $com_price_agree_vat; 


        $modal_commission .= '

          <div class="model5Coloumn alter1 ">
            <div class="invoiceHInfoSingleLarge"> 
              <div class="invoiceHInfoTitleLarge "> + VAT </div>
            </div>
  
            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescriptionsm rightText"> '.$invoice->vat_price.'% </div>
            </div> 

             <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
            </div>

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescriptionsm rightText"> '.$com_price_agree_vat .'€</div>
            </div>

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescriptionsm rightText"> '.($com_price_agree + $com_price_agree_vat) .'€  </div>
            </div>

          </div> ';

      }

      $total_mdl_agreed_amt = $com_price_agree + $com_price_agree_vat;

  $invoice->additional_modal_text = $invoice->additional_modal_text != '' ? $invoice->additional_modal_text : '&nbsp;';


        $mystr =  ' 

         <!DOCTYPE html>

          <html>

          <head>

            <title></title>

            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

            <style type="text/css">

             .invoiceHeader{

                  text-align: center;

                  font-size: 15px;
                  font-weight: bold;

                  color: #000;  

                  padding-bottom: 5px; 


              }

              .headerData{

                padding-top: 20px;
                font-size:12px;

              }

              .singleHRecordTitle{

                font-weight:400;

                width:33.33%;

                float:left;

                color: #000;               

              }

              .singleHRecordDesc{

                width:66.66%;

                float:left; 

                color: #000;                 

              }

              .addressHRecord{ 
                padding-bottom: 5px;
 

              }

              .singleHRecordCompany{

                color: #000;

              }

              .fontbold{

               font-weight:bold;

              }

              .font-sm{

                font-size: 13px;

              }

              .invoiceHInfo{

                padding-bottom:20px;

              }

              .invoiceHInfo .invoiceHInfoSingle{

                 width: 33.33%;

                 float: left;
                 font-size:12px;



              }

              .invoiceHInfoTitle{

                color : #000;
                font-size:12px;

              }

              .alter1{

                // background-color:#fff;

                // padding: 8px 5px;
                margin-bottom: 5px;

              }

              .alter2{

                // background-color:#f1f1f1;

                // padding: 5px;
                 margin-bottom: 5px;

              }

              .displaymodelBudget{

                // background-color: #333;

                padding: 20px 0 0 0;
              }



              .displaymodelBudget .singleHRecordTitle, .displaymodelBudget .singleHRecordDesc{

                // color: #fff !important;
                font-size:12px;

              }

              .behalyOfModel{

                font-style: italic;

                margin-top: 15px;

                padding-bottom:5px;

                // border-bottom: 2px solid #e1e1e1;
                text-decoration:underline;

                color: #000;
                font-size:13px !important;
                margin-bottom:5px;

              }

              .rightText{

                text-align: right;

              }



              .model5Coloumn{

                width: 100%;
                font-size:12px;

              }

              .invoiceHInfoSingleLarge{

                width:30%;

                float:left;

                color: #000;
                font-size:12px;

              }

              .invoiceHInfoSingleSmall{

                width:17%;

                float:left;

                color: #000;

              }

              .colorwhite .invoiceHInfoSingleSmall .invoiceHInfoDescriptionsm, .colorwhite .invoiceHInfoSingleLarge .invoiceHInfoTitleLarge {
                // color: #fff !important;
                font-size:12px;
              }
              .secondDiv{
                margin-top: 5px;
              }
              .top55px{
                margin-top: 50px;
              }
              .totaldispamt{
                padding:4px 0 !important;
                margin-top: 20px;
                border-top: 2px solid #ccc;
                border-bottom: 2px solid #ccc;
              }


            </style>

          </head>

          <body>

                    

            <div class="headerData">

              <div class="addressHRecord alter1">

                <div class="singleHRecordCompany fontbold top55px"> '. $invoice->i_company_name .' </div>

                <div class="singleHRecordCompany"> '. $invoice->i_address_line1.', '.$invoice->i_address_line2 .' </div>

                <div class="singleHRecordCompany"> '. $invoice->i_city.', '.$invoice->i_pincode .' </div>

                <div class="singleHRecordCompany font-sm"> '. strtoupper($invoice->i_country) .' </div>

              </div>

               <div class="invoiceHeader fontbold"> INVOICE </div> 

              <div class="invoiceHInfo alter2">

                <div class="invoiceHInfoSingle"> 

                  <div class="invoiceHInfoTitle fontbold"> Ticket ID </div>

                  <div class="invoiceHInfoDescription"> #'. $invoice->issue_id .'</div>

                </div>

                <div class="invoiceHInfoSingle"> 

                  <div class="invoiceHInfoTitle fontbold"> Invoice Number </div>

                  <div class="invoiceHInfoDescription">'. $invoice->invoice_number.$correction .'</div>

                </div>

                <div class="invoiceHInfoSingle"> 

                  <div class="invoiceHInfoTitle fontbold"> Date </div>

                  <div class="invoiceHInfoDescription">'. date('d/m/Y', strtotime($invoice->invoice_date)) .'</div>

                </div>                 

              </div>



              <div class="singleHRecord alter1">

                <div class="singleHRecordTitle"> Model </div>

                <div class="singleHRecordDesc"> '. $invoice->m_model_name.', '.$invoice->m_name. ', '.$invoice->m_address_line1. ' - '.$invoice->m_pincode. ', '.$invoice->m_city. ', '.$invoice->m_country .'</div>

              </div>

              <div class="singleHRecord alter2">

                <div class="singleHRecordTitle"> TIN </div>

                <div class="singleHRecordDesc"> '. $invoice->m_vat_tin_number .'</div>

              </div>

              <div class="singleHRecord alter1">

                <div class="singleHRecordTitle"> Provided by Trademark </div>

                <div class="singleHRecordDesc">  Most Wanted Model® </div>

              </div>



              <div class="singleHRecord alter2">

                <div class="singleHRecordTitle"> Customer </div>

                <div class="singleHRecordDesc"> '. $invoice->i_company_name .'</div>

              </div>

               <div class="singleHRecord alter1">

                <div class="singleHRecordTitle"> Booking Date </div>

                <div class="singleHRecordDesc"> '. date('d/m/Y', strtotime($invoice->creation_date)) .'-'.date('d/m/Y', strtotime($invoice->job_date_till)).'</div>

              </div>

              <div class="singleHRecord alter2">

                <div class="singleHRecordTitle"> Uses </div>

                <div class="singleHRecordDesc"> '. $invoice->uses .'</div>

              </div>

              '.$hstar .'<div>'. $model_budget_txt .'</div>

        

              <div class=" behalyOfModel">
                <div class="singleHRecordCompany fontbold">  Invoicing on behalf of the model  </div>
              </div> 

                <div class="model5Coloumn alter2 ">
                  <div class="invoiceHInfoSingleLarge"> 
                   <div class="invoiceHInfoTitleLarge "> '.$invoice->modelnametext2.' <p><small><b>'.$invoice->modelothertext.'</b></small></p></div>
                  </div>

                  <div class="invoiceHInfoSingleSmall"> 
                    <div class="invoiceHInfoDescriptionsm rightText"> '.$invoice->additional_modal_text.' </div>
                  </div>

                  <div class="invoiceHInfoSingleSmall"> 
                    <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
                  </div>

                  <div class="invoiceHInfoSingleSmall"> 
                    <div class="invoiceHInfoDescriptionsm rightText"> '.$invoice->additional_modal_price .'€  </div>
                  </div>

                  <div class="invoiceHInfoSingleSmall"> 
                    <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
                  </div>  
                </div> 


              </div>' . $modal_data_text . ' '. $modelvattext .'

            

            <div class=" behalyOfModel">

                <div class="singleHRecordCompany fontbold"> Invoicing on behalf of the Most Wanted Models @ Agency Germany </div>

              </div> '.$modal_commission.'
           
              <div class="model5Coloumn alter2 displaymodelBudget colorwhite totaldispamt">
              <div class="invoiceHInfoSingleLarge"> 
                <div class="invoiceHInfoTitleLarge "> <b>Total Amount</b> </div>
              </div>

              <div class="invoiceHInfoSingleSmall"> 
                <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
              </div>

              <div class="invoiceHInfoSingleSmall"> 
                <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
              </div>

              

              <div class="invoiceHInfoSingleSmall"> 
                <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
              </div>  

              <div class="invoiceHInfoSingleSmall"> 
                <div class="invoiceHInfoDescriptionsm rightText"> '.$total_mdl_agreed_amt .'€  </div>
              </div>
            </div> 


             
            </div>

          </body>

          </html>';
          
          $mpdf->SetHTMLHeader('<div class="invoiceHeader fontbold"> <img style="float:right; height:35px; width: auto;" src="'.base_url('assets/frontend/images/logo.png').'"/></div> 
            <div style="font-size: 10px; margin: 8px 0; padding-bottom:50px;">Select Inc. Corregimiento Obarrio, Calle 58 Este y Calle 50 Edificio Office One piso 12 Oficina 1207, Panama City, Panama</div>');


        $mpdf->Bookmark('Start of the document');

        $mpdf->WriteHTML($mystr);
        
        $footer = get_footer_contents();

     $footer_cont = '
      <table style="text-align: center; width:100%; margin-top:10px;">';

      

      foreach ($footer as $data_f) {

        $fs = $data_f->font_size;
        $fb = $data_f->font_size = 1 ? 'bold' : '';
        $footer_cont .= '      
          <tr><td style="padding: 2px; font-size:'.$fs.'px; font-weight:'.$fb.';">'.$data_f->content_text.'</td><tr>
        ';
      }

      $footer_cont .= '
      </table>';

        $mpdf->SetHTMLFooter($footer_cont);

        $invoive_name = $invoice->invoice_number."_".time().'.pdf';
        $mpdf->Output($invoive_name,"D");

}

public function partners_invoice_pdf($invoice_number){

    // $data['view'] = 'generate-invoice-pdf';

    $invoice = $this->home_model->get_invoive_detail($invoice_number);
    $model_data = $this->home_model->model_agreed_data($invoice_number);
    $headers = $this->home_model->get_invoive_headers($invoice_number);
    $expenses = $this->home_model->get_invoice_expenses($invoice_number);
    $services = $this->home_model->get_invoice_service($invoice_number);
    $user_id = $this->home_model->user_id();
 
    $mpdf = $this->m_pdf->load();    
    $mypdfData = $this->load->view('pdfTesting');
 
    $total_mdl_agreed_amt = 0; 

    $vat_price = 0;
    $ingermany = $invoice->m_ingermany;

     $correction = $invoice->correction == 1 ? '/C' : '';



    $i = 0;

    $hstar = '';              

    foreach ($headers as $header) {  

      if($i%2 == 0){

        $myclass = "singleHRecord alter2";

      }

      else{

        $myclass = "singleHRecord alter1";

      }

      $hstar .= '<div class="'.$myclass.'">

        <div class="singleHRecordTitle"> '.$header->invoive_title.' </div>

        <div class="singleHRecordDesc"> '.$header->invoive_value .'</div>

      </div>';

      $i++;

    }



    $model_budget_txt = '';


    if($invoice->model_budget > 0){
      // if($invoice->apply_model_fee == 1){

    if($invoice->model_budget != $invoice->model_total_agreed){

      $model_budget = $invoice->model_budget;

      $model_budget_txt = ' <div class="model5Coloumn alter2 displaymodelBudget colorwhite ">
        <div class="invoiceHInfoSingleLarge"> 
          <div class="invoiceHInfoTitleLarge "> '.$invoice->modelnametext1.' </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> '.$model_budget .'€  </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
        </div>  
      </div> ';  
    }
  // }
}


$modal_data_text = '';

// $total_agreed_amount = $invoice->additional_modal_price;
$total_agreed_amount = $invoice->apply_model_fee == 1 ? $invoice->model_budget : $invoice->additional_modal_price;

if($invoice->reverse_invoice == 1){
  $total_agreed_amount = $invoice->apply_model_fee == 1 ? $invoice->additional_modal_price : $invoice->model_budget;
}

if(!empty($model_data)){

  $i = 0;
  $len = count($model_data);
  $tdata_text = '';
  foreach ($model_data as $modeldata) {
    $total_agreed_amount = $total_agreed_amount + $modeldata->amount;
    if($invoice->m_vat_percent > 0 || $ingermany != 1){
      if ($i == $len - 1 && ($invoice->m_vat_percent ||  $ingermany != 1 )) {
        $tdata_text = $total_agreed_amount."€";
      }
    }

    $t1 = '&nbsp;';
    $t2 = '&nbsp;';
    $t3 = '&nbsp;';
    if($modeldata->name != ''){
      $t1 = $modeldata->name;
    }
    if($modeldata->title_1 != ''){
      $t2 = $modeldata->title_1;
    }
    if($modeldata->title_2 != ''){
      $t3 = $modeldata->title_2;
    }



      if($i%2 == 0){
        $myclass = "model5Coloumn alter1";
      }
      else{
        $myclass = "model5Coloumn alter2";
      }

      $i++;
      $stext = '';
      if(count($services) == $i){
        $stext = $ser_total."€ ";
      }
 
      $modal_data_text .= '<div style="color:'.$mycolor.'" class="'.$myclass.'">

        <div class="invoiceHInfoSingleLarge"> 
          <div class="invoiceHInfoTitle   "> '.$t1.' </div>
        </div>

         <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescription rightText"> '.$t2.'</div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescription rightText"> '.$t3.'</div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescription rightText"> '.$modeldata->amount.'€ </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescription rightText"> &nbsp; </div>
        </div> 

      </div>'; 
    }
  }




    $total_mdl_agreed_amt = $total_mdl_agreed_amt +  $total_agreed_amount;
     //checkForGermany($invoice->model_id);

    $modelvattext = '';


    $vat_price = 0;
    if($invoice->m_vat_percent > 0 && $ingermany==1){       

      if($invoice->m_vat_percent > 0){
          $vat_price = ($total_agreed_amount*$invoice->m_vat_percent)/100;
          $total_mdl_agreed_amt = $total_mdl_agreed_amt + $vat_price; 
      }
 

      $modelvattext .= '

      <div class="model5Coloumn alter1 ">
        <div class="invoiceHInfoSingleLarge"> 
          <div class="invoiceHInfoTitleLarge "> + VAT </div>
        </div>

        

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> '. $invoice->m_vat_percent .'% </div>
        </div>

         <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText">  &nbsp; </div>
        </div>

        

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> '. $vat_price .'€ </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText">  &nbsp; </div>
        </div>  
      </div> ';
 

   }

  

    $total_mdl_agreed_amt = 0;
    $modelServices = '';


    if(!empty($services)){


      $modelServices = '
      <div class=" behalyOfModel">

                <div class="singleHRecordCompany fontbold"> invoicing on behalf of the Select Inc. </div>

              </div>' ;
 


        $i = 0;
        $ser_total = 0;
        foreach ($services as $service) {

          $vat_ser_price = 0;
          $total_mdl_agreed_amt_loc = 0;
          $mycolor = '#f00';
          $showcal = '-';


          $srow1 = '<div>'.$service->model_service.'</div>';
          $srow2 = '<div>&nbsp;</div>';
          $srow3 = '<div>&nbsp;</div>';
          $srow5 = '<div> (-) '. $service->model_ser_amount  .'€</div>';


          if ($service->status == 1) {   
            $srow5 = '<div> (+) '. $service->model_ser_amount  .'€</div>';
            $total_mdl_agreed_amt_loc = $service->model_ser_amount;
            if(($service->vat_include == 1)&&!empty($ingermany)&&($ingermany==1)){                 

                if($service->vat_percent > 0){
                    $vat_ser_price = ($service->model_ser_amount*$service->vat_percent)/100;
                    $total_mdl_agreed_amt_loc = $total_mdl_agreed_amt_loc + $vat_ser_price;

                    $srow1 = '<div>'.$service->model_service.'</div><div class="secondDiv">  Plus VAT </div>';
                    $srow2 = '<div>&nbsp;</div><div class="secondDiv"> '. $service->vat_percent .'%</div>';
                    $srow3 = '<div>'.$service->model_ser_amount.'€</div><div class="secondDiv"> '. $vat_ser_price .'€</div>';
                    $srow5 = '<div>&nbsp;</div><div class="secondDiv"> (+) '. $total_mdl_agreed_amt_loc  .'€</div>'; 
                }
            }

            $total_mdl_agreed_amt = $total_mdl_agreed_amt + $total_mdl_agreed_amt_loc;
            $mycolor = '';
            

             $ser_total =  $ser_total + ($service->model_ser_amount + $vat_ser_price);

          }

          if($i%2 == 0){
            $myclass = "model5Coloumn alter1";
          }
          else{
            $myclass = "model5Coloumn alter2";
          }

          $i++;
          $stext = '';
          if(count($services) == $i){
            $stext = $ser_total."€ ";
          }



          $modelServices .= '<div style="color:'.$mycolor.'" class="'.$myclass.'">

            <div class="invoiceHInfoSingleLarge"> 
              <div class="invoiceHInfoTitle   "> '.$srow1.' </div>
            </div>

             <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> '.$srow2.' </div>
            </div>

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> &nbsp; </div>
            </div>

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> '.$srow3.'</div>
            </div> 

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> '.$srow5.' </div>
            </div> 

          </div>';

          

        }

      } 





        $mystr =  ' 

         <!DOCTYPE html>

          <html>

          <head>

            <title></title>

            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

            <style type="text/css">

            
             .invoiceHeader{

                  text-align: center;

                  font-size: 15px;
                  font-weight: bold;

                  color: #000;  

                  padding-bottom: 5px; 


              }

              .headerData{

                padding-top: 20px;
                font-size:12px;

              }

              .singleHRecordTitle{

                font-weight:400;

                width:33.33%;

                float:left;

                color: #000;               

              }

              .singleHRecordDesc{

                width:66.66%;

                float:left; 

                color: #000;                 

              }

              .addressHRecord{ 
                padding-bottom: 5px;
 

              }

              .singleHRecordCompany{

                color: #000;

              }

              .fontbold{

               font-weight:bold;

              }

              .font-sm{

                font-size: 13px;

              }

              .invoiceHInfo{

                padding-bottom:20px;

              }

              .invoiceHInfo .invoiceHInfoSingle{

                 width: 33.33%;

                 float: left;
                 font-size:12px;



              }

              .invoiceHInfoTitle{

                color : #000;
                font-size:12px;

              }

              .alter1{

                // background-color:#fff;

                // padding: 8px 5px;
                margin-bottom: 5px;

              }

              .alter2{

                // background-color:#f1f1f1;

                // padding: 5px;
                 margin-bottom: 5px;

              }

              .displaymodelBudget{

                // background-color: #333;

                padding: 20px 0 0 0;
              }



              .displaymodelBudget .singleHRecordTitle, .displaymodelBudget .singleHRecordDesc{

                // color: #fff !important;
                font-size:12px;

              }

              .behalyOfModel{

                font-style: italic;

                margin-top: 15px;

                padding-bottom:5px;

                // border-bottom: 2px solid #e1e1e1;
                text-decoration:underline;

                color: #000;
                font-size:13px !important;
                margin-bottom:5px;

              }

              .rightText{

                text-align: right;

              }



              .model5Coloumn{

                width: 100%;
                font-size:12px;

              }

              .invoiceHInfoSingleLarge{

                width:30%;

                float:left;

                color: #000;
                font-size:12px;

              }

              .invoiceHInfoSingleSmall{

                width:17%;

                float:left;

                color: #000;

              }

              .colorwhite .invoiceHInfoSingleSmall .invoiceHInfoDescriptionsm, .colorwhite .invoiceHInfoSingleLarge .invoiceHInfoTitleLarge {
                // color: #fff !important;
                font-size:12px;
              }
              .secondDiv{
                margin-top: 5px;
              }
              .top55px{
                margin-top: 50px;
              }
              .totaldispamt{
                padding:4px 0 !important;
                margin-top: 20px;
                border-top: 2px solid #ccc;
                border-bottom: 2px solid #ccc;
              }


            </style>

          </head>

          <body>

            
            <div class="headerData">

              <div class="addressHRecord alter1">

                <div class="singleHRecordCompany fontbold top55px"> '. $invoice->i_company_name .' </div>

                <div class="singleHRecordCompany"> '. $invoice->i_address_line1.', '.$invoice->i_address_line2 .' </div>

                <div class="singleHRecordCompany"> '. $invoice->i_city.', '.$invoice->i_pincode .' </div>

                <div class="singleHRecordCompany font-sm"> '. strtoupper($invoice->i_country) .' </div>

              </div>

               <div class="invoiceHeader fontbold"> INVOICE </div> 

              <div class="invoiceHInfo alter2">

                <div class="invoiceHInfoSingle"> 

                  <div class="invoiceHInfoTitle fontbold"> Ticket ID </div>

                  <div class="invoiceHInfoDescription"> #'. $invoice->issue_id .'</div>

                </div>

                <div class="invoiceHInfoSingle"> 

                  <div class="invoiceHInfoTitle fontbold"> Invoice Number </div>

                  <div class="invoiceHInfoDescription">'. $invoice->invoice_number.$correction .'</div>

                </div>

                <div class="invoiceHInfoSingle"> 

                  <div class="invoiceHInfoTitle fontbold"> Date </div>

                  <div class="invoiceHInfoDescription">'. date('d/m/Y', strtotime($invoice->invoice_date)) .'</div>

                </div>                 

              </div>



              <div class="singleHRecord alter1">

                <div class="singleHRecordTitle"> Model </div>

                <div class="singleHRecordDesc"> '. $invoice->m_model_name.', '.$invoice->m_name. ', '.$invoice->m_address_line1. ' - '.$invoice->m_pincode. ', '.$invoice->m_city. ', '.$invoice->m_country .'</div>

              </div>

              <div class="singleHRecord alter2">

                <div class="singleHRecordTitle"> TIN </div>

                <div class="singleHRecordDesc"> '. $invoice->m_vat_tin_number .'</div>

              </div>

              <div class="singleHRecord alter1">

                <div class="singleHRecordTitle"> Provided by Trademark </div>

                <div class="singleHRecordDesc">  Most Wanted Model® </div>

              </div>



              <div class="singleHRecord alter2">

                <div class="singleHRecordTitle"> Customer </div>

                <div class="singleHRecordDesc"> '. $invoice->i_company_name .'</div>

              </div>

               <div class="singleHRecord alter1">

                <div class="singleHRecordTitle"> Booking Date </div>

                <div class="singleHRecordDesc"> '. date('d/m/Y', strtotime($invoice->creation_date)) .'-'.date('d/m/Y', strtotime($invoice->job_date_till)).'</div>

              </div>

              <div class="singleHRecord alter2">

                <div class="singleHRecordTitle"> Uses </div>

                <div class="singleHRecordDesc"> '. $invoice->uses .'</div>

              </div>

              '.$hstar .'<div>'. $model_budget_txt .'</div>

        

              <div class=" behalyOfModel">
                <div class="singleHRecordCompany fontbold">  Invoicing on behalf of the model  </div>
              </div> 

                <div class="model5Coloumn alter2 ">
                  <div class="invoiceHInfoSingleLarge"> 
                    <div class="invoiceHInfoTitleLarge "> '.$invoice->modelnametext2.' <p><small><b>'.$invoice->modelothertext.'</b></small></p></div>
                  </div>

                  <div class="invoiceHInfoSingleSmall"> 
                    <div class="invoiceHInfoDescriptionsm rightText"> '. $invoice->additional_modal_price.' </div>
                  </div>

                  <div class="invoiceHInfoSingleSmall"> 
                    <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
                  </div>

                  <div class="invoiceHInfoSingleSmall"> 
                    <div class="invoiceHInfoDescriptionsm rightText"> '.$invoice->model_total_agreed .'€  </div>
                  </div>

                  <div class="invoiceHInfoSingleSmall"> 
                    <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
                  </div>  
                </div> 


              </div>' . $modal_data_text . ' '. $modelvattext .'

            

            '.$modal_commission.' '.$modelServices.'

           
              <div class="model5Coloumn alter2 displaymodelBudget colorwhite totaldispamt">
              <div class="invoiceHInfoSingleLarge"> 
                <div class="invoiceHInfoTitleLarge "> <b>Total Amount</b> </div>
              </div>

              <div class="invoiceHInfoSingleSmall"> 
                <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
              </div>

              <div class="invoiceHInfoSingleSmall"> 
                <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
              </div>

              

              <div class="invoiceHInfoSingleSmall"> 
                <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
              </div>  

              <div class="invoiceHInfoSingleSmall"> 
                <div class="invoiceHInfoDescriptionsm rightText"> '.$total_mdl_agreed_amt .'€  </div>
              </div>
            </div> 


             
            </div>

          </body>

          </html>';
          
          $mpdf->SetHTMLHeader('<div class="invoiceHeader fontbold"> <img style="float:right; height:35px; width: auto;" src="'.base_url('assets/frontend/images/logo.png').'"/></div> 
            <div style="font-size: 10px; margin: 8px 0; padding-bottom:50px;">Select Inc. Corregimiento Obarrio, Calle 58 Este y Calle 50 Edificio Office One piso 12 Oficina 1207, Panama City, Panama</div>');

        $mpdf->Bookmark('Start of the document');

        $mpdf->WriteHTML($mystr);
        
         $footer = get_footer_contents();

     $footer_cont = '
      <table style="text-align: center; width:100%; margin-top:10px;">';

      

      foreach ($footer as $data_f) {

        $fs = $data_f->font_size;
        $fb = $data_f->font_size = 1 ? 'bold' : '';
        $footer_cont .= '      
          <tr><td style="padding: 2px; font-size:'.$fs.'px; font-weight:'.$fb.';">'.$data_f->content_text.'</td><tr>
        ';
      }

      $footer_cont .= '
      </table>';

        $mpdf->SetHTMLFooter($footer_cont);

        $invoive_name = $invoice->invoice_number."_".time().'.pdf';
        $mpdf->Output($invoive_name,"D");

}

 

// ================== REFUND =================


public function refund_invoice_pdf($invoice_number){

    // $data['view'] = 'generate-invoice-pdf';

    $invoice = $this->home_model->get_invoive_detail($invoice_number);
    $model = $this->home_model->get_model_management_detail_id($invoice->model_id);

    // print_r($client);
    $model_data = $this->home_model->model_agreed_data($invoice_number);
    $headers = $this->home_model->get_invoive_headers($invoice_number);
    $expenses = [];//$this->home_model->get_invoice_expenses($invoice_number);
    $services = $this->home_model->get_invoice_service($invoice_number);
    $user_id = $this->home_model->user_id();
 
    $mpdf = $this->m_pdf->load();    
    $mypdfData = $this->load->view('pdfTesting');
 
    $total_mdl_agreed_amt = 0; 

    $vat_price = 0;
    $ingermany = $invoice->m_ingermany;
    $correction = $invoice->correction == 1 ? '/C' : '';
    $model_budget = $invoice->apply_model_fee == 2 ? $invoice->model_total_agreed : $invoice->model_budget;

    $vat_price = 0;
    if(!empty($ingermany)&&($ingermany==1 && $invoice->m_vat_percent > 0)){
      if($invoice->m_vat_percent > 0){
        $vat_price = ($model_budget*$invoice->m_vat_percent)/100;
      }
   }

   $m_sfee = 0;

   if($invoice->m_service_fee > 0){
      $m_sfee = ($model_budget * $invoice->m_service_fee)/100;
   }
 
  $specialcharges =  $invoice->special_charge_amount < 0 ? 0 :  $invoice->special_charge_amount;
  $specialcharges_vat =  $invoice->special_charget_vat < 0 ? 0 :  $invoice->special_charget_vat;

    $travelcost = $invoice->VatmodelExp + $invoice->modelExp;
    $total_sum = $model_budget + $vat_price - $m_sfee - $specialcharges + $travelcost;


 $travalcost = $invoice->refund == 1 ? $invoice->travel_cost_amount : $invoice->modelExp;
  $travalcost_vat = $invoice->refund == 1 ? $invoice->travel_cost_vat : $invoice->VatmodelExp;


  $total_amount = ($model_budget + $vat_price - $m_sfee - $invoice_info->deduction_amout - $invoice_info->special_charge_amount + $travalcost + $travalcost_vat) < 0 ? 0 : number_format(($model_budget + $vat_price - $m_sfee - $invoice_info->deduction_amout - $invoice_info->special_charge_amount + $travalcost + $travalcost_vat) , 2);



    $modelServices = '';

    $smoel_p = 0;
    if(!empty($services)){

        $i = 0;
        $ser_total = 0;
        foreach ($services as $service) {

          $vat_ser_price = 0;
          $total_mdl_agreed_amt_loc = 0;
          $mycolor = '#f00';
          $showcal = '-';


          $srow1 = '<div>'.$service->model_service.'</div>';
          $srow2 = '<div>&nbsp;</div>';
          $srow3 = '<div>&nbsp;</div>';
          $srow5 = '<div> '. $service->model_ser_amount  .'€</div>';


          if ($service->status == 1) {   
            $srow5 = '<div> '. $service->model_ser_amount  .'€</div>';
            $total_mdl_agreed_amt_loc = $service->model_ser_amount;
            if(($service->vat_include == 1)&&!empty($ingermany)&&($ingermany==1)){                 

                if($service->vat_percent > 0){
                    $vat_ser_price = ($service->model_ser_amount*$service->vat_percent)/100;
                    $total_mdl_agreed_amt_loc = $total_mdl_agreed_amt_loc + $vat_ser_price;

                    $srow1 = '<div>'.$service->model_service.'</div><div class="secondDiv">  Plus VAT </div>';
                    $srow2 = '<div>&nbsp;</div><div class="secondDiv"> '. $service->vat_percent .'%</div>';
                    $srow3 = '<div>'.$service->model_ser_amount.'€</div><div class="secondDiv"> '. $vat_ser_price .'€</div>';
                    $srow5 = '<div>&nbsp;</div><div class="secondDiv"> '. $total_mdl_agreed_amt_loc  .'€</div>'; 
                }
            }
            
             $smoel_p = $smoel_p + $total_mdl_agreed_amt_loc;

            $total_mdl_agreed_amt = $total_mdl_agreed_amt + $total_mdl_agreed_amt_loc;
            $mycolor = '';
            
            $ser_total =  $ser_total + ($service->model_ser_amount + $vat_ser_price);
          }

          $mymdl_fee = $mymdl_fee - ($service->model_ser_amount + $vat_ser_price);

          if($i%2 == 0){
            $myclass = "model5Coloumn alter1";
          }
          else{
            $myclass = "model5Coloumn alter2";
          }

          $i++;
          $stext = '';
          if(count($services) == $i){
            $stext = $ser_total."€ ";
          }


          $modelServices .= '<div style="color:'.$mycolor.'" class="'.$myclass.'">

            <div class="invoiceHInfoSingleLarge"> 
              <div class="invoiceHInfoTitle   "> '.$srow1.' </div>
            </div>

             <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> '.$srow2.' </div>
            </div>

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> &nbsp; </div>
            </div>

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> '.$srow3.' </div>
            </div> 

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText">'.$srow5.' </div>
            </div> 

          </div>';
           
        }

      } 
 

      $hstr = '';

              if(!empty($headers)){

                $hcount = count($headers);
                $loop = $hcount/2;   
                if($loop >= 1){
                for ($i=0; $i < $loop; $i++) {  

                $hstr .= '<div class="r4cont"> 
                  <div class="r4"><div class="mtitle">'.$headers[$i]->invoive_title.'</div></div>
                  <div class="r4"><div class="mdesc">'.$headers[$i]->invoive_value.'</div></div>';

                  $i++;
                  $hstr .= '<div class="r4"><div class="mtitle">'.$headers[$i]->invoive_title.'</div></div>
                  <div class="r4"><div class="mdesc">'.$headers[$i]->invoive_value.'</div></div>
                </div>'; 
  
                }
              }

              if($hcount % 2 > 0){

                if($hcount <= 1){
                  $i = 0;
                }
               
              $hstr .= '<div class="r4cont"> 
                <div class="r4"><div class="mtitle">'.$headers[$i]->invoive_title.'</div></div>
                <div class="r34"><div class="mdesc">'.$headers[$i]->invoive_value.'</div></div>
              </div>';
              
              }
              }
            
              




        $mystr =  ' 

         <!DOCTYPE html>

          <html>

          <head>

            <title></title>

            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

            <style type="text/css">

              .invoiceHeader{

                  text-align: center;

                  font-size: 18px;
                  font-weight: bold;

                  color: #000; 

                   
                  padding-bottom: 5px; 

              }

              .headerData{

                margin-top: 10px;

              }

              .singleHRecordTitle{

                font-weight:400;

                width:33.33%;

                float:left;

                color: #000;               

              }

              .singleHRecordDesc{

                width:66.66%;

                float:left; 

                color: #000;                 

              }

              .addressHRecord{
 

                padding-bottom: 5px; 


              }

              .singleHRecordCompany{

                color: #000;

              }

              .fontbold{

               font-weight:bold;

              }

              .font-sm{

                font-size: 13px;

              }

              .invoiceHInfo{

 

              }

              .invoiceHInfo .invoiceHInfoSingle{

                 width: 33.33%;

                 float: left;



              }

              .invoiceHInfoTitle{

                color : #000;

              }

              .alter1{

                background-color:#fff;

                padding: 8px 5px;

              }

              .alter2{

                background-color:#f1f1f1;

                padding: 5px;

              }

              .displaymodelBudget{

                // background-color: #333;

                padding: 5px;

                

              }



              .displaymodelBudget .singleHRecordTitle, .displaymodelBudget .singleHRecordDesc{

                color: #fff !important;

              }

              .behalyOfModel{

                font-style: italic;

                margin-top: 15px;

                padding-bottom:5px;

                border-bottom: 2px solid #e1e1e1;

                color: #000;

              }

              .rightText{

                text-align: right;

              }



              .model5Coloumn{

                width: 100%;

              }

              .invoiceHInfoSingleLarge{

                width:30%;

                float:left;

                color: #000;

              }

              .invoiceHInfoSingleSmall{

                width:17%;

                float:left;

                color: #000;

              }

              .colorwhite .invoiceHInfoSingleSmall .invoiceHInfoDescriptionsm, .colorwhite .invoiceHInfoSingleLarge .invoiceHInfoTitleLarge {
                color: #fff !important;
              }
              .secondDiv{
                margin-top: 5px;
              }

              .modelDetails{
                padding-top:55px;
              }

              .borderCredit{
                border-top:1px solid #666;
                border-bottom:1px solid #666;
                padding: 4px 20px;
                text-align:right;
                font-size: 16px !important;
              }

              .borderMdldetail{
                background-color: #e1e1e1;
                padding: 5px;
                box-shadow: 5px 5px #000;
              }

              .r4cont{ 
                width:100%;
                padding: 2px;
                border-bottom:1px solid #666;
              }
             .r4{
                float:left;
                width:24.9%;
                
              }
              .r34{
                float:right;
                width:75%;
              }
              .mdesc{
                background-color: #ccc;
              }

              .refundInvoice{
                background-color: #e1e1e1;
                padding: 5px;
                box-shadow: 5px 5px #000;
              }


              .irow{ 
                width:100%;
                padding: 2px;
                border-bottom:1px solid #666;
                 
              }
             .one3rd{
                float:left;
                width:75%; 
              }
              .one4th{
                float:right;
                width:24.9%;
              }

              .idesc{
                background-color: #ccc;
                text-align:right;
              }

              .splrow{
                width: 100%;
              }

              .w40{
                float:left;
                width:39%;
              }
              .w60{
                float:right;
                width:60%;
                background-color: #ccc;
                margin-top:5px;
              }

              .fleft{
                float:left;
                width:59%;
              }
              .fright{
                float:right;
                width:40%;
                text-align:right;
              }


            </style>



          </head>

          <body>

            <div class="modelDetails">
              <div >'.$model->name.'</div>
              <div>'.$model->address_line1.'</div>
              <div>'.$model->city.', '.$model->pincode.'</div>
              <div>'.$model->country.'<br/> <br/></div> 
            </div>

            <div class="borderMdldetail">
              <div class="borderCredit"> credit note &nbsp;&nbsp;&nbsp;&nbsp; '.$invoice->credit_note.' </div>

              <div class="r4cont"> 
                <div class="r4"> <div class="mtitle">Modelname</div></div>
                <div class="r4"><div class="mdesc">'. $invoice->m_model_name.', '.$invoice->m_name. ', '.$invoice->m_address_line1. ' - '.$invoice->m_pincode. ', '.$invoice->m_city. ', '.$invoice->m_country .'</div></div>
                <div class="r4"><div class="mtitle">&nbsp;&nbsp;Date of job</div></div>
                <div class="r4"><div class="mdesc">'. date('d/m/Y', strtotime($invoice->job_date)).'-'.date('d/m/Y', strtotime($invoice->job_date_till)) .'</div></div>
              </div>

              <div class="r4cont"> 
                <div class="r4"><div class="mtitle">Taxnumber</div></div>
                <div class="r4"><div class="mdesc">'. $invoice->m_vat_tin_number .'</div></div>
                <div class="r4"><div class="mtitle">&nbsp;&nbsp;Job Nr</div></div>
                <div class="r4"><div class="mdesc">'. $invoice_number .'</div></div>
              </div>'.$hstr.'



              <div class="r4cont"> 
                <div class="r4"><div class="mtitle">Client</div></div>
                <div class="r34"><div class="mdesc">'. $invoice->i_company_name .'</div></div>
              </div>

              <div class="r4cont"> 
                <div class="r4"><div class="mtitle">Uses</div></div>
                <div class="r34 full"><div class="mdesc">'. $invoice->uses .'</div></div>
              </div>
            </div>

            <div style="font-size: 13px; margin: 15px 0;"> We Invoiced as follows in your name: </div>
            

            <div class="refundInvoice">  
                <div class="irow">
                    <div class="one3rd"> Honorarium '.$invoice->honorarium_text.' </div>
                    <div class="one4th"> <div class="idesc">'. number_format($model_budget, 2) .'€</div> </div>

                    <div class="splrow">
                        <div class="w40">&nbsp;</div>
                        <div class="w60"><div class="fleft"> VAT &nbsp; &nbsp; '. number_format($invoice->m_vat_percent, 1) .'% </div> <div class="fright"> + '. number_format($vat_price, 2) .'€  </div> </div>
                    </div> 
                </div> 

                <div class="irow">
                    <div class="one3rd"> Servicefee &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  '.number_format($invoice->m_service_fee, 2).'% 
                    <div style="font-size: 11px; margin: 2px 0;"> VAT free, because placeof performance at the place of residence of the recipient </div>
                    </div> 
                    <div class="one4th"> <div class="idesc"> - '. number_format($m_sfee, 2) .'€</div> </div>
                </div> 

                 <div class="irow">
                    <div class="one3rd"> Specialcharge &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  '. number_format( $specialcharges_vat, 2) .'% 
                    <div style="font-size: 11px; margin: 2px 0;"> VAT free, because placeof performance at the place of residence of the recipient </div>
                    </div> 
                    <div class="one4th"> <div class="idesc"> - '. number_format($specialcharges, 2)  .'€</div> </div>
                </div> 

                <div class="irow">
                    <div class="one3rd"> ' . $invoice->deduction_text . '  
                    <div style="font-size: 11px; margin: 2px 0;"> VAT free, because placeof performance at the place of residence of the recipient </div>
                    </div> 
                    <div class="one4th"> <div class="idesc"> - '. number_format($invoice->deduction_amout, 2) .'€</div> </div>
                </div> 

                <div class="irow">
                    <div class="one3rd"> SUBTOTAL </div> 
                    <div class="one4th"> <div class="idesc">'. number_format(($model_budget + $vat_price - $m_sfee - $invoice->deduction_amout) , 2) .'€</div> </div>
                </div>

                <div class="irow">
                    <div class="one3rd"> Travel costs </div> 
                    <div class="one4th"> <div class="idesc"> + '. number_format($travalcost , 2) .'€</div> </div>
                    <div class="splrow">
                        <div class="w40">&nbsp;</div>
                        <div class="w60"><div class="fleft"> VAT &nbsp; &nbsp; '. number_format($invoice->travelcost_percent, 2) .'</div> <div class="fright"> + <span> '. number_format($travalcost_vat, 2).'</span> €  </div> </div>
                      
                    </div>  
                </div>

                <div class="irow">
                   <div class="splrow">
                        <div class="w40">CREDIT</div>
                        <div class="w60"><div class="fleft"> includes VAT &nbsp; &nbsp; '. number_format(0, 1) .' </div> <div class="fright"> '. number_format(($model_budget + $vat_price - $m_sfee - $invoice->deduction_amout + $travalcost + $travalcost_vat), 2) .'€  </div> </div>
                    </div> 
                </div>

            </div> 
             
            </div>

          </body>

          </html>';


          $footer = get_footer_contents();
          $footer_cont = '
          <table style="text-align: center; width:100%; margin-top:10px;">
          <tr><td style="padding:30px 0px; font-weight:bold;">money send by transfer</td></tr>
          <tr><td style="padding: 2px; font-size: 12px; font-weight:bold; border-bottom: 1px solid #000;"> Select Partners Inc. </td><tr>
          <tr><td>Corregimiento Obarrio, Calle 58 Este y Calle 50 Edificio Office One piso 12 Oficina 1207 Panama City, Panama TAXID: RUC 2571137-1-829489</td></tr></table>';


        $mpdf->Bookmark('Start of the document');

        $mpdf->SetHTMLHeader('<!DOCTYPE html>
        <html>
        <head>
          <title></title>
        </head> <body ><div class="mySelHeader"> <div style="text-align: right;"> <img style="height:35px; width: auto;" src="'.base_url('assets/frontend/images/logo.png').'"/> </div>  <div style="font-size: 10px; margin: 8px 0; padding-bottom:50px;">Select Inc. Corregimiento Obarrio, Calle 58 Este y Calle 50 Edificio Office One piso 12 Oficina 1207, Panama City, Panama</div></div> </body>
        </html>');

        $mpdf->WriteHTML($mystr);
        $mpdf->SetHTMLFooter($footer_cont);

        $invoive_name = $invoice->invoice_number."_".time().'.pdf';
        $mpdf->Output($invoive_name,"D");

}



public function download_client_list_pdf(){

    // $data['view'] = 'generate-invoice-pdf';

    $client_id = $this->input->post('client_d_f');
    $date_from = $this->input->post('ddate_from');
    $date_to = $this->input->post('ddate_to');

    $invoices = $this->home_model->client_list_invoice_data($client_id, $date_from, $date_to);
    $_client = $this->home_model->client_details_pdf($client_id);
    
    $mpdf = $this->m_pdf->load();    
    $mypdfData = $this->load->view('pdfTesting');

    $count = 0;

    $mob_bud = 0;
    $mob_bud_vat = 0;
    $mob_mwm = 0;
    $mob_mwm_vat = 0;
    $mob_total = 0;

    $mob_total_mwm = 0;
    
    $strall = '';
    $str1 = '';

    $hdr = '';

   if(!empty($_client)){
      $hdr ='
        <tr class="no-border"><th colspan="6" class="text-left"> '.$_client->company_name.' </th> </tr>
        <tr class="no-border"><td colspan="6"> '.$_client->address_line1.', '.$_client->address_line1.'</td> </tr>
        <tr class="no-border"><td colspan="6"> <b>'.$_client->country.'</b> </td> </tr>
      ';
    }

    $hnamedata = '  <tr class="no-border"><th colspan="9" class="center" style="font-size: 18px;"> Invoice List </th> </tr>';

        if(!empty($date_from) &&  !empty($date_to)){
           $hnamedata .= ' <tr class="no-border"><td colspan="9"> Invoice Date : '. $date_from .' - '. $date_to.'</td> </tr>';
        }

    

    foreach ($invoices as $invoice) {
      $modal_vat = 0;
      if($invoice->m_vat_percent > 0){
        $modal_vat = ($invoice->model_budget *$invoice->m_vat_percent)/100;
      }

      $modal_com = 0;
      $modal_com_vat= 0;
      if($invoice->model_agency_comission > 0){
        $modal_com = ($invoice->model_budget *$invoice->model_agency_comission)/100;
      }

      if($modal_com > 0 && $invoice->vat_price > 0){
        $modal_com_vat = ($modal_com *$invoice->vat_price)/100;
      }

      $total_amt = $invoice->model_budget + $invoice->modelExp + $invoice->selectInc + $modal_com + $modal_com_vat;


      $mob_bud += $invoice->model_budget;
      $mob_bud_vat += $modal_vat;
      $mob_mwm += $modal_com;
      $mob_mwm_vat += $modal_com_vat;
      $mob_total += $total_amt;

      $mob_total_mwm += ($invoice->model_budget + $mob_mwm);

      $m_date = date('d-m-Y', strtotime($invoice->invoice_date));
      $strall .= ' <tr>
        <td>'. ++$count .'</td>
        <td>'.$m_date.' </td>
        <td> '.$invoice->invoice_number.'  </td>
        <td>'.$invoice->m_model_name.', '.$invoice->m_name. ', '.$invoice->m_address_line1. ' - '.$invoice->m_pincode. ', '.$invoice->m_city. ', '.$invoice->m_country.' </td>        
        <td class="text-right">€'.$invoice->model_budget.' </td>
        <td class="text-right">€'.$modal_vat.' </td>
        <td class="text-right">€'.$modal_com .' </td>
        <td class="text-right">€'.$modal_com_vat .'  </td>
        <td class="text-right">€'.$total_amt .'</td>
      </tr>';
      }

    $mystr ='
    <style>
    .text-right{
      text-align:right;
    }

    table tr th, table tr td {
      border-bottom: 1px solid #ccc !important;
      padding: 8px 5px;
      font-size:12px;
    }

    table tr.no-border th, table tr.no-border td {
      border-bottom : none;
      font-size:13px;
      padding: 4px 10px;
    }
    .text-left{
      text-align:left;
    }

    table{
      width:100%;
    }

    </style>

     <div class="invoiceHeader fontbold"> <img style="float:right; height:35px; width: auto;" src="'.base_url('assets/frontend/images/logo.png').'"/></div><br/>
    <table >'.$hdr . $hnamedata.'



    <tr>
    <th>#</th>
    <th>Date</th>
    <th>Invoice No.</th>
    <th>Model Name</th>
    <th>Model Fee</th>
    <th>Vat on Model</th>
    <th>MWM Commission</th>
    <th>Vat on Commission</th>
    <th>Total</th>
    </tr>
  

    <tbody>'.$strall.'

    <tr>
            <th>Total</th>
            <th></th>
            <th></th>
            <th></th>
            <td class="text-right">€'. $mob_bud .'</td>
            <td class="text-right">€'. $mob_bud_vat .'</td>
            <td class="text-right">€'. $mob_mwm .'</td>
            <td class="text-right">€'. $mob_mwm_vat .'</td>
            <td class="text-right">€'. $mob_total .'</td>
            
          </tr>
          <tr>
            <th colspan="4">Gesamtabrechnung wie aufgelistel :</th>
            <th>netto</th>
            <th colspan="2" class="text-center">€'. $mob_total_mwm .'</th>
            <th class="">brutto</th>            
            <th class="text-right">€'. $mob_total .'</th>
            
          </tr>
    </tbody>

    </table>

    ';

  
    $mpdf->Bookmark('Start of the document');

    $mpdf->WriteHTML($mystr);

    $invoive_name = time().'.pdf';
    $mpdf->Output($invoive_name,"D");

}




public function download_client_list_pdf_without_vat(){

    // $data['view'] = 'generate-invoice-pdf';

    $client_id = $this->input->post('client_d_f');
    $date_from = $this->input->post('ddate_from');
    $date_to = $this->input->post('ddate_to');

    $invoices = $this->home_model->client_list_invoice_data($client_id, $date_from, $date_to);
    $_client = $this->home_model->client_details_pdf($client_id);
    
    $mpdf = $this->m_pdf->load();    
    $mypdfData = $this->load->view('pdfTesting');

    $count = 0;

    $mob_bud = 0;
    $mob_bud_vat = 0;
    $mob_mwm = 0;
    $mob_mwm_vat = 0;
    $mob_total = 0;

    $mob_total_mwm = 0;
    
    $strall = '';
    $str1 = '';

    $hdr = '';

    if(!empty($_client)){
      $hdr ='
        <tr class="no-border"><th colspan="6" class="text-left"> '.$_client->company_name.' </th> </tr>
        <tr class="no-border"><td colspan="6"> '.$_client->address_line1.', '.$_client->address_line2.'</td> </tr>
        <tr class="no-border"><td colspan="6"> <b>'.$_client->country.'</b> </td> </tr>
      ';
    }

    $hnamedata =' 
        <tr class="no-border"><th colspan="9" class="center" class="center" style="font-size: 18px;"> Invoice List </th> </tr>';

        if(!empty($date_from) &&  !empty($date_to)){
           $hnamedata .=' <tr class="no-border"><td colspan="9"> Invoice Date : '. $date_from .' - '. $date_to.'</td> </tr>';
        }
         

    

    foreach ($invoices as $invoice) {
      $modal_vat = 0;
      // if($invoice->m_vat_percent > 0){
      //   $modal_vat = ($invoice->model_budget *$invoice->m_vat_percent)/100;
      // }

      $modal_com = 0;
      $modal_com_vat= 0;
      if($invoice->model_agency_comission > 0){
        $modal_com = ($invoice->model_budget *$invoice->model_agency_comission)/100;
      }

      // if($modal_com > 0 && $invoice->vat_price > 0){
      //   $modal_com_vat = ($modal_com *$invoice->vat_price)/100;
      // }

      $total_amt = $invoice->model_budget + $invoice->modelExp + $invoice->selectInc + $modal_com + $modal_com_vat;


      $mob_bud += $invoice->model_budget;
      $mob_bud_vat += $modal_vat;
      $mob_mwm += $modal_com;
      $mob_mwm_vat += $modal_com_vat;
      $mob_total += $total_amt;

      $mob_total_mwm += ($invoice->model_budget + $mob_mwm);

      $m_date = date('d-m-Y', strtotime($invoice->invoice_date));
      $strall .= ' <tr>
        <td>'. ++$count .'</td>
        <td>'.$m_date.' </td>
        <td> '.$invoice->invoice_number.'  </td>
        <td>'.$invoice->m_model_name.', '.$invoice->m_name. ', '.$invoice->m_address_line1. ' - '.$invoice->m_pincode. ', '.$invoice->m_city. ', '.$invoice->m_country.' </td>        
        <td class="text-right">€'.$invoice->model_budget.' </td> 
        <td class="text-right">€'.$modal_com .' </td>  
        <td class="text-right">€'.$total_amt .'</td>
      </tr>';
      }

    $mystr ='
    <style>
    .text-right{
      text-align:right;
    }

    table tr th, table tr td {
      border-bottom: 1px solid #ccc !important;
      padding: 8px 5px;
      font-size:12px;
    }

    table tr.no-border th, table tr.no-border td {
      border-bottom : none;
      font-size:13px;
      padding: 4px 10px;
    }
    .text-left{
      text-align:left;
    }

     table{
      width:100%;
    }

    </style>

     <div class="invoiceHeader fontbold"> <img style="float:right; height:35px; width: auto;" src="'.base_url('assets/frontend/images/logo.png').'"/></div><br/>
    <table >'.$hdr. $hnamedata.'.



    <tr>
    <th>#</th>
    <th>Date</th>
    <th>Invoice No.</th>
    <th>Model Name</th>
    <th>Model Fee</th> 
    <th>MWM Commission</th> 
    <th>Total</th>
    </tr>
  

    <tbody>'.$strall.'

    <tr>
            <th>Total</th>
            <th></th>
            <th></th>
            <th></th>
            <td class="text-right">€'. $mob_bud .'</td>
            <td class="text-right">€'. $mob_mwm .'</td>
            <td class="text-right">€'. $mob_total .'</td>
            
          </tr>
          <tr>
            <th colspan="3">Gesamtabrechnung wie aufgelistel :</th>
            <th>netto</th>
            <th colspan=" " class="text-center">€'. $mob_total_mwm .'</th>
            <th class="">brutto</th>            
            <th class="text-right">€'. $mob_total .'</th>
            
          </tr>
    </tbody>

    </table>

    ';

  
    $mpdf->Bookmark('Start of the document');

    $mpdf->WriteHTML($mystr);

    $invoive_name = time().'.pdf';
    $mpdf->Output($invoive_name,"D");

}

  


public function download_mwm_pdf(){

    $month = $this->input->get('month');
    $year = $this->input->get('year');
    $vat = $this->input->get('vat');
    $total_amount = $this->input->get('total_amount');
    $other = trim($this->input->get('other'));

  
    $invoices = $this->home_model->get_mwm_invoices(0, $month, $year, $vat, $total_amount, $other);

    $mpdf = $this->m_pdf->load();    
    $mypdfData = $this->load->view('pdfTesting');

    $hdr = '
      <style>
      table.table tr th, table.table tr td{
        border-bottom: 1px solid #ccc !important;
        padding:5px;
      }
      </style>
     <div style="margin-top:60px;">&nbsp;&nbsp;</div>
     <div style="margin-top:10px;">&nbsp;&nbsp;</div>
      <table style="width:100%;" class="table">
      <tr> <th>Date</th>
      <th>Job Date</th>
      <th>Invoice No.</th>
      <th>Client</th>
      <th>Model</th>
      <th>Amount Accepted</th>
      <th>Accepted Model</th>
      <th>VAT Model</th>
      <th>Agency Comission</th>
      <th>VAT (AC)</th>
      <th>Select </th>
      <th>Total</th>
      </tr>';

      $total_commission = 0;
      foreach ($invoices as $invoice) {
          $total_commission = $total_commission + $invoice->model_comission;

          $hdr .= '<tr style="border:1px solid #ccc;">
            <td>'.date('d-m-Y', strtotime($invoice->creation_date)).' </td>
            <td>'.date('d-m-Y', strtotime($invoice->job_date)) .' </td>
            <td>'.$invoice->invoice_number.' </td>
            <td>'.$invoice->i_company_name.' </td>
            <td>'.$invoice->m_model_name.', '.$invoice->m_name. ', '.$invoice->m_address_line1. ' - '.$invoice->m_pincode. ', '.$invoice->m_city. ', '.$invoice->m_country.' </td>
            <td>'.$invoice->model_budget.' </td>
            <td>'.$invoice->model_total_agreed.' </td>
            <td>'.$invoice->m_vat_percent.'% </td>
            <td>'.$invoice->model_agency_comission.'% </td>
            <td>'.number_format($invoice->vat_price, 2).'% </td>
            <td>'.number_format($invoice->selectInc, 2).'</td>
            <td>'.$invoice->model_comission.'</td>
          </tr>';
      }
      $hdr .= '<tr>
        <th colspan="11"> Total </th>
        <th>'.$total_commission .'</th>
       </tr></table>';


    $mpdf->SetHTMLHeader('<div class="invoiceHeader fontbold"> <img style="float:right; height:35px; width: auto;" src="'.base_url('assets/frontend/images/logo.png').'"/></div> 
            <div style="font-size: 10px; margin: 8px 0; padding-bottom:50px;">Select Inc. Corregimiento Obarrio, Calle 58 Este y Calle 50 Edificio Office One piso 12 Oficina 1207, Panama City, Panama</div>');
    $mpdf->Bookmark('Start of the document');

    $mpdf->WriteHTML($hdr);
    $footer = get_footer_contents();
    $footer_cont = '<table>';
     foreach ($footer as $data_f) {

        $fs = $data_f->font_size;
        $fb = $data_f->font_size = 1 ? 'bold' : '';
        $footer_cont .= '      
          <tr><td style="text-align:center; padding: 2px; font-size:'.$fs.'px; font-weight:'.$fb.';">'.$data_f->content_text.'</td><tr>
        ';
      }

      $footer_cont .= '
      </table>';

        $mpdf->SetHTMLFooter($footer_cont);

    $invoive_name = time().'.pdf';
    $mpdf->Output($invoive_name,"D");

}



public function collective_invoice_pdf(){
    
    $selected_invoices = $this->input->post('selected_invoices');
    // $date_from = $this->input->post('date_from');
    // $date_to = $this->input->post('date_to');
    
    
    $user_id = $this->home_model->user_id();

 
    $invoices = $this->home_model->collective_list_invoice_data_pdf($selected_invoices);
     
    
    $mpdf = $this->m_pdf->load(); 
    // $mypdfData = $this->load->view('pdfTesting');
    
     $hdr = '
      <tr> 
        <th>Date</th>
        <th>Job Date</th>
        <th>Invoice No.</th>
        <th>Client</th>
        <th>Model</th>
        <th>Model Fee</th>
        <th>Model Budget</th>
        <th>VAT Model</th>
        <th>Expenses</th>
        <th>MWM Comission</th>
        <th>VAT (AC)</th>
        <th>Select </th>
        <th>Total</th>
      </tr>';

      foreach ($invoices as $invoice) {

           $hdr .= '<tr>
          <td>'.date('d-m-Y', strtotime($invoice->creation_date)).' </td>
          <td>'.date('d-m-Y', strtotime($invoice->job_date)) .' </td>
          <td>'.$invoice->invoice_number.' </td>
          <td>'.$invoice->i_company_name.' </td>
          <td>'.$invoice->m_model_name.', '.$invoice->m_name. ', '.$invoice->m_address_line1. ' - '.$invoice->m_pincode. ', '.$invoice->m_city. ', '.$invoice->m_country.' </td> 
          <td>'.$invoice->i_fee.' </td> 
          <td>'.$invoice->model_budget.' </td>
          <td>'.$invoice->m_vat_percent.'% </td>
          <td>'.$invoice->modelExp.' </td>
          <td>'.$invoice->model_comission.'% </td>
          
          <td>'.$invoice->vat_price.'% </td>
          <td>'.$invoice->selectInc.' </td>
          <td>'. ($invoice->model_budget + $invoice->vat_price + $invoice->selectInc + $invoice->modelExp ) .'</td></tr>';
      }

    /*$mpdf->SetHTMLHeader('<div class="invoiceHeader fontbold"> <img style="float:right; height:35px; width: auto;" src="'.base_url('assets/frontend/images/logo.png').'"/></div> 
            <div style="font-size: 10px; margin: 8px 0; padding-bottom:50px;">Select Inc. Corregimiento Obarrio, Calle 58 Este y Calle 50 Edificio Office One piso 12 Oficina 1207, Panama City, Panama</div>');
    */
    
    
    
     $mystr ='
    <style>
    .text-right{
      text-align:right;
    }

    table tr th, table tr td {
      border-bottom: 1px solid #ccc !important;
      padding: 8px 5px;
      font-size:12px;
    }

    table tr.no-border th, table tr.no-border td {
      border-bottom : none;
      font-size:13px;
      padding: 4px 10px;
    }
    .text-left{
      text-align:left;
    }

     table{
      width:100%;
    }

    </style>
<div class="invoiceHeader fontbold"> <img style="float:right; height:35px; width: auto;" src="'.base_url('assets/frontend/images/logo.png').'"/></div> 
            <div style="font-size: 10px; margin: 8px 0; padding-bottom:50px;">Select Inc. Corregimiento Obarrio, Calle 58 Este y Calle 50 Edificio Office One piso 12 Oficina 1207, Panama City, Panama</div>
     <br/>
    <table >'.$hdr.'.


    </table>

    ';
    $mpdf->Bookmark('Start of the document');
    $mpdf->WriteHTML($mystr);

    $invoive_name = time().'.pdf';
    
    // error_reporting(E_ALL);
    $mpdf->Output($invoive_name,"D");
   

}





public function download_general_invoice_pdf($invoice_id){


    $invoices = $this->home_model->generate_invoice_details($invoice_id);

    
    $mpdf = $this->m_pdf->load();    
    $mypdfData = $this->load->view('pdfTesting');

    $hstar = '';              

    $headers = $invoices->headers;

    if(!empty( $headers)){

      $headers = json_decode($headers);
      foreach ($headers as $header) {  

        if($i%2 == 0){
          $myclass = "singleHRecord alter2";
        }

        else{
          $myclass = "singleHRecord alter1";
        }

        $hstar .= '<div class="'.$myclass.'">
          <div class="singleHRecordTitle"> '.$header->title.' </div>
          <div class="singleHRecordDesc"> '.$header->details .'</div>
        </div>';

        $i++;

      }
  }

  $currency = '€';

  $currency_array = get_currency_list();
  if(!empty($invoices)){
    if(!empty($currency_array)){
      foreach($currency_array as $curr){

        if($curr->code == $invoices[0]->currency){
          $currency = $curr->symbol ;
        }
      }
    }
  }




    $general_invoice = '';
    $total_amount = 0;

    foreach($invoices as $invoice){

      $total_amount = $total_amount + ($invoice->amount - $invoice->percentage);

      $invoice->name = $invoice->name != ''  ? $invoice->name : '&nbsp;'; 
      $invoice->title_1 = $invoice->title_1 != ''  ? $invoice->title_1 : '&nbsp;'; 
      $invoice->title_2 = $invoice->title_2 != ''  ? $invoice->title_2 : '&nbsp;'; 

      $general_invoice .= ' 

      <div class="model5Coloumn alter2 displaymodelBudget colorwhite ">
        
        <div class="invoiceHInfoSingleLarge"> 
          <div class="invoiceHInfoTitleLarge "> '.$invoice->name.' </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm "> '.$invoice->title_1.' </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> '.$invoice->title_2 .'</div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> '.$currency.$invoice->amount.'€ </div>
        </div>

        <div class="invoiceHInfoSingleSmall">    
          <div class="invoiceHInfoDescriptionsm rightText"> '.$currency.$invoice->percentage.'€ </div>
        </div> 

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> '.$currency.($invoice->amount - $invoice->percentage).'€ </div>
        </div>   

      </div> ';  

    }

    $invoice = $invoices[0];

   $mystr =  ' 

         <!DOCTYPE html>

          <html>

          <head>

            <title></title>

            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

            <style type="text/css">

             .invoiceHeader{

                  text-align: center;

                  font-size: 15px;
                  font-weight: bold;

                  color: #000;  

                  padding-bottom: 5px; 


              }

              .headerData{

                padding-top: 20px;
                font-size:12px;

              }

              .singleHRecordTitle{

                font-weight:400;

                width:33.33%;

                float:left;

                color: #000;               

              }

              .singleHRecordDesc{

                width:66.66%;

                float:left; 

                color: #000;                 

              }

              .addressHRecord{ 
                padding-bottom: 5px;
 

              }

              .singleHRecordCompany{

                color: #000;

              }

              .fontbold{

               font-weight:bold;

              }

              .font-sm{

                font-size: 13px;

              }

              .invoiceHInfo{

                padding-bottom:20px;

              }

              .invoiceHInfo .invoiceHInfoSingle{

                 width: 33.33%;

                 float: left;
                 font-size:12px;



              }

              .invoiceHInfoTitle{

                color : #000;
                font-size:12px;

              }

              .alter1{

                // background-color:#fff;

                // padding: 8px 5px;
                margin-bottom: 5px;

              }

              .alter2{

                // background-color:#f1f1f1;

                // padding: 5px;
                 margin-bottom: 5px;

              }

              .displaymodelBudget{

                // background-color: #333;

                padding: 20px 0 0 0;
              }



              .displaymodelBudget .singleHRecordTitle, .displaymodelBudget .singleHRecordDesc{

                // color: #fff !important;
                font-size:12px;

              }

              .behalyOfModel{

                font-style: italic;

                margin-top: 15px;

                padding-bottom:5px;

                // border-bottom: 2px solid #e1e1e1;
                text-decoration:underline;

                color: #000;
                font-size:13px !important;
                margin-bottom:5px;

              }

              .rightText{

                text-align: right;

              }



              .model5Coloumn{

                width: 100%;
                font-size:12px;

              }

              .invoiceHInfoSingleLarge{

                width:25%;

                float:left;

                color: #000;
                font-size:12px;

              }

              .invoiceHInfoSingleSmall{

                width:14%;

                float:left;

                color: #000;

              }

              .colorwhite .invoiceHInfoSingleSmall .invoiceHInfoDescriptionsm, .colorwhite .invoiceHInfoSingleLarge .invoiceHInfoTitleLarge {
                // color: #fff !important;
                font-size:12px;
              }
              .secondDiv{
                margin-top: 5px;
              }
              .top55px{
                margin-top: 50px;
              }
              .totaldispamt{
                padding:4px 0 !important;
                margin-top: 20px;
                border-top: 2px solid #ccc;
                border-bottom: 2px solid #ccc;
              }


            </style>

          </head>

          <body>

                    

            <div class="headerData">
              <div class="addressHRecord alter1">
                <div class="singleHRecordCompany fontbold top55px"> '. $invoice->address1 .' </div>
                <div class="singleHRecordCompany"> '. $invoice->address2 .' </div>
                <div class="singleHRecordCompany"> '. $invoice->address3 .' </div>
                <div class="singleHRecordCompany font-sm"> '. strtoupper($invoice->address4) .' </div>
              </div>

              <div class="invoiceHeader fontbold"> INVOICE </div> 

              <div class="invoiceHInfo alter2">
                <div class="invoiceHInfoSingle"> 
                  <div class="invoiceHInfoTitle fontbold"> Ticket ID </div>
                  <div class="invoiceHInfoDescription"> #'. $invoice->issue_id .'</div>
                </div>
                <div class="invoiceHInfoSingle"> 
                  <div class="invoiceHInfoTitle fontbold"> Invoice Number </div>
                  <div class="invoiceHInfoDescription">'. $invoice->invoice_number .'</div>
                </div>

                <div class="invoiceHInfoSingle"> 
                  <div class="invoiceHInfoTitle fontbold"> Date </div>
                  <div class="invoiceHInfoDescription">'. date('d/m/Y', strtotime($invoice->i_date)) .'</div>
                </div>                 
              </div>



              <div class="singleHRecord alter1">
                <div class="singleHRecordTitle"> Customer </div>
                <div class="singleHRecordDesc"> '. $invoice->client .'</div>
              </div>

              <div class="singleHRecord alter2">
                <div class="singleHRecordTitle"> TID </div>
                <div class="singleHRecordDesc"> '. $invoice->tin .'</div>
              </div>
           
               <div class="singleHRecord alter1">
                <div class="singleHRecordTitle"> Booking Date </div>
                <div class="singleHRecordDesc"> '. date('d/m/Y', strtotime($invoice->booking_date)) .'</div>
              </div>
            

              '.$hstar .$general_invoice.'

              <div class="model5Coloumn alter2 displaymodelBudget colorwhite totaldispamt ">
              <div class="invoiceHInfoSingleLarge"> 
                <div class="invoiceHInfoTitleLarge "> <b>Total/Gross</b> </div>
              </div>

              <div class="invoiceHInfoSingleSmall"> 
                <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
              </div>

              <div class="invoiceHInfoSingleSmall"> 
                <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
              </div>

              

              <div class="invoiceHInfoSingleSmall"> 
                <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
              </div>  

              <div class="invoiceHInfoSingleSmall"> 
                <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
              </div>
              <div class="invoiceHInfoSingleSmall"> 
                <div class="invoiceHInfoDescriptionsm rightText"> '.$total_amount .'€  </div>
              </div>
            </div>

             
            </div>

          </body>

          </html>';
          
          $mpdf->SetHTMLHeader('<div class="invoiceHeader fontbold"> <img style="float:right; height:35px; width: auto;" src="'.base_url('assets/frontend/images/logo.png').'"/></div> 
            <div style="font-size: 10px; margin: 8px 0; padding-bottom:50px;">Select Inc. Corregimiento Obarrio, Calle 58 Este y Calle 50 Edificio Office One piso 12 Oficina 1207, Panama City, Panama</div>');


        $mpdf->Bookmark('Start of the document');

        $mpdf->WriteHTML($mystr);
        
        $footer = get_footer_contents();

     $footer_cont = '
      <table style="text-align: center; width:100%; margin-top:10px;">';

      

      foreach ($footer as $data_f) {

        $fs = $data_f->font_size;
        $fb = $data_f->font_size = 1 ? 'bold' : '';
        $footer_cont .= '      
          <tr><td style="padding: 2px; font-size:'.$fs.'px; font-weight:'.$fb.';">'.$data_f->content_text.'</td><tr>
        ';
      }

      $footer_cont .= '
      </table>';

        $mpdf->SetHTMLFooter($footer_cont);

        $invoive_name = $invoice->invoice_number."_".time().'.pdf';
        $mpdf->Output($invoive_name,"D");

}








}