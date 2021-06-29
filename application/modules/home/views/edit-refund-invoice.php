<?php 

// $user_session = $this->session->userdata('user');
$user_profie = user_profile($user_id);
// print_r($user_profie);

$issues = [];
$records = 0;
$offset = 0;
$records_on_page = 10;
$page = 0;

if (!empty($_GET['page'])) {
	$page = $_GET['page'];
	$offset = $page * $records_on_page;
}


$data = [];
$attachments = [];
$journals = [];

$token = 0;

if (!empty($_GET['token'])) {
	$token = $_GET['token'];
}


$filter_data = '';

$search_status = '';
if (!empty($_GET['status_id'])) {
	$search_status = $_GET['status_id'];
	$filter_data .= '&status_id='.$search_status;
}

$search_priority = ''; 
if (!empty($_GET['priority_id'])) {
	$search_priority = $_GET['priority_id'];
	$filter_data .= '&priority_id='.$search_priority;
}

$search_assignee = '';
if (!empty($_GET['assigned_to_id'])) {
	$search_assignee = $_GET['assigned_to_id'];
	$filter_data .= '&assigned_to_id='.$search_assignee;
}
else{
	$search_assignee = $user_profie->redmine_assignee;
	$filter_data .= '&assigned_to_id='.$search_assignee;
} 


if(!empty($user_profie)){

	$service_url = "https://tickets.mostwantedmodels.com/projects/jobs/issues.json?offset=".$offset."&limit=".$records_on_page.$filter_data;
	$curl = curl_init($service_url);
	$autho = $user_profie->redmine_username.':'.$user_profie->redmine_password;
	$request_headers = array(
		"Authorization:Basic ".base64_encode($autho),
	);

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
	curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);
	$curl_response = curl_exec($curl);
	curl_close($curl);
	$response = json_decode($curl_response, true);

	if(!empty($response['issues'])){
		$issues = $response['issues'];
		$records = $response['total_count'];
	}

	// print_r($response);

	$service_url = "https://tickets.mostwantedmodels.com/issues/".$token.".json?include=attachments,journals";
	$curl = curl_init($service_url);
	$autho = $user_profie->redmine_username.':'.$user_profie->redmine_password;

	$request_headers = array(
		"Authorization:Basic ".base64_encode($autho),
	);

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);
	$curl_response = curl_exec($curl);
	curl_close($curl);
	$response = json_decode($curl_response, true);

	if(!empty($response['issue'])){
		$data = $response['issue'];
		$attachments = $response['issue']['attachments'];
		$journals = $response['issue']['journals'];
	}
}

// print_r($journals);

?>

<!-- End Header -->

<style type="text/css">
	#model_budget, #model_total_agreed, .Modelfee input[type="number"]{

		width: 110px;

		height: 28px;

	}
	.select2-container--default .select2-selection--single .select2-selection__rendered {
		margin-top: -14px;
	}


	.select2-container--default .select2-selection--single {
		padding: 20px 2px;
		border: 1px solid #ced4da;

	}



	ul.journals{

		margin-bottom: 0px;

	}

	ul.journals li{

		border-bottom: 1px solid #ccc;

		padding-top: 5px;

		padding-bottom: 5px;

		list-style: square;

	}

	ul.journals li:last-child{

		border-bottom: none;

		padding-top: 5px;

		padding-bottom: 0px;

		list-style: square;

	}

	ul.journals li::marker {

		color: #c3083c;

	}



	.refundInvoice input[type="number"]{

		width: 110px;

		height: 28px;

	}
	#modelexpence input[type="text"], #modelservice input[type="text"]{
		width: 155px;
	}

	/*.singlemodelpriceSeparater input{
		width: 110px;

		height: 28px;
	}*/

	.Modelfee.Icon.text-right::before {

		content: " ";

	}
	#form_filter div small b{
		color: #169;
		margin-bottom: 8px;
		/*font-weight: bold;
		border-bottom: 1px dotted #169;*/
	}

	.editbtn {
		text-align: center;
		font-weight: bold;
		/*text-transform: uppercase;*/

	}
	.editbtn a{
		font-size: 12px !important;
		color: #169 !important;
	}

	.chargespercent{
		float: right;
    width: 75px;
	}

	#newModelTotalFee input, #additional_modal_price{
		max-width: 100%;
	}

	.dcolor{
	background-color: #601010;
	color: #fff;
}
/*==============*/
 

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

              #deductiontext, #honorariumtext{
              	width: 100%;
              }
</style>

<!-- Start Dashboard -->

