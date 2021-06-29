



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

							<h4>Add Model Management</h4>

						</div>

						<div class="ClientManagement">

							<a href="<?php echo base_url('model-management');?>"><button type="button" class="btn bg-white btn-outline-primary"><img src="<?php echo base_url('assets/frontend/'); ?>images/teamwork.svg" alt="Icon"> Back</button></a>



							<a href="<?php echo base_url('add-model-management'); ?>"><button type="button" class="btn bg-white btn-outline-primary"><img src="<?php echo base_url('assets/frontend/images/contact.svg'); ?>" alt="Icon"> Add Model</button></a>

							<button type="button" class="btn bg-white btn-outline-primary"><img src="<?php echo base_url('assets/frontend/'); ?>images/import.svg" alt="Icon"> Import Client</button>

						</div>

						<form id="modelManagement" name="modelManagement">

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

																<input type="text" class="form-control" placeholder="Model Name" id="name" name="name" title="Only Character and Space" />

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
																<input type="text" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon2" id="service_fee" name="service_fee" pattern="[0-9]+" min="0" max="100" title="Only Number" value="30">

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
																<label for="usr"> Model Name</label>
															</div>
														</div>
														<div class="col-md-7">
															<div class="form-group">
																<input type="text" class="form-control" placeholder=" Name" id="model_name" name="model_name"  title="Only Character, Number and Space"  />
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

																<input type="text" class="form-control" placeholder="Surname" id="surname" name="surname"  title="Only Character and Space" >

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

																<input type="text" class="form-control" placeholder="Address Line 1" id="addressline1" name="addressline1" title="Only Character, Number and Space"  />

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

																<input type="text" class="form-control" placeholder="Address Line 2" id="addressline2" name="addressline2"  title="Only Character, Number and Space">

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
																<input type="text" class="form-control" placeholder="City" id="city" name="city" title="Only Character and Space" >

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

																<input type="text" class="form-control" placeholder="Post Code" id="postcode" name="postcode" title="Only  Numbers"  />

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

																<input type="text" class="form-control" placeholder="Vat Number/TIN" id="vat_tin_no" name="vat_tin_no" pattern="[A-Za-z0-9]+" title="Only Character and  Number" />

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

																<input type="text" class="form-control" placeholder="Telephone" id="telephone" name="telephone" pattern="[0-9]+" title="Only Numbers">

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
																<input type="text" class="form-control" placeholder="Email" id="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Enter valid Email id (Ex : abc@expl.com) " />
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

																<input type="text" class="form-control" placeholder="Country" id="country" name="country" pattern="[A-Za-z ]+" title="Only Character and Space" >

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
																<input type="text" class="form-control" placeholder="Mobile No." id="phone" name="phone" pattern="[0-9]+" title="Only Numbers" />
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
																<div class="custom-control custom-radio">										<input type="radio" class="custom-control-input"  id="kvatyes"  name="kvatornot" value="1"  onclick="manageKVat(1)">
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

												<!-- <div class="col-md-6">

													<div class="row">

														<div class="col-md-5">

															<div class="form-group">

																<label for="usr">Selected Country</label>

															</div>

														</div>

														<div class="col-md-7">

														<label style="color: #001737; font-size: 12px;"><input type="radio" name="ingermany" id="ingermany" value="0" checked=""> <b class="checkCountry"> &nbsp;OUT OF GERMANY</b> </label>

															<label style="color: #001737; font-size: 12px;"><input type="radio" name="ingermany" id="ingermany" value="1"> <b class="checkCountry"> &nbsp;IN GERMANY</b> </label>

														</div>

													</div>

												</div> -->

												<!-- <div class="col-md-12">

													<div class="form-group">
														<label for="usr">Kleinunternehmer with VAT or not</label>
													</div>

													<div class="row">

														<div class="col-md-6">
															<div class="custom-control custom-radio">										<input type="radio" class="custom-control-input"  id="kvatyes"  name="kvatornot" value="1"  onclick="manageKVat(1)">
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

														<div class="col-md-12">
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
														</div>
													</div>
												</div> -->

												<!-- <div class="col-md-6 mt-3">
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

							<div class="BtnBox">

								<button type="submit" class="btn">Save</button>

								<a href="<?php echo base_url('model-management'); ?>"> <button type="button" class="btn cancel">Cancel</button> </a>

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

            	url: '<?php echo base_url('save-model-management'); ?>',

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

            			window.location.href = "<?php echo base_url('model-management'); ?>";

            			return true;

            		}



            		if(data == "error"){

            			$('#displaymsg').html('Error to create model, retry');

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