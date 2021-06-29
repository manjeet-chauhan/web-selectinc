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



	#model_budget, #model_total_agreed, .Modelfee input[type="number"]{

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

							<h4>Edit Invoice</h4>

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
											<div class="form-group">
											 	<input type="text" id="search-bar" placeholder="Browse Older Invoices for Duplication">
													<a href="javascript:void(0)"><img class="search-icon" src="http://www.endlessicons.com/wp-content/uploads/2012/12/search-icon.png"></a> 
											</div>
										</div>
									</div>
								</form>
								
							</div>
						</div>
					 

					<div class="clearfix"></div>
 
				


			<form id="formInvoice" name="formInvoice">

				<div class="OpenTicket Box Boxtwo NoRadius ModelMgmt" >

					<div class="row HeightInitial">

						<div class="col-md-12 MinusPadding">

							<div class="col-md-6 pl-0">

								<div class="d-flex">

									<div class="col-md-5 pl-0">

										<div class="Status mt-2">

											<h6>Token Id</h6>

										</div>

									</div>

									<div class="col-md-7 ">

										<div class="Status Feedback mt-2">

											<h4>#<?php echo $invoice_info->issue_id; ?></h4>

										</div>

									</div>

								</div>

							</div>

							<hr />

							<div class="clearfix"></div>

							<div class="col-md-12 pl-0">

								<div class="d-flex">

									<div class="col-md-6 pl-0">

										<div class="d-flex">

											<div class="col-md-5 pl-0">

												<div class="Status mt-2">

													<h6>Invoice number</h6>

												</div>

											</div>

											<div class="col-md-7 ">

												<div class="Status Feedback mt-2">

													<div class="form-group InputBox">

														<input type="text" class="form-control" placeholder="Invoice Number" id="invoice_number" name="invoice_number"  value="<?php echo $invoice_info->invoice_number;?>">

														 
													</div>

												</div>

											</div>

										</div>

									</div>



									<input type="hidden" name="client_ids" id="client_id" value="<?php echo $invoice_info->client_id; ?>">

									<input type="hidden" name="model_ids" id="model_id" value="<?php echo $invoice_info->model_id; ?>">



									<div class="col-md-6">

										<div class="d-flex">



											<div class="col-md-6">

												<div class="Status Feedback mt-2 InputBox">

													<?php



													$clients = get_clients($user_id);

													?>


													<select class="custom-select myselect" id="save_clients" name="save_clients" 

													onchange="bind_client();">

													<option value="" selected disabled > Select Client</option>

													<?php 

													if(!empty($clients)){

														foreach ($clients as $client){

															$selected = '';
															if($invoice_info->client_id == $client->id){
																$selected = 'selected';
															}

															?>

															<option <?php echo $selected ?>

															value="<?php echo $client->id; ?>"
															value_code="<?php echo $client->unique_code; ?>"

															data-fee="<?php echo $client->client_fee; ?>"

															data-kvat="<?php echo $client->kvat; ?>"

															data-kvat_percent="<?php echo $client->kvat_percent; ?>"

															><?php echo ucwords(strtolower($client->company_name)); ?></option>

															<?php

														}

													}

													?> 

												</select>
												<div class="editbtn"> 
													<a href="" data-toggle="modal" data-target="#modelEditClient" onclick="editClient();">Edit Client</a>
												</div>

											</div>

										</div>



										<div class="col-md-6">

											<div class="Status Feedback mt-2 InputBox">

												<?php

												$models = get_models($user_id); 

															// print_r($models);

												?>

												<select class="custom-select myselect" id="save_model" name="save_model" 

												onchange="bind_model();">

												<option value="" selected disabled > Select Model</option>

												<?php 

												if(!empty($models)){

													foreach ($models as $model){

														$selected = '';
															if($invoice_info->model_id == $model->id){
																$selected = 'selected';
															}

															?>

														?>

														<option <?php echo $selected; ?>

														value="<?php echo $model->id; ?>"

														value_code="<?php echo $model->unique_code; ?>"

														data-fee="<?php echo $model->service_fee; ?>"

														data-kvat="<?php echo $model->kvat; ?>"

														data-kvat_percent="<?php echo $model->kvat_percent; ?>"

														><?php echo ucwords(strtolower($model->model_name)); ?></option>

														<?php

													}

												}

												?> 

											</select>
											<div class="editbtn"><a href="" data-toggle="modal" data-target="#modalEditModel" onclick="editModel();">Edit Model</a></div>

										</div>

									</div>

								</div>

							</div>

						</div>

					</div>



					<div class="ModelMgmt pl-0 mt-0">

						<div class="row">

							<div class="col-md-6">

								<div class="InputBox">

									<div class="Form">

										<div class="row">

											<div class="col-md-5">

												<div class="form-group">

													<label for="usr">Company Name</label>

												</div>

											</div>

											<div class="col-md-7">

												<div class="form-group">

													<input type="text" class="form-control" placeholder="Company Name" id="i_company_name" name="i_company_name" value="<?php echo $invoice_info->i_company_name ?>">

													<input type="hidden" id="issue_id" name="issue_id" value="<?php echo $invoice_info->issue_id; ?>">

												</div>

											</div>

											<div class="col-md-5">

												<div class="form-group">

													<label for="usr">Name</label>

												</div>

											</div>

											<div class="col-md-7">

												<div class="form-group">

													<input type="text" class="form-control" placeholder="Name" id="i_name" name="i_name" value="<?php echo $invoice_info->i_name ?>">

												</div>

											</div>

											<div class="col-md-5">

												<div class="form-group">

													<label for="usr">Address Line 1</label>

												</div>

											</div>

											<div class="col-md-7">

												<div class="form-group">

													<input type="text" class="form-control" placeholder="Address Line 1"  id="i_address_line1" name="i_address_line1" value="<?php echo $invoice_info->i_address_line1 ?>">

												</div>

											</div>

											<div class="col-md-5">

												<div class="form-group">

													<label for="usr">Post Code</label>

												</div>

											</div>

											<div class="col-md-7">

												<div class="form-group">

													<input type="text" class="form-control" placeholder="Post Code"  id="i_pincode" name="i_pincode" value="<?php echo $invoice_info->i_pincode ?>">

												</div>

											</div>

											<div class="col-md-5">

												<div class="form-group">

													<label for="usr">Vat Number/TIN</label>

												</div>

											</div>

											<div class="col-md-7">

												<div class="form-group">

													<input type="text" class="form-control" placeholder="Vat Number/TIN"  id="i_vat_tin_number" name="i_vat_tin_number" value="<?php echo $invoice_info->i_vat_tin_number ?>">

												</div>

											</div>

											<div class="col-md-5">

												<div class="form-group">

													<label for="usr">Email</label>

												</div>

											</div>

											<div class="col-md-7">

												<div class="form-group">

													<input type="text" class="form-control" placeholder="Email"  id="i_email" name="i_email"  value="<?php echo $invoice_info->i_email ?>">

												</div>

											</div>

											<div class="col-md-5">

												<div class="form-group">

													<label for="usr">Mobile No.</label>

												</div>

											</div>

											<div class="col-md-7">

												<div class="form-group">

													<input type="text" class="form-control" placeholder="Mobile No."  id="i_mobile_no" name="i_mobile_no" value="<?php echo $invoice_info->i_mobile_no ?>">

												</div>

											</div>

										</div>

									</div>

								</div>

							</div>

							<div class="col-md-6">

								<div class="InputBox">

									<div class="Form">

										<div class="row">

											<div class="col-md-5">

												<div class="form-group">

													<label for="usr">Fee(%)</label>

												</div>

											</div>

											<div class="col-md-7">

												<div class="form-group">

													<input type="text" class="form-control" placeholde="Surname"  id="i_fee" name="i_fee" value="<?php echo $invoice_info->i_fee ?>">

												</div>

											</div>

											<div class="col-md-5">

												<div class="form-group">

													<label for="usr">Surname</label>

												</div>

											</div>

											<div class="col-md-7">

												<div class="form-group">

													<input type="text" class="form-control" placeholder="Surname"  id="i_surname" name="i_surname" value="<?php echo $invoice_info->i_surname ?>">

												</div>

											</div>


											<div class="col-md-5">

												<div class="form-group">

													<label for="usr">Address Line 2</label>

												</div>

											</div>

											<div class="col-md-7">

												<div class="form-group">

													<input type="text" class="form-control" placeholder="Address Line 2"  id="i_address_line2" name="i_address_line2" value="<?php echo $invoice_info->i_address_line2 ?>">

												</div>

											</div>


											<div class="col-md-5">

												<div class="form-group">

													<label for="usr">Address Line 2</label>

												</div>

											</div>

											<div class="col-md-7">

												<div class="form-group">

													<input type="text" class="form-control" placeholder="Address Line 2"  id="i_address_line2" name="i_address_line2" value="<?php echo $invoice_info->i_address_line2 ?>">

												</div>

											</div>

											<div class="col-md-5">

												<div class="form-group">

													<label for="usr">City</label>

												</div>

											</div>

											<div class="col-md-7">

												<div class="form-group">

													<input type="text" class="form-control" placeholder="City" id="i_city" name="i_city" value="<?php echo $invoice_info->i_city ?>">

												</div>

											</div>

											<div class="col-md-5">

												<div class="form-group">

													<label for="usr">Country</label>

												</div>

											</div>

											<div class="col-md-7">

												<div class="form-group">

													<input type="text" class="form-control" placeholder="Country"  id="i_country" name="i_country" value="<?php echo $invoice_info->i_country ?>">

												</div>

											</div>

											<div class="col-md-5">

												<div class="form-group">

													<label for="usr">Telephone</label>

												</div>

											</div>

											<div class="col-md-7">

												<div class="form-group">

													<input type="text" class="form-control" placeholder="Telephone"  id="i_telephone" name="i_telephone" value="<?php echo $invoice_info->i_telephone ?>">

												</div>

											</div>



										</div>

									</div>

								</div>

							</div>

							<div class="col-md-12">

								<div class="ModelMgmt Notes">

									<h3>Internal Notes</h3>

									<textarea class="form-control"  rows="5" placeholder="Lorem ipsum dolor sit amet..." id="i_internal_notes" name="i_internal_notes"><?php echo $invoice_info->i_internal_notes ?></textarea>

								</div>

							</div>

						</div>			

					</div>

					<h6>Other Shipping Address</h6>

					<div class="row">

						<div class="col-md-6">

							<div class="InputBox">

								<div class="Form">

									<div class="row">

										<div class="col-md-5">

											<div class="form-group">

												<label for="usr">Company Name</label>

											</div>

										</div>

										<div class="col-md-7">

											<div class="form-group">

												<input type="text" class="form-control" placeholder="Company Name" id="shipping_company_name" name="shipping_company_name" value="<?php echo $invoice_info->shipping_company_name ?>">

											</div>

										</div>

										<div class="col-md-5">

											<div class="form-group">

												<label for="usr">Name</label>

											</div>

										</div>

										<div class="col-md-7">

											<div class="form-group">

												<input type="text" class="form-control" placeholder="Name" id="shipping_name" name="shipping_name" value="<?php echo $invoice_info->shipping_name ?>">

											</div>

										</div>

										<div class="col-md-5">

											<div class="form-group">

												<label for="usr">Address Line 1</label>

											</div>

										</div>

										<div class="col-md-7">

											<div class="form-group">

												<input type="text" class="form-control" placeholder="Address Line 1" id="shipping_address_line1" name="shipping_address_line1" value="<?php echo $invoice_info->shipping_address_line1 ?>">

											</div>

										</div>

										<div class="col-md-5">

											<div class="form-group">

												<label for="usr">Post Code</label>

											</div>

										</div>

										<div class="col-md-7">

											<div class="form-group">

												<input type="text" class="form-control" placeholder="Post Code"  id="shipping_pincode" name="shipping_pincode" value="<?php echo $invoice_info->shipping_pincode ?>">

											</div>

										</div>

									</div>

								</div>

							</div>

						</div>

						<div class="col-md-6">

							<div class="InputBox">

								<div class="Form">

									<div class="row">

										<div class="col-md-5">

											<div class="form-group">

												<label for="usr">Surname</label>

											</div>

										</div>

										<div class="col-md-7">

											<div class="form-group">

												<input type="text" class="form-control" placeholder="Surname"  id="shipping_surname" name="shipping_surname" value="<?php echo $invoice_info->shipping_surname ?>">

											</div>

										</div>

										<div class="col-md-5">

											<div class="form-group">

												<label for="usr">Address Line 2</label>

											</div>

										</div>

										<div class="col-md-7">

											<div class="form-group">

												<input type="text" class="form-control" placeholder="Address Line 2"  id="shipping_address_line2" name="shipping_address_line2" value="<?php echo $invoice_info->shipping_address_line2 ?>">

											</div>

										</div>

										<div class="col-md-5">

											<div class="form-group">

												<label for="usr">City</label>

											</div>

										</div>

										<div class="col-md-7">

											<div class="form-group">

												<input type="text" class="form-control" placeholder="Address Line 2"  id="shipping_city" name="shipping_city" value="<?php echo $invoice_info->shipping_city ?>">

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

		<div class="OpenTicket Box Boxtwo NoRadiusForm">

			<div class="row"> 



				<div class="col-md-6">

					<div class="InputBox">

						<div class="Form">

							<div class="row">

								<div class="col-md-5">

									<div class="form-group">

										<label for="usr">Payment terms</label>

									</div>

								</div>

								<div class="col-md-7">
									<select class="custom-select" id="payment_terms" name="payment_terms" onchange="addDays();">

										<option value='15' <?php echo $invoice_info->payment_terms == 15 ?  'selected' :  '' ?>>Pay within 15 days</option>
										<option value='30' <?php echo $invoice_info->payment_terms == 30 ?  'selected' :  '' ?>>Pay within 30 days</option>
										<option value='60' <?php echo $invoice_info->payment_terms == 60 ?  'selected' :  '' ?>>Pay within 60 days</option>
										<option value='90' <?php echo $invoice_info->payment_terms == 90 ?  'selected' :  '' ?>>Pay within 90 days</option>
										<option value='90' <?php echo$invoice_info->payment_terms == 90 ?  'selected' :  '' ?>>Pay within 90 days</option>
										<option value='120' <?php  echo $invoice_info->payment_terms == 120 ?  'selected' :  '' ?>>Pay within 120 days</option>

									</select> 
								</div>
							</div>
						</div>
					</div>

				</div>
				<div class="col-md-6"></div>

				<div class="col-md-6">

					<div class="InputBox">

						<div class="Form">

							<div class="row">

								<div class="col-md-5">

									<div class="form-group">

										<label for="usr">Job Date From</label>

									</div>

								</div>

								<div class="col-md-7">

									<div class="form-group">

										<input type="text" class="form-control dateSelector" placeholder="Job Date From " id="job_date" name="job_date" value="<?php echo $invoice_info->job_date; ?>">

									</div>

								</div>

							</div>

						</div>

					</div>

				</div>

				<div class="col-md-6">

					<div class="InputBox">

						<div class="Form">

							<div class="row">

								<div class="col-md-5">

									<div class="form-group">

										<label for="usr">Job Date Till</label>

									</div>

								</div>

								<div class="col-md-7">

									<div class="form-group"> 

										<input type="text" class="form-control dateSelector" placeholder="Job Date Till" id="job_date" name="job_date_till" value="<?php echo $invoice_info->job_date_till; ?>">

									</div>

								</div>

							</div>

						</div>

					</div>

				</div>

				<div class="col-md-6">

					<div class="InputBox">

						<div class="Form">

							<div class="row">

								<div class="col-md-5">

									<div class="form-group">

										<label for="usr">Invoice Date</label>

									</div>

								</div>

								<div class="col-md-7">

									<div class="form-group">

										<input type="text" class="form-control dateSelector" id="invoice_date" name="invoice_date" value="<?php echo $invoice_info->invoice_date; ?>" onchange="addDays();">

									</div>

								</div>

								<div class="col-md-5">

									<div class="form-group">

										<label for="usr">Usage</label>

									</div>

								</div>

								<div class="col-md-7"> 
									<div class="form-group"> 
										<textarea type="text" class="form-control" placeholder="See booking confirmation" rows="4" id="uses" name="uses"><?php echo $invoice_info->uses; ?></textarea> 
									</div> 
								</div> 

							</div>

						</div>

					</div>

				</div>

				<div class="col-md-6">

					<div class="InputBox">

						<div class="Form">

							<div class="row">

								<div class="col-md-12"></div>

								<div class="col-md-5">

									<div class="form-group">

										<label for="usr">Invoice Due Date</label>

									</div>

								</div>

								<div class="col-md-7">

									<div class="form-group">

										<?php 
											$Date1 = $invoice_info->invoice_date;
											$date = new DateTime($Date1);
											$date->modify('+'.(int)$invoice_info->payment_terms.' day');
											$invoive_due_date = $date->format('Y-m-d');
										?>


										<input type="text" class="form-control dateSelector" id="invoive_due_date" name="invoive_due_date" value="<?php echo $invoive_due_date; ?>">

									</div>

								</div>

								<div class="col-md-5">

									<div class="form-group">

										<label for="usr">Reminder</label>

									</div>

								</div>

								<div class="col-md-7">													

									<div class="form-group">

										<input type="text" class="form-control" value="3" id="reminder" name="reminder" value="<?php echo $invoice_info->reminder; ?>">

									</div>

								</div>

								<div class="col-md-5">

									<div class="form-group">

										<label for="usr">Interval in days</label>

									</div>

								</div>

								<div class="col-md-7">

									<select class="custom-select" id="interval_in_days" name="interval_in_days">

										<option value='15' <?php echo $invoice_info->interval_in_days == 15 ? 'selected' : '' ?>>15 days</option>

										<option value='30' <?php echo $invoice_info->interval_in_days == 30 ? 'selected' : '' ?> >30 days</option>

										<option value='60' <?php echo $invoice_info->interval_in_days == 60 ? 'selected' : '' ?> >60 days</option>

										<option value='90' <?php echo $invoice_info->interval_in_days == 90 ? 'selected' : '' ?> >90 days</option>

										<option value='120' <?php echo $invoice_info->interval_in_days == 120 ? 'selected' : '' ?> >120 days</option>

									</select> 

								</div>

							</div>

						</div>

					</div>

				</div>

			</div>

		</div>

		<div class="OpenTicket Box Boxtwo NoRadiusForm">

			<div class="row HeightInitial">

				<div class="col-md-12 MinusPadding">

					<div class="ModelMgmt p-0">

						<div class="row">

							<div class="col-md-6">

								<div class="InputBox">

									<div class="Form">

										<div class="row">

											<div class="col-md-5">

												<div class="form-group">

													<label for="usr">Model Name</label>

												</div>

											</div>

											<div class="col-md-7">

												<div class="form-group">

													<input type="text" class="form-control" placeholder="Model Name" id="m_model_name" name="m_model_name" value="<?php echo $invoice_info->m_model_name; ?>">

												</div>

											</div>

											<div class="col-md-5">

												<div class="form-group">

													<label for="usr">Surname</label>

												</div>

											</div>

											<div class="col-md-7">

												<div class="form-group">

													<input type="text" class="form-control" placeholder="Surname" id="m_surname" name="m_surname" value="<?php echo $invoice_info->m_surname; ?>">

												</div>

											</div>

											<div class="col-md-5">

												<div class="form-group">

													<label for="usr">Address Line 1</label>

												</div>

											</div>

											<div class="col-md-7">

												<div class="form-group">

													<input type="text" class="form-control" placeholder="Address Line 1" id="m_address_line1" name="m_address_line1" value="<?php echo $invoice_info->m_address_line1; ?>">

												</div>

											</div>

											<div class="col-md-5">

												<div class="form-group">

													<label for="usr">Post Code</label>

												</div>

											</div>

											<div class="col-md-7">

												<div class="form-group">

													<input type="text" class="form-control" placeholder="Post Code" id="m_pincode" name="m_pincode" value="<?php echo $invoice_info->m_pincode; ?>">

												</div>

											</div>

											<div class="col-md-5">

												<div class="form-group">

													<label for="usr">Vat Number/TIN</label>

												</div>

											</div>

											<div class="col-md-7">

												<div class="form-group">

													<input type="text" class="form-control" placeholder="Vat Number/TIN" id="m_vat_tin_number" name="m_vat_tin_number" value="<?php echo $invoice_info->m_vat_tin_number; ?>">

												</div>

											</div>

											<div class="col-md-5">

												<div class="form-group">

													<label for="usr">Email</label>

												</div>

											</div>

											<div class="col-md-7">

												<div class="form-group">

													<input type="text" class="form-control" placeholder="Email" id="m_email" name="m_email" value="<?php echo $invoice_info->m_email; ?>">

												</div>

											</div>

										</div>

									</div>

								</div>

							</div>

							<div class="col-md-6">

								<div class="InputBox">

									<div class="Form">

										<div class="row">

											<div class="col-md-5">

												<div class="form-group">

													<label for="usr">Name</label>

												</div>

											</div>

											<div class="col-md-7">

												<div class="form-group">

													<input type="text" class="form-control" placeholder="Name" id="m_name" name="m_name" value="<?php echo $invoice_info->m_name; ?>">

												</div>

											</div>

											<div class="col-md-5">

												<div class="form-group">

													<label for="usr">Service Fee</label>

												</div>

											</div>

											<div class="col-md-7">

												<div class="form-group">

													<input type="text" class="form-control" placeholder="Service Fee" id="m_service_fee" name="m_service_fee" value="<?php echo $invoice_info->m_service_fee ?>">

												</div>

											</div>

											<div class="col-md-5">

												<div class="form-group">

													<label for="usr">Address Line 2</label>

												</div>

											</div>

											<div class="col-md-7">

												<div class="form-group">

													<input type="text" class="form-control" placeholder="Address Line 2" id="m_address_line2" name="m_address_line2" value="<?php echo $invoice_info->m_address_line2; ?>">

												</div>

											</div>

											<div class="col-md-5">

												<div class="form-group">

													<label for="usr">City</label>

												</div>

											</div>

											<div class="col-md-7">

												<div class="form-group">

													<input type="text" class="form-control" placeholder="City" id="m_city" name="m_city" value="<?php echo $invoice_info->m_city; ?>">

												</div>

											</div>

											<div class="col-md-5">

												<div class="form-group">

													<label for="usr">Country</label>

												</div>

											</div>

											<div class="col-md-7">

												<div class="form-group">

													<input type="text" class="form-control" placeholder="Country" id="m_country" name="m_country" value="<?php echo $invoice_info->m_country; ?>">



													<input type="hidden" class="form-control" placeholder="Country" id="m_ingermany" name="m_ingermany" value="<?php echo $invoice_info->m_ingermany; ?>">



												</div>

											</div>

											<div class="col-md-5">

												<div class="form-group">

													<label for="usr">Internal Notes</label>

												</div>

											</div>

											<div class="col-md-7">

												<div class="form-group">

													<textarea class="form-control" rows="3" placeholder="Internal Notes" id="m_internal_notes" name="m_internal_notes"><?php echo $invoice_info->m_internal_notes; ?></textarea>

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

			<div class="row">

				<div class="col-md-6">

					<div class="InputBox">

						<div class="Form">

							<div class="row">

								<div class="col-md-12">

									<div class="form-group">

									</div>

									<div class="row">

										<div class="col-md-6">

											<div class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" id="m_vat_yes" name="m_vat" value="1" <?php if(!empty($invoice_info)&&($invoice_info->m_vat==1)){  echo "checked"; }?>>
												<input type="hidden" name="m_vat_yes_checked" id="m_vat_yes_checked" value="1">
												<label class="custom-control-label" for="ot_vat_yes">Yes VAT added</label>
											</div>
										</div>

										<div class="col-md-6">

											<div class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" id="m_vat_no" name="m_vat" value="0" <?php if(!empty($invoice_info)&&($invoice_info->m_vat==0)){  echo "checked"; }?>>
												<label class="custom-control-label" for="ot_vat_no">No, VAT not added</label>

											</div>

										</div>

									</div>

								</div>

								<div class="col-md-6 mt-3">

									<div id="modelvalc" class="answer-vat" style="display: <?php echo $invoice_info->m_vat ? 'block' : 'none' ;  ?>">

										<div class="input-group mb-3">
											<input type="text" class="form-control" placeholder="16" id="m_vat_percent" name="m_vat_percent" value="<?php if(!empty($invoice_info)){  echo $invoice_info->m_vat_percent; }?>">

											<div class="input-group-append">
												<span class="input-group-text">%</span>
											</div>
										</div>

									</div>

									<style type="text/css">

										.answer-vat { display:none }

									</style>					
									<script type="text/javascript">

										$(function() {

											$("#coupon_question2").on("click",function() {

												$(".answer-vat").toggle(this.checked);

											});

										});

									</script>

								</div>

							</div>

						</div>

					</div>

				</div>

			</div>

		</div>

		<div class="OpenTicket Box Boxtwo NoRadiusForm">

			<hr>

			<div class="ModelMgmt Notes">

				<h3>Internal Notes</h3>

				<textarea class="form-control" rows="5" placeholder="Internal Notes"  id="internal_notes" name="internal_notes"><?php if(!empty($invoice_info)){  echo $invoice_info->internal_notes; }?></textarea>

			</div>

		</div>

		<div class="OpenTicket Box Boxtwo NoRadiusForm">

			<div class="BorderRow">
				<div class="row">
					<div class="col-md-3">
						<div class="Modelfee">
							<h6><label> Currency </label></h6>
						</div>
					</div>

					<div class="col-md-3">
						<select style="padding: 4px;" name="sel_currency" id="sel_currency" required onchange="$('.m_currency').html($('#sel_currency option:selected').attr('data-value'));">
							<?php 
							$m_curr = get_currency_list();
							foreach ($m_curr as $data) {
								$selected = '';
								if($invoice_info->currency == $data->code){
									$selected = 'selected';
								}
							
							?>
							<option <?php echo $selected; ?> data-value='<?php echo $data->symbol; ?>' value="<?php echo $data->code; ?>"><?php echo $data->name ."(". $data->symbol .")"; ?></option>
							<?php
							}
							?>
						</select>
					</div>
					<div class="col-md-3"></div>
					<div class="col-md-3"> </div>

				</div>
			</div>

			<hr>


			<div class="BorderRow">

				<div class="row">

					<div class="col-md-3">
						 <div class="Modelfee">
		                    <h6><label><input <?php if($invoice_info->apply_model_fee == 1){ echo 'checked'; } ?> type="radio" checked name="apply_model_fee" id="apply_model_fee_1" value="1" > <input type="text" name="modelnametext1" id="modelnametext1" value="<?php echo $invoice_info->modelnametext1 ?>"> </label></h6>
		                </div>

					</div>

					<div class="col-md-3"></div>

					<div class="col-md-3"></div>

					<div class="col-md-3">

						<div class="Modelfee text-right">
		                    <h6><span class="m_currency"><i class="fa fa-eur" aria-hidden="true"></i></span>  <input type="number" name="model_budget" id="model_budget" min="0" value="<?php if(!empty($invoice_info)){  echo $invoice_info->model_budget; }?>"></h6>
		                </div>

					</div>

				</div>

			</div>

			<div class="Invoicing">

				<div class="InputBox Search brbottom">

					<h3>Invoicing on behalf of the model</h3>

				</div>

			</div>

			<div class="NewInvoice">



				<!-- <div class="BorderRow"> -->




					<div class="row">

						<div class="col-md-3">							 
							 <h6 class="pl-10"><label><input <?php if($invoice_info->apply_model_fee == 2){ echo 'checked'; } ?> type="radio" name="apply_model_fee" id="apply_model_fee_2" value="2"> <input type="text" name="modelnametext2" id="modelnametext2" value="<?php echo $invoice_info->modelnametext2 ?>"> </label></h6>
						</div>

						<div class="col-md-2">							 
							 <input type="text" name="additional_modal_text" id="additional_modal_text" value="<?php echo $invoice_info->additional_modal_text ?>"> 
						</div>
						<div class="col-md-2">							 
							 
						</div>
						<div class="col-md-2">							 
							<input type="text" name="additional_modal_price" id="additional_modal_price" step="any" min="0"  value="<?php echo $invoice_info->additional_modal_price; ?>"> 
						</div>

						<div class="col-md-3">
							<div class="Modelfee text-right">
								<h6 class="pr-10"><span class="m_currency"><i class="fa fa-eur" aria-hidden="true"></i></span>  <input type="number" name="model_total_agreed" id="model_total_agreed" min="1" step="any" value="<?php echo $invoice_info->model_total_agreed ?>" readonly ></h6>
							</div>
						</div>
					</div>

					
					<div id="newModelTotalFee"> 
			        	<?php 
			        	$i=1;
			        	if(!empty($model_data)){
			        		foreach ($model_data as $data) {
			        	?>

			        	<div id="singlemodelpriceSeparater<?php echo $i; ?>"> 
							<div class="row">
								<div class="col-md-3">
									<div class="modeladdmoredata">
									<button type="button" class="btn btn-sm btn-danger" onclick="delModelAddedRow('singlemodelpriceSeparater<?php echo $i; ?>', <?php echo $i; ?>)"><i class="fa fa-trash"></i></button>
									<input type="hidden" name="modelTextdel<?php echo $i; ?>" id="modelTextdel<?php echo $i; ?>" value="0">
									<input type="text" name="modelTextName<?php echo $i; ?>" placeholder="Name" value="<?php echo $data->name; ?>">									 
									<input type="hidden" name="modelTextid<?php echo $i; ?>" placeholder="Name" value="<?php echo $data->id; ?>">
									</div>
								</div>

								<div class="col-md-2">
									<div class="modeladdmoredata">
									<input type="text" name="modelText1Name<?php echo $i; ?>" placeholder="Text 1" value="<?php echo $data->title_1; ?>">
									</div>
								</div>
								<div class="col-md-2">
									<div class="modeladdmoredata">
									<input type="text" name="modelText2Name<?php echo $i; ?>" placeholder="Text 2" value="<?php echo $data->title_2; ?>">
									</div>
								</div>

								<div class="col-md-2">
									<div class="modeladdmoredata">
									<input type="number" onkeyup="calculateAddedRow(this)" onchange="calculateAddedRow(this)" placeholder="amount" name="modelPriceValue<?php echo $i; ?>"  id="modelPriceValue<?php echo $i; ?>"  step="any" value="<?php echo $data->amount; ?>">
									</div>
								</div>

							</div>
							<hr>
						</div>

			        	<?php
			        	$i++;
			        		}
			        	}
			        	?> 

			        </div>  
										
					<div><button type="button" class="btn btn-warning btn-sm" onclick="moreModelData();">ADD MORE</button></div> 
					<br>
					<!-- </div> -->

					<?php 
								    if($invoice_info->m_ingermany == 1){
								    ?>

								    <div class="BorderRow" id="modalDispVat">

								        <div class="row">

								            <div class="col-md-3">

								                <div class="Modelfee">

								                    <h6>VAT automatically added <span id='modalsvat'><?php if(!empty($invoice_info)&&($invoice_info->m_vat==1)){  echo $invoice_info->m_vat_percent; }else{echo "0";}?>%</span></h6>                    

								                </div> 

								            </div>

								            <div class="col-md-3"></div>

								            <div class="col-md-3"></div>

								            <div class="col-md-3">

								                <div class="Modelfee Icon text-right">

								                    <h6 class="pr-10"><span class="m_currency"><i class="fa fa-eur" aria-hidden="true"></i></span> <span id='modalsvatamt'><?php if(!empty($invoice_info)&&($invoice_info->m_vat==1)){echo ($invoice_info->m_vat_percent*$invoice_info->model_total_agreed)/100;}?></span></h6>

								                    <input type="hidden" name="model_budget_vat_amt" id="model_budget_vat_amt" value="<?php if(!empty($invoice_info)&&($invoice_info->m_vat==1)){echo ($invoice_info->m_vat_percent*$invoice_info->model_total_agreed)/100;}?>">

								                </div> 

								             </div>

								        </div>

								    </div>

								<?php }else{
									echo "<hr/>";
								}
								?>

					
					<h6 class="pl-10">Expenses Model</h6>



					<div id="modelexpence">
				    	<?php 
				    	$expCount=0;
				    	if(!empty($expenses)){
				    		foreach ($expenses as $expense) {
				    			$expCount++;
				    	
				    	?>
				    	<div class="BorderRow ExpRow_<?=$expCount?>" id="demomdlexpRow<?php echo $expCount;  ?>">
					        <div class="row">
					            <div class="col-md-3">
					                <div class="Modelfee">	
					                <button class="btn btn-danger btn-sm" type="button" onclick="deleteModelExpenses('demomdlexpRow<?php echo $expCount;  ?>', <?php echo $expCount;  ?>)"><i class="fa fa-trash"></i> </button>								                	
					                     <input type="text" placeholder="Expense Name" name="model_expense<?=$expCount?>" value="<?php echo $expense->model_expense?>">
					                     <input type="hidden" name="model_expense_del<?=$expCount?>" id="model_expense_del<?=$expCount?>" value="0">
					                     <input type="hidden" placeholder="Expense ID" id="model_expense_id<?=$expCount?>" name="model_expense_id<?=$expCount?>" value="<?php echo $expense->id?>">
 
					                </div>
					            </div>

					            <div class="col-md-3">
					                <div class="custom-control custom-radio">
									    <input type="radio" class="custom-control-input" id="vati<?=$expCount?>" value="0" name="vat_include<?=$expCount?>" <?php if($expense->vat_include==0){echo "checked";}?>>
									    <label class="custom-control-label" for="vati<?=$expCount?>">VAT included</label>
								    </div>
					            </div>

					            <div class="col-md-3">
					                <div class="custom-control custom-radio">
									    <input type="radio" class="custom-control-input" id="vate<?=$expCount?>" value="1" name="vat_include<?=$expCount?>" <?php if($expense->vat_include==1){echo "checked";}?>>
									    <label class="custom-control-label" for="vate<?=$expCount?>">VAT excluded</label>
									    <input class="chargespercent" type="number" class="" id="expences_vat_percent<?=$expCount?>" value="<?php echo $expense->vat_percent; ?>" name="expences_vat_percent<?=$expCount?>">
								    </div>
					            </div>

					            <div class="col-md-3">
					                <div class="Modelfee Icon text-right">
					                    <h6><span class="m_currency"><i class="fa fa-eur" aria-hidden="true"></i></span> <input type="number" name="model_exp_amount<?=$expCount?>" min="1" step="any" value="<?php echo $expense->model_exp_amount;?>"></h6>
					                </div>
					             </div>
					        </div>
					    </div>
					    <?php
							}
						}

					    ?>
				    </div>



					<div class="row">

						<div class="col-md-12">

							<hr>

						</div>

						<div class="col-md-3">

							<div class="Modelfee">

								<button type="button" class="btn btn-primary btn-sm" onclick="bindmodelExpenses();"> + ADD EXPENSES</button>

							</div>

						</div>

						<div class="col-md-3">

						</div>

						<div class="col-md-3">

						</div>

						<div class="col-md-3">

						</div>

					</div>



					<hr />

				</div>

			</div>

			<div class="OpenTicket Box Boxtwo NoRadiusForm">

				<!-- contenteditable="true" -->

				<div class="Invoicing">

					<div class="InputBox Search brbottom">

						<h3>invoicing on behalf of the Most Wanted Models @ Agency Germany</h3>

					</div>

				</div>

				<?php 

								// $comission = get_agency_comission();

								?>

								<div class="NewInvoice">

								    <div class="BorderRow">

								        <div class="row">

								            <div class="col-md-3">

								                <div class="Modelfee">

								                    <h6>Plus comission <span id="spnmserfee"></span></h6>

								                    <input type="text" name="modelAgencyComission" id="modelAgencyComission" value="<?php if(!empty($invoice_info)) { echo $invoice_info->model_agency_comission; }?>" style="width: 75px;"> <b>%</b>

								                </div>

								            </div>

								            <div class="col-md-3"></div>

								            <div class="col-md-3"></div>

								            <div class="col-md-3">

								                <div class="Modelfee Icon text-right">

								                    <h6><span class="m_currency"><i class="fa fa-eur" aria-hidden="true"></i></span> <span id="spanmodal_service_fee"><?php
								                    $mwm = 0;
								                    if(!empty($invoice_info)){	$mwm = ($invoice_info->model_agency_comission* ( $invoice_info->apply_model_fee == 1 ? $invoice_info->model_budget : $invoice_info->model_total_agreed) )/100; }
								                    	echo $mwm;
								                    ?></span> 
								                    <input type="hidden" name="modal_service_fee" id="modal_service_fee" value="<?php echo $mwm; ?>" ></h6>

								                    <input type="hidden" name="modal_service_comm" id="modal_service_comm" value="<?php if(!empty($invoice_info)) { echo $invoice_info->m_vat_percent; } ?>" >

								                </div> 

								             </div> 

								        </div>

								    </div>

								    <?php 
								    if($invoice_info->m_ingermany == 1){ 
								    ?>
								    <div id="mwmDispvat">
								    	<h6 class="pl-3">Incl comission </h6>

									    <div class="BorderRow">

									        <div class="row">

									            <div class="col-md-3">

									                <div class="Modelfee">

									                    <h6>VAT added <span id="spanvatinccom"></span></h6>

									                     <input type="text" name="modelInclComission" id="modelInclComission" value="<?=$invoice_info->vat_price?>" style="width: 75px;"> <b>%</b>

									                </div>

									            </div>

									            <div class="col-md-3"></div>

									            <div class="col-md-3"></div>

									            <div class="col-md-3">

									                <div class="Modelfee Icon text-right">

									                    <h6><span class="m_currency"><i class="fa fa-eur" aria-hidden="true"></i></span> <span id="spnfinalcompvatamt"><?php
									                    echo ($mwm*$invoice_info->vat_price)/100;
									                    ?></span><!-- <input type="hidden" name="modal_service_fee" id="modal_service_fee" > --></h6>

									                </div>

									             </div> 

									        </div>

									    </div>


									</div>

								<?php } ?>

								</div>	

			</div>

			<div class="OpenTicket Box Boxtwo NoRadiusForm" >

				<!-- contenteditable="true" -->

				<div class="Invoicing">

					<div class="InputBox Search brbottom">

						<h3>invoicing on behalf of the Select Inc.</h3>

					</div>

				</div>

				<div class="NewInvoice">
					<div class="row">
						<div class="col-md-10"><h6 class="pl-3">Special Needs</h6></div>
					</div>

					<hr>

					
					<div id="modelservice">
				    	<?php
				    	$serCount=0;
				    	if(!empty($services)){
				    		foreach ($services as $service) {
				    			$serCount++;
				    		
				    	?>
				    	<div class="BorderRow" id="demomdlSerRow<?php echo $serCount; ?>">

						        <div class="row">

						            <div class="col-md-3">

						                <div class="Modelfee">
						                	
						                	<button class="btn btn-danger btn-sm" type="button" onclick="deleteModelService('demomdlSerRow<?php echo $serCount; ?>', <?php echo $serCount; ?>)"><i class="fa fa-trash"></i> </button>

						                     <input type="text" placeholder="Service Name" name="model_service<?=$serCount?>" value="<?php echo $service->model_service;?>">
						                     <input type="hidden" placeholder="Service ID" name="model_service_id<?=$serCount?>" id="model_service_id<?=$serCount?>" value="<?php echo $service->id;?>">
						                     <input type="hidden" name="model_ser_del<?=$serCount?>" id="model_ser_del<?=$serCount?>">



						                </div>

						            </div>

						            <div class="col-md-3">

						                <div class="custom-control custom-radio">

										    <input type="radio" class="custom-control-input" id="svati<?=$serCount?>" value="0" name="service_vat_include<?=$serCount?>" <?php if($service->vat_include==0){echo "checked";}?>>

										    <label class="custom-control-label" for="svati<?=$serCount?>">VAT included</label>

									    </div>

						            </div>

						            <div class="col-md-3">

						            	<!-- <button type="button" data-service_id="<?php echo $service->id; ?>" data-toggle="modal" data-target="#modalService" class="btn btn-sm btn-danger" style="padding: 0px 5px;" onclick="$('#service_id').val($(this).attr('data-service_id'))"><i class="fa fa-trash"></i></button>  -->

						                <div class="custom-control custom-radio">
										    <input type="radio" class="custom-control-input" id="svate<?=$serCount?>" value="1" name="service_vat_include<?=$serCount?>" <?php if($service->vat_include==1){echo "checked";}?>>
										    <label class="custom-control-label" for="svate<?=$serCount?>">VAT excluded</label>
										    <input class="chargespercent" type="number" class="" id="special_need_vat_percent<?=$serCount?>" value="<?php echo $service->vat_percent; ?>" name="special_need_percent<?=$serCount?>"  step="any">
									    </div>
						            </div>

						            <div class="col-md-3">
						                <div class="Modelfee Icon text-right">
						                    <h6><span class="m_currency"><i class="fa fa-eur" aria-hidden="true"></i></span> <input type="number" name="model_service_amount<?=$serCount?>" min="1" step="any" value="<?php echo $service->model_ser_amount;?>"></h6>
						                </div>
						             </div>
						        </div>

						    </div>

						    <?php

						}
					}
						    ?>

				    </div>

					<div class="row">

						<div class="col-md-3">

							<div class="Modelfee">

								<button type="button" class="btn btn-primary btn-sm" onclick="bindmodelServices();"> + ADD SERVICES</button>

							</div>

						</div>

						<div class="col-md-3">

						</div>

						<div class="col-md-3">

						</div>

						<div class="col-md-3">

						</div>

					</div>

					<hr />


				</div>	

			</div>						 

			<div class="OpenTicket Box Boxtwo NoRadius"> 
				<div class="Divpdf">  
					<div class="BtnBox" >
						<!-- contenteditable="false" -->
						<button type="save" class="btn cancel">Save & Preview</button>
						<!-- <button type="save" class="btn cancel">Preview</button> -->
						<!-- </a> --> 
					</div> 
				</div> 
			</div>
			 

			<input type="hidden" name="manageexpstart" id="manageexpstart" value="<?=($expCount+1)?>">
			<input type="hidden" name="manageexp" id="manageexp" value="<?=($expCount+1)?>"> 			 
			<input type="hidden" name="manageserstart" id="manageserstart" value="<?=($serCount+1)?>"> 
			<input type="hidden" name="manageser" id="manageser" value="<?=($serCount+1)?>"> 
			<input type="hidden" name="txtmodalIncreaseValueStart" id="txtmodalIncreaseValueStart" value="<?php echo count($model_data) ?>">					
			<input type="hidden" name="txtmodalIncreaseValue" id="txtmodalIncreaseValue" value="<?php echo count($model_data) ?>">

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
					<input class="chargespercent" type="number" class="" id="expences_vat_percent@percent@" value="0" name="expences_vat_percent@percent@">
				</div>
			</div>

			<div class="col-md-3">

				<div class="Modelfee Icon text-right">

					<h6><span class="m_currency"><i class="fa fa-eur" aria-hidden="true"></i></span> <input type="number" name="model_exp_amount@amt@" min="0" step="any" value="0"></h6>

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
					<h6><span class="m_currency"><i class="fa fa-eur" aria-hidden="true"></i></span> <input type="number" name="model_service_amount@seamt@" min="0" step="any" value="0"></h6>
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
													<input type="text" class="form-control" placeholder="Company Name" id="c_shipping_companyname" name="shipping_companyname"   />
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
	</div>