<section class="Dashboard">

	<div class="container">

		<div class="row">

			<div class="col-md-2">

				<?php include 'sidebar.php' ?>

			</div>

			<div class="col-md-10">

				<div class="DashboardContent">

					<div class="OpenTicket Box">

						<div class="BoxHeading generate">

							<h4> Create Refund <?php if(!empty($invoice_number)) echo ' [' . $invoice_number . ']' ?></h4>

						</div>

					</div> 
					

					<div class="OpenTicket Box NoRadius" >

						 
						<div class="col-md-12">
							<div class="InputBox">
								<form id="formSelectedInvoice">
									<div class="row" style="height: initial;">
										<div class="col-md-6 pl-0">
											<div class="form-group">												
												<select class="custom-select myselect" id="invoive" name="invoive" onchange="$('#formSelectedInvoice')[0].submit();">
 													<option value="" selected disabled > Select Invoive</option>
													<?php 
													if(!empty($invoices)){
														foreach ($invoices as $invoice){
															$selected = '';
															 
																if($invoice->invoice_number == $invoice_number){
																	$selected = 'selected';
																}
															 

													?>
														<option <?php echo $selected; ?> value="<?php echo $invoice->invoice_number; ?>" data-id="<?php echo $invoice->id; ?>" data-issue="<?php echo $invoice->issue_id; ?>" >
															<?php echo $invoice->invoice_number; ?>	
														</option> 
													<?php
														}
													}
													?>
												</select>
											</div>
										</div>
										<div class="col-md-6 pr-0">
										<!-- 	<div class="form-group">
											 	<input type="text" id="search-bar" placeholder="Browse Older Invoices for Duplication">
													<a href="javascript:void(0)"><img class="search-icon" src="http://www.endlessicons.com/wp-content/uploads/2012/12/search-icon.png"></a> 
											</div> -->
										</div>
									</div>
								</form>
								
							</div>
						</div>
					 

					<div class="clearfix"></div>

					<?php 
					if(empty($_GET['invoive'])){
					?>
					<div class="alert alert-danger"> No invoice selected, please select a invoice to create a refund.</div>
					<?php
					}
					else{
					?>
 
				


			<form id="formInvoice" name="formInvoice">

				<?php 
				$vat_price = 0;
    $ingermany = $invoice_info->m_ingermany;
    $correction = $invoice_info->correction == 1 ? '/C' : '';
    $model_budget = $invoice_info->apply_model_fee == 2 ? $invoice_info->model_total_agreed : $invoice_info->model_budget;

    $vat_price = 0;
    if(!empty($ingermany)&&($ingermany==1 && $invoice_info->m_vat_percent > 0)){
      if($invoice_info->m_vat_percent > 0){
        $vat_price = ($model_budget*$invoice_info->m_vat_percent)/100;
      }
   }

    $m_sfee = 0;

   if($invoice_info->m_service_fee > 0){
      $m_sfee = ($model_budget * $invoice_info->m_service_fee)/100;
   }

   $specialcharges = 0;
   $travelcost = $invoice_info->VatmodelExp + $invoice_info->modelExp;
   $total_sum = $model_budget + $vat_price - $m_sfee - $specialcharges + $travelcost;

   
	$max = 0;
	$min = 0;
	$total_d = 0;

	$block_edit = '';
	
	



	$travalcost = $invoice_info->refund == 1 ? $invoice_info->travel_cost_amount : $invoice_info->modelExp;
	$travalcost_vat = $invoice_info->refund == 1 ? $invoice_info->travel_cost_vat : $invoice_info->VatmodelExp;


	$subtotal2 = $model_budget + $vat_price - $m_sfee - $invoice_info->special_charge_amount + $travalcost + $travalcost_vat;

	if($invoice_info->refund == 1){
		if($invoice_info->deduction_amout > 0){
			$max =  $invoice_info->deduction_amout;
			$min = $max;
			$block_edit = 'disabled';
		}
	}
	else if(!empty($deduction_info->wallet)){
		$total_d =  $deduction_info->wallet;
		if( $total_d < $subtotal2){			
			$max = $total_d;
		}
		else{
			$max = $total_sum;
		}
	}


		$subtotal = $model_budget + $vat_price - $m_sfee - $max - $invoice_info->special_charge_amount;


		$subtotal2 = $subtotal + $travalcost + $travalcost_vat;
	?> 

	
		<div class="OpenTicket Box Boxtwo NoRadiusForm">

			

			<div class="Invoicing">
				<div class="InputBox Search brbottom">
					<h3>Invoicing on behalf of the model</h3>
				</div>
			</div>

			<div class="NewInvoice">


			<div class="modelDetails">
              <div ><?php echo $model->name; ?></div>
              <div><?php echo $model->address_line1; ?></div>
              <div><?php echo $model->city; ?>, <?php echo $model->pincode; ?></div>
              <div><?php echo $model->country; ?><br/> <br/></div> 
            </div>

            <div class="borderMdldetail">
            	<?php 
            	
            	$credit_note = $invoice_info->credit_note;
            	if(empty($credit_note)){
            		$credit_note = 'MWM'.date('dY').str_pad(autoIncrementer(),6,"0",STR_PAD_LEFT);
            	}
            	?>
              <div class="borderCredit"> credit note &nbsp;&nbsp;&nbsp;&nbsp; <input type="text" name="txtcreditnotes" id="txtcreditnotes" value="<?php echo $credit_note; ?>"  required> </div>

              <div class="r4cont"> 
                <div class="r4"><div class="mtitle">Modelname</div></div>
                <div class="r4"><div class="mdesc"><?php echo $invoice_info->m_model_name ; ?></div></div>
                <div class="r4"><div class="mtitle">&nbsp;&nbsp;Date of job</div></div>
                <div class="r4"><div class="mdesc"><?php echo date('d/m/Y', strtotime($invoice_info->job_date)).'-'.date('d/m/Y', strtotime($invoice_info->job_date_till)) ; ?></div></div>
                <div class="clearfix"></div>
              </div>


              <div class="r4cont"> 
                <div class="r4"><div class="mtitle">Taxnumber</div></div>
                <div class="r4"><div class="mdesc"><?php echo $invoice_info->m_vat_tin_number ; ?></div></div>
                <div class="r4"><div class="mtitle">&nbsp;&nbsp;Job Nr</div></div>
                <div class="r4"><div class="mdesc"><?php echo $invoice_number ; ?></div></div>
                <div class="clearfix"></div>
              </div>

              <?php 
              // print_r($headers);
              if(!empty($headers)){

              	$hcount = count($headers);
              	$loop = $hcount/2;

              	if($loop >= 1){
              	for ($i=0; $i < $loop; $i++) { 
              ?>

              <div class="r4cont"> 
                <div class="r4"><div class="mtitle"><?php echo $headers[$i]->invoive_title; ?></div></div>
                <div class="r4"><div class="mdesc"><?php echo $headers[$i]->invoive_value; $i++; ?></div></div>
                <div class="r4"><div class="mtitle"><?php echo $headers[$i]->invoive_title; ?></div></div>
                <div class="r4"><div class="mdesc"><?php echo $headers[$i]->invoive_value; ?></div></div>
                <div class="clearfix"></div>
              </div>

              <?php
              		 
              	}
              }

              if($hcount % 2 > 0){
              	if($hcount <= 1){
              		$i = 0;
              	}
              ?>
              <div class="r4cont"> 
                <div class="r4"><div class="mtitle"><?php echo $headers[$i]->invoive_title; ?></div></div>
                <div class="r34"><div class="mdesc"><?php echo $headers[$i]->invoive_value; ?></div></div>
                <div class="clearfix"></div>
              </div>
              <?php
              }
              }
              ?>


              <div class="r4cont"> 
                <div class="r4"><div class="mtitle">Client</div></div>
                <div class="r34"><div class="mdesc"><?php echo $invoice_info->i_company_name ; ?></div></div>
                <div class="clearfix"></div>
              </div>
            
              <div class="r4cont"> 
                <div class="r4"><div class="mtitle">Uses</div></div>
                <div class="r34 full"><div class="mdesc"><?php echo $invoice_info->uses ; ?></div></div>
                <div class="clearfix"></div>
              </div>
            </div>

            <div style="font-size: 13px; margin: 15px 0;"> We Invoiced as follows in your name: </div>
            

            <div class="refundInvoice">  
                <div class="irow">
                    <div class="one3rd"> Honorarium <input type="text" name="honorariumtext" id="honorariumtext" value="<?php echo $invoice_info->honorarium_text; ?>" > </div>
                    <div class="one4th"> <div class="idesc"><?php echo number_format($model_budget, 2) ; ?>€</div> </div>
                    <div class="clearfix"></div>
                    <div class="splrow">
                        <div class="w40">&nbsp;</div>
                        <div class="w60"><div class="fleft"> VAT &nbsp; &nbsp; <input type="number" name="m_vat_percent" id="m_vat_percent" value="<?php echo $invoice_info->m_vat_percent; ?>">% </div> <div class="fright" id="m_vat_percent_show"> + <?php echo number_format($vat_price, 2) ; ?>€  </div> </div>
                        <div class="clearfix"></div> 
                    </div> 
                </div> 

                <div class="irow">
                    <div class="one3rd"> Servicefee &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="number" min="0" step="any" name="myservicefee" id="myservicefee" value="<?php echo $invoice_info->m_service_fee; ?>"> % 
                    <div style="font-size: 11px; margin: 2px 0;"> VAT free, because placeof performance at the place of residence of the recipient </div>
                    </div> 
                    <div class="one4th"> <div class="idesc" id="servicefeeamount"> - <?php echo number_format($m_sfee, 2) ; ?>€</div> </div>
                    <div class="clearfix"></div> 
                </div> 

                 <div class="irow">
                    <div class="one3rd"> Specialcharge &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <input type="number" step="any" class="text-right" min="0" name="servicechargesvat"  id="servicechargesvat" value="<?php echo $invoice_info->special_charget_vat > 0 ? $invoice_info->special_charget_vat : 0; ?>" >% 
                    <div style="font-size: 11px; margin: 2px 0;"> VAT free, because placeof performance at the place of residence of the recipient </div>
                    </div> 
                    <div class="one4th"> <div class="idesc"> - <input min="0" type="number" step="any" class="text-right" name="servicecharges"  id="servicecharges"  value="<?php echo $invoice_info->special_charge_amount > 0 ? $invoice_info->special_charge_amount : 0; ?>">€</div> </div>
                    <div class="clearfix"></div>
                </div> 

                <div class="irow">
                    <div class="one3rd"> <input type="text" name="deductiontext" id="deductiontext"  value="<?php echo $invoice_info->deduction_text != '' ? $invoice_info->deduction_text : 'Deduction' ?>"> 
                    <div style="font-size: 11px; margin: 2px 0;"> VAT free, because placeof performance at the place of residence of the recipient </div>
                    </div> 
                    <div class="one4th"> <div class="idesc"> 
                    	<?php 
						if($invoice_info->refund != 1){
						?><span id="totalDed" style="color: #f00;"><small><b>€ <?php if(!empty($deduction_info)) { echo $deduction_info->wallet; }else{ echo 0; }?></b></small></span>&nbsp; &nbsp; <?php } ?>
						- <input type="number" step="any" class="text-right"   placeholder="amount" min="0" name="modelDeductionValue"  id="modelDeductionValue"  value="<?php echo $max ?>">€   <!-- max="<?php echo $max ?>" min="<?php echo $min ?>" -->
                      
                 	</div> </div>
                    <div class="clearfix"></div>
                </div> 

                <div class="irow">
                    <div class="one3rd"> SUBTOTAL </div> 
                    <div class="one4th"> <div class="idesc" id="subtotal"><?php echo number_format($subtotal , 2) ; ?>€</div> </div>
                    <div class="clearfix"></div>
                </div>

                <div class="irow">
                    <div class="one3rd"> Travel costs </div> 
                    <div class="one4th"> <div class="idesc"> + <input class="text-right" min="0" type="number" step="any" name="travelcost" id="travelcost" value="<?php echo  $travalcost; ?>">€</div> </div>
                    <div class="clearfix"></div>
                    <div class="splrow">
                        <div class="w40">&nbsp;</div>
                        <div class="w60"><div class="fleft"> VAT &nbsp; &nbsp;  <input type="number" name="travelcost_percent" id="travelcost_percent" value="0">% </div> <div class="fright"> + <input class="text-right" min="0" type="number" step="any" name="travelcostvat" id="travelcostvat" value="<?php echo $travalcost_vat; ?>">€  </div> </div>
                        <div class="clearfix"></div>
                    </div> 
                </div>

                <div class="irow"> 
                   <div class="splrow">
                        <div class="w40">CREDIT</div> 
                        <div class="w60"><div class="fleft"> includes VAT &nbsp; &nbsp; <?php echo number_format(0, 1) ; ?> </div> <div class="fright" id="fright"> <?php echo number_format($subtotal2, 2) ; ?>€  </div> </div>
                        <input type="hidden" name="totalsum" id="totalsum" value="<?php echo $total_sum; ?>">
                        <input type="hidden" name="invoice_number" id="invoice_number" value="<?php echo $_GET['invoive']; ?>">
                        <input type="hidden" name="modeldeduction" id="modeldeduction" value="<?php echo $model->unique_code ; ?>">
                        <input type="hidden" name="modelfee" id="modelfee" value="<?php echo $model_budget ; ?>">
                        <input type="hidden" name="modelfeevat" id="modelfeevat" value="<?php echo $vat_price ; ?>">
                        <input type="hidden" name="servicefee" id="servicefee" value="<?php echo $m_sfee ; ?>">
                        <input type="hidden" name="is_refund" id="is_refund" value="<?php echo $invoice_info->refund ; ?>">

                        <div class="clearfix"></div>
                    </div> 
                </div>

            </div> 

            <script type="text/javascript">

            	function manageDeductionValue() {
	        		 // var total_a = $('#totalsum').val();
	        		 // if(total_a != ''){
	        		 // 	total_a = parseFloat(total_a);
	        		 // }

	        		 var modal_a = $('#modelfee').val();
	        		 if(modal_a != ''){
	        		 		 modal_a =  parseFloat(modal_a);
	        		 }
	        		 else{
	        		 	modal_a = 0;
	        		 }

	        		  var m_vat_percent = $('#m_vat_percent').val();
	        		 if(m_vat_percent != ''){
	        		 		m_vat_percent =  parseFloat(m_vat_percent);
	        		 }
	        		 else{
	        		 	m_vat_percent = 0;
	        		 }

	        		 var vat_amt = 0;
	        		 if(m_vat_percent > 0){
	        		 		vat_amt = (modal_a * m_vat_percent)/100;
	        		 }

	        		 // $('#m_vat_percent').val(m_vat_percent);
	        		 $('#m_vat_percent_show').html(vat_amt);
	        		 $('#modelfeevat').val(vat_amt)


	        		 var modalvat_a = $('#modelfeevat').val();
	        		 if(modalvat_a != ''){
	        		 		modalvat_a =  parseFloat(modalvat_a);
	        		 }
	        		 else{
	        		 	modalvat_a = 0;
	        		 }

 
	        		 var myservicefee = $('#myservicefee').val();
	        		  if(myservicefee != ''){
	        		 	myservicefee = parseFloat(myservicefee);
	        		 }
	        		 else{
	        		 	myservicefee = 0;
	        		 }
 
	        		 var service_amount = 0;
	        		 if(myservicefee > 0 && modal_a > 0){
	        		 		service_amount = (modal_a * myservicefee)/100;

	        		 }
	        		 $('#servicefee').val(service_amount);

	        		 $('#servicefeeamount').html(service_amount);
	        	 
	        		 var service_fee = $('#servicefee').val();
	        		 if(service_fee != ''){
	        		 		service_fee =  parseFloat(service_fee);
	        		 }
	        		 else{
	        		 	service_fee = 0;
	        		 }



	        		 var total_ded = $('#modelDeductionValue').val();
	        		  if(total_ded != ''){
	        		 	total_ded = parseFloat(total_ded);
	        		 }
	        		 else{
	        		 	total_ded = 0;
	        		 }


	        		 var scharges = $('#servicecharges').val();
	        		  if(scharges != ''){
	        		 	scharges = parseFloat(scharges);
	        		 }
	        		 else{
	        		 	scharges = 0;
	        		 }


	        		 




	        		 var travelcost = $('#travelcost').val();
	        		  if(travelcost != ''){
	        		 	travelcost = parseFloat(travelcost);
	        		 }
	        		 else{
	        		 	travelcost = 0;
	        		 }


	        		 var travelcost_percent = $('#travelcost_percent').val();

	        		  if(travelcost_percent != ''){
	        		 	travelcost_percent = parseFloat(travelcost_percent);
	        		 }
	        		 else{
	        		 	travelcost_percent = 0;
	        		 }

	        		 var t_vat_amt = 0;
	        		 if(travelcost_percent > 0){
	        		 		t_vat_amt = (travelcost * travelcost_percent)/100;
	        		 }
	        		 $('#travelcostvat').val(t_vat_amt);


	        		  var travelcostvat = $('#travelcostvat').val();
	        		  if(travelcostvat != ''){
	        		 	travelcostvat = parseFloat(travelcostvat);
	        		 }
	        		 else{
	        		 	travelcostvat = 0;
	        		 }



	        		 var sub_total = modal_a + modalvat_a - service_fee - scharges - total_ded;
	        		 var travel_cost = travelcost + travelcostvat;

	        		 
	        		 $('#subtotal').html(sub_total+'€');
	        		 $('#fright').html((sub_total + travel_cost) +'€');


            	}
            	$(function(){
            		$('#modelDeductionValue, #servicecharges, #travelcost, #travelcostvat, #myservicefee, #m_vat_percent, #travelcost_percent').change(function(){
            			manageDeductionValue();
            		}).keyup(function(){
            			manageDeductionValue();
            		})
            	})
            </script>
             
            </div>


				</div>

			</div>


			<div class="OpenTicket Box Boxtwo NoRadius"> 
				<div class="Divpdf">  
					<div class="BtnBox" >
						<!-- contenteditable="false" -->

						 
						<button type="submit" class="btn cancel" >Save & Preview</button>
						 
						<!-- <a href="<?php echo base_url('refund-invoice-pdf/').$_GET['invoive']; ?>"><button type="button" class="btn cancel" >Download PDF</button> -->
						 
						<!-- <button type="save" class="btn cancel">Preview</button> -->
						<!-- </a> --> 
					</div> 
				</div> 
			</div>
			 
<!-- 
			<input type="hidden" name="refund_invoice" id="refund_invoice" value="1">
			<input type="hidden" name="manageexpstart" id="manageexpstart" value="<?=($expCount+1)?>">
			<input type="hidden" name="manageexp" id="manageexp" value="<?=($expCount+1)?>"> 			 
			<input type="hidden" name="manageserstart" id="manageserstart" value="<?=($serCount+1)?>"> 
			<input type="hidden" name="manageser" id="manageser" value="<?=($serCount+1)?>"> 
			<input type="hidden" name="txtmodalIncreaseValueStart" id="txtmodalIncreaseValueStart" value="<?php echo count($model_data) ?>">					
			<input type="hidden" name="txtmodalIncreaseValue" id="txtmodalIncreaseValue" value="<?php echo count($model_data) ?>"> -->

		</form>
	</div>
</div>
</div>
</div>
</section>

<!-- End Dashboard -->



<!-- Start Footer -->

<div id="demomdlexp" style="display: none;">

	<div class="BorderRow" id="demomdlexpRow@rwid@">

		<div class="row">

			<div class="col-md-3">
				<div class="Modelfee">

					<button class="btn btn-danger btn-sm" type="button" onclick="deleteModelExpenses('demomdlexpRow@rwid2@', @rwid3@)"><i class="fa fa-trash"></i> </button>
					<input type="text" placeholder="Expense Name" name="model_expense@exname@">
					<input type="hidden" name="model_expense_del@exnamedel@" id="model_expense_del@exnamedel2@">

				</div>

			</div>

			<div class="col-md-3">

				<div class="custom-control custom-radio">

					<input type="radio" class="custom-control-input" id="vati@inc@" value="0" name="vat_include@ninc@">

					<label class="custom-control-label" for="vati@linc@">VAT included</label>

				</div>

			</div>

			<div class="col-md-3">

				<div class="custom-control custom-radio"> 
					<input type="radio" class="custom-control-input" id="vate@exc@" value="1" name="vat_include@nexc@"> 
					<label class="custom-control-label" for="vate@lexc@">VAT excluded</label>
					<input class="chargespercent" type="number" step="any" class="" id="expences_vat_percent@percent@" value="0" name="expences_vat_percent@percent@">
				</div>
			</div>

			<div class="col-md-3">

				<div class="Modelfee Icon text-right">

					<h6><i class="fa fa-eur" aria-hidden="true"></i> <input type="number"  name="model_exp_amount@amt@" min="0" step="any" value="0"></h6>

				</div>

			</div>

		</div>

	</div>

</div>





<div id="demomdlser" style="display: none;">

	<div class="BorderRow" id="demomdlSerRow@rwid@">

		<div class="row">

			<div class="col-md-3">

				<div class="Modelfee">

					<button class="btn btn-danger btn-sm" type="button" onclick="deleteModelService('demomdlSerRow@rwid2@', @rwid3@)"><i class="fa fa-trash"></i> </button>
					<input type="text" placeholder="Service Name" name="model_service@sename@">
					<input type="hidden" name="model_ser_del@exnamedel@" id="model_ser_del@exnamedel2@">
					<input type="hidden" placeholder="Service ID" name="model_service_id@serid@" id="model_service_id@serid2@" value="0">
				</div>

			</div>

			<div class="col-md-3"> 
				<div class="custom-control custom-radio">
					<input type="radio" class="custom-control-input" id="svati@seinc@" value="0" name="service_vat_include@seninc@">
					<label class="custom-control-label" for="svati@selinc@">VAT included</label>
				</div>
			</div>

			<div class="col-md-3">
				<div class="custom-control custom-radio">
					<input type="radio" class="custom-control-input" id="svate@seexc@" value="1" name="service_vat_include@senexc@">
					<label class="custom-control-label" for="svate@selexc@">VAT excluded</label>
					<input class="chargespercent" type="number" class="" id="special_need_vat_percent@percent@" value="0" name="special_need_percent@percent@"  step="any">
				</div>
			</div>

			<div class="col-md-3">
				<div class="Modelfee Icon text-right">
					<h6><i class="fa fa-eur" aria-hidden="true"></i> <input type="number" name="model_service_amount@seamt@" min="0" step="any" value="0"></h6>
				</div>

			</div>

		</div>

	</div>

</div>


<div id="demododelincData" style="display: none;">	
	<div id="singlemodelpriceSeparater@incdiv@"> 
		<div class="row">
			<div class="col-md-3">
				<div class="modeladdmoredata">
				<button type="button" class="btn btn-sm btn-danger" onclick="delModelAddedRow('singlemodelpriceSeparater@delete@', @delete2@)"><i class="fa fa-trash"></i></button>
				<input type="hidden" name="modelTextdel@delrow@" id="modelTextdel@delrowid@" value="0">
				<input type="hidden" name="modelTextid@mdlid@" placeholder="Name" value="0">
				<input type="text" name="modelTextName@name1@" placeholder="Name">
				</div>
			</div>

			<div class="col-md-2">
				<div class="modeladdmoredata">
				<input type="text" name="modelText1Name@name2@" placeholder="Text 1">
				</div>
			</div>
			<div class="col-md-2">
				<div class="modeladdmoredata">
				<input type="text" name="modelText2Name@name3@" placeholder="Text 2">
				</div>
			</div>

			<div class="col-md-2">
				<div class="modeladdmoredata">
				<input type="number" onkeyup="calculateAddedRow(this)" onchange="calculateAddedRow(this)" placeholder="amount" name="modelPriceValue@name@"  id="modelPriceValue@id@"  step="any">
				</div>
			</div>

		</div>
		<hr>
	</div>
	
</div>

<script type="text/javascript">
	function calculateAddedRow(thisObj){
		manageaddedModelRowCalculation();
	}


	$(function(){
		$('#additional_modal_price').keyup(function(){  
			manageaddedModelRowCalculation();
		});
	});



	function manageaddedModelRowCalculation(){

		var added_row = $('#txtmodalIncreaseValue').val();
		var t_additional_modal_price = $('#additional_modal_price').val();

		var total_cal_amount = 0;
		var additional_modal_price = 0;

		if(t_additional_modal_price != ''){
			additional_modal_price = parseFloat(t_additional_modal_price);
		}


		if(added_row != ''){
			added_row = parseInt(added_row);

			for (var i = 1; i <= added_row; i++) {
				
				var delRow = $('#modelTextdel'+i).val();
				if(delRow == 0){

					var t_row_amt = $('#modelPriceValue'+i).val();
					var row_amount = 0;

					if(t_row_amt != ''){
						row_amount = parseFloat(t_row_amt);
					}

					total_cal_amount = total_cal_amount + row_amount;
				}				
			}
		}

		total_cal_amount = total_cal_amount + additional_modal_price;
		$('#model_total_agreed').val(total_cal_amount);

		manage_modal_val();
	}

	function delModelAddedRow(remove_id, del_id){

		var confirm = window.confirm("Are you sure, you want to delete this row!");
		var confirm_text = 'Cancelled successfully';

		if (confirm == true) {
		   	$('#' + remove_id).css('display', 'none');
			$('#modelTextdel'+del_id).val(1);

			confirm_text = "Delete successfully";
		} 
		else {
		  confirm_text = "Cancelled successfully";
		}
		manageaddedModelRowCalculation();
		alert(confirm_text);		
	}


	function deleteModelExpenses(remove_id, del_id){

		var confirm = window.confirm("Are you sure, you want to delete this row!");
		var confirm_text = 'Cancelled successfully';

		if (confirm == true) {
		   	$('#' + remove_id).css('display', 'none');
			$('#model_expense_del'+del_id).val(1);

			confirm_text = "Delete successfully";
		} 
		else {
		  confirm_text = "Cancelled successfully";
		}
		alert(confirm_text);		
	}

	function deleteModelService(remove_id, del_id){

		var confirm = window.confirm("Are you sure, you want to delete this row!");
		var confirm_text = 'Cancelled successfully';

		if (confirm == true) {
		   	$('#' + remove_id).css('display', 'none');
			$('#model_ser_del'+del_id).val(1);

			confirm_text = "Delete successfully";
		} 
		else {
		  confirm_text = "Cancelled successfully";
		}
		alert(confirm_text);		
	}

</script>

<style type="text/css">
	.closemodel{
		position: absolute;
	    right: 1px;
	    background-color: #f00;
	    z-index: 9;
	    color: #fff;
	    margin-top: 1px;
	    /* margin-right: 1px; */
	    padding: 2px 5px;
	    font-size: 12px;
	    font-weight: bold;
	    cursor: pointer;

	    margin-top: -16px;
    margin-right: -1px;
    border: none;
    padding: 2px 8px;
	}
</style>


<div id="modelEditClient" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		
		<div class="modal-content">
			<div class="modal-header">         
				<h4 class="modal-title">Client<button class="closemodel" data-dismiss="modal"> X CLOSE</button></h4>
			</div>
			<form id="clientManagement">
				<div class="modal-body">
					<div class="ModelMgmt">
						<div class="InputBox">
							<div class="Form">
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">Company Name</label>
												</div>

											</div>
											<div class="col-md-7">
												<div class="form-group">
													<input type="hidden" class="form-control" placeholder="Company Name" id="c_uniquecode" name="uniquecode" />
													<input type="text" class="form-control" placeholder="Company Name" id="c_companyname" name="companyname" />
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">Client Fee</label>
												</div>
											</div>

											<div class="col-md-7">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="Client Fee 0.3%" id="c_client_fee" name="client_fee" >
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">Name</label>
												</div>
											</div>

											<div class="col-md-7">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="Name" id="c_name" name="name" />
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">Surname</label>
												</div>
											</div>

											<div class="col-md-7">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="Surname" id="c_surname" name="surname">
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">Address Line 1</label>
												</div>
											</div>

											<div class="col-md-7">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="Address Line 1" id="c_addressline1" name="addressline1"   />
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">

										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">Address Line 2</label>
												</div>
											</div>

											<div class="col-md-7">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="Address Line 2" id="c_addressline2" name="addressline2"  >
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">Post Code</label>
												</div>
											</div>

											<div class="col-md-7">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="Post Code" id="c_postcode" name="postcode" />
												</div>

											</div>

										</div>

									</div>

									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">City</label>
												</div>
											</div>
											<div class="col-md-7">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="City" id="c_city" name="city">
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">Vat Number/TIN</label>
												</div>
											</div>

											<div class="col-md-7">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="Vat Number/TIN" id="c_vat_tin_no" name="vat_tin_no" />
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">Country</label>
												</div>
											</div>

											<div class="col-md-7">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="Country" id="c_country" name="country" >
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">Email</label>
												</div>
											</div>
											<div class="col-md-7">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="Email"  id="c_email" name="email" />
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">Telephone</label>
												</div>
											</div>

											<div class="col-md-7">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="Telephone" id="c_telephone" name="telephone">
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">Mobile No.</label>
												</div>
											</div>
											<div class="col-md-7">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="Mobile No." id="c_phone" name="phone" />
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">In Germany</label>
												</div>
											</div>

											<div class="col-md-7">
												<div style="margin-top: -10px;">
													<label style="color: #001737; font-size: 12px;"><input type="radio" name="ingermany" id="c_ingermany" value="0" > <b class="checkCountry"> &nbsp;No</b> </label>

													<label style="color: #001737; font-size: 12px;"><input type="radio" name="ingermany" id="c_in_ingermany" value="1"> <b class="checkCountry"> &nbsp;Yes</b> </label>
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">Internal Notes</label>
												</div>
											</div>

											<div class="col-md-7">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="Internal Notes" id="c_internal_notes" name="internal_notes" >
												</div>
											</div>
										</div>
									</div>	



									<div class="col-md-6" style="display: none;">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">Kleinunternehmer with VAT or not</label>
												</div>
											</div>

											<div class="col-md-7">
												<div class="row">
													<div class="col-md-6">


														<div class="custom-control custom-radio">
															<input type="radio" class="custom-control-input"  id="c_kvatyes" name="kvatornot" value="1" onclick="manageKVat(1)">
															<label class="custom-control-label" for="c_kvatyes" >Yes</label>
														</div>

													</div>
													<div class="col-md-6">
														<div class="custom-control custom-radio">
															<input type="radio" class="custom-control-input" id="c_kvatno" name="kvatornot" value="0" onclick="manageKVat(0)">
															<label class="custom-control-label" for="c_kvatno">No</label>

														</div>
													</div>

													<div class="col-md-9 mt-3">
														<div id="c_kvatvalue" style="display:none;">
															<div class="input-group mb-3">
																<input type="text" class="form-control" placeholder="16" id="c_kvat_percent" name="kvat_percent" pattern="[0-9]+" title="Only  Number">
																<div class="input-group-append">
																	<span class="input-group-text">%</span>
																</div>
															</div>
														</div>	
													</div>												
												</div>
											</div>
										</div>
									</div> 									 
								</div>
							</div>
						</div>	
					</div>

					<div class="BoxHeading HeadingLeft">
						<h4>Other Shipping Address</h4>
					</div>

					<div class="ModelMgmt">
						<div class="InputBox">
							<div class="Form">
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">Company Name</label>
												</div>
											</div>

											<div class="col-md-7">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="Company Name" id="c_shipping_companyname" name="shipping_companyname"  />
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6"></div>

									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">Name</label>
												</div>
											</div>

											<div class="col-md-7">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="Name" id="c_shipping_name" name="shipping_name" />
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">Surname</label>
												</div>
											</div>

											<div class="col-md-7">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="Surname" id="c_shipping_surname" name="shipping_surname">
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">Address Line 1</label>
												</div>
											</div>

											<div class="col-md-7">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="Address Line 1" id="c_shipping_addressline1" name="shipping_addressline1"  />
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">Address Line 2</label>
												</div>
											</div>

											<div class="col-md-7">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="Address Line 2" id="c_shipping_addressline2" name="shipping_addressline2"  >
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">City</label>
												</div>
											</div>

											<div class="col-md-7">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="City" id="c_shipping_city" name="shipping_city" >
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr" >Post Code</label>
												</div>
											</div>
											<div class="col-md-7">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="Post Code" id="c_shipping_postcode" name="shipping_postcode" />
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>	
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-info btn-sm">Save</button>
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>



<div id="modalEditModel" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		
		<div class="modal-content">
			<div class="modal-header">        
				<h4 class="modal-title">Model <button class="closemodel" data-dismiss="modal"> X CLOSE</button></h4>
			</div>
			<form id="modelManagement" name="modelManagement">
				<div class="modal-body">
					<div class="ModelMgmt">
						<div class="InputBox">
							<div class="Form">
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr"> Nick Name</label>
												</div>
											</div>

											<div class="col-md-7">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="Name" id="mm_name" name="name" title="Only Character and Space" />
												</div>
											</div>
										</div>
									</div> 
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">Service Fee</label>
												</div>
											</div>
											<div class="col-md-7">
												<div class="input-group">
													<input type="text" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon2" id="mm_service_fee" name="service_fee" pattern="[0-9]+" min="0" max="100" title="Only Number"  required>
													<div class="input-group-append AppendBox">
														<span class="input-group-text" id="basic-addon2">%</span>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">Model Name</label>
												</div>
											</div>
											<div class="col-md-7">
												<div class="form-group">
													<input type="hidden" id="mm_modelcode" name="modelcode" />

													<input type="text" class="form-control" placeholder="Model Name" id="mm_model_name" name="model_name"  title="Only Character, Number and Space"    required />
												</div>
											</div>
										</div>
									</div>								

									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">Surname</label>
												</div>
											</div>
											<div class="col-md-7">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="Surname" id="mm_surname" name="surname"   title="Only Character and Space" required />
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">Address Line 1</label>
												</div>
											</div>
											<div class="col-md-7">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="Address Line 1" id="mm_addressline1" name="addressline1"   title="Only Character, Number and Space"  required   />
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">Address Line 2</label>
												</div>
											</div>

											<div class="col-md-7">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="Address Line 2" id="mm_addressline2" name="addressline2"  title="Only Character, Number and Space"/>
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">City</label>
												</div>
											</div>
											<div class="col-md-7">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="City" id="mm_city" name="city"  title="Only Character and Space" required/>
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">Post Code</label>
												</div>
											</div>

											<div class="col-md-7">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="Post Code" id="mm_postcode" name="postcode"  title="Only  Numbers" required />
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">Vat Number/TIN</label>
												</div>
											</div>
											<div class="col-md-7">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="Vat Number/TIN" id="mm_vat_tin_no" name="vat_tin_no" title="Only Character and  Number"  />
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">Telephone</label>
												</div>
											</div>
											<div class="col-md-7">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="Telephone" id="mm_telephone" name="telephone"   title="Only Numbers" />
												</div>
											</div>
										</div>
									</div>



									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">Email</label>
												</div>
											</div>
											<div class="col-md-7">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="Email" id="mm_email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Enter valid Email id (Ex : abc@expl.com) "  required />
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">Country</label>
												</div>
											</div>

											<div class="col-md-7">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="Country" id="mm_country" name="country" pattern="[A-Za-z ]+" title="Only Character and Space" required />
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">Mobile No.</label>
												</div>
											</div>
											<div class="col-md-7">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="Mobile No." id="mm_phone" name="phone" title="Only Numbers"   />
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="usr">Kleinunternehmer with VAT or not</label>
												</div>
											</div>
											<div class="col-md-7">
												<div class="row">
													<div class="col-md-6">

													<div class="custom-control custom-radio">
														<input type="radio" class="custom-control-input"  id="mm_kvatyes" name="kvatornot" value="1" onclick="manageKVatMdl(1)">
														<label class="custom-control-label" for="mm_kvatyes" >Yes</label>
													</div>
												</div>

												<div class="col-md-6">												
													<div class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" id="mm_kvatno" name="kvatornot" value="0" onclick="manageKVatMdl(0)">
														<label class="custom-control-label" for="mm_kvatno">No</label>
													</div>
												</div>

												<div class="col-md-9 mt-3">
													<div id="mm_kvatvalue" style="display: none;">
														<div class="input-group mb-3">
															<input type="text" class="form-control" placeholder="16" id="mm_kvat_percent" name="kvat_percent" pattern="[0-9]+" title="Only  Number" >
															<div class="input-group-append">
																<span class="input-group-text">%</span>
															</div>
														</div>
													</div>	
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>	
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-info btn-sm">Save</button>
				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
			</div>
		</form>

	<?php } ?>
	</div>

