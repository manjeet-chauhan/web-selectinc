



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

							<h4>Model Management Detail</h4>

						</div>

						<div class="ClientManagement">

							<a href="<?php echo base_url('model-management');?>"><button type="button" class="btn bg-white btn-outline-primary"><img src="<?php echo base_url('assets/frontend/'); ?>images/teamwork.svg" alt="Icon"> Back</button></a>



							<a href="<?php echo base_url('edit-model-management/').$uniquecode;?>"> <button type="button" class="btn bg-white btn-outline-primary"><img src="<?php echo base_url('assets/frontend/'); ?>images/contact.svg" alt="Icon"> Edit Model</button></a>



							<a href="<?php echo base_url('add-model-management'); ?>"><button type="button" class="btn bg-white btn-outline-primary"><img src="<?php echo base_url('assets/frontend/images/contact.svg'); ?>" alt="Icon"> Add Model</button></a>

						</div>					 

						<div class="ModelMgmt">

							<div class="InputBox">									

									<div class="Form">

										<div class="row">

											


											<div class="col-md-6">

												<div class="row">

													<div class="col-md-5">

														<div class="form-group">
															<label for="usr">Nick Name</label>
														</div>
													</div>

													<div class="col-md-7">
														<div class="form-group">
															<input type="text" class="form-control" readonly placeholder="Name" id="name" name="name" pattern="[A-Za-z ]+" title="Only Character and Space" value="<?php echo $model->name ?>" />
														</div>

													</div>

												</div>

											</div>

											<!-- <div class="col-md-6">

												<div class="row">

													<div class="col-md-5">

														<div class="form-group">

															<label for="usr">Service Fee</label>

														</div>

													</div>

													<div class="col-md-7">

														<div class="input-group">

															<input type="text" class="form-control" readonly placeholder="" aria-label="" aria-describedby="basic-addon2" id="service_fee" name="service_fee" pattern="[0-9]+" min="0" max="100" title="Only Number" value="<?php echo $model->service_fee ?>">

															<div class="input-group-append AppendBox">

																<span class="input-group-text" id="basic-addon2">%</span>

															</div>

														</div>

													</div>

												</div>

											</div> -->

											

											<div class="col-md-6">

												<div class="row">

													<div class="col-md-5">

														<div class="form-group">

															<label for="usr">Model Name</label>

														</div>

													</div>

													<div class="col-md-7">

														<div class="form-group">

															<input type="text" class="form-control" readonly placeholder="Model Name" id="model_name" name="model_name" pattern="[A-Za-z0-9 ]+" title="Only Character, Number and Space"  value="<?php echo $model->model_name ?>" />

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

															<input type="text" class="form-control" readonly placeholder="Surname" id="surname" name="surname" pattern="[A-Za-z ]+" title="Only Character and Space" value="<?php echo $model->surname ?>" />

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

															<input type="text" class="form-control" readonly placeholder="Address Line 1" id="addressline1" name="addressline1" pattern="[A-Za-z0-9 ]+" title="Only Character, Number and Space" value="<?php echo $model->address_line1 ?>" />

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

															<input type="text" class="form-control" readonly placeholder="Address Line 2" id="addressline2" name="addressline2" pattern="[A-Za-z0-9 ]+" title="Only Character, Number and Space" value="<?php echo $model->address_line2 ?>"/>

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

															<input type="text" class="form-control" readonly placeholder="City" id="city" name="city" pattern="[A-Za-z ]+" title="Only Character and Space" value="<?php echo $model->city ?>"/>

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

															<input type="text" class="form-control" readonly placeholder="Post Code" id="postcode" name="postcode" pattern="[0-9]+" title="Only  Numbers" value="<?php echo $model->pincode ?>" />

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

															<input type="text" class="form-control" readonly placeholder="Vat Number/TIN" id="vat_tin_no" name="vat_tin_no" pattern="[A-Za-z0-9]+" title="Only Character and  Number" value="<?php echo $model->vat_tin_number ?>" />

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

															<input type="text" class="form-control" readonly placeholder="Telephone" id="telephone" name="telephone" pattern="[0-9]+" title="Only Numbers" value="<?php echo $model->telephone ?>" />

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

															<input type="text" class="form-control" readonly placeholder="Email" id="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Enter valid Email id (Ex : abc@expl.com) " value="<?php echo $model->email ?>" />

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

															<input type="text" class="form-control" readonly placeholder="Country" id="country" name="country" pattern="[A-Za-z ]+" title="Only Character and Space" value="<?php echo $model->country ?>" />

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

															<input type="text" class="form-control" readonly placeholder="Mobile No." id="phone" name="phone" pattern="[0-9]+" title="Only Numbers" value="<?php echo $model->mobile_no ?>" />

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

																<?php 

																	$display = 'none';

																	$checked = '';

																	if($model->kvat == 1){

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

																	if($model->kvat == 0){

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

																		<input type="text" class="form-control" readonly placeholder="16" id="kvat_percent" name="kvat_percent" pattern="[0-9]" title="Only  Number" value="<?php echo $model->kvat_percent ?>">

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

				</div>

			</div>

		</div>

	</div>

</section>

<!-- End Dashboard -->

 