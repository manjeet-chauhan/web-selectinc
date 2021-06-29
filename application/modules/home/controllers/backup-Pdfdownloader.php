<?php

//error_reporting(0);

if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Pdfdownloader extends CI_Controller{

	 

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

 
	

public function generate_invoice_pdf($invoice_number){

    // $data['view'] = 'generate-invoice-pdf';

    $invoice = $this->home_model->get_invoive_detail($invoice_number);
    $headers = $this->home_model->get_invoive_headers($invoice_number);
    $expenses = $this->home_model->get_invoice_expenses($invoice_number);
    $services = $this->home_model->get_invoice_service($invoice_number);
    $user_id = $this->home_model->user_id();


    $mpdf = $this->m_pdf->load();    
    $mypdfData = $this->load->view('pdfTesting');



    $total_mdl_agreed_amt = 0; 

    $vat_price = 0;



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
      if($invoice->apply_model_fee == 1){

    if($invoice->model_budget != $invoice->model_total_agreed){

      $model_budget = $invoice->model_budget;

      $model_budget_txt = ' <div class="model5Coloumn alter2 displaymodelBudget colorwhite ">
        <div class="invoiceHInfoSingleLarge"> 
          <div class="invoiceHInfoTitleLarge "> Model Fee Net </div>
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
  }
}





    $total_mdl_agreed_amt = $total_mdl_agreed_amt +  $invoice->model_total_agreed;



    $ingermany = $invoice->m_ingermany; //checkForGermany($invoice->model_id);

    $modelvattext = '';


    $vat_price = 0;
    if(!empty($ingermany)&&($ingermany==1)){       

	    if($invoice->m_vat_percent > 0){
	        $vat_price = ($invoice->model_total_agreed*$invoice->m_vat_percent)/100;
          $total_mdl_agreed_amt = $total_mdl_agreed_amt + $vat_price; 
	    }



	    

	   	$modelvattext .= '

      <div class="model5Coloumn alter1 ">
        <div class="invoiceHInfoSingleLarge"> 
          <div class="invoiceHInfoTitleLarge "> + VAT </div>
        </div>

         <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText">  &nbsp; </div>
        </div>
        
        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> '. $invoice->m_vat_percent .'% </div>
        </div>

        

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> '. $vat_price .'€ </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> '. ($invoice->model_total_agreed + $vat_price) .'€ </div>
        </div>  
      </div> ';
 

	 }

 
    $modelExpenses = '';



    if(!empty($expenses)){



      // $modelExpenses = '<div class="model5Coloumn alter2">

      //   <div class="invoiceHInfoSingleLarge"> 
      //     <div class="invoiceHInfoTitleLarge "> Name </div>
      //   </div>

      //   <div class="invoiceHInfoSingleSmall"> 
      //     <div class="invoiceHInfoDescriptionsm rightText"> Amount </div>
      //   </div>

      //   <div class="invoiceHInfoSingleSmall"> 
      //     <div class="invoiceHInfoDescriptionsm rightText"> + Vat ('.$invoice->m_vat_percent.'%) </div>
      //   </div>

      //   <div class="invoiceHInfoSingleSmall"> 
      //     <div class="invoiceHInfoDescriptionsm rightText"> Sub Amount </div>
      //   </div>

      //    <div class="invoiceHInfoSingleSmall"> 
      //     <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
      //   </div>                 

      // </div>';



        $i = 0;        
        $total_sum = 0;        

        foreach ($expenses as $expense) {

          $vat_exp_price = 0;          

          $total_mdl_agreed_amt_loc =  $expense->model_exp_amount;



          if(($expense->vat_include == 1)&&!empty($ingermany)&&($ingermany==1)){ 

	            if($invoice->m_vat_percent > 0){
	                $vat_exp_price = ($expense->model_exp_amount*$invoice->m_vat_percent)/100;
	                $total_mdl_agreed_amt_loc = $total_mdl_agreed_amt_loc + $vat_exp_price;
	            } 
  		    }
          $total_mdl_agreed_amt = $total_mdl_agreed_amt + $total_mdl_agreed_amt_loc;
          $total_sum = $total_sum + ($total_mdl_agreed_amt_loc + $vat_exp_price);


          if($i%2 == 0){

            $myclass = "model5Coloumn alter1";

          }

          else{

            $myclass = "model5Coloumn alter2";

          }

           $i++;

           $stext = '';
           if(count($expenses) == $i){  
              $stext =  $total_sum.'€ ';  
            }

          $modelExpenses .= '<div class="'.$myclass.'">

            <div class="invoiceHInfoSingleLarge"> 
              <div class="invoiceHInfoTitle   "> '.$expense->model_expense.' </div>
            </div>

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> '.$expense->model_exp_amount.'€ </div>
            </div>

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> '.$vat_exp_price.'€ </div>
            </div>

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> '.($expense->model_exp_amount + $vat_exp_price).'€ </div>
            </div>  

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> '. $stext .' </div>
            </div>

          </div>';

         

    		}

    	} 
 
      // $agency_commission = get_agency_comission();

      $commisssion  = $invoice->model_agency_comission;      

      $com_price_agree = (( ( $invoice->apply_model_fee == 1 ? $invoice->model_budget : $invoice->model_total_agreed) *  $commisssion)/100);

      $total_mdl_agreed_amt = $total_mdl_agreed_amt + $com_price_agree;



    

      $modal_commission .= '

      <div class="model5Coloumn alter2 ">
        <div class="invoiceHInfoSingleLarge"> 
          <div class="invoiceHInfoTitleLarge "> Agency Commission </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> '.  $commisssion .'% </div>
        </div> 
  
         <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> '.$com_price_agree .'€  </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
        </div> 

      </div> ';



      if(($invoice->vat_price > 0)&&!empty($ingermany)&&($ingermany==1)){ 
 
        $com_price_agree_vat = (($com_price_agree * $invoice->vat_price)/100); 
        $total_mdl_agreed_amt = $total_mdl_agreed_amt + $com_price_agree_vat; 


        $modal_commission .= '

          <div class="model5Coloumn alter1 ">
            <div class="invoiceHInfoSingleLarge"> 
              <div class="invoiceHInfoTitleLarge "> + VAT </div>
            </div>

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
            </div>

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescriptionsm rightText"> '.$invoice->vat_price.'% </div>
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

              </div> 
        <div class="model5Coloumn alter2">
        <div class="invoiceHInfoSingleLarge"> 
          <div class="invoiceHInfoTitleLarge "> Name </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> Amount </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText">  Vat ('.$invoice->m_vat_percent.'%) </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> Sub Amount </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
        </div>                 

      </div>';



        $i = 0;
        $ser_total = 0;
        foreach ($services as $service) {

          $vat_ser_price = 0;
          $total_mdl_agreed_amt_loc = 0;
          $mycolor = '#f00';
          $showcal = '-';

          if ($service->status == 1) {   
            $total_mdl_agreed_amt_loc = $service->model_ser_amount;
            if(($service->vat_include == 1)&&!empty($ingermany)&&($ingermany==1)){                 

                if($invoice->m_vat_percent > 0){
                    $vat_ser_price = ($service->model_ser_amount*$invoice->m_vat_percent)/100;
                    $total_mdl_agreed_amt_loc = $total_mdl_agreed_amt_loc + $vat_ser_price;
                } 
            }

            $total_mdl_agreed_amt = $total_mdl_agreed_amt + $total_mdl_agreed_amt_loc;
            $mycolor = '';
            $showcal = '+';

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
              <div class="invoiceHInfoTitle   "> '.$service->model_service.' </div>
            </div>

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> '.$service->model_ser_amount.'€ </div>
            </div>

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> '.$vat_ser_price.'€ </div>
            </div>

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> ('.$showcal.') '. ($service->model_ser_amount + $vat_ser_price) .'€ </div>
            </div>

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> '. $stext .'</div>
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

                  font-size: 25px;

                  color: #000; 

                  border-bottom: 1px solid #e1e1e1;

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

                border-bottom: 1px solid #e1e1e1;

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

                background-color: #333;

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



            </style>

          </head>

          <body>

            <div class="invoiceHeader fontbold"> INVOICE </div>            

            <div class="headerData">

              <div class="addressHRecord alter1">

                <div class="singleHRecordCompany fontbold"> '. $invoice->i_company_name .' </div>

                <div class="singleHRecordCompany"> '. $invoice->i_address_line1.', '.$invoice->i_address_line2 .' </div>

                <div class="singleHRecordCompany"> '. $invoice->i_city.', '.$invoice->i_pincode .' </div>

                <div class="singleHRecordCompany font-sm"> '. strtoupper($invoice->i_country) .' </div>

              </div>



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

                  <div class="invoiceHInfoDescription">'. date('d/m/Y', strtotime($invoice->invoice_date)) .'</div>

                </div>                 

              </div>



              <div class="singleHRecord alter1">

                <div class="singleHRecordTitle"> Model </div>

                <div class="singleHRecordDesc"> '. $invoice->m_model_name .'</div>

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

                <div class="singleHRecordDesc"> '. date('d/m/Y', strtotime($invoice->creation_date)) .'</div>

              </div>

              '.$hstar .'<div>'. $model_budget_txt .'</div>

        

              <div class=" behalyOfModel">
                <div class="singleHRecordCompany fontbold">  Invoicing on behalf of the model  </div>
              </div> 

                <div class="model5Coloumn alter2 ">
                  <div class="invoiceHInfoSingleLarge"> 
                    <div class="invoiceHInfoTitleLarge "> Model Total Agreed </div>
                  </div>

                  <div class="invoiceHInfoSingleSmall"> 
                    <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
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


              </div>'. $modelvattext .' <div>'. $modelExpenses .'</div>

            

            <div class=" behalyOfModel">

                <div class="singleHRecordCompany fontbold"> Invoicing on behalf of the Most Wanted Models @ Agency Germany </div>

              </div> '.$modal_commission.' '.$modelServices.'

           
              <div class="model5Coloumn alter2 displaymodelBudget colorwhite ">
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

        $mpdf->WriteHTML($mystr);

        $invoive_name = $invoice->invoice_number."_".time().'.pdf';
        $mpdf->Output($invoive_name,"D");

}



public function model_invoice_pdf($invoice_number){

    // $data['view'] = 'generate-invoice-pdf';

    $invoice = $this->home_model->get_invoive_detail($invoice_number);
    $headers = $this->home_model->get_invoive_headers($invoice_number);
    $expenses = $this->home_model->get_invoice_expenses($invoice_number);
    $services = $this->home_model->get_invoice_service($invoice_number);
    $user_id = $this->home_model->user_id();


    $mpdf = $this->m_pdf->load();    
    $mypdfData = $this->load->view('pdfTesting');



    $total_mdl_agreed_amt = 0; 

    $vat_price = 0;



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

    if($invoice->model_budget != $invoice->model_total_agreed){

      $model_budget = $invoice->model_budget;

      $model_budget_txt = ' <div class="model5Coloumn alter2 displaymodelBudget colorwhite ">
        <div class="invoiceHInfoSingleLarge"> 
          <div class="invoiceHInfoTitleLarge "> Model Fee Net </div>
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





    $total_mdl_agreed_amt = $total_mdl_agreed_amt +  $invoice->model_total_agreed;



    $ingermany = $invoice->m_ingermany; //checkForGermany($invoice->model_id);

    $modelvattext = '';


    $vat_price = 0;
    if(!empty($ingermany)&&($ingermany==1)){       

      if($invoice->m_vat_percent > 0){
          $vat_price = ($invoice->model_total_agreed*$invoice->m_vat_percent)/100;
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
          <div class="invoiceHInfoDescriptionsm rightText"> '. ($invoice->model_total_agreed + $vat_price) .'€ </div>
        </div>  
      </div> ';
 

   }

 
    $modelExpenses = '';



    if(!empty($expenses)){



      $modelExpenses = '<div class="model5Coloumn alter2">

        <div class="invoiceHInfoSingleLarge"> 
          <div class="invoiceHInfoTitleLarge "> Name </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> Amount </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> + Vat ('.$invoice->m_vat_percent.'%) </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> Sub Amount </div>
        </div>

         <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
        </div>                 

      </div>';



        $i = 0;        
        $total_sum = 0;        

        foreach ($expenses as $expense) {

          $vat_exp_price = 0;          

          $total_mdl_agreed_amt_loc =  $expense->model_exp_amount;



          if(($expense->vat_include == 1)&&!empty($ingermany)&&($ingermany==1)){ 

              if($invoice->m_vat_percent > 0){
                  $vat_exp_price = ($expense->model_exp_amount*$invoice->m_vat_percent)/100;
                  $total_mdl_agreed_amt_loc = $total_mdl_agreed_amt_loc + $vat_exp_price;
              } 
          }
          $total_mdl_agreed_amt = $total_mdl_agreed_amt + $total_mdl_agreed_amt_loc;
          $total_sum = $total_sum + ($total_mdl_agreed_amt_loc + $vat_exp_price);


          if($i%2 == 0){

            $myclass = "model5Coloumn alter1";

          }

          else{

            $myclass = "model5Coloumn alter2";

          }

           $i++;

           $stext = '';
           if(count($expenses) == $i){  
              $stext =  $total_sum.'€ ';  
            }

          $modelExpenses .= '<div class="'.$myclass.'">

            <div class="invoiceHInfoSingleLarge"> 
              <div class="invoiceHInfoTitle   "> '.$expense->model_expense.' </div>
            </div>

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> '.$expense->model_exp_amount.'€ </div>
            </div>

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> '.$vat_exp_price.'€ </div>
            </div>

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> '.($expense->model_exp_amount + $vat_exp_price).'€ </div>
            </div>  

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> '. $stext .' </div>
            </div>

          </div>';

         

        }

      } 
 
      // $agency_commission = get_agency_comission();

     


        $mystr =  ' 

         <!DOCTYPE html>

          <html>

          <head>

            <title></title>

            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

            <style type="text/css">

              .invoiceHeader{

                  text-align: center;

                  font-size: 25px;

                  color: #000; 

                  border-bottom: 1px solid #e1e1e1;

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

                border-bottom: 1px solid #e1e1e1;

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

                background-color: #333;

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



            </style>

          </head>

          <body>

            <div class="invoiceHeader fontbold"> INVOICE </div>            

            <div class="headerData">

              <div class="addressHRecord alter1">

                <div class="singleHRecordCompany fontbold"> '. $invoice->i_company_name .' </div>

                <div class="singleHRecordCompany"> '. $invoice->i_address_line1.', '.$invoice->i_address_line2 .' </div>

                <div class="singleHRecordCompany"> '. $invoice->i_city.', '.$invoice->i_pincode .' </div>

                <div class="singleHRecordCompany font-sm"> '. strtoupper($invoice->i_country) .' </div>

              </div>



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

                  <div class="invoiceHInfoDescription">'. date('d/m/Y', strtotime($invoice->invoice_date)) .'</div>

                </div>                 

              </div>



              <div class="singleHRecord alter1">

                <div class="singleHRecordTitle"> Model </div>

                <div class="singleHRecordDesc"> '. $invoice->m_model_name .'</div>

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

                <div class="singleHRecordDesc"> '. date('d/m/Y', strtotime($invoice->creation_date)) .'</div>

              </div>

              '.$hstar .'<div>'. $model_budget_txt .'</div>

        

              <div class=" behalyOfModel">
                <div class="singleHRecordCompany fontbold">  Invoicing on behalf of the model  </div>
              </div> 

                <div class="model5Coloumn alter2 ">
                  <div class="invoiceHInfoSingleLarge"> 
                    <div class="invoiceHInfoTitleLarge "> Model Total Agreed </div>
                  </div>

                  <div class="invoiceHInfoSingleSmall"> 
                    <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
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


              </div>'. $modelvattext .' <div>'. $modelExpenses .'</div>
 
           
              <div class="model5Coloumn alter2 displaymodelBudget colorwhite ">
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

        $mpdf->WriteHTML($mystr);

        $invoive_name = $invoice->invoice_number."_".time().'.pdf';
        $mpdf->Output($invoive_name,"D");

}


public function mwm_invoice_pdf($invoice_number){

    // $data['view'] = 'generate-invoice-pdf';

    $invoice = $this->home_model->get_invoive_detail($invoice_number);
    $headers = $this->home_model->get_invoive_headers($invoice_number);
    $expenses = $this->home_model->get_invoice_expenses($invoice_number);
    $services = $this->home_model->get_invoice_service($invoice_number);
    $user_id = $this->home_model->user_id();


    $mpdf = $this->m_pdf->load();    
    $mypdfData = $this->load->view('pdfTesting');



    $total_mdl_agreed_amt = 0; 

    $vat_price = 0;



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

    if($invoice->model_budget != $invoice->model_total_agreed){

      $model_budget = $invoice->model_budget;

      $model_budget_txt = ' <div class="model5Coloumn alter2 displaymodelBudget colorwhite ">
        <div class="invoiceHInfoSingleLarge"> 
          <div class="invoiceHInfoTitleLarge "> Model Fee Net </div>
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





    $total_mdl_agreed_amt = $total_mdl_agreed_amt +  $invoice->model_total_agreed;



    $ingermany = $invoice->m_ingermany; //checkForGermany($invoice->model_id);

    $modelvattext = '';


    $vat_price = 0;
    if(!empty($ingermany)&&($ingermany==1)){       

      if($invoice->m_vat_percent > 0){
          $vat_price = ($invoice->model_total_agreed*$invoice->m_vat_percent)/100;
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
          <div class="invoiceHInfoDescriptionsm rightText"> '. ($invoice->model_total_agreed + $vat_price) .'€ </div>
        </div>  
      </div> ';
 

   }



        
       
 
      // $agency_commission = get_agency_comission();

      // print_r($invoice);

    $total_mdl_agreed_amt = 0;
      $commisssion  = $invoice->model_agency_comission;      

      $com_price_agree = (( ( $invoice->apply_model_fee == 1 ? $invoice->model_budget : $invoice->model_total_agreed) *  $commisssion)/100);

      $total_mdl_agreed_amt = $total_mdl_agreed_amt + $com_price_agree;



    

      $modal_commission .= '

      <div class="model5Coloumn alter2 ">
        <div class="invoiceHInfoSingleLarge"> 
          <div class="invoiceHInfoTitleLarge "> Agency Commission </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> '.  $commisssion .'% </div>
        </div> 
  
         <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> '.$com_price_agree .'€  </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
        </div> 

      </div> ';



      if(($invoice->vat_price > 0)&&!empty($ingermany)&&($ingermany==1)){ 
 
        $com_price_agree_vat = (($com_price_agree * $invoice->vat_price)/100); 
        $total_mdl_agreed_amt = $total_mdl_agreed_amt + $com_price_agree_vat; 


        $modal_commission .= '

          <div class="model5Coloumn alter1 ">
            <div class="invoiceHInfoSingleLarge"> 
              <div class="invoiceHInfoTitleLarge "> + VAT </div>
            </div>

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
            </div>

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescriptionsm rightText"> '.$invoice->vat_price.'% </div>
            </div> 

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescriptionsm rightText"> '.$com_price_agree_vat .'€</div>
            </div>

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescriptionsm rightText"> '.($com_price_agree + $com_price_agree_vat) .'€  </div>
            </div>

          </div> ';

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

                  font-size: 25px;

                  color: #000; 

                  border-bottom: 1px solid #e1e1e1;

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

                border-bottom: 1px solid #e1e1e1;

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

                background-color: #333;

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



            </style>

          </head>

          <body>

            <div class="invoiceHeader fontbold"> INVOICE </div>            

            <div class="headerData">

              <div class="addressHRecord alter1">

                <div class="singleHRecordCompany fontbold"> '. $invoice->i_company_name .' </div>

                <div class="singleHRecordCompany"> '. $invoice->i_address_line1.', '.$invoice->i_address_line2 .' </div>

                <div class="singleHRecordCompany"> '. $invoice->i_city.', '.$invoice->i_pincode .' </div>

                <div class="singleHRecordCompany font-sm"> '. strtoupper($invoice->i_country) .' </div>

              </div>



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

                  <div class="invoiceHInfoDescription">'. date('d/m/Y', strtotime($invoice->invoice_date)) .'</div>

                </div>                 

              </div>



              <div class="singleHRecord alter1">

                <div class="singleHRecordTitle"> Model </div>

                <div class="singleHRecordDesc"> '. $invoice->m_model_name .'</div>

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

                <div class="singleHRecordDesc"> '. date('d/m/Y', strtotime($invoice->creation_date)) .'</div>

              </div>

              '.$hstar .'<div>'. $model_budget_txt .'</div>

        

              <div class=" behalyOfModel">
                <div class="singleHRecordCompany fontbold">  Invoicing on behalf of the model  </div>
              </div> 

                <div class="model5Coloumn alter2 ">
                  <div class="invoiceHInfoSingleLarge"> 
                    <div class="invoiceHInfoTitleLarge "> Model Total Agreed </div>
                  </div>

                  <div class="invoiceHInfoSingleSmall"> 
                    <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
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


              </div>'. $modelvattext .'

            

            <div class=" behalyOfModel">

                <div class="singleHRecordCompany fontbold"> Invoicing on behalf of the Most Wanted Models @ Agency Germany </div>

              </div> '.$modal_commission.' 

           
              <div class="model5Coloumn alter2 displaymodelBudget colorwhite ">
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

        $mpdf->WriteHTML($mystr);

        $invoive_name = $invoice->invoice_number."_".time().'.pdf';
        $mpdf->Output($invoive_name,"D");

}



public function xxmwm_invoice_pdf($invoice_number){

    // $data['view'] = 'generate-invoice-pdf';

    $invoice = $this->home_model->get_invoive_detail($invoice_number);
    $headers = $this->home_model->get_invoive_headers($invoice_number);
    $expenses = $this->home_model->get_invoice_expenses($invoice_number);
    $services = $this->home_model->get_invoice_service($invoice_number);
    $user_id = $this->home_model->user_id();


    $mpdf = $this->m_pdf->load();    
    $mypdfData = $this->load->view('pdfTesting');



    $total_mdl_agreed_amt = 0; 

    $vat_price = 0;



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

    if($invoice->model_budget != $invoice->model_total_agreed){

      $model_budget = $invoice->model_budget;

      $model_budget_txt = ' <div class="model5Coloumn alter2 displaymodelBudget colorwhite ">
        <div class="invoiceHInfoSingleLarge"> 
          <div class="invoiceHInfoTitleLarge "> Model Fee Net </div>
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





    $total_mdl_agreed_amt = $total_mdl_agreed_amt +  $invoice->model_total_agreed;



    $ingermany = $invoice->m_ingermany; //checkForGermany($invoice->model_id);

    $modelvattext = '';


    $vat_price = 0;
    if(!empty($ingermany)&&($ingermany==1)){       

      if($invoice->m_vat_percent > 0){
          $vat_price = ($invoice->model_total_agreed*$invoice->m_vat_percent)/100;
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
          <div class="invoiceHInfoDescriptionsm rightText"> '. ($invoice->model_total_agreed + $vat_price) .'€ </div>
        </div>  
      </div> ';
 

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

                  font-size: 25px;

                  color: #000; 

                  border-bottom: 1px solid #e1e1e1;

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

                border-bottom: 1px solid #e1e1e1;

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

                background-color: #333;

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



            </style>

          </head>

          <body>

            <div class="invoiceHeader fontbold"> INVOICE </div>            

            <div class="headerData">

              <div class="addressHRecord alter1">

                <div class="singleHRecordCompany fontbold"> '. $invoice->i_company_name .' </div>

                <div class="singleHRecordCompany"> '. $invoice->i_address_line1.', '.$invoice->i_address_line2 .' </div>

                <div class="singleHRecordCompany"> '. $invoice->i_city.', '.$invoice->i_pincode .' </div>

                <div class="singleHRecordCompany font-sm"> '. strtoupper($invoice->i_country) .' </div>

              </div>



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

                  <div class="invoiceHInfoDescription">'. date('d/m/Y', strtotime($invoice->invoice_date)) .'</div>

                </div>                 

              </div>



              <div class="singleHRecord alter1">

                <div class="singleHRecordTitle"> Model </div>

                <div class="singleHRecordDesc"> '. $invoice->m_model_name .'</div>

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

                <div class="singleHRecordDesc"> '. date('d/m/Y', strtotime($invoice->creation_date)) .'</div>

              </div>

              '.$hstar .'<div>'. $model_budget_txt .'</div>

        

              <div class=" behalyOfModel">
                <div class="singleHRecordCompany fontbold">  Invoicing on behalf of the model  </div>
              </div> 

                <div class="model5Coloumn alter2 ">
                  <div class="invoiceHInfoSingleLarge"> 
                    <div class="invoiceHInfoTitleLarge "> Model Total Agreed </div>
                  </div>

                  <div class="invoiceHInfoSingleSmall"> 
                    <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
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


              </div>'. $modelvattext .' 

            <div class=" behalyOfModel">

                <div class="singleHRecordCompany fontbold"> Invoicing on behalf of the Most Wanted Models @ Agency Germany </div>

              </div> '.$modal_commission.'

           
              <div class="model5Coloumn alter2 displaymodelBudget colorwhite ">
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

        $mpdf->WriteHTML($mystr);

        $invoive_name = $invoice->invoice_number."_".time().'.pdf';
        $mpdf->Output($invoive_name,"D");

}

 

public function partners_invoice_pdf($invoice_number){

    // $data['view'] = 'generate-invoice-pdf';

    $invoice = $this->home_model->get_invoive_detail($invoice_number);
    $headers = $this->home_model->get_invoive_headers($invoice_number);
    $expenses = $this->home_model->get_invoice_expenses($invoice_number);
    $services = $this->home_model->get_invoice_service($invoice_number);
    $user_id = $this->home_model->user_id();


    $mpdf = $this->m_pdf->load();    
    $mypdfData = $this->load->view('pdfTesting');



    $total_mdl_agreed_amt = 0; 

    $vat_price = 0;



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

    if($invoice->model_budget != $invoice->model_total_agreed){

      $model_budget = $invoice->model_budget;

      $model_budget_txt = ' <div class="model5Coloumn alter2 displaymodelBudget colorwhite ">
        <div class="invoiceHInfoSingleLarge"> 
          <div class="invoiceHInfoTitleLarge "> Model Fee Net </div>
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





    $total_mdl_agreed_amt = $total_mdl_agreed_amt +  $invoice->model_total_agreed;



    $ingermany = $invoice->m_ingermany; //checkForGermany($invoice->model_id);

    $modelvattext = '';


    $vat_price = 0;
    if(!empty($ingermany)&&($ingermany==1)){       

      if($invoice->m_vat_percent > 0){
          $vat_price = ($invoice->model_total_agreed*$invoice->m_vat_percent)/100;
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
          <div class="invoiceHInfoDescriptionsm rightText"> '. ($invoice->model_total_agreed + $vat_price) .'€ </div>
        </div>  
      </div> ';
 

   }

 


    $modelServices = '';


    if(!empty($services)){


      $modelServices = '
      <div class=" behalyOfModel">

                <div class="singleHRecordCompany fontbold"> invoicing on behalf of the Select Inc. </div>

              </div> 
        <div class="model5Coloumn alter2">
        <div class="invoiceHInfoSingleLarge"> 
          <div class="invoiceHInfoTitleLarge "> Name </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> Amount </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText">  Vat ('.$invoice->m_vat_percent.'%) </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> Sub Amount </div>
        </div>

        <div class="invoiceHInfoSingleSmall"> 
          <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
        </div>                 

      </div>';



        $i = 0;
        $ser_total = 0;
        foreach ($services as $service) {

          $vat_ser_price = 0;
          $total_mdl_agreed_amt_loc = 0;
          $mycolor = '#f00';
          $showcal = '-';

          if ($service->status == 1) {   
            $total_mdl_agreed_amt_loc = $service->model_ser_amount;
            if(($service->vat_include == 1)&&!empty($ingermany)&&($ingermany==1)){                 

                if($invoice->m_vat_percent > 0){
                    $vat_ser_price = ($service->model_ser_amount*$invoice->m_vat_percent)/100;
                    $total_mdl_agreed_amt_loc = $total_mdl_agreed_amt_loc + $vat_ser_price;
                } 
            }

            $total_mdl_agreed_amt = $total_mdl_agreed_amt + $total_mdl_agreed_amt_loc;
            $mycolor = '';
            $showcal = '+';

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
              <div class="invoiceHInfoTitle   "> '.$service->model_service.' </div>
            </div>

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> '.$service->model_ser_amount.'€ </div>
            </div>

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> '.$vat_ser_price.'€ </div>
            </div>

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> ('.$showcal.') '. ($service->model_ser_amount + $vat_ser_price) .'€ </div>
            </div>

            <div class="invoiceHInfoSingleSmall"> 
              <div class="invoiceHInfoDescription rightText"> '. $stext .'</div>
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

                  font-size: 25px;

                  color: #000; 

                  border-bottom: 1px solid #e1e1e1;

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

                border-bottom: 1px solid #e1e1e1;

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

                background-color: #333;

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



            </style>

          </head>

          <body>

            <div class="invoiceHeader fontbold"> INVOICE </div>            

            <div class="headerData">

              <div class="addressHRecord alter1">

                <div class="singleHRecordCompany fontbold"> '. $invoice->i_company_name .' </div>

                <div class="singleHRecordCompany"> '. $invoice->i_address_line1.', '.$invoice->i_address_line2 .' </div>

                <div class="singleHRecordCompany"> '. $invoice->i_city.', '.$invoice->i_pincode .' </div>

                <div class="singleHRecordCompany font-sm"> '. strtoupper($invoice->i_country) .' </div>

              </div>



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

                  <div class="invoiceHInfoDescription">'. date('d/m/Y', strtotime($invoice->invoice_date)) .'</div>

                </div>                 

              </div>



              <div class="singleHRecord alter1">

                <div class="singleHRecordTitle"> Model </div>

                <div class="singleHRecordDesc"> '. $invoice->m_model_name .'</div>

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

                <div class="singleHRecordDesc"> '. date('d/m/Y', strtotime($invoice->creation_date)) .'</div>

              </div>

              '.$hstar .'<div>'. $model_budget_txt .'</div>

        

              <div class=" behalyOfModel">
                <div class="singleHRecordCompany fontbold">  Invoicing on behalf of the model  </div>
              </div> 

                <div class="model5Coloumn alter2 ">
                  <div class="invoiceHInfoSingleLarge"> 
                    <div class="invoiceHInfoTitleLarge "> Model Total Agreed </div>
                  </div>

                  <div class="invoiceHInfoSingleSmall"> 
                    <div class="invoiceHInfoDescriptionsm rightText"> &nbsp; </div>
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


              </div>'. $modelvattext .' <div> '.$modelServices.'

           
              <div class="model5Coloumn alter2 displaymodelBudget colorwhite ">
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

        $mpdf->WriteHTML($mystr);

        $invoive_name = $invoice->invoice_number."_".time().'.pdf';
        $mpdf->Output($invoive_name,"D");

}

public function xxpartners_invoice_pdf($invoice_number){

  $invoice = $this->home_model->get_invoive_detail($invoice_number);

    $headers = $this->home_model->get_invoive_headers($invoice_number);

    $services = $this->home_model->get_invoice_service($invoice_number);

   

    $user_id = $this->home_model->user_id();

   

    $mpdf = $this->m_pdf->load();    

    $mypdfData = $this->load->view('pdfTesting');

    $total_mdl_agreed_amt = 0; 

    $vat_price = 0;



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

    if($invoice->model_budget != $invoice->model_total_agreed){

      $model_budget = $invoice->model_budget;

      $model_budget_txt = '<div class="displaymodelBudget">

        <div class="singleHRecordTitle fontbold">  Model Fee Net </div>

        <div class="singleHRecordDesc fontbold rightText"> '.$invoice->model_budget .'€ </div>

      </div>';

    }





    $total_mdl_agreed_amt = $total_mdl_agreed_amt+ $invoice->model_total_agreed;



    $ingermany = $invoice->m_ingermany; //checkForGermany($invoice->model_id);

    $modelvattext = '';



    if(!empty($ingermany)&&($ingermany==1)){       

      if($invoice->i_fee > 0){

          $vat_price = ($invoice->model_total_agreed*$invoice->i_fee)/100;

          $total_mdl_agreed_amt = $total_mdl_agreed_amt + $vat_price; 

      }



      

      $modelvattext .= '<div class="invoiceHInfo alter1">

        <div class="invoiceHInfoSingle"> 

          <div class="invoiceHInfoTitle "> + VAT </div>

        </div>

        <div class="invoiceHInfoSingle"> 

          <div class="invoiceHInfoDescription">'. $invoice->i_fee .'% </div>

        </div>

        <div class="invoiceHInfoSingle"> 

          <div class="invoiceHInfoDescription rightText">'. $vat_price .'€ </div>

        </div>                 

      </div>';

   }





    $modelServices = '';



    if(!empty($services)){



      $modelServices = '<div class="model5Coloumn alter2">

        <div class="invoiceHInfoSingleLarge"> 

          <div class="invoiceHInfoTitleLarge "> Name </div>

        </div>

        <div class="invoiceHInfoSingleSmall"> 

          <div class="invoiceHInfoDescriptionsm rightText"> Amount </div>

        </div>

        <div class="invoiceHInfoSingleSmall"> 

          <div class="invoiceHInfoDescriptionsm rightText"> + Vat ('.$invoice->i_fee.'%) </div>

        </div>

        <div class="invoiceHInfoSingleSmall"> 

          <div class="invoiceHInfoDescriptionsm rightText"> Sub Amount </div>

        </div>                 

      </div>';


      $total_mdl_agreed_amt = 0;
        $i = 0;

        foreach ($services as $service) {

          $vat_ser_price = 0;
          $total_mdl_agreed_amt_loc = 0;
          $showcal = '-';
         if($service->status == 1){

            $total_mdl_agreed_amt_loc = $service->model_ser_amount;
            if(($service->vat_include == 1)&&!empty($ingermany)&&($ingermany==1)){                

                if($invoice->i_fee > 0){
                    $vat_ser_price = ($service->model_ser_amount*$invoice->i_fee)/100;
                    $total_mdl_agreed_amt_loc = $total_mdl_agreed_amt_loc + $vat_ser_price;
                }
            }
            $showcal = '+';
            $total_mdl_agreed_amt = $total_mdl_agreed_amt + $total_mdl_agreed_amt_loc;
         }



          if($i%2 == 0){
            $myclass = "model5Coloumn alter1";
          }
          else{
            $myclass = "model5Coloumn alter2";
          }

          $modelServices .= '<div class="'.$myclass.'">
           
            <div class="invoiceHInfoSingleLarge"> 
              <div class="invoiceHInfoTitle   "> '.$service->model_service.' </div>
            </div>

            <div class="invoiceHInfoSingleSmall"> 

              <div class="invoiceHInfoDescription rightText"> '.$service->model_ser_amount.'€ </div>

            </div>

            <div class="invoiceHInfoSingleSmall"> 

              <div class="invoiceHInfoDescription rightText"> '.$vat_ser_price.'€ </div>

            </div>

            <div class="invoiceHInfoSingleSmall"> 

              <div class="invoiceHInfoDescription rightText"> ('.$showcal.') '. ($service->model_ser_amount + $vat_ser_price) .'€ </div>

            </div>                 

          </div>';

          $i++;

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

                  font-size: 25px;

                  color: #000; 

                  border-bottom: 1px solid #e1e1e1;

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

                border-bottom: 1px solid #e1e1e1;

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

                background-color: #333;

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

                width:40%;

                float:left;

                color: #000;

              }

              .invoiceHInfoSingleSmall{

                width:20%;

                float:left;

                color: #000;

              }



            </style>

          </head>

          <body>

            <div class="invoiceHeader fontbold"> INVOICE </div>            

            <div class="headerData">

              <div class="addressHRecord alter1">

                <div class="singleHRecordCompany fontbold"> '. $invoice->i_company_name .' </div>

                <div class="singleHRecordCompany"> '. $invoice->i_address_line1.', '.$invoice->i_address_line2 .' </div>

                <div class="singleHRecordCompany"> '. $invoice->i_city.', '.$invoice->i_pincode .' </div>

                <div class="singleHRecordCompany font-sm"> '. strtoupper($invoice->i_country) .' </div>

              </div>



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

                  <div class="invoiceHInfoDescription">'. date('d/m/Y', strtotime($invoice->invoice_date)) .'</div>

                </div>                 

              </div>



              <div class="singleHRecord alter1">

                <div class="singleHRecordTitle"> Model </div>

                <div class="singleHRecordDesc"> '. $invoice->m_model_name .'</div>

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

                <div class="singleHRecordDesc"> '. date('d/m/Y', strtotime($invoice->creation_date)) .'</div>

              </div>

              '.$hstar .'<div>'. $model_budget_txt .'</div>

        
              <div class="singleHRecord alter2">

                <div class="singleHRecordTitle singleHRecordDesc"> Model Total Agreed </div>

                <div class="singleHRecordDesc singleHRecordTitle rightText"> '. $invoice->model_total_agreed .'€ </div>

              </div>'. $modelvattext .' 
       

            <div class=" behalyOfModel">

                <div class="singleHRecordCompany fontbold"> invoicing on behalf of the Select Inc. </div>

              </div> '.$modelServices.'

           



              <div class="displaymodelBudget">

                <div class="singleHRecordTitle fontbold">  Total Amount </div>

                <div class="singleHRecordDesc fontbold rightText"> '.$total_mdl_agreed_amt .'€ </div>

              </div>  





            </div>

          </body>

          </html>';

        $mpdf->Bookmark('Start of the document');

        $mpdf->WriteHTML($mystr);

          $invoive_name = $invoice->invoice_number."_".time().'.pdf';
        $mpdf->Output($invoive_name,"D"); 
} 

  













}