</div>
</div>


<script type="text/javascript">



	function manage_modal_val(){

		var sel_client = $('#save_clients option:selected').val();
		if(sel_client == ''){
			$('#displaymsg').html('No Client selected');
			$('#displaymsg').show().delay(5000).fadeOut();
			$('#displaymsg').addClass(' alert alert-danger');
			return false;
		}

		var sel_model = $('#save_model option:selected').val();

		if(sel_model == ''){

			$('#displaymsg').html('No Model selected');

			$('#displaymsg').show().delay(5000).fadeOut();

			$('#displaymsg').addClass(' alert alert-danger');

			return false;

		}
 
		// var t_m_budget = $('#model_budget').val();

		var t_m_budget_0 = $('#model_budget').val();
		var t_m_budget = $('#model_total_agreed').val();
		var t_m_vat_percent = $('#m_vat_percent').val();
		var t_m_comiss_percent = $('#modal_service_comm').val(); 
	
		var m_budget = 0;
		var m_vat_percent = 0;
		var m_comiss_percent = 0;
		var m_budget_0	 = 0;
 

		if(t_m_budget != ''){
			m_budget = parseFloat(t_m_budget);
		}

		if(t_m_vat_percent != ''){
			m_vat_percent = parseFloat(t_m_vat_percent);
		}

		if(t_m_comiss_percent != ''){
			m_comiss_percent = parseFloat(t_m_comiss_percent);
		}

		if(t_m_budget_0 != ''){
			m_budget_0 = parseFloat(t_m_budget_0);
		}
 
		var t_md_vat_amt = (m_budget * m_vat_percent);
		if(t_md_vat_amt > 0){
			t_md_vat_amt = t_md_vat_amt/100;
			t_md_vat_amt = t_md_vat_amt.toFixed(2);
		}

		if(Number.isNaN(t_md_vat_amt)){
			t_md_vat_amt = 0;
		}

		$('#modalsvatamt').html(t_md_vat_amt);
		$("#model_budget_vat_amt").val(t_md_vat_amt);

		// for MWM Model

		var selected_modal = $('input[name="apply_model_fee"]:checked').val();
		if(selected_modal == "1"){
			m_budget = m_budget_0;
		}

		var t_m_comiss_percent = $('#modelAgencyComission').val();
 
		if(t_m_comiss_percent != ''){

			m_comiss_percent = parseFloat(t_m_comiss_percent);

		}

		var t_md_comiss_amt = (m_budget * m_comiss_percent);

		if(t_md_comiss_amt > 0){

			t_md_comiss_amt = t_md_comiss_amt/100;

			t_md_comiss_amt = t_md_comiss_amt.toFixed(2);

		}



		$('#modal_service_fee').val(t_md_comiss_amt);

		$('#spanmodal_service_fee').html(t_md_comiss_amt);



		var m_vat_percent = 0;

		var t_m_vat_percent = $('#modelInclComission').val();

		if(t_m_vat_percent != ''){

			m_vat_percent = parseFloat(t_m_vat_percent);

		}





		var t_md_vat_amt = (t_md_comiss_amt * m_vat_percent);

		if(t_md_vat_amt > 0){

			t_md_vat_amt = t_md_vat_amt/100;

			t_md_vat_amt = t_md_vat_amt.toFixed(2);

		}

		$('#spnfinalcompvatamt').html(t_md_vat_amt); 
		$('#finalcompvatamt').val(t_md_vat_amt); 

	}



	$(function(){

		$('#model_budget, #modelAgencyComission, #modelInclComission, #model_total_agreed').keyup(function(){
			manage_modal_val();
		});
		$('input[name="apply_model_fee"]').change(function(){
			manage_modal_val();
		});
	});

 
	function bindmodelExpenses(){

		var expid = $('#manageexp').val();

		var t_modal_hdata = $('#demomdlexp').html(); 

		t_modal_hdata = t_modal_hdata.replace('@exname@', expid);

		t_modal_hdata = t_modal_hdata.replace('@inc@', expid);

		t_modal_hdata = t_modal_hdata.replace('@ninc@', expid);

		t_modal_hdata = t_modal_hdata.replace('@linc@', expid);

		t_modal_hdata = t_modal_hdata.replace('@exc@', expid);

		t_modal_hdata = t_modal_hdata.replace('@nexc@', expid);

		t_modal_hdata = t_modal_hdata.replace('@lexc@', expid);

		t_modal_hdata = t_modal_hdata.replace('@amt@', expid);
		t_modal_hdata = t_modal_hdata.replace('@percent@', expid);
		t_modal_hdata = t_modal_hdata.replace('@percent@', expid);

		t_modal_hdata = t_modal_hdata.replace('@rwid@', expid);
		t_modal_hdata = t_modal_hdata.replace('@rwid2@', expid);
		t_modal_hdata = t_modal_hdata.replace('@rwid3@', expid);

		t_modal_hdata = t_modal_hdata.replace('@exnamedel@', expid);
		t_modal_hdata = t_modal_hdata.replace('@exnamedel2@', expid);
 
		$('#modelexpence').append(t_modal_hdata);
		$('#manageexp').val(parseInt(expid) + 1);

	}



	function bindmodelServices(){



		var serid = $('#manageser').val();

		var t_modal_hdata = $('#demomdlser').html();



		t_modal_hdata = t_modal_hdata.replace('@sename@', serid);

		t_modal_hdata = t_modal_hdata.replace('@seinc@', serid);

		t_modal_hdata = t_modal_hdata.replace('@seninc@', serid);

		t_modal_hdata = t_modal_hdata.replace('@selinc@', serid);

		t_modal_hdata = t_modal_hdata.replace('@seexc@', serid);

		t_modal_hdata = t_modal_hdata.replace('@senexc@', serid);

		t_modal_hdata = t_modal_hdata.replace('@selexc@', serid);

		t_modal_hdata = t_modal_hdata.replace('@seamt@', serid);

		t_modal_hdata = t_modal_hdata.replace('@percent@', serid);
		t_modal_hdata = t_modal_hdata.replace('@percent@', serid);


		t_modal_hdata = t_modal_hdata.replace('@rwid@', serid);
		t_modal_hdata = t_modal_hdata.replace('@rwid2@', serid);
		t_modal_hdata = t_modal_hdata.replace('@rwid3@', serid);
		t_modal_hdata = t_modal_hdata.replace('@exnamedel@', serid);
		t_modal_hdata = t_modal_hdata.replace('@exnamedel2@', serid);
		t_modal_hdata = t_modal_hdata.replace('@serid@', serid);
		t_modal_hdata = t_modal_hdata.replace('@serid2@', serid);

		 


		$('#modelservice').append(t_modal_hdata);

		$('#manageser').val(parseInt(serid) + 1);

	}



	function bind_client(){

		var client_id = $('#save_clients option:selected').val();

		if(client_id == ''){

			alert('No Client Selected.');

			return false;

		}

		$.ajax({

			url: '<?php echo base_url('clients-for-invoice'); ?>',

			type: "POST",

			data: {

				client_id : client_id

			},

			success: function (data) { 



				var _parse_data = JSON.parse(data);

        		// console.log(_parse_data);

        		

        		// i_company_name i_fee i_name i_surname i_address_line1 i_address_line2 i_pincode i_city i_vat_tin_number i_country i_email i_telephone i_mobile_no i_internal_notes

        		// shipping_company_name shipping_surname shipping_name shipping_address_line2 shipping_address_line1 shipping_city shipping_pincode





        		if(_parse_data['error'] == 'success'){



        			$('#client_id').val(_parse_data['data'].id);

        			$('#i_company_name').val(_parse_data['data'].company_name);

        			$('#i_fee').val(_parse_data['data'].client_fee);
        			$('#modelAgencyComission').val(_parse_data['data'].client_fee);


        			$('#i_name').val(_parse_data['data'].name);

        			$('#i_surname').val(_parse_data['data'].surname);

        			$('#i_address_line1').val(_parse_data['data'].address_line1);

        			$('#i_address_line2').val(_parse_data['data'].address_line2);

        			$('#i_pincode').val(_parse_data['data'].pincode);

        			$('#i_city').val(_parse_data['data'].city);

        			$('#i_vat_tin_number').val(_parse_data['data'].vat_tin_number);

        			$('#i_country').val(_parse_data['data'].country);

        			$('#i_email').val(_parse_data['data'].email);

        			$('#i_telephone').val(_parse_data['data'].telephone);

        			$('#i_mobile_no').val(_parse_data['data'].mobile_no);

        			$('#i_internal_notes').val(_parse_data['data'].internal_notes);

        			$('#m_ingermany').val(_parse_data['data'].ingermany);


        			$('#shipping_company_name').val(_parse_data['data'].shipping_company_name);

        			$('#shipping_surname').val(_parse_data['data'].shipping_surname);

        			$('#shipping_name').val(_parse_data['data'].shipping_name);

        			$('#shipping_address_line2').val(_parse_data['data'].shipping_address_line2);

        			$('#shipping_address_line1').val(_parse_data['data'].shipping_address_line1);

        			$('#shipping_city').val(_parse_data['data'].shipping_city);

        			$('#shipping_pincode').val(_parse_data['data'].shipping_pincode);





        			$('#modal_service_comm').val(_parse_data['data'].client_fee);

					// $('#spnmserfee').html('('+_parse_data['data'].client_fee+'%)');



					// $('#m_vat_no').prop('checked', true);

					// $('#modelvalc').css('display', 'none');

					// $('#m_vat_percent').val(0);

					// $('#m_vat_yes').attr('disabled', true);

					// $('#m_vat_no').attr('disabled', true);

					// $('#modalsvat, #spanvatinccom').html('(0%)');
					// $('#modalsvat').html('(0%)');

					// $('#m_vat_yes_checked').val(0);



					// if(_parse_data['data'].kvat == 1){

					// 	$('#m_vat_yes_checked').val(1);

					// 	$('#m_vat_yes').prop('checked', true);

					// 	$('#modelvalc').css('display', 'block');

					// 	$('#m_vat_percent').val(_parse_data['data'].kvat_percent);

					// 	$('#m_vat_percent').attr('readonly', true);

					// 	// $('#modalsvat, #spanvatinccom').html('('+_parse_data['data'].kvat_percent+'%)');
					// 	$('#modalsvat').html('('+_parse_data['data'].kvat_percent+'%)');

					// }

					manage_modal_val();

				}

			}

		});

	}



	function bind_model(){

		var model_id = $('#save_model option:selected').val();

		if(model_id == ''){

			alert('No Model Selected.');

			return false;

		}

		$.ajax({

			url: '<?php echo base_url('models-for-invoice'); ?>',

			type: "POST",

			data: {

				model_id : model_id

			},

			success: function (data) { 



				var _parse_data = JSON.parse(data);

				if(_parse_data['error'] == 'success'){

					$('#model_id').val(_parse_data['data'].id);

					$('#m_model_name').val(_parse_data['data'].model_name);

					$('#m_surname').val(_parse_data['data'].surname);

					$('#m_address_line1').val(_parse_data['data'].address_line1);

					$('#m_pincode').val(_parse_data['data'].pincode);

					$('#m_vat_tin_number').val(_parse_data['data'].vat_tin_number);

					$('#m_email').val(_parse_data['data'].email);

					$('#m_name').val(_parse_data['data'].name);

					$('#m_service_fee').val(_parse_data['data'].service_fee);
					$('#m_address_line2').val(_parse_data['data'].address_line2);



					$('#m_city').val(_parse_data['data'].city);

					$('#m_country').val(_parse_data['data'].country);

					$('#m_internal_notes').val('');



					$('#m_vat_no').prop('checked', true);

					$('#modelvalc').css('display', 'none');

					$('#m_vat_percent').val(0);

					$('#m_vat_yes').attr('disabled', true);

					$('#m_vat_no').attr('disabled', true);

					$('#modalsvat').html('(0%)');

					$('#m_vat_yes_checked').val(0);



					if(_parse_data['data'].kvat == 1){

						$('#m_vat_yes_checked').val(1);

						$('#m_vat_yes').prop('checked', true);

						$('#modelvalc').css('display', 'block');

						$('#m_vat_percent').val(_parse_data['data'].kvat_percent);

						$('#m_vat_percent').attr('readonly', true);

						// $('#modalsvat, #spanvatinccom').html('('+_parse_data['data'].kvat_percent+'%)');
						$('#modalsvat').html('('+_parse_data['data'].kvat_percent+'%)');

					}


				}

			}

		});

	}



	$("#invoice_number").blur(function(){

		var checkinvoic = $('#invoice_number').val();
		// var i='<?php echo get_invoice_no('+checkinvoic+')?>';

		// alert(i);



		$.ajax({

			url: '<?php echo base_url('invoice-no-info'); ?>',

			type: "POST",

			data: {

				invoice_number : checkinvoic

			},

			success: function (data) { 



				var _parse_data = JSON.parse(data);

				console.log(_parse_data);

				if(_parse_data['error'] == 'error'){

					$('#iN').fadeIn('slow').delay(2000).fadeOut('slow');



				}

			}

		});

	});



	$(function(){
		$('.token-data input[type="checkbox"]').click(function(){
			// $('token-data input[type="checkbox"]').prop('checked', false);
			var page = <?php echo $page ?>;
			var record = $(this).attr('value');
			var url = "<?php echo base_url('generate-new-invoice/?page='); ?>";
			url = url + page + '&token='+record;
			window.location.href = url;
		})
	});



	$(function(){

		$('#formInvoice').submit(function(e){ 
			e.preventDefault();

			$('#displaymsg').removeClass(' alert alert-info');
			$('#displaymsg').removeClass(' alert alert-success');
			$('#displaymsg').removeClass(' alert alert-danger');

			$('#displaymsg').html('Please wait');
			$('#displaymsg').show().delay(5000).fadeOut();
			$('#displaymsg').addClass(' alert alert-info');

		 

            $.ajax({

            	url: '<?php echo base_url('save-created-refund'); ?>',
            	type: "POST",
            	data: new FormData(this),
            	contentType: false,
            	cache: false,
            	processData: false,
            	async: true,
            	success: function (data) { 

            		$('#displaymsg').removeClass(' alert alert-info');
            		if(data == "success"){
            			$('#displaymsg').html('Invoice created Success');
            			$('#displaymsg').show().delay(5000).fadeOut();
            			$('#displaymsg').addClass(' alert alert-success');
            			window.location.href = "<?php echo base_url('invoive-refund-details/'); ?>" + $('#invoice_number').val();
            			// location.reload();
            			return true;
            		} 

            		if(data == "error"){
            			$('#displaymsg').html('Error to create invoice, retry');
            			$('#displaymsg').show().delay(5000).fadeOut();
            			$('#displaymsg').addClass(' alert alert-danger');
            			return false;
            		} 
            		$('#displaymsg').html(data);
            		$('#displaymsg').show().delay(5000).fadeOut();
            		$('#displaymsg').addClass(' alert alert-danger');
            	}
            });
        });
	})



