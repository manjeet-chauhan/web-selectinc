

<?php 

// print_r($client); 

?>

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

						<div class="BoxHeading">

							<h4>Edit Client Management</h4>

						</div>

						<div class="ClientManagement">

							<a href="<?php echo base_url('client-management');?>"><button type="button" class="btn bg-white btn-outline-primary"><img src="<?php echo base_url('assets/frontend/'); ?>images/teamwork.svg" alt="Icon"> Back</button></a>



							<a href="<?php echo base_url('edit-client-management/').$uniquecode;?>"> <button type="button" class="btn bg-white btn-outline-primary"><img src="<?php echo base_url('assets/frontend/'); ?>images/contact.svg" alt="Icon"> Edit Client</button></a>



							<a href="<?php echo base_url('add-client-management'); ?>"><button type="button" class="btn bg-white btn-outline-primary"><img src="<?php echo base_url('assets/frontend/images/contact.svg'); ?>" alt="Icon"> Add Client</button></a>

						</div>

						<form id="clientManagement">

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

															<input type="hidden" class="form-control" placeholder="Company Name" id="uniquecode" name="uniquecode" value="<?php echo $client->unique_code ?>" />

															<input type="text" class="form-control" placeholder="Company Name" id="companyname" name="companyname" value="<?php echo $client->company_name ?>" />

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

															<input type="text" class="form-control" placeholder="Client Fee 0.3%" id="client_fee" name="client_fee" value="<?php echo $client->client_fee ?>">

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

															<input type="text" class="form-control" placeholder="Name" id="name" name="name" value="<?php echo $client->name ?>" />

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

															<input type="text" class="form-control" placeholder="Surname" id="surname" name="surname" value="<?php echo $client->surname ?>">

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

															<input type="text" class="form-control" placeholder="Address Line 1" id="addressline1" name="addressline1" value="<?php echo $client->address_line1 ?>" />

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

															<input type="text" class="form-control" placeholder="Address Line 2" id="addressline2" name="addressline2" value="<?php echo $client->address_line2 ?>">

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

															<input type="text" class="form-control" placeholder="Post Code" id="postcode" name="postcode" value="<?php echo $client->pincode ?>" />

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

															<input type="text" class="form-control" placeholder="City" id="city" name="city" value="<?php echo $client->city ?>">

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

															<input type="text" class="form-control" placeholder="Vat Number/TIN" id="vat_tin_no" name="vat_tin_no" value="<?php echo $client->vat_tin_number ?>" />

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

															<input type="text" class="form-control" placeholder="Country" id="country" name="country" value="<?php echo $client->country ?>">

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

															<input type="text" class="form-control" placeholder="Email"  id="email" name="email" value="<?php echo $client->email ?>" />

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

															<input type="text" class="form-control" placeholder="Telephone" id="telephone" name="telephone" value="<?php echo $client->telephone ?>">

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

															<input type="text" class="form-control" placeholder="Mobile No." id="phone" name="phone"  value="<?php echo $client->mobile_no ?>" />

														</div>

													</div>

												</div>

											</div>

											<div class="col-md-6">

													<div class="row">

														<div class="col-md-5">

															<div class="form-group">

																<label for="usr">Selected Country</label>

															</div>

														</div>

														<div class="col-md-7">

														<div style="margin-top: -10px;">
															<label style="color: #001737; font-size: 12px;"><input type="radio" name="ingermany" id="ingermany" value="0" <?php if($client->ingermany!=1){ echo "checked";}?>> <b class="checkCountry"> &nbsp;OUT OF GERMANY</b> </label>

															<label style="color: #001737; font-size: 12px;"><input type="radio" name="ingermany" id="ingermany" value="1" <?php if($client->ingermany==1){ echo "checked";}?>> <b class="checkCountry"> &nbsp;IN GERMANY</b> </label>

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

															<input type="text" class="form-control" placeholder="Internal Notes" id="internal_notes" name="internal_notes" value="<?php echo $client->internal_notes ?>">

														</div>

													</div>

												</div>

											</div>	



												<div class="col-md-6"  style="display: none;">
													<div class="row">
														<div class="col-md-5">
															<div class="form-group">
																<label for="usr">Kleinunternehmer with VAT or not</label>
															</div>
														</div>

														<div class="col-md-7">
															<div class="row">
																<div class="col-md-6">
																	<?php 
																		$display = 'none';
																		$checked = '';
																		if($client->kvat == 1){
																			$checked = 'checked';
																			$display = 'block';
																		}
																	?>

																	<div class="custom-control custom-radio">
																		<input <?php echo $checked; ?> type="radio" class="custom-control-input"  id="kvatyes" name="kvatornot" value="1" onclick="manageKVat(1)">
																		<label class="custom-control-label" for="kvatyes" >Yes</label>
																	</div>

																</div>
																<div class="col-md-6">

																	<?php 
																		$checked = '';
																		if($client->kvat == 0){
																			$checked = 'checked';
																		}
																	?>

																	<div class="custom-control custom-radio">
																		<input <?php echo $checked; ?> type="radio" class="custom-control-input" id="kvatno" name="kvatornot" value="0" onclick="manageKVat(0)">

																		<label class="custom-control-label" for="kvatno">No</label>

																	</div>
																</div>

																<div class="col-md-9 mt-3">
																	<div id="kvatvalue" style="display: <?php echo $display; ?>">
																		<div class="input-group mb-3">
																			<input type="text" class="form-control" placeholder="16" id="kvat_percent" name="kvat_percent" pattern="[0-9]+" title="Only  Number" value="<?php echo $client->kvat_percent ?>">
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

															<input type="text" class="form-control" placeholder="Company Name" id="shipping_companyname" name="shipping_companyname" value="<?php echo $client->shipping_company_name ?>" />

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

															<input type="text" class="form-control" placeholder="Name" id="shipping_name" name="shipping_name" value="<?php echo $client->shipping_name ?>"/>

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

															<input type="text" class="form-control" placeholder="Surname" id="shipping_surname" name="shipping_surname" value="<?php echo $client->shipping_surname ?>">

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

															<input type="text" class="form-control" placeholder="Address Line 1" id="shipping_addressline1" name="shipping_addressline1" value="<?php echo $client->shipping_address_line1 ?>" />

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

															<input type="text" class="form-control" placeholder="Address Line 2" id="shipping_addressline2" name="shipping_addressline2" value="<?php echo $client->shipping_address_line2 ?>">

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

															<input type="text" class="form-control" placeholder="City" id="shipping_city" name="shipping_city" value="<?php echo $client->shipping_city ?>">

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

															<input type="text" class="form-control" placeholder="Post Code" id="shipping_postcode" name="shipping_postcode"  value="<?php echo $client->shipping_pincode ?>" />

														</div>

													</div>

												</div>

											</div>

										</div>

									</div>

								</div>			

							</div>

							<div class="BtnBox">

								<button type="submit" class="btn Save">Save</button>

								<a href="<?php echo base_url('client-management'); ?>"> <button type="button" class="btn cancel">Cancel</button> </a>

							</div>

						</form>

					</div>

				</div>

			</div>

		</div>

	</div>

