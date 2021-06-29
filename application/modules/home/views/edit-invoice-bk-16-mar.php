<?php 
 
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



if(!empty($user_profie)){

	$service_url = "https://tickets.mostwantedmodels.com/projects/jobs/issues.json?offset=".$offset."&limit=".$records_on_page;

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



	// print_r($response);



	if(!empty($response['issues'])){

		$issues = $response['issues'];

		$records = $response['total_count'];

	}

 

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

.Modelfee.Icon.text-right::before {

    content: " ";

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

							<h4> Edit Invoice <?php if(!empty($invoice_number)) echo ' [' . $invoice_number . ']' ?></h4>

						</div>

					</div>
 

					<div class="OpenTicket Box Boxtwo NoRadius ModelMgmt" >

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

															<h4>#<?php if(!empty($invoice_info->issue_id)){ echo $invoice_info->issue_id; }?></h4>

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

																<input type="text" class="form-control" readonly placeholder="Invoice Number" id="invoice_number" name="invoice_number"  value="<?php if(!empty($invoice_number)){echo $invoice_number;}?>"> 
															</div>
														</div>
													</div>
												</div>
											</div>  

											<input type="hidden" name="client_ids" id="client_ids" value="<?php if(!empty($invoice_info)){echo $invoice_info->client_id;}?>">

											<input type="hidden" name="model_ids" id="model_ids" value="<?php if(!empty($invoice_info)){echo $invoice_info->model_id;}?>"> 

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
																		if($client->id == $invoice_info->client_id){
																			$selected = 'selected';
																		}
																?>
																<option <?php echo $selected ?>
																value="<?php echo $client->unique_code; ?>"
																data-fee="<?php echo $client->client_fee; ?>"
																data-kvat="<?php echo $client->kvat; ?>"
																data-kvat_percent="<?php echo $client->kvat_percent; ?>"
																><?php echo ucwords(strtolower($client->company_name)); ?></option>
																<?php
																	}
																}
																?> 
															</select>
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
																		if($model->id == $invoice_info->model_id){
																			$selected = 'selected';
																		}
																?>
																<option <?php echo $selected; ?>
																value="<?php echo $model->unique_code; ?>"
																data-fee="<?php echo $model->service_fee; ?>"
																data-kvat="<?php echo $model->kvat; ?>"
																data-kvat_percent="<?php echo $model->kvat_percent; ?>"
																><?php echo ucwords(strtolower($model->model_name)); ?></option>
																<?php
																	}
																}
																?> 

															</select>

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

																		<input type="text" class="form-control" placeholder="Company Name" id="i_company_name" name="i_company_name" value="<?php if(!empty($invoice_info)){ echo $invoice_info->i_company_name; }?>">

																		<input type="hidden" id="issue_id" name="issue_id" value="<?php if(!empty($invoice_info->issue_id)){ echo $invoice_info->issue_id; }?>">

																	</div>

																</div>

																<div class="col-md-5">

																	<div class="form-group">

																		<label for="usr">Name</label>

																	</div>

																</div>

																<div class="col-md-7">

																	<div class="form-group">

																		<input type="text" class="form-control" placeholder="Name" id="i_name" name="i_name" value="<?php if(!empty($invoice_info)){ echo $invoice_info->i_name; }?>" >

																	</div>

																</div>

																<div class="col-md-5">

																	<div class="form-group">

																		<label for="usr">Address Line 1</label>

																	</div>

																</div>

																<div class="col-md-7">

																	<div class="form-group">

																		<input type="text" class="form-control" placeholder="Address Line 1"  id="i_address_line1" name="i_address_line1" value="<?php if(!empty($invoice_info)){ echo $invoice_info->i_address_line1; }?>">

																	</div>

																</div>

																<div class="col-md-5">

																	<div class="form-group">

																		<label for="usr">Post Code</label>

																	</div>

																</div>

																<div class="col-md-7">

																	<div class="form-group">

																		<input type="text" class="form-control" placeholder="Post Code"  id="i_pincode" name="i_pincode" value="<?php if(!empty($invoice_info)){ echo $invoice_info->i_pincode; }?>">

																	</div>

																</div>

																<div class="col-md-5">

																	<div class="form-group">

																		<label for="usr">Vat Number/TIN</label>

																	</div>

																</div>

																<div class="col-md-7">

																	<div class="form-group">

																		<input type="text" class="form-control" placeholder="Vat Number/TIN"  id="i_vat_tin_number" name="i_vat_tin_number" value="<?php if(!empty($invoice_info)){ echo $invoice_info->i_vat_tin_number; }?>">

																	</div>

																</div>

																<div class="col-md-5">

																	<div class="form-group">

																		<label for="usr">Email</label>

																	</div>

																</div>

																<div class="col-md-7">

																	<div class="form-group">

																		<input type="text" class="form-control" placeholder="Email"  id="i_email" name="i_email" value="<?php if(!empty($invoice_info)){ echo $invoice_info->i_email; }?>">

																	</div>

																</div>

																<div class="col-md-5">

																	<div class="form-group">

																		<label for="usr">Mobile No.</label>

																	</div>

																</div>

																<div class="col-md-7">

																	<div class="form-group">

																		<input type="text" class="form-control" placeholder="Mobile No."  id="i_mobile_no" name="i_mobile_no" value="<?php if(!empty($invoice_info)){ echo $invoice_info->i_mobile_no; }?>">

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

																		<input type="text" class="form-control" placeholde="Surname"  id="i_fee" name="i_fee" value="<?php if(!empty($invoice_info)){ echo $invoice_info->i_fee; }?>">

																	</div>

																</div>

																<div class="col-md-5">

																	<div class="form-group">

																		<label for="usr">Surname</label>

																	</div>

																</div>

																<div class="col-md-7">

																	<div class="form-group">

																		<input type="text" class="form-control" placeholder="Surname"  id="i_surname" name="i_surname" value="<?php if(!empty($invoice_info)){ echo $invoice_info->i_surname; }?>">

																	</div>

																</div>

																<div class="col-md-5">

																	<div class="form-group">

																		<label for="usr">Address Line 2</label>

																	</div>

																</div>

																<div class="col-md-7">

																	<div class="form-group">

																		<input type="text" class="form-control" placeholder="Address Line 2"  id="i_address_line2" name="i_address_line2" value="<?php if(!empty($invoice_info)){ echo $invoice_info->i_address_line2; }?>">

																	</div>

																</div>

																<div class="col-md-5">

																	<div class="form-group">

																		<label for="usr">City</label>

																	</div>

																</div>

																<div class="col-md-7">

																	<div class="form-group">

																		<input type="text" class="form-control" placeholder="City" id="i_city" name="i_city" value="<?php if(!empty($invoice_info)){ echo $invoice_info->i_city; }?>">

																	</div>

																</div>

																<div class="col-md-5">

																	<div class="form-group">

																		<label for="usr">Country</label>

																	</div>

																</div>

																<div class="col-md-7">

																	<div class="form-group">

																		<input type="text" class="form-control" placeholder="Country"  id="i_country" name="i_country" value="<?php if(!empty($invoice_info)){ echo $invoice_info->i_country; }?>">

																	</div>

																</div>

																<div class="col-md-5">

																	<div class="form-group">

																		<label for="usr">Telephone</label>

																	</div>

																</div>

																<div class="col-md-7">

																	<div class="form-group">

																		<input type="text" class="form-control" placeholder="Telephone"  id="i_telephone" name="i_telephone" value="<?php if(!empty($invoice_info)){ echo $invoice_info->i_telephone; }?>">

																	</div>

																</div>

																

															</div>

														</div>

												</div>

											</div>

											<div class="col-md-12">

	                                            <div class="ModelMgmt Notes">

									                <h3>Internal Notes</h3>

									                <textarea class="form-control"  rows="5" placeholder="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmodtempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esseillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum." id="i_internal_notes" name="i_internal_notes"><?php if(!empty($invoice_info)){ echo $invoice_info->i_internal_notes; }?></textarea>

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

																	<input type="text" class="form-control" placeholder="Company Name" id="shipping_company_name" name="shipping_company_name" value="<?php if(!empty($invoice_info)){ echo $invoice_info->shipping_company_name; }?>">

																</div>

															</div>

															<div class="col-md-5">

																<div class="form-group">

																	<label for="usr">Name</label>

																</div>

															</div>

															<div class="col-md-7">

																<div class="form-group">

																	<input type="text" class="form-control" placeholder="Name" id="shipping_name" name="shipping_name" value="<?php if(!empty($invoice_info)){ echo $invoice_info->shipping_name; }?>">

																</div>

															</div>

															<div class="col-md-5">

																<div class="form-group">

																	<label for="usr">Address Line 1</label>

																</div>

															</div>

															<div class="col-md-7">

																<div class="form-group">

																	<input type="text" class="form-control" placeholder="Address Line 1" id="shipping_address_line1" name="shipping_address_line1" value="<?php if(!empty($invoice_info)){ echo $invoice_info->shipping_address_line1; }?>">

																</div>

															</div>

															<div class="col-md-5">

																<div class="form-group">

																	<label for="usr">Post Code</label>

																</div>

															</div>

															<div class="col-md-7">

																<div class="form-group">

																	<input type="text" class="form-control" placeholder="Post Code"  id="shipping_pincode" name="shipping_pincode" value="<?php if(!empty($invoice_info)){ echo $invoice_info->shipping_pincode; }?>">

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

																	<input type="text" class="form-control" placeholder="Surname"  id="shipping_surname" name="shipping_surname" value="<?php if(!empty($invoice_info)){ echo $invoice_info->shipping_surname; }?>">

																</div>

															</div>

															<div class="col-md-5">

																<div class="form-group">

																	<label for="usr">Address Line 2</label>

																</div>

															</div>

															<div class="col-md-7">

																<div class="form-group">

																	<input type="text" class="form-control" placeholder="Address Line 2"  id="shipping_address_line2" name="shipping_address_line2" value="<?php if(!empty($invoice_info)){ echo $invoice_info->shipping_address_line2; }?>">

																</div>

															</div>

															<div class="col-md-5">

																<div class="form-group">

																	<label for="usr">City</label>

																</div>

															</div>

															<div class="col-md-7">

																<div class="form-group">

																	<input type="text" class="form-control" placeholder="Address Line 2"  id="shipping_city" name="shipping_city" value="<?php if(!empty($invoice_info)){ echo $invoice_info->shipping_city; }?>">

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

														<select class="custom-select" id="payment_terms" name="payment_terms">

															<option value='1' <?php if(!empty($invoice_info)&&($invoice_info->payment_terms==1)){ echo 'selected'; }?>>Pay within 14 days</option>

															<option value='2'  <?php if(!empty($invoice_info)&&($invoice_info->payment_terms==2)){ echo 'selected'; }?>>Pay within 30 days</option>

															<option value='3'  <?php if(!empty($invoice_info)&&($invoice_info->payment_terms==3)){ echo 'selected'; }?>>Pay within 60 days</option>

															<option value='4'  <?php if(!empty($invoice_info)&&($invoice_info->payment_terms==4)){ echo 'selected'; }?>>Pay within 90 days</option>

															<option value='5'  <?php if(!empty($invoice_info)&&($invoice_info->payment_terms==5)){ echo 'selected'; }?>>Pay within 120 days</option>

														</select> 

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

															<label for="usr">Job Date</label>

														</div>

													</div>

													<div class="col-md-7">

														<div class="form-group">

															<input type="date" class="form-control" placeholder="Enter Company Name" id="job_date" name="job_date" value="<?php if(!empty($invoice_info)){  echo $invoice_info->job_date; }?>">

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

															<input type="date" class="form-control" id="invoice_date" name="invoice_date" value="<?php if(!empty($invoice_info)){  echo $invoice_info->invoice_date; }?>">

														</div>

													</div>

													<div class="col-md-5">

														<div class="form-group">

															<label for="usr">Usage</label>

														</div>

													</div>

													<div class="col-md-7">

														<div class="form-group">

															<textarea type="text" class="form-control" placeholder="1234567" rows="4" id="uses" name="uses"><?php if(!empty($invoice_info)){  echo $invoice_info->uses; }?></textarea>

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

															<input type="date" class="form-control" id="invoive_due_date" name="invoive_due_date" value="<?php if(!empty($invoice_info)){  echo $invoice_info->invoive_due_date; }?>">

														</div>

													</div>

													<div class="col-md-5">

														<div class="form-group">

															<label for="usr">Reminder</label>

														</div>

													</div>

													<div class="col-md-7">													

														<div class="form-group">

															<input type="text" class="form-control" id="reminder" name="reminder" value="<?php if(!empty($invoice_info)){  echo $invoice_info->reminder; }?>">

														</div>

													</div>

													<div class="col-md-5">

														<div class="form-group">

															<label for="usr">Interval in days</label>

														</div>

													</div>

													<div class="col-md-7">

														<select class="custom-select" id="interval_in_days" name="interval_in_days">

															<option value='1' <?php if(!empty($invoice_info)&&($invoice_info->interval_in_days==1)){ echo 'selected'; }?>>15 days</option>

															<option value='2' <?php if(!empty($invoice_info)&&($invoice_info->interval_in_days==2)){ echo 'selected'; }?>>30 days</option>

															<option value='3' <?php if(!empty($invoice_info)&&($invoice_info->interval_in_days==3)){ echo 'selected'; }?>>60 days</option>

															<option value='4' <?php if(!empty($invoice_info)&&($invoice_info->interval_in_days==4)){ echo 'selected'; }?>>90 days</option>

															<option value='5' <?php if(!empty($invoice_info)&&($invoice_info->interval_in_days==5)){ echo 'selected'; }?>>120 days</option>

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

																		<input type="text" class="form-control" placeholder="Model Name" id="m_model_name" name="m_model_name" value="<?php if(!empty($invoice_info)){  echo $invoice_info->m_model_name; }?>">

																	</div>

																</div>

																<div class="col-md-5">

																	<div class="form-group">

																		<label for="usr">Surname</label>

																	</div>

																</div>

																<div class="col-md-7">

																	<div class="form-group">

																		<input type="text" class="form-control" placeholder="Surname" id="m_surname" name="m_surname" value="<?php if(!empty($invoice_info)){  echo $invoice_info->m_surname; }?>">

																	</div>

																</div>

																<div class="col-md-5">

																	<div class="form-group">

																		<label for="usr">Address Line 1</label>

																	</div>

																</div>

																<div class="col-md-7">

																	<div class="form-group">

																		<input type="text" class="form-control" placeholder="Address Line 1" id="m_address_line1" name="m_address_line1" value="<?php if(!empty($invoice_info)){  echo $invoice_info->m_address_line1; }?>">

																	</div>

																</div>

																<div class="col-md-5">

																	<div class="form-group">

																		<label for="usr">Post Code</label>

																	</div>

																</div>

																<div class="col-md-7">

																	<div class="form-group">

																		<input type="text" class="form-control" placeholder="Post Code" id="m_pincode" name="m_pincode" value="<?php if(!empty($invoice_info)){  echo $invoice_info->m_pincode; }?>">

																	</div>

																</div>

																<div class="col-md-5">

																	<div class="form-group">

																		<label for="usr">Vat Number/TIN</label>

																	</div>

																</div>

																<div class="col-md-7">

																	<div class="form-group">

																		<input type="text" class="form-control" placeholder="Vat Number/TIN" id="m_vat_tin_number" name="m_vat_tin_number" value="<?php if(!empty($invoice_info)){  echo $invoice_info->m_vat_tin_number; }?>">

																	</div>

																</div>

																<div class="col-md-5">

																	<div class="form-group">

																		<label for="usr">Email</label>

																	</div>

																</div>

																<div class="col-md-7">

																	<div class="form-group">

																		<input type="text" class="form-control" placeholder="Email" id="m_email" name="m_email" value="<?php if(!empty($invoice_info)){  echo $invoice_info->m_email; }?>">

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

																		<input type="text" class="form-control" placeholder="Name" id="m_name" name="m_name" value="<?php if(!empty($invoice_info)){  echo $invoice_info->m_name; }?>">

																	</div>

																</div>

																<div class="col-md-5">

																	<div class="form-group">

																		<label for="usr">Address Line 2</label>

																	</div>

																</div>

																<div class="col-md-7">

																	<div class="form-group">

						