// clientsssssss


function manageKVat(showdata){
	$('#c_kvatvalue').css('display', 'none');
	if(showdata == 1){
		$('#c_kvatvalue').css('display', 'block');
	}
} 

function manageKVatMdl(showdata){
	$('#mm_kvatvalue').css('display', 'none');
	if(showdata == 1){
		$('#mm_kvatvalue').css('display', 'block');
	}
} 


function editClient(){ 
	var clientcode = $('#save_clients option:selected').val();
	if(clientcode == ''){
		alert('No client selected to edit.');
		return false;
	}

	$.ajax({
		url: '<?php echo base_url('edit-generate-invoice-client'); ?>',
		type: "POST",
		data: {
			clientcode : clientcode
		}, 
		success: function (data) {
			var response = JSON.parse(data);
	    	// console.log(response) ;
	    	if(response['error'] == 'success'){	    		 
	    		$('#c_uniquecode').val(response['data'].unique_code);
	    		$('#c_companyname').val(response['data'].company_name);
	    		$('#c_client_fee').val(response['data'].client_fee);
	    		$('#c_name').val(response['data'].name);
	    		$('#c_surname').val(response['data'].surname);
	    		$('#c_addressline1').val(response['data'].address_line1);
	    		$('#c_addressline2').val(response['data'].address_line2);
	    		$('#c_postcode').val(response['data'].pincode);
	    		$('#c_email').val(response['data'].email);
	    		$('#c_city').val(response['data'].city);
	    		$('#c_country').val(response['data'].country);
	    		$('#c_vat_tin_no').val(response['data'].vat_tin_number);
	    		$('#c_telephone').val(response['data'].telephone);
	    		$('#c_phone').val(response['data'].mobile_no);
	    		$('#c_internal_notes').val(response['data'].internal_notes);

	    		if(response['data'].ingermany == 1){
	    			$('#c_in_ingermany').attr('checked', true);
	    		}
	    		else{
	    			$('#c_ingermany').attr('checked', true);
	    		}

	    		$('#c_kvatvalue').css('display', 'none');
	    		$('#c_kvat_percent').val(0);
	    		$('#c_kvatno').prop('checked', true);

	    		if(response['data'].kvat == 1){
	    			$('#c_kvatvalue').css('display', 'block');
	    			$('#c_kvat_percent').val(response['data'].kvat_percent);
	    			$('#c_kvatyes').prop('checked', true);
	    		}

	    		$('#c_shipping_companyname').val(response['data'].shipping_company_name);
	    		$('#c_shipping_name').val(response['data'].shipping_name);
	    		$('#c_shipping_surname').val(response['data'].shipping_surname);
	    		$('#c_shipping_addressline1').val(response['data'].shipping_address_line1);
	    		$('#c_shipping_addressline2').val(response['data'].shipping_address_line2);
	    		$('#c_shipping_postcode').val(response['data'].shipping_pincode);
	    		$('#c_shipping_city').val(response['data'].shipping_city); 
	    		
	    	} 
	    }
	});
}

