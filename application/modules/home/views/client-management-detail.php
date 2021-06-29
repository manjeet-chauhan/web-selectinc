

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

							<h4> Client Management Detail</h4>

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

															<input type="text" readonly class="form-control" placeholder="Company Name" id="companyname" name="companyname" value="<?php echo $client->company_name ?>" />

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

															<input type="text" readonly="" class="form-control" placeholder="Client Fee 0.3%" id="client_fee" name="client_fee" value="<?php echo $client->client_fee?>">

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

															<input type="text" readonly class="form-control" placeholder="Name" id="name" name="name" value="<?php echo $client->name ?>" />

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

															<input type="text" readonly="" class="form-control" placeholder="Surname" id="surname" name="surname" value="<?php echo $client->surname ?>">

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

															<input type="text" readonly class="form-control" placeholder="Address Line 1" id="addressline1" name="addressline1" value="<?php echo $client->address_line1 ?>" />

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

															<input type="text" readonly="" class="form-control" placeholder="Address Line 2" id="addressline2" name="addressline2" value="<?php echo $client->address_line2 ?>">

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

															<input type="text" readonly class="form-control" placeholder="Post Code" id="postcode" name="postcode" value="<?php echo $client->pincode ?>" />

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

															<input type="text" readonly="" class="form-control" placeholder="City" id="city" name="city" value="<?php echo $client->city ?>">

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

															<input type="text" readonly class="form-control" placeholder="Vat Number/TIN" id="vat_tin_no" name="vat_tin_no" value="<?php echo $client->vat_tin_number ?>" />

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

															<input type="text" readonly="" class="form-control" placeholder="Telephone" id="telephone" name="telephone"value="<?php echo $client->telephone ?>">

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

															<input type="text" readonly class="form-control" placeholder="Email"  id="email" name="email" value="<?php echo $client->email ?>" />

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

															<input type="text" readonly="" class="form-control" placeholder="Country" id="country" name="country" value="<?php echo $client->country ?>">

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

															<input type="text" readonly class="form-control" placeholder="Mobile No." id="phone" name="phone"  value="<?php echo $client->mobile_no ?>" />

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
																<label style="color: #001737; font-size: 12px;"><input type="radio" disabled name="ingermany" id="ingermany" value="0" <?php if($client->ingermany!=1){ echo "checked";}?>> <b class="checkCountry"> &nbsp;OUT OF GERMANY</b> </label>

															<label style="color: #001737; font-size: 12px;"><input type="radio" disabled name="ingermany" id="ingermany" value="1" <?php if($client->ingermany==1){ echo "checked";}?>> <b class="checkCountry"> &nbsp;IN GERMANY</b> </label>
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

															<input type="text" readonly="" class="form-control" placeholder="Internal Notes" id="internal_notes" name="internal_notes" value="<?php echo $client->internal_notes ?>">

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
																<?php 
																	$display = 'none';
																	$checked = '';
																	if($client->kvat == 1){
																		$checked = 'checked';
																		$display = 'block';
																	}
																?>
																<div class="custom-control custom-radio">
																	<input disabled <?php echo $checked; ?> type="radio" class="custom-control-input"  id="kvatyes" name="kvatornot" value="1" onclick="manageKVat(1)">
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
																	<input disabled <?php echo $checked; ?> type="radio" class="custom-control-input" id="kvatno" name="kvatornot" value="0" onclick="manageKVat(0)">
																	<label class="custom-control-label" for="kvatno">No</label>
																</div>
															</div>

															<div class="col-md-9 mt-3">
																<div id="kvatvalue" style="display: <?php echo $display; ?>">
																	<div class="input-group mb-3">
																		<input type="text" class="form-control" readonly placeholder="16" id="kvat_percent" name="kvat_percent" pattern="[0-9]" title="Only  Number" value="<?php echo $client->kvat_percent ?>">
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

															<input type="text" readonly class="form-control" placeholder="Company Name" id="shipping_companyname" name="shipping_companyname" value="<?php echo $client->shipping_company_name ?>" />

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

															<input type="text" readonly class="form-control" placeholder="Name" id="shipping_name" name="shipping_name" value="<?php echo $client->shipping_name ?>"/>

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

															<input type="text" readonly="" class="form-control" placeholder="Surname" id="shipping_surname" name="shipping_surname" value="<?php echo $client->shipping_surname ?>">

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

															<input type="text" readonly class="form-control" placeholder="Address Line 1" id="shipping_addressline1" name="shipping_addressline1" value="<?php echo $client->shipping_address_line1 ?>" />

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

															<input type="text" readonly="" class="form-control" placeholder="Address Line 2" id="shipping_addressline2" name="shipping_addressline2" value="<?php echo $client->shipping_address_line2 ?>">

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

															<input type="text" readonly="" class="form-control" placeholder="City" id="shipping_city" name="shipping_city" value="<?php echo $client->shipping_city ?>">

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

															<input type="text" readonly class="form-control" placeholder="Post Code" id="shipping_postcode" name="shipping_postcode"  value="<?php echo $client->shipping_pincode ?>" />

														</div>

													</div>

												</div>

											</div>

										</div>

									</div>

								</div>			

							</div>

							

						</form>

					</div>

				</div>

			</div>

		</div>

	</div>

</section>

<!-- End Dashboard -->

