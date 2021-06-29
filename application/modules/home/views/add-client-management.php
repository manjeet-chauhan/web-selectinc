



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

							<h4>Add Client Management</h4>

						</div>

						<div class="ClientManagement">

							<a href="<?php echo base_url('client-management');?>"><button type="button" class="btn bg-white btn-outline-primary"><img src="<?php echo base_url('assets/frontend/'); ?>images/teamwork.svg" alt="Icon"> Back</button></a>



							<a href="<?php echo base_url('add-client-management'); ?>"><button type="button" class="btn bg-white btn-outline-primary"><img src="<?php echo base_url('assets/frontend/images/contact.svg'); ?>" alt="Icon"> Add Client</button></a>

							<button type="button" class="btn bg-white btn-outline-primary"><img src="<?php echo base_url('assets/frontend/'); ?>images/import.svg" alt="Icon"> Import Client</button>

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
															<input type="text" class="form-control" placeholder="Company Name" id="companyname" name="companyname"  />
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

														<div class="input-group">
															<input type="text" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon2" id="client_fee" name="client_fee" pattern="[0-9]+" min="0" max="100" title="Only Number" value="20">
															<div class="input-group-append AppendBox">										<span class="input-group-text" id="basic-addon2">%</span>
															</div>
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

															<input type="text" class="form-control" placeholder="Name" id="name" name="name" />

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

															<input type="text" class="form-control" placeholder="Surname" id="surname" name="surname">

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

															<input type="text" class="form-control" placeholder="Address Line 1" id="addressline1" name="addressline1"  />

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
															<input type="text" class="form-control" placeholder="Address Line 2" id="addressline2" name="addressline2">
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

															<input type="text" class="form-control" placeholder="Post Code" id="postcode" name="postcode" />

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
															<input type="text" class="form-control" placeholder="City" id="city" name="city" >

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

															<input type="text" class="form-control" placeholder="Vat Number/TIN" id="vat_tin_no" name="vat_tin_no" />

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

															<input type="text" class="form-control" placeholder="Telephone" id="telephone" name="telephone">

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

															<input type="text" class="form-control" placeholder="Email"  id="email" name="email" />

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

															<input type="text" class="form-control" placeholder="Country" id="country" name="country">

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

															<input type="text" class="form-control" placeholder="Mobile No." id="phone" name="phone" />

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

														<div class="col-md-7" >

														<div style="margin-top: -10px;">
															<label style="color: #001737; font-size: 12px;"><input type="radio" name="ingermany" id="ingermany" value="0" checked=""> <b class="checkCountry"> &nbsp;OUT OF GERMANY</b> </label>

															<label style="color: #001737; font-size: 12px;"><input type="radio" name="ingermany" id="ingermany" value="1"> <b class="checkCountry"> &nbsp;IN GERMANY</b> </label>
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

															<input type="text" class="form-control" placeholder="Internal Notes" id="internal_notes" name="internal_notes">

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
																	<input type="radio" class="custom-control-input"  id="kvatyes"  name="kvatornot" value="1"  onclick="manageKVat(1)">
																	<label class="custom-control-label" for="kvatyes">Yes</label>
																</div> 			
															</div>
															<div class="col-md-6">
																<div class="custom-control custom-radio"> 
																<input type="radio" class="custom-control-input" id="kvatno" name="kvatornot" value="0"  onclick="manageKVat(0)">
																<label class="custom-control-label" for="kvatno">No</label>
																</div>
															</div>

															<div class="clearfix"></div>

															<div class="col-md-9">
																<div id="kvatvalue" style="margin-top: 5px;">
																	<div class="input-group mb-3">
																		<input type="text" class="form-control" placeholder="16" id="kvat_percent" name="kvat_percent" pattern="[0-9]+" min="0" max="100" title="Only Number">

																		<div class="input-group-append">
																			<span class="input-group-text">%</span>
																		</div>
																	</div>
																</div> 
																<style type="text/css">
																	#kvatvalue { display:none }
																</style>
															</div>
														</div>
														 
													</div>
													</div>
												</div>





											<!-- <div class="col-md-12">

													<div class="form-group">

														<label for="usr">Kleinunternehmer with VAT or not</label>

													</div>

													<div class="row">

														<div class="col-md-6">

															<div class="custom-control custom-radio">

																<input type="radio" class="custom-control-input"  id="kvatyes"  name="kvatornot" value="1"  onclick="manageKVat(1)">

																<label class="custom-control-label" for="kvatyes">Yes</label>

															</div>

														</div>

														<div class="col-md-6">

															<div class="custom-control custom-radio">

																<input type="radio" class="custom-control-input" id="kvatno" name="kvatornot" value="0"  onclick="manageKVat(0)">

																<label class="custom-control-label" for="kvatno">No</label>

															</div>

														</div>

													</div>

												</div>

												<div class="col-md-6 mt-3">

													<div id="kvatvalue">

														<div class="input-group mb-3">
															<input type="text" class="form-control" placeholder="16" id="kvat_percent" name="kvat_percent" pattern="[0-9]+" min="0" max="100" title="Only Number">

															<div class="input-group-append">

																<span class="input-group-text">%</span>

															</div>

														</div>

													</div>

													<style type="text/css">

														#kvatvalue { display:none }

													</style>

												</div> -->

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

													<div class="col-md-12">
														<div class="divAboveAddress">
														  <label style="color: #ad085c"><input style="height: auto;" type="checkbox" name="aboveAddress" id="aboveAddress"> &nbsp; Same as above address</label>
														</div>
														<hr>
													</div>

													<div class="col-md-6">

														<div class="row">

															<div class="col-md-5">

																<div class="form-group">

																	<label for="usr">Company Name</label>

																</div>

															</div>

															<div class="col-md-7">

																<div class="form-group">

																	<input type="text" class="form-control" placeholder="Company Name" id="shipping_companyname" name="shipping_companyname"/>

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

																			<input type="text" class="form-control" placeholder="Name" id="shipping_name" name="shipping_name"/>

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

																			<input type="text" class="form-control" placeholder="Surname" id="shipping_surname" name="shipping_surname">

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

																			<input type="text" class="form-control" placeholder="Address Line 1" id="shipping_addressline1" name="shipping_addressline1" />

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

																			<input type="text" class="form-control" placeholder="Address Line 2" id="shipping_addressline2" name="shipping_addressline2">

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

																			<input type="text" class="form-control" placeholder="City" id="shipping_city" name="shipping_city">

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

																			<input type="text" class="form-control" placeholder="Post Code" id="shipping_postcode" name="shipping_postcode" />

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

	$(function(){
		$('input[type="checkbox"]#aboveAddress').change(function(){

			$('#shipping_companyname, #shipping_name, #shipping_surname, #shipping_addressline1, #shipping_addressline2, #shipping_city, #shipping_postcode').val('');
			if($(this).prop('checked') == true){

				$('#shipping_companyname').val($('#companyname').val());
				$('#shipping_name').val($('#name').val());
				$('#shipping_surname').val($('#surname').val());
				$('#shipping_addressline1').val($('#addressline1').val());
				$('#shipping_addressline2').val($('#addressline2').val());
				$('#shipping_city').val($('#city').val());
				$('#shipping_postcode').val($('#postcode').val());
				
			}   
		})
	})

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

            	url: '<?php echo base_url('save-client-management'); ?>',

            	type: "POST",

            	data: new FormData(this),

            	contentType: false,

            	cache: false,

            	processData: false,

            	async: true,

            	success: function (data) { 



            		$('#displaymsg').removeClass(' alert alert-info');

            		if(data == "success"){

            			$('#displaymsg').html('Client created Success');

            			$('#displaymsg').show().delay(5000).fadeOut();

            			$('#displaymsg').addClass(' alert alert-success');

            			window.location.href = "<?php echo base_url('client-management'); ?>";

            			return true;

            		}



            		if(data == "error"){

            			$('#displaymsg').html('Error to create client profile, retry');

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

 

</script>