$(function(){
	$('#clientManagement').submit(function(e){

		e.preventDefault();
		$('#displaymsg').removeClass(' alert alert-info');
		$('#displaymsg').removeClass(' alert alert-success');
		$('#displaymsg').removeClass(' alert alert-danger');


		$('#displaymsg').html('Please wait');
		$('#displaymsg').show().delay(5000).fadeOut();
		$('#displaymsg').addClass(' alert alert-info');
        // $('#myloader').show();

        $.ajax({

        	url: '<?php echo base_url('save-edit-client-management'); ?>',
        	type: "POST",
        	data: new FormData(this),
        	contentType: false,
        	cache: false,
        	processData: false,
        	async: true,

        	success: function (data) { 

        		$('#displaymsg').removeClass(' alert alert-info');
        		if(data == "success"){
        			$('#displaymsg').html('Client successfully saved');
        			$('#displaymsg').show().delay(5000).fadeOut();
        			$('#displaymsg').addClass(' alert alert-success');
        			bind_client();
        			return true;
        		} 
        		if(data == "error"){
        			$('#displaymsg').html('Error to client profile, retry');
        			$('#displaymsg').show().delay(5000).fadeOut();
        			$('#displaymsg').addClass(' alert alert-danger');
        			return false;
        		}
        		$('#displaymsg').html(data);
        		$('#displaymsg').show().delay(5000).fadeOut();
        		$('#displaymsg').addClass(' alert alert-danger');

        	}
        });
    })
});