</section>

<!-- End Dashboard -->

<script type="text/javascript">



	function manageKVat(showdata){

		$('#kvatvalue').css('display', 'none');

		if(showdata == 1){

			$('#kvatvalue').css('display', 'block');

		}



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

            			$('#displaymsg').html('Client data saved Successfully');

            			$('#displaymsg').show().delay(5000).fadeOut();

            			$('#displaymsg').addClass(' alert alert-success');

            			// window.location.href = "<?php echo base_url('client-management-detail/').$uniquecode; ?>";
            			// window.location.href = "<?php echo base_url('client-management-detail/').$uniquecode; ?>";
            			location.reload();

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





// $(document).ready(function(){

// 	$('#clientManagement').validate({

// 		rules: {

// 			companyname: {

// 				required:true,

// 			},

// 			name: {

// 				required:true,

// 			},

// 			addressline1: {

// 				required:true,



// 			},

// 			postcode: {

// 				required:true,

// 				number:true,

// 			},

// 			vat_tin_no: {

// 				required:true,

// 			},

// 			email: {

// 				required:true,

// 				email:true,

// 			},

// 			phone: {

// 				required:true,

// 				number:true,

// 			},

// 			client_fee: {

// 				required:true,

// 				number:true,

// 			},

// 			surname: {

// 				required:true,

// 			},

// 			addressline2: {

// 				required:true,

// 			},

// 			city: {

// 				required:true,

// 			},

// 			country: {

// 				required:true,

// 			},

// 			telephone: {

// 				required:true,

// 			},

// 			internal_notes: {

// 				required:true,

// 			},

// 			shipping_companyname: {

// 				required:true,

// 			},

// 			shipping_name: {

// 				required:true,

// 			},

// 			shipping_addressline1: {

// 				required:true,

// 			},

// 			shipping_postcode: {

// 				required:true,

// 				number:true,

// 			},

// 			shipping_surname: {

// 				required:true, 

// 			},

// 			shipping_addressline2: {

// 				required:true, 

// 			},

// 			shipping_city: {

// 				required:true, 

// 			},

// 		},

// 		messages: {



// 			companyname:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Company Name. </span>",

// 			},

// 			name:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Name. </span>",

// 			},

// 			addressline1:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Address Line 1. </span>",

// 			},

// 			postcode:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Postcode. </span>",

// 				number:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Only Numbers. </span>",

// 			},

// 			vat_tin_no:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter VAT/TIN Number. </span>",

// 			},

// 			email:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Email. </span>",

// 				email:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Right Email Format. </span>",

// 			},

// 			phone:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Mobile Number. </span>",

// 				number:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Only Numbers. </span>",

// 			},

// 			client_fee:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Client Fee. </span>",

// 				number:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Only Numbers. </span>",

// 			},

// 			surname:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Surname. </span>",

// 			},

// 			addressline2:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Address Line 2. </span>",

// 			},

// 			city:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter City. </span>",

// 			},

// 			country:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Country. </span>",

// 			},

// 			telephone:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Telephone. </span>",

// 			},

// 			internal_notes:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Internal Notes. </span>",

// 			},

// 			shipping_companyname:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'> Please Enter Shipping Company Name. </span>",

// 			},



// 			shipping_name:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'> Please Enter Shipping Name. </span>",

// 			},



// 			shipping_addressline1:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'> Please Enter Shipping Address Line 1. </span>",

// 			},

// 			shipping_postcode:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Shipping Postcode. </span>",

// 				number:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Only Numbers. </span>",

// 			},

// 			shipping_surname:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Shipping Surname. </span>",

// 			},

// 			shipping_addressline2:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'> Please Enter Shipping Address Line 2. </span>",

// 			},



// 			shipping_city:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Shipping City. </span>",

// 			},



// 		},

// 		submitHandler: function (form) {

// 			form.submit();

// 		}

// 	});

// });

</script>