</div>
</div>


<script type="text/javascript">

	$(function(){
		$('.m_currency').html($('#sel_currency option:selected').attr('data-value'));
	})

	function manage_modal_val(){

		var sel_client = $('#save_clients option:selected').attr('value_code');
		if(sel_client == ''){
			$('#displaymsg').html('No Client selected');
			$('#displaymsg').show().delay(5000).fadeOut();
			$('#displaymsg').addClass(' alert alert-danger');
			return false;
		}

		var sel_model = $('#save_model option:selected').attr('value_code');

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

		var client_id = $('#save_clients option:selected').attr('value_code');

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

		var model_id = $('#save_model option:selected').attr('value_code');

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

			// var checkLen=$('.checked-issue:checked').length;
			// if(checkLen==0){
			// 	$('#displaymsg').html('No issue selected.');
			// 	$('#displaymsg').show().delay(5000).fadeOut();
			// 	$('#displaymsg').addClass(' alert alert-danger');	
			// 	return false;			
			// }

            // $('#myloader').show();

            $.ajax({

            	url: '<?php echo base_url('save-edit-invoice'); ?>',
            	type: "POST",
            	data: new FormData(this),
            	contentType: false,
            	cache: false,
            	processData: false,
            	async: true,
            	success: function (data) { 

            		$('#displaymsg').removeClass(' alert alert-info');
            		if(data == "success"){
            			$('#displaymsg').html('Invoice saved successfully');
            			$('#displaymsg').show().delay(5000).fadeOut();
            			$('#displaymsg').addClass(' alert alert-success');
            			window.location.href = "<?php echo base_url('generate-invoice/'); ?>" + $('#invoice_number').val();
            			// location.reload();
            			return true;
            		} 

            		if(data == "error"){
            			$('#displaymsg').html('Error to save invoice, retry');
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
	var clientcode = $('#save_clients option:selected').attr('value_code');
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
	var modelcode = $('#save_model option:selected').attr('value_code');
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
            			$('#displaymsg').html('Model saved Success');
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



function addDays() {
	var days = $('#payment_terms option:selected').val();
	var date = $('#invoice_date').val();
	if(date != '' && days != ''){
		// var d = new Date(date);
		// d.setDate(d.getDate() + days);
		// var mydate = convertDate(d);
		// $('#invoive_due_date').val(mydate);

		$.ajax({

        	url: '<?php echo base_url('get-modified-date'); ?>',
        	type: "POST",
        	data: {
        		days : days,
        		date : date,
        	},
        	success: function (data) { 
        		$('#invoive_due_date').val(data);
        	}
        });
	}
}
 

// function convertDate(date) {
//   var yyyy = date.getFullYear().toString();
//   var mm = (date.getMonth()+1).toString();
//   var dd  = date.getDate().toString();
//   var mmChars = mm.split('');
//   var ddChars = dd.split('');
//   return yyyy + '-' + (mmChars[1]?mm:"0"+mmChars[0]) + '-' + (ddChars[1]?dd:"0"+ddChars[0]);
// }
</script>



 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

 <script>
  $( function() {
    // $( 'input[type="date"]' ).datepicker();
    $( '.dateSelector' ).datepicker();
  } );



;(function($, window, document, undefined){
    $("#invoice_date, #payment_terms").on("change", function(){
       var date = new Date($("#invoice_date").val()),
           days = parseInt($("#payment_terms").val(), 10);
        
        if(!isNaN(date.getTime())){
            date.setDate(date.getDate() + days);
            
            $("#invoive_due_date").val(date.toInputFormat());
        } else {
            alert("Invalid Date");  
        }
    });
    
    
    //From: http://stackoverflow.com/questions/3066586/get-string-in-yyyymmdd-format-from-js-date-object
    Date.prototype.toInputFormat = function() {
       var yyyy = this.getFullYear().toString();
       var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
       var dd  = this.getDate().toString();
       return yyyy + "-" + (mm[1]?mm:"0"+mm[0]) + "-" + (dd[1]?dd:"0"+dd[0]); // padding
    };
})(jQuery, this, document);

  </script>