// modallllll



function editModel(){ 
	var modelcode = $('#save_model option:selected').val();
	if(modelcode == ''){
		alert('No client selected to edit.');
		return false;
	}

	$.ajax({
		url: '<?php echo base_url('edit-generate-invoice-modal'); ?>',
		type: "POST",
		data: {
			modelcode : modelcode
		}, 
		success: function (data) {
			var response = JSON.parse(data);
	    	console.log(response) ;
 
	    	if(response['error'] == 'success'){	    		 
	    		$('#mm_modelcode').val(response['data'].unique_code);
	    		$('#mm_name').val(response['data'].name);
	    		$('#mm_model_name').val(response['data'].model_name);
	    		$('#mm_service_fee').val(response['data'].service_fee);

	    		$('#mm_surname').val(response['data'].surname);
	    		$('#mm_addressline1').val(response['data'].address_line1);
	    		$('#mm_addressline2').val(response['data'].address_line2);
	    		$('#mm_city').val(response['data'].city);
	    		$('#mm_postcode').val(response['data'].pincode);
	    		$('#mm_vat_tin_no').val(response['data'].vat_tin_number);
	    		$('#mm_country').val(response['data'].country);
	    		$('#mm_email').val(response['data'].email);
	    		$('#mm_telephone').val(response['data'].telephone);
	    		$('#mm_phone').val(response['data'].mobile_no);
	    		 
 	    		$('#mm_kvatvalue').css('display', 'none');
	    		$('#mm_kvat_percent').val(0);
	    		$('#mm_kvatno').prop('checked', true);

	    		if(response['data'].kvat == 1){
	    			$('#mm_kvatvalue').css('display', 'block');
	    			$('#mm_kvat_percent').val(response['data'].kvat_percent);
	    			$('#mm_kvatyes').prop('checked', true);
	    		}
	    	} 
	    }
	});
}



$(function(){

		$('#modelManagement').submit(function(e){
			e.preventDefault();

			$('#displaymsg').removeClass(' alert alert-info');
			$('#displaymsg').removeClass(' alert alert-success');
			$('#displaymsg').removeClass(' alert alert-danger');

			$('#displaymsg').html('Please wait');
			$('#displaymsg').show().delay(5000).fadeOut();
			$('#displaymsg').addClass(' alert alert-info');
            // $('#myloader').show();
            $.ajax({

            	url: '<?php echo base_url('save-edit-model-management'); ?>',
            	type: "POST",
            	data: new FormData(this),
            	contentType: false,
            	cache: false,
            	processData: false,
            	async: true,
            	success: function (data) { 

            		$('#displaymsg').removeClass(' alert alert-info');
            		if(data == "success"){
            			$('#displaymsg').html('Model created Success');
            			$('#displaymsg').show().delay(5000).fadeOut();
            			$('#displaymsg').addClass(' alert alert-success');
            			bind_model();
            			return true;
            		}

            		if(data == "error"){

            			$('#displaymsg').html('Error to client profile, retry');
            			$('#displaymsg').show().delay(5000).fadeOut();
            			$('#displaymsg').addClass(' alert alert-danger');
            			return false;
            		}

            		$('#displaymsg').html(data);
            		$('#displaymsg').show().delay(5000).fadeOut();
            		$('#displaymsg').addClass(' alert alert-danger');
            	}
            });
        })
	})

 

function moreModelData(){

	var increasedata = $('#txtmodalIncreaseValue').val();
	var modeladdmoreRow = $('#demododelincData').html();

	increasedata = parseInt(increasedata) + 1; 

	modeladdmoreRow = modeladdmoreRow.replace('@incdiv@', increasedata);
	modeladdmoreRow = modeladdmoreRow.replace('@name1@', increasedata);

	modeladdmoreRow = modeladdmoreRow.replace('@name2@', increasedata);
	modeladdmoreRow = modeladdmoreRow.replace('@name3@', increasedata);
	modeladdmoreRow = modeladdmoreRow.replace('@name@', increasedata);
	modeladdmoreRow = modeladdmoreRow.replace('@id@', increasedata);
	modeladdmoreRow = modeladdmoreRow.replace('@totalshowid@', increasedata);

	modeladdmoreRow = modeladdmoreRow.replace('@delrow@', increasedata); 
	modeladdmoreRow = modeladdmoreRow.replace('@delrowid@', increasedata); 
	modeladdmoreRow = modeladdmoreRow.replace('@delete@', increasedata); 
	modeladdmoreRow = modeladdmoreRow.replace('@delete2@', increasedata); 
	modeladdmoreRow = modeladdmoreRow.replace('@mdlid@', increasedata); 

	$('#newModelTotalFee').append(modeladdmoreRow);
	$('#txtmodalIncreaseValue').val(increasedata);
}